<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemLoginLogMapper;
use App\System\Model\SystemUser;
use Hyperf\Database\Model\ModelNotFoundException;
use Hyperf\Di\Annotation\Inject;
use Mine\Event\UserLoginAfter;
use Mine\Event\UserLogout;
use Mine\Event\UserLoginBefore;
use Mine\Exception\NormalStatusException;
use Mine\Exception\UserBanException;
use Mine\MineModelService;
use Mine\MineRequest;
use Mine\Helper\MineCode;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * 用户业务
 * Class SystemUserService
 * @package App\System\Service
 */
class SystemUserService extends MineModelService
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

    public function __construct(SystemLoginLogMapper $mapper)
    {
        parent::__construct($mapper);
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
                    return $this->request->getLoginUser()->getToken($userinfo);
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
        } catch (Exception $e) {
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
     */
    public function logout()
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->evDispatcher->dispatch(new UserLogout($this->request->getUserInfo()));
        $this->request->getLoginUser()->getJwt()->unsetToken();
    }
}