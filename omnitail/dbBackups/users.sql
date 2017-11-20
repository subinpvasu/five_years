-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2016 at 01:35 PM
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
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1: admin',
  `del_status` tinyint(4) NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
  `added` datetime NOT NULL,
  `updated` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `del_status`, `last_login`, `added`, `updated`) VALUES
(1, 'Omni Tail Tools', 'omnitailtools@gmail.com', '9b57fba144c21575590f221ab668e146', 1, 0, '2016-03-08 17:58:26', '2016-03-08 16:56:18', '2016-03-08 11:26:18'),
(2, 'Deepa', 'deepa@dtcm.in', '593a721839c7356f63243febda99cc33', 0, 0, '0000-00-00 00:00:00', '2016-03-08 17:43:08', '2016-03-08 12:15:06'),
(3, 'Bisjo', 'bis@dtcm.in', '9b57fba144c21575590f221ab668e146', 0, 0, '2016-03-08 17:59:34', '2016-03-08 17:45:33', '2016-03-08 12:29:02');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
