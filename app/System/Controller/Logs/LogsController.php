<?php

declare(strict_types=1);
namespace App\System\Controller\Logs;

use App\System\Service\SystemLoginLogService;
use App\System\Service\SystemOperLogService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Mine\Annotation\Permission;
use Mine\MineController;

/**
 * 日志控制器
 * Class LogsController
 * @package App\System\Controller\Logs
 * @Controller(prefix="system/logs")
 */
class LogsController extends MineController
{
    /**
     * 登录日志服务
     * @Inject
     * @var SystemLoginLogService
     */
    protected $loginLogService;

    /**
     * 操作日志服务
     * @Inject
     * @var SystemOperLogService
     */
    protected $operLogService;

    /**
     * 获取登录日志列表
     * @GetMapping("getLoginLogPageList")
     * @Permission
     */
    public function getLoginLogPageList(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success($this->loginLogService->getPageList($this->request->all()));
    }

    /**
     * 获取操作日志列表
     * @GetMapping("getOperLogPageList")
     * @Permission
     */
    public function getOperLogPageList(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success($this->operLogService->getPageList($this->request->all()));
    }

    /**
     * 删除操作日志
     * @DeleteMapping("realDeleteOperLog/{ids}")
     * @Permission
     */
    public function realDeleteOperLog(String $ids): \Psr\Http\Message\ResponseInterface
    {
        return $this->operLogService->realDelete($ids) ? $this->success() : $this->error();
    }

    /**
     * 删除登录日志
     * @DeleteMapping("realDeleteLoginLog/{ids}")
     * @Permission
     */
    public function realDeleteLoginLog(String $ids): \Psr\Http\Message\ResponseInterface
    {
        return $this->loginLogService->realDelete($ids) ? $this->success() : $this->error();
    }
}
