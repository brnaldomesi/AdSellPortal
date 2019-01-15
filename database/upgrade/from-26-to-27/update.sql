-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Nov 11, 2016 at 03:37 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laraclassified`
--

ALTER TABLE `<<prefix>>packs` ADD `short_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'In country language' AFTER `name`;
ALTER TABLE `<<prefix>>packs` ADD `ribbon` enum('red','orange','green') COLLATE utf8_unicode_ci DEFAULT NULL AFTER `short_name`;
ALTER TABLE `<<prefix>>packs` ADD `has_badge` tinyint(3) UNSIGNED DEFAULT '0' AFTER `ribbon`;
ALTER TABLE `<<prefix>>packs` MODIFY COLUMN `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'In country language' AFTER `has_badge`;


UPDATE `<<prefix>>packs` SET short_name='FREE', ribbon=NULL, has_badge=0 WHERE translation_of=1;
UPDATE `<<prefix>>packs` SET short_name='Urgent', ribbon='red', has_badge=0 WHERE translation_of=2;
UPDATE `<<prefix>>packs` SET short_name='Premium', ribbon='orange', has_badge=1 WHERE translation_of=3;
UPDATE `<<prefix>>packs` SET short_name='Premium+', ribbon='green', has_badge=1 WHERE translation_of=4;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;