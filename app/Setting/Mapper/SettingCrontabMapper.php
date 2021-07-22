<?php

declare(strict_types=1);
namespace App\Setting\Mapper;

use App\Setting\Model\SettingCrontab;
use Mine\Abstracts\AbstractMapper;

class SettingCrontabMapper extends AbstractMapper
{
    /**
     * @var SettingCrontab
     */
    public $model;

    public function assignModel()
    {
        $this->model = SettingCrontab::class;
    }
}