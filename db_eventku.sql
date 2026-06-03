-- =========================================================
-- Database: db_eventku
-- Aplikasi: Management Event & Sertifikat Online Sederhana
-- Versi schema baru disesuaikan dari database sebelumnya
-- =========================================================

DROP DATABASE IF EXISTS db_eventconsole;
CREATE DATABASE db_eventconsole
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE db_eventconsole;

-- =========================================================
-- Tabel users
-- Menyimpan data akun admin dan peserta
-- =========================================================

CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','peserta') NOT NULL DEFAULT 'peserta',
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Tabel events
-- Menyimpan data event yang dibuat oleh admin
-- =========================================================

CREATE TABLE events (
  id INT NOT NULL AUTO_INCREMENT,
  nama_event VARCHAR(150) NOT NULL,
  deskripsi TEXT,
  tanggal DATE NOT NULL,
  waktu_mulai TIME NULL,
  waktu_selesai TIME NULL,
  lokasi VARCHAR(150) DEFAULT NULL,
  kuota INT DEFAULT NULL,
  banner VARCHAR(255) DEFAULT NULL,
  status ENUM('dibuka','ditutup','selesai') NOT NULL DEFAULT 'dibuka',
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Tabel pendaftaran
-- Menyimpan data pendaftaran peserta ke event
-- =========================================================

CREATE TABLE pendaftaran (
  id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  event_id INT NOT NULL,
  status ENUM('pending','approved') NOT NULL DEFAULT 'pending',
  kehadiran ENUM('belum_hadir','hadir','tidak_hadir') NOT NULL DEFAULT 'belum_hadir',
  no_hp VARCHAR(20) DEFAULT NULL,
  instansi VARCHAR(100) DEFAULT NULL,
  alamat TEXT,
  team VARCHAR(100) DEFAULT NULL,
  catatan TEXT,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  KEY event_id (event_id),
  CONSTRAINT fk_pendaftaran_user
    FOREIGN KEY (user_id) REFERENCES users (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_pendaftaran_event
    FOREIGN KEY (event_id) REFERENCES events (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT unique_user_event
    UNIQUE (user_id, event_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Tabel pembayaran
-- Menyimpan bukti pembayaran peserta
-- =========================================================

CREATE TABLE pembayaran (
  id INT NOT NULL AUTO_INCREMENT,
  pendaftaran_id INT NOT NULL,
  bukti_bayar VARCHAR(255) DEFAULT NULL,
  status ENUM('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY pendaftaran_id (pendaftaran_id),
  CONSTRAINT fk_pembayaran_pendaftaran
    FOREIGN KEY (pendaftaran_id) REFERENCES pendaftaran (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT unique_pembayaran_pendaftaran
    UNIQUE (pendaftaran_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Tabel sertifikat
-- Menyimpan data sertifikat peserta
-- =========================================================

CREATE TABLE sertifikat (
  id INT NOT NULL AUTO_INCREMENT,
  pendaftaran_id INT NOT NULL,
  nomor_sertifikat VARCHAR(100) NOT NULL,
  file_sertifikat VARCHAR(255) DEFAULT NULL,
  kode_verifikasi VARCHAR(100) DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY pendaftaran_id (pendaftaran_id),
  UNIQUE KEY nomor_sertifikat (nomor_sertifikat),
  UNIQUE KEY kode_verifikasi (kode_verifikasi),
  CONSTRAINT fk_sertifikat_pendaftaran
    FOREIGN KEY (pendaftaran_id) REFERENCES pendaftaran (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT unique_sertifikat_pendaftaran
    UNIQUE (pendaftaran_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Data awal users
-- Password contoh tetap memakai hash dari database sebelumnya
-- Admin login:
-- email    : admin@gmail.com
-- password : sesuai password pada aplikasi lama
--
-- Peserta login:
-- email    : user@gmail.com
-- password : sesuai password pada aplikasi lama
-- =========================================================

INSERT INTO users (id, nama, email, password, role, created_at) VALUES
(1, 'Administrator', 'admin@gmail.com', '$2a$12$ib2JdXUubQrYTm1HzZ9vcuFYsCnNYdPJOSgAvka9UY8D5zpOqOJHW', 'admin', '2026-05-24 14:09:51'),
(2, 'user', 'user@gmail.com', '$2a$12$R9DQ5rqF/2Gjvg/S33emc.YLgnImPZ5gPmRSx3QTOuhuZwe3qaeOG', 'peserta', '2026-05-24 14:19:23');

-- =========================================================
-- Data contoh events
-- =========================================================

INSERT INTO events
(id, nama_event, deskripsi, tanggal, waktu_mulai, waktu_selesai, lokasi, kuota, banner, status, created_at)
VALUES
(1, 'Seminar Teknologi Digital', 'Event seminar tentang perkembangan teknologi digital dan pemanfaatannya di dunia kerja.', '2026-05-30', '09:00:00', '12:00:00', 'Aula Kampus', 100, 'banner_event_1.png', 'selesai', '2026-05-27 01:51:44'),
(2, 'Workshop Web Development', 'Workshop dasar pembuatan aplikasi web sederhana menggunakan database dan framework.', '2026-06-15', '13:00:00', '16:00:00', 'Laboratorium Komputer', 50, 'banner_event_2.png', 'dibuka', '2026-05-27 11:08:54');

-- =========================================================
-- Data contoh pendaftaran
-- =========================================================

INSERT INTO pendaftaran
(id, user_id, event_id, status, kehadiran, no_hp, instansi, alamat, team, catatan, created_at)
VALUES
(1, 2, 1, 'approved', 'hadir', '081234567890', 'Universitas Contoh', 'Tangerang', 'Team A', 'Peserta hadir tepat waktu', '2026-05-27 02:06:59'),
(2, 2, 2, 'pending', 'belum_hadir', '08123456789', 'Universitas Contoh', 'Tangerang', NULL, 'Menunggu verifikasi pembayaran', '2026-05-27 11:10:15');

-- =========================================================
-- Data contoh pembayaran
-- =========================================================

INSERT INTO pembayaran
(id, pendaftaran_id, bukti_bayar, status, created_at)
VALUES
(1, 1, 'bukti_bayar_1.png', 'verified', '2026-05-27 02:07:30'),
(2, 2, 'bukti_bayar_2.jpeg', 'pending', '2026-05-27 11:10:47');

-- =========================================================
-- Data contoh sertifikat
-- Sertifikat hanya dibuat untuk peserta yang approved, verified, dan hadir
-- =========================================================

INSERT INTO sertifikat
(id, pendaftaran_id, nomor_sertifikat, file_sertifikat, kode_verifikasi, created_at)
VALUES
(1, 1, 'SRT-1-20260527020952', 'SRT-1-20260527020952.pdf', 'VERIFY-SRT-1-20260527020952', '2026-05-27 02:09:52');

-- =========================================================
-- Query contoh untuk cek peserta yang berhak mendapat sertifikat
-- =========================================================
--
-- SELECT
--   p.id AS pendaftaran_id,
--   u.nama,
--   e.nama_event,
--   p.status AS status_pendaftaran,
--   pb.status AS status_pembayaran,
--   p.kehadiran
-- FROM pendaftaran p
-- JOIN users u ON p.user_id = u.id
-- JOIN events e ON p.event_id = e.id
-- JOIN pembayaran pb ON pb.pendaftaran_id = p.id
-- WHERE p.status = 'approved'
--   AND pb.status = 'verified'
--   AND p.kehadiran = 'hadir';
--
-- =========================================================
-- Selesai
-- =========================================================
