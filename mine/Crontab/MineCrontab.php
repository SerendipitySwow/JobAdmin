<?php
declare(strict_types=1);
namespace Mine\Crontab;

use App\Setting\Model\SettingCrontab;
use Exception;
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
    protected $logger;

    /**
     * @Inject
     * @var MineCrontabManage
     */
    protected $mineCrontabManage;

    /**
     * 执行定时任务
     * @throws Exception
     */
    public function execute()
    {
        $crontab = $this->mineCrontabManage->getCrontabList();
        foreach ($crontab as $item) {
            co(function() use($item) {

                $wait = $item['executeTime'] - time();
                $wait > 0 && \Swoole\Coroutine::sleep($wait);

                $result = true;
                if ($item['type'] == SettingCrontab::COMMAND_CRONTAB) {
                    $result = $this->mineCrontabManage->commandCrontabExecute($item);
                }
                if ($item['type'] == SettingCrontab::CLASS_CRONTAB) {
                    $result = $this->mineCrontabManage->classCrontabExecute($item);
                }
                if ($item['type'] == SettingCrontab::URL_CRONTAB) {
                    $result = $this->mineCrontabManage->urlCrontabExecute($item);
                }

                $this->logger->info(
                    'crontab ['.$item['name'].'] run time at:' .
                    date('Y-m-d H:i:s') .
                    ' execute status: ' . $result ? 'OK' : 'ERROR'
                );
            });
        }
    }
}
