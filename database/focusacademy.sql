-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jun 2025 pada 03.08
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `focusacademy`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pertanyaan`
--

CREATE TABLE `detail_pertanyaan` (
  `no_soal` int(11) NOT NULL,
  `id_option` int(11) NOT NULL,
  `teks_option` varchar(255) NOT NULL,
  `point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_pertanyaan`
--

INSERT INTO `detail_pertanyaan` (`no_soal`, `id_option`, `teks_option`, `point`) VALUES
(1, 1, 'Pengendalian lingkungan hidup dan kebijakan moneter', 5),
(1, 2, 'Politik luar negeri dan pertahanan', 0),
(1, 3, 'Keamanan dan yustisi', 0),
(1, 4, 'Moneter dan fiscal nasional', 0),
(1, 5, 'Agama dan politik luar negeri', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `logo`) VALUES
(1, 'Sekolah Kedinasan', '/image/logo-fa.png'),
(2, 'CPNS Umum', '/image/logo-pns.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `option`
--

CREATE TABLE `option` (
  `id_option` int(11) NOT NULL,
  `opsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `option`
--

INSERT INTO `option` (`id_option`, `opsi`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, 'E');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `kabupaten` varchar(100) NOT NULL,
  `tanggal_daftar` datetime NOT NULL,
  `foto_pengguna` varchar(255) DEFAULT NULL,
  `nomor_hp` varchar(15) NOT NULL,
  `saldo` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama`, `email`, `password`, `tanggal_lahir`, `provinsi`, `kabupaten`, `tanggal_daftar`, `foto_pengguna`, `nomor_hp`, `saldo`) VALUES
(1, 'Kezia Valerina 25# 1C', 'keziadamanik20@gmail.com', '12345', '2005-06-20', 'Sumatera Barat', 'Padang', '2025-05-31 10:25:52', NULL, '0852652546889', 180000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `question`
--

CREATE TABLE `question` (
  `no_soal` int(11) NOT NULL,
  `id_tryout` int(11) DEFAULT NULL,
  `id_subject` int(11) DEFAULT NULL,
  `teks_soal` text NOT NULL,
  `penjelasan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `question`
--

INSERT INTO `question` (`no_soal`, `id_tryout`, `id_subject`, `teks_soal`, `penjelasan`) VALUES
(1, 1, 1, 'Pemerintah daerah menyelenggarakan urusan pemerintahan yang menjadi kewenangannya, kecuali urusan pemerintahan yang oleh Undang-Undang ini ditentukan menjadi urusan pemerintah. Di bawah ini, manakah yang bukan menjadi urusan yang dimaksud?', 'Urusan yang menjadi urusan pemerintah adalah: Politik luar negeri, Pertahanan, Keamanan, Yustisi, Moneter, Fiscal nasional, Agama.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `subject`
--

CREATE TABLE `subject` (
  `id_subject` int(11) NOT NULL,
  `nama_subject` varchar(255) NOT NULL,
  `passing_grade` int(11) NOT NULL,
  `jumlah_soal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `subject`
--

INSERT INTO `subject` (`id_subject`, `nama_subject`, `passing_grade`, `jumlah_soal`) VALUES
(1, 'TWK', 65, 30),
(2, 'TIU', 80, 35),
(3, 'TKP', 156, 45);

-- --------------------------------------------------------

--
-- Struktur dari tabel `subject_result`
--

CREATE TABLE `subject_result` (
  `id_pengguna` int(11) NOT NULL,
  `id_subject` int(11) NOT NULL,
  `id_tryout` int(11) NOT NULL,
  `jumlah_benar` int(11) DEFAULT 0,
  `score` int(11) DEFAULT 0,
  `status_kelulusan_subject` enum('LULUS','TIDAK LULUS') DEFAULT 'TIDAK LULUS'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tryout`
--

CREATE TABLE `tryout` (
  `id_tryout` int(11) NOT NULL,
  `nama_tryout` varchar(255) NOT NULL,
  `tanggal_mulai` text NOT NULL,
  `tanggal_selesai` text NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tryout`
--

INSERT INTO `tryout` (`id_tryout`, `nama_tryout`, `tanggal_mulai`, `tanggal_selesai`, `harga`, `id_kategori`) VALUES
(1, 'Sekdin 2025 (vol 1)', 'Rabu, 11 Desember 2024', 'Selasa, 30 September 2025', 20000.00, 1),
(2, 'Sekdin 2025 (vol 2)', 'Selasa, 21 Januari 2025', 'Selasa, 30 September 2025', 20000.00, 1),
(3, 'Sekdin 2025 (vol 3)', 'Kamis, 30 Januari 2025', 'Selasa, 30 September 2025', 20000.00, 1),
(4, 'Sekdin 2025 (vol 4)', 'Senin, 10 Februari 2025', 'Selasa, 30 September 2025', 20000.00, 1),
(5, 'Sekdin 2025 (vol 5)', 'Senin, 24 Februari 2025', 'Selasa, 30 September 2025', 20000.00, 1),
(6, 'Sekdin 2025 (vol 6)', 'Selasa, 08 April 2025', 'Selasa, 30 September 2025', 20000.00, 1),
(7, 'Sekdin 2025 (vol 7)', 'Senin, 21 April 2025', 'Selasa, 30 September 2025', 20000.00, 1),
(8, 'CPNS 2025 (vol 1)', 'Kamis, 13 Maret 2025', 'Selasa, 30 September 2025', 20000.00, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tryout_purchase`
--

CREATE TABLE `tryout_purchase` (
  `id_tryout` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `tanggal_transaksi` datetime DEFAULT current_timestamp(),
  `status_pengerjaan` enum('Belum','Sedang Dikerjakan','Selesai') DEFAULT 'Belum',
  `total_score` int(11) DEFAULT 0,
  `status_kelulusan_to` enum('Lulus','Tidak Lulus','Belum Dikerjakan') DEFAULT 'Belum Dikerjakan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tryout_purchase`
--

INSERT INTO `tryout_purchase` (`id_tryout`, `id_pengguna`, `tanggal_transaksi`, `status_pengerjaan`, `total_score`, `status_kelulusan_to`) VALUES
(2, 1, '2025-06-09 07:45:19', 'Belum', 0, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_answer`
--

CREATE TABLE `user_answer` (
  `id_pengguna` int(11) NOT NULL,
  `no_soal` int(11) NOT NULL,
  `id_option` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_pertanyaan`
--
ALTER TABLE `detail_pertanyaan`
  ADD PRIMARY KEY (`no_soal`,`id_option`),
  ADD KEY `id_option` (`id_option`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `option`
--
ALTER TABLE `option`
  ADD PRIMARY KEY (`id_option`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`no_soal`),
  ADD KEY `id_tryout` (`id_tryout`),
  ADD KEY `id_subject` (`id_subject`);

--
-- Indeks untuk tabel `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id_subject`);

--
-- Indeks untuk tabel `subject_result`
--
ALTER TABLE `subject_result`
  ADD PRIMARY KEY (`id_pengguna`,`id_subject`,`id_tryout`),
  ADD KEY `id_subject` (`id_subject`),
  ADD KEY `id_tryout` (`id_tryout`);

--
-- Indeks untuk tabel `tryout`
--
ALTER TABLE `tryout`
  ADD PRIMARY KEY (`id_tryout`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `tryout_purchase`
--
ALTER TABLE `tryout_purchase`
  ADD PRIMARY KEY (`id_tryout`,`id_pengguna`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indeks untuk tabel `user_answer`
--
ALTER TABLE `user_answer`
  ADD PRIMARY KEY (`id_pengguna`,`no_soal`),
  ADD KEY `no_soal` (`no_soal`),
  ADD KEY `id_option` (`id_option`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `option`
--
ALTER TABLE `option`
  MODIFY `id_option` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `question`
--
ALTER TABLE `question`
  MODIFY `no_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `subject`
--
ALTER TABLE `subject`
  MODIFY `id_subject` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_pertanyaan`
--
ALTER TABLE `detail_pertanyaan`
  ADD CONSTRAINT `detail_pertanyaan_ibfk_1` FOREIGN KEY (`no_soal`) REFERENCES `question` (`no_soal`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_pertanyaan_ibfk_2` FOREIGN KEY (`id_option`) REFERENCES `option` (`id_option`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`id_tryout`) REFERENCES `tryout` (`id_tryout`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_ibfk_2` FOREIGN KEY (`id_subject`) REFERENCES `subject` (`id_subject`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `subject_result`
--
ALTER TABLE `subject_result`
  ADD CONSTRAINT `subject_result_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE,
  ADD CONSTRAINT `subject_result_ibfk_2` FOREIGN KEY (`id_subject`) REFERENCES `subject` (`id_subject`) ON DELETE CASCADE,
  ADD CONSTRAINT `subject_result_ibfk_3` FOREIGN KEY (`id_tryout`) REFERENCES `tryout` (`id_tryout`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tryout`
--
ALTER TABLE `tryout`
  ADD CONSTRAINT `tryout_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Ketidakleluasaan untuk tabel `tryout_purchase`
--
ALTER TABLE `tryout_purchase`
  ADD CONSTRAINT `tryout_purchase_ibfk_1` FOREIGN KEY (`id_tryout`) REFERENCES `tryout` (`id_tryout`) ON DELETE CASCADE,
  ADD CONSTRAINT `tryout_purchase_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_answer`
--
ALTER TABLE `user_answer`
  ADD CONSTRAINT `user_answer_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_answer_ibfk_2` FOREIGN KEY (`no_soal`) REFERENCES `question` (`no_soal`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_answer_ibfk_3` FOREIGN KEY (`id_option`) REFERENCES `option` (`id_option`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
