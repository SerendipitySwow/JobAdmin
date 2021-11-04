<?php
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

declare(strict_types=1);

namespace Mine;

use App\Setting\Service\SettingConfigService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Filesystem\FilesystemFactory;
use League\Flysystem\Filesystem;
use Mine\Exception\NormalStatusException;
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
        $path = $this->getPath($config);
        $filename = $this->getNewName() . '.' . $uploadedFile->getExtension();

        if (!$this->filesystem->writeStream($path . '/' . $filename, $uploadedFile->getStream()->detach())) {
            throw new NormalStatusException($uploadedFile->getError(), 500);
        }

        $fileInfo = [
            'storage_mode' => $this->getMappingMode(),
            'origin_name' => $uploadedFile->getClientFilename(),
            'object_name' => $filename,
            'mime_type' => $uploadedFile->getClientMediaType(),
            'storage_path' => $path,
            'suffix' => $uploadedFile->getExtension(),
            'size_byte' => $uploadedFile->getSize(),
            'size_info' => format_size($uploadedFile->getSize()),
            'url' => $this->assembleUrl($path, $filename),
        ];

        $this->evDispatcher->dispatch(new \Mine\Event\UploadAfter($fileInfo));

        return $fileInfo;
    }

    /**
     * 保存网络图片
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function handleSaveNetworkImage(array $data): array
    {
        $path = $this->getPath($data);
        $filename = $this->getNewName() . '.jpg';

        try {
            $content = file_get_contents($data['url']);

            $handle = fopen($data['url'], 'rb');
            $meta = stream_get_meta_data($handle);
            fclose($handle);

            $dataInfo = $meta['wrapper_data']['headers'] ?? $meta['wrapper_data'];
            $size = 0;

            foreach ($dataInfo as $va) {
                if ( preg_match('/length/iU', $va) ) {
                    $ts = explode(':', $va);
                    $size = intval(trim(array_pop($ts))) * 1024;
                    break;
                }
            }

            if (!$this->filesystem->write($path . '/' . $filename, $content)) {
                throw new \Exception(t('network_image_save_fail'));
            }

        } catch (\Throwable $e) {
            throw new NormalStatusException($e->getMessage(), 500);
        }

        $fileInfo = [
            'storage_mode' => $this->getMappingMode(),
            'origin_name' => md5((string) time()).'.jpg',
            'object_name' => $filename,
            'mime_type' => 'image/jpg',
            'storage_path' => $path,
            'suffix' => 'jpg',
            'size_byte' => $size,
            'size_info' => format_size($size),
            'url' => $this->assembleUrl($path, $filename),
        ];

        $this->evDispatcher->dispatch(new \Mine\Event\UploadAfter($fileInfo));

        return $fileInfo;
    }

    protected function getPath($config)
    {
        return empty($config['path']) ? date('Ymd') : $config['path'];
    }

    /**
     * 创建目录
     * @param string $name
     * @return bool
     */
    public function createUploadDir(string $name): bool
    {
        return $this->filesystem->createDir($name);
    }

    /**
     * 获取目录内容
     * @param string $path
     * @return array
     */
    public function listContents(string $path = ''): array
    {
        return $this->filesystem->listContents($path);
    }

    /**
     * 获取目录
     * @param string $path
     * @param bool $isChildren
     * @return array
     */
    public function getDirectory(string $path, bool $isChildren): array
    {
        $contents = $this->filesystem->listContents($path, $isChildren);
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
    public function assembleUrl(string $path, string $filename): string
    {
        $realpath =  '/'. $path . '/' . $filename;
        $mode = $this->getStorageMode();
        $host = $this->container->get(SettingConfigService::class)->getConfigByKey('site_resource_host')['value'];
        if (empty($host)) {
            $host = '127.0.0.1:'. config('server.servers')[0]['port'];
        }
        if ($mode == 'local') {
            return $this->getProtocol() . $host .'/uploadfile'.$realpath;
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
        return $this->container->get(SettingConfigService::class)->getConfigByKey('site_storage_mode')['value'] ?? 'local';
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
}