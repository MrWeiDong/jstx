/*
Navicat MySQL Data Transfer

Source Server         : A--本地数据库
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : jstx

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2019-06-24 17:56:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for member
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `phone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES ('9', 'xiandan', '/static/home/images/touxian.jpg', '$2y$10$gLSK/e5Ih.NkoYnaPMY3ke5ZP5UByDIdDe1.E.1uN254FzvGnyexO', '1560828752', '1', '17688153447');
INSERT INTO `member` VALUES ('11', 'user1', '/static/home/images/touxian.jpg', '$2y$10$wa1TA1OovzZGiDXddEpYl.3SV1cWve7AI9KL4hcXRtskdHXdQrxme', '1560839140', '1', null);
INSERT INTO `member` VALUES ('13', '咸蛋超人', '/head/20190620\\\\d22fa64d360f32f511cfd63820200fed.jpeg', '$2y$10$hrfscegL/IUM/4pfSssrMuO9QHS9Wd3gg2SvJ1CkdSHaPao0K8bMW', '1561008906', '1', '17688153448');
INSERT INTO `member` VALUES ('14', '法克鱿', '/head/20190620\\\\9472068b6eab15dcd908db92f541767a.png', '$2y$10$FxTP1D8nv/vcrl6GUSytI.l0zx6S9TIq.cXkftXg.itN2ulS7nPFK', '1561011597', '1', '17688153446');
INSERT INTO `member` VALUES ('15', '张三', '/head/20190620/8bd17954743b69e4bee1017a53a8f4a1.jpg', '$2y$10$y.WaJewgINVdhrxyJCcfBeZyvnWbSZJp3Yx0I5E1.G.g9TPLQHMSu', '1561012089', '1', '17688153445');

-- ----------------------------
-- Table structure for message
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `message` text,
  `isdu` tinyint(2) DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1文本 2图片 3语音',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of message
-- ----------------------------
INSERT INTO `message` VALUES ('94', '13', '14', ':pen:#qq_44#我在彭水', '1', '1561110956', '1');
INSERT INTO `message` VALUES ('95', '14', '13', ':haha:飒飒#qq_86#', '1', '1561110965', '1');
INSERT INTO `message` VALUES ('96', '13', '14', '/uploads/chat_img_5d0ca9bdc7973.png', '1', '1561110973', '2');
INSERT INTO `message` VALUES ('97', '14', '13', '/uploads/chat_img_5d0ca9c4308e8.jpg', '1', '1561110980', '2');
INSERT INTO `message` VALUES ('98', '14', '13', ':hehe::ku:#qq_44##qq_27#', '1', '1561111086', '1');
INSERT INTO `message` VALUES ('99', '13', '14', ':yiwen:', '1', '1561111179', '1');
INSERT INTO `message` VALUES ('100', '13', '14', ':qian:', '1', '1561111234', '1');
INSERT INTO `message` VALUES ('101', '13', '14', '#qq_12#', '0', '1561355759', '1');
INSERT INTO `message` VALUES ('102', '13', '9', ':xiaonian:', '1', '1561355822', '1');
INSERT INTO `message` VALUES ('103', '9', '13', '#qq_43#', '1', '1561355833', '1');
INSERT INTO `message` VALUES ('104', '13', '15', ':shengqi:', '0', '1561365851', '1');

-- ----------------------------
-- Table structure for regcode
-- ----------------------------
DROP TABLE IF EXISTS `regcode`;
CREATE TABLE `regcode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(12) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `code` int(6) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of regcode
-- ----------------------------
INSERT INTO `regcode` VALUES ('6', '17688153448', '1', '473415', '1561002850');
INSERT INTO `regcode` VALUES ('7', '17688153446', '1', '473414', '1561002850');
INSERT INTO `regcode` VALUES ('8', '17688153445', '1', '404703', '1561011538');
