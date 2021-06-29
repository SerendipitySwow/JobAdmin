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

 Date: 28/06/2021 22:25:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '菜单名称',
  `route` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '路由地址',
  `component` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '组件路径',
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
INSERT INTO `system_menu` VALUES (2, 0, '0,', '系统', 'system', 'microchip', '/system', 'mainLayout', '1', '0', '1', '1', 'T', '0', 0, NULL, NULL, '2021-05-01 19:56:33', '2021-05-01 19:56:29', NULL, NULL);
INSERT INTO `system_menu` VALUES (3, 2, '0,2,', '权限管理', 'system-permission', 'bullseye', '/system/permission', '', '1', '0', '1', '1', 'C', '0', 0, NULL, NULL, '2021-05-01 20:15:50', '2021-05-01 20:15:52', NULL, NULL);
INSERT INTO `system_menu` VALUES (4, 3, '0,2,3,', '菜单管理', 'system-menu-index', 'bars', '/system/menu/index', 'system/menu/index', '1', '0', '0', '1', 'M', '0', 0, NULL, NULL, '2021-05-01 20:21:39', '2021-05-01 20:21:44', NULL, NULL);
INSERT INTO `system_menu` VALUES (5, 4, '0,2,3,4', '新增菜单', 'system-menu-create', '', '', '', '1', '0', '1', '1', 'B', '0', 0, NULL, NULL, '2021-05-01 20:24:10', '2021-05-01 20:24:13', NULL, NULL);
INSERT INTO `system_menu` VALUES (2546417356, 0, '0', '设置', 'setting', 'cog', '/setting', '', '1', '0', '1', '1', 'T', '0', 0, NULL, NULL, '2021-05-13 20:43:17', '2021-05-13 20:43:17', NULL, NULL);
INSERT INTO `system_menu` VALUES (2550341996, 2546417356, '0,2546417356', '系统配置', 'setting-index', 'gavel', '/setting/config/index', 'setting/config/index', '1', '0', '1', '1', 'M', '0', 1, NULL, NULL, '2021-05-13 20:47:22', '2021-06-28 22:15:32', NULL, NULL);
INSERT INTO `system_menu` VALUES (2554077676, 2546417356, '', '工具', 'setting-tools', 'rocket', '/setting/tools', '', '1', '0', '1', '1', 'C', '0', 0, NULL, NULL, '2021-05-13 20:51:15', '2021-05-13 20:51:15', NULL, NULL);
INSERT INTO `system_menu` VALUES (2554922252, 2554077676, '2546417356', '代码生成器', 'setting-code-index', 'code', '/setting/code/index', 'setting/code/index', '1', '0', '1', '1', 'M', '0', 0, NULL, NULL, '2021-05-13 20:52:08', '2021-05-13 20:52:08', NULL, NULL);
INSERT INTO `system_menu` VALUES (2561673564, 2554077676, '2546417356', '数据表设计', 'setting-table-index', 'paint-brush', '/setting/table/index', 'setting/table/index', '1', '0', '1', '1', 'M', '0', 0, NULL, NULL, '2021-05-13 20:59:10', '2021-05-13 20:59:10', NULL, NULL);
INSERT INTO `system_menu` VALUES (2562551980, 2554077676, '2546417356', '定时任务', 'setting-crontab-index', 'tasks', '/setting/crontab/index', 'setting/crontab/index', '1', '0', '1', '1', 'M', '0', 0, NULL, NULL, '2021-05-13 21:00:05', '2021-05-13 21:00:05', NULL, NULL);
INSERT INTO `system_menu` VALUES (2578117100, 2, '2', '数据中心', 'system-dataCenter', 'database', '/system/dataCenter', '', '1', '0', '1', '1', 'C', '0', 0, NULL, NULL, '2021-05-13 21:16:18', '2021-05-13 21:16:18', NULL, NULL);
INSERT INTO `system_menu` VALUES (2582849900, 2, '2', '日志管理', 'system-logs', 'hdd-o', '/system/logs', '', '1', '0', '1', '1', 'C', '0', 0, NULL, NULL, '2021-05-13 21:21:14', '2021-05-13 21:21:14', NULL, NULL);
INSERT INTO `system_menu` VALUES (2589924364, 2578117100, '2,2578117100', '数据字典', 'system-dictData', 'book', '/system/dictData/index', 'system/dictData/index', '1', '0', '1', '1', 'M', '0', 0, NULL, NULL, '2021-05-13 21:28:36', '2021-05-13 21:28:36', NULL, NULL);
INSERT INTO `system_menu` VALUES (2592070652, 2578117100, '2,2578117100', '数据表维护', 'system-dataMaintain', 'briefcase', '/system/dataMaintain/index', 'system/dataMaintain/index', '1', '0', '1', '1', 'M', '0', 0, NULL, NULL, '2021-05-13 21:30:50', '2021-05-13 21:30:50', NULL, NULL);
INSERT INTO `system_menu` VALUES (2593102076, 2578117100, '2,2578117100', '文件管理', 'system-attachment', 'image', '/system/attachment/index', 'system/attachment/index', '1', '0', '1', '1', 'M', '0', 0, NULL, NULL, '2021-05-13 21:31:54', '2021-05-13 21:31:54', NULL, NULL);
INSERT INTO `system_menu` VALUES (2597362684, 2582849900, '2,2582849900', '登录日志', 'system-loginLog', 'binoculars', '/system/loginLog/index', 'system/loginLog/index', '1', '0', '1', '1', 'M', '0', 0, NULL, NULL, '2021-05-13 21:36:21', '2021-05-13 21:36:21', NULL, NULL);
INSERT INTO `system_menu` VALUES (2598892300, 2582849900, '2,2582849900', '操作日志', 'system-operLog', 'pencil-square-o', '/system/operLog/index', 'system/operLog/index', '1', '0', '1', '1', 'M', '0', 0, NULL, NULL, '2021-05-13 21:37:56', '2021-05-13 21:37:56', NULL, NULL);
INSERT INTO `system_menu` VALUES (2610507228, 3, '2,3', '用户管理', 'system-user', 'user', '/system/user/index', 'system/user/index', '1', '0', '1', '1', 'M', '0', 0, NULL, NULL, '2021-05-13 21:50:02', '2021-05-13 21:50:02', NULL, NULL);
INSERT INTO `system_menu` VALUES (2611564860, 3, '2,3', '角色管理', 'system-role', 'user-o', '/system/role/index', 'system/role/index', '1', '0', '1', '1', 'M', '0', 0, NULL, NULL, '2021-05-13 21:51:08', '2021-05-13 21:51:08', NULL, NULL);
INSERT INTO `system_menu` VALUES (2612352412, 3, '2,3', '部门管理', 'system-dept', 'drivers-license-o', '/system/dept/index', 'system/dept/index', '1', '0', '1', '1', 'M', '0', 0, NULL, NULL, '2021-05-13 21:51:58', '2021-05-13 21:51:58', NULL, NULL);
INSERT INTO `system_menu` VALUES (2613467612, 3, '2,3', '岗位管理', 'system-post', 'graduation-cap', '/system/post/index', 'system/post/index', '1', '0', '1', '1', 'M', '0', 0, NULL, NULL, '2021-05-13 21:53:07', '2021-05-13 21:53:07', NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
