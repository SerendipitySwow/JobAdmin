<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemUploadFileMapper;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Upload\UploadedFile;
use Mine\Abstracts\AbstractService;
use Mine\MineUpload;
use Psr\EventDispatcher\EventDispatcherInterface;

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

    /**
     * @Inject
     * @var EventDispatcherInterface
     */
    protected $evDispatcher;

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

    /**
     * 真实删除文件
     * @param string $ids
     * @return bool
     */
    public function realDelete(string $ids): bool
    {
        $event = new \Mine\Event\realDeleteUploadfile($ids);
        $this->evDispatcher->dispatch($event);
        return $event->getConfirm() ? parent::realDelete($ids) : false;
    }
}
