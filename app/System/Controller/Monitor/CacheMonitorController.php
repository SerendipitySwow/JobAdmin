<?php

declare(strict_types=1);
namespace App\System\Controller\Monitor;

use App\System\Service\CacheMonitorService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\MineController;

/**
 * 缓存监控
 * Class CacheMonitorController
 * @package App\System\Controller\Monitor
 * @Controller(prefix="system/cache")
 */
class CacheMonitorController extends MineController
{
    /**
     * @Inject
     * @var CacheMonitorService
     */
    protected $service;

    /**
     * 获取Redis服务器信息
     * @GetMapping("monitor")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getCacheInfo(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success($this->service->getCacheServerInfo());
    }
}