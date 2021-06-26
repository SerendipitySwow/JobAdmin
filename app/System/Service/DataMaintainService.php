<?php


namespace App\System\Service;


use Hyperf\Database\Model\Collection;
use Hyperf\DbConnection\Db;
use Hyperf\Paginator\Paginator;

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
            $collect = $collect->filter( function($row) use($params) {
                return \Mine\Helper\Str::contains($row->Name, $params['name']);
            });
        }
        if ($params['engine'] ?? false) {
            $collect = $collect->where('Engine', $params['engine']);
        }

        $data = $collect->forPage($params['page'] ?? 1, $params['pageSize'] ?? 10)->toArray();
        $tables = [];
        foreach ($data as $item) {
            $tables[] = array_change_key_case( (array) $item );
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
}