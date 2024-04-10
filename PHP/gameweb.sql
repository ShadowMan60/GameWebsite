-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 10, 2024 at 09:25 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gameweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cubper_scores`
--

CREATE TABLE `cubper_scores` (
  `score_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cubper_scores`
--

INSERT INTO `cubper_scores` (`score_id`, `username`, `score`) VALUES
(1, 'ADMIN', 0),
(2, 'ADMIN', 350),
(3, 'ADMIN', 20),
(4, 'ADMIN', 120),
(5, 'ADMIN', 150),
(6, 'ADMIN', 0),
(7, 'ADMIN', 10);

-- --------------------------------------------------------

--
-- Table structure for table `mazer_scores`
--

CREATE TABLE `mazer_scores` (
  `score_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mazer_scores`
--

INSERT INTO `mazer_scores` (`score_id`, `username`, `score`) VALUES
(1, 'ADMIN', 4),
(2, 'ADMIN', 5),
(3, 'ADMIN', 7),
(4, 'ADMIN', 9),
(5, 'ADMIN', 11);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `username`, `password`) VALUES
(2, 'dave23', '23'),
(3, 'jappie', '245'),
(4, 'bamibal', '123'),
(5, 'ADMIN', '101'),
(6, 'kevin', '14');

-- --------------------------------------------------------

--
-- Table structure for table `tetris_scores`
--

CREATE TABLE `tetris_scores` (
  `score_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tetris_scores`
--

INSERT INTO `tetris_scores` (`score_id`, `username`, `score`) VALUES
(1, 'ADMIN', 30),
(2, 'ADMIN', 230),
(3, 'ADMIN', 0),
(4, 'ADMIN', 120),
(5, 'ADMIN', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cubper_scores`
--
ALTER TABLE `cubper_scores`
  ADD PRIMARY KEY (`score_id`);

--
-- Indexes for table `mazer_scores`
--
ALTER TABLE `mazer_scores`
  ADD PRIMARY KEY (`score_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tetris_scores`
--
ALTER TABLE `tetris_scores`
  ADD PRIMARY KEY (`score_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cubper_scores`
--
ALTER TABLE `cubper_scores`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mazer_scores`
--
ALTER TABLE `mazer_scores`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tetris_scores`
--
ALTER TABLE `tetris_scores`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
