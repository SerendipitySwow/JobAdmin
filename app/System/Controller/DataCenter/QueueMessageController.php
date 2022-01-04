<?php

declare(strict_types=1);
namespace App\System\Controller\DataCenter;

use App\System\Model\SystemQueueMessage;
use App\System\Service\SystemQueueMessageService;
use App\System\Request\Message\SystemMessageCreateRequest;
use App\System\Request\Message\SystemMessageUpdateRequest;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\OperationLog;
use Mine\Annotation\Permission;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * 信息管理控制器
 * Class MessageController
 * @Controller(prefix="system/queueMessage")
 * @Auth
 */
class QueueMessageController extends MineController
{
    /**
     * @Inject
     * @var SystemQueueMessageService
     */
    protected $service;

    /**
     * 接收消息列表
     * @GetMapping("receiveList")
     * @return ResponseInterface
     */
    public function receiveList(): ResponseInterface
    {
        return $this->success($this->service->getReceiveMessage($this->request->all()));
    }

    /**
     * 已发送消息列表
     * @GetMapping("sendList")
     * @return ResponseInterface
     */
    public function sendList(): ResponseInterface
    {
        return $this->success($this->service->getSendMessage($this->request->all()));
    }

    /**
     * 获取接收人列表
     * @GetMapping("getReceiveUser")
     * @return ResponseInterface
     */
    public function getReceiveUser(): ResponseInterface
    {
        return $this->success(
            $this->service->getReceiveUserList( $this->request->input('id', 0) )
        );
    }

    /**
     * 单个或批量删除数据到回收站
     * @DeleteMapping("delete/{ids}")
     * @param String $ids
     * @return ResponseInterface
     * @OperationLog
     */
    public function delete(String $ids): ResponseInterface
    {
        return $this->service->delete($ids) ? $this->success() : $this->error();
    }

    /**
     * 更新状态到已读
     * @PutMapping("updateReadStatus/{ids}")
     * @param String $ids
     * @return ResponseInterface
     * @OperationLog
     */
    public function updateReadStatus(String $ids): ResponseInterface
    {
        return $this->service->updateDataStatus($ids) ? $this->success() : $this->error();
    }
}
