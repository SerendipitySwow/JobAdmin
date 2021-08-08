<?php

declare(strict_types=1);
namespace App\System\Controller;

use App\Setting\Service\SettingCrontabService;
use App\System\Request\User\SystemUserLoginRequest;
use App\System\Service\SystemUserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Redis\Redis;
use Mine\Annotation\Auth;
use Mine\Crontab\MineCrontabManage;
use Mine\Helper\LoginUser;
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
        return $this->success($this->systemUserService->getCaptcha());
    }

    /**
     * @PostMapping("login")
     * @param SystemUserLoginRequest $request
     * @return ResponseInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
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
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function logout(): ResponseInterface
    {
        $this->systemUserService->logout();
        return $this->success();
    }

    /**
     * @Auth
     * @GetMapping("getInfo")
     */
    public function getInfo(): ResponseInterface
    {
        return $this->success($this->systemUserService->getInfo());
    }

    /**
     * 刷新token
     * @PostMapping("refresh")
     * @param LoginUser $user
     * @return ResponseInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function refresh(LoginUser $user): ResponseInterface
    {
        return $this->success(['token' => $user->refresh()]);
    }

    /**
     * @GetMapping("test")
     */
    public function test()
    {
        /* @var Redis $redis */
        $redis = $this->app(Redis::class);
        $prefix = config('cache.default.prefix');
        $res = $redis->keys("{$prefix}MineAdmin_jwt_default_*");
        print_r($res);
    }
}