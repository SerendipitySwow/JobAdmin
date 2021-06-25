<?php

declare(strict_types=1);
namespace App\System\Controller;

use App\System\Service\SystemUploadFileService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Filesystem\FilesystemFactory;
use Mine\MineController;

/**
 * Class UploadController
 * @package App\System\Controller
 * @Controller(prefix="system")
 */
class UploadController extends MineController
{
    /**
     * @Inject
     * @var SystemUploadFileService
     */
    protected $service;

    /**
     * 上传文件
     * @PostMapping("uploadFile")
     * @throws \Exception
     */
    public function uploadFile(): \Psr\Http\Message\ResponseInterface
    {
        $path = $this->request->input('path', null);
        $result = $this->service->upload($this->request->file('image'), ['path' => $path]);
        return $result ? $this->success() : $this->error();
    }

    /**
     * 上传图片
     * @PostMapping("uploadImage")
     * @throws \League\Flysystem\FileExistsException
     */
    public function uploadImage(): \Psr\Http\Message\ResponseInterface
    {
        $path = $this->request->input('path', null);
        $result = $this->service->upload($this->request->file('image'), ['path' => $path]);
        return $result ? $this->success() : $this->error();
    }

    /**
     * 下载文件
     * @GetMapping("download")
     */
    public function download()
    {
        print_r($this->request->getHeader('X-scheme'));
    }

    /**
     * 获取文件url
     * @GetMapping("getFileUrl")
     */
    public function getFileUrl()
    {

    }

    /**
     * 输出图片
     * @GetMapping("outPutImage")
     */
    public function outPutImage()
    {

    }
}