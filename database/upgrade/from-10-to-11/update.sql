-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jun 10, 2016 at 03:30 AM
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

--
-- Truncate table before insert `advertising`
--

TRUNCATE TABLE `<<prefix>>advertising`;
--
-- Dumping data for table `advertising`
--

INSERT INTO `<<prefix>>advertising` (`id`, `slug`, `provider_name`, `tracking_code_large`, `tracking_code_medium`, `tracking_code_small`, `active`) VALUES
(1, 'top', 'Google AdSense', '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>\r\n<!-- large970x90-visualText -->\r\n<ins class="adsbygoogle"\r\n	 style="display:inline-block;width:970px;height:90px"\r\n	 data-ad-client="ca-pub-2461204719026790"\r\n	 data-ad-slot="8943644949"></ins>\r\n<script>\r\n	(adsbygoogle = window.adsbygoogle || []).push({});\r\n</script>', '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>\r\n<!-- medium728x90-visualText -->\r\n<ins class="adsbygoogle"\r\n	 style="display:inline-block;width:728px;height:90px"\r\n	 data-ad-client="ca-pub-2461204719026790"\r\n	 data-ad-slot="5818394949"></ins>\r\n<script>\r\n	(adsbygoogle = window.adsbygoogle || []).push({});\r\n</script>', '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>\r\n<!-- mobile320x100-visualText -->\r\n<ins class="adsbygoogle"\r\n	 style="display:inline-block;width:320px;height:100px"\r\n	 data-ad-client="ca-pub-2461204719026790"\r\n	 data-ad-slot="2864928545"></ins>\r\n<script>\r\n	(adsbygoogle = window.adsbygoogle || []).push({});\r\n</script>', 0),
(2, 'bottom', 'Google AdSense', '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>\r\n<!-- large970x90-visualText -->\r\n<ins class="adsbygoogle"\r\n	 style="display:inline-block;width:970px;height:90px"\r\n	 data-ad-client="ca-pub-2461204719026790"\r\n	 data-ad-slot="8943644949"></ins>\r\n<script>\r\n	(adsbygoogle = window.adsbygoogle || []).push({});\r\n</script>', '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>\r\n<!-- medium728x90-visualText -->\r\n<ins class="adsbygoogle"\r\n	 style="display:inline-block;width:728px;height:90px"\r\n	 data-ad-client="ca-pub-2461204719026790"\r\n	 data-ad-slot="5818394949"></ins>\r\n<script>\r\n	(adsbygoogle = window.adsbygoogle || []).push({});\r\n</script>', '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>\r\n<!-- mobile320x100-visualText -->\r\n<ins class="adsbygoogle"\r\n	 style="display:inline-block;width:320px;height:100px"\r\n	 data-ad-client="ca-pub-2461204719026790"\r\n	 data-ad-slot="2864928545"></ins>\r\n<script>\r\n	(adsbygoogle = window.adsbygoogle || []).push({});\r\n</script>', 0);

--
-- Truncate table before insert `settings`
--

TRUNCATE TABLE `<<prefix>>settings`;
--
-- Dumping data for table `settings`
--

INSERT INTO `<<prefix>>settings` (`id`, `key`, `name`, `value`, `description`, `field`, `parent_id`, `lft`, `rgt`, `depth`, `active`, `created_at`, `updated_at`) VALUES
(1, 'app_name', 'App Name', 'LaraClassified', 'Website name', '', 0, 2, 13, 1, 1, NULL, '2016-06-15 00:33:22'),
(2, 'app_logo', 'Logo', '', 'Website Logo', '{"name":"value","label":"Value","type":"browse"}', 1, 3, 4, 2, 1, NULL, '2016-06-14 22:27:49'),
(3, 'app_slogan', 'App Slogan', 'LaraClassified - Geo Classified Ads CMS', 'Website slogan (for Meta Title)', '', 1, 5, 6, 2, 1, NULL, '2016-06-14 22:27:49'),
(4, 'app_theme', 'Theme', '', 'Supported: blue, yellow, green, red (or empty)', '', 1, 7, 8, 2, 1, NULL, '2016-06-14 22:27:49'),
(5, 'app_email', 'Email', 'contact@larapen.com', 'The email address that all emails from the contact form will go to.', '{"name":"value","label":"Value","type":"email"}', 1, 9, 10, 2, 1, NULL, '2016-06-14 22:27:49'),
(6, 'app_phone_number', 'Phone number', NULL, 'Website phone number', '', 1, 11, 12, 2, 1, NULL, '2016-06-14 22:27:49'),
(7, 'activation_geolocation', 'Geolocation activation', '1', 'Geolocation activation', '{"name":"value","label":"Activation","type":"checkbox"}', 0, 14, 19, 1, 1, NULL, '2016-06-15 00:33:22'),
(8, 'app_default_country', 'Default Country', 'CA', 'Default country (ISO alpha-2 codes - e.g. US)', '', 7, 15, 16, 2, 1, NULL, '2016-06-14 22:27:49'),
(9, 'activation_country_flag', 'Show country flag on top', '1', 'Show country flag on top page', '{"name":"value","label":"Activation","type":"checkbox"}', 7, 17, 18, 2, 1, NULL, '2016-06-14 22:27:49'),
(10, 'activation_guests_can_post', 'Guests can post Ads', '1', 'Guest can post Ad', '{"name":"value","label":"Activation","type":"checkbox"}', 0, 20, 25, 1, 1, NULL, '2016-06-15 00:33:22'),
(11, 'require_users_activation', 'Users activation required', '1', 'Users activation required', '{"name":"value","label":"Required","type":"checkbox"}', 10, 21, 22, 2, 1, NULL, '2016-06-14 22:27:49'),
(12, 'require_ads_activation', 'Ads activation required', '0', 'Ads activation required', '{"name":"value","label":"Required","type":"checkbox"}', 10, 23, 24, 2, 1, NULL, '2016-06-14 22:27:49'),
(13, 'activation_social_login', 'Social Login Activation', '0', 'Allow users to connect via social networks', '{"name":"value","label":"Required","type":"checkbox"}', 0, 38, 39, 1, 1, NULL, '2016-06-15 00:33:22'),
(14, 'activation_facebook_comments', 'Facebook Comments activation', '0', 'Allow Facebook comments on single page', '{"name":"value","label":"Required","type":"checkbox"}', 0, 36, 37, 1, 1, NULL, '2016-06-15 00:33:22'),
(15, 'show_powered_by', 'Show Powered by', '1', 'Show Powered by infos', '{"name":"value","label":"Activation","type":"checkbox"}', 0, 26, 27, 1, 1, NULL, '2016-06-15 00:33:22'),
(16, 'google_site_verification', 'Google site verification content', NULL, 'Google site verification content', '', 0, 28, 31, 1, 1, NULL, '2016-06-15 00:33:22'),
(17, 'msvalidate', 'Bing site verification content', NULL, 'Bing site verification content', '', 18, 33, 34, 2, 1, NULL, '2016-06-14 22:28:49'),
(18, 'alexa_verify_id', 'Alexa site verification content', NULL, 'Alexa site verification content', '', 18, 35, 36, 2, 1, NULL, '2016-06-14 22:28:49'),
(19, 'activation_home_stats', 'Show Homepage Stats', '1', 'Show Homepage Stats (bottom page)', '{"name":"value","label":"Activation","type":"checkbox"}', 0, 32, 33, 1, 1, NULL, '2016-06-15 00:33:22'),
(20, 'activation_serp_left_sidebar', 'Search left sidebar activation', '0', 'Search page (Left sidebar activation)', '{"name":"value","label":"Activation","type":"checkbox"}', 16, 29, 30, 2, 0, NULL, '2016-06-15 00:33:22'),
(21, 'seo_google_analytics', 'Google Analytics''s tracking code', NULL, 'Google Analytics''s tracking code', '{"name":"value","label":"Value","type":"textarea"}', 0, 34, 35, 1, 1, NULL, '2016-06-15 00:33:22'),
(22, 'facebook_page_url', 'Facebook - Page URL', 'https://web.facebook.com/larapencom', 'Website Facebook Page URL', '', 0, 40, 47, 1, 1, NULL, '2016-06-15 00:33:22'),
(23, 'facebook_page_id', 'Facebook - Page ID', '806182476160185', 'Website Facebook Page ID (Not username)', '', 22, 41, 42, 2, 1, NULL, '2016-06-15 00:26:15'),
(24, 'facebook_client_id', 'Facebook Client ID', NULL, 'Facebook Client ID', '', 22, 43, 44, 2, 1, NULL, '2016-06-15 00:26:15'),
(25, 'facebook_client_secret', 'Facebook Client Secret', NULL, 'Facebook Client Secret', '', 22, 45, 46, 2, 1, NULL, '2016-06-15 00:26:15'),
(26, 'google_client_id', 'Google Client ID', NULL, 'Google Client ID', '', 0, 48, 49, 1, 1, NULL, '2016-06-15 00:33:22'),
(27, 'google_client_secret', 'Google Client Secret', NULL, 'Google Client Secret', '', 26, 53, 54, 2, 1, NULL, '2016-06-14 23:42:29'),
(28, 'googlemaps_key', 'Google Maps key', NULL, 'Google Maps key', '', 26, 55, 56, 2, 1, NULL, '2016-06-14 23:42:29'),
(29, 'twitter_url', 'Twitter - URL', 'https://twitter.com/larapencom', 'Website Twitter URL', '', 0, 50, 57, 1, 1, NULL, '2016-06-15 00:33:22'),
(30, 'twitter_username', 'Twitter - Username', 'larapencom', 'Website Twitter username', '', 29, 51, 52, 2, 1, NULL, '2016-06-15 00:29:26'),
(31, 'twitter_client_id', 'Twitter Client ID', NULL, 'Twitter Client ID', '', 29, 53, 54, 2, 0, NULL, '2016-06-15 00:29:26'),
(32, 'twitter_client_secret', 'Twitter Client Secret', NULL, 'Twitter Client Secret', '', 29, 55, 56, 2, 0, NULL, '2016-06-15 00:29:26'),
(33, 'activation_recaptcha', 'Recaptcha activation', '0', 'Recaptcha activation', '{"name":"value","label":"Activation","type":"checkbox"}', 0, 58, 63, 1, 1, NULL, '2016-06-15 00:33:22'),
(34, 'recaptcha_public_key', 'reCAPTCHA public key', NULL, 'reCAPTCHA public key', '', 33, 59, 60, 2, 1, NULL, '2016-06-15 00:29:26'),
(35, 'recaptcha_private_key', 'reCAPTCHA private key', NULL, 'reCAPTCHA private key', '', 33, 61, 62, 2, 1, NULL, '2016-06-15 00:29:26'),
(36, 'paypal_mode', 'PayPal mode', 'sandbox', 'PayPal mode (e.g. sandbox, live)', '', 0, 88, 95, 1, 1, NULL, '2016-06-15 00:33:22'),
(37, 'paypal_username', 'PayPal username', NULL, 'PayPal username', '', 36, 89, 90, 2, 1, NULL, '2016-06-15 00:32:06'),
(38, 'paypal_password', 'PayPal password', NULL, 'PayPal password', '', 36, 91, 92, 2, 1, NULL, '2016-06-15 00:32:06'),
(39, 'paypal_signature', 'PayPal signature', NULL, 'PayPal signature', '', 36, 93, 94, 2, 1, NULL, '2016-06-15 00:32:06'),
(40, 'mail_driver', 'Mail driver', 'smtp', 'e.g. smtp, mail, sendmail, mailgun, mandrill, ses', '', 0, 64, 75, 1, 1, NULL, '2016-06-15 00:33:22'),
(41, 'mail_host', 'Mail host', NULL, 'SMTP host', '', 40, 65, 66, 2, 1, NULL, '2016-06-15 00:31:42'),
(42, 'mail_port', 'Mail port', '25', 'SMTP port (e.g. 25, 587, ...)', '', 40, 67, 68, 2, 1, NULL, '2016-06-15 00:31:42'),
(43, 'mail_encryption', 'Mail encryption', 'tls', 'SMTP encryption (e.g. tls, ssl, starttls)', '', 40, 69, 70, 2, 1, NULL, '2016-06-15 00:31:42'),
(44, 'mail_username', 'Mail username', NULL, 'SMTP username', '', 40, 71, 72, 2, 1, NULL, '2016-06-15 00:31:42'),
(45, 'mail_password', 'Mail password', NULL, 'SMTP password', '', 40, 73, 74, 2, 1, NULL, '2016-06-15 00:31:42'),
(46, 'mailgun_domain', 'Mailgun domain', NULL, 'Mailgun domain', '', 0, 76, 79, 1, 1, NULL, '2016-06-15 00:33:22'),
(47, 'mailgun_secret', 'Mailgun secret', NULL, 'Mailgun secret', '', 46, 77, 78, 2, 1, NULL, '2016-06-15 00:31:42'),
(48, 'mandrill_secret', 'Mandrill secret', NULL, 'Mandrill secret', '', 0, 80, 81, 1, 1, NULL, '2016-06-15 00:33:22'),
(49, 'ses_key', 'SES key', NULL, 'SES key', '', 0, 82, 87, 1, 1, NULL, '2016-06-15 00:33:22'),
(50, 'ses_secret', 'SES secret', NULL, 'SES secret', '', 49, 83, 84, 2, 1, NULL, '2016-06-15 00:32:06'),
(51, 'ses_region', 'SES region', NULL, 'SES region', '', 49, 85, 86, 2, 1, NULL, '2016-06-15 00:32:06'),
(52, 'stripe_secret', 'Stripe secret', NULL, 'Stripe secret', '', 53, 97, 98, 2, 0, NULL, '2016-06-15 00:31:42'),
(53, 'stripe_key', 'Stripe key', NULL, 'Stripe key', '', 0, 96, 99, 1, 0, NULL, '2016-06-15 00:33:22'),
(54, 'sparkpost_secret', 'Sparkpost secret', NULL, 'Sparkpost secret', '', 0, 100, 101, 1, 0, NULL, '2016-06-15 00:33:22'),
(55, 'app_cache_expire', 'Cache Expire duration', '60', 'Cache Expire duration (in seconde)', '', 0, 102, 103, 1, 1, NULL, '2016-06-15 00:33:22'),
(56, 'app_cookie_expire', 'Cookie Expire duration', '2592000', 'Cookie Expire duration (in seconde)', '', 55, 111, 112, 2, 1, NULL, '2016-06-14 23:42:29'),
(57, 'activation_minify_html', 'HTML Minify activation', '0', 'Optimization - HTML Minify activation', '{"name":"value","label":"Activation","type":"checkbox"}', 55, 113, 114, 2, 1, NULL, '2016-06-14 23:42:29'),
(58, 'activation_http_cache', 'HTTP Cache activation', '0', 'Optimization - HTTP Cache activation', '{"name":"value","label":"Activation","type":"checkbox"}', 55, 115, 116, 2, 1, NULL, '2016-06-14 23:42:29');
INSERT INTO `<<prefix>>settings` (`id`, `key`, `name`, `value`, `description`, `field`, `parent_id`, `lft`, `rgt`, `depth`, `active`, `created_at`, `updated_at`)
VALUES
	(59, 'show_country_svgmap', 'Show country SVG map', '1', 'Show country SVG map on the homepage', '{\"name\":\"value\",\"label\":\"Show\",\"type\":\"checkbox\"}', 0, 200, NULL, NULL, 1, NULL, NULL),
	(60, 'ads_pictures_number', 'Ad''s photos number', '3', 'Ad''s photos number', '', NULL, 0, NULL, NULL, 1, NULL, '2016-06-15 17:31:46'),
	(61, 'show_ad_on_googlemap', 'Show Ads on Google Maps', '1', 'Show Ads on Google Maps (Single page only)', '{\"name\":\"value\",\"label\":\"Show\",\"type\":\"checkbox\"}', NULL, NULL, NULL, NULL, 1, NULL, NULL),
	(62, 'custom_css', 'Custom CSS', NULL, 'Custom CSS for your site', '{\"name\":\"value\",\"label\":\"Value\",\"type\":\"textarea\"}', NULL, NULL, NULL, NULL, 1, NULL, '2016-06-16 15:15:25');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;