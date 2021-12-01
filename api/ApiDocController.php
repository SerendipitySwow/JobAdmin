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
namespace Api;

use App\System\Service\SystemAppService;
use Hyperf\HttpServer\Annotation\PostMapping;
use Mine\Helper\MineCode;
use Mine\MineApi;
use Hyperf\HttpServer\Annotation\Controller;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ApiDocController
 * @package Api
 * @Controller(prefix="apiDoc")
 */
class ApiDocController extends MineApi
{
    /**
     * 登录文档
     * @PostMapping("login")
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function login(): ResponseInterface
    {
        $app_id = $this->request->input('app_id', '');
        $app_secret = $this->request->input('app_secret', '');

        if (empty($app_id) && empty($app_secret)) {
            return $this->error(t('mineadmin.api_auth_fail'), MineCode::API_PARAMS_ERROR);
        }

        $service = container()->get(SystemAppService::class);
        if (($code = $service->verifyEasyMode($app_id, $app_secret)) !== MineCode::API_VERIFY_PASS) {
            return $this->error(t('mineadmin.api_auth_fail'), $code);
        }

        return $this->success();
    }

}