-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 13, 2023 at 04:58 PM
-- Server version: 8.0.34-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wp`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_ads_frontend_form_submission`
--

CREATE TABLE `wp_ads_frontend_form_submission` (
  `id` bigint NOT NULL,
  `amount` int NOT NULL,
  `buyer` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `receipt_id` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `items` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `buyer_email` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `buyer_ip` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `city` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `hash_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `entry_at` date DEFAULT NULL,
  `entry_by` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_ads_frontend_form_submission`
--

INSERT INTO `wp_ads_frontend_form_submission` (`id`, `amount`, `buyer`, `receipt_id`, `items`, `buyer_email`, `buyer_ip`, `note`, `city`, `phone`, `hash_key`, `entry_at`, `entry_by`) VALUES
(1, 4500, 'Hasib', '123454', '20', 'newbuyer@buy.com', '::1', 'Awesome things are going to happen today.', 'Dhaka', '01743909015', '358700fc6036bc170f85a322d57b2e8f232c2b421b43fe265050b7a2ded97f4c0f687e8f620970a29c81c590f083dc1d8e589510af3378a41001da6cef6b7d2f', '2023-09-13', 1),
(2, 50000, 'Rakibul Islam', '23145', '50', 'rakibul32@gmail.com', '::1', 'Hello world', 'Khulna', '+8801743909015', '0648eb9a1e713a04db88329f147137ef3fa2a25907de85add80e492a8aa2475b68f96686d37d53156e94351edf837d8ffc25ad0dd1330b9a30623ece452a6955', '2023-09-07', 1),
(3, 90000, 'Jahidul Islam', '23146', '55', 'zlt2o@5e3d.com', '::1', '0sxKJjtxRA', 'Feni', '0902738184', '0f9f51f52cd8003b9c0bada8e8f1cca9feb209eff50bdef2c33c0c8c78c991d765f83514d83c2ce3fb016a6f04e0bbb3d92682031d13fd972baf53e7905827c6', '2023-09-13', 1),
(11, 90000, 'Sajidul Islam', '23146', '55', 'zlt2o@5e3d.com', NULL, '0sxKJjtxRA', 'Gazipur', '0902738184', NULL, '2023-09-13', 1),
(13, 90000, 'Jaker Ali', '34564', '80', 'xu3k2@iboy.com', NULL, 'yG07gD1jlo', 'Chandpur', '3312654182', NULL, '2023-09-13', 1),
(14, 90000, 'Shahin Khan', '23146', '55', 'shahin@5e3d.com', NULL, 'Good progress', 'Manchester', '0902738184', NULL, '2023-09-13', 1),
(15, 85000, 'Hasin Hydar', '239876', '100', 'hasin@hydar.com', NULL, 'Request to review throughly', 'Rajshahi', '+8801743984656', NULL, '2023-09-13', 1),
(16, 120000, 'Rashed Khan', '129087', '1000', 'rashed@khan.com', '::1', 'There was a fantastic option to sale the products', 'Narshindi', '88087123576', '98c79c2a36d9a4248df1123d5f977517c03c1b546f6144c925740d33b964961b918b7ee5e2c0ffec4123b9d9d8d42c4c28758c13e91823c81d6eff44ab911094', '2023-09-13', 1),
(17, 120500, 'Rasel Khan', '159087', '1000', 'rasel@khan.com', '::1', 'There was a fantastic option to sale the products', 'Bagerhat', '88087123453', '999014b9589d3d9d9880058b13b5eebaa68b8585785ce6286ebf0e2e03810ef6febbd6b391b308a1e4e18bfca35ef86f705392813b8411de6a37bea2c51e4ce7', '2023-09-13', 1),
(18, 120900, 'Elias Ali Khan', '179087', '120', 'elias@khan.com', '::1', 'There was a fantastic option to sale', 'Dinajpur', '88087122314', '7f7651f6260542bda312fcc2788c66f6c196ca550ad961a07c5a30b50eae94045db2f5e1e85ef37f77eb290efe73b6b6714c4cbda46e2e03bed8e3e2cb410fd1', '2023-09-13', 1),
(19, 7890, 'Jaman Mir', '908765', '45', 'jaman@mir.com', '::1', 'Sales was a fun', 'Khulna', '88087669766', '94d710178e9953c1d9cef8e62c04fc70405184753a928f914bb00d0f2c8fd32203a7db19b37b0ba15e81f98ccdbb2fe3f5051027e06de1bab4de8ec6caa567ae', '2023-09-13', 1),
(20, 145324, 'Rinki', '906545', '35', 'uoo0d@78mz.com', '::1', '7wN3TyYCmC', 'Chittagong', '88056543435555', '4a8fce275e11be15fdbe7ec98348e8b496faf715be87310de4e31302b9d0ca841300657bbe52473e213b00ebecfd7ae0ee4e37350133bf0e7cbc4c872f295c36', '2023-09-13', 1),
(21, 145329, 'Haris Mifta', '906542', '38', 'uoo0d@78mz.com', '::1', 'BFg7UvcUay', 'Chittagong', '88056543435555', '8c36cece0f07d9ca178fb55ab6888c213e0a7504ece1581a796a25bf45e8a9ea5ee5291d4bec78caccca2606fad512ba1451676d11a5718fc2afd5ec5cc2640b', '2023-09-13', 1),
(22, 127654, 'Harry Brook', '906542', '98', 'uoo0d@78mz.com', '::1', 'sYY8imtW4z', 'London', '88056543435435', '8c36cece0f07d9ca178fb55ab6888c213e0a7504ece1581a796a25bf45e8a9ea5ee5291d4bec78caccca2606fad512ba1451676d11a5718fc2afd5ec5cc2640b', '2023-09-13', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_ads_frontend_form_submission`
--
ALTER TABLE `wp_ads_frontend_form_submission`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_ads_frontend_form_submission`
--
ALTER TABLE `wp_ads_frontend_form_submission`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;