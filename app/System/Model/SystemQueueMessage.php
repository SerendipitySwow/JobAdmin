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
     * 消息类型：抄送我的
     * @var string
     */
    const TYPE_COPY_MINE = 'carbon_copy_mine';

    /**
     * 消息类型：私信
     * @var string
     */
    const TYPE_PRIVATE_MESSAGE = 'private_message';

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
    protected $fillable = ['id', 'content_type', 'title', 'content', 'send_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'remark'];
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
            'system_queue_message_receive',
            'message_id',
            'user_id'
        )->as('receive_users')->withPivot(...['read_status']);
    }
}
