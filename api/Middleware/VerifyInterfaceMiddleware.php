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
namespace Api\Middleware;

use App\System\Model\SystemApi;
use App\System\Service\SystemApiService;
use Mine\Exception\NormalStatusException;
use Mine\Helper\MineCode;
use Mine\MineRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VerifyInterfaceMiddleware implements MiddlewareInterface
{

    /**
     * 验证检查接口
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
    {
        $this->crossSetting($request);

        $this->auth();

        $this->apiLog();

        return $handler->handle($this->apiModelCheck($request));
    }

    /**
     * 跨域设置
     * @param $request
     */
    protected function crossSetting($request): void
    {
        $crossData = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'POST,GET,OPTIONS',
            'Access-Control-Allow-Headers'     => 'Version, Access-Token, User-Token, Api-Auth, User-Agent, Keep-Alive, Origin, No-Cache, X-Requested-With, If-Modified-Since, Pragma, Last-Modified, Cache-Control, Expires, Content-Type, X-E4M-With',
            'Access-Control-Allow-Credentials' => 'true'
        ];

        foreach ($crossData as $name => $value) {
            $request->withHeader($name, $value);
        }
    }

    /**
     * api 鉴权
     */
    protected function auth()
    {

    }

    /**
     * api 日志
     */
    protected function apiLog()
    {

    }

    /**
     * api 检查
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    protected function apiModelCheck($request)
    {
        $service = container()->get(SystemApiService::class);
        $apiModel = $service->mapper->one(function($query) {
            $request = container()->get(MineRequest::class);
            $query->where('access_name', $request->route('method'));
        });

        // 检查接口是否存在
        if (! $apiModel) {
            throw new NormalStatusException(t('mineadmin.not_found'), MineCode::NOT_FOUND);
        }

        // 检查接口是否停用
        if ($apiModel['status'] == SystemApi::DISABLE) {
            throw new NormalStatusException(t('mineadmin.api_stop'), MineCode::RESOURCE_STOP);
        }

        // 检查接口请求方法
        if ($apiModel['request_mode'] !== SystemApi::METHOD_ALL) {
            if ($request->getMethod()[0] !== $apiModel['request_mode'] && $request->getMethod()[0] !== $apiModel['request_mode']) {
                throw new NormalStatusException(
                    t('mineadmin.not_allow_method', ['method' => $request->getMethod()]),
                    MineCode::METHOD_NOT_ALLOW
                );
            }
        }

        // 合并入参
        return $request->withParsedBody(array_merge(
            $request->getParsedBody(), ['apiData' => $apiModel->toArray()]
        ));
    }
}