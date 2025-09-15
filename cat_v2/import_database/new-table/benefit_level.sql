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
-- Table structure for table `benefit_level`
--

CREATE TABLE `benefit_level` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_benefit_id` bigint(20) UNSIGNED NOT NULL,
  `member_level_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `benefit_level`
--

INSERT INTO `benefit_level` (`id`, `member_benefit_id`, `member_level_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-07-21 08:20:10', '2025-07-21 08:20:10'),
(2, 1, 2, '2025-07-21 08:20:10', '2025-07-21 08:20:10'),
(3, 1, 3, '2025-07-21 08:20:10', '2025-07-21 08:20:10'),
(4, 2, 2, '2025-07-21 08:20:10', '2025-07-21 08:20:10'),
(5, 2, 3, '2025-07-21 08:20:10', '2025-07-21 08:20:10'),
(6, 3, 3, '2025-07-21 08:20:10', '2025-07-21 08:20:10'),
(7, 4, 3, '2025-07-21 08:20:10', '2025-07-21 08:20:10'),
(8, 5, 3, '2025-07-21 08:20:10', '2025-07-21 08:20:10'),
(9, 6, 3, '2025-07-21 08:43:13', '2025-07-21 08:43:13'),
(10, 3, 2, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `benefit_level`
--
ALTER TABLE `benefit_level`
  ADD PRIMARY KEY (`id`),
  ADD KEY `benefit_level_member_benefit_id_foreign` (`member_benefit_id`),
  ADD KEY `benefit_level_member_level_id_foreign` (`member_level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `benefit_level`
--
ALTER TABLE `benefit_level`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `benefit_level`
--
ALTER TABLE `benefit_level`
  ADD CONSTRAINT `benefit_level_member_benefit_id_foreign` FOREIGN KEY (`member_benefit_id`) REFERENCES `member_benefits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `benefit_level_member_level_id_foreign` FOREIGN KEY (`member_level_id`) REFERENCES `member_levels` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
