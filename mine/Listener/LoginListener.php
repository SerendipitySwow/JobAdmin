<?php

declare(strict_types=1);
namespace Mine\Listener;


use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Mine\Event\UserLoginBefore;
use Mine\MineRequest;
use Psr\Container\ContainerInterface;

/**
 * Class LoginListener
 * @Listener
 */
class LoginListener implements ListenerInterface
{

    protected $request;

    public function __construct(ContainerInterface $container)
    {
        $this->request = $container->get(MineRequest::class);
    }

    public function listen(): array
    {
        return [
            UserLoginBefore::class
        ];
    }

    /**
     * @param UserLoginBefore $event
     */
    public function process(object $event)
    {
        $event->inputData;
        $ip = $this->request->ip();
        echo $ip;
    }
}