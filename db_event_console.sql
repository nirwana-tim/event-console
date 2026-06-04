-- =========================================================
-- Database: db_eventconsole
-- Application: Simple Online Event & Certificate Management
-- New English schema version
-- =========================================================

DROP DATABASE IF EXISTS db_eventconsole;
CREATE DATABASE db_eventconsole
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE db_eventconsole;

-- =========================================================
-- Table users
-- Stores admin and participant account data
-- =========================================================

CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','participant') NOT NULL DEFAULT 'participant',
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Table events
-- Stores event data created by admins
-- =========================================================

CREATE TABLE events (
  id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL DEFAULT 1,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  date DATE NOT NULL,
  start_time TIME NULL,
  end_time TIME NULL,
  location VARCHAR(150) DEFAULT NULL,
  quota INT DEFAULT NULL,
  banner VARCHAR(255) DEFAULT NULL,
  status ENUM('dibuka','ditutup','selesai') NOT NULL DEFAULT 'dibuka',
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  CONSTRAINT fk_events_user
    FOREIGN KEY (user_id) REFERENCES users (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Table registrations
-- Stores participant registration data for events
-- =========================================================

CREATE TABLE registrations (
  id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  event_id INT NOT NULL,
  status ENUM('pending','approved') NOT NULL DEFAULT 'pending',
  attendance ENUM('unconfirmed','present','absent') NOT NULL DEFAULT 'unconfirmed',
  phone_number VARCHAR(20) DEFAULT NULL,
  institution VARCHAR(100) DEFAULT NULL,
  address TEXT,
  team VARCHAR(100) DEFAULT NULL,
  notes TEXT,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  KEY event_id (event_id),
  CONSTRAINT fk_registrations_user
    FOREIGN KEY (user_id) REFERENCES users (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_registrations_event
    FOREIGN KEY (event_id) REFERENCES events (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT unique_user_event
    UNIQUE (user_id, event_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =========================================================
-- Table certificates
-- Stores participant certificate data
-- =========================================================

CREATE TABLE certificates (
  id INT NOT NULL AUTO_INCREMENT,
  registration_id INT NOT NULL,
  certificate_number VARCHAR(100) NOT NULL,
  certificate_file VARCHAR(255) DEFAULT NULL,
  verification_code VARCHAR(100) DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY registration_id (registration_id),
  UNIQUE KEY certificate_number (certificate_number),
  UNIQUE KEY verification_code (verification_code),
  CONSTRAINT fk_certificates_registration
    FOREIGN KEY (registration_id) REFERENCES registrations (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT unique_certificates_registration
    UNIQUE (registration_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Initial users data
-- Admin login:
-- email    : admin@gmail.com
-- password : password
--
-- Participant login:
-- email    : user@gmail.com
-- password : password
-- =========================================================

INSERT INTO users (id, name, email, password, role, created_at) VALUES
(1, 'Administrator', 'admin@gmail.com', '$2y$10$cK2B54oTSg1CyBhTm0ymdeb/o4dF9kmldtKoBgHzCEtpyn4UxQnJS', 'admin', '2026-05-24 14:09:51'),
(2, 'user1', 'user1@gmail.com', '$2y$10$cK2B54oTSg1CyBhTm0ymdeb/o4dF9kmldtKoBgHzCEtpyn4UxQnJS', 'participant', '2026-05-24 14:19:23');


-- =========================================================
-- Sample query to check participants eligible for certificates
-- =========================================================
--
-- SELECT
--   r.id AS registration_id,
--   u.name,
--   e.name AS event_name,
--   r.status AS registration_status,
--   r.attendance
-- FROM registrations r
-- JOIN users u ON r.user_id = u.id
-- JOIN events e ON r.event_id = e.id
-- WHERE r.status = 'approved'
--   AND r.attendance = 'present';
--
-- =========================================================
-- Done
-- =========================================================
