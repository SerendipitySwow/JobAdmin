<?php
declare(strict_types=1);

namespace Mine;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Request;
use HyperfExt\Jwt\Exceptions\JwtException;
use Mine\Helper\LoginUser;

class MineRequest extends Request
{
    /**
     * @Inject
     * @var MineResponse
     */
    protected $response;

    /**
     * @Inject
     * @var LoginUser
     */
    protected $loginUser;

    /**
     * @return LoginUser
     */
    public function getLoginUser(): LoginUser
    {
        return $this->loginUser;
    }

    /**
     * 获取当前token用户ID
     * @return string
     * @throws JwtException
     */
    public function getId(): string
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return $this->loginUser->getId();
    }

    /**
     * 获取当前token用户名
     * @return string
     * @throws JwtException
     */
    public function getUsername(): string
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return $this->loginUser->getUsername();
    }

    /**
     * 获取当前token用户角色
     * @return string
     * @throws JwtException
     */
    public function getRole(): string
    {
        return $this->loginUser->getRole();
    }

    /**
     * 获取当前token用户类型
     * @return string
     * @throws JwtException
     */
    public function getUserType(): string
    {
        return $this->loginUser->getUserType();
    }

    /**
     * 获取当前token用户部门ID
     * @return string
     * @throws JwtException
     */
    public function getDeptId(): string
    {
        return $this->loginUser->getDeptId();
    }

    /**
     * 是否为超级管理员（创始人），用户禁用对创始人没用
     * @return bool
     * @throws JwtException
     */
    public function isSuperAdmin():bool
    {
        return $this->loginUser->isSuperAdmin();
    }

    /**
     * 是否为管理员角色，用户禁用对该角色有用
     * @return bool
     * @throws JwtException
     */
    public function isAdminRole(): bool
    {
        return $this->loginUser->isAdminRole();
    }

    /**
     * @return array
     * @throws JwtException
     */
    public function getUserInfo(): array
    {
        return $this->loginUser->getUserInfo();
    }

    /**
     * 获取请求IP
     * @return string
     */
    public function ip(): string
    {
        $ip = $this->getServerParams()['remote_addr'] ?? '0.0.0.0';
        $headers = $this->getHeaders();

        if (isset($headers['x-real-ip'])) {
            $ip = $headers['x-real-ip'][0];
        } else if (isset($headers['x-forwarded-for'])) {
            $ip = $headers['x-forwarded-for'][0];
        } else if (isset($headers['http_x_forwarded_for'])) {
            $ip = $headers['http_x_forwarded_for'][0];
        }

        return $ip;
    }
}

