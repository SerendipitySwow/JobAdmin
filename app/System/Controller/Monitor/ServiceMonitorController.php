<?php


namespace App\System\Controller\Monitor;


use App\System\Service\ServiceMonitorService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\MineController;

/**
 * Class ServiceMonitorController
 * @package App\System\Controller\Monitor
 * @Controller(prefix="system/serviceMonitor")
 * @Auth
 */
class ServiceMonitorController extends MineController
{
    /**
     * @Inject
     * @var ServiceMonitorService
     */
    protected $service;

    /**
     * 获取服务器信息
     * @GetMapping("serverInfo")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getServerInfo(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success([
            'cpuinfo' => $this->service->getCpuInfo(),
            'meminfo' => $this->service->getMemInfo(),
        ]);
    }
}