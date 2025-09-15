-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2025 at 10:06 AM
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
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` char(36) DEFAULT NULL,
  `code` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `user_limit` int(11) DEFAULT NULL,
  `active_period` int(11) NOT NULL,
  `access_type` enum('basic_member','standard_member','premium_member') NOT NULL,
  `type` enum('week','month','year') NOT NULL,
  `price_before_discount` double NOT NULL,
  `price_after_discount` double NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `created_at`, `updated_at`, `category_id`, `code`, `name`, `user_limit`, `active_period`, `access_type`, `type`, `price_before_discount`, `price_after_discount`, `description`, `is_active`) VALUES
('45bd6526-735c-47ad-bfdb-01a19bc92e81', '2025-07-23 07:53:42', '2025-07-23 07:54:33', '9675f18e-f909-4b37-a748-feb0e8ddde78', '123', 'primer', 10, 6, 'standard_member', 'month', 200000, 160000, '<p>voucher example</p>', 1),
('b4aad9f4-f337-4f77-b59c-281e51f539f5', '2025-07-23 08:04:31', '2025-07-23 08:04:31', 'b2873169-e856-4d8f-a043-a815d67e3610', '321', 'Paket Evaluasi Bulan Juli', 20, 3, 'standard_member', 'month', 400000, 280000, '<p>Dapatkan akses ke paket evaluasi lengkap untuk bulan ini. <strong>Sekarang Juga!</strong></p>', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
