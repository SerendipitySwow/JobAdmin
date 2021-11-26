<?php

declare (strict_types=1);
namespace App\System\Model;

use Mine\MineModel;
/**
 * @property int $id 主键
 * @property int $app_id app ID
 * @property string $app_name 应用名称
 * @property int $api_id api ID
 * @property string $api_name 接口名称
 * @property string $access_name 接口访问名称
 * @property string $request_data 请求数据
 * @property string $response_code 响应状态码
 * @property string $response_data 响应数据
 * @property string $ip 访问IP地址
 * @property string $ip_location IP所属地
 * @property string $access_time 访问时间
 * @property string $remark 备注
 */
class SystemApiLog extends MineModel
{
    public $incrementing = false;
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_api_log';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'app_id', 'app_name', 'api_id', 'api_name', 'access_name', 'request_data', 'response_code', 'response_data', 'ip', 'ip_location', 'access_time', 'remark'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'app_id' => 'integer', 'api_id' => 'integer'];
}