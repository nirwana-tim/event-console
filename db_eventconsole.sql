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
  status ENUM('approved') NOT NULL DEFAULT 'approved',
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
-- email    : user2@gmail.com
-- password : password
--
-- email    : user3@gmail.com
-- password : password
-- =========================================================

INSERT INTO users (id, name, email, password, role, created_at) VALUES
(1, 'System Administrator', 'admin@gmail.com', '$2y$10$cK2B54oTSg1CyBhTm0ymdeb/o4dF9kmldtKoBgHzCEtpyn4UxQnJS', 'admin', '2026-05-24 14:09:51'),
(2, 'user2', 'user2@gmail.com', '$2y$10$cK2B54oTSg1CyBhTm0ymdeb/o4dF9kmldtKoBgHzCEtpyn4UxQnJS', 'participant', '2026-05-24 14:19:23'),
(3, 'user3', 'user3@gmail.com', '$2y$10$cK2B54oTSg1CyBhTm0ymdeb/o4dF9kmldtKoBgHzCEtpyn4UxQnJS', 'participant', '2026-05-24 14:20:23');

-- =========================================================
-- Initial event data
-- Banner files use images available in uploads/banner
-- =========================================================

INSERT INTO events (id, user_id, name, description, date, start_time, end_time, location, quota, banner, status, created_at) VALUES
(1, 1, 'UI UX Short Class', 'Kelas singkat untuk memahami proses riset, wireframe, dan desain antarmuka aplikasi.', '2026-06-10', '09:00:00', '12:00:00', 'Auditorium Horizon University', 40, '135d52967eb3b62f0d7c3ccacaab0582.png', 'dibuka', '2026-06-01 08:00:00'),
(2, 1, 'Data Analytics Fundamental', 'Belajar dasar analisis data, visualisasi, dan pengambilan keputusan berbasis data.', '2026-06-12', '13:00:00', '16:00:00', 'Lab Komputer A', 35, '2c1100e829cbee00a3f0233674051a57.png', 'dibuka', '2026-06-01 08:10:00'),
(3, 1, 'Career Preparation Workshop', 'Workshop persiapan karir mulai dari CV, portfolio, interview, sampai personal branding.', '2026-06-14', '10:00:00', '14:00:00', 'Ruang Seminar Utama', 50, 'aa1014ce87c99f72e5b043cea086c63b.jpeg', 'dibuka', '2026-06-01 08:20:00'),
(4, 1, 'Web Development Bootcamp', 'Pelatihan membuat aplikasi web sederhana menggunakan HTML, CSS, PHP, dan database.', '2026-06-16', '09:00:00', '15:00:00', 'Lab Programming 1', 30, 'c3efa821f3a46706b49d236357ff5863.png', 'dibuka', '2026-06-01 08:30:00'),
(5, 1, 'Public Speaking Clinic', 'Sesi praktik berbicara di depan umum untuk presentasi akademik dan profesional.', '2026-06-18', '08:30:00', '11:30:00', 'Ruang Teater Mini', 45, '135d52967eb3b62f0d7c3ccacaab0582.png', 'dibuka', '2026-06-01 08:40:00'),
(6, 1, 'Digital Marketing Strategy', 'Membahas strategi konten, media sosial, campaign planning, dan evaluasi performa marketing.', '2026-06-20', '13:00:00', '16:30:00', 'Creative Hub', 60, '2c1100e829cbee00a3f0233674051a57.png', 'ditutup', '2026-06-01 08:50:00'),
(7, 1, 'Cyber Security Awareness', 'Pengenalan keamanan digital, password hygiene, phishing, dan perlindungan data pribadi.', '2026-06-22', '10:00:00', '12:00:00', 'Lab Network', 35, 'aa1014ce87c99f72e5b043cea086c63b.jpeg', 'dibuka', '2026-06-01 09:00:00'),
(8, 1, 'Mobile App Introduction', 'Pengenalan konsep aplikasi mobile, UI mobile, dan struktur project aplikasi sederhana.', '2026-06-24', '09:00:00', '13:00:00', 'Lab Mobile', 32, 'c3efa821f3a46706b49d236357ff5863.png', 'dibuka', '2026-06-01 09:10:00'),
(9, 1, 'Entrepreneurship Talk', 'Diskusi membangun ide bisnis, validasi pasar, dan strategi awal menjalankan usaha.', '2026-06-26', '14:00:00', '16:00:00', 'Aula Gedung B', 80, '135d52967eb3b62f0d7c3ccacaab0582.png', 'selesai', '2026-06-01 09:20:00'),
(10, 1, 'Cloud Computing Basic', 'Mengenal layanan cloud, deployment sederhana, dan konsep server modern.', '2026-06-28', '10:00:00', '13:00:00', 'Lab Cloud', 30, '2c1100e829cbee00a3f0233674051a57.png', 'dibuka', '2026-06-01 09:30:00'),
(11, 1, 'Database Design Practice', 'Latihan membuat ERD, relasi tabel, normalisasi, dan query SQL dasar.', '2026-06-30', '09:00:00', '12:30:00', 'Lab Database', 36, 'aa1014ce87c99f72e5b043cea086c63b.jpeg', 'dibuka', '2026-06-01 09:40:00'),
(12, 1, 'Graphic Design Mini Class', 'Kelas desain visual untuk poster event, layout, warna, dan tipografi dasar.', '2026-07-02', '13:00:00', '15:30:00', 'Studio Multimedia', 28, 'c3efa821f3a46706b49d236357ff5863.png', 'ditutup', '2026-06-01 09:50:00'),
(13, 1, 'Project Management Basic', 'Mengenal timeline, pembagian tugas, monitoring progress, dan evaluasi project.', '2026-07-04', '09:30:00', '12:00:00', 'Ruang Meeting 2', 40, '135d52967eb3b62f0d7c3ccacaab0582.png', 'dibuka', '2026-06-01 10:00:00'),
(14, 1, 'Artificial Intelligence Seminar', 'Seminar pengenalan AI, contoh penerapan, dan dampaknya pada dunia kerja.', '2026-07-06', '10:00:00', '13:00:00', 'Grand Hall', 100, '2c1100e829cbee00a3f0233674051a57.png', 'dibuka', '2026-06-01 10:10:00'),
(15, 1, 'Content Creator Workshop', 'Workshop membuat ide konten, script singkat, editing dasar, dan publikasi konten.', '2026-07-08', '13:00:00', '17:00:00', 'Creative Studio', 45, 'aa1014ce87c99f72e5b043cea086c63b.jpeg', 'selesai', '2026-06-01 10:20:00');

-- =========================================================
-- Initial registration data
-- Registrations are automatically approved.
-- Attendance is managed by admin.
-- =========================================================

INSERT INTO registrations (id, user_id, event_id, status, attendance, phone_number, institution, address, team, notes, created_at) VALUES
(1, 2, 1, 'approved', 'present', '081200000001', 'Horizon University', 'Jl. Merdeka No. 1', 'Alpha Team', 'Peserta hadir dan berhak mendapat sertifikat.', '2026-06-02 09:00:00'),
(2, 3, 1, 'approved', 'unconfirmed', '081200000002', 'Horizon University', 'Jl. Merdeka No. 2', 'Beta Team', 'Menunggu konfirmasi kehadiran.', '2026-06-02 09:10:00'),
(3, 2, 2, 'approved', 'absent', '081200000003', 'Horizon University', 'Jl. Merdeka No. 1', 'Data Team', 'Peserta tidak hadir.', '2026-06-02 09:20:00'),
(4, 3, 3, 'approved', 'present', '081200000004', 'Horizon University', 'Jl. Merdeka No. 2', 'Career Team', 'Peserta hadir dan berhak mendapat sertifikat.', '2026-06-02 09:30:00'),
(5, 2, 4, 'approved', 'unconfirmed', '081200000005', 'Horizon University', 'Jl. Merdeka No. 1', 'Web Team', 'Menunggu konfirmasi kehadiran.', '2026-06-02 09:40:00'),
(6, 3, 5, 'approved', 'present', '081200000006', 'Horizon University', 'Jl. Merdeka No. 2', 'Speaker Team', 'Peserta hadir dan berhak mendapat sertifikat.', '2026-06-02 09:50:00'),
(7, 2, 7, 'approved', 'absent', '081200000007', 'Horizon University', 'Jl. Merdeka No. 1', 'Security Team', 'Peserta tidak hadir.', '2026-06-02 10:00:00'),
(8, 3, 8, 'approved', 'unconfirmed', '081200000008', 'Horizon University', 'Jl. Merdeka No. 2', 'Mobile Team', 'Menunggu konfirmasi kehadiran.', '2026-06-02 10:10:00'),
(9, 2, 10, 'approved', 'present', '081200000009', 'Horizon University', 'Jl. Merdeka No. 1', 'Cloud Team', 'Peserta hadir dan berhak mendapat sertifikat.', '2026-06-02 10:20:00'),
(10, 3, 11, 'approved', 'unconfirmed', '081200000010', 'Horizon University', 'Jl. Merdeka No. 2', 'Database Team', 'Menunggu konfirmasi kehadiran.', '2026-06-02 10:30:00');

INSERT INTO certificates (id, registration_id, certificate_number, certificate_file, verification_code, created_at) VALUES
(1, 1, 'SRT-1-20260602090000', 'SRT-1-20260602090000.pdf', 'VERIFY-SRT-1-20260602090000', '2026-06-02 09:00:00'),
(2, 4, 'SRT-4-20260602093000', 'SRT-4-20260602093000.pdf', 'VERIFY-SRT-4-20260602093000', '2026-06-02 09:30:00'),
(3, 6, 'SRT-6-20260602095000', 'SRT-6-20260602095000.pdf', 'VERIFY-SRT-6-20260602095000', '2026-06-02 09:50:00'),
(4, 9, 'SRT-9-20260602102000', 'SRT-9-20260602102000.pdf', 'VERIFY-SRT-9-20260602102000', '2026-06-02 10:20:00');

-- =========================================================
-- Sample query to check participants eligible for certificates
-- =========================================================
--
-- SELECT
--   r.id AS registration_id,
--   u.name,
--   e.name AS event_name,
--   r.attendance
-- FROM registrations r
-- JOIN users u ON r.user_id = u.id
-- JOIN events e ON r.event_id = e.id
-- WHERE r.attendance = 'present';
--
-- =========================================================
-- Done
-- =========================================================
