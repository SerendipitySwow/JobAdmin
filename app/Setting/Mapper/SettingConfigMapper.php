<?php

declare(strict_types=1);
namespace App\Setting\Mapper;

use App\Setting\Model\SettingConfig;
use Mine\Abstracts\AbstractMapper;

class SettingConfigMapper extends AbstractMapper
{
    /**
     * @var SettingConfig
     */
    public $model;

    public function assignModel()
    {
        $this->model = SettingConfig::class;
    }

    /**
     * 按组获取配置
     * @param string $groupName
     * @return array
     */
    public function getConfigByGroup(string $groupName): array
    {
        return $this->model::query()->where('group_name', $groupName)->get([
            'id', 'group_name', 'name', 'key', 'value', 'remark'
        ])->toArray();
    }

    /**
     * 按Key获取配置
     * @param string $key
     * @return array
     */
    public function getConfigByKey(string $key): array
    {
        return $this->model::query()->where('key', $key)->get([
            'id', 'group_name', 'name', 'key', 'value', 'remark'
        ])->toArray();
    }

}