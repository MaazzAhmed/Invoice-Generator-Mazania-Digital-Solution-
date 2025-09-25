-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2025 at 03:14 PM
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
-- Database: `invoice_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `full_name` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `exp_date` varchar(250) NOT NULL,
  `reset_link_token` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `full_name`, `email`, `password`, `created_date`, `exp_date`, `reset_link_token`) VALUES
(1, 'maaz', 'maaza42101@gmail.com', '$2y$10$VkbVvAvOpoeiEFdWioFCDuePwg59Q9f.C/qcxO6PUb4bcqqAbWz3W', '07-Nov-2023 04:18: PM', '', ''),
(2, 'maaz', 'maaza4@gmail.com', '$2y$10$T/WquVrb28KG5dbrJTr6CuDQAFTet/o99de.PvjnmmPwzdYulA1hy', '07-Nov-2023 04:19: PM', '', ''),
(3, 'dani', 'd@gmail.com', '$2y$10$1iqluZ8lcjYXHi1HufGq3urDTcXJjhb.oEjEBmvxp01jeglKIwV8W', '07-Nov-2023 06:49: PM', '', ''),
(4, 'abc', 'abc@gmail.com', '$2y$10$mX44Mc4JzJ/57fwoe0Q3tuAsrl/9fuEvmR0kCkQPmDdrwZ5wPtaEq', '08-Nov-2023 10:58: AM', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `email_setting`
--

CREATE TABLE `email_setting` (
  `id` int(11) NOT NULL,
  `host` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `port` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_setting`
--

INSERT INTO `email_setting` (`id`, `host`, `username`, `password`, `port`, `subject`, `body`) VALUES
(1, 'Your Host', 'Username', 'Your Password', 0, 'this is dummy subject', 'YOur Body');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `client_name` varchar(100) DEFAULT NULL,
  `client_email` varchar(100) DEFAULT NULL,
  `pdf_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `client_name`, `client_email`, `pdf_path`, `created_at`) VALUES
(63, 'dm', 'dm@gmail.com', 'uploads/dm_invoice.pdf', '2024-11-18 12:33:12'),
(64, 'dmdd', 'dm@gmail.com', 'uploads/dmdd_invoice.pdf', '2024-11-18 12:34:44'),
(149, 'dm', 'dm@gmail.com', 'uploads/dm.pdf', '2024-11-25 11:02:16'),
(150, 'dm', 'dm@gmail.com', 'uploads/dm.pdf', '2024-11-25 11:28:48'),
(325, 'dm', 'dm@gmail.com', 'uploads/dm_2025-09-25.pdf', '2025-09-25 13:14:07');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_temp`
--

CREATE TABLE `password_reset_temp` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `expDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `password_reset_temp`
--

INSERT INTO `password_reset_temp` (`id`, `email`, `key`, `expDate`) VALUES
(17, 'maaza42101@gmail.com', '61e65e682869665970664ea8bee0a5023752594c39', '2023-11-26 08:45:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `roles` varchar(200) NOT NULL,
  `user_created_date` varchar(300) DEFAULT NULL,
  `loggedin_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `roles`, `user_created_date`, `loggedin_status`) VALUES
(27, 'Maaz', 'maaza42101@gmail.com', '$2y$10$1iqluZ8lcjYXHi1HufGq3urDTcXJjhb.oEjEBmvxp01jeglKIwV8W', '1', '02-Nov-2023 12:46: PM', 'logged_out');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_setting`
--
ALTER TABLE `email_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_temp`
--
ALTER TABLE `password_reset_temp`
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
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `email_setting`
--
ALTER TABLE `email_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=326;

--
-- AUTO_INCREMENT for table `password_reset_temp`
--
ALTER TABLE `password_reset_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
