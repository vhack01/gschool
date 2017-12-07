-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2017 at 10:22 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gschool`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `sr_no` int(10) NOT NULL,
  `marker_id` varchar(1000) DEFAULT NULL,
  `group_id` varchar(100) NOT NULL,
  `mark_status` varchar(100) NOT NULL,
  `mark_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`sr_no`, `marker_id`, `group_id`, `mark_status`, `mark_date`) VALUES
(1, '1', 'group_1', 'Y', '2017-09-13 00:06:43'),
(2, '1', 'group_3', 'Y', '2017-10-22 18:54:10');

-- --------------------------------------------------------

--
-- Table structure for table `global_msg`
--

CREATE TABLE `global_msg` (
  `msg_id` int(10) NOT NULL,
  `sender_id` varchar(10) NOT NULL,
  `message` mediumtext,
  `date_stamp` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `global_msg`
--

INSERT INTO `global_msg` (`msg_id`, `sender_id`, `message`, `date_stamp`) VALUES
(1, '1', 'hey', '2017-09-14 21:47:57'),
(2, '1', 'hello', '2017-09-14 22:00:41'),
(3, '1', 'ðŸ˜ðŸ˜ðŸ˜ðŸ˜ðŸ˜', '2017-09-14 22:02:43'),
(4, '1', 'asd', '2017-09-14 22:03:28'),
(5, '1', '123123', '2017-09-14 22:07:01'),
(6, '1', 'adfgh', '2017-09-14 22:07:54'),
(7, '2', 'hey', '2017-09-14 22:12:18'),
(8, '1', 'lol', '2017-09-15 03:57:35'),
(9, '1', 'hy', '2017-09-15 04:30:25'),
(10, '2', 'hello global', '2017-09-15 04:54:54'),
(11, '1', 'ðŸ˜ðŸ˜•ðŸ˜ŸðŸ˜ŽðŸ˜›ðŸ˜”ðŸ˜ŸðŸ˜ðŸ˜˜ðŸ˜—', '2017-09-15 06:43:09'),
(12, '1', 'hey', '2017-10-22 18:52:04'),
(13, '1', 'ðŸ¥', '2017-10-22 18:52:21'),
(14, '2', 'https://www.xvideos.com/video21563959/indian_school_girl_fucking_around_in_the_back_of_a_car', '2017-11-10 01:08:14'),
(15, '2', 'koi h kya', '2017-11-10 01:09:28'),
(16, '1', 'hai be', '2017-11-10 01:09:39'),
(17, '2', 'fuck u', '2017-11-10 01:10:16'),
(18, '2', 'babu..', '2017-11-10 01:24:38'),
(19, '1', 'u to bhosadike ke', '2017-11-10 01:31:49'),
(20, '1', 'ðŸ˜ŽðŸ˜ŽðŸ˜ŽðŸ˜ŽðŸ˜Ž', '2017-11-10 01:32:02');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `sr_no` int(10) NOT NULL,
  `group_identification` varchar(1000) DEFAULT NULL,
  `creator_id` varchar(100) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `group_type` varchar(100) DEFAULT NULL,
  `group_length` int(100) DEFAULT NULL,
  `group_location` varchar(1000) DEFAULT NULL,
  `group_description` varchar(60000) DEFAULT NULL,
  `group_logo` varchar(100) DEFAULT NULL,
  `create_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`sr_no`, `group_identification`, `creator_id`, `group_name`, `group_type`, `group_length`, `group_location`, `group_description`, `group_logo`, `create_date`) VALUES
(1, 'group_1', '1', 'Bug boat', 'Invite only', 50, 'India', 'Hello guys.Welcom to my group.', '', '2017-09-13 00:05:37'),
(2, 'group_3', '3', 'Ravimate', 'Any one can join', 100, 'India', 'Hello friends join my group.......', '', '2017-09-15 06:58:18');

-- --------------------------------------------------------

--
-- Table structure for table `group_1`
--

CREATE TABLE `group_1` (
  `sr_no` int(10) NOT NULL,
  `mem_id` varchar(1000) NOT NULL,
  `mem_pos` varchar(1000) DEFAULT NULL,
  `mem_status` varchar(100) DEFAULT NULL,
  `join_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_1`
--

INSERT INTO `group_1` (`sr_no`, `mem_id`, `mem_pos`, `mem_status`, `join_date`) VALUES
(1, '1', 'Leader', 'Y', '2017-09-13 00:05:39'),
(2, '2', 'Member', 'Y', '2017-09-15 04:54:04');

-- --------------------------------------------------------

--
-- Table structure for table `group_3`
--

CREATE TABLE `group_3` (
  `sr_no` int(10) NOT NULL,
  `mem_id` varchar(1000) NOT NULL,
  `mem_pos` varchar(1000) DEFAULT NULL,
  `mem_status` varchar(100) DEFAULT NULL,
  `join_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_3`
--

INSERT INTO `group_3` (`sr_no`, `mem_id`, `mem_pos`, `mem_status`, `join_date`) VALUES
(1, '3', 'Leader', 'Y', '2017-09-15 06:58:19');

-- --------------------------------------------------------

--
-- Table structure for table `group_msg_1`
--

CREATE TABLE `group_msg_1` (
  `sr_no` int(100) NOT NULL,
  `sender_id` varchar(1000) NOT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `group_message` varchar(10000) DEFAULT NULL,
  `join_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_msg_1`
--

INSERT INTO `group_msg_1` (`sr_no`, `sender_id`, `message`, `group_message`, `join_date`) VALUES
(1, '1', 'hello everyone', NULL, '2017-09-15 01:08:06'),
(2, '1', 'asdf', NULL, '2017-09-15 01:17:45'),
(3, '1', 'f', NULL, '2017-09-15 01:17:45'),
(4, '1', 'asd', NULL, '2017-09-15 01:17:45'),
(5, '1', 'asd', NULL, '2017-09-15 01:17:45'),
(6, '1', 'as', NULL, '2017-09-15 01:17:45'),
(7, '1', 'as', NULL, '2017-09-15 01:17:46'),
(8, '1', 'f', NULL, '2017-09-15 01:17:46'),
(9, '1', 'df', NULL, '2017-09-15 01:17:46'),
(10, '1', 'hey boss', NULL, '2017-09-15 03:39:36'),
(11, '1', 'lool', NULL, '2017-09-15 03:58:09'),
(12, '1', 'testing 1', NULL, '2017-09-15 04:16:27'),
(13, '1', 'test -- 2', NULL, '2017-09-15 04:23:24'),
(14, '1', 'tes -- 3', NULL, '2017-09-15 04:27:21'),
(15, '1', 'final', NULL, '2017-09-15 04:30:36'),
(16, '1', 'final 2', NULL, '2017-09-15 04:32:03'),
(17, '2', 'hey guys', NULL, '2017-09-15 04:54:44'),
(18, '1', 'ðŸ¦ðŸ™ŠðŸ’ðŸ’ðŸµ', NULL, '2017-09-15 06:45:45'),
(19, '2', 'babu..', NULL, '2017-11-10 01:25:16');

-- --------------------------------------------------------

--
-- Table structure for table `group_msg_3`
--

CREATE TABLE `group_msg_3` (
  `sr_no` int(100) NOT NULL,
  `sender_id` varchar(1000) NOT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `group_message` varchar(10000) DEFAULT NULL,
  `join_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_msg_3`
--

INSERT INTO `group_msg_3` (`sr_no`, `sender_id`, `message`, `group_message`, `join_date`) VALUES
(1, '3', 'hey groupmates...ðŸ§ðŸ§ðŸ§ðŸ§', NULL, '2017-09-15 06:59:22');

-- --------------------------------------------------------

--
-- Table structure for table `g_about`
--

CREATE TABLE `g_about` (
  `sr_no` int(10) NOT NULL,
  `user_id` int(255) NOT NULL,
  `workplace` varchar(1000) DEFAULT NULL,
  `professional_skill` varchar(1000) DEFAULT NULL,
  `university` varchar(1000) DEFAULT NULL,
  `high_school` varchar(10000) DEFAULT NULL,
  `city` varchar(10000) DEFAULT NULL,
  `home_town` varchar(1000) DEFAULT NULL,
  `place` varchar(1000) DEFAULT NULL,
  `relationship_status` varchar(1000) DEFAULT NULL,
  `family_member` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `g_about`
--

INSERT INTO `g_about` (`sr_no`, `user_id`, `workplace`, `professional_skill`, `university`, `high_school`, `city`, `home_town`, `place`, `relationship_status`, `family_member`) VALUES
(1, 1, 'Aptech Computer education', 'Developer', 'None', 'Little Flower School , Maharajganj', 'Kanpur', NULL, 'Kakadeo Kanpur', NULL, NULL),
(2, 2, 'Aptech Computer Education', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `g_coverphotos`
--

CREATE TABLE `g_coverphotos` (
  `pid` int(255) NOT NULL,
  `uploader_id` varchar(255) NOT NULL,
  `pic_path` varchar(255) NOT NULL,
  `time_stamp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `g_notification`
--

CREATE TABLE `g_notification` (
  `sr_no` int(10) NOT NULL,
  `sender_id` varchar(10) NOT NULL,
  `receiver_id` varchar(10) NOT NULL,
  `group_name` varchar(100) DEFAULT NULL,
  `notification_msg` varchar(10000) DEFAULT NULL,
  `group_message` varchar(40000) DEFAULT NULL,
  `note_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `g_notification`
--

INSERT INTO `g_notification` (`sr_no`, `sender_id`, `receiver_id`, `group_name`, `notification_msg`, `group_message`, `note_date`) VALUES
(1, '1', '1', 'group_1', NULL, 'Hey Guys . This is my first group in this site.Please join my group and enjoy.', '2017-09-13 00:36:33');

-- --------------------------------------------------------

--
-- Table structure for table `g_photos`
--

CREATE TABLE `g_photos` (
  `pid` int(255) NOT NULL,
  `uploader_id` varchar(255) NOT NULL,
  `pic_path` varchar(255) NOT NULL,
  `time_stamp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `g_photos`
--

INSERT INTO `g_photos` (`pid`, `uploader_id`, `pic_path`, `time_stamp`) VALUES
(1, '1', '022-computer.png', '2017-09-15 06:50:37');

-- --------------------------------------------------------

--
-- Table structure for table `g_post`
--

CREATE TABLE `g_post` (
  `sr_no` int(10) NOT NULL,
  `post_id` int(255) NOT NULL,
  `sender_id` varchar(10) NOT NULL,
  `receiver_id` varchar(10) NOT NULL,
  `text_post` varchar(10000) DEFAULT NULL,
  `post_photos` varchar(10000) DEFAULT NULL,
  `plike` varchar(100) DEFAULT NULL,
  `post_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `g_post`
--

INSERT INTO `g_post` (`sr_no`, `post_id`, `sender_id`, `receiver_id`, `text_post`, `post_photos`, `plike`, `post_date`) VALUES
(1, 1, '1', '1', 'hey ... Friends', NULL, NULL, '2017-09-13 00:09:52'),
(2, 2, '1', '1', 'hey ... Friends', NULL, 'Y', '2017-09-13 00:09:53'),
(3, 3, '1', '1', 'good night...Friends.....', NULL, 'Y', '2017-09-13 03:16:48'),
(4, 3, '1', '2', 'good night...Friends.....', NULL, 'Y', '2017-09-13 03:16:48'),
(5, 4, '1', '1', NULL, 'group-bottom.png', 'Y', '2017-09-13 03:22:06'),
(6, 4, '1', '2', NULL, 'group-bottom.png', NULL, '2017-09-13 03:22:06'),
(7, 1, '2', '2', 'good night.......bye bye', NULL, NULL, '2017-09-13 03:29:06'),
(8, 1, '2', '1', 'good night.......bye bye', NULL, 'Y', '2017-09-13 03:29:06'),
(9, 5, '1', '1', 'Good Evening guys...', NULL, 'Y', '2017-09-13 20:04:48'),
(10, 5, '1', '2', 'Good Evening guys...', NULL, NULL, '2017-09-13 20:04:48'),
(11, 6, '1', '1', NULL, 'logo.png', 'Y', '2017-09-13 20:07:55'),
(12, 6, '1', '2', NULL, 'logo.png', 'Y', '2017-09-13 20:07:55'),
(13, 7, '1', '1', 'Hello Suto.....', NULL, 'Y', '2017-09-13 21:21:45'),
(14, 7, '1', '2', 'Hello Suto.....', NULL, NULL, '2017-09-13 21:21:45'),
(15, 8, '1', '1', 'Hey ravi ....Welcome here', NULL, NULL, '2017-09-14 12:42:34'),
(16, 8, '1', '2', 'Hey ravi ....Welcome here', NULL, NULL, '2017-09-14 12:42:34'),
(17, 9, '1', '3', 'Hello ravi...welcome to this site..', NULL, 'Y', '2017-09-14 12:48:51'),
(18, 9, '1', '2', 'Hello ravi...welcome to this site..', NULL, NULL, '2017-09-14 12:48:51'),
(19, 10, '1', '1', 'Join my group..', NULL, 'Y', '2017-09-14 13:04:57'),
(20, 10, '1', '2', 'Join my group..', NULL, NULL, '2017-09-14 13:04:57'),
(21, 11, '1', '', 'Giantschool', NULL, NULL, '2017-09-14 20:45:04'),
(22, 11, '1', '2', 'Giantschool', NULL, NULL, '2017-09-14 20:45:04'),
(23, 12, '1', '', 'Giantschool', NULL, NULL, '2017-09-14 20:45:05'),
(24, 12, '1', '2', 'Giantschool', NULL, NULL, '2017-09-14 20:45:05'),
(25, 13, '1', '1', 'GiantSchool', NULL, 'Y', '2017-09-14 20:55:17'),
(26, 13, '1', '2', 'GiantSchool', NULL, NULL, '2017-09-14 20:55:17'),
(27, 14, '1', '1', NULL, '012-pirate.png', 'Y', '2017-09-14 21:03:52'),
(28, 14, '1', '2', NULL, '012-pirate.png', NULL, '2017-09-14 21:03:52'),
(29, 2, '2', '2', 'anybody is there\n', NULL, NULL, '2017-11-10 01:08:38'),
(30, 2, '2', '1', 'anybody is there\n', NULL, NULL, '2017-11-10 01:08:38');

-- --------------------------------------------------------

--
-- Table structure for table `g_relationship`
--

CREATE TABLE `g_relationship` (
  `sr_no` int(10) NOT NULL,
  `sender_id` varchar(10) NOT NULL,
  `receiver_id` varchar(10) NOT NULL,
  `req_status` varchar(100) DEFAULT NULL,
  `req_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `g_relationship`
--

INSERT INTO `g_relationship` (`sr_no`, `sender_id`, `receiver_id`, `req_status`, `req_date`) VALUES
(1, '2', '1', '1', '2017-09-13 02:10:47'),
(2, '3', '2', '-1', '2017-09-14 15:26:20'),
(3, '3', '1', '2', '2017-09-14 16:16:57');

-- --------------------------------------------------------

--
-- Table structure for table `g_signup`
--

CREATE TABLE `g_signup` (
  `id` int(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `mobile` varchar(10) NOT NULL,
  `birthday` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `signup_date` varchar(100) NOT NULL,
  `OTP` varchar(10) DEFAULT NULL,
  `verified` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `g_signup`
--

INSERT INTO `g_signup` (`id`, `first_name`, `last_name`, `email`, `password`, `country`, `state`, `mobile`, `birthday`, `gender`, `signup_date`, `OTP`, `verified`) VALUES
(1, 'vishwas', 'kumar', 'vishwas101kumar@gmail.com', 'vishwas101kumar@gmail.com', 'India', 'Uttar Pradesh', '7266880340', '08/05/1997', 'male', '2017-09-12 22:52:00', '0189', 'Y'),
(2, 'harshit', 'pandey', 'harshitpandey123@gmail.com', 'harshitpandey123@gmail.com', 'India', 'Uttar Pradesh', '7007630439', '11/11/1999', 'male', '2017-09-13 02:08:03', '0309', 'Y'),
(3, 'Ravi', 'patel', 'ravipatel123@gmail.com', 'ravipatel123@gmail.com', 'India', 'Uttar Pradesh', '8853408344', '01/10/1999', 'male', '2017-09-14 11:52:00', '3594', 'Y'),
(4, 'Adarsh', 'shukla', 'adarshshukla123@gmail.com', 'adarshshukla123@gmail.com', 'India', 'Banglore', '9198957933', '04/03/1997', 'male', '2017-09-14 19:15:44', '8277', 'Y'),
(5, 'krishna', 'sharma', 'krishnasharma123@gmail.com', 'krishnasharma123@gmail.com', 'India', 'Delhi', '7860435463', '04/03/1997', 'male', '2017-09-15 13:31:20', '5259', 'N'),
(6, 'Rishu', 'Nayak', 'rishunayak123@gmail.com', 'rishunayak123@gmail.com', 'India', 'Mumbai', '8957736763', '10/06/1995', 'male', '2017-09-15 18:06:19', '6057', 'Y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `global_msg`
--
ALTER TABLE `global_msg`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `group_1`
--
ALTER TABLE `group_1`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `group_3`
--
ALTER TABLE `group_3`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `group_msg_1`
--
ALTER TABLE `group_msg_1`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `group_msg_3`
--
ALTER TABLE `group_msg_3`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `g_about`
--
ALTER TABLE `g_about`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `g_coverphotos`
--
ALTER TABLE `g_coverphotos`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `g_notification`
--
ALTER TABLE `g_notification`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `g_photos`
--
ALTER TABLE `g_photos`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `g_post`
--
ALTER TABLE `g_post`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `g_relationship`
--
ALTER TABLE `g_relationship`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `g_signup`
--
ALTER TABLE `g_signup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `sr_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `global_msg`
--
ALTER TABLE `global_msg`
  MODIFY `msg_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `sr_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `group_1`
--
ALTER TABLE `group_1`
  MODIFY `sr_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `group_3`
--
ALTER TABLE `group_3`
  MODIFY `sr_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `group_msg_1`
--
ALTER TABLE `group_msg_1`
  MODIFY `sr_no` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `group_msg_3`
--
ALTER TABLE `group_msg_3`
  MODIFY `sr_no` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `g_about`
--
ALTER TABLE `g_about`
  MODIFY `sr_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `g_coverphotos`
--
ALTER TABLE `g_coverphotos`
  MODIFY `pid` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `g_notification`
--
ALTER TABLE `g_notification`
  MODIFY `sr_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `g_photos`
--
ALTER TABLE `g_photos`
  MODIFY `pid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `g_post`
--
ALTER TABLE `g_post`
  MODIFY `sr_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `g_relationship`
--
ALTER TABLE `g_relationship`
  MODIFY `sr_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `g_signup`
--
ALTER TABLE `g_signup`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
