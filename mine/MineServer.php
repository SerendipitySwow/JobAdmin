<?php
declare(strict_types=1);
/**
 * 
 */
namespace Mine;

use Hyperf\HttpServer\Router\Router;
use Hyperf\HttpServer\Server;

class MineServer extends Server
{
    protected $serverName = 'MineAdmin';

    protected $routes;

    public function onRequest($request, $response): void
    {
//        $this->setServerName($this->serverName);
        parent::onRequest($request, $response);
        $this->bootstrap();
    }

    /**
     * MineServer bootstrap
     * @return void
     */
    protected function bootstrap(): void
    {
//        $this->setServerName($this->serverName);
    }

    /**
     * 获取已注册的路由。
     */
    protected function registerRouters()
    {
        $this->routes = Router::getDcomposeata();
    }
}
