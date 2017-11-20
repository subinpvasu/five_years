-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mar 14, 2016 at 09:21 AM
-- Server version: 5.5.48-MariaDB
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `omnitail_excelupload`
--
CREATE DATABASE IF NOT EXISTS `omnitail_excelupload` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `omnitail_excelupload`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `spot_updateFinishedRows`$$
CREATE DEFINER=`omnitail`@`localhost` PROCEDURE `spot_updateFinishedRows`(refid int)
BEGIN

  declare currentCount varchar(50);
  set @currentCount=(select finished_count from  tbl_records  where tbl_records.id=refid)+1;
  update tbl_records set finished_count=@currentCount where tbl_records.id=refid;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `account_details`
--

DROP TABLE IF EXISTS `account_details`;
CREATE TABLE IF NOT EXISTS `account_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `account_number` varchar(15) NOT NULL,
  `mccid` varchar(25) NOT NULL,
  `prospect` int(1) NOT NULL DEFAULT '0' COMMENT '1 for prospect',
  `currency_code` varchar(15) NOT NULL,
  `added` date NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=767 ;

-- --------------------------------------------------------

--
-- Table structure for table `adgroup_data`
--

DROP TABLE IF EXISTS `adgroup_data`;
CREATE TABLE IF NOT EXISTS `adgroup_data` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customerid` varchar(50) NOT NULL,
  `campaignid` varchar(50) NOT NULL,
  `adgroupid` varchar(50) NOT NULL,
  `campaign_name` varchar(100) NOT NULL,
  `adgroup_name` varchar(100) NOT NULL,
  `crname` varchar(100) NOT NULL,
  `bid` varchar(15) NOT NULL,
  `added` varchar(50) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=507579 ;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_data`
--

DROP TABLE IF EXISTS `campaign_data`;
CREATE TABLE IF NOT EXISTS `campaign_data` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customerid` varchar(50) NOT NULL,
  `campaignid` varchar(30) NOT NULL,
  `campaign_name` varchar(100) NOT NULL,
  `type` varchar(15) NOT NULL,
  `added` varchar(50) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20156 ;

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

DROP TABLE IF EXISTS `credentials`;
CREATE TABLE IF NOT EXISTS `credentials` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `access_token` text NOT NULL,
  `refresh_token` text NOT NULL,
  `thetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `process_status`
--

DROP TABLE IF EXISTS `process_status`;
CREATE TABLE IF NOT EXISTS `process_status` (
  `statusId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `record_id` int(10) unsigned DEFAULT NULL,
  `position_no` int(10) unsigned DEFAULT NULL,
  `processed_status` varchar(200) DEFAULT NULL,
  `target` varchar(45) DEFAULT NULL,
  `target_data` varchar(100) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `clo` varchar(100) DEFAULT NULL,
  `campaign_name` varchar(100) DEFAULT NULL,
  `ad_group_name` varchar(100) DEFAULT NULL,
  `bid` varchar(45) DEFAULT NULL,
  `priority` varchar(45) DEFAULT NULL,
  `merchant_id` varchar(100) DEFAULT NULL,
  `budget` varchar(45) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`statusId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6557 ;

-- --------------------------------------------------------

--
-- Table structure for table `prospect_credentials`
--

DROP TABLE IF EXISTS `prospect_credentials`;
CREATE TABLE IF NOT EXISTS `prospect_credentials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `account_number` varchar(150) NOT NULL,
  `manage` int(1) NOT NULL DEFAULT '0' COMMENT '1 for mcc',
  `access_token` varchar(500) NOT NULL,
  `refresh_token` varchar(500) NOT NULL,
  `prospect` int(1) NOT NULL DEFAULT '0',
  `account_status` int(11) NOT NULL DEFAULT '1' COMMENT '1 for active,0 for inactive',
  `primary_download` int(11) NOT NULL DEFAULT '1' COMMENT '2 for end',
  `secondary_download` int(11) NOT NULL DEFAULT '0' COMMENT '1 for working',
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_number` (`account_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_adgroups`
--

DROP TABLE IF EXISTS `tbl_adgroups`;
CREATE TABLE IF NOT EXISTS `tbl_adgroups` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `adgroupId` varchar(50) NOT NULL,
  `adgroupName` text NOT NULL,
  `adgroupStatus` int(2) NOT NULL DEFAULT '0',
  `campaignId` int(50) NOT NULL,
  `merchantId` int(50) NOT NULL,
  `adgroupCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastUpdated` date NOT NULL,
  `recordId` int(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_adgroups_1` (`campaignId`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16116 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_campaigns`
--

DROP TABLE IF EXISTS `tbl_campaigns`;
CREATE TABLE IF NOT EXISTS `tbl_campaigns` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `campaignId` int(50) NOT NULL,
  `campaignName` text NOT NULL,
  `campaignStatus` int(2) NOT NULL DEFAULT '0',
  `merchantId` int(50) NOT NULL,
  `campaignCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastUpdated` date NOT NULL,
  `recordId` int(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_campaigns_1` (`recordId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13494 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_productgroups`
--

DROP TABLE IF EXISTS `tbl_productgroups`;
CREATE TABLE IF NOT EXISTS `tbl_productgroups` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `target` varchar(100) NOT NULL,
  `targetData` text NOT NULL,
  `adgroupId` int(50) NOT NULL,
  `merchantId` int(50) NOT NULL,
  `campaignId` int(50) NOT NULL,
  `productGropuCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `recordId` int(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_productgroups_1` (`adgroupId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15985 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_records`
--

DROP TABLE IF EXISTS `tbl_records`;
CREATE TABLE IF NOT EXISTS `tbl_records` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `uploadStarted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uploadFinished` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `upload_name` varchar(150) DEFAULT NULL,
  `user_id_fk` int(10) unsigned NOT NULL,
  `account_id` varchar(100) NOT NULL,
  `upload_status` int(11) NOT NULL DEFAULT '0',
  `location` varchar(10) NOT NULL DEFAULT '1' COMMENT '1 for campaigns,2 for schedule',
  `total_rows` int(11) NOT NULL,
  `finished_count` int(11) NOT NULL,
  `process_enabled` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=271 ;

-- --------------------------------------------------------

--
-- Table structure for table `test_tbl`
--

DROP TABLE IF EXISTS `test_tbl`;
CREATE TABLE IF NOT EXISTS `test_tbl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9721 ;

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

DROP TABLE IF EXISTS `timetable`;
CREATE TABLE IF NOT EXISTS `timetable` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customerid` varchar(50) NOT NULL,
  `lasttime` varchar(50) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1: admin',
  `del_status` tinyint(4) NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
  `added` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_adgroups`
--
ALTER TABLE `tbl_adgroups`
  ADD CONSTRAINT `FK_tbl_adgroups_1` FOREIGN KEY (`campaignId`) REFERENCES `tbl_campaigns` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_campaigns`
--
ALTER TABLE `tbl_campaigns`
  ADD CONSTRAINT `FK_tbl_campaigns_1` FOREIGN KEY (`recordId`) REFERENCES `tbl_records` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_productgroups`
--
ALTER TABLE `tbl_productgroups`
  ADD CONSTRAINT `FK_tbl_productgroups_1` FOREIGN KEY (`adgroupId`) REFERENCES `tbl_adgroups` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
