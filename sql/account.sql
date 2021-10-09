SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+07:00";
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
  `LastName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(600) NOT NULL,
  `role` ENUM('admin', 'user') DEFAULT 'user',
  `email` varchar(255),
  `img_profile` varchar(255),
  `createtime` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;