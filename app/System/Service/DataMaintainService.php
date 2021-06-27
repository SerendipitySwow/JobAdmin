<?php


namespace App\System\Service;


use Hyperf\Database\Model\Collection;
use Hyperf\Database\Schema\Schema;
use Hyperf\DbConnection\Db;
use Hyperf\Paginator\Paginator;
use phpDocumentor\Reflection\Types\Boolean;

class DataMaintainService
{
    /**
     * 获取表状态分页列表
     * @param array|null $params
     * @return array
     */
    public function getPageList(?array $params = []): array
    {
        $collect = new Collection(
            Db::select(Db::raw("SHOW TABLE STATUS WHERE name <> 'migrations'")->getValue())
        );

        if ($params['name'] ?? false) {
            $collect = $collect->filter(function ($row) use ($params) {
                return \Mine\Helper\Str::contains($row->Name, $params['name']);
            });
        }
        if ($params['engine'] ?? false) {
            $collect = $collect->where('Engine', $params['engine']);
        }

        $data = $collect->forPage($params['page'] ?? 1, $params['pageSize'] ?? 10)->toArray();
        $tables = [];
        foreach ($data as $item) {
            $tables[] = array_change_key_case((array)$item);
        }
        return [
            'items' => $tables,
            'pageInfo' => [
                'total' => $collect->count(),
                'currentPage' => $params['page'] ?? 1,
                'totalPage' => ceil($collect->count() / ($params['pageSize'] ?? 10))
            ]
        ];
    }

    /**
     * 获取表字段
     * @param string $table
     * @return array
     */
    public function getColumnList(string $table): array
    {
        if ($table) {
            return Schema::getColumnTypeListing($table);
        } else {
            return [];
        }
    }

    /**
     * 优化表
     * @param array $tables
     * @return bool
     */
    public function optimize(array $tables): bool
    {
        foreach ($tables as $table) {
            Db::select('optimize table `?`', [$table]);
        }
        return true;
    }

    /**
     * 清理表碎片
     * @param array $tables
     * @return bool
     */
    public function fragment(array $tables): bool
    {
        foreach ($tables as $table) {
            Db::select('analyze table `?`', [$table]);
        }
        return true;
    }


}