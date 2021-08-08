<?php

declare(strict_types = 1);
namespace App\System\Controller\Monitor;

use App\System\Service\SystemUserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Mine\Annotation\Permission;
use Mine\MineController;

/**
 * 在线用户监控
 * Class OnlineUserMonitorController
 * @package App\System\Controller\Monitor
 * @Controller(prefix="system/onlineUser")
 */
class OnlineUserMonitorController extends MineController
{
    /**
     * @Inject
     * @var SystemUserService
     */
    protected $service;

    /**
     * 获取在线用户列表
     * @GetMapping("index")
     * @Permission("system:onlineUser:index")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getPageList(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success($this->service->getOnlineUserPageList($this->request->all()));
    }

    /**
     * 强退用户
     * @PostMapping("kick")
     * @Permission("system:onlineUser:kick")
     */
    public function getDetail(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success();
    }
}