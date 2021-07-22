<?php
declare(strict_types=1);
namespace Mine;

use Hyperf\Crontab\Parser;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Crontab\Annotation\Crontab;
use Hyperf\Di\Annotation\Inject;

/**
 * 定时任务
 * Class MineCrontab
 * @package Mine
 * @Crontab(name="MineAdmin Crontab", rule="* * * * *", callback="execute", memo="MineAdmin定时任务调度器")
 */
class MineCrontab
{
    /**
     * @Inject
     * @var StdoutLoggerInterface
     */
    private $logger;

    /**
     * @Inject
     * @var Parser
     */
    private $parser;

    public function execute()
    {
//        Coroutine::create(function () use ($crontab) {
//            if ($crontab->getExecuteTime() instanceof Carbon) {
//                $wait = $crontab->getExecuteTime()->getTimeStamp() - time();
//                $wait > 0 && \Swoole\Coroutine::sleep($wait);
//                $executor = $this->container->get(Executor::class);
//                $executor->execute($crontab);
//            }
//        });
        $times = $this->parser->parse("*/2 * * * *", time());
        if ($times) {
            foreach ($times as $time) {
                echo $time->getTimestamp() - time();
                echo PHP_EOL;
                echo time() - $time->getTimestamp();
                if (time() >= $time->getTimestamp()) {
                    echo PHP_EOL;
                    echo '123';
                    echo PHP_EOL;
//                    (new \App\System\Crontab\O)->execute();
                }
            }
        }
        $this->logger->info('crontab run time at:' . date('Y-m-d H:i:s'));
    }
}