<?php


namespace Mine;


use Hyperf\Di\Annotation\Inject;
use Hyperf\Filesystem\FilesystemFactory;
use Mine\Helper\Id;
use Hyperf\HttpMessage\Upload\UploadedFile;
use Psr\EventDispatcher\EventDispatcherInterface;

class MineUpload
{
    /**
     * @Inject
     * @var FilesystemFactory
     */
    protected $factory;

    /**
     * @Inject
     * @var EventDispatcherInterface
     */
    protected $evDispatcher;

    /**
     * 上传文件
     * @param UploadedFile $uploadedFile
     * @param array $config
     * @return array
     * @throws \League\Flysystem\FileExistsException
     */
    public function upload(UploadedFile $uploadedFile, array $config = []): array
    {
        return $this->handleUpload($uploadedFile, $config);
    }

    /**
     * 处理上传
     * @param UploadedFile $uploadedFile
     * @param array $config
     * @return array
     * @throws \League\Flysystem\FileExistsException
     * @throws \Exception
     */
    protected function handleUpload(UploadedFile $uploadedFile, array $config): array
    {
        $filesystem = $this->factory->get($this->getStorageMode());
        $path = $config['path'] ?? date('Ymd');
        $filename = $this->getNewName() . '.' . $uploadedFile->getExtension();

        if (! $filesystem->write($path . '/' . $filename, $uploadedFile->getStream()->getContents())) {
            throw new \HttpException($uploadedFile->getError(), 500);
        }

        $fileInfo = [
            'storage_mode' => $this->getMappingMode(),
            'origin_name'  => $uploadedFile->getClientFilename(),
            'object_name'  => $filename,
            'mime_type'    => $uploadedFile->getClientMediaType(),
            'storage_path' => $path,
            'suffix'       => $uploadedFile->getExtension(),
            'size_byte'    => $uploadedFile->getSize(),
            'size_info'    => $this->getSizeInfo($uploadedFile->getSize()),
            'url'          => $this->assembleUrl($path, $filename),
        ];

        $this->evDispatcher->dispatch(new \Mine\Event\UploadAfter($fileInfo));

        return $fileInfo;
    }

    /**
     * 组装url
     * @param string $path
     * @param $filename
     * @return string
     */
    protected function assembleUrl(string $path, $filename): string
    {
        $mode = $this->getStorageMode();
        if ($mode == 'local') {
            return 'http://' . env('HOST', '127.0.0.1') . '/' . $path . '/' . $filename;
        } else if ($mode == 'qiniu') {
            //todo
            return '';
        } else if ($mode == 'oss') {
            //todo
            return '';
        } else if ($mode == 'cos') {
            //todo
            return '';
        }
        return '';
    }

    /**
     * 获取存储方式
     */
    public function getStorageMode(): string
    {
        return 'local';
    }

    /**
     * 获取存储配置
     */
    public function getStorageConfig()
    {

    }

    /**
     * 获取编码后的文件名
     * @throws \Exception
     * @return string
     */
    public function getNewName(): string
    {
        $id = new Id(2, 2, 2);
        return (string) $id->getId();
    }

    /**
     * @return int
     */
    protected function getMappingMode(): int
    {
        $mapping = 1;
        switch ($this->getStorageMode()) {
            case 'local' :
                $mapping = 1;
                break;
            case 'oss' :
                $mapping = 2;
                break;
            case 'qiniu' :
                $mapping = 3;
                break;
            case 'cos' :
                $mapping = 4;
                break;
        }
        return $mapping;
    }

    protected function getSizeInfo(int $size): string
    {
        if ($size < 1024) {
            return $size . 'byte';
        } else if ($size < (1024 * 1024)) {
            return sprintf('%.2f', ($size / 1024)) . 'kb';
        } else {
            return sprintf('%.2f', ($size / 1024 / 1024)) . 'mb';
        }
    }
}