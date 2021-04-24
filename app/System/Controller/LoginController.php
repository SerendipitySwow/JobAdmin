<?php

declare(strict_types=1);
namespace App\System\Controller;

use App\System\Request\SystemUserRequest;
use App\System\Service\SystemUserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Mine\Annotation\Auth;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * Class LoginController
 * @package App\System\Controller
 * @Controller(prefix="system")
 * @Auth
 */
class LoginController extends MineController
{

    /**
     * @Inject
     * @var SystemUserService
     */
    protected $systemUserService;

    /**
     * @PostMapping("login")
     * @param SystemUserRequest $request
     * @return ResponseInterface
     */
    public function login(SystemUserRequest $request): ResponseInterface
    {
        $token = $this->systemUserService->login($request->validated());
        return $this->success(['token' => $token]);
    }

    /**
     * @PostMapping("logout")
     * @return ResponseInterface
     * @throws \HyperfExt\Jwt\Exceptions\JwtException
     */
    public function logout(): ResponseInterface
    {
        $this->systemUserService->logout();
        return $this->success();
    }

    /**
     * @GetMapping("getInfo")
     * @throws \HyperfExt\Jwt\Exceptions\JwtException
     */
    public function getInfo(): ResponseInterface
    {
        return $this->success($this->systemUserService->getInfo());
    }

}