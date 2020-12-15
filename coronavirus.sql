-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2020 at 09:08 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coronavirus`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `countryName` varchar(150) NOT NULL,
  `countryFlagFilename` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `countryName`, `countryFlagFilename`) VALUES
(4, 'France', '5fb0d2d073a68_france.png'),
(5, 'canada', '5fb0e5f743732_canada.png'),
(6, 'lebanon', '5fb1267d1e2ba_lebanon.gif'),
(7, 'United states', '5fb29c223faff_us.PNG'),
(8, 'germany', '5fb3607844faa_germany.png'),
(10, 'brazil', '5fb39cded14b9_brazil.png'),
(11, 'japan', '5fb768e86dc1b_japan.png');

-- --------------------------------------------------------

--
-- Table structure for table `covidstats`
--

CREATE TABLE `covidstats` (
  `id` int(10) UNSIGNED NOT NULL,
  `lastCases` int(10) UNSIGNED NOT NULL,
  `lastDeaths` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `countryId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `covidstats`
--

INSERT INTO `covidstats` (`id`, `lastCases`, `lastDeaths`, `date`, `countryId`) VALUES
(6, 1, 1, '2020-11-15', 5),
(24, 1, 1, '2020-11-01', 4),
(25, 1000, 1000, '2020-11-16', 4),
(29, 2, 20, '2020-12-03', 6),
(46, 1000, 1000, '2020-11-18', 4),
(47, 1657, 467, '2020-11-20', 5),
(48, 3000, 3000, '2020-11-11', 4),
(50, 1, 1, '2020-11-20', 11),
(56, 1200, 3, '2020-12-01', 4),
(57, 432, 635, '2020-12-04', 4),
(59, 324, 21, '2020-10-03', 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'phpprogrammer@live.com', '7c4a8d09ca3762a'),
(2, 'test', 'test');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `covidstats`
--
ALTER TABLE `covidstats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id_fk` (`countryId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `covidstats`
--
ALTER TABLE `covidstats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `covidstats`
--
ALTER TABLE `covidstats`
  ADD CONSTRAINT `country_id_fk` FOREIGN KEY (`countryId`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
