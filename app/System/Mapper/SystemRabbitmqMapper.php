<?php

declare(strict_types = 1);
namespace App\System\Mapper;

use App\System\Model\SystemRabbitmq;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 队列管理Mapper类
 */
class SystemRabbitmqMapper extends AbstractMapper
{
    /**
     * @var SystemRabbitmq
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemRabbitmq::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        
        // 交换机名称
        if (isset($params['exchange_name'])) {
            $query->where('exchange_name', '=', $params['exchange_name']);
        }

        // 路由名称
        if (isset($params['routing_key_name'])) {
            $query->where('routing_key_name', '=', $params['routing_key_name']);
        }

        // 队列名称
        if (isset($params['queue_name'])) {
            $query->where('queue_name', '=', $params['queue_name']);
        }

        // 队列内容
        if (isset($params['queue_content'])) {
            $query->where('queue_content', '=', $params['queue_content']);
        }

        // 日志内容
        if (isset($params['log_content'])) {
            $query->where('log_content', '=', $params['log_content']);
        }

        // 生产状态 0:未生产 1:生产中 2:生产成功 3:生产失败 4:生产重复
        if (isset($params['produce_status'])) {
            $query->where('produce_status', '=', $params['produce_status']);
        }

        // 消费状态 0:未消费 1:消费中 2:消费成功 3:消费失败 4:消费重复
        if (isset($params['consume_status'])) {
            $query->where('consume_status', '=', $params['consume_status']);
        }

        // 延迟时间 (秒)
        if (isset($params['delay_time'])) {
            $query->where('delay_time', '=', $params['delay_time']);
        }

        return $query;
    }
}