-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2025 at 06:18 AM
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
-- Table structure for table `member_benefits`
--

CREATE TABLE `member_benefits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member_benefits`
--

INSERT INTO `member_benefits` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Pembahasan untuk Tiap-tiap Soal', '2025-07-21 08:17:57', '2025-07-21 08:17:57'),
(2, 'Mengikuti Try Out', '2025-07-21 08:17:57', '2025-07-21 08:17:57'),
(3, 'Pembahasan Materi Sesuai Mata Pelajaran', '2025-07-21 08:17:57', '2025-07-21 08:17:57'),
(4, 'Webinar Evaluasi Dengan Mentor', '2025-07-21 08:17:57', '2025-07-21 08:17:57'),
(5, 'Group Telegram / Whatsapp Khusus', '2025-07-21 08:17:57', '2025-07-21 08:17:57'),
(6, 'Affiliate Program', '2025-07-21 08:17:57', '2025-07-21 08:17:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `member_benefits`
--
ALTER TABLE `member_benefits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `member_benefits`
--
ALTER TABLE `member_benefits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
