-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2016 at 11:20 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esomo`
--

-- --------------------------------------------------------

--
-- Table structure for table `class_selection`
--

CREATE TABLE `class_selection` (
  `class_id` int(255) UNSIGNED NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `class_level` enum('primary','high_school','college','') NOT NULL DEFAULT 'primary' COMMENT 'The level of education this class belongs to'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class_selection`
--

INSERT INTO `class_selection` (`class_id`, `class_name`, `class_level`) VALUES
(1, 'Lower Levels (Grade 1-8)', 'primary'),
(2, 'Higher Levels (Grade 9-11)', 'high_school');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class_selection`
--
ALTER TABLE `class_selection`
  ADD PRIMARY KEY (`class_id`),
  ADD UNIQUE KEY `class_id` (`class_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class_selection`
--
ALTER TABLE `class_selection`
  MODIFY `class_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
