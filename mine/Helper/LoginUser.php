<?php

namespace Mine\Helper;

use HyperfExt\Jwt\Contracts\JwtFactoryInterface;
use HyperfExt\Jwt\Contracts\ManagerInterface;
use HyperfExt\Jwt\Exceptions\JwtException;
use HyperfExt\Jwt\Exceptions\TokenInvalidException;
use HyperfExt\Jwt\Jwt;
use Mine\JwtAuth\UserJwtSubject;
use Mine\Exception\NoPermissionException;

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
     * @return Jwt
     */
    public function getJwt(): Jwt
    {
        return $this->jwt;
    }

    /**
     * @param bool $getPayload
     * @return bool|\HyperfExt\Jwt\Payload
     * @throws JwtException
     * @throws TokenInvalidException
     */
    public function check(bool $getPayload = false): ?bool
    {
        try {
            if (! $this->jwt->getToken()) {
                throw new JwtException;
            }
            return $this->jwt->check($getPayload);
        } catch (\Exception $e) {
            if ($e instanceof TokenInvalidException) {
                throw new NoPermissionException(__('jwt.validate_fail'));
            }
            if ($e instanceof JwtException) {
                throw new NoPermissionException(__('jwt.no_login'));
            }
            throw new NoPermissionException(__('jwt.no_token'));
        }
    }

    /**
     * @return string
     * @throws JwtException
     */
    public function getId(): string
    {
        $this->check();
        return $this->jwt->getClaim('id');
    }

    /**
     * @return string
     * @throws JwtException
     */
    public function getUsername(): string
    {
        $this->check();
        return $this->jwt->getClaim('username');
    }

    /**
     * @return string
     * @throws JwtException
     */
    public function getRole(): string
    {
        $this->check();
        return $this->jwt->getClaim('role');
    }

    /**
     * @return string
     * @throws JwtException
     */
    public function getDept(): string
    {
        $this->check();
        return $this->jwt->getClaim('dept_id');
    }

    /**
     * @param array $user
     * @return string
     */
    public function getToken(array $user): string
    {
        return $this->jwt->fromUser(new UserJwtSubject($user));
    }
}