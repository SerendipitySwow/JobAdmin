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
     * @param int $code
     * @return ResponseInterface
     */
    public function success($msgOrData = '', $data = [], $code = 200): ResponseInterface
    {
        if (is_string($msgOrData) || is_null($msgOrData)) {
            return $this->response->success($msgOrData, $data, $code);
        } else if (is_array($msgOrData) || is_object($msgOrData)) {
            return $this->response->success(null, $msgOrData, $code);
        } else {
            return $this->response->success(null, $data, $code);
        }
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $code
     * @return ResponseInterface
     */
    public function error(string $message = '', int $code = 500, array $data = []): ResponseInterface
    {
        return $this->response->error($message, $code, $data);
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
}
