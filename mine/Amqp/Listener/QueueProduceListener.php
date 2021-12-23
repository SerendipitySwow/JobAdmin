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

    /**
     * @param object $event
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     */
    public function process(object $event)
    {
        $this->setId(snowflake_id());
        $this->service = container()->get(SystemQueueService::class);
        $class = get_class($event);
        $func = lcfirst(trim(strrchr($class, '\\'),'\\'));
        $this->$func($event);
    }

    /**
     * Description:生产前
     * User:mike
     * @param object $event
     */
    public function beforeProduce(object $event){

        $queueName = strchr($event->producer->getRoutingKey(),'.',true).'.queue';

        $id = $this->getId();

        $event->producer->setPayload(
            [ 'id'=> $id, 'data' => json_decode( $event->producer->payload() ) ]
        );

        $this->service->save([
            'id'=> $id,
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
        // TODO...
    }

    /**
     * Description:生产后
     * User:mike
     * @param object $event
     */
    public function afterProduce(object $event): void
    {
        // TODO...
    }

    /**
     * Description:生产失败
     * User:mike
     */
    public function failToProduce(object $event): void
    {
        $this->service->update($this->getId(), [
            'produce_status' => SystemQueue::PRODUCE_STATUS_FAIL,
            'log_content' => $event->throwable ?: $event->throwable->getMessage()
        ]);
    }

    public function setId(string $uuid): void
    {
        Context::set('id', $uuid);
    }

    public function getId(): string
    {
        return Context::get('id', '');
    }
}
