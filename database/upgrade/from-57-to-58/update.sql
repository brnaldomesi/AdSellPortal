-- posts
ALTER TABLE `<<prefix>>posts` ADD `street_name` varchar(255) NULL AFTER `archived_at`;
ALTER TABLE `<<prefix>>posts` ADD `house_number` varchar(255) NULL AFTER `street_name`;
ALTER TABLE `<<prefix>>posts` ADD `orientational_number` varchar(255) NULL AFTER `house_number`;
ALTER TABLE `<<prefix>>posts` ADD `town_district` varchar(255) NULL AFTER `orientational_number`;
ALTER TABLE `<<prefix>>posts` ADD `town_name` varchar(255) NULL AFTER `town_district`;
ALTER TABLE `<<prefix>>posts` ADD `zip_code` varchar(255) NULL AFTER `town_name`;


