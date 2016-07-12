-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2016 at 11:53 PM
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
-- Table structure for table `access_levels`
--

CREATE TABLE `access_levels` (
  `access_level_id` int(255) UNSIGNED NOT NULL,
  `level_name` varchar(256) NOT NULL,
  `level_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `acc_id` int(255) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(256) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `username` varchar(100) NOT NULL,
  `student_id` int(255) UNSIGNED NOT NULL,
  `password` varchar(256) NOT NULL,
  `salt` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_accounts`
--

CREATE TABLE `admin_accounts` (
  `admin_acc_id` int(255) UNSIGNED NOT NULL COMMENT 'id of the admin account',
  `f_name` varchar(128) NOT NULL COMMENT 'first name',
  `l_name` varchar(128) NOT NULL COMMENT 'last name',
  `username` varchar(128) NOT NULL COMMENT 'username',
  `access_level_id` int(255) UNSIGNED NOT NULL COMMENT 'id representing the access level of the admin',
  `email` varchar(256) NOT NULL COMMENT 'email address of the admin',
  `password` varchar(512) NOT NULL COMMENT 'encrypted password',
  `salt` varchar(512) NOT NULL COMMENT 'salt for the password - used for validation comparison',
  `phone` varchar(15) NOT NULL COMMENT 'phone number of the admin',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'date the account was created'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `ass_id` int(255) UNSIGNED NOT NULL,
  `ass_title` varchar(256) NOT NULL,
  `ass_description` text NOT NULL,
  `teacher_id` int(255) UNSIGNED NOT NULL COMMENT 'The id of the teacher who sent the assignment',
  `class_id` int(255) UNSIGNED NOT NULL COMMENT 'class it was sent to',
  `stream_id` int(255) UNSIGNED NOT NULL COMMENT 'stream it was sent to',
  `sent_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'date the assignment was sent'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ass_content`
--

CREATE TABLE `ass_content` (
  `content_id` int(255) UNSIGNED NOT NULL,
  `content_title` varchar(256) NOT NULL,
  `content_description` text NOT NULL,
  `content_path` varchar(512) NOT NULL,
  `ass_id` int(255) UNSIGNED NOT NULL COMMENT 'the assignment to which the content belongs'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `topic_id` int(255) UNSIGNED NOT NULL COMMENT 'topic id representing the topic the article belongs to'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `esomo_books`
--

CREATE TABLE `esomo_books` (
  `book_id` int(255) UNSIGNED NOT NULL,
  `book_path` varchar(512) NOT NULL,
  `book_title` varchar(256) NOT NULL,
  `topic_id` int(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `esomo_videos`
--

CREATE TABLE `esomo_videos` (
  `video_id` int(255) UNSIGNED NOT NULL,
  `video_path` varchar(512) NOT NULL,
  `video_title` varchar(256) NOT NULL,
  `topic_id` int(255) UNSIGNED NOT NULL
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
  `teacher_id` int(255) UNSIGNED NOT NULL COMMENT 'the id of the teacher scheduling the task'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `streams`
--

CREATE TABLE `streams` (
  `stream_id` int(255) UNSIGNED NOT NULL,
  `stream_name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(255) UNSIGNED NOT NULL,
  `student_name` varchar(256) NOT NULL,
  `class_id` int(255) UNSIGNED NOT NULL,
  `stream_id` int(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(255) UNSIGNED NOT NULL,
  `subject_category` enum('sciences','humanities','languages','extras') NOT NULL DEFAULT 'sciences',
  `subject_name` varchar(256) NOT NULL,
  `subject_level` enum('primary','high_school','college','') NOT NULL DEFAULT 'primary',
  `subject_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_category`, `subject_name`, `subject_level`, `subject_description`) VALUES
(1, 'sciences', 'Mathematics', 'primary', ''),
(2, 'languages', 'English', 'primary', ''),
(3, 'languages', 'Kiswahili', 'primary', ''),
(4, 'languages', 'French', 'primary', ''),
(5, 'sciences', 'Physics', 'primary', ''),
(6, 'sciences', 'Biology', 'primary', ''),
(7, 'humanities', 'Religion', 'primary', ''),
(8, 'languages', 'Literature', 'primary', ''),
(9, 'humanities', 'Geography', 'primary', ''),
(10, 'humanities', 'Sociology', 'primary', ''),
(11, 'extras', 'Travel and tourism', 'primary', ''),
(12, 'humanities', 'History', 'primary', ''),
(13, 'extras', 'Art and Design', 'primary', ''),
(14, 'extras', 'ICT', 'primary', ''),
(15, 'extras', 'Physical Education', 'primary', ''),
(16, 'extras', 'Music', 'primary', ''),
(17, 'extras', 'Business studies', 'primary', '');

-- --------------------------------------------------------

--
-- Table structure for table `sub_topics`
--

CREATE TABLE `sub_topics` (
  `sub_topic_id` int(255) UNSIGNED NOT NULL,
  `sub_topic_name` varchar(256) NOT NULL,
  `sub_topic_description` text NOT NULL,
  `topic_id` int(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(255) UNSIGNED NOT NULL,
  `topic_name` varchar(512) NOT NULL,
  `topic_description` text NOT NULL,
  `subject_id` int(255) UNSIGNED NOT NULL,
  `class_id` int(255) UNSIGNED NOT NULL COMMENT 'class id of the topic'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_levels`
--
ALTER TABLE `access_levels`
  ADD PRIMARY KEY (`access_level_id`),
  ADD UNIQUE KEY `access_level_id` (`access_level_id`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`acc_id`),
  ADD UNIQUE KEY `acc_id` (`acc_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD PRIMARY KEY (`admin_acc_id`),
  ADD UNIQUE KEY `admin_acc_id` (`admin_acc_id`),
  ADD KEY `access_level_id` (`access_level_id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`ass_id`),
  ADD UNIQUE KEY `ass_id` (`ass_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `stream_id` (`stream_id`);

--
-- Indexes for table `ass_content`
--
ALTER TABLE `ass_content`
  ADD PRIMARY KEY (`content_id`),
  ADD UNIQUE KEY `content_id` (`content_id`),
  ADD KEY `ass_id` (`ass_id`);

--
-- Indexes for table `class_selection`
--
ALTER TABLE `class_selection`
  ADD PRIMARY KEY (`class_id`),
  ADD UNIQUE KEY `class_id` (`class_id`);

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
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `streams`
--
ALTER TABLE `streams`
  ADD PRIMARY KEY (`stream_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `stream_id` (`stream_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD UNIQUE KEY `subject_id` (`subject_id`);

--
-- Indexes for table `sub_topics`
--
ALTER TABLE `sub_topics`
  ADD PRIMARY KEY (`sub_topic_id`),
  ADD UNIQUE KEY `sub_topic_id` (`sub_topic_id`),
  ADD KEY `topic_id` (`topic_id`);

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
-- AUTO_INCREMENT for table `access_levels`
--
ALTER TABLE `access_levels`
  MODIFY `access_level_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `acc_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  MODIFY `admin_acc_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id of the admin account';
--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `ass_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ass_content`
--
ALTER TABLE `ass_content`
  MODIFY `content_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `class_selection`
--
ALTER TABLE `class_selection`
  MODIFY `class_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
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
-- AUTO_INCREMENT for table `streams`
--
ALTER TABLE `streams`
  MODIFY `stream_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `sub_topics`
--
ALTER TABLE `sub_topics`
  MODIFY `sub_topic_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `fk_accounts_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD CONSTRAINT `fk_admin_access_level` FOREIGN KEY (`access_level_id`) REFERENCES `access_levels` (`access_level_id`);

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `fk_ass_class` FOREIGN KEY (`class_id`) REFERENCES `class_selection` (`class_id`),
  ADD CONSTRAINT `fk_ass_stream` FOREIGN KEY (`stream_id`) REFERENCES `streams` (`stream_id`),
  ADD CONSTRAINT `fk_ass_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `admin_accounts` (`admin_acc_id`);

--
-- Constraints for table `ass_content`
--
ALTER TABLE `ass_content`
  ADD CONSTRAINT `fk_ass_content` FOREIGN KEY (`ass_id`) REFERENCES `assignments` (`ass_id`);

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
  ADD CONSTRAINT `fk_schedule_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `admin_accounts` (`admin_acc_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_student_class` FOREIGN KEY (`class_id`) REFERENCES `class_selection` (`class_id`),
  ADD CONSTRAINT `fk_student_stream` FOREIGN KEY (`stream_id`) REFERENCES `streams` (`stream_id`);

--
-- Constraints for table `sub_topics`
--
ALTER TABLE `sub_topics`
  ADD CONSTRAINT `fk_subtopic` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`);

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `fk_topics_classes` FOREIGN KEY (`class_id`) REFERENCES `class_selection` (`class_id`),
  ADD CONSTRAINT `fk_topics_subjects` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
