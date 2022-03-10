<?php

declare(strict_types = 1);

namespace App\Task\Controller;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * 任务列表控制器
 * Class MissionTaskController
 * @Controller(prefix="task/chart")
 * @Auth()
 */
class ChartController extends MineController {
    /**
     * 回收站列表
     * @GetMapping("info")
     * @return ResponseInterface
     * @Permission("task:chart:info")
     */
    public function info() : ResponseInterface
    {
        $params = $this->request->all();
        return $this->success();
    }
}
