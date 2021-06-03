<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;
use Mine\Helper\Id;

class SystemDeptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = (new Id())->getId();
        Db::table('system_dept')->insert(
            [
                'id' => $id,
                'parent_id' => 0,
                'level' => '0',
                'name' => '曼艺科技',
                'leader' => '曼艺',
                'phone' => '1688888888'
            ]
        );
        Db::table('system_user')
            ->where('id', env('SUPER_ADMIN', 1))
            ->update(['dept_id' => $id]);
    }
}
