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

namespace Mine\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Mine\Exception\NormalStatusException;
use Mine\Helper\MineCode;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Class DataNotFoundExceptionHandler
 * @package Mine\Exception\Handler
 */
class NormalStatusExceptionHandler extends ExceptionHandler
{
    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        $this->stopPropagation();
        $format = [
            'success' => false,
            'message' => $throwable->getMessage(),
        ];
        if ($throwable->getCode() != 200 && $throwable->getCode() != 0) {
            $format['code'] = $throwable->getCode();
        }
//        logger('Exception log')->debug($throwable->getMessage());
        return $response->withHeader('Server', 'MineAdmin')
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withBody(new SwooleStream(Json::encode($format)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof NormalStatusException;
    }
}
