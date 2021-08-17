<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class SettingCrontab extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('setting_crontab')->truncate();
        foreach ($this->getData() as $item) {
            Db::insert($item);
        }
    }

    public function getData(): array
    {
        $tableName = \App\Setting\Model\SettingCrontab::getModel()->getTable();
        return [
            "INSERT INTO `{$tableName}` VALUES (3890924964000, 'urlCrontab', '3', 'http://127.0.0.1:9501/', '', '59 */1 * * * *', '1', '1', NULL, NULL, '2021-08-07 23:28:28', '2021-08-07 23:44:55', '请求127.0.0.1')"
        ];
    }
}
