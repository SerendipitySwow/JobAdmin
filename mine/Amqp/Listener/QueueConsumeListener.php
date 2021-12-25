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

use App\System\Model\SystemQueueLog;
use App\System\Service\SystemQueueLogService;
use Hyperf\Utils\Context;
use Mine\Amqp\Event\AfterConsume;
use Mine\Amqp\Event\BeforeConsume;
use Mine\Amqp\Event\ConsumeEvent;
use Mine\Amqp\Event\FailToConsume;
use Mine\Amqp\Event\WaitTimeout;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Event\Annotation\Listener;
/**
 * @Listener
 */
class QueueConsumeListener implements ListenerInterface
{
    private $service;

    public function listen(): array
    {
        // 返回一个该监听器要监听的事件数组，可以同时监听多个事件
        return [
            AfterConsume::class,
            BeforeConsume::class,
            ConsumeEvent::class,
            FailToConsume::class,
            WaitTimeout::class,
        ];
    }

    public function process(object $event)
    {
        $this->service = container()->get(SystemQueueLogService::class);
        if ($event->message) {
            $class = get_class($event);
            $func = lcfirst(trim(strrchr($class, '\\'),'\\'));
            $this->$func($event);
        }
    }

    /**
     * Description:消费前
     * User:mike
     * @param object $event
     */
    public function beforeConsume(object $event)
    {
        $this->service->update((int) $event->data['id'], [ 'consume_status' => SystemQueueLog::CONSUME_STATUS_DOING ]);
    }

    /**
     * Description:消费中
     * User:mike
     * @param object $event
     */
    public function consumeEvent(object $event)
    {
        // TODO...
    }

    /**
     * Description:消费后
     * User:mike
     * @param object $event
     */
    public function afterConsume(object $event)
    {
        $this->service->update((int) $event->data['id'], [ 'consume_status' => SystemQueueLog::CONSUME_STATUS_SUCCESS ]);
    }

    /**
     * Description:消费失败
     * User:mike
     * @param object $event
     */
    public function failToConsume(object $event)
    {
        $this->service->update((int) $event->data['id'], [
            'consume_status' => SystemQueueLog::CONSUME_STATUS_4,
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
