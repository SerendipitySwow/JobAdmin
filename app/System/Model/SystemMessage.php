<?php

declare (strict_types = 1);

namespace App\System\Model;

use Hyperf\Database\Model\SoftDeletes;
use Mine\MineModel;

/**
 * @property int $id 主键
 * @property int $content_id 内容ID
 * @property string $content_type 内容类型
 * @property string $content 发送内容
 * @property int $receive_by 接收人ID
 * @property int $created_by 发送人ID
 * @property string $status 发送状态 0:待发送 1:发送中 2:发送成功 3:发送失败
 * @property int $updated_by 更新者
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property string $remark 备注
 */
class SystemMessage extends MineModel
{
    use SoftDeletes;
    public $incrementing = false;
    const STATUS_SEND_WAIT = 0; //待发送
    const STATUS_SENDING = 1; //发送中
    const STATUS_SEND_SUCCESS = 2; //发送成功
    const STATUS_SEND_FAIL = 3; //发送失败
    
    const READ_STATUS_NO = 0; //未读
    const READ_STATUS_YES = 1; //已读
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_message';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','content_id','content_type','content','receive_by','created_by','send_status','read_status','updated_by','created_at','updated_at','deleted_at','remark'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer','content_id' => 'integer','receive_by' => 'integer','created_by' => 'integer','updated_by' => 'integer','created_at' => 'datetime','updated_at' => 'datetime'];
}
