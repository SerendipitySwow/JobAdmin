<?php

declare(strict_types=1);
namespace App\Setting\Mapper;

use App\Setting\Model\SettingGenerateColumns;
use Mine\Abstracts\AbstractMapper;

/**
 * 生成业务字段信息表查询类
 * Class SettingGenerateColumnsMapper
 * @package App\Setting\Mapper
 */
class SettingGenerateColumnsMapper extends AbstractMapper
{
    public $model;

    public function assignModel()
    {
        $this->model = SettingGenerateColumns::class;
    }
}