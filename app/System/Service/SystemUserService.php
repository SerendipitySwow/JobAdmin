<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemUserMapper;
use App\System\Model\SystemUser;
use Hyperf\Database\Model\ModelNotFoundException;
use Hyperf\Di\Annotation\Inject;
use Mine\Exception\NormalStatusException;
use Mine\Exception\UserBanException;
use Mine\MineRequest;
use Mine\Helper\MineCode;

/**
 * Class SystemUserService
 * @package App\System\Service
 */
class SystemUserService
{
    /**
     * @Inject
     * @var SystemUserMapper
     */
    protected $systemUserMapper;

    /**
     * 用户登陆
     * @param array $data
     * @param MineRequest $request
     * @return string|null
     */
    public function Login(array $data, MineRequest $request): ?string
    {
        try {
            $userinfo = $this->systemUserMapper->checkUserByUsername($data['username']);
            if ($this->systemUserMapper->checkPass($data['password'], $userinfo['password'])) {
                if (
                    ($userinfo['status'] == SystemUser::USER_NORMAL)
                    ||
                    ($userinfo['status'] == SystemUser::USER_BAN && $userinfo['id'] == env('SUPER_ADMIN'))
                ) {
                    return $request->getLoginUser()->getToken($userinfo);
                } else {
                    throw new UserBanException;
                }
            } else {
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
     */
    public function logout()
    {

    }
}