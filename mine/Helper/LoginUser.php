<?php

namespace Mine\Helper;

use HyperfExt\Jwt\Contracts\JwtFactoryInterface;
use HyperfExt\Jwt\Contracts\ManagerInterface;
use HyperfExt\Jwt\Exceptions\JwtException;
use HyperfExt\Jwt\Exceptions\TokenInvalidException;
use HyperfExt\Jwt\Jwt;
use Mine\Exception\TokenException;
use Mine\JwtAuth\UserJwtSubject;

class LoginUser
{
    /**
     * 提供了对 JWT 编解码、刷新和失活的能力。
     *
     * @var ManagerInterface
     */
    protected $manager;

    /**
     * 提供了从请求解析 JWT 及对 JWT 进行一系列相关操作的能力。
     *
     * @var Jwt
     */
    protected $jwt;


    /**
     * LoginUser constructor.
     * @param ManagerInterface $manager
     * @param JwtFactoryInterface $jwtFactory
     */
    public function __construct(ManagerInterface $manager, JwtFactoryInterface $jwtFactory)
    {
        $this->manager = $manager;
        $this->jwt = $jwtFactory->make();
    }

    /**
     * 获取JWT对象
     * @return Jwt
     * @noinspection PhpUnused
     */
    public function getJwt(): Jwt
    {
        return $this->jwt;
    }

    /**
     * 对用户身份验证
     * @return bool|null
     * @throws \HyperfExt\Jwt\Exceptions\TokenBlacklistedException
     */
    public function check(): ?bool
    {
        try {
            if ($this->jwt->getToken() !== null) {
                throw new JwtException;
            }
            return true;
        } catch (\Exception $e) {
            if ($e instanceof TokenInvalidException) {
                throw new TokenException(__('jwt.validate_fail'));
            }
            if ($e instanceof JwtException) {
                throw new TokenException(__('jwt.no_login'));
            }
            throw new TokenException(__('jwt.no_token'));
        }
    }

    /**
     * 获取当前token用户ID
     * @return string
     * @throws JwtException
     */
    public function getId(): string
    {
        return $this->jwt->getClaim('id');
    }

    /**
     * 获取当前token用户名
     * @return string
     * @throws JwtException
     */
    public function getUsername(): string
    {
        return $this->jwt->getClaim('username');
    }

    /**
     * 获取当前token用户角色
     * @return string
     * @throws JwtException
     */
    public function getRole(): string
    {
        return $this->jwt->getClaim('role');
    }

    /**
     * 获取当前token用户类型
     * @return string
     * @throws JwtException
     */
    public function getUserType(): string
    {
        return $this->jwt->getClaim('user_type');
    }

    /**
     * 获取当前token用户部门ID
     * @return string
     * @throws JwtException
     */
    public function getDeptId(): string
    {
        return $this->jwt->getClaim('dept_id');
    }

    /**
     * 是否为超级管理员（创始人），用户禁用对创始人没用
     * @return bool
     * @throws JwtException
     */
    public function isSuperAdmin():bool
    {
        return env('SUPER_ADMIN') == $this->getId();
    }

    /**
     * 是否为管理员角色，用户禁用对该角色有用
     * @return bool
     * @throws JwtException
     */
    public function isAdminRole(): bool
    {
        return env('ADMIN_ROLE') == $this->getRole();
    }

    /**
     * @param bool $ignoreExpired
     * @return array
     * @throws JwtException
     */
    public function getUserInfo(bool $ignoreExpired = false): array
    {
        return $this->jwt->getPayload($ignoreExpired)->getClaims()->toPlainArray();
    }

    /**
     * 获取Token
     * @param array $user
     * @return string
     */
    public function getToken(array $user): string
    {
        return $this->jwt->fromUser(new UserJwtSubject($user));
    }

    /**
     * 刷新token
     * @param bool $forceForever
     * @return string
     * @throws JwtException
     * @throws \HyperfExt\Jwt\Exceptions\TokenBlacklistedException
     */
    public function refresh(bool $forceForever = false): string
    {
        $this->jwt->setToken(
            $token =$this->jwt->getManager()->refresh(
                $this->jwt->getToken(), $forceForever, $this->getUserInfo(true)
            )->get()
        );
        return $token;
    }
}