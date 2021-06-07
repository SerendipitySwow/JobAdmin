<?php

declare(strict_types=1);
namespace Mine\Crontab;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Crontab\Crontab;
use Hyperf\Crontab\CrontabManager;
use Hyperf\Crontab\Event\CrontabDispatcherStarted;
use Hyperf\Crontab\Scheduler;
use Hyperf\Crontab\Strategy\StrategyInterface;
use Hyperf\Process\AbstractProcess;
use Hyperf\Process\ProcessManager;
use Psr\Container\ContainerInterface;
use Swoole\Server;

class MineCrontab extends AbstractProcess
{
    /**
     * @var string
     */
    public $name = 'mine-crontab-process';

    /**
     * @var Server
     */
    private $server;

    /**
     * @var Scheduler
     */
    private $scheduler;

    /**
     * @var CrontabManager
     */
    private $crontabManager;

    /**
     * @var StrategyInterface
     */
    private $strategy;

    /**
     * @var StdoutLoggerInterface
     */
    private $logger;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->crontabManager = $container->get(CrontabManager::class);
        $this->strategy = $container->get(StrategyInterface::class);
        $this->logger = $container->get(StdoutLoggerInterface::class);

        $this->registerCrontab();
    }

    /**
     * 注册定时任务
     */
    private function registerCrontab()
    {
        $this->scheduler = new Scheduler($this->crontabManager);
    }

    public function handle(): void
    {
        $this->event->dispatch(new CrontabDispatcherStarted());
        while (ProcessManager::isRunning()) {
            $this->sleep();
            $crontabs = $this->scheduler->schedule();
            while (! $crontabs->isEmpty()) {
                $crontab = $crontabs->dequeue();
                $this->strategy->dispatch($crontab);
            }
        }
    }

    public function bind($server): void
    {
        $this->server = $server;
        parent::bind($server);
    }

    public function isEnable($server): bool
    {
        return true;
    }

    private function sleep()
    {
        $current = date('s', time());
        $sleep = 60 - $current;
        $this->logger->debug('Crontab dispatcher sleep ' . $sleep . 's.');
        $sleep > 0 && \Swoole\Coroutine::sleep($sleep);
    }
}