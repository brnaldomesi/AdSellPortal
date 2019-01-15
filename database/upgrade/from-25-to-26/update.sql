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

INSERT INTO `<<prefix>>settings` (`key`, `name`, `value`, `description`, `field`, `parent_id`, `lft`, `rgt`, `depth`, `active`, `created_at`, `updated_at`) 
VALUES
	('upload_max_file_size', 'Upload Max File Size', '2500', 'Upload Max File Size (in KB)', '{"name":"value","label":"Value","type":"text"}', 0, 25, 25, 1, 1, NULL, '2017-01-13 11:21:08'),
	('admin_notification', 'settings_mail_admin_notification_label', '0', 'settings_mail_admin_notification_hint', '{"name":"value","label":"Activation","type":"checkbox"}', 0, 26, 33, 1, 1, NULL, '2017-01-13 14:38:08'),
	('payment_notification', 'settings_mail_payment_notification_label', '0', 'settings_mail_payment_notification_hint', '{"name":"value","label":"Activation","type":"checkbox"}', 0, 26, 33, 1, 1, NULL, '2017-01-13 14:38:08');





/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;