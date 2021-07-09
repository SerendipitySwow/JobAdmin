<?php

declare(strict_types=1);
namespace App\System\Controller;

use App\System\Request\Upload\UploadFileRequest;
use App\System\Request\Upload\UploadImageRequest;
use App\System\Service\SystemUploadFileService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Filesystem\FilesystemFactory;
use Mine\Annotation\Auth;
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
     * @param UploadFileRequest $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \League\Flysystem\FileExistsException
     * @Auth
     */
    public function uploadFile(UploadFileRequest $request): \Psr\Http\Message\ResponseInterface
    {
        if ($request->validated() && $request->file('file')->isValid()) {
            $data = $this->service->upload(
                $request->file('file'), ['path' => $request->input('path', null)]
            );
            return empty($data) ? $this->error() : $this->success($data);
        } else {
            return $this->error('文件上传验证不通过');
        }
    }

    /**
     * 上传图片
     * @PostMapping("uploadImage")
     * @param UploadImageRequest $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \League\Flysystem\FileExistsException
     * @Auth
     */
    public function uploadImage(UploadImageRequest $request): \Psr\Http\Message\ResponseInterface
    {
        if ($request->validated() && $request->file('image')->isValid()) {
            $data = $this->service->upload(
                $request->file('image'), ['path' => $request->input('path', null)]
            );
            return empty($data) ? $this->error() : $this->success($data);
        } else {
            return $this->error('图片上传验证不通过');
        }
    }

    /**
     * 获取可上传的目录
     * @GetMapping("getDirectory")
     * @Auth
     */
    public function getDirectory(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success(
            $this->service->getDirectory($this->request->input('path', ''))
        );
    }

    /**
     * 获取当前目录所有文件和目录
     * @GetMapping("getAllFiles")
     * @Auth
     */
    public function getAllFile(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success(
            $this->service->getAllFile($this->request->all())
        );
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
     * 获取文件信息
     * @GetMapping("getFileInfo")
     */
    public function getFileInfo(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success($this->service->read($this->request->input('id', null)));
    }
}