<?php

declare(strict_types=1);
namespace Mine\Crontab;

use App\Setting\Model\SettingCrontab;
use App\Setting\Service\SettingCrontabService;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Crontab\Parser;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\Redis\Redis;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * 定时任务管理器
 * Class MineCrontabManage
 * @package Mine\Crontab
 */
class MineCrontabManage
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var Parser
     */
    protected $parser;

    /**
     * @Inject
     * @var ClientFactory
     */
    protected $clientFactory;

    /**
     * @var SettingCrontabService
     */
    protected $crontabService;

    /**
     * @var Redis
     */
    protected $redis;


    /**
     * MineCrontabManage constructor.
     */
    public function __construct()
    {
        $this->crontabService = $this->container->get(SettingCrontabService::class);

        $this->redis = $this->container->get(Redis::class);
    }

    /**
     * 获取定时任务列表
     * @return array
     */
    public function getCrontabList(): array
    {
        $data = $this->redis->get('MineAdmin:crontab');

        if ($data === false) {
            $data = $this->crontabService->getList([
                'select' => 'name,type,target,rule,parameter,fail_policy',
                'status' => '0',
            ]);
            $this->redis->set('MineAdmin:crontab', serialize($data));
        } else {
            $data = unserialize($data);
        }

        $logger = $this->container->get(StdoutLoggerInterface::class);
        $last = time();
        $list = [];

        foreach ($data as $item) {

            $crontab = new MineCrontab();
            $crontab->setCallback($item['target']);
            $crontab->setType($item['type']);
            $crontab->setEnable(true);
            $crontab->setFailPolicy($item['fail_policy']);
            $crontab->setName($item['name']);
            $crontab->setParameter($item['parameter'] ?: '');
            $crontab->setRule($item['rule']);

            if (!$this->parser->isValid($crontab->getRule())) {
                $logger->info('Crontab task ['.$item['name'].'] rule error, skipping execution');
                continue;
            }

            $time = $this->parser->parse($crontab->getRule(), $last);
            if ($time) {
                foreach ($time as $t) {
                    $list[] = clone $crontab->setExecuteTime($t);
                }
            }
        }
        return $list;
    }
}