-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2016 at 09:56 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@admin.com', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invester_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `detail` text NOT NULL,
  `time_stamp` timestamp NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `invester_id`, `title`, `detail`, `time_stamp`, `image`) VALUES
(1, 25, 'My Blog', 'Lorem ipsum is a dummy text. Lorem ipsum is a dummy text. Lorem ipsum is a dummy text. Lorem ipsum is a dummy text. Lorem ipsum is a dummy text. Lorem ipsum is a dummy text. Lorem ipsum is a dummy text. Lorem ipsum is a dummy text. ', '2016-01-05 04:04:03', 'assets/blogPic/547ceffead1eb4c5ee32149ed70ce186.png'),
(2, 16, 'Blog', 'My blog post on stock', '2016-01-05 22:15:20', 'assets/blogPic/f4d3efe56ffc21fecae896db5d9aa2dc.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chatId` varchar(100) NOT NULL,
  `sender` int(11) NOT NULL,
  `message` text NOT NULL,
  `attachment` varchar(300) NOT NULL,
  `chatType` varchar(250) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `chatId`, `sender`, `message`, `attachment`, `chatType`, `timestamp`) VALUES
(1, '', 16, 'hello this message is from public chat widget.\n', '', 'public', '2016-01-04 10:09:17'),
(2, '', 16, 'hello this message is from public chat widget.\n', '', 'public', '2016-01-04 10:13:18'),
(3, '', 16, 'yes its working from this widget\n', '', 'public', '2016-01-04 10:19:08'),
(4, '', 16, 'jl;kjkj lkjkl \n', '', 'public', '2016-01-04 10:20:57'),
(5, '', 16, 'ok now test the chat loading\n', '', 'public', '2016-01-04 10:30:01'),
(6, '', 16, 'give it another try to the chat load function\n', '', 'public', '2016-01-04 10:30:54'),
(7, '', 16, 'give it another try to the chat load function.\n', '', 'public', '2016-01-04 10:31:51'),
(8, '', 16, 'test foreach statement\n', '', 'public', '2016-01-04 10:35:13'),
(9, '', 16, 'hello please load messages\n', '', 'public', '2016-01-04 10:40:16'),
(10, '', 16, 'hello message plz\n', '', 'public', '2016-01-04 10:56:10'),
(11, '', 16, 'dafadfdf sdf adf adf\n', '', 'public', '2016-01-04 10:58:39'),
(12, '', 16, 'hello hi how are you\n', '', 'public', '2016-01-04 11:00:51'),
(13, '', 16, 'haan ji\n', '', 'public', '2016-01-04 11:02:55');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invester_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `comment_detail` text NOT NULL,
  `time_stamp` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `invester_id`, `blog_id`, `comment_detail`, `time_stamp`) VALUES
(1, 25, 1, 'Lorem Ipsum is dummy text.', '2016-01-05 06:00:46'),
(2, 25, 1, 'Lorem Ipsum is a', '2016-01-05 06:11:46');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(250) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `path`, `datetime`) VALUES
(27, 'assets/gallery/b97825b2db9149c9c6895d9e7dfb827a.jpg', '2015-12-23 16:19:51'),
(28, 'assets/gallery/5dc828b25f188ca800c995af1ab763b5.jpg', '2015-12-23 16:22:22'),
(29, 'assets/gallery/babe962366c7e85ce44adf4cf08aad92.jpg', '2015-12-23 16:22:29'),
(30, 'assets/gallery/edca0f8c7ac10871c5d61c6d708cb03e.jpg', '2015-12-23 16:22:35'),
(31, 'assets/gallery/45038b05af674f800d76954a276f76e2.jpg', '2015-12-23 16:22:51'),
(32, 'assets/gallery/e3a75f4c3108e3905442ce30e1d20e90.jpg', '2015-12-23 16:22:58'),
(33, 'assets/gallery/f3ea46968fc223579cfb0441c4e57cb9.jpg', '2015-12-23 16:23:05');

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `slug` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `investers`
--

CREATE TABLE IF NOT EXISTS `investers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `activationCode` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `investers`
--

INSERT INTO `investers` (`id`, `fname`, `lname`, `email`, `password`, `dob`, `gender`, `city`, `country`, `datetime`, `thumb`, `status`, `activationCode`) VALUES
(13, 'Zain', 'ud-din', 'zain@yopmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2014-01-01', 'Male', 'mingora', 'pakistan', '2015-11-23 06:59:11', 'assets/userUploads/profilePic/2e1f4b2479d989d4157b9922d0a35d08.jpg', 0, 'Activated'),
(14, 'Abid', 'Ali', 'abid@yopmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2014-01-01', 'Male', 'jhang', 'pakistan', '2015-11-23 07:00:18', 'assets/userUploads/profilePic/d0bd11766d0de77dd65c99df90368cd5.jpg', 1, 'Activated'),
(15, 'Afaan', 'Ahmed', 'afaan@yopmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2014-01-01', 'Male', 'Islamabad', 'Pakistan', '2015-12-11 13:24:34', 'assets/userUploads/profilePic/8e14e8e6613bf4b4ac4714dea7fed6b2.jpg', 0, 'Activated'),
(16, 'Yasir', 'Ahmed', 'yasir@yopmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1988-09-19', 'Male', 'Islamabad', 'pakistan', '2015-12-17 12:41:30', 'assets/userUploads/profilePic/908d89bc910c8237a17ea80dacfd9821.jpeg', 1, 'g00uuh3r'),
(17, 'Hameed', 'Gul', 'hamid@yopmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1988-09-19', 'Male', 'Islamabad', 'Pakistan', '2015-12-17 12:43:54', 'assets/userUploads/profilePic/b8ac2011dcbb069d666e6664bd16badf.jpg', 1, 'bwmbetsy'),
(18, 'Yasir', 'Ahmed', 'yasir1@yopmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2014-01-01', 'Male', 'Islamabad', 'islamabad', '2015-12-23 12:12:46', 'assets/userUploads/profilePic/4eb5daa8dc0a66ed53ab8a954cf939e4.jpg', 0, '6e4uk2ax'),
(19, 'Hameed', 'Gul', 'hamid3@yopmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2014-01-01', 'Male', 'Islamabad', 'islababad', '2015-12-23 12:13:25', 'assets/userUploads/profilePic/f7036da7bd8726cec572d5e160981d25.jpg', 0, 'yr20u86v'),
(20, 'Afaan', 'Ahmed', 'afaaeen@yopmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2014-01-01', 'Male', 'Islamabad', 'islababad', '2015-12-23 12:14:00', 'assets/userUploads/profilePic/39470befcfdb8ea5e2068213259fabef.jpeg', 0, '30boyd8w'),
(21, 'Yasir', 'Ahmed', 'yasissr@yopmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2014-01-01', 'Male', 'Islamabad', 'islababad', '2015-12-23 12:14:26', 'assets/userUploads/profilePic/364cbef720dc9ae656523ae5ca915e4d.jpg', 0, '5st7dkvo'),
(22, 'Hameed', 'Ahmed', 'hamidds3@yopmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2014-01-01', 'Male', 'Islamabad', 'islababad', '2015-12-23 12:14:55', 'assets/userUploads/profilePic/a0f850954e5562aa2f5e146b0c9f8292.jpg', 0, '4krwds30'),
(23, 'Afaan', 'Ahmed', 'afaasseen@yopmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2014-01-01', 'Male', 'Islamabad', 'islababad', '2015-12-23 12:15:23', 'assets/userUploads/profilePic/3c2d041cfd54d909cbdcd72b7877a322.jpg', 0, '4syaww2j'),
(24, 'Yasir', 'Ahmed', 'yasdfsdfssir@yopmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2014-01-01', 'Male', 'Islamabad', 'islababad', '2015-12-23 12:15:49', 'assets/userUploads/profilePic/4fb6e01f76bd9c091ff4cfe8e1ce6d90.jpg', 0, 't62d387v'),
(25, 'Disco', 'Molvi', 'disco@molvi.com', 'e10adc3949ba59abbe56e057f20f883e', '1990-08-09', 'Male', 'Islamabad', 'Pakistan', '2015-12-29 13:18:30', 'assets/userUploads/profilePic/114d64c0055cf496206adc6af6b961c2.jpg', 0, 'o58rdzhb');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) NOT NULL,
  `path` varchar(300) NOT NULL,
  `type` varchar(250) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `title`, `path`, `type`, `datetime`) VALUES
(2, '2015 stock market Report', 'assets/reports/62ecd06f70cd3ddc3b6fd74c77bea289.pdf', 'Local', '2015-01-01 00:00:00'),
(3, '2014 stock market Report', 'assets/reports/e2de89fb9bf54e5fc2b2a147de167bbb.pdf', 'Local', '2015-01-01 00:00:00'),
(4, '2013 stock market Report', 'assets/reports/63a2484e21118b085078828aedd4c99d.pdf', 'Local', '2015-01-01 00:00:00'),
(5, '2012 stock market Report', 'assets/reports/574f35ac745e55b188a41e665bd74515.pdf', 'Local', '2015-01-01 00:00:00'),
(6, '2011 stock market Report', 'assets/reports/c41087baa95b2457f0cdb83b8966a605.pdf', 'Local', '2015-01-01 00:00:00'),
(7, '2011 stock market Report', 'assets/reports/4f497a8f458813d4ebc98f633729ae30.pdf', 'International', '2015-01-01 00:00:00'),
(8, '2012 stock market Report', 'assets/reports/d50de83d2b0c4a0fcd1a1ddecb9ea2b3.pdf', 'International', '2015-01-01 00:00:00'),
(9, '2013 stock market Report', 'assets/reports/a9a84b00f52ec54a1541cf36374c09fe.pdf', 'International', '2015-01-01 00:00:00'),
(10, '2014 stock market Report', 'assets/reports/14bd10596658ccd187feb03d294d9c5b.pdf', 'International', '2015-01-01 00:00:00'),
(11, '2015 stock market Report', 'assets/reports/0fa0d63d8e6e587c64c62b48e7d75d6e.pdf', 'International', '2015-01-01 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
