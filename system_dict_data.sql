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

 Date: 27/06/2021 22:27:34
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
INSERT INTO `system_dict_data` VALUES (2058945281696, 2058928973472, '本地存储', 'local', 'upload_mode', 0, '0', 1937003305632, NULL, '2021-06-27 13:33:43', '2021-06-27 13:33:43', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2058951566496, 2058928973472, '七牛云', 'qiniu', 'upload_mode', 0, '0', 1937003305632, NULL, '2021-06-27 13:33:55', '2021-06-27 13:33:55', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2058957471392, 2058928973472, '阿里云OSS', 'oss', 'upload_mode', 0, '0', 1937003305632, NULL, '2021-06-27 13:34:07', '2021-06-27 13:34:07', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2058963571360, 2058928973472, '腾讯云COS', 'cos', 'upload_mode', 0, '0', 1937003305632, NULL, '2021-06-27 13:34:19', '2021-06-27 13:34:19', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2059041780384, 2059023428768, '正常', '0', 'data_status', 0, '0', 1937003305632, NULL, '2021-06-27 13:36:51', '2021-06-27 13:37:01', NULL, '0为正常');
INSERT INTO `system_dict_data` VALUES (2059051223200, 2059023428768, '停用', '1', 'data_status', 0, '0', 1937003305632, NULL, '2021-06-27 13:37:10', '2021-06-27 13:37:10', NULL, '1为停用');
INSERT INTO `system_dict_data` VALUES (2066630025888, 2066617579680, '华东1（杭州）', 'oss-cn-hangzhou.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:43:52', '2021-06-27 17:43:52', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066647785632, 2066617579680, '华东2（上海）', 'oss-cn-shanghai.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:44:27', '2021-06-27 17:44:27', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066660299936, 2066617579680, '华北1（青岛）', 'oss-cn-qingdao.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:44:51', '2021-06-27 17:44:51', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066671577248, 2066617579680, '华北2（北京）', 'oss-cn-beijing.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:45:13', '2021-06-27 17:45:13', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066682664096, 2066617579680, '华北3（张家口）', 'oss-cn-zhangjiakou.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:45:35', '2021-06-27 17:45:35', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066697363616, 2066617579680, '华北5（呼和浩特）', 'oss-cn-huhehaote.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:46:04', '2021-06-27 17:46:04', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066713281184, 2066617579680, '华北6（乌兰察布）', 'oss-cn-wulanchabu.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:46:35', '2021-06-27 17:46:35', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066722770592, 2066617579680, '华南1（深圳）', 'oss-cn-shenzhen.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:46:53', '2021-06-27 17:46:53', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066731212960, 2066617579680, '华南2（河源）', 'oss-cn-heyuan.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:47:10', '2021-06-27 17:47:10', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066739821216, 2066617579680, '华南3（广州）', 'oss-cn-guangzhou.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:47:27', '2021-06-27 17:47:27', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066747588768, 2066617579680, '西南1（成都）', 'oss-cn-chengdu.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:47:42', '2021-06-27 17:47:42', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066755712160, 2066617579680, '中国（香港）', 'oss-cn-hongkong.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:47:58', '2021-06-27 17:47:58', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066763098784, 2066617579680, '美国西部1（硅谷）', 'oss-us-west-1.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:48:12', '2021-06-27 17:48:12', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066774434976, 2066617579680, '美国东部1（弗吉尼亚）', 'oss-us-east-1.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:48:34', '2021-06-27 17:48:34', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066785543840, 2066617579680, '亚太东南1（新加坡）', 'oss-ap-southeast-1.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:48:56', '2021-06-27 17:48:56', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066793102496, 2066617579680, '亚太东南2（悉尼）', 'oss-ap-southeast-2.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:49:11', '2021-06-27 17:49:11', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066800109216, 2066617579680, '亚太东南3（吉隆坡）', 'oss-ap-southeast-3.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:49:24', '2021-06-27 17:49:24', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066814016672, 2066617579680, '亚太东南5（雅加达）', 'oss-ap-southeast-5.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:49:52', '2021-06-27 17:49:52', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066821073568, 2066617579680, '亚太东北1（日本）', 'oss-ap-northeast-1.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:50:05', '2021-06-27 17:50:05', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066831129760, 2066617579680, '亚太南部1（孟买）', 'oss-ap-south-1.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:50:25', '2021-06-27 17:50:25', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066838042784, 2066617579680, '欧洲中部1（法兰克福）', 'oss-eu-central-1.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:50:39', '2021-06-27 17:50:39', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066844704928, 2066617579680, '英国（伦敦）', 'oss-eu-west-1.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:50:52', '2021-06-27 17:50:52', NULL, NULL);
INSERT INTO `system_dict_data` VALUES (2066852266656, 2066617579680, '中东东部1（迪拜）', 'oss-me-east-1.aliyuncs.com', 'oss_endpoint', 0, '0', 1937003305632, NULL, '2021-06-27 17:51:06', '2021-06-27 17:51:06', NULL, NULL);

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
INSERT INTO `system_dict_type` VALUES (2066617579680, '阿里EndPoint', 'oss_endpoint', '0', 1937003305632, NULL, '2021-06-27 17:43:28', '2021-06-27 17:43:28', NULL, '阿里云OSS存储EndPoint信息列表');

SET FOREIGN_KEY_CHECKS = 1;
