-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 05:29 AM
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
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `location` point NOT NULL,
  `details` text NOT NULL,
  `status` varchar(45) NOT NULL,
  `image` varchar(45) NOT NULL,
  `price` float NOT NULL,
  `date_added` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facility`
--

INSERT INTO `facility` (`id`, `name`, `location`, `details`, `status`, `image`, `price`, `date_added`, `date_updated`) VALUES
(1, 'c1', 0x0000000001010000000000000000d072400000000000788440, 'test', 'Available', '', 0, '2025-04-02', '0000-00-00'),
(2, 'c8', 0x0000000001010000000000000000e490400000000000a88440, 'test', 'Available', '', 0, '2025-04-02', '0000-00-00'),
(3, 'a1', 0x0000000001010000000000000000c08b400000000000005440, 'test', 'Available', '', 0, '2025-04-02', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `birthdate` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `age`, `birthdate`, `address`, `gender`, `email`, `password`, `created_at`, `username`) VALUES
(4, 'JL Abarcutie', 22, '2002-10-22', 'Brgy.Balingasag', 'male', 'jlcolocot@gmail.com', '$2y$10$SyUMImHn2TfIFP.rjHXDD.MAUMiCBtN9qkvDgJxCtvJ/beNvvYfgi', '2025-04-14 02:45:59', 'jaboljl'),
(6, 'Tado Capili', 22, '2002-02-17', 'dito lang', 'male', 'tadocapili@gmail.com', '$2y$10$GaI9GbPqI0Ep0odwd56mcOyE6xkc61oKwUSXWbMx58CHNc9e6XbrW', '2025-04-14 03:14:17', 'nezu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `facility`
--
ALTER TABLE `facility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
