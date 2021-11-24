<?php

declare(strict_types=1);

namespace App\Amqp\Producer;

use Hyperf\Amqp\Annotation\Producer;
use Hyperf\Amqp\Message\ProducerMessage;

/**
 * @Producer(exchange="hyperf", routingKey="message.routing")
 */
#[Producer(exchange: 'hyperf', routingKey: 'message.routing')]
class MessageProducer extends ProducerMessage
{
    public function __construct($data)
    {
        $this->payload = $data;
    }
}
