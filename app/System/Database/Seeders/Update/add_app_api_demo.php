<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class addAppApiDemo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $prefix = env('DB_PREFIX');
        $apiTable =  $prefix . \App\System\Model\SystemApi::getModel()->getTable();
        $appTable =  $prefix . \App\System\Model\SystemApp::getModel()->getTable();
        $apiGroupTable =  $prefix . \App\System\Model\SystemApiGroup::getModel()->getTable();
        $appGroupTable =  $prefix . \App\System\Model\SystemAppGroup::getModel()->getTable();

        $appApiTable = $prefix . 'system_app_api';

        $apiGroup = "INSERT INTO `{$apiGroupTable}`(`id`, `name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (1, '演示接口分组', '0', NULL, NULL, '2021-11-27 12:40:46', '2021-12-06 21:32:19', NULL, '')";
        $appGroup = "INSERT INTO `{$appGroupTable}`(`id`, `name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (1, '演示应用分组', '0', NULL, NULL, '2021-11-27 12:40:16', '2021-12-06 21:29:39', NULL, '')";
        $api = [
            "INSERT INTO `{$apiTable}`(`id`, `group_id`, `name`, `access_name`, `class_name`, `method_name`, `auth_mode`, `request_mode`, `description`, `response`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (1, 1, '获取用户演示列表', 'user', 'Api\\InterfaceApi\\v1\\DemoApi', 'getUserList', '1', 'P', '<p>介绍说明。。。。。。。。。。。</p>', '{\n  code: 200,\n  success: true,\n  message: \'请求成功\',\n  data: []\n}', '0', NULL, NULL, '2021-11-27 12:41:22', '2021-12-06 22:28:56', NULL, '')",
            "INSERT INTO `{$apiTable}`(`id`, `group_id`, `name`, `access_name`, `class_name`, `method_name`, `auth_mode`, `request_mode`, `description`, `response`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (2, 1, '获取部门演示接口', 'dept', 'Api\\InterfaceApi\\v1\\DemoApi', 'getDeptList', '0', 'G', '', '{\n  code: 200,\n  success: true,\n  message: \'请求成功\',\n  data: []\n}', '0', NULL, NULL, '2021-11-28 12:16:43', '2021-12-06 21:31:10', NULL, '')"
        ];
        $app = "INSERT INTO `{$appTable}`(`id`, `group_id`, `app_name`, `app_id`, `app_secret`, `status`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (1, 1, '演示应用', 'af2870e854', 'MmY5YzkwYTU5YjM0Y2IyODllM2U3NzhmYWNhYzViOTI4ZGY3ZjE5MjFjN2M3M2YzY2I1N2IwYTEyYTI1YTM0Yw==', '0', '', NULL, NULL, '2021-11-27 12:40:26', '2021-12-06 21:30:02', NULL, '')";

        $appApi = [
            "INSERT INTO `{$appApiTable}`(`app_id`, `api_id`) VALUES (1, 1)",
            "INSERT INTO `{$appApiTable}`(`app_id`, `api_id`) VALUES (1, 2)"
        ];
        try {
            Db::beginTransaction();
            // API GROUP
            Db::insert($apiGroup);
            // API
            Db::insert($api[0]);
            Db::insert($api[1]);

            // APP
            Db::insert($app);
            // APp GROUP
            Db::insert($appGroup);

            // APP API
            Db::insert($appApi[0]);
            Db::insert($appApi[1]);

            Db::commit();
        } catch (\Exception $e) {
            Db::rollBack();
        }
    }
}
