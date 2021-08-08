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

 Date: 08/08/2021 21:08:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for setting_crontab
-- ----------------------------
DROP TABLE IF EXISTS `setting_crontab`;
CREATE TABLE `setting_crontab`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '主键',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '任务名称',
  `type` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '4' COMMENT '任务类型 (1 command, 2 class, 3 url, 4 eval)',
  `target` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '调用任务字符串',
  `parameter` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '调用任务参数',
  `rule` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '任务执行表达式',
  `singleton` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '是否单次执行 (0 是 1 不是)',
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '状态 (0正常 1停用)',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新者',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '定时任务信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of setting_crontab
-- ----------------------------
INSERT INTO `setting_crontab` VALUES (3890924964000, 'urlCrontab', '3', 'http://127.0.0.1:9501/', '', '59 */1 * * * *', '1', '1', 3094419583648, NULL, '2021-08-07 23:28:28', '2021-08-07 23:44:55', '请求127.0.0.1');

SET FOREIGN_KEY_CHECKS = 1;
