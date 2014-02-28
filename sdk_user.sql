/*
Navicat MySQL Data Transfer

Source Server         : SDK_SohaStudio
Source Server Version : 50171
Source Host           : 192.168.4.170:3306
Source Database       : sdk_user

Target Server Type    : MYSQL
Target Server Version : 50171
File Encoding         : 65001

Date: 2014-02-28 14:35:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `session`
-- ----------------------------
DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `session` varchar(255) NOT NULL,
  `ip_address` int(11) DEFAULT NULL,
  `game_id` int(11) NOT NULL,
  `expired_date` datetime DEFAULT NULL,
  `game_server_id` int(11) DEFAULT NULL,
  `user_game_id` int(11) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of session
-- ----------------------------

-- ----------------------------
-- Table structure for `user_session`
-- ----------------------------
DROP TABLE IF EXISTS `user_session`;
CREATE TABLE `user_session` (
  `user_session_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `sesion_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`user_session_id`),
  KEY `sesion_id` (`sesion_id`),
  CONSTRAINT `user_session_ibfk_1` FOREIGN KEY (`sesion_id`) REFERENCES `session` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_session
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `device_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tel` int(11) DEFAULT NULL,
  `scoin` int(11) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `join_time` datetime DEFAULT NULL,
  `modified_time` date DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `inviter_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('17', 'demo', 'demo', null, null, null, null, null, null, null, null, null, '2014-01-09 17:13:05', '2014-01-09', null, null);
INSERT INTO `users` VALUES ('26', '', '123', null, 'dinhtuananh1990@gmail.com', null, null, null, null, null, null, null, '2014-01-15 17:01:21', '2014-01-15', null, null);
