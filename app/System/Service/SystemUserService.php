<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemUserMapper;
use App\System\Model\SystemUser;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Annotation\CacheEvict;
use Hyperf\Database\Model\ModelNotFoundException;
use Hyperf\Di\Annotation\Inject;
use HyperfExt\Jwt\Exceptions\JwtException;
use Mine\Event\UserLoginAfter;
use Mine\Event\UserLogout;
use Mine\Event\UserLoginBefore;
use Mine\Exception\NormalStatusException;
use Mine\Exception\UserBanException;
use Mine\Helper\LoginUser;
use Mine\MineModelService;
use Mine\MineRequest;
use Mine\Helper\MineCode;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * 用户业务
 * Class SystemUserService
 * @package App\System\Service
 */
class SystemUserService
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
     * @var SystemMenuService
     */
    protected $sysMenuService;

    public $mapper;

    /**
     * SystemUserService constructor.
     * @param SystemUserMapper $mapper
     * @param SystemMenuService $service
     */
    public function __construct(SystemUserMapper $mapper, SystemMenuService $service)
    {
        $this->mapper = $mapper;
        $this->sysMenuService = $service;
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
        $user = new SystemUser;
        $user->id = $this->request->getId();
        $this->clearCache($user);
    }

    /**
     * @CacheEvict(prefix="loginInfo", value="userId_#{user.id}")
     * @param SystemUser $user
     * @throws JwtException
     */
    protected function clearCache(SystemUser $user)
    {
        $this->request->getLoginUser()->getJwt()->invalidate();
        $this->request->getLoginUser()->getJwt()->unsetToken();
    }

    /**
     * 获取用户信息
     * @return array
     * @throws JwtException
     * @noinspection PhpParamsInspection
     */
    public function getInfo(): array
    {
        $user = $this->mapper->findById((int) $this->request->getId());
        return $this->getCacheInfo($this->request->getLoginUser(), $user);
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
        if ($loginUser->isSuperAdmin()) {
            $data['roles'] = ['super_admin'];
            $data['routers'] = $this->sysMenuService->mapper->getSuperAdminRouters();
        } else {
            $data['roles'] = $user->roles()->pluck('code')->toArray();
            $data['routers'] = $this->sysMenuService->mapper->getRoutersByRoleIds($user->roles()->pluck('id')->toArray());
        }
        return $data;
    }

    /**
     * 更新用户信息
     * @param int $id
     * @param array $data
     * @return int
     */
    public function updateById(int $id, array $data): int
    {
        return $this->mapper->updateById($id, $data);
    }
}