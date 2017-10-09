-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 08, 2017 at 12:26 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

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
(1, 'Ball', 'NA', 'NA', 'jenniferball2@yahoo.com\r\n', 'Saturday 7th of October 2017 ---->Test test 12 |Saturday 7th of October 2017 ---->Test test 12 |Monday 18th of September 2017 ---->Brandon is no longer taking lessons\r\n|First entry', 'First entry', 0, 'Jennifer', 'Gordon'),
(2, 'AbouAyash', 'NA', 'NA', 'geries@jjmusiccamps.com', 'First entry', 'First entry', 0, 'Geries', 'Angela'),
(3, 'Cesca', '1016 Dunhill Ct Danville', '415-902-3100', 'buscesca@yahoo.com', 'First entry', 'First entry', 0, 'John', '');

-- --------------------------------------------------------

--
-- Table structure for table `accounts_courses`
--

CREATE TABLE `accounts_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_courses`
--

CREATE TABLE `owners_schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` int(20) DEFAULT NULL,
  `school_id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `owners_schools` (`id`, `owner_id`, `school_id`) VALUES (1, '1', '1');

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
  `role` varchar (30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `owners` (`id`, `first_name`, `last_name`, `email_address`, `password`, `role`) VALUES
(1, 'Carlos', 'Munoz Kampff', 'info@starpowermusic.net', '$2y$10$uqrvFifO5tpeALDqg1TIAe0Mnu22K5CUwALXhwJtDZh6bHRvIfnwi', 'owner');


-- --------------------------------------------------------
--
-- Table structure for table `accounts_images`
--

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
(5, 1, 1, NULL),
(6, 2, 1, NULL),
(7, 3, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `accounts_services`
--

CREATE TABLE `accounts_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts_services`
--

INSERT INTO `accounts_services` (`id`, `account_id`, `service_id`, `date_of_join`) VALUES
(1, 1, 1, NULL),
(2, 1, 2, NULL),
(3, 1, 3, NULL),
(4, 1, 4, NULL),
(5, 1, 5, NULL),
(6, 1, 6, NULL),
(7, 1, 7, NULL),
(8, 1, 8, NULL),
(9, 1, 9, NULL),
(10, 1, 10, NULL),
(11, 1, 11, NULL),
(12, 1, 12, NULL),
(13, 2, 13, NULL),
(14, 2, 14, NULL),
(15, 2, 15, NULL),
(16, 2, 16, NULL),
(17, 2, 17, NULL),
(18, 2, 18, NULL),
(19, 2, 19, NULL),
(20, 2, 20, NULL),
(21, 2, 21, NULL),
(22, 2, 22, NULL),
(23, 2, 23, NULL),
(24, 2, 24, NULL),
(25, 2, 25, NULL),
(26, 2, 26, NULL),
(27, 2, 27, NULL),
(28, 1, 28, NULL),
(29, 1, 29, NULL),
(30, 1, 30, NULL),
(31, 1, 31, NULL),
(32, 1, 32, NULL),
(33, 1, 33, NULL),
(34, 1, 34, NULL),
(35, 1, 35, NULL),
(36, 1, 36, NULL),
(37, 1, 37, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `accounts_students`
--

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
(1, 1, 2, NULL),
(2, 1, 3, NULL),
(3, 2, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `accounts_teachers`
--

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

CREATE TABLE `courses_lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses_lessons`
--

INSERT INTO `courses_lessons` (`id`, `course_id`, `lesson_id`, `date_of_join`) VALUES
(3, 1, 3, NULL),
(5, 1, 5, NULL),
(6, 1, 6, NULL),
(7, 1, 7, NULL),
(8, 1, 8, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `courses_schools`
--

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
(1, 1, 2, '2017-09-17 03:56:51'),
(2, 1, 4, '2017-09-17 09:51:41');

-- --------------------------------------------------------

--
-- Table structure for table `courses_teachers`
--

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

CREATE TABLE `images` (
  `idpic` int(10) UNSIGNED NOT NULL,
  `caption` varchar(45) NOT NULL,
  `img` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images_lessons`
--

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

CREATE TABLE `lessons` (
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` text,
  `id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`title`, `description`, `content`, `id`) VALUES
('C major scale ', 'https://flat.io/embed/59cc6a5b7313303dda3c40d2?layout=responsive', 'Play the scale :-)', 3),
('wikipedia', 'https://en.wikipedia.org/wiki/The_Strokes', 'read the article', 5),
('youtube', 'https://www.youtube.com/embed/fAGS5qSauO4', 'watch the music video', 6),
('7 Nation Army', 'https://flat.io/embed/5991e4d39d089d6e221bc35b?layout=responsive', 'Practice the main riff first', 7),
('Google Docs example', 'https://docs.google.com/document/d/15TJRSES8QvESf4rKAGJs-lOLgLajXo-twi3wmvqH0e0/edit?usp=sharing', 'You can write things in or click through to the document.', 8);

-- --------------------------------------------------------

--
-- Table structure for table `lessons_schools`
--

CREATE TABLE `lessons_schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lessons_schools`
--

INSERT INTO `lessons_schools` (`id`, `lesson_id`, `school_id`, `date_of_join`) VALUES
(3, 3, 1, NULL),
(5, 5, 1, NULL),
(6, 6, 1, NULL),
(7, 7, 1, NULL),
(8, 8, 1, NULL),
(9, 9, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lessons_services`
--

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
(1, 'SPMS', 'Carlos Munoz Kampff', '617-780-8362', 'info@starpowermusic.net', 'PO 6267', 'Alameda', 'CA', 'USA', '94706', 'music');

-- --------------------------------------------------------

--
-- Table structure for table `schools_services`
--

CREATE TABLE `schools_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools_services`
--

INSERT INTO `schools_services` (`id`, `school_id`, `service_id`, `date_of_join`) VALUES
(1, 1, 1, NULL),
(2, 1, 2, NULL),
(3, 1, 3, NULL),
(4, 1, 4, NULL),
(5, 1, 5, NULL),
(6, 1, 6, NULL),
(7, 1, 7, NULL),
(8, 1, 8, NULL),
(9, 1, 9, NULL),
(10, 1, 10, NULL),
(11, 1, 11, NULL),
(12, 1, 12, NULL),
(13, 1, 13, NULL),
(14, 1, 14, NULL),
(15, 1, 15, NULL),
(16, 1, 16, NULL),
(17, 1, 17, NULL),
(18, 1, 18, NULL),
(19, 1, 19, NULL),
(20, 1, 20, NULL),
(21, 1, 21, NULL),
(22, 1, 22, NULL),
(23, 1, 23, NULL),
(24, 1, 24, NULL),
(25, 1, 25, NULL),
(26, 1, 26, NULL),
(27, 1, 27, NULL),
(28, 1, 28, NULL),
(29, 1, 29, NULL),
(30, 1, 30, NULL),
(31, 1, 31, NULL),
(32, 1, 32, NULL),
(33, 1, 33, NULL),
(34, 1, 34, NULL),
(35, 1, 35, NULL),
(36, 1, 36, NULL),
(37, 1, 37, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schools_students`
--

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
(2, 1, 2, NULL),
(3, 1, 3, NULL),
(4, 1, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schools_teachers`
--

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
(4, 1, 1, NULL),
(5, 1, 2, NULL),
(6, 1, 3, NULL),
(7, 1, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

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

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`description`, `duration`, `price`, `discount`, `paid_for`, `notes`, `date_of_service`, `recurrence`, `attendance`, `id`) VALUES
('music lesson', 40, 40.00, 1.00, 0, 'Monday 25th of September 2017 ---->test|Monday 25th of September 2017 ---->banana|banana|Monday 25th of September 2017 ---->\"peanut butter\"|Monday 25th of September 2017 ---->https://www.learnhowtoprogram.com/php/database-basics-with-php/to-do-with-sql-and-silex|Monday 25th of September 2017 ---->|Monday 25th of September 2017 ---->|Monday 25th of September 2017 ---->We worked on Sweet Child Of Mine|Monday 25th of September 2017 ---->We worked on Sweet Child Of Mine|Monday 25th of September 2017 ---->We worked on Sweet Child Of Mine|Scheduled on Sunday 17th of September 2017 ', '0000-00-00 00:00:00', 'Wednesday|9:30', 'Scheduled', 1),
('music lesson', 40, 40.00, 1.00, 0, 'Monday 25th of September 2017 ---->|Monday 25th of September 2017 ---->blah|Scheduled on Sunday 17th of September 2017 ', '0000-00-00 00:00:00', 'Wednesday|9:30', 'SCWN', 2),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-10-02 09:30:00', 'Wednesday|9:30', 'Scheduled', 3),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-10-09 09:30:00', 'Wednesday|9:30', 'Scheduled', 4),
('music lesson', 40, 40.00, 1.00, 0, 'Monday 25th of September 2017 ---->Learned Something Else|Monday 25th of September 2017 ---->Learned Something Else|Scheduled on Sunday 17th of September 2017 ', '0000-00-00 00:00:00', 'Wednesday|9:30', 'Scheduled', 5),
('music lesson', 40, 40.00, 1.00, 0, 'Saturday 7th of October 2017 ---->|Scheduled on Sunday 17th of September 2017 ', '0000-00-00 00:00:00', 'Wednesday|9:30', 'Attended', 6),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-10-02 09:30:00', 'Wednesday|9:30', 'Scheduled', 7),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-10-09 09:30:00', 'Wednesday|9:30', 'Scheduled', 8),
('music lesson', 40, 40.00, 1.00, 0, 'Saturday 7th of October 2017 ---->|Scheduled on Sunday 17th of September 2017 ', '0000-00-00 00:00:00', 'Weakday|Time', 'Attended', 9),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-09-09 01:01:00', 'Weakday|Time', 'Scheduled', 10),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-09-16 01:01:00', 'Weakday|Time', 'Scheduled', 11),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-09-23 01:01:00', 'Weakday|Time', 'Scheduled', 12),
('music lesson', 40, 40.00, 1.00, 0, 'Tuesday 26th of September 2017 ---->|Monday 25th of September 2017 ---->|Monday 25th of September 2017 ---->We worked on amazing music\r\n|Scheduled on Sunday 17th of September 2017 ', '2017-09-26 18:06:00', 'Mondays|3:30pm', 'Scheduled', 13),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-09-24 03:00:00', 'Weekday|Time', 'Scheduled', 14),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-10-01 03:00:00', 'Weekday|Time', 'Scheduled', 15),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-10-08 03:00:00', 'Weekday|Time', 'Scheduled', 16),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-10-15 03:00:00', 'Weekday|Time', 'Scheduled', 17),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-10-22 03:00:00', 'Weekday|Time', 'Scheduled', 18),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-10-29 03:00:00', 'Weekday|Time', 'Scheduled', 19),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-11-05 03:00:00', 'Weekday|Time', 'Scheduled', 20),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-11-12 03:00:00', 'Weekday|Time', 'Scheduled', 21),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-11-19 03:00:00', 'Weekday|Time', 'Scheduled', 22),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-11-26 03:00:00', 'Weekday|Time', 'Scheduled', 23),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-12-03 03:00:00', 'Weekday|Time', 'Scheduled', 24),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-12-10 03:00:00', 'Weekday|Time', 'Scheduled', 25),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-12-17 03:00:00', 'Weekday|Time', 'Scheduled', 26),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Sunday 17th of September 2017 ', '2017-12-24 03:00:00', 'Weekday|Time', 'Scheduled', 27),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Friday 22nd of September 2017 ', '2017-08-01 12:00:00', 'Weekday|Time', 'Scheduled', 28),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Friday 22nd of September 2017 ', '2017-08-08 12:00:00', 'Weekday|Time', 'Scheduled', 29),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Friday 22nd of September 2017 ', '2017-08-15 12:00:00', 'Weekday|Time', 'Scheduled', 30),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Friday 22nd of September 2017 ', '2017-08-22 12:00:00', 'Weekday|Time', 'Scheduled', 31),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Friday 22nd of September 2017 ', '2017-08-29 12:00:00', 'Weekday|Time', 'Scheduled', 32),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Friday 22nd of September 2017 ', '2017-09-05 12:00:00', 'Weekday|Time', 'Scheduled', 33),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Friday 22nd of September 2017 ', '2017-09-12 12:00:00', 'Weekday|Time', 'Scheduled', 34),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Friday 22nd of September 2017 ', '2017-09-19 12:00:00', 'Weekday|Time', 'Scheduled', 35),
('music lesson', 40, 40.00, 1.00, 0, 'Saturday 7th of October 2017 ---->|Scheduled on Friday 22nd of September 2017 ', '0000-00-00 00:00:00', 'Weekday|Time', 'SCWN', 36),
('music lesson', 40, 40.00, 1.00, 0, 'Scheduled on Friday 22nd of September 2017 ', '2017-10-03 12:00:00', 'Weekday|Time', 'Scheduled', 37);

-- --------------------------------------------------------

--
-- Table structure for table `services_students`
--

CREATE TABLE `services_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services_students`
--

INSERT INTO `services_students` (`id`, `service_id`, `student_id`, `date_of_join`) VALUES
(1, 1, 2, NULL),
(2, 2, 2, NULL),
(3, 3, 2, NULL),
(4, 4, 2, NULL),
(5, 5, 2, NULL),
(6, 6, 2, NULL),
(7, 7, 2, NULL),
(8, 8, 2, NULL),
(9, 9, 2, NULL),
(10, 10, 2, NULL),
(11, 11, 2, NULL),
(12, 12, 2, NULL),
(13, 13, 4, NULL),
(14, 14, 4, NULL),
(15, 15, 4, NULL),
(16, 16, 4, NULL),
(17, 17, 4, NULL),
(18, 18, 4, NULL),
(19, 19, 4, NULL),
(20, 20, 4, NULL),
(21, 21, 4, NULL),
(22, 22, 4, NULL),
(23, 23, 4, NULL),
(24, 24, 4, NULL),
(25, 25, 4, NULL),
(26, 26, 4, NULL),
(27, 27, 4, NULL),
(28, 28, 2, NULL),
(29, 29, 2, NULL),
(30, 30, 2, NULL),
(31, 31, 2, NULL),
(32, 32, 2, NULL),
(33, 33, 2, NULL),
(34, 34, 2, NULL),
(35, 35, 2, NULL),
(36, 36, 2, NULL),
(37, 37, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services_teachers`
--

CREATE TABLE `services_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `date_of_join` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services_teachers`
--

INSERT INTO `services_teachers` (`id`, `service_id`, `teacher_id`, `date_of_join`) VALUES
(1, 1, 1, NULL),
(2, 2, 1, NULL),
(3, 3, 1, NULL),
(4, 4, 1, NULL),
(5, 5, 1, NULL),
(6, 6, 1, NULL),
(7, 7, 1, NULL),
(8, 8, 1, NULL),
(9, 9, 1, NULL),
(10, 10, 1, NULL),
(11, 11, 1, NULL),
(12, 12, 1, NULL),
(13, 13, 1, NULL),
(14, 14, 1, NULL),
(15, 15, 1, NULL),
(16, 16, 1, NULL),
(17, 17, 1, NULL),
(18, 18, 1, NULL),
(19, 19, 1, NULL),
(20, 20, 1, NULL),
(21, 21, 1, NULL),
(22, 22, 1, NULL),
(23, 23, 1, NULL),
(24, 24, 1, NULL),
(25, 25, 1, NULL),
(26, 26, 1, NULL),
(27, 27, 1, NULL),
(28, 28, 1, NULL),
(29, 29, 1, NULL),
(30, 30, 1, NULL),
(31, 31, 1, NULL),
(32, 32, 1, NULL),
(33, 33, 1, NULL),
(34, 34, 1, NULL),
(35, 35, 1, NULL),
(36, 36, 1, NULL),
(37, 37, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_name`, `notes`) VALUES
(2, 'Johnny Ball', 'Friday 22nd of September 2017 ---->Hurray we can see all the scheduled lessons for this and the previous month!|Sunday 17th of September 2017 ---->Admin note test|'),
(3, 'Brandon Ball', ''),
(4, 'Jacob AbouAyash', '');

-- --------------------------------------------------------

--
-- Table structure for table `students_teachers`
--

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
(1, 1, 1, NULL),
(2, 2, 1, NULL),
(3, 4, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

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
(1, 'Jimi Marks', 'Piano', 'Sunday 17th of September 2017 03:22:30 PM of first entry.'),
(2, 'Emmanuel Mora', 'Guitar, Drums', 'Sunday 17th of September 2017 07:21:14 PM of first entry.'),
(3, 'David Kaisa', 'Piano, Guitar', 'Wednesday 27th of September 2017 07:52:59 PM of first entry.'),
(4, 'Carlos Munoz Kampff', 'Guitar', 'Wednesday 27th of September 2017 08:01:04 PM of first entry.');

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
-- Indexes for table `owners`
--
ALTER TABLE `owners`
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
-- Indexes for table `owners_schools`
--
ALTER TABLE `owners_schools`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `accounts_services`
--
ALTER TABLE `accounts_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `accounts_students`
--
ALTER TABLE `accounts_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `lessons_schools`
--
ALTER TABLE `lessons_schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
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
-- AUTO_INCREMENT for table `owners_schools`
--
ALTER TABLE `owners_schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schools_services`
--
ALTER TABLE `schools_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `schools_students`
--
ALTER TABLE `schools_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `schools_teachers`
--
ALTER TABLE `schools_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `services_students`
--
ALTER TABLE `services_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `services_teachers`
--
ALTER TABLE `services_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `students_teachers`
--
ALTER TABLE `students_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
