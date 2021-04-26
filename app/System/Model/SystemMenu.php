<?php

declare (strict_types=1);
namespace App\System\Model;

use Hyperf\Database\Model\SoftDeletes;
use Mine\MineModel;
/**
 * @property int $id 主键
 * @property int $parent_id 父ID
 * @property string $level 组级集合
 * @property string $name 菜单名称
 * @property string $code 菜单标识代码
 * @property string $icon 菜单名称
 * @property string $route 路由地址
 * @property string $component 组件路径
 * @property string $is_out 是否外链, (0是 1否)
 * @property string $is_cache 是否缓存, (0是 1否)
 * @property string $is_quick 是否快捷菜单, (0是 1否)
 * @property string $is_hidden 是否隐藏 (0是 1否)
 * @property string $type 菜单类型, (T分类 C目录 M菜单 B按钮)
 * @property string $status 状态 (0正常 1停用)
 * @property int $sort 排序
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property string $remark 备注
 */
class SystemMenu extends MineModel
{
    use SoftDeletes;
    public $incrementing = false;
    /**
     * 状态
     */
    public const ENABLE = 0;
    public const DISABLE = 1;
    /**
     * 类型
     */
    public const TYPE_CLASSIFY = 'T';
    public const CATALOG = 'C';
    public const MENUS_LIST = 'M';
    public const BUTTON = 'B';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_menu';
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
    protected $casts = ['id' => 'integer', 'parent_id' => 'integer', 'sort' => 'integer', 'created_by' => 'integer', 'updated_by' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}