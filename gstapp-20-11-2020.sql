-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2020 at 08:48 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gstapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `company_settings`
--

CREATE TABLE `company_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_logo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_no` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gstin` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_email` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gstin` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_registration_type_id` int(11) NOT NULL,
  `billing_street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_city` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_state` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_pincode` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_country` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_city` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_state` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_pincode` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_country` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `first_name`, `last_name`, `email`, `company`, `phone`, `mobile`, `display_name`, `website`, `gstin`, `gst_registration_type_id`, `billing_street`, `billing_city`, `billing_state`, `billing_pincode`, `billing_country`, `shipping_street`, `shipping_city`, `shipping_state`, `shipping_pincode`, `shipping_country`, `created_at`, `updated_at`) VALUES
(1, 1, 'Customer', 'Test', 'test@cust.com', NULL, NULL, '8855112244', 'test_customer', NULL, NULL, 1, 'rajkot', 'rajkot', 'rajkot', '3600008', 'India', 'rajkot', 'rajkot', 'rajkot', '546544', 'India', '2020-11-03 07:25:42', '2020-11-03 07:25:42'),
(2, 2, 'Test', 'Payee', 'testpayee@test.com', NULL, '9876543210', '9988217263', 'Test Payee', NULL, NULL, 3, 'Test address', 'Rajkot', 'Gujarat', '360004', 'India', 'where(\'user_id\',$user->id)', 'Rajkot', 'Gujarat', '360004', 'India', '2020-11-10 04:34:46', '2020-11-10 04:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` int(11) NOT NULL,
  `hire_date` date NOT NULL,
  `released` date DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `first_name`, `last_name`, `email`, `display_name`, `phone`, `mobile`, `street`, `city`, `state`, `pincode`, `country`, `gender`, `hire_date`, `released`, `date_of_birth`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 'Test', 'Emp', 'test@emp.com', 'test_emp', NULL, '7788994455', 'Ghatkopar', 'Mumbai', 'Maharstra', '8554654', 'India', 1, '2019-11-03', NULL, NULL, NULL, '2020-11-03 07:20:47', '2020-11-03 07:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `tax_id` int(11) NOT NULL,
  `tax_type` int(11) NOT NULL COMMENT '(1 => Exclusive, 2 => Inclusive, 3 => Out of scope)',
  `payee_id` int(11) NOT NULL,
  `payment_account_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expense_category` int(11) DEFAULT NULL,
  `amount_before_tax` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_amount` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `user_id`, `tax_id`, `tax_type`, `payee_id`, `payment_account_id`, `payment_date`, `payment_method`, `ref_no`, `expense_category`, `amount_before_tax`, `tax_amount`, `total`, `created_at`, `updated_at`) VALUES
(3, 2, 1, 1, 4, 1, '2020-11-09', '1', '123', NULL, '', '', '', '2020-11-09 08:04:59', '2020-11-09 08:04:59'),
(4, 2, 1, 1, 3, 1, '2020-11-09', '1', '123', NULL, '', '', '', '2020-11-09 08:06:03', '2020-11-09 08:06:03'),
(5, 2, 1, 1, 3, 1, '2020-11-09', '1', '123', NULL, '', '', '', '2020-11-09 08:07:19', '2020-11-09 08:07:19'),
(6, 2, 2, 1, 3, 1, '2020-11-09', '2', '123', NULL, '', '', '', '2020-11-09 08:08:00', '2020-11-09 08:08:00'),
(7, 2, 1, 1, 3, 1, '2020-11-11', '1', '00124', NULL, '300.00', '3.00', '303.00', '2020-11-10 04:36:49', '2020-11-10 06:25:13');

-- --------------------------------------------------------

--
-- Table structure for table `expense_items`
--

CREATE TABLE `expense_items` (
  `id` int(11) NOT NULL,
  `expense_id` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `quantity` varchar(10) NOT NULL,
  `rate` varchar(15) NOT NULL,
  `amount` varchar(15) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expense_items`
--

INSERT INTO `expense_items` (`id`, `expense_id`, `item_name`, `description`, `quantity`, `rate`, `amount`, `created_at`, `updated_at`) VALUES
(1, 6, 'Item 1', 'Description 1', '1', '100', '100', '2020-11-09 08:08:00', '2020-11-09 08:08:00'),
(2, 6, 'Item 2', 'Description 2', '2', '200', '400', '2020-11-09 08:08:00', '2020-11-09 08:08:00'),
(14, 7, 'Item 2', 'Description 2', '1', '200', '200', '2020-11-10 06:25:13', '2020-11-10 06:25:13'),
(15, 7, 'Item 1', 'Description 1', '1', '100', '100', '2020-11-10 06:25:13', '2020-11-10 06:25:13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_10_24_114001_create_expenses_table', 1),
(5, '2020_10_24_114001_create_payment_accounts_table', 1),
(6, '2020_10_27_053507_create_payees_table', 1),
(7, '2020_10_27_053507_create_taxes_table', 1),
(8, '2020_10_27_063754_create_suppliers_table', 1),
(9, '2020_10_27_063809_create_employees_table', 1),
(10, '2020_10_27_063822_create_customers_table', 1),
(11, '2020_11_02_065717_create_company_settings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('lalitv@webplanex.com', '$2y$10$nci8e6P/L5sX2cGTSPbyFOJMXSPmydwBwPGzm8WhFOK4kUzgNyOu2', '2020-11-05 08:20:59'),
('dineshs@webplanex.com', '$2y$10$Zski4ggQbSHqdDCQgDnMKOJqnK/iFpPRVT59u5hxcBPc0eVB3PEAi', '2020-11-10 06:41:16');

-- --------------------------------------------------------

--
-- Table structure for table `payees`
--

CREATE TABLE `payees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payees`
--

INSERT INTO `payees` (`id`, `user_id`, `name`, `type`, `type_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Aryan Haranesha', '1', 1, '2020-11-03 07:16:14', '2020-11-03 07:16:14'),
(2, 1, 'Test Emp', '2', 1, '2020-11-03 07:20:48', '2020-11-03 07:20:48'),
(3, 2, 'Customer Test', '3', 1, '2020-11-03 07:25:42', '2020-11-03 07:25:42'),
(4, 2, 'Test Payee', '3', 2, '2020-11-10 04:34:46', '2020-11-10 04:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `payment_accounts`
--

CREATE TABLE `payment_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_type` int(11) NOT NULL,
  `detail_type` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_tax_code` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `as_of` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_accounts`
--

INSERT INTO `payment_accounts` (`id`, `user_id`, `account_type`, `detail_type`, `name`, `description`, `default_tax_code`, `balance`, `as_of`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 3, 'Client trust accounts', 'Description', '1', '10000', '2020-11-04', '2020-11-04 06:54:01', '2020-11-04 06:54:01'),
(2, 2, 2, 4, 'Current', 'Bank current', '2', '1000', '2020-11-10', '2020-11-10 04:31:10', '2020-11-10 04:31:10');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_rate` int(11) DEFAULT NULL,
  `pan_no` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apply_tds_for_supplier` int(11) DEFAULT NULL,
  `gstin` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_registration_type_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `user_id`, `first_name`, `last_name`, `email`, `company`, `phone`, `mobile`, `display_name`, `website`, `street`, `city`, `state`, `pincode`, `country`, `billing_rate`, `pan_no`, `account_no`, `apply_tds_for_supplier`, `gstin`, `gst_registration_type_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Aryan', 'Haranesha', 'aryan@gmail.com', NULL, NULL, '7788994455', 'aryan', NULL, 'Rajnagar', 'Rajkot', 'gujarat', '360004', 'India', NULL, NULL, NULL, 0, NULL, 1, '2020-11-03 07:16:14', '2020-11-03 07:16:14');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` int(11) UNSIGNED NOT NULL,
  `tax_name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `tax_name`, `rate`, `status`, `created_at`, `updated_at`) VALUES
(1, 'GST', '6', 1, NULL, NULL),
(2, 'IGST', '6', 1, NULL, NULL),
(4, 'GST', '18', 1, '2020-11-10 18:30:00', NULL),
(5, 'IGST', '18', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mukund', 'mukund@admin.com', NULL, '$2y$10$.grfVTHax5oWQ5NaMXIQHOhiOcqapqMdTuMgwxJetHzWkTzqpMiSe', NULL, '2020-11-03 07:13:48', '2020-11-03 07:13:48'),
(2, 'Lalit Vaghela', 'lalitv@webplanex.com', NULL, '$2y$10$.xIyLpgev8V1alwuksJCUea5en4ZbeXBbUMCTNI2UI4Uy3khxPHXO', NULL, '2020-11-04 04:04:41', '2020-11-04 04:04:41'),
(3, 'Dinesh WebPlanex', 'dineshs@webplanex.com', NULL, '$2y$10$dWg0yVH6iuWI5mTAFL80VeFHjbQDihpUFO17vQKm/baQGmIReGG0u', NULL, '2020-11-10 06:40:46', '2020-11-10 06:40:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company_settings`
--
ALTER TABLE `company_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_items`
--
ALTER TABLE `expense_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payees`
--
ALTER TABLE `payees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_accounts`
--
ALTER TABLE `payment_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company_settings`
--
ALTER TABLE `company_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `expense_items`
--
ALTER TABLE `expense_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payees`
--
ALTER TABLE `payees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment_accounts`
--
ALTER TABLE `payment_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
