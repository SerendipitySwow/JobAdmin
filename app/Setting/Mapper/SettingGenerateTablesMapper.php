<?php

declare(strict_types=1);
namespace App\Setting\Mapper;

use App\Setting\Model\SettingGenerateTables;
use Mine\Abstracts\AbstractMapper;

/**
 * 生成业务信息表查询类
 * Class SettingGenerateTablesMapper
 * @package App\Setting\Mapper
 */
class SettingGenerateTablesMapper extends AbstractMapper
{
    /**
     * @var SettingGenerateTables
     */
    public $model;

    public function assignModel()
    {
        $this->model = SettingGenerateTables::class;
    }
}