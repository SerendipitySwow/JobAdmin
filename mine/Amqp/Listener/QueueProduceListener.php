<?php
/**
 * Description:队列消费监听器
 * Created by phpStorm.
 * User: mike
 * Date: 2021/9/30
 * Time: 3:13 下午
 */
declare(strict_types=1);
namespace Mine\Amqp\Listener;

use App\System\Mapper\SystemQueueMapper;
use App\System\Model\SystemQueue;
use App\System\Service\SystemQueueService;
use Hyperf\Utils\Context;
use Mine\Helper\Str;
use Mine\Amqp\Event\AfterProduce;
use Mine\Amqp\Event\BeforeProduce;
use Mine\Amqp\Event\FailToProduce;
use Mine\Amqp\Event\ProduceEvent;
use Mine\Amqp\Event\WaitTimeout;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Event\Annotation\Listener;

/**
 * @Listener
 */
class QueueProduceListener implements ListenerInterface
{
    private $service;

    public function listen(): array
    {
        // 返回一个该监听器要监听的事件数组，可以同时监听多个事件
        return [
            AfterProduce::class,
            BeforeProduce::class,
            ProduceEvent::class,
            FailToProduce::class,
            WaitTimeout::class,
        ];
    }
    
    public function process(object $event)
    {
        $this->setUUID(Str::getUUID());
        $this->service = new SystemQueueService(new SystemQueueMapper());
        $class = get_class($event);
        $func = lcfirst(trim(strrchr($class, '\\'),'\\'));
        // 事件触发后该监听器要执行的代码写在这里，比如该示例下的发送用户注册成功短信等
        $this->$func($event);
    }

    /**
     * Description:生产前
     * User:mike
     * @param object $event
     */
    public function beforeProduce(object $event){

        $queueName = strchr($event->producer->getRoutingKey(),'.',true).'.queue';

        $uuid = $this->getUUID();

        $event->producer->setPayload(
            [ 'uuid'=> $uuid, 'data' => json_decode( $event->producer->payload() ) ]
        );

        $this->service->save([
            'uuid'=> $uuid,
            'exchange_name'=> $event->producer->getExchange(),
            'routing_key_name'=> $event->producer->getRoutingKey(),
            'queue_name'=> $queueName,
            'queue_content'=> $event->producer->payload(),
            'delay_time'=> $event->delayTime ?? 0,
            'produce_status'=>SystemQueue::PRODUCE_STATUS_SUCCESS
        ]);
    }

    /**
     * Description:生产中
     * User:mike
     * @param $producer
     * @param $delayTime
     */
    public function produceEvent($producer,$delayTime): void
    {
//        $condition = ['uuid'=>$this->uuid];
//        $data = ['produce_status'=>SystemRabbitmq::PRODUCE_STATUS_DOING];
//        $this->service->update($condition,$data);
    }

    /**
     * Description:生产后
     * User:mike
     * @param object $event
     */
    public function afterProduce(object $event): void
    {
//        $condition = ['uuid'=>$this->uuid];
//        $data = ['produce_status'=>SystemRabbitmq::PRODUCE_STATUS_SUCCESS];
//        $this->service->update($condition,$data);
    }

    /**
     * Description:生产失败
     * User:mike
     */
    public function failToProduce(object $event): void
    {
        $this->service->updateByCondition(
            ['uuid' => $this->getUuid()],
            [
                'produce_status' => SystemQueue::PRODUCE_STATUS_FAIL,
                'log_content' => $event->throwable ?? $event->throwable->getMessage()
            ]
        );
    }

    public function setUUID(string $uuid): void
    {
        Context::set('uuid', $uuid);
    }

    public function getUUID(): string
    {
        return Context::get('uuid', '');
    }
}
