<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemUploadFileMapper;
use Mine\Abstracts\AbstractService;

/**
 * 文件上传业务
 * Class SystemLoginLogService
 * @package App\System\Service
 */
class SystemUploadFileService extends AbstractService
{
    /**
     * @var SystemUploadFileMapper
     */
    public $mapper;

    public function __construct(SystemUploadFileMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 获取存储方式
     */
    public function getStorageMode()
    {

    }

    /**
     * 获取存储配置
     */
    public function getStorageConfig()
    {

    }

    /**
     * 获取
     */
}