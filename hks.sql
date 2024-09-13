-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2024 at 11:51 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hks`
--

-- --------------------------------------------------------

--
-- Table structure for table `food_orders`
--

CREATE TABLE `food_orders` (
  `username` varchar(255) NOT NULL DEFAULT 'username',
  `id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL DEFAULT 'id',
  `food_item` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `total_price` decimal(64,0) UNSIGNED DEFAULT NULL,
  `payment_status` enum('pending','0') CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `username` varchar(255) NOT NULL DEFAULT 'username',
  `id` int(11) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `check_in` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `check_out` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `total_price` decimal(64,0) DEFAULT NULL,
  `is_occupied` tinyint(1) DEFAULT '0',
  `payment_status` varchar(255) NOT NULL,
  `payment_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`username`, `id`, `room_number`, `room_type`, `check_in`, `check_out`, `total_price`, `is_occupied`, `payment_status`, `payment_number`) VALUES
('master', 1, '101', 'Single', '2024-08-26 05:56:42.000000', '2024-11-11 11:11:00', '50000', 1, 'pending', '66cc272a5579c'),
('master', 2, '102', 'Single', '2024-08-26 06:11:48.000000', '2024-11-11 11:11:00', '50000', 1, 'pending', '66cc2ab49c1eb'),
('master', 3, '103', 'Double', '2024-08-26 06:30:28.000000', '2024-11-11 11:11:00', '80000', 1, 'pending', '66cc2f147b29a'),
('username', 4, '104', 'Double', '2024-08-17 10:13:17.000000', '2024-08-17 13:13:17', '80000', 0, '0', ''),
('username', 5, '105', 'Single', '2024-08-17 10:13:11.000000', '2024-08-17 13:13:11', '50000', 0, '0', ''),
('username', 6, '106', 'Single', '2024-08-16 19:17:23.000000', '2024-08-16 22:17:23', '50000', 0, '0', ''),
('username', 7, '107', 'Double', '2024-08-16 19:17:52.000000', '2024-08-16 22:17:52', '80000', 0, '0', ''),
('username', 8, '108', 'Double', '2024-08-19 10:26:10.714094', '2024-08-19 13:26:10', '80000', 0, '0', ''),
('username', 9, '109', 'Double', '2024-08-16 19:18:03.000000', '2024-08-16 22:18:03', '80000', 0, '0', ''),
('username', 10, '110', 'Double', '2024-08-16 19:18:08.000000', '2024-08-16 22:18:08', '80000', 0, '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `phone` int(255) NOT NULL,
  `Region` varchar(30) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `phone`, `Region`, `password`) VALUES
(1, 'MASTER', 687030949, 'MBEYA', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4'),
(2, '211002', 785032309, 'MBEYA', 'cbfad02f9ed2a8d1e08d8f74f5303e9eb93637d47f82ab6f1c15871cf8dd0481'),
(3, 'silvester', 687030949, 'arusha', '61503690505f84b144e6ac89124540a3eb8d22e77db76500984cfc50a1d8776e'),
(4, 'JOHN', 748485959, 'MBEYA', 'cbfad02f9ed2a8d1e08d8f74f5303e9eb93637d47f82ab6f1c15871cf8dd0481');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `food_orders`
--
ALTER TABLE `food_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `food_orders`
--
ALTER TABLE `food_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
