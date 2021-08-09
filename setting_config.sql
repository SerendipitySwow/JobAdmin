/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 80012
 Source Host           : localhost:3306
 Source Schema         : mineadmin

 Target Server Type    : MySQL
 Target Server Version : 80012
 File Encoding         : 65001

 Date: 09/08/2021 23:24:10
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for setting_config
-- ----------------------------
DROP TABLE IF EXISTS `setting_config`;
CREATE TABLE `setting_config`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '主键',
  `group_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '组名称',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '配置名称',
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '配置键名',
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '配置值',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新者',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `setting_config_key_index`(`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '参数配置信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of setting_config
-- ----------------------------
INSERT INTO `setting_config` VALUES (1000, 'system', '网站名称', 'site_name', '', NULL, NULL, '2021-08-09 23:09:51', NULL, NULL, NULL);
INSERT INTO `setting_config` VALUES (1001, 'system', '网站关键字', 'site_keywords', NULL, NULL, NULL, '2021-08-09 23:10:43', NULL, NULL, NULL);
INSERT INTO `setting_config` VALUES (1002, 'system', '网站描述', 'site_desc', NULL, NULL, NULL, '2021-08-09 23:11:07', NULL, NULL, NULL);
INSERT INTO `setting_config` VALUES (1003, 'system', '网站备案号', 'site_record_number', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `setting_config` VALUES (1004, 'system', '版权信息', 'site_copyright', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `setting_config` VALUES (1005, 'system', '上传存储模式', 'site_storage_mode', '1', NULL, NULL, NULL, NULL, NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
