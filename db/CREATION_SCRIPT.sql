-- Creation script for the project database
--	This script should create the database and the tables
--	corresponding to the database design in the version
-- 	specified bellow.
--  
-- 	Author: David Campos Rodríguez <david.campos.r96@gmail.com>

/*******************************************************************************
 * DATABASE VERSION = 1
 * 
 * NOT IMPLEMENTED:
 * 	Multiplicity of the relation "answers" on the side of SurveyAnswers (2..*)
 *******************************************************************************/

-- DATABASE CREATION AND SELECTION
-- The name of the database will be database_version
CREATE DATABASE IF NOT EXISTS  `database_1`;
-- We select the database we've just created
USE database_1;

-- TABLES CREATION
-- Users table
-- It stores the information about the users of our system, this users
-- can upload presentations
-- NOTE: password and salt are likely to be removed in future versions
-- and be replaced with some kind of login with an external system
CREATE TABLE IF NOT EXISTS `users` (
	`user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_name` VARCHAR(100) NOT NULL,
	`password` CHAR(128) NOT NULL,
	`salt` CHAR(128) NOT NULL,
	
	PRIMARY KEY (`user_id`)
);

-- Presentations table
-- It stores the information relative to the presentations in the system
CREATE TABLE IF NOT EXISTS `presentations` (
	`id_code` CHAR(128) NOT NULL,
	`start_timestamp` TIMESTAMP NOT NULL,
	`end_timestamp` TIMESTAMP, -- NULLABLE
	`location_lat` DECIMAL(8,6), -- NULLABLE
	`location_lon` DECIMAL(9,6), -- NULLABLE
	`access_code` CHAR(128) DEFAULT NULL, -- NULLABLE
	
	`user_id` INT UNSIGNED NOT NULL,
	
	PRIMARY KEY (`id_code`),
	
	FOREIGN KEY (`user_id`)
		REFERENCES `users`(`user_id`)
		ON UPDATE CASCADE
		ON DELETE RESTRICT -- Avoid erasing by mistake?
);

-- Surveys table
-- It stores information about the surveys that the user can place
-- in his presentations
CREATE TABLE IF NOT EXISTS `surveys` (
	`page` INT UNSIGNED NOT NULL,
	`question` VARCHAR(255) NOT NULL,
	`positionX` DECIMAL(5,2) NOT NULL DEFAULT '50.00',
	`positionY` DECIMAL(5,2) NOT NULL DEFAULT '50.00',
	`open` TINYINT NOT NULL DEFAULT 1,
	`multiple_choice` TINYINT NOT NULL,
	
	`presentation_code` CHAR(128) NOT NULL,
	
	PRIMARY KEY(`presentation_code`, `page`),
	
	FOREIGN KEY (`presentation_code`)
		REFERENCES `presentations`(`id_code`)
		ON UPDATE CASCADE
		ON DELETE RESTRICT
);

-- SurveyAnswers table
-- It stores information about the possible answers for the surveys registered
-- on the surveys table
CREATE TABLE IF NOT EXISTS `survey_answers` (
	`answer_num` TINYINT UNSIGNED NOT NULL,
	`answer_text` VARCHAR(255) NOT NULL,
	`votes` INT NOT NULL DEFAULT 0,
	
	`presentation` CHAR(128) NOT NULL,
	`survey_page` INT UNSIGNED NOT NULL,
	
	PRIMARY KEY(`presentation`, `survey_page`, `answer_num`),
	
	FOREIGN KEY (`presentation`, `survey_page`)
		REFERENCES `surveys` (`presentation_code`, `page`)
		ON UPDATE CASCADE
		ON DELETE RESTRICT
);