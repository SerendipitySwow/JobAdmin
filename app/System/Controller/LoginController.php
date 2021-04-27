<?php

declare(strict_types=1);
namespace App\System\Controller;

use App\System\Request\SystemUserRequest;
use App\System\Request\User\SystemUserLoginRequest;
use App\System\Service\SystemUserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use HyperfExt\Jwt\Exceptions\JwtException;
use Mine\Annotation\Auth;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * Class LoginController
 * @package App\System\Controller
 * @Controller(prefix="system")
 */
class LoginController extends MineController
{

    /**
     * @Inject
     * @var SystemUserService
     */
    protected $systemUserService;

    /**
     * @GetMapping("captcha")
     * @return ResponseInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function captcha(): ResponseInterface
    {
        return $this->success($this->systemUserService->genCaptcha());
    }

    /**
     * @PostMapping("login")
     * @param SystemUserLoginRequest $request
     * @return ResponseInterface
     */
    public function login(SystemUserLoginRequest $request): ResponseInterface
    {
        $token = $this->systemUserService->login($request->validated());
        return $this->success(['token' => $token]);
    }

    /**
     * @Auth
     * @PostMapping("logout")
     * @return ResponseInterface
     * @throws JwtException
     */
    public function logout(): ResponseInterface
    {
        $this->systemUserService->logout();
        return $this->success();
    }

    /**
     * @Auth
     * @GetMapping("getInfo")
     * @throws JwtException
     */
    public function getInfo(): ResponseInterface
    {
        return $this->success($this->systemUserService->getInfo());
    }

}