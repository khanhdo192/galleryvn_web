/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : galleryvn

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2021-06-11 18:39:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for gvn_vtt_filters
-- ----------------------------
DROP TABLE IF EXISTS `gvn_vtt_filters`;
CREATE TABLE `gvn_vtt_filters` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count` int(11) unsigned NOT NULL DEFAULT 0,
  `parent_id` int(11) unsigned NOT NULL DEFAULT 0,
  `is_valid` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of gvn_vtt_filters
-- ----------------------------
INSERT INTO `gvn_vtt_filters` VALUES ('1', 'Phong cách', null, 'product', '8', '0', '1', '2021-06-11 18:10:30', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('2', 'Đen trắng', null, 'product', '0', '1', '1', '2021-06-11 18:10:30', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('3', 'Hiện thực', null, 'product', '0', '1', '1', '2021-06-11 18:10:30', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('4', 'Tối giản', null, 'product', '0', '1', '1', '2021-06-11 18:10:30', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('5', 'Trừu tượng', null, 'product', '0', '1', '1', '2021-06-11 18:10:30', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('6', 'Cổ điển', null, 'product', '0', '1', '1', '2021-06-11 18:10:30', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('7', 'Biểu hiện', null, 'product', '0', '1', '1', '2021-06-11 18:10:30', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('8', 'Ấn tượng', null, 'product', '0', '1', '1', '2021-06-11 18:10:30', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('9', 'Lập thể', null, 'product', '0', '1', '1', '2021-06-11 18:10:30', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('10', 'Chủ đề', null, 'product', '5', '0', '1', '2021-06-11 18:24:48', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('11', 'Chân dung', null, 'product', '0', '10', '1', '2021-06-11 18:24:48', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('12', 'Phong cảnh', null, 'product', '0', '10', '1', '2021-06-11 18:24:48', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('13', 'Tĩnh vật', null, 'product', '0', '10', '1', '2021-06-11 18:24:48', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('14', 'Xúc cảm', null, 'product', '0', '10', '1', '2021-06-11 18:24:48', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('15', 'Tôn giáo', null, 'product', '0', '10', '1', '2021-06-11 18:24:48', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('16', 'Chất liệu', null, 'product', '5', '0', '1', '2021-06-11 18:26:45', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('17', 'Sơn dầu', null, 'product', '0', '16', '1', '2021-06-11 18:26:45', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('18', 'Bút chì', null, 'product', '0', '16', '1', '2021-06-11 18:26:45', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('19', 'Màu acrylic', null, 'product', '0', '16', '1', '2021-06-11 18:26:45', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('20', 'In ấn', null, 'product', '0', '16', '1', '2021-06-11 18:26:45', '0000-00-00 00:00:00');
INSERT INTO `gvn_vtt_filters` VALUES ('21', 'Kĩ thuật số', null, 'product', '0', '16', '1', '2021-06-11 18:26:45', '0000-00-00 00:00:00');
