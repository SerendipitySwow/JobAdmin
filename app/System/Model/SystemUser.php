<?php

declare (strict_types=1);
namespace App\System\Model;

use Hyperf\Database\Model\SoftDeletes;
use Mine\MineModel;
/**
 * @property int $id 用户ID，主键
 * @property string $username 用户名
 * @property string $user_type 用户类型：(100系统用户)
 * @property string $email 用户邮箱
 * @property string $avatar 用户头像
 * @property int $dept_id 部门ID
 * @property string $remember_token 用户Token
 * @property string $status 状态 (0正常 1停用)
 * @property string $login_ip 最后登陆IP
 * @property string $login_time 最后登陆时间
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property string $remark 备注
 * @property-write mixed $password 密码
 */
class SystemUser extends MineModel
{
    use SoftDeletes;
    public const USER_NORMAL = 0;
    public const USER_BAN = 1;
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['dept_id', 'username', 'user_type', 'email', 'status', 'remember_token', 'login_ip', 'login_time', 'password', 'avatar'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'dept_id' => 'integer', 'created_by' => 'integer', 'updated_by' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 通过中间表关联角色
     * @return \Hyperf\Database\Model\Relations\BelongsToMany
     */
    public function roles(): \Hyperf\Database\Model\Relations\BelongsToMany
    {
        return $this->belongsToMany(SystemRole::class, 'system_user_role', 'user_id', 'role_id');
    }

    /**
     * @param $value
     * @return false|string|null
     */
    public function setPasswordAttribute($value)
    {
        return $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
    }
    /**
     * @param $password
     * @param $hash
     * @return bool
     */
    public static function passwordVerify($password, $hash) : bool
    {
        return password_verify($password, $hash);
    }
}