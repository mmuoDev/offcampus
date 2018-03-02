-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 02, 2018 at 03:20 PM
-- Server version: 5.6.39-cll-lve
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
-- Database: `offcamp1_offcampus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_members`
--

CREATE TABLE `admin_members` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `status` varchar(20) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_members`
--

INSERT INTO `admin_members` (`id`, `name`, `email`, `password`, `status`, `category`) VALUES
(1, 'obioha uche', 'radioactive.uche11@gmail.com', '54e0bdc4d17a1dbc8d5fe4393390efe9d599b7b405d8c9c69d4435c7e842bb01', 'active', 'manager');

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `school` varchar(100) NOT NULL,
  `price` int(50) NOT NULL,
  `number` varchar(20) NOT NULL,
  `member_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `title`, `description`, `category`, `school`, `price`, `number`, `member_id`, `date`) VALUES
(22, 'human hair', 'natural human hair for sale', 'Fashion & beauty', 'Akwa Ibom State University of Science and Technology', 23980, '08067170799', 3, '2015-12-01 23:46:59'),
(23, 'samsung phone', 'we is good', 'mobile phones & tablets', 'Benue State Polytechnic', 18000, '', 3, '2015-11-29 15:35:11'),
(24, 'my tecno c8 phone', 'do you know our Lord Jesus loves you', 'mobile phones & tablets', 'Benue State Polytechnic', 100380, '', 3, '2015-11-29 15:36:18'),
(29, 'htc phone', 'kdddj', 'mobile phones & tablets', 'Benue State Polytechnic', 38838, '', 3, '2015-11-29 17:26:55'),
(35, 'nokia phone', 'we got to treat our phone', 'mobile phones & tablets', 'Benue State Polytechnic', 12987, '08067170799', 3, '2015-11-29 19:32:21'),
(36, 'new samsung galaxy', 'we got to treat our ', 'Mobile phones & tablets', 'University of Abuja', 100837, '08067170799', 3, '2015-12-04 14:57:16'),
(37, 'samsung phone', 'we got to treat our ', 'Mobile phones & tablets', 'University of Abuja', 45890, '08067170799', 3, '2015-12-04 15:01:33'),
(38, 'samsung phone', '!preg_match(\"/^[1-9]+,[0-9,]*$/\",$_POST[\'price\']) OR ', 'Fashion & beauty', 'Moshood Abiola Polytechnic', 768, '08067170799', 3, '2015-12-04 15:20:50'),
(39, 'UUD', 'JJJDJ', 'Fashion & beauty', 'Nasarawa State University', 980, '08067170799', 3, '2015-12-04 15:35:01'),
(40, 'nnn', 'djjdjj', 'Fashion & beauty', 'Nasarawa State University', 190098, '08067170799', 3, '2015-12-04 15:36:20'),
(41, 'hdjdj', 'jjdj', 'Electronics', 'College of Agriculture, Kabba', 9829, '08067170799', 3, '2015-12-04 15:37:05'),
(42, 'hdhdh', 'hdhdhhd', 'Fashion & beauty', 'College of Education, Akwanga', 100937, '08067170799', 3, '2015-12-04 15:37:25'),
(43, 'hdhhq', 'jdjdjj', 'Electronics', 'Adeyemi College of Education', 109993, '08067170799', 3, '2015-12-04 15:39:41'),
(44, 'yuddh', 'hdhdh', 'Mobile phones & tablets', 'Nasarawa State University', 1093837, '08067170799', 3, '2015-12-04 15:40:29'),
(45, 'Fairly used refrigerator', 'Fairly used refrigerator', 'Electronics', 'Lagos State University', 10000, '08067170799', 3, '2015-12-06 00:07:02');

-- --------------------------------------------------------

--
-- Table structure for table `ads_photos`
--

CREATE TABLE `ads_photos` (
  `id` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `member_id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ads_photos`
--

INSERT INTO `ads_photos` (`id`, `photo`, `member_id`, `ad_id`) VALUES
(24, '1449007386.jpg', 3, 22),
(25, 'no image.jpg', 3, 23),
(26, 'no image.jpg', 3, 24),
(27, 'no image.jpg', 3, 25),
(28, 'no image.jpg', 3, 26),
(29, 'no image.jpg', 3, 27),
(30, 'no image.jpg', 3, 28),
(31, 'no image.jpg', 3, 29),
(33, 'no image.jpg', 3, 31),
(34, 'no image.jpg', 3, 32),
(35, 'no image.jpg', 3, 33),
(37, '0_1448825542.jpg', 3, 35),
(38, '1_1448825542.jpg', 3, 35),
(39, '2_1448825542.jpg', 3, 35),
(40, '3_1448825542.jpg', 3, 35),
(41, '0_1448831067.jpg', 3, 36),
(42, 'no image.jpg', 3, 36),
(43, 'no image.jpg', 3, 37),
(44, 'no image.jpg', 3, 38),
(45, 'no image.jpg', 3, 39),
(46, 'no image.jpg', 3, 40),
(47, 'no image.jpg', 3, 41),
(48, 'no image.jpg', 3, 42),
(49, 'no image.jpg', 3, 43),
(50, 'no image.jpg', 3, 44),
(51, '0_1449360422.jpg', 3, 45),
(52, '1_1449360422.jpg', 3, 45),
(53, '2_1449360422.jpg', 3, 45);

-- --------------------------------------------------------

--
-- Table structure for table `ambassador`
--

CREATE TABLE `ambassador` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(20) NOT NULL,
  `school` varchar(50) NOT NULL,
  `level` varchar(10) NOT NULL,
  `knowledge` text NOT NULL,
  `motivation_1` text NOT NULL,
  `motivation_2` text NOT NULL,
  `motivation_3` text NOT NULL,
  `motivation_4` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ambassador`
--

INSERT INTO `ambassador` (`id`, `name`, `email`, `number`, `school`, `level`, `knowledge`, `motivation_1`, `motivation_2`, `motivation_3`, `motivation_4`) VALUES
(1, 'uche', 'uche@offcampus.com.ng', '08067170799', 'College of Education, Akwanga', 'second yea', 'jdh', 'hdhh', 'hdhh', 'hdhh', 'chhc'),
(2, 'uche', 'uche@offcampus.com.ng', '08067170798', 'College of Education, Katsina Ala', 'second yea', 'yes', 'yes', 'yes', 'yes', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `amb_photos`
--

CREATE TABLE `amb_photos` (
  `id` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `amb_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `amb_photos`
--

INSERT INTO `amb_photos` (`id`, `photo`, `amb_id`) VALUES
(1, '1450256717.jpg', 1),
(2, '1450258499.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `title` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `description`, `title`, `date`) VALUES
(2, '<p><span style=\"font-family: \'times new roman\', times, serif; font-size: 14pt;\">Are you a student of a Nigerian tertiary institution? Have you noticed the stress involved in looking for off-campus accommodations? - you have to go around town in search of available accommodations, ask friends to help you look around and you may have to pay multiple agent registration fees for just one accommodation! But wait, there is a solution. We are happy to introduce&nbsp;<a href=\"http://www.offcampus.com.ng\">www.offcampus.com.ng</a>.&nbsp;</span></p>\r\n<p><img src=\"http://www.offcampus.com.ng/img/logo.jpg\" alt=\"\" width=\"168\" height=\"67\" /></p>\r\n<p><span style=\"font-size: 14pt; line-height: 18.4px; font-family: \'times new roman\', times, serif;\">Offcampus.com.ng is a&nbsp;an online platform&nbsp;that allows Nigerian students in tertiary institutions (universities, polytechnics and colleges of education) search for, and rent off-campus accommodations around their schools.</span></p>\r\n<p class=\"MsoNormal\"><span style=\"font-size: 14pt; line-height: 21.4667px; font-family: \'times new roman\', times, serif;\">With offcampus.com.ng, students can quickly search for off-campus accommodations around their campuses in just one click as the website is regularly updated with accommodations courtesy of estate agents working around the school environs.</span></p>\r\n<p class=\"MsoNormal\"><span style=\"font-size: 14pt; line-height: 21.4667px; font-family: \'times new roman\', times, serif;\">In addition to accommodations, Offcampus.com.ng provides a platform that allows students find roommates to stay with. This is also as easy as finding accommodations. It practically takes less than 2 minutes. &nbsp;</span></p>\r\n<p class=\"MsoNormal\"><span style=\"font-size: 14pt; line-height: 21.4667px; font-family: \'times new roman\', times, serif;\">So do you need an off-campus accommodation and/or in need of roommates to stay with? Visit&nbsp;<a href=\"http://www.offcampus.com.ng/\">www.offcampus.com.ng</a>&nbsp;and experience the difference.&nbsp;</span></p>', 'Introducing offcampus.com.ng - Find off-campus accommodations and roommates around your campus. ', '2017-01-02 22:49:43');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `post_id` int(100) NOT NULL,
  `poster_id` int(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` int(10) NOT NULL,
  `message` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contact_agent`
--

CREATE TABLE `contact_agent` (
  `id` int(11) NOT NULL,
  `property_id` int(100) NOT NULL,
  `student_name` varchar(200) NOT NULL,
  `student_number` varchar(20) NOT NULL,
  `agent_id` int(20) NOT NULL,
  `agent_number` varchar(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `favourite`
--

CREATE TABLE `favourite` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `fullname` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `status` varchar(10) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `company_address` varchar(50) NOT NULL,
  `number_1` varchar(11) NOT NULL,
  `number_2` varchar(11) NOT NULL,
  `category` varchar(10) NOT NULL,
  `age` varchar(11) NOT NULL,
  `_school` varchar(200) NOT NULL,
  `smoke` varchar(100) NOT NULL,
  `clean` varchar(100) NOT NULL,
  `alcohol` varchar(100) NOT NULL,
  `religion` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `about` varchar(200) NOT NULL,
  `sex` varchar(20) NOT NULL,
  `payment_option` varchar(20) NOT NULL,
  `verification` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `fullname`, `email`, `username`, `password`, `status`, `company_name`, `company_address`, `number_1`, `number_2`, `category`, `age`, `_school`, `smoke`, `clean`, `alcohol`, `religion`, `photo`, `about`, `sex`, `payment_option`, `verification`) VALUES
(2, 'obioha ebere                                                                  ', 'radioactive.uche@yahoo.com', 'thelma                                                                  ', '3f713768529ab64985964a8ab8114d24021477d8c613cdddb30818520c19a3d5', 'active', 'access holdings plc                               ', '17 apapa road                                     ', '07033282980', '08067179835', 'agent', '0', '', '', '', '', '', '', '', '', '', 'active'),
(3, 'emelogu joy', 'jolly@gmail.com', 'jolly', '32548750bb37c9256dbbfaa970aadcd4f08a04be7df463f4801af8848131700a', 'active', '', '', '08067170799', '0', 'student', '0', 'Lagos State University', '', '', '', '', '', '', '', '', 'active'),
(6, 'Adaobi Titi Nana', 'ambrose.6533@gmail.com', 'adaobi', '32548750bb37c9256dbbfaa970aadcd4f08a04be7df463f4801af8848131700a', 'active', '', '', '07065009215', '0', 'student', '0', 'College of Education, Zubi', '', '', '', '', '', '', '', '', 'active'),
(9, 'Muyiwa Afolabi                ', 'email@gmail.com', 'access                 ', '9a7159e3b94a88525e5e1c75e2cf872680c4b71096fe3d77335408a69b76b805', 'active', 'Access bank plc                ', '12 marina layout, Agbara, Ogun state.        ', '08067170799', '', 'agent', '0', '', '', '', '', '', '', '', '', 'subscription', 'active'),
(12, 'carlos tevez juventus       ', 'carlos@gmail.com', 'carlos       ', '32548750bb37c9256dbbfaa970aadcd4f08a04be7df463f4801af8848131700a', 'active', '', '', '98067179837', '', 'student', '0', '', '', '', '', '', '', '', '', '', 'inactive'),
(19, 'obioha uche ', 'obioha@gmail.com', 'obioha ', '9a7159e3b94a88525e5e1c75e2cf872680c4b71096fe3d77335408a69b76b805', 'active', '', '', '', '', 'student', '0', 'University of Lagos', '', '', '', '', '', '', '', '', 'inactive'),
(26, 'x ', 'x@gmail.com', 'x ', '3c50e0b7d9f546fe9adfacc50f1c8f039e3af20701a5b3a3b840d860cec322b4', 'inactive', 'x ', 'x ', '07033282983', '', 'agent', '0', '', '', '', '', '', '', '', '', 'commission', 'active'),
(29, 'chi ike     ', 'radioactive.uche11@gmail.com', 'chi     ', 'd228eef676cc70130a5262f8b8e1da3a72ef2f48428fb7388e9dafb41cf553ce', 'active', '', '', '', '', 'student', '32', 'University of Lagos', 'does not smoke', 'clean', '', '', '', '', 'male', '', 'active'),
(33, 'ww', 'ww@gmail.com', 'ww', '00804f76af4f19ac6042c44567cb73668675c49eca1eb8c66dcba826f45b08f1', 'inactive', '', '', '', '', 'student', '', '', '', '', '', '', '', '', '', '', 'inactive'),
(34, 'sunday adeyemi', 'sunyflex@yahoo.co.uk', 'sunday', '54e0bdc4d17a1dbc8d5fe4393390efe9d599b7b405d8c9c69d4435c7e842bb01', 'inactive', 'maxgrey enterprises', '18 community road, akoka', '08055204358', '', 'agent', '', '', '', '', '', '', '', '', '', 'commission', 'inactive'),
(35, 'helen', 'helen@gmail.com', 'helen', '54e0bdc4d17a1dbc8d5fe4393390efe9d599b7b405d8c9c69d4435c7e842bb01', 'inactive', 'helen', '17 Elemijaye Street, Etegbin-Shibiri, Ojo LGA, Lag', '08053247685', '', 'agent', '', '', '', '', '', '', '', '', '', 'commission', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `sender_id` int(100) NOT NULL,
  `receiver_id` int(100) NOT NULL,
  `message` text NOT NULL,
  `message_id` int(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `sender_id`, `receiver_id`, `message`, `message_id`, `status`, `date`) VALUES
(41, 17, 18, 'Its nice meeting you', 35, 'read', '2015-07-24 08:02:35'),
(42, 18, 17, 'Have you ever liked a photo on Facebook so that God or Jesus will do something', 35, 'read', '2015-07-24 08:06:36'),
(43, 17, 18, 'lets see how this goes. ', 35, 'read', '2015-07-24 08:21:53'),
(44, 18, 17, 'What if I told you am falling in love with you. ', 35, 'read', '2015-07-24 08:24:23'),
(46, 17, 18, 'Whats strange is that you never said shit about this. ', 35, 'read', '2015-07-24 08:27:16'),
(47, 18, 17, 'Don\'t panic, we just getting started. ', 35, 'read', '2015-07-24 08:42:52'),
(48, 18, 17, 'I told y\'all, money makes the world go round. ', 35, 'read', '2015-07-24 08:43:30'),
(49, 18, 17, 'Shit@', 35, 'read', '2015-07-24 08:52:29'),
(50, 17, 18, 'Baby you look so sweet, am codes are not working. ', 35, 'read', '2015-07-24 09:00:18'),
(51, 17, 18, 'Can I take you out! ', 35, 'read', '2015-07-24 09:00:51'),
(52, 18, 17, 'I have not gotten any reply sweet. ', 35, 'read', '2015-07-24 09:06:16'),
(53, 18, 17, 'Baby you still there? I am feeling you', 35, 'read', '2015-07-24 09:07:26'),
(54, 17, 18, 'Wiz sent a message', 35, 'read', '2015-07-24 09:10:33'),
(55, 18, 17, 'chiazor sent a message', 35, 'read', '2015-07-24 09:12:55'),
(56, 17, 10, 'Firefox is having trouble recovering your windows and tabs. This is usually caused by a recently opened web page.\r\n\r\nYou can try:\r\n\r\n    Removing one or more tabs that you think may be causing the problem\r\n    Starting an entirely new browsing session', 27, 'read', '2015-07-24 09:26:37'),
(57, 10, 17, 'Dude whats with all these firefox? I don\'t dig firefix. Am all about Chrome. ', 27, 'read', '2015-07-25 05:11:27');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `accommodation` varchar(100) NOT NULL,
  `school` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(50) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `available` varchar(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `member_id` int(10) NOT NULL,
  `price` int(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `distance` varchar(10) DEFAULT NULL,
  `water` varchar(10) DEFAULT NULL,
  `business` varchar(10) DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `accommodation`, `school`, `description`, `photo`, `photo_id`, `available`, `date`, `member_id`, `price`, `location`, `distance`, `water`, `business`, `status`) VALUES
(1, 'one room self-contain', 'Federal University of Technology, Akure', 'A brand new hostel accommodation containing about 60 self contained room apartments. This hostel has restaurant, bar, mini super mart, security guards and 24 hours steady water flow. Power inverters are available for use.  ', '', 0, 'yes', '2016-12-31 06:33:52', 1, 120000, 'FUTA North Gate', 'near', 'both', 'near', 'show'),
(2, 'one room self-contain', 'Federal University of Technology, Akure', 'Well furnished one room self contained apartment at FUTA South gate. ', '', 0, 'yes', '2017-01-02 11:29:30', 1, 80000, 'FUTA South gate', 'near', 'both', 'near', 'show'),
(3, 'one room self-contain', 'Federal University of Technology, Akure', 'One room self contained apartments in a new hostel at FUTA North gate. ', '', 0, 'yes', '2018-03-02 14:01:42', 1, 110000, 'FUTA North gate', 'near', 'both', 'near', 'show');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `member_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `photo_id`, `photo`, `member_id`) VALUES
(1, 1, '0_1483166032.jpg', 1),
(2, 1, '1_1483166032.jpg', 1),
(3, 1, '2_1483166032.jpg', 1),
(4, 1, '3_1483166032.jpg', 1),
(5, 1, '4_1483166032.jpg', 1),
(6, 1, '5_1483166032.jpg', 1),
(7, 1, '6_1483166032.jpg', 1),
(8, 1, '7_1483166032.jpg', 1),
(9, 1, '8_1483166032.jpg', 1),
(10, 1, '9_1483166033.jpg', 1),
(11, 1, '10_1483166033.jpg', 1),
(12, 2, '0_1483356570.jpg', 1),
(13, 2, '1_1483356571.jpg', 1),
(14, 2, '2_1483356571.jpg', 1),
(15, 2, '3_1483356571.jpg', 1),
(16, 2, '4_1483356571.jpg', 1),
(17, 2, '5_1483356571.jpg', 1),
(18, 3, '0_1483356686.jpg', 1),
(19, 3, '1_1483356686.jpg', 1),
(20, 3, '2_1483356686.jpg', 1),
(21, 3, '3_1483356686.jpg', 1),
(22, 3, '4_1483356686.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_request`
--

CREATE TABLE `post_request` (
  `id` int(11) NOT NULL,
  `school` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `member_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profile_photos`
--

CREATE TABLE `profile_photos` (
  `id` int(11) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `member_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_count`
--

CREATE TABLE `request_count` (
  `id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request_count`
--

INSERT INTO `request_count` (`id`, `count`, `request_id`, `member_id`) VALUES
(13, 11, 9, 11);

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE `responses` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `responses`
--

INSERT INTO `responses` (`id`, `request_id`, `member_id`, `status`) VALUES
(1, 2, 5, 'unresolved');

-- --------------------------------------------------------

--
-- Table structure for table `roommate_links`
--

CREATE TABLE `roommate_links` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `share_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roommate_links`
--

INSERT INTO `roommate_links` (`id`, `request_id`, `member_id`, `share_link`) VALUES
(1, 1, 2, 'www.offcampus.com.ng/request_details.php?id=1'),
(2, 2, 5, 'www.offcampus.com.ng/request_details.php?id=2');

-- --------------------------------------------------------

--
-- Table structure for table `roommate_request`
--

CREATE TABLE `roommate_request` (
  `id` int(11) NOT NULL,
  `school` varchar(256) NOT NULL,
  `sex` varchar(20) NOT NULL,
  `accommodation` varchar(100) NOT NULL,
  `price` int(50) NOT NULL,
  `member_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roommate_request`
--

INSERT INTO `roommate_request` (`id`, `school`, `sex`, `accommodation`, `price`, `member_id`, `date`, `status`) VALUES
(1, 'Lagos State University', 'Female', 'one room', 70000, 2, '2017-01-02 16:26:36', 'unresolved'),
(2, 'Lagos State University', 'Male', 'one room self-contain', 35000, 5, '2017-01-10 20:32:31', 'unresolved');

-- --------------------------------------------------------

--
-- Table structure for table `roommate_seek`
--

CREATE TABLE `roommate_seek` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `accommodation_type` varchar(200) NOT NULL,
  `price` varchar(200) NOT NULL,
  `member_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roommate_seek`
--

INSERT INTO `roommate_seek` (`id`, `category`, `accommodation_type`, `price`, `member_id`) VALUES
(1, 'no_accommodation', 'not_required', 'not_required', 29);

-- --------------------------------------------------------

--
-- Table structure for table `school_request`
--

CREATE TABLE `school_request` (
  `id` int(11) NOT NULL,
  `school` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school_request`
--

INSERT INTO `school_request` (`id`, `school`, `location`) VALUES
(1, 'university of otuoke', 'bayelsa');

-- --------------------------------------------------------

--
-- Table structure for table `student_id`
--

CREATE TABLE `student_id` (
  `id` int(11) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `member_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(12) NOT NULL,
  `security_code` varchar(256) NOT NULL,
  `status` varchar(11) NOT NULL,
  `category` varchar(20) NOT NULL,
  `school` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone_number`, `security_code`, `status`, `category`, `school`) VALUES
(1, 'Obioha uche', 'radioactive.uche11@gmail.com', '54e0bdc4d17a1dbc8d5fe4393390efe9d599b7b405d8c9c69d4435c7e842bb01', '08067170799', '8d9a6e908ed2b731fb96151d9bb94d49', 'active', 'agent', 'Federal University of Technology, Akure'),
(2, 'Kingsley', 'kingskeyjk12@gmail.com', 'f83e1ed090415e9804275bf8794a2c8544c5a47f0c99f1aadc513787ba1d3184', '08152495524', '8d9a6e908ed2b731fb96151d9bb94d49', 'inactive', 'student', 'Lagos State University'),
(3, 'Tosin', 'thowsyne@gmail.com', 'ae87438f4a97a1bd94b854e7cd7a9fb54cc8d4adb59ea7b9b9df918a936b4ba6', '08063798271', '8d9a6e908ed2b731fb96151d9bb94d49', 'active', 'student', 'Federal University of Technology, Akure'),
(4, 'vince', 'nvnnyz@gmail.com', 'c127d021b54476c3fa97f1efb410bdb55a96b70ddf2f161fd8573c467bf8d19a', '07067990212', '8d9a6e908ed2b731fb96151d9bb94d49', 'inactive', 'student', 'University of Lagos'),
(5, 'Adam', 'adamarku@gmail.com', '3238a10c3f8750d5f3d55d06c0dfce400f36b2d5c1e82e0709c96c7015ea693b', '08123470155', '8d9a6e908ed2b731fb96151d9bb94d49', 'inactive', 'student', 'University of Ibadan'),
(6, 'OMjester', 'omjester@gmail.com', 'ea7afefee4c20692355f542e7c47d2db39b4e15d349dbb1c8ea99f90eb7dc1b8', '08167271566', '8d9a6e908ed2b731fb96151d9bb94d49', 'inactive', 'agent', 'University of Lagos'),
(7, 'ayomide odunuga', 'odunugaayodq@gmail.com', '1c7106f20699bb589c58a4b0089ab966c488cfe1b2ac3cdde119aefd02f2f8c8', '08093016488', '8d9a6e908ed2b731fb96151d9bb94d49', 'inactive', 'student', 'University of Lagos');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_members`
--
ALTER TABLE `admin_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ads_photos`
--
ALTER TABLE `ads_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ambassador`
--
ALTER TABLE `ambassador`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amb_photos`
--
ALTER TABLE `amb_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_agent`
--
ALTER TABLE `contact_agent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favourite`
--
ALTER TABLE `favourite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_request`
--
ALTER TABLE `post_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_photos`
--
ALTER TABLE `profile_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_count`
--
ALTER TABLE `request_count`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roommate_links`
--
ALTER TABLE `roommate_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roommate_request`
--
ALTER TABLE `roommate_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roommate_seek`
--
ALTER TABLE `roommate_seek`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_request`
--
ALTER TABLE `school_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_id`
--
ALTER TABLE `student_id`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_members`
--
ALTER TABLE `admin_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `ads_photos`
--
ALTER TABLE `ads_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `ambassador`
--
ALTER TABLE `ambassador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `amb_photos`
--
ALTER TABLE `amb_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_agent`
--
ALTER TABLE `contact_agent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favourite`
--
ALTER TABLE `favourite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `post_request`
--
ALTER TABLE `post_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profile_photos`
--
ALTER TABLE `profile_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_count`
--
ALTER TABLE `request_count`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roommate_links`
--
ALTER TABLE `roommate_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roommate_request`
--
ALTER TABLE `roommate_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roommate_seek`
--
ALTER TABLE `roommate_seek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `school_request`
--
ALTER TABLE `school_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_id`
--
ALTER TABLE `student_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
