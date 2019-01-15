-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Sept 14, 2017 at 15:07 AM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `laraclassified`
--


-- payment_methods
ALTER TABLE `<<prefix>>payment_methods` CHANGE `description` `description` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;

-- posts
ALTER TABLE `<<prefix>>posts` ADD `tags` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `description`;
ALTER TABLE `<<prefix>>posts` ADD INDEX(`tags`);

-- settings
UPDATE `<<prefix>>settings` SET `key` = 'guests_can_post_ads' WHERE `key` = 'activation_guests_can_post';

UPDATE `<<prefix>>settings` SET `field`='{"name":"value","label":"Value","type":"textarea","hint":"Paste your Google Analytics (or other) tracking code here. This will be added into the footer."}' WHERE `key`='tracking_code';

INSERT INTO `<<prefix>>settings` (`key`, `name`, `value`, `description`, `field`, `parent_id`, `lft`, `rgt`, `depth`, `active`, `created_at`, `updated_at`) VALUES('guests_can_contact_seller', 'Guests can contact Sellers', '1', 'Guests can contact Sellers', '{"name":"value","label":"Activation","type":"checkbox"}', 0, 62, 63, 1, 1, NULL, '2017-09-15 08:14:08');



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;