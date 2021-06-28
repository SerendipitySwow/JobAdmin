<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemUploadFileMapper;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Upload\UploadedFile;
use Mine\Abstracts\AbstractService;
use Mine\MineUpload;

/**
 * 文件上传业务
 * Class SystemLoginLogService
 * @package App\System\Service
 */
class SystemUploadFileService extends AbstractService
{
    /**
     * @Inject
     * @var \Hyperf\Contract\ConfigInterface
     */
    public $config;

    /**
     * @var SystemUploadFileMapper
     */
    public $mapper;

    /**
     * @var MineUpload
     */
    public $mineUpload;

    public function __construct(SystemUploadFileMapper $mapper, MineUpload $mineUpload)
    {
        $this->mapper = $mapper;
        $this->mineUpload = $mineUpload;
    }

    /**
     * 上传文件
     * @throws \League\Flysystem\FileExistsException
     */
    public function upload(UploadedFile $uploadedFile, array $config = []): int
    {
        return $this->save($this->mineUpload->upload($uploadedFile, $config));
    }
}
