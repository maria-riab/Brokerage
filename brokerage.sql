-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 02, 2022 at 09:27 PM
-- Server version: 8.0.27
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brokerage`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `stockID` varchar(10) NOT NULL,
  `quantity` int NOT NULL,
  `priceBought` float NOT NULL,
  `transactionDate` date NOT NULL,
  `ISBUY` tinyint(1) NOT NULL,
  `orderID` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  PRIMARY KEY (`orderID`),
  KEY `StockID` (`stockID`),
  KEY `userID` (`userID`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
CREATE TABLE IF NOT EXISTS `stocks` (
  `stockID` int NOT NULL AUTO_INCREMENT,
  `companyName` varchar(255) NOT NULL,
  `ticker` varchar(10) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`stockID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stockID`, `companyName`, `ticker`, `price`) VALUES
(1, 'Apple inc.', 'APPL', 100),
(2, 'Microsoft corp.', 'MSFT', 60),
(3, 'Labranche inc', 'PPL', 99.5);

-- --------------------------------------------------------
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `balance` float NOT NULL,
  `userID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;