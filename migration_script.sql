-- ----------------------------------------------------------------------------
-- MySQL Workbench Migration
-- Migrated Schemata: state_bonus
-- Source Schemata: state_bonus
-- Created: Wed Apr 13 20:51:03 2022
-- Workbench Version: 8.0.28
-- ----------------------------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------------------------------------------------------
-- Schema state_bonus
-- ----------------------------------------------------------------------------
DROP SCHEMA IF EXISTS `state_bonus` ;
CREATE SCHEMA IF NOT EXISTS `state_bonus` ;

-- ----------------------------------------------------------------------------
-- Table state_bonus.bonus_list
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `state_bonus`.`bonus_list` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `type_id` INT(10) UNSIGNED NOT NULL,
  `quantity` INT(10) UNSIGNED NOT NULL,
  `sold_at` DATE NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_sold_unique` (`name` ASC, `sold_at` ASC) VISIBLE,
  INDEX `bonus_type_fk` (`type_id` ASC) VISIBLE,
  CONSTRAINT `bonus_type_fk`
    FOREIGN KEY (`type_id`)
    REFERENCES `state_bonus`.`bonus_type` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 34
DEFAULT CHARACTER SET = utf8mb4;

-- ----------------------------------------------------------------------------
-- Table state_bonus.bonus_type
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `state_bonus`.`bonus_type` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(255) NOT NULL,
  `saved_minutes` INT(10) UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  UNIQUE INDEX `type_unique_k` (`type` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8mb4;
SET FOREIGN_KEY_CHECKS = 1;
