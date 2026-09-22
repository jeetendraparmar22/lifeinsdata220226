-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2024 at 05:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `lifeins_sessions` (
  `session_id` varchar(128) NOT NULL,
  `session_data` mediumblob NOT NULL,
  `last_activity` int(10) unsigned NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `idx_lifeins_sessions_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `life_ins`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `adminid` int(11) NOT NULL,
  `adminname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `adminusername` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `adminpassword` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employeedetail`
--

CREATE TABLE `employeedetail` (
  `id` int(11) NOT NULL,
  `empname` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(150) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `status` varchar(200) NOT NULL,
  `utype` varchar(200) NOT NULL,
  `subadmin` varchar(255) NOT NULL,
  `to_date` date NOT NULL,
  `flag` enum('1','0') NOT NULL DEFAULT '1',
  `last_action_time` datetime DEFAULT NULL,
  `active_time` time DEFAULT NULL,
  `deactive_time` time DEFAULT NULL,
  `active_date` varchar(255) NOT NULL,
  `deactive_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` int(11) NOT NULL,
  `formno` varchar(100) DEFAULT NULL,
  `record_no` varchar(100) DEFAULT NULL,
  `invoice_no` varchar(100) DEFAULT NULL,
  `demoDate` varchar(100) DEFAULT NULL,
  `customer_id` varchar(20) DEFAULT NULL,
  `fileno` varchar(50) DEFAULT NULL,
  `ph_name` varchar(100) DEFAULT NULL,
  `ph_address` mediumtext DEFAULT NULL,
  `ph_city` varchar(100) DEFAULT NULL,
  `ph_state` varchar(255) DEFAULT NULL,
  `ph_zip` varchar(10) DEFAULT NULL,
  `ph_phone` varchar(15) DEFAULT NULL,
  `ph_email` varchar(100) DEFAULT NULL,
  `ph_dob` varchar(100) DEFAULT NULL,
  `education` varchar(100) DEFAULT NULL,
  `nominee_name` varchar(100) DEFAULT NULL,
  `nominee_address` mediumtext DEFAULT NULL,
  `nominee_city` varchar(100) DEFAULT NULL,
  `nominee_state` varchar(100) DEFAULT NULL,
  `nominee_zip` varchar(15) DEFAULT NULL,
  `relation_with_nominee` varchar(100) DEFAULT NULL,
  `chest` varchar(100) DEFAULT NULL,
  `height` varchar(100) DEFAULT NULL,
  `weight` varchar(100) DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `policyno` varchar(100) DEFAULT NULL,
  `referenceno` varchar(100) DEFAULT NULL,
  `agentname` varchar(100) DEFAULT NULL,
  `agent_address` mediumtext DEFAULT NULL,
  `agent_city` varchar(100) DEFAULT NULL,
  `agent_state` varchar(100) DEFAULT NULL,
  `agent_zipcode` varchar(15) DEFAULT NULL,
  `agent_code` varchar(15) DEFAULT NULL,
  `agent_licenceno` varchar(25) DEFAULT NULL,
  `plane_name` varchar(100) DEFAULT NULL,
  `plan_code` varchar(15) DEFAULT NULL,
  `soi` varchar(100) DEFAULT NULL,
  `poi` varchar(100) DEFAULT NULL,
  `chek1` varchar(100) DEFAULT NULL,
  `chek2` varchar(100) DEFAULT NULL,
  `chek3` varchar(100) DEFAULT NULL,
  `chek4` varchar(100) DEFAULT NULL,
  `chek5` varchar(100) DEFAULT NULL,
  `chek6` varchar(100) DEFAULT NULL,
  `chek7` varchar(100) DEFAULT NULL,
  `chek8` varchar(100) DEFAULT NULL,
  `chek9` varchar(100) DEFAULT NULL,
  `chek10` varchar(100) DEFAULT NULL,
  `payment_option` varchar(100) DEFAULT NULL,
  `premium` varchar(10) DEFAULT NULL,
  `discount` varchar(50) DEFAULT NULL,
  `total_amount` varchar(100) DEFAULT NULL,
  `card_type` varchar(100) DEFAULT NULL,
  `card_no` varchar(100) DEFAULT NULL,
  `expiry_date` varchar(100) DEFAULT NULL,
  `card_holder_name` varchar(100) DEFAULT NULL,
  `transactionid` varchar(100) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `captcha` varchar(100) DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `post_datetime` datetime DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  `eid` int(10) DEFAULT NULL,
  `ename` varchar(100) DEFAULT NULL,
  `usertype` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subadmin`
--

CREATE TABLE `subadmin` (
  `id` int(11) NOT NULL,
  `adminusername` varchar(200) NOT NULL,
  `adminpassword` varchar(200) NOT NULL,
  `adminemail` varchar(200) NOT NULL,
  `login_date` datetime NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` varchar(200) NOT NULL,
  `utype` varchar(200) NOT NULL,
  `last_action_time` datetime NOT NULL,
  `flag` enum('1','0') NOT NULL DEFAULT '1',
  `no_of_user` int(11) NOT NULL,
  `active_date` datetime NOT NULL,
  `active_time` time NOT NULL,
  `deactive_date` datetime NOT NULL,
  `deactive_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `employeedetail`
--
ALTER TABLE `employeedetail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subadmin`
--
ALTER TABLE `subadmin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `adminid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employeedetail`
--
ALTER TABLE `employeedetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subadmin`
--
ALTER TABLE `subadmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
