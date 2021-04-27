/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : mineadmin

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 27/04/2021 17:09:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2021_04_12_160526_create_system_user_table', 1);
INSERT INTO `migrations` VALUES (2, '2021_04_18_215320_create_system_menu_table', 1);
INSERT INTO `migrations` VALUES (3, '2021_04_18_215515_create_system_role_table', 1);
INSERT INTO `migrations` VALUES (4, '2021_04_18_215521_create_system_user_role_table', 1);
INSERT INTO `migrations` VALUES (5, '2021_04_18_222634_create_system_role_menu_table', 1);
INSERT INTO `migrations` VALUES (6, '2021_04_18_224626_create_system_config_table', 1);
INSERT INTO `migrations` VALUES (7, '2021_04_18_224723_create_system_dict_data_table', 1);
INSERT INTO `migrations` VALUES (8, '2021_04_18_224727_create_system_dict_type_table', 1);
INSERT INTO `migrations` VALUES (9, '2021_04_18_224817_create_system_dept_table', 1);
INSERT INTO `migrations` VALUES (15, '2021_04_18_224835_create_system_post_table', 2);
INSERT INTO `migrations` VALUES (11, '2021_04_18_224912_create_system_login_log_table', 1);
INSERT INTO `migrations` VALUES (12, '2021_04_18_224938_create_system_oper_log_table', 1);
INSERT INTO `migrations` VALUES (13, '2021_04_18_225055_create_system_task_table', 1);
INSERT INTO `migrations` VALUES (14, '2021_04_18_225100_create_system_task_log_table', 1);

-- ----------------------------
-- Table structure for system_config
-- ----------------------------
DROP TABLE IF EXISTS `system_config`;
CREATE TABLE `system_config`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '主键',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新者',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '参数配置信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_config
-- ----------------------------

-- ----------------------------
-- Table structure for system_dept
-- ----------------------------
DROP TABLE IF EXISTS `system_dept`;
CREATE TABLE `system_dept`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '主键',
  `parent_id` bigint(20) UNSIGNED NOT NULL COMMENT '父ID',
  `level` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '组级集合',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '部门名称',
  `leader` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '负责人',
  `phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '联系电话',
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '状态 (0正常 1停用)',
  `sort` tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新者',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '部门信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_dept
-- ----------------------------
INSERT INTO `system_dept` VALUES (1, 0, '0', '顶层部门', '测试', '18638883567', '0', 0, NULL, NULL, '2021-04-22 22:30:45', '2021-04-22 22:30:49', NULL, NULL);

-- ----------------------------
-- Table structure for system_dict_data
-- ----------------------------
DROP TABLE IF EXISTS `system_dict_data`;
CREATE TABLE `system_dict_data`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '主键',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新者',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '字典数据表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_dict_data
-- ----------------------------

-- ----------------------------
-- Table structure for system_dict_type
-- ----------------------------
DROP TABLE IF EXISTS `system_dict_type`;
CREATE TABLE `system_dict_type`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '主键',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新者',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '字典类型表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_dict_type
-- ----------------------------

-- ----------------------------
-- Table structure for system_login_log
-- ----------------------------
DROP TABLE IF EXISTS `system_login_log`;
CREATE TABLE `system_login_log`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '主键',
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '登录IP地址',
  `ip_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'IP所属地',
  `os` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '操作系统',
  `browser` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '浏览器',
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '登录状态 (0成功 1失败)',
  `message` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '提示消息',
  `login_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '登录时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '登录日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_login_log
-- ----------------------------
INSERT INTO `system_login_log` VALUES (1612847228076953600, 'admin', '172.17.0.1', '未知', '未知', '未知', '0', '密码不正确', '2021-04-22 21:55:44', NULL);
INSERT INTO `system_login_log` VALUES (1612853915127123968, 'admin', '172.17.0.1', '未知', '未知', '未知', '0', '密码不正确', '2021-04-22 22:22:18', NULL);
INSERT INTO `system_login_log` VALUES (1613051681652609024, 'test', '172.17.0.1', '未知', '未知', '未知', '1', '登录成功', '2021-04-23 11:28:09', NULL);
INSERT INTO `system_login_log` VALUES (1613069144842833920, 'test', '172.17.0.1', '未知', '未知', '未知', '1', '登录成功', '2021-04-23 12:37:33', NULL);
INSERT INTO `system_login_log` VALUES (1613071646795501568, 'admin', '172.17.0.1', '未知', '未知', '未知', '1', '登录成功', '2021-04-23 12:47:30', NULL);
INSERT INTO `system_login_log` VALUES (1613097516981555200, 'test', '172.17.0.1', '未知', '未知', '未知', '1', '登录成功', '2021-04-23 14:30:17', NULL);
INSERT INTO `system_login_log` VALUES (1613119163704807424, 'test', '172.17.0.1', '未知', '未知', '未知', '1', '登录成功', '2021-04-23 15:56:18', NULL);
INSERT INTO `system_login_log` VALUES (1613134547514298368, 'test', '172.17.0.1', '未知', '未知', '未知', '1', '登录成功', '2021-04-23 16:57:26', NULL);
INSERT INTO `system_login_log` VALUES (1613824887560867840, 'test', '127.0.0.1', '未知', 'Windows 10', 'Edge', '0', '用户被禁用', '2021-04-25 14:40:36', NULL);
INSERT INTO `system_login_log` VALUES (1613824914987421696, 'test', '127.0.0.1', '未知', 'Windows 10', 'Edge', '0', '用户被禁用', '2021-04-25 14:40:43', NULL);
INSERT INTO `system_login_log` VALUES (1613824927612276736, 'test', '127.0.0.1', '未知', 'Windows 10', 'Edge', '0', '用户被禁用', '2021-04-25 14:40:46', NULL);
INSERT INTO `system_login_log` VALUES (1613824940006445056, 'test', '127.0.0.1', '未知', 'Windows 10', 'Edge', '0', '用户被禁用', '2021-04-25 14:40:49', NULL);
INSERT INTO `system_login_log` VALUES (1613825106277044224, 'test', '127.0.0.1', '未知', 'Windows 10', 'Edge', '0', '用户被禁用', '2021-04-25 14:41:28', NULL);
INSERT INTO `system_login_log` VALUES (1613844368622358528, 'test', '127.0.0.1', '未知', 'Windows 10', 'Edge', '0', '用户被禁用', '2021-04-25 15:58:01', NULL);
INSERT INTO `system_login_log` VALUES (1613844406182350848, 'test', '127.0.0.1', '未知', 'Windows 10', 'Edge', '1', '登录成功', '2021-04-25 15:58:10', NULL);
INSERT INTO `system_login_log` VALUES (1613861008667840512, 'test', '127.0.0.1', '未知', 'Windows 10', 'Edge', '1', '登录成功', '2021-04-25 17:04:08', NULL);
INSERT INTO `system_login_log` VALUES (1613864850696441856, 'admin', '127.0.0.1', '未知', 'Windows 10', 'Edge', '1', '登录成功', '2021-04-25 17:19:24', NULL);
INSERT INTO `system_login_log` VALUES (1614102842363088896, 'test', '127.0.0.1', '未知', 'Windows 10', 'Edge', '1', '登录成功', '2021-04-26 09:05:06', NULL);
INSERT INTO `system_login_log` VALUES (1614124845895782400, 'test', '127.0.0.1', '未知', 'Windows 10', 'Edge', '1', '登录成功', '2021-04-26 10:32:32', NULL);
INSERT INTO `system_login_log` VALUES (1614169474020151296, 'admin', '127.0.0.1', '未知', 'Windows 10', 'Edge', '1', '登录成功', '2021-04-26 13:29:52', NULL);
INSERT INTO `system_login_log` VALUES (1614185059848294400, 'admin', '127.0.0.1', '未知', 'Windows 10', 'Edge', '1', '登录成功', '2021-04-26 14:31:48', NULL);
INSERT INTO `system_login_log` VALUES (1614207871178772480, 'admin', '127.0.0.1', '未知', 'Windows 10', 'Edge', '1', '登录成功', '2021-04-26 16:02:27', NULL);
INSERT INTO `system_login_log` VALUES (1614228518936252416, 'admin', '127.0.0.1', '未知', 'Windows 10', 'Edge', '1', '登录成功', '2021-04-26 17:24:29', NULL);
INSERT INTO `system_login_log` VALUES (1614531325732065280, 'admin', '127.0.0.1', '未知', 'Windows 10', 'Edge', '1', '登录成功', '2021-04-27 13:27:44', NULL);
INSERT INTO `system_login_log` VALUES (1614533708486807552, 'admin', '127.0.0.1', '未知', 'Windows 10', 'Edge', '1', '登录成功', '2021-04-27 13:37:12', NULL);

-- ----------------------------
-- Table structure for system_menu
-- ----------------------------
DROP TABLE IF EXISTS `system_menu`;
CREATE TABLE `system_menu`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '主键',
  `parent_id` bigint(20) UNSIGNED NOT NULL COMMENT '父ID',
  `level` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '组级集合',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '菜单名称',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '菜单标识代码',
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '菜单名称',
  `route` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '路由地址',
  `component` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '组件路径',
  `is_out` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1' COMMENT '是否外链, (0是 1否)',
  `is_cache` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '是否缓存, (0是 1否)',
  `is_quick` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1' COMMENT '是否快捷菜单, (0是 1否)',
  `is_hidden` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1' COMMENT '是否隐藏 (0是 1否)',
  `type` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '菜单类型, (T分类 C目录 M菜单 B按钮)',
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '状态 (0正常 1停用)',
  `sort` tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新者',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '菜单信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_menu
-- ----------------------------
INSERT INTO `system_menu` VALUES (1, 0, '0，', '首页', 'dashbold', '1', 'dashbold', '2312', '1', '0', '1', '1', 'T', '0', 0, NULL, NULL, '2021-04-22 22:38:58', '2021-04-22 22:39:00', NULL, NULL);

-- ----------------------------
-- Table structure for system_oper_log
-- ----------------------------
DROP TABLE IF EXISTS `system_oper_log`;
CREATE TABLE `system_oper_log`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '主键',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新者',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '操作日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_oper_log
-- ----------------------------

-- ----------------------------
-- Table structure for system_post
-- ----------------------------
DROP TABLE IF EXISTS `system_post`;
CREATE TABLE `system_post`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '主键',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '岗位名称',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '岗位代码',
  `sort` tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '状态 (0正常 1停用)',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新者',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '职位信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_post
-- ----------------------------
INSERT INTO `system_post` VALUES (1, '321', '123', 0, '0', NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for system_role
-- ----------------------------
DROP TABLE IF EXISTS `system_role`;
CREATE TABLE `system_role`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '主键，角色ID',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '角色名称',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '角色代码',
  `data_scope` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '数据范围（0：全部数据权限 1：自定数据权限 2：本部门数据权限 3：本部门及以下数据权限）',
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '状态 (0正常 1停用)',
  `sort` tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新者',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_role
-- ----------------------------
INSERT INTO `system_role` VALUES (1612846635858006083, '超级管理员（创始人）', 'super_admin', '0', '0', 0, 1612846635858006016, 0, '2021-04-22 21:54:14', '2021-04-22 21:54:14', NULL, '系统内置角色，不可删除');
INSERT INTO `system_role` VALUES (1612846635858006084, '管理员', 'admin', '0', '0', 0, 1612846635858006016, 0, '2021-04-22 21:54:14', '2021-04-22 21:54:14', NULL, '系统内置角色，不可删除');

-- ----------------------------
-- Table structure for system_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `system_role_menu`;
CREATE TABLE `system_role_menu`  (
  `role_id` bigint(20) UNSIGNED NOT NULL COMMENT '角色主键',
  `menu_id` bigint(20) UNSIGNED NOT NULL COMMENT '菜单主键',
  PRIMARY KEY (`role_id`, `menu_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色与菜单关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_role_menu
-- ----------------------------
INSERT INTO `system_role_menu` VALUES (1612846635858006084, 1);

-- ----------------------------
-- Table structure for system_task
-- ----------------------------
DROP TABLE IF EXISTS `system_task`;
CREATE TABLE `system_task`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '主键',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新者',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '定时任务信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_task
-- ----------------------------

-- ----------------------------
-- Table structure for system_task_log
-- ----------------------------
DROP TABLE IF EXISTS `system_task_log`;
CREATE TABLE `system_task_log`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '主键',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新者',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '定时任务执行日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_task_log
-- ----------------------------

-- ----------------------------
-- Table structure for system_user
-- ----------------------------
DROP TABLE IF EXISTS `system_user`;
CREATE TABLE `system_user`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '用户ID，主键',
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `user_type` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '100' COMMENT '用户类型：(100系统用户)',
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '用户邮箱',
  `avatar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '用户头像',
  `dept_id` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '部门ID',
  `remember_token` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '用户Token',
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '状态 (0正常 1停用)',
  `login_ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '最后登陆IP',
  `login_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后登陆时间',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新者',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `system_user_username_unique`(`username`) USING BTREE,
  INDEX `system_user_dept_id_index`(`dept_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_user
-- ----------------------------
INSERT INTO `system_user` VALUES (1612846635858006016, 'admin', '$2y$10$F3iCSPGSVMqi4/E9NHspS.f/IH0ijs1NLjgg30NB6vJlec0PZd9p2', '100', NULL, NULL, 1, NULL, '0', '127.0.0.1', '2021-04-27 13:37:12', 0, 0, '2021-04-22 21:54:14', '2021-04-27 13:37:12', NULL, NULL);
INSERT INTO `system_user` VALUES (1612856850330423296, 'test', '$2y$10$Sqrmct1UFJQX0geYb2Dm8ubFXR2l1ZQB16J52OhOaujoKOBGj8tuu', '100', NULL, NULL, NULL, NULL, '0', '127.0.0.1', '2021-04-26 10:32:32', NULL, NULL, '2021-04-22 22:33:58', '2021-04-26 10:32:32', NULL, NULL);
INSERT INTO `system_user` VALUES (1614175990198571008, 'test1', '$2y$10$YXO4PvpuUiU4o6G6k4ep.Oh01baeQc1qqQYo6x4N13RS2Wdrl1tYa', '100', NULL, NULL, 1, NULL, '0', NULL, NULL, NULL, NULL, '2021-04-26 13:55:46', '2021-04-26 13:55:46', NULL, NULL);
INSERT INTO `system_user` VALUES (1614177417914486784, 'test2', '$2y$10$Rknjhe6W80rYYokNbISj6.fv/RvpyOMA0JL5Rayqa7TnUIrr4WHvG', '100', NULL, NULL, 1, NULL, '0', NULL, NULL, NULL, NULL, '2021-04-26 14:01:26', '2021-04-26 14:01:26', NULL, NULL);
INSERT INTO `system_user` VALUES (1614185115464765440, 'test3', '$2y$10$nOkg4bpaNezVUzgbgbTbHu9jGaxbsKc0DRugwWv5O8CgRWHUfSpPm', '100', NULL, NULL, 1, NULL, '0', NULL, NULL, NULL, NULL, '2021-04-26 14:32:01', '2021-04-26 14:32:01', NULL, NULL);
INSERT INTO `system_user` VALUES (1614185381211672576, 'test4', '$2y$10$OD1YuWZvIIQNCXfum8UzdOrwnzYu4bDp1LUpWSk1vZekbppIT0Hou', '100', NULL, NULL, 1, NULL, '0', NULL, NULL, NULL, NULL, '2021-04-26 14:33:04', '2021-04-26 14:33:04', NULL, NULL);

-- ----------------------------
-- Table structure for system_user_post
-- ----------------------------
DROP TABLE IF EXISTS `system_user_post`;
CREATE TABLE `system_user_post`  (
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT '用户主键',
  `job_id` bigint(20) UNSIGNED NOT NULL COMMENT '岗位主键'
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户与岗位关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_user_post
-- ----------------------------

-- ----------------------------
-- Table structure for system_user_role
-- ----------------------------
DROP TABLE IF EXISTS `system_user_role`;
CREATE TABLE `system_user_role`  (
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT '用户主键',
  `role_id` bigint(20) UNSIGNED NOT NULL COMMENT '角色主键',
  PRIMARY KEY (`user_id`, `role_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户与角色关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_user_role
-- ----------------------------
INSERT INTO `system_user_role` VALUES (1612846635858006016, 1612846635858006083);
INSERT INTO `system_user_role` VALUES (1612856850330423296, 1612846635858006084);
INSERT INTO `system_user_role` VALUES (1614175990198571008, 1612846635858006084);
INSERT INTO `system_user_role` VALUES (1614177417914486784, 1612846635858006084);
INSERT INTO `system_user_role` VALUES (1614185115464765440, 1612846635858006084);
INSERT INTO `system_user_role` VALUES (1614185381211672576, 1612846635858006084);

SET FOREIGN_KEY_CHECKS = 1;
