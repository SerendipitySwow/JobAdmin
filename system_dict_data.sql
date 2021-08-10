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

 Date: 10/08/2021 16:46:37
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for system_dict_data
-- ----------------------------
DROP TABLE IF EXISTS `system_dict_data`;
CREATE TABLE `system_dict_data`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '主键',
  `type_id` bigint(20) UNSIGNED NOT NULL COMMENT '字典类型ID',
  `label` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典标签',
  `value` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典值',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典标示',
  `sort` tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '状态 (0正常 1停用)',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新者',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `system_dict_data_type_id_index`(`type_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '字典数据表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_dict_data
-- ----------------------------
INSERT INTO `system_dict_data` VALUES (2035090111136, 2035075124896, 'InnoDB', 'InnoDB', 'table_engine', 0, '0', 1897686194336, NULL, '2021-06-27 00:37:11', '2021-06-27 13:33:29', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2035095441568, 2035075124896, 'MyISAM', 'MyISAM', 'table_engine', 0, '0', 1897686194336, NULL, '2021-06-27 00:37:21', '2021-06-27 13:33:29', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2058945281696, 2058928973472, '本地存储', 'local', 'upload_mode', 99, '0', 1937003305632, NULL, '2021-06-27 13:33:43', '2021-06-27 13:33:43', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2058951566496, 2058928973472, '七牛云', 'qiniu', 'upload_mode', 98, '0', 1937003305632, NULL, '2021-06-27 13:33:55', '2021-06-27 13:33:55', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2058957471392, 2058928973472, '阿里云OSS', 'oss', 'upload_mode', 97, '0', 1937003305632, NULL, '2021-06-27 13:34:07', '2021-06-27 13:34:07', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2058963571360, 2058928973472, '腾讯云COS', 'cos', 'upload_mode', 96, '0', 1937003305632, NULL, '2021-06-27 13:34:19', '2021-06-27 13:34:19', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2059041780384, 2059023428768, '正常', '0', 'data_status', 0, '0', 1937003305632, NULL, '2021-06-27 13:36:51', '2021-06-27 13:37:01', NULL, '0为正常');
INSERT INTO `system_dict_data` VALUES (2059051223200, 2059023428768, '停用', '1', 'data_status', 0, '0', 1937003305632, NULL, '2021-06-27 13:37:10', '2021-06-27 13:37:10', NULL, '1为停用');
INSERT INTO `system_dict_data` VALUES (3959904132768, 3959885616288, '统计页面', 'statistics', 'dashboard', 0, '0', 3697515475616, NULL, '2021-08-09 12:53:53', '2021-08-09 12:53:53', NULL, '管理员用');
INSERT INTO `system_dict_data` VALUES (3959916887200, 3959885616288, '工作台', 'work', 'dashboard', 0, '0', 3697515475616, NULL, '2021-08-09 12:54:18', '2021-08-09 12:54:18', NULL, '员工使用');
INSERT INTO `system_dict_data` VALUES (3959938423968, 3959928216736, '男', '0', 'sex', 0, '0', 3697515475616, NULL, '2021-08-09 12:55:00', '2021-08-09 12:55:00', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (3959942491808, 3959928216736, '女', '1', 'sex', 0, '0', 3697515475616, NULL, '2021-08-09 12:55:08', '2021-08-09 12:55:08', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (3959946307744, 3959928216736, '未知', '2', 'sex', 0, '0', 3697515475616, NULL, '2021-08-09 12:55:16', '2021-08-09 12:55:16', NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
