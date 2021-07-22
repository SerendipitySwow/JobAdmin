<?php

declare (strict_types=1);
namespace App\Setting\Model;

use Hyperf\Database\Model\SoftDeletes;
use Mine\MineModel;
/**
 * @property int $id 主键
 * @property string $name 任务名称
 * @property string $type 任务类型 (1 command, 2 class, 3 url
 * @property string $target 调用任务字符串
 * @property string $rule 任务执行表达式
 * @property string $fail_policy 失败策略 (1 执行 ，2 尝试执行一次，3 放弃执行)
 * @property string $status 状态 (0正常 1停用)
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property string $remark 备注
 */
class SettingCrontab extends MineModel
{
    use SoftDeletes;
    public $incrementing = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'setting_crontab';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'type', 'target', 'rule', 'fail_policy', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at', 'remark'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'created_by' => 'integer', 'updated_by' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}