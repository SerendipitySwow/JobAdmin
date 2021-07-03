<?php
declare(strict_types=1);

namespace Mine\Generator;

use http\Exception\RuntimeException;
use Hyperf\Utils\Filesystem\Filesystem;

class ModuleGenerator extends MineGenerator
{
    /**
     * @var array
     */
    protected $moduleInfo;

    /**
     * 设置模块信息
     * @param array $moduleInfo
     * @return $this
     */
    public function setModuleInfo(array $moduleInfo): ModuleGenerator
    {
        $this->moduleInfo = $moduleInfo;
        return $this;
    }

    /**
     * 生成模块基础架构
     */
    public function createModule(): bool
    {
        if (! ($this->moduleInfo['name'] ?? false)) {
            throw new RuntimeException('模块名称为空');
        }

        $this->moduleInfo['name'] = ucfirst($this->moduleInfo['name']);

        if (! empty($this->mine->getModuleInfo($this->moduleInfo['name']))) {
            throw new RuntimeException('同名模块已存在');
        }

        $appPath = BASE_PATH . '/app/';
        $modulePath = $appPath . $this->moduleInfo['name'] . '/';

        /** @var Filesystem $filesystem */
        $filesystem = make(Filesystem::class);
        $filesystem->makeDirectory($appPath . $this->moduleInfo['name']);

        foreach ($this->getGeneratorDirs() as $dir) {
            $filesystem->makeDirectory($modulePath . $dir);
        }

        $this->createModuleJSON();

        return true;
    }

    /**
     * 创建模块JSON文件
     */
    protected function createModuleJSON()
    {

    }

    /**
     * 生成的目录列表
     */
    protected function getGeneratorDirs(): array
    {
        return [
            'Controller',
            'Model',
            'Listener',
            'Request',
            'Service',
            'Mapper',
            'DataBase',
            'Middleware',
        ];
    }
}