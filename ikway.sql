-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.23-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-04-04 16:19:58
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping database structure for ikway_b
CREATE DATABASE IF NOT EXISTS `ikway` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `ikway`;


-- Dumping structure for procedure ikway_b.closest
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `closest`(IN `id` INT, IN `mylat` DOUBLE, IN `mylon` DOUBLE, IN `number` INT)
BEGIN

declare cnt int;
declare step double;

set step=0.010000;
set cnt=0;

drop temporary table if exists temp;

create temporary table temp (id_user int not null, dist double not null);

 qqq:  WHILE (cnt < number) DO
		set step=step*10;
      INSERT into temp
      (SELECT id_user,dist(mylat,mylon, lat,lon) FROM tbl_online WHERE MBRContains(LINESTRING(POINT(mylat-step,mylon-step),POINT(mylat+step,mylon+step)),ll)  and dist(mylat,mylon, lat,lon)<=(step*111));
		select count(distinct id_user) into cnt from temp;

      if (step>=180) then  leave qqq; end if;

  END WHILE qqq;

SET @s = CONCAT('select distinct * from temp join tbl_profiles on temp.id_user=tbl_profiles.user_id where id_user<>',id,' order by dist limit ',number);

PREPARE go FROM @s;
EXECUTE go;

drop temporary table temp;


END//
DELIMITER ;


-- Dumping structure for function ikway_b.dist
DELIMITER //
CREATE DEFINER=`root`@`localhost` FUNCTION `dist`(`alat1` FLOAT, `alon1` FLOAT, `alat2` FLOAT, `alon2` FLOAT) RETURNS float
BEGIN

declare R integer;
declare dLat float;
declare dLon float;
declare lat1 float;
declare lat2 float;
declare a float;
declare c float;
declare d float;

set R = 6371;
set dLat = RADIANS(alat2-alat1);
set dLon = RADIANS(alon2-alon1);
set lat1 = RADIANS(alat1);
set lat2 = RADIANS(alat2);
set a = sin(dLat/2) * sin(dLat/2) + cos(lat1) * cos(lat2) * sin(dLon/2) * sin(dLon/2);
set c=2*atan2(sqrt(a),sqrt(1-a));
set d = (R * c);

return d;


END//
DELIMITER ;


-- Dumping structure for procedure ikway_b.q
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `q`()
BEGIN

declare cnt int;
declare step double;

set step=0;
set cnt=0;

 qqq: WHILE (cnt < 5)  DO
      set step=step+1;
      set cnt=cnt+1;
      select * from online limit 1;

      if (step>=2) then leave qqq;end if;

  END WHILE qqq;





END//
DELIMITER ;


-- Dumping structure for table ikway_b.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `expire` (`expire`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- Dumping data for table ikway_b.sessions: 0 rows
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;


-- Dumping structure for table ikway_b.tbl_meetings
CREATE TABLE IF NOT EXISTS `tbl_meetings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_init` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Инициатор встречи',
  `id_reflex` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Приглашаемый',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 - новая встреча. 1 - заявка принята. 2 - заявка не принята. 3 - встреча удачно прошла. 4 - встреча не подтвердилась',
  `code_init` varchar(45) NOT NULL DEFAULT '' COMMENT 'Коды графовалидатора инициатора',
  `code_reflex` varchar(45) NOT NULL DEFAULT '' COMMENT 'Коды графовалидатора приглашаемого',
  `code_common` char(4) NOT NULL DEFAULT '' COMMENT 'Общий код графовалидаторов',
  `sel_init` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Результат выбора ГВ инициатора. 1 - да. 2 - нет',
  `sel_reflex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Результат выбора ГВ рефлексора. 1 - да. 2 - нет',
  `time_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время создания встречи',
  PRIMARY KEY (`id`),
  KEY `id_init` (`id_init`),
  KEY `id_reflex` (`id_reflex`)
) ENGINE=Aria AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 PAGE_CHECKSUM=1;

-- Dumping data for table ikway_b.tbl_meetings: 0 rows
/*!40000 ALTER TABLE `tbl_meetings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_meetings` ENABLE KEYS */;


-- Dumping structure for table ikway_b.tbl_messages
CREATE TABLE IF NOT EXISTS `tbl_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_sender` int(10) unsigned NOT NULL,
  `id_rcpt` int(10) unsigned NOT NULL,
  `text` text NOT NULL,
  `status_sender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 - отправлено. 1 - удалено.',
  `status_rcpt` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 - новое. 1 - прочитанное. 2 - удалено',
  `time_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_sender_status_sender` (`id_sender`,`status_sender`),
  KEY `id_rcpt_status_rcpt` (`id_rcpt`,`status_rcpt`),
  KEY `time_create` (`time_create`)
) ENGINE=Aria AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 PAGE_CHECKSUM=1;

-- Dumping data for table ikway_b.tbl_messages: 0 rows
/*!40000 ALTER TABLE `tbl_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_messages` ENABLE KEYS */;


-- Dumping structure for table ikway_b.tbl_migration
CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- Dumping data for table ikway_b.tbl_migration: ~3 rows (approximately)
/*!40000 ALTER TABLE `tbl_migration` DISABLE KEYS */;
INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1356135916),
	('m110805_153437_installYiiUser', 1356135937),
	('m110810_162301_userTimestampFix', 1356135938);
/*!40000 ALTER TABLE `tbl_migration` ENABLE KEYS */;


-- Dumping structure for table ikway_b.tbl_online
CREATE TABLE IF NOT EXISTS `tbl_online` (
  `id_user` int(11) NOT NULL,
  `lat` double NOT NULL,
  `lon` double NOT NULL,
  `la` int(11) NOT NULL,
  `ll` point NOT NULL,
  PRIMARY KEY (`id_user`),
  SPATIAL KEY `ll_key` (`ll`),
  KEY `la` (`la`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table ikway_b.tbl_online: 0 rows
/*!40000 ALTER TABLE `tbl_online` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_online` ENABLE KEYS */;


-- Dumping structure for table ikway_b.tbl_profiles
CREATE TABLE IF NOT EXISTS `tbl_profiles` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `ava` varchar(255) NOT NULL DEFAULT 'assets/noname.png',
  `rating` decimal(4,2) unsigned NOT NULL DEFAULT '0.00',
  `mood` int(2) NOT NULL DEFAULT '0',
  `status_text` varchar(140) NOT NULL DEFAULT 'Здесь указывается Ваш статус.',
  `vk_url` varchar(21) NOT NULL DEFAULT '',
  `fb_url` varchar(40) NOT NULL DEFAULT '',
  `tw_url` varchar(40) NOT NULL DEFAULT '',
  `age` int(2) NOT NULL DEFAULT '0',
  `sex` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  CONSTRAINT `user_profile_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table ikway_b.tbl_profiles: ~2 rows (approximately)
/*!40000 ALTER TABLE `tbl_profiles` DISABLE KEYS */;
INSERT INTO `tbl_profiles` (`user_id`, `first_name`, `last_name`, `ava`, `rating`, `mood`, `status_text`, `vk_url`, `fb_url`, `tw_url`, `age`, `sex`) VALUES
	(1, 'Administrator', 'Admin', 'assets/pic/thumb/DSC00366.JPG', 10.00, 3, 'Это новый статус-статус. Его можно менять.', 'vk.com/durov', 'facebook.com/durov', 'twitter.com/i.antoshkin', 31, 0),
	(3, 'Дмитрий', 'Виниченко', 'assets/pic/thumb/P7190710.JPG', 13.00, 1, 'Это новый статус-статус. Его можно менять.', 'vk.com/vini', 'facebook.com/vini', 'twitter.com/point', 14, 0);
/*!40000 ALTER TABLE `tbl_profiles` ENABLE KEYS */;


-- Dumping structure for table ikway_b.tbl_profiles_fields
CREATE TABLE IF NOT EXISTS `tbl_profiles_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `field_type` varchar(50) NOT NULL DEFAULT '',
  `field_size` int(3) NOT NULL DEFAULT '0',
  `field_size_min` int(3) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` text,
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` text,
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Dumping data for table ikway_b.tbl_profiles_fields: ~11 rows (approximately)
/*!40000 ALTER TABLE `tbl_profiles_fields` DISABLE KEYS */;
INSERT INTO `tbl_profiles_fields` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
	(1, 'first_name', 'First Name', 'VARCHAR', 255, 3, 2, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
	(2, 'last_name', 'Last Name', 'VARCHAR', 255, 3, 2, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 2, 3),
	(5, 'ava', 'Photo', 'VARCHAR', 255, 0, 0, '', '', '', '', '', 'UWprofilepic', '{"rawPath":"assets/pic/raw/","path":"assets/pic/thumb/","defaultPic":"http://localhost/ikway/assets/noname.png","maxRawW":"600","maxRawH":"600","thumbW":"200","thumbH":"200","maxSize":"2","types":"jpg,jpeg,png,gif"}', 0, 2),
	(6, 'rating', 'rating', 'INTEGER', 10, 0, 0, '', '', '', '', '0', '', '', 0, 0),
	(7, 'mood', 'mood', 'INTEGER', 2, 0, 0, '', '', '', '', '0', '', '', 0, 3),
	(9, 'status_text', 'status_text', 'VARCHAR', 140, 0, 0, '', '', '', '', '', '', '', 0, 3),
	(10, 'vk_url', 'vk_url', 'VARCHAR', 21, 0, 0, '', '', '', '', '', '', '', 0, 3),
	(11, 'fb_url', 'fb_url', 'VARCHAR', 40, 0, 0, '', '', '', '', '', '', '', 0, 3),
	(12, 'tw_url', 'tw_url', 'VARCHAR', 40, 0, 0, '', '', '', '', '', '', '', 0, 3),
	(13, 'age', 'age', 'INTEGER', 2, 0, 0, '', '', '', '', '0', '', '', 0, 3),
	(14, 'sex', 'sex', 'INTEGER', 1, 0, 0, '', '', '', '', '0', '', '', 0, 3);
/*!40000 ALTER TABLE `tbl_profiles_fields` ENABLE KEYS */;


-- Dumping structure for table ikway_b.tbl_users
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_username` (`username`),
  UNIQUE KEY `user_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table ikway_b.tbl_users: ~2 rows (approximately)
/*!40000 ALTER TABLE `tbl_users` DISABLE KEYS */;
INSERT INTO `tbl_users` (`id`, `username`, `password`, `email`, `activkey`, `superuser`, `status`, `create_at`, `lastvisit_at`) VALUES
	(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'webmaster@example.com', '76407027a35b5467a1cb1cc7462aeff3', 1, 1, '2012-12-22 02:25:37', '2013-04-04 01:57:11'),
	(3, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@ikway.com', '64e2f384edee375aa1a4cfc0b555d6a4', 0, 1, '2012-12-22 17:26:11', '2013-04-04 04:58:47');
/*!40000 ALTER TABLE `tbl_users` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
