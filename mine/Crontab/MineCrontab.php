<?php
declare(strict_types=1);
namespace Mine\Crontab;

use Hyperf\Crontab\Parser;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Crontab\Annotation\Crontab;
use Hyperf\Di\Annotation\Inject;

/**
 * 定时任务
 * Class MineCrontab
 * @package Mine
 * @Crontab(name="MineAdmin Crontab", rule="* * * * *", singleton=true, callback="execute", memo="MineAdmin定时任务调度器")
 */
class MineCrontab
{
    /**
     * @Inject()
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
        $times = $this->parser->parse("*/1 * * * *", time());
        if ($times) {
            foreach ($times as $time) {
                if (time() >= $time->getTimestamp()) {
                    echo '123';
//                    (new \App\System\Crontab\O)->execute();
                }
            }
        }
        $this->logger->info('crontab run time at:' . date('Y-m-d H:i:s'));
    }
}