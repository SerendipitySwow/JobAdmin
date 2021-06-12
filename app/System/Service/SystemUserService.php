<?php
declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemUserMapper;
use App\System\Model\SystemUser;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Annotation\CacheEvict;
use Hyperf\Contract\ContainerInterface;
use Hyperf\Database\Model\ModelNotFoundException;
use Hyperf\Di\Annotation\Inject;
use HyperfExt\Jwt\Exceptions\JwtException;
use Mine\Abstracts\AbstractService;
use Mine\Event\UserLoginAfter;
use Mine\Event\UserLogout;
use Mine\Event\UserLoginBefore;
use Mine\Exception\CaptchaException;
use Mine\Exception\NormalStatusException;
use Mine\Exception\UserBanException;
use Mine\Helper\LoginUser;
use Mine\Helper\MineCaptcha;
use Mine\MineCollection;
use Mine\MineRequest;
use Mine\Helper\MineCode;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * 用户业务
 * Class SystemUserService
 * @package App\System\Service
 */
class SystemUserService extends AbstractService
{
    /**
     * @Inject
     * @var EventDispatcherInterface
     */
    protected $evDispatcher;

    /**
     * @Inject
     * @var MineRequest
     */
    protected $request;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var SystemMenuService
     */
    protected $sysMenuService;

    /**
     * @var sysRoleService
     */
    protected $sysRoleService;

    /**
     * @var SystemUserMapper
     */
    public $mapper;

    /**
     * SystemUserService constructor.
     * @param ContainerInterface $container
     * @param SystemUserMapper $mapper
     * @param SystemMenuService $systemMenuService
     * @param SystemRoleService $systemRoleService
     */
    public function __construct(
        ContainerInterface $container,
        SystemUserMapper $mapper,
        SystemMenuService $systemMenuService,
        SystemRoleService $systemRoleService
    )
    {
        $this->mapper = $mapper;
        $this->sysMenuService = $systemMenuService;
        $this->sysRoleService = $systemRoleService;
        $this->container = $container;
    }

    /**
     * 获取验证码
     * @throws InvalidArgumentException
     * @throws \Exception
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function genCaptcha(): array
    {
        $cache = $this->container->get(CacheInterface::class);
        $captcha = new MineCaptcha();
        $captcha->initialize([]);
        $img = $captcha->create()->getBase64();
        $code = $captcha->getText();
        $cache->set(sprintf('captcha:%s', md5($code)), $code, 60);
        return ['img' => $img];
    }

    /**
     * 检查用户提交的验证码
     * @param String $code
     * @return bool
     * @throws \Exception
     */
    public function checkCaptcha(String $code): bool
    {
        try {
            $cache = $this->container->get(CacheInterface::class);
            $key = 'captcha:' . md5($code);
            if ($code == $cache->get($key)) {
                $cache->delete($key);
                return true;
            } else {
                return false;
            }
        } catch (InvalidArgumentException $e) {
            throw new \Exception;
        }
    }

    /**
     * 用户登陆
     * @param array $data
     * @return string|null
     */
    public function login(array $data): ?string
    {
        try {
            $this->evDispatcher->dispatch(new UserLoginBefore($data));
            $userinfo = $this->mapper->checkUserByUsername($data['username']);
            $userLoginAfter = new UserLoginAfter($userinfo);
            if (!$this->checkCaptcha($data['code'])) {
                $userLoginAfter->message = __('jwt.code_error');
                $userLoginAfter->loginStatus = false;
                $this->evDispatcher->dispatch($userLoginAfter);
                throw new CaptchaException;
            }
            if ($this->mapper->checkPass($data['password'], $userinfo['password'])) {
                if (
                    ($userinfo['status'] == SystemUser::USER_NORMAL)
                    ||
                    ($userinfo['status'] == SystemUser::USER_BAN && $userinfo['id'] == env('SUPER_ADMIN'))
                ) {
                    $userLoginAfter->message = __('jwt.login_success');
                    $this->evDispatcher->dispatch($userLoginAfter);
                    return $this->request->getLoginUser()->getToken($userLoginAfter->userinfo);
                } else {
                    $userLoginAfter->loginStatus = false;
                    $userLoginAfter->message = __('jwt.user_ban');
                    $this->evDispatcher->dispatch($userLoginAfter);
                    throw new UserBanException;
                }
            } else {
                $userLoginAfter->loginStatus = false;
                $userLoginAfter->message = __('jwt.password_error');
                $this->evDispatcher->dispatch($userLoginAfter);
                throw new NormalStatusException;
            }
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                throw new NormalStatusException(__('jwt.username_error'), MineCode::NO_DATA);
            }
            if ($e instanceof NormalStatusException) {
                throw new NormalStatusException(__('jwt.password_error'), MineCode::PASSWORD_ERROR);
            }
            if ($e instanceof UserBanException) {
                throw new NormalStatusException(__('jwt.user_ban'), MineCode::USER_BAN);
            }
            if ($e instanceof CaptchaException) {
                throw new NormalStatusException(__('jwt.code_error'));
            }
            throw new NormalStatusException(__('jwt.unknown_error'));
        }
    }

    /**
     * 用户退出
     * @throws JwtException
     */
    public function logout()
    {
        $this->evDispatcher->dispatch(new UserLogout($this->request->getUserInfo()));
        $this->request->getLoginUser()->getJwt()->invalidate();
        $this->request->getLoginUser()->getJwt()->unsetToken();
    }

    /**
     * 获取用户信息
     * @return array
     * @throws JwtException
     */
    public function getInfo(): array
    {
        return $this->getCacheInfo($this->request->getLoginUser(), SystemUser::find((int) $this->request->getId()));
    }

    /**
     * 获取缓存用户信息
     * @Cacheable(prefix="loginInfo", value="userId_#{user.id}")
     * @param LoginUser $loginUser
     * @param SystemUser $user
     * @return array
     * @throws JwtException
     */
    protected function getCacheInfo(LoginUser $loginUser, SystemUser $user): array
    {
        $user->addHidden('deleted_at', 'password');
        $data['user'] = $user->toArray();
        $collect = new MineCollection();
        if ($loginUser->isSuperAdmin()) {
            $data['roles'] = ['super_admin'];
            $data['routers'] = $this->sysMenuService->mapper->getSuperAdminRouters();
            $data['codes'] = ['*'];
            $tempQuickMenu = $this->sysMenuService->mapper->getQuickMenu();
        } else {
            $roles = $this->sysRoleService->mapper->getMenuIdsByRoleIds($user->roles()->pluck('id')->toArray());
            $ids = $this->filterMenuIds($roles);
            $data['roles'] = $user->roles()->pluck('code')->toArray();
            $data['routers'] = $this->sysMenuService->mapper->getRoutersByIds($ids);
            $data['codes'] = $this->sysMenuService->mapper->getMenuCode($ids);
            $tempQuickMenu = $this->sysMenuService->mapper->getQuickMenu($ids);
        }
        $data['quickMenu'] = [];
        // 快捷菜单
        if (count($tempQuickMenu)) {
            foreach ($tempQuickMenu as $quick) {
                array_push($data['quickMenu'], $collect->setRouter($quick));
            }
        }
        unset($tempQuickMenu);

        return $data;
    }

    /**
     * 过滤通过角色查询出来的菜单id列表，并去重
     * @param array $roleData
     * @return array
     */
    protected function filterMenuIds(array &$roleData): array
    {
        $ids = [];
        foreach ($roleData as $val) {
            foreach ($val['menus'] as $menu) {
                $ids[] = $menu['id'];
            }
        }
        unset($roleData);
        return array_unique($ids);
    }

    /**
     * 新增用户
     * @param array $data
     * @return int
     */
    public function save(array $data): int
    {
        if ($this->mapper->existsByUsername($data['username'])) {
            throw new NormalStatusException(__('system.username_exists'));
        } else {
            return $this->mapper->save($this->handleData($data));
        }
    }

    /**
     * 更新用户信息
     * @CacheEvict(prefix="loginInfo", value="userId_#{id}")
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        if (isset($data['username'])) unset($data['username']);
        if (isset($data['password'])) unset($data['password']);
        return $this->mapper->update($id, $this->handleData($data));
    }

    /**
     * 处理提交数据
     * @param $data
     * @return array
     */
    protected function handleData($data): array
    {
        if (!is_array($data['role_ids'])) {
            $data['role_ids'] = explode(',', $data['role_ids']);
        }
        if (($key = array_search(env('ADMIN_ROLE'), $data['role_ids'])) !== false) {
            unset($data['role_ids'][$key]);
        }
        if (!empty($data['post_ids']) && !is_array($data['post_ids'])) {
            $data['post_ids'] = explode(',', $data['post_ids']);
        }
        if (is_array($data['dept_id'])) {
            $data['dept_id'] = array_pop($data['dept_id']);
        }
        return $data;
    }

    /**
     * 修改用户状态
     * @param int $id
     * @param string $value
     * @return bool
     */
    public function changeUserStatus(int $id, string $value): bool
    {
        if ($value === '0') {
            $this->mapper->enable([$id]);
            return true;
        } else if ($value === '1') {
            $this->mapper->disable([$id]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 初始化用户密码
     * @param int $id
     * @return bool
     */
    public function initUserPassword(int $id): bool
    {
        return $this->mapper->initUserPassword($id, $password = '123456');
    }
}