<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemUploadFileMapper;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Upload\UploadedFile;
use Hyperf\Utils\Collection;
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


    public function __construct(SystemUploadFileMapper $mapper, MineUpload $mineUpload)
    {
        $this->mapper = $mapper;
        $this->mineUpload = $mineUpload;
    }

    /**
     * 上传文件
     * @param UploadedFile $uploadedFile
     * @param array $config
     * @return array
     * @throws \League\Flysystem\FileExistsException
     */
    public function upload(UploadedFile $uploadedFile, array $config = []): array
    {
        $data = $this->mineUpload->upload($uploadedFile, $config);
        if ($this->save($data)) {
            return $data;
        } else {
            return [];
        }
    }

    /**
     * 创建新目录
     * @param array $params
     * @return bool
     */
    public function createUploadDir(array $params): bool
    {
        $name = $params['name'];
        if ($params['path'] ?? false) {
            $name = $params['path'] . '/' . $name;
        }
        return $this->mineUpload->createUploadDir($name);
    }

    /**
     * 获取根目录下所有目录
     * @param string $path
     * @param bool $isChildren
     * @return array
     */
    public function getDirectory(string $path = '', bool $isChildren = false): array
    {
        return $this->mineUpload->getDirectory($path, $isChildren);
    }

    /**
     * 获取当前目录下所有文件（包含目录）
     * @param array $params
     * @return array
     */
    public function getAllFile(array $params = []): array
    {
        $directory = $this->getDirectory($params['storage_path'] ?? '');

        $params['select'] = [
            'origin_name',
            'object_name',
            'mime_type',
            'url',
            'size_info',
            'storage_path',
            'created_at'
        ];

        $params['select'] = implode(',', $params['select']);

        $collect = new Collection( array_merge($directory, $this->getList($params)) );

        $data = $collect->forPage(
            (int) $params['page'] ?? 1,
            (int) $params['pageSize'] ?? 10
        )->toArray();

        return [
            'items' => $data,
            'pageInfo' => [
                'total' => $collect->count(),
                'currentPage' => $params['page'] ?? 1,
                'totalPage' => ceil($collect->count() / ($params['pageSize'] ?? 10))
            ]
        ];
    }
}
