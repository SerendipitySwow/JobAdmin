<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class SystemMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('system_menu')->truncate();
        foreach ($this->getData() as $item) {
            Db::insert($item);
        }
    }

    protected function getData(): array
    {
        $model = \App\System\Model\SystemMenu::getModel()->getTable();
        return [
            "INSERT INTO `{$model}` VALUES (1000, 0, '0', '权限管理', 'permission', 'sc-icon-shield-flash-line', 'permission', '', NULL, '1', 'M', '0', 99, NULL, NULL, '2021-07-25 18:48:47', '2021-07-25 18:48:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1100, 1000, '0,1000', '用户管理', 'system:user', 'sc-icon-user-settings-line', 'user', 'system/user/index', NULL, '1', 'M', '0', 99, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1101, 1100, '0,1000,1100', '用户列表', 'system:user:index', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1102, 1100, '0,1000,1100', '用户回收站列表', 'system:user:recycle', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1103, 1100, '0,1000,1100', '用户保存', 'system:user:save', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1104, 1100, '0,1000,1100', '用户更新', 'system:user:update', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1105, 1100, '0,1000,1100', '用户删除', 'system:user:delete', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1106, 1100, '0,1000,1100', '用户读取', 'system:user:read', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1107, 1100, '0,1000,1100', '用户恢复', 'system:user:recovery', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1108, 1100, '0,1000,1100', '用户真实删除', 'system:user:realDelete', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1109, 1100, '0,1000,1100', '用户导入', 'system:user:import', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1110, 1100, '0,1000,1100', '用户导出', 'system:user:export', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1111, 1100, '0,1000,1100', '用户状态改变', 'system:user:changeStatus', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 18:53:02', '2021-07-25 18:53:02', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1112, 1100, '0,1000,1100', '用户初始化密码', 'system:user:initUserPassword', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 18:55:55', '2021-07-25 18:55:55', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1113, 1100, '0,1000,1100', '更新用户缓存', 'system:user:cache', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-08 18:30:57', '2021-08-08 18:30:57', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1114, 1100, '0,1000,1100', '设置用户首页', 'system:user:homePage', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-08 18:34:30', '2021-08-08 18:34:30', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1200, 1000, '0,1000', '菜单管理', 'system:menu', 'sc-icon-apps-line', 'menu', 'system/menu/index', NULL, '1', 'M', '0', 96, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1201, 1200, '0,1000,1200', '菜单列表', 'system:menu:index', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1202, 1200, '0,1000,1200', '菜单回收站', 'system:menu:recycle', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1203, 1200, '0,1000,1200', '菜单保存', 'system:menu:save', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1204, 1200, '0,1000,1200', '菜单更新', 'system:menu:update', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1205, 1200, '0,1000,1200', '菜单删除', 'system:menu:delete', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1206, 1200, '0,1000,1200', '菜单读取', 'system:menu:read', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1207, 1200, '0,1000,1200', '菜单恢复', 'system:menu:recovery', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1208, 1200, '0,1000,1200', '菜单真实删除', 'system:menu:realDelete', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1209, 1200, '0,1000,1200', '菜单导入', 'system:menu:import', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1210, 1200, '0,1000,1200', '菜单导出', 'system:menu:export', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1300, 1000, '0,1000', '部门管理', 'system:dept', 'el-icon-postcard', 'dept', 'system/dept/index', NULL, '1', 'M', '0', 97, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1301, 1300, '0,1000,1300', '部门列表', 'system:dept:index', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1302, 1300, '0,1000,1300', '部门回收站', 'system:dept:recycle', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1303, 1300, '0,1000,1300', '部门保存', 'system:dept:save', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1304, 1300, '0,1000,1300', '部门更新', 'system:dept:update', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1305, 1300, '0,1000,1300', '部门删除', 'system:dept:delete', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1306, 1300, '0,1000,1300', '部门读取', 'system:dept:read', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1307, 1300, '0,1000,1300', '部门恢复', 'system:dept:recovery', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1308, 1300, '0,1000,1300', '部门真实删除', 'system:dept:realDelete', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1309, 1300, '0,1000,1300', '部门导入', 'system:dept:import', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1310, 1300, '0,1000,1300', '部门导出', 'system:dept:export', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1400, 1000, '0,1000', '角色管理', 'system:role', 'sc-icon-user-star-line', 'role', 'system/role/index', NULL, '1', 'M', '0', 98, NULL, NULL, '2021-07-25 19:17:37', '2021-07-25 19:17:37', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1401, 1400, '0,1000,1400', '角色列表', 'system:role:index', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:17:37', '2021-07-25 19:17:37', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1402, 1400, '0,1000,1400', '角色回收站', 'system:role:recycle', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1403, 1400, '0,1000,1400', '角色保存', 'system:role:save', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1404, 1400, '0,1000,1400', '角色更新', 'system:role:update', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1405, 1400, '0,1000,1400', '角色删除', 'system:role:delete', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1406, 1400, '0,1000,1400', '角色读取', 'system:role:read', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1407, 1400, '0,1000,1400', '角色恢复', 'system:role:recovery', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1408, 1400, '0,1000,1400', '角色真实删除', 'system:role:realDelete', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1409, 1400, '0,1000,1400', '角色导入', 'system:role:import', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1410, 1400, '0,1000,1400', '角色导出', 'system:role:export', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1411, 1400, '0,1000,1400', '角色状态改变', 'system:role:changeStatus', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-30 11:21:24', '2021-07-30 11:21:24', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1412, 1400, '0,1000,1400', '更新菜单权限', 'system:role:menuPermission', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-09 11:52:33', '2021-08-09 11:52:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1413, 1400, '0,1000,1400', '更新数据权限', 'system:role:dataPermission', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-09 11:52:52', '2021-08-09 11:52:52', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1500, 1000, '0,1000', '岗位管理', 'system:post', 'el-icon-data-board', 'post', 'system/post/index', NULL, '1', 'M', '0', 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1501, 1500, '0,1000,1500', '岗位列表', 'system:post:index', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1502, 1500, '0,1000,1500', '岗位回收站', 'system:post:recycle', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1503, 1500, '0,1000,1500', '岗位保存', 'system:post:save', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1504, 1500, '0,1000,1500', '岗位更新', 'system:post:update', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1505, 1500, '0,1000,1500', '岗位删除', 'system:post:delete', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1506, 1500, '0,1000,1500', '岗位读取', 'system:post:read', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1507, 1500, '0,1000,1500', '岗位恢复', 'system:post:recovery', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1508, 1500, '0,1000,1500', '岗位真实删除', 'system:post:realDelete', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1509, 1500, '0,1000,1500', '岗位导入', 'system:post:import', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1510, 1500, '0,1000,1500', '岗位导出', 'system:post:export', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2000, 0, '0', '数据中心', 'dataCenter', 'sc-icon-database-2-line', 'dataCenter', '', NULL, '1', 'M', '0', 98, NULL, NULL, '2021-07-31 17:17:03', '2021-07-31 17:17:03', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2100, 2000, '0,2000', '数据字典', 'system:dataDict', 'el-icon-s-ticket', 'dataDict', 'system/dataDict/index', NULL, '1', 'M', '0', 99, NULL, NULL, '2021-07-31 17:23:58', '2021-07-31 17:23:58', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2101, 2100, '0,2000,2100', '数据字典列表', 'system:dataDict:index', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 17:23:58', '2021-07-31 17:23:58', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2102, 2100, '0,2000,2100', '数据字典回收站', 'system:dataDict:recycle', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 17:23:58', '2021-07-31 17:23:58', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2103, 2100, '0,2000,2100', '数据字典保存', 'system:dataDict:save', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 17:23:58', '2021-07-31 17:23:58', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2104, 2100, '0,2000,2100', '数据字典更新', 'system:dataDict:update', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 17:23:58', '2021-07-31 17:23:58', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2105, 2100, '0,2000,2100', '数据字典删除', 'system:dataDict:delete', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 17:23:58', '2021-07-31 17:23:58', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2106, 2100, '0,2000,2100', '数据字典读取', 'system:dataDict:read', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 17:23:58', '2021-07-31 17:23:58', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2107, 2100, '0,2000,2100', '数据字典恢复', 'system:dataDict:recovery', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 17:23:58', '2021-07-31 17:23:58', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2108, 2100, '0,2000,2100', '数据字典真实删除', 'system:dataDict:realDelete', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 17:23:58', '2021-07-31 17:23:58', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2109, 2100, '0,2000,2100', '数据字典导入', 'system:dataDict:import', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 17:23:58', '2021-07-31 17:23:58', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2110, 2100, '0,2000,2100', '数据字典导出', 'system:dataDict:export', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 17:23:58', '2021-07-31 17:23:58', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2111, 2100, '0,2000,2100', '清除字典缓存', 'system:dataDict:clearCache', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-10 13:14:32', '2021-08-10 13:14:32', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2200, 2000, '0,2000', '字典类型', 'system:dictType', '', 'dictType', '', NULL, '0', 'M', '0', 0, NULL, NULL, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2201, 2200, '0,2000,2200', '字典类型列表', 'system:dictType:index', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2202, 2200, '0,2000,2200', '字典类型回收站', 'system:dictType:recycle', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2203, 2200, '0,2000,2200', '字典类型保存', 'system:dictType:save', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2204, 2200, '0,2000,2200', '字典类型更新', 'system:dictType:update', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2205, 2200, '0,2000,2200', '字典类型删除', 'system:dictType:delete', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2206, 2200, '0,2000,2200', '字典类型读取', 'system:dictType:read', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:33:46', '2021-07-31 18:33:46', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2207, 2200, '0,2000,2200', '字典类型恢复', 'system:dictType:recovery', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:33:46', '2021-07-31 18:33:46', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2208, 2200, '0,2000,2200', '字典类型真实删除', 'system:dictType:realDelete', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:33:46', '2021-07-31 18:33:46', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2209, 2200, '0,2000,2200', '字典类型导入', 'system:dictType:import', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:33:46', '2021-07-31 18:33:46', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2210, 2200, '0,2000,2200', '字典类型导出', 'system:dictType:export', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:33:46', '2021-07-31 18:33:46', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2300, 2000, '0,2000', '附件管理', 'system:attachment', 'sc-icon-image-line', 'attachment', 'system/attachment/index', NULL, '1', 'M', '0', 98, NULL, NULL, '2021-07-31 18:36:34', '2021-07-31 18:36:34', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2301, 2300, '0,2000,2300', '附件删除', 'system:attachment:delete', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:37:20', '2021-07-31 18:37:20', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2302, 2300, '0,2000,2300', '附件列表', 'system:attachment:index', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:38:05', '2021-07-31 18:38:05', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2303, 2300, '0,2000,2300', '附件回收站', 'system:attachment:recycle', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:38:57', '2021-07-31 18:38:57', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2304, 2300, '0,2000,2300', '附件真实删除', 'system:attachment:realDelete', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:40:44', '2021-07-31 18:40:44', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2400, 2000, '0,2000', '数据表维护', 'system:dataMaintain', 'el-icon-receiving', 'dataMaintain', 'system/dataMaintain/index', NULL, '1', 'M', '0', 95, NULL, NULL, '2021-07-31 18:43:20', '2021-07-31 18:43:20', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2401, 2400, '0,2000,2400', '数据表列表', 'system:dataMaintain:index', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:44:03', '2021-07-31 18:44:03', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2402, 2400, '0,2000,2400', '数据表详细', 'system:dataMaintain:detailed', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:45:17', '2021-07-31 18:45:17', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2403, 2400, '0,2000,2400', '数据表清理碎片', 'system:dataMaintain:clear', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:46:04', '2021-07-31 18:46:04', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2404, 2400, '0,2000,2400', '数据表优化', 'system:dataMaintain:optimize', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:46:31', '2021-07-31 18:46:31', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (3000, 0, '0', '系统监控', 'monitor', 'el-icon-aim', 'monitor', '', NULL, '1', 'M', '0', 97, NULL, NULL, '2021-07-31 18:49:24', '2021-07-31 18:49:24', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (3100, 3000, '0,3000', '依赖监控', 'system:monitor:rely', 'el-icon-discover', 'rely', 'system/monitor/rely/index', NULL, '1', 'M', '0', 97, NULL, NULL, '2021-07-31 18:51:48', '2021-07-31 18:51:48', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (3101, 3000, '0,3000,3000', '依赖包详细', 'system:monitor:relyDetail', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-09 11:44:20', '2021-08-09 11:44:20', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (3200, 3000, '0,3000', '服务监控', 'system:monitor:server', 'el-icon-umbrella', 'server', 'system/monitor/server/index', NULL, '1', 'M', '0', 99, NULL, NULL, '2021-07-31 18:52:46', '2021-07-31 18:52:46', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (3300, 3000, '0,3000', '日志监控', 'logs', 'el-icon-date', 'logs', '', NULL, '1', 'M', '0', 95, NULL, NULL, '2021-07-31 18:54:01', '2021-07-31 18:54:01', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (3400, 3300, '0,3000,3200', '登录日志', 'system:loginLog', 'el-icon-notebook-2', 'loginLog', 'system/loginLog/index', NULL, '1', 'M', '0', 0, NULL, NULL, '2021-07-31 18:54:55', '2021-07-31 18:54:55', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (3401, 3400, '0,3000,3200,3300', '登录日志删除', 'system:loginLog:delete', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:56:43', '2021-07-31 18:56:43', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (3500, 3300, '0,3000,3200', '操作日志', 'system:operLog', 'el-icon-notebook-1', 'operLog', 'system/operLog/index', NULL, '1', 'M', '0', 0, NULL, NULL, '2021-07-31 18:55:40', '2021-07-31 18:55:40', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (3501, 3500, '0,3000,3200,3400', '操作日志删除', 'system:operLog:delete', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 18:56:19', '2021-07-31 18:56:19', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (3600, 3000, '0,3000', '在线用户', 'system:onlineUser', 'el-icon-paperclip', 'onlineUser', 'system/monitor/onlineUser/index', NULL, '1', 'M', '0', 98, NULL, NULL, '2021-08-08 18:26:31', '2021-08-08 18:26:31', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (3601, 3500, '0,3000,3500', '在线用户列表', 'system:onlineUser:index', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-08 18:26:55', '2021-08-08 18:26:55', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (3602, 3500, '0,3000,3500', '强退用户', 'system:onlineUser:kick', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-08 18:27:21', '2021-08-08 18:27:21', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4000, 0, '0', '开发工具', 'devTools', 'el-icon-s-tools', 'devTools', '', NULL, '1', 'M', '0', 95, NULL, NULL, '2021-07-31 19:03:32', '2021-07-31 19:03:32', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4100, 4000, '0,4000', '模块管理', 'setting:module', 'el-icon-brush', 'module', 'setting/module/index', NULL, '1', 'M', '0', 99, NULL, NULL, '2021-07-31 19:33:49', '2021-07-31 19:33:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4101, 4100, '0,4000,4100', '新增模块', 'setting:module:save', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 19:45:29', '2021-07-31 19:45:29', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4102, 4100, '0,4000,4100', '模块删除', 'setting:module:delete', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 19:34:15', '2021-07-31 19:34:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4103, 4100, '0,4000,4100', '模块列表', 'setting:module:index', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-09 11:48:27', '2021-08-09 11:48:27', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4200, 4000, '0,4000', '代码生成器', 'setting:code', 'sc-icon-code-fill', 'code', 'setting/code/index', NULL, '1', 'M', '0', 98, NULL, NULL, '2021-07-31 19:36:17', '2021-07-31 19:36:17', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4201, 4200, '0,4000,4200', '预览代码', 'setting:code:preview', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 19:36:44', '2021-07-31 19:36:44', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4202, 4200, '0,4000,4200', '装载数据表', 'setting:code:loadTable', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 19:38:03', '2021-07-31 19:38:03', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4203, 4200, '0,4000,4200', '删除业务表', 'setting:code:delete', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 19:38:53', '2021-07-31 19:38:53', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4204, 4200, '0,4000,4200', '同步业务表', 'setting:code:sync', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 19:39:18', '2021-07-31 19:39:18', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4205, 4200, '0,4000,4200', '生成代码', 'setting:code:generate', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 19:39:48', '2021-07-31 19:39:48', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4206, 4200, '0,4000,4200', '更新业务表', 'setting:code:update', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 19:43:12', '2021-07-31 19:43:12', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4300, 4000, '0,4000', '数据表设计器', 'setting:table', 'el-icon-magic-stick', 'table', 'setting/table/index', NULL, '1', 'M', '0', 0, NULL, NULL, '2021-07-31 19:44:08', '2021-07-31 19:44:08', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4301, 4300, '0,4000,4300', '保存数据表', 'setting:table:save', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 19:44:36', '2021-07-31 19:44:36', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4400, 4000, '0,4000', '定时任务', 'setting:crontab', 'el-icon-time', 'crontab', 'setting/crontab/index', '', '1', 'M', '0', 0, NULL, NULL, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4401, 4400, '0,4000,4400', '定时任务列表', 'setting:crontab:index', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4402, 4400, '0,4000,4400', '定时任务保存', 'setting:crontab:save', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4403, 4400, '0,4000,4400', '定时任务更新', 'setting:crontab:update', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4404, 4400, '0,4000,4400', '定时任务删除', 'setting:crontab:delete', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4405, 4400, '0,4000,4400', '定时任务读取', 'setting:crontab:read', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4406, 4400, '0,4000,4400', '定时任务导入', 'setting:crontab:import', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4407, 4400, '0,4000,4400', '定时任务导出', 'setting:crontab:export', NULL, NULL, NULL, NULL, '1', 'B', '0', 0, NULL, NULL, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4408, 4400, '0,4000,4400', '定时任务执行', 'setting:crontab:run', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-07 23:44:06', '2021-08-07 23:44:06', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4500, 0, '0', '系统设置', 'setting:config', '', 'setting', '', '', '0', 'M', '0', 0, NULL, NULL, '2021-07-31 19:58:57', '2021-07-31 19:58:57', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4501, 4500, '0,4500', '获取系统组配置', 'setting:config:getSystemConfig', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-10 13:08:49', '2021-08-10 13:08:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4502, 4500, '0,4500', '获取扩展组配置', 'setting:config:getExtendConfig', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-10 13:09:18', '2021-08-10 13:09:18', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4503, 4500, '0,4500', '保存系统组配置', 'setting:config:saveSystemConfig', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-10 13:11:25', '2021-08-10 13:11:25', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4504, 4500, '0,4500', '新增配置 ', 'setting:config:save', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-10 13:11:56', '2021-08-10 13:11:56', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4505, 4500, '0,4500', '更新配置', 'setting:config:update', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-10 13:12:25', '2021-08-10 13:12:25', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4506, 4500, '0,4500', '删除配置', 'setting:config:delete', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-10 13:13:33', '2021-08-10 13:13:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4507, 4500, '0,4500', '清除配置缓存', 'setting:config:clearCache', '', NULL, '', NULL, '1', 'B', '0', 0, NULL, NULL, '2021-08-10 13:13:59', '2021-08-10 13:13:59', NULL, NULL)",
        ];
    }
}
