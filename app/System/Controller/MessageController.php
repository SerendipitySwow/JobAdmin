<?php
declare(strict_types=1);

/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

namespace App\System\Controller;

use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Hyperf\Di\Annotation\Inject;
use Mine\Helper\LoginUser;
use Mine\MineController;
use Psr\Http\Message\ServerRequestInterface;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

/**
 * Class MessageController
 * @package App\System\Controller
 */
class MessageController extends MineController implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{
    /**
     * @Inject
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var LoginUser
     */
    protected $user;

    /**
     * 成功连接到 ws 回调
     * @param Response|Server $server
     * @param Request $request
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function onOpen($server, Request $request): void
    {
        $userinfo = $this->getUserinfo();
        console()->info(
            "WebSocket [ user connection to message server: id > {$userinfo['id']}, ".
            "fd > {$request->fd}, time > ". date('Y-m-d H:i:s') .' ]'
        );
    }

    /**
     * 消息回调
     * @param Response|Server $server
     * @param Frame $frame
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function onMessage($server, Frame $frame): void
    {
        $userinfo = $this->getUserinfo();
        if ($frame->data == 'PONG') {
            console()->info(
                "WebSocket [ user send 'PONG': id > {$userinfo['id']}, ".
                "fd > {$frame->fd}, time > ". date('Y-m-d H:i:s') .' ]'
            );
        } else {
            echo 'ok';
            // TODO...
        }
    }

    /**
     * 关闭 ws 连接回调
     * @param Response|\Swoole\Server $server
     * @param int $fd
     * @param int $reactorId
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function onClose($server, int $fd, int $reactorId): void
    {
        $user_id = '';
        console()->info(
            "WebSocket [ user close connect for message server: id > {$user_id}, ".
            "fd > {$fd}, time > ". date('Y-m-d H:i:s') .' ]'
        );
    }

    /**
     * 获取当前用户信息
     * @return array
     */
    protected function getUserinfo(): array
    {
        return $this->user->getUserInfo($this->request->getQueryParams()['token']);
    }
}