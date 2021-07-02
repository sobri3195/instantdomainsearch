TRUNCATE TABLE `tlds`;

INSERT INTO `tlds` (`id`, `display_order`, `tld`, `status`) VALUES
(1, 1, 'com', 1),
(2, 2, 'net', 1),
(3, 4, 'org', 1),
(4, 5, 'biz', 1),
(5, 3, 'info', 1),
(6, 7, 'name', 1),
(7, 8, 'co', 1),
(8, 6, 'tv', 1),
(9, 10, 'in', 1),
(10, 9, 'no', 1),
(11, 11, 'us', 1),
(12, 13, 'me', 1),
(13, 12, 'am', 1),
(14, 14, 'cc', 1),
(15, 15, 'uk', 1),
(16, 16, 'ag', 1),
(17, 17, 'ru', 1),
(18, 18, 'eu', 1),
(19, 19, 'is', 1),
(20, 20, 'asia', 1),
(21, 21, 'ir', 1),
(22, 22, 'cz', 1),
(23, 23, 'de', 1),
(24, 24, 'ac', 1),
(25, 25, 'ca', 1),
(26, 26, 'ro', 1),
(27, 27, 'io', 1),
(28, 28, 'jp', 1),
(29, 29, 'ie', 1),
(30, 30, 'ch', 1),
(31, 31, 'it', 1),
(32, 32, 'se', 1),
(33, 33, 'es', 1),
(34, 34, 'mobi', 1),
(35, 35, 'im', 1),
(36, 36, 'be', 1),
(37, 38, 'aero', 1),
(38, 39, 'cn', 1),
(39, 40, 'fr', 1),
(40, 37, 'fi', 1),
(41, 41, 'dk', 1),
(42, 42, 'nu', 1),
(43, 43, 'hu', 1),
(44, 44, 'tw', 1),
(45, 45, 'pt', 1),
(46, 46, 'cl', 1),
(47, 47, 'pro', 1),
(48, 48, 'my', 1),
(49, 49, 'lu', 1),
(50, 50, 'md', 1);

ALTER TABLE `affiliates` ADD `dk` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `nu` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `hu` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `tw` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `pt` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `cl` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `pro` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `my` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `lu` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `md` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `instant_domain` ADD `dk` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `nu` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `hu` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `tw` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `pt` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `cl` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `pro` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `my` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `lu` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `md` TINYINT(1) NOT NULL ;

ALTER TABLE `affiliates` CHANGE `at` `im` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;

ALTER TABLE `instant_domain` CHANGE `at` `im` TINYINT(1) NOT NULL;

ALTER TABLE `pages` ADD `header_status` TINYINT(1) DEFAULT '1' NOT NULL ;

ALTER TABLE `pages` ADD `footer_status` TINYINT(1) DEFAULT '1' NOT NULL ;

ALTER TABLE `settings` ADD `whois_url` VARCHAR(200) DEFAULT 'http://whois.nexthon.com/whois.php?url={domain}' NOT NULL ;

UPDATE `tlds` SET `tld`='im' WHERE tld='at' ;

DROP TABLE IF EXISTS `cache_settings`;

CREATE TABLE IF NOT EXISTS `cache_settings` (
  `id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `tld_time` varchar(10) NOT NULL,
  `tld_status` tinyint(1) NOT NULL,
  `suggest_time` varchar(10) NOT NULL,
  `suggest_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

TRUNCATE TABLE `cache_settings`;

INSERT INTO `cache_settings` (`id`, `tld_time`, `tld_status`, `suggest_time`, `suggest_status`) VALUES
(2, '86400', 1, '86400', 1);