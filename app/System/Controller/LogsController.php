<?php

declare(strict_types=1);
namespace App\System\Controller;


use App\System\Service\SystemLoginLogService;
use App\System\Service\SystemOperLogService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Mine\Annotation\Auth;
use Mine\MineController;

/**
 * Class LogsController
 * @package App\System\Controller
 * @Controller(prefix="system/logs")
 * @Auth
 */
class LogsController extends MineController
{
    /**
     * @Inject
     * @var SystemLoginLogService
     */
    public $loginLogService;

    /**
     * @Inject
     * @var SystemOperLogService
     */
    public $operLogService;

    /**
     * 获取登陆日志列表
     * @GetMapping("getLoginLogPageList")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getLoginLogPageList(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success($this->loginLogService->getPageList($this->request->all()));
    }

    /**
     * 获取操作日志列表
     * @GetMapping("getOperLogPageList")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getOperLogPageList(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success($this->operLogService->getPageList($this->request->all()));
    }
}