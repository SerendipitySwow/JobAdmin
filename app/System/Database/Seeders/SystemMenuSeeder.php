<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use App\System\Service\SystemMenuService;

class SystemMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $service = make(SystemMenuService::Class);
    }

    protected function getData()
    {

    }
}
