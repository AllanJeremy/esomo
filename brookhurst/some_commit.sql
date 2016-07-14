-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2016 at 10:30 PM
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

--
-- Dumping data for table `access_levels`
--

INSERT INTO `access_levels` (`access_level_id`, `level_name`, `level_description`) VALUES
(1, 'None', 'Cannot make any modifications or view content of any of the admin navigation'),
(2, 'Content creator', 'Can add content but cannot access other parts of admin'),
(3, 'Teacher', 'Has all content creator rights\r\n- Can add assignments and schedule classes'),
(4, 'Principal', 'Has all teacher rights\r\n- Can view statistics on teacher/student performance'),
(5, 'Superuser', 'Has all principal rights\r\n- Can change access levels');

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`acc_id`, `first_name`, `last_name`, `email`, `phone`, `username`, `student_id`, `password`) VALUES
(1, 'Allan', 'Jeremy', 'aj@gmail.com', '', 'AJ', 1, '$2y$10$datG97U0xJezO03KSN85gOo9WlEbiSzGXEHmGEyqo5JUvI7MxBPzC');

--
-- Dumping data for table `class_selection`
--

INSERT INTO `class_selection` (`class_id`, `class_name`, `class_level`) VALUES
(1, 'Grade 1', 'primary'),
(2, 'Grade 2', 'primary'),
(3, 'Grade 3', 'primary'),
(4, 'Grade 4', 'primary'),
(5, 'Grade 5', 'primary'),
(6, 'Grade 6', 'primary'),
(7, 'Grade 7', 'primary'),
(8, 'Grade 8', 'primary'),
(9, 'Grade 9', 'high_school'),
(10, 'Grade 10', 'high_school'),
(11, 'Grade 11', 'high_school'),
(12, 'Grade 12', 'high_school');

-- --------------------------------------------------------

--
-- Table structure for table `esomo_articles`
--

CREATE TABLE `esomo_articles` (
  `article_id` int(255) UNSIGNED NOT NULL COMMENT 'unique id for the article',
  `article_path` varchar(512) NOT NULL COMMENT 'path the article file',
  `article_title` varchar(256) NOT NULL COMMENT 'the title of the article',
  `topic_id` int(255) UNSIGNED NOT NULL COMMENT 'topic id representing the topic the article belongs to',
  `thumbnail_path` varchar(512) NOT NULL COMMENT 'Path to the thumbnail',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `esomo_books`
--

CREATE TABLE `esomo_books` (
  `book_id` int(255) UNSIGNED NOT NULL,
  `book_path` varchar(512) NOT NULL,
  `book_title` varchar(256) NOT NULL,
  `topic_id` int(255) UNSIGNED NOT NULL,
  `thumbnail_path` varchar(512) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `esomo_videos`
--

CREATE TABLE `esomo_videos` (
  `video_id` int(255) UNSIGNED NOT NULL,
  `video_path` varchar(512) NOT NULL,
  `video_title` varchar(256) NOT NULL,
  `topic_id` int(255) UNSIGNED NOT NULL,
  `thumbnail_path` varchar(512) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `task_id` int(255) UNSIGNED NOT NULL,
  `task_title` varchar(256) NOT NULL,
  `task_description` text NOT NULL,
  `task_date` datetime NOT NULL,
  `teacher_id` int(255) UNSIGNED NOT NULL COMMENT 'the id of the teacher scheduling the task',
  `stream_id` int(255) UNSIGNED NOT NULL,
  `class_id` int(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `streams`
--

INSERT INTO `streams` (`stream_id`, `stream_name`) VALUES
(1, 'stream1');

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_name`, `class_id`, `stream_id`) VALUES
(1, 'Test stud', 1, 1);

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_category`, `subject_name`, `subject_level`, `subject_description`) VALUES
(1, 'sciences', 'Mathematics', 'high_school', ''),
(2, 'languages', 'English', 'primary', ''),
(3, 'languages', 'Kiswahili', 'high_school', ''),
(4, 'languages', 'French', 'high_school', ''),
(5, 'sciences', 'Physics', 'high_school', ''),
(6, 'sciences', 'Biology', 'high_school', ''),
(7, 'sciences', 'Chemistry', 'high_school', ''),
(8, 'humanities', 'Religion', 'high_school', ''),
(9, 'languages', 'Literature', 'high_school', ''),
(10, 'humanities', 'Geography', 'primary', ''),
(11, 'humanities', 'Sociology', 'primary', ''),
(12, 'extras', 'Travel and tourism', 'primary', ''),
(13, 'humanities', 'History', 'high_school', ''),
(14, 'extras', 'Art and Design', 'high_school', ''),
(15, 'extras', 'ICT', 'high_school', ''),
(16, 'extras', 'Physical Education', 'high_school', ''),
(17, 'extras', 'Music', 'high_school', ''),
(18, 'extras', 'Business studies', 'high_school', '');

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `topic_name`, `topic_description`, `subject_id`, `class_id`) VALUES
(1, 'Some random topic', '', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esomo_articles`
--
ALTER TABLE `esomo_articles`
  ADD PRIMARY KEY (`article_id`),
  ADD UNIQUE KEY `article_id` (`article_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `esomo_books`
--
ALTER TABLE `esomo_books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `book_id` (`book_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `esomo_videos`
--
ALTER TABLE `esomo_videos`
  ADD PRIMARY KEY (`video_id`),
  ADD UNIQUE KEY `video_id` (`video_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`task_id`),
  ADD UNIQUE KEY `task_id` (`task_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `stream_id` (`stream_id`),
  ADD KEY `class_id` (`class_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esomo_articles`
--
ALTER TABLE `esomo_articles`
  MODIFY `article_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'unique id for the article';
--
-- AUTO_INCREMENT for table `esomo_books`
--
ALTER TABLE `esomo_books`
  MODIFY `book_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `esomo_videos`
--
ALTER TABLE `esomo_videos`
  MODIFY `video_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `task_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `esomo_articles`
--
ALTER TABLE `esomo_articles`
  ADD CONSTRAINT `fk_articles_topics` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`);

--
-- Constraints for table `esomo_books`
--
ALTER TABLE `esomo_books`
  ADD CONSTRAINT `fk_books_topics` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`);

--
-- Constraints for table `esomo_videos`
--
ALTER TABLE `esomo_videos`
  ADD CONSTRAINT `fk_videos_topics` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`);

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `fk_schedule_class` FOREIGN KEY (`class_id`) REFERENCES `class_selection` (`class_id`),
  ADD CONSTRAINT `fk_schedule_stream` FOREIGN KEY (`stream_id`) REFERENCES `streams` (`stream_id`),
  ADD CONSTRAINT `fk_schedule_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `admin_accounts` (`admin_acc_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
