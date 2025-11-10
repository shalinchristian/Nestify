-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2025 at 06:48 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nestify`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `property_id`, `added_at`) VALUES
(20, 1, 18, '2025-04-02 05:49:37'),
(21, 1, 22, '2025-04-03 11:26:31'),
(22, 1, 16, '2025-04-05 04:24:10');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('sent','delivered','read') DEFAULT 'sent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `sender_id`, `receiver_id`, `property_id`, `message`, `timestamp`, `status`) VALUES
(1, 1, 12, 18, 'hello', '2025-03-28 06:50:36', 'sent'),
(2, 1, 12, 18, 'bolo', '2025-03-28 06:51:05', 'sent'),
(3, 12, 1, 18, 'shu kam che bolo', '2025-03-28 06:52:02', 'sent'),
(4, 12, 1, 18, 'hy', '2025-03-28 06:52:39', 'sent'),
(5, 1, 12, 17, 'hyyy', '2025-03-28 06:53:42', 'sent'),
(6, 1, 12, 17, 'sdvjnd', '2025-03-28 06:53:49', 'sent'),
(7, 12, 1, 17, 'sahajanand', '2025-03-28 06:54:45', 'sent'),
(8, 1, 12, 18, 'studio', '2025-03-28 06:55:10', 'sent'),
(9, 12, 1, 17, 'sahajanand height', '2025-03-28 07:58:39', 'sent'),
(10, 1, 12, 17, 'yes please', '2025-03-28 07:59:04', 'sent'),
(11, 1, 12, 18, 'studie', '2025-03-28 07:59:29', 'sent'),
(12, 5, 12, 18, 'hyy', '2025-03-28 08:08:16', 'sent'),
(13, 5, 12, 18, 'bolo', '2025-03-28 08:08:21', 'sent'),
(14, 12, 5, 18, 'studeio 17', '2025-03-28 09:24:23', 'sent'),
(15, 5, 12, 18, 'hyy', '2025-03-28 09:24:59', 'sent'),
(16, 12, 5, 18, 'bolo', '2025-03-28 09:25:08', 'sent'),
(17, 5, 12, 18, 'user', '2025-03-28 09:27:31', 'sent'),
(18, 12, 5, 18, 'agent', '2025-03-28 09:27:42', 'sent'),
(19, 1, 12, 18, 'user keval', '2025-03-28 09:35:30', 'sent'),
(20, 12, 1, 18, 'agent jasani', '2025-03-28 09:36:12', 'sent'),
(21, 12, 1, 18, 'agent 1', '2025-03-28 09:41:34', 'sent'),
(22, 5, 12, 18, 'user 1', '2025-03-28 09:42:24', 'sent'),
(23, 12, 5, 18, 'meet 1', '2025-03-28 09:43:57', 'sent'),
(24, 5, 12, 18, 'meet 2', '2025-03-28 09:44:52', 'sent'),
(25, 5, 12, 18, 'hy', '2025-03-28 09:48:16', 'sent'),
(26, 5, 12, 18, 'dcds', '2025-03-28 09:49:02', 'sent'),
(27, 5, 12, 18, 'dc', '2025-03-28 09:50:17', 'sent'),
(28, 5, 12, 18, 'ccc', '2025-03-28 09:51:38', 'sent'),
(29, 1, 12, 18, 'heyy???', '2025-03-28 09:56:53', 'sent'),
(30, 1, 12, 17, 'heyyy?', '2025-03-28 09:57:20', 'sent'),
(31, 1, 12, 18, 'hyy', '2025-03-31 10:40:30', 'sent'),
(32, 1, 12, 18, 'hyy', '2025-04-01 08:59:39', 'sent'),
(33, 12, 1, 18, 'gggg', '2025-04-01 09:04:06', 'sent'),
(34, 1, 12, 18, 'hyy', '2025-04-01 09:15:43', 'sent'),
(35, 1, 12, 18, 'hi', '2025-04-03 08:17:23', 'sent'),
(36, 12, 1, 18, 'hyy', '2025-04-03 08:18:17', 'sent'),
(37, 1, 12, 18, 'sk', '2025-04-04 08:11:25', 'sent'),
(38, 12, 1, 18, 'moj', '2025-04-04 08:13:01', 'sent'),
(39, 1, 12, 18, 'hyy', '2025-04-04 11:53:51', 'sent');

-- --------------------------------------------------------

--
-- Table structure for table `dealers`
--

CREATE TABLE `dealers` (
  `dealer_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `certificate_no` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dealers`
--

INSERT INTO `dealers` (`dealer_id`, `fullname`, `certificate_no`, `email`, `mobile`, `password`, `otp`, `verified`, `created_at`) VALUES
(12, 'Keval', 'GUJ/RERA/PRJ/2023/0001', 'kevaljasani3656@gmail.com', '8849787588', '$2y$10$V0U6SS1DAwTNmHB8Jf14f.VTpod8FIrX8kjlgb0pLlqFg5B.G.1Ey', '4446', 0, '2025-03-20 06:03:12'),
(13, 'Keval Jasani', 'GUJ/RERA/PRJ/2023/0002', 'sureshm9236@gmail.com', '1234567890', '$2y$10$CRsiL8f0kxeSaY3Iu.gTdu7fUegn/VpjJZTxZ2cFx5ZMuCesJy.YK', '3958', 0, '2025-03-20 10:52:54');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favorites_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`favorites_id`, `user_id`, `property_id`, `added_at`) VALUES
(23, 1, 17, '2025-04-03 11:30:08'),
(24, 1, 22, '2025-04-03 11:30:13');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `subject`, `message`, `submitted_at`) VALUES
(1, 1, 'about property details', 'i can\'t add property please fix it.....', '2025-02-28 11:59:23'),
(2, 1, 'xyz', 'seygtdj', '2025-03-19 08:49:02'),
(3, 1, 'about property details', 'Greate UI', '2025-04-03 11:22:37');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dealer_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `dealer_response` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `user_id`, `dealer_id`, `property_id`, `message`, `dealer_response`, `created_at`, `updated_at`) VALUES
(13, 1, 12, 17, 'Heyy', 'shu kam padyu', '2025-03-20 07:07:18', '2025-03-20 11:15:17'),
(15, 1, 12, 18, 'Km thay levu che ghar??', 'no way', '2025-03-20 11:16:45', '2025-03-20 11:25:43'),
(17, 5, 12, 18, 'heyy', 'bolo', '2025-03-28 08:02:58', '2025-03-28 08:03:29'),
(18, 1, 12, 16, 'hyy', NULL, '2025-04-05 04:24:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Completed','Failed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `property_id` int(11) NOT NULL,
  `dealer_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` enum('Apartment','House','Villa','Studio','Commercial') NOT NULL,
  `price` decimal(10,2) NOT NULL CHECK (`price` >= 0),
  `location` varchar(255) NOT NULL,
  `bedrooms` int(11) DEFAULT 0 CHECK (`bedrooms` >= 0),
  `bathrooms` int(11) DEFAULT 0 CHECK (`bathrooms` >= 0),
  `area` int(11) NOT NULL CHECK (`area` > 0),
  `furnished` enum('Yes','No','Semi') NOT NULL,
  `availability` enum('Available','Rented','Pending') DEFAULT 'Available',
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`property_id`, `dealer_id`, `title`, `description`, `category`, `price`, `location`, `bedrooms`, `bathrooms`, `area`, `furnished`, `availability`, `images`, `created_at`) VALUES
(16, 12, 'Sumeru House', '2 BHK House', 'House', 25000.00, 'Surat', 2, 2, 900, 'Yes', 'Available', '[\"uploads/property_67dbb006d8f70.jpeg\",\"uploads/property_67dbb006d94cb.jpeg\",\"uploads/property_67dbb006d973c.jpeg\"]', '2025-03-20 06:04:54'),
(17, 12, 'Sahajanand Heights', 'Your Dream House', 'Apartment', 20000.00, 'Anand', 3, 2, 1500, 'Semi', 'Available', '[\"uploads/property_67dbb0d8bb7a8.jpg\",\"uploads/property_67dbb0d8bb9b8.jpg\",\"uploads/property_67dbb0d8bbb8f.jpg\"]', '2025-03-20 06:08:24'),
(18, 12, 'Studio', 'Welcome to our home', 'Studio', 17000.00, 'mota varachha', 1, 1, 500, 'Yes', 'Available', '[\"uploads/property_67dbb14b40cd1.jpg\",\"uploads/property_67dbb14b40ea6.jpeg\"]', '2025-03-20 06:10:19'),
(19, 12, 'Khodal House', 'Farm House', 'Villa', 29000.00, 'nadiad', 4, 3, 1900, 'Yes', 'Pending', '[\"uploads/property_67dbb184f0135.jpg\",\"uploads/property_67dbb184f12e5.jpeg\",\"uploads/property_67dbb184f26ed.jpeg\",\"uploads/property_67dbb184f2984.jpg\"]', '2025-03-20 06:11:16'),
(22, 12, 'Ashirwad Villa', 'jem tem', 'Villa', 45000.00, 'Surat', 2, 1, 1100, 'Yes', 'Available', '[\"uploads/property_67ee6d23edcca.jpg\",\"uploads/property_67ee6d23edf7a.jpg\",\"uploads/property_67ee6d23ee21c.jpeg\"]', '2025-04-03 11:12:35');

-- --------------------------------------------------------

--
-- Table structure for table `property_visits`
--

CREATE TABLE `property_visits` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dealer_id` int(11) NOT NULL,
  `visit_date` date NOT NULL,
  `visit_time` time NOT NULL,
  `appointment_status` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_visits`
--

INSERT INTO `property_visits` (`id`, `property_id`, `user_id`, `dealer_id`, `visit_date`, `visit_time`, `appointment_status`, `created_at`) VALUES
(4, 17, 5, 12, '2025-04-22', '15:27:00', '', '2025-04-20 07:58:49'),
(5, 17, 5, 12, '2025-04-21', '13:31:00', '', '2025-04-20 08:00:00'),
(6, 17, 5, 12, '2025-05-01', '13:33:00', '', '2025-04-20 08:00:23'),
(7, 18, 5, 12, '2025-04-30', '14:29:00', '', '2025-04-20 08:55:53'),
(8, 19, 5, 12, '2025-05-07', '14:30:00', 'Confirm', '2025-04-20 08:56:02'),
(9, 17, 1, 12, '2025-04-22', '21:00:00', 'Confirm', '2025-04-20 12:24:40'),
(10, 18, 1, 12, '2025-04-23', '22:12:00', 'Confirm', '2025-04-21 12:38:33'),
(11, 16, 1, 12, '2025-04-22', '18:00:00', '', '2025-04-21 18:14:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `otp` int(11) NOT NULL,
  `Verified` tinyint(1) DEFAULT 0,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Name`, `Email`, `Password`, `otp`, `Verified`, `Created_at`) VALUES
(1, 'Keval Jasani', 'hiteshvasani581@gmail.com', '$2y$10$oSmduJTB7/iaqdgu7wwl/uMeopd57dskGecSkpsj1ybpq9omrbY6O', 379293, 1, '2025-03-19 08:50:48'),
(5, 'meet', 'tapijk666@gmail.com', '$2y$10$xkGi3psH.GGz9nhrMxbQwOnqw8Fy1pgJcwDjFDWb40iAMe2vLowmO', 3444, 1, '2025-03-28 08:02:11'),
(6, 'keval', 'yebofax743@dizigg.com', '$2y$10$mugKZRcsJ9fWeDZmnVKnZ.zPJdayAkGsjFHEsqPezhM8hRUvqi/dq', 5878, 0, '2025-04-03 10:44:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `dealers`
--
ALTER TABLE `dealers`
  ADD PRIMARY KEY (`dealer_id`),
  ADD UNIQUE KEY `certificate_no` (`certificate_no`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorites_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `dealer_id` (`dealer_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`property_id`),
  ADD KEY `dealer_id` (`dealer_id`);

--
-- Indexes for table `property_visits`
--
ALTER TABLE `property_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`),
  ADD KEY `dealer_id` (`dealer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `dealers`
--
ALTER TABLE `dealers`
  MODIFY `dealer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorites_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `property_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `property_visits`
--
ALTER TABLE `property_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`);

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`dealer_id`) REFERENCES `dealers` (`dealer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_ibfk_3` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE;

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`dealer_id`) REFERENCES `dealers` (`dealer_id`) ON DELETE CASCADE;

--
-- Constraints for table `property_visits`
--
ALTER TABLE `property_visits`
  ADD CONSTRAINT `property_visits_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`),
  ADD CONSTRAINT `property_visits_ibfk_2` FOREIGN KEY (`dealer_id`) REFERENCES `dealers` (`dealer_id`),
  ADD CONSTRAINT `property_visits_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
