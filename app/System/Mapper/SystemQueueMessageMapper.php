<?php

declare(strict_types = 1);
namespace App\System\Mapper;

use App\System\Model\SystemQueueMessage;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;
use Mine\Annotation\Transaction;

/**
 * 信息管理Mapper类
 */
class SystemQueueMessageMapper extends AbstractMapper
{
    /**
     * @var SystemQueueMessage
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemQueueMessage::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        // 内容ID
        if (isset($params['content_id'])) {
            $query->where('content_id', '=', $params['content_id']);
        }

        // 内容类型
        if (isset($params['content_type'])) {
            $query->where('content_type', '=', $params['content_type']);
        }

        // 接收人ID
        if (isset($params['receive_by'])) {
            $query->where('receive_by', '=', $params['receive_by']);
        }

        if (isset($params['send_by'])) {
            $query->where('send_by', '=', $params['send_by']);
        }

        // 发送状态 0:待发送 1:发送中 2:发送成功 3:发送失败
        if (isset($params['send_status'])) {
            $query->where('send_status', '=', $params['send_status']);
        }

        if (isset($params['read_status'])) {
            $query->where('read_status', '=', $params['read_status']);
        }

        $query->with(['sendUser' => function($query) {
            $query->select([ 'id', 'nickname' ]);
        }]);

        return $query;
    }

    /**
     * 保存数据
     * @Transaction
     * @param array $data
     * @return int
     */
    public function save(array $data): int
    {
        $receiveUsers = $data['receive_users'];
        $this->filterExecuteAttributes($data);
        $model = $this->model::create($data);
        $model->receiveUser()->sync($receiveUsers);
        return $model->{$model->getKeyName()};
    }
}
