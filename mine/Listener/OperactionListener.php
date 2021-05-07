<?php


namespace Mine\Listener;


use App\System\Service\SystemOperLogService;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Mine\Event\Operation;
use Mine\MineRequest;
use Psr\Container\ContainerInterface;

/**
 * Class OperactionListener
 * @package Mine\Listener
 * @Listener
 */
class OperactionListener implements ListenerInterface
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return string[] returns the events that you want to listen
     */
    public function listen(): array
    {
        return [
            Operation::class
        ];
    }

    /**
     * Handle the Event when the event is triggered, all listeners will
     * complete before the event is returned to the EventDispatcher.
     * @throws \HyperfExt\Jwt\Exceptions\JwtException
     * @var Operation $event
     */
    public function process(object $event)
    {
        $requestInfo = $event->getRequsetInfo();
        $service = $this->container->get(SystemOperLogService::class);
        $request = $this->container->get(MineRequest::class);
        $requestInfo['created_by'] = $request->getId();
        $requestInfo['data'] = json_encode($requestInfo['data']);
        $service->save($requestInfo);
    }
}