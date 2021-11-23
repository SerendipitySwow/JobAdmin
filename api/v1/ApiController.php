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
namespace Api\v1;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Mine\MineApi;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ApiController
 * @package Api\v1
 * @Controller(prefix="api/v1")
 */
class ApiController extends MineApi
{

    /**
     * @RequestMapping("index/{method}")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return $this->success([
            'txt' => 'api interface',
            'method' => $this->request->route('method'),
            'params' => $this->request->getQueryParams()
        ]);
    }
}