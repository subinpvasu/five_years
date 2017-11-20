-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2016 at 08:27 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `omnitail_excelupload`
--

-- --------------------------------------------------------

--
-- Table structure for table `ad_schedule_status`
--

CREATE TABLE IF NOT EXISTS `ad_schedule_status` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `recordId` bigint(20) NOT NULL,
  `campaignName` varchar(200) NOT NULL,
  `campaign` varchar(50) NOT NULL,
  `bid` varchar(20) NOT NULL,
  `day` varchar(20) NOT NULL,
  `startHour` varchar(10) NOT NULL,
  `startMin` varchar(10) NOT NULL,
  `endHour` varchar(10) NOT NULL,
  `endMin` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1219 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
