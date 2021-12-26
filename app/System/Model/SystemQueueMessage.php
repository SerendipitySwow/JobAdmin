<?php

declare (strict_types=1);
namespace App\System\Model;

use Hyperf\Database\Model\SoftDeletes;
use Mine\MineModel;
/**
 * @property int $id 主键
 * @property string $title 消息标题
 * @property string $content_type 内容类型
 * @property string $content 消息内容
 * @property int $send_by 发送人
 * @property string $send_status 发送状态 0:待发送 1:发送中 2:发送成功 3:发送失败
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 更新时间
 * @property string $remark 备注
 */
class SystemQueueMessage extends MineModel
{
    public $incrementing = false;

    /**
     * 待发送
     */
    const STATUS_SEND_WAIT = '0';

    /**
     * 发送中
     */
    const STATUS_SENDING = '1';

    /**
     * 发送成功
     */
    const STATUS_SEND_SUCCESS = '2';

    /**
     * 发送失败
     */
    const STATUS_SEND_FAIL = '3';

    /**
     * 消息类型：通知
     * @var string
     */
    const TYPE_NOTICE = 'notice';

    /**
     * 消息类型：公告
     * @var string
     */
    const TYPE_ANNOUNCE = 'announcement';

    /**
     * 消息类型：待办
     * @var string
     */
    const TYPE_TODO = 'todo';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_queue_message';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'content_type', 'title', 'content', 'send_by', 'send_status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'remark'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'content_id' => 'integer', 'send_by' => 'integer', 'created_by' => 'integer', 'updated_by' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 关联发送人
     * @return \Hyperf\Database\Model\Relations\HasOne
     */
    public function sendUser() : \Hyperf\Database\Model\Relations\HasOne
    {
        return $this->hasOne(SystemUser::class, 'id', 'send_by');
    }

    /**
     * 关联接收人中间表
     * @return \Hyperf\Database\Model\Relations\BelongsToMany
     */
    public function receiveUser() : \Hyperf\Database\Model\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            SystemUser::class,
            'queue_message_receive',
            'message_id',
            'user_id'
        )->as('receive_users')->withPivot(...['read_status']);
    }
}
