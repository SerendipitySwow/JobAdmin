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
     * 获取根目录下所有目录
     * @param string $path
     * @return array
     */
    public function getDirectory(string $path = ''): array
    {
        return $this->mineUpload->getDirectory($path);
    }

    /**
     * 获取当前目录下所有文件（包含目录）
     * @param array $params
     * @return array
     */
    public function getAllFile(array $params = []): array
    {
        $collect = new Collection(
            $this->mineUpload->listContents($params['path'] ?? '')
        );

        if ($params['name'] ?? false) {
            $collect = $collect->filter(function ($row) use ($params) {
                return \Mine\Helper\Str::contains($row->Name, $params['name']);
            });
        }

        $data = $collect->forPage(
            (int) $params['page'] ?? 1,
            (int) $params['pageSize'] ?? 10
        )->toArray();

        foreach ($data as &$item) {
            $item['url'] = $this->mineUpload->assembleUrl($item['dirname'], $item['basename']);
        }

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
