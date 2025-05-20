-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2025 at 05:37 PM
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
-- Database: `spk`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatives`
--

CREATE TABLE `alternatives` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `kreativitas` float NOT NULL,
  `keaktifan` float NOT NULL,
  `teknologi` float NOT NULL,
  `inovatif` float NOT NULL,
  `fisik & olahraga` float NOT NULL,
  `komunikasi & public speaking` float NOT NULL,
  `religiusitas` float NOT NULL,
  `seni & musik` float NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `alternatives`
--

INSERT INTO `alternatives` (`id`, `name`, `kreativitas`, `keaktifan`, `teknologi`, `inovatif`, `fisik & olahraga`, `komunikasi & public speaking`, `religiusitas`, `seni & musik`, `created_at`, `updated_at`) VALUES
(1, 'UKM Bina Darma Cyber Army (BDCA)', 3, 5, 5, 3, 2, 3, 3, 2, '2025-05-20 13:57:07', '2025-05-20 17:00:54'),
(2, 'UKM Keagamaan', 4, 4, 2, 2, 3, 4, 5, 5, '2025-05-20 13:57:07', '2025-05-20 17:10:52'),
(3, 'UKM Panjat Tebing', 2, 5, 3, 3, 5, 4, 3, 2, '2025-05-20 13:57:07', '2025-05-20 17:01:34'),
(4, 'UKM Mahasiswa Pencinta Alam (MABIDAR)', 3, 5, 3, 4, 5, 4, 2, 2, '2025-05-20 13:57:07', '2025-05-20 15:47:13'),
(5, 'UKM Bujang Gadis Kampus (BGK)', 5, 3, 2, 5, 5, 5, 3, 2, '2025-05-20 13:57:07', '2025-05-20 15:46:02'),
(6, 'UKM Panduan Suara Mahasiswa (BDSC)', 2, 5, 3, 3, 4, 5, 2, 5, '2025-05-20 13:57:07', '2025-05-20 17:09:59'),
(7, 'UKM Binadarma Debat Union (BDCU)', 3, 5, 3, 4, 4, 5, 2, 2, '2025-05-20 13:57:07', '2025-05-20 17:02:05'),
(8, 'UKM Bina Darma Programmer (BDPRO)', 4, 5, 5, 4, 2, 3, 2, 3, '2025-05-20 13:57:07', '2025-05-20 17:02:26'),
(9, 'UKM Futsal', 2, 5, 3, 3, 5, 3, 3, 2, '2025-05-20 13:57:07', '2025-05-20 17:03:04'),
(10, 'UKM Seni', 5, 3, 3, 2, 2, 5, 4, 5, '2025-05-20 13:57:07', '2025-05-20 16:57:50'),
(11, 'UKM Pramuka', 3, 5, 2, 4, 5, 4, 3, 2, '2025-05-20 13:57:07', '2025-05-20 16:42:27'),
(12, 'UKM Bina Darma Radio (B-Radio)', 4, 5, 5, 2, 4, 5, 2, 3, '2025-05-20 13:57:07', '2025-05-20 16:58:32'),
(13, 'UKM EDS South Sumatera English Community (SSEC)', 5, 4, 3, 4, 3, 5, 2, 2, '2025-05-20 13:57:07', '2025-05-20 17:03:35'),
(14, 'Inovator Center (DIIB)', 5, 5, 5, 5, 3, 4, 2, 2, '2025-05-20 13:57:07', '2025-05-20 15:35:50'),
(15, 'UKM Pencak Silat', 2, 5, 3, 3, 5, 3, 3, 2, '2025-05-20 13:57:07', '2025-05-20 17:09:06'),
(16, 'UKM Basket Club', 2, 5, 3, 3, 5, 4, 2, 3, '2025-05-20 13:57:07', '2025-05-20 17:04:08'),
(17, 'UKM Data Science', 4, 4, 5, 5, 2, 3, 2, 3, '2025-05-20 17:07:51', '2025-05-20 17:07:51'),
(18, 'UKM Multimedia', 5, 4, 5, 5, 2, 3, 2, 3, '2025-05-20 17:07:51', '2025-05-20 17:07:51'),
(19, 'UKM BTV', 5, 4, 5, 4, 2, 4, 2, 3, '2025-05-20 17:21:21', '2025-05-20 17:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `value` tinyint NOT NULL COMMENT '5 = Sangat Setuju, 1 = Sangat Tidak Setuju',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `user_id`, `question_id`, `value`, `created_at`, `updated_at`) VALUES
(351, 14, 51, 4, '2025-05-20 09:34:06', '2025-05-20 09:34:06'),
(352, 14, 52, 4, '2025-05-20 09:34:10', '2025-05-20 09:34:10'),
(353, 14, 53, 4, '2025-05-20 09:34:14', '2025-05-20 09:34:14'),
(354, 14, 54, 4, '2025-05-20 09:34:18', '2025-05-20 09:34:18'),
(355, 14, 55, 4, '2025-05-20 09:34:24', '2025-05-20 09:34:24'),
(356, 14, 56, 5, '2025-05-20 09:34:27', '2025-05-20 09:34:27'),
(357, 14, 57, 3, '2025-05-20 09:34:31', '2025-05-20 09:34:31'),
(358, 14, 58, 4, '2025-05-20 09:34:36', '2025-05-20 09:34:36'),
(359, 14, 59, 1, '2025-05-20 09:34:39', '2025-05-20 09:34:39'),
(360, 14, 60, 2, '2025-05-20 09:34:43', '2025-05-20 09:34:43'),
(361, 14, 61, 1, '2025-05-20 09:34:46', '2025-05-20 09:34:46'),
(362, 14, 62, 1, '2025-05-20 09:34:49', '2025-05-20 09:34:49'),
(363, 14, 63, 2, '2025-05-20 09:34:53', '2025-05-20 09:34:53'),
(364, 14, 64, 5, '2025-05-20 09:34:56', '2025-05-20 09:34:56'),
(365, 14, 65, 4, '2025-05-20 09:35:01', '2025-05-20 09:35:01'),
(366, 14, 66, 5, '2025-05-20 09:35:04', '2025-05-20 09:35:04'),
(367, 14, 67, 5, '2025-05-20 09:35:08', '2025-05-20 09:35:08'),
(368, 14, 68, 4, '2025-05-20 09:35:14', '2025-05-20 09:35:14'),
(369, 14, 69, 5, '2025-05-20 09:35:18', '2025-05-20 09:35:18'),
(370, 14, 70, 2, '2025-05-20 09:35:23', '2025-05-20 09:35:23'),
(371, 14, 71, 2, '2025-05-20 09:35:29', '2025-05-20 09:35:29'),
(372, 14, 72, 1, '2025-05-20 09:35:32', '2025-05-20 09:35:32'),
(373, 14, 73, 3, '2025-05-20 09:35:36', '2025-05-20 09:35:36'),
(374, 14, 74, 2, '2025-05-20 09:35:43', '2025-05-20 09:35:43'),
(375, 14, 75, 1, '2025-05-20 09:35:46', '2025-05-20 09:35:46'),
(376, 14, 76, 4, '2025-05-20 09:35:51', '2025-05-20 09:35:51'),
(377, 14, 77, 5, '2025-05-20 09:35:54', '2025-05-20 09:35:54'),
(378, 14, 78, 4, '2025-05-20 09:35:57', '2025-05-20 09:35:57'),
(379, 14, 79, 5, '2025-05-20 09:36:01', '2025-05-20 09:36:01'),
(380, 14, 80, 5, '2025-05-20 09:36:03', '2025-05-20 09:36:03'),
(381, 14, 81, 4, '2025-05-20 09:36:07', '2025-05-20 09:36:07'),
(382, 14, 82, 2, '2025-05-20 09:36:10', '2025-05-20 09:36:10'),
(383, 14, 83, 1, '2025-05-20 09:36:12', '2025-05-20 09:36:12'),
(384, 14, 84, 1, '2025-05-20 09:36:16', '2025-05-20 09:36:16'),
(385, 14, 85, 1, '2025-05-20 09:36:19', '2025-05-20 09:36:19'),
(386, 14, 86, 1, '2025-05-20 09:36:21', '2025-05-20 09:36:21'),
(387, 14, 87, 2, '2025-05-20 09:36:24', '2025-05-20 09:36:24'),
(388, 14, 88, 5, '2025-05-20 09:36:29', '2025-05-20 09:36:29'),
(389, 14, 89, 4, '2025-05-20 09:36:32', '2025-05-20 09:36:32'),
(390, 14, 90, 5, '2025-05-20 09:36:35', '2025-05-20 09:36:35'),
(391, 14, 91, 5, '2025-05-20 09:36:38', '2025-05-20 09:36:38'),
(392, 14, 92, 5, '2025-05-20 09:36:42', '2025-05-20 09:36:42'),
(393, 14, 93, 5, '2025-05-20 09:36:49', '2025-05-20 09:36:49'),
(394, 14, 94, 4, '2025-05-20 09:36:52', '2025-05-20 09:36:52'),
(395, 14, 95, 2, '2025-05-20 09:36:59', '2025-05-20 09:36:59'),
(396, 14, 96, 2, '2025-05-20 09:37:05', '2025-05-20 09:37:05'),
(397, 14, 97, 5, '2025-05-20 09:37:09', '2025-05-20 09:37:09'),
(398, 14, 98, 1, '2025-05-20 09:37:16', '2025-05-20 09:37:16'),
(399, 14, 99, 3, '2025-05-20 09:37:21', '2025-05-20 09:37:21'),
(400, 14, 100, 3, '2025-05-20 09:37:26', '2025-05-20 09:37:26'),
(401, 14, 101, 4, '2025-05-20 09:37:30', '2025-05-20 09:37:30'),
(402, 14, 102, 4, '2025-05-20 09:37:34', '2025-05-20 09:37:34'),
(403, 14, 103, 2, '2025-05-20 09:37:37', '2025-05-20 09:37:37'),
(404, 14, 104, 1, '2025-05-20 09:37:39', '2025-05-20 09:37:39'),
(405, 14, 105, 1, '2025-05-20 09:37:43', '2025-05-20 09:37:43'),
(406, 14, 106, 2, '2025-05-20 09:37:47', '2025-05-20 09:37:47'),
(407, 14, 107, 2, '2025-05-20 09:37:52', '2025-05-20 09:37:52'),
(408, 14, 108, 4, '2025-05-20 09:38:02', '2025-05-20 09:38:02'),
(409, 14, 109, 3, '2025-05-20 09:38:05', '2025-05-20 09:38:05'),
(410, 14, 110, 4, '2025-05-20 09:38:08', '2025-05-20 09:38:08'),
(411, 14, 111, 4, '2025-05-20 09:38:13', '2025-05-20 09:38:13'),
(412, 14, 112, 4, '2025-05-20 09:38:17', '2025-05-20 09:38:17'),
(413, 14, 113, 5, '2025-05-20 09:38:21', '2025-05-20 09:38:21'),
(414, 14, 114, 5, '2025-05-20 09:38:24', '2025-05-20 09:38:24'),
(415, 14, 115, 5, '2025-05-20 09:38:27', '2025-05-20 09:38:27'),
(416, 14, 116, 3, '2025-05-20 09:38:31', '2025-05-20 09:38:31'),
(417, 14, 117, 5, '2025-05-20 09:38:39', '2025-05-20 09:38:39'),
(418, 14, 118, 5, '2025-05-20 09:38:43', '2025-05-20 09:38:43'),
(419, 14, 119, 4, '2025-05-20 09:38:46', '2025-05-20 09:38:46'),
(420, 14, 120, 2, '2025-05-20 09:38:51', '2025-05-20 09:38:51'),
(421, 14, 121, 4, '2025-05-20 09:38:57', '2025-05-20 09:38:57'),
(422, 14, 122, 2, '2025-05-20 09:38:59', '2025-05-20 09:38:59'),
(423, 14, 123, 1, '2025-05-20 09:39:02', '2025-05-20 09:39:02'),
(424, 14, 124, 2, '2025-05-20 09:39:06', '2025-05-20 09:39:06'),
(425, 14, 125, 5, '2025-05-20 09:39:10', '2025-05-20 09:39:10'),
(426, 14, 126, 5, '2025-05-20 09:39:12', '2025-05-20 09:39:12'),
(427, 14, 127, 5, '2025-05-20 09:39:14', '2025-05-20 09:39:14'),
(428, 14, 128, 5, '2025-05-20 09:39:16', '2025-05-20 09:39:16'),
(429, 14, 129, 5, '2025-05-20 09:39:19', '2025-05-20 09:39:19'),
(430, 14, 130, 5, '2025-05-20 09:39:21', '2025-05-20 09:39:21'),
(431, 14, 131, 2, '2025-05-20 09:39:24', '2025-05-20 09:39:24'),
(432, 14, 132, 2, '2025-05-20 09:39:26', '2025-05-20 09:39:26'),
(433, 14, 133, 1, '2025-05-20 09:39:29', '2025-05-20 09:39:29'),
(434, 14, 134, 1, '2025-05-20 09:39:32', '2025-05-20 09:39:32'),
(435, 14, 135, 1, '2025-05-20 09:39:34', '2025-05-20 09:39:34'),
(436, 14, 136, 2, '2025-05-20 09:43:43', '2025-05-20 09:43:43'),
(437, 14, 137, 2, '2025-05-20 09:43:47', '2025-05-20 09:43:47'),
(438, 14, 138, 2, '2025-05-20 09:43:49', '2025-05-20 09:43:49'),
(439, 14, 139, 3, '2025-05-20 09:43:53', '2025-05-20 09:43:53'),
(440, 14, 140, 1, '2025-05-20 09:43:56', '2025-05-20 09:43:56'),
(441, 14, 141, 4, '2025-05-20 09:44:00', '2025-05-20 09:44:00'),
(442, 14, 142, 2, '2025-05-20 09:44:04', '2025-05-20 09:44:04'),
(443, 14, 143, 2, '2025-05-20 09:44:08', '2025-05-20 09:44:08'),
(444, 14, 144, 3, '2025-05-20 09:44:11', '2025-05-20 09:44:11'),
(445, 14, 145, 2, '2025-05-20 09:44:18', '2025-05-20 09:44:18'),
(446, 14, 146, 4, '2025-05-20 09:44:22', '2025-05-20 09:44:22'),
(447, 14, 147, 4, '2025-05-20 09:44:25', '2025-05-20 09:44:25'),
(448, 14, 148, 3, '2025-05-20 09:44:29', '2025-05-20 09:44:29'),
(449, 14, 149, 3, '2025-05-20 09:44:34', '2025-05-20 09:44:34'),
(450, 14, 150, 1, '2025-05-20 09:44:38', '2025-05-20 09:44:38');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_reset-password:127.0.0.1', 'i:1;', 1747465877),
('laravel_cache_reset-password:127.0.0.1:timer', 'i:1747465877;', 1747465877),
('laravel_cache_user_registration_AJGhNh', 'a:4:{s:4:\"name\";s:5:\"cloud\";s:5:\"email\";s:21:\"dennytriyyy@gmail.com\";s:8:\"password\";s:60:\"$2y$12$YrIaWPQLYuFsk64PCSlv3.zwAH0xrbiDCC88BlYk5Af/eS9ShBSCi\";s:18:\"verification_token\";s:6:\"AJGhNh\";}', 1746638265),
('laravel_cache_user_registration_CAGm7b', 'a:4:{s:4:\"name\";s:5:\"cloud\";s:5:\"email\";s:21:\"dennytriyyy@gmail.com\";s:8:\"password\";s:60:\"$2y$12$8Q0x7fcZKgAcoevKRzn2l.SxFix7.nvL.DtvFwANXFI4lfhzpD/pa\";s:18:\"verification_token\";s:6:\"CAGm7b\";}', 1746638690),
('laravel_cache_user_registration_DLiaWX', 'a:4:{s:4:\"name\";s:5:\"cloud\";s:5:\"email\";s:21:\"dennytriyyy@gmail.com\";s:8:\"password\";s:60:\"$2y$12$mp01jV4/q/tU/nPPyhFMjOS6HbZpLrxZjuSgXU/cKOrv2tSs1.JSy\";s:18:\"verification_token\";s:6:\"DLiaWX\";}', 1746638014),
('laravel_cache_user_registration_dyt343@gmail.com', 'a:5:{s:4:\"name\";s:11:\"meowmeowali\";s:5:\"email\";s:16:\"dyt343@gmail.com\";s:8:\"password\";s:60:\"$2y$12$wmvShqIlDX0gkB.lYYb5LuQ7VxQZX0t/aTx9e2tl3MqeK5ZA16c3i\";s:18:\"verification_token\";s:6:\"1HYmtQ\";s:4:\"role\";s:9:\"mahasiswa\";}', 1747468776),
('laravel_cache_user_registration_FdzjbM', 'a:4:{s:4:\"name\";s:5:\"cloud\";s:5:\"email\";s:21:\"dennytriyyy@gmail.com\";s:8:\"password\";s:60:\"$2y$12$8WFXY9L3/aS6QohX6ZE3DOJeoW21oFaDGNFqVdIkZpSBO2ERNpYHC\";s:18:\"verification_token\";s:6:\"FdzjbM\";}', 1746636486),
('laravel_cache_user_registration_fsKMVR', 'a:4:{s:4:\"name\";s:5:\"cloud\";s:5:\"email\";s:21:\"dennytriyyy@gmail.com\";s:8:\"password\";s:60:\"$2y$12$lCxoTLp6M/EZkBlGmo4EX.NCzi6GCac.9KbXiykb6/DjzZeRv/0y6\";s:18:\"verification_token\";s:6:\"fsKMVR\";}', 1746637500),
('laravel_cache_user_registration_GwzuYM', 'a:4:{s:4:\"name\";s:5:\"cloud\";s:5:\"email\";s:21:\"dennytriyyy@gmail.com\";s:8:\"password\";s:60:\"$2y$12$L9QmbdholfWVDPFT/3rGYOoy3AeUA2170F.kh2U/wKHJXHWqIKsPa\";s:18:\"verification_token\";s:6:\"GwzuYM\";}', 1746636702),
('laravel_cache_user_registration_hdhFgj', 'a:4:{s:4:\"name\";s:5:\"cloud\";s:5:\"email\";s:21:\"dennytriyyy@gmail.com\";s:8:\"password\";s:60:\"$2y$12$W/e0yXV518E9omaiD3gppORzHGy7SOw8ZgiiAAbSrILavaHCGnpO.\";s:18:\"verification_token\";s:6:\"hdhFgj\";}', 1746637264),
('laravel_cache_user_registration_J0KxRp', 'a:4:{s:4:\"name\";s:5:\"cloud\";s:5:\"email\";s:21:\"dennytriyyy@gmail.com\";s:8:\"password\";s:60:\"$2y$12$dnwqR3QHOHXXOmB0YFxomuauhUTF/FV.JP/1bZdFlFy.ZSQRjeMey\";s:18:\"verification_token\";s:6:\"J0KxRp\";}', 1746638449),
('laravel_cache_user_registration_JsZ3oa', 'a:4:{s:4:\"name\";s:5:\"cloud\";s:5:\"email\";s:21:\"dennytriyyy@gmail.com\";s:8:\"password\";s:60:\"$2y$12$eYm/K4B5H8ChD75Oj.2gyu68k7P7y/Ah3s/NpjAQ2LI6VyiVdyjL6\";s:18:\"verification_token\";s:6:\"JsZ3oa\";}', 1746637204),
('laravel_cache_user_registration_kSAsPp', 'a:4:{s:4:\"name\";s:5:\"cloud\";s:5:\"email\";s:21:\"dennytriyyy@gmail.com\";s:8:\"password\";s:60:\"$2y$12$ekCK4PXP2D.hpLku3q8VtuFjLCUIF34hPUf1g6YihD0mvsUyELdgK\";s:18:\"verification_token\";s:6:\"kSAsPp\";}', 1746637300),
('laravel_cache_user_registration_lH0Z3T', 'a:4:{s:4:\"name\";s:5:\"cloud\";s:5:\"email\";s:21:\"dennytriyyy@gmail.com\";s:8:\"password\";s:60:\"$2y$12$gNpTscFJ3NmDrRVZ26cFP.byXaDTX8HBwvLUg7Vkx/t4gcX2.UY12\";s:18:\"verification_token\";s:6:\"lH0Z3T\";}', 1746636933),
('laravel_cache_user_registration_mi5HMl', 'a:4:{s:4:\"name\";s:5:\"cloud\";s:5:\"email\";s:21:\"dennytriyyy@gmail.com\";s:8:\"password\";s:60:\"$2y$12$i3LJZp0IWLbJf59pVFBYDejpo0.4qrUdjm8j/vedqUHza3tdmsr9e\";s:18:\"verification_token\";s:6:\"mi5HMl\";}', 1746638412),
('laravel_cache_user_registration_tBeL2E', 'a:4:{s:4:\"name\";s:5:\"cloud\";s:5:\"email\";s:21:\"dennytriyyy@gmail.com\";s:8:\"password\";s:60:\"$2y$12$565jVC15xiRZzPQXAOooQumzgAATmkn.b5hL6PYysxg6CeEcrBf8.\";s:18:\"verification_token\";s:6:\"tBeL2E\";}', 1746637179),
('laravel_cache_user_registration_ttGeFO', 'a:4:{s:4:\"name\";s:5:\"cloud\";s:5:\"email\";s:21:\"dennytriyyy@gmail.com\";s:8:\"password\";s:60:\"$2y$12$8BtIFmeJldJ3Kz8oRAXNjevYIZIiRHAoZjYXmUh3pcr/kkrkEX8nC\";s:18:\"verification_token\";s:6:\"ttGeFO\";}', 1746636792),
('laravel_cache_user_registration_WPbMSz', 'a:4:{s:4:\"name\";s:5:\"cloud\";s:5:\"email\";s:21:\"dennytriyyy@gmail.com\";s:8:\"password\";s:60:\"$2y$12$WuIkVN6FGMD3/k8L8tIm5epDAE.us1R3oe8kRmwHVU2jXc624JTTG\";s:18:\"verification_token\";s:6:\"WPbMSz\";}', 1746638421),
('laravel_cache_user_registration_y5xoTL', 'a:4:{s:4:\"name\";s:5:\"cloud\";s:5:\"email\";s:21:\"dennytriyyy@gmail.com\";s:8:\"password\";s:60:\"$2y$12$pXKE.9m7/W0YCSOBUJoDl.hQ3K6/Fg6KdD45RN2fBeNFjdVrLn9eC\";s:18:\"verification_token\";s:6:\"y5xoTL\";}', 1746638575);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftarans`
--

CREATE TABLE `pendaftarans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `setting_id` bigint UNSIGNED NOT NULL,
  `organization_1` varchar(100) NOT NULL,
  `organization_2` varchar(100) DEFAULT NULL,
  `organization_3` varchar(100) DEFAULT NULL,
  `alamat` text NOT NULL,
  `deskripsi` text NOT NULL,
  `upload_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('pending','diterima','ditolak') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pendaftarans`
--

INSERT INTO `pendaftarans` (`id`, `user_id`, `setting_id`, `organization_1`, `organization_2`, `organization_3`, `alamat`, `deskripsi`, `upload_file`, `created_at`, `updated_at`, `status`) VALUES
(10, 14, 1, 'UKM Bina Darma Cyber Army (BDCA)', 'UKM Bina Darma Programmer (BDPRO)', 'Inovator Center (DIIB) - Bonus akan mendapatkan Jika jawaban anda sempurna', 'alamak', 'wkwwkw', 'uploads/pendaftaran/1747139611_tabel_konsultasi.pdf', '2025-05-13 04:51:14', '2025-05-13 05:33:31', 'diterima'),
(12, 14, 1, 'UKM Bina Darma Cyber Army (BDCA)', 'UKM Bina Darma Programmer (BDPRO)', 'Inovator Center (DIIB) - Bonus akan mendapatkan Jika jawaban anda sempurna', 'alamak', 'sedapnye', 'uploads/pendaftaran/1747141704_homework_it_security_fundamental_(decadev).pdf', '2025-05-13 06:08:24', '2025-05-13 06:12:07', 'diterima'),
(13, 14, 1, 'UKM Bina Darma Cyber Army (BDCA)', 'UKM Bina Darma Programmer (BDPRO)', 'UKM LDK ALQORIB', 'alamak', 'sedapnye', 'uploads/pendaftaran/1747142176_01-pendahuluan_-_tugas.pdf', '2025-05-13 06:16:16', '2025-05-13 06:17:14', 'diterima');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `kriteria` varchar(50) NOT NULL,
  `indikator` enum('favorable','unfavorable') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `kriteria`, `indikator`, `created_at`, `updated_at`) VALUES
(51, 'Saya suka membuat karya baru dari ide yang belum pernah ada sebelumnya.', 'Kreativitas', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(52, 'Saya mampu memecahkan masalah dengan pendekatan yang tidak biasa.', 'Kreativitas', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(53, 'Saya menikmati kegiatan seperti menggambar, menulis, atau mendesain.', 'Kreativitas', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(54, 'Saya sering punya ide-ide unik dalam diskusi kelompok.', 'Kreativitas', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(55, 'Saya bisa mengembangkan sesuatu dari hal sederhana menjadi luar biasa.', 'Kreativitas', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(56, 'Saya mampu membuat inovasi kecil yang membantu pekerjaan saya.', 'Kreativitas', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(57, 'Saya kesulitan menemukan ide baru saat menghadapi tantangan.', 'Kreativitas', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(58, 'Saya lebih suka mengikuti pola yang sudah ada daripada membuat sendiri.', 'Kreativitas', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(59, 'Saya jarang berpikir out of the box.', 'Kreativitas', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(60, 'Saya merasa bingung ketika harus menciptakan sesuatu dari nol.', 'Kreativitas', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(61, 'Saya tidak suka mencoba hal baru.', 'Kreativitas', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(62, 'Saya menghindari kegiatan yang membutuhkan imajinasi tinggi.', 'Kreativitas', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(63, 'Saya merasa tidak berbakat dalam bidang seni atau kreativitas.', 'Kreativitas', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(64, 'Saya aktif dalam kegiatan organisasi di luar kegiatan akademik.', 'Keaktifan', 'favorable', '2025-05-20 14:08:44', '2025-05-20 15:20:47'),
(65, 'Saya senang terlibat dalam organisasi atau komunitas.', 'Keaktifan', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(66, 'Saya merasa semangat saat bekerja dalam tim.', 'Keaktifan', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(67, 'Saya selalu hadir dalam rapat organisasi tepat waktu.', 'Keaktifan', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(68, 'Saya sering mengambil peran penting dalam kegiatan bersama.', 'Keaktifan', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(69, 'Saya tidak ragu mengambil inisiatif dalam kelompok.', 'Keaktifan', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(70, 'Saya jarang hadir dalam kegiatan organisasi.', 'Keaktifan', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 15:21:06'),
(71, 'Saya merasa malas terlibat dalam kegiatan organisasi.', 'Keaktifan', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(72, 'Saya hanya aktif jika diminta oleh orang lain.', 'Keaktifan', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(73, 'Saya lebih suka menjadi pengikut daripada pemimpin.', 'Keaktifan', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(74, 'Saya menghindari tanggung jawab tambahan di luar akademik.', 'Keaktifan', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(75, 'Saya merasa organisasi hanya membuang waktu.', 'Keaktifan', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(76, 'Saya tertarik dengan perkembangan teknologi terbaru.', 'Teknologi', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(77, 'Saya suka mencoba software atau aplikasi baru.', 'Teknologi', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(78, 'Saya mampu menggunakan alat teknologi untuk menyelesaikan tugas.', 'Teknologi', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(79, 'Saya bisa mengoperasikan komputer dengan baik.', 'Teknologi', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(80, 'Saya tertarik belajar jaringan dan pemrograman.', 'Teknologi', 'favorable', '2025-05-20 14:08:44', '2025-05-20 15:21:48'),
(81, 'Saya sering membantu orang lain menyelesaikan masalah teknologi.', 'Teknologi', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(82, 'Saya merasa kesulitan memahami teknologi baru.', 'Teknologi', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(83, 'Saya jarang menggunakan komputer/laptop untuk hal produktif.', 'Teknologi', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(84, 'Saya tidak tertarik dengan hal-hal yang berbau teknologi.', 'Teknologi', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(85, 'Saya sering bingung saat harus menggunakan aplikasi baru.', 'Teknologi', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(86, 'Saya menghindari tugas yang berhubungan dengan teknologi.', 'Teknologi', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(87, 'Saya merasa teknologi itu membingungkan.', 'Teknologi', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(88, 'Saya punya banyak ide untuk meningkatkan sistem yang ada.', 'Inovatif', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(89, 'Saya sering memberi masukan baru yang bermanfaat dalam organisasi.', 'Inovatif', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(90, 'Saya percaya bahwa perubahan bisa membawa kemajuan.', 'Inovatif', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(91, 'Saya suka bereksperimen dengan cara kerja baru.', 'Inovatif', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(92, 'Saya terbiasa mengembangkan sesuatu agar lebih efisien.', 'Inovatif', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(93, 'Saya berani mengambil risiko dengan pendekatan baru.', 'Inovatif', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(94, 'Saya lebih suka menjalankan sistem lama daripada mencoba hal baru.', 'Inovatif', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(95, 'Saya tidak percaya perubahan akan membawa hasil baik.', 'Inovatif', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(96, 'Saya jarang memikirkan solusi baru atas suatu masalah.', 'Inovatif', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(97, 'Saya cenderung menunggu instruksi daripada membuat inisiatif.', 'Inovatif', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(98, 'Saya merasa inovasi itu rumit dan tidak perlu.', 'Inovatif', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(99, 'Saya tidak suka jika ada ide perubahan dalam organisasi.', 'Inovatif', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(100, 'Saya cepat puas dengan kondisi yang ada.', 'Inovatif', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(101, 'Saya rutin berolahraga setiap minggu.', 'Fisik & Olahraga', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(102, 'Saya memiliki stamina yang cukup untuk kegiatan lapangan.', 'Fisik & Olahraga', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(103, 'Saya suka mengikuti lomba atau kegiatan fisik.', 'Fisik & Olahraga', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(104, 'Saya merasa bugar dan energik saat beraktivitas.', 'Fisik & Olahraga', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(105, 'Saya tidak mudah lelah saat mengikuti kegiatan organisasi di luar ruangan.', 'Fisik & Olahraga', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(106, 'Saya terbiasa berlatih untuk meningkatkan kemampuan fisik.', 'Fisik & Olahraga', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(107, 'Saya mudah kelelahan saat berolahraga.', 'Fisik & Olahraga', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(108, 'Saya menghindari kegiatan yang membutuhkan kekuatan fisik.', 'Fisik & Olahraga', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(109, 'Saya jarang mengikuti kegiatan olahraga.', 'Fisik & Olahraga', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(110, 'Saya tidak menyukai kegiatan di luar ruangan.', 'Fisik & Olahraga', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(111, 'Saya merasa fisik saya tidak cukup kuat untuk organisasi tertentu.', 'Fisik & Olahraga', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 15:22:40'),
(112, 'Saya kurang percaya diri dalam kegiatan fisik.', 'Fisik & Olahraga', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(113, 'Saya percaya diri berbicara di depan umum.', 'Komunikasi & Public Speaking', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(114, 'Saya mampu menjelaskan ide dengan jelas di depan orang lain.', 'Komunikasi & Public Speaking', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(115, 'Saya suka menjadi pembicara dalam kegiatan organisasi.', 'Komunikasi & Public Speaking', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(116, 'Saya tidak gugup ketika diminta presentasi.', 'Komunikasi & Public Speaking', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(117, 'Saya bisa berkomunikasi secara efektif dalam tim.', 'Komunikasi & Public Speaking', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(118, 'Saya terbiasa memimpin diskusi kelompok.', 'Komunikasi & Public Speaking', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(119, 'Saya sering gugup saat berbicara di depan umum.', 'Komunikasi & Public Speaking', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(120, 'Saya lebih suka mendengarkan daripada berbicara.', 'Komunikasi & Public Speaking', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(121, 'Saya menghindari posisi yang harus berbicara di depan banyak orang.', 'Komunikasi & Public Speaking', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(122, 'Saya merasa tidak pandai berbicara dengan kata-kata yang baik.', 'Komunikasi & Public Speaking', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(123, 'Saya cenderung diam dalam diskusi kelompok.', 'Komunikasi & Public Speaking', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(124, 'Saya takut membuat kesalahan saat berbicara.', 'Komunikasi & Public Speaking', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(125, 'Saya aktif dalam kegiatan keagamaan.', 'Religiusitas', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(126, 'Saya merasa agama penting dalam kehidupan sehari-hari.', 'Religiusitas', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(127, 'Saya mengikuti kajian atau kegiatan rohani secara rutin.', 'Religiusitas', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(128, 'Saya menjadikan nilai keagamaan sebagai pedoman hidup.', 'Religiusitas', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(129, 'Saya menghormati keyakinan orang lain.', 'Religiusitas', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(130, 'Saya merasa nyaman berada di lingkungan religius.', 'Religiusitas', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(131, 'Saya jarang mengikuti kegiatan ibadah bersama.', 'Religiusitas', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(132, 'Saya menganggap kegiatan rohani tidak terlalu penting.', 'Religiusitas', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(133, 'Saya kurang memahami ajaran agama saya.', 'Religiusitas', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(134, 'Saya merasa kegiatan keagamaan hanya membuang waktu.', 'Religiusitas', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(135, 'Saya tidak pernah terlibat dalam kegiatan keagamaan kampus.', 'Religiusitas', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(136, 'Saya tidak suka berdiskusi soal agama.', 'Religiusitas', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(137, 'Saya tidak percaya kegiatan religius bisa mengubah perilaku.', 'Religiusitas', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(138, 'Saya suka memainkan alat musik.', 'Seni & Musik', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(139, 'Saya aktif dalam kegiatan seni atau musik.', 'Seni & Musik', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(140, 'Saya suka bernyanyi atau menari di depan umum.', 'Seni & Musik', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(141, 'Saya menikmati menonton pertunjukan seni.', 'Seni & Musik', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(142, 'Saya pernah tampil dalam panggung seni atau lomba.', 'Seni & Musik', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(143, 'Saya punya ketertarikan besar terhadap dunia seni.', 'Seni & Musik', 'favorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(144, 'Saya tidak tertarik dengan seni atau musik.', 'Seni & Musik', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(145, 'Saya tidak bisa memainkan alat musik apa pun.', 'Seni & Musik', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(146, 'Saya merasa malu jika tampil di depan umum.', 'Seni & Musik', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(147, 'Saya tidak punya bakat di bidang seni.', 'Seni & Musik', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(148, 'Saya lebih suka kegiatan teknis daripada seni.', 'Seni & Musik', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(149, 'Saya tidak pernah ikut kegiatan seni di kampus.', 'Seni & Musik', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44'),
(150, 'Saya merasa seni itu tidak terlalu penting.', 'Seni & Musik', 'unfavorable', '2025-05-20 14:08:44', '2025-05-20 14:08:44');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `recommended_1` varchar(255) NOT NULL,
  `recommended_2` varchar(255) NOT NULL,
  `recommended_3` varchar(255) NOT NULL,
  `show_innovator_center` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `user_id`, `recommended_1`, `recommended_2`, `recommended_3`, `show_innovator_center`, `created_at`, `updated_at`) VALUES
(41, 14, 'UKM Bina Darma Cyber Army (BDCA)', 'UKM BTV', 'UKM Bina Darma Programmer (BDPRO)', 1, '2025-05-20 09:44:38', '2025-05-20 10:21:30');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CcJR3GLnJBMuWcwG69SU3G1CMOUomruVVTJrPVhY', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUncwS2tuMURINjBteWJxZ1B2YzM2WjhaZFp4eDhDSmR1enFPUlpBeCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1746357826),
('WZTJ9pDeR69zQjHjkv2W8Gay2tYJhMEMZXfIlgWA', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSmZOVEM3MU5EMU1RbGNvZ3VzUzVVd2NycDRrYWxDamU5dkpXd1pRaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1746357630);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `organization_1` varchar(100) DEFAULT NULL,
  `organization_2` varchar(100) DEFAULT NULL,
  `organization_3` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `user_id`, `profile_photo`, `nim`, `phone_number`, `jurusan`, `organization_1`, `organization_2`, `organization_3`, `created_at`, `updated_at`) VALUES
(1, 14, 'profile_photos/1747590085.jpg', '21121111', '081212111', 'Teknik Informatika', NULL, NULL, NULL, '2025-05-12 09:28:32', '2025-05-18 10:41:25'),
(3, 15, 'profile_photos/1747467182.png', '21123131', '8211121212', 'Teknik Industri', NULL, NULL, NULL, '2025-05-17 00:33:02', '2025-05-17 00:33:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `verification_token`, `remember_token`, `role`, `created_at`, `updated_at`) VALUES
(2, 'denny', 'dennytribtri@gmail.com', '2025-03-11 07:53:44', '$2y$12$7PaHL.2DyJOggk4DF.Wb1eRhggnQ5exL/rCq329xT0/Mhso14YiXq', NULL, NULL, 'superadmin', '2025-03-11 07:53:44', '2025-05-17 06:55:44'),
(4, 'koutsura', 'jerukbersyukur@gmail.com', '2025-05-04 06:42:28', '$2y$12$C9rdbXi.7xBuP4NhxMMY3OT.PsvutF5kGJE7ZOZFDW3Y0YzzKD.Tu', NULL, NULL, 'mahasiswa', '2025-05-04 06:42:28', '2025-05-17 06:54:48'),
(14, 'cloud', 'dennytriyyy@gmail.com', '2025-05-10 20:43:01', '$2y$12$Srn4qZj6L8dD1VuwQYUCWeUP8dioVtEbaLyB679QHTkrAhlfIiP.a', NULL, 'f51dbb599675e3543d2426841aabd2733d6342d321eb956f7b1180490c23118f', 'mahasiswa', '2025-05-10 20:43:01', '2025-05-18 10:57:01'),
(15, 'amu', 'henshin311@gmail.com', '2025-05-17 00:31:41', '$2y$12$oHMatqaw3kZsOiS8dWKiJOk5pAq7yldnDtwX8x.8erO70DowJlG.i', NULL, NULL, 'mahasiswa', '2025-05-17 00:31:41', '2025-05-17 00:34:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatives`
--
ALTER TABLE `alternatives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`,`token`);

--
-- Indexes for table `pendaftarans`
--
ALTER TABLE `pendaftarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `setting_id` (`setting_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatives`
--
ALTER TABLE `alternatives`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=451;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendaftarans`
--
ALTER TABLE `pendaftarans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pendaftarans`
--
ALTER TABLE `pendaftarans`
  ADD CONSTRAINT `pendaftarans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftarans_ibfk_2` FOREIGN KEY (`setting_id`) REFERENCES `settings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
