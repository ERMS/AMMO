-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2014 at 12:28 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `amodb`
--
CREATE DATABASE IF NOT EXISTS `amodb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `amodb`;

-- --------------------------------------------------------

--
-- Table structure for table `department_list`
--

CREATE TABLE IF NOT EXISTS `department_list` (
  `D_id` int(3) NOT NULL AUTO_INCREMENT,
  `Department` varchar(20) NOT NULL,
  PRIMARY KEY (`D_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `department_list`
--

INSERT INTO `department_list` (`D_id`, `Department`) VALUES
(1, 'AVP'),
(2, 'Co. Registrar'),
(3, 'PE Office'),
(4, 'AdZU Coop'),
(5, 'DSA'),
(6, 'CCES'),
(7, 'Admission/Scholar'),
(8, 'Education'),
(9, 'SMA'),
(10, 'Computer Center'),
(11, 'SITAO'),
(12, 'SLA'),
(13, 'Campus Ministry'),
(14, 'LPO'),
(15, 'College of Law'),
(16, 'Nursing'),
(17, 'Nursing Library'),
(18, 'High School'),
(19, 'Grade School'),
(20, 'Testing Center'),
(21, 'PCO'),
(22, 'API'),
(23, 'ARC'),
(24, 'Graduate School'),
(25, 'SACSI'),
(26, 'HRADO'),
(27, 'School of Medicine'),
(28, 'GPA'),
(29, 'CPVA'),
(30, 'Alumni'),
(31, 'Auxiliary Office ');

-- --------------------------------------------------------

--
-- Table structure for table `incoming`
--

CREATE TABLE IF NOT EXISTS `incoming` (
  `Mail_ID` int(8) NOT NULL,
  `Mail_Number` varchar(10) NOT NULL,
  `Year_Received` int(4) unsigned zerofill NOT NULL,
  `Month_Received` int(2) unsigned zerofill NOT NULL,
  `Day_Received` int(2) unsigned zerofill NOT NULL,
  `Department` varchar(40) NOT NULL,
  `Sender_Name` varchar(40) NOT NULL,
  `ID_Number` varchar(6) NOT NULL,
  `Mail_Status` tinyint(1) NOT NULL,
  PRIMARY KEY (`Mail_ID`),
  KEY `ID_Number` (`ID_Number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `incoming`
--

INSERT INTO `incoming` (`Mail_ID`, `Mail_Number`, `Year_Received`, `Month_Received`, `Day_Received`, `Department`, `Sender_Name`, `ID_Number`, `Mail_Status`) VALUES
(20140001, 'OR20140001', 2014, 03, 13, 'SITAO', 'Hello', '110036', 0),
(20140002, 'OR20140002', 2014, 03, 13, 'Not Specified', 'Not specified', '110036', 1),
(20140003, 'OR20140003', 2014, 03, 13, 'GPA', 'Not specified', '110036', 1),
(20140006, 'OR20140004', 2014, 03, 14, 'Not Specified', 'Not specified', '110382', 0),
(20140007, 'OR20140005', 2014, 03, 14, 'Not Specified', 'Not specified', '110036', 1),
(20140009, 'OR20140006', 2014, 03, 14, 'Not Specified', 'Not specified', '110036', 1),
(20140010, 'OR20140007', 2014, 03, 14, 'Not Specified', 'Not specified', '110036', 1),
(20140011, 'OR20140008', 2014, 03, 14, 'Not Specified', 'Not specified', '110036', 1),
(20140013, 'OR20140009', 2014, 03, 14, 'SITAO', 'hellow', '110036', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mail`
--

CREATE TABLE IF NOT EXISTS `mail` (
  `Mail_ID` int(8) NOT NULL,
  `Mail_Type` varchar(10) NOT NULL,
  `Category` varchar(10) NOT NULL,
  PRIMARY KEY (`Mail_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mail`
--

INSERT INTO `mail` (`Mail_ID`, `Mail_Type`, `Category`) VALUES
(20140001, 'Ordinary', 'Incoming'),
(20140002, 'Ordinary', 'Incoming'),
(20140003, 'Ordinary', 'Incoming'),
(20140004, 'Ordinary', 'Outgoing'),
(20140005, 'Ordinary', 'Outgoing'),
(20140006, 'Ordinary', 'Incoming'),
(20140007, 'Ordinary', 'Incoming'),
(20140008, 'Ordinary', 'Outgoing'),
(20140009, 'Ordinary', 'Incoming'),
(20140010, 'Ordinary', 'Incoming'),
(20140011, 'Ordinary', 'Incoming'),
(20140012, 'Ordinary', 'Outgoing'),
(20140013, 'Ordinary', 'Incoming');

-- --------------------------------------------------------

--
-- Table structure for table `outgoing`
--

CREATE TABLE IF NOT EXISTS `outgoing` (
  `Mail_ID` int(8) NOT NULL,
  `Year_Sent` int(4) unsigned zerofill NOT NULL,
  `Month_Sent` int(2) unsigned zerofill NOT NULL,
  `Day_Sent` int(2) unsigned zerofill NOT NULL,
  `Destination` varchar(40) NOT NULL,
  `Recipient_Name` varchar(40) NOT NULL,
  `Total_Cost` float NOT NULL,
  `Weight` varchar(15) NOT NULL,
  `ID_Number` varchar(6) NOT NULL,
  PRIMARY KEY (`Mail_ID`),
  KEY `ID_Number` (`ID_Number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `outgoing`
--

INSERT INTO `outgoing` (`Mail_ID`, `Year_Sent`, `Month_Sent`, `Day_Sent`, `Destination`, `Recipient_Name`, `Total_Cost`, `Weight`, `ID_Number`) VALUES
(20140004, 2014, 03, 13, 'Intra', 'Not specified', 14, '21 to 50 grams', '110036'),
(20140005, 2014, 03, 13, 'Inter', 'HelloHello', 20, '21 to 50 grams', '110036'),
(20140008, 2014, 03, 14, 'Intra', 'Not specified', 7, '0 to 20 grams', '110036'),
(20140012, 2014, 03, 14, 'Intra', 'enriqueta', 7, '0 to 20 grams', '110382');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `ID_Number` varchar(6) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `First_Name` varchar(20) NOT NULL,
  `Last_Name` varchar(20) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Person_Type` varchar(10) NOT NULL,
  `Department_Name` varchar(60) NOT NULL,
  PRIMARY KEY (`ID_Number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`ID_Number`, `Password`, `First_Name`, `Last_Name`, `Email`, `Person_Type`, `Department_Name`) VALUES
('110036', '9151ee105890421593c2a158e4b26d3e', 'Caselyne Jaziel', 'Anastacio', '110036@adzu.edu.ph', 'Student', 'SITAO'),
('110382', 'c153a851246c7a79cb979eeca222dd7a', 'Alkino', 'Ko', '110382@adzu.edu.ph', 'Student', 'SITAO'),
('110392', 'cc0b044bf6d02448f2ff41b8c422be5d', 'Enrique', 'Lacambra', '110392@adzu.edu.ph', 'Employee', 'SITAO'),
('110497', 'd9790d9bd62a90aeb95fd9efaa06a6bf', 'Ana Kriselda', 'Natividad', '110497@adzu.edu.ph', 'Student', 'SITAO'),
('admin', '81dc9bdb52d04dc20036dbd8313ed055', 'Auxilliary Mail', 'Administrator', 'amoadmin@adzu.edu.ph', 'Admin', 'Auxiliary Office'),
('S14002', '81dc9bdb52d04dc20036dbd8313ed055', 'Joe', 'joey', 'casey012995@gmail.com', 'Employee', 'Admission/Scholar');

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE IF NOT EXISTS `rate` (
  `rid` int(3) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `weight` varchar(20) NOT NULL,
  `region` varchar(20) NOT NULL,
  `rate` double NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`rid`, `type`, `category`, `weight`, `region`, `rate`) VALUES
(1, 'Ordinary', '', '0 to 20 grams', 'Intra', 7),
(2, 'Ordinary', '', '0 to 20 grams', 'Inter', 12),
(3, 'Ordinary', '', '21 to 50 grams', 'Intra', 14),
(4, 'Ordinary', '', '21 to 50 grams', 'Inter', 20),
(5, 'Registered', '', '0 to 20 grams', 'Intra', 25),
(6, 'Registered', '', '0 to 20 grams', 'Inter', 30),
(7, 'Registered', '', '21 to 50 grams', 'Intra', 35),
(8, 'Registered', '', '21 to 50 grams', 'Inter', 50),
(9, 'Registered', 'EMS', '0 to 50 grams', 'Intra', 60),
(10, 'Registered', 'EMS', '0 to 50 grams', 'Inter', 70);

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE IF NOT EXISTS `user_activity` (
  `ID_Number` varchar(6) NOT NULL,
  `DateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isLogged` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_Number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_activity`
--

INSERT INTO `user_activity` (`ID_Number`, `DateTime`, `isLogged`) VALUES
('110036', '2014-03-14 03:24:50', 0),
('110382', '2014-02-12 05:24:45', 0),
('110392', '2014-03-11 03:00:50', 0),
('110497', '2014-02-16 23:49:11', 0),
('admin', '2014-03-14 03:30:25', 0),
('S14002', '2014-03-14 03:22:24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `ID_Number` varchar(6) NOT NULL,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY (`ID_Number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`ID_Number`, `role`) VALUES
('admin', 'SAdmin'),
('S14002', 'Admin');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `incoming`
--
ALTER TABLE `incoming`
  ADD CONSTRAINT `incoming_ibfk_1` FOREIGN KEY (`Mail_ID`) REFERENCES `mail` (`Mail_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `incoming_ibfk_2` FOREIGN KEY (`ID_Number`) REFERENCES `person` (`ID_Number`) ON DELETE CASCADE;

--
-- Constraints for table `outgoing`
--
ALTER TABLE `outgoing`
  ADD CONSTRAINT `outgoing_ibfk_1` FOREIGN KEY (`Mail_ID`) REFERENCES `mail` (`Mail_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `outgoing_ibfk_2` FOREIGN KEY (`ID_Number`) REFERENCES `person` (`ID_Number`) ON DELETE CASCADE;

--
-- Constraints for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `user_activity_ibfk_1` FOREIGN KEY (`ID_Number`) REFERENCES `person` (`ID_Number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`ID_Number`) REFERENCES `person` (`ID_Number`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
