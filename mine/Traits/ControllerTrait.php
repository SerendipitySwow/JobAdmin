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

declare(strict_types = 1);

namespace Mine\Traits;

use Hyperf\Di\Annotation\Inject;
use Mine\MineRequest;
use Mine\MineResponse;
use Psr\Http\Message\ResponseInterface;

trait ControllerTrait
{
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

    /**
     * 下载文件
     * @param string $filePath
     * @param string $name
     * @return ResponseInterface
     */
    public function _download(string $filePath, string $name = ''): ResponseInterface
    {
        return $this->response->download($filePath, $name);
    }
}