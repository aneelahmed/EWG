-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2015 at 02:25 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stock`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
`id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@admin.com', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
`id` int(11) NOT NULL,
  `chatId` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `message` text NOT NULL,
  `attachment` varchar(300) NOT NULL,
  `chatType` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groupmembers`
--

CREATE TABLE IF NOT EXISTS `groupmembers` (
  `id` int(11) DEFAULT NULL,
  `groupId` int(11) NOT NULL,
  `memberId` int(11) NOT NULL,
  `memberType` varchar(250) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
`id` int(11) NOT NULL,
  `title` text NOT NULL,
  `slug` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `investers`
--

CREATE TABLE IF NOT EXISTS `investers` (
`id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL COMMENT 'First Name',
  `lname` varchar(255) NOT NULL COMMENT 'Last Name',
  `email` varchar(255) NOT NULL COMMENT 'Email Address',
  `password` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL COMMENT 'Date of Birth',
  `gender` varchar(255) NOT NULL COMMENT 'Male/Female',
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `thumb` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `activationCode` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `investers`
--

INSERT INTO `investers` (`id`, `fname`, `lname`, `email`, `password`, `dob`, `gender`, `city`, `country`, `datetime`, `thumb`, `status`, `activationCode`) VALUES
(13, 'Zain', 'ud-din', 'zain@yopmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2014-01-01', 'Male', 'mingora', 'pakistan', '2015-11-23 06:59:11', '', 1, 'Activated'),
(14, 'Abid', 'Ali', 'abid@yopmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2014-01-01', 'Male', 'jhang', 'pakistan', '2015-11-23 07:00:18', '', 0, 'Activated'),
(15, 'Afaan', 'Ahmed', 'afaan@yopmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2014-01-01', 'Male', 'Islamabad', 'Pakistan', '2015-12-11 13:24:34', '', 0, 'Activated'),
(16, 'Yasir', 'Ahmed', 'yasir@yopmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1988-09-19', 'Male', 'Islamabad', 'pakistan', '2015-12-17 12:41:30', '', 0, 'g00uuh3r'),
(17, 'Hameed', 'Gul', 'hamid@yopmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1988-09-19', 'Male', 'Islamabad', 'Pakistan', '2015-12-17 12:43:54', 'assets/userUploads/profilePic/05b3d14893172d5cde190a1c36ffdae4.jpg', 0, 'bwmbetsy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investers`
--
ALTER TABLE `investers`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `investers`
--
ALTER TABLE `investers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
