<?php

declare(strict_types=1);
namespace Mine\Event;

use App\System\Model\SystemUploadFile;
use League\Flysystem\Filesystem;

class RealDeleteUploadFile
{
    protected $model;

    protected $confirm = true;

    protected $filesystem;

    public function __construct(SystemUploadFile $model, Filesystem $filesystem)
    {
        $this->model = $model;
        $this->filesystem = $filesystem;
    }

    /**
     * 获取当前模型实例
     * @return SystemUploadFile
     */
    public function getModel(): SystemUploadFile
    {
        return $this->model;
    }

    /**
     * 获取文件处理系统
     * @return Filesystem
     */
    public function getFilesystem(): Filesystem
    {
        return $this->filesystem;
    }

    /**
     * 是否删除
     * @return bool
     */
    public function getConfirm(): bool
    {
        return $this->confirm;
    }

    public function setConfirm(bool $confirm): void
    {
        $this->confirm = $confirm;
    }
}