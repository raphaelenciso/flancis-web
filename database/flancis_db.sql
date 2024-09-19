-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2024 at 05:37 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flancis_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments_tbl`
--

CREATE TABLE `appointments_tbl` (
  `appointment_id` char(16) NOT NULL DEFAULT substr(md5(rand()),1,16),
  `user_id` varchar(36) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `service_id` varchar(36) NOT NULL,
  `payment_type` varchar(36) NOT NULL,
  `remarks` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `admin_note` text DEFAULT NULL,
  `is_rated` tinyint(1) NOT NULL DEFAULT 0,
  `proof` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments_tbl`
--

INSERT INTO `appointments_tbl` (`appointment_id`, `user_id`, `appointment_date`, `appointment_time`, `service_id`, `payment_type`, `remarks`, `status`, `admin_note`, `is_rated`, `proof`, `created_at`, `updated_at`) VALUES
('db07ad93b8038096', 'b86943b85e58988a', '2024-09-10', '11:30:00', '2a374422d2f66bac', 'gcash', 'Nail Art', 'completed', NULL, 1, 'images/appointment-proofs/1726673138_e79dd102b35213f815291e0fb4bd12df.jpg', '2024-09-18 07:25:38', '2024-09-18 07:27:43');

-- --------------------------------------------------------

--
-- Table structure for table `employees_tbl`
--

CREATE TABLE `employees_tbl` (
  `employee_id` char(16) NOT NULL DEFAULT substr(md5(rand()),1,16),
  `employee_first_name` varchar(100) NOT NULL,
  `employee_last_name` varchar(100) NOT NULL,
  `employee_middle_name` varchar(100) DEFAULT NULL,
  `gender` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `birthday` date NOT NULL,
  `role` varchar(20) NOT NULL,
  `employee_image` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees_tbl`
--

INSERT INTO `employees_tbl` (`employee_id`, `employee_first_name`, `employee_last_name`, `employee_middle_name`, `gender`, `email`, `phone`, `address`, `birthday`, `role`, `employee_image`, `created_at`, `updated_at`) VALUES
('70aedb6e43e856ce', 'Mary Loi', 'Ricalde', 'Yves', 'female', 'maloi@bini.com', '09987654321', '123 sample address street sampaloc manila', '1995-01-01', 'Manicurist', 'maloi@bini.com.jpg', '2024-09-18 07:31:09', '2024-09-18 07:31:09');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_09_17_051652_create_users_tbl', 1),
(3, '2024_09_17_051702_create_service_types_tbl', 1),
(4, '2024_09_17_051703_create_services_tbl', 1),
(5, '2024_09_17_051704_create_appointments_tbl', 1),
(6, '2024_09_17_051705_create_service_ratings_tbl', 1),
(7, '2024_09_17_051707_create_employees_tbl', 1),
(8, '2024_09_18_142558_create_resources_tbl', 1),
(9, '2024_09_18_144044_create_promos_tbl', 1),
(10, '2024_09_18_145535_create_promo_service_tbl_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promos_tbl`
--

CREATE TABLE `promos_tbl` (
  `promo_id` char(16) NOT NULL DEFAULT substr(md5(rand()),1,16),
  `promo_name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `percent_discount` decimal(5,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promo_service_tbl`
--

CREATE TABLE `promo_service_tbl` (
  `service_id` varchar(36) NOT NULL,
  `promo_id` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resources_tbl`
--

CREATE TABLE `resources_tbl` (
  `resource_id` char(16) NOT NULL DEFAULT substr(md5(rand()),1,16),
  `resource_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` enum('available','unavailable') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resources_tbl`
--

INSERT INTO `resources_tbl` (`resource_id`, `resource_name`, `quantity`, `status`, `created_at`, `updated_at`) VALUES
('dcb2df50624b2e5e', 'Conference Room B', 1, 'unavailable', '2024-09-18 07:28:20', '2024-09-18 07:28:42');

-- --------------------------------------------------------

--
-- Table structure for table `services_tbl`
--

CREATE TABLE `services_tbl` (
  `service_id` char(16) NOT NULL DEFAULT substr(md5(rand()),1,16),
  `service_name` varchar(100) NOT NULL,
  `service_type_id` varchar(36) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `rating` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services_tbl`
--

INSERT INTO `services_tbl` (`service_id`, `service_name`, `service_type_id`, `price`, `rating`, `description`, `status`, `created_at`, `updated_at`) VALUES
('2a374422d2f66bac', 'Manicure', '12d8ce6fba600710', 150.00, NULL, NULL, 'active', '2024-09-18 07:23:09', '2024-09-18 07:23:09'),
('b97c3c4d4b3ef1e3', 'Back Massage', '7c3c1123192ec492', 500.00, NULL, 'Back massage', 'active', '2024-09-18 07:23:34', '2024-09-18 07:23:52'),
('fbecaf134a5eafad', 'Pedicure', '35e1a01f9f256fc8', 250.00, NULL, NULL, 'active', '2024-09-18 07:23:17', '2024-09-18 07:23:22');

-- --------------------------------------------------------

--
-- Table structure for table `service_ratings_tbl`
--

CREATE TABLE `service_ratings_tbl` (
  `rating_id` char(16) NOT NULL DEFAULT substr(md5(rand()),1,16),
  `appointment_id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `service_id` varchar(36) NOT NULL,
  `rating` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_ratings_tbl`
--

INSERT INTO `service_ratings_tbl` (`rating_id`, `appointment_id`, `user_id`, `service_id`, `rating`, `description`, `created_at`, `updated_at`) VALUES
('dd2bcf9a24a4591d', 'db07ad93b8038096', 'b86943b85e58988a', '2a374422d2f66bac', 4, 'Good', '2024-09-18 07:27:43', '2024-09-18 07:27:43');

-- --------------------------------------------------------

--
-- Table structure for table `service_types_tbl`
--

CREATE TABLE `service_types_tbl` (
  `service_type_id` char(16) NOT NULL DEFAULT substr(md5(rand()),1,16),
  `service_type` varchar(36) NOT NULL,
  `service_image` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_types_tbl`
--

INSERT INTO `service_types_tbl` (`service_type_id`, `service_type`, `service_image`, `status`, `created_at`, `updated_at`) VALUES
('12d8ce6fba600710', 'Hand Care', 'images/service-types/1726672956_handcare.jpg', 'active', '2024-09-18 07:22:36', '2024-09-18 07:22:36'),
('35e1a01f9f256fc8', 'Foot Care', 'images/service-types/1726672967_footcare.jpg', 'active', '2024-09-18 07:22:47', '2024-09-18 07:22:47'),
('7c3c1123192ec492', 'Body Massage', 'images/service-types/1726672979_massage.jpg', 'active', '2024-09-18 07:22:59', '2024-09-18 07:22:59');

-- --------------------------------------------------------

--
-- Table structure for table `users_tbl`
--

CREATE TABLE `users_tbl` (
  `user_id` char(16) NOT NULL DEFAULT substr(md5(rand()),1,16),
  `username` varchar(36) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` varchar(16) NOT NULL,
  `email` varchar(36) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `birthday` date NOT NULL,
  `address` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `role` varchar(36) NOT NULL DEFAULT 'customer',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_tbl`
--

INSERT INTO `users_tbl` (`user_id`, `username`, `first_name`, `middle_name`, `last_name`, `gender`, `email`, `phone`, `birthday`, `address`, `password`, `picture`, `role`, `created_at`, `updated_at`) VALUES
('b86943b85e58988a', 'raphaelenciso', 'Raphael', NULL, 'Enciso', 'male', 'psyruz18@gmail.com', '09273707664', '2002-06-22', '1047 samar st. sampaloc manila', '$2y$12$yYxy1xH5Mlgr4iGBLTPNRuK7Zo/fl.Lto.AuP1tVT9XYG.rJ0PltO', 'b86943b85e58988a.jpg', 'customer', '2024-09-18 07:21:42', '2024-09-18 07:28:55'),
('d01943b2fe58c88a', 'admin', 'admin', NULL, 'admin', 'male', 'admin@gmail.com', '09123456789', '2002-06-22', 'admin', '$2y$12$yYxy1xH5Mlgr4iGBLTPNRuK7Zo/fl.Lto.AuP1tVT9XYG.rJ0PltO', 'b86943b85e58988a.jpg', 'admin', '2024-09-18 07:21:42', '2024-09-18 07:28:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments_tbl`
--
ALTER TABLE `appointments_tbl`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `appointments_tbl_user_id_foreign` (`user_id`),
  ADD KEY `appointments_tbl_service_id_foreign` (`service_id`);

--
-- Indexes for table `employees_tbl`
--
ALTER TABLE `employees_tbl`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `promos_tbl`
--
ALTER TABLE `promos_tbl`
  ADD PRIMARY KEY (`promo_id`);

--
-- Indexes for table `promo_service_tbl`
--
ALTER TABLE `promo_service_tbl`
  ADD PRIMARY KEY (`promo_id`,`service_id`),
  ADD KEY `promo_service_tbl_service_id_foreign` (`service_id`);

--
-- Indexes for table `resources_tbl`
--
ALTER TABLE `resources_tbl`
  ADD PRIMARY KEY (`resource_id`);

--
-- Indexes for table `services_tbl`
--
ALTER TABLE `services_tbl`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `services_tbl_service_type_id_foreign` (`service_type_id`);

--
-- Indexes for table `service_ratings_tbl`
--
ALTER TABLE `service_ratings_tbl`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `service_ratings_tbl_appointment_id_foreign` (`appointment_id`),
  ADD KEY `service_ratings_tbl_user_id_foreign` (`user_id`),
  ADD KEY `service_ratings_tbl_service_id_foreign` (`service_id`);

--
-- Indexes for table `service_types_tbl`
--
ALTER TABLE `service_types_tbl`
  ADD PRIMARY KEY (`service_type_id`);

--
-- Indexes for table `users_tbl`
--
ALTER TABLE `users_tbl`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments_tbl`
--
ALTER TABLE `appointments_tbl`
  ADD CONSTRAINT `appointments_tbl_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services_tbl` (`service_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_tbl_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users_tbl` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `promo_service_tbl`
--
ALTER TABLE `promo_service_tbl`
  ADD CONSTRAINT `promo_service_tbl_promo_id_foreign` FOREIGN KEY (`promo_id`) REFERENCES `promos_tbl` (`promo_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promo_service_tbl_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services_tbl` (`service_id`) ON DELETE CASCADE;

--
-- Constraints for table `services_tbl`
--
ALTER TABLE `services_tbl`
  ADD CONSTRAINT `services_tbl_service_type_id_foreign` FOREIGN KEY (`service_type_id`) REFERENCES `service_types_tbl` (`service_type_id`) ON DELETE CASCADE;

--
-- Constraints for table `service_ratings_tbl`
--
ALTER TABLE `service_ratings_tbl`
  ADD CONSTRAINT `service_ratings_tbl_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments_tbl` (`appointment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_ratings_tbl_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services_tbl` (`service_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_ratings_tbl_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users_tbl` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
