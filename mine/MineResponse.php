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
    public const ERROR_MISSING_PARAMS     = 10000;  // 缺少参数
    public const ERROR_PROVIDE_SERVICE    = 10001;  // 提供服务错误
    public const ERROR_DATA_NULL          = 10002;  // 数据为空
    public const ERROR_REQUEST_FAILED     = 10003;  // 请求失败
    public const ERROR_DATA_VALIDATE_FAIL = 10004;  // 数据验证不通过

    public const ERROR_TOKEN_EXPIRED      = 11005;  // TOKEN已过期失效
    public const ERROR_TOKEN_BLACKLIST    = 11006;  // TOKEN在黑名单里
    public const ERROR_TOKEN_NO_EXISTS    = 11007;  // TOKEN不存在
    public const ERROR_LOGIN_EXCEPTION    = 11008;  // 登录异常

    /**
     * @param string $message
     * @param array $data
     * @return ResponseInterface
     */
    public function success(string $message = '', array $data = []): ResponseInterface
    {
        $format = [
            'success' => true,
            'message' => $message ?: '请求成功',
            'data'    => &$data,
        ];
        $format = $this->toJson($format);
        return $this->getResponse()
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withBody(new SwooleStream($format));
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
        $format = [
            'success' => false,
            'message' => $message ?: '请求失败',
        ];

        if ($errorNo > 0) {
            $format['error_number'] = $errorNo;
        }

        if (!empty($data)) {
            $format['data'] = &$data;
        }

        $format = $this->toJson($format);
        return $this->getResponse()->withStatus($code)
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withBody(new SwooleStream($format));
    }
}

