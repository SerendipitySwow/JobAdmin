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
     * 列表
     * @GetMapping("index")
     * @return ResponseInterface
     * @Permission("system:queueMessage:index")
     */
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }

    /**
     * 用户信息列表
     * @GetMapping("userMessage")
     * @return ResponseInterface
     * @Permission("system:queueMessage:index")
     */
    public function userMessage(): ResponseInterface
    {
        return $this->success($this->service->getList($this->request->all()));
    }

    /**
     * 回收站列表
     * @GetMapping("recycle")
     * @return ResponseInterface
     * @Permission("system:queueMessage:recycle")
     */
    public function recycle(): ResponseInterface
    {
        return $this->success($this->service->getPageListByRecycle($this->request->all()));
    }

    /**
     * 读取数据
     * @GetMapping("read/{id}")
     * @param int $id
     * @return ResponseInterface
     * @Permission("system:message:read")
     */
    public function read(int $id): ResponseInterface
    {
        return $this->success($this->service->read($id));
    }

    /**
     * 更新
     * @PutMapping("update/{id}")
     * @param int $id
     * @param SystemMessageUpdateRequest $request
     * @return ResponseInterface
     * @Permission("system:message:update")
     * @OperationLog
     */
    public function update(int $id, SystemMessageUpdateRequest $request): ResponseInterface
    {
        return $this->service->update($id, $request->all()) ? $this->success() : $this->error();
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
}
