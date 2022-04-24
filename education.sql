-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2022 at 09:34 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `education`
--

-- --------------------------------------------------------

--
-- Table structure for table `course_tb`
--

CREATE TABLE `course_tb` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(50) NOT NULL,
  `min_cap` tinyint(4) NOT NULL,
  `max_cap` tinyint(4) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `teacher_fname` varchar(30) NOT NULL,
  `course_fee` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_tb`
--

INSERT INTO `course_tb` (`course_id`, `course_name`, `min_cap`, `max_cap`, `teacher_id`, `teacher_fname`, `course_fee`) VALUES
(49, 'webdev', 5, 20, 1002, 'zac', 300),
(50, 'ux/ui', 10, 20, 1002, 'zac', 250);

-- --------------------------------------------------------

--
-- Table structure for table `enroll_tb`
--

CREATE TABLE `enroll_tb` (
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `teacher_fname` varchar(20) NOT NULL,
  `student_fname` varchar(20) NOT NULL,
  `course_name` varchar(20) NOT NULL,
  `course_fee` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enroll_tb`
--

INSERT INTO `enroll_tb` (`student_id`, `teacher_id`, `course_id`, `teacher_fname`, `student_fname`, `course_name`, `course_fee`) VALUES
(1003, 1002, 49, 'zac', 'youngran', 'webdev', 300),
(1004, 1002, 49, 'zac', 'taichi', 'webdev', 300),
(1004, 1002, 50, 'zac', 'taichi', 'ux/ui', 250);

-- --------------------------------------------------------

--
-- Table structure for table `marks_tb`
--

CREATE TABLE `marks_tb` (
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `mark` float NOT NULL,
  `comment` tinytext DEFAULT NULL,
  `course_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `marks_tb`
--

INSERT INTO `marks_tb` (`student_id`, `teacher_id`, `course_id`, `mark`, `comment`, `course_name`) VALUES
(1003, 1002, 49, 99, 'good', 'webdev'),
(1004, 1002, 49, 98, 'good', 'webdev'),
(1004, 1002, 50, 100, '', 'ux/ui');

-- --------------------------------------------------------

--
-- Table structure for table `users_tb`
--

CREATE TABLE `users_tb` (
  `user_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(200) NOT NULL,
  `position` varchar(20) NOT NULL,
  `salt` varchar(20) NOT NULL,
  `user_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_tb`
--

INSERT INTO `users_tb` (`user_id`, `email`, `password`, `fname`, `lname`, `dob`, `address`, `position`, `salt`, `user_type`) VALUES
(1001, 'admin@mail.com', 'e753f1ce599a363adcb77c4dd93eee60', 'sooyeon', 'cheon', '1900-01-01', 'addr', 'admin1', '177172259', 'admin'),
(1002, 'teacher@mail.com', '2b83d9680fabad05a751a5c8d1802218', 'zac', 'doskočil', '1900-02-02', 'address', 'teacher1', '396917662', 'teacher'),
(1003, 'stu1@mail.com', 'cd9e50df821e3a7f62bc67c01b795d25', 'youngran', 'joo', '1900-03-03', 'addr', 'international studen', '535563932', 'student'),
(1004, 'stu2@test.com', '7600f4129f3cecf98b756376b112f69e', 'taichi', 'nakamura', '1900-04-04', 'addr4', 'student', '271371170', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course_tb`
--
ALTER TABLE `course_tb`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `teacher` (`teacher_id`);

--
-- Indexes for table `enroll_tb`
--
ALTER TABLE `enroll_tb`
  ADD KEY `student_con` (`student_id`),
  ADD KEY `teacher_con` (`teacher_id`),
  ADD KEY `course_con` (`course_id`);

--
-- Indexes for table `marks_tb`
--
ALTER TABLE `marks_tb`
  ADD KEY `teacher_FK` (`teacher_id`),
  ADD KEY `course_FK` (`course_id`),
  ADD KEY `user_id_FK` (`student_id`);

--
-- Indexes for table `users_tb`
--
ALTER TABLE `users_tb`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course_tb`
--
ALTER TABLE `course_tb`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_tb`
--
ALTER TABLE `course_tb`
  ADD CONSTRAINT `teacher` FOREIGN KEY (`teacher_id`) REFERENCES `users_tb` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `enroll_tb`
--
ALTER TABLE `enroll_tb`
  ADD CONSTRAINT `course_con` FOREIGN KEY (`course_id`) REFERENCES `course_tb` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_con` FOREIGN KEY (`student_id`) REFERENCES `users_tb` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_con` FOREIGN KEY (`teacher_id`) REFERENCES `users_tb` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `marks_tb`
--
ALTER TABLE `marks_tb`
  ADD CONSTRAINT `course_FK` FOREIGN KEY (`course_id`) REFERENCES `course_tb` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_FK` FOREIGN KEY (`teacher_id`) REFERENCES `users_tb` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id_FK` FOREIGN KEY (`student_id`) REFERENCES `users_tb` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
