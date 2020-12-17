-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2020 at 10:01 PM
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
-- Database: `coronavirus_refactored`
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
  `countryId` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `covidstats`
--

INSERT INTO `covidstats` (`id`, `lastCases`, `lastDeaths`, `date`, `countryId`, `userId`) VALUES
(6, 1, 1, '2020-11-15', 5, 1),
(24, 1, 1, '2020-11-01', 4, 1),
(25, 1000, 1000, '2020-11-16', 4, 1),
(29, 2, 20, '2020-12-03', 6, 1),
(46, 1000, 1000, '2020-11-18', 4, 1),
(47, 1657, 467, '2020-11-20', 5, 1),
(48, 3000, 3000, '2020-11-11', 4, 1),
(50, 1, 1, '2020-11-20', 11, 1),
(56, 1201, 3, '2020-12-01', 4, 3),
(59, 324, 21, '2020-10-03', 10, 1),
(64, 3, 3, '2020-12-04', 4, 3),
(67, 1, 1, '2020-12-16', 8, 3),
(68, 1, 1, '2020-12-16', 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pendingcovidstats`
--

CREATE TABLE `pendingcovidstats` (
  `id` int(10) UNSIGNED NOT NULL,
  `lastCases` int(10) UNSIGNED NOT NULL,
  `lastDeaths` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `covidStatId` int(10) UNSIGNED DEFAULT NULL,
  `countryId` int(10) UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pendingcovidstats`
--

INSERT INTO `pendingcovidstats` (`id`, `lastCases`, `lastDeaths`, `userId`, `covidStatId`, `countryId`, `date`) VALUES
(29, 3, 2, 3, NULL, 6, '2020-12-04'),
(32, 104, 163, 3, 67, NULL, NULL),
(33, 162, 417, 3, 47, NULL, NULL),
(34, 14, 42, 9, 47, NULL, NULL),
(36, 16, 12, 9, 68, NULL, NULL),
(37, 32, 26, 9, 59, NULL, NULL),
(38, 273, 225, 9, 64, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` bit(1) NOT NULL DEFAULT b'0',
  `phoneNumber` varchar(30) NOT NULL,
  `isAccepted` bit(1) NOT NULL DEFAULT b'0',
  `username` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `isAdmin`, `phoneNumber`, `isAccepted`, `username`) VALUES
(1, 'phpprogrammer@live.com', '7ce0359f12857f2a90c7de465f40a95f01cb5da9', b'1', '+96179153043', b'1', 'PhPWarrior'),
(3, 'jeanpaul.r_1999@live.com', '5c5d9d0015f8064fbec68877a7450172bb20f209', b'0', '+96179153043', b'1', 'BusinessMan'),
(4, 'encrypter@diffie-hellman.com', 'f88d499cbebd774ed979ddc6af46e69fb246d9f2', b'0', '+96101234567', b'1', 'encrypterMan'),
(5, 'javascript@javascriptsamurai.js', 'f88d499cbebd774ed979ddc6af46e69fb246d9f2', b'0', '+96184827492', b'0', 'javascriptersamurai'),
(6, 'pleaseacceptme@acceptme.please', 'f88d499cbebd774ed979ddc6af46e69fb246d9f2', b'0', '+9617915304', b'0', 'acceptme'),
(7, 'pleaserejectme@rejectme.now', 'f88d499cbebd774ed979ddc6af46e69fb246d9f2', b'0', '+96101234567', b'0', 'dontacceptme'),
(9, 'supermario@supermario.com', '7ce0359f12857f2a90c7de465f40a95f01cb5da9', b'0', '+96101234567', b'1', 'supermario');

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
  ADD KEY `country_id_fk` (`countryId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `pendingcovidstats`
--
ALTER TABLE `pendingcovidstats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `pendingcovidstats_ibfk_2` (`covidStatId`),
  ADD KEY `fk_country_id` (`countryId`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `pendingcovidstats`
--
ALTER TABLE `pendingcovidstats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `covidstats`
--
ALTER TABLE `covidstats`
  ADD CONSTRAINT `country_id_fk` FOREIGN KEY (`countryId`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `covidstats_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `pendingcovidstats`
--
ALTER TABLE `pendingcovidstats`
  ADD CONSTRAINT `fk_country_id` FOREIGN KEY (`countryId`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `pendingcovidstats_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pendingcovidstats_ibfk_2` FOREIGN KEY (`covidStatId`) REFERENCES `covidstats` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
