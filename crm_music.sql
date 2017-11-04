-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 03, 2017 at 08:11 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm_music`
--
CREATE DATABASE IF NOT EXISTS `crm_music` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
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

-- --------------------------------------------------------

--
-- Table structure for table `accounts_courses`
--

DROP TABLE IF EXISTS `accounts_courses`;
CREATE TABLE `accounts_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_images`
--

DROP TABLE IF EXISTS `accounts_images`;
CREATE TABLE `accounts_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `image_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_lessons`
--

DROP TABLE IF EXISTS `accounts_lessons`;
CREATE TABLE `accounts_lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_schools`
--

DROP TABLE IF EXISTS `accounts_schools`;
CREATE TABLE `accounts_schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_services`
--

DROP TABLE IF EXISTS `accounts_services`;
CREATE TABLE `accounts_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_students`
--

DROP TABLE IF EXISTS `accounts_students`;
CREATE TABLE `accounts_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_teachers`
--

DROP TABLE IF EXISTS `accounts_teachers`;
CREATE TABLE `accounts_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `courses_images`
--

DROP TABLE IF EXISTS `courses_images`;
CREATE TABLE `courses_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `image_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses_lessons`
--

DROP TABLE IF EXISTS `courses_lessons`;
CREATE TABLE `courses_lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses_schools`
--

DROP TABLE IF EXISTS `courses_schools`;
CREATE TABLE `courses_schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses_services`
--

DROP TABLE IF EXISTS `courses_services`;
CREATE TABLE `courses_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses_students`
--

DROP TABLE IF EXISTS `courses_students`;
CREATE TABLE `courses_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses_teachers`
--

DROP TABLE IF EXISTS `courses_teachers`;
CREATE TABLE `courses_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `image_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images_schools`
--

DROP TABLE IF EXISTS `images_schools`;
CREATE TABLE `images_schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images_services`
--

DROP TABLE IF EXISTS `images_services`;
CREATE TABLE `images_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images_students`
--

DROP TABLE IF EXISTS `images_students`;
CREATE TABLE `images_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images_teachers`
--

DROP TABLE IF EXISTS `images_teachers`;
CREATE TABLE `images_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
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
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lessons_services`
--

DROP TABLE IF EXISTS `lessons_services`;
CREATE TABLE `lessons_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lessons_students`
--

DROP TABLE IF EXISTS `lessons_students`;
CREATE TABLE `lessons_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lessons_teachers`
--

DROP TABLE IF EXISTS `lessons_teachers`;
CREATE TABLE `lessons_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

DROP TABLE IF EXISTS `owners`;
CREATE TABLE `owners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`id`, `first_name`, `last_name`, `email_address`, `password`, `role`) VALUES
(33, 'Carlos', 'Munoz Kampff', 'info@starpowermusic.net', '$2y$10$sxVg4I4P/S9v9wZRLsMDfehNtsrst3jtGG7/vI2JoynjQtUUBocSC', 'owner'),
(34, 'Koji', 'Nakagawa', 'lightupthesky0627@gmail.com', '$2y$10$fpKtD4c8qt4cMiOhd1OORu8.mzCX4ml1FKG3vojBLrqUf60xAPteC', 'owner');

-- --------------------------------------------------------

--
-- Table structure for table `owners_schools`
--

DROP TABLE IF EXISTS `owners_schools`;
CREATE TABLE `owners_schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `owners_schools`
--

INSERT INTO `owners_schools` (`id`, `owner_id`, `school_id`) VALUES
(22, 33, 12),
(23, 34, 13);

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
(12, 'SPMS', 'Carlos Munoz Kampff', '6177808362', 'info@starpowermusic.net', 'PO 6267', 'Alameda', 'CA', 'USA', '94706', 'Music'),
(13, 'Koji School', 'Koji', '1234567890', 'lightupthesky0627@gmail.com', 'Some', 'Address', 'OR', 'USA', '97201', 'TEST');

-- --------------------------------------------------------

--
-- Table structure for table `schools_services`
--

DROP TABLE IF EXISTS `schools_services`;
CREATE TABLE `schools_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schools_students`
--

DROP TABLE IF EXISTS `schools_students`;
CREATE TABLE `schools_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schools_teachers`
--

DROP TABLE IF EXISTS `schools_teachers`;
CREATE TABLE `schools_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `services_teachers`
--

DROP TABLE IF EXISTS `services_teachers`;
CREATE TABLE `services_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `students_teachers`
--

DROP TABLE IF EXISTS `students_teachers`;
CREATE TABLE `students_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `users_accounts`
--

DROP TABLE IF EXISTS `users_accounts`;
CREATE TABLE `users_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users_teachers`
--

DROP TABLE IF EXISTS `users_teachers`;
CREATE TABLE `users_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `accounts_images`
--
ALTER TABLE `accounts_images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Indexes for table `accounts_lessons`
--
ALTER TABLE `accounts_lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `accounts_schools`
--
ALTER TABLE `accounts_schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `accounts_services`
--
ALTER TABLE `accounts_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `accounts_students`
--
ALTER TABLE `accounts_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `accounts_teachers`
--
ALTER TABLE `accounts_teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `teacher_id` (`teacher_id`);

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
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Indexes for table `courses_lessons`
--
ALTER TABLE `courses_lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `courses_schools`
--
ALTER TABLE `courses_schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `courses_services`
--
ALTER TABLE `courses_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `courses_students`
--
ALTER TABLE `courses_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `courses_teachers`
--
ALTER TABLE `courses_teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images_lessons`
--
ALTER TABLE `images_lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `images_schools`
--
ALTER TABLE `images_schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `images_services`
--
ALTER TABLE `images_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `images_students`
--
ALTER TABLE `images_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `images_teachers`
--
ALTER TABLE `images_teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `teacher_id` (`teacher_id`);

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
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `lesson_id` (`lesson_id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `lessons_services`
--
ALTER TABLE `lessons_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `lesson_id` (`lesson_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `lessons_students`
--
ALTER TABLE `lessons_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `lesson_id` (`lesson_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `lessons_teachers`
--
ALTER TABLE `lessons_teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `lesson_id` (`lesson_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `owners_schools`
--
ALTER TABLE `owners_schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `school_id` (`school_id`);

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
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `schools_students`
--
ALTER TABLE `schools_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `schools_teachers`
--
ALTER TABLE `schools_teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `teacher_id` (`teacher_id`);

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
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `services_teachers`
--
ALTER TABLE `services_teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `teacher_id` (`teacher_id`);

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
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `users_accounts`
--
ALTER TABLE `users_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `users_teachers`
--
ALTER TABLE `users_teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `accounts_services`
--
ALTER TABLE `accounts_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `accounts_students`
--
ALTER TABLE `accounts_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `accounts_teachers`
--
ALTER TABLE `accounts_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `courses_images`
--
ALTER TABLE `courses_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `courses_lessons`
--
ALTER TABLE `courses_lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `courses_schools`
--
ALTER TABLE `courses_schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `courses_services`
--
ALTER TABLE `courses_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `courses_students`
--
ALTER TABLE `courses_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `courses_teachers`
--
ALTER TABLE `courses_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `lessons_schools`
--
ALTER TABLE `lessons_schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `owners_schools`
--
ALTER TABLE `owners_schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `schools_services`
--
ALTER TABLE `schools_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `schools_students`
--
ALTER TABLE `schools_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `schools_teachers`
--
ALTER TABLE `schools_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `services_students`
--
ALTER TABLE `services_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `services_teachers`
--
ALTER TABLE `services_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `students_teachers`
--
ALTER TABLE `students_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `users_accounts`
--
ALTER TABLE `users_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users_teachers`
--
ALTER TABLE `users_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts_courses`
--
ALTER TABLE `accounts_courses`
  ADD CONSTRAINT `accounts_courses_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accounts_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `accounts_images`
--
ALTER TABLE `accounts_images`
  ADD CONSTRAINT `accounts_images_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accounts_images_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `accounts_lessons`
--
ALTER TABLE `accounts_lessons`
  ADD CONSTRAINT `accounts_lessons_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accounts_lessons_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `accounts_schools`
--
ALTER TABLE `accounts_schools`
  ADD CONSTRAINT `accounts_schools_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accounts_schools_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `accounts_services`
--
ALTER TABLE `accounts_services`
  ADD CONSTRAINT `accounts_services_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accounts_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `accounts_students`
--
ALTER TABLE `accounts_students`
  ADD CONSTRAINT `accounts_students_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accounts_students_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `accounts_teachers`
--
ALTER TABLE `accounts_teachers`
  ADD CONSTRAINT `accounts_teachers_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accounts_teachers_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses_images`
--
ALTER TABLE `courses_images`
  ADD CONSTRAINT `courses_images_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `courses_images_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses_lessons`
--
ALTER TABLE `courses_lessons`
  ADD CONSTRAINT `courses_lessons_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `courses_lessons_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses_schools`
--
ALTER TABLE `courses_schools`
  ADD CONSTRAINT `courses_schools_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `courses_schools_ibfk_2` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses_services`
--
ALTER TABLE `courses_services`
  ADD CONSTRAINT `courses_services_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `courses_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses_students`
--
ALTER TABLE `courses_students`
  ADD CONSTRAINT `courses_students_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `courses_students_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses_teachers`
--
ALTER TABLE `courses_teachers`
  ADD CONSTRAINT `courses_teachers_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `courses_teachers_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images_lessons`
--
ALTER TABLE `images_lessons`
  ADD CONSTRAINT `images_lessons_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `images_lessons_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images_schools`
--
ALTER TABLE `images_schools`
  ADD CONSTRAINT `images_schools_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `images_schools_ibfk_2` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images_services`
--
ALTER TABLE `images_services`
  ADD CONSTRAINT `images_services_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `images_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images_students`
--
ALTER TABLE `images_students`
  ADD CONSTRAINT `images_students_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `images_students_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images_teachers`
--
ALTER TABLE `images_teachers`
  ADD CONSTRAINT `images_teachers_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `images_teachers_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lessons_schools`
--
ALTER TABLE `lessons_schools`
  ADD CONSTRAINT `lessons_schools_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lessons_schools_ibfk_2` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lessons_services`
--
ALTER TABLE `lessons_services`
  ADD CONSTRAINT `lessons_services_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lessons_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lessons_students`
--
ALTER TABLE `lessons_students`
  ADD CONSTRAINT `lessons_students_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lessons_students_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lessons_teachers`
--
ALTER TABLE `lessons_teachers`
  ADD CONSTRAINT `lessons_teachers_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lessons_teachers_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `owners_schools`
--
ALTER TABLE `owners_schools`
  ADD CONSTRAINT `owners_schools_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `owners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `owners_schools_ibfk_2` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schools_services`
--
ALTER TABLE `schools_services`
  ADD CONSTRAINT `schools_services_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schools_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schools_students`
--
ALTER TABLE `schools_students`
  ADD CONSTRAINT `schools_students_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schools_students_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schools_teachers`
--
ALTER TABLE `schools_teachers`
  ADD CONSTRAINT `schools_teachers_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `services_students`
--
ALTER TABLE `services_students`
  ADD CONSTRAINT `services_students_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `services_students_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `services_teachers`
--
ALTER TABLE `services_teachers`
  ADD CONSTRAINT `services_teachers_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `services_teachers_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students_teachers`
--
ALTER TABLE `students_teachers`
  ADD CONSTRAINT `students_teachers_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_teachers_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_accounts`
--
ALTER TABLE `users_accounts`
  ADD CONSTRAINT `users_accounts_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_accounts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `owners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_teachers`
--
ALTER TABLE `users_teachers`
  ADD CONSTRAINT `users_teachers_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_teachers_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `owners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
