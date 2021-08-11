<?php

declare (strict_types=1);
namespace App\Setting\Model;

use Mine\MineModel;
/**
 * @property int $id 主键
 * @property string $table_name 表名称
 * @property string $table_comment 表注释
 * @property string $module_name 所属模块
 * @property string $namespace 命名空间
 * @property string $menu_name 生成菜单名
 * @property int $belong_menu_id 所属菜单
 * @property string $package_name 控制器包名
 * @property string $type 生成类型，single 单表CRUD，tree 树表CRUD，parent_sub父子表CRUD
 * @property string $generate_type 0 压缩包下载 1 生成到模块
 * @property string $options 其他业务选项
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 更新时间
 * @property string $remark 备注
 */
class SettingGenerateTables extends MineModel
{
    public $incrementing = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'setting_generate_tables';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'table_name', 'table_comment', 'module_name', 'namespace', 'menu_name', 'belong_menu_id', 'package_name', 'type', 'generate_type', 'options', 'created_by', 'updated_by', 'created_at', 'updated_at', 'remark'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'belong_menu_id' => 'integer', 'created_by' => 'integer', 'updated_by' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 获取options参数
     *
     * @param string|null $value
     * @return array|null
     */
    public function getOptionsAttribute(?string $value): array
    {
        return is_null($value) ? [] : unserialize($value);
    }

    /**
     * 设置options参数
     *
     * @param string|null $value
     * @return string
     */
    public function setOptionsAttribute(?string $value): ?string
    {
        return empty($value) ? null : serialize($value);
    }

    /**
     * 关联生成业务字段信息表
     * @return \Hyperf\Database\Model\Relations\HasMany
     */
    public function columns(): \Hyperf\Database\Model\Relations\HasMany
    {
        return $this->hasMany(SettingGenerateColumns::class, 'table_id', 'id');
    }
}