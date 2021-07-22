<?php


namespace App\Setting\Mapper;


use App\Setting\Model\SettingCrontabLog;
use Mine\Abstracts\AbstractMapper;

class SettingCrontabLogMapper extends AbstractMapper
{
    /**
     * @var SettingCrontabLog
     */
    public $model;

    public function assignModel()
    {
        $this->model = SettingCrontabLog::class;
    }

}