<?php


namespace App\System\Service;


use Hyperf\Database\Model\Collection;
use Hyperf\DbConnection\Db;

class DataMaintainService
{
    public function getPageList(): array
    {
        $collect = new Collection(
            Db::select(Db::raw("SHOW TABLE STATUS WHERE name <> 'migrations'")->getValue())
        );
        return $collect->where('Name', 'system_user')->toArray();
    }
}