<?php

declare(strict_types = 1);
namespace App\Task\Mapper;

use App\Task\Model\MissionTask;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 任务列表Mapper类
 */
class MissionTaskMapper extends AbstractMapper
{
    /**
     * @var MissionTask
     */
    public $model;

    public function assignModel()
    {
        $this->model = MissionTask::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        
        // 任务状态 0:待处理 1:处理中 2:已处理 3:已取消 4:处理失败
        if (isset($params['status']) && $params['status'] !== '') {
            $query->where('status', '=', $params['status']);
        }

        // 重试间隔(秒)
        if (isset($params['step']) && $params['step'] !== '') {
            $query->where('step', '=', $params['step']);
        }

        // 执行时间
        if (isset($params['runtime']) && $params['runtime'] !== '') {
            $query->where('runtime', '=', $params['runtime']);
        }

        // 任务内容
        if (isset($params['content']) && $params['content'] !== '') {
            $query->where('content', '=', $params['content']);
        }

        // 任务执行时间
        if (isset($params['timeout']) && $params['timeout'] !== '') {
            $query->where('timeout', '=', $params['timeout']);
        }

        // 任务名称
        if (isset($params['name']) && $params['name'] !== '') {
            $query->where('name', '=', $params['name']);
        }

        // 执行当前的任务协程ID,用于取消当前任务
        if (isset($params['coroutine_id']) && $params['coroutine_id'] !== '') {
            $query->where('coroutine_id', '=', $params['coroutine_id']);
        }

        // 当任务执行出现错误时,记录错误信息
        if (isset($params['memo']) && $params['memo'] !== '') {
            $query->where('memo', '=', $params['memo']);
        }

        // 执行任务完成的结果
        if (isset($params['result']) && $params['result'] !== '') {
            $query->where('result', '=', $params['result']);
        }

        // 重试次数
        if (isset($params['retry_times']) && $params['retry_times'] !== '') {
            $query->where('retry_times', '=', $params['retry_times']);
        }

        // consul运行服务的ID
        if (isset($params['consul_service_id']) && $params['consul_service_id'] !== '') {
            $query->where('consul_service_id', '=', $params['consul_service_id']);
        }

        return $query;
    }
}