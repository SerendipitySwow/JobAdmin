<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class AddDictDataApiData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $tableName = env('DB_PREFIX') . \App\System\Model\SystemDictData::getModel()->getTable();

        $sql = [
            "INSERT INTO `{$tableName}`(`id`, `type_id`, `label`, `value`, `code`, `sort`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (8619601224864, 8619580222112, '字符串', 'string', 'api_data_type', 10, '0', NULL, NULL, '2021-11-22 20:56:44', '2021-11-22 20:56:44', NULL, NULL)",
            "INSERT INTO `{$tableName}`(`id`, `type_id`, `label`, `value`, `code`, `sort`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (8620723800224, 8619580222112, '整型', 'integer', 'api_data_type', 0, '0', NULL, NULL, '2021-11-22 21:33:17', '2021-11-22 21:33:29', NULL, NULL)",
            "INSERT INTO `{$tableName}`(`id`, `type_id`, `label`, `value`, `code`, `sort`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (8620738421408, 8619580222112, '浮点型', 'float', 'api_data_type', 0, '0', NULL, NULL, '2021-11-22 21:33:45', '2021-11-22 21:33:45', NULL, NULL)",
            "",
            "",
            "",
        ];
        try {
            Db::beginTransaction();
            foreach ($sql as $str) {
                Db::insert($str);
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollBack();
        }
    }
}
