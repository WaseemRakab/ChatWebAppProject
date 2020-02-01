-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2019 at 08:00 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--
CREATE DATABASE IF NOT EXISTS `project` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `project`;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `currentID` int(10) NOT NULL,
  `sendToID` int(10) NOT NULL,
  `currentTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chatlog`
--

CREATE TABLE `chatlog` (
  `fromID` int(10) UNSIGNED NOT NULL,
  `toID` int(10) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `currentTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chatlog`
--

INSERT INTO `chatlog` (`fromID`, `toID`, `message`, `currentTime`) VALUES
(1, 2, 'hello hisham', '2019-01-25 16:44:47'),
(1, 2, 'how are you.', '2019-01-25 16:44:50'),
(2, 1, 'im good , what about you?', '2019-01-25 16:45:16'),
(1, 2, 'good to know', '2019-01-25 17:08:09'),
(1, 3, 'hello php', '2019-01-25 17:09:28'),
(1, 3, 'what\'s up?', '2019-01-25 17:09:33'),
(4, 1, 'hello waseem', '2019-01-25 17:12:21'),
(4, 1, 'are you here/', '2019-01-25 17:12:24'),
(4, 1, 'reply in ur free time', '2019-01-25 17:12:31'),
(4, 3, 'oh phph', '2019-01-25 17:12:39'),
(4, 3, 'hi there', '2019-01-25 17:12:42'),
(4, 2, 'hey hisham', '2019-01-25 17:12:50'),
(1, 4, 'yes im here , whatsup?', '2019-01-25 17:13:09'),
(1, 2, 'i love this chat', '2019-01-30 07:56:54'),
(2, 1, 'PHP is so good to work with', '2019-01-30 08:07:06'),
(2, 4, 'hello tester', '2019-01-30 08:07:16'),
(2, 4, 'how are you?xD', '2019-01-30 08:07:22'),
(1, 2, 'hello?', '2019-01-30 18:15:10'),
(2, 3, 'hello php', '2019-01-30 18:15:43'),
(2, 1, 'hello waseem how are you?', '2019-01-30 18:57:40'),
(2, 3, 'hi !!!!', '2019-01-30 18:58:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(10) UNSIGNED NOT NULL,
  `UserName` varchar(20) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `UserName`, `Email`, `FirstName`, `LastName`, `Password`) VALUES
(1, 'waseemrkab', 'sc12@hotmail.co.il', 'Waseem', 'Rakab', '$2y$10$obPX21sDG4Ccodoj4wn45eYq4pm99oFPy6RcGP5GmNnOo/vtnnwyC'),
(2, 'hisham', 'hisham@hotmail.com', 'Hisham', 'Mansour', '$2y$10$bqt0u2o3oa7Al9qPIfOg8e.Qri92aqKDoXHcuVesbPONbPWws9Lle'),
(3, 'PHP', 'PHP@hotmail.com', 'PHP', 'test', '$2y$10$/Kaxd2eNBpgFADTtf3y1uu8D3pPLFm6BHAvKXkFgr33K7j9xWI.aO'),
(4, 'someone', 'someone@hotmail.com', 'someone', 'test', '$2y$10$ELIuk61/8Qp76ksRNBPRruSr7HtWutQXy.x8H4IcfcczEVuSuz27e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`currentID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
