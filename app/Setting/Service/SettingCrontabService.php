<?php

declare(strict_types=1);
namespace App\Setting\Service;

use App\Setting\Mapper\SettingCrontabMapper;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use Mine\Abstracts\AbstractService;
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
        $this->redis->del('MineAdmin:crontab');

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
        $this->redis->del('MineAdmin:crontab');

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
        $this->redis->del('MineAdmin:crontab');

        return $res;
    }

    /**
     * 立即执行一次定时任务
     * @param $id
     */
    public function run($id)
    {

    }
}