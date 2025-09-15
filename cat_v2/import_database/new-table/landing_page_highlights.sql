-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2025 at 06:18 AM
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
-- Table structure for table `landing_page_highlights`
--

CREATE TABLE `landing_page_highlights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title1` varchar(191) NOT NULL,
  `description1` text NOT NULL,
  `title2` varchar(191) NOT NULL,
  `description2` text NOT NULL,
  `title3` varchar(191) NOT NULL,
  `description3` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `landing_page_highlights`
--

INSERT INTO `landing_page_highlights` (`id`, `title1`, `description1`, `title2`, `description2`, `title3`, `description3`, `created_at`, `updated_at`) VALUES
(1, 'Dibuat khusus seperti aslinya', 'Sistem dibuat mirip dengan tes aslinya agar anda tidak perlu banyak beradaptasi, sehingga anda tetap fokus dan menghindari dari masalah teknis yang tidak diinginkan.', 'Modern responsive design', 'Menampilkan komponen mobile-first yang dibuat dengan sangat elegan, aplikasi akan berfungsi dengan baik di perangkat apa pun seperti laptop, tablet ataupun smartphone!', 'Dokumentasi Lengkap', 'Semua tata letak, bagian halaman, komponen, dan utilitas sepenuhnya tercakup dalam dokumen lengkap agar memudahkan user ketika menggunakan aplikasi CAT', '2025-07-18 02:27:04', '2025-07-18 03:16:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `landing_page_highlights`
--
ALTER TABLE `landing_page_highlights`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `landing_page_highlights`
--
ALTER TABLE `landing_page_highlights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
