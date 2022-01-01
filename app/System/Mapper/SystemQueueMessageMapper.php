<?php

declare(strict_types = 1);
namespace App\System\Mapper;

use App\System\Model\SystemQueueMessage;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;
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
        // 内容类型
        if (isset($params['content_type'])) {
            $query->where('content_type', '=', $params['content_type']);
        }

        // 获取收信数据
        if (isset($params['getReceive'])) {
            $query->with(['sendUser' => function($query) {
                $query->select([ 'id', 'username', 'nickname' ]);
            }]);
            $prefix = env('DB_PREFIX');
            $readStatus = $params['read_status'] ?? 'all';
            $sql = <<<sql
                id IN ( 
                    SELECT `message_id` FROM `{$prefix}system_queue_message_receive` WHERE `user_id` = ?
                    AND if (? <> 'all', `read_status` = ?, ' 1 = 1 ')
                )
            sql;
            $query->whereRaw($sql, [ user()->getId(), $readStatus, $readStatus ]);
        }

        // 收取发信数据
        if (isset($params['getSend'])) {
            $query->where('send_by', user()->getId());

            $query->with(['receiveUser' => function($query) {
                $query->select('*');
            }]);
        }

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
