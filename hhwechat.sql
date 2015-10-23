/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50529
Source Host           : localhost:3306
Source Database       : hhwechat

Target Server Type    : MYSQL
Target Server Version : 50529
File Encoding         : 65001

Date: 2015-10-23 11:25:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for hhwechat_accesslog
-- ----------------------------
DROP TABLE IF EXISTS `hhwechat_accesslog`;
CREATE TABLE `hhwechat_accesslog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `data` text CHARACTER SET utf8,
  `memo` text CHARACTER SET utf8,
  `type` int(11) DEFAULT '10',
  `status` int(11) DEFAULT '10',
  `ip` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Ip address',
  `useragent` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of hhwechat_accesslog
-- ----------------------------

-- ----------------------------
-- Table structure for hhwechat_collect
-- ----------------------------
DROP TABLE IF EXISTS `hhwechat_collect`;
CREATE TABLE `hhwechat_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `codes` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `collects` int(11) DEFAULT '0',
  `complete` int(1) DEFAULT '0',
  `memo` text CHARACTER SET utf8,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `useragent` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT '10',
  `type` int(11) DEFAULT '10',
  `udate` timestamp NULL DEFAULT NULL,
  `cdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `isdelete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `status` (`status`) USING BTREE,
  KEY `codes` (`codes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of hhwechat_collect
-- ----------------------------

-- ----------------------------
-- Table structure for hhwechat_profile
-- ----------------------------
DROP TABLE IF EXISTS `hhwechat_profile`;
CREATE TABLE `hhwechat_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `num1` int(11) DEFAULT '0',
  `temp1` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `memo` text CHARACTER SET utf8,
  `status` int(11) DEFAULT '10',
  `udate` timestamp NULL DEFAULT NULL,
  `cdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `isdelete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of hhwechat_profile
-- ----------------------------

-- ----------------------------
-- Table structure for hhwechat_setting
-- ----------------------------
DROP TABLE IF EXISTS `hhwechat_setting`;
CREATE TABLE `hhwechat_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `udate` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of hhwechat_setting
-- ----------------------------
INSERT INTO `hhwechat_setting` VALUES ('1', 'access_token', '_Q3UnlzgU1Q_iYIwh_85OuNYoSLdnbyR-I_WwvYiMn5eU20trrOqg_UrrndqBOJkyQHyoNqlxVi_-ci7UPL5nWpRXa4YGT0k1JZeSoF1Has', '1', '1442215147');
INSERT INTO `hhwechat_setting` VALUES ('2', 'jsapi_ticket', 'sM4AOVdWfPE4DxkXGEs8VAJlSgAW7wSHr3pFSUgpkmNvdLlva48REmYDCXqN9sTa4nPQGF64lp9yWu_zL6DvMw', '1', '1442215147');

-- ----------------------------
-- Table structure for hhwechat_user
-- ----------------------------
DROP TABLE IF EXISTS `hhwechat_user`;
CREATE TABLE `hhwechat_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `levels` int(11) DEFAULT '1',
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `headimgurl` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `refreshtoken` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unionid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iswechat` int(11) DEFAULT '0',
  `memo` text COLLATE utf8_unicode_ci,
  `status` int(11) DEFAULT '10',
  `udate` timestamp NULL DEFAULT NULL,
  `cdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `isdelete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `openid` (`openid`),
  KEY `levels` (`levels`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of hhwechat_user
-- ----------------------------
INSERT INTO `hhwechat_user` VALUES ('1', 'admin', 'admin', '123', '99', 'admin', null, null, null, null, null, null, '0', null, '10', null, '2015-08-20 14:11:48', '0');
