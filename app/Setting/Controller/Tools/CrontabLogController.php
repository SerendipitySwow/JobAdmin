<?php

declare(strict_types=1);
namespace App\Setting\Controller\Tools;


use App\Setting\Service\SettingCrontabLogService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Mine\Annotation\Auth;
use Mine\MineController;

/**
 * 定时任务日志控制器
 * Class CrontabLogController
 * @package App\Setting\Controller\Tools
 * @Controller(prefix="setting/crontabLog")
 * @Auth
 */
class CrontabLogController extends MineController
{
    /**
     * @Inject
     * @var SettingCrontabLogService
     */
    protected $service;
}