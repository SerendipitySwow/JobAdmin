<?php

declare(strict_types=1);
namespace App\Setting\Controller\Settings;

use App\Setting\Service\SettingConfigService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\OperationLog;
use Mine\Annotation\Permission;
use Mine\MineController;

/**
 * 系统配置控制器
 * Class SystemConfigController
 * @package App\Setting\Controller\Settings
 * @Controller(prefix="setting/config")
 * @Auth
 */
class SystemConfigController extends MineController
{
    /**
     * @Inject
     * @var SettingConfigService
     */
    protected $service;

    /**
     * 获取系统组配置
     * @GetMapping("getSystemConfig")
     * @Permission("setting:config:getSystemConfig")
     */
    public function getSystemGroupConfig(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success($this->service->getSystemGroupConfig());
    }

    /**
     * 获取扩展组配置
     * @GetMapping("getExtendConfig")
     * @Permission("setting:config:getExtendConfig")
     */
    public function getExtendGroupConfig(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success($this->service->getExtendGroupConfig());
    }

    /**
     * 按组名获取配置
     * @GetMapping("getConfigByGroup")
     */
    public function getConfigByGroup(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success($this->service->getConfigByGroup($this->request->input('groupName', '')));
    }

    /**
     * 按key获取配置
     * @GetMapping("getConfigByKey")
     */
    public function getConfigByKey(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success($this->service->getConfigByGroup($this->request->input('key', '')));
    }

    /**
     * 保存系统配置组数据
     * @PostMapping("saveSystemConfig")
     * @Permission("setting:config:saveSystemConfig")
     * @OperationLog
     */
    public function saveSystemConfig(): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->saveSystemConfig($this->request->all()) ? $this->success() : $this->error();
    }

    /**
     * 清除配置缓存
     * @PostMapping("clearCache")
     * @Permission("setting:config:clearCache")
     * @OperationLog
     */
    public function clearCache(): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->clearCache() ? $this->success() : $this->error();
    }
}