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
  PRIMARY KEY (id)
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
-- Table payments
-- Stores participant payment proof
-- =========================================================

CREATE TABLE payments (
  id INT NOT NULL AUTO_INCREMENT,
  registration_id INT NOT NULL,
  payment_proof VARCHAR(255) DEFAULT NULL,
  status ENUM('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY registration_id (registration_id),
  CONSTRAINT fk_payments_registration
    FOREIGN KEY (registration_id) REFERENCES registrations (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT unique_payments_registration
    UNIQUE (registration_id)
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
(1, 'Administrator', 'admin@gmail.com', '$2a$12$ib2JdXUubQrYTm1HzZ9vcuFYsCnNYdPJOSgAvka9UY8D5zpOqOJHW', 'admin', '2026-05-24 14:09:51'),
(2, 'user', 'user@gmail.com', '$2a$12$R9DQ5rqF/2Gjvg/S33emc.YLgnImPZ5gPmRSx3QTOuhuZwe3qaeOG', 'participant', '2026-05-24 14:19:23');

-- =========================================================
-- Sample events data
-- =========================================================

INSERT INTO events
(id, name, description, date, start_time, end_time, location, quota, banner, status, created_at)
VALUES
(1, 'Digital Technology Seminar', 'A seminar event about digital technology development and its use in the workplace.', '2026-05-30', '09:00:00', '12:00:00', 'Campus Hall', 100, 'banner_event_1.png', 'selesai', '2026-05-27 01:51:44'),
(2, 'Workshop Web Development', 'Workshop dasar pembuatan aplikasi web sederhana menggunakan database dan framework.', '2026-06-15', '13:00:00', '16:00:00', 'Laboratorium Komputer', 50, 'banner_event_2.png', 'dibuka', '2026-05-27 11:08:54');

-- =========================================================
-- Sample registrations data
-- =========================================================

INSERT INTO registrations
(id, user_id, event_id, status, attendance, phone_number, institution, address, team, notes, created_at)
VALUES
(1, 2, 1, 'approved', 'present', '081234567890', 'Example University', 'Tangerang', 'Team A', 'Participant arrived on time', '2026-05-27 02:06:59'),
(2, 2, 2, 'pending', 'unconfirmed', '08123456789', 'Example University', 'Tangerang', NULL, 'Waiting for payment verification', '2026-05-27 11:10:15');

-- =========================================================
-- Sample payments data
-- =========================================================

INSERT INTO payments
(id, registration_id, payment_proof, status, created_at)
VALUES
(1, 1, 'bukti_bayar_1.png', 'verified', '2026-05-27 02:07:30'),
(2, 2, 'bukti_bayar_2.jpeg', 'pending', '2026-05-27 11:10:47');

-- =========================================================
-- Sample certificates data
-- =========================================================

INSERT INTO certificates
(id, registration_id, certificate_number, certificate_file, verification_code, created_at)
VALUES
(1, 1, 'SRT-1-20260527020952', 'SRT-1-20260527020952.pdf', 'VERIFY-SRT-1-20260527020952', '2026-05-27 02:09:52');

-- =========================================================
-- Sample query to check participants eligible for certificates
-- =========================================================
--
-- SELECT
--   r.id AS registration_id,
--   u.name,
--   e.name AS event_name,
--   r.status AS registration_status,
--   p.status AS payment_status,
--   r.attendance
-- FROM registrations r
-- JOIN users u ON r.user_id = u.id
-- JOIN events e ON r.event_id = e.id
-- JOIN payments p ON p.registration_id = r.id
-- WHERE r.status = 'approved'
--   AND p.status = 'verified'
--   AND r.attendance = 'present';
--
-- =========================================================
-- Done
-- =========================================================
