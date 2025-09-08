-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2025 at 04:23 PM
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
-- Database: `mental_health_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'Rifat', 'rifat@gmail.com', '1234'),
(2, 'Rifat', 'rifat5566123@gmail.com', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `mental_health_logs`
--

CREATE TABLE `mental_health_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `mood` enum('Happy','Sad','Neutral','Angry','Stressed') NOT NULL,
  `stress_level` enum('Low','Medium','High') NOT NULL,
  `sleep_hours` decimal(3,1) NOT NULL CHECK (`sleep_hours` >= 0 and `sleep_hours` <= 24),
  `additional_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mental_health_logs`
--

INSERT INTO `mental_health_logs` (`id`, `user_id`, `date`, `mood`, `stress_level`, `sleep_hours`, `additional_notes`) VALUES
(3, 1, '2024-12-31', 'Neutral', 'Medium', 6.0, 'Normal day did nothing.'),
(5, 2, '2025-01-01', 'Sad', 'High', 12.0, 'Fireworks killed innocent lives'),
(6, 1, '2025-01-02', 'Sad', 'Medium', 8.0, 'Must sleep for 9 hours tomorrow. Do need to exercise.'),
(7, 1, '2024-12-12', 'Sad', 'Medium', 12.0, 'testetsetsetsestestes.t'),
(8, 4, '2025-01-01', 'Happy', 'Medium', 10.0, '8 hour shifts\r\n'),
(9, 5, '2025-01-01', 'Happy', 'Low', 14.0, '');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` enum('picture','video','url') NOT NULL,
  `link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `title`, `category`, `link`) VALUES
(1, 'Exercise and mental health', 'url', 'https://www.betterhealth.vic.gov.au/health/healthyliving/exercise-and-mental-health'),
(2, 'Benefits of Physical Activity on Mental Health', 'video', 'https://www.youtube.com/watch?v=Muz0YR0ILaU&t=2s'),
(3, 'test', 'picture', 'https://www.webpagetest.org/');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `age` int(3) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `age`, `password`, `gender`, `created_at`) VALUES
(1, 'Rifat Bin Alam', 'rifat5566123@gmail.com', 21, '123456', 'male', '2024-12-31 17:28:04'),
(2, 'Farhana Karim Labonno', 'farhanakarim3225@gmail.com', 21, '1234', 'female', '2024-12-31 18:54:21'),
(3, 'test', 'test1@gmail.com', 50, '1234', 'other', '2025-01-01 06:18:14'),
(4, 'Ashraful Alam', 'ashrafulalam94444@gmail.com', 53, '1234', 'male', '2025-01-01 07:13:29'),
(5, 'Rifat', 'rifatsg.me@gmail.com', 20, '12345', 'male', '2025-01-05 14:17:29'),
(6, 'test100', 'test100@gmail.com', 52, '12345', 'male', '2025-01-05 14:41:12'),
(7, 'Rifat Bin Alam', 'rifat123456@gmail.com', 95, '12345', 'male', '2025-01-05 14:51:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `mental_health_logs`
--
ALTER TABLE `mental_health_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mental_health_logs`
--
ALTER TABLE `mental_health_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mental_health_logs`
--
ALTER TABLE `mental_health_logs`
  ADD CONSTRAINT `mental_health_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
