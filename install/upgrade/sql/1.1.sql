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
(35, 35, 'at', 1),
(36, 36, 'be', 1),
(37, 38, 'aero', 1),
(38, 39, 'cn', 1),
(39, 40, 'fr', 1),
(40, 37, 'fi', 1);

ALTER TABLE `affiliates` ADD `ir` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `cz` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `de` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `ca` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `io` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `jp` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `ch` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `it` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `se` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `es` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `mobi` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `at` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `ro` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `be` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `cn` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `fr` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `ac` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `fi` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `ie` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `affiliates` ADD `aero` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;

ALTER TABLE `instant_domain` ADD `ir` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `cz` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `de` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `ca` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `io` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `jp` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `ch` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `it` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `se` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `es` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `mobi` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `at` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `ro` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `be` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `cn` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `fr` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `ac` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `fi` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `ie` TINYINT(1) NOT NULL ;

ALTER TABLE `instant_domain` ADD `aero` TINYINT(1) NOT NULL ;
