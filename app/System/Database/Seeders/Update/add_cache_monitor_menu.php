<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;
use Mine\Helper\Id;

class AddCacheMonitorMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $table = env('DB_PREFIX') . \App\System\Model\SystemMenu::getModel()->getTable();
        $menu = "INSERT INTO `{$table}` VALUES (3700, 3000, '0,3000', '缓存监控', 'system:onlineUser', 'el-icon-paperclip', 'onlineUser', 'system/monitor/onlineUser/index', NULL, '1', 'M', '0', 98, NULL, NULL, '2021-08-08 18:26:31', '2021-08-08 18:26:31', NULL, NULL)";
        try {
            Db::beginTransaction();
            Db::insert($menu);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollBack();
        }
    }
}
