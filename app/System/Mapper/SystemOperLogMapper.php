<?php


namespace App\System\Mapper;


use App\System\Model\SystemOperLog;
use Mine\Abstracts\AbstractMapper;

class SystemOperLogMapper extends AbstractMapper
{
    /**
     * @var SystemOperLog
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemOperLog::class;
    }
}