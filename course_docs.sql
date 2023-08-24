-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 20, 2023 at 11:37 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pathway`
--

-- --------------------------------------------------------

--
-- Table structure for table `course_docs`
--

CREATE TABLE `course_docs` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_docs`
--

INSERT INTO `course_docs` (`id`, `course_id`, `name`, `size`, `note`, `created_at`, `updated_at`) VALUES
(4, 1, '1_1689852138.pdf', '66.89 KB', 'Magna vero minus eum', '2023-07-20 11:22:18', '2023-07-20 11:22:18'),
(5, 1, '1_1689852153.doc', '1,012.50 KB', 'Dolor distinctio Ip', '2023-07-20 11:22:33', '2023-07-20 11:22:33'),
(6, 1, '1_1689852474.zip', '6.30 MB', NULL, '2023-07-20 11:27:54', '2023-07-20 11:27:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course_docs`
--
ALTER TABLE `course_docs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_docs_course_id_foreign` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course_docs`
--
ALTER TABLE `course_docs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_docs`
--
ALTER TABLE `course_docs`
  ADD CONSTRAINT `course_docs_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
