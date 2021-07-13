<?php

declare(strict_types=1);
namespace App\Setting\Service;

use App\Setting\Mapper\SettingGenerateColumnsMapper;
use Mine\Abstracts\AbstractService;

/**
 * 业务生成字段信息表业务处理类
 * Class SettingGenerateColumnsService
 * @package App\Setting\Service
 */
class SettingGenerateColumnsService extends AbstractService
{
    /**
     * @var SettingGenerateColumnsMapper
     */
    public $mapper;

    /**
     * SettingGenerateColumnsService constructor.
     * @param SettingGenerateColumnsMapper $mapper
     */
    public function __construct(SettingGenerateColumnsMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 循环插入数据
     * @param array $data
     * @return int
     */
    public function save(array $data): int
    {
        // 组装数据
        foreach ($data as $k => $item) {
            $column = [
                'table_id' => $item['table_id'],
                'column_name' => $item['column_name'],
                'column_comment' => $item['column_comment'],
                'column_type' => $item['data_type'],
                'is_pk' => empty($item['column_key']) ? '0' : '1' ,
                'query_type' => 'eq',
                'view_type' => 'text',
                'sort' => count($data) - $k,
            ];
            $this->mapper->save($column);
        }
        return 1;
    }
}