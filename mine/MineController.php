<?php

declare(strict_types=1);
/**
 * This file is part of MineServer.
 */
namespace Mine;

use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class MineController
 * @package MineServer
 */
abstract class MineController
{
    /**
     * @Inject
     * @var Mine
     */
    protected $mine;

    /**
     * @Inject
     * @var MineRequest
     */
    protected $request;

    /**
     * @Inject
     * @var MineResponse
     */
    protected $response;

    /**
     * @param string $id
     * @return mixed
     */
    public function app(string $id)
    {
        return $this->mine->app($id);
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->mine->getContainer();
    }

    /**
     * @param string | array $msgOrData
     * @param array $data
     * @return ResponseInterface
     */
    public function success($msgOrData = '', $data = []): ResponseInterface
    {
        if (is_string($msgOrData) || is_null($msgOrData)) {
            return $this->response->success($msgOrData);
        } else if (!empty($msgOrData) && (is_array($msgOrData) || is_object($msgOrData))) {
            return $this->response->success('', $msgOrData);
        } else {
            return $this->response->success($msgOrData, $data);
        }
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $code
     * @param int $errorNo
     * @return ResponseInterface
     */
    public function error(string $message = '', array $data = [], int $code = 500, int $errorNo = 0): ResponseInterface
    {
        return $this->response->error($message = '', $data, $code, $errorNo);
    }

    /**
     * 跳转
     * @param string $toUrl
     * @param int $status
     * @param string $schema
     * @return ResponseInterface
     */
    public function redirect(string $toUrl, int $status = 302, string $schema = 'http'): ResponseInterface
    {
        return $this->response->redirect($toUrl, $status, $schema);
    }

    /**
     * 下载文件
     * @param string $file
     * @param string $name
     * @return ResponseInterface
     */
    public function download(string $file, string $name = ''): ResponseInterface
    {
        return $this->response->download($file, $name);
    }
}
