-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2014 at 06:36 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `indore`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_charts`
--

CREATE TABLE IF NOT EXISTS `tbl_charts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `day` int(2) NOT NULL,
  `playlists` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `tbl_charts`
--

INSERT INTO `tbl_charts` (`id`, `uid`, `day`, `playlists`) VALUES
(1, 12, 0, '{36,35,36,23,35,24,26,22,36,34,35,36,34,21,24,21,36,25,26,26,36,35,26,36,22}'),
(2, 12, 1, '{35,22,22,36,22,35,34,35,25,25,35,25,36,35,24,36,36,36,36,21,35,36,22,35,36}'),
(3, 12, 2, '{25,22,21,21,34,36,35,35,36,24,22,24,22,34,26,23,35,21,21,21,23,34,24,23,25}'),
(4, 12, 3, '{21,35,25,23,36,25,25,35,36,35,22,36,22,24,34,22,25,26,36,21,35,35,25,26,24}'),
(5, 12, 4, '{36,22,35,35,21,22,35,26,35,22,36,22,35,23,23,26,35,24,35,21,35,22,36,25,35}'),
(6, 12, 5, '{35,23,24,36,22,35,36,21,35,36,35,21,35,36,23,34,35,21,36,26,35,23,36,35,35}'),
(7, 12, 6, '{35,21,25,24,24,36,24,26,25,36,34,36,35,22,21,35,26,22,21,23,26,34,36,25,36}'),
(8, 0, 0, '{36,21,34,24,21,36,22,24,23,36,35,22,23,36,36,36,24,25,24,21,23,36,22,21,24}'),
(9, 0, 1, '{36,26,34,23,34,22,23,35,21,34,21,36,34,22,26,36,21,36,34,26,36,24,34,36,35}'),
(10, 0, 2, '{26,21,35,24,24,24,36,34,26,36,26,36,21,36,34,25,22,21,24,24,35,36,35,36,35}'),
(11, 0, 3, '{22,36,35,22,34,22,36,36,21,21,21,35,23,22,22,21,21,35,23,36,34,34,25,23,36}'),
(12, 0, 4, '{34,24,35,36,24,25,25,36,22,25,24,22,25,36,21,21,35,21,34,36,22,26,21,36,35}'),
(13, 0, 5, '{25,36,25,24,21,25,34,36,35,22,21,35,23,35,36,36,25,21,25,25,21,34,25,22,35}'),
(14, 0, 6, '{24,34,26,26,36,24,26,36,35,21,36,35,35,21,24,36,36,36,24,34,35,25,21,36,36}'),
(15, 14, 0, '{36,21,34,24,21,27,22,24,23,36,35,22,23,36,36,28,24,25,24,18,23,28,22,21,24}'),
(16, 14, 1, '{36,26,34,23,34,22,23,35,21,34,18,27,34,22,26,28,18,28,34,26,28,24,34,36,35}'),
(17, 14, 2, '{26,21,35,24,24,24,27,34,26,36,26,28,21,27,34,25,22,21,24,24,35,28,35,36,27}'),
(18, 14, 3, '{22,28,27,22,34,22,36,36,18,21,21,35,23,22,22,18,18,35,23,28,34,34,25,23,28}'),
(19, 14, 4, '{34,24,27,36,24,25,25,28,22,25,24,22,25,36,21,18,35,21,34,28,22,26,21,28,27}'),
(20, 14, 5, '{25,36,25,24,21,25,34,36,35,22,18,35,23,35,36,36,25,21,25,25,21,34,25,22,35}'),
(21, 14, 6, '{24,34,26,26,28,24,26,28,27,18,36,27,35,21,24,36,36,28,24,34,35,25,18,28,36}'),
(22, 15, 0, '{36,21,34,24,21,27,22,24,23,36,35,22,23,36,36,28,24,25,24,18,23,28,22,21,24}'),
(23, 15, 1, '{36,26,34,23,34,22,23,35,21,34,18,27,34,22,26,28,18,28,34,26,28,24,34,36,35}'),
(24, 15, 2, '{26,21,35,24,24,24,27,34,26,36,26,28,21,27,34,25,22,21,24,24,35,28,35,36,27}'),
(25, 15, 3, '{22,28,27,22,34,22,36,36,18,21,21,35,23,22,22,18,18,35,23,28,34,34,25,23,28}'),
(26, 15, 4, '{34,24,27,36,24,25,25,28,22,25,24,22,25,36,21,18,35,21,34,28,22,26,21,28,27}'),
(27, 15, 5, '{25,36,25,24,21,25,34,36,35,22,18,35,23,35,36,36,25,21,25,25,21,34,25,22,35}'),
(28, 15, 6, '{24,34,26,26,28,24,26,28,27,18,36,27,35,21,24,36,36,28,24,34,35,25,18,28,36}');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customers`
--

CREATE TABLE IF NOT EXISTS `tbl_customers` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `uid` varchar(30) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `company` varchar(100) NOT NULL,
  `name` varchar(40) NOT NULL,
  `user_email` varchar(75) NOT NULL,
  `city` varchar(50) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `location` varchar(50) NOT NULL,
  `device` varchar(100) NOT NULL,
  `ad_no` int(3) NOT NULL DEFAULT '0',
  `ad_gap` int(3) NOT NULL DEFAULT '0',
  `jingle_gap` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `tbl_customers`
--

INSERT INTO `tbl_customers` (`id`, `uid`, `ip`, `company`, `name`, `user_email`, `city`, `status`, `location`, `device`, `ad_no`, `ad_gap`, `jingle_gap`) VALUES
(12, '10009', '', 'Hilton', 'Tower Bridge', '', 'London', 0, 'Bar', 'Samsung tab3', 3, 2, 5),
(13, '10012', '', 'Hilton3', 'Tower Bridge3', '', 'London', 0, 'Bar', 'Samsung tab3', 0, 0, 0),
(14, '10013', '', 'test', 'arif', '', 'London', 1, 'Bar', 'Samsung tab3', 0, 0, 0),
(15, '10014', '', 'test', 'arif2', '', 'London', 1, 'Bar', 'Samsung tab3', 0, 0, 0),
(16, '10015', '', 'test', 'arif121', '', 'trissur', 1, 'India', 'adafd', 0, 0, 0),
(17, '10025', '', 'TestCompany', 'TestName', '', 'TestCity', 0, 'TestLocation', 'TestDevice', 0, 0, 0),
(18, '10026', '', 'sdacfds', 'asxcxzcdsfcdsf', '', 'xzcxzc', 1, 'zxccc', 'cxzczxcc', 0, 0, 0),
(19, '10027', '', 'fdszczx', 'zxcxzc', '', 'zxcxzc', 1, 'xzczxc', 'xzczxc', 0, 0, 0),
(20, '10028', '', 'fdszczx', 'zxcxzc', '', 'zxcxzc', 1, 'xzczxc', 'xzczxc', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jingles`
--

CREATE TABLE IF NOT EXISTS `tbl_jingles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tittle` varchar(150) NOT NULL,
  `path` varchar(100) NOT NULL,
  `type` int(2) NOT NULL DEFAULT '1',
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_jingles`
--

INSERT INTO `tbl_jingles` (`id`, `tittle`, `path`, `type`, `customer_id`) VALUES
(2, 'test1', 'ads-jingles/ 5410.mp3', 0, 12),
(3, 'Jing', 'ads-jingles/jingle5701.mp3', 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lastplayed`
--

CREATE TABLE IF NOT EXISTS `tbl_lastplayed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `songs` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_playlists`
--

CREATE TABLE IF NOT EXISTS `tbl_playlists` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `style` varchar(150) NOT NULL DEFAULT '{0}',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `tbl_playlists`
--

INSERT INTO `tbl_playlists` (`id`, `name`, `style`) VALUES
(0, 'Silence', '{0}'),
(22, 'sscsdcc', '{1,2}'),
(23, 'test2', '{1,2}'),
(24, 'test12', '{1}'),
(25, 'test1213', '{1}'),
(26, 'test1213', '{1,5}'),
(34, 'Test final', '{0}'),
(35, 'Test final1', '{1,5}'),
(36, 'gbngv', '{1,5}'),
(39, 'test arif', '{1,2}'),
(40, 'retert', '{1,2}');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_songs`
--

CREATE TABLE IF NOT EXISTS `tbl_songs` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `style` varchar(50) NOT NULL DEFAULT '{0}',
  `path` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `tbl_songs`
--

INSERT INTO `tbl_songs` (`id`, `name`, `style`, `path`) VALUES
(5, '2 Track 07.mp3', '{1}', 'on14-01/song_fdd77205075e1aad9cda5af3f0ac4bf7.mp3'),
(8, 'kaanan.mp3', '{1,6}', 'on14-02/song_f79c5ed95a1876136769d25484abcc8f.mp3'),
(9, 'Ore Oru - Www.Tamilkey.Com.mp3', '{5,6,8}', 'on14-02/song_068af53fdb410efb19fc4cc4ce15038b.mp3'),
(10, '03 - Chori Kiya Re Jiya.mp3', '{1,8}', 'on14-02/song_dd5491f39344f447976d8e99b6b5f3b8.mp3'),
(12, 'neeum nilavum.mp3', '{5}', 'on14-03/song_abdf37fa44273a5cdab409bb9a2706a3.mp3'),
(26, 'kaanan.mp3', '{0}', 'on14-04/a9e2cc05ed2220370106a3d3c1f32669.mp3'),
(27, 'neeum nilavum.mp3', '{1,5,6}', 'on14-04/087545728fe6db5a024a2f5c0313b599.mp3'),
(28, 'kaanan.mp3', '{0}', 'on14-04/3813d49f88a5de0e7eec2adfd7ecc7b3.mp3'),
(29, 'neeum nilavum.mp3', '{0}', 'on14-04/b2fb9cd517c01aecdd49c0422ea77c81.mp3'),
(31, 'song_3ac432c308eb7db4090434c5c52765bc.mp3', '{0}', 'on14-04/ca62a342b36d71c8ff21402fc275145c.mp3'),
(32, 'kaanan.mp3', '{8,10}', 'on14-04/e0b3345783bab54f896a242e05eee684.mp3'),
(33, 'neeum nilavum.mp3', '{8,10}', 'on14-04/ec6165a6943eaf81e6849de3b3329108.mp3'),
(34, 'Pataka Guddi - Highway - [SongsPk.CC].mp3', '{8,10}', 'on14-04/87f4e0650017d5810b5146ad8a20d36b.mp3'),
(35, 'kaanan.mp3', '{8,10}', 'on14-04/768f09221e61e2091a9cbc5405057885.mp3'),
(36, 'kaanan.mp3', '{8,10}', 'on14-04/e0aa050d2e0ef6900911c368d5a53684.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_style`
--

CREATE TABLE IF NOT EXISTS `tbl_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbl_style`
--

INSERT INTO `tbl_style` (`id`, `name`) VALUES
(1, 'Rock'),
(5, 'zsxfczxc'),
(6, 'test'),
(7, 'test3'),
(8, 'test4'),
(9, 'test5'),
(10, 'atrif1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stylepercentage`
--

CREATE TABLE IF NOT EXISTS `tbl_stylepercentage` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `playlist` int(25) NOT NULL,
  `style` int(25) NOT NULL,
  `percentage` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `tbl_stylepercentage`
--

INSERT INTO `tbl_stylepercentage` (`id`, `playlist`, `style`, `percentage`) VALUES
(4, 18, 1, 40.45),
(5, 18, 2, 32),
(6, 21, 2, 50),
(8, 21, 3, 80),
(9, 22, 1, 100),
(10, 5, 1, 0),
(11, 5, 2, 100),
(12, 23, 1, 100),
(13, 23, 2, 100),
(14, 32, 1, 25),
(15, 32, 2, 30),
(16, 32, 3, 45),
(17, 33, 1, 33.34),
(18, 33, 2, 33.32),
(19, 33, 3, 33.34),
(20, 18, 3, 45),
(21, 21, 1, 20),
(22, 18, 5, 59.55),
(23, 35, 1, 75),
(24, 35, 5, 25),
(25, 36, 1, 50),
(26, 36, 5, 50),
(27, 21, 5, 30),
(28, 21, 6, 50),
(29, 21, 9, 0),
(30, 24, 1, 100),
(31, 25, 1, 100),
(32, 26, 1, 50),
(33, 26, 5, 50),
(34, 37, 1, 10),
(35, 37, 9, 100),
(36, 38, 1, 100);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(75) NOT NULL,
  `email` varchar(50) NOT NULL,
  `active` int(2) NOT NULL DEFAULT '0',
  `activation_code` int(11) NOT NULL,
  `password_reset` int(2) NOT NULL DEFAULT '0',
  `password_conformation_code` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `email`, `active`, `activation_code`, `password_reset`, `password_conformation_code`) VALUES
(3, 'arif', '273ae04a253a00753cec8c5b372c8c50c5bafeb20fd4668a51475fba33b1e9ab', 'caarif123@gmail.com', 1, 0, 1, '314011112241081'),
(12, 'admin', '273ae04a253a00753cec8c5b372c8c50c5bafeb20fd4668a51475fba33b1e9ab', 'admin@gmail.com', 1, 0, 0, '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
