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
namespace Api\v1;

use Mine\Exception\NormalStatusException;
use Mine\Helper\MineCode;
use Mine\MineApi;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;
use Api\v1\Middleware\VerifyInterfaceMiddleware;

/**
 * Class ApiController
 * @package Api\v1
 * @Controller(prefix="api/v1")
 */
class ApiController extends MineApi
{

    /**
     * @RequestMapping("index/{method}")
     * @Middlewares({
     *     @Middleware(VerifyInterfaceMiddleware::class)
     * })
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(): ResponseInterface
    {
        $apiData = $this->__init();

        try {
            $class = make($apiData['class_name']);
            return $this->success($class->{$apiData['method_name']}());
        } catch (\Throwable $e) {
            throw new NormalStatusException(t('mineadmin.interface_exception'), MineCode::INTERFACE_EXCEPTION);
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