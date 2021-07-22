<?php

declare(strict_types=1);
namespace Mine\Crontab;

use _HumbugBoxfd814575fcc2\Nette\Neon\Exception;
use App\Setting\Model\SettingCrontab;
use App\Setting\Service\SettingCrontabLogService;
use App\Setting\Service\SettingCrontabService;
use GuzzleHttp\Exception\GuzzleException;
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
     * @var SettingCrontabLogService
     */
    protected $crontabLogService;

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

        $this->crontabLogService = $this->container->get(SettingCrontabLogService::class);

        $this->redis = $this->container->get(Redis::class);
    }

    /**
     * 获取定时任务列表
     * @return array
     */
    public function getCrontabList(): array
    {
        if (($crontab = $this->redis->get('MineAdmin:crontab')) === false) {
            $data = $this->crontabService->getList([
                'select' => 'id,name,type,target,rule,fail_policy',
                'status' => '0',
            ]);

            $last = time();

            $crontab = [];
            foreach ($data as $item) {
                $time = $this->parser->parse($item['rule'], $last);
                if ($time) {
                    foreach ($time as $t) {
                        $t['executeTime'] = $t->getTimestamp();
                        $crontab[] = $t;
                    }
                }
            }

            $this->redis->set('MineAdmin:crontab', $crontab);

        }
        return $crontab;
    }

    /**
     * 执行 command 命令定时任务
     * @param array $crontab
     * @param bool $isTry
     * @return bool
     */
    public function commandCrontabExecute(array $crontab, bool $isTry = false): bool
    {
        try {
            $parameter = $crontab['parameter'] ?: '{}';
            $input = new ArrayInput(json_decode($parameter, true));
            $output = new NullOutput();

            /** @var \Symfony\Component\Console\Application $application */
            $application = $this->container->get(\Hyperf\Contract\ApplicationInterface::class);
            $application->setAutoExit(false);
            $result = $application->find($crontab['target'])->run($input, $output);

        } catch (\Exception $e) {
            if ($isTry) {
                return false;
            }
            return $this->policyRun('commandCrontabExecute', $crontab);
        }
        return true;
    }

    /**
     * 执行 class 命令定时任务
     * @param array $crontab
     * @param bool $isTry
     * @return bool
     */
    public function classCrontabExecute(array $crontab, bool $isTry = false): bool
    {
        $targetClass = new $crontab['target'];
        try {
            if (method_exists($targetClass, 'execute')) {
                if ($targetClass->execute($crontab['parameter']) !== false) {
                    return true;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {
            if ($isTry) {
                return false;
            }
            return $this->policyRun('classCrontabExecute', $crontab);
        }
        return true;
    }

    /**
     * 执行 url 定时任务
     * @param array $crontab
     * @param bool $isTry
     * @return bool
     */
    public function urlCrontabExecute(array $crontab, bool $isTry = false): bool
    {
        $client = $this->clientFactory->create();
        try {
            $result = $client->get($crontab['target']);
            if ($result->getStatusCode() !== 200) {
                throw new \Exception;
            }
        } catch (\Exception $e) {
            if ($isTry) {
                return false;
            }
        } catch (GuzzleException $e) {
            return $this->policyRun('urlCrontabExecute', $crontab);
        }
        return true;
    }

    /**
     * @param string $method
     * @param array $crontab
     * @return bool
     */
    protected function policyRun(string $method, array $crontab): bool
    {
        if ($crontab['fail_policy'] == SettingCrontab::POLICY_GIVE_UP) {
            return false;
        } else if ($crontab['fail_policy'] == SettingCrontab::POLICY_TRY_ONCE) {
            return $this->{$method}($crontab, true);
        } else if ($crontab['fail_policy'] == SettingCrontab::POLICY_TRY_RUN) {
            return $this->{$method}($crontab);
        }
        return false;
    }

    /**
     * 写入定时任务执行日志
     */
    protected function writeCrontabLog()
    {}
}