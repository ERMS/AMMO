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
-- Database: `psuedoadzudb`
--
CREATE DATABASE IF NOT EXISTS `psuedoadzudb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `psuedoadzudb`;

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
('110382', 'c153a851246c7a79cb979eeca222dd7a', 'Alkino', 'Ko', 'alkinoko21@gmail.com', 'Student', 'SITAO'),
('110392', 'cc0b044bf6d02448f2ff41b8c422be5d', 'Enrique', 'Lacambra', '110392@adzu.edu.ph', 'Employee', 'SITAO'),
('110497', 'd9790d9bd62a90aeb95fd9efaa06a6bf', 'Ana Kriselda', 'Natividad', '110497@adzu.edu.ph', 'Student', 'SITAO'),
('A14001', 'employee', 'Caselyne', 'Anastacio', 'casey012995@gmail.com', 'Employee', 'SITAO');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
