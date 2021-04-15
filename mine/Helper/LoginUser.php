<?php

namespace Mine\Helper;

use HyperfExt\Jwt\Contracts\JwtFactoryInterface;
use HyperfExt\Jwt\Contracts\ManagerInterface;
use HyperfExt\Jwt\Jwt;

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

    public function getToken()
    {
        $this->jwt->getToken();
    }
}