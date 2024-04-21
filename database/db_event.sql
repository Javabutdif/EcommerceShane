-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2024 at 11:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_event`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `login_attempts` int(11) DEFAULT 0,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contact`, `username`, `password`, `login_attempts`, `role`) VALUES
(1, 'Brandon Dwite Cobacha', 'bbscobacha@gmail.com', '09757895561', 'Dwite', '$2y$10$Y/gYI8orY0JzDkdvDodt2elHgV4CQa9dltQhpT1hO.nmywjgsNuja', 0, ''),
(2, 'Queencie Shane Resma', 'queencieshaneresma@gmail.com', '09057383234', 'Shane Resma', '$2y$10$m.i4CcNkD4GnSQG2qTYGcu128F1ErSF4dTgy2lcnk5bSbLJTdaXZ6', 0, ''),
(3, 'Jermain', 'jermaine@gmail.com', '123', 'jer', '$2y$10$aoekohKYMui//9xTSjxVDOde5Mw6iUwu3Jp6pMAd/0b34aFGg/CAW', 0, ''),
(5, 'jims', 'jamesgenabio@yahoo.com', '09083095890', 'jer1', '$2y$10$prafjNm/GV8WXQWr8z46kufiJOBP0RPbXB8KesSbREDHrwqAsPmTS', 0, 'Vendor'),
(6, 'dawdw', 'jamesgenabio2@yahoo.com', '12313', 'jer2', '$2y$10$bJ/EhSl44kBtIrhVdFskT.NznsgFEL9bOaqhKMfyRad3YLavFY8jO', 0, 'Customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
