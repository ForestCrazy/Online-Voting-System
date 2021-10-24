SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+07:00";

CREATE TABLE IF NOT EXISTS `candidate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `election_id` int(5) ZEROFILL NOT NULL,
  `cdd_id` int(5) NOT NULL,
  `FirstName` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci,
  `LastName` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci,
  `slogan` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `img` varchar(255),
  `score` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;