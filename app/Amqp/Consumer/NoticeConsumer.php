<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * @Consumer(exchange="hyperf", routingKey="notice.routing", queue="notice.queue", name="notice.queue", nums=1)
 */
#[Consumer(exchange: 'hyperf', routingKey: 'notice.routing', queue: 'notice.queue', name: "notice.queue", nums: 1)]
class NoticeConsumer extends ConsumerMessage
{
    public function consumeMessage($data, AMQPMessage $message): string
    {
        parent::consumeMessage($data,$message);
        return Result::ACK;
    }
}
