/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : mathew

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-05-28 03:27:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for addon_services
-- ----------------------------
DROP TABLE IF EXISTS `addon_services`;
CREATE TABLE `addon_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(255) NOT NULL,
  `price` int(10) NOT NULL,
  `action` varchar(15) NOT NULL,
  `sort` int(11) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of addon_services
-- ----------------------------
INSERT INTO `addon_services` VALUES ('2', null, 'Professional real estate photography', 'Photographing the property with a digital SLR camera according to the rules of the hotel effect and subsequent editing of the photos according to the standards of professional presentation.', '1500', 'email/sms', null);
INSERT INTO `addon_services` VALUES ('3', null, 'Aerial video - photo tour', 'We will arrange for you an impressive video of your property from the air.', '1500', 'email/sms', null);
INSERT INTO `addon_services` VALUES ('4', null, 'Video presentation of your property', ' We will not only develop a professional video of the property for you, but also an unforgettable aerial video tour that will greatly increase your chances of successful sales.', '3000', 'email/sms', null);
INSERT INTO `addon_services` VALUES ('5', null, 'Dedicated website for the property', 'We recommend this service especially for the sale of exclusive real estate, development projects, etc', '1500', 'email/sms', null);
INSERT INTO `addon_services` VALUES ('6', null, 'Property Energy Certificate (PENB)', 'So-called. the energy label is mandatory for most of today\'s properties. PENB will be issued to you in accordance with the conditions stipulated by law. The card / label is valid for 10 years.', '3000', 'email/sms', null);
INSERT INTO `addon_services` VALUES ('7', null, 'Advocacy services', 'Advocacy safekeeping with insured guarantee & Preparation of a protocol for the final handover of the property.\r\n      Submission of contracts to the Land Registry including payment of the administrative fee.', '3999', 'email/sms', null);
INSERT INTO `addon_services` VALUES ('8', null, 'Purchase contract', 'Purchase Contract, Contract for Future Contract or, in the case of Cooperative Ownership Contract Contract for Transfer of Member Rights and Obligations in Housing Cooperative.', '3999', 'email/sms', null);
INSERT INTO `addon_services` VALUES ('9', null, 'Energy transcription', 'We will provide you with a transcription of energy suppliers, both electricity and gas', '2999', 'email/sms', null);
INSERT INTO `addon_services` VALUES ('10', null, 'Proffesional real estate agent', 'We will arrange tours through our professional real estate agent in the area. Guarantee of tour within 24 hours.', '8999', 'email/sms', null);
INSERT INTO `addon_services` VALUES ('11', null, 'Fast Sell to Real estate investors', 'We prefer to offer your property to investors or real estate funds or cooperatives.', '12999', 'email/sms', null);
INSERT INTO `addon_services` VALUES ('12', null, 'Floor plan', 'We\'ll make a visualization of the layout of your property', '4999', 'email/sms', null);

-- ----------------------------
-- Table structure for advertising
-- ----------------------------
DROP TABLE IF EXISTS `advertising`;
CREATE TABLE `advertising` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `provider_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tracking_code_large` text COLLATE utf8_unicode_ci,
  `tracking_code_medium` text COLLATE utf8_unicode_ci,
  `tracking_code_small` text COLLATE utf8_unicode_ci,
  `active` tinyint(1) unsigned DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of advertising
-- ----------------------------
INSERT INTO `advertising` VALUES ('1', 'top', 'Advert Code', '', '', '', '0');
INSERT INTO `advertising` VALUES ('2', 'bottom', 'Advert Code', '', '', '', '0');

-- ----------------------------
-- Table structure for appointments
-- ----------------------------
DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `full_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `budget` int(11) NOT NULL,
  `payment_method` enum('Paypal') COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Personal','Investor','Company') COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `from` time NOT NULL,
  `to` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of appointments
-- ----------------------------

-- ----------------------------
-- Table structure for blacklist
-- ----------------------------
DROP TABLE IF EXISTS `blacklist`;
CREATE TABLE `blacklist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('domain','email','ip','word') COLLATE utf8_unicode_ci DEFAULT NULL,
  `entry` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `type` (`type`,`entry`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blacklist
-- ----------------------------

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` mediumtext COLLATE utf8_unicode_ci,
  `expiration` int(11) DEFAULT NULL,
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of cache
-- ----------------------------

-- ----------------------------
-- Table structure for calendar
-- ----------------------------
DROP TABLE IF EXISTS `calendar`;
CREATE TABLE `calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of calendar
-- ----------------------------

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `translation_lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `translation_of` int(10) unsigned DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT '0',
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon_class` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `type` enum('classified','job-offer','job-search','not-salable') COLLATE utf8_unicode_ci DEFAULT 'classified' COMMENT 'Only select this for parent categories',
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `translation_lang` (`translation_lang`),
  KEY `translation_of` (`translation_of`),
  KEY `parent_id` (`parent_id`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=290 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('9', 'en', '162', '0', 'Real estate', 'real-estate', null, 'app/categories/skin-blue/fa-home.png', 'icon-home', '42', '65', '1', 'classified', '0');
INSERT INTO `categories` VALUES ('10', 'en', '163', '162', 'Commercial Property - Offices - Premises', 'commercial-property-offices-premises', null, null, null, '47', '48', '2', null, '0');
INSERT INTO `categories` VALUES ('11', 'en', '164', '162', 'I\'m looking for', 'im-looking-for', null, null, null, '51', '52', '2', null, '0');
INSERT INTO `categories` VALUES ('12', 'en', '165', '162', 'Roomates', 'roomates', null, null, null, '53', '54', '2', null, '0');
INSERT INTO `categories` VALUES ('13', 'en', '166', '162', 'Accommodation and Hotels', 'accommodation-and-hotels', null, null, null, '55', '56', '2', null, '0');
INSERT INTO `categories` VALUES ('14', 'en', '167', '162', 'Vacation Rental', 'vacation-rental', null, null, null, '57', '58', '2', null, '0');
INSERT INTO `categories` VALUES ('15', 'en', '168', '162', 'Garage, Parking, Farms', 'garage-parking-farms', null, null, null, '59', '60', '2', null, '0');
INSERT INTO `categories` VALUES ('16', 'en', '169', '162', 'Real Estate Services', 'real-estate-services', null, null, null, '61', '62', '2', null, '0');
INSERT INTO `categories` VALUES ('17', 'en', '170', '162', 'Rooms - Studio for Rent', 'rooms-studio-for-rent', null, null, null, '63', '64', '2', null, '0');
INSERT INTO `categories` VALUES ('18', 'en', '171', '162', 'Land for Sale, Rent', 'land-for-sale-rent', null, null, null, '49', '50', '2', null, '0');
INSERT INTO `categories` VALUES ('19', 'en', '172', '162', 'Property for sale', 'property-for-sale', null, null, null, '45', '46', '2', null, '0');
INSERT INTO `categories` VALUES ('20', 'en', '173', '162', 'Rentals', 'rentals', null, null, null, '43', '44', '2', null, '0');
INSERT INTO `categories` VALUES ('162', 'cs', '162', '0', 'Real estate', 'real-estate-cs', null, 'app/categories/skin-blue/fa-home.png', 'icon-home', '42', '65', '1', 'classified', '0');
INSERT INTO `categories` VALUES ('163', 'cs', '163', '162', 'Commercial Property - Offices - Premises', 'commercial-property-offices-premises-cs', null, null, null, '47', '48', '2', null, '0');
INSERT INTO `categories` VALUES ('164', 'cs', '164', '162', 'I\'m looking for', 'im-looking-for-cs', null, null, null, '51', '52', '2', null, '0');
INSERT INTO `categories` VALUES ('165', 'cs', '165', '162', 'Roomates', 'roomates-cs', null, null, null, '53', '54', '2', null, '0');
INSERT INTO `categories` VALUES ('166', 'cs', '166', '162', 'Accommodation and Hotels', 'accommodation-and-hotels-cs', null, null, null, '55', '56', '2', null, '0');
INSERT INTO `categories` VALUES ('167', 'cs', '167', '162', 'Vacation Rental', 'vacation-rental-cs', null, null, null, '57', '58', '2', null, '0');
INSERT INTO `categories` VALUES ('168', 'cs', '168', '162', 'Garage, Parking, Farms', 'garage-parking-farms-cs', null, null, null, '59', '60', '2', null, '0');
INSERT INTO `categories` VALUES ('169', 'cs', '169', '162', 'Real Estate Services', 'real-estate-services-cs', null, null, null, '61', '62', '2', null, '0');
INSERT INTO `categories` VALUES ('170', 'cs', '170', '162', 'Rooms - Studio for Rent', 'rooms-studio-for-rent-cs', null, null, null, '63', '64', '2', null, '0');
INSERT INTO `categories` VALUES ('171', 'cs', '171', '162', 'Land for Sale, Rent', 'land-for-sale-rent-cs', null, null, null, '49', '50', '2', null, '0');
INSERT INTO `categories` VALUES ('172', 'cs', '172', '162', 'Property for sale', 'property-for-sale-cs', null, null, null, '45', '46', '2', null, '0');
INSERT INTO `categories` VALUES ('173', 'cs', '173', '162', 'Rentals', 'rentals-cs', null, null, null, '43', '44', '2', null, '0');
INSERT INTO `categories` VALUES ('174', 'en', '175', '0', 'Byty', 'byty', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('175', 'cs', '175', '0', 'Byty', 'byty-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('176', 'en', '177', '0', 'Domy', 'domy', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('177', 'cs', '177', '0', 'Domy', 'domy-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('178', 'en', '179', '0', 'Pozemky', 'pozemky', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('179', 'cs', '179', '0', 'Pozemky', 'pozemky-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('180', 'en', '181', '0', 'Komerční', 'komercni', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('181', 'cs', '181', '0', 'Komerční', 'komercni-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('182', 'en', '183', '0', 'Ostatní', 'ostatni', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('183', 'cs', '183', '0', 'Ostatní', 'ostatni-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('184', 'en', '185', '183', 'Chaty', 'chaty', null, null, null, null, null, null, null, '1');
INSERT INTO `categories` VALUES ('185', 'cs', '185', '183', 'Chaty', 'chaty-cs', null, null, null, null, null, null, null, '1');
INSERT INTO `categories` VALUES ('186', 'en', '187', '183', 'Garáže', 'garaze', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('187', 'cs', '187', '183', 'Garáže', 'garaze-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('188', 'en', '189', '183', 'Historické objekty', 'historicke-objekty', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('189', 'cs', '189', '183', 'Historické objekty', 'historicke-objekty-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('190', 'en', '191', '183', 'Jiný', 'jiny', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('191', 'cs', '191', '183', 'Jiný', 'jiny-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('192', 'en', '193', '183', 'Chalupy', 'chalupy', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('193', 'cs', '193', '183', 'Chalupy', 'chalupy-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('194', 'en', '195', '183', 'Zemědělské usedlosti', 'zemedelske-usedlosti', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('195', 'cs', '195', '183', 'Zemědělské usedlosti', 'zemedelske-usedlosti-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('196', 'en', '197', '183', 'Objekty obč. vybavenosti', 'objekty-obc-vybavenosti', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('197', 'cs', '197', '183', 'Objekty obč. vybavenosti', 'objekty-obc-vybavenosti-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('198', 'en', '199', '183', 'Rybníky', 'rybniky', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('199', 'cs', '199', '183', 'Rybníky', 'rybniky-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('200', 'en', '201', '183', 'Vinný sklep', 'vinny-sklep', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('201', 'cs', '201', '183', 'Vinný sklep', 'vinny-sklep-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('202', 'en', '203', '183', 'Půdní prostor', 'pudni-prostor', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('203', 'cs', '203', '183', 'Půdní prostor', 'pudni-prostor-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('204', 'en', '205', '183', 'Garážové stání', 'garazove-stani', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('205', 'cs', '205', '183', 'Garážové stání', 'garazove-stani-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('206', 'en', '207', '183', 'Mobilheim', 'mobilheim', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('207', 'cs', '207', '183', 'Mobilheim', 'mobilheim-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('208', 'en', '209', '181', 'Kanceláře', 'kancelare', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('209', 'cs', '209', '181', 'Kanceláře', 'kancelare-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('210', 'en', '211', '181', 'Sklady', 'sklady', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('211', 'cs', '211', '181', 'Sklady', 'sklady-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('212', 'en', '213', '181', 'Výroba', 'vyroba', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('213', 'cs', '213', '181', 'Výroba', 'vyroba-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('214', 'en', '215', '181', 'Obchodní prostory', 'obchodni-prostory', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('215', 'cs', '215', '181', 'Obchodní prostory', 'obchodni-prostory-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('216', 'en', '217', '181', 'Ubytování', 'ubytovani', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('217', 'cs', '217', '181', 'Ubytování', 'ubytovani-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('218', 'en', '219', '181', 'Restaurace', 'restaurace', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('219', 'cs', '219', '181', 'Restaurace', 'restaurace-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('220', 'en', '221', '181', 'Zemědělské objekty', 'zemedelske-objekty', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('221', 'cs', '221', '181', 'Zemědělské objekty', 'zemedelske-objekty-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('222', 'en', '223', '181', 'Jiný', 'jiny-1', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('223', 'cs', '223', '181', 'Jiný', 'jiny-1-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('224', 'en', '225', '181', 'Virtuální kancelář', 'virtualni-kancelar', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('225', 'cs', '225', '181', 'Virtuální kancelář', 'virtualni-kancelar-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('226', 'en', '227', '179', 'Pro komerční výstavbu', 'pro-komercni-vystavbu', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('227', 'cs', '227', '179', 'Pro komerční výstavbu', 'pro-komercni-vystavbu-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('228', 'en', '229', '179', 'Pro bydlení', 'pro-bydleni', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('229', 'cs', '229', '179', 'Pro bydlení', 'pro-bydleni-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('230', 'en', '231', '179', 'Zemědělská půda', 'zemedelska-puda', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('231', 'cs', '231', '179', 'Zemědělská půda', 'zemedelska-puda-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('232', 'en', '233', '179', 'Les', 'les', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('233', 'cs', '233', '179', 'Les', 'les-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('234', 'en', '235', '179', 'Trvalý travní porost', 'trvaly-travni-porost', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('235', 'cs', '235', '179', 'Trvalý travní porost', 'trvaly-travni-porost-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('236', 'en', '237', '179', 'Zahrada', 'zahrada', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('237', 'cs', '237', '179', 'Zahrada', 'zahrada-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('238', 'en', '239', '179', 'Ostatní', 'ostatni-1', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('239', 'cs', '239', '179', 'Ostatní', 'ostatni-1-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('240', 'en', '241', '179', 'Sady/Vinice', 'sady-vinice', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('241', 'cs', '241', '179', 'Sady/Vinice', 'sady-vinice-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('242', 'en', '243', '177', 'Rodinný', 'rodinny', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('243', 'cs', '243', '177', 'Rodinný', 'rodinny-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('244', 'en', '245', '177', 'Činžovní', 'cinzovni', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('245', 'cs', '245', '177', 'Činžovní', 'cinzovni-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('246', 'en', '247', '177', 'Vily', 'vily', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('247', 'cs', '247', '177', 'Vily', 'vily-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('248', 'en', '249', '177', 'Na klíč', 'na-klic', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('249', 'cs', '249', '177', 'Na klíč', 'na-klic-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('250', 'en', '251', '177', 'Dřevostavby', 'drevostavby', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('251', 'cs', '251', '177', 'Dřevostavby', 'drevostavby-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('252', 'en', '253', '177', 'Nízkoenergetické', 'nizkoenergeticke', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('253', 'cs', '253', '177', 'Nízkoenergetické', 'nizkoenergeticke-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('254', 'en', '255', '175', 'Garsonka', 'garsonka', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('255', 'cs', '255', '175', 'Garsonka', 'garsonka-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('256', 'en', '257', '175', '1+kk', '1-kk', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('257', 'cs', '257', '175', '1+kk', '1-kk-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('258', 'en', '259', '175', '1+1', '1-1', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('259', 'cs', '259', '175', '1+1', '1-1-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('260', 'en', '261', '175', '2+kk', '2-kk', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('261', 'cs', '261', '175', '2+kk', '2-kk-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('262', 'en', '263', '175', '2+1', '2-1', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('263', 'cs', '263', '175', '2+1', '2-1-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('264', 'en', '265', '175', '3+kk', '3-kk', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('265', 'cs', '265', '175', '3+kk', '3-kk-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('266', 'en', '267', '175', '3+1', '3-1', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('267', 'cs', '267', '175', '3+1', '3-1-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('268', 'en', '269', '175', '4+kk', '4-kk', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('269', 'cs', '269', '175', '4+kk', '4-kk-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('270', 'en', '271', '175', '4+1', '4-1', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('271', 'cs', '271', '175', '4+1', '4-1-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('272', 'en', '273', '175', '5+kk', '5-kk', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('273', 'cs', '273', '175', '5+kk', '5-kk-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('274', 'en', '275', '175', '5+1', '5-1', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('275', 'cs', '275', '175', '5+1', '5-1-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('276', 'en', '277', '175', '6+kk', '6-kk', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('277', 'cs', '277', '175', '6+kk', '6-kk-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('278', 'en', '279', '175', '6+1', '6-1', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('279', 'cs', '279', '175', '6+1', '6-1-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('280', 'en', '281', '175', '7+kk', '7-kk', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('281', 'cs', '281', '175', '7+kk', '7-kk-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('282', 'en', '283', '175', '7+1', '7-1', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('283', 'cs', '283', '175', '7+1', '7-1-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('284', 'en', '285', '175', 'Atypický', 'atypicky', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('285', 'cs', '285', '175', 'Atypický', 'atypicky-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('286', 'en', '287', '175', 'Jiný', 'jiny-2', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('287', 'cs', '287', '175', 'Jiný', 'jiny-2-cs', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('288', 'en', '289', '175', 'Pokoj', 'pokoj', null, null, null, null, null, null, 'classified', '1');
INSERT INTO `categories` VALUES ('289', 'cs', '289', '175', 'Pokoj', 'pokoj-cs', null, null, null, null, null, null, 'classified', '1');

-- ----------------------------
-- Table structure for category_field
-- ----------------------------
DROP TABLE IF EXISTS `category_field`;
CREATE TABLE `category_field` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(60) unsigned DEFAULT NULL,
  `field_id` int(10) unsigned DEFAULT NULL,
  `disabled_in_subcategories` tinyint(1) unsigned DEFAULT '0',
  `parent_id` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `categories` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_id` (`category_id`,`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of category_field
-- ----------------------------
INSERT INTO `category_field` VALUES ('21', '175', '49', '0', '0', '24', '25', '1', '');
INSERT INTO `category_field` VALUES ('23', '175', '55', '0', '0', '22', '23', '1', '');
INSERT INTO `category_field` VALUES ('24', '175', '32', '0', '0', '26', '27', '1', '177');
INSERT INTO `category_field` VALUES ('33', '175', '71', '0', '0', '28', '29', '1', '');
INSERT INTO `category_field` VALUES ('34', '175', '73', '0', '0', '32', '33', '1', '');
INSERT INTO `category_field` VALUES ('35', '175', '75', '0', '0', '30', '31', '1', '');
INSERT INTO `category_field` VALUES ('36', '175', '77', '0', '0', '34', '35', '1', '');
INSERT INTO `category_field` VALUES ('37', '175', '87', '0', '0', '5', '6', '1', '175 177 179 181 183 ');
INSERT INTO `category_field` VALUES ('39', '175', '85', '0', '0', '3', '4', '1', '175 177 179 181 183 ');
INSERT INTO `category_field` VALUES ('40', '175', '83', '0', '0', '2', '3', '1', '175 177 179 181 183 ');
INSERT INTO `category_field` VALUES ('41', '175', '81', '0', '0', '1', '2', '1', '175 177 179 181 183 ');
INSERT INTO `category_field` VALUES ('44', '175', '89', '0', '0', '46', '47', '1', '');
INSERT INTO `category_field` VALUES ('45', '175', '91', '0', '0', '43', '44', '1', '');
INSERT INTO `category_field` VALUES ('46', '175', '93', '0', '0', '44', '45', '1', '177');
INSERT INTO `category_field` VALUES ('47', '175', '95', '0', '0', '8', '9', '1', '');
INSERT INTO `category_field` VALUES ('48', '175', '97', '0', '0', '10', '11', '1', '');
INSERT INTO `category_field` VALUES ('49', '175', '99', '0', '0', '12', '13', '1', '');
INSERT INTO `category_field` VALUES ('50', '175', '101', '0', '0', '14', '15', '1', '');
INSERT INTO `category_field` VALUES ('51', '175', '103', '0', '0', '16', '17', '1', '');
INSERT INTO `category_field` VALUES ('52', '175', '107', '0', '0', '18', '19', '1', '');
INSERT INTO `category_field` VALUES ('53', '175', '109', '0', '0', '20', '21', '1', '175 177 179 181 183 ');
INSERT INTO `category_field` VALUES ('54', '175', '113', '0', '0', '45', '46', '1', '175 177 179 181 183 ');
INSERT INTO `category_field` VALUES ('55', '175', '115', '0', null, null, null, null, '');
INSERT INTO `category_field` VALUES ('56', '175', '53', '0', null, null, null, null, '');

-- ----------------------------
-- Table structure for cities
-- ----------------------------
DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `country_code` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'ISO-3166 2-letter country code, 2 characters',
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'name of geographical point (utf8) varchar(200)',
  `asciiname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'name of geographical point in plain ascii characters, varchar(200)',
  `latitude` float DEFAULT NULL COMMENT 'latitude in decimal degrees (wgs84)',
  `longitude` float DEFAULT NULL COMMENT 'longitude in decimal degrees (wgs84)',
  `feature_class` char(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'see http://www.geonames.org/export/codes.html, char(1)',
  `feature_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'see http://www.geonames.org/export/codes.html, varchar(10)',
  `subadmin1_code` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'fipscode (subject to change to iso code), see exceptions below, see file admin1Codes.txt for display names of this code; varchar(20)',
  `subadmin2_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'code for the second administrative division, a county in the US, see file admin2Codes.txt; varchar(80)',
  `population` bigint(20) DEFAULT NULL COMMENT 'bigint (4 byte int)',
  `time_zone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'the timezone id (see file timeZone.txt)',
  `active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country_code` (`country_code`),
  KEY `name` (`name`),
  KEY `subadmin1_code` (`subadmin1_code`),
  KEY `subadmin2_code` (`subadmin2_code`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of cities
-- ----------------------------
INSERT INTO `cities` VALUES ('3061284', 'CZ', 'Dvůr Králové nad Labem', 'Dvur Kralove nad Labem', '50.4317', '15.814', 'P', 'PPL', 'CZ.82', 'CZ.82.0525', '16150', 'Europe/Prague', '1', '2017-01-27 07:00:00', '2017-01-27 07:00:00');
INSERT INTO `cities` VALUES ('3061327', 'CZ', 'Zubří', 'Zubri', '49.466', '18.0925', 'P', 'PPL', 'CZ.90', 'CZ.90.0723', '5409', 'Europe/Prague', '1', '2017-02-03 07:00:00', '2017-02-03 07:00:00');
INSERT INTO `cities` VALUES ('3061344', 'CZ', 'Znojmo', 'Znojmo', '48.8555', '16.0488', 'P', 'PPL', 'CZ.78', 'CZ.78.0627', '35280', 'Europe/Prague', '1', '2015-11-13 07:00:00', '2015-11-13 07:00:00');
INSERT INTO `cities` VALUES ('3061370', 'CZ', 'Zlín', 'Zlin', '49.2265', '17.6707', 'P', 'PPLA', 'CZ.90', 'CZ.90.0724', '78759', 'Europe/Prague', '1', '2014-07-21 07:00:00', '2014-07-21 07:00:00');
INSERT INTO `cities` VALUES ('3061562', 'CZ', 'Železný Brod', 'Zelezny Brod', '50.6427', '15.2541', 'P', 'PPL', 'CZ.83', 'CZ.83.0512', '6442', 'Europe/Prague', '1', '2017-01-30 07:00:00', '2017-01-30 07:00:00');
INSERT INTO `cities` VALUES ('3061692', 'CZ', 'Žďár nad Sázavou Druhy', 'Zd\'ar nad Sazavou Druhy', '49.5873', '15.9321', 'P', 'PPLX', 'CZ.80', 'CZ.80.0615', '23996', 'Europe/Prague', '1', '2017-01-25 07:00:00', '2017-01-25 07:00:00');
INSERT INTO `cities` VALUES ('3061695', 'CZ', 'Žďár nad Sázavou', 'Zd\'ar nad Sazavou', '49.5626', '15.9392', 'P', 'PPL', 'CZ.80', 'CZ.80.0615', '24030', 'Europe/Prague', '1', '2015-02-06 07:00:00', '2015-02-06 07:00:00');
INSERT INTO `cities` VALUES ('3061822', 'CZ', 'Žatec', 'Zatec', '50.3272', '13.5458', 'P', 'PPL', 'CZ.89', 'CZ.89.0424', '19607', 'Europe/Prague', '1', '2017-04-06 07:00:00', '2017-04-06 07:00:00');
INSERT INTO `cities` VALUES ('3061888', 'CZ', 'Žamberk', 'Zamberk', '50.086', '16.4674', 'P', 'PPL', 'CZ.86', 'CZ.86.0534', '6082', 'Europe/Prague', '1', '2017-02-07 07:00:00', '2017-02-07 07:00:00');
INSERT INTO `cities` VALUES ('3062111', 'CZ', 'Zábřeh', 'Zabreh', '49.8826', '16.8722', 'P', 'PPL', 'CZ.84', 'CZ.84.0715', '14360', 'Europe/Prague', '1', '2017-01-31 07:00:00', '2017-01-31 07:00:00');
INSERT INTO `cities` VALUES ('3062214', 'CZ', 'Vysoké Mýto', 'Vysoke Myto', '49.9532', '16.1617', 'P', 'PPL', 'CZ.86', 'CZ.86.0532', '12293', 'Europe/Prague', '1', '2012-11-26 07:00:00', '2012-11-26 07:00:00');
INSERT INTO `cities` VALUES ('3062257', 'CZ', 'Vysočany', 'Vysocany', '50.1094', '14.5167', 'P', 'PPLX', 'CZ.52', 'CZ.52.8378777', '11646', 'Europe/Prague', '1', '2013-09-29 07:00:00', '2013-09-29 07:00:00');
INSERT INTO `cities` VALUES ('3062283', 'CZ', 'Vyškov', 'Vyskov', '49.2775', '16.999', 'P', 'PPL', 'CZ.78', 'CZ.78.0626', '22265', 'Europe/Prague', '1', '2013-01-04 07:00:00', '2013-01-04 07:00:00');
INSERT INTO `cities` VALUES ('3062339', 'CZ', 'Vsetín', 'Vsetin', '49.3387', '17.9962', 'P', 'PPL', 'CZ.90', 'CZ.90.0723', '28575', 'Europe/Prague', '1', '2012-12-19 07:00:00', '2012-12-19 07:00:00');
INSERT INTO `cities` VALUES ('3062439', 'CZ', 'Vrchlabí', 'Vrchlabi', '50.627', '15.6094', 'P', 'PPL', 'CZ.82', 'CZ.82.0525', '12898', 'Europe/Prague', '1', '2012-12-10 07:00:00', '2012-12-10 07:00:00');
INSERT INTO `cities` VALUES ('3062446', 'CZ', 'Vrbno pod Pradědem', 'Vrbno pod Pradedem', '50.1209', '17.3832', 'P', 'PPL', 'CZ.85', 'CZ.85.0801', '6072', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3062497', 'CZ', 'Vratimov', 'Vratimov', '49.77', '18.3102', 'P', 'PPL', 'CZ.85', 'CZ.85.0806', '6378', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3062642', 'CZ', 'Vodňany', 'Vodnany', '49.1479', '14.1751', 'P', 'PPL', 'CZ.79', 'CZ.79.0316', '6687', 'Europe/Prague', '1', '2017-01-23 07:00:00', '2017-01-23 07:00:00');
INSERT INTO `cities` VALUES ('3062759', 'CZ', 'Vlašim', 'Vlasim', '49.7063', '14.8988', 'P', 'PPL', 'CZ.88', 'CZ.88.0201', '12225', 'Europe/Prague', '1', '2017-02-09 07:00:00', '2017-02-09 07:00:00');
INSERT INTO `cities` VALUES ('3062811', 'CZ', 'Vítkov', 'Vitkov', '49.7744', '17.7494', 'P', 'PPL', 'CZ.85', 'CZ.85.0805', '6202', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3062888', 'CZ', 'Vimperk', 'Vimperk', '49.0586', '13.7829', 'P', 'PPL', 'CZ.79', 'CZ.79.0315', '8043', 'Europe/Prague', '1', '2007-09-30 07:00:00', '2007-09-30 07:00:00');
INSERT INTO `cities` VALUES ('3063032', 'CZ', 'Veselí nad Moravou', 'Veseli nad Moravou', '48.9536', '17.3765', 'P', 'PPL', 'CZ.78', 'CZ.78.0625', '12081', 'Europe/Prague', '1', '2017-01-18 07:00:00', '2017-01-18 07:00:00');
INSERT INTO `cities` VALUES ('3063033', 'CZ', 'Veselí nad Lužnicí', 'Veseli nad Luznici', '49.1843', '14.6973', 'P', 'PPL', 'CZ.79', 'CZ.79.0317', '6534', 'Europe/Prague', '1', '2013-01-15 07:00:00', '2013-01-15 07:00:00');
INSERT INTO `cities` VALUES ('3063196', 'CZ', 'Velké Meziříčí', 'Velke Mezirici', '49.3552', '16.0122', 'P', 'PPL', 'CZ.80', 'CZ.80.0615', '11753', 'Europe/Prague', '1', '2011-04-17 07:00:00', '2011-04-17 07:00:00');
INSERT INTO `cities` VALUES ('3063375', 'CZ', 'Varnsdorf', 'Varnsdorf', '50.9115', '14.6182', 'P', 'PPL', 'CZ.89', 'CZ.89.0421', '15895', 'Europe/Prague', '1', '2017-02-06 07:00:00', '2017-02-06 07:00:00');
INSERT INTO `cities` VALUES ('3063447', 'CZ', 'Valašské Meziříčí', 'Valasske Mezirici', '49.4718', '17.9711', 'P', 'PPL', 'CZ.90', 'CZ.90.0723', '27481', 'Europe/Prague', '1', '2017-02-03 07:00:00', '2017-02-03 07:00:00');
INSERT INTO `cities` VALUES ('3063448', 'CZ', 'Valašské Klobouky', 'Valasske Klobouky', '49.1406', '18.0076', 'P', 'PPL', 'CZ.90', 'CZ.90.0724', '5201', 'Europe/Prague', '1', '2017-02-03 07:00:00', '2017-02-03 07:00:00');
INSERT INTO `cities` VALUES ('3063546', 'CZ', 'Ústí nad Orlicí', 'Usti nad Orlici', '49.9739', '16.3936', 'P', 'PPL', 'CZ.86', 'CZ.86.0534', '15151', 'Europe/Prague', '1', '2007-10-01 07:00:00', '2007-10-01 07:00:00');
INSERT INTO `cities` VALUES ('3063548', 'CZ', 'Ústí nad Labem', 'Usti nad Labem', '50.6607', '14.0323', 'P', 'PPLA', 'CZ.89', 'CZ.89.0427', '94105', 'Europe/Prague', '1', '2014-03-07 07:00:00', '2014-03-07 07:00:00');
INSERT INTO `cities` VALUES ('3063590', 'CZ', 'Úpice', 'Upice', '50.5124', '16.0161', 'P', 'PPL', 'CZ.82', 'CZ.82.0525', '5959', 'Europe/Prague', '1', '2017-01-27 07:00:00', '2017-01-27 07:00:00');
INSERT INTO `cities` VALUES ('3063596', 'CZ', 'Uničov', 'Unicov', '49.7709', '17.1214', 'P', 'PPL', 'CZ.84', 'CZ.84.0712', '12385', 'Europe/Prague', '1', '2013-01-03 07:00:00', '2013-01-03 07:00:00');
INSERT INTO `cities` VALUES ('3063736', 'CZ', 'Uherský Brod', 'Uhersky Brod', '49.0251', '17.6472', 'P', 'PPL', 'CZ.90', 'CZ.90.0722', '17508', 'Europe/Prague', '1', '2015-11-19 07:00:00', '2015-11-19 07:00:00');
INSERT INTO `cities` VALUES ('3063739', 'CZ', 'Uherské Hradiště', 'Uherske Hradiste', '49.0698', '17.4597', 'P', 'PPL', 'CZ.90', 'CZ.90.0722', '26421', 'Europe/Prague', '1', '2017-07-13 07:00:00', '2017-07-13 07:00:00');
INSERT INTO `cities` VALUES ('3063794', 'CZ', 'Týn nad Vltavou', 'Tyn nad Vltavou', '49.2234', '14.4206', 'P', 'PPL', 'CZ.79', 'CZ.79.0311', '8296', 'Europe/Prague', '1', '2017-01-19 07:00:00', '2017-01-19 07:00:00');
INSERT INTO `cities` VALUES ('3063797', 'CZ', 'Týniště nad Orlicí', 'Tyniste nad Orlici', '50.1514', '16.0777', 'P', 'PPL', 'CZ.82', 'CZ.82.0524', '6342', 'Europe/Prague', '1', '2017-01-27 07:00:00', '2017-01-27 07:00:00');
INSERT INTO `cities` VALUES ('3063804', 'CZ', 'Týnec nad Sázavou', 'Tynec nad Sazavou', '49.8335', '14.5898', 'P', 'PPL', 'CZ.88', 'CZ.88.0201', '5165', 'Europe/Prague', '1', '2017-02-09 07:00:00', '2017-02-09 07:00:00');
INSERT INTO `cities` VALUES ('3063853', 'CZ', 'Turnov', 'Turnov', '50.5836', '15.1519', 'P', 'PPL', 'CZ.83', 'CZ.83.0514', '14507', 'Europe/Prague', '1', '2013-01-04 07:00:00', '2013-01-04 07:00:00');
INSERT INTO `cities` VALUES ('3063907', 'CZ', 'Trutnov', 'Trutnov', '50.561', '15.9127', 'P', 'PPL', 'CZ.82', 'CZ.82.0525', '31398', 'Europe/Prague', '1', '2012-12-13 07:00:00', '2012-12-13 07:00:00');
INSERT INTO `cities` VALUES ('3064000', 'CZ', 'Třinec', 'Trinec', '49.6776', '18.6708', 'P', 'PPL', 'CZ.85', 'CZ.85.0802', '38415', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3064029', 'CZ', 'Třešť', 'Trest\'', '49.2909', '15.4821', 'P', 'PPL', 'CZ.80', 'CZ.80.0612', '5979', 'Europe/Prague', '1', '2012-12-14 07:00:00', '2012-12-14 07:00:00');
INSERT INTO `cities` VALUES ('3064079', 'CZ', 'Třeboň', 'Trebon', '49.0036', '14.7706', 'P', 'PPL', 'CZ.79', 'CZ.79.0313', '8862', 'Europe/Prague', '1', '2013-01-04 07:00:00', '2013-01-04 07:00:00');
INSERT INTO `cities` VALUES ('3064104', 'CZ', 'Třebíč', 'Trebic', '49.2149', '15.8817', 'P', 'PPL', 'CZ.80', 'CZ.80.0614', '38785', 'Europe/Prague', '1', '2013-01-04 07:00:00', '2013-01-04 07:00:00');
INSERT INTO `cities` VALUES ('3064122', 'CZ', 'Třebechovice pod Orebem', 'Trebechovice pod Orebem', '50.201', '15.9922', 'P', 'PPL', 'CZ.82', 'CZ.82.0521', '5611', 'Europe/Prague', '1', '2017-01-26 07:00:00', '2017-01-26 07:00:00');
INSERT INTO `cities` VALUES ('3064211', 'CZ', 'Tišnov', 'Tisnov', '49.3487', '16.4244', 'P', 'PPL', 'CZ.78', 'CZ.78.0623', '8227', 'Europe/Prague', '1', '2017-01-18 07:00:00', '2017-01-18 07:00:00');
INSERT INTO `cities` VALUES ('3064288', 'CZ', 'Teplice', 'Teplice', '50.6404', '13.8245', 'P', 'PPL', 'CZ.89', 'CZ.89.0426', '51223', 'Europe/Prague', '1', '2015-11-13 07:00:00', '2015-11-13 07:00:00');
INSERT INTO `cities` VALUES ('3064316', 'CZ', 'Telč', 'Telc', '49.1842', '15.4528', 'P', 'PPL', 'CZ.80', 'CZ.80.0612', '5883', 'Europe/Prague', '1', '2012-12-14 07:00:00', '2012-12-14 07:00:00');
INSERT INTO `cities` VALUES ('3064358', 'CZ', 'Tanvald', 'Tanvald', '50.7374', '15.3059', 'P', 'PPL', 'CZ.83', 'CZ.83.0512', '6921', 'Europe/Prague', '1', '2017-02-15 07:00:00', '2017-02-15 07:00:00');
INSERT INTO `cities` VALUES ('3064373', 'CZ', 'Tachov', 'Tachov', '49.7953', '12.6336', 'P', 'PPL', 'CZ.87', 'CZ.87.0327', '12640', 'Europe/Prague', '1', '2013-01-03 07:00:00', '2013-01-03 07:00:00');
INSERT INTO `cities` VALUES ('3064379', 'CZ', 'Tábor', 'Tabor', '49.4144', '14.6578', 'P', 'PPL', 'CZ.79', 'CZ.79.0317', '36264', 'Europe/Prague', '1', '2007-11-05 07:00:00', '2007-11-05 07:00:00');
INSERT INTO `cities` VALUES ('3064454', 'CZ', 'Svitavy', 'Svitavy', '49.7559', '16.4683', 'P', 'PPL', 'CZ.86', 'CZ.86.0533', '17427', 'Europe/Prague', '1', '2015-11-13 07:00:00', '2015-11-13 07:00:00');
INSERT INTO `cities` VALUES ('3064510', 'CZ', 'Světlá nad Sázavou', 'Svetla nad Sazavou', '49.668', '15.4039', 'P', 'PPL', 'CZ.80', 'CZ.80.0611', '7037', 'Europe/Prague', '1', '2013-01-17 07:00:00', '2013-01-17 07:00:00');
INSERT INTO `cities` VALUES ('3064662', 'CZ', 'Sušice', 'Susice', '49.2311', '13.5202', 'P', 'PPL', 'CZ.87', 'CZ.87.0322', '11483', 'Europe/Prague', '1', '2012-12-18 07:00:00', '2012-12-18 07:00:00');
INSERT INTO `cities` VALUES ('3064673', 'CZ', 'Šumperk', 'Sumperk', '49.9653', '16.9706', 'P', 'PPL', 'CZ.84', 'CZ.84.0715', '28768', 'Europe/Prague', '1', '2012-12-10 07:00:00', '2012-12-10 07:00:00');
INSERT INTO `cities` VALUES ('3064807', 'CZ', 'Studénka', 'Studenka', '49.7234', '18.0785', 'P', 'PPL', 'CZ.85', 'CZ.85.0804', '10341', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3064894', 'CZ', 'Střížkov', 'Strizkov', '50.1267', '14.4936', 'P', 'PPLX', 'CZ.52', 'CZ.52.8378777', '14069', 'Europe/Prague', '1', '2013-09-29 07:00:00', '2013-09-29 07:00:00');
INSERT INTO `cities` VALUES ('3064919', 'CZ', 'Stříbro', 'Stribro', '49.7556', '12.997', 'P', 'PPL', 'CZ.87', 'CZ.87.0327', '7689', 'Europe/Prague', '1', '2013-01-27 07:00:00', '2013-01-27 07:00:00');
INSERT INTO `cities` VALUES ('3064995', 'CZ', 'Strážnice', 'Straznice', '48.901', '17.3168', 'P', 'PPL', 'CZ.78', 'CZ.78.0625', '5900', 'Europe/Prague', '1', '2017-01-18 07:00:00', '2017-01-18 07:00:00');
INSERT INTO `cities` VALUES ('3065067', 'CZ', 'Strakonice', 'Strakonice', '49.2614', '13.9024', 'P', 'PPL', 'CZ.79', 'CZ.79.0316', '23545', 'Europe/Prague', '1', '2017-01-23 07:00:00', '2017-01-23 07:00:00');
INSERT INTO `cities` VALUES ('3065117', 'CZ', 'Stochov', 'Stochov', '50.1463', '13.9635', 'P', 'PPL', 'CZ.88', 'CZ.88.0203', '5538', 'Europe/Prague', '1', '2017-02-09 07:00:00', '2017-02-09 07:00:00');
INSERT INTO `cities` VALUES ('3065163', 'CZ', 'Štětí', 'Steti', '50.453', '14.3742', 'P', 'PPL', 'CZ.89', 'CZ.89.0423', '9165', 'Europe/Prague', '1', '2013-01-16 07:00:00', '2013-01-16 07:00:00');
INSERT INTO `cities` VALUES ('3065166', 'CZ', 'Šternberk', 'Sternberk', '49.7304', '17.2989', 'P', 'PPL', 'CZ.84', 'CZ.84.0712', '13967', 'Europe/Prague', '1', '2012-11-26 07:00:00', '2012-11-26 07:00:00');
INSERT INTO `cities` VALUES ('3065281', 'CZ', 'Starý Bohumín', 'Stary Bohumin', '49.9169', '18.3362', 'P', 'PPLX', 'CZ.85', 'CZ.85.0803', '23034', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3065328', 'CZ', 'Staré Město', 'Stare Mesto', '50.087', '14.4202', 'P', 'PPLX', 'CZ.52', 'CZ.52.8378769', '10127', 'Europe/Prague', '1', '2014-09-15 07:00:00', '2014-09-15 07:00:00');
INSERT INTO `cities` VALUES ('3065335', 'CZ', 'Staré Město', 'Stare Mesto', '49.0751', '17.4334', 'P', 'PPL', 'CZ.90', 'CZ.90.0722', '6742', 'Europe/Prague', '1', '2012-12-13 07:00:00', '2012-12-13 07:00:00');
INSERT INTO `cities` VALUES ('3065617', 'CZ', 'Sokolov', 'Sokolov', '50.1813', '12.6401', 'P', 'PPL', 'CZ.81', 'CZ.81.0413', '24901', 'Europe/Prague', '1', '2013-01-11 07:00:00', '2013-01-11 07:00:00');
INSERT INTO `cities` VALUES ('3065644', 'CZ', 'Soběslav', 'Sobeslav', '49.2599', '14.7186', 'P', 'PPL', 'CZ.79', 'CZ.79.0317', '7308', 'Europe/Prague', '1', '2017-01-23 07:00:00', '2017-01-23 07:00:00');
INSERT INTO `cities` VALUES ('3065768', 'CZ', 'Šluknov', 'Sluknov', '51.0037', '14.4526', 'P', 'PPL', 'CZ.89', 'CZ.89.0421', '5701', 'Europe/Prague', '1', '2012-12-10 07:00:00', '2012-12-10 07:00:00');
INSERT INTO `cities` VALUES ('3065824', 'CZ', 'Slavkov u Brna', 'Slavkov u Brna', '49.1533', '16.8765', 'P', 'PPL', 'CZ.78', 'CZ.78.0626', '5936', 'Europe/Prague', '1', '2017-01-18 07:00:00', '2017-01-18 07:00:00');
INSERT INTO `cities` VALUES ('3065843', 'CZ', 'Slavičín', 'Slavicin', '49.088', '17.8735', 'P', 'PPL', 'CZ.90', 'CZ.90.0724', '7079', 'Europe/Prague', '1', '2017-02-03 07:00:00', '2017-02-03 07:00:00');
INSERT INTO `cities` VALUES ('3065901', 'CZ', 'Šlapanice', 'Slapanice', '49.1686', '16.7273', 'P', 'PPL', 'CZ.78', 'CZ.78.0623', '7109', 'Europe/Prague', '1', '2017-01-18 07:00:00', '2017-01-18 07:00:00');
INSERT INTO `cities` VALUES ('3065903', 'CZ', 'Slaný', 'Slany', '50.2305', '14.0869', 'P', 'PPL', 'CZ.88', 'CZ.88.0203', '15070', 'Europe/Prague', '1', '2013-01-03 07:00:00', '2013-01-03 07:00:00');
INSERT INTO `cities` VALUES ('3065921', 'CZ', 'Skuteč', 'Skutec', '49.8435', '15.9965', 'P', 'PPL', 'CZ.86', 'CZ.86.0531', '5415', 'Europe/Prague', '1', '2013-01-16 07:00:00', '2013-01-16 07:00:00');
INSERT INTO `cities` VALUES ('3066154', 'CZ', 'Sezimovo Ústí', 'Sezimovo Usti', '49.3852', '14.6848', 'P', 'PPL', 'CZ.79', 'CZ.79.0317', '7420', 'Europe/Prague', '1', '2013-01-03 07:00:00', '2013-01-03 07:00:00');
INSERT INTO `cities` VALUES ('3066184', 'CZ', 'Šenov', 'Senov', '49.7932', '18.3761', 'P', 'PPL', 'CZ.85', 'CZ.85.0806', '5462', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3066220', 'CZ', 'Semily', 'Semily', '50.6019', '15.3355', 'P', 'PPL', 'CZ.83', 'CZ.83.0514', '9040', 'Europe/Prague', '1', '2017-01-30 07:00:00', '2017-01-30 07:00:00');
INSERT INTO `cities` VALUES ('3066333', 'CZ', 'Sedlčany', 'Sedlcany', '49.6606', '14.4266', 'P', 'PPL', 'CZ.88', 'CZ.88.020B', '7836', 'Europe/Prague', '1', '2017-02-12 07:00:00', '2017-02-12 07:00:00');
INSERT INTO `cities` VALUES ('3066483', 'CZ', 'Rýmařov', 'Rymarov', '49.9318', '17.2718', 'P', 'PPL', 'CZ.85', 'CZ.85.0801', '9069', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3066492', 'CZ', 'Rychvald', 'Rychvald', '49.8662', '18.3763', 'P', 'PPL', 'CZ.85', 'CZ.85.0803', '6771', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3066503', 'CZ', 'Rychnov nad Kněžnou', 'Rychnov nad Kneznou', '50.1628', '16.2749', 'P', 'PPL', 'CZ.82', 'CZ.82.0524', '11695', 'Europe/Prague', '1', '2013-01-11 07:00:00', '2013-01-11 07:00:00');
INSERT INTO `cities` VALUES ('3066578', 'CZ', 'Rumburk', 'Rumburk', '50.9515', '14.557', 'P', 'PPL', 'CZ.89', 'CZ.89.0421', '11101', 'Europe/Prague', '1', '2013-01-21 07:00:00', '2013-01-21 07:00:00');
INSERT INTO `cities` VALUES ('3066636', 'CZ', 'Roztoky', 'Roztoky', '50.1584', '14.3976', 'P', 'PPL', 'CZ.88', 'CZ.88.020A', '5956', 'Europe/Prague', '1', '2017-02-11 07:00:00', '2017-02-11 07:00:00');
INSERT INTO `cities` VALUES ('3066651', 'CZ', 'Rožnov pod Radhoštěm', 'Roznov pod Radhostem', '49.4585', '18.143', 'P', 'PPL', 'CZ.90', 'CZ.90.0723', '17238', 'Europe/Prague', '1', '2017-05-22 07:00:00', '2017-05-22 07:00:00');
INSERT INTO `cities` VALUES ('3066719', 'CZ', 'Rousínov', 'Rousinov', '49.2013', '16.8822', 'P', 'PPL', 'CZ.78', 'CZ.78.0626', '5016', 'Europe/Prague', '1', '2017-01-18 07:00:00', '2017-01-18 07:00:00');
INSERT INTO `cities` VALUES ('3066727', 'CZ', 'Roudnice nad Labem', 'Roudnice nad Labem', '50.4253', '14.2618', 'P', 'PPL', 'CZ.89', 'CZ.89.0423', '13084', 'Europe/Prague', '1', '2017-02-06 07:00:00', '2017-02-06 07:00:00');
INSERT INTO `cities` VALUES ('3066759', 'CZ', 'Rosice', 'Rosice', '49.1823', '16.3879', 'P', 'PPL', 'CZ.78', 'CZ.78.0623', '5287', 'Europe/Prague', '1', '2013-01-03 07:00:00', '2013-01-03 07:00:00');
INSERT INTO `cities` VALUES ('3066794', 'CZ', 'Rokycany', 'Rokycany', '49.7427', '13.5946', 'P', 'PPL', 'CZ.87', 'CZ.87.0326', '13826', 'Europe/Prague', '1', '2012-11-23 07:00:00', '2012-11-23 07:00:00');
INSERT INTO `cities` VALUES ('3066878', 'CZ', 'Říčany', 'Ricany', '49.9917', '14.6543', 'P', 'PPL', 'CZ.88', 'CZ.88.0209', '11329', 'Europe/Prague', '1', '2013-01-03 07:00:00', '2013-01-03 07:00:00');
INSERT INTO `cities` VALUES ('3067051', 'CZ', 'Rakovník', 'Rakovnik', '50.1037', '13.7334', 'P', 'PPL', 'CZ.88', 'CZ.88.020C', '16473', 'Europe/Prague', '1', '2017-02-11 07:00:00', '2017-02-11 07:00:00');
INSERT INTO `cities` VALUES ('3067395', 'CZ', 'Protivín', 'Protivin', '49.1995', '14.2172', 'P', 'PPL', 'CZ.79', 'CZ.79.0314', '5021', 'Europe/Prague', '1', '2017-01-20 07:00:00', '2017-01-20 07:00:00');
INSERT INTO `cities` VALUES ('3067421', 'CZ', 'Prostějov', 'Prostejov', '49.4719', '17.1118', 'P', 'PPL', 'CZ.84', 'CZ.84.0713', '47374', 'Europe/Prague', '1', '2012-12-19 07:00:00', '2012-12-19 07:00:00');
INSERT INTO `cities` VALUES ('3067433', 'CZ', 'Prosek', 'Prosek', '50.1152', '14.5069', 'P', 'PPLX', 'CZ.52', 'CZ.52.8378777', '15581', 'Europe/Prague', '1', '2013-09-29 07:00:00', '2013-09-29 07:00:00');
INSERT INTO `cities` VALUES ('3067542', 'CZ', 'Příbram', 'Pribram', '49.6899', '14.0104', 'P', 'PPL', 'CZ.88', 'CZ.88.020B', '35251', 'Europe/Prague', '1', '2013-01-11 07:00:00', '2013-01-11 07:00:00');
INSERT INTO `cities` VALUES ('3067544', 'CZ', 'Příbor', 'Pribor', '49.6409', '18.145', 'P', 'PPL', 'CZ.85', 'CZ.85.0804', '8789', 'Europe/Prague', '1', '2013-12-12 07:00:00', '2013-12-12 07:00:00');
INSERT INTO `cities` VALUES ('3067553', 'CZ', 'Přeštice', 'Prestice', '49.573', '13.3335', 'P', 'PPL', 'CZ.87', 'CZ.87.0324', '6353', 'Europe/Prague', '1', '2017-02-08 07:00:00', '2017-02-08 07:00:00');
INSERT INTO `cities` VALUES ('3067580', 'CZ', 'Přerov', 'Prerov', '49.4551', '17.4509', 'P', 'PPL', 'CZ.84', 'CZ.84.0714', '47311', 'Europe/Prague', '1', '2017-01-30 07:00:00', '2017-01-30 07:00:00');
INSERT INTO `cities` VALUES ('3067594', 'CZ', 'Přelouč', 'Prelouc', '50.0398', '15.5603', 'P', 'PPL', 'CZ.86', 'CZ.86.0532', '8586', 'Europe/Prague', '1', '2013-01-25 07:00:00', '2013-01-25 07:00:00');
INSERT INTO `cities` VALUES ('3067696', 'CZ', 'Prague', 'Prague', '50.088', '14.4208', 'P', 'PPLC', 'CZ.52', null, '1165581', 'Europe/Prague', '1', '2013-11-25 07:00:00', '2013-11-25 07:00:00');
INSERT INTO `cities` VALUES ('3067713', 'CZ', 'Prachatice', 'Prachatice', '49.0129', '13.9975', 'P', 'PPL', 'CZ.79', 'CZ.79.0315', '11803', 'Europe/Prague', '1', '2017-01-20 07:00:00', '2017-01-20 07:00:00');
INSERT INTO `cities` VALUES ('3067870', 'CZ', 'Polná', 'Polna', '49.487', '15.7188', 'P', 'PPL', 'CZ.80', 'CZ.80.0612', '5006', 'Europe/Prague', '1', '2013-01-15 07:00:00', '2013-01-15 07:00:00');
INSERT INTO `cities` VALUES ('3067882', 'CZ', 'Polička', 'Policka', '49.7146', '16.2654', 'P', 'PPL', 'CZ.86', 'CZ.86.0533', '9129', 'Europe/Prague', '1', '2013-01-16 07:00:00', '2013-01-16 07:00:00');
INSERT INTO `cities` VALUES ('3068107', 'CZ', 'Poděbrady', 'Podebrady', '50.1424', '15.1188', 'P', 'PPL', 'CZ.88', 'CZ.88.0208', '13128', 'Europe/Prague', '1', '2012-11-23 07:00:00', '2012-11-23 07:00:00');
INSERT INTO `cities` VALUES ('3068119', 'CZ', 'Podbořany', 'Podborany', '50.2294', '13.4119', 'P', 'PPL', 'CZ.89', 'CZ.89.0424', '6212', 'Europe/Prague', '1', '2017-02-06 07:00:00', '2017-02-06 07:00:00');
INSERT INTO `cities` VALUES ('3068160', 'CZ', 'Pilsen', 'Pilsen', '49.7475', '13.3776', 'P', 'PPLA', 'CZ.87', 'CZ.87.0323', '164180', 'Europe/Prague', '1', '2014-05-11 07:00:00', '2014-05-11 07:00:00');
INSERT INTO `cities` VALUES ('3068246', 'CZ', 'Planá', 'Plana', '49.8682', '12.7438', 'P', 'PPL', 'CZ.87', 'CZ.87.0327', '5450', 'Europe/Prague', '1', '2012-12-19 07:00:00', '2012-12-19 07:00:00');
INSERT INTO `cities` VALUES ('3068293', 'CZ', 'Písek', 'Pisek', '49.3088', '14.1475', 'P', 'PPL', 'CZ.79', 'CZ.79.0314', '29774', 'Europe/Prague', '1', '2012-12-10 07:00:00', '2012-12-10 07:00:00');
INSERT INTO `cities` VALUES ('3068329', 'CZ', 'Petřvald', 'Petrvald', '49.831', '18.3894', 'P', 'PPL', 'CZ.85', 'CZ.85.0803', '6854', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3068445', 'CZ', 'Pelhřimov', 'Pelhrimov', '49.4313', '15.2234', 'P', 'PPL', 'CZ.80', 'CZ.80.0613', '16541', 'Europe/Prague', '1', '2012-12-14 07:00:00', '2012-12-14 07:00:00');
INSERT INTO `cities` VALUES ('3068582', 'CZ', 'Pardubice', 'Pardubice', '50.0407', '15.7766', 'P', 'PPLA', 'CZ.86', 'CZ.86.0532', '88741', 'Europe/Prague', '1', '2012-12-13 07:00:00', '2012-12-13 07:00:00');
INSERT INTO `cities` VALUES ('3068647', 'CZ', 'Pacov', 'Pacov', '49.4708', '15.0017', 'P', 'PPL', 'CZ.80', 'CZ.80.0613', '5145', 'Europe/Prague', '1', '2017-01-24 07:00:00', '2017-01-24 07:00:00');
INSERT INTO `cities` VALUES ('3068690', 'CZ', 'Otrokovice', 'Otrokovice', '49.2093', '17.5394', 'P', 'PPL', 'CZ.90', 'CZ.90.0724', '18857', 'Europe/Prague', '1', '2013-01-03 07:00:00', '2013-01-03 07:00:00');
INSERT INTO `cities` VALUES ('3068766', 'CZ', 'Ostrov', 'Ostrov', '50.3059', '12.9391', 'P', 'PPL', 'CZ.81', 'CZ.81.0412', '17206', 'Europe/Prague', '1', '2017-01-26 07:00:00', '2017-01-26 07:00:00');
INSERT INTO `cities` VALUES ('3068799', 'CZ', 'Ostrava', 'Ostrava', '49.8346', '18.282', 'P', 'PPLA', 'CZ.85', 'CZ.85.0806', '313088', 'Europe/Prague', '1', '2015-10-23 07:00:00', '2015-10-23 07:00:00');
INSERT INTO `cities` VALUES ('3068873', 'CZ', 'Orlová', 'Orlova', '49.8453', '18.4301', 'P', 'PPL', 'CZ.85', 'CZ.85.0803', '34282', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3068927', 'CZ', 'Opava', 'Opava', '49.9387', '17.9026', 'P', 'PPL', 'CZ.85', 'CZ.85.0805', '60252', 'Europe/Prague', '1', '2012-12-24 07:00:00', '2012-12-24 07:00:00');
INSERT INTO `cities` VALUES ('3069011', 'CZ', 'Olomouc', 'Olomouc', '49.5955', '17.2518', 'P', 'PPLA', 'CZ.84', 'CZ.84.0712', '101268', 'Europe/Prague', '1', '2012-12-10 07:00:00', '2012-12-10 07:00:00');
INSERT INTO `cities` VALUES ('3069136', 'CZ', 'Odry', 'Odry', '49.6626', '17.8308', 'P', 'PPL', 'CZ.85', 'CZ.85.0804', '7395', 'Europe/Prague', '1', '2016-09-06 07:00:00', '2016-09-06 07:00:00');
INSERT INTO `cities` VALUES ('3069230', 'CZ', 'Nýrsko', 'Nyrsko', '49.2939', '13.1435', 'P', 'PPL', 'CZ.87', 'CZ.87.0322', '5070', 'Europe/Prague', '1', '2013-01-03 07:00:00', '2013-01-03 07:00:00');
INSERT INTO `cities` VALUES ('3069232', 'CZ', 'Nýřany', 'Nyrany', '49.7114', '13.2119', 'P', 'PPL', 'CZ.87', 'CZ.87.0325', '6942', 'Europe/Prague', '1', '2017-02-08 07:00:00', '2017-02-08 07:00:00');
INSERT INTO `cities` VALUES ('3069236', 'CZ', 'Nymburk', 'Nymburk', '50.1861', '15.0417', 'P', 'PPL', 'CZ.88', 'CZ.88.0208', '14373', 'Europe/Prague', '1', '2012-12-10 07:00:00', '2012-12-10 07:00:00');
INSERT INTO `cities` VALUES ('3069305', 'CZ', 'Nový Jičín', 'Novy Jicin', '49.5944', '18.0103', 'P', 'PPL', 'CZ.85', 'CZ.85.0804', '26547', 'Europe/Prague', '1', '2013-12-12 07:00:00', '2013-12-12 07:00:00');
INSERT INTO `cities` VALUES ('3069377', 'CZ', 'Nový Bydžov', 'Novy Bydzov', '50.2415', '15.4908', 'P', 'PPL', 'CZ.82', 'CZ.82.0521', '7160', 'Europe/Prague', '1', '2017-01-26 07:00:00', '2017-01-26 07:00:00');
INSERT INTO `cities` VALUES ('3069381', 'CZ', 'Nový Bor', 'Novy Bor', '50.7576', '14.5555', 'P', 'PPL', 'CZ.83', 'CZ.83.0511', '12171', 'Europe/Prague', '1', '2016-09-06 07:00:00', '2016-09-06 07:00:00');
INSERT INTO `cities` VALUES ('3069431', 'CZ', 'Nové Strašecí', 'Nove Straseci', '50.1527', '13.9004', 'P', 'PPL', 'CZ.88', 'CZ.88.020C', '5082', 'Europe/Prague', '1', '2017-02-11 07:00:00', '2017-02-11 07:00:00');
INSERT INTO `cities` VALUES ('3069465', 'CZ', 'Nové Město na Moravě', 'Nove Mesto na Morave', '49.5614', '16.0742', 'P', 'PPL', 'CZ.80', 'CZ.80.0615', '10537', 'Europe/Prague', '1', '2012-12-13 07:00:00', '2012-12-13 07:00:00');
INSERT INTO `cities` VALUES ('3069466', 'CZ', 'Nové Město nad Metují', 'Nove Mesto nad Metuji', '50.3446', '16.1515', 'P', 'PPL', 'CZ.82', 'CZ.82.0523', '10126', 'Europe/Prague', '1', '2016-09-06 07:00:00', '2016-09-06 07:00:00');
INSERT INTO `cities` VALUES ('3069669', 'CZ', 'Nová Paka', 'Nova Paka', '50.4945', '15.515', 'P', 'PPL', 'CZ.82', 'CZ.82.0522', '9219', 'Europe/Prague', '1', '2017-01-26 07:00:00', '2017-01-26 07:00:00');
INSERT INTO `cities` VALUES ('3069844', 'CZ', 'Neratovice', 'Neratovice', '50.2593', '14.5176', 'P', 'PPL', 'CZ.88', 'CZ.88.0206', '16427', 'Europe/Prague', '1', '2017-02-10 07:00:00', '2017-02-10 07:00:00');
INSERT INTO `cities` VALUES ('3069934', 'CZ', 'Nejdek', 'Nejdek', '50.3224', '12.7294', 'P', 'PPL', 'CZ.81', 'CZ.81.0412', '8565', 'Europe/Prague', '1', '2017-02-08 07:00:00', '2017-02-08 07:00:00');
INSERT INTO `cities` VALUES ('3070045', 'CZ', 'Napajedla', 'Napajedla', '49.1716', '17.5119', 'P', 'PPL', 'CZ.90', 'CZ.90.0724', '7662', 'Europe/Prague', '1', '2012-12-10 07:00:00', '2012-12-10 07:00:00');
INSERT INTO `cities` VALUES ('3070055', 'CZ', 'Náměšť nad Oslavou', 'Namest\' nad Oslavou', '49.2073', '16.1585', 'P', 'PPL', 'CZ.80', 'CZ.80.0614', '5192', 'Europe/Prague', '1', '2017-01-25 07:00:00', '2017-01-25 07:00:00');
INSERT INTO `cities` VALUES ('3070122', 'CZ', 'Náchod', 'Nachod', '50.4167', '16.1629', 'P', 'PPL', 'CZ.82', 'CZ.82.0523', '21263', 'Europe/Prague', '1', '2012-12-13 07:00:00', '2012-12-13 07:00:00');
INSERT INTO `cities` VALUES ('3070291', 'CZ', 'Most', 'Most', '50.503', '13.6362', 'P', 'PPL', 'CZ.89', 'CZ.89.0425', '67905', 'Europe/Prague', '1', '2015-11-13 07:00:00', '2015-11-13 07:00:00');
INSERT INTO `cities` VALUES ('3070310', 'CZ', 'Moravský Krumlov', 'Moravsky Krumlov', '49.0489', '16.3117', 'P', 'PPL', 'CZ.78', 'CZ.78.0627', '6050', 'Europe/Prague', '1', '2017-01-17 07:00:00', '2017-01-17 07:00:00');
INSERT INTO `cities` VALUES ('3070323', 'CZ', 'Moravské Budějovice', 'Moravske Budejovice', '49.0521', '15.8086', 'P', 'PPL', 'CZ.80', 'CZ.80.0614', '7971', 'Europe/Prague', '1', '2017-01-25 07:00:00', '2017-01-25 07:00:00');
INSERT INTO `cities` VALUES ('3070325', 'CZ', 'Moravská Třebová', 'Moravska Trebova', '49.7579', '16.6643', 'P', 'PPL', 'CZ.86', 'CZ.86.0533', '11414', 'Europe/Prague', '1', '2013-01-11 07:00:00', '2013-01-11 07:00:00');
INSERT INTO `cities` VALUES ('3070409', 'CZ', 'Mohelnice', 'Mohelnice', '49.777', '16.9195', 'P', 'PPL', 'CZ.84', 'CZ.84.0715', '9742', 'Europe/Prague', '1', '2012-12-10 07:00:00', '2012-12-10 07:00:00');
INSERT INTO `cities` VALUES ('3070420', 'CZ', 'Modřany', 'Modrany', '50.0112', '14.4096', 'P', 'PPLX', 'CZ.52', 'CZ.52.8378780', '31901', 'Europe/Prague', '1', '2013-09-29 07:00:00', '2013-09-29 07:00:00');
INSERT INTO `cities` VALUES ('3070451', 'CZ', 'Mnichovo Hradiště', 'Mnichovo Hradiste', '50.5272', '14.9713', 'P', 'PPL', 'CZ.88', 'CZ.88.0207', '8368', 'Europe/Prague', '1', '2017-02-10 07:00:00', '2017-02-10 07:00:00');
INSERT INTO `cities` VALUES ('3070544', 'CZ', 'Mladá Boleslav', 'Mlada Boleslav', '50.4114', '14.9032', 'P', 'PPL', 'CZ.88', 'CZ.88.0207', '43684', 'Europe/Prague', '1', '2016-09-26 07:00:00', '2016-09-26 07:00:00');
INSERT INTO `cities` VALUES ('3070622', 'CZ', 'Mimoň', 'Mimon', '50.6587', '14.7247', 'P', 'PPL', 'CZ.83', 'CZ.83.0511', '6692', 'Europe/Prague', '1', '2016-09-06 07:00:00', '2016-09-06 07:00:00');
INSERT INTO `cities` VALUES ('3070628', 'CZ', 'Milovice', 'Milovice', '50.226', '14.8886', 'P', 'PPL', 'CZ.88', 'CZ.88.0208', '5461', 'Europe/Prague', '1', '2017-02-11 07:00:00', '2017-02-11 07:00:00');
INSERT INTO `cities` VALUES ('3070678', 'CZ', 'Milevsko', 'Milevsko', '49.4509', '14.36', 'P', 'PPL', 'CZ.79', 'CZ.79.0314', '9343', 'Europe/Prague', '1', '2017-01-20 07:00:00', '2017-01-20 07:00:00');
INSERT INTO `cities` VALUES ('3070720', 'CZ', 'Mikulov', 'Mikulov', '48.8056', '16.6378', 'P', 'PPL', 'CZ.78', 'CZ.78.0624', '7608', 'Europe/Prague', '1', '2012-12-13 07:00:00', '2012-12-13 07:00:00');
INSERT INTO `cities` VALUES ('3070862', 'CZ', 'Mělník', 'Melnik', '50.3505', '14.4741', 'P', 'PPL', 'CZ.88', 'CZ.88.0206', '19231', 'Europe/Prague', '1', '2012-12-13 07:00:00', '2012-12-13 07:00:00');
INSERT INTO `cities` VALUES ('3071024', 'CZ', 'Mariánské Lázně', 'Marianske Lazne', '49.9646', '12.7012', 'P', 'PPL', 'CZ.81', 'CZ.81.0411', '14277', 'Europe/Prague', '1', '2012-11-23 07:00:00', '2012-11-23 07:00:00');
INSERT INTO `cities` VALUES ('3071213', 'CZ', 'Malá Strana', 'Mala Strana', '50.0877', '14.4045', 'P', 'PPLX', 'CZ.52', 'CZ.52.8378769', '6350', 'Europe/Prague', '1', '2014-09-14 07:00:00', '2014-09-14 07:00:00');
INSERT INTO `cities` VALUES ('3071304', 'CZ', 'Lysá nad Labem', 'Lysa nad Labem', '50.2014', '14.8328', 'P', 'PPL', 'CZ.88', 'CZ.88.0208', '8194', 'Europe/Prague', '1', '2017-02-11 07:00:00', '2017-02-11 07:00:00');
INSERT INTO `cities` VALUES ('3071407', 'CZ', 'Luhačovice', 'Luhacovice', '49.0998', '17.7575', 'P', 'PPL', 'CZ.90', 'CZ.90.0724', '5554', 'Europe/Prague', '1', '2013-01-25 07:00:00', '2013-01-25 07:00:00');
INSERT INTO `cities` VALUES ('3071480', 'CZ', 'Lovosice', 'Lovosice', '50.515', '14.051', 'P', 'PPL', 'CZ.89', 'CZ.89.0423', '9196', 'Europe/Prague', '1', '2017-02-06 07:00:00', '2017-02-06 07:00:00');
INSERT INTO `cities` VALUES ('3071507', 'CZ', 'Louny', 'Louny', '50.357', '13.7967', 'P', 'PPL', 'CZ.89', 'CZ.89.0424', '19147', 'Europe/Prague', '1', '2012-12-19 07:00:00', '2012-12-19 07:00:00');
INSERT INTO `cities` VALUES ('3071606', 'CZ', 'Lomnice nad Popelkou', 'Lomnice nad Popelkou', '50.5306', '15.3734', 'P', 'PPL', 'CZ.83', 'CZ.83.0514', '5957', 'Europe/Prague', '1', '2013-01-17 07:00:00', '2013-01-17 07:00:00');
INSERT INTO `cities` VALUES ('3071665', 'CZ', 'Litvínov', 'Litvinov', '50.6042', '13.6181', 'P', 'PPL', 'CZ.89', 'CZ.89.0425', '27022', 'Europe/Prague', '1', '2013-01-11 07:00:00', '2013-01-11 07:00:00');
INSERT INTO `cities` VALUES ('3071669', 'CZ', 'Litovel', 'Litovel', '49.7012', '17.0762', 'P', 'PPL', 'CZ.84', 'CZ.84.0712', '10062', 'Europe/Prague', '1', '2017-01-31 07:00:00', '2017-01-31 07:00:00');
INSERT INTO `cities` VALUES ('3071675', 'CZ', 'Litomyšl', 'Litomysl', '49.8681', '16.313', 'P', 'PPL', 'CZ.86', 'CZ.86.0533', '10146', 'Europe/Prague', '1', '2012-12-10 07:00:00', '2012-12-10 07:00:00');
INSERT INTO `cities` VALUES ('3071677', 'CZ', 'Litoměřice', 'Litomerice', '50.5335', '14.1318', 'P', 'PPL', 'CZ.89', 'CZ.89.0423', '24489', 'Europe/Prague', '1', '2015-11-13 07:00:00', '2015-11-13 07:00:00');
INSERT INTO `cities` VALUES ('3071791', 'CZ', 'Lipník nad Bečvou', 'Lipnik nad Becvou', '49.5272', '17.5859', 'P', 'PPL', 'CZ.84', 'CZ.84.0714', '8369', 'Europe/Prague', '1', '2013-01-25 07:00:00', '2013-01-25 07:00:00');
INSERT INTO `cities` VALUES ('3071961', 'CZ', 'Liberec', 'Liberec', '50.7671', '15.0562', 'P', 'PPLA', 'CZ.83', 'CZ.83.0513', '97770', 'Europe/Prague', '1', '2012-11-23 07:00:00', '2012-11-23 07:00:00');
INSERT INTO `cities` VALUES ('3071966', 'CZ', 'Libeň', 'Liben', '50.1082', '14.4746', 'P', 'PPLX', 'CZ.52', 'CZ.52.8378776', '31756', 'Europe/Prague', '1', '2013-09-29 07:00:00', '2013-09-29 07:00:00');
INSERT INTO `cities` VALUES ('3072130', 'CZ', 'Letovice', 'Letovice', '49.5471', '16.5736', 'P', 'PPL', 'CZ.78', 'CZ.78.0621', '6799', 'Europe/Prague', '1', '2013-01-25 07:00:00', '2013-01-25 07:00:00');
INSERT INTO `cities` VALUES ('3072134', 'CZ', 'Letohrad', 'Letohrad', '50.0358', '16.4988', 'P', 'PPL', 'CZ.86', 'CZ.86.0534', '6195', 'Europe/Prague', '1', '2018-01-03 07:00:00', '2018-01-03 07:00:00');
INSERT INTO `cities` VALUES ('3072137', 'CZ', 'Letňany', 'Letnany', '50.1333', '14.5167', 'P', 'PPLX', 'CZ.52', 'CZ.52.8378788', '15862', 'Europe/Prague', '1', '2013-09-29 07:00:00', '2013-09-29 07:00:00');
INSERT INTO `cities` VALUES ('3072235', 'CZ', 'Ledeč nad Sázavou', 'Ledec nad Sazavou', '49.6952', '15.2777', 'P', 'PPL', 'CZ.80', 'CZ.80.0611', '6048', 'Europe/Prague', '1', '2017-01-23 07:00:00', '2017-01-23 07:00:00');
INSERT INTO `cities` VALUES ('3072332', 'CZ', 'Lanškroun', 'Lanskroun', '49.9122', '16.6119', 'P', 'PPL', 'CZ.86', 'CZ.86.0534', '9847', 'Europe/Prague', '1', '2017-12-31 07:00:00', '2017-12-31 07:00:00');
INSERT INTO `cities` VALUES ('3072394', 'CZ', 'Kynšperk nad Ohří', 'Kynsperk nad Ohri', '50.1189', '12.5303', 'P', 'PPL', 'CZ.81', 'CZ.81.0413', '5085', 'Europe/Prague', '1', '2017-01-26 07:00:00', '2017-01-26 07:00:00');
INSERT INTO `cities` VALUES ('3072407', 'CZ', 'Kyjov', 'Kyjov', '49.0102', '17.1225', 'P', 'PPL', 'CZ.78', 'CZ.78.0625', '12191', 'Europe/Prague', '1', '2012-12-13 07:00:00', '2012-12-13 07:00:00');
INSERT INTO `cities` VALUES ('3072463', 'CZ', 'Kutná Hora', 'Kutna Hora', '49.9484', '15.2682', 'P', 'PPL', 'CZ.88', 'CZ.88.0205', '21280', 'Europe/Prague', '1', '2015-11-13 07:00:00', '2015-11-13 07:00:00');
INSERT INTO `cities` VALUES ('3072476', 'CZ', 'Kuřim', 'Kurim', '49.2985', '16.5314', 'P', 'PPL', 'CZ.78', 'CZ.78.0623', '9283', 'Europe/Prague', '1', '2017-01-18 07:00:00', '2017-01-18 07:00:00');
INSERT INTO `cities` VALUES ('3072497', 'CZ', 'Kunovice', 'Kunovice', '49.045', '17.4701', 'P', 'PPL', 'CZ.90', 'CZ.90.0722', '5148', 'Europe/Prague', '1', '2015-04-23 07:00:00', '2015-04-23 07:00:00');
INSERT INTO `cities` VALUES ('3072598', 'CZ', 'Krupka', 'Krupka', '50.6845', '13.8581', 'P', 'PPL', 'CZ.89', 'CZ.89.0426', '13687', 'Europe/Prague', '1', '2017-02-06 07:00:00', '2017-02-06 07:00:00');
INSERT INTO `cities` VALUES ('3072649', 'CZ', 'Kroměříž', 'Kromeriz', '49.2979', '17.3931', 'P', 'PPL', 'CZ.90', 'CZ.90.0721', '29126', 'Europe/Prague', '1', '2015-11-13 07:00:00', '2015-11-13 07:00:00');
INSERT INTO `cities` VALUES ('3072656', 'CZ', 'Krnov', 'Krnov', '50.0897', '17.7038', 'P', 'PPL', 'CZ.85', 'CZ.85.0801', '25547', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3072841', 'CZ', 'Kravaře', 'Kravare', '49.932', '18.0047', 'P', 'PPL', 'CZ.85', 'CZ.85.0805', '6787', 'Europe/Prague', '1', '2016-09-07 07:00:00', '2016-09-07 07:00:00');
INSERT INTO `cities` VALUES ('3072903', 'CZ', 'Kraslice', 'Kraslice', '50.3237', '12.5175', 'P', 'PPL', 'CZ.81', 'CZ.81.0413', '7159', 'Europe/Prague', '1', '2017-01-26 07:00:00', '2017-01-26 07:00:00');
INSERT INTO `cities` VALUES ('3072927', 'CZ', 'Králův Dvůr', 'Kraluv Dvur', '49.9498', '14.0344', 'P', 'PPL', 'CZ.88', 'CZ.88.0202', '5805', 'Europe/Prague', '1', '2013-01-11 07:00:00', '2013-01-11 07:00:00');
INSERT INTO `cities` VALUES ('3072929', 'CZ', 'Kralupy nad Vltavou', 'Kralupy nad Vltavou', '50.2411', '14.3115', 'P', 'PPL', 'CZ.88', null, '17373', 'Europe/Prague', '1', '2015-03-10 07:00:00', '2015-03-10 07:00:00');
INSERT INTO `cities` VALUES ('3073149', 'CZ', 'Kostelec nad Orlicí', 'Kostelec nad Orlici', '50.1227', '16.2132', 'P', 'PPL', 'CZ.82', 'CZ.82.0524', '6184', 'Europe/Prague', '1', '2017-01-27 07:00:00', '2017-01-27 07:00:00');
INSERT INTO `cities` VALUES ('3073254', 'CZ', 'Kopřivnice', 'Koprivnice', '49.5995', '18.1448', 'P', 'PPL', 'CZ.85', 'CZ.85.0804', '23424', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3073371', 'CZ', 'Kolín', 'Kolin', '50.0281', '15.1998', 'P', 'PPL', 'CZ.88', 'CZ.88.0204', '29690', 'Europe/Prague', '1', '2016-11-01 07:00:00', '2016-11-01 07:00:00');
INSERT INTO `cities` VALUES ('3073407', 'CZ', 'Kojetín', 'Kojetin', '49.3518', '17.3021', 'P', 'PPL', 'CZ.84', 'CZ.84.0714', '6397', 'Europe/Prague', '1', '2017-01-30 07:00:00', '2017-01-30 07:00:00');
INSERT INTO `cities` VALUES ('3073660', 'CZ', 'Klatovy', 'Klatovy', '49.3955', '13.295', 'P', 'PPL', 'CZ.87', 'CZ.87.0322', '23102', 'Europe/Prague', '1', '2017-02-07 07:00:00', '2017-02-07 07:00:00');
INSERT INTO `cities` VALUES ('3073668', 'CZ', 'Klášterec nad Ohří', 'Klasterec nad Ohri', '50.3886', '13.1834', 'P', 'PPL', 'CZ.89', 'CZ.89.0422', '15040', 'Europe/Prague', '1', '2014-11-04 07:00:00', '2014-11-04 07:00:00');
INSERT INTO `cities` VALUES ('3073699', 'CZ', 'Kladno', 'Kladno', '50.1473', '14.1028', 'P', 'PPL', 'CZ.88', 'CZ.88.0203', '70003', 'Europe/Prague', '1', '2017-02-09 07:00:00', '2017-02-09 07:00:00');
INSERT INTO `cities` VALUES ('3073743', 'CZ', 'Kbely', 'Kbely', '50.1333', '14.55', 'P', 'PPLX', 'CZ.52', 'CZ.52.8378789', '5457', 'Europe/Prague', '1', '2013-09-29 07:00:00', '2013-09-29 07:00:00');
INSERT INTO `cities` VALUES ('3073789', 'CZ', 'Karviná', 'Karvina', '49.854', '18.5417', 'P', 'PPL', 'CZ.85', 'CZ.85.0803', '63677', 'Europe/Prague', '1', '2012-12-13 07:00:00', '2012-12-13 07:00:00');
INSERT INTO `cities` VALUES ('3073803', 'CZ', 'Karlovy Vary', 'Karlovy Vary', '50.2327', '12.8712', 'P', 'PPLA', 'CZ.81', 'CZ.81.0412', '51807', 'Europe/Prague', '1', '2012-11-21 07:00:00', '2012-11-21 07:00:00');
INSERT INTO `cities` VALUES ('3073838', 'CZ', 'Karlín', 'Karlin', '50.0927', '14.4471', 'P', 'PPLX', 'CZ.52', 'CZ.52.8378776', '11971', 'Europe/Prague', '1', '2013-09-29 07:00:00', '2013-09-29 07:00:00');
INSERT INTO `cities` VALUES ('3073862', 'CZ', 'Kaplice', 'Kaplice', '48.7388', '14.4945', 'P', 'PPL', 'CZ.79', 'CZ.79.0312', '7195', 'Europe/Prague', '1', '2016-07-18 07:00:00', '2016-07-18 07:00:00');
INSERT INTO `cities` VALUES ('3074020', 'CZ', 'Kadaň', 'Kadan', '50.3833', '13.2667', 'P', 'PPL', 'CZ.89', null, '18759', 'Europe/Prague', '1', '2016-03-17 07:00:00', '2016-03-17 07:00:00');
INSERT INTO `cities` VALUES ('3074110', 'CZ', 'Jirkov', 'Jirkov', '50.4998', '13.4477', 'P', 'PPL', 'CZ.89', 'CZ.89.0422', '21056', 'Europe/Prague', '1', '2017-02-06 07:00:00', '2017-02-06 07:00:00');
INSERT INTO `cities` VALUES ('3074149', 'CZ', 'Jindřichův Hradec', 'Jindrichuv Hradec', '49.144', '15.003', 'P', 'PPL', 'CZ.79', 'CZ.79.0313', '22812', 'Europe/Prague', '1', '2012-12-05 07:00:00', '2012-12-05 07:00:00');
INSERT INTO `cities` VALUES ('3074181', 'CZ', 'Jílové', 'Jilove', '50.7608', '14.1038', 'P', 'PPL', 'CZ.89', 'CZ.89.0421', '5307', 'Europe/Prague', '1', '2017-02-06 07:00:00', '2017-02-06 07:00:00');
INSERT INTO `cities` VALUES ('3074187', 'CZ', 'Jilemnice', 'Jilemnice', '50.6089', '15.5065', 'P', 'PPL', 'CZ.83', 'CZ.83.0514', '5777', 'Europe/Prague', '1', '2017-01-30 07:00:00', '2017-01-30 07:00:00');
INSERT INTO `cities` VALUES ('3074199', 'CZ', 'Jihlava', 'Jihlava', '49.3961', '15.5912', 'P', 'PPLA', 'CZ.80', 'CZ.80.0612', '50100', 'Europe/Prague', '1', '2012-12-10 07:00:00', '2012-12-10 07:00:00');
INSERT INTO `cities` VALUES ('3074204', 'CZ', 'Jičín', 'Jicin', '50.4372', '15.3516', 'P', 'PPL', 'CZ.82', 'CZ.82.0522', '16328', 'Europe/Prague', '1', '2012-12-10 07:00:00', '2012-12-10 07:00:00');
INSERT INTO `cities` VALUES ('3074281', 'CZ', 'Jeseník', 'Jesenik', '50.2294', '17.2046', 'P', 'PPL', 'CZ.84', 'CZ.84.0711', '12457', 'Europe/Prague', '1', '2012-12-13 07:00:00', '2012-12-13 07:00:00');
INSERT INTO `cities` VALUES ('3074462', 'CZ', 'Jaroměř', 'Jaromer', '50.3562', '15.9214', 'P', 'PPL', 'CZ.82', 'CZ.82.0523', '12831', 'Europe/Prague', '1', '2013-01-11 07:00:00', '2013-01-11 07:00:00');
INSERT INTO `cities` VALUES ('3074593', 'CZ', 'Jablunkov', 'Jablunkov', '49.5767', '18.7646', 'P', 'PPL', 'CZ.85', 'CZ.85.0802', '5782', 'Europe/Prague', '1', '2013-01-17 07:00:00', '2013-01-17 07:00:00');
INSERT INTO `cities` VALUES ('3074603', 'CZ', 'Jablonec nad Nisou', 'Jablonec nad Nisou', '50.7243', '15.1711', 'P', 'PPL', 'CZ.83', 'CZ.83.0512', '44878', 'Europe/Prague', '1', '2014-10-27 07:00:00', '2014-10-27 07:00:00');
INSERT INTO `cities` VALUES ('3074615', 'CZ', 'Ivančice', 'Ivancice', '49.1014', '16.3775', 'P', 'PPL', 'CZ.78', 'CZ.78.0623', '9354', 'Europe/Prague', '1', '2017-01-18 07:00:00', '2017-01-18 07:00:00');
INSERT INTO `cities` VALUES ('3074677', 'CZ', 'Hustopeče', 'Hustopece', '48.9408', '16.7376', 'P', 'PPL', 'CZ.78', 'CZ.78.0624', '5913', 'Europe/Prague', '1', '2013-01-17 07:00:00', '2013-01-17 07:00:00');
INSERT INTO `cities` VALUES ('3074723', 'CZ', 'Humpolec', 'Humpolec', '49.5415', '15.3593', 'P', 'PPL', 'CZ.80', 'CZ.80.0613', '10914', 'Europe/Prague', '1', '2012-11-28 07:00:00', '2012-11-28 07:00:00');
INSERT INTO `cities` VALUES ('3074731', 'CZ', 'Hulín', 'Hulin', '49.3169', '17.4637', 'P', 'PPL', 'CZ.90', 'CZ.90.0721', '7571', 'Europe/Prague', '1', '2017-02-03 07:00:00', '2017-02-03 07:00:00');
INSERT INTO `cities` VALUES ('3074805', 'CZ', 'Hronov', 'Hronov', '50.4797', '16.1823', 'P', 'PPL', 'CZ.82', 'CZ.82.0523', '6516', 'Europe/Prague', '1', '2016-09-07 07:00:00', '2016-09-07 07:00:00');
INSERT INTO `cities` VALUES ('3074893', 'CZ', 'Hranice', 'Hranice', '49.548', '17.7347', 'P', 'PPL', 'CZ.84', 'CZ.84.0714', '19582', 'Europe/Prague', '1', '2012-12-19 07:00:00', '2012-12-19 07:00:00');
INSERT INTO `cities` VALUES ('3074944', 'CZ', 'Hrádek nad Nisou', 'Hradek nad Nisou', '50.8528', '14.8446', 'P', 'PPL', 'CZ.83', 'CZ.83.0513', '7327', 'Europe/Prague', '1', '2016-09-07 07:00:00', '2016-09-07 07:00:00');
INSERT INTO `cities` VALUES ('3074967', 'CZ', 'Hradec Králové', 'Hradec Kralove', '50.2092', '15.8328', 'P', 'PPLA', 'CZ.82', 'CZ.82.0521', '95195', 'Europe/Prague', '1', '2014-10-27 07:00:00', '2014-10-27 07:00:00');
INSERT INTO `cities` VALUES ('3074975', 'CZ', 'Hradec nad Moravici', 'Hradec nad Moravici', '49.8704', '17.8784', 'P', 'PPL', 'CZ.85', 'CZ.85.0805', '5255', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3075119', 'CZ', 'Hořovice', 'Horovice', '49.836', '13.9027', 'P', 'PPL', 'CZ.88', 'CZ.88.0202', '6431', 'Europe/Prague', '1', '2012-12-18 07:00:00', '2012-12-18 07:00:00');
INSERT INTO `cities` VALUES ('3075208', 'CZ', 'Horní Slavkov', 'Horni Slavkov', '50.1386', '12.8076', 'P', 'PPL', 'CZ.81', 'CZ.81.0413', '5818', 'Europe/Prague', '1', '2017-01-26 07:00:00', '2017-01-26 07:00:00');
INSERT INTO `cities` VALUES ('3075257', 'CZ', 'Horní Počernice', 'Horni Pocernice', '50.1121', '14.6104', 'P', 'PPLX', 'CZ.52', 'CZ.52.8378790', '14296', 'Europe/Prague', '1', '2013-09-29 07:00:00', '2013-09-29 07:00:00');
INSERT INTO `cities` VALUES ('3075493', 'CZ', 'Hořice', 'Horice', '50.3661', '15.6318', 'P', 'PPL', 'CZ.82', 'CZ.82.0522', '8899', 'Europe/Prague', '1', '2017-01-26 07:00:00', '2017-01-26 07:00:00');
INSERT INTO `cities` VALUES ('3075522', 'CZ', 'Horažďovice', 'Horazd\'ovice', '49.3207', '13.701', 'P', 'PPL', 'CZ.87', 'CZ.87.0322', '5727', 'Europe/Prague', '1', '2017-02-07 07:00:00', '2017-02-07 07:00:00');
INSERT INTO `cities` VALUES ('3075599', 'CZ', 'Holice', 'Holice', '50.066', '15.9859', 'P', 'PPL', 'CZ.86', 'CZ.86.0532', '6219', 'Europe/Prague', '1', '2017-02-02 07:00:00', '2017-02-02 07:00:00');
INSERT INTO `cities` VALUES ('3075606', 'CZ', 'Holešov', 'Holesov', '49.3333', '17.5783', 'P', 'PPL', 'CZ.90', 'CZ.90.0721', '12384', 'Europe/Prague', '1', '2017-02-03 07:00:00', '2017-02-03 07:00:00');
INSERT INTO `cities` VALUES ('3075654', 'CZ', 'Hodonín', 'Hodonin', '48.8489', '17.1324', 'P', 'PPL', 'CZ.78', 'CZ.78.0625', '26345', 'Europe/Prague', '1', '2017-01-18 07:00:00', '2017-01-18 07:00:00');
INSERT INTO `cities` VALUES ('3075716', 'CZ', 'Hlučín', 'Hlucin', '49.8979', '18.192', 'P', 'PPL', 'CZ.85', 'CZ.85.0805', '14228', 'Europe/Prague', '1', '2013-01-04 07:00:00', '2013-01-04 07:00:00');
INSERT INTO `cities` VALUES ('3075766', 'CZ', 'Hlinsko', 'Hlinsko', '49.7621', '15.9076', 'P', 'PPL', 'CZ.86', 'CZ.86.0531', '10411', 'Europe/Prague', '1', '2012-12-14 07:00:00', '2012-12-14 07:00:00');
INSERT INTO `cities` VALUES ('3075919', 'CZ', 'Havlíčkův Brod', 'Havlickuv Brod', '49.6078', '15.5807', 'P', 'PPL', 'CZ.80', 'CZ.80.0611', '24356', 'Europe/Prague', '1', '2012-11-27 07:00:00', '2012-11-27 07:00:00');
INSERT INTO `cities` VALUES ('3075921', 'CZ', 'Havířov', 'Havirov', '49.7798', '18.4369', 'P', 'PPL', 'CZ.85', null, '82768', 'Europe/Prague', '1', '2013-08-18 07:00:00', '2013-08-18 07:00:00');
INSERT INTO `cities` VALUES ('3076076', 'CZ', 'Habartov', 'Habartov', '50.183', '12.5505', 'P', 'PPL', 'CZ.81', 'CZ.81.0413', '5337', 'Europe/Prague', '1', '2012-12-24 07:00:00', '2012-12-24 07:00:00');
INSERT INTO `cities` VALUES ('3076116', 'CZ', 'Fulnek', 'Fulnek', '49.7124', '17.9032', 'P', 'PPL', 'CZ.85', 'CZ.85.0804', '6107', 'Europe/Prague', '1', '2016-09-07 07:00:00', '2016-09-07 07:00:00');
INSERT INTO `cities` VALUES ('3076123', 'CZ', 'Frýdlant nad Ostravicí', 'Frydlant nad Ostravici', '49.5928', '18.3597', 'P', 'PPL', 'CZ.85', 'CZ.85.0802', '9824', 'Europe/Prague', '1', '2016-09-07 07:00:00', '2016-09-07 07:00:00');
INSERT INTO `cities` VALUES ('3076124', 'CZ', 'Frýdlant', 'Frydlant', '50.9214', '15.0797', 'P', 'PPL', 'CZ.83', 'CZ.83.0513', '7471', 'Europe/Prague', '1', '2012-12-24 07:00:00', '2012-12-24 07:00:00');
INSERT INTO `cities` VALUES ('3076127', 'CZ', 'Frýdek-Místek', 'Frydek-Mistek', '49.6833', '18.35', 'P', 'PPL', 'CZ.85', 'CZ.85.0802', '59416', 'Europe/Prague', '1', '2017-12-23 07:00:00', '2017-12-23 07:00:00');
INSERT INTO `cities` VALUES ('3076132', 'CZ', 'Frenštát pod Radhoštěm', 'Frenstat pod Radhostem', '49.5484', '18.2108', 'P', 'PPL', 'CZ.85', 'CZ.85.0804', '11334', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3076136', 'CZ', 'Františkovy Lázně', 'Frantiskovy Lazne', '50.1203', '12.3517', 'P', 'PPL', 'CZ.81', 'CZ.81.0411', '5355', 'Europe/Prague', '1', '2012-11-23 07:00:00', '2012-11-23 07:00:00');
INSERT INTO `cities` VALUES ('3076311', 'CZ', 'Duchcov', 'Duchcov', '50.6038', '13.7462', 'P', 'PPL', 'CZ.89', 'CZ.89.0426', '8937', 'Europe/Prague', '1', '2017-02-07 07:00:00', '2017-02-07 07:00:00');
INSERT INTO `cities` VALUES ('3076329', 'CZ', 'Dubňany', 'Dubnany', '48.9169', '17.09', 'P', 'PPL', 'CZ.78', 'CZ.78.0625', '6649', 'Europe/Prague', '1', '2017-01-18 07:00:00', '2017-01-18 07:00:00');
INSERT INTO `cities` VALUES ('3076346', 'CZ', 'Dubí', 'Dubi', '50.6856', '13.7856', 'P', 'PPL', 'CZ.89', 'CZ.89.0426', '7591', 'Europe/Prague', '1', '2017-02-06 07:00:00', '2017-02-06 07:00:00');
INSERT INTO `cities` VALUES ('3076587', 'CZ', 'Domažlice', 'Domazlice', '49.4405', '12.9298', 'P', 'PPL', 'CZ.87', 'CZ.87.0321', '10944', 'Europe/Prague', '1', '2012-11-21 07:00:00', '2012-11-21 07:00:00');
INSERT INTO `cities` VALUES ('3076972', 'CZ', 'Doksy', 'Doksy', '50.5647', '14.6555', 'P', 'PPL', 'CZ.83', 'CZ.83.0511', '5025', 'Europe/Prague', '1', '2016-09-07 07:00:00', '2016-09-07 07:00:00');
INSERT INTO `cities` VALUES ('3076985', 'CZ', 'Dobruška', 'Dobruska', '50.292', '16.16', 'P', 'PPL', 'CZ.82', 'CZ.82.0524', '7085', 'Europe/Prague', '1', '2016-09-07 07:00:00', '2016-09-07 07:00:00');
INSERT INTO `cities` VALUES ('3077024', 'CZ', 'Dobříš', 'Dobris', '49.7811', '14.1672', 'P', 'PPL', 'CZ.88', 'CZ.88.020B', '7926', 'Europe/Prague', '1', '2017-02-12 07:00:00', '2017-02-12 07:00:00');
INSERT INTO `cities` VALUES ('3077073', 'CZ', 'Dobřany', 'Dobrany', '49.6548', '13.2931', 'P', 'PPL', 'CZ.87', 'CZ.87.0324', '5779', 'Europe/Prague', '1', '2017-02-08 07:00:00', '2017-02-08 07:00:00');
INSERT INTO `cities` VALUES ('3077244', 'CZ', 'Děčín', 'Decin', '50.7822', '14.2148', 'P', 'PPL', 'CZ.89', 'CZ.89.0421', '52058', 'Europe/Prague', '1', '2012-11-27 07:00:00', '2012-11-27 07:00:00');
INSERT INTO `cities` VALUES ('3077304', 'CZ', 'Dačice', 'Dacice', '49.0815', '15.4373', 'P', 'PPL', 'CZ.79', 'CZ.79.0313', '7958', 'Europe/Prague', '1', '2012-11-27 07:00:00', '2012-11-27 07:00:00');
INSERT INTO `cities` VALUES ('3077539', 'CZ', 'Chrudim', 'Chrudim', '49.9511', '15.7956', 'P', 'PPL', 'CZ.86', 'CZ.86.0531', '23630', 'Europe/Prague', '1', '2013-01-17 07:00:00', '2013-01-17 07:00:00');
INSERT INTO `cities` VALUES ('3077549', 'CZ', 'Chropyně', 'Chropyne', '49.3564', '17.3645', 'P', 'PPL', 'CZ.90', 'CZ.90.0721', '5172', 'Europe/Prague', '1', '2017-02-03 07:00:00', '2017-02-03 07:00:00');
INSERT INTO `cities` VALUES ('3077584', 'CZ', 'Chrastava', 'Chrastava', '50.8169', '14.9688', 'P', 'PPL', 'CZ.83', 'CZ.83.0513', '6051', 'Europe/Prague', '1', '2017-01-30 07:00:00', '2017-01-30 07:00:00');
INSERT INTO `cities` VALUES ('3077669', 'CZ', 'Chotěboř', 'Chotebor', '49.7207', '15.6702', 'P', 'PPL', 'CZ.80', 'CZ.80.0611', '9849', 'Europe/Prague', '1', '2017-01-23 07:00:00', '2017-01-23 07:00:00');
INSERT INTO `cities` VALUES ('3077685', 'CZ', 'Chomutov', 'Chomutov', '50.4605', '13.4178', 'P', 'PPL', 'CZ.89', 'CZ.89.0422', '50251', 'Europe/Prague', '1', '2013-01-04 07:00:00', '2013-01-04 07:00:00');
INSERT INTO `cities` VALUES ('3077706', 'CZ', 'Chodov', 'Chodov', '50.2402', '12.7455', 'P', 'PPL', 'CZ.81', 'CZ.81.0413', '14454', 'Europe/Prague', '1', '2017-01-26 07:00:00', '2017-01-26 07:00:00');
INSERT INTO `cities` VALUES ('3077725', 'CZ', 'Choceň', 'Chocen', '50.0016', '16.223', 'P', 'PPL', 'CZ.86', 'CZ.86.0534', '9008', 'Europe/Prague', '1', '2017-02-02 07:00:00', '2017-02-02 07:00:00');
INSERT INTO `cities` VALUES ('3077751', 'CZ', 'Chlumec nad Cidlinou', 'Chlumec nad Cidlinou', '50.1544', '15.4603', 'P', 'PPL', 'CZ.82', 'CZ.82.0521', '5292', 'Europe/Prague', '1', '2017-01-26 07:00:00', '2017-01-26 07:00:00');
INSERT INTO `cities` VALUES ('3077835', 'CZ', 'Cheb', 'Cheb', '50.0796', '12.3739', 'P', 'PPL', 'CZ.81', 'CZ.81.0411', '33242', 'Europe/Prague', '1', '2012-12-10 07:00:00', '2012-12-10 07:00:00');
INSERT INTO `cities` VALUES ('3077882', 'CZ', 'Český Těšín', 'Cesky Tesin', '49.7461', '18.6261', 'P', 'PPL', 'CZ.85', null, '25750', 'Europe/Prague', '1', '2013-08-18 07:00:00', '2013-08-18 07:00:00');
INSERT INTO `cities` VALUES ('3077889', 'CZ', 'Český Krumlov', 'Cesky Krumlov', '48.8109', '14.3152', 'P', 'PPL', 'CZ.79', 'CZ.79.0312', '14146', 'Europe/Prague', '1', '2014-09-12 07:00:00', '2014-09-12 07:00:00');
INSERT INTO `cities` VALUES ('3077898', 'CZ', 'Český Brod', 'Cesky Brod', '50.0742', '14.8608', 'P', 'PPL', 'CZ.88', 'CZ.88.0204', '6609', 'Europe/Prague', '1', '2017-02-09 07:00:00', '2017-02-09 07:00:00');
INSERT INTO `cities` VALUES ('3077916', 'CZ', 'České Budějovice', 'Ceske Budejovice', '48.9745', '14.4743', 'P', 'PPLA', 'CZ.79', 'CZ.79.0311', '96053', 'Europe/Prague', '1', '2014-08-28 07:00:00', '2014-08-28 07:00:00');
INSERT INTO `cities` VALUES ('3077920', 'CZ', 'Česká Třebová', 'Ceska Trebova', '49.9044', '16.4441', 'P', 'PPL', 'CZ.86', 'CZ.86.0534', '16655', 'Europe/Prague', '1', '2017-02-07 07:00:00', '2017-02-07 07:00:00');
INSERT INTO `cities` VALUES ('3077921', 'CZ', 'Česká Skalice', 'Ceska Skalice', '50.3947', '16.0428', 'P', 'PPL', 'CZ.82', 'CZ.82.0523', '5402', 'Europe/Prague', '1', '2013-01-11 07:00:00', '2013-01-11 07:00:00');
INSERT INTO `cities` VALUES ('3077929', 'CZ', 'Česká Lípa', 'Ceska Lipa', '50.6855', '14.5376', 'P', 'PPL', 'CZ.83', 'CZ.83.0511', '38841', 'Europe/Prague', '1', '2016-07-21 07:00:00', '2016-07-21 07:00:00');
INSERT INTO `cities` VALUES ('3077932', 'CZ', 'Česká Kamenice', 'Ceska Kamenice', '50.7978', '14.4177', 'P', 'PPL', 'CZ.89', 'CZ.89.0421', '5475', 'Europe/Prague', '1', '2017-02-06 07:00:00', '2017-02-06 07:00:00');
INSERT INTO `cities` VALUES ('3077955', 'CZ', 'Červený Kostelec', 'Cerveny Kostelec', '50.4763', '16.0929', 'P', 'PPL', 'CZ.82', 'CZ.82.0523', '8441', 'Europe/Prague', '1', '2013-01-11 07:00:00', '2013-01-11 07:00:00');
INSERT INTO `cities` VALUES ('3078160', 'CZ', 'Čelákovice', 'Celakovice', '50.1604', '14.75', 'P', 'PPL', 'CZ.88', 'CZ.88.0209', '10125', 'Europe/Prague', '1', '2017-02-11 07:00:00', '2017-02-11 07:00:00');
INSERT INTO `cities` VALUES ('3078234', 'CZ', 'Čáslav', 'Caslav', '49.911', '15.3897', 'P', 'PPL', 'CZ.88', 'CZ.88.0205', '10025', 'Europe/Prague', '1', '2007-10-01 07:00:00', '2007-10-01 07:00:00');
INSERT INTO `cities` VALUES ('3078286', 'CZ', 'Bystřice pod Hostýnem', 'Bystrice pod Hostynem', '49.3992', '17.674', 'P', 'PPL', 'CZ.90', 'CZ.90.0721', '8727', 'Europe/Prague', '1', '2017-02-03 07:00:00', '2017-02-03 07:00:00');
INSERT INTO `cities` VALUES ('3078288', 'CZ', 'Bystřice nad Pernštejnem', 'Bystrice nad Pernstejnem', '49.5229', '16.2615', 'P', 'PPL', 'CZ.80', 'CZ.80.0615', '8996', 'Europe/Prague', '1', '2017-01-25 07:00:00', '2017-01-25 07:00:00');
INSERT INTO `cities` VALUES ('3078301', 'CZ', 'Bystřice', 'Bystrice', '49.6366', '18.7204', 'P', 'PPL', 'CZ.85', 'CZ.85.0802', '5076', 'Europe/Prague', '1', '2016-09-07 07:00:00', '2016-09-07 07:00:00');
INSERT INTO `cities` VALUES ('3078503', 'CZ', 'Bučovice', 'Bucovice', '49.149', '17.0019', 'P', 'PPL', 'CZ.78', 'CZ.78.0626', '6386', 'Europe/Prague', '1', '2017-01-18 07:00:00', '2017-01-18 07:00:00');
INSERT INTO `cities` VALUES ('3078545', 'CZ', 'Bruntál', 'Bruntal', '49.9884', '17.4647', 'P', 'PPL', 'CZ.85', 'CZ.85.0801', '17686', 'Europe/Prague', '1', '2012-12-19 07:00:00', '2012-12-19 07:00:00');
INSERT INTO `cities` VALUES ('3078577', 'CZ', 'Broumov', 'Broumov', '50.5857', '16.3318', 'P', 'PPL', 'CZ.82', 'CZ.82.0523', '8254', 'Europe/Prague', '1', '2017-01-27 07:00:00', '2017-01-27 07:00:00');
INSERT INTO `cities` VALUES ('3078610', 'CZ', 'Brno', 'Brno', '49.1952', '16.608', 'P', 'PPLA', 'CZ.78', 'CZ.78.0622', '369559', 'Europe/Prague', '1', '2012-11-22 07:00:00', '2012-11-22 07:00:00');
INSERT INTO `cities` VALUES ('3078773', 'CZ', 'Břeclav', 'Breclav', '48.759', '16.882', 'P', 'PPL', 'CZ.78', 'CZ.78.0624', '25789', 'Europe/Prague', '1', '2012-12-13 07:00:00', '2012-12-13 07:00:00');
INSERT INTO `cities` VALUES ('3078833', 'CZ', 'Braník', 'Branik', '50.035', '14.4152', 'P', 'PPLX', 'CZ.52', null, '18740', 'Europe/Prague', '1', '2017-02-12 07:00:00', '2017-02-12 07:00:00');
INSERT INTO `cities` VALUES ('3078837', 'CZ', 'Brandýs nad Labem-Stará Boleslav', 'Brandys nad Labem-Stara Boleslav', '50.1871', '14.6633', 'P', 'PPL', 'CZ.88', 'CZ.88.0209', '15398', 'Europe/Prague', '1', '2017-02-11 07:00:00', '2017-02-11 07:00:00');
INSERT INTO `cities` VALUES ('3078910', 'CZ', 'Boskovice', 'Boskovice', '49.4875', '16.66', 'P', 'PPL', 'CZ.78', 'CZ.78.0621', '11121', 'Europe/Prague', '1', '2012-12-13 07:00:00', '2012-12-13 07:00:00');
INSERT INTO `cities` VALUES ('3079129', 'CZ', 'Bohumín', 'Bohumin', '49.9041', '18.3575', 'P', 'PPL', 'CZ.85', 'CZ.85.0803', '23075', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3079252', 'CZ', 'Blatná', 'Blatna', '49.4249', '13.8818', 'P', 'PPL', 'CZ.79', 'CZ.79.0316', '6735', 'Europe/Prague', '1', '2013-01-11 07:00:00', '2013-01-11 07:00:00');
INSERT INTO `cities` VALUES ('3079273', 'CZ', 'Blansko', 'Blansko', '49.363', '16.6445', 'P', 'PPL', 'CZ.78', 'CZ.78.0621', '20384', 'Europe/Prague', '1', '2012-11-16 07:00:00', '2012-11-16 07:00:00');
INSERT INTO `cities` VALUES ('3079336', 'CZ', 'Bílovec', 'Bilovec', '49.7564', '18.0158', 'P', 'PPL', 'CZ.85', 'CZ.85.0804', '7486', 'Europe/Prague', '1', '2017-02-01 07:00:00', '2017-02-01 07:00:00');
INSERT INTO `cities` VALUES ('3079346', 'CZ', 'Bílina Kyselka', 'Bilina Kyselka', '50.55', '13.7667', 'P', 'PPL', 'CZ.89', 'CZ.89.0426', '15697', 'Europe/Prague', '1', '2017-02-06 07:00:00', '2017-02-06 07:00:00');
INSERT INTO `cities` VALUES ('3079348', 'CZ', 'Bílina', 'Bilina', '50.5485', '13.7753', 'P', 'PPL', 'CZ.89', 'CZ.89.0426', '15738', 'Europe/Prague', '1', '2017-02-06 07:00:00', '2017-02-06 07:00:00');
INSERT INTO `cities` VALUES ('3079467', 'CZ', 'Beroun', 'Beroun', '49.9638', '14.072', 'P', 'PPL', 'CZ.88', 'CZ.88.0202', '17550', 'Europe/Prague', '1', '2012-11-23 07:00:00', '2012-11-23 07:00:00');
INSERT INTO `cities` VALUES ('3079508', 'CZ', 'Benešov', 'Benesov', '49.7816', '14.687', 'P', 'PPL', 'CZ.88', 'CZ.88.0201', '16257', 'Europe/Prague', '1', '2012-12-18 07:00:00', '2012-12-18 07:00:00');
INSERT INTO `cities` VALUES ('3079514', 'CZ', 'Benátky nad Jizerou', 'Benatky nad Jizerou', '50.2909', '14.8234', 'P', 'PPL', 'CZ.88', 'CZ.88.0207', '6818', 'Europe/Prague', '1', '2017-02-10 07:00:00', '2017-02-10 07:00:00');
INSERT INTO `cities` VALUES ('3079616', 'CZ', 'Bechyně', 'Bechyne', '49.2952', '14.4681', 'P', 'PPL', 'CZ.79', 'CZ.79.0317', '5755', 'Europe/Prague', '1', '2013-01-03 07:00:00', '2013-01-03 07:00:00');
INSERT INTO `cities` VALUES ('3079751', 'CZ', 'Aš', 'As', '50.2239', '12.195', 'P', 'PPL', 'CZ.81', 'CZ.81.0411', '12866', 'Europe/Prague', '1', '2017-01-25 07:00:00', '2017-01-25 07:00:00');
INSERT INTO `cities` VALUES ('6269470', 'CZ', 'Černý Most', 'Cerny Most', '50.1048', '14.5797', 'P', 'PPLX', 'CZ.52', null, '21500', 'Europe/Prague', '1', '2007-04-24 07:00:00', '2007-04-24 07:00:00');

-- ----------------------------
-- Table structure for continents
-- ----------------------------
DROP TABLE IF EXISTS `continents`;
CREATE TABLE `continents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of continents
-- ----------------------------
INSERT INTO `continents` VALUES ('1', 'AF', 'Africa', '1');
INSERT INTO `continents` VALUES ('2', 'AN', 'Antarctica', '1');
INSERT INTO `continents` VALUES ('3', 'AS', 'Asia', '1');
INSERT INTO `continents` VALUES ('4', 'EU', 'Europe', '1');
INSERT INTO `continents` VALUES ('5', 'NA', 'North America', '1');
INSERT INTO `continents` VALUES ('6', 'OC', 'Oceania', '1');
INSERT INTO `continents` VALUES ('7', 'SA', 'South America', '1');

-- ----------------------------
-- Table structure for countries
-- ----------------------------
DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `iso3` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iso_numeric` int(10) unsigned DEFAULT NULL,
  `fips` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `asciiname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `capital` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area` int(10) unsigned DEFAULT NULL,
  `population` int(10) unsigned DEFAULT NULL,
  `continent_code` char(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tld` char(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_code` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code_format` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code_regex` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `languages` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `neighbours` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `equivalent_fips_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `background_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_type` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `admin_field_active` tinyint(1) unsigned DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of countries
-- ----------------------------
INSERT INTO `countries` VALUES ('1', 'AD', 'AND', '20', 'AN', 'Andorra', 'Andorra', 'Andorra la Vella', '468', '84000', 'EU', '.ad', 'EUR', '376', 'AD###', '^(?:AD)*(d{3})$', 'ca', 'ES,FR', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('2', 'AE', 'ARE', '784', 'AE', 'al-Imārāt', 'United Arab Emirates', 'Abu Dhabi', '82880', '4975593', 'AS', '.ae', 'AED', '971', '', '', 'ar-AE,fa,en,hi,ur', 'SA,OM', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('3', 'AF', 'AFG', '4', 'AF', 'Afġānistān', 'Afghanistan', 'Kabul', '647500', '29121286', 'AS', '.af', 'AFN', '93', '', '', 'fa-AF,ps,uz-AF,tk', 'TM,CN,IR,TJ,PK,UZ', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('4', 'AG', 'ATG', '28', 'AC', 'Antigua and Barbuda', 'Antigua and Barbuda', 'St. John\'s', '443', '86754', 'NA', '.ag', 'XCD', '+1-268', '', '', 'en-AG', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('5', 'AI', 'AIA', '660', 'AV', 'Anguilla', 'Anguilla', 'The Valley', '102', '13254', 'NA', '.ai', 'XCD', '+1-264', '', '', 'en-AI', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('6', 'AL', 'ALB', '8', 'AL', 'Shqipëria', 'Albania', 'Tirana', '28748', '2986952', 'EU', '.al', 'ALL', '355', '', '', 'sq,el', 'MK,GR,ME,RS,XK', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('7', 'AM', 'ARM', '51', 'AM', 'Hayastan', 'Armenia', 'Yerevan', '29800', '2968000', 'AS', '.am', 'AMD', '374', '######', '^(d{6})$', 'hy', 'GE,IR,AZ,TR', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('8', 'AN', 'ANT', '530', 'NT', 'Netherlands Antilles', 'Netherlands Antilles', 'Willemstad', '960', '136197', 'NA', '.an', 'ANG', '599', '', '', 'nl-AN,en,es', 'GP', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('9', 'AO', 'AGO', '24', 'AO', 'Angola', 'Angola', 'Luanda', '1246700', '13068161', 'AF', '.ao', 'AOA', '244', '', '', 'pt-AO', 'CD,NA,ZM,CG', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('10', 'AQ', 'ATA', '10', 'AY', 'Antarctica', 'Antarctica', '', '14000000', '0', 'AN', '.aq', '', '', '', '', '', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('11', 'AR', 'ARG', '32', 'AR', 'Argentina', 'Argentina', 'Buenos Aires', '2766890', '41343201', 'SA', '.ar', 'ARS', '54', '@####@@@', '^([A-Z]d{4}[A-Z]{3})$', 'es-AR,en,it,de,fr,gn', 'CL,BO,UY,PY,BR', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('12', 'AS', 'ASM', '16', 'AQ', 'American Samoa', 'American Samoa', 'Pago Pago', '199', '57881', 'OC', '.as', 'USD', '+1-684', '', '', 'en-AS,sm,to', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('13', 'AT', 'AUT', '40', 'AU', 'Österreich', 'Austria', 'Vienna', '83858', '8205000', 'EU', '.at', 'EUR', '43', '####', '^(d{4})$', 'de-AT,hr,hu,sl', 'CH,DE,HU,SK,CZ,IT,SI,LI', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('14', 'AU', 'AUS', '36', 'AS', 'Australia', 'Australia', 'Canberra', '7686850', '21515754', 'OC', '.au', 'AUD', '61', '####', '^(d{4})$', 'en-AU', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('15', 'AW', 'ABW', '533', 'AA', 'Aruba', 'Aruba', 'Oranjestad', '193', '71566', 'NA', '.aw', 'AWG', '297', '', '', 'nl-AW,es,en', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('16', 'AX', 'ALA', '248', '', 'Aland Islands', 'Aland Islands', 'Mariehamn', '1580', '26711', 'EU', '.ax', 'EUR', '+358-18', '#####', '^(?:FI)*(d{5})$', 'sv-AX', '', 'FI', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('17', 'AZ', 'AZE', '31', 'AJ', 'Azərbaycan', 'Azerbaijan', 'Baku', '86600', '8303512', 'AS', '.az', 'AZN', '994', 'AZ ####', '^(?:AZ)*(d{4})$', 'az,ru,hy', 'GE,IR,AM,TR,RU', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('18', 'BA', 'BIH', '70', 'BK', 'Bosna i Hercegovina', 'Bosnia and Herzegovina', 'Sarajevo', '51129', '4590000', 'EU', '.ba', 'BAM', '387', '#####', '^(d{5})$', 'bs,hr-BA,sr-BA', 'HR,ME,RS', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('19', 'BB', 'BRB', '52', 'BB', 'Barbados', 'Barbados', 'Bridgetown', '431', '285653', 'NA', '.bb', 'BBD', '+1-246', 'BB#####', '^(?:BB)*(d{5})$', 'en-BB', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('20', 'BD', 'BGD', '50', 'BG', 'Bāṅlādēś', 'Bangladesh', 'Dhaka', '144000', '156118464', 'AS', '.bd', 'BDT', '880', '####', '^(d{4})$', 'bn-BD,en', 'MM,IN', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('21', 'BE', 'BEL', '56', 'BE', 'Belgique', 'Belgium', 'Brussels', '30510', '10403000', 'EU', '.be', 'EUR', '32', '####', '^(d{4})$', 'nl-BE,fr-BE,de-BE', 'DE,NL,LU,FR', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('22', 'BF', 'BFA', '854', 'UV', 'Burkina Faso', 'Burkina Faso', 'Ouagadougou', '274200', '16241811', 'AF', '.bf', 'XOF', '226', '', '', 'fr-BF', 'NE,BJ,GH,CI,TG,ML', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('23', 'BG', 'BGR', '100', 'BU', 'Bŭlgarija', 'Bulgaria', 'Sofia', '110910', '7148785', 'EU', '.bg', 'BGN', '359', '####', '^(d{4})$', 'bg,tr-BG,rom', 'MK,GR,RO,TR,RS', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('24', 'BH', 'BHR', '48', 'BA', 'al-Baḥrayn', 'Bahrain', 'Manama', '665', '738004', 'AS', '.bh', 'BHD', '973', '####|###', '^(d{3}d?)$', 'ar-BH,en,fa,ur', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('25', 'BI', 'BDI', '108', 'BY', 'Burundi', 'Burundi', 'Bujumbura', '27830', '9863117', 'AF', '.bi', 'BIF', '257', '', '', 'fr-BI,rn', 'TZ,CD,RW', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('26', 'BJ', 'BEN', '204', 'BN', 'Bénin', 'Benin', 'Porto-Novo', '112620', '9056010', 'AF', '.bj', 'XOF', '+229', '', '', 'fr-BJ', 'NE,TG,BF,NG', '', null, '0', '0', '0', null, '2016-05-10 04:55:29');
INSERT INTO `countries` VALUES ('27', 'BL', 'BLM', '652', 'TB', 'Saint Barthelemy', 'Saint Barthelemy', 'Gustavia', '21', '8450', 'NA', '.gp', 'EUR', '590', '### ###', '', 'fr', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('28', 'BM', 'BMU', '60', 'BD', 'Bermuda', 'Bermuda', 'Hamilton', '53', '65365', 'NA', '.bm', 'BMD', '+1-441', '@@ ##', '^([A-Z]{2}d{2})$', 'en-BM,pt', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('29', 'BN', 'BRN', '96', 'BX', 'Brunei Darussalam', 'Brunei', 'Bandar Seri Begawan', '5770', '395027', 'AS', '.bn', 'BND', '673', '@@####', '^([A-Z]{2}d{4})$', 'ms-BN,en-BN', 'MY', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('30', 'BO', 'BOL', '68', 'BL', 'Bolivia', 'Bolivia', 'Sucre', '1098580', '9947418', 'SA', '.bo', 'BOB', '591', '', '', 'es-BO,qu,ay', 'PE,CL,PY,BR,AR', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('31', 'BQ', 'BES', '535', '', 'Bonaire, Saint Eustatius and Saba ', 'Bonaire, Saint Eustatius and Saba ', '', '328', '18012', 'NA', '.bq', 'USD', '599', '', '', 'nl,pap,en', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('32', 'BR', 'BRA', '76', 'BR', 'Brasil', 'Brazil', 'Brasilia', '8511965', '201103330', 'SA', '.br', 'BRL', '55', '#####-###', '^(d{8})$', 'pt-BR,es,en,fr', 'SR,PE,BO,UY,GY,PY,GF,VE,CO,AR', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('33', 'BS', 'BHS', '44', 'BF', 'Bahamas', 'Bahamas', 'Nassau', '13940', '301790', 'NA', '.bs', 'BSD', '+1-242', '', '', 'en-BS', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('34', 'BT', 'BTN', '64', 'BT', 'Druk-yul', 'Bhutan', 'Thimphu', '47000', '699847', 'AS', '.bt', 'BTN', '975', '', '', 'dz', 'CN,IN', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('35', 'BV', 'BVT', '74', 'BV', 'Bouvet Island', 'Bouvet Island', '', '49', '0', 'AN', '.bv', 'NOK', '', '', '', '', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('36', 'BW', 'BWA', '72', 'BC', 'Botswana', 'Botswana', 'Gaborone', '600370', '2029307', 'AF', '.bw', 'BWP', '267', '', '', 'en-BW,tn-BW', 'ZW,ZA,NA', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('37', 'BY', 'BLR', '112', 'BO', 'Biełaruś', 'Belarus', 'Minsk', '207600', '9685000', 'EU', '.by', 'BYR', '375', '######', '^(d{6})$', 'be,ru', 'PL,LT,UA,RU,LV', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('38', 'BZ', 'BLZ', '84', 'BH', 'Belize', 'Belize', 'Belmopan', '22966', '314522', 'NA', '.bz', 'BZD', '501', '', '', 'en-BZ,es', 'GT,MX', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('39', 'CA', 'CAN', '124', 'CA', 'Canada', 'Canada', 'Ottawa', '9984670', '33679000', 'NA', '.ca', 'CAD', '1', '@#@ #@#', '^([ABCEGHJKLMNPRSTVXY]d[ABCEGHJKLMNPRSTVWXYZ]) ?(d[ABCEGHJKLMNPRSTVWXYZ]d)$ ', 'en-CA,fr-CA,iu', 'US', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('40', 'CC', 'CCK', '166', 'CK', 'Cocos Islands', 'Cocos Islands', 'West Island', '14', '628', 'AS', '.cc', 'AUD', '61', '', '', 'ms-CC,en', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('41', 'CD', 'COD', '180', 'CG', 'RDC', 'Democratic Republic of the Congo', 'Kinshasa', '2345410', '70916439', 'AF', '.cd', 'CDF', '243', '', '', 'fr-CD,ln,kg', 'TZ,CF,SS,RW,ZM,BI,UG,CG,AO', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('42', 'CF', 'CAF', '140', 'CT', 'Centrafrique', 'Central African Republic', 'Bangui', '622984', '4844927', 'AF', '.cf', 'XAF', '236', '', '', 'fr-CF,sg,ln,kg', 'TD,SD,CD,SS,CM,CG', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('43', 'CG', 'COG', '178', 'CF', 'Congo', 'Republic of the Congo', 'Brazzaville', '342000', '3039126', 'AF', '.cg', 'XAF', '242', '', '', 'fr-CG,kg,ln-CG', 'CF,GA,CD,CM,AO', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('44', 'CH', 'CHE', '756', 'SZ', 'Switzerland', 'Switzerland', 'Berne', '41290', '7581000', 'EU', '.ch', 'CHF', '41', '####', '^(d{4})$', 'de-CH,fr-CH,it-CH,rm', 'DE,IT,LI,FR,AT', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('45', 'CI', 'CIV', '384', 'IV', 'Côte d\'Ivoire', 'Ivory Coast', 'Yamoussoukro', '322460', '21058798', 'AF', '.ci', 'XOF', '225', '', '', 'fr-CI', 'LR,GH,GN,BF,ML', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('46', 'CK', 'COK', '184', 'CW', 'Cook Islands', 'Cook Islands', 'Avarua', '240', '21388', 'OC', '.ck', 'NZD', '682', '', '', 'en-CK,mi', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('47', 'CL', 'CHL', '152', 'CI', 'Chile', 'Chile', 'Santiago', '756950', '16746491', 'SA', '.cl', 'CLP', '56', '#######', '^(d{7})$', 'es-CL', 'PE,BO,AR', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('48', 'CM', 'CMR', '120', 'CM', 'Cameroun', 'Cameroon', 'Yaounde', '475440', '19294149', 'AF', '.cm', 'XAF', '237', '', '', 'fr-CM,en-CM', 'TD,CF,GA,GQ,CG,NG', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('49', 'CN', 'CHN', '156', 'CH', 'Zhōngguó', 'China', 'Beijing', '9596960', '1330044000', 'AS', '.cn', 'CNY', '86', '######', '^(d{6})$', 'zh-CN,yue,wuu,dta,ug,za', 'LA,BT,TJ,KZ,MN,AF,NP,MM,KG,PK,KP,RU,VN,IN', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('50', 'CO', 'COL', '170', 'CO', 'Colombia', 'Colombia', 'Bogota', '1138910', '47790000', 'SA', '.co', 'COP', '57', '', '', 'es-CO', 'EC,PE,PA,BR,VE', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('51', 'CR', 'CRI', '188', 'CS', 'Costa Rica', 'Costa Rica', 'San Jose', '51100', '4516220', 'NA', '.cr', 'CRC', '506', '####', '^(d{4})$', 'es-CR,en', 'PA,NI', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('52', 'CS', 'SCG', '891', 'YI', 'Serbia and Montenegro', 'Serbia and Montenegro', 'Belgrade', '102350', '10829175', 'EU', '.cs', 'RSD', '381', '#####', '^(d{5})$', 'cu,hu,sq,sr', 'AL,HU,MK,RO,HR,BA,BG', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('53', 'CU', 'CUB', '192', 'CU', 'Cuba', 'Cuba', 'Havana', '110860', '11423000', 'NA', '.cu', 'CUP', '53', 'CP #####', '^(?:CP)*(d{5})$', 'es-CU', 'US', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('54', 'CV', 'CPV', '132', 'CV', 'Cabo Verde', 'Cape Verde', 'Praia', '4033', '508659', 'AF', '.cv', 'CVE', '238', '####', '^(d{4})$', 'pt-CV', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('55', 'CW', 'CUW', '531', 'UC', 'Curacao', 'Curacao', ' Willemstad', '444', '141766', 'NA', '.cw', 'ANG', '599', '', '', 'nl,pap', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('56', 'CX', 'CXR', '162', 'KT', 'Christmas Island', 'Christmas Island', 'Flying Fish Cove', '135', '1500', 'AS', '.cx', 'AUD', '61', '####', '^(d{4})$', 'en,zh,ms-CC', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('57', 'CY', 'CYP', '196', 'CY', 'Kýpros (Kıbrıs)', 'Cyprus', 'Nicosia', '9250', '1102677', 'EU', '.cy', 'EUR', '357', '####', '^(d{4})$', 'el-CY,tr-CY,en', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('58', 'CZ', 'CZE', '203', 'EZ', 'Česko', 'Czech Republic', 'Prague', '78866', '10476000', 'EU', '.cz', 'CZK', '420', '### ##', '^(d{5})$', 'cs,sk', 'PL,DE,SK,AT', '', null, '0', '0', '1', null, null);
INSERT INTO `countries` VALUES ('59', 'DE', 'DEU', '276', 'GM', 'Deutschland', 'Germany', 'Berlin', '357021', '81802257', 'EU', '.de', 'EUR', '49', '#####', '^(d{5})$', 'de', 'CH,PL,NL,DK,BE,CZ,LU,FR,AT', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('60', 'DJ', 'DJI', '262', 'DJ', 'Djibouti', 'Djibouti', 'Djibouti', '23000', '740528', 'AF', '.dj', 'DJF', '253', '', '', 'fr-DJ,ar,so-DJ,aa', 'ER,ET,SO', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('61', 'DK', 'DNK', '208', 'DA', 'Danmark', 'Denmark', 'Copenhagen', '43094', '5484000', 'EU', '.dk', 'DKK', '45', '####', '^(d{4})$', 'da-DK,en,fo,de-DK', 'DE', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('62', 'DM', 'DMA', '212', 'DO', 'Dominica', 'Dominica', 'Roseau', '754', '72813', 'NA', '.dm', 'XCD', '+1-767', '', '', 'en-DM', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('63', 'DO', 'DOM', '214', 'DR', 'República Dominicana', 'Dominican Republic', 'Santo Domingo', '48730', '9823821', 'NA', '.do', 'DOP', '+809/829/849', '#####', '^(d{5})$', 'es-DO', 'HT', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('64', 'DZ', 'DZA', '12', 'AG', 'Algérie', 'Algeria', 'Algiers', '2381740', '34586184', 'AF', '.dz', 'DZD', '213', '#####', '^(d{5})$', 'ar-DZ,fr', 'NE,EH,LY,MR,TN,MA,ML', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('65', 'EC', 'ECU', '218', 'EC', 'Ecuador', 'Ecuador', 'Quito', '283560', '14790608', 'SA', '.ec', 'USD', '593', '@####@', '^([a-zA-Z]d{4}[a-zA-Z])$', 'es-EC', 'PE,CO', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('66', 'EE', 'EST', '233', 'EN', 'Eesti', 'Estonia', 'Tallinn', '45226', '1291170', 'EU', '.ee', 'EUR', '372', '#####', '^(d{5})$', 'et,ru', 'RU,LV', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('67', 'EG', 'EGY', '818', 'EG', 'Egypt', 'Egypt', 'Cairo', '1001450', '80471869', 'AF', '.eg', 'EGP', '20', '#####', '^(d{5})$', 'ar-EG,en,fr', 'LY,SD,IL,PS', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('68', 'EH', 'ESH', '732', 'WI', 'aṣ-Ṣaḥrāwīyâ al-ʿArabīyâ', 'Western Sahara', 'El-Aaiun', '266000', '273008', 'AF', '.eh', 'MAD', '212', '', '', 'ar,mey', 'DZ,MR,MA', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('69', 'ER', 'ERI', '232', 'ER', 'Ertrā', 'Eritrea', 'Asmara', '121320', '5792984', 'AF', '.er', 'ERN', '291', '', '', 'aa-ER,ar,tig,kun,ti-ER', 'ET,SD,DJ', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('70', 'ES', 'ESP', '724', 'SP', 'España', 'Spain', 'Madrid', '504782', '46505963', 'EU', '.es', 'EUR', '34', '#####', '^(d{5})$', 'es-ES,ca,gl,eu,oc', 'AD,PT,GI,FR,MA', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('71', 'ET', 'ETH', '231', 'ET', 'Ityoṗya', 'Ethiopia', 'Addis Ababa', '1127127', '88013491', 'AF', '.et', 'ETB', '251', '####', '^(d{4})$', 'am,en-ET,om-ET,ti-ET,so-ET,sid', 'ER,KE,SD,SS,SO,DJ', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('72', 'FI', 'FIN', '246', 'FI', 'Suomi (Finland)', 'Finland', 'Helsinki', '337030', '5244000', 'EU', '.fi', 'EUR', '358', '#####', '^(?:FI)*(d{5})$', 'fi-FI,sv-FI,smn', 'NO,RU,SE', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('73', 'FJ', 'FJI', '242', 'FJ', 'Viti', 'Fiji', 'Suva', '18270', '875983', 'OC', '.fj', 'FJD', '679', '', '', 'en-FJ,fj', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('74', 'FK', 'FLK', '238', 'FK', 'Falkland Islands', 'Falkland Islands', 'Stanley', '12173', '2638', 'SA', '.fk', 'FKP', '500', '', '', 'en-FK', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('75', 'FM', 'FSM', '583', 'FM', 'Micronesia', 'Micronesia', 'Palikir', '702', '107708', 'OC', '.fm', 'USD', '691', '#####', '^(d{5})$', 'en-FM,chk,pon,yap,kos,uli,woe,nkr,kpg', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('76', 'FO', 'FRO', '234', 'FO', 'Føroyar', 'Faroe Islands', 'Torshavn', '1399', '48228', 'EU', '.fo', 'DKK', '298', 'FO-###', '^(?:FO)*(d{3})$', 'fo,da-FO', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('77', 'FR', 'FRA', '250', 'FR', 'France', 'France', 'Paris', '547030', '64768389', 'EU', '.fr', 'EUR', '33', '#####', '^(d{5})$', 'fr-FR,frp,br,co,ca,eu,oc', 'CH,DE,BE,LU,IT,AD,MC,ES', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('78', 'GA', 'GAB', '266', 'GB', 'Gabon', 'Gabon', 'Libreville', '267667', '1545255', 'AF', '.ga', 'XAF', '241', '', '', 'fr-GA', 'CM,GQ,CG', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('79', 'GD', 'GRD', '308', 'GJ', 'Grenada', 'Grenada', 'St. George\'s', '344', '107818', 'NA', '.gd', 'XCD', '+1-473', '', '', 'en-GD', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('80', 'GE', 'GEO', '268', 'GG', 'Sak\'art\'velo', 'Georgia', 'Tbilisi', '69700', '4630000', 'AS', '.ge', 'GEL', '995', '####', '^(d{4})$', 'ka,ru,hy,az', 'AM,AZ,TR,RU', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('81', 'GF', 'GUF', '254', 'FG', 'Guyane', 'French Guiana', 'Cayenne', '91000', '195506', 'SA', '.gf', 'EUR', '594', '#####', '^((97|98)3d{2})$', 'fr-GF', 'SR,BR', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('82', 'GG', 'GGY', '831', 'GK', 'Guernsey', 'Guernsey', 'St Peter Port', '78', '65228', 'EU', '.gg', 'GBP', '+44-1481', '@# #@@|@## #@@|@@# #@@|@@## #@@|@#@ #@@|@@#@ #@@|G', '^(([A-Z]d{2}[A-Z]{2})|([A-Z]d{3}[A-Z]{2})|([A-Z]{2}d{2}[A-Z]{2})|([A-Z]{2}d{3}[A-Z]{2})|([A-Z]d[A-Z]d[A-Z]{2})|([A-Z]{2}d[A-Z]d[A-Z]{2})|(GIR0AA))$', 'en,fr', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('83', 'GH', 'GHA', '288', 'GH', 'Ghana', 'Ghana', 'Accra', '239460', '24339838', 'AF', '.gh', 'GHS', '233', '', '', 'en-GH,ak,ee,tw', 'CI,TG,BF', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('84', 'GI', 'GIB', '292', 'GI', 'Gibraltar', 'Gibraltar', 'Gibraltar', '7', '27884', 'EU', '.gi', 'GIP', '350', '', '', 'en-GI,es,it,pt', 'ES', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('85', 'GL', 'GRL', '304', 'GL', 'Grønland', 'Greenland', 'Nuuk', '2166086', '56375', 'NA', '.gl', 'DKK', '299', '####', '^(d{4})$', 'kl,da-GL,en', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('86', 'GM', 'GMB', '270', 'GA', 'Gambia', 'Gambia', 'Banjul', '11300', '1593256', 'AF', '.gm', 'GMD', '220', '', '', 'en-GM,mnk,wof,wo,ff', 'SN', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('87', 'GN', 'GIN', '324', 'GV', 'Guinée', 'Guinea', 'Conakry', '245857', '10324025', 'AF', '.gn', 'GNF', '224', '', '', 'fr-GN', 'LR,SN,SL,CI,GW,ML', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('88', 'GP', 'GLP', '312', 'GP', 'Guadeloupe', 'Guadeloupe', 'Basse-Terre', '1780', '443000', 'NA', '.gp', 'EUR', '590', '#####', '^((97|98)d{3})$', 'fr-GP', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('89', 'GQ', 'GNQ', '226', 'EK', 'Guinée Equatoriale', 'Equatorial Guinea', 'Malabo', '28051', '1014999', 'AF', '.gq', 'XAF', '240', '', '', 'es-GQ,fr', 'GA,CM', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('90', 'GR', 'GRC', '300', 'GR', 'Elláda', 'Greece', 'Athens', '131940', '11000000', 'EU', '.gr', 'EUR', '30', '### ##', '^(d{5})$', 'el-GR,en,fr', 'AL,MK,TR,BG', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('91', 'GS', 'SGS', '239', 'SX', 'South Georgia and the South Sandwich Islands', 'South Georgia and the South Sandwich Islands', 'Grytviken', '3903', '30', 'AN', '.gs', 'GBP', '', '', '', 'en', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('92', 'GT', 'GTM', '320', 'GT', 'Guatemala', 'Guatemala', 'Guatemala City', '108890', '13550440', 'NA', '.gt', 'GTQ', '502', '#####', '^(d{5})$', 'es-GT', 'MX,HN,BZ,SV', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('93', 'GU', 'GUM', '316', 'GQ', 'Guam', 'Guam', 'Hagatna', '549', '159358', 'OC', '.gu', 'USD', '+1-671', '969##', '^(969d{2})$', 'en-GU,ch-GU', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('94', 'GW', 'GNB', '624', 'PU', 'Guiné-Bissau', 'Guinea-Bissau', 'Bissau', '36120', '1565126', 'AF', '.gw', 'XOF', '245', '####', '^(d{4})$', 'pt-GW,pov', 'SN,GN', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('95', 'GY', 'GUY', '328', 'GY', 'Guyana', 'Guyana', 'Georgetown', '214970', '748486', 'SA', '.gy', 'GYD', '592', '', '', 'en-GY', 'SR,BR,VE', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('96', 'HK', 'HKG', '344', 'HK', 'Hèunggóng', 'Hong Kong', 'Hong Kong', '1092', '6898686', 'AS', '.hk', 'HKD', '852', '', '', 'zh-HK,yue,zh,en', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('97', 'HM', 'HMD', '334', 'HM', 'Heard Island and McDonald Islands', 'Heard Island and McDonald Islands', '', '412', '0', 'AN', '.hm', 'AUD', ' ', '', '', '', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('98', 'HN', 'HND', '340', 'HO', 'Honduras', 'Honduras', 'Tegucigalpa', '112090', '7989415', 'NA', '.hn', 'HNL', '504', '@@####', '^([A-Z]{2}d{4})$', 'es-HN', 'GT,NI,SV', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('99', 'HR', 'HRV', '191', 'HR', 'Hrvatska', 'Croatia', 'Zagreb', '56542', '4491000', 'EU', '.hr', 'HRK', '385', '#####', '^(?:HR)*(d{5})$', 'hr-HR,sr', 'HU,SI,BA,ME,RS', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('100', 'HT', 'HTI', '332', 'HA', 'Haïti', 'Haiti', 'Port-au-Prince', '27750', '9648924', 'NA', '.ht', 'HTG', '509', 'HT####', '^(?:HT)*(d{4})$', 'ht,fr-HT', 'DO', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('101', 'HU', 'HUN', '348', 'HU', 'Magyarország', 'Hungary', 'Budapest', '93030', '9982000', 'EU', '.hu', 'HUF', '36', '####', '^(d{4})$', 'hu-HU', 'SK,SI,RO,UA,HR,AT,RS', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('102', 'ID', 'IDN', '360', 'ID', 'Indonesia', 'Indonesia', 'Jakarta', '1919440', '242968342', 'AS', '.id', 'IDR', '62', '#####', '^(d{5})$', 'id,en,nl,jv', 'PG,TL,MY', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('103', 'IE', 'IRL', '372', 'EI', 'Ireland', 'Ireland', 'Dublin', '70280', '4622917', 'EU', '.ie', 'EUR', '353', '', '', 'en-IE,ga-IE', 'GB', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('104', 'IL', 'ISR', '376', 'IS', 'Yiśrā\'ēl', 'Israel', 'Jerusalem', '20770', '7353985', 'AS', '.il', 'ILS', '972', '#####', '^(d{5})$', 'he,ar-IL,en-IL,', 'SY,JO,LB,EG,PS', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('105', 'IM', 'IMN', '833', 'IM', 'Isle of Man', 'Isle of Man', 'Douglas, Isle of Man', '572', '75049', 'EU', '.im', 'GBP', '+44-1624', '@# #@@|@## #@@|@@# #@@|@@## #@@|@#@ #@@|@@#@ #@@|G', '^(([A-Z]d{2}[A-Z]{2})|([A-Z]d{3}[A-Z]{2})|([A-Z]{2}d{2}[A-Z]{2})|([A-Z]{2}d{3}[A-Z]{2})|([A-Z]d[A-Z]d[A-Z]{2})|([A-Z]{2}d[A-Z]d[A-Z]{2})|(GIR0AA))$', 'en,gv', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('106', 'IN', 'IND', '356', 'IN', 'Bhārat', 'India', 'New Delhi', '3287590', '1173108018', 'AS', '.in', 'INR', '91', '######', '^(d{6})$', 'en-IN,hi,bn,te,mr,ta,ur,gu,kn,ml,or,pa,as,bh,sat,k', 'CN,NP,MM,BT,PK,BD', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('107', 'IO', 'IOT', '86', 'IO', 'British Indian Ocean Territory', 'British Indian Ocean Territory', 'Diego Garcia', '60', '4000', 'AS', '.io', 'USD', '246', '', '', 'en-IO', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('108', 'IQ', 'IRQ', '368', 'IZ', 'al-ʿIrāq', 'Iraq', 'Baghdad', '437072', '29671605', 'AS', '.iq', 'IQD', '964', '#####', '^(d{5})$', 'ar-IQ,ku,hy', 'SY,SA,IR,JO,TR,KW', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('109', 'IR', 'IRN', '364', 'IR', 'Īrān', 'Iran', 'Tehran', '1648000', '76923300', 'AS', '.ir', 'IRR', '98', '##########', '^(d{10})$', 'fa-IR,ku', 'TM,AF,IQ,AM,PK,AZ,TR', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('110', 'IS', 'ISL', '352', 'IC', 'Ísland', 'Iceland', 'Reykjavik', '103000', '308910', 'EU', '.is', 'ISK', '354', '###', '^(d{3})$', 'is,en,de,da,sv,no', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('111', 'IT', 'ITA', '380', 'IT', 'Italia', 'Italy', 'Rome', '301230', '60340328', 'EU', '.it', 'EUR', '39', '#####', '^(d{5})$', 'it-IT,en,de-IT,fr-IT,sc,ca,co,sl', 'CH,VA,SI,SM,FR,AT', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('112', 'JE', 'JEY', '832', 'JE', 'Jersey', 'Jersey', 'Saint Helier', '116', '90812', 'EU', '.je', 'GBP', '+44-1534', '@# #@@|@## #@@|@@# #@@|@@## #@@|@#@ #@@|@@#@ #@@|G', '^(([A-Z]d{2}[A-Z]{2})|([A-Z]d{3}[A-Z]{2})|([A-Z]{2}d{2}[A-Z]{2})|([A-Z]{2}d{3}[A-Z]{2})|([A-Z]d[A-Z]d[A-Z]{2})|([A-Z]{2}d[A-Z]d[A-Z]{2})|(GIR0AA))$', 'en,pt', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('113', 'JM', 'JAM', '388', 'JM', 'Jamaica', 'Jamaica', 'Kingston', '10991', '2847232', 'NA', '.jm', 'JMD', '+1-876', '', '', 'en-JM', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('114', 'JO', 'JOR', '400', 'JO', 'al-Urdun', 'Jordan', 'Amman', '92300', '6407085', 'AS', '.jo', 'JOD', '962', '#####', '^(d{5})$', 'ar-JO,en', 'SY,SA,IQ,IL,PS', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('115', 'JP', 'JPN', '392', 'JA', 'Nihon', 'Japan', 'Tokyo', '377835', '127288000', 'AS', '.jp', 'JPY', '81', '###-####', '^(d{7})$', 'ja', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('116', 'KE', 'KEN', '404', 'KE', 'Kenya', 'Kenya', 'Nairobi', '582650', '40046566', 'AF', '.ke', 'KES', '254', '#####', '^(d{5})$', 'en-KE,sw-KE', 'ET,TZ,SS,SO,UG', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('117', 'KG', 'KGZ', '417', 'KG', 'Kyrgyzstan', 'Kyrgyzstan', 'Bishkek', '198500', '5508626', 'AS', '.kg', 'KGS', '996', '######', '^(d{6})$', 'ky,uz,ru', 'CN,TJ,UZ,KZ', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('118', 'KH', 'KHM', '116', 'CB', 'Kambucā', 'Cambodia', 'Phnom Penh', '181040', '14453680', 'AS', '.kh', 'KHR', '855', '#####', '^(d{5})$', 'km,fr,en', 'LA,TH,VN', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('119', 'KI', 'KIR', '296', 'KR', 'Kiribati', 'Kiribati', 'Tarawa', '811', '92533', 'OC', '.ki', 'AUD', '686', '', '', 'en-KI,gil', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('120', 'KM', 'COM', '174', 'CN', 'Comores', 'Comoros', 'Moroni', '2170', '773407', 'AF', '.km', 'KMF', '269', '', '', 'ar,fr-KM', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('121', 'KN', 'KNA', '659', 'SC', 'Saint Kitts and Nevis', 'Saint Kitts and Nevis', 'Basseterre', '261', '51134', 'NA', '.kn', 'XCD', '+1-869', '', '', 'en-KN', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('122', 'KP', 'PRK', '408', 'KN', 'Joseon', 'North Korea', 'Pyongyang', '120540', '22912177', 'AS', '.kp', 'KPW', '850', '###-###', '^(d{6})$', 'ko-KP', 'CN,KR,RU', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('123', 'KR', 'KOR', '410', 'KS', 'Hanguk', 'South Korea', 'Seoul', '98480', '48422644', 'AS', '.kr', 'KRW', '82', 'SEOUL ###-###', '^(?:SEOUL)*(d{6})$', 'ko-KR,en', 'KP', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('124', 'KW', 'KWT', '414', 'KU', 'al-Kuwayt', 'Kuwait', 'Kuwait City', '17820', '2789132', 'AS', '.kw', 'KWD', '965', '#####', '^(d{5})$', 'ar-KW,en', 'SA,IQ', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('125', 'KY', 'CYM', '136', 'CJ', 'Cayman Islands', 'Cayman Islands', 'George Town', '262', '44270', 'NA', '.ky', 'KYD', '+1-345', '', '', 'en-KY', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('126', 'KZ', 'KAZ', '398', 'KZ', 'Ķazaķstan', 'Kazakhstan', 'Astana', '2717300', '15340000', 'AS', '.kz', 'KZT', '7', '######', '^(d{6})$', 'kk,ru', 'TM,CN,KG,UZ,RU', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('127', 'LA', 'LAO', '418', 'LA', 'Lāw', 'Laos', 'Vientiane', '236800', '6368162', 'AS', '.la', 'LAK', '856', '#####', '^(d{5})$', 'lo,fr,en', 'CN,MM,KH,TH,VN', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('128', 'LB', 'LBN', '422', 'LE', 'Lubnān', 'Lebanon', 'Beirut', '10400', '4125247', 'AS', '.lb', 'LBP', '961', '#### ####|####', '^(d{4}(d{4})?)$', 'ar-LB,fr-LB,en,hy', 'SY,IL', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('129', 'LC', 'LCA', '662', 'ST', 'Saint Lucia', 'Saint Lucia', 'Castries', '616', '160922', 'NA', '.lc', 'XCD', '+1-758', '', '', 'en-LC', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('130', 'LI', 'LIE', '438', 'LS', 'Liechtenstein', 'Liechtenstein', 'Vaduz', '160', '35000', 'EU', '.li', 'CHF', '423', '####', '^(d{4})$', 'de-LI', 'CH,AT', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('131', 'LK', 'LKA', '144', 'CE', 'Šrī Laṁkā', 'Sri Lanka', 'Colombo', '65610', '21513990', 'AS', '.lk', 'LKR', '94', '#####', '^(d{5})$', 'si,ta,en', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('132', 'LR', 'LBR', '430', 'LI', 'Liberia', 'Liberia', 'Monrovia', '111370', '3685076', 'AF', '.lr', 'LRD', '231', '####', '^(d{4})$', 'en-LR', 'SL,CI,GN', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('133', 'LS', 'LSO', '426', 'LT', 'Lesotho', 'Lesotho', 'Maseru', '30355', '1919552', 'AF', '.ls', 'LSL', '266', '###', '^(d{3})$', 'en-LS,st,zu,xh', 'ZA', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('134', 'LT', 'LTU', '440', 'LH', 'Lietuva', 'Lithuania', 'Vilnius', '65200', '2944459', 'EU', '.lt', 'EUR', '370', 'LT-#####', '^(?:LT)*(d{5})$', 'lt,ru,pl', 'PL,BY,RU,LV', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('135', 'LU', 'LUX', '442', 'LU', 'Lëtzebuerg', 'Luxembourg', 'Luxembourg', '2586', '497538', 'EU', '.lu', 'EUR', '352', 'L-####', '^(d{4})$', 'lb,de-LU,fr-LU', 'DE,BE,FR', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('136', 'LV', 'LVA', '428', 'LG', 'Latvija', 'Latvia', 'Riga', '64589', '2217969', 'EU', '.lv', 'EUR', '371', 'LV-####', '^(?:LV)*(d{4})$', 'lv,ru,lt', 'LT,EE,BY,RU', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('137', 'LY', 'LBY', '434', 'LY', 'Lībiyā', 'Libya', 'Tripolis', '1759540', '6461454', 'AF', '.ly', 'LYD', '218', '', '', 'ar-LY,it,en', 'TD,NE,DZ,SD,TN,EG', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('138', 'MA', 'MAR', '504', 'MO', 'Maroc', 'Morocco', 'Rabat', '446550', '31627428', 'AF', '.ma', 'MAD', '212', '#####', '^(d{5})$', 'ar-MA,fr', 'DZ,EH,ES', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('139', 'MC', 'MCO', '492', 'MN', 'Monaco', 'Monaco', 'Monaco', '2', '32965', 'EU', '.mc', 'EUR', '377', '#####', '^(d{5})$', 'fr-MC,en,it', 'FR', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('140', 'MD', 'MDA', '498', 'MD', 'Moldova', 'Moldova', 'Chisinau', '33843', '4324000', 'EU', '.md', 'MDL', '373', 'MD-####', '^(?:MD)*(d{4})$', 'ro,ru,gag,tr', 'RO,UA', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('141', 'ME', 'MNE', '499', 'MJ', 'Crna Gora', 'Montenegro', 'Podgorica', '14026', '666730', 'EU', '.me', 'EUR', '382', '#####', '^(d{5})$', 'sr,hu,bs,sq,hr,rom', 'AL,HR,BA,RS,XK', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('142', 'MF', 'MAF', '663', 'RN', 'Saint Martin', 'Saint Martin', 'Marigot', '53', '35925', 'NA', '.gp', 'EUR', '590', '### ###', '', 'fr', 'SX', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('143', 'MG', 'MDG', '450', 'MA', 'Madagascar', 'Madagascar', 'Antananarivo', '587040', '21281844', 'AF', '.mg', 'MGA', '261', '###', '^(d{3})$', 'fr-MG,mg', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('144', 'MH', 'MHL', '584', 'RM', 'Marshall Islands', 'Marshall Islands', 'Majuro', '181', '65859', 'OC', '.mh', 'USD', '692', '', '', 'mh,en-MH', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('145', 'MK', 'MKD', '807', 'MK', 'Makedonija', 'Macedonia', 'Skopje', '25333', '2062294', 'EU', '.mk', 'MKD', '389', '####', '^(d{4})$', 'mk,sq,tr,rmm,sr', 'AL,GR,BG,RS,XK', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('146', 'ML', 'MLI', '466', 'ML', 'Mali', 'Mali', 'Bamako', '1240000', '13796354', 'AF', '.ml', 'XOF', '223', '', '', 'fr-ML,bm', 'SN,NE,DZ,CI,GN,MR,BF', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('147', 'MM', 'MMR', '104', 'BM', 'Mẏanmā', 'Myanmar', 'Nay Pyi Taw', '678500', '53414374', 'AS', '.mm', 'MMK', '95', '#####', '^(d{5})$', 'my', 'CN,LA,TH,BD,IN', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('148', 'MN', 'MNG', '496', 'MG', 'Mongol Uls', 'Mongolia', 'Ulan Bator', '1565000', '3086918', 'AS', '.mn', 'MNT', '976', '######', '^(d{6})$', 'mn,ru', 'CN,RU', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('149', 'MO', 'MAC', '446', 'MC', 'Ngoumún', 'Macao', 'Macao', '254', '449198', 'AS', '.mo', 'MOP', '853', '', '', 'zh,zh-MO,pt', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('150', 'MP', 'MNP', '580', 'CQ', 'Northern Mariana Islands', 'Northern Mariana Islands', 'Saipan', '477', '53883', 'OC', '.mp', 'USD', '+1-670', '', '', 'fil,tl,zh,ch-MP,en-MP', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('151', 'MQ', 'MTQ', '474', 'MB', 'Martinique', 'Martinique', 'Fort-de-France', '1100', '432900', 'NA', '.mq', 'EUR', '596', '#####', '^(d{5})$', 'fr-MQ', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('152', 'MR', 'MRT', '478', 'MR', 'Mauritanie', 'Mauritania', 'Nouakchott', '1030700', '3205060', 'AF', '.mr', 'MRO', '222', '', '', 'ar-MR,fuc,snk,fr,mey,wo', 'SN,DZ,EH,ML', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('153', 'MS', 'MSR', '500', 'MH', 'Montserrat', 'Montserrat', 'Plymouth', '102', '9341', 'NA', '.ms', 'XCD', '+1-664', '', '', 'en-MS', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('154', 'MT', 'MLT', '470', 'MT', 'Malta', 'Malta', 'Valletta', '316', '403000', 'EU', '.mt', 'EUR', '356', '@@@ ###|@@@ ##', '^([A-Z]{3}d{2}d?)$', 'mt,en-MT', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('155', 'MU', 'MUS', '480', 'MP', 'Mauritius', 'Mauritius', 'Port Louis', '2040', '1294104', 'AF', '.mu', 'MUR', '230', '', '', 'en-MU,bho,fr', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('156', 'MV', 'MDV', '462', 'MV', 'Dhivehi', 'Maldives', 'Male', '300', '395650', 'AS', '.mv', 'MVR', '960', '#####', '^(d{5})$', 'dv,en', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('157', 'MW', 'MWI', '454', 'MI', 'Malawi', 'Malawi', 'Lilongwe', '118480', '15447500', 'AF', '.mw', 'MWK', '265', '', '', 'ny,yao,tum,swk', 'TZ,MZ,ZM', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('158', 'MX', 'MEX', '484', 'MX', 'México', 'Mexico', 'Mexico City', '1972550', '112468855', 'NA', '.mx', 'MXN', '52', '#####', '^(d{5})$', 'es-MX', 'GT,US,BZ', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('159', 'MY', 'MYS', '458', 'MY', 'Malaysia', 'Malaysia', 'Kuala Lumpur', '329750', '28274729', 'AS', '.my', 'MYR', '60', '#####', '^(d{5})$', 'ms-MY,en,zh,ta,te,ml,pa,th', 'BN,TH,ID', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('160', 'MZ', 'MOZ', '508', 'MZ', 'Moçambique', 'Mozambique', 'Maputo', '801590', '22061451', 'AF', '.mz', 'MZN', '258', '####', '^(d{4})$', 'pt-MZ,vmw', 'ZW,TZ,SZ,ZA,ZM,MW', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('161', 'NA', 'NAM', '516', 'WA', 'Namibia', 'Namibia', 'Windhoek', '825418', '2128471', 'AF', '.na', 'NAD', '264', '', '', 'en-NA,af,de,hz,naq', 'ZA,BW,ZM,AO', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('162', 'NC', 'NCL', '540', 'NC', 'Nouvelle Calédonie', 'New Caledonia', 'Noumea', '19060', '216494', 'OC', '.nc', 'XPF', '687', '#####', '^(d{5})$', 'fr-NC', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('163', 'NE', 'NER', '562', 'NG', 'Niger', 'Niger', 'Niamey', '1267000', '15878271', 'AF', '.ne', 'XOF', '227', '####', '^(d{4})$', 'fr-NE,ha,kr,dje', 'TD,BJ,DZ,LY,BF,NG,ML', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('164', 'NF', 'NFK', '574', 'NF', 'Norfolk Island', 'Norfolk Island', 'Kingston', '35', '1828', 'OC', '.nf', 'AUD', '672', '####', '^(d{4})$', 'en-NF', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('165', 'NG', 'NGA', '566', 'NI', 'Nigeria', 'Nigeria', 'Abuja', '923768', '154000000', 'AF', '.ng', 'NGN', '234', '######', '^(d{6})$', 'en-NG,ha,yo,ig,ff', 'TD,NE,BJ,CM', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('166', 'NI', 'NIC', '558', 'NU', 'Nicaragua', 'Nicaragua', 'Managua', '129494', '5995928', 'NA', '.ni', 'NIO', '505', '###-###-#', '^(d{7})$', 'es-NI,en', 'CR,HN', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('167', 'NL', 'NLD', '528', 'NL', 'Nederland', 'Netherlands', 'Amsterdam', '41526', '16645000', 'EU', '.nl', 'EUR', '31', '#### @@', '^(d{4}[A-Z]{2})$', 'nl-NL,fy-NL', 'DE,BE', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('168', 'NO', 'NOR', '578', 'NO', 'Norge (Noreg)', 'Norway', 'Oslo', '324220', '5009150', 'EU', '.no', 'NOK', '47', '####', '^(d{4})$', 'no,nb,nn,se,fi', 'FI,RU,SE', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('169', 'NP', 'NPL', '524', 'NP', 'Nēpāl', 'Nepal', 'Kathmandu', '140800', '28951852', 'AS', '.np', 'NPR', '977', '#####', '^(d{5})$', 'ne,en', 'CN,IN', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('170', 'NR', 'NRU', '520', 'NR', 'Naoero', 'Nauru', 'Yaren', '21', '10065', 'OC', '.nr', 'AUD', '674', '', '', 'na,en-NR', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('171', 'NU', 'NIU', '570', 'NE', 'Niue', 'Niue', 'Alofi', '260', '2166', 'OC', '.nu', 'NZD', '683', '', '', 'niu,en-NU', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('172', 'NZ', 'NZL', '554', 'NZ', 'New Zealand', 'New Zealand', 'Wellington', '268680', '4252277', 'OC', '.nz', 'NZD', '64', '####', '^(d{4})$', 'en-NZ,mi', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('173', 'OM', 'OMN', '512', 'MU', 'ʿUmān', 'Oman', 'Muscat', '212460', '2967717', 'AS', '.om', 'OMR', '968', '###', '^(d{3})$', 'ar-OM,en,bal,ur', 'SA,YE,AE', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('174', 'PA', 'PAN', '591', 'PM', 'Panamá', 'Panama', 'Panama City', '78200', '3410676', 'NA', '.pa', 'PAB', '507', '', '', 'es-PA,en', 'CR,CO', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('175', 'PE', 'PER', '604', 'PE', 'Perú', 'Peru', 'Lima', '1285220', '29907003', 'SA', '.pe', 'PEN', '51', '', '', 'es-PE,qu,ay', 'EC,CL,BO,BR,CO', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('176', 'PF', 'PYF', '258', 'FP', 'Polinésie Française', 'French Polynesia', 'Papeete', '4167', '270485', 'OC', '.pf', 'XPF', '689', '#####', '^((97|98)7d{2})$', 'fr-PF,ty', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('177', 'PG', 'PNG', '598', 'PP', 'Papua New Guinea', 'Papua New Guinea', 'Port Moresby', '462840', '6064515', 'OC', '.pg', 'PGK', '675', '###', '^(d{3})$', 'en-PG,ho,meu,tpi', 'ID', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('178', 'PH', 'PHL', '608', 'RP', 'Pilipinas', 'Philippines', 'Manila', '300000', '99900177', 'AS', '.ph', 'PHP', '63', '####', '^(d{4})$', 'tl,en-PH,fil', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('179', 'PK', 'PAK', '586', 'PK', 'Pākistān', 'Pakistan', 'Islamabad', '803940', '184404791', 'AS', '.pk', 'PKR', '92', '#####', '^(d{5})$', 'ur-PK,en-PK,pa,sd,ps,brh', 'CN,AF,IR,IN', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('180', 'PL', 'POL', '616', 'PL', 'Polska', 'Poland', 'Warsaw', '312685', '38500000', 'EU', '.pl', 'PLN', '48', '##-###', '^(d{5})$', 'pl', 'DE,LT,SK,CZ,BY,UA,RU', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('181', 'PM', 'SPM', '666', 'SB', 'Saint Pierre and Miquelon', 'Saint Pierre and Miquelon', 'Saint-Pierre', '242', '7012', 'NA', '.pm', 'EUR', '508', '#####', '^(97500)$', 'fr-PM', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('182', 'PN', 'PCN', '612', 'PC', 'Pitcairn', 'Pitcairn', 'Adamstown', '47', '46', 'OC', '.pn', 'NZD', '870', '', '', 'en-PN', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('183', 'PR', 'PRI', '630', 'RQ', 'Puerto Rico', 'Puerto Rico', 'San Juan', '9104', '3916632', 'NA', '.pr', 'USD', '+1-787/1-939', '#####-####', '^(d{9})$', 'en-PR,es-PR', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('184', 'PS', 'PSE', '275', 'WE', 'Filasṭīn', 'Palestinian Territory', 'East Jerusalem', '5970', '3800000', 'AS', '.ps', 'ILS', '970', '', '', 'ar-PS', 'JO,IL,EG', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('185', 'PT', 'PRT', '620', 'PO', 'Portugal', 'Portugal', 'Lisbon', '92391', '10676000', 'EU', '.pt', 'EUR', '351', '####-###', '^(d{7})$', 'pt-PT,mwl', 'ES', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('186', 'PW', 'PLW', '585', 'PS', 'Palau', 'Palau', 'Melekeok', '458', '19907', 'OC', '.pw', 'USD', '680', '96940', '^(96940)$', 'pau,sov,en-PW,tox,ja,fil,zh', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('187', 'PY', 'PRY', '600', 'PA', 'Paraguay', 'Paraguay', 'Asuncion', '406750', '6375830', 'SA', '.py', 'PYG', '595', '####', '^(d{4})$', 'es-PY,gn', 'BO,BR,AR', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('188', 'QA', 'QAT', '634', 'QA', 'Qaṭar', 'Qatar', 'Doha', '11437', '840926', 'AS', '.qa', 'QAR', '974', '', '', 'ar-QA,en', 'SA', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('189', 'RE', 'REU', '638', 'RE', 'Réunion', 'Reunion', 'Saint-Denis', '2517', '776948', 'AF', '.re', 'EUR', '262', '#####', '^((97|98)(4|7|8)d{2})$', 'fr-RE', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('190', 'RO', 'ROU', '642', 'RO', 'România', 'Romania', 'Bucharest', '237500', '21959278', 'EU', '.ro', 'RON', '40', '######', '^(d{6})$', 'ro,hu,rom', 'MD,HU,UA,BG,RS', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('191', 'RS', 'SRB', '688', 'RI', 'Srbija', 'Serbia', 'Belgrade', '88361', '7344847', 'EU', '.rs', 'RSD', '381', '######', '^(d{6})$', 'sr,hu,bs,rom', 'AL,HU,MK,RO,HR,BA,BG,ME,XK', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('192', 'RU', 'RUS', '643', 'RS', 'Rossija', 'Russia', 'Moscow', '17100000', '140702000', 'EU', '.ru', 'RUB', '7', '######', '^(d{6})$', 'ru,tt,xal,cau,ady,kv,ce,tyv,cv,udm,tut,mns,bua,myv', 'GE,CN,BY,UA,KZ,LV,PL,EE,LT,FI,MN,NO,AZ,KP', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('193', 'RW', 'RWA', '646', 'RW', 'Rwanda', 'Rwanda', 'Kigali', '26338', '11055976', 'AF', '.rw', 'RWF', '250', '', '', 'rw,en-RW,fr-RW,sw', 'TZ,CD,BI,UG', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('194', 'SA', 'SAU', '682', 'SA', 'as-Saʿūdīyâ', 'Saudi Arabia', 'Riyadh', '1960582', '25731776', 'AS', '.sa', 'SAR', '966', '#####', '^(d{5})$', 'ar-SA', 'QA,OM,IQ,YE,JO,AE,KW', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('195', 'SB', 'SLB', '90', 'BP', 'Solomon Islands', 'Solomon Islands', 'Honiara', '28450', '559198', 'OC', '.sb', 'SBD', '677', '', '', 'en-SB,tpi', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('196', 'SC', 'SYC', '690', 'SE', 'Seychelles', 'Seychelles', 'Victoria', '455', '88340', 'AF', '.sc', 'SCR', '248', '', '', 'en-SC,fr-SC', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('197', 'SD', 'SDN', '729', 'SU', 'Sudan', 'Sudan', 'Khartoum', '1861484', '35000000', 'AF', '.sd', 'SDG', '249', '#####', '^(d{5})$', 'ar-SD,en,fia', 'SS,TD,EG,ET,ER,LY,CF', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('198', 'SE', 'SWE', '752', 'SW', 'Sverige', 'Sweden', 'Stockholm', '449964', '9555893', 'EU', '.se', 'SEK', '46', '### ##', '^(?:SE)*(d{5})$', 'sv-SE,se,sma,fi-SE', 'NO,FI', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('199', 'SG', 'SGP', '702', 'SN', 'xīnjiāpō', 'Singapore', 'Singapur', '693', '4701069', 'AS', '.sg', 'SGD', '65', '######', '^(d{6})$', 'cmn,en-SG,ms-SG,ta-SG,zh-SG', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('200', 'SH', 'SHN', '654', 'SH', 'Saint Helena', 'Saint Helena', 'Jamestown', '410', '7460', 'AF', '.sh', 'SHP', '290', 'STHL 1ZZ', '^(STHL1ZZ)$', 'en-SH', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('201', 'SI', 'SVN', '705', 'SI', 'Slovenija', 'Slovenia', 'Ljubljana', '20273', '2007000', 'EU', '.si', 'EUR', '386', '####', '^(?:SI)*(d{4})$', 'sl,sh', 'HU,IT,HR,AT', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('202', 'SJ', 'SJM', '744', 'SV', 'Svalbard and Jan Mayen', 'Svalbard and Jan Mayen', 'Longyearbyen', '62049', '2550', 'EU', '.sj', 'NOK', '47', '', '', 'no,ru', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('203', 'SK', 'SVK', '703', 'LO', 'Slovensko', 'Slovakia', 'Bratislava', '48845', '5455000', 'EU', '.sk', 'EUR', '421', '### ##', '^(d{5})$', 'sk,hu', 'PL,HU,CZ,UA,AT', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('204', 'SL', 'SLE', '694', 'SL', 'Sierra Leone', 'Sierra Leone', 'Freetown', '71740', '5245695', 'AF', '.sl', 'SLL', '232', '', '', 'en-SL,men,tem', 'LR,GN', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('205', 'SM', 'SMR', '674', 'SM', 'San Marino', 'San Marino', 'San Marino', '61', '31477', 'EU', '.sm', 'EUR', '378', '4789#', '^(4789d)$', 'it-SM', 'IT', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('206', 'SN', 'SEN', '686', 'SG', 'Sénégal', 'Senegal', 'Dakar', '196190', '12323252', 'AF', '.sn', 'XOF', '221', '#####', '^(d{5})$', 'fr-SN,wo,fuc,mnk', 'GN,MR,GW,GM,ML', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('207', 'SO', 'SOM', '706', 'SO', 'Soomaaliya', 'Somalia', 'Mogadishu', '637657', '10112453', 'AF', '.so', 'SOS', '252', '@@  #####', '^([A-Z]{2}d{5})$', 'so-SO,ar-SO,it,en-SO', 'ET,KE,DJ', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('208', 'SR', 'SUR', '740', 'NS', 'Suriname', 'Suriname', 'Paramaribo', '163270', '492829', 'SA', '.sr', 'SRD', '597', '', '', 'nl-SR,en,srn,hns,jv', 'GY,BR,GF', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('209', 'SS', 'SSD', '728', 'OD', 'South Sudan', 'South Sudan', 'Juba', '644329', '8260490', 'AF', '', 'SSP', '211', '', '', 'en', 'CD,CF,ET,KE,SD,UG,', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('210', 'ST', 'STP', '678', 'TP', 'São Tomé e Príncipe', 'Sao Tome and Principe', 'Sao Tome', '1001', '175808', 'AF', '.st', 'STD', '239', '', '', 'pt-ST', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('211', 'SV', 'SLV', '222', 'ES', 'El Salvador', 'El Salvador', 'San Salvador', '21040', '6052064', 'NA', '.sv', 'USD', '503', 'CP ####', '^(?:CP)*(d{4})$', 'es-SV', 'GT,HN', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('212', 'SX', 'SXM', '534', 'NN', 'Sint Maarten', 'Sint Maarten', 'Philipsburg', '21', '37429', 'NA', '.sx', 'ANG', '599', '', '', 'nl,en', 'MF', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('213', 'SY', 'SYR', '760', 'SY', 'Sūrīyâ', 'Syria', 'Damascus', '185180', '22198110', 'AS', '.sy', 'SYP', '963', '', '', 'ar-SY,ku,hy,arc,fr,en', 'IQ,JO,IL,TR,LB', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('214', 'SZ', 'SWZ', '748', 'WZ', 'Swaziland', 'Swaziland', 'Mbabane', '17363', '1354051', 'AF', '.sz', 'SZL', '268', '@###', '^([A-Z]d{3})$', 'en-SZ,ss-SZ', 'ZA,MZ', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('215', 'TC', 'TCA', '796', 'TK', 'Turks and Caicos Islands', 'Turks and Caicos Islands', 'Cockburn Town', '430', '20556', 'NA', '.tc', 'USD', '+1-649', 'TKCA 1ZZ', '^(TKCA 1ZZ)$', 'en-TC', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('216', 'TD', 'TCD', '148', 'CD', 'Tchad', 'Chad', 'N\'Djamena', '1284000', '10543464', 'AF', '.td', 'XAF', '235', '', '', 'fr-TD,ar-TD,sre', 'NE,LY,CF,SD,CM,NG', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('217', 'TF', 'ATF', '260', 'FS', 'French Southern Territories', 'French Southern Territories', 'Port-aux-Francais', '7829', '140', 'AN', '.tf', 'EUR', '', '', '', 'fr', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('218', 'TG', 'TGO', '768', 'TO', 'Togo', 'Togo', 'Lome', '56785', '6587239', 'AF', '.tg', 'XOF', '228', '', '', 'fr-TG,ee,hna,kbp,dag,ha', 'BJ,GH,BF', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('219', 'TH', 'THA', '764', 'TH', 'Prathēt tai', 'Thailand', 'Bangkok', '514000', '67089500', 'AS', '.th', 'THB', '66', '#####', '^(d{5})$', 'th,en', 'LA,MM,KH,MY', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('220', 'TJ', 'TJK', '762', 'TI', 'Tojikiston', 'Tajikistan', 'Dushanbe', '143100', '7487489', 'AS', '.tj', 'TJS', '992', '######', '^(d{6})$', 'tg,ru', 'CN,AF,KG,UZ', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('221', 'TK', 'TKL', '772', 'TL', 'Tokelau', 'Tokelau', '', '10', '1466', 'OC', '.tk', 'NZD', '690', '', '', 'tkl,en-TK', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('222', 'TL', 'TLS', '626', 'TT', 'Timór Lorosa\'e', 'East Timor', 'Dili', '15007', '1154625', 'OC', '.tl', 'USD', '670', '', '', 'tet,pt-TL,id,en', 'ID', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('223', 'TM', 'TKM', '795', 'TX', 'Turkmenistan', 'Turkmenistan', 'Ashgabat', '488100', '4940916', 'AS', '.tm', 'TMT', '993', '######', '^(d{6})$', 'tk,ru,uz', 'AF,IR,UZ,KZ', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('224', 'TN', 'TUN', '788', 'TS', 'Tunisie', 'Tunisia', 'Tunis', '163610', '10589025', 'AF', '.tn', 'TND', '216', '####', '^(d{4})$', 'ar-TN,fr', 'DZ,LY', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('225', 'TO', 'TON', '776', 'TN', 'Tonga', 'Tonga', 'Nuku\'alofa', '748', '122580', 'OC', '.to', 'TOP', '676', '', '', 'to,en-TO', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('226', 'TR', 'TUR', '792', 'TU', 'Türkiye', 'Turkey', 'Ankara', '780580', '77804122', 'AS', '.tr', 'TRY', '90', '#####', '^(d{5})$', 'tr-TR,ku,diq,az,av', 'SY,GE,IQ,IR,GR,AM,AZ,BG', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('227', 'TT', 'TTO', '780', 'TD', 'Trinidad and Tobago', 'Trinidad and Tobago', 'Port of Spain', '5128', '1228691', 'NA', '.tt', 'TTD', '+1-868', '', '', 'en-TT,hns,fr,es,zh', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('228', 'TV', 'TUV', '798', 'TV', 'Tuvalu', 'Tuvalu', 'Funafuti', '26', '10472', 'OC', '.tv', 'AUD', '688', '', '', 'tvl,en,sm,gil', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('229', 'TW', 'TWN', '158', 'TW', 'T\'ai2-wan1', 'Taiwan', 'Taipei', '35980', '22894384', 'AS', '.tw', 'TWD', '886', '#####', '^(d{5})$', 'zh-TW,zh,nan,hak', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('230', 'TZ', 'TZA', '834', 'TZ', 'Tanzania', 'Tanzania', 'Dodoma', '945087', '41892895', 'AF', '.tz', 'TZS', '255', '', '', 'sw-TZ,en,ar', 'MZ,KE,CD,RW,ZM,BI,UG,MW', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('231', 'UA', 'UKR', '804', 'UP', 'Ukrajina', 'Ukraine', 'Kiev', '603700', '45415596', 'EU', '.ua', 'UAH', '380', '#####', '^(d{5})$', 'uk,ru-UA,rom,pl,hu', 'PL,MD,HU,SK,BY,RO,RU', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('232', 'UG', 'UGA', '800', 'UG', 'Uganda', 'Uganda', 'Kampala', '236040', '33398682', 'AF', '.ug', 'UGX', '256', '', '', 'en-UG,lg,sw,ar', 'TZ,KE,SS,CD,RW', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('233', 'UK', 'GBR', '826', 'UK', 'United Kingdom', 'United Kingdom', 'London', '244820', '62348447', 'EU', '.uk', 'GBP', '44', '@# #@@|@## #@@|@@# #@@|@@## #@@|@#@ #@@|@@#@ #@@|G', '^(([A-Z]d{2}[A-Z]{2})|([A-Z]d{3}[A-Z]{2})|([A-Z]{2}d{2}[A-Z]{2})|([A-Z]{2}d{3}[A-Z]{2})|([A-Z]d[A-Z]d[A-Z]{2})|([A-Z]{2}d[A-Z]d[A-Z]{2})|(GIR0AA))$', 'en-GB,cy-GB,gd', 'IE', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('234', 'UM', 'UMI', '581', '', 'United States Minor Outlying Islands', 'United States Minor Outlying Islands', '', '0', '0', 'OC', '.um', 'USD', '1', '', '', 'en-UM', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('235', 'US', 'USA', '840', 'US', 'USA', 'United States', 'Washington', '9629091', '310232863', 'NA', '.us', 'USD', '1', '#####-####', '^d{5}(-d{4})?$', 'en-US,es-US,haw,fr', 'CA,MX,CU', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('236', 'UY', 'URY', '858', 'UY', 'Uruguay', 'Uruguay', 'Montevideo', '176220', '3477000', 'SA', '.uy', 'UYU', '598', '#####', '^(d{5})$', 'es-UY', 'BR,AR', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('237', 'UZ', 'UZB', '860', 'UZ', 'O\'zbekiston', 'Uzbekistan', 'Tashkent', '447400', '27865738', 'AS', '.uz', 'UZS', '998', '######', '^(d{6})$', 'uz,ru,tg', 'TM,AF,KG,TJ,KZ', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('238', 'VA', 'VAT', '336', 'VT', 'Vaticanum', 'Vatican', 'Vatican City', '0', '921', 'EU', '.va', 'EUR', '379', '#####', '^(d{5})$', 'la,it,fr', 'IT', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('239', 'VC', 'VCT', '670', 'VC', 'Saint Vincent and the Grenadines', 'Saint Vincent and the Grenadines', 'Kingstown', '389', '104217', 'NA', '.vc', 'XCD', '+1-784', '', '', 'en-VC,fr', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('240', 'VE', 'VEN', '862', 'VE', 'Venezuela', 'Venezuela', 'Caracas', '912050', '27223228', 'SA', '.ve', 'VEF', '58', '####', '^(d{4})$', 'es-VE', 'GY,BR,CO', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('241', 'VG', 'VGB', '92', 'VI', 'British Virgin Islands', 'British Virgin Islands', 'Road Town', '153', '21730', 'NA', '.vg', 'USD', '+1-284', '', '', 'en-VG', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('242', 'VI', 'VIR', '850', 'VQ', 'U.S. Virgin Islands', 'U.S. Virgin Islands', 'Charlotte Amalie', '352', '108708', 'NA', '.vi', 'USD', '+1-340', '#####-####', '^d{5}(-d{4})?$', 'en-VI', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('243', 'VN', 'VNM', '704', 'VM', 'Việt Nam', 'Vietnam', 'Hanoi', '329560', '89571130', 'AS', '.vn', 'VND', '84', '######', '^(d{6})$', 'vi,en,fr,zh,km', 'CN,LA,KH', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('244', 'VU', 'VUT', '548', 'NH', 'Vanuatu', 'Vanuatu', 'Port Vila', '12200', '221552', 'OC', '.vu', 'VUV', '678', '', '', 'bi,en-VU,fr-VU', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('245', 'WF', 'WLF', '876', 'WF', 'Wallis and Futuna', 'Wallis and Futuna', 'Mata Utu', '274', '16025', 'OC', '.wf', 'XPF', '681', '#####', '^(986d{2})$', 'wls,fud,fr-WF', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('246', 'WS', 'WSM', '882', 'WS', 'Samoa', 'Samoa', 'Apia', '2944', '192001', 'OC', '.ws', 'WST', '685', '', '', 'sm,en-WS', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('247', 'XK', 'XKX', '0', 'KV', 'Kosovo', 'Kosovo', 'Pristina', '10908', '1800000', 'EU', '', 'EUR', '', '', '', 'sq,sr', 'RS,AL,MK,ME', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('248', 'YE', 'YEM', '887', 'YM', 'al-Yaman', 'Yemen', 'Sanaa', '527970', '23495361', 'AS', '.ye', 'YER', '967', '', '', 'ar-YE', 'SA,OM', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('249', 'YT', 'MYT', '175', 'MF', 'Mayotte', 'Mayotte', 'Mamoudzou', '374', '159042', 'AF', '.yt', 'EUR', '262', '#####', '^(d{5})$', 'fr-YT', '', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('250', 'ZA', 'ZAF', '710', 'SF', 'South Africa', 'South Africa', 'Pretoria', '1219912', '49000000', 'AF', '.za', 'ZAR', '27', '####', '^(d{4})$', 'zu,xh,af,nso,en-ZA,tn,st,ts,ss,ve,nr', 'ZW,SZ,MZ,BW,NA,LS', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('251', 'ZM', 'ZMB', '894', 'ZA', 'Zambia', 'Zambia', 'Lusaka', '752614', '13460305', 'AF', '.zm', 'ZMW', '260', '#####', '^(d{5})$', 'en-ZM,bem,loz,lun,lue,ny,toi', 'ZW,TZ,MZ,CD,NA,MW,AO', '', null, '0', '0', '0', null, null);
INSERT INTO `countries` VALUES ('252', 'ZW', 'ZWE', '716', 'ZI', 'Zimbabwe', 'Zimbabwe', 'Harare', '390580', '11651858', 'AF', '.zw', 'ZWL', '263', '', '', 'en-ZW,sn,nr,nd', 'ZA,MZ,BW,ZM', '', null, '0', '0', '0', null, null);

-- ----------------------------
-- Table structure for coupons
-- ----------------------------
DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage` int(11) NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired` enum('true','false') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of coupons
-- ----------------------------

-- ----------------------------
-- Table structure for currencies
-- ----------------------------
DROP TABLE IF EXISTS `currencies`;
CREATE TABLE `currencies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `html_entity` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'From Github : An array of currency symbols as HTML entities',
  `font_arial` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `font_code2000` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unicode_decimal` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unicode_hex` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `in_left` tinyint(1) unsigned DEFAULT '0',
  `decimal_places` int(10) unsigned DEFAULT '2' COMMENT 'Currency Decimal Places - ISO 4217',
  `decimal_separator` varchar(10) COLLATE utf8_unicode_ci DEFAULT '.',
  `thousand_separator` varchar(10) COLLATE utf8_unicode_ci DEFAULT ',',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of currencies
-- ----------------------------
INSERT INTO `currencies` VALUES ('1', 'AED', 'United Arab Emirates Dirham', '&#1583;.&#1573;', 'د.إ', 'د.إ', null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('2', 'AFN', 'Afghanistan Afghani', '&#65;&#102;', '؋', '؋', '1547', '60b', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('3', 'ALL', 'Albania Lek', '&#76;&#101;&#107;', 'Lek', 'Lek', '76, 1', '4c, 6', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('4', 'AMD', 'Armenia Dram', '', null, null, null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('5', 'ANG', 'Netherlands Antilles Guilder', '&#402;', 'ƒ', 'ƒ', '402', '192', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('6', 'AOA', 'Angola Kwanza', '&#75;&#122;', 'Kz', 'Kz', null, null, '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('7', 'ARS', 'Argentina Peso', '&#36;', '$', '$', '36', '24', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('8', 'AUD', 'Australia Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('9', 'AWG', 'Aruba Guilder', '&#402;', 'ƒ', 'ƒ', '402', '192', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('10', 'AZN', 'Azerbaijan New Manat', '&#1084;&#1072;&#1085;', 'ман', 'ман', '1084,', '43c, ', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('11', 'BAM', 'Bosnia and Herzegovina Convertible Marka', '&#75;&#77;', 'KM', 'KM', '75, 7', '4b, 4', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('12', 'BBD', 'Barbados Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('13', 'BDT', 'Bangladesh Taka', '&#2547;', '৳', '৳', null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('14', 'BGN', 'Bulgaria Lev', '&#1083;&#1074;', 'лв', 'лв', '1083,', '43b, ', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('15', 'BHD', 'Bahrain Dinar', '.&#1583;.&#1576;', null, null, null, null, '0', '3', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('16', 'BIF', 'Burundi Franc', '&#70;&#66;&#117;', 'FBu', 'FBu', null, null, '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('17', 'BMD', 'Bermuda Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('18', 'BND', 'Brunei Darussalam Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('19', 'BOB', 'Bolivia Boliviano', '&#36;&#98;', '$b', '$b', '36, 9', '24, 6', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('20', 'BRL', 'Brazil Real', '&#82;&#36;', 'R$', 'R$', '82, 3', '52, 2', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('21', 'BSD', 'Bahamas Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('22', 'BTN', 'Bhutan Ngultrum', '&#78;&#117;&#46;', null, null, null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('23', 'BWP', 'Botswana Pula', '&#80;', 'P', 'P', '80', '50', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('24', 'BYR', 'Belarus Ruble', '&#112;&#46;', 'p.', 'p.', '112, ', '70, 2', '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('25', 'BZD', 'Belize Dollar', '&#66;&#90;&#36;', 'BZ$', 'BZ$', '66, 9', '42, 5', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('26', 'CAD', 'Canada Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('27', 'CDF', 'Congo/Kinshasa Franc', '&#70;&#67;', 'Fr', 'Fr', null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('28', 'CHF', 'Switzerland Franc', '', 'Fr', 'Fr', '67, 7', '43, 4', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('29', 'CLP', 'Chile Peso', '&#36;', '$', '$', '36', '24', '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('30', 'CNY', 'China Yuan Renminbi', '&#165;', '¥', '¥', '165', 'a5', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('31', 'COP', 'Colombia Peso', '&#36;', '$', '$', '36', '24', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('32', 'CRC', 'Costa Rica Colon', '&#8353;', '₡', '₡', '8353', '20a1', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('33', 'CUC', 'Cuba Convertible Peso', null, null, null, null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('34', 'CUP', 'Cuba Peso', '&#8396;', '₱', '₱', '8369', '20b1', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('35', 'CVE', 'Cape Verde Escudo', '&#x24;', '$', '$', null, null, '1', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('36', 'CZK', 'Czech Republic Koruna', '&#75;&#269;', 'Kč', 'Kč', '75, 2', '4b, 1', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('37', 'DJF', 'Djibouti Franc', '&#70;&#100;&#106;', 'Fr', 'Fr', null, null, '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('38', 'DKK', 'Denmark Krone', '&#107;&#114;', 'kr', 'kr', '107, ', '6b, 7', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('39', 'DOP', 'Dominican Republic Peso', '&#82;&#68;&#36;', 'RD$', 'RD$', '82, 6', '52, 4', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('40', 'DZD', 'Algeria Dinar', '&#1583;&#1580;', 'DA', 'DA', null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('41', 'EEK', 'Estonia Kroon', null, 'kr', 'kr', '107, ', '6b, 7', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('42', 'EGP', 'Egypt Pound', '&#163;', '£', '£', '163', 'a3', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('43', 'ERN', 'Eritrea Nakfa', '&#x4E;&#x66;&#x6B;', 'Nfk', 'Nfk', null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('44', 'ETB', 'Ethiopia Birr', '&#66;&#114;', 'Br', 'Br', null, null, '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('45', 'EUR', 'Euro Member Countries', '€', '€', '€', '8364', '20ac', '0', '2', ',', ' ', null, null);
INSERT INTO `currencies` VALUES ('46', 'FJD', 'Fiji Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('47', 'FKP', 'Falkland Islands (Malvinas) Pound', '&#163;', '£', '£', '163', 'a3', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('48', 'GBP', 'United Kingdom Pound', '&#163;', '£', '£', '163', 'a3', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('49', 'GEL', 'Georgia Lari', '&#4314;', null, null, null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('50', 'GGP', 'Guernsey Pound', null, '£', '£', '163', 'a3', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('51', 'GHC', 'Ghana Cedi', '&#x47;&#x48;&#xA2;', 'GH¢', 'GH¢', '162', 'a2', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('52', 'GHS', 'Ghana Cedi', '&#x47;&#x48;&#xA2;', 'GH¢', 'GH¢', null, null, '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('53', 'GIP', 'Gibraltar Pound', '&#163;', '£', '£', '163', 'a3', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('54', 'GMD', 'Gambia Dalasi', '&#68;', 'D', 'D', null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('55', 'GNF', 'Guinea Franc', '&#70;&#71;', 'Fr', 'Fr', null, null, '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('56', 'GTQ', 'Guatemala Quetzal', '&#81;', 'Q', 'Q', '81', '51', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('57', 'GYD', 'Guyana Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('58', 'HKD', 'Hong Kong Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('59', 'HNL', 'Honduras Lempira', '&#76;', 'L', 'L', '76', '4c', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('60', 'HRK', 'Croatia Kuna', '&#107;&#110;', 'kn', 'kn', '107, ', '6b, 6', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('61', 'HTG', 'Haiti Gourde', '&#71;', null, null, null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('62', 'HUF', 'Hungary Forint', '&#70;&#116;', 'Ft', 'Ft', '70, 1', '46, 7', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('63', 'IDR', 'Indonesia Rupiah', '&#82;&#112;', 'Rp', 'Rp', '82, 1', '52, 7', '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('64', 'ILS', 'Israel Shekel', '&#8362;', '₪', '₪', '8362', '20aa', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('65', 'IMP', 'Isle of Man Pound', null, '£', '£', '163', 'a3', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('66', 'INR', 'India Rupee', '&#8377;', '₨', '₨', '', '', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('67', 'IQD', 'Iraq Dinar', '&#1593;.&#1583;', 'د.ع;', 'د.ع;', null, null, '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('68', 'IRR', 'Iran Rial', '&#65020;', '﷼', '﷼', '65020', 'fdfc', '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('69', 'ISK', 'Iceland Krona', '&#107;&#114;', 'kr', 'kr', '107, ', '6b, 7', '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('70', 'JEP', 'Jersey Pound', '&#163;', '£', '£', '163', 'a3', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('71', 'JMD', 'Jamaica Dollar', '&#74;&#36;', 'J$', 'J$', '74, 3', '4a, 2', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('72', 'JOD', 'Jordan Dinar', '&#74;&#68;', null, null, null, null, '0', '3', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('73', 'JPY', 'Japan Yen', '&#165;', '¥', '¥', '165', 'a5', '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('74', 'KES', 'Kenya Shilling', '&#x4B;&#x53;&#x68;', 'KSh', 'KSh', null, null, '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('75', 'KGS', 'Kyrgyzstan Som', '&#1083;&#1074;', 'лв', 'лв', '1083,', '43b, ', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('76', 'KHR', 'Cambodia Riel', '&#6107;', '៛', '៛', '6107', '17db', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('77', 'KMF', 'Comoros Franc', '&#67;&#70;', 'Fr', 'Fr', null, null, '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('78', 'KPW', 'Korea (North) Won', '&#8361;', '₩', '₩', '8361', '20a9', '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('79', 'KRW', 'Korea (South) Won', '&#8361;', '₩', '₩', '8361', '20a9', '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('80', 'KWD', 'Kuwait Dinar', '&#1583;.&#1603;', 'د.ك', 'د.ك', null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('81', 'KYD', 'Cayman Islands Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('82', 'KZT', 'Kazakhstan Tenge', '&#1083;&#1074;', 'лв', 'лв', '1083,', '43b, ', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('83', 'LAK', 'Laos Kip', '&#8365;', '₭', '₭', '8365', '20ad', '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('84', 'LBP', 'Lebanon Pound', '&#163;', '£', '£', '163', 'a3', '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('85', 'LKR', 'Sri Lanka Rupee', '&#8360;', '₨', '₨', '8360', '20a8', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('86', 'LRD', 'Liberia Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('87', 'LSL', 'Lesotho Loti', '&#76;', 'M', 'M', null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('88', 'LTL', 'Lithuania Litas', '&#76;&#116;', 'Lt', 'Lt', '76, 1', '4c, 7', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('89', 'LVL', 'Latvia Lat', '&#76;&#115;', 'Ls', 'Ls', '76, 1', '4c, 7', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('90', 'LYD', 'Libya Dinar', '&#1604;.&#1583;', 'DL', 'DL', null, null, '0', '3', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('91', 'MAD', 'Morocco Dirham', '&#1583;.&#1605;.', 'Dhs', 'Dhs', null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('92', 'MDL', 'Moldova Leu', '&#76;', null, null, null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('93', 'MGA', 'Madagascar Ariary', '&#65;&#114;', 'Ar', 'Ar', null, null, '0', '5', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('94', 'MKD', 'Macedonia Denar', '&#1076;&#1077;&#1085;', 'ден', 'ден', '1076,', '434, ', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('95', 'MMK', 'Myanmar (Burma) Kyat', '&#75;', null, null, null, null, '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('96', 'MNT', 'Mongolia Tughrik', '&#8366;', '₮', '₮', '8366', '20ae', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('97', 'MOP', 'Macau Pataca', '&#77;&#79;&#80;&#36;', null, null, null, null, '0', '1', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('98', 'MRO', 'Mauritania Ouguiya', '&#85;&#77;', 'UM', 'UM', null, null, '0', '5', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('99', 'MUR', 'Mauritius Rupee', '&#8360;', '₨', '₨', '8360', '20a8', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('100', 'MVR', 'Maldives (Maldive Islands) Rufiyaa', '.&#1923;', null, null, null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('101', 'MWK', 'Malawi Kwacha', '&#77;&#75;', 'MK', 'MK', null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('102', 'MXN', 'Mexico Peso', '&#36;', '$', '$', '36', '24', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('103', 'MYR', 'Malaysia Ringgit', '&#82;&#77;', 'RM', 'RM', '82, 7', '52, 4', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('104', 'MZN', 'Mozambique Metical', '&#77;&#84;', 'MT', 'MT', '77, 8', '4d, 5', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('105', 'NAD', 'Namibia Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('106', 'NGN', 'Nigeria Naira', '&#8358;', '₦', '₦', '8358', '20a6', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('107', 'NIO', 'Nicaragua Cordoba', '&#67;&#36;', 'C$', 'C$', '67, 3', '43, 2', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('108', 'NOK', 'Norway Krone', '&#107;&#114;', 'kr', 'kr', '107, ', '6b, 7', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('109', 'NPR', 'Nepal Rupee', '&#8360;', '₨', '₨', '8360', '20a8', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('110', 'NZD', 'New Zealand Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('111', 'OMR', 'Oman Rial', '&#65020;', '﷼', '﷼', '65020', 'fdfc', '0', '3', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('112', 'PAB', 'Panama Balboa', '&#66;&#47;&#46;', 'B/.', 'B/.', '66, 4', '42, 2', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('113', 'PEN', 'Peru Nuevo Sol', '&#83;&#47;&#46;', 'S/.', 'S/.', '83, 4', '53, 2', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('114', 'PGK', 'Papua New Guinea Kina', '&#75;', null, null, null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('115', 'PHP', 'Philippines Peso', '&#8369;', '₱', '₱', '8369', '20b1', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('116', 'PKR', 'Pakistan Rupee', '&#8360;', '₨', '₨', '8360', '20a8', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('117', 'PLN', 'Poland Zloty', '&#122;&#322;', 'zł', 'zł', '122, ', '7a, 1', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('118', 'PYG', 'Paraguay Guarani', '&#71;&#115;', 'Gs', 'Gs', '71, 1', '47, 7', '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('119', 'QAR', 'Qatar Riyal', '&#65020;', '﷼', '﷼', '65020', 'fdfc', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('120', 'RON', 'Romania New Leu', '&#108;&#101;&#105;', 'lei', 'lei', '108, ', '6c, 6', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('121', 'RSD', 'Serbia Dinar', '&#1044;&#1080;&#1085;&#46;', 'Дин.', 'Дин.', '1044,', '414, ', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('122', 'RUB', 'Russia Ruble', '&#1088;&#1091;&#1073;', 'руб', 'руб', '1088,', '440, ', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('123', 'RWF', 'Rwanda Franc', '&#1585;.&#1587;', 'FRw', 'FRw', null, null, '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('124', 'SAR', 'Saudi Arabia Riyal', '&#65020;', '﷼', '﷼', '65020', 'fdfc', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('125', 'SBD', 'Solomon Islands Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('126', 'SCR', 'Seychelles Rupee', '&#8360;', '₨', '₨', '8360', '20a8', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('127', 'SDG', 'Sudan Pound', '&#163;', 'DS', 'DS', null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('128', 'SEK', 'Sweden Krona', '&#107;&#114;', 'kr', 'kr', '107, ', '6b, 7', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('129', 'SGD', 'Singapore Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('130', 'SHP', 'Saint Helena Pound', '&#163;', '£', '£', '163', 'a3', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('131', 'SLL', 'Sierra Leone Leone', '&#76;&#101;', 'Le', 'Le', null, null, '1', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('132', 'SOS', 'Somalia Shilling', '&#83;', 'S', 'S', '83', '53', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('133', 'SPL', 'Seborga Luigino', null, null, null, null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('134', 'SRD', 'Suriname Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('135', 'SSP', 'South Sudanese Pound', '&#xA3;', '£', '£', null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('136', 'STD', 'São Tomé and Príncipe Dobra', '&#68;&#98;', 'Db', 'Db', null, null, '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('137', 'SVC', 'El Salvador Colon', '&#36;', '$', '$', '36', '24', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('138', 'SYP', 'Syria Pound', '&#163;', '£', '£', '163', 'a3', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('139', 'SZL', 'Swaziland Lilangeni', '&#76;', 'E', 'E', null, null, '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('140', 'THB', 'Thailand Baht', '&#3647;', '฿', '฿', '3647', 'e3f', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('141', 'TJS', 'Tajikistan Somoni', '&#84;&#74;&#83;', null, null, null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('142', 'TMT', 'Turkmenistan Manat', '&#109;', null, null, null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('143', 'TND', 'Tunisia Dinar', '&#1583;.&#1578;', 'DT', 'DT', null, null, '1', '3', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('144', 'TOP', 'Tonga Pa\'anga', '&#84;&#36;', null, null, null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('145', 'TRL', 'Turkey Lira', null, '₤', '₤', '8356', '20a4', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('146', 'TRY', 'Turkey Lira', '&#x20BA;', '₺', '₺', '', '', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('147', 'TTD', 'Trinidad and Tobago Dollar', '&#36;', 'TT$', 'TT$', '84, 8', '54, 5', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('148', 'TVD', 'Tuvalu Dollar', null, '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('149', 'TWD', 'Taiwan New Dollar', '&#78;&#84;&#36;', 'NT$', 'NT$', '78, 8', '4e, 5', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('150', 'TZS', 'Tanzania Shilling', '&#x54;&#x53;&#x68;', 'TSh', 'TSh', null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('151', 'UAH', 'Ukraine Hryvnia', '&#8372;', '₴', '₴', '8372', '20b4', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('152', 'UGX', 'Uganda Shilling', '&#85;&#83;&#104;', 'USh', 'USh', null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('153', 'USD', 'United States Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('154', 'UYU', 'Uruguay Peso', '&#36;&#85;', '$U', '$U', '36, 8', '24, 5', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('155', 'UZS', 'Uzbekistan Som', '&#1083;&#1074;', 'лв', 'лв', '1083,', '43b, ', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('156', 'VEF', 'Venezuela Bolivar', '&#66;&#115;', 'Bs', 'Bs', '66, 1', '42, 7', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('157', 'VND', 'Viet Nam Dong', '&#8363;', '₫', '₫', '8363', '20ab', '1', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('158', 'VUV', 'Vanuatu Vatu', '&#86;&#84;', null, null, null, null, '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('159', 'WST', 'Samoa Tala', '&#87;&#83;&#36;', null, null, null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('160', 'XAF', 'Communauté Financière Africaine (BEAC) CFA Franc B', '&#70;&#67;&#70;&#65;', 'F', 'F', null, null, '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('161', 'XCD', 'East Caribbean Dollar', '&#36;', '$', '$', '36', '24', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('162', 'XDR', 'International Monetary Fund (IMF) Special Drawing ', '', null, null, null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('163', 'XOF', 'Communauté Financière Africaine (BCEAO) Franc', '&#70;&#67;&#70;&#65;', 'F', 'F', null, null, '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('164', 'XPF', 'Comptoirs Français du Pacifique (CFP) Franc', '&#70;', 'F', 'F', null, null, '0', '0', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('165', 'YER', 'Yemen Rial', '&#65020;', '﷼', '﷼', '65020', 'fdfc', '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('166', 'ZAR', 'South Africa Rand', '&#82;', 'R', 'R', '82', '52', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('167', 'ZMW', 'Zambia Kwacha', null, 'ZK', 'ZK', null, null, '0', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('168', 'ZWD', 'Zimbabwe Dollar', null, 'Z$', 'Z$', '90, 3', '5a, 2', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('169', 'ZWL', 'Zimbabwe Dollar', null, 'Z$', 'Z$', '90, 3', '5a, 2', '1', '2', '.', ',', null, null);
INSERT INTO `currencies` VALUES ('170', 'XBT', 'Bitcoin', '฿', '฿', '฿', null, null, '1', '2', '.', ',', null, null);

-- ----------------------------
-- Table structure for fast_sells
-- ----------------------------
DROP TABLE IF EXISTS `fast_sells`;
CREATE TABLE `fast_sells` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of fast_sells
-- ----------------------------

-- ----------------------------
-- Table structure for fields
-- ----------------------------
DROP TABLE IF EXISTS `fields`;
CREATE TABLE `fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `belongs_to` enum('posts','users') COLLATE utf8_unicode_ci NOT NULL,
  `translation_lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `translation_of` int(10) unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('text','textarea','checkbox','checkbox_multiple','select','radio','file') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text',
  `max` int(10) unsigned DEFAULT '255',
  `default` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `required` tinyint(1) unsigned DEFAULT NULL,
  `help` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `translation_lang` (`translation_lang`),
  KEY `translation_of` (`translation_of`),
  KEY `belongs_to` (`belongs_to`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of fields
-- ----------------------------
INSERT INTO `fields` VALUES ('8', 'posts', 'en', '32', 'Condition', 'select', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('32', 'posts', 'cs', '32', 'Stav ojektu', 'select', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('49', 'posts', 'cs', '49', 'Stav', 'select', null, null, '0', null, '0');
INSERT INTO `fields` VALUES ('50', 'posts', 'en', '49', 'Stav', 'select', null, null, '0', null, '0');
INSERT INTO `fields` VALUES ('53', 'posts', 'cs', '53', 'Typ budovy', 'select', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('54', 'posts', 'en', '53', 'Typ budovy', 'select', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('55', 'posts', 'cs', '55', 'Plocha užitná', 'text', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('56', 'posts', 'en', '55', 'Plocha užitná', 'text', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('71', 'posts', 'cs', '71', 'Plocha zastavěná', 'text', '50', 'estate_area', '0', null, '1');
INSERT INTO `fields` VALUES ('72', 'posts', 'en', '71', 'Plocha zastavěná', 'text', '50', '50', '0', null, '1');
INSERT INTO `fields` VALUES ('73', 'posts', 'cs', '73', 'Typ domu', 'select', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('74', 'posts', 'en', '73', 'Typ domu', 'select', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('75', 'posts', 'cs', '75', 'Vlastnictví', 'select', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('76', 'posts', 'en', '75', 'Vlastnictví', 'select', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('77', 'posts', 'cs', '77', 'Pokoje', 'select', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('78', 'posts', 'en', '77', 'Pokoje', 'select', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('79', 'posts', 'cs', '79', 'Cena', 'text', '50', null, '1', null, '1');
INSERT INTO `fields` VALUES ('80', 'posts', 'en', '79', 'Cena', 'text', '50', null, '1', null, '1');
INSERT INTO `fields` VALUES ('81', 'posts', 'cs', '81', 'Měna', 'select', null, 'CZK', '1', null, '1');
INSERT INTO `fields` VALUES ('82', 'posts', 'en', '81', 'Měna', 'select', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('83', 'posts', 'cs', '83', 'Jednotka', 'select', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('84', 'posts', 'en', '83', 'Jednotka', 'select', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('85', 'posts', 'cs', '85', 'DPH', 'radio', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('86', 'posts', 'en', '85', 'DPH', 'radio', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('87', 'posts', 'cs', '87', 'Poznámka k ceně', 'text', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('88', 'posts', 'en', '87', 'Poznámka k ceně', 'text', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('89', 'posts', 'cs', '89', 'Znepřesnění adresy', 'select', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('90', 'posts', 'en', '89', 'Znepřesnění adresy', 'select', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('91', 'posts', 'cs', '91', 'Elektřina', 'checkbox_multiple', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('92', 'posts', 'en', '91', 'Elektřina', 'checkbox_multiple', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('93', 'posts', 'cs', '93', 'Objekty', 'checkbox_multiple', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('94', 'posts', 'en', '93', 'Objekty', 'checkbox_multiple', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('95', 'posts', 'cs', '95', 'Komunikace', 'checkbox_multiple', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('96', 'posts', 'en', '95', 'Komunikace', 'checkbox_multiple', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('97', 'posts', 'cs', '97', 'Voda', 'checkbox_multiple', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('98', 'posts', 'en', '97', 'Voda', 'checkbox_multiple', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('99', 'posts', 'cs', '99', 'Plyn', 'checkbox_multiple', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('100', 'posts', 'en', '99', 'Plyn', 'checkbox_multiple', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('101', 'posts', 'cs', '101', 'Energetická náročnost budovy', 'select', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('102', 'posts', 'en', '101', 'Energetická náročnost budovy', 'select', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('103', 'posts', 'cs', '103', 'Podle vyhlášky', 'select', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('104', 'posts', 'en', '103', 'Podle vyhlášky', 'select', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('105', 'posts', 'cs', '105', 'Ukazatel en. náročnosti budovy (kW)', 'text', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('106', 'posts', 'en', '105', 'Ukazatel en. náročnosti budovy', 'text', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('107', 'posts', 'cs', '107', 'Telekomunikace', 'checkbox_multiple', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('108', 'posts', 'en', '107', 'Telekomunikace', 'checkbox_multiple', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('109', 'posts', 'cs', '109', 'Doprava', 'checkbox_multiple', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('110', 'posts', 'en', '109', 'Doprava', 'checkbox_multiple', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('113', 'posts', 'cs', '113', 'Topení', 'checkbox_multiple', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('114', 'posts', 'en', '113', 'Topení', 'checkbox_multiple', null, null, '0', null, '1');
INSERT INTO `fields` VALUES ('115', 'posts', 'cs', '115', 'Podlaží umístění', 'text', null, null, '1', null, '1');
INSERT INTO `fields` VALUES ('116', 'posts', 'en', '115', 'Podlaží umístění', 'text', null, null, '1', null, '1');

-- ----------------------------
-- Table structure for fields_options
-- ----------------------------
DROP TABLE IF EXISTS `fields_options`;
CREATE TABLE `fields_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(10) unsigned DEFAULT NULL,
  `translation_lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `translation_of` int(10) unsigned DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `field_id` (`field_id`),
  KEY `translation_lang` (`translation_lang`),
  KEY `translation_of` (`translation_of`)
) ENGINE=InnoDB AUTO_INCREMENT=417 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of fields_options
-- ----------------------------
INSERT INTO `fields_options` VALUES ('11', '32', 'en', '172', 'New', null, null, null, null);
INSERT INTO `fields_options` VALUES ('172', '32', 'cs', '172', 'Velmi dobrý', null, null, null, null);
INSERT INTO `fields_options` VALUES ('323', '49', 'cs', null, 'Rezervováno', null, null, null, null);
INSERT INTO `fields_options` VALUES ('324', '49', 'cs', null, 'Prodáno', null, null, null, null);
INSERT INTO `fields_options` VALUES ('325', '32', 'cs', null, 'Dobrý', null, null, null, null);
INSERT INTO `fields_options` VALUES ('326', '32', 'cs', null, 'Špatný', null, null, null, null);
INSERT INTO `fields_options` VALUES ('327', '32', 'cs', null, 'Ve výstavbě', null, null, null, null);
INSERT INTO `fields_options` VALUES ('328', '32', 'cs', null, 'Projekt', null, null, null, null);
INSERT INTO `fields_options` VALUES ('329', '32', 'cs', null, 'Novostavba', null, null, null, null);
INSERT INTO `fields_options` VALUES ('330', '32', 'cs', null, 'K demolici', null, null, null, null);
INSERT INTO `fields_options` VALUES ('331', '32', 'cs', null, 'Před rekonstrukcí', null, null, null, null);
INSERT INTO `fields_options` VALUES ('332', '32', 'cs', null, 'Po rekonstrukci', null, null, null, null);
INSERT INTO `fields_options` VALUES ('333', '53', 'cs', null, 'Dřevěná', null, null, null, null);
INSERT INTO `fields_options` VALUES ('334', '53', 'cs', null, 'Cihlová', null, null, null, null);
INSERT INTO `fields_options` VALUES ('335', '53', 'cs', null, 'Kamenná', null, null, null, null);
INSERT INTO `fields_options` VALUES ('336', '53', 'cs', null, 'Montovaná', null, null, null, null);
INSERT INTO `fields_options` VALUES ('337', '53', 'cs', null, 'Panelová', null, null, null, null);
INSERT INTO `fields_options` VALUES ('338', '53', 'cs', null, 'Skeletová', null, null, null, null);
INSERT INTO `fields_options` VALUES ('339', '53', 'cs', null, 'Smíšená', null, null, null, null);
INSERT INTO `fields_options` VALUES ('340', '73', 'cs', null, 'Přízemní', null, null, null, null);
INSERT INTO `fields_options` VALUES ('341', '73', 'cs', null, 'Patrový', null, null, null, null);
INSERT INTO `fields_options` VALUES ('342', '75', 'cs', null, 'Osobní', null, null, null, null);
INSERT INTO `fields_options` VALUES ('343', '75', 'cs', null, 'Družstevní', null, null, null, null);
INSERT INTO `fields_options` VALUES ('344', '75', 'cs', null, 'Státní/obecní', null, null, null, null);
INSERT INTO `fields_options` VALUES ('345', '77', 'cs', null, '1 pokoj', null, null, null, null);
INSERT INTO `fields_options` VALUES ('346', '77', 'cs', null, '2 pokoje', null, null, null, null);
INSERT INTO `fields_options` VALUES ('347', '77', 'cs', null, '3 pokoje', null, null, null, null);
INSERT INTO `fields_options` VALUES ('348', '77', 'cs', null, '4 pokoje', null, null, null, null);
INSERT INTO `fields_options` VALUES ('349', '77', 'cs', null, '5 a více pokojů', null, null, null, null);
INSERT INTO `fields_options` VALUES ('350', '77', 'cs', null, 'Atypický', null, null, null, null);
INSERT INTO `fields_options` VALUES ('351', '81', 'cs', null, 'CZK', null, null, null, null);
INSERT INTO `fields_options` VALUES ('352', '81', 'cs', null, 'EUR', null, null, null, null);
INSERT INTO `fields_options` VALUES ('353', '81', 'cs', null, 'USD', null, null, null, null);
INSERT INTO `fields_options` VALUES ('354', '83', 'cs', null, 'za nemovitost', null, null, null, null);
INSERT INTO `fields_options` VALUES ('355', '83', 'cs', null, 'za měsíc', null, null, null, null);
INSERT INTO `fields_options` VALUES ('356', '83', 'cs', null, 'za metr čtvereční', null, null, null, null);
INSERT INTO `fields_options` VALUES ('357', '83', 'cs', null, 'za metr čtvereční / měsíc', null, null, null, null);
INSERT INTO `fields_options` VALUES ('358', '83', 'cs', null, 'za metr čtvereční / rok', null, null, null, null);
INSERT INTO `fields_options` VALUES ('359', '83', 'cs', null, 'za rok', null, null, null, null);
INSERT INTO `fields_options` VALUES ('360', '83', 'cs', null, 'za den', null, null, null, null);
INSERT INTO `fields_options` VALUES ('361', '83', 'cs', null, 'za hodinu', null, null, null, null);
INSERT INTO `fields_options` VALUES ('362', '83', 'cs', null, 'za metr čtvereční / den', null, null, null, null);
INSERT INTO `fields_options` VALUES ('363', '83', 'cs', null, 'za metr čtvereční / hodinu', null, null, null, null);
INSERT INTO `fields_options` VALUES ('364', '85', 'cs', null, 'včetně DPH', null, null, null, null);
INSERT INTO `fields_options` VALUES ('365', '85', 'cs', null, 'bez DPH', null, null, null, null);
INSERT INTO `fields_options` VALUES ('366', '89', 'cs', null, 'Adresa je přesně dle zadání', null, null, null, null);
INSERT INTO `fields_options` VALUES ('367', '89', 'cs', null, 'Namísto přesné adresy se zobrazuje ulice', null, null, null, null);
INSERT INTO `fields_options` VALUES ('368', '89', 'cs', null, 'Namísto přesné adresy se zobrazuje část města', null, null, null, null);
INSERT INTO `fields_options` VALUES ('369', '91', 'cs', null, '120V', null, null, null, null);
INSERT INTO `fields_options` VALUES ('370', '91', 'cs', null, '230V', null, null, null, null);
INSERT INTO `fields_options` VALUES ('371', '91', 'cs', null, '400V', null, null, null, null);
INSERT INTO `fields_options` VALUES ('374', '93', 'cs', null, 'Parkovací stání', null, null, null, null);
INSERT INTO `fields_options` VALUES ('375', '93', 'cs', null, 'Terasa', null, null, null, null);
INSERT INTO `fields_options` VALUES ('376', '93', 'cs', null, 'Bazén', null, null, null, null);
INSERT INTO `fields_options` VALUES ('377', '93', 'cs', null, 'Lodžie', null, null, null, null);
INSERT INTO `fields_options` VALUES ('378', '93', 'cs', null, 'Garáž', null, null, null, null);
INSERT INTO `fields_options` VALUES ('379', '93', 'cs', null, 'Sklep', null, null, null, null);
INSERT INTO `fields_options` VALUES ('380', '93', 'cs', null, 'Balkón', null, null, null, null);
INSERT INTO `fields_options` VALUES ('381', '95', 'cs', null, 'Betonová', null, null, null, null);
INSERT INTO `fields_options` VALUES ('382', '95', 'cs', null, 'Dlážděná', null, null, null, null);
INSERT INTO `fields_options` VALUES ('383', '95', 'cs', null, 'Asfaltová', null, null, null, null);
INSERT INTO `fields_options` VALUES ('384', '95', 'cs', null, 'Neupravená', null, null, null, null);
INSERT INTO `fields_options` VALUES ('385', '97', 'cs', null, 'Místní zdroj', null, null, null, null);
INSERT INTO `fields_options` VALUES ('386', '97', 'cs', null, 'Dálkový vodovod', null, null, null, null);
INSERT INTO `fields_options` VALUES ('387', '99', 'cs', null, 'Individuální', null, null, null, null);
INSERT INTO `fields_options` VALUES ('388', '99', 'cs', null, 'Plynovod', null, null, null, null);
INSERT INTO `fields_options` VALUES ('389', '101', 'cs', null, 'A - Mimořádně úsporná', null, null, null, null);
INSERT INTO `fields_options` VALUES ('390', '101', 'cs', null, 'B - Velmi úsporná', null, null, null, null);
INSERT INTO `fields_options` VALUES ('391', '101', 'cs', null, 'C - Úsporná', null, null, null, null);
INSERT INTO `fields_options` VALUES ('392', '101', 'cs', null, 'D - Méně úsporná', null, null, null, null);
INSERT INTO `fields_options` VALUES ('393', '101', 'cs', null, 'E - Nehospodárná', null, null, null, null);
INSERT INTO `fields_options` VALUES ('394', '101', 'cs', null, 'F - Velmi nehospodárná', null, null, null, null);
INSERT INTO `fields_options` VALUES ('395', '101', 'cs', null, 'G - Mimořádně nehospodárná', null, null, null, null);
INSERT INTO `fields_options` VALUES ('396', '103', 'cs', null, 'č. 148/2007 Sb.', null, null, null, null);
INSERT INTO `fields_options` VALUES ('397', '103', 'cs', null, 'č. 78/2013 Sb.', null, null, null, null);
INSERT INTO `fields_options` VALUES ('398', '107', 'cs', null, 'Telefon', null, null, null, null);
INSERT INTO `fields_options` VALUES ('399', '107', 'cs', null, 'Internet', null, null, null, null);
INSERT INTO `fields_options` VALUES ('400', '107', 'cs', null, 'Satelit', null, null, null, null);
INSERT INTO `fields_options` VALUES ('401', '107', 'cs', null, 'Kabelová televize', null, null, null, null);
INSERT INTO `fields_options` VALUES ('402', '107', 'cs', null, 'Kabelová televize', null, null, null, null);
INSERT INTO `fields_options` VALUES ('403', '107', 'cs', null, 'Ostatní', null, null, null, null);
INSERT INTO `fields_options` VALUES ('404', '109', 'cs', null, 'Vlak', null, null, null, null);
INSERT INTO `fields_options` VALUES ('405', '109', 'cs', null, 'Dálnice', null, null, null, null);
INSERT INTO `fields_options` VALUES ('406', '109', 'cs', null, 'Silnice', null, null, null, null);
INSERT INTO `fields_options` VALUES ('407', '109', 'cs', null, 'MHD', null, null, null, null);
INSERT INTO `fields_options` VALUES ('408', '109', 'cs', null, 'Autobus', null, null, null, null);
INSERT INTO `fields_options` VALUES ('409', '113', 'cs', null, 'Lokální plynové', null, null, null, null);
INSERT INTO `fields_options` VALUES ('410', '113', 'cs', null, 'Lokální tuhá paliva', null, null, null, null);
INSERT INTO `fields_options` VALUES ('411', '113', 'cs', null, 'Lokální elektrické', null, null, null, null);
INSERT INTO `fields_options` VALUES ('412', '113', 'cs', null, 'Ústřední plynové', null, null, null, null);
INSERT INTO `fields_options` VALUES ('413', '113', 'cs', null, 'Ústřední tuhá paliva', null, null, null, null);
INSERT INTO `fields_options` VALUES ('414', '113', 'cs', null, 'Ústřední elektrické', null, null, null, null);
INSERT INTO `fields_options` VALUES ('415', '113', 'cs', null, 'Ústřední dálkové', null, null, null, null);
INSERT INTO `fields_options` VALUES ('416', '113', 'cs', null, 'Jiné', null, null, null, null);

-- ----------------------------
-- Table structure for gender
-- ----------------------------
DROP TABLE IF EXISTS `gender`;
CREATE TABLE `gender` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `translation_lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `translation_of` int(10) unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `translation_lang` (`translation_lang`),
  KEY `translation_of` (`translation_of`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of gender
-- ----------------------------
INSERT INTO `gender` VALUES ('1', 'en', '3', 'Mr');
INSERT INTO `gender` VALUES ('2', 'en', '4', 'Mrs');
INSERT INTO `gender` VALUES ('3', 'cs', '3', 'Mr');
INSERT INTO `gender` VALUES ('4', 'cs', '4', 'Mrs');

-- ----------------------------
-- Table structure for home_sections
-- ----------------------------
DROP TABLE IF EXISTS `home_sections`;
CREATE TABLE `home_sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `method` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `view` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `field` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of home_sections
-- ----------------------------
INSERT INTO `home_sections` VALUES ('1', 'getSearchForm', 'Search Form Area', '{\"enable_form_area_customization\":\"1\",\"background_color\":null,\"background_image\":\"app\\/logo\\/header-5c1c611f18194.png\",\"height\":null,\"parallax\":\"0\",\"hide_form\":\"0\",\"form_border_color\":\"#eaeaea\",\"form_border_width\":\"10px\",\"form_btn_background_color\":null,\"form_btn_text_color\":null,\"hide_titles\":\"0\",\"title_en\":\"P\\u0159ejeme vesel\\u00e9 V\\u00e1noce\",\"sub_title_en\":\"5 Servers = 100% Prodej\",\"big_title_color\":\"#000000\",\"sub_title_color\":\"#00a0ff\",\"active\":\"1\"}', 'home.inc.search', null, '0', '0', '1', '1', '1');
INSERT INTO `home_sections` VALUES ('2', 'getLocations', 'Locations & Country Map', null, 'home.inc.locations', null, '0', '2', '3', '1', '1');
INSERT INTO `home_sections` VALUES ('3', 'getSponsoredPosts', 'Sponsored Ads', null, 'home.inc.featured', null, '0', '4', '5', '1', '1');
INSERT INTO `home_sections` VALUES ('4', 'getCategories', 'Categories', null, 'home.inc.categories', null, '0', '6', '7', '1', '0');
INSERT INTO `home_sections` VALUES ('5', 'getLatestPosts', 'Latest Ads', null, 'home.inc.latest', null, '0', '8', '9', '1', '1');
INSERT INTO `home_sections` VALUES ('6', 'getStats', 'Mini Stats', null, 'home.inc.stats', null, '0', '10', '11', '1', '1');
INSERT INTO `home_sections` VALUES ('7', 'getTopAdvertising', 'Advertising #1', null, 'layouts.inc.advertising.top', null, '0', '12', '13', '1', '0');
INSERT INTO `home_sections` VALUES ('8', 'getBottomAdvertising', 'Advertising #2', null, 'layouts.inc.advertising.bottom', null, '0', '14', '15', '1', '0');

-- ----------------------------
-- Table structure for invoices
-- ----------------------------
DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_total` double(8,2) NOT NULL,
  `total` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of invoices
-- ----------------------------

-- ----------------------------
-- Table structure for invoice_datas
-- ----------------------------
DROP TABLE IF EXISTS `invoice_datas`;
CREATE TABLE `invoice_datas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of invoice_datas
-- ----------------------------

-- ----------------------------
-- Table structure for languages
-- ----------------------------
DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `abbr` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `native` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flag` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `app_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `script` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `direction` enum('ltr','rtl') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ltr',
  `russian_pluralization` tinyint(1) unsigned DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `abbr` (`abbr`),
  KEY `active` (`active`),
  KEY `default` (`default`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of languages
-- ----------------------------
INSERT INTO `languages` VALUES ('1', 'en', 'en_US', 'English', 'English', null, 'english', 'Latn', 'ltr', '0', '0', '0', '0', '0', '0', '0', null, null, null);
INSERT INTO `languages` VALUES ('2', 'cs', 'cs_CZ', 'Czech', 'Czech', null, 'czech', null, 'ltr', '0', '1', '1', null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned DEFAULT '0',
  `parent_id` int(10) unsigned DEFAULT '0',
  `from_user_id` int(10) unsigned DEFAULT '0',
  `from_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `to_user_id` int(10) unsigned DEFAULT '0',
  `to_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `to_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `to_phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` text COLLATE utf8_unicode_ci,
  `message` text COLLATE utf8_unicode_ci,
  `filename` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) unsigned DEFAULT '0',
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `parent_id` (`parent_id`),
  KEY `from_user_id` (`from_user_id`),
  KEY `to_user_id` (`to_user_id`),
  KEY `deleted_by` (`deleted_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of messages
-- ----------------------------

-- ----------------------------
-- Table structure for meta_tags
-- ----------------------------
DROP TABLE IF EXISTS `meta_tags`;
CREATE TABLE `meta_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `translation_lang` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `translation_of` int(10) unsigned NOT NULL,
  `page` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `translation_lang` (`translation_lang`),
  KEY `translation_of` (`translation_of`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of meta_tags
-- ----------------------------
INSERT INTO `meta_tags` VALUES ('1', 'en', '9', 'home', '{app_name} - Geo Classified Ads CMS', 'Sell and Buy products and services on {app_name} in Minutes {country}. Free ads in {country}. Looking for a product or service - {country}', '{app_name}, {country}, free ads, classified, ads, script, app, premium ads', '1');
INSERT INTO `meta_tags` VALUES ('2', 'en', '10', 'register', 'Sign Up - {app_name}', 'Sign Up on {app_name}', '{app_name}, {country}, free ads, classified, ads, script, app, premium ads', '1');
INSERT INTO `meta_tags` VALUES ('3', 'en', '11', 'login', 'Login - {app_name}', 'Log in to {app_name}', '{app_name}, {country}, free ads, classified, ads, script, app, premium ads', '1');
INSERT INTO `meta_tags` VALUES ('4', 'en', '12', 'create', 'Post Free Ads', 'Post Free Ads - {country}.', '{app_name}, {country}, free ads, classified, ads, script, app, premium ads', '1');
INSERT INTO `meta_tags` VALUES ('5', 'en', '13', 'countries', 'Free Local Classified Ads in the World', 'Welcome to {app_name} : 100% Free Ads Classified. Sell and buy near you. Simple, fast and efficient.', '{app_name}, {country}, free ads, classified, ads, script, app, premium ads', '1');
INSERT INTO `meta_tags` VALUES ('6', 'en', '14', 'contact', 'Contact Us - {app_name}', 'Contact Us - {app_name}', '{app_name}, {country}, free ads, classified, ads, script, app, premium ads', '1');
INSERT INTO `meta_tags` VALUES ('7', 'en', '15', 'sitemap', 'Sitemap {app_name} - {country}', 'Sitemap {app_name} - {country}. 100% Free Ads Classified', '{app_name}, {country}, free ads, classified, ads, script, app, premium ads', '1');
INSERT INTO `meta_tags` VALUES ('8', 'en', '16', 'password', 'Lost your password? - {app_name}', 'Lost your password? - {app_name}', '{app_name}, {country}, free ads, classified, ads, script, app, premium ads', '1');
INSERT INTO `meta_tags` VALUES ('9', 'cs', '9', 'home', '{app_name} - Geo Classified Ads CMS', 'Sell and Buy products and services on {app_name} in Minutes {country}. Free ads in {country}. Looking for a product or service - {country}', '{app_name}, {country}, free ads, classified, ads, script, app, premium ads', '1');
INSERT INTO `meta_tags` VALUES ('10', 'cs', '10', 'register', 'Sign Up - {app_name}', 'Sign Up on {app_name}', '{app_name}, {country}, free ads, classified, ads, script, app, premium ads', '1');
INSERT INTO `meta_tags` VALUES ('11', 'cs', '11', 'login', 'Login - {app_name}', 'Log in to {app_name}', '{app_name}, {country}, free ads, classified, ads, script, app, premium ads', '1');
INSERT INTO `meta_tags` VALUES ('12', 'cs', '12', 'create', 'Post Free Ads', 'Post Free Ads - {country}.', '{app_name}, {country}, free ads, classified, ads, script, app, premium ads', '1');
INSERT INTO `meta_tags` VALUES ('13', 'cs', '13', 'countries', 'Free Local Classified Ads in the World', 'Welcome to {app_name} : 100% Free Ads Classified. Sell and buy near you. Simple, fast and efficient.', '{app_name}, {country}, free ads, classified, ads, script, app, premium ads', '1');
INSERT INTO `meta_tags` VALUES ('14', 'cs', '14', 'contact', 'Contact Us - {app_name}', 'Contact Us - {app_name}', '{app_name}, {country}, free ads, classified, ads, script, app, premium ads', '1');
INSERT INTO `meta_tags` VALUES ('15', 'cs', '15', 'sitemap', 'Sitemap {app_name} - {country}', 'Sitemap {app_name} - {country}. 100% Free Ads Classified', '{app_name}, {country}, free ads, classified, ads, script, app, premium ads', '1');
INSERT INTO `meta_tags` VALUES ('16', 'cs', '16', 'password', 'Lost your password? - {app_name}', 'Lost your password? - {app_name}', '{app_name}, {country}, free ads, classified, ads, script, app, premium ads', '1');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('2016_06_01_000001_create_oauth_auth_codes_table', '1');
INSERT INTO `migrations` VALUES ('2016_06_01_000002_create_oauth_access_tokens_table', '1');
INSERT INTO `migrations` VALUES ('2016_06_01_000003_create_oauth_refresh_tokens_table', '1');
INSERT INTO `migrations` VALUES ('2016_06_01_000004_create_oauth_clients_table', '1');
INSERT INTO `migrations` VALUES ('2016_06_01_000005_create_oauth_personal_access_clients_table', '1');
INSERT INTO `migrations` VALUES ('2019_04_06_055648_create_sync_tabel', '2');
INSERT INTO `migrations` VALUES ('2019_05_14_180516_add_cityanddistrict_to_users_table', '3');
INSERT INTO `migrations` VALUES ('2019_05_17_183436_create_admin_services_table', '4');
INSERT INTO `migrations` VALUES ('2019_05_15_160953_create_coupons_table', '5');
INSERT INTO `migrations` VALUES ('2019_05_15_161108_create_invoices_table', '6');
INSERT INTO `migrations` VALUES ('2019_05_15_161607_create_invoice_datas_table', '7');
INSERT INTO `migrations` VALUES ('2019_05_16_030633_create_appointments_table', '8');
INSERT INTO `migrations` VALUES ('2019_05_17_151015_create_fast_sells_table', '9');

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES ('1', '1', 'App\\Models\\User');

-- ----------------------------
-- Table structure for oauth_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of oauth_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for oauth_auth_codes
-- ----------------------------
DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `scopes` text COLLATE utf8_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of oauth_auth_codes
-- ----------------------------

-- ----------------------------
-- Table structure for oauth_clients
-- ----------------------------
DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of oauth_clients
-- ----------------------------

-- ----------------------------
-- Table structure for oauth_personal_access_clients
-- ----------------------------
DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of oauth_personal_access_clients
-- ----------------------------

-- ----------------------------
-- Table structure for oauth_refresh_tokens
-- ----------------------------
DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of oauth_refresh_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('1', '23', '1');
INSERT INTO `orders` VALUES ('2', '23', '2');
INSERT INTO `orders` VALUES ('3', '23', '4');

-- ----------------------------
-- Table structure for packages
-- ----------------------------
DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `translation_lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `translation_of` int(10) unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'In country language',
  `short_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'In country language',
  `ribbon` enum('red','orange','green') COLLATE utf8_unicode_ci DEFAULT NULL,
  `has_badge` tinyint(1) unsigned DEFAULT '0',
  `price` decimal(10,2) unsigned DEFAULT NULL,
  `currency_code` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `duration` int(10) unsigned DEFAULT '30' COMMENT 'In days',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'In country language',
  `parent_id` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of packages
-- ----------------------------
INSERT INTO `packages` VALUES ('1', 'en', '5', 'Regular List', 'FREE', null, '0', '0.00', 'CZK', '30', 'Regular List', '0', '2', '3', '1', '1');
INSERT INTO `packages` VALUES ('2', 'en', '6', 'Urgent Ad', 'Urgent', 'red', '0', '150.00', 'CZK', '30', 'Urgent', '0', '4', '5', '1', '1');
INSERT INTO `packages` VALUES ('3', 'en', '7', 'Top page Ad', 'Premium', 'orange', '1', '1500.00', 'CZK', '30', 'Top Ads', '0', '6', '7', '1', '1');
INSERT INTO `packages` VALUES ('4', 'en', '8', 'Top page Ad + Urgent Ad', 'Premium+', 'green', '1', '3500.00', 'CZK', '30', 'Featured Ads', '0', '8', '9', '1', '1');
INSERT INTO `packages` VALUES ('5', 'cs', '5', 'Regular List', 'FREE', null, '0', '0.00', 'CZK', '30', 'Regular List', '0', '2', '3', '1', '1');
INSERT INTO `packages` VALUES ('6', 'cs', '6', 'Urgent Ad', 'Urgent', 'red', '0', '150.00', 'CZK', '30', 'Urgent', '0', '4', '5', '1', '1');
INSERT INTO `packages` VALUES ('7', 'cs', '7', 'Top page Ad', 'Premium', 'orange', '1', '1500.00', 'CZK', '30', 'Top Ads', '0', '6', '7', '1', '1');
INSERT INTO `packages` VALUES ('8', 'cs', '8', 'Top page Ad + Urgent Ad', 'Premium+', 'green', '1', '3500.00', 'CZK', '30', 'Featured Ads', '0', '8', '9', '1', '1');

-- ----------------------------
-- Table structure for pages
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `translation_lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `translation_of` int(10) unsigned DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `type` enum('standard','terms','privacy','tips') COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `external_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `name_color` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title_color` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `target_blank` tinyint(1) unsigned DEFAULT '0',
  `excluded_from_footer` tinyint(1) unsigned DEFAULT '0',
  `active` tinyint(1) unsigned DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `translation_lang` (`translation_lang`),
  KEY `translation_of` (`translation_of`),
  KEY `parent_id` (`parent_id`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES ('1', 'en', '5', '0', 'terms', 'Terms', 'terms', 'Terms & Conditions', null, '<h4><b>Definitions</b></h4><p>Each of the terms mentioned below have in these Conditions of Sale LaraClassified Service (hereinafter the \"Conditions\") the following meanings:</p><ol><li>Announcement&nbsp;: refers to all the elements and data (visual, textual, sound, photographs, drawings), presented by an Advertiser editorial under his sole responsibility, in order to buy, rent or sell a product or service and broadcast on the Website and Mobile Site.</li><li>Advertiser&nbsp;: means any natural or legal person, a major, established in France, holds an account and having submitted an announcement, from it, on the Website. Any Advertiser must be connected to the Personal Account for deposit and or manage its ads. Ad first deposit automatically entails the establishment of a Personal Account to the Advertiser.</li><li>Personal Account&nbsp;: refers to the free space than any Advertiser must create and which it should connect from the Website to disseminate, manage and view its ads.</li><li>LaraClassified&nbsp;: means the company that publishes and operates the Website and Mobile Site {YourCompany}, registered at the Trade and Companies Register of Cotonou under the number {YourCompany Registration Number} whose registered office is at {YourCompany Address}.</li><li>Customer Service&nbsp;: LaraClassified means the department to which the Advertiser may obtain further information. This service can be contacted via email by clicking the link on the Website and Mobile Site.</li><li>LaraClassified Service&nbsp;: LaraClassified means the services made available to Users and Advertisers on the Website and Mobile Site.</li><li>Website&nbsp;: means the website operated by LaraClassified accessed mainly from the URL <a href=\"http://www.bedigit.com\">http://www.bedigit.com</a> and allowing Users and Advertisers to access the Service via internet LaraClassified.</li><li>Mobile Site&nbsp;: is the mobile site operated by LaraClassified accessible from the URL <a href=\"http://www.bedigit.com\">http://www.bedigit.com</a> and allowing Users and Advertisers to access via their mobile phone service {YourSiteName}.</li><li>User&nbsp;: any visitor with access to LaraClassified Service via the Website and Mobile Site and Consultant Service LaraClassified accessible from different media.</li></ol><h4><b>Subject</b></h4><p>These Terms and Conditions Of Use establish the contractual conditions applicable to any subscription by an Advertiser connected to its Personal Account from the Website and Mobile Site.<br></p><h4><b>Acceptance</b></h4><p>Any use of the website by an Advertiser is full acceptance of the current Terms.<br></p><h4><b>Responsibility</b></h4><p>Responsibility for LaraClassified can not be held liable for non-performance or improper performance of due control, either because of the Advertiser, or a case of major force.<br></p><h4><b>Modification of these terms</b></h4><p>LaraClassified reserves the right, at any time, to modify all or part of the Terms and Conditions.</p><p>Advertisers are advised to consult the Terms to be aware of the changes.</p><h4><b>Miscellaneous</b></h4><p>If part of the Terms should be illegal, invalid or unenforceable for any reason whatsoever, the provisions in question would be deemed unwritten, without questioning the validity of the remaining provisions will continue to apply between Advertisers and LaraClassified.</p><p>Any complaints should be addressed to Customer Service LaraClassified.</p>', null, '6', '7', '1', null, null, '0', '0', '1', '2017-02-10 19:10:40', '2019-04-10 21:36:31');
INSERT INTO `pages` VALUES ('2', 'en', '6', '0', 'privacy', 'Privacy', 'privacy', 'Privacy', null, '<p>Your privacy is an important part of our relationship with you. Protecting your privacy is only part of our mission to provide a secure web environment. When using our site, including our services, your information will remain strictly confidential. Contributions made on our blog or on our forum are open to public view; so please do not post any personal information in your dealings with others. We accept no liability for those actions because it is your sole responsibility to adequate and safe post content on our site. We will not share, rent or share your information with third parties.</p><p>When you visit our site, we collect technical information about your computer and how you access our website and analyze this information such as Internet Protocol (IP) address of your computer, the operating system used by your computer, the browser (eg, Chrome, Firefox, Internet Explorer or other) your computer uses, the name of your Internet service provider (ISP), the Uniform Resource Locator (URL) of the website from which you come and the URL to which you go next and certain operating metrics such as the number of times you use our website. This general information can be used to help us better understand how our site is viewed and used. We may share this general information about our site with our business partners or the general public. For example, we may share the information on the number of daily unique visitors to our site with potential corporate partners or use them for advertising purposes. This information does contain any of your personal data that can be used to contact you or identify you.</p><p>When we place links or banners to other sites of our website, please note that we do not control this kind of content or practices or privacy policies of those sites. We do not endorse or assume no responsibility for the privacy policies or information collection practices of any other website other than managed sites LaraClassified.</p><p>We use the highest security standard available to protect your identifiable information in transit to us. All data stored on our servers are protected by a secure firewall for the unauthorized use or activity can not take place. Although we make every effort to protect your personal information against loss, misuse or alteration by third parties, you should be aware that there is always a risk that low-intentioned manage to find a way to thwart our security system or that Internet transmissions could be intercepted.</p><p>We reserve the right, without notice, to change, modify, add or remove portions of our Privacy Policy at any time and from time to time. These changes will be posted publicly on our website. When you visit our website, you accept all the terms of our privacy policy. Your continued use of this website constitutes your continued agreement to these terms. If you do not agree with the terms of our privacy policy, you should cease using our website.</p>', null, '8', '9', '1', null, null, '0', '0', '1', '2017-02-10 19:28:37', '2019-04-10 21:36:31');
INSERT INTO `pages` VALUES ('3', 'en', '7', '0', 'standard', 'Anti-Scam', 'anti-scam', 'Anti-Scam', null, '<p><b>Protect yourself against Internet fraud!</b></p><p>The vast majority of ads are posted by honest people and trust. So you can do excellent business. Despite this, it is important to follow a few common sense rules following to prevent any attempt to scam.</p><p><b>Our advices</b></p><ul><li>Doing business with people you can meet in person.</li><li>Never send money by Western Union, MoneyGram or other anonymous payment systems.</li><li>Never send money or products abroad.</li><li>Do not accept checks.</li><li>Ask about the person you\'re dealing with another confirming source name, address and telephone number.</li><li>Keep copies of all correspondence (emails, ads, letters, etc.) and details of the person.</li><li>If a deal seems too good to be true, there is every chance that this is the case. Refrain.</li></ul><p><b>Recognize attempted scam</b></p><ul><li>The majority of scams have one or more of these characteristics:</li><li>The person is abroad or traveling abroad.</li><li>The person refuses to meet you in person.</li><li>Payment is made through Western Union, Money Gram or check.</li><li>The messages are in broken language (English or French or ...).</li><li>The texts seem to be copied and pasted.</li><li>The deal seems to be too good to be true.</li></ul>', null, '4', '5', '1', null, null, '0', '0', '1', '2017-02-10 19:31:56', '2019-04-10 21:36:31');
INSERT INTO `pages` VALUES ('4', 'en', '8', '0', 'standard', 'FAQ', 'faq', 'Frequently Asked Questions', null, '<p><b>How do I place an ad?</b></p><p>It\'s very easy to place an ad: click on the button \"Post free Ads\" above right.</p><p><b>What does it cost to advertise?</b></p><p>The publication is 100% free throughout the website.</p><p><b>If I post an ad, will I also get more spam e-mails?</b></p><p>Absolutely not because your email address is not visible on the website.</p><p><b>How long will my ad remain on the website?</b></p><p>In general, an ad is automatically deactivated from the website after 3 months. You will receive an email a week before D-Day and another on the day of deactivation. You have the ability to put them online in the following month by logging into your account on the site. After this delay, your ad will be automatically removed permanently from the website.</p><p><b>I sold my item. How do I delete my ad?</b></p><p>Once your product is sold or leased, log in to your account to remove your ad.</p>', null, '2', '3', '1', null, null, '0', '0', '1', '2017-02-10 19:34:56', '2019-04-10 21:36:31');
INSERT INTO `pages` VALUES ('5', 'cs', '5', '0', 'terms', 'Terms', 'terms', 'Terms & Conditions', null, '<h4><b>Definitions</b></h4><p>Each of the terms mentioned below have in these Conditions of Sale LaraClassified Service (hereinafter the \"Conditions\") the following meanings:</p><ol><li>Announcement&nbsp;: refers to all the elements and data (visual, textual, sound, photographs, drawings), presented by an Advertiser editorial under his sole responsibility, in order to buy, rent or sell a product or service and broadcast on the Website and Mobile Site.</li><li>Advertiser&nbsp;: means any natural or legal person, a major, established in France, holds an account and having submitted an announcement, from it, on the Website. Any Advertiser must be connected to the Personal Account for deposit and or manage its ads. Ad first deposit automatically entails the establishment of a Personal Account to the Advertiser.</li><li>Personal Account&nbsp;: refers to the free space than any Advertiser must create and which it should connect from the Website to disseminate, manage and view its ads.</li><li>LaraClassified&nbsp;: means the company that publishes and operates the Website and Mobile Site {YourCompany}, registered at the Trade and Companies Register of Cotonou under the number {YourCompany Registration Number} whose registered office is at {YourCompany Address}.</li><li>Customer Service&nbsp;: LaraClassified means the department to which the Advertiser may obtain further information. This service can be contacted via email by clicking the link on the Website and Mobile Site.</li><li>LaraClassified Service&nbsp;: LaraClassified means the services made available to Users and Advertisers on the Website and Mobile Site.</li><li>Website&nbsp;: means the website operated by LaraClassified accessed mainly from the URL <a href=\"http://www.bedigit.com\">http://www.bedigit.com</a> and allowing Users and Advertisers to access the Service via internet LaraClassified.</li><li>Mobile Site&nbsp;: is the mobile site operated by LaraClassified accessible from the URL <a href=\"http://www.bedigit.com\">http://www.bedigit.com</a> and allowing Users and Advertisers to access via their mobile phone service {YourSiteName}.</li><li>User&nbsp;: any visitor with access to LaraClassified Service via the Website and Mobile Site and Consultant Service LaraClassified accessible from different media.</li></ol><h4><b>Subject</b></h4><p>These Terms and Conditions Of Use establish the contractual conditions applicable to any subscription by an Advertiser connected to its Personal Account from the Website and Mobile Site.<br></p><h4><b>Acceptance</b></h4><p>Any use of the website by an Advertiser is full acceptance of the current Terms.<br></p><h4><b>Responsibility</b></h4><p>Responsibility for LaraClassified can not be held liable for non-performance or improper performance of due control, either because of the Advertiser, or a case of major force.<br></p><h4><b>Modification of these terms</b></h4><p>LaraClassified reserves the right, at any time, to modify all or part of the Terms and Conditions.</p><p>Advertisers are advised to consult the Terms to be aware of the changes.</p><h4><b>Miscellaneous</b></h4><p>If part of the Terms should be illegal, invalid or unenforceable for any reason whatsoever, the provisions in question would be deemed unwritten, without questioning the validity of the remaining provisions will continue to apply between Advertisers and LaraClassified.</p><p>Any complaints should be addressed to Customer Service LaraClassified.</p>', null, '6', '7', '1', null, null, '0', '0', '1', '2018-12-21 10:10:34', '2019-04-10 21:36:31');
INSERT INTO `pages` VALUES ('6', 'cs', '6', '0', 'privacy', 'Privacy', 'privacy', 'Privacy', null, '<p>Your privacy is an important part of our relationship with you. Protecting your privacy is only part of our mission to provide a secure web environment. When using our site, including our services, your information will remain strictly confidential. Contributions made on our blog or on our forum are open to public view; so please do not post any personal information in your dealings with others. We accept no liability for those actions because it is your sole responsibility to adequate and safe post content on our site. We will not share, rent or share your information with third parties.</p><p>When you visit our site, we collect technical information about your computer and how you access our website and analyze this information such as Internet Protocol (IP) address of your computer, the operating system used by your computer, the browser (eg, Chrome, Firefox, Internet Explorer or other) your computer uses, the name of your Internet service provider (ISP), the Uniform Resource Locator (URL) of the website from which you come and the URL to which you go next and certain operating metrics such as the number of times you use our website. This general information can be used to help us better understand how our site is viewed and used. We may share this general information about our site with our business partners or the general public. For example, we may share the information on the number of daily unique visitors to our site with potential corporate partners or use them for advertising purposes. This information does contain any of your personal data that can be used to contact you or identify you.</p><p>When we place links or banners to other sites of our website, please note that we do not control this kind of content or practices or privacy policies of those sites. We do not endorse or assume no responsibility for the privacy policies or information collection practices of any other website other than managed sites LaraClassified.</p><p>We use the highest security standard available to protect your identifiable information in transit to us. All data stored on our servers are protected by a secure firewall for the unauthorized use or activity can not take place. Although we make every effort to protect your personal information against loss, misuse or alteration by third parties, you should be aware that there is always a risk that low-intentioned manage to find a way to thwart our security system or that Internet transmissions could be intercepted.</p><p>We reserve the right, without notice, to change, modify, add or remove portions of our Privacy Policy at any time and from time to time. These changes will be posted publicly on our website. When you visit our website, you accept all the terms of our privacy policy. Your continued use of this website constitutes your continued agreement to these terms. If you do not agree with the terms of our privacy policy, you should cease using our website.</p>', null, '8', '9', '1', null, null, '0', '0', '1', '2018-12-21 10:10:34', '2019-04-10 21:36:31');
INSERT INTO `pages` VALUES ('7', 'cs', '7', '0', 'standard', 'Anti-Scam', 'anti-scam', 'Anti-Scam', null, '<p><b>Protect yourself against Internet fraud!</b></p><p>The vast majority of ads are posted by honest people and trust. So you can do excellent business. Despite this, it is important to follow a few common sense rules following to prevent any attempt to scam.</p><p><b>Our advices</b></p><ul><li>Doing business with people you can meet in person.</li><li>Never send money by Western Union, MoneyGram or other anonymous payment systems.</li><li>Never send money or products abroad.</li><li>Do not accept checks.</li><li>Ask about the person you\'re dealing with another confirming source name, address and telephone number.</li><li>Keep copies of all correspondence (emails, ads, letters, etc.) and details of the person.</li><li>If a deal seems too good to be true, there is every chance that this is the case. Refrain.</li></ul><p><b>Recognize attempted scam</b></p><ul><li>The majority of scams have one or more of these characteristics:</li><li>The person is abroad or traveling abroad.</li><li>The person refuses to meet you in person.</li><li>Payment is made through Western Union, Money Gram or check.</li><li>The messages are in broken language (English or French or ...).</li><li>The texts seem to be copied and pasted.</li><li>The deal seems to be too good to be true.</li></ul>', null, '4', '5', '1', null, null, '0', '0', '1', '2018-12-21 10:10:34', '2019-04-10 21:36:31');
INSERT INTO `pages` VALUES ('8', 'cs', '8', '0', 'standard', 'FAQ', 'faq', 'Frequently Asked Questions', null, '<p><b>How do I place an ad?</b></p><p>It\'s very easy to place an ad: click on the button \"Post free Ads\" above right.</p><p><b>What does it cost to advertise?</b></p><p>The publication is 100% free throughout the website.</p><p><b>If I post an ad, will I also get more spam e-mails?</b></p><p>Absolutely not because your email address is not visible on the website.</p><p><b>How long will my ad remain on the website?</b></p><p>In general, an ad is automatically deactivated from the website after 3 months. You will receive an email a week before D-Day and another on the day of deactivation. You have the ability to put them online in the following month by logging into your account on the site. After this delay, your ad will be automatically removed permanently from the website.</p><p><b>I sold my item. How do I delete my ad?</b></p><p>Once your product is sold or leased, log in to your account to remove your ad.</p>', null, '2', '3', '1', null, null, '0', '0', '1', '2018-12-21 10:10:34', '2019-04-10 21:36:31');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for payments
-- ----------------------------
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned DEFAULT NULL,
  `package_id` int(10) unsigned DEFAULT NULL,
  `payment_method_id` int(10) unsigned DEFAULT '0',
  `transaction_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Transaction''s ID at the Provider',
  `invoice_id` int(11) DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_method_id` (`payment_method_id`),
  KEY `package_id` (`package_id`) USING BTREE,
  KEY `post_id` (`post_id`),
  KEY `active` (`active`),
  KEY `transaction_id` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of payments
-- ----------------------------

-- ----------------------------
-- Table structure for payment_methods
-- ----------------------------
DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE `payment_methods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `has_ccbox` tinyint(1) unsigned DEFAULT '0',
  `is_compatible_api` tinyint(1) DEFAULT '0',
  `countries` text COLLATE utf8_unicode_ci COMMENT 'Countries codes separated by comma.',
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `has_ccbox` (`has_ccbox`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of payment_methods
-- ----------------------------
INSERT INTO `payment_methods` VALUES ('1', 'paypal', 'Paypal', 'Payment with Paypal', '0', '0', null, '0', '0', '1', '0', '1');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'list-permission', 'web', '2018-12-21 10:07:11', '2018-12-21 10:07:11');
INSERT INTO `permissions` VALUES ('2', 'create-permission', 'web', '2018-12-21 10:07:11', '2018-12-21 10:07:11');
INSERT INTO `permissions` VALUES ('3', 'update-permission', 'web', '2018-12-21 10:07:11', '2018-12-21 10:07:11');
INSERT INTO `permissions` VALUES ('4', 'delete-permission', 'web', '2018-12-21 10:07:11', '2018-12-21 10:07:11');
INSERT INTO `permissions` VALUES ('5', 'list-role', 'web', '2018-12-21 10:07:11', '2018-12-21 10:07:11');
INSERT INTO `permissions` VALUES ('6', 'create-role', 'web', '2018-12-21 10:07:11', '2018-12-21 10:07:11');
INSERT INTO `permissions` VALUES ('7', 'update-role', 'web', '2018-12-21 10:07:11', '2018-12-21 10:07:11');
INSERT INTO `permissions` VALUES ('8', 'delete-role', 'web', '2018-12-21 10:07:11', '2018-12-21 10:07:11');
INSERT INTO `permissions` VALUES ('9', 'access-dashboard', 'web', '2018-12-21 10:07:11', '2018-12-21 10:07:11');

-- ----------------------------
-- Table structure for pictures
-- ----------------------------
DROP TABLE IF EXISTS `pictures`;
CREATE TABLE `pictures` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(10) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) unsigned DEFAULT '1' COMMENT 'Set at 0 on updating the ad',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pictures
-- ----------------------------
INSERT INTO `pictures` VALUES ('9', '3', 'files/cz/3/c60e1eabee59d43e9c5f763a8a308e36.jpg', '1', '1', '2018-12-21 11:59:55', '2018-12-21 11:59:55');
INSERT INTO `pictures` VALUES ('15', '5', 'files/cz/5/c8e26e392881467f697d5232e3874c38.JPG', '1', '1', '2018-12-23 05:23:10', '2018-12-23 05:23:10');
INSERT INTO `pictures` VALUES ('16', '5', 'files/cz/5/5dce49ee051ce46b3e5549445f4356bc.JPG', '2', '1', '2018-12-23 05:23:10', '2018-12-23 05:23:10');
INSERT INTO `pictures` VALUES ('17', '5', 'files/cz/5/f807ad1f7aee24bd4127408bb2cf9a3c.JPG', '3', '1', '2018-12-23 05:23:10', '2018-12-23 05:23:10');
INSERT INTO `pictures` VALUES ('18', '5', 'files/cz/5/5f989b33ccc712db126ad71a65efd41a.JPG', '4', '1', '2018-12-23 05:23:10', '2018-12-23 05:23:10');
INSERT INTO `pictures` VALUES ('19', '6', 'files/cz/6/69c47dde7aa1386cbccce74e44ba3702.JPG', '1', '1', '2018-12-23 06:00:29', '2018-12-23 06:00:29');
INSERT INTO `pictures` VALUES ('20', '6', 'files/cz/6/0855cd919fcff54bc312cb07429bca23.JPG', '2', '1', '2018-12-23 06:00:29', '2018-12-23 06:00:29');
INSERT INTO `pictures` VALUES ('21', '6', 'files/cz/6/055758b12a622cba64bbac38d8946b73.JPG', '3', '1', '2018-12-23 06:00:29', '2018-12-23 06:00:29');
INSERT INTO `pictures` VALUES ('22', '8', 'files/cz/8/e5b6dc5b2f99c768a18186f300df0723.jpg', '1', '1', '2019-01-08 06:56:09', '2019-01-08 06:56:09');
INSERT INTO `pictures` VALUES ('25', '15', 'files/cz/15/50c1f1cc434d6f310acb7ffe2c59f4f7.jpeg', '1', '1', '2019-04-20 03:46:19', '2019-04-20 03:46:19');
INSERT INTO `pictures` VALUES ('26', '17', 'files/cz/17/3e7f84a74bc967d882fb512bd0d6530a.png', '1', '1', '2019-04-24 10:34:26', '2019-04-24 10:34:26');
INSERT INTO `pictures` VALUES ('27', '19', 'files/cz/19/6686e6cb59edc1181d7fdca40421d445.png', '1', '1', '2019-05-03 10:22:35', '2019-05-03 10:22:35');
INSERT INTO `pictures` VALUES ('28', '20', 'files/cz/20/dc78f3fdf15279e0aae8405e7c2dc14c.png', '1', '1', '2019-05-03 10:30:44', '2019-05-03 10:30:44');
INSERT INTO `pictures` VALUES ('29', '21', 'files/cz/21/a7bc88a80e74840c8647897dbc2d55b3.png', '1', '1', '2019-05-03 10:38:09', '2019-05-03 10:38:09');
INSERT INTO `pictures` VALUES ('31', '23', 'files/cz/23/24dc92d140b89aebc7824784eb133c36.jpg', '1', '1', '2019-05-03 23:06:03', '2019-05-03 23:06:03');
INSERT INTO `pictures` VALUES ('32', '22', 'files/cz/22/cfd5162ac95f167b4b6722c137c47d98.jpg', '1', '1', '2019-05-10 04:57:41', '2019-05-10 04:57:41');
INSERT INTO `pictures` VALUES ('33', '27', 'files/cz/27/8e78c59bd3deb4db010f1719c1306f69.png', '1', '1', '2019-05-16 23:25:30', '2019-05-16 23:25:30');
INSERT INTO `pictures` VALUES ('34', '28', 'files/cz/28/63eecbd35d550dd67478dbdd39b0f69f.png', '1', '1', '2019-05-17 00:56:25', '2019-05-17 00:56:25');
INSERT INTO `pictures` VALUES ('35', '28', 'files/cz/28/b3047689a96d70b7bdc1bb190ed7c99e.png', '1', '1', '2019-05-17 03:03:44', '2019-05-17 03:03:44');
INSERT INTO `pictures` VALUES ('36', '29', 'files/cz/29/21088065e040b7477c421b4bece1eac8.png', '1', '1', '2019-05-17 17:01:48', '2019-05-17 17:01:48');
INSERT INTO `pictures` VALUES ('37', '35', 'files/cz/35/254390099343c35c9fada260e205c927.png', '1', '1', '2019-05-18 02:45:12', '2019-05-18 02:45:12');

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `category_id` int(10) unsigned NOT NULL DEFAULT '0',
  `post_type_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `tags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(17,2) unsigned DEFAULT NULL,
  `negotiable` tinyint(1) DEFAULT '0',
  `contact_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_hidden` tinyint(1) DEFAULT '0',
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lon` float DEFAULT NULL COMMENT 'longitude in decimal degrees (wgs84)',
  `lat` float DEFAULT NULL COMMENT 'latitude in decimal degrees (wgs84)',
  `ip_addr` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `visits` int(10) unsigned DEFAULT '0',
  `email_token` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_token` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tmp_token` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verified_email` tinyint(1) DEFAULT '0',
  `verified_phone` tinyint(1) unsigned DEFAULT '1',
  `reviewed` tinyint(1) DEFAULT '0',
  `featured` tinyint(1) unsigned DEFAULT '0',
  `archived` tinyint(1) DEFAULT '0',
  `archived_at` timestamp NULL DEFAULT NULL,
  `archived_manually` tinyint(3) unsigned DEFAULT '0',
  `street_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `house_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `orientational_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `town_district` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `town_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deletion_mail_sent_at` timestamp NULL DEFAULT NULL,
  `fb_profile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `partner` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sreality` int(11) DEFAULT NULL,
  `idnes` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lat` (`lon`,`lat`),
  KEY `country_code` (`country_code`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  KEY `title` (`title`),
  KEY `address` (`address`),
  KEY `city_id` (`city_id`),
  KEY `reviewed` (`reviewed`),
  KEY `featured` (`featured`),
  KEY `post_type_id` (`post_type_id`),
  KEY `verified_email` (`verified_email`),
  KEY `verified_phone` (`verified_phone`),
  KEY `contact_name` (`contact_name`),
  KEY `tags` (`tags`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES ('3', 'CZ', '2', '173', '3', 'Dfgdf', '<p>ddfgdg<br></p>', null, '44545.00', '0', 'Admin', 'junell@xlabs.systems', null, '0', null, '3067421', '17.1118', '49.4719', '37.187.143.63', '1', null, null, 'e68a261c024d321130d67437096bed84', '1', '1', '0', '0', '1', '2019-03-21 13:00:02', '0', null, null, null, null, null, null, null, null, null, null, null, '2018-12-21 11:10:11', '2019-04-10 21:36:30', null);
INSERT INTO `posts` VALUES ('5', 'CZ', '2', '172', '3', 'Prodej, rodinný dům, Mariánské Lázně', '<p>kuruku ahoj Junell jak se máš</p>', null, '1500000.00', null, 'Adam Soleh', 'solehada@gmail.com', '+420773602900', null, null, '3071024', '12.7012', '49.9646', '185.151.174.57', '5', null, null, null, '1', '1', '0', '0', '1', '2019-03-23 07:00:02', '0', null, null, null, null, null, null, null, null, null, null, null, '2018-12-23 05:22:36', '2019-04-10 21:36:30', null);
INSERT INTO `posts` VALUES ('6', 'CZ', '2', '172', '4', 'Prodej, rodinný dům, Plzeň', '<p>Nabízíme k prodeji novostavbu rodinného domu o dispozici 5+2. Dvoupodlažní nízkoenergetický dům se zahradou 500 m2 je k dispozici ihned. V přízemí kuchyně, obývací pokoj, koupelna</p>', null, '3650000.00', null, 'Adam Soleh', 'solehada@gmail.com', '+420773602900', null, null, '3068160', '13.3776', '49.7475', '185.151.174.57', '4', null, null, null, '1', '1', '0', '0', '1', '2019-03-23 07:00:02', '0', null, null, null, null, null, null, null, null, null, null, null, '2018-12-23 06:00:02', '2019-04-10 21:36:30', null);
INSERT INTO `posts` VALUES ('8', 'CZ', '2', '172', '4', 'Kukuruku', '<p>kujhzu</p>', null, '1300000.00', null, 'Frenk', 'solehada@gmail.com', '+420556453345', null, null, '3070451', '14.9713', '50.5272', '185.151.174.57', '2', null, null, null, '1', '1', '0', '0', '1', '2019-04-08 08:00:02', '0', null, null, null, null, null, null, null, null, null, null, null, '2019-01-08 06:55:53', '2019-04-10 21:36:30', null);
INSERT INTO `posts` VALUES ('12', 'CZ', '0', '163', '3', 'fdgdgf dgdfgd', '<p>dkhjhdjdh kjjhjh dkhjhkd khjh    djhhhjj<br></p>', null, null, null, 'fdsfs', 'junell@xlabs.systems1', null, null, null, '3071024', '12.7012', '49.9646', '37.187.143.63', '2', null, null, null, '1', '1', '0', '0', '0', null, '0', 'Ruská', '608', '52a', 'Mariánské Lázně', 'Mariánské Lázně', '35301', null, null, null, null, null, '2019-02-05 12:23:24', '2019-04-10 21:36:30', null);
INSERT INTO `posts` VALUES ('13', 'CZ', '0', '173', '3', 'Byt 2+1', '<p>Super byt<br></p>', null, '35000000.00', null, 'Jan Tešnar', 'jan.tesnar@email.cz', null, null, null, '3068799', '18.282', '49.8346', '193.165.236.40', '0', null, null, '206c769acba791830f1ae676679043ac', '1', '1', '0', '0', '0', null, '0', 'Karpatská', '2859', '27', 'Zábřeh', 'Ostrava', '70030', null, null, null, null, null, '2019-03-21 04:03:24', '2019-04-10 21:36:30', null);
INSERT INTO `posts` VALUES ('14', 'CZ', '0', '173', '3', 'dfsdf', '<p>dsfsdffssdffffffffffffffffffffffffffffffffffffffffffffff ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff<br></p>', 's', '22.00', null, 'Tester Man', 'de@vland.eu', '34343433333', null, null, '3071024', '12.7012', '49.9646', '37.187.143.63', '0', null, null, '6706ce0b97c6b454e91ba483d69fab84', '1', '1', '0', '0', '0', null, '0', 'Ruská', '608', '52a', 'Mariánské Lázně', 'Mariánské Lázně', '35301', null, null, null, null, null, '2019-04-06 23:23:19', '2019-04-10 21:36:30', null);
INSERT INTO `posts` VALUES ('15', 'CZ', '0', '265', '4', 'Prodej, byt 3kk', '<p>Udjsihiuhiuh. Pu8g piuhké. </p>', null, '1250000.00', null, 'Adamos', 'Solehada@gmail.com', '666777665', null, null, '3071024', '12.7012', '49.9646', '185.151.174.63', '11', null, null, null, '1', '1', '0', '0', '0', null, '0', 'Ruská', '608', '52a', 'Mariánské Lázně', 'Mariánské Lázně', '35301', null, null, null, null, null, '2019-04-20 03:45:17', '2019-05-09 03:41:48', null);
INSERT INTO `posts` VALUES ('17', 'CZ', '1', '247', '4', 'gbbbbbbbbbbbbbbbbbbbbbbbbbbbb', '<p>ssssssssssssssssssssssssddddddddddddddddddddddaaaaaaaaaaaaaa  sa<br></p>', null, null, null, 'Admin', 'junell@xlabs.systems', '+420605132128', null, null, '3067696', '14.4208', '50.088', '37.187.143.63', '6', null, null, '0b3cb67514974a9b2832b9a0328be768', '1', '1', '0', '0', '0', null, '0', null, null, '52a', null, null, null, null, null, null, null, null, '2019-04-24 10:31:57', '2019-05-15 16:22:44', null);
INSERT INTO `posts` VALUES ('18', 'CZ', '1', '259', '3', 'Testttjh j jhgjhghhh hhgjh', '<p>kljkkkkkkkkkkkkkkkkk KJKKKKKKKKKKKKKKKKKKKKKKKKKKK kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk<br></p>', null, '1500.00', null, 'Admin', 'junell@xlabs.systems', null, null, null, '3067696', '14.4208', '50.088', '37.187.143.63', '1', null, null, '54f83002656fba2cb53ff29f7865c8c7', '1', '1', '0', '0', '0', null, '0', null, null, '52a', null, null, null, null, null, null, null, null, '2019-05-03 09:47:01', '2019-05-03 22:35:21', null);
INSERT INTO `posts` VALUES ('19', 'CZ', '0', '259', '3', 'Testttt finalle', '<p>asfdsdf lkdsajs fsdjf lkjlkjd flsk dfdfggggggggggggggggggggggggggggggggggggggggggggggv ggggggggggggg<br></p>', null, '1300.00', null, 'Charles de goul', 'accountant@xlabs.systems', '5456454555', null, null, '3067696', '14.4208', '50.088', '37.187.143.63', '5', null, null, null, '1', '1', '0', '0', '0', null, '0', null, null, '52a', null, null, null, null, null, null, null, null, '2019-05-03 10:22:17', '2019-05-10 12:33:59', null);
INSERT INTO `posts` VALUES ('20', 'CZ', '0', '259', '4', 'Testttt finalle', '<p>dsffffffffffffffffffffffffffffffffffffsd dddddddddddddddddddddddddddddd dfdddddddddddddd<br></p>', null, '1120.00', null, 'Chales Two', 'accountant@xlabs.systems', '5565465454', null, null, '3067696', '14.4208', '50.088', '37.187.143.63', '12', null, null, null, '1', '1', '0', '0', '0', null, '0', null, null, '52a', null, null, null, null, null, null, null, null, '2019-05-03 10:30:37', '2019-05-14 05:44:14', null);
INSERT INTO `posts` VALUES ('21', 'CZ', '0', '259', '4', 'KLJLJ ksakjd l jkj kjlkj', '<p>kjlkj kjaskdjas dsl j kljjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj lklkkkkkkkkkkkkkkkkk<br></p>', null, '1222.00', null, 'Charles de 3', 'accountant@xlabs.systems', '4654654564', null, null, '3067696', '14.4208', '50.088', '37.187.143.63', '12', null, null, null, '1', '1', '0', '0', '0', null, '0', null, null, '52a', null, null, null, null, null, null, null, null, '2019-05-03 10:38:00', '2019-05-10 14:06:41', null);
INSERT INTO `posts` VALUES ('22', 'CZ', '4', '259', '3', 'sdfdsdffsdf', '<p>sadsfffffffffffffffffffffffff khkjh ksjdhfksjd fkjshf ss djhf ffffffffffffffffffffffffffff<br></p>', null, '333.00', null, 'ALpha De gol3', 'accountant@xlabs.systems', '544654654654', null, null, '3067696', '14.4208', '50.088', '37.187.143.63', '7', null, null, null, '1', '1', '0', '0', '0', null, '0', null, null, '52a', null, null, null, null, null, null, null, null, '2019-05-03 10:57:53', '2019-05-10 00:46:30', null);
INSERT INTO `posts` VALUES ('23', 'CZ', '4', '259', '3', 'Test AKhilusn', '<p>fdsdfsf Jhdsf KJSJ  o you have something to sell, to rent, any service to offer or a job offer? Post it at Tuty Prodej.cz, its free, for local business and very easy to use<br></p>', null, '22.00', null, 'ALpha De Gol3', 'accountant@xlabs.systems', '544654654654', null, null, '3067696', '14.4208', '50.088', '37.187.143.63', '92', null, null, null, '1', '1', '0', '0', '0', null, '1', null, null, '52a', null, null, null, null, null, null, null, null, '2019-05-03 23:05:08', '2019-05-16 23:26:58', null);
INSERT INTO `posts` VALUES ('28', 'CZ', '4', '259', '3', 'est title 33444 ff', '<p>asdfasdf</p>', null, '333.00', null, 'ALpha De Gol3', 'accountant@xlabs.systems', '544654654654', null, null, '3067696', '14.4208', '50.088', '::1', '0', null, null, null, '1', '1', '0', '0', '0', null, '0', null, null, '52a', null, null, null, null, null, null, null, null, '2019-05-17 00:54:52', '2019-05-17 03:31:07', null);
INSERT INTO `posts` VALUES ('29', 'CZ', '4', '259', '3', 'asdfasdfasdfasdf', '<p>qewrwqerweqr</p>', null, '333.00', null, 'ALpha De Gol3', 'accountant@xlabs.systems', '544654654654', null, null, '3067696', '14.4208', '50.088', '::1', '0', null, null, '30e2e7a7f801712deefd52906510b723', '1', '1', '0', '0', '0', null, '0', null, null, '52a', null, null, null, null, null, null, null, null, '2019-05-17 16:40:49', '2019-05-17 16:40:49', null);
INSERT INTO `posts` VALUES ('30', 'CZ', '4', '259', '3', 'est title 33444 ff', '<p>asdfasdf</p>', null, '333.00', null, 'ALpha De Gol3', 'accountant@xlabs.systems', '544654654654', null, null, '3067696', '14.4208', '50.088', '::1', '0', null, null, null, '1', '1', '0', '0', '0', null, '0', null, null, '52a', null, null, null, null, null, null, null, null, '2019-05-17 17:31:12', '2019-05-17 17:31:12', null);
INSERT INTO `posts` VALUES ('31', 'CZ', '4', '259', '3', 'est title 33444 ff', '<p>asdfasdf</p>', null, '333.00', null, 'ALpha De Gol3', 'accountant@xlabs.systems', '544654654654', null, null, '3067696', '14.4208', '50.088', '::1', '0', null, null, null, '1', '1', '0', '0', '0', null, '0', null, null, '52a', null, null, null, null, null, null, null, null, '2019-05-17 17:40:32', '2019-05-17 17:40:32', null);
INSERT INTO `posts` VALUES ('32', 'CZ', '4', '259', '3', 'est title 33444 ff', '<p>asdfasdf</p>', null, '333.00', null, 'ALpha De Gol3', 'accountant@xlabs.systems', '544654654654', null, null, '3067696', '14.4208', '50.088', '::1', '0', null, null, null, '1', '1', '0', '0', '0', null, '0', null, null, '52a', null, null, null, null, null, null, null, null, '2019-05-17 17:43:34', '2019-05-17 17:43:34', null);
INSERT INTO `posts` VALUES ('33', 'CZ', '4', '259', '3', 'est title 33444 ff', '<p>asdfasdf</p>', null, '333.00', null, 'ALpha De Gol3', 'accountant@xlabs.systems', '544654654654', null, null, '3067696', '14.4208', '50.088', '::1', '0', null, null, null, '1', '1', '0', '0', '0', null, '0', null, null, '52a', null, null, null, null, null, null, null, null, '2019-05-17 17:43:44', '2019-05-17 17:43:44', null);
INSERT INTO `posts` VALUES ('34', 'CZ', '4', '259', '3', 'est title 33444 ff', '<p>asdfasdf</p>', null, '333.00', null, 'ALpha De Gol3', 'accountant@xlabs.systems', '544654654654', null, null, '3067696', '14.4208', '50.088', '::1', '1', null, null, null, '1', '1', '0', '0', '0', null, '0', null, null, '52a', null, null, null, null, null, null, null, null, '2019-05-17 17:47:40', '2019-05-17 21:35:52', null);
INSERT INTO `posts` VALUES ('35', 'CZ', '4', '257', '3', 'nddest title 33444 ff', '<ul><li>Use a brief title and description of the item</li><li>Make sure you post in the correct category</li><li>Add nice photos to your ad</li><li>Put a reasonable price</li><li>Check the item before publish</li></ul>', null, '333.00', null, 'ALpha De Gol3', 'accountant@xlabs.systems', '544654654654', null, null, '3068160', '13.3776', '49.7475', '::1', '4', null, null, '73ab99d8203a0f8f664848e88d08de54', '1', '1', '0', '0', '0', null, '0', null, null, '52a', null, null, null, null, null, null, null, null, '2019-05-18 02:43:59', '2019-05-21 08:05:55', null);

-- ----------------------------
-- Table structure for post_types
-- ----------------------------
DROP TABLE IF EXISTS `post_types`;
CREATE TABLE `post_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `translation_lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `translation_of` int(10) unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `translation_lang` (`translation_lang`),
  KEY `translation_of` (`translation_of`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of post_types
-- ----------------------------
INSERT INTO `post_types` VALUES ('1', 'en', '3', 'Pronájem', null, null, null, '1');
INSERT INTO `post_types` VALUES ('2', 'en', '4', 'Prodej', null, null, null, '1');
INSERT INTO `post_types` VALUES ('3', 'cs', '3', 'Pronájem', null, null, null, '1');
INSERT INTO `post_types` VALUES ('4', 'cs', '4', 'Prodej', null, null, null, '1');

-- ----------------------------
-- Table structure for post_values
-- ----------------------------
DROP TABLE IF EXISTS `post_values`;
CREATE TABLE `post_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned DEFAULT NULL,
  `field_id` int(10) unsigned DEFAULT NULL,
  `option_id` int(10) unsigned DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `field_id` (`field_id`),
  KEY `option_id` (`option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=382 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of post_values
-- ----------------------------
INSERT INTO `post_values` VALUES ('68', '15', '115', null, '3');
INSERT INTO `post_values` VALUES ('69', '15', '81', null, '351');
INSERT INTO `post_values` VALUES ('70', '15', '83', null, '354');
INSERT INTO `post_values` VALUES ('71', '15', '85', null, '365');
INSERT INTO `post_values` VALUES ('72', '15', '97', '386', '386');
INSERT INTO `post_values` VALUES ('73', '15', '101', null, '391');
INSERT INTO `post_values` VALUES ('74', '15', '103', null, '396');
INSERT INTO `post_values` VALUES ('75', '15', '107', '399', '399');
INSERT INTO `post_values` VALUES ('76', '15', '107', '402', '402');
INSERT INTO `post_values` VALUES ('77', '15', '107', '403', '403');
INSERT INTO `post_values` VALUES ('78', '15', '109', '405', '405');
INSERT INTO `post_values` VALUES ('79', '15', '55', null, '56');
INSERT INTO `post_values` VALUES ('80', '15', '32', null, '325');
INSERT INTO `post_values` VALUES ('81', '15', '71', null, 'estate_area');
INSERT INTO `post_values` VALUES ('82', '15', '75', null, '342');
INSERT INTO `post_values` VALUES ('83', '15', '73', null, '341');
INSERT INTO `post_values` VALUES ('84', '15', '77', null, '347');
INSERT INTO `post_values` VALUES ('85', '15', '91', '370', '370');
INSERT INTO `post_values` VALUES ('86', '15', '93', '380', '380');
INSERT INTO `post_values` VALUES ('87', '15', '113', '411', '411');
INSERT INTO `post_values` VALUES ('88', '15', '89', null, '367');
INSERT INTO `post_values` VALUES ('89', '18', '115', null, '2');
INSERT INTO `post_values` VALUES ('90', '18', '81', null, '351');
INSERT INTO `post_values` VALUES ('91', '18', '83', null, '360');
INSERT INTO `post_values` VALUES ('92', '18', '85', null, '365');
INSERT INTO `post_values` VALUES ('93', '18', '87', null, '4');
INSERT INTO `post_values` VALUES ('94', '18', '95', '383', '383');
INSERT INTO `post_values` VALUES ('95', '18', '95', '384', '384');
INSERT INTO `post_values` VALUES ('96', '18', '97', '386', '386');
INSERT INTO `post_values` VALUES ('97', '18', '99', '388', '388');
INSERT INTO `post_values` VALUES ('98', '18', '101', null, '389');
INSERT INTO `post_values` VALUES ('99', '18', '103', null, '396');
INSERT INTO `post_values` VALUES ('100', '18', '107', '399', '399');
INSERT INTO `post_values` VALUES ('101', '18', '107', '401', '401');
INSERT INTO `post_values` VALUES ('102', '18', '109', '408', '408');
INSERT INTO `post_values` VALUES ('103', '18', '109', '407', '407');
INSERT INTO `post_values` VALUES ('104', '18', '55', null, '4');
INSERT INTO `post_values` VALUES ('105', '18', '32', null, '325');
INSERT INTO `post_values` VALUES ('106', '18', '71', null, '34');
INSERT INTO `post_values` VALUES ('107', '18', '75', null, '343');
INSERT INTO `post_values` VALUES ('108', '18', '73', null, '341');
INSERT INTO `post_values` VALUES ('109', '18', '77', null, '348');
INSERT INTO `post_values` VALUES ('110', '18', '91', '371', '371');
INSERT INTO `post_values` VALUES ('111', '18', '93', '380', '380');
INSERT INTO `post_values` VALUES ('112', '18', '93', '376', '376');
INSERT INTO `post_values` VALUES ('113', '18', '113', '416', '416');
INSERT INTO `post_values` VALUES ('114', '18', '113', '411', '411');
INSERT INTO `post_values` VALUES ('115', '18', '89', null, '366');
INSERT INTO `post_values` VALUES ('116', '19', '115', null, '3');
INSERT INTO `post_values` VALUES ('117', '19', '81', null, '351');
INSERT INTO `post_values` VALUES ('118', '19', '83', null, '360');
INSERT INTO `post_values` VALUES ('119', '19', '85', null, '365');
INSERT INTO `post_values` VALUES ('120', '19', '87', null, '15');
INSERT INTO `post_values` VALUES ('121', '19', '95', '383', '383');
INSERT INTO `post_values` VALUES ('122', '19', '97', '386', '386');
INSERT INTO `post_values` VALUES ('123', '19', '99', '387', '387');
INSERT INTO `post_values` VALUES ('124', '19', '101', null, '391');
INSERT INTO `post_values` VALUES ('125', '19', '103', null, '396');
INSERT INTO `post_values` VALUES ('126', '19', '107', '399', '399');
INSERT INTO `post_values` VALUES ('127', '19', '107', '402', '402');
INSERT INTO `post_values` VALUES ('128', '19', '109', '407', '407');
INSERT INTO `post_values` VALUES ('129', '19', '55', null, '4');
INSERT INTO `post_values` VALUES ('130', '19', '32', null, '325');
INSERT INTO `post_values` VALUES ('131', '19', '71', null, '44');
INSERT INTO `post_values` VALUES ('132', '19', '75', null, '343');
INSERT INTO `post_values` VALUES ('133', '19', '73', null, '341');
INSERT INTO `post_values` VALUES ('134', '19', '77', null, '345');
INSERT INTO `post_values` VALUES ('135', '19', '91', '371', '371');
INSERT INTO `post_values` VALUES ('136', '19', '93', '380', '380');
INSERT INTO `post_values` VALUES ('137', '19', '93', '376', '376');
INSERT INTO `post_values` VALUES ('138', '19', '113', '416', '416');
INSERT INTO `post_values` VALUES ('139', '19', '113', '411', '411');
INSERT INTO `post_values` VALUES ('140', '19', '89', null, '366');
INSERT INTO `post_values` VALUES ('141', '20', '115', null, '33');
INSERT INTO `post_values` VALUES ('142', '20', '81', null, '351');
INSERT INTO `post_values` VALUES ('143', '20', '83', null, '360');
INSERT INTO `post_values` VALUES ('144', '20', '85', null, '365');
INSERT INTO `post_values` VALUES ('145', '20', '87', null, '3');
INSERT INTO `post_values` VALUES ('146', '20', '95', '383', '383');
INSERT INTO `post_values` VALUES ('147', '20', '95', '381', '381');
INSERT INTO `post_values` VALUES ('148', '20', '97', '386', '386');
INSERT INTO `post_values` VALUES ('149', '20', '99', '388', '388');
INSERT INTO `post_values` VALUES ('150', '20', '101', null, '390');
INSERT INTO `post_values` VALUES ('151', '20', '103', null, '396');
INSERT INTO `post_values` VALUES ('152', '20', '107', '399', '399');
INSERT INTO `post_values` VALUES ('153', '20', '107', '401', '401');
INSERT INTO `post_values` VALUES ('154', '20', '109', '408', '408');
INSERT INTO `post_values` VALUES ('155', '20', '109', '406', '406');
INSERT INTO `post_values` VALUES ('156', '20', '55', null, '3');
INSERT INTO `post_values` VALUES ('157', '20', '32', null, '325');
INSERT INTO `post_values` VALUES ('158', '20', '71', null, '333');
INSERT INTO `post_values` VALUES ('159', '20', '75', null, '343');
INSERT INTO `post_values` VALUES ('160', '20', '73', null, '340');
INSERT INTO `post_values` VALUES ('161', '20', '77', null, '345');
INSERT INTO `post_values` VALUES ('162', '20', '91', '369', '369');
INSERT INTO `post_values` VALUES ('163', '20', '91', '371', '371');
INSERT INTO `post_values` VALUES ('164', '20', '93', '376', '376');
INSERT INTO `post_values` VALUES ('165', '20', '113', '411', '411');
INSERT INTO `post_values` VALUES ('166', '20', '89', null, '366');
INSERT INTO `post_values` VALUES ('167', '21', '115', null, '3');
INSERT INTO `post_values` VALUES ('168', '21', '81', null, '352');
INSERT INTO `post_values` VALUES ('169', '21', '83', null, '360');
INSERT INTO `post_values` VALUES ('170', '21', '85', null, '365');
INSERT INTO `post_values` VALUES ('171', '21', '87', null, '44');
INSERT INTO `post_values` VALUES ('172', '21', '95', '383', '383');
INSERT INTO `post_values` VALUES ('173', '21', '97', '385', '385');
INSERT INTO `post_values` VALUES ('174', '21', '99', '387', '387');
INSERT INTO `post_values` VALUES ('175', '21', '101', null, '389');
INSERT INTO `post_values` VALUES ('176', '21', '103', null, '396');
INSERT INTO `post_values` VALUES ('177', '21', '107', '399', '399');
INSERT INTO `post_values` VALUES ('178', '21', '107', '401', '401');
INSERT INTO `post_values` VALUES ('179', '21', '109', '407', '407');
INSERT INTO `post_values` VALUES ('180', '21', '55', null, '33');
INSERT INTO `post_values` VALUES ('181', '21', '32', null, '332');
INSERT INTO `post_values` VALUES ('182', '21', '71', null, '33');
INSERT INTO `post_values` VALUES ('183', '21', '75', null, '343');
INSERT INTO `post_values` VALUES ('184', '21', '73', null, '341');
INSERT INTO `post_values` VALUES ('185', '21', '77', null, '346');
INSERT INTO `post_values` VALUES ('186', '21', '91', '370', '370');
INSERT INTO `post_values` VALUES ('187', '21', '91', '371', '371');
INSERT INTO `post_values` VALUES ('188', '21', '93', '380', '380');
INSERT INTO `post_values` VALUES ('189', '21', '93', '378', '378');
INSERT INTO `post_values` VALUES ('190', '21', '113', '409', '409');
INSERT INTO `post_values` VALUES ('191', '21', '113', '410', '410');
INSERT INTO `post_values` VALUES ('192', '21', '89', null, '368');
INSERT INTO `post_values` VALUES ('193', '22', '115', null, '33');
INSERT INTO `post_values` VALUES ('194', '22', '81', null, '352');
INSERT INTO `post_values` VALUES ('195', '22', '83', null, '360');
INSERT INTO `post_values` VALUES ('196', '22', '85', null, '365');
INSERT INTO `post_values` VALUES ('197', '22', '87', null, '33');
INSERT INTO `post_values` VALUES ('198', '22', '95', '383', '383');
INSERT INTO `post_values` VALUES ('199', '22', '95', '384', '384');
INSERT INTO `post_values` VALUES ('200', '22', '97', '385', '385');
INSERT INTO `post_values` VALUES ('201', '22', '99', '387', '387');
INSERT INTO `post_values` VALUES ('202', '22', '99', '388', '388');
INSERT INTO `post_values` VALUES ('203', '22', '101', null, '390');
INSERT INTO `post_values` VALUES ('204', '22', '103', null, '396');
INSERT INTO `post_values` VALUES ('205', '22', '107', '402', '402');
INSERT INTO `post_values` VALUES ('206', '22', '107', '403', '403');
INSERT INTO `post_values` VALUES ('207', '22', '109', '408', '408');
INSERT INTO `post_values` VALUES ('208', '22', '55', null, '444');
INSERT INTO `post_values` VALUES ('209', '22', '32', null, '325');
INSERT INTO `post_values` VALUES ('210', '22', '71', null, '222');
INSERT INTO `post_values` VALUES ('211', '22', '75', null, '343');
INSERT INTO `post_values` VALUES ('212', '22', '73', null, '341');
INSERT INTO `post_values` VALUES ('213', '22', '77', null, '346');
INSERT INTO `post_values` VALUES ('214', '22', '91', '371', '371');
INSERT INTO `post_values` VALUES ('215', '22', '93', '380', '380');
INSERT INTO `post_values` VALUES ('216', '22', '113', '416', '416');
INSERT INTO `post_values` VALUES ('217', '22', '89', null, '366');
INSERT INTO `post_values` VALUES ('218', '23', '115', null, '22');
INSERT INTO `post_values` VALUES ('219', '23', '81', null, '352');
INSERT INTO `post_values` VALUES ('220', '23', '83', null, '355');
INSERT INTO `post_values` VALUES ('221', '23', '85', null, '365');
INSERT INTO `post_values` VALUES ('222', '23', '87', null, '22');
INSERT INTO `post_values` VALUES ('223', '23', '95', '381', '381');
INSERT INTO `post_values` VALUES ('224', '23', '95', '382', '382');
INSERT INTO `post_values` VALUES ('225', '23', '97', '385', '385');
INSERT INTO `post_values` VALUES ('226', '23', '99', '387', '387');
INSERT INTO `post_values` VALUES ('227', '23', '101', null, '392');
INSERT INTO `post_values` VALUES ('228', '23', '103', null, '396');
INSERT INTO `post_values` VALUES ('229', '23', '107', '403', '403');
INSERT INTO `post_values` VALUES ('230', '23', '107', '400', '400');
INSERT INTO `post_values` VALUES ('231', '23', '109', '408', '408');
INSERT INTO `post_values` VALUES ('232', '23', '109', '405', '405');
INSERT INTO `post_values` VALUES ('233', '23', '55', null, '22');
INSERT INTO `post_values` VALUES ('234', '23', '32', null, '330');
INSERT INTO `post_values` VALUES ('235', '23', '71', null, '33');
INSERT INTO `post_values` VALUES ('236', '23', '75', null, '343');
INSERT INTO `post_values` VALUES ('237', '23', '73', null, '341');
INSERT INTO `post_values` VALUES ('238', '23', '77', null, '347');
INSERT INTO `post_values` VALUES ('239', '23', '91', '371', '371');
INSERT INTO `post_values` VALUES ('240', '23', '93', '376', '376');
INSERT INTO `post_values` VALUES ('241', '23', '93', '375', '375');
INSERT INTO `post_values` VALUES ('242', '23', '113', '415', '415');
INSERT INTO `post_values` VALUES ('243', '23', '113', '414', '414');
INSERT INTO `post_values` VALUES ('244', '23', '89', null, '367');
INSERT INTO `post_values` VALUES ('245', '23', '53', '334', null);
INSERT INTO `post_values` VALUES ('246', '22', '53', '334', null);
INSERT INTO `post_values` VALUES ('247', '24', '53', null, '334');
INSERT INTO `post_values` VALUES ('248', '24', '115', null, '6565');
INSERT INTO `post_values` VALUES ('249', '24', '81', null, '352');
INSERT INTO `post_values` VALUES ('250', '24', '83', null, '361');
INSERT INTO `post_values` VALUES ('251', '24', '85', null, '365');
INSERT INTO `post_values` VALUES ('252', '24', '87', null, '3232');
INSERT INTO `post_values` VALUES ('253', '24', '95', '381', '381');
INSERT INTO `post_values` VALUES ('254', '24', '99', '387', '387');
INSERT INTO `post_values` VALUES ('255', '24', '101', null, '390');
INSERT INTO `post_values` VALUES ('256', '24', '103', null, '397');
INSERT INTO `post_values` VALUES ('257', '24', '107', '399', '399');
INSERT INTO `post_values` VALUES ('258', '24', '107', '398', '398');
INSERT INTO `post_values` VALUES ('259', '24', '109', '407', '407');
INSERT INTO `post_values` VALUES ('260', '24', '55', null, '12');
INSERT INTO `post_values` VALUES ('261', '24', '32', null, '329');
INSERT INTO `post_values` VALUES ('262', '24', '71', null, '2121');
INSERT INTO `post_values` VALUES ('263', '24', '75', null, '342');
INSERT INTO `post_values` VALUES ('264', '24', '73', null, '341');
INSERT INTO `post_values` VALUES ('265', '24', '91', '370', '370');
INSERT INTO `post_values` VALUES ('266', '24', '93', '376', '376');
INSERT INTO `post_values` VALUES ('267', '24', '93', '375', '375');
INSERT INTO `post_values` VALUES ('268', '24', '113', '416', '416');
INSERT INTO `post_values` VALUES ('269', '24', '113', '411', '411');
INSERT INTO `post_values` VALUES ('270', '24', '89', null, '366');
INSERT INTO `post_values` VALUES ('271', '25', '53', null, '334');
INSERT INTO `post_values` VALUES ('272', '25', '115', null, '6565');
INSERT INTO `post_values` VALUES ('273', '25', '81', null, '352');
INSERT INTO `post_values` VALUES ('274', '25', '83', null, '361');
INSERT INTO `post_values` VALUES ('275', '25', '85', null, '365');
INSERT INTO `post_values` VALUES ('276', '25', '87', null, '3232');
INSERT INTO `post_values` VALUES ('277', '25', '95', '381', '381');
INSERT INTO `post_values` VALUES ('278', '25', '99', '387', '387');
INSERT INTO `post_values` VALUES ('279', '25', '101', null, '390');
INSERT INTO `post_values` VALUES ('280', '25', '103', null, '397');
INSERT INTO `post_values` VALUES ('281', '25', '107', '399', '399');
INSERT INTO `post_values` VALUES ('282', '25', '107', '398', '398');
INSERT INTO `post_values` VALUES ('283', '25', '109', '407', '407');
INSERT INTO `post_values` VALUES ('284', '25', '55', null, '12');
INSERT INTO `post_values` VALUES ('285', '25', '32', null, '329');
INSERT INTO `post_values` VALUES ('286', '25', '71', null, '2121');
INSERT INTO `post_values` VALUES ('287', '25', '75', null, '342');
INSERT INTO `post_values` VALUES ('288', '25', '73', null, '341');
INSERT INTO `post_values` VALUES ('289', '25', '91', '370', '370');
INSERT INTO `post_values` VALUES ('290', '25', '93', '376', '376');
INSERT INTO `post_values` VALUES ('291', '25', '93', '375', '375');
INSERT INTO `post_values` VALUES ('292', '25', '113', '416', '416');
INSERT INTO `post_values` VALUES ('293', '25', '113', '411', '411');
INSERT INTO `post_values` VALUES ('294', '25', '89', null, '366');
INSERT INTO `post_values` VALUES ('295', '26', '53', null, '334');
INSERT INTO `post_values` VALUES ('296', '26', '115', null, '6565');
INSERT INTO `post_values` VALUES ('297', '26', '81', null, '352');
INSERT INTO `post_values` VALUES ('298', '26', '83', null, '355');
INSERT INTO `post_values` VALUES ('299', '26', '85', null, '365');
INSERT INTO `post_values` VALUES ('300', '26', '87', null, '6565');
INSERT INTO `post_values` VALUES ('301', '26', '95', '383', '383');
INSERT INTO `post_values` VALUES ('302', '26', '95', '382', '382');
INSERT INTO `post_values` VALUES ('303', '26', '97', '386', '386');
INSERT INTO `post_values` VALUES ('304', '26', '99', '387', '387');
INSERT INTO `post_values` VALUES ('305', '26', '101', null, '390');
INSERT INTO `post_values` VALUES ('306', '26', '103', null, '397');
INSERT INTO `post_values` VALUES ('307', '26', '107', '399', '399');
INSERT INTO `post_values` VALUES ('308', '26', '107', '401', '401');
INSERT INTO `post_values` VALUES ('309', '26', '109', '407', '407');
INSERT INTO `post_values` VALUES ('310', '26', '55', null, '12');
INSERT INTO `post_values` VALUES ('311', '26', '32', null, '325');
INSERT INTO `post_values` VALUES ('312', '26', '71', null, '323');
INSERT INTO `post_values` VALUES ('313', '26', '75', null, '343');
INSERT INTO `post_values` VALUES ('314', '26', '73', null, '341');
INSERT INTO `post_values` VALUES ('315', '26', '77', null, '348');
INSERT INTO `post_values` VALUES ('316', '26', '91', '369', '369');
INSERT INTO `post_values` VALUES ('317', '26', '93', '376', '376');
INSERT INTO `post_values` VALUES ('318', '26', '93', '379', '379');
INSERT INTO `post_values` VALUES ('319', '26', '113', '416', '416');
INSERT INTO `post_values` VALUES ('320', '26', '113', '411', '411');
INSERT INTO `post_values` VALUES ('321', '26', '89', null, '366');
INSERT INTO `post_values` VALUES ('322', '27', '53', null, '334');
INSERT INTO `post_values` VALUES ('323', '27', '115', null, '6565');
INSERT INTO `post_values` VALUES ('324', '27', '81', null, '351');
INSERT INTO `post_values` VALUES ('325', '27', '83', null, '360');
INSERT INTO `post_values` VALUES ('326', '27', '85', null, '365');
INSERT INTO `post_values` VALUES ('327', '27', '101', null, '390');
INSERT INTO `post_values` VALUES ('328', '27', '103', null, '396');
INSERT INTO `post_values` VALUES ('329', '27', '32', null, '325');
INSERT INTO `post_values` VALUES ('330', '27', '71', null, 'estate_area');
INSERT INTO `post_values` VALUES ('331', '27', '73', null, '341');
INSERT INTO `post_values` VALUES ('332', '27', '89', null, '366');
INSERT INTO `post_values` VALUES ('333', '28', '53', null, '334');
INSERT INTO `post_values` VALUES ('334', '28', '115', null, '6565');
INSERT INTO `post_values` VALUES ('335', '28', '81', null, '351');
INSERT INTO `post_values` VALUES ('336', '28', '83', null, '360');
INSERT INTO `post_values` VALUES ('337', '28', '85', null, '365');
INSERT INTO `post_values` VALUES ('338', '28', '87', null, '6565');
INSERT INTO `post_values` VALUES ('339', '28', '101', null, '390');
INSERT INTO `post_values` VALUES ('340', '28', '103', null, '396');
INSERT INTO `post_values` VALUES ('341', '28', '32', null, '325');
INSERT INTO `post_values` VALUES ('342', '28', '71', null, 'estate_area');
INSERT INTO `post_values` VALUES ('343', '28', '73', null, '341');
INSERT INTO `post_values` VALUES ('344', '28', '89', null, '368');
INSERT INTO `post_values` VALUES ('345', '29', '53', null, '334');
INSERT INTO `post_values` VALUES ('346', '29', '115', null, '6565');
INSERT INTO `post_values` VALUES ('347', '29', '81', null, '351');
INSERT INTO `post_values` VALUES ('348', '29', '83', null, '360');
INSERT INTO `post_values` VALUES ('349', '29', '85', null, '365');
INSERT INTO `post_values` VALUES ('350', '29', '87', null, '6565');
INSERT INTO `post_values` VALUES ('351', '29', '101', null, '390');
INSERT INTO `post_values` VALUES ('352', '29', '103', null, '396');
INSERT INTO `post_values` VALUES ('353', '29', '32', null, '325');
INSERT INTO `post_values` VALUES ('354', '29', '71', null, 'estate_area');
INSERT INTO `post_values` VALUES ('355', '29', '73', null, '341');
INSERT INTO `post_values` VALUES ('356', '29', '89', null, '366');
INSERT INTO `post_values` VALUES ('357', '35', '53', null, '333');
INSERT INTO `post_values` VALUES ('358', '35', '115', null, '6565');
INSERT INTO `post_values` VALUES ('359', '35', '81', null, '351');
INSERT INTO `post_values` VALUES ('360', '35', '83', null, '355');
INSERT INTO `post_values` VALUES ('361', '35', '85', null, '364');
INSERT INTO `post_values` VALUES ('362', '35', '87', null, '6565');
INSERT INTO `post_values` VALUES ('363', '35', '95', '381', '381');
INSERT INTO `post_values` VALUES ('364', '35', '97', '385', '385');
INSERT INTO `post_values` VALUES ('365', '35', '101', null, '389');
INSERT INTO `post_values` VALUES ('366', '35', '103', null, '396');
INSERT INTO `post_values` VALUES ('367', '35', '107', '401', '401');
INSERT INTO `post_values` VALUES ('368', '35', '107', '403', '403');
INSERT INTO `post_values` VALUES ('369', '35', '109', '406', '406');
INSERT INTO `post_values` VALUES ('370', '35', '109', '404', '404');
INSERT INTO `post_values` VALUES ('371', '35', '55', null, '12');
INSERT INTO `post_values` VALUES ('372', '35', '32', null, '325');
INSERT INTO `post_values` VALUES ('373', '35', '71', null, '32');
INSERT INTO `post_values` VALUES ('374', '35', '75', null, '343');
INSERT INTO `post_values` VALUES ('375', '35', '73', null, '341');
INSERT INTO `post_values` VALUES ('376', '35', '77', null, '346');
INSERT INTO `post_values` VALUES ('377', '35', '91', '369', '369');
INSERT INTO `post_values` VALUES ('378', '35', '93', '380', '380');
INSERT INTO `post_values` VALUES ('379', '35', '93', '375', '375');
INSERT INTO `post_values` VALUES ('380', '35', '113', '416', '416');
INSERT INTO `post_values` VALUES ('381', '35', '89', null, '366');

-- ----------------------------
-- Table structure for report_types
-- ----------------------------
DROP TABLE IF EXISTS `report_types`;
CREATE TABLE `report_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `translation_lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `translation_of` int(10) unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `translation_lang` (`translation_lang`),
  KEY `translation_of` (`translation_of`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of report_types
-- ----------------------------
INSERT INTO `report_types` VALUES ('1', 'en', '6', 'Fraud');
INSERT INTO `report_types` VALUES ('2', 'en', '7', 'Duplicate');
INSERT INTO `report_types` VALUES ('3', 'en', '8', 'Spam');
INSERT INTO `report_types` VALUES ('4', 'en', '9', 'Wrong category');
INSERT INTO `report_types` VALUES ('5', 'en', '10', 'Other');
INSERT INTO `report_types` VALUES ('6', 'cs', '6', 'Fraud');
INSERT INTO `report_types` VALUES ('7', 'cs', '7', 'Duplicate');
INSERT INTO `report_types` VALUES ('8', 'cs', '8', 'Spam');
INSERT INTO `report_types` VALUES ('9', 'cs', '9', 'Wrong category');
INSERT INTO `report_types` VALUES ('10', 'cs', '10', 'Other');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'super-admin', 'web', '2018-12-21 10:07:11', '2018-12-21 10:07:11');

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `role_has_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES ('1', '1');
INSERT INTO `role_has_permissions` VALUES ('2', '1');
INSERT INTO `role_has_permissions` VALUES ('3', '1');
INSERT INTO `role_has_permissions` VALUES ('4', '1');
INSERT INTO `role_has_permissions` VALUES ('5', '1');
INSERT INTO `role_has_permissions` VALUES ('6', '1');
INSERT INTO `role_has_permissions` VALUES ('7', '1');
INSERT INTO `role_has_permissions` VALUES ('8', '1');
INSERT INTO `role_has_permissions` VALUES ('9', '1');

-- ----------------------------
-- Table structure for saved_posts
-- ----------------------------
DROP TABLE IF EXISTS `saved_posts`;
CREATE TABLE `saved_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `post_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of saved_posts
-- ----------------------------
INSERT INTO `saved_posts` VALUES ('7', '4', '18', '2019-05-11 21:02:49', '2019-05-11 21:02:49');

-- ----------------------------
-- Table structure for saved_search
-- ----------------------------
DROP TABLE IF EXISTS `saved_search`;
CREATE TABLE `saved_search` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `keyword` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'To show',
  `query` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `count` int(10) unsigned DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `country_code` (`country_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of saved_search
-- ----------------------------
INSERT INTO `saved_search` VALUES ('1', 'CZ', '4', 'Test', 'q=Test', '4', '2019-05-11 21:05:59', '2019-05-11 21:05:59');

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `payload` text COLLATE utf8_unicode_ci,
  `last_activity` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(250) COLLATE utf8_unicode_ci DEFAULT '',
  `user_agent` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sessions
-- ----------------------------

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `field` text COLLATE utf8_unicode_ci,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `key` (`key`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES ('1', 'app', 'Application', '{\"purchase_code\":\"b6a4f18d-f29e-4ff2-922f-6f61739a4426\",\"app_name\":\"Tuty Prodej.cz\",\"slogan\":\"100% Fast Sale\",\"logo\":\"app\\/logo\\/logo-5ccbbae9e1ef7.png\",\"favicon\":null,\"email\":\"junell@xlabs.systems\",\"phone_number\":\"+4420574156454\",\"auto_detect_language\":\"2\",\"default_date_format\":\"%d %B %Y\",\"default_datetime_format\":\"%d %B %Y %H:%M\",\"default_timezone\":\"Europe\\/Prague\",\"date_force_utf8\":\"0\",\"show_countries_charts\":\"1\",\"latest_entries_limit\":\"5\"}', 'Application Setup', null, '0', '2', '3', '1', '1', null, null);
INSERT INTO `settings` VALUES ('2', 'style', 'Style', '{\"app_skin\":\"skin-blue\",\"body_background_color\":null,\"body_text_color\":null,\"body_background_image\":null,\"body_background_image_fixed\":\"0\",\"page_width\":null,\"title_color\":null,\"progress_background_color\":null,\"link_color\":null,\"link_color_hover\":null,\"header_sticky\":\"0\",\"header_height\":null,\"header_background_color\":null,\"header_bottom_border_width\":\"1px\",\"header_bottom_border_color\":\"#e8e8e8\",\"header_link_color\":null,\"header_link_color_hover\":null,\"footer_background_color\":null,\"footer_text_color\":null,\"footer_title_color\":null,\"footer_link_color\":null,\"footer_link_color_hover\":null,\"payment_icon_top_border_width\":null,\"payment_icon_top_border_color\":null,\"payment_icon_bottom_border_width\":null,\"payment_icon_bottom_border_color\":null,\"btn_post_bg_top_color\":null,\"btn_post_bg_bottom_color\":null,\"btn_post_border_color\":null,\"btn_post_text_color\":null,\"btn_post_bg_top_color_hover\":null,\"btn_post_bg_bottom_color_hover\":null,\"btn_post_border_color_hover\":null,\"btn_post_text_color_hover\":null,\"custom_css\":\"body {\\r\\n    font-size: 16px;\\r\\n}\\r\\n.user-panel-sidebar ul li a {\\r\\n    font-size: 16px;\\r\\n}\\r\\n.price-td {\\r\\n    font-size: 20px;\\r\\n}\\r\\n.payable-amount{\\r\\nfont-size: 24px;\\r\\n}\",\"admin_skin\":\"skin-yellow\"}', 'Style Customization', null, '0', '4', '5', '1', '1', null, null);
INSERT INTO `settings` VALUES ('3', 'listing', 'Listing & Search', null, 'Listing & Search Options', null, '0', '6', '7', '1', '1', null, null);
INSERT INTO `settings` VALUES ('4', 'single', 'Ads Single Page', '{\"publication_form_type\":\"1\",\"picture_mandatory\":\"1\",\"pictures_limit\":\"5\",\"tags_limit\":\"15\",\"guests_can_post_ads\":\"1\",\"posts_review_activation\":\"0\",\"auto_registration\":\"2\",\"simditor_wysiwyg\":\"1\",\"ckeditor_wysiwyg\":\"0\",\"guests_can_contact_ads_authors\":\"0\",\"show_post_on_googlemap\":\"0\",\"activation_facebook_comments\":\"0\"}', 'Ads Single Page Options', null, '0', '8', '9', '1', '1', null, null);
INSERT INTO `settings` VALUES ('5', 'mail', 'Mail', '{\"driver\":\"mail\",\"host\":null,\"port\":null,\"username\":null,\"password\":null,\"encryption\":null,\"mailgun_domain\":null,\"mailgun_secret\":null,\"mandrill_secret\":null,\"ses_key\":null,\"ses_secret\":null,\"ses_region\":null,\"sparkpost_secret\":null,\"email_sender\":\"junell@xlabs.systems\",\"email_verification\":\"0\",\"confirmation\":\"1\",\"admin_notification\":\"1\",\"payment_notification\":\"1\"}', 'Mail Sending Configuration', null, '0', '10', '11', '1', '1', null, null);
INSERT INTO `settings` VALUES ('6', 'sms', 'SMS', '{\"driver\":\"twilio\",\"nexmo_key\":null,\"nexmo_secret\":null,\"nexmo_from\":null,\"twilio_account_sid\":\"545456545\",\"twilio_auth_token\":\"54546545\",\"twilio_from\":\"+45454564555\",\"phone_verification\":\"0\",\"message_activation\":\"0\"}', 'SMS Sending Configuration', null, '0', '12', '13', '1', '1', null, null);
INSERT INTO `settings` VALUES ('7', 'seo', 'SEO', null, 'SEO Tools', null, '0', '26', '27', '1', '1', null, null);
INSERT INTO `settings` VALUES ('8', 'upload', 'Upload', null, 'Upload Settings', null, '0', '14', '15', '1', '1', null, null);
INSERT INTO `settings` VALUES ('9', 'geo_location', 'Geo Location', '{\"geolocation_activation\":\"0\",\"default_country_code\":\"CZ\",\"country_flag_activation\":\"0\",\"local_currency_packages_activation\":\"0\"}', 'Geo Location Configuration', null, '0', '16', '17', '1', '1', null, null);
INSERT INTO `settings` VALUES ('10', 'security', 'Security', '{\"login_open_in_modal\":\"1\",\"login_max_attempts\":\"10\",\"login_decay_minutes\":\"2\",\"recaptcha_activation\":\"1\",\"recaptcha_site_key\":\"6LfDhKEUAAAAAHTrXboVEb60ngQ1m4thqz8o_POv\",\"recaptcha_secret_key\":\"6LfDhKEUAAAAAJQK3Hb6VvrkvaIjtcdaLrXaWlle\",\"recaptcha_version\":\"v2\",\"recaptcha_skip_ips\":null}', 'Security Options', null, '0', '18', '19', '1', '1', null, null);
INSERT INTO `settings` VALUES ('11', 'social_auth', 'Social Login', '{\"social_login_activation\":\"1\",\"facebook_client_id\":null,\"facebook_client_secret\":null,\"google_client_id\":null,\"google_client_secret\":null}', 'Social Network Login', null, '0', '20', '21', '1', '1', null, null);
INSERT INTO `settings` VALUES ('12', 'social_link', 'Social Network', '{\"facebook_page_url\":\"#\",\"twitter_url\":\"#\",\"google_plus_url\":null,\"linkedin_url\":null,\"pinterest_url\":null}', 'Social Network Profiles', null, '0', '22', '23', '1', '1', null, null);
INSERT INTO `settings` VALUES ('13', 'other', 'Others', '{\"cookie_consent_enabled\":\"1\",\"show_tips_messages\":\"1\",\"googlemaps_key\":null,\"timer_new_messages_checking\":\"60000\",\"simditor_wysiwyg\":\"1\",\"ckeditor_wysiwyg\":\"0\",\"ios_app_url\":null,\"android_app_url\":null,\"decimals_superscript\":\"1\",\"cookie_expiration\":\"86400\",\"cache_expiration\":\"1440\",\"minify_html_activation\":\"0\",\"js_code\":null}', 'Other Options', null, '0', '28', '29', '1', '1', null, null);
INSERT INTO `settings` VALUES ('14', 'cron', 'Cron', null, 'Cron Job', null, '0', '30', '31', '1', '1', null, null);
INSERT INTO `settings` VALUES ('15', 'footer', 'Footer', '{\"hide_links\":\"0\",\"hide_payment_plugins_logos\":\"0\",\"hide_powered_by\":\"0\",\"powered_by_info\":\"By XLABS Europe Ltd -  All Rights Reserved. <br\\/>Powered by Cloud4Hosting.eu <a href=\\\"https:\\/\\/www.cloud4hosting.eu\\\">Web Hosting<\\/a>\",\"tracking_code\":null}', 'Pages Footer', null, '0', '32', '33', '1', '1', null, null);
INSERT INTO `settings` VALUES ('16', 'optimization', 'Optimization', '[]', 'Optimization Tools', null, '0', '24', '25', '1', '1', null, null);

-- ----------------------------
-- Table structure for subadmin1
-- ----------------------------
DROP TABLE IF EXISTS `subadmin1`;
CREATE TABLE `subadmin1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `country_code` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `asciiname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `country_code` (`country_code`),
  KEY `name` (`name`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=740 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of subadmin1
-- ----------------------------
INSERT INTO `subadmin1` VALUES ('726', 'CZ.52', 'CZ', 'Praha', 'Praha', '1');
INSERT INTO `subadmin1` VALUES ('727', 'CZ.78', 'CZ', 'South Moravian', 'South Moravian', '1');
INSERT INTO `subadmin1` VALUES ('728', 'CZ.79', 'CZ', 'Jihočeský', 'Jihocesky', '1');
INSERT INTO `subadmin1` VALUES ('729', 'CZ.80', 'CZ', 'Vysočina', 'Vysocina', '1');
INSERT INTO `subadmin1` VALUES ('730', 'CZ.81', 'CZ', 'Karlovarský', 'Karlovarsky', '1');
INSERT INTO `subadmin1` VALUES ('731', 'CZ.82', 'CZ', 'Královéhradecký', 'Kralovehradecky', '1');
INSERT INTO `subadmin1` VALUES ('732', 'CZ.83', 'CZ', 'Liberecký', 'Liberecky', '1');
INSERT INTO `subadmin1` VALUES ('733', 'CZ.84', 'CZ', 'Olomoucký', 'Olomoucky', '1');
INSERT INTO `subadmin1` VALUES ('734', 'CZ.85', 'CZ', 'Moravskoslezský', 'Moravskoslezsky', '1');
INSERT INTO `subadmin1` VALUES ('735', 'CZ.86', 'CZ', 'Pardubický', 'Pardubicky', '1');
INSERT INTO `subadmin1` VALUES ('736', 'CZ.87', 'CZ', 'Plzeňský', 'Plzensky', '1');
INSERT INTO `subadmin1` VALUES ('737', 'CZ.88', 'CZ', 'Central Bohemia', 'Central Bohemia', '1');
INSERT INTO `subadmin1` VALUES ('738', 'CZ.89', 'CZ', 'Ústecký', 'Ustecky', '1');
INSERT INTO `subadmin1` VALUES ('739', 'CZ.90', 'CZ', 'Zlín', 'Zlin', '1');

-- ----------------------------
-- Table structure for subadmin2
-- ----------------------------
DROP TABLE IF EXISTS `subadmin2`;
CREATE TABLE `subadmin2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `country_code` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subadmin1_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `asciiname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `country_code` (`country_code`),
  KEY `subadmin1_code` (`subadmin1_code`),
  KEY `name` (`name`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=11915 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of subadmin2
-- ----------------------------
INSERT INTO `subadmin2` VALUES ('11817', 'CZ.78.0627', 'CZ', 'CZ.78', 'Okres Znojmo', 'Okres Znojmo', '1');
INSERT INTO `subadmin2` VALUES ('11818', 'CZ.80.0615', 'CZ', 'CZ.80', 'Okres Žďár nad Sázavou', 'Okres Zd\'ar nad Sazavou', '1');
INSERT INTO `subadmin2` VALUES ('11819', 'CZ.78.0626', 'CZ', 'CZ.78', 'Okres Vyškov', 'Okres Vyskov', '1');
INSERT INTO `subadmin2` VALUES ('11820', 'CZ.90.0723', 'CZ', 'CZ.90', 'Okres Vsetín', 'Okres Vsetin', '1');
INSERT INTO `subadmin2` VALUES ('11821', 'CZ.86.0534', 'CZ', 'CZ.86', 'Okres Ústí nad Orlicí', 'Okres Usti nad Orlici', '1');
INSERT INTO `subadmin2` VALUES ('11822', 'CZ.89.0427', 'CZ', 'CZ.89', 'Okres Ústí nad Labem', 'Okres Usti nad Labem', '1');
INSERT INTO `subadmin2` VALUES ('11823', 'CZ.90.0722', 'CZ', 'CZ.90', 'Okres Uherské Hradiště', 'Okres Uherske Hradiste', '1');
INSERT INTO `subadmin2` VALUES ('11824', 'CZ.82.0525', 'CZ', 'CZ.82', 'Okres Trutnov', 'Okres Trutnov', '1');
INSERT INTO `subadmin2` VALUES ('11825', 'CZ.80.0614', 'CZ', 'CZ.80', 'Okres Třebíč', 'Okres Trebic', '1');
INSERT INTO `subadmin2` VALUES ('11826', 'CZ.89.0426', 'CZ', 'CZ.89', 'Okres Teplice', 'Okres Teplice', '1');
INSERT INTO `subadmin2` VALUES ('11827', 'CZ.87.0327', 'CZ', 'CZ.87', 'Okres Tachov', 'Okres Tachov', '1');
INSERT INTO `subadmin2` VALUES ('11828', 'CZ.79.0317', 'CZ', 'CZ.79', 'Okres Tábor', 'Okres Tabor', '1');
INSERT INTO `subadmin2` VALUES ('11829', 'CZ.86.0533', 'CZ', 'CZ.86', 'Okres Svitavy', 'Okres Svitavy', '1');
INSERT INTO `subadmin2` VALUES ('11830', 'CZ.84.0715', 'CZ', 'CZ.84', 'Okres Šumperk', 'Okres Sumperk', '1');
INSERT INTO `subadmin2` VALUES ('11831', 'CZ.79.0316', 'CZ', 'CZ.79', 'Okres Strakonice', 'Okres Strakonice', '1');
INSERT INTO `subadmin2` VALUES ('11832', 'CZ.81.0413', 'CZ', 'CZ.81', 'Okres Sokolov', 'Okres Sokolov', '1');
INSERT INTO `subadmin2` VALUES ('11833', 'CZ.83.0514', 'CZ', 'CZ.83', 'Okres Semily', 'Okres Semily', '1');
INSERT INTO `subadmin2` VALUES ('11834', 'CZ.82.0524', 'CZ', 'CZ.82', 'Okres Rychnov nad Kněžnou', 'Okres Rychnov nad Kneznou', '1');
INSERT INTO `subadmin2` VALUES ('11835', 'CZ.87.0326', 'CZ', 'CZ.87', 'Okres Rokycany', 'Okres Rokycany', '1');
INSERT INTO `subadmin2` VALUES ('11836', 'CZ.88.020C', 'CZ', 'CZ.88', 'Okres Rakovník', 'Okres Rakovnik', '1');
INSERT INTO `subadmin2` VALUES ('11837', 'CZ.84.0713', 'CZ', 'CZ.84', 'Okres Prostějov', 'Okres Prostejov', '1');
INSERT INTO `subadmin2` VALUES ('11838', 'CZ.88.020B', 'CZ', 'CZ.88', 'Okres Příbram', 'Okres Pribram', '1');
INSERT INTO `subadmin2` VALUES ('11839', 'CZ.84.0714', 'CZ', 'CZ.84', 'Okres Přerov', 'Okres Prerov', '1');
INSERT INTO `subadmin2` VALUES ('11840', 'CZ.88.020A', 'CZ', 'CZ.88', 'Okres Praha-Západ', 'Okres Praha-Zapad', '1');
INSERT INTO `subadmin2` VALUES ('11841', 'CZ.88.0209', 'CZ', 'CZ.88', 'Okres Praha-Východ', 'Okres Praha-Vychod', '1');
INSERT INTO `subadmin2` VALUES ('11842', 'CZ.79.0315', 'CZ', 'CZ.79', 'Okres Prachatice', 'Okres Prachatice', '1');
INSERT INTO `subadmin2` VALUES ('11843', 'CZ.87.0325', 'CZ', 'CZ.87', 'Okres Plzeň-Sever', 'Okres Plzen-Sever', '1');
INSERT INTO `subadmin2` VALUES ('11844', 'CZ.87.0323', 'CZ', 'CZ.87', 'Okres Plzeň-Město', 'Okres Plzen-Mesto', '1');
INSERT INTO `subadmin2` VALUES ('11845', 'CZ.87.0324', 'CZ', 'CZ.87', 'Okres Plzeň-Jih', 'Okres Plzen-Jih', '1');
INSERT INTO `subadmin2` VALUES ('11846', 'CZ.79.0314', 'CZ', 'CZ.79', 'Okres Písek', 'Okres Pisek', '1');
INSERT INTO `subadmin2` VALUES ('11847', 'CZ.80.0613', 'CZ', 'CZ.80', 'Okres Pelhřimov', 'Okres Pelhrimov', '1');
INSERT INTO `subadmin2` VALUES ('11848', 'CZ.86.0532', 'CZ', 'CZ.86', 'Okres Pardubice', 'Okres Pardubice', '1');
INSERT INTO `subadmin2` VALUES ('11849', 'CZ.85.0806', 'CZ', 'CZ.85', 'Okres Ostrava-Město', 'Okres Ostrava-Mesto', '1');
INSERT INTO `subadmin2` VALUES ('11850', 'CZ.85.0805', 'CZ', 'CZ.85', 'Okres Opava', 'Okres Opava', '1');
INSERT INTO `subadmin2` VALUES ('11851', 'CZ.84.0712', 'CZ', 'CZ.84', 'Okres Olomouc', 'Okres Olomouc', '1');
INSERT INTO `subadmin2` VALUES ('11852', 'CZ.88.0208', 'CZ', 'CZ.88', 'Okres Nymburk', 'Okres Nymburk', '1');
INSERT INTO `subadmin2` VALUES ('11853', 'CZ.85.0804', 'CZ', 'CZ.85', 'Okres Nový Jičín', 'Okres Novy Jicin', '1');
INSERT INTO `subadmin2` VALUES ('11854', 'CZ.82.0523', 'CZ', 'CZ.82', 'Okres Náchod', 'Okres Nachod', '1');
INSERT INTO `subadmin2` VALUES ('11855', 'CZ.89.0425', 'CZ', 'CZ.89', 'Okres Most', 'Okres Most', '1');
INSERT INTO `subadmin2` VALUES ('11856', 'CZ.88.0207', 'CZ', 'CZ.88', 'Okres Mladá Boleslav', 'Okres Mlada Boleslav', '1');
INSERT INTO `subadmin2` VALUES ('11857', 'CZ.88.0206', 'CZ', 'CZ.88', 'Okres Mělník', 'Okres Melnik', '1');
INSERT INTO `subadmin2` VALUES ('11858', 'CZ.89.0424', 'CZ', 'CZ.89', 'Okres Louny', 'Okres Louny', '1');
INSERT INTO `subadmin2` VALUES ('11859', 'CZ.89.0423', 'CZ', 'CZ.89', 'Okres Litoměřice', 'Okres Litomerice', '1');
INSERT INTO `subadmin2` VALUES ('11860', 'CZ.83.0513', 'CZ', 'CZ.83', 'Okres Liberec', 'Okres Liberec', '1');
INSERT INTO `subadmin2` VALUES ('11861', 'CZ.88.0205', 'CZ', 'CZ.88', 'Okres Kutná Hora', 'Okres Kutna Hora', '1');
INSERT INTO `subadmin2` VALUES ('11862', 'CZ.90.0721', 'CZ', 'CZ.90', 'Okres Kroměříž', 'Okres Kromeriz', '1');
INSERT INTO `subadmin2` VALUES ('11863', 'CZ.88.0204', 'CZ', 'CZ.88', 'Okres Kolín', 'Okres Kolin', '1');
INSERT INTO `subadmin2` VALUES ('11864', 'CZ.87.0322', 'CZ', 'CZ.87', 'Okres Klatovy', 'Okres Klatovy', '1');
INSERT INTO `subadmin2` VALUES ('11865', 'CZ.88.0203', 'CZ', 'CZ.88', 'Okres Kladno', 'Okres Kladno', '1');
INSERT INTO `subadmin2` VALUES ('11866', 'CZ.85.0803', 'CZ', 'CZ.85', 'Okres Karviná', 'Okres Karvina', '1');
INSERT INTO `subadmin2` VALUES ('11867', 'CZ.81.0412', 'CZ', 'CZ.81', 'Okres Karlovy Vary', 'Okres Karlovy Vary', '1');
INSERT INTO `subadmin2` VALUES ('11868', 'CZ.79.0313', 'CZ', 'CZ.79', 'Okres Jindřichův Hradec', 'Okres Jindrichuv Hradec', '1');
INSERT INTO `subadmin2` VALUES ('11869', 'CZ.80.0612', 'CZ', 'CZ.80', 'Okres Jihlava', 'Okres Jihlava', '1');
INSERT INTO `subadmin2` VALUES ('11870', 'CZ.82.0522', 'CZ', 'CZ.82', 'Okres Jičín', 'Okres Jicin', '1');
INSERT INTO `subadmin2` VALUES ('11871', 'CZ.83.0512', 'CZ', 'CZ.83', 'Okres Jablonec nad Nisou', 'Okres Jablonec nad Nisou', '1');
INSERT INTO `subadmin2` VALUES ('11872', 'CZ.82.0521', 'CZ', 'CZ.82', 'Okres Hradec Králové', 'Okres Hradec Kralove', '1');
INSERT INTO `subadmin2` VALUES ('11873', 'CZ.78.0625', 'CZ', 'CZ.78', 'Okres Hodonín', 'Okres Hodonin', '1');
INSERT INTO `subadmin2` VALUES ('11874', 'CZ.80.0611', 'CZ', 'CZ.80', 'Okres Havlíčkův Brod', 'Okres Havlickuv Brod', '1');
INSERT INTO `subadmin2` VALUES ('11875', 'CZ.90.0724', 'CZ', 'CZ.90', 'Okres Zlín', 'Okres Zlin', '1');
INSERT INTO `subadmin2` VALUES ('11876', 'CZ.85.0802', 'CZ', 'CZ.85', 'Okres Frýdek-Místek', 'Okres Frydek-Mistek', '1');
INSERT INTO `subadmin2` VALUES ('11877', 'CZ.87.0321', 'CZ', 'CZ.87', 'Okres Domažlice', 'Okres Domazlice', '1');
INSERT INTO `subadmin2` VALUES ('11878', 'CZ.89.0421', 'CZ', 'CZ.89', 'Okres Děčín', 'Okres Decin', '1');
INSERT INTO `subadmin2` VALUES ('11879', 'CZ.86.0531', 'CZ', 'CZ.86', 'Okres Chrudim', 'Okres Chrudim', '1');
INSERT INTO `subadmin2` VALUES ('11880', 'CZ.89.0422', 'CZ', 'CZ.89', 'Okres Chomutov', 'Okres Chomutov', '1');
INSERT INTO `subadmin2` VALUES ('11881', 'CZ.81.0411', 'CZ', 'CZ.81', 'Okres Cheb', 'Okres Cheb', '1');
INSERT INTO `subadmin2` VALUES ('11882', 'CZ.79.0312', 'CZ', 'CZ.79', 'Okres Český Krumlov', 'Okres Cesky Krumlov', '1');
INSERT INTO `subadmin2` VALUES ('11883', 'CZ.79.0311', 'CZ', 'CZ.79', 'Okres České Budějovice', 'Okres Ceske Budejovice', '1');
INSERT INTO `subadmin2` VALUES ('11884', 'CZ.83.0511', 'CZ', 'CZ.83', 'Okres Česká Lípa', 'Okres Ceska Lipa', '1');
INSERT INTO `subadmin2` VALUES ('11885', 'CZ.85.0801', 'CZ', 'CZ.85', 'Okres Bruntál', 'Okres Bruntal', '1');
INSERT INTO `subadmin2` VALUES ('11886', 'CZ.78.0623', 'CZ', 'CZ.78', 'Okres Brno-Venkov', 'Okres Brno-Venkov', '1');
INSERT INTO `subadmin2` VALUES ('11887', 'CZ.78.0622', 'CZ', 'CZ.78', 'Město Brno', 'Mesto Brno', '1');
INSERT INTO `subadmin2` VALUES ('11888', 'CZ.78.0624', 'CZ', 'CZ.78', 'Okres Břeclav', 'Okres Breclav', '1');
INSERT INTO `subadmin2` VALUES ('11889', 'CZ.78.0621', 'CZ', 'CZ.78', 'Okres Blansko', 'Okres Blansko', '1');
INSERT INTO `subadmin2` VALUES ('11890', 'CZ.88.0202', 'CZ', 'CZ.88', 'Okres Beroun', 'Okres Beroun', '1');
INSERT INTO `subadmin2` VALUES ('11891', 'CZ.88.0201', 'CZ', 'CZ.88', 'Okres Benešov', 'Okres Benesov', '1');
INSERT INTO `subadmin2` VALUES ('11892', 'CZ.84.0711', 'CZ', 'CZ.84', 'Okres Jeseník', 'Okres Jesenik', '1');
INSERT INTO `subadmin2` VALUES ('11893', 'CZ.52.8378769', 'CZ', 'CZ.52', 'Praha 1', 'Praha 1', '1');
INSERT INTO `subadmin2` VALUES ('11894', 'CZ.52.8378770', 'CZ', 'CZ.52', 'Praha 2', 'Praha 2', '1');
INSERT INTO `subadmin2` VALUES ('11895', 'CZ.52.8378771', 'CZ', 'CZ.52', 'Praha 3', 'Praha 3', '1');
INSERT INTO `subadmin2` VALUES ('11896', 'CZ.52.8378772', 'CZ', 'CZ.52', 'Praha 4', 'Praha 4', '1');
INSERT INTO `subadmin2` VALUES ('11897', 'CZ.52.8378773', 'CZ', 'CZ.52', 'Praha 5', 'Praha 5', '1');
INSERT INTO `subadmin2` VALUES ('11898', 'CZ.52.8378774', 'CZ', 'CZ.52', 'Praha 6', 'Praha 6', '1');
INSERT INTO `subadmin2` VALUES ('11899', 'CZ.52.8378775', 'CZ', 'CZ.52', 'Praha 7', 'Praha 7', '1');
INSERT INTO `subadmin2` VALUES ('11900', 'CZ.52.8378776', 'CZ', 'CZ.52', 'Praha 8', 'Praha 8', '1');
INSERT INTO `subadmin2` VALUES ('11901', 'CZ.52.8378777', 'CZ', 'CZ.52', 'Praha 9', 'Praha 9', '1');
INSERT INTO `subadmin2` VALUES ('11902', 'CZ.52.8378778', 'CZ', 'CZ.52', 'Praha 10', 'Praha 10', '1');
INSERT INTO `subadmin2` VALUES ('11903', 'CZ.52.8378779', 'CZ', 'CZ.52', 'Praha 11', 'Praha 11', '1');
INSERT INTO `subadmin2` VALUES ('11904', 'CZ.52.8378780', 'CZ', 'CZ.52', 'Praha 12', 'Praha 12', '1');
INSERT INTO `subadmin2` VALUES ('11905', 'CZ.52.8378781', 'CZ', 'CZ.52', 'Praha 13', 'Praha 13', '1');
INSERT INTO `subadmin2` VALUES ('11906', 'CZ.52.8378782', 'CZ', 'CZ.52', 'Praha 14', 'Praha 14', '1');
INSERT INTO `subadmin2` VALUES ('11907', 'CZ.52.8378784', 'CZ', 'CZ.52', 'Praha 15', 'Praha 15', '1');
INSERT INTO `subadmin2` VALUES ('11908', 'CZ.52.8378785', 'CZ', 'CZ.52', 'Praha 16', 'Praha 16', '1');
INSERT INTO `subadmin2` VALUES ('11909', 'CZ.52.8378787', 'CZ', 'CZ.52', 'Praha 17', 'Praha 17', '1');
INSERT INTO `subadmin2` VALUES ('11910', 'CZ.52.8378788', 'CZ', 'CZ.52', 'Praha 18', 'Praha 18', '1');
INSERT INTO `subadmin2` VALUES ('11911', 'CZ.52.8378789', 'CZ', 'CZ.52', 'Praha 19', 'Praha 19', '1');
INSERT INTO `subadmin2` VALUES ('11912', 'CZ.52.8378790', 'CZ', 'CZ.52', 'Praha 20', 'Praha 20', '1');
INSERT INTO `subadmin2` VALUES ('11913', 'CZ.52.8378792', 'CZ', 'CZ.52', 'Praha 21', 'Praha 21', '1');
INSERT INTO `subadmin2` VALUES ('11914', 'CZ.52.8378793', 'CZ', 'CZ.52', 'Praha 22', 'Praha 22', '1');

-- ----------------------------
-- Table structure for sync
-- ----------------------------
DROP TABLE IF EXISTS `sync`;
CREATE TABLE `sync` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `server` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `remote_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `add` tinyint(1) NOT NULL DEFAULT '0',
  `edit` tinyint(1) NOT NULL DEFAULT '0',
  `delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sync_server_index` (`server`),
  KEY `sync_add_index` (`add`),
  KEY `sync_edit_index` (`edit`),
  KEY `sync_delete_index` (`delete`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sync
-- ----------------------------
INSERT INTO `sync` VALUES ('1', '23', 'sreality', null, '1', '1', '0', '2019-05-03 23:06:10', '2019-05-16 23:26:58');
INSERT INTO `sync` VALUES ('2', '28', 'sreality', null, '1', '0', '0', '2019-05-17 03:31:07', '2019-05-17 03:31:07');

-- ----------------------------
-- Table structure for time_zones
-- ----------------------------
DROP TABLE IF EXISTS `time_zones`;
CREATE TABLE `time_zones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `time_zone_id` varchar(40) COLLATE utf8_unicode_ci DEFAULT '',
  `gmt` double DEFAULT NULL,
  `dst` double DEFAULT NULL,
  `raw` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `time_zone_id` (`time_zone_id`),
  KEY `country_code` (`country_code`)
) ENGINE=InnoDB AUTO_INCREMENT=425 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of time_zones
-- ----------------------------
INSERT INTO `time_zones` VALUES ('1', 'CI', 'Africa/Abidjan', '0', '0', '0');
INSERT INTO `time_zones` VALUES ('2', 'GH', 'Africa/Accra', '0', '0', '0');
INSERT INTO `time_zones` VALUES ('3', 'ET', 'Africa/Addis_Ababa', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('4', 'DZ', 'Africa/Algiers', '1', '1', '1');
INSERT INTO `time_zones` VALUES ('5', 'ER', 'Africa/Asmara', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('6', 'ML', 'Africa/Bamako', '0', '0', '0');
INSERT INTO `time_zones` VALUES ('7', 'CF', 'Africa/Bangui', '1', '1', '1');
INSERT INTO `time_zones` VALUES ('8', 'GM', 'Africa/Banjul', '0', '0', '0');
INSERT INTO `time_zones` VALUES ('9', 'GW', 'Africa/Bissau', '0', '0', '0');
INSERT INTO `time_zones` VALUES ('10', 'MW', 'Africa/Blantyre', '2', '2', '2');
INSERT INTO `time_zones` VALUES ('11', 'CG', 'Africa/Brazzaville', '1', '1', '1');
INSERT INTO `time_zones` VALUES ('12', 'BI', 'Africa/Bujumbura', '2', '2', '2');
INSERT INTO `time_zones` VALUES ('13', 'EG', 'Africa/Cairo', '2', '2', '2');
INSERT INTO `time_zones` VALUES ('14', 'MA', 'Africa/Casablanca', '0', '1', '0');
INSERT INTO `time_zones` VALUES ('15', 'ES', 'Africa/Ceuta', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('16', 'GN', 'Africa/Conakry', '0', '0', '0');
INSERT INTO `time_zones` VALUES ('17', 'SN', 'Africa/Dakar', '0', '0', '0');
INSERT INTO `time_zones` VALUES ('18', 'TZ', 'Africa/Dar_es_Salaam', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('19', 'DJ', 'Africa/Djibouti', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('20', 'CM', 'Africa/Douala', '1', '1', '1');
INSERT INTO `time_zones` VALUES ('21', 'EH', 'Africa/El_Aaiun', '0', '1', '0');
INSERT INTO `time_zones` VALUES ('22', 'SL', 'Africa/Freetown', '0', '0', '0');
INSERT INTO `time_zones` VALUES ('23', 'BW', 'Africa/Gaborone', '2', '2', '2');
INSERT INTO `time_zones` VALUES ('24', 'ZW', 'Africa/Harare', '2', '2', '2');
INSERT INTO `time_zones` VALUES ('25', 'ZA', 'Africa/Johannesburg', '2', '2', '2');
INSERT INTO `time_zones` VALUES ('26', 'SS', 'Africa/Juba', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('27', 'UG', 'Africa/Kampala', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('28', 'SD', 'Africa/Khartoum', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('29', 'RW', 'Africa/Kigali', '2', '2', '2');
INSERT INTO `time_zones` VALUES ('30', 'CD', 'Africa/Kinshasa', '1', '1', '1');
INSERT INTO `time_zones` VALUES ('31', 'NG', 'Africa/Lagos', '1', '1', '1');
INSERT INTO `time_zones` VALUES ('32', 'GA', 'Africa/Libreville', '1', '1', '1');
INSERT INTO `time_zones` VALUES ('33', 'TG', 'Africa/Lome', '0', '0', '0');
INSERT INTO `time_zones` VALUES ('34', 'AO', 'Africa/Luanda', '1', '1', '1');
INSERT INTO `time_zones` VALUES ('35', 'CD', 'Africa/Lubumbashi', '2', '2', '2');
INSERT INTO `time_zones` VALUES ('36', 'ZM', 'Africa/Lusaka', '2', '2', '2');
INSERT INTO `time_zones` VALUES ('37', 'GQ', 'Africa/Malabo', '1', '1', '1');
INSERT INTO `time_zones` VALUES ('38', 'MZ', 'Africa/Maputo', '2', '2', '2');
INSERT INTO `time_zones` VALUES ('39', 'LS', 'Africa/Maseru', '2', '2', '2');
INSERT INTO `time_zones` VALUES ('40', 'SZ', 'Africa/Mbabane', '2', '2', '2');
INSERT INTO `time_zones` VALUES ('41', 'SO', 'Africa/Mogadishu', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('42', 'LR', 'Africa/Monrovia', '0', '0', '0');
INSERT INTO `time_zones` VALUES ('43', 'KE', 'Africa/Nairobi', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('44', 'TD', 'Africa/Ndjamena', '1', '1', '1');
INSERT INTO `time_zones` VALUES ('45', 'NE', 'Africa/Niamey', '1', '1', '1');
INSERT INTO `time_zones` VALUES ('46', 'MR', 'Africa/Nouakchott', '0', '0', '0');
INSERT INTO `time_zones` VALUES ('47', 'BF', 'Africa/Ouagadougou', '0', '0', '0');
INSERT INTO `time_zones` VALUES ('48', 'BJ', 'Africa/Porto-Novo', '1', '1', '1');
INSERT INTO `time_zones` VALUES ('49', 'ST', 'Africa/Sao_Tome', '0', '0', '0');
INSERT INTO `time_zones` VALUES ('50', 'LY', 'Africa/Tripoli', '2', '2', '2');
INSERT INTO `time_zones` VALUES ('51', 'TN', 'Africa/Tunis', '1', '1', '1');
INSERT INTO `time_zones` VALUES ('52', 'NA', 'Africa/Windhoek', '2', '1', '1');
INSERT INTO `time_zones` VALUES ('53', 'US', 'America/Adak', '-10', '-9', '-10');
INSERT INTO `time_zones` VALUES ('54', 'US', 'America/Anchorage', '-9', '-8', '-9');
INSERT INTO `time_zones` VALUES ('55', 'AI', 'America/Anguilla', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('56', 'AG', 'America/Antigua', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('57', 'BR', 'America/Araguaina', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('58', 'AR', 'America/Argentina/Buenos_Aires', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('59', 'AR', 'America/Argentina/Catamarca', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('60', 'AR', 'America/Argentina/Cordoba', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('61', 'AR', 'America/Argentina/Jujuy', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('62', 'AR', 'America/Argentina/La_Rioja', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('63', 'AR', 'America/Argentina/Mendoza', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('64', 'AR', 'America/Argentina/Rio_Gallegos', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('65', 'AR', 'America/Argentina/Salta', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('66', 'AR', 'America/Argentina/San_Juan', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('67', 'AR', 'America/Argentina/San_Luis', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('68', 'AR', 'America/Argentina/Tucuman', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('69', 'AR', 'America/Argentina/Ushuaia', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('70', 'AW', 'America/Aruba', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('71', 'PY', 'America/Asuncion', '-3', '-4', '-4');
INSERT INTO `time_zones` VALUES ('72', 'CA', 'America/Atikokan', '-5', '-5', '-5');
INSERT INTO `time_zones` VALUES ('73', 'BR', 'America/Bahia', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('74', 'MX', 'America/Bahia_Banderas', '-6', '-5', '-6');
INSERT INTO `time_zones` VALUES ('75', 'BB', 'America/Barbados', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('76', 'BR', 'America/Belem', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('77', 'BZ', 'America/Belize', '-6', '-6', '-6');
INSERT INTO `time_zones` VALUES ('78', 'CA', 'America/Blanc-Sablon', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('79', 'BR', 'America/Boa_Vista', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('80', 'CO', 'America/Bogota', '-5', '-5', '-5');
INSERT INTO `time_zones` VALUES ('81', 'US', 'America/Boise', '-7', '-6', '-7');
INSERT INTO `time_zones` VALUES ('82', 'CA', 'America/Cambridge_Bay', '-7', '-6', '-7');
INSERT INTO `time_zones` VALUES ('83', 'BR', 'America/Campo_Grande', '-3', '-4', '-4');
INSERT INTO `time_zones` VALUES ('84', 'MX', 'America/Cancun', '-5', '-5', '-5');
INSERT INTO `time_zones` VALUES ('85', 'VE', 'America/Caracas', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('86', 'GF', 'America/Cayenne', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('87', 'KY', 'America/Cayman', '-5', '-5', '-5');
INSERT INTO `time_zones` VALUES ('88', 'US', 'America/Chicago', '-6', '-5', '-6');
INSERT INTO `time_zones` VALUES ('89', 'MX', 'America/Chihuahua', '-7', '-6', '-7');
INSERT INTO `time_zones` VALUES ('90', 'CR', 'America/Costa_Rica', '-6', '-6', '-6');
INSERT INTO `time_zones` VALUES ('91', 'CA', 'America/Creston', '-7', '-7', '-7');
INSERT INTO `time_zones` VALUES ('92', 'BR', 'America/Cuiaba', '-3', '-4', '-4');
INSERT INTO `time_zones` VALUES ('93', 'CW', 'America/Curacao', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('94', 'GL', 'America/Danmarkshavn', '0', '0', '0');
INSERT INTO `time_zones` VALUES ('95', 'CA', 'America/Dawson', '-8', '-7', '-8');
INSERT INTO `time_zones` VALUES ('96', 'CA', 'America/Dawson_Creek', '-7', '-7', '-7');
INSERT INTO `time_zones` VALUES ('97', 'US', 'America/Denver', '-7', '-6', '-7');
INSERT INTO `time_zones` VALUES ('98', 'US', 'America/Detroit', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('99', 'DM', 'America/Dominica', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('100', 'CA', 'America/Edmonton', '-7', '-6', '-7');
INSERT INTO `time_zones` VALUES ('101', 'BR', 'America/Eirunepe', '-5', '-5', '-5');
INSERT INTO `time_zones` VALUES ('102', 'SV', 'America/El_Salvador', '-6', '-6', '-6');
INSERT INTO `time_zones` VALUES ('103', 'CA', 'America/Fort_Nelson', '-7', '-7', '-7');
INSERT INTO `time_zones` VALUES ('104', 'BR', 'America/Fortaleza', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('105', 'CA', 'America/Glace_Bay', '-4', '-3', '-4');
INSERT INTO `time_zones` VALUES ('106', 'GL', 'America/Godthab', '-3', '-2', '-3');
INSERT INTO `time_zones` VALUES ('107', 'CA', 'America/Goose_Bay', '-4', '-3', '-4');
INSERT INTO `time_zones` VALUES ('108', 'TC', 'America/Grand_Turk', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('109', 'GD', 'America/Grenada', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('110', 'GP', 'America/Guadeloupe', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('111', 'GT', 'America/Guatemala', '-6', '-6', '-6');
INSERT INTO `time_zones` VALUES ('112', 'EC', 'America/Guayaquil', '-5', '-5', '-5');
INSERT INTO `time_zones` VALUES ('113', 'GY', 'America/Guyana', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('114', 'CA', 'America/Halifax', '-4', '-3', '-4');
INSERT INTO `time_zones` VALUES ('115', 'CU', 'America/Havana', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('116', 'MX', 'America/Hermosillo', '-7', '-7', '-7');
INSERT INTO `time_zones` VALUES ('117', 'US', 'America/Indiana/Indianapolis', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('118', 'US', 'America/Indiana/Knox', '-6', '-5', '-6');
INSERT INTO `time_zones` VALUES ('119', 'US', 'America/Indiana/Marengo', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('120', 'US', 'America/Indiana/Petersburg', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('121', 'US', 'America/Indiana/Tell_City', '-6', '-5', '-6');
INSERT INTO `time_zones` VALUES ('122', 'US', 'America/Indiana/Vevay', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('123', 'US', 'America/Indiana/Vincennes', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('124', 'US', 'America/Indiana/Winamac', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('125', 'CA', 'America/Inuvik', '-7', '-6', '-7');
INSERT INTO `time_zones` VALUES ('126', 'CA', 'America/Iqaluit', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('127', 'JM', 'America/Jamaica', '-5', '-5', '-5');
INSERT INTO `time_zones` VALUES ('128', 'US', 'America/Juneau', '-9', '-8', '-9');
INSERT INTO `time_zones` VALUES ('129', 'US', 'America/Kentucky/Louisville', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('130', 'US', 'America/Kentucky/Monticello', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('131', 'BQ', 'America/Kralendijk', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('132', 'BO', 'America/La_Paz', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('133', 'PE', 'America/Lima', '-5', '-5', '-5');
INSERT INTO `time_zones` VALUES ('134', 'US', 'America/Los_Angeles', '-8', '-7', '-8');
INSERT INTO `time_zones` VALUES ('135', 'SX', 'America/Lower_Princes', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('136', 'BR', 'America/Maceio', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('137', 'NI', 'America/Managua', '-6', '-6', '-6');
INSERT INTO `time_zones` VALUES ('138', 'BR', 'America/Manaus', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('139', 'MF', 'America/Marigot', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('140', 'MQ', 'America/Martinique', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('141', 'MX', 'America/Matamoros', '-6', '-5', '-6');
INSERT INTO `time_zones` VALUES ('142', 'MX', 'America/Mazatlan', '-7', '-6', '-7');
INSERT INTO `time_zones` VALUES ('143', 'US', 'America/Menominee', '-6', '-5', '-6');
INSERT INTO `time_zones` VALUES ('144', 'MX', 'America/Merida', '-6', '-5', '-6');
INSERT INTO `time_zones` VALUES ('145', 'US', 'America/Metlakatla', '-9', '-8', '-9');
INSERT INTO `time_zones` VALUES ('146', 'MX', 'America/Mexico_City', '-6', '-5', '-6');
INSERT INTO `time_zones` VALUES ('147', 'PM', 'America/Miquelon', '-3', '-2', '-3');
INSERT INTO `time_zones` VALUES ('148', 'CA', 'America/Moncton', '-4', '-3', '-4');
INSERT INTO `time_zones` VALUES ('149', 'MX', 'America/Monterrey', '-6', '-5', '-6');
INSERT INTO `time_zones` VALUES ('150', 'UY', 'America/Montevideo', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('151', 'MS', 'America/Montserrat', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('152', 'BS', 'America/Nassau', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('153', 'US', 'America/New_York', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('154', 'CA', 'America/Nipigon', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('155', 'US', 'America/Nome', '-9', '-8', '-9');
INSERT INTO `time_zones` VALUES ('156', 'BR', 'America/Noronha', '-2', '-2', '-2');
INSERT INTO `time_zones` VALUES ('157', 'US', 'America/North_Dakota/Beulah', '-6', '-5', '-6');
INSERT INTO `time_zones` VALUES ('158', 'US', 'America/North_Dakota/Center', '-6', '-5', '-6');
INSERT INTO `time_zones` VALUES ('159', 'US', 'America/North_Dakota/New_Salem', '-6', '-5', '-6');
INSERT INTO `time_zones` VALUES ('160', 'MX', 'America/Ojinaga', '-7', '-6', '-7');
INSERT INTO `time_zones` VALUES ('161', 'PA', 'America/Panama', '-5', '-5', '-5');
INSERT INTO `time_zones` VALUES ('162', 'CA', 'America/Pangnirtung', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('163', 'SR', 'America/Paramaribo', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('164', 'US', 'America/Phoenix', '-7', '-7', '-7');
INSERT INTO `time_zones` VALUES ('165', 'HT', 'America/Port-au-Prince', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('166', 'TT', 'America/Port_of_Spain', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('167', 'BR', 'America/Porto_Velho', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('168', 'PR', 'America/Puerto_Rico', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('169', 'CL', 'America/Punta_Arenas', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('170', 'CA', 'America/Rainy_River', '-6', '-5', '-6');
INSERT INTO `time_zones` VALUES ('171', 'CA', 'America/Rankin_Inlet', '-6', '-5', '-6');
INSERT INTO `time_zones` VALUES ('172', 'BR', 'America/Recife', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('173', 'CA', 'America/Regina', '-6', '-6', '-6');
INSERT INTO `time_zones` VALUES ('174', 'CA', 'America/Resolute', '-6', '-5', '-6');
INSERT INTO `time_zones` VALUES ('175', 'BR', 'America/Rio_Branco', '-5', '-5', '-5');
INSERT INTO `time_zones` VALUES ('176', 'BR', 'America/Santarem', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('177', 'CL', 'America/Santiago', '-3', '-4', '-4');
INSERT INTO `time_zones` VALUES ('178', 'DO', 'America/Santo_Domingo', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('179', 'BR', 'America/Sao_Paulo', '-2', '-3', '-3');
INSERT INTO `time_zones` VALUES ('180', 'GL', 'America/Scoresbysund', '-1', '0', '-1');
INSERT INTO `time_zones` VALUES ('181', 'US', 'America/Sitka', '-9', '-8', '-9');
INSERT INTO `time_zones` VALUES ('182', 'BL', 'America/St_Barthelemy', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('183', 'CA', 'America/St_Johns', '-3.5', '-2.5', '-3.5');
INSERT INTO `time_zones` VALUES ('184', 'KN', 'America/St_Kitts', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('185', 'LC', 'America/St_Lucia', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('186', 'VI', 'America/St_Thomas', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('187', 'VC', 'America/St_Vincent', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('188', 'CA', 'America/Swift_Current', '-6', '-6', '-6');
INSERT INTO `time_zones` VALUES ('189', 'HN', 'America/Tegucigalpa', '-6', '-6', '-6');
INSERT INTO `time_zones` VALUES ('190', 'GL', 'America/Thule', '-4', '-3', '-4');
INSERT INTO `time_zones` VALUES ('191', 'CA', 'America/Thunder_Bay', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('192', 'MX', 'America/Tijuana', '-8', '-7', '-8');
INSERT INTO `time_zones` VALUES ('193', 'CA', 'America/Toronto', '-5', '-4', '-5');
INSERT INTO `time_zones` VALUES ('194', 'VG', 'America/Tortola', '-4', '-4', '-4');
INSERT INTO `time_zones` VALUES ('195', 'CA', 'America/Vancouver', '-8', '-7', '-8');
INSERT INTO `time_zones` VALUES ('196', 'CA', 'America/Whitehorse', '-8', '-7', '-8');
INSERT INTO `time_zones` VALUES ('197', 'CA', 'America/Winnipeg', '-6', '-5', '-6');
INSERT INTO `time_zones` VALUES ('198', 'US', 'America/Yakutat', '-9', '-8', '-9');
INSERT INTO `time_zones` VALUES ('199', 'CA', 'America/Yellowknife', '-7', '-6', '-7');
INSERT INTO `time_zones` VALUES ('200', 'AQ', 'Antarctica/Casey', '11', '11', '11');
INSERT INTO `time_zones` VALUES ('201', 'AQ', 'Antarctica/Davis', '7', '7', '7');
INSERT INTO `time_zones` VALUES ('202', 'AQ', 'Antarctica/DumontDUrville', '10', '10', '10');
INSERT INTO `time_zones` VALUES ('203', 'AU', 'Antarctica/Macquarie', '11', '11', '11');
INSERT INTO `time_zones` VALUES ('204', 'AQ', 'Antarctica/Mawson', '5', '5', '5');
INSERT INTO `time_zones` VALUES ('205', 'AQ', 'Antarctica/McMurdo', '13', '12', '12');
INSERT INTO `time_zones` VALUES ('206', 'AQ', 'Antarctica/Palmer', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('207', 'AQ', 'Antarctica/Rothera', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('208', 'AQ', 'Antarctica/Syowa', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('209', 'AQ', 'Antarctica/Troll', '0', '2', '0');
INSERT INTO `time_zones` VALUES ('210', 'AQ', 'Antarctica/Vostok', '6', '6', '6');
INSERT INTO `time_zones` VALUES ('211', 'SJ', 'Arctic/Longyearbyen', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('212', 'YE', 'Asia/Aden', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('213', 'KZ', 'Asia/Almaty', '6', '6', '6');
INSERT INTO `time_zones` VALUES ('214', 'JO', 'Asia/Amman', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('215', 'RU', 'Asia/Anadyr', '12', '12', '12');
INSERT INTO `time_zones` VALUES ('216', 'KZ', 'Asia/Aqtau', '5', '5', '5');
INSERT INTO `time_zones` VALUES ('217', 'KZ', 'Asia/Aqtobe', '5', '5', '5');
INSERT INTO `time_zones` VALUES ('218', 'TM', 'Asia/Ashgabat', '5', '5', '5');
INSERT INTO `time_zones` VALUES ('219', 'KZ', 'Asia/Atyrau', '5', '5', '5');
INSERT INTO `time_zones` VALUES ('220', 'IQ', 'Asia/Baghdad', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('221', 'BH', 'Asia/Bahrain', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('222', 'AZ', 'Asia/Baku', '4', '4', '4');
INSERT INTO `time_zones` VALUES ('223', 'TH', 'Asia/Bangkok', '7', '7', '7');
INSERT INTO `time_zones` VALUES ('224', 'RU', 'Asia/Barnaul', '7', '7', '7');
INSERT INTO `time_zones` VALUES ('225', 'LB', 'Asia/Beirut', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('226', 'KG', 'Asia/Bishkek', '6', '6', '6');
INSERT INTO `time_zones` VALUES ('227', 'BN', 'Asia/Brunei', '8', '8', '8');
INSERT INTO `time_zones` VALUES ('228', 'RU', 'Asia/Chita', '9', '9', '9');
INSERT INTO `time_zones` VALUES ('229', 'MN', 'Asia/Choibalsan', '8', '8', '8');
INSERT INTO `time_zones` VALUES ('230', 'LK', 'Asia/Colombo', '5.5', '5.5', '5.5');
INSERT INTO `time_zones` VALUES ('231', 'SY', 'Asia/Damascus', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('232', 'BD', 'Asia/Dhaka', '6', '6', '6');
INSERT INTO `time_zones` VALUES ('233', 'TL', 'Asia/Dili', '9', '9', '9');
INSERT INTO `time_zones` VALUES ('234', 'AE', 'Asia/Dubai', '4', '4', '4');
INSERT INTO `time_zones` VALUES ('235', 'TJ', 'Asia/Dushanbe', '5', '5', '5');
INSERT INTO `time_zones` VALUES ('236', 'CY', 'Asia/Famagusta', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('237', 'PS', 'Asia/Gaza', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('238', 'PS', 'Asia/Hebron', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('239', 'VN', 'Asia/Ho_Chi_Minh', '7', '7', '7');
INSERT INTO `time_zones` VALUES ('240', 'HK', 'Asia/Hong_Kong', '8', '8', '8');
INSERT INTO `time_zones` VALUES ('241', 'MN', 'Asia/Hovd', '7', '7', '7');
INSERT INTO `time_zones` VALUES ('242', 'RU', 'Asia/Irkutsk', '8', '8', '8');
INSERT INTO `time_zones` VALUES ('243', 'ID', 'Asia/Jakarta', '7', '7', '7');
INSERT INTO `time_zones` VALUES ('244', 'ID', 'Asia/Jayapura', '9', '9', '9');
INSERT INTO `time_zones` VALUES ('245', 'IL', 'Asia/Jerusalem', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('246', 'AF', 'Asia/Kabul', '4.5', '4.5', '4.5');
INSERT INTO `time_zones` VALUES ('247', 'RU', 'Asia/Kamchatka', '12', '12', '12');
INSERT INTO `time_zones` VALUES ('248', 'PK', 'Asia/Karachi', '5', '5', '5');
INSERT INTO `time_zones` VALUES ('249', 'NP', 'Asia/Kathmandu', '5.75', '5.75', '5.75');
INSERT INTO `time_zones` VALUES ('250', 'RU', 'Asia/Khandyga', '9', '9', '9');
INSERT INTO `time_zones` VALUES ('251', 'IN', 'Asia/Kolkata', '5.5', '5.5', '5.5');
INSERT INTO `time_zones` VALUES ('252', 'RU', 'Asia/Krasnoyarsk', '7', '7', '7');
INSERT INTO `time_zones` VALUES ('253', 'MY', 'Asia/Kuala_Lumpur', '8', '8', '8');
INSERT INTO `time_zones` VALUES ('254', 'MY', 'Asia/Kuching', '8', '8', '8');
INSERT INTO `time_zones` VALUES ('255', 'KW', 'Asia/Kuwait', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('256', 'MO', 'Asia/Macau', '8', '8', '8');
INSERT INTO `time_zones` VALUES ('257', 'RU', 'Asia/Magadan', '11', '11', '11');
INSERT INTO `time_zones` VALUES ('258', 'ID', 'Asia/Makassar', '8', '8', '8');
INSERT INTO `time_zones` VALUES ('259', 'PH', 'Asia/Manila', '8', '8', '8');
INSERT INTO `time_zones` VALUES ('260', 'OM', 'Asia/Muscat', '4', '4', '4');
INSERT INTO `time_zones` VALUES ('261', 'CY', 'Asia/Nicosia', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('262', 'RU', 'Asia/Novokuznetsk', '7', '7', '7');
INSERT INTO `time_zones` VALUES ('263', 'RU', 'Asia/Novosibirsk', '7', '7', '7');
INSERT INTO `time_zones` VALUES ('264', 'RU', 'Asia/Omsk', '6', '6', '6');
INSERT INTO `time_zones` VALUES ('265', 'KZ', 'Asia/Oral', '5', '5', '5');
INSERT INTO `time_zones` VALUES ('266', 'KH', 'Asia/Phnom_Penh', '7', '7', '7');
INSERT INTO `time_zones` VALUES ('267', 'ID', 'Asia/Pontianak', '7', '7', '7');
INSERT INTO `time_zones` VALUES ('268', 'KP', 'Asia/Pyongyang', '8.5', '8.5', '8.5');
INSERT INTO `time_zones` VALUES ('269', 'QA', 'Asia/Qatar', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('270', 'KZ', 'Asia/Qyzylorda', '6', '6', '6');
INSERT INTO `time_zones` VALUES ('271', 'SA', 'Asia/Riyadh', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('272', 'RU', 'Asia/Sakhalin', '11', '11', '11');
INSERT INTO `time_zones` VALUES ('273', 'UZ', 'Asia/Samarkand', '5', '5', '5');
INSERT INTO `time_zones` VALUES ('274', 'KR', 'Asia/Seoul', '9', '9', '9');
INSERT INTO `time_zones` VALUES ('275', 'CN', 'Asia/Shanghai', '8', '8', '8');
INSERT INTO `time_zones` VALUES ('276', 'SG', 'Asia/Singapore', '8', '8', '8');
INSERT INTO `time_zones` VALUES ('277', 'RU', 'Asia/Srednekolymsk', '11', '11', '11');
INSERT INTO `time_zones` VALUES ('278', 'TW', 'Asia/Taipei', '8', '8', '8');
INSERT INTO `time_zones` VALUES ('279', 'UZ', 'Asia/Tashkent', '5', '5', '5');
INSERT INTO `time_zones` VALUES ('280', 'GE', 'Asia/Tbilisi', '4', '4', '4');
INSERT INTO `time_zones` VALUES ('281', 'IR', 'Asia/Tehran', '3.5', '4.5', '3.5');
INSERT INTO `time_zones` VALUES ('282', 'BT', 'Asia/Thimphu', '6', '6', '6');
INSERT INTO `time_zones` VALUES ('283', 'JP', 'Asia/Tokyo', '9', '9', '9');
INSERT INTO `time_zones` VALUES ('284', 'RU', 'Asia/Tomsk', '7', '7', '7');
INSERT INTO `time_zones` VALUES ('285', 'MN', 'Asia/Ulaanbaatar', '8', '8', '8');
INSERT INTO `time_zones` VALUES ('286', 'CN', 'Asia/Urumqi', '6', '6', '6');
INSERT INTO `time_zones` VALUES ('287', 'RU', 'Asia/Ust-Nera', '10', '10', '10');
INSERT INTO `time_zones` VALUES ('288', 'LA', 'Asia/Vientiane', '7', '7', '7');
INSERT INTO `time_zones` VALUES ('289', 'RU', 'Asia/Vladivostok', '10', '10', '10');
INSERT INTO `time_zones` VALUES ('290', 'RU', 'Asia/Yakutsk', '9', '9', '9');
INSERT INTO `time_zones` VALUES ('291', 'MM', 'Asia/Yangon', '6.5', '6.5', '6.5');
INSERT INTO `time_zones` VALUES ('292', 'RU', 'Asia/Yekaterinburg', '5', '5', '5');
INSERT INTO `time_zones` VALUES ('293', 'AM', 'Asia/Yerevan', '4', '4', '4');
INSERT INTO `time_zones` VALUES ('294', 'PT', 'Atlantic/Azores', '-1', '0', '-1');
INSERT INTO `time_zones` VALUES ('295', 'BM', 'Atlantic/Bermuda', '-4', '-3', '-4');
INSERT INTO `time_zones` VALUES ('296', 'ES', 'Atlantic/Canary', '0', '1', '0');
INSERT INTO `time_zones` VALUES ('297', 'CV', 'Atlantic/Cape_Verde', '-1', '-1', '-1');
INSERT INTO `time_zones` VALUES ('298', 'FO', 'Atlantic/Faroe', '0', '1', '0');
INSERT INTO `time_zones` VALUES ('299', 'PT', 'Atlantic/Madeira', '0', '1', '0');
INSERT INTO `time_zones` VALUES ('300', 'IS', 'Atlantic/Reykjavik', '0', '0', '0');
INSERT INTO `time_zones` VALUES ('301', 'GS', 'Atlantic/South_Georgia', '-2', '-2', '-2');
INSERT INTO `time_zones` VALUES ('302', 'SH', 'Atlantic/St_Helena', '0', '0', '0');
INSERT INTO `time_zones` VALUES ('303', 'FK', 'Atlantic/Stanley', '-3', '-3', '-3');
INSERT INTO `time_zones` VALUES ('304', 'AU', 'Australia/Adelaide', '10.5', '9.5', '9.5');
INSERT INTO `time_zones` VALUES ('305', 'AU', 'Australia/Brisbane', '10', '10', '10');
INSERT INTO `time_zones` VALUES ('306', 'AU', 'Australia/Broken_Hill', '10.5', '9.5', '9.5');
INSERT INTO `time_zones` VALUES ('307', 'AU', 'Australia/Currie', '11', '10', '10');
INSERT INTO `time_zones` VALUES ('308', 'AU', 'Australia/Darwin', '9.5', '9.5', '9.5');
INSERT INTO `time_zones` VALUES ('309', 'AU', 'Australia/Eucla', '8.75', '8.75', '8.75');
INSERT INTO `time_zones` VALUES ('310', 'AU', 'Australia/Hobart', '11', '10', '10');
INSERT INTO `time_zones` VALUES ('311', 'AU', 'Australia/Lindeman', '10', '10', '10');
INSERT INTO `time_zones` VALUES ('312', 'AU', 'Australia/Lord_Howe', '11', '10.5', '10.5');
INSERT INTO `time_zones` VALUES ('313', 'AU', 'Australia/Melbourne', '11', '10', '10');
INSERT INTO `time_zones` VALUES ('314', 'AU', 'Australia/Perth', '8', '8', '8');
INSERT INTO `time_zones` VALUES ('315', 'AU', 'Australia/Sydney', '11', '10', '10');
INSERT INTO `time_zones` VALUES ('316', 'NL', 'Europe/Amsterdam', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('317', 'AD', 'Europe/Andorra', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('318', 'RU', 'Europe/Astrakhan', '4', '4', '4');
INSERT INTO `time_zones` VALUES ('319', 'GR', 'Europe/Athens', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('320', 'RS', 'Europe/Belgrade', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('321', 'DE', 'Europe/Berlin', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('322', 'SK', 'Europe/Bratislava', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('323', 'BE', 'Europe/Brussels', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('324', 'RO', 'Europe/Bucharest', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('325', 'HU', 'Europe/Budapest', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('326', 'DE', 'Europe/Busingen', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('327', 'MD', 'Europe/Chisinau', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('328', 'DK', 'Europe/Copenhagen', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('329', 'IE', 'Europe/Dublin', '0', '1', '0');
INSERT INTO `time_zones` VALUES ('330', 'GI', 'Europe/Gibraltar', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('331', 'GG', 'Europe/Guernsey', '0', '1', '0');
INSERT INTO `time_zones` VALUES ('332', 'FI', 'Europe/Helsinki', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('333', 'IM', 'Europe/Isle_of_Man', '0', '1', '0');
INSERT INTO `time_zones` VALUES ('334', 'TR', 'Europe/Istanbul', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('335', 'JE', 'Europe/Jersey', '0', '1', '0');
INSERT INTO `time_zones` VALUES ('336', 'RU', 'Europe/Kaliningrad', '2', '2', '2');
INSERT INTO `time_zones` VALUES ('337', 'UA', 'Europe/Kiev', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('338', 'RU', 'Europe/Kirov', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('339', 'PT', 'Europe/Lisbon', '0', '1', '0');
INSERT INTO `time_zones` VALUES ('340', 'SI', 'Europe/Ljubljana', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('341', 'UK', 'Europe/London', '0', '1', '0');
INSERT INTO `time_zones` VALUES ('342', 'LU', 'Europe/Luxembourg', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('343', 'ES', 'Europe/Madrid', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('344', 'MT', 'Europe/Malta', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('345', 'AX', 'Europe/Mariehamn', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('346', 'BY', 'Europe/Minsk', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('347', 'MC', 'Europe/Monaco', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('348', 'RU', 'Europe/Moscow', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('349', 'NO', 'Europe/Oslo', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('350', 'FR', 'Europe/Paris', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('351', 'ME', 'Europe/Podgorica', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('352', 'CZ', 'Europe/Prague', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('353', 'LV', 'Europe/Riga', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('354', 'IT', 'Europe/Rome', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('355', 'RU', 'Europe/Samara', '4', '4', '4');
INSERT INTO `time_zones` VALUES ('356', 'SM', 'Europe/San_Marino', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('357', 'BA', 'Europe/Sarajevo', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('358', 'RU', 'Europe/Saratov', '4', '4', '4');
INSERT INTO `time_zones` VALUES ('359', 'RU', 'Europe/Simferopol', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('360', 'MK', 'Europe/Skopje', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('361', 'BG', 'Europe/Sofia', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('362', 'SE', 'Europe/Stockholm', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('363', 'EE', 'Europe/Tallinn', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('364', 'AL', 'Europe/Tirane', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('365', 'RU', 'Europe/Ulyanovsk', '4', '4', '4');
INSERT INTO `time_zones` VALUES ('366', 'UA', 'Europe/Uzhgorod', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('367', 'LI', 'Europe/Vaduz', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('368', 'VA', 'Europe/Vatican', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('369', 'AT', 'Europe/Vienna', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('370', 'LT', 'Europe/Vilnius', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('371', 'RU', 'Europe/Volgograd', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('372', 'PL', 'Europe/Warsaw', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('373', 'HR', 'Europe/Zagreb', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('374', 'UA', 'Europe/Zaporozhye', '2', '3', '2');
INSERT INTO `time_zones` VALUES ('375', 'CH', 'Europe/Zurich', '1', '2', '1');
INSERT INTO `time_zones` VALUES ('376', 'MG', 'Indian/Antananarivo', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('377', 'IO', 'Indian/Chagos', '6', '6', '6');
INSERT INTO `time_zones` VALUES ('378', 'CX', 'Indian/Christmas', '7', '7', '7');
INSERT INTO `time_zones` VALUES ('379', 'CC', 'Indian/Cocos', '6.5', '6.5', '6.5');
INSERT INTO `time_zones` VALUES ('380', 'KM', 'Indian/Comoro', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('381', 'TF', 'Indian/Kerguelen', '5', '5', '5');
INSERT INTO `time_zones` VALUES ('382', 'SC', 'Indian/Mahe', '4', '4', '4');
INSERT INTO `time_zones` VALUES ('383', 'MV', 'Indian/Maldives', '5', '5', '5');
INSERT INTO `time_zones` VALUES ('384', 'MU', 'Indian/Mauritius', '4', '4', '4');
INSERT INTO `time_zones` VALUES ('385', 'YT', 'Indian/Mayotte', '3', '3', '3');
INSERT INTO `time_zones` VALUES ('386', 'RE', 'Indian/Reunion', '4', '4', '4');
INSERT INTO `time_zones` VALUES ('387', 'WS', 'Pacific/Apia', '14', '13', '13');
INSERT INTO `time_zones` VALUES ('388', 'NZ', 'Pacific/Auckland', '13', '12', '12');
INSERT INTO `time_zones` VALUES ('389', 'PG', 'Pacific/Bougainville', '11', '11', '11');
INSERT INTO `time_zones` VALUES ('390', 'NZ', 'Pacific/Chatham', '13.75', '12.75', '12.75');
INSERT INTO `time_zones` VALUES ('391', 'FM', 'Pacific/Chuuk', '10', '10', '10');
INSERT INTO `time_zones` VALUES ('392', 'CL', 'Pacific/Easter', '-5', '-6', '-6');
INSERT INTO `time_zones` VALUES ('393', 'VU', 'Pacific/Efate', '11', '11', '11');
INSERT INTO `time_zones` VALUES ('394', 'KI', 'Pacific/Enderbury', '13', '13', '13');
INSERT INTO `time_zones` VALUES ('395', 'TK', 'Pacific/Fakaofo', '13', '13', '13');
INSERT INTO `time_zones` VALUES ('396', 'FJ', 'Pacific/Fiji', '13', '12', '12');
INSERT INTO `time_zones` VALUES ('397', 'TV', 'Pacific/Funafuti', '12', '12', '12');
INSERT INTO `time_zones` VALUES ('398', 'EC', 'Pacific/Galapagos', '-6', '-6', '-6');
INSERT INTO `time_zones` VALUES ('399', 'PF', 'Pacific/Gambier', '-9', '-9', '-9');
INSERT INTO `time_zones` VALUES ('400', 'SB', 'Pacific/Guadalcanal', '11', '11', '11');
INSERT INTO `time_zones` VALUES ('401', 'GU', 'Pacific/Guam', '10', '10', '10');
INSERT INTO `time_zones` VALUES ('402', 'US', 'Pacific/Honolulu', '-10', '-10', '-10');
INSERT INTO `time_zones` VALUES ('403', 'KI', 'Pacific/Kiritimati', '14', '14', '14');
INSERT INTO `time_zones` VALUES ('404', 'FM', 'Pacific/Kosrae', '11', '11', '11');
INSERT INTO `time_zones` VALUES ('405', 'MH', 'Pacific/Kwajalein', '12', '12', '12');
INSERT INTO `time_zones` VALUES ('406', 'MH', 'Pacific/Majuro', '12', '12', '12');
INSERT INTO `time_zones` VALUES ('407', 'PF', 'Pacific/Marquesas', '-9.5', '-9.5', '-9.5');
INSERT INTO `time_zones` VALUES ('408', 'UM', 'Pacific/Midway', '-11', '-11', '-11');
INSERT INTO `time_zones` VALUES ('409', 'NR', 'Pacific/Nauru', '12', '12', '12');
INSERT INTO `time_zones` VALUES ('410', 'NU', 'Pacific/Niue', '-11', '-11', '-11');
INSERT INTO `time_zones` VALUES ('411', 'NF', 'Pacific/Norfolk', '11', '11', '11');
INSERT INTO `time_zones` VALUES ('412', 'NC', 'Pacific/Noumea', '11', '11', '11');
INSERT INTO `time_zones` VALUES ('413', 'AS', 'Pacific/Pago_Pago', '-11', '-11', '-11');
INSERT INTO `time_zones` VALUES ('414', 'PW', 'Pacific/Palau', '9', '9', '9');
INSERT INTO `time_zones` VALUES ('415', 'PN', 'Pacific/Pitcairn', '-8', '-8', '-8');
INSERT INTO `time_zones` VALUES ('416', 'FM', 'Pacific/Pohnpei', '11', '11', '11');
INSERT INTO `time_zones` VALUES ('417', 'PG', 'Pacific/Port_Moresby', '10', '10', '10');
INSERT INTO `time_zones` VALUES ('418', 'CK', 'Pacific/Rarotonga', '-10', '-10', '-10');
INSERT INTO `time_zones` VALUES ('419', 'MP', 'Pacific/Saipan', '10', '10', '10');
INSERT INTO `time_zones` VALUES ('420', 'PF', 'Pacific/Tahiti', '-10', '-10', '-10');
INSERT INTO `time_zones` VALUES ('421', 'KI', 'Pacific/Tarawa', '12', '12', '12');
INSERT INTO `time_zones` VALUES ('422', 'TO', 'Pacific/Tongatapu', '14', '13', '13');
INSERT INTO `time_zones` VALUES ('423', 'UM', 'Pacific/Wake', '12', '12', '12');
INSERT INTO `time_zones` VALUES ('424', 'WF', 'Pacific/Wallis', '12', '12', '12');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_type_id` int(10) unsigned DEFAULT NULL,
  `gender_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_hidden` tinyint(1) unsigned DEFAULT '0',
  `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(1) unsigned DEFAULT '0',
  `can_be_impersonated` tinyint(1) unsigned DEFAULT '1',
  `disable_comments` tinyint(1) unsigned DEFAULT '0',
  `receive_newsletter` tinyint(1) unsigned DEFAULT '1',
  `receive_advice` tinyint(1) unsigned DEFAULT '1',
  `ip_addr` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider_id` int(10) unsigned DEFAULT NULL,
  `email_token` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_token` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verified_email` tinyint(1) unsigned DEFAULT '1',
  `verified_phone` tinyint(1) unsigned DEFAULT '0',
  `blocked` tinyint(1) unsigned DEFAULT '0',
  `closed` tinyint(1) unsigned DEFAULT '0',
  `last_login_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `city` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `district` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_code` (`country_code`),
  KEY `user_type_id` (`user_type_id`),
  KEY `gender_id` (`gender_id`),
  KEY `phone` (`phone`),
  KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `verified_email` (`verified_email`),
  KEY `verified_phone` (`verified_phone`),
  KEY `is_admin` (`is_admin`),
  KEY `can_be_impersonated` (`can_be_impersonated`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'CZ', null, '1', '3', 'Admin', null, 'Administrator', null, '0', null, 'junell@xlabs.systems', '$2y$10$J8FVXdjR42AXGzOnUm3WKOmoVBQtfuLoRWEtaHWZmS3eWgHuSysU2', 'sF3U7eMs1dEKVl2xOXC1LeFc99IMYtB7rVS6285UQww2lrENhPPQL7x1wf2y', null, '1', '0', '1', '1', null, null, null, null, null, '1', '1', '0', '0', '2019-05-22 00:56:48', null, '2019-05-22 00:56:48', null, 'Prague', '');
INSERT INTO `users` VALUES ('2', 'CZ', 'en', null, null, 'ada', null, null, null, null, null, 'solehada8888@gmail.com', '$2y$10$J8FVXdjR42AXGzOnUm3WKOmoVBQtfuLoRWEtaHWZmS3eWgHuSysU2', null, '0', '1', '0', '1', '1', '185.151.174.57', null, null, null, null, '1', '1', '0', '0', '2019-05-10 03:45:30', '2019-01-08 06:58:26', '2019-05-10 03:45:30', null, '', '');
INSERT INTO `users` VALUES ('4', 'CZ', 'cs', null, null, 'ALpha De Gol3', null, null, '544654654654', '0', null, 'accountant@xlabs.systems', '$2y$10$J8FVXdjR42AXGzOnUm3WKOmoVBQtfuLoRWEtaHWZmS3eWgHuSysU2', null, '0', '1', '0', '1', '1', '37.187.143.63', null, null, null, null, '1', '1', '0', '0', '2019-05-21 08:06:20', '2019-05-03 10:57:53', '2019-05-21 08:06:20', null, '', '');
INSERT INTO `users` VALUES ('6', 'CZ', 'cs', null, null, 'aa', null, null, null, null, null, 'aa@gmail.com', '$2y$10$J8FVXdjR42AXGzOnUm3WKOmoVBQtfuLoRWEtaHWZmS3eWgHuSysU2', null, '0', '1', '0', '1', '1', '::1', null, null, null, null, '1', '1', '0', '0', '2019-05-10 03:21:30', '2019-05-10 03:19:52', '2019-05-10 03:21:30', null, '', '');

-- ----------------------------
-- Table structure for user_types
-- ----------------------------
DROP TABLE IF EXISTS `user_types`;
CREATE TABLE `user_types` (
  `id` tinyint(1) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user_types
-- ----------------------------
INSERT INTO `user_types` VALUES ('1', 'Professional', '1');
INSERT INTO `user_types` VALUES ('2', 'Individual', '1');

-- ----------------------------
-- Function structure for orthodromy
-- ----------------------------
DROP FUNCTION IF EXISTS `orthodromy`;
DELIMITER ;;
CREATE DEFINER=`tuttyman.growapp`@`localhost` FUNCTION `orthodromy`(`lat1` FLOAT, `lon1` FLOAT, `lat2` FLOAT, `lon2` FLOAT) RETURNS float
    NO SQL
    DETERMINISTIC
    COMMENT 'Returns the distance in degrees on the Earth between two known points of latitude and longitude. To get km, multiply by 6371, and miles by 3959'
BEGIN
	DECLARE r FLOAT unsigned DEFAULT 6371;
	DECLARE lonDiff FLOAT unsigned;
	DECLARE a FLOAT unsigned;
	DECLARE c FLOAT unsigned;
 
	SET lonDiff = RADIANS(lon2 - lon1);
	SET lat1 = RADIANS(lat1);
	SET lat2 = RADIANS(lat2);
	
	SET c = ACOS((COS(lat1) * COS(lat2) * COS(lonDiff)) + (SIN(lat1) * SIN(lat2)));
 
	RETURN (r * c);
END
;;
DELIMITER ;
