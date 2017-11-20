-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2016 at 11:45 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hostpush_adwords_ricky`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `spad_getdailyreports`$$
CREATE DEFINER=`hostpush`@`localhost` PROCEDURE `spad_getdailyreports` (`refusername` VARCHAR(45))  BEGIN

    if refusername='' or refusername='master' then
      select * from management_daily_report;
    else
      select * from management_daily_report where user_name = refusername;
    end if;


END$$

DROP PROCEDURE IF EXISTS `spad_getsummeryreports`$$
CREATE DEFINER=`hostpush`@`localhost` PROCEDURE `spad_getsummeryreports` (`refusername` VARCHAR(45), `report` INT)  BEGIN

    if refusername='' then
      select * from management_summery_report;
    else if report= 1 then
      select * from management_summery_report where user_name = refusername and Top_5_biggest_increse_in_visitors=1;
    else if report = 2 then
      select * from management_summery_report where user_name = refusername and Biggest_Increases_in_CPC=1;
    else if report = 3 then
      select * from management_summery_report where user_name = refusername and Biggest_underspends=1;
    else if report = 4 then
      select * from management_summery_report where user_name = refusername and Worst_5_with_biggest_decrease_in_visitors=1;
    else if report = 5 then
      select * from management_summery_report where user_name = refusername and Best_Decreases_in_CPC=1;
    else if report = 6 then
      select * from management_summery_report where user_name = refusername and biggest_Overspends=1;
    else if report = 7 then
      select * from management_summery_report where user_name = refusername and Biggest_Gain_in_Expected_Conversions=1;
    else if report = 8 then
      select * from management_summery_report where user_name = refusername and Biggest_Change_in_CPA=1;
    else if report = 9 then
      select * from management_summery_report where user_name = refusername and Worst_drop_in_expected_conversions=1;
    else if report = 10 then
      select * from management_summery_report where user_name = refusername and Best_Change_in_CPA=1;
    end if;
    end if;
    end if;
    end if;
    end if;
    end if;
    end if;
    end if;
    end if;
    end if;
    end if;


END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `login_statistics`
--

DROP TABLE IF EXISTS `login_statistics`;
CREATE TABLE IF NOT EXISTS `login_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `mccid` int(11) NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_statistics`
--

INSERT INTO `login_statistics` (`id`, `user_id`, `mccid`, `login_time`, `logout_time`) VALUES
(8, 3, 2147483647, '2016-10-07 17:13:21', '0000-00-00 00:00:00'),
(4, 12, 2147483647, '2016-10-07 14:03:20', '2016-10-07 14:03:29'),
(5, 12, 2147483647, '2016-10-07 14:03:52', '2016-10-07 14:03:59'),
(6, 12, 2147483647, '2016-10-07 14:09:28', '2016-10-07 17:02:53'),
(7, 12, 2147483647, '2016-10-07 17:03:06', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
