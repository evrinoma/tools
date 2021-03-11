-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 20, 2019 at 10:49 AM
-- Server version: 5.5.52-MariaDB
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `setAutoIncrement`()
    MODIFIES SQL DATA
BEGIN
	  SELECT @max := AUTO_INCREMENT+1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'tools' AND TABLE_NAME = 'tb_spam_fishing';
      set @alter_statement = concat('ALTER TABLE `tools`.`tb_spam_fishing` AUTO_INCREMENT = ', @max);
      PREPARE stmt FROM @alter_statement;
      EXECUTE stmt;
      DEALLOCATE PREPARE stmt;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `relaytofrom`
--

CREATE TABLE IF NOT EXISTS `relaytofrom` (
  `id` bigint(20) NOT NULL,
  `relay_ip` char(16) DEFAULT NULL,
  `mail_from` varchar(255) DEFAULT NULL,
  `rcpt_to` varchar(255) DEFAULT NULL,
  `block_expires` datetime NOT NULL,
  `record_expires` datetime NOT NULL,
  `blocked_count` bigint(20) NOT NULL DEFAULT '0',
  `passed_count` bigint(20) NOT NULL DEFAULT '0',
  `aborted_count` bigint(20) NOT NULL DEFAULT '0',
  `origin_type` enum('MANUAL','AUTO') NOT NULL,
  `create_time` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_spam_hits`
--

CREATE TABLE IF NOT EXISTS `tb_spam_hits` (
  `id` int(11) NOT NULL,
  `tb_spam_rules` int(11) NOT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `destination` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tb_domains`,`tb_emails`, `tb_spam_rules`;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `relaytofrom`
--
ALTER TABLE `relaytofrom`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relay_ip` (`relay_ip`),
  ADD KEY `mail_from` (`mail_from`(20)),
  ADD KEY `rcpt_to` (`rcpt_to`(20));

--
--
-- Indexes for table `tb_spam_hits`
--
ALTER TABLE `tb_spam_hits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `relaytofrom`
--
ALTER TABLE `relaytofrom`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
-- AUTO_INCREMENT for table `tb_spam_hits`
--
ALTER TABLE `tb_spam_hits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
