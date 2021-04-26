<?php

declare (strict_types=1);
namespace App\System\Model;

use Hyperf\Database\Model\SoftDeletes;
use Mine\MineModel;
/**
 * @property int $id 主键，角色ID
 * @property string $name 角色名称
 * @property string $code 角色代码
 * @property string $data_scope 数据范围（0：全部数据权限 1：自定数据权限 2：本部门数据权限 3：本部门及以下数据权限）
 * @property string $status 状态 (0正常 1停用)
 * @property int $sort 排序
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property string $remark 备注
 */
class SystemRole extends MineModel
{
    use SoftDeletes;
    public $incrementing = false;
    public const ALL_SCOPE = 0;
    // 所有
    public const CUSTOM_SCOPE = 1;
    // 自定义
    public const SELF_DEPT_SCOPE = 2;
    // 本部门
    public const DEPT_BELOW_SCOPE = 3;
    // 本部门及子部门
    public const SELF_SCOPE = 4;
    // 本人
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_role';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'sort' => 'integer', 'created_by' => 'integer', 'updated_by' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
    /**
     * 通过中间表获取用户菜单
     */
    public function menus() : \Hyperf\Database\Model\Relations\BelongsToMany
    {
        return $this->belongsToMany(SystemMenu::class, 'system_role_menu', 'role_id', 'menu_id');
    }
}