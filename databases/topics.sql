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
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(255) UNSIGNED NOT NULL,
  `topic_name` varchar(512) NOT NULL,
  `topic_description` text NOT NULL,
  `subject_id` int(255) UNSIGNED NOT NULL DEFAULT '18',
  `class_id` int(255) UNSIGNED NOT NULL DEFAULT '2' COMMENT 'class id of the topic'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `topic_name`, `topic_description`, `subject_id`, `class_id`) VALUES
(1, 'Number', '', 1, 2),
(2, 'Algebra and graphs', '', 1, 2),
(3, 'Geometry', '', 1, 2),
(4, 'Mensuration', '', 1, 2),
(5, 'Trigonometry', '', 1, 2),
(6, 'Matrices and transformations', '', 1, 2),
(7, 'Probability', '', 1, 2),
(8, 'Statistics', '', 1, 2),
(10, 'Reading', '', 2, 2),
(11, 'Writing', '', 2, 2),
(12, 'Speaking and listening', '', 2, 2),
(13, 'Everyday activities', '', 4, 2),
(14, 'Personal and social life', '', 4, 2),
(15, 'The world around us', '', 4, 2),
(16, 'The world of work', '', 4, 2),
(17, 'The international world.', '', 4, 2),
(18, 'General Physics', '', 5, 2),
(19, 'Thermal physics', '', 5, 2),
(20, 'Properties of waves, including light and sound', '', 5, 2),
(21, 'Electricity and magnetism', '', 5, 2),
(22, 'Atomic physics', '', 5, 2),
(23, 'Characteristics and classification of living organisms', '', 6, 2),
(24, 'Organisation of the organism', '', 6, 2),
(25, 'Movement in and out of cells', '', 6, 2),
(26, 'Biological molecules', '', 6, 2),
(27, 'Enzymes', '', 6, 2),
(28, 'Plant nutrition', '', 6, 2),
(29, 'Human nutrition', '', 6, 2),
(30, 'Transport in plants', '', 6, 2),
(31, 'Transport in animals', '', 6, 2),
(32, 'Diseases and immunity', '', 6, 2),
(33, 'Gas exchange in humans', '', 6, 2),
(34, 'Respiration', '', 6, 2),
(35, 'Excretion in humans', '', 6, 2),
(36, 'Coordination and response', '', 6, 2),
(37, 'Drugs', '', 6, 2),
(38, 'Reproduction', '', 6, 2),
(39, 'Inheritance', '', 6, 2),
(40, 'Variation and selection', '', 6, 2),
(41, 'Organisms and their environment', '', 6, 2),
(42, 'Biotechnology and genetic engineering', '', 6, 2),
(43, 'Human influences on ecosystems', '', 6, 2),
(44, 'Principles of chemistry', '', 7, 2),
(45, 'Chemistry of the elements', '', 7, 2),
(46, 'Organic chemistry', '', 7, 2),
(47, 'Physical chemistry', '', 7, 2),
(48, 'Chemistry in industry', '', 7, 2),
(49, 'Poetry', '', 9, 2),
(50, 'Prose', '', 9, 2),
(51, 'Population and settlement', '', 10, 2),
(52, 'The natural environment', '', 10, 2),
(53, 'Economic development and the use of resources', '', 10, 2),
(54, 'Geographical investigation and skills', '', 10, 2),
(55, 'Theory and\r\nmethods', '', 11, 2),
(56, 'Culture, identity\r\nand socialisation', '', 11, 2),
(57, 'Social inequality', '', 11, 2),
(58, 'Family', '', 11, 2),
(59, 'Education', '', 11, 2),
(60, 'Crime, deviance\r\nand social control', '', 11, 2),
(61, 'Media', '', 11, 2),
(62, 'The travel and tourism industry', '', 12, 2),
(63, 'Features of worldwide destinations', '', 12, 2),
(64, 'Customer care and working procedures', '', 12, 2),
(65, 'Travel and tourism products and services', '', 12, 2),
(66, 'Marketing and promotion', '', 12, 2),
(67, 'The marketing and promotion of visitor services', '', 12, 2),
(68, 'The 19th century: The Development of Modern Nation States, 1848-1914', '', 13, 2),
(69, 'The 20th century: International Relations since 1919', '', 13, 2),
(70, 'Painting and related media', '', 14, 2),
(71, 'Printmaking', '', 14, 2),
(72, 'Three-dimensional studies', '', 14, 2),
(73, 'Photography, digital and lens-based media', '', 14, 2),
(74, 'Graphic communication', '', 14, 2),
(75, 'Textile design', '', 14, 2),
(76, 'Types and components of computer systems', '', 15, 2),
(77, 'Input and output devices', '', 15, 2),
(78, 'Storage devices and media', '', 15, 2),
(79, 'Networks and the effects of using them', '', 15, 2),
(80, 'The effects of using IT', '', 15, 2),
(81, 'ICT applications', '', 15, 2),
(82, 'The systems life cycle', '', 15, 2),
(83, 'Safety and security', '', 15, 2),
(84, 'Audience', '', 15, 2),
(85, 'Communication', '', 15, 2),
(86, 'File management', '', 15, 2),
(87, 'Images', '', 15, 2),
(88, 'Layout', '', 15, 2),
(89, 'Styles', '', 15, 2),
(90, 'Proofing', '', 15, 2),
(91, 'Graphs and charts', '', 15, 2),
(92, 'Document production', '', 15, 2),
(93, 'Data manipulation', '', 15, 2),
(94, 'Presentations', '', 15, 2),
(95, 'Data analysis', '', 15, 2),
(96, 'Website authoring', '', 15, 2),
(97, 'Business Enterprise', '', 18, 2),
(98, 'Business Structures and Processes', '', 18, 2),
(99, 'Strategic Business Decisions', '', 18, 2),
(100, 'Business in a Global Context', '', 18, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD UNIQUE KEY `topic_id` (`topic_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `class_id` (`class_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `fk_topics_classes` FOREIGN KEY (`class_id`) REFERENCES `class_selection` (`class_id`),
  ADD CONSTRAINT `fk_topics_subjects` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
