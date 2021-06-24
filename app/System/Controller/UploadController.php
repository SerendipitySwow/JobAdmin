<?php

declare(strict_types=1);
namespace App\System\Controller;

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
     * @inject
     * @var FilesystemFactory
     */
    protected $factory;

    /**
     * @PostMapping("uploadFile")
     */
    public function uploadFile()
    {
        return '123';
    }

    /**
     * @PostMapping("uploadImage")
     * @throws \League\Flysystem\FileExistsException
     */
    public function uploadImage()
    {
        $image = $this->request->file('image');
        $local = $this->factory->get('local');
        $ok = $local->write('aaa1.jpg', $image->getStream()->getContents());
        print_r($ok);
        return $this->success($ok);
    }

    /**
     * @PostMapping("uploadVideo")
     */
    public function uploadVideo()
    {

    }

    /**
     * @GetMapping("download")
     */
    public function download()
    {

    }

    /**
     * @GetMapping("getFileUrl")
     */
    public function getFileUrl()
    {

    }

    /**
     * @GetMapping("getFileInfo")
     */
    public function getFileInfo()
    {

    }
}