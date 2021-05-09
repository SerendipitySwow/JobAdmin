<?php

namespace Mine\Middleware;


use App\System\Service\SystemMenuService;
use Mine\Helper\Str;
use Mine\MineRequest;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Container\ContainerInterface;
use Mine\Event\Operation;

class OperationMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $evDispatcher = $this->container->get(EventDispatcherInterface::class);
        $mineRequest = $this->container->get(MineRequest::class);

        if ($request->getServerParams()['path_info'] === '/favicon.ico') {
            return $handler->handle($request);
        }

        try {
            $mineRequest->getLoginUser()->check();
            $pathInfo = substr($request->getServerParams()['path_info'], 1);
            if (count(explode('/', $pathInfo)) > 2) {
                $evDispatcher->dispatch(new Operation($this->getRequestInfo()));
            }
            return $handler->handle($request);
        } catch (\Exception $e) {
            return $handler->handle($request);
        }
    }

    /**
     * @return array
     * @throws \HyperfExt\Jwt\Exceptions\JwtException
     */
    protected function getRequestInfo(): array
    {
        $request = $this->container->get(MineRequest::class);
        /** @noinspection PhpUnhandledExceptionInspection */
        return [
            'data' => $request->all(),
            'time' => date('Y-m-d H:i:s', $request->getServerParams()['request_time']),
            'method' => $request->getServerParams()['request_method'],
            'router' => $request->getServerParams()['path_info'],
            'protocol' => $request->getServerParams()['server_protocol'],
            'ip' => $request->ip(),
            'username' => $request->getUsername(),
            'ip_location' => Str::ipToRegion($request->ip()),
            'service_name' => $this->getOperationMenuName()
        ];
    }

    /**
     *
     */
    protected function getOperationMenuName()
    {
        $request = $this->container->get(MineRequest::class);
        $service = $this->container->get(SystemMenuService::class);
        list($module, $controller, $action) = explode('/', substr($request->getServerParams()['path_info'], 1));
        return $service->findNameByCode(sprintf('%s:%s:%s', $module, $controller, $action));
    }
}