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
-- Table structure for table `landing_page_features`
--

CREATE TABLE `landing_page_features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `landing_page_features`
--

INSERT INTO `landing_page_features` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Permintaan Lengkap', 'Terdiri dari tes TNI, POLRI, Kedinasan, dan CPNS yang didalamnya terdapat banyak kategori yang akan diujikan. ', NULL, NULL),
(2, 'Sistem Penilaian', 'Sistem penilaian untuk kategori peminatan sesuai dengan sistem yang sebenarnya, sehingga siswa dapat mengetahui ambang batas nilai di kategori tersebut.', '2025-07-17 06:51:41', '2025-07-17 06:51:41'),
(3, 'Peringkat Nilai', 'Siswa dapat melihat ranking dari masing-masing Try Out yang telah diikuti sehingga siswa tahu dimana posisi dia dibanding dengan siswa lainnya.', '2025-07-17 06:52:58', '2025-07-17 06:52:58'),
(4, 'Pembahasan Materi', 'Pembahasan materi disajikan dalam bentuk dokumentasi tertulis atau video, baik itu pembahasan untuk masing-masing soal, atau materi yang disampaikan sesuai dengan judul bahasan.', '2025-07-17 06:53:51', '2025-07-17 06:53:51'),
(5, 'Webinar', 'Siswa dapat mengikuti webinar via Zoom Meeting yang bertujuan untuk mengevaluasi kegiatan pembelajaran.', '2025-07-17 06:55:19', '2025-07-17 06:55:19'),
(6, 'Affiliate Program', 'Selain bermanfaat bagi diri sendiri, siswa dapat mengajakan teman-teman lainnya kedalam sistem {{ $setting->app_name ?? \'\' }}, dan siswa tersebut akan mendapatkan komisi ketika siswa baru mengikuti link nya dan melakukan transaksi.', '2025-07-17 07:44:33', '2025-07-17 07:44:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `landing_page_features`
--
ALTER TABLE `landing_page_features`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `landing_page_features`
--
ALTER TABLE `landing_page_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
