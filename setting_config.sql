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

 Date: 10/08/2021 23:25:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for setting_config
-- ----------------------------
DROP TABLE IF EXISTS `setting_config`;
CREATE TABLE `setting_config`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '配置键名',
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '配置值',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '配置名称',
  `group_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '组名称',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `sort` tinyint(3) NULL DEFAULT 0 COMMENT '排序',
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `setting_config_key_index`(`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '参数配置信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of setting_config
-- ----------------------------
INSERT INTO `setting_config` VALUES ('aa', 'bbasdsadf', 'ccsdf', 'extend', 'ddaas', 0);
INSERT INTO `setting_config` VALUES ('site_copyright', 'aas', '版权信息', 'system', NULL, 96);
INSERT INTO `setting_config` VALUES ('site_desc', 'bfd', '网站描述', 'system', NULL, 97);
INSERT INTO `setting_config` VALUES ('site_keywords', 'csd', '网站关键字', 'system', NULL, 98);
INSERT INTO `setting_config` VALUES ('site_name', 'dfs', '网站名称', 'system', NULL, 99);
INSERT INTO `setting_config` VALUES ('site_record_number', 'esdf', '网站备案号', 'system', NULL, 95);
INSERT INTO `setting_config` VALUES ('site_resource_host', '127.0.0.1:9501', '本地资源地址', 'system', NULL, 94);
INSERT INTO `setting_config` VALUES ('site_storage_mode', 'local', '上传存储模式', 'system', NULL, 93);

SET FOREIGN_KEY_CHECKS = 1;
