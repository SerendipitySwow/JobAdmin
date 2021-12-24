<?php

declare(strict_types = 1);

namespace App\System\Service;

use App\System\Mapper\SystemQueueMessageMapper;
use App\System\Model\SystemQueueMessage;
use App\System\Model\SystemUser;
use App\System\Queue\Producer\MessageProducer;
use Hyperf\Di\Annotation\Inject;
use Mine\Abstracts\AbstractService;
use Mine\Amqp\DelayProducer;

/**
 * 信息管理服务类
 */
class SystemQueueMessageService extends AbstractService
{
    /**
     * @var SystemQueueMessageMapper
     */
    public $mapper;
    /**
     * @Inject
     * @var SystemUserService
     */
    public $userService;

    /**
     * @Inject
     * @var DelayProducer
     */
    protected $producer;

    public function __construct(SystemQueueMessageMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 获取列表数据（带分页）
     * @param array|null $params
     * @return array
     */
    public function getPageList(?array $params = null):array
    {
        $res = parent::getPageList($params);
        foreach($res['items'] as $key => $info){
            $info['receive_name'] = $info->receiveUser->nickname;
            $info['send_name']    = $info->sendUser->nickname;
            $res['items'][$key] = $info;
        }
        return $res;
    }

    /**
     * 获取列表数据（带分页）
     * @param array|null $params
     * @return array
     */
    public function getLogPageList(?array $params = null):array
    {
        $params['type'] = 'log';
        $res = parent::getPageList($params);
        foreach($res['items'] as $key => $info){
            $info['receive_name'] = $info->receiveUser->nickname;
            $info['send_name']    = $info->sendUser->nickname;
            $res['items'][$key] = $info;
        }
        return $res;
    }

    /**
     * Description:发送消息
     * User:mike
     * @param array $data
     * @return int
     */
    public function send(array $data):int
    {
        $this->setAttributes($data);
        $userIdArr = $this->receive_by;
        //发送所有用户
        if(!$this->receive_by){
            //获取所有用户Id
            $userIdArr = $this->userService->pluck(['status' => SystemUser::USER_NORMAL],'id');
        }
        $data['send_by'] = user()->getId();
        $messageId       = array_map(function($userId) use ($data){
            $data['receive_by'] = $userId;
            return $this->mapper->save($data);
        },$userIdArr);

        return $this->push($messageId);
    }

    /**
     * Description:查看操作
     * User:mike
     * @param int $messageId
     * @return int
     */
    public function look($messageId = 0):int
    {
        $condition = $messageId;
        if(!$messageId){
            $condition = [
                'receive_by' => user()->getId()
            ];
        }
        return $this->mapper->updateByCondition($condition,[
            'read_status' => SystemQueueMessage::STATUS_READ_YES
        ])?1:0;
    }

    /**
     * Description:发送队列
     * User:mike
     * @param array $messageId
     * @return int
     */
    protected function push(array $messageId):int
    {
        $message = new MessageProducer(['messageId' => $messageId]);
        return $this->producer->produce($message,false,5,0)?1:0;
    }
}
