-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2022 at 06:47 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `challenge_5a`
--

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

CREATE TABLE `exercises` (
  `id` int(11) NOT NULL,
  `author` varchar(30) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exercises`
--

INSERT INTO `exercises` (`id`, `author`, `title`, `content`, `filename`, `date`) VALUES
(8, 'teacher1', 'Bai1', 'prog1', '1666891622_anhdv_chall3.docx', '2022-10-28 00:27:02');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `usersendId` int(11) DEFAULT NULL,
  `userrecvId` int(11) DEFAULT NULL,
  `content` varchar(100) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `submit`
--

CREATE TABLE `submit` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `exercise` varchar(100) DEFAULT NULL,
  `file` varchar(100) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `submit`
--

INSERT INTO `submit` (`id`, `title`, `author`, `exercise`, `file`, `date`) VALUES
(5, 'sdasd', 'student1', 'Bai1', '1666932309_asd.txt', '2022-10-28 11:45:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` int(100) NOT NULL,
  `role` int(3) NOT NULL,
  `avatar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `phone`, `role`, `avatar`) VALUES
(1, 'teacher1', '123456', 'Le Van A', 'a@teacher1.co', 123456780, 1, '1666543077_Where_is_Nemo.jpg'),
(2, 'teacher2', '123456a@A', 'Le Van B', 'a@a.com', 123456789, 1, ''),
(3, 'student1', '123456a@A', 'Le Van C', 'a@a.com', 123456789, 0, ''),
(4, 'student2', '123456a@A', 'Le Van D', 'a@student2.com', 123456789, 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submit`
--
ALTER TABLE `submit`
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
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `submit`
--
ALTER TABLE `submit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
