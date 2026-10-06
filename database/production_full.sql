-- ============================================================
-- moshmok — FULL PRODUCTION DATABASE
-- Professional Financial & Training Solutions
-- Combine of schema.sql + lead_system_migration.sql
-- Run this ONCE on a fresh server database.
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE IF NOT EXISTS `moshmok_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `moshmok_db`;

-- ─────────────────────────────────────────────────────────────
-- CORE TABLES (from schema.sql)
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `csrf_tokens` (
  `id`         INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
  `token`      VARCHAR(64)   NOT NULL UNIQUE,
  `created_at` TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` TIMESTAMP     NULL DEFAULT NULL,
  INDEX `idx_csrf_token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `bookings` (
  `id`               INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
  `name`             VARCHAR(150)  NOT NULL,
  `email`            VARCHAR(255)  NOT NULL,
  `phone`            VARCHAR(30)   NOT NULL DEFAULT '',
  `service_type`     VARCHAR(100)  NOT NULL DEFAULT '',
  `preferred_date`   DATE          DEFAULT NULL,
  `preferred_time`   TIME          DEFAULT NULL,
  `message`          TEXT          DEFAULT NULL,
  `status`           ENUM('pending','confirmed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at`       TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_booking_email`  (`email`),
  INDEX `idx_booking_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `document_uploads` (
  `id`             INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
  `name`           VARCHAR(150)  NOT NULL,
  `email`          VARCHAR(255)  NOT NULL,
  `notes`          TEXT          DEFAULT NULL,
  `fee_status`     ENUM('pending','paid','waived','refunded') NOT NULL DEFAULT 'pending',
  `created_at`     TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_upload_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `document_files` (
  `id`          INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
  `upload_id`   INT UNSIGNED  NOT NULL,
  `original_name` VARCHAR(255) NOT NULL,
  `stored_name`   VARCHAR(255) NOT NULL,
  `mime_type`     VARCHAR(100) NOT NULL DEFAULT '',
  `file_size`     INT UNSIGNED NOT NULL DEFAULT 0,
  `created_at`    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_files_upload` FOREIGN KEY (`upload_id`) REFERENCES `document_uploads` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `training_signups` (
  `id`          INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
  `first_name`  VARCHAR(75)   NOT NULL,
  `last_name`   VARCHAR(75)   NOT NULL,
  `email`       VARCHAR(255)  NOT NULL,
  `phone`       VARCHAR(30)   NOT NULL DEFAULT '',
  `company`     VARCHAR(150)  NOT NULL DEFAULT '',
  `designation` VARCHAR(100)  NOT NULL DEFAULT '',
  `course`      VARCHAR(100)  NOT NULL DEFAULT '',
  `attendees`   TINYINT       NOT NULL DEFAULT 1,
  `message`     TEXT          DEFAULT NULL,
  `status`      ENUM('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending',
  `created_at`  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_training_email`  (`email`),
  INDEX `idx_training_course` (`course`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id`          INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
  `name`        VARCHAR(150)  NOT NULL,
  `email`       VARCHAR(255)  NOT NULL,
  `phone`       VARCHAR(30)   NOT NULL DEFAULT '',
  `service`     VARCHAR(100)  NOT NULL DEFAULT '',
  `message`     TEXT          DEFAULT NULL,
  `consent`     TINYINT(1)    NOT NULL DEFAULT 0,
  `read_status` ENUM('unread','read') NOT NULL DEFAULT 'unread',
  `created_at`  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_contact_email`  (`email`),
  INDEX `idx_contact_status` (`read_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ─────────────────────────────────────────────────────────────
-- LEAD CONVERTER & FOLLOW-UP SYSTEM TABLES
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id`            INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
  `username`      VARCHAR(50)   NOT NULL UNIQUE,
  `password_hash` VARCHAR(255)  NOT NULL,
  `full_name`     VARCHAR(100)  NOT NULL,
  `role`          ENUM('admin','staff') NOT NULL DEFAULT 'staff',
  `created_at`    TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `leads` (
  `id`                 INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
  `source_type`        ENUM('booking','training','contact','upload','manual') NOT NULL,
  `source_id`          INT UNSIGNED  DEFAULT NULL,
  `full_name`          VARCHAR(150)  NOT NULL,
  `email`              VARCHAR(255)  NOT NULL,
  `phone`              VARCHAR(30)   NOT NULL DEFAULT '',
  `service_interest`   VARCHAR(100)  NOT NULL DEFAULT '',
  `status`             ENUM('new','contacted','qualified','converted','lost') NOT NULL DEFAULT 'new',
  `score`              TINYINT       NOT NULL DEFAULT 0,
  `assigned_to`        INT UNSIGNED  DEFAULT NULL,
  `last_contacted_at`  TIMESTAMP     NULL DEFAULT NULL,
  `next_follow_up_at`  TIMESTAMP     NULL DEFAULT NULL,
  `created_at`         TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`         TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_lead_email`          (`email`),
  INDEX `idx_lead_status`         (`status`),
  INDEX `idx_lead_source`         (`source_type`, `source_id`),
  INDEX `idx_lead_next_follow_up` (`next_follow_up_at`),
  INDEX `idx_lead_created`        (`created_at`),
  CONSTRAINT `fk_leads_assigned` FOREIGN KEY (`assigned_to`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `lead_follow_ups` (
  `id`            INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
  `lead_id`       INT UNSIGNED  NOT NULL,
  `type`          ENUM('auto_email','manual_email','call','note') NOT NULL DEFAULT 'auto_email',
  `template_key`  VARCHAR(50)   NOT NULL DEFAULT '',
  `scheduled_for` TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status`        ENUM('pending','sent','failed','cancelled') NOT NULL DEFAULT 'pending',
  `sent_at`       TIMESTAMP     NULL DEFAULT NULL,
  `error_message` TEXT          DEFAULT NULL,
  `created_by`    INT UNSIGNED  DEFAULT NULL,
  `created_at`    TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_followup_status_scheduled` (`status`, `scheduled_for`),
  INDEX `idx_followup_lead`             (`lead_id`),
  CONSTRAINT `fk_followup_lead`  FOREIGN KEY (`lead_id`)    REFERENCES `leads` (`id`)       ON DELETE CASCADE,
  CONSTRAINT `fk_followup_admin` FOREIGN KEY (`created_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `lead_notes` (
  `id`          INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
  `lead_id`     INT UNSIGNED  NOT NULL,
  `author_id`   INT UNSIGNED  DEFAULT NULL,
  `author_name` VARCHAR(100)  NOT NULL DEFAULT '',
  `note`        TEXT          NOT NULL,
  `created_at`  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_notes_lead` (`lead_id`),
  CONSTRAINT `fk_notes_lead`  FOREIGN KEY (`lead_id`)   REFERENCES `leads` (`id`)       ON DELETE CASCADE,
  CONSTRAINT `fk_notes_admin` FOREIGN KEY (`author_id`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ─────────────────────────────────────────────────────────────
-- DEFAULT ADMIN SEED (change password immediately after deploy)
-- Username: admin | Password: Admin@2026!
-- ─────────────────────────────────────────────────────────────
INSERT INTO `admin_users` (`username`, `password_hash`, `full_name`, `role`)
SELECT 'admin', '$2y$10$vsE/D.ZSYb.izesi.ZlWP./el6pL6hfq1ciYHFVGE.9xZb5NjGjHu', 'Practice Administrator', 'admin'
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `admin_users` WHERE `username` = 'admin');

SET FOREIGN_KEY_CHECKS = 1;
