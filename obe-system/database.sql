-- Database: `obe_system`
CREATE DATABASE IF NOT EXISTS obe_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE obe_system;

-- Tabel Prodi
CREATE TABLE prodi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL
);

-- Tabel Angkatan
CREATE TABLE angkatan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tahun VARCHAR(9) NOT NULL, 
    prodi_id INT,
    FOREIGN KEY (prodi_id) REFERENCES prodi(id) ON DELETE CASCADE
);

CREATE TABLE cpl (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(10) NOT NULL,
    deskripsi TEXT NOT NULL,
    angkatan_id INT,
    FOREIGN KEY (angkatan_id) REFERENCES angkatan(id) ON DELETE CASCADE
);


CREATE TABLE cpmk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(10) NOT NULL,
    deskripsi TEXT NOT NULL,
    cpl_id INT,
    matkul_id INT,
    FOREIGN KEY (cpl_id) REFERENCES cpl(id) ON DELETE CASCADE,
    FOREIGN KEY (matkul_id) REFERENCES matkul(id) ON DELETE SET NULL
);

CREATE TABLE matkul (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(10) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    dosen_pengampu VARCHAR(100),
    angkatan_id INT,
    FOREIGN KEY (angkatan_id) REFERENCES angkatan(id) ON DELETE CASCADE
);

-- Tabel Teknik Penilaian
CREATE TABLE teknik_penilaian (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(50) NOT NULL -- UTS, UAS, Tugas, Kuis, dll
);

-- Tabel Penilaian (input skor oleh dosen)
CREATE TABLE penilaian (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matkul_id INT,
    cpmk_id INT,
    teknik_id INT,
    skor DECIMAL(5,2) NOT NULL,
    UNIQUE KEY unique_penilaian (matkul_id, cpmk_id, teknik_id),
    FOREIGN KEY (matkul_id) REFERENCES matkul(id) ON DELETE CASCADE,
    FOREIGN KEY (cpmk_id) REFERENCES cpmk(id) ON DELETE CASCADE,
    FOREIGN KEY (teknik_id) REFERENCES teknik_penilaian(id) ON DELETE CASCADE
);

-- Tabel Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    role ENUM('admin', 'akademik', 'kaprodi', 'wadir1', 'dosen') NOT NULL,
    prodi_id INT,
    FOREIGN KEY (prodi_id) REFERENCES prodi(id) ON DELETE SET NULL
);

-- Tabel Mahasiswa
CREATE TABLE mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    angkatan_id INT,
    FOREIGN KEY (angkatan_id) REFERENCES angkatan(id) ON DELETE CASCADE
);

-- Data awal: teknik penilaian
INSERT INTO teknik_penilaian (nama) VALUES 
('Tugas'), ('Kuis'), ('UTS'), ('UAS'), ('Praktikum');

-- Data awal: prodi
INSERT INTO prodi (nama) VALUES ('Teknik Informatika'), ('Sistem Informasi');