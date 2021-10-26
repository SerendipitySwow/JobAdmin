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
        $menus[] = "INSERT INTO `{$table}` VALUES (3700, 3000, '0,3000', '缓存监控', 'system:cache', 'el-icon-odometer', 'cache', 'system/monitor/cache/index', NULL, '1', 'M', '0', 98, NULL, NULL, '2021-10-26 20:50:31', '2021-10-26 20:50:31', NULL, NULL)";
        $menus[] = "INSERT INTO `{$table}` VALUES (3701, 3700, '0,3000,3700', '获取Redis信息', 'system:cache:monitor', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-10-26 20:50:31', '2021-10-26 20:50:31', NULL, NULL)";
        try {
            Db::beginTransaction();
            list($menu, $button) = $menus;
            Db::insert($menu);
            Db::insert($button);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollBack();
        }
    }
}
