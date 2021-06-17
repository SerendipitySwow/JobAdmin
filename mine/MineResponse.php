<?php
declare(strict_types=1);

namespace Mine;

use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Class MineResponse
 * @package MineServer
 */
class MineResponse extends Response
{
    /**
     * @param string|null $message
     * @param array | object $data
     * @param int $code
     * @return ResponseInterface
     */
    public function success(string $message = null, $data = [], $code = 200): ResponseInterface
    {
        $format = [
            'success' => true,
            'message' => $message ?: '请求成功',
            'code'    => $code,
            'data'    => &$data,
        ];
        $format = $this->toJson($format);
        return $this->getResponse()
            ->withHeader('Server', 'MineAdmin')
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withBody(new SwooleStream($format));
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $code
     * @return ResponseInterface
     */
    public function error(string $message = '', int $code = 500, array $data = []): ResponseInterface
    {
        $format = [
            'success' => false,
            'code'    => $code,
            'message' => $message ?: '请求失败',
        ];

        if (!empty($data)) {
            $format['data'] = &$data;
        }

        $format = $this->toJson($format);
        return $this->getResponse()
            ->withHeader('Server', 'MineAdmin')
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withBody(new SwooleStream($format));
    }
}

