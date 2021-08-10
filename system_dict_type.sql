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

 Date: 10/08/2021 16:46:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for system_dict_type
-- ----------------------------
DROP TABLE IF EXISTS `system_dict_type`;
CREATE TABLE `system_dict_type`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '主键',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典名称',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典标示',
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '状态 (0正常 1停用)',
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
INSERT INTO `system_dict_type` VALUES (2035075124896, '数据表引擎', 'table_engine', '0', 1897686194336, NULL, '2021-06-27 00:36:42', '2021-06-27 13:33:29', NULL, '数据表引擎字典');
INSERT INTO `system_dict_type` VALUES (2058928973472, '存储模式', 'upload_mode', '0', 1937003305632, NULL, '2021-06-27 13:33:11', '2021-06-27 13:33:11', NULL, '上传文件存储模式');
INSERT INTO `system_dict_type` VALUES (2059023428768, '数据状态', 'data_status', '0', 1937003305632, NULL, '2021-06-27 13:36:16', '2021-06-27 13:36:34', NULL, '通用数据状态');
INSERT INTO `system_dict_type` VALUES (3959885616288, '后台首页', 'dashboard', '0', 3697515475616, NULL, '2021-08-09 12:53:17', '2021-08-09 12:53:17', NULL, NULL);
INSERT INTO `system_dict_type` VALUES (3959928216736, '性别', 'sex', '0', 3697515475616, NULL, '2021-08-09 12:54:40', '2021-08-09 12:54:40', NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
