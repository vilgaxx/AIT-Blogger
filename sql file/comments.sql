-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2020 at 01:54 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blogger`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `approvedby` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `post_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `datetime`, `name`, `email`, `comment`, `approvedby`, `status`, `post_id`) VALUES
(1, 'March-10-2020 17:42:20', 'anasar', 'ansass@gmail.com', 'yesss', 'Pending', 'OFF', 12),
(2, 'March-10-2020 17:42:25', 'anasar', 'ansass@gmail.com', 'yesss', 'Pending', 'OFF', 12),
(5, 'March-10-2020 17:44:20', 'babu', 'bau@gmail.com', 'yusuf', 'jazeb', 'ON', 8),
(6, 'March-10-2020 17:47:20', 'rajj', 'rajjiv@yahoo.in', 'kya baat hai', 'jazeb', 'ON', 8),
(7, 'March-11-2020 09:23:36', 'saima ', 'saima@gmail.com', 'nice', 'vilgax', 'ON', 16),
(8, 'March-11-2020 11:00:38', 'rahul', 'rahul@gmail.com', 'nice pic bro', 'vilgax', 'OFF', 17),
(10, 'April-23-2020 23:50:09', 'yusuf', 'andari@gmail.com', 'hahahhahahah', 'vilgax', 'ON', 21),
(11, 'April-23-2020 23:50:46', 'fck boy', 'hahah@gmail.com', 'hahhaahah', 'vilgax', 'ON', 21),
(14, 'April-28-2020 20:08:05', 'yusuf', 'ansariy40@gmail.com', 'nice', 'vilgax', 'ON', 14),
(15, 'April-28-2020 20:09:26', 'aslam', 'aslam@gmail.com', 'fab post\r\n', 'vilgax', 'ON', 14);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Foreign_Relation` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
