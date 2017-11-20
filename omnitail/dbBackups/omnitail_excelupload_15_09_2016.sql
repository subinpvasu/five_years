-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2016 at 01:03 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `omnitail_excelupload`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=9388 DEFAULT CHARSET=latin1;

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
  `crid` varchar(50) NOT NULL,
  `campaign_name` text NOT NULL,
  `adgroup_name` text NOT NULL,
  `crname` text NOT NULL,
  `bid` varchar(15) NOT NULL,
  `added` varchar(50) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `customerid` (`customerid`,`campaignid`,`adgroupid`)
) ENGINE=InnoDB AUTO_INCREMENT=1076635 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ad_audience_status`
--

DROP TABLE IF EXISTS `ad_audience_status`;
CREATE TABLE IF NOT EXISTS `ad_audience_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recordId` int(11) NOT NULL,
  `campaignid` varchar(200) NOT NULL,
  `campaign_name` varchar(150) NOT NULL,
  `adgroupid` varchar(150) NOT NULL,
  `adgroup_name` varchar(50) NOT NULL,
  `audienceid` varchar(50) NOT NULL,
  `audience_name` varchar(50) NOT NULL,
  `bid_adjust` varchar(50) NOT NULL,
  `targeting_setting` varchar(50) NOT NULL,
  `status` varchar(25) NOT NULL,
  `message` text NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12688 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ad_schedule_status`
--

DROP TABLE IF EXISTS `ad_schedule_status`;
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
  `status` varchar(20) NOT NULL DEFAULT 'Not Processed',
  `message` text NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=518031 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_data`
--

DROP TABLE IF EXISTS `campaign_data`;
CREATE TABLE IF NOT EXISTS `campaign_data` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customerid` varchar(50) NOT NULL,
  `campaignid` varchar(30) NOT NULL,
  `campaign_name` text NOT NULL,
  `type` varchar(15) NOT NULL,
  `added` varchar(50) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `customerid` (`customerid`,`campaignid`)
) ENGINE=InnoDB AUTO_INCREMENT=46244 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `criterion_data`
--

DROP TABLE IF EXISTS `criterion_data`;
CREATE TABLE IF NOT EXISTS `criterion_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customerid` varchar(150) NOT NULL,
  `campaignid` varchar(150) NOT NULL,
  `adgroupid` varchar(150) NOT NULL,
  `criterionid` varchar(150) NOT NULL,
  `crname` text NOT NULL,
  `crbid` varchar(150) NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `customerid` (`customerid`,`campaignid`,`adgroupid`),
  KEY `criterionid` (`criterionid`)
) ENGINE=MyISAM AUTO_INCREMENT=485434 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `extended_ads_status`
--

DROP TABLE IF EXISTS `extended_ads_status`;
CREATE TABLE IF NOT EXISTS `extended_ads_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recordId` int(11) NOT NULL,
  `headline1` varchar(150) NOT NULL,
  `headline2` varchar(150) NOT NULL,
  `keyword1` varchar(250) NOT NULL,
  `keyword2` varchar(250) NOT NULL,
  `keyword3` varchar(250) NOT NULL,
  `keyword4` varchar(250) NOT NULL,
  `finalurl` varchar(2500) NOT NULL,
  `description` varchar(150) NOT NULL,
  `path1` varchar(250) NOT NULL,
  `path2` varchar(150) NOT NULL,
  `availability` varchar(150) NOT NULL,
  `campaign_name` varchar(250) NOT NULL,
  `adgroup_name` varchar(250) NOT NULL,
  `bid` varchar(50) NOT NULL,
  `budget` varchar(50) NOT NULL,
  `status` text NOT NULL,
  `message` text NOT NULL,
  `error` text NOT NULL,
  `added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=294 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `process_status`
--

DROP TABLE IF EXISTS `process_status`;
CREATE TABLE IF NOT EXISTS `process_status` (
  `statusId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `record_id` int(10) UNSIGNED DEFAULT NULL,
  `position_no` int(10) UNSIGNED DEFAULT NULL,
  `processed_status` varchar(200) DEFAULT NULL,
  `target` text,
  `target_data` text,
  `brand` text,
  `clo` text,
  `campaign_name` text,
  `ad_group_name` text,
  `bid` text,
  `priority` varchar(45) DEFAULT NULL,
  `merchant_id` varchar(100) DEFAULT NULL,
  `budget` varchar(45) DEFAULT NULL,
  `label` text,
  `country` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`statusId`)
) ENGINE=InnoDB AUTO_INCREMENT=153375 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=127963 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=41723 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=127485 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_records`
--

DROP TABLE IF EXISTS `tbl_records`;
CREATE TABLE IF NOT EXISTS `tbl_records` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `uploadStarted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uploadFinished` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `upload_name` text,
  `user_id_fk` int(10) UNSIGNED NOT NULL,
  `account_id` varchar(100) NOT NULL,
  `upload_status` int(11) NOT NULL DEFAULT '0',
  `location` varchar(10) NOT NULL DEFAULT '1' COMMENT '1 for campaigns,2 for schedule',
  `total_rows` int(11) NOT NULL,
  `finished_count` int(11) NOT NULL,
  `process_enabled` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=836 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `test_tbl`
--

DROP TABLE IF EXISTS `test_tbl`;
CREATE TABLE IF NOT EXISTS `test_tbl` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `text` text,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12061 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_campaigns`
--
ALTER TABLE `tbl_campaigns`
  ADD CONSTRAINT `FK_tbl_campaigns_1` FOREIGN KEY (`recordId`) REFERENCES `tbl_records` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
