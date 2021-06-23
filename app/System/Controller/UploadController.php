<?php

declare(strict_types=1);
namespace App\System\Controller;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;

/**
 * Class UploadController
 * @package App\System\Controller
 * @Controller(prefix="system")
 */
class UploadController
{
    /**
     * @PostMapping("uploadFile")
     */
    public function uploadFile()
    {

    }

    /**
     * @PostMapping("uploadImage")
     */
    public function uploadImage()
    {

    }

    /**
     * @PostMapping("uploadVideo")
     */
    public function uploadVideo()
    {

    }

    /**
     * @GetMapping("download/{id}")
     */
    public function download()
    {

    }

    /**
     * @GetMapping("getFileUrl/{id}")
     */
    public function getFileUrl()
    {

    }

    /**
     * @GetMapping("getFileUrl/{id}")
     */
    public function getFileInfo()
    {

    }
}