-- Select the database
USE database_1;

-- Insert version
UPDATE `table_version` SET `version`=4 WHERE `version`=3;

-- Add width and height to surveys
ALTER TABLE `surveys` ADD `width` DECIMAL(5,2) NOT NULL DEFAULT '50.00';
ALTER TABLE `surveys` ADD `height` DECIMAL(5,2) NOT NULL DEFAULT '50.00';