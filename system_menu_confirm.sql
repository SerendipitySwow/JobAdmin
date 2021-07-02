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

 Date: 02/07/2021 17:30:13
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
INSERT INTO `system_menu` VALUES (2252249837216, 0, '0', '系统', 'system', 'microchip', 'system', NULL, '1', '0', '1', '1', 'T', '0', 99, 1937003305632, NULL, '2021-07-01 22:26:11', '2021-07-01 22:30:11', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252263087264, 0, '0', '设置', 'setting', 'cog', 'setting', NULL, '1', '0', '1', '1', 'T', '0', 0, 1937003305632, NULL, '2021-07-01 22:26:37', '2021-07-01 22:26:37', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252346015392, 2252249837216, '0,2252249837216', '权限管理', 'permission', 'bullseye', 'permission', NULL, '1', '0', '1', '1', 'C', '0', 99, 1937003305632, NULL, '2021-07-01 22:29:19', '2021-07-01 22:30:16', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252367037088, 2252249837216, '0,2252249837216', '日志管理', 'logs', 'hdd-o', 'logs', NULL, '1', '0', '1', '1', 'C', '0', 0, 1937003305632, NULL, '2021-07-01 22:30:00', '2021-07-01 22:30:54', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252387867296, 2252249837216, '0,2252249837216', '数据中心', 'dataCenter', 'database', 'dataCenter', NULL, '1', '0', '1', '1', 'C', '0', 98, 1937003305632, NULL, '2021-07-01 22:30:41', '2021-07-01 22:30:48', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252448115872, 2252263087264, '0,2252263087264', '系统配置', 'config', 'gavel', 'config', 'setting/config/index', '1', '0', '1', '1', 'M', '0', 99, 1937003305632, NULL, '2021-07-01 22:32:38', '2021-07-01 22:32:38', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252471315616, 2252263087264, '0,2252263087264', '系统工具', 'tools', 'rocket', 'tools', NULL, '1', '0', '1', '1', 'C', '0', 0, 1937003305632, NULL, '2021-07-01 22:33:24', '2021-07-01 22:33:24', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252523422880, 2252346015392, '0,2252249837216,2252346015392', '用户管理', 'system:user', 'user', 'user', 'system/user/index', '1', '0', '1', '1', 'M', '0', 99, 1937003305632, NULL, '2021-07-01 22:35:05', '2021-07-01 22:42:32', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252523431072, 2252523422880, '0,2252249837216,2252346015392,2252523422880', '列表', 'system:user:index', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:35:05', '2021-07-01 22:43:04', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252523437216, 2252523422880, '0,2252249837216,2252346015392,2252523422880', '保存', 'system:user:save', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:35:05', '2021-07-01 22:43:08', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252523442848, 2252523422880, '0,2252249837216,2252346015392,2252523422880', '更新', 'system:user:update', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:35:05', '2021-07-01 22:42:43', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252523452576, 2252523422880, '0,2252249837216,2252346015392,2252523422880', '删除', 'system:user:delete', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:35:05', '2021-07-01 22:42:47', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252523458720, 2252523422880, '0,2252249837216,2252346015392,2252523422880', '读取', 'system:user:read', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:35:05', '2021-07-01 22:42:51', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252523464352, 2252523422880, '0,2252249837216,2252346015392,2252523422880', '恢复', 'system:user:recovery', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:35:05', '2021-07-01 22:42:55', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252523470496, 2252523422880, '0,2252249837216,2252346015392,2252523422880', '真实删除', 'system:user:realDelete', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:35:05', '2021-07-01 22:43:00', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252899374240, 2252346015392, '0,2252249837216,2252346015392', '菜单管理', 'system:menu', 'bars', 'menu', 'system/menu/index', '1', '0', '1', '1', 'M', '0', 97, 1937003305632, NULL, '2021-07-01 22:47:20', '2021-07-01 22:47:56', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252899384480, 2252899374240, '0,2252249837216,2252346015392,2252899374240', '列表', 'system:menu:index', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:47:20', '2021-07-01 22:47:20', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252899391136, 2252899374240, '0,2252249837216,2252346015392,2252899374240', '保存', 'system:menu:save', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:47:20', '2021-07-01 22:47:20', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252899397280, 2252899374240, '0,2252249837216,2252346015392,2252899374240', '更新', 'system:menu:update', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:47:20', '2021-07-01 22:47:20', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252899402912, 2252899374240, '0,2252249837216,2252346015392,2252899374240', '删除', 'system:menu:delete', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:47:20', '2021-07-01 22:47:20', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252899409568, 2252899374240, '0,2252249837216,2252346015392,2252899374240', '读取', 'system:menu:read', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:47:20', '2021-07-01 22:47:20', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252899416224, 2252899374240, '0,2252249837216,2252346015392,2252899374240', '恢复', 'system:menu:recovery', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:47:20', '2021-07-01 22:47:20', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252899423392, 2252899374240, '0,2252249837216,2252346015392,2252899374240', '真实删除', 'system:menu:realDelete', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:47:20', '2021-07-01 22:47:20', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252965575840, 2252346015392, '0,2252249837216,2252346015392', '角色管理', 'system:role', 'user-o', 'role', 'system/role/index', '1', '0', '1', '1', 'M', '0', 96, 1937003305632, NULL, '2021-07-01 22:49:29', '2021-07-01 22:49:41', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252965598880, 2252965575840, '0,2252249837216,2252346015392,2252965575840', '列表', 'system:role:index', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:49:29', '2021-07-01 22:49:29', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252965608608, 2252965575840, '0,2252249837216,2252346015392,2252965575840', '保存', 'system:role:save', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:49:29', '2021-07-01 22:49:29', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252965615264, 2252965575840, '0,2252249837216,2252346015392,2252965575840', '更新', 'system:role:update', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:49:29', '2021-07-01 22:49:29', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252965621408, 2252965575840, '0,2252249837216,2252346015392,2252965575840', '删除', 'system:role:delete', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:49:29', '2021-07-01 22:49:29', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252965627552, 2252965575840, '0,2252249837216,2252346015392,2252965575840', '读取', 'system:role:read', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:49:29', '2021-07-01 22:49:29', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252965633184, 2252965575840, '0,2252249837216,2252346015392,2252965575840', '恢复', 'system:role:recovery', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:49:29', '2021-07-01 22:49:29', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252965639840, 2252965575840, '0,2252249837216,2252346015392,2252965575840', '真实删除', 'system:role:realDelete', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:49:29', '2021-07-01 22:49:29', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252994299040, 2252346015392, '0,2252249837216,2252346015392', '部门管理', 'system:dept', 'drivers-license-o', 'dept', 'system/dept/index', '1', '0', '1', '1', 'M', '0', 95, 1937003305632, NULL, '2021-07-01 22:50:25', '2021-07-01 22:50:34', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252994321568, 2252994299040, '0,2252249837216,2252346015392,2252994299040', '列表', 'system:dept:index', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:50:25', '2021-07-01 22:50:25', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252994328224, 2252994299040, '0,2252249837216,2252346015392,2252994299040', '保存', 'system:dept:save', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:50:25', '2021-07-01 22:50:25', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252994333856, 2252994299040, '0,2252249837216,2252346015392,2252994299040', '更新', 'system:dept:update', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:50:25', '2021-07-01 22:50:25', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252994339488, 2252994299040, '0,2252249837216,2252346015392,2252994299040', '删除', 'system:dept:delete', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:50:25', '2021-07-01 22:50:25', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252994346144, 2252994299040, '0,2252249837216,2252346015392,2252994299040', '读取', 'system:dept:read', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:50:25', '2021-07-01 22:50:25', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252994352800, 2252994299040, '0,2252249837216,2252346015392,2252994299040', '恢复', 'system:dept:recovery', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:50:25', '2021-07-01 22:50:25', NULL, NULL);
INSERT INTO `system_menu` VALUES (2252994358944, 2252994299040, '0,2252249837216,2252346015392,2252994299040', '真实删除', 'system:dept:realDelete', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:50:25', '2021-07-01 22:50:25', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253020886176, 2252346015392, '0,2252249837216,2252346015392', '岗位管理', 'system:post', 'graduation-cap', 'post', 'system/post/index', '1', '0', '1', '1', 'M', '0', 94, 1937003305632, NULL, '2021-07-01 22:51:17', '2021-07-01 22:51:17', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253020909216, 2253020886176, '0,2252249837216,2252346015392,2253020886176', '列表', 'system:post:index', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:51:17', '2021-07-01 22:51:17', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253020915360, 2253020886176, '0,2252249837216,2252346015392,2253020886176', '保存', 'system:post:save', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:51:17', '2021-07-01 22:51:17', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253020922016, 2253020886176, '0,2252249837216,2252346015392,2253020886176', '更新', 'system:post:update', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:51:17', '2021-07-01 22:51:17', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253020928160, 2253020886176, '0,2252249837216,2252346015392,2253020886176', '删除', 'system:post:delete', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:51:17', '2021-07-01 22:51:17', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253020934304, 2253020886176, '0,2252249837216,2252346015392,2253020886176', '读取', 'system:post:read', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:51:17', '2021-07-01 22:51:17', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253020940448, 2253020886176, '0,2252249837216,2252346015392,2253020886176', '恢复', 'system:post:recovery', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:51:17', '2021-07-01 22:51:17', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253020946592, 2253020886176, '0,2252249837216,2252346015392,2253020886176', '真实删除', 'system:post:realDelete', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:51:17', '2021-07-01 22:51:17', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253070298272, 2252387867296, '0,2252249837216,2252387867296', '数据字典', 'system:dictData', 'book', 'dictData', 'system/dictData/index', '1', '0', '1', '1', 'M', '0', 0, 1937003305632, NULL, '2021-07-01 22:52:53', '2021-07-01 22:52:53', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253070305952, 2253070298272, '0,2252249837216,2252387867296,2253070298272', '列表', 'system:dictData:index', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:52:53', '2021-07-01 22:52:53', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253070312096, 2253070298272, '0,2252249837216,2252387867296,2253070298272', '保存', 'system:dictData:save', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:52:53', '2021-07-01 22:52:53', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253070318240, 2253070298272, '0,2252249837216,2252387867296,2253070298272', '更新', 'system:dictData:update', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:52:53', '2021-07-01 22:52:53', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253070323872, 2253070298272, '0,2252249837216,2252387867296,2253070298272', '删除', 'system:dictData:delete', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:52:53', '2021-07-01 22:52:53', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253070330016, 2253070298272, '0,2252249837216,2252387867296,2253070298272', '读取', 'system:dictData:read', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:52:53', '2021-07-01 22:52:53', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253070335648, 2253070298272, '0,2252249837216,2252387867296,2253070298272', '恢复', 'system:dictData:recovery', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:52:53', '2021-07-01 22:52:53', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253070341280, 2253070298272, '0,2252249837216,2252387867296,2253070298272', '真实删除', 'system:dictData:realDelete', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:52:54', '2021-07-01 22:52:54', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253106098336, 2252387867296, '0,2252249837216,2252387867296', '字典管理', 'system:dictType', 'book', 'dictType', NULL, '1', '0', '1', '0', 'M', '0', 0, 1937003305632, NULL, '2021-07-01 22:54:03', '2021-07-01 22:54:03', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253106127008, 2253106098336, '0,2252249837216,2252387867296,2253106098336', '列表', 'system:dictType:index', NULL, NULL, NULL, '1', '0', '1', '0', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:54:03', '2021-07-01 22:54:03', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253106133152, 2253106098336, '0,2252249837216,2252387867296,2253106098336', '保存', 'system:dictType:save', NULL, NULL, NULL, '1', '0', '1', '0', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:54:03', '2021-07-01 22:54:03', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253106141856, 2253106098336, '0,2252249837216,2252387867296,2253106098336', '更新', 'system:dictType:update', NULL, NULL, NULL, '1', '0', '1', '0', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:54:03', '2021-07-01 22:54:03', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253106148512, 2253106098336, '0,2252249837216,2252387867296,2253106098336', '删除', 'system:dictType:delete', NULL, NULL, NULL, '1', '0', '1', '0', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:54:03', '2021-07-01 22:54:03', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253106154656, 2253106098336, '0,2252249837216,2252387867296,2253106098336', '读取', 'system:dictType:read', NULL, NULL, NULL, '1', '0', '1', '0', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:54:03', '2021-07-01 22:54:03', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253106160800, 2253106098336, '0,2252249837216,2252387867296,2253106098336', '恢复', 'system:dictType:recovery', NULL, NULL, NULL, '1', '0', '1', '0', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:54:03', '2021-07-01 22:54:03', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253106167456, 2253106098336, '0,2252249837216,2252387867296,2253106098336', '真实删除', 'system:dictType:realDelete', NULL, NULL, NULL, '1', '0', '1', '0', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:54:03', '2021-07-01 22:54:03', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253163384992, 2252387867296, '0,2252249837216,2252387867296', '数据表维护', 'system:dataMaintain', 'briefcase', 'dataMaintain', 'system/dataMaintain/index', '1', '0', '1', '1', 'M', '0', 0, 1937003305632, NULL, '2021-07-01 22:55:55', '2021-07-01 22:55:55', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253190194336, 2253163384992, '0,2252249837216,2252387867296,2253163384992', '表优化', 'system:dataMaintain:optimize', '', NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:56:48', '2021-07-01 22:57:43', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253201630880, 2253163384992, '0,2252249837216,2252387867296,2253163384992', '清理碎片', 'system:dataMaintain:clear', '', NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:57:10', '2021-07-01 22:57:29', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253269464224, 2252387867296, '0,2252249837216,2252387867296', '附件管理', 'system:attachment', 'image', 'attachment', 'system/attachment/index', '1', '0', '1', '1', 'M', '0', 0, 1937003305632, NULL, '2021-07-01 22:59:22', '2021-07-01 22:59:22', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253284174496, 2253269464224, '0,2252249837216,2252387867296,2253269464224', '删除附件', 'system:attachment:delete', '', NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 22:59:51', '2021-07-01 22:59:51', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253300961952, 2253269464224, '0,2252249837216,2252387867296,2253269464224', '真实删除', 'system:attachment:realDelete', '', NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 23:00:24', '2021-07-01 23:00:24', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253422178464, 2252471315616, '0,2252263087264,2252471315616', '代码生成器', 'setting:code', 'code', 'code', 'setting/code/index', '1', '0', '1', '1', 'M', '0', 99, 1937003305632, NULL, '2021-07-01 23:04:21', '2021-07-01 23:04:21', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253460182176, 2252471315616, '0,2252263087264,2252471315616', '数据表设计', 'setting:table', 'paint-brush', 'table', 'setting/table/index', '1', '0', '1', '1', 'M', '0', 98, 1937003305632, NULL, '2021-07-01 23:05:35', '2021-07-01 23:05:35', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253492815520, 2252471315616, '0,2252263087264,2252471315616', '定时任务', 'setting:crontab', 'tasks', 'crontab', 'setting/crontab/index', '1', '0', '1', '1', 'M', '0', 97, 1937003305632, NULL, '2021-07-01 23:06:39', '2021-07-01 23:06:39', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253492829856, 2253492815520, '0,2252263087264,2252471315616,2253492815520', '列表', 'setting:crontab:index', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 23:06:39', '2021-07-01 23:06:39', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253492835488, 2253492815520, '0,2252263087264,2252471315616,2253492815520', '保存', 'setting:crontab:save', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 23:06:39', '2021-07-01 23:06:39', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253492842144, 2253492815520, '0,2252263087264,2252471315616,2253492815520', '更新', 'setting:crontab:update', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 23:06:39', '2021-07-01 23:06:39', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253492847776, 2253492815520, '0,2252263087264,2252471315616,2253492815520', '删除', 'setting:crontab:delete', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 23:06:39', '2021-07-01 23:06:39', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253492854432, 2253492815520, '0,2252263087264,2252471315616,2253492815520', '读取', 'setting:crontab:read', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 23:06:39', '2021-07-01 23:06:39', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253492861088, 2253492815520, '0,2252263087264,2252471315616,2253492815520', '恢复', 'setting:crontab:recovery', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 23:06:39', '2021-07-01 23:06:39', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253492866720, 2253492815520, '0,2252263087264,2252471315616,2253492815520', '真实删除', 'setting:crontab:realDelete', NULL, NULL, NULL, '1', '0', '1', '1', 'B', '0', 0, 1937003305632, NULL, '2021-07-01 23:06:39', '2021-07-01 23:06:39', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253717921440, 2252367037088, '0,2252249837216,2252367037088', '操作日志', 'system:operLog', 'pencil-square-o', 'operLog', 'system/operLog/index', '1', '0', '1', '1', 'M', '0', 0, 1937003305632, NULL, '2021-07-01 23:13:58', '2021-07-01 23:13:58', NULL, NULL);
INSERT INTO `system_menu` VALUES (2253746544288, 2252367037088, '0,2252249837216,2252367037088', '登录日志', 'system:loginLog', 'binoculars', 'loginLog', 'system/loginLog/index', '1', '0', '1', '1', 'M', '0', 0, 1937003305632, NULL, '2021-07-01 23:14:54', '2021-07-01 23:14:54', NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
