<?php

declare (strict_types=1);
namespace App\Task\Model;

use Mine\MineModel;

class MissionTask extends MineModel
{
    public $incrementing = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'is_deleted', 'status', 'app_key', 'task_no', 'step', 'runtime', 'content', 'created_at', 'updated_at', 'timeout', 'name', 'coroutine_id', 'memo', 'result', 'retry_times', 'consul_service_id'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    protected $connection = 'job';
}
