<?php
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

declare(strict_types=1);
namespace Api;

use App\System\Service\SystemAppService;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Mine\Exception\NormalStatusException;
use Mine\Helper\MineCode;
use Mine\MineApi;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;
use Api\Middleware\VerifyInterfaceMiddleware;

/**
 * Class ApiController
 * @package Api\v1
 * @Controller(prefix="api")
 */
class ApiController extends MineApi
{
    public const SIGN_VERSION = '1.0';

    /**
     * 获取accessToken
     * @PostMapping("v1/getAccessToken")
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getAccessToken(): ResponseInterface
    {
        $service = container()->get(SystemAppService::class);
        return $this->success($service->getAccessToken($this->request->all()));
    }

    /**
     * 登录文档
     * @GetMapping("v1/docLogin")
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function docLogin(): ResponseInterface
    {
        $app_id = $this->request->input('app_id', '');
        $app_secret = $this->request->input('app_secret', '');

        if (empty($app_id) && empty($app_secret)) {
            return $this->error(t('mineadmin.api_auth_fail'), MineCode::API_PARAMS_ERROR);
        }

        $service = container()->get(SystemAppService::class);
        if (($code = $service->verifyEasyMode($app_id, $app_secret)) !== MineCode::API_VERIFY_PASS) {
            return $this->error(t('mineadmin.api_auth_fail'), $code);
        }

        return $this->success();
    }

    /**
     * v1 版本
     * @RequestMapping("v1/{method}")
     * @Middlewares({
     *     @Middleware(VerifyInterfaceMiddleware::class)
     * })
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function v1(): ResponseInterface
    {
        $apiData = $this->__init();

        try {
            $class = make($apiData['class_name']);
            return $this->success($class->{$apiData['method_name']}());
        } catch (\Throwable $e) {
            throw new NormalStatusException(
                t('mineadmin.interface_exception') . $e->getMessage(),
                MineCode::INTERFACE_EXCEPTION
            );
        }
    }

    /**
     * 初始化
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function __init()
    {
        if (empty($this->request->input('apiData'))) {
            throw new NormalStatusException(t('mineadmin.access_denied'), MineCode::NORMAL_STATUS);
        }

        return $this->request->input('apiData');
    }
}