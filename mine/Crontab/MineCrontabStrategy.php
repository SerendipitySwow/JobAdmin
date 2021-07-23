<?php

declare(strict_types=1);
namespace Mine\Crontab;

use Hyperf\Di\Annotation\Inject;

class MineCrontabStrategy
{
    /**
     * @Inject
     * @var MineCrontabManage
     */
    private $mineCrontabManage;

    /**
     * @param array $crontab
     */
    public function dispatch(array $crontab)
    {
        co(function() use($crontab) {

            $wait = $crontab['executeTime'] - time();
            $wait > 0 && \Swoole\Coroutine::sleep($wait);

            $result = true;
            if ($crontab['type'] == SettingCrontab::COMMAND_CRONTAB) {
                $result = $this->mineCrontabManage->commandCrontabExecute($crontab);
            }
            if ($crontab['type'] == SettingCrontab::CLASS_CRONTAB) {
                $result = $this->mineCrontabManage->classCrontabExecute($crontab);
            }
            if ($crontab['type'] == SettingCrontab::URL_CRONTAB) {
                $result = $this->mineCrontabManage->urlCrontabExecute($crontab);
            }

            $this->logger->info(
                'crontab ['.$crontab['name'].'] run time at:' .
                date('Y-m-d H:i:s') .
                ' execute status: ' . $result ? 'OK' : 'ERROR'
            );
        });
    }
}