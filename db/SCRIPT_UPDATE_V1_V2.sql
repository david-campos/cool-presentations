-- Select the database
USE database_1;

-- VERSION TABLE
-- Used to store the version of the database so
-- the code can use it to check the version is the right
-- one.
CREATE TABLE IF NOT EXISTS `table_version` (
    `version` INT UNSIGNED NOT NULL PRIMARY KEY
);
-- Insert version
INSERT INTO `table_version`(`version`) VALUES (2);

-- Add name to the presentations
ALTER TABLE `presentations` ADD `name` VARCHAR(100) NOT NULL;