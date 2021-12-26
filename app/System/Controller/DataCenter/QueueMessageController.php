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
        $params = $this->request->all();
//        $params['receive_by'] = user()->getId();
//        $params['send_status'] = SystemQueueMessage::STATUS_SEND_SUCCESS;
        $params['orderBy'] = 'id';
        $params['orderType'] = 'desc';
        return $this->success($this->service->getPageList($params));
    }

    /**
     * 用户信息列表
     * @GetMapping("userMessage")
     * @return ResponseInterface
     * @Permission("system:queueMessage:index")
     */
    public function userMessage(): ResponseInterface
    {
        $params = $this->request->all();
        $params['receive_by'] = user()->getId();
        $params['send_status'] = SystemQueueMessage::STATUS_SEND_SUCCESS;
        $params['read_status'] = SystemQueueMessage::STATUS_READ_NO;
        $params['type'] = 'log';
        $params['orderBy'] = 'id';
        $params['orderType'] = 'desc';
        return $this->success($this->service->getList($params));
    }

    /**
     * 日志列表
     * @GetMapping("log")
     * @return ResponseInterface
     * @Permission("system:queueMessage:log")
     */
    public function log(): ResponseInterface
    {
        $params = $this->request->all();
//        $params['orderBy'] = ['id'=>'desc'];
//        $params['orderBy'] = 'id desc';
        
        $params['orderBy'] = 'id';
        $params['orderType'] = 'desc';
        return $this->success($this->service->getLogPageList($params));
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
     * 发送信息
     * @PostMapping("send")
     * @param SystemMessageCreateRequest $request
     * ['content_id','content_type','title','content','receive_by','remark']
     * @return ResponseInterface
     * @Permission("system:queueMessage:save")
     * @OperationLog
     */
    public function send(SystemMessageCreateRequest $request): ResponseInterface
    {
        return $this->success($this->service->send($request->all()));
    }

    /**
     * Description:查看操作
     * User:mike
     * @PutMapping("look")
     * @return ResponseInterface
     */
    public function look(): ResponseInterface
    {
        return $this->service->look($this->request->input('id')) ? $this->success() : $this->error();
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
     * @Permission("system:message:delete")
     * @OperationLog
     */
    public function delete(String $ids): ResponseInterface
    {
        return $this->service->delete($ids) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量真实删除数据 （清空回收站）
     * @DeleteMapping("realDelete/{ids}")
     * @param String $ids
     * @return ResponseInterface
     * @Permission("system:message:realDelete")
     * @OperationLog
     */
    public function realDelete(String $ids): ResponseInterface
    {
        return $this->service->realDelete($ids) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量恢复在回收站的数据
     * @PutMapping("recovery/{ids}")
     * @param String $ids
     * @return ResponseInterface
     * @Permission("system:message:recovery")
     * @OperationLog
     */
    public function recovery(String $ids): ResponseInterface
    {
        return $this->service->recovery($ids) ? $this->success() : $this->error();
    }
}
