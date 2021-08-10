<?php

declare(strict_types=1);
namespace App\Setting\Service;

use App\Setting\Mapper\SettingCrontabMapper;
use Hyperf\Config\Annotation\Value;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use Mine\Abstracts\AbstractService;
use Mine\Crontab\MineCrontab;
use Mine\Crontab\MineExecutor;
use Psr\Container\ContainerInterface;

class SettingCrontabService extends AbstractService
{
    /**
     * @var SettingCrontabMapper
     */
    public $mapper;

    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Redis
     */
    protected $redis;

    /**
     * @Value("cache.default.prefix")
     * @var string
     */
    protected $prefix;

    public function __construct(SettingCrontabMapper $mapper)
    {
        $this->mapper = $mapper;
        $this->redis = $this->container->get(Redis::class);
    }

    /**
     * 保存
     * @param array $data
     * @return int
     */
    public function save(array $data): int
    {
        $id = parent::save($data);
        $this->redis->del($this->prefix . 'crontab');

        return $id;
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $res = parent::update($id, $data);
        $this->redis->del($this->prefix . 'crontab');

        return $res;
    }

    /**
     * 删除
     * @param string $ids
     * @return bool
     */
    public function delete(string $ids): bool
    {
        $res = parent::delete($ids);
        $this->redis->del($this->prefix . 'crontab');

        return $res;
    }

    /**
     * 立即执行一次定时任务
     * @param $id
     * @return bool|null
     */
    public function run($id): ?bool
    {
        $crontab = new MineCrontab();
        $model = $this->read($id);
        $crontab->setCallback($model->target);
        $crontab->setType($model->type);
        $crontab->setEnable(true);
        $crontab->setCrontabId($model->id);
        $crontab->setName($model->name);
        $crontab->setParameter($model->parameter ?: '');
        $crontab->setRule($model->rule);

        $executor = $this->container->get(MineExecutor::class);

        return $executor->execute($crontab, true);
    }
}