/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : erictpcms

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-03-21 17:35:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cms_admin
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin`;
CREATE TABLE `cms_admin` (
  `admin_id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `lastloginip` varchar(15) DEFAULT '0',
  `lastlogintime` int(10) unsigned DEFAULT '0',
  `email` varchar(40) DEFAULT '',
  `realname` varchar(40) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`admin_id`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_admin
-- ----------------------------
INSERT INTO `cms_admin` VALUES ('1', 'admin', 'd099d126030d3207ba102efa8e60630a', '127.0.0.1', '1489993613', 'eric@163.com', 'eric', '1');

-- ----------------------------
-- Table structure for cms_menu
-- ----------------------------
DROP TABLE IF EXISTS `cms_menu`;
CREATE TABLE `cms_menu` (
  `menu_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `parentid` smallint(6) NOT NULL DEFAULT '0',
  `m` varchar(20) NOT NULL DEFAULT '',
  `c` varchar(20) NOT NULL DEFAULT '',
  `f` varchar(20) NOT NULL DEFAULT '',
  `listorder` smallint(6) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`),
  KEY `listorder` (`listorder`),
  KEY `parentid` (`parentid`),
  KEY `module` (`m`,`c`,`f`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_menu
-- ----------------------------
INSERT INTO `cms_menu` VALUES ('1', '菜单管理', '0', 'admin', 'menu', 'index', '9', '1', '1');
INSERT INTO `cms_menu` VALUES ('2', '文章管理', '0', 'admin', 'content', 'index', '8', '1', '1');
INSERT INTO `cms_menu` VALUES ('3', '汽车', '0', 'home', 'index', 'index', '1', '1', '0');
INSERT INTO `cms_menu` VALUES ('4', '体育', '0', 'home', 'index', 'index', '3', '1', '0');
INSERT INTO `cms_menu` VALUES ('5', '新闻', '0', 'home', 'index', 'index', '5', '1', '0');
INSERT INTO `cms_menu` VALUES ('6', '测试菜单', '0', 'admin', 'index', 'index', '0', '-1', '1');
INSERT INTO `cms_menu` VALUES ('7', '科技', '0', 'home', 'index', 'index', '0', '1', '0');
INSERT INTO `cms_menu` VALUES ('8', '推荐位管理', '0', 'admin', 'position', 'index', '7', '1', '1');
INSERT INTO `cms_menu` VALUES ('9', '推荐位内容管理', '0', 'admin', 'positionContent', 'index', '6', '1', '1');
INSERT INTO `cms_menu` VALUES ('10', '基本管理', '0', 'admin', 'basic', 'index', '0', '1', '1');
INSERT INTO `cms_menu` VALUES ('11', '用户管理', '0', 'admin', 'admin', 'index', '2', '1', '1');

-- ----------------------------
-- Table structure for cms_news
-- ----------------------------
DROP TABLE IF EXISTS `cms_news`;
CREATE TABLE `cms_news` (
  `news_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `title` varchar(80) NOT NULL DEFAULT '',
  `small_title` varchar(30) NOT NULL DEFAULT '',
  `title_font_color` varchar(250) DEFAULT NULL COMMENT '鏍囬?棰滆壊',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `keywords` char(40) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL COMMENT '鏂囩珷鎻忚堪',
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `copyfrom` varchar(250) DEFAULT NULL COMMENT '鏉ユ簮',
  `username` char(20) NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`news_id`),
  KEY `listorder` (`listorder`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_news
-- ----------------------------
INSERT INTO `cms_news` VALUES ('1', '3', '测试文章更新', '测试', '#5674ed', '/upload/2017/03/13/58c60f26224b2.JPG', '测试', '测试一下', '0', '1', '0', 'admin', '1489375048', '1489395152', '5');
INSERT INTO `cms_news` VALUES ('2', '3', '测试2', '测试', '#5674ed', '/upload/2017/03/13/58c636a58acbe.JPG', '测试2', '测试2', '0', '1', '0', 'admin', '1489385142', '1489385142', '10');
INSERT INTO `cms_news` VALUES ('3', '4', '测试3', '测试', '#5674ed', '', '测试3', '测试3', '0', '1', '0', 'admin', '1489385173', '1489385173', '7');
INSERT INTO `cms_news` VALUES ('4', '7', 'test', '测试', '#ed568b', '', '测试', '测试', '0', '1', '0', 'admin', '1489385245', '1489385245', '5');
INSERT INTO `cms_news` VALUES ('5', '5', 'test2', 'test', '#ed568b', '', 'test', 'testtest', '0', '1', '0', 'admin', '1489385887', '1489385887', '7');
INSERT INTO `cms_news` VALUES ('6', '5', 'test3', 'test', '#5674ed', '/upload/2017/03/13/58c639a6ec0f4.JPG', 'test', 'test', '0', '1', '3', 'admin', '1489385907', '1489385907', '11');
INSERT INTO `cms_news` VALUES ('7', '5', '首页测试文章测试最大长度是多少', '测试', '#ed568b', '/upload/2017/03/15/58c8ae250f4c1.JPG', '测试', '测试测试测试', '0', '1', '3', 'admin', '1489546803', '1489560013', '22');

-- ----------------------------
-- Table structure for cms_news_content
-- ----------------------------
DROP TABLE IF EXISTS `cms_news_content`;
CREATE TABLE `cms_news_content` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` mediumint(8) unsigned NOT NULL,
  `content` mediumtext NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_news_content
-- ----------------------------
INSERT INTO `cms_news_content` VALUES ('1', '1', '&lt;p&gt;\r\n	这篇是测试文章\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	&lt;br /&gt;\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	看看是否测试成功\r\n&lt;/p&gt;', '1489375048', '1489395152');
INSERT INTO `cms_news_content` VALUES ('2', '2', '&lt;p&gt;\r\n	测试2&lt;span&gt;测试2&lt;/span&gt;\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	&lt;span&gt;&lt;span&gt;测试2&lt;/span&gt;&lt;br /&gt;\r\n&lt;/span&gt;\r\n&lt;/p&gt;', '1489385142', '1489385142');
INSERT INTO `cms_news_content` VALUES ('3', '3', '&lt;p&gt;\r\n	&lt;span&gt;测试3&lt;/span&gt;\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	&lt;span&gt;&lt;span&gt;测试3&lt;span&gt;测试3&lt;/span&gt;&lt;/span&gt;&lt;br /&gt;\r\n&lt;/span&gt;\r\n&lt;/p&gt;', '1489385173', '1489385173');
INSERT INTO `cms_news_content` VALUES ('4', '4', '&lt;span&gt;测试2&lt;/span&gt;&lt;span&gt;测试2&lt;/span&gt;&lt;span&gt;测试2&lt;/span&gt;', '1489385245', '1489385245');
INSERT INTO `cms_news_content` VALUES ('5', '5', 'testtesttest', '1489385887', '1489385887');
INSERT INTO `cms_news_content` VALUES ('6', '6', '&lt;p&gt;\r\n	test\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	testtest\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	testtesttest\r\n&lt;/p&gt;', '1489385907', '1489385907');
INSERT INTO `cms_news_content` VALUES ('7', '7', '测试测试测试测试测试', '1489546803', '1489560013');

-- ----------------------------
-- Table structure for cms_position
-- ----------------------------
DROP TABLE IF EXISTS `cms_position`;
CREATE TABLE `cms_position` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `description` char(100) DEFAULT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_position
-- ----------------------------
INSERT INTO `cms_position` VALUES ('1', '首页右下方广告位小图', '1', '推送首页右下方广告位小图2张', '0', '1489546705');
INSERT INTO `cms_position` VALUES ('2', '首页新闻小图', '1', '推送首页新闻小图3张', '0', '1489546678');
INSERT INTO `cms_position` VALUES ('3', '首页新闻大图', '1', '推送1条首页新闻大图', '0', '1489546660');

-- ----------------------------
-- Table structure for cms_position_content
-- ----------------------------
DROP TABLE IF EXISTS `cms_position_content`;
CREATE TABLE `cms_position_content` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `position_id` int(5) unsigned NOT NULL,
  `title` varchar(30) NOT NULL DEFAULT '',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(100) DEFAULT NULL,
  `news_id` mediumint(8) unsigned NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `position_id` (`position_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_position_content
-- ----------------------------
INSERT INTO `cms_position_content` VALUES ('1', '3', 'test测试', '/upload/2017/03/14/58c7857a0e025.JPG', 'http://document.thinkphp.cn/manual_3_2.html', '0', '9', '-1', '1489470879', '1489479944');
INSERT INTO `cms_position_content` VALUES ('8', '2', '测试2', '/upload/2017/03/13/58c636a58acbe.JPG', null, '2', '6', '1', '1489385142', '1489385142');
INSERT INTO `cms_position_content` VALUES ('9', '2', 'test3', '/upload/2017/03/13/58c639a6ec0f4.JPG', null, '6', '5', '1', '1489385907', '1489385907');
INSERT INTO `cms_position_content` VALUES ('7', '2', '测试文章更新', '/upload/2017/03/13/58c60f26224b2.JPG', null, '1', '8', '1', '1489375048', '1489395152');
INSERT INTO `cms_position_content` VALUES ('10', '1', '测试广告', '/upload/2017/03/14/58c797f8af462.JPG', 'http://document.thinkphp.cn/manual_3_2.html', '0', '3', '1', '1489475580', '1489475580');
INSERT INTO `cms_position_content` VALUES ('11', '1', '测试广告2', '/upload/2017/03/15/58c8addf846fd.JPG', 'http://document.thinkphp.cn/manual_3_2.html', '0', '0', '1', '1489546731', '1489546731');
INSERT INTO `cms_position_content` VALUES ('12', '3', '首页测试文章', '/upload/2017/03/15/58c8ae250f4c1.JPG', null, '7', '0', '1', '1489546803', '1489546803');
