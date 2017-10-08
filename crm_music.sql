-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 18, 2017 at 01:59 AM
-- Server version: 5.6.34-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm_music`
--
CREATE DATABASE IF NOT EXISTS `crm_music` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `crm_music`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `family_name` varchar(255) DEFAULT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `notes` text,
  `billing_history` text,
  `outstanding_balance` int(11) DEFAULT NULL,
  `parent_one_name` varchar(255) DEFAULT NULL,
  `parent_two_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `family_name`, `street_address`, `phone_number`, `email_address`, `notes`, `billing_history`, `outstanding_balance`, `parent_one_name`, `parent_two_name`) VALUES
(1, 't', 't', 't', 't', 'First entry', 'First entry', 0, 'tt', 't');

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

DROP TABLE IF EXISTS `owners`;
CREATE TABLE `owners` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar (30) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_courses`
--

DROP TABLE IF EXISTS `accounts_courses`;
CREATE TABLE `accounts_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_images`
--

DROP TABLE IF EXISTS `accounts_images`;
CREATE TABLE `accounts_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_lessons`
--

DROP TABLE IF EXISTS `accounts_lessons`;
CREATE TABLE `accounts_lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_schools`
--

DROP TABLE IF EXISTS `accounts_schools`;
CREATE TABLE `accounts_schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts_schools`
--

INSERT INTO `accounts_schools` (`id`, `account_id`, `school_id`, `date_of_join`) VALUES
(1, 0, 1, NULL),
(2, 0, 1, NULL),
(3, 0, 1, NULL),
(4, 0, 1, NULL),
(5, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `accounts_services`
--

DROP TABLE IF EXISTS `accounts_services`;
CREATE TABLE `accounts_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_students`
--

DROP TABLE IF EXISTS `accounts_students`;
CREATE TABLE `accounts_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts_students`
--

INSERT INTO `accounts_students` (`id`, `account_id`, `student_id`, `date_of_join`) VALUES
(1, 1, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `accounts_teachers`
--

DROP TABLE IF EXISTS `accounts_teachers`;
CREATE TABLE `accounts_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `title` varchar(255) DEFAULT NULL,
  `id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`title`, `id`) VALUES
('Piano Level One', 1);

-- --------------------------------------------------------

--
-- Table structure for table `courses_images`
--

DROP TABLE IF EXISTS `courses_images`;
CREATE TABLE `courses_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses_lessons`
--

DROP TABLE IF EXISTS `courses_lessons`;
CREATE TABLE `courses_lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses_schools`
--

DROP TABLE IF EXISTS `courses_schools`;
CREATE TABLE `courses_schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses_schools`
--

INSERT INTO `courses_schools` (`id`, `course_id`, `school_id`, `date_of_join`) VALUES
(1, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `courses_services`
--

DROP TABLE IF EXISTS `courses_services`;
CREATE TABLE `courses_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses_students`
--

DROP TABLE IF EXISTS `courses_students`;
CREATE TABLE `courses_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses_students`
--

INSERT INTO `courses_students` (`id`, `course_id`, `student_id`, `date_of_join`) VALUES
(1, 1, 2, '2017-09-17 03:56:51');

-- --------------------------------------------------------

--
-- Table structure for table `courses_teachers`
--

DROP TABLE IF EXISTS `courses_teachers`;
CREATE TABLE `courses_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `idpic` int(10) UNSIGNED NOT NULL,
  `caption` varchar(45) NOT NULL,
  `img` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images_lessons`
--

DROP TABLE IF EXISTS `images_lessons`;
CREATE TABLE `images_lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images_schools`
--

DROP TABLE IF EXISTS `images_schools`;
CREATE TABLE `images_schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images_services`
--

DROP TABLE IF EXISTS `images_services`;
CREATE TABLE `images_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images_students`
--

DROP TABLE IF EXISTS `images_students`;
CREATE TABLE `images_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images_teachers`
--

DROP TABLE IF EXISTS `images_teachers`;
CREATE TABLE `images_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
CREATE TABLE `lessons` (
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` text,
  `id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lessons_schools`
--

DROP TABLE IF EXISTS `lessons_schools`;
CREATE TABLE `lessons_schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lessons_services`
--

DROP TABLE IF EXISTS `lessons_services`;
CREATE TABLE `lessons_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lessons_students`
--

DROP TABLE IF EXISTS `lessons_students`;
CREATE TABLE `lessons_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lessons_teachers`
--

DROP TABLE IF EXISTS `lessons_teachers`;
CREATE TABLE `lessons_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

DROP TABLE IF EXISTS `schools`;
CREATE TABLE `schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_name` varchar(255) DEFAULT NULL,
  `manager_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `business_address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `school_name`, `manager_name`, `phone_number`, `email`, `business_address`, `city`, `state`, `country`, `zip`, `type`) VALUES
(1, 'SPMS', 'Carlos Munoz Kampff', '617-780-8362', 'info@starpowermusic.net', 'PO 6267', 'Alameda', 'CA', 'USA', '94706', 'music'),
(2, 'SPMS', 'Carlos Munoz Kampff', '617-780-8362', 'info@starpowermusic.net', 'PO 6267', 'Alameda', 'CA', 'USA', '94706', 'music'),
(3, 'SPMS', 'Carlos Munoz Kampff', '617-780-8362', 'info@starpowermusic.net', 'PO 6267', 'Alameda', 'CA', 'USA', '94706', 'music'),
(4, 'SPMS', 'Carlos Munoz Kampff', '617-780-8362', 'info@starpowermusic.net', 'PO 6267', 'Alameda', 'CA', 'USA', '94706', 'music'),
(5, 'SPMS', 'Carlos Munoz Kampff', '617-780-8362', 'info@starpowermusic.net', 'PO 6267', 'Alameda', 'CA', 'USA', '94706', 'music'),
(6, 'SPMS', 'Carlos Munoz Kampff', '617-780-8362', 'info@starpowermusic.net', 'PO 6267', 'Alameda', 'CA', 'USA', '94706', 'music'),
(7, 'SPMS', 'Carlos Munoz Kampff', '617-780-8362', 'info@starpowermusic.net', 'PO 6267', 'Alameda', 'CA', 'USA', '94706', 'music'),
(8, 'SPMS', 'Carlos Munoz Kampff', '617-780-8362', 'info@starpowermusic.net', 'PO 6267', 'Alameda', 'CA', 'USA', '94706', 'music'),
(9, 'SPMS', 'Carlos Munoz Kampff', '617-780-8362', 'info@starpowermusic.net', 'PO 6267', 'Alameda', 'CA', 'USA', '94706', 'music');

-- --------------------------------------------------------

--
-- Table structure for table `schools_services`
--

DROP TABLE IF EXISTS `schools_services`;
CREATE TABLE `schools_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schools_students`
--

DROP TABLE IF EXISTS `schools_students`;
CREATE TABLE `schools_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools_students`
--

INSERT INTO `schools_students` (`id`, `school_id`, `student_id`, `date_of_join`) VALUES
(1, 1, 1, NULL),
(2, 1, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schools_teachers`
--

DROP TABLE IF EXISTS `schools_teachers`;
CREATE TABLE `schools_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools_teachers`
--

INSERT INTO `schools_teachers` (`id`, `school_id`, `teacher_id`, `date_of_join`) VALUES
(1, 1, 0, NULL),
(2, 1, 0, NULL),
(3, 1, 0, NULL),
(4, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `description` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `paid_for` int(11) DEFAULT NULL,
  `notes` text,
  `date_of_service` datetime DEFAULT NULL,
  `recurrence` varchar(255) DEFAULT NULL,
  `attendance` varchar(255) DEFAULT NULL,
  `id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `services_students`
--

DROP TABLE IF EXISTS `services_students`;
CREATE TABLE `services_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `services_teachers`
--

DROP TABLE IF EXISTS `services_teachers`;
CREATE TABLE `services_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_name`, `notes`) VALUES
(1, 'Johnny Ball', 'Sunday 17th of September 2017 03:23:23 PM of first entry.'),
(2, 'Johnny Ball', '');

-- --------------------------------------------------------

--
-- Table structure for table `students_teachers`
--

DROP TABLE IF EXISTS `students_teachers`;
CREATE TABLE `students_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students_teachers`
--

INSERT INTO `students_teachers` (`id`, `student_id`, `teacher_id`, `date_of_join`) VALUES
(1, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE `teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_name` varchar(255) DEFAULT NULL,
  `instrument` varchar(100) DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `teacher_name`, `instrument`, `notes`) VALUES
(1, 'Jimi Marks', 'Piano', 'Sunday 17th of September 2017 03:22:30 PM of first entry.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `accounts_courses`
--
ALTER TABLE `accounts_courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `accounts_images`
--
ALTER TABLE `accounts_images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `accounts_lessons`
--
ALTER TABLE `accounts_lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `accounts_schools`
--
ALTER TABLE `accounts_schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `accounts_services`
--
ALTER TABLE `accounts_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `accounts_students`
--
ALTER TABLE `accounts_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `accounts_teachers`
--
ALTER TABLE `accounts_teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `courses_images`
--
ALTER TABLE `courses_images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `courses_lessons`
--
ALTER TABLE `courses_lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `courses_schools`
--
ALTER TABLE `courses_schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `courses_services`
--
ALTER TABLE `courses_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `courses_students`
--
ALTER TABLE `courses_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `courses_teachers`
--
ALTER TABLE `courses_teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`idpic`);

--
-- Indexes for table `images_lessons`
--
ALTER TABLE `images_lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `images_schools`
--
ALTER TABLE `images_schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `images_services`
--
ALTER TABLE `images_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `images_students`
--
ALTER TABLE `images_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `images_teachers`
--
ALTER TABLE `images_teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `lessons_schools`
--
ALTER TABLE `lessons_schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `lessons_services`
--
ALTER TABLE `lessons_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `lessons_students`
--
ALTER TABLE `lessons_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `lessons_teachers`
--
ALTER TABLE `lessons_teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `schools_services`
--
ALTER TABLE `schools_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `schools_students`
--
ALTER TABLE `schools_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `schools_teachers`
--
ALTER TABLE `schools_teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `services_students`
--
ALTER TABLE `services_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `services_teachers`
--
ALTER TABLE `services_teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `students_teachers`
--
ALTER TABLE `students_teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `accounts_courses`
--
ALTER TABLE `accounts_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `accounts_images`
--
ALTER TABLE `accounts_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `accounts_lessons`
--
ALTER TABLE `accounts_lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `accounts_schools`
--
ALTER TABLE `accounts_schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `accounts_services`
--
ALTER TABLE `accounts_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `accounts_students`
--
ALTER TABLE `accounts_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `accounts_teachers`
--
ALTER TABLE `accounts_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `courses_images`
--
ALTER TABLE `courses_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `courses_lessons`
--
ALTER TABLE `courses_lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `courses_schools`
--
ALTER TABLE `courses_schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `courses_services`
--
ALTER TABLE `courses_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `courses_students`
--
ALTER TABLE `courses_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `courses_teachers`
--
ALTER TABLE `courses_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `idpic` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `images_lessons`
--
ALTER TABLE `images_lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `images_schools`
--
ALTER TABLE `images_schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `images_services`
--
ALTER TABLE `images_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `images_students`
--
ALTER TABLE `images_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `images_teachers`
--
ALTER TABLE `images_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lessons_schools`
--
ALTER TABLE `lessons_schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lessons_services`
--
ALTER TABLE `lessons_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lessons_students`
--
ALTER TABLE `lessons_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lessons_teachers`
--
ALTER TABLE `lessons_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `schools_services`
--
ALTER TABLE `schools_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schools_students`
--
ALTER TABLE `schools_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `schools_teachers`
--
ALTER TABLE `schools_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `services_students`
--
ALTER TABLE `services_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `services_teachers`
--
ALTER TABLE `services_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `students_teachers`
--
ALTER TABLE `students_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
