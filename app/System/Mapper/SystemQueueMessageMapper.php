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
        if (isset($params['title'])) {
            $query->where('title', 'like', '%'.$params['content_type'].'%');
        }

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
        }

        return $query;
    }

    /**
     * 获取接收人列表
     * @param int $id
     * @return array
     */
    public function getReceiveUserList(int $id): array
    {
        $model = $this->read($id);
        $queueMessage = $model->toArray();
        $queueMessage['receive_users'] = $model->receiveUser;
        return $queueMessage;
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

    /**
     * 删除消息
     * @param array $ids
     * @return bool
     * @throws \Exception
     * @Transaction
     */
    public function delete(array $ids): bool
    {
        foreach ($ids as $id) {
            $model = $this->model::find($id);
            if ($model) {
                $model->receiveUser()->detach();
                $model->delete();
            }
        }
        return true;
    }

    /**
     * 更新中间表数据状态
     * @param array $ids
     * @param string $columnName
     * @param string $value
     * @return bool
     * @Transaction
     */
    public function updateDataStatus(array $ids, string $columnName = 'read_status', string $value = '1'): bool
    {
        foreach ($ids as $id) {
            $result = Db::table('system_queue_message_receive')
                ->where('message_id', $id)
                ->where('user_id', user()->getId())
                ->value($columnName);

            if ($result != $value) {
                Db::table('system_queue_message_receive')
                    ->where('message_id', $id)
                    ->where('user_id', user()->getId())
                    ->update([ $columnName => $value ]);
            }
        }

        return true;
    }
}
