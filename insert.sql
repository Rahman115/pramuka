-- ===============================
-- TABEL MASTER DENGAN UUID
-- ===============================

-- Data semua orang
CREATE TABLE anggota (
    id_anggota INT AUTO_INCREMENT PRIMARY KEY,
    uuid_anggota CHAR(36) NOT NULL UNIQUE DEFAULT (UUID()),
    nama VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    tanggal_lahir DATE,
    kontak VARCHAR(50),
    kategori ENUM('kwarcab', 'dkc', 'pendamping', 'siaga', 'penggalang', 'penegak') NOT NULL,
    tanggal_daftar DATE DEFAULT CURRENT_DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Gugus Depan
CREATE TABLE gudep (
    id_gudep INT AUTO_INCREMENT PRIMARY KEY,
    uuid_gudep CHAR(36) NOT NULL UNIQUE DEFAULT (UUID()),
    nomor_gudep VARCHAR(20) NOT NULL UNIQUE,
    nama_gudep VARCHAR(100) NOT NULL,
    pangkalan VARCHAR(150) NOT NULL,  -- sekolah / kampus / desa
    alamat TEXT,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ===============================
-- DETAIL KEANGGOTAAN
-- ===============================

-- Pengurus Kwarcab
CREATE TABLE kwarcab (
    id_kwarcab INT AUTO_INCREMENT PRIMARY KEY,
    uuid_kwarcab CHAR(36) NOT NULL UNIQUE DEFAULT (UUID()),
    id_anggota INT,
    jabatan VARCHAR(100),
    periode VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_anggota) REFERENCES anggota(id_anggota) ON DELETE CASCADE,
    INDEX idx_kwarcab_anggota (id_anggota)
);

-- Dewan Kerja Cabang
CREATE TABLE dkc (
    id_dkc INT AUTO_INCREMENT PRIMARY KEY,
    uuid_dkc CHAR(36) NOT NULL UNIQUE DEFAULT (UUID()),
    id_anggota INT,
    jabatan VARCHAR(100),
    periode VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_anggota) REFERENCES anggota(id_anggota) ON DELETE CASCADE,
    INDEX idx_dkc_anggota (id_anggota)
);

-- Pendamping / pembina gudep
CREATE TABLE pendamping (
    id_pendamping INT AUTO_INCREMENT PRIMARY KEY,
    uuid_pendamping CHAR(36) NOT NULL UNIQUE DEFAULT (UUID()),
    id_anggota INT,
    id_gudep INT,
    jabatan ENUM('pembina', 'pembina_pembantu', 'pelatih') DEFAULT 'pembina',
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_anggota) REFERENCES anggota(id_anggota) ON DELETE CASCADE,
    FOREIGN KEY (id_gudep) REFERENCES gudep(id_gudep) ON DELETE CASCADE,
    INDEX idx_pendamping_anggota (id_anggota),
    INDEX idx_pendamping_gudep (id_gudep)
);

-- Peserta didik (Siaga, Penggalang, Penegak)
CREATE TABLE peserta_didik (
    id_peserta INT AUTO_INCREMENT PRIMARY KEY,
    uuid_peserta CHAR(36) NOT NULL UNIQUE DEFAULT (UUID()),
    id_anggota INT,
    golongan ENUM('siaga','penggalang','penegak') NOT NULL,
    id_gudep INT,
    status ENUM('aktif', 'alumni', 'pindah') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_anggota) REFERENCES anggota(id_anggota) ON DELETE CASCADE,
    FOREIGN KEY (id_gudep) REFERENCES gudep(id_gudep) ON DELETE CASCADE,
    INDEX idx_peserta_anggota (id_anggota),
    INDEX idx_peserta_gudep (id_gudep)
);

-- ===============================
-- KEGIATAN & PARTISIPASI
-- ===============================

-- Daftar kegiatan
CREATE TABLE kegiatan (
    id_kegiatan INT AUTO_INCREMENT PRIMARY KEY,
    uuid_kegiatan CHAR(36) NOT NULL UNIQUE DEFAULT (UUID()),
    nama_kegiatan VARCHAR(150) NOT NULL,
    tanggal_mulai DATE,
    tanggal_selesai DATE,
    lokasi VARCHAR(150),
    deskripsi TEXT,
    status ENUM('draft', 'published', 'completed', 'cancelled') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Keikutsertaan kegiatan (many-to-many anggota ↔ kegiatan)
CREATE TABLE keikutsertaan (
    id_keikutsertaan INT AUTO_INCREMENT PRIMARY KEY,
    uuid_keikutsertaan CHAR(36) NOT NULL UNIQUE DEFAULT (UUID()),
    id_anggota INT,
    id_kegiatan INT,
    peran ENUM('peserta','panitia','pembina','lainnya') DEFAULT 'peserta',
    status_kehadiran ENUM('hadir', 'tidak_hadir', 'izin') DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_anggota) REFERENCES anggota(id_anggota) ON DELETE CASCADE,
    FOREIGN KEY (id_kegiatan) REFERENCES kegiatan(id_kegiatan) ON DELETE CASCADE,
    UNIQUE KEY unique_anggota_kegiatan (id_anggota, id_kegiatan),
    INDEX idx_keikutsertaan_anggota (id_anggota),
    INDEX idx_keikutsertaan_kegiatan (id_kegiatan)
);

-- ===============================
-- PENGGUNA / LOGIN
-- ===============================

CREATE TABLE pengguna (
    id_pengguna INT AUTO_INCREMENT PRIMARY KEY,
    uuid_pengguna CHAR(36) NOT NULL UNIQUE DEFAULT (UUID()),
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin','pembina','anggota') NOT NULL,
    id_anggota INT,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_anggota) REFERENCES anggota(id_anggota) ON DELETE CASCADE,
    INDEX idx_pengguna_anggota (id_anggota)
);

-- ===============================
-- INDEX TAMBAHAN UNTUK PERFORMANSI
-- ===============================

-- Index untuk pencarian nama anggota
CREATE INDEX idx_anggota_nama ON anggota(nama);
CREATE INDEX idx_anggota_kategori ON anggota(kategori);

-- Index untuk pencarian gudep
CREATE INDEX idx_gudep_nomor ON gudep(nomor_gudep);
CREATE INDEX idx_gudep_nama ON gudep(nama_gudep);

-- Index untuk kegiatan berdasarkan tanggal
CREATE INDEX idx_kegiatan_tanggal ON kegiatan(tanggal_mulai, tanggal_selesai);
CREATE INDEX idx_kegiatan_status ON kegiatan(status);
