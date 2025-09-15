-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2025 at 06:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `caping`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_showcases`
--

CREATE TABLE `app_showcases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `thumbnail` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_showcases`
--

INSERT INTO `app_showcases` (`id`, `thumbnail`, `title`, `description`, `order`, `created_at`, `updated_at`) VALUES
(1, 'app_showcases/SZMGzmLB74H9XY5MUol1dfjQFA61jl1DJxhL9mmW.png', 'Kategori Peminatan', 'Tampilan halaman kategori peminatan, menampilkan kategori untuk TNI, POLRI, CPNS dan Kedinasan', 0, NULL, '2025-07-21 02:59:35'),
(2, 'app_showcases/qMR50jEuAVNPuRiDoJfQwqxEXUTVtzeD2mK5yIUY.png', 'Halaman Try Out', 'Tampilan halaman Try Out dengan soal matematika. menampilkan nomor soal serta navigasi soal agar siswa tahu soal mana saja yang sudah dijawab.', 2, '2025-07-20 16:49:20', '2025-07-20 16:49:20'),
(3, 'app_showcases/j4OH7lnc9kesAGcjubQH5HdccOlhgHYucPUJAXD6.png', 'Detail Penilaian', 'Tampilan detail penilaian. Menampikan kategori penilaian yang ada didalam tes yang sudah dikerjakan, sehingga siwa tahu mana yang harus dievaluasi.', 3, '2025-07-21 02:43:21', '2025-07-21 02:43:21'),
(4, 'app_showcases/9r1xBG8lmQ2NToabkTEUnPNRSwj2NhQMGqX1JIj2.png', 'Tes Kecermatan POLRI', 'Menampilkan soal tanpa nomor dan navigasi, ketika klik jawaban, soal otomatis berpindah. ada 10 kolom dalam tes ini, tiap kolom terdiri dari 50 soal.', 4, '2025-07-21 02:45:13', '2025-07-21 02:45:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_showcases`
--
ALTER TABLE `app_showcases`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_showcases`
--
ALTER TABLE `app_showcases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
