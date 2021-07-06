<?php


namespace Mine;


use Hyperf\Di\Annotation\Inject;
use Hyperf\Filesystem\FilesystemFactory;
use League\Flysystem\Filesystem;
use Mine\Helper\Id;
use Hyperf\HttpMessage\Upload\UploadedFile;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Container\ContainerInterface;

class MineUpload
{
    /**
     * @Inject
     * @var FilesystemFactory
     */
    protected $factory;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @Inject
     * @var EventDispatcherInterface
     */
    protected $evDispatcher;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * 存储配置信息
     * @var mixed
     */
    protected $config;

    /**
     * MineUpload constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->config = config('file.storage');
        $this->filesystem = $this->factory->get($this->getStorageMode());
    }

    /**
     * 获取文件操作处理系统
     * @return Filesystem
     */
    public function getFileSystem(): Filesystem
    {
        return $this->filesystem;
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
        $path = $config['path'] ?? date('Ymd');
        $filename = $this->getNewName() . '.' . $uploadedFile->getExtension();

        if (! $this->filesystem->writeStream($path . '/' . $filename, $uploadedFile->getStream()->detach())) {
            throw new \RuntimeException($uploadedFile->getError(), 500);
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
     * 获取目录内容
     * @param string $path
     * @return array
     */
    public function listContents(string $path = ''): array
    {
        return $this->factory->get($this->getStorageMode())->listContents($path);
    }

    /**
     * 获取目录内容
     * @param string $path
     * @return array
     */
    public function getDirectory(string $path = ''): array
    {
        $contents = $this->filesystem->listContents($path);
        $dirs = [];
        foreach ($contents as $content) {
            if ($content['type'] == 'dir') {
                $dirs[] = $content;
            }
        }
        return $dirs;
    }

    /**
     * 组装url
     * @param string $path
     * @param string $filename
     * @return string
     */
    protected function assembleUrl(string $path, string $filename): string
    {
        $realpath =  '/'. $path . '/' . $filename;
        $mode = $this->getStorageMode();
        if ($mode == 'local') {
            return $this->getProtocol() . env('RESOURCE_HOST', '127.0.0.1:9501').$realpath;
        }
        if ($mode == 'qiniu') {
            $qiniu = $this->config['qiniu'];
            return $qiniu['schema'].$qiniu['domain'].$realpath;
        }
        if ($mode == 'oss') {
            $oss = $this->config['oss'];
            if ($oss['isCName'] === false) {
                return $oss['schema'].$oss['bucket'].'/'.$oss['endpoint'].$realpath;
            } else {
                return $oss['schema'].$oss['domain'].$realpath;
            }
        }
        if ($mode == 'cos') {
            $cos = $this->config['oss'];
            return $cos['schema'].$cos['domain'].$realpath;
        }
        return '';
    }

    /**
     * 获取存储方式
     */
    public function getStorageMode(): string
    {
        return config('file.default', 'local');
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

    protected function getProtocol(): string
    {
        return $this->container->get(MineRequest::class)->getScheme();
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