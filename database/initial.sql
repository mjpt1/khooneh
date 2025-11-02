-- BuildingChargeManager - Database Schema
-- Author: محسن جبار اصل - mahsen81.ir
-- Version: final-production
-- https://github.com/mahseng/BuildingChargeManager

-- Set character set and collation for the database.
-- The database should be created with `utf8mb4` charset and `utf8mb4_persian_ci` collation.
-- Example: CREATE DATABASE `building_charge_manager` CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci;

SET NAMES utf8mb4;
SET time_zone = '+03:30';
SET foreign_key_checks = 0;

--
-- Table structure for table `buildings`
--
DROP TABLE IF EXISTS `buildings`;
CREATE TABLE `buildings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `address` TEXT,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Table structure for table `units`
--
DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` INT UNSIGNED NOT NULL,
  `block` VARCHAR(50) DEFAULT NULL,
  `floor` SMALLINT NOT NULL,
  `number` VARCHAR(50) NOT NULL,
  `area` DECIMAL(8,2) NOT NULL COMMENT 'in square meters',
  `people_count` TINYINT UNSIGNED DEFAULT 1,
  `owner_name` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Table structure for table `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `unit_id` INT UNSIGNED DEFAULT NULL,
  `username` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'manager', 'resident', 'pending') NOT NULL DEFAULT 'pending',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Table structure for table `charges`
--
DROP TABLE IF EXISTS `charges`;
CREATE TABLE `charges` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `charge_month` DATE NOT NULL,
  `due_date` DATE NOT NULL,
  `generation_method` ENUM('fixed', 'by_area', 'by_people') NOT NULL,
  `total_amount` DECIMAL(12,2) NOT NULL,
  `created_by` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Table structure for table `charge_items` (invoice for each unit)
--
DROP TABLE IF EXISTS `charge_items`;
CREATE TABLE `charge_items` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `charge_id` INT UNSIGNED NOT NULL,
  `unit_id` INT UNSIGNED NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `status` ENUM('paid', 'unpaid') NOT NULL DEFAULT 'unpaid',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`charge_id`) REFERENCES `charges` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Table structure for table `payments`
--
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `charge_item_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `payment_method` ENUM('online', 'manual') NOT NULL,
  `transaction_ref` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('completed', 'pending', 'failed') NOT NULL DEFAULT 'pending',
  `paid_at` TIMESTAMP NOT NULL,
  `verified_by` INT UNSIGNED DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`charge_item_id`) REFERENCES `charge_items` (`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Table structure for table `tickets`
--
DROP TABLE IF EXISTS `tickets`;
CREATE TABLE `tickets` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `status` ENUM('open', 'in_progress', 'closed') NOT NULL DEFAULT 'open',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Table structure for table `attachments` (for tickets, messages, etc.)
--
DROP TABLE IF EXISTS `attachments`;
CREATE TABLE `attachments` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `attachable_id` INT UNSIGNED NOT NULL,
  `attachable_type` VARCHAR(50) NOT NULL COMMENT 'e.g., ticket, message',
  `file_path` VARCHAR(255) NOT NULL,
  `original_filename` VARCHAR(255) NOT NULL,
  `mime_type` VARCHAR(100) NOT NULL,
  `uploaded_by` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `attachable` (`attachable_id`,`attachable_type`),
  FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Table structure for table `building_rules`
--
DROP TABLE IF EXISTS `building_rules`;
CREATE TABLE `building_rules` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `created_by` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Table structure for table `messages` (chat)
--
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `sender_id` INT UNSIGNED NOT NULL,
  `receiver_id` INT UNSIGNED DEFAULT NULL COMMENT 'NULL for public/group messages',
  `content` TEXT NOT NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Table structure for table `polls`
--
DROP TABLE IF EXISTS `polls`;
CREATE TABLE `polls` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `question` TEXT NOT NULL,
  `options` JSON NOT NULL,
  `created_by` INT UNSIGNED NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Table structure for table `poll_votes`
--
DROP TABLE IF EXISTS `poll_votes`;
CREATE TABLE `poll_votes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `poll_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `vote_option` INT NOT NULL COMMENT 'Index of the selected option in the poll''s JSON array',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `poll_user_vote` (`poll_id`, `user_id`),
  FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Table structure for table `settings` (key-value store)
--
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_key` VARCHAR(100) NOT NULL,
  `setting_value` TEXT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Table structure for table `news`
--
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `created_by` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

SET foreign_key_checks = 1;
