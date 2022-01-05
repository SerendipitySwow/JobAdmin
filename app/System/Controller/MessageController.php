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
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use App\System\Middleware\WsAuthMiddleware;
use Mine\MineController;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

/**
 * Class MessageController
 * @package App\System\Controller
 * @Controller(server="message",prefix="message.io")
 * @Middleware(WsAuthMiddleware::class)
 */
class MessageController extends MineController implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{
    /**
     * 成功连接到 ws 回调
     * @param Response|Server $server
     * @param Request $request
     */
    public function onOpen($server, Request $request): void
    {
        // TODO: Implement onOpen() method.
    }

    /**
     * 消息回调
     * @param Response|Server $server
     * @param Frame $frame
     */
    public function onMessage($server, Frame $frame): void
    {
        // TODO: Implement onMessage() method.
    }

    /**
     * 关闭 ws 连接回调
     * @param Response|\Swoole\Server $server
     * @param int $fd
     * @param int $reactorId
     */
    public function onClose($server, int $fd, int $reactorId): void
    {
        // TODO: Implement onClose() method.
    }


}