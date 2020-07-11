-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 02, 2020 at 11:42 AM
-- Server version: 8.0.19
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2019_projet7_participations`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cid` int NOT NULL,
  `nom` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cid`, `nom`) VALUES
(1, 'Examens'),
(2, 'Cours'),
(3, 'TPs');

-- --------------------------------------------------------

--
-- Table structure for table `evenements`
--

CREATE TABLE `evenements` (
  `eid` int NOT NULL,
  `intitule` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `dateDebut` datetime NOT NULL,
  `dateFin` datetime NOT NULL,
  `type` enum('ouvert','ferme') NOT NULL,
  `cid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `evenements`
--

INSERT INTO `evenements` (`eid`, `intitule`, `description`, `dateDebut`, `dateFin`, `type`, `cid`) VALUES
(1, 'Examen Progweb', 'Examen de programmation WEB', '2017-05-05 10:00:00', '2017-05-05 12:00:00', 'ferme', 1),
(2, 'Examen BD', 'Examen des bases de données.', '2017-05-12 14:00:00', '2017-05-12 17:00:00', 'ferme', 1),
(3, 'TP de programmation fonctionnelle', 'TP de programmation fonctionnelle', '2017-01-04 00:00:00', '2017-06-08 00:00:00', 'ouvert', 3),
(4, 'Cours d\'Analyse', 'Analyse 2', '2017-03-07 00:00:00', '2017-06-09 00:00:00', 'ouvert', 2),
(5, 'Test', 'Test', '2020-04-14 12:45:02', '2020-04-15 12:45:06', 'ouvert', 3);

-- --------------------------------------------------------

--
-- Table structure for table `identifications`
--

CREATE TABLE `identifications` (
  `pid` int NOT NULL,
  `tid` int NOT NULL,
  `valeur` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `identifications`
--

INSERT INTO `identifications` (`pid`, `tid`, `valeur`) VALUES
(0, 1, '343234'),
(2, 1, '662333188825'),
(2, 2, '82CVT552'),
(3, 4, 'Brouillard Patrick'),
(4, 1, '66299937877425'),
(4, 4, 'Pires 	Simon'),
(5, 2, '345'),
(5, 3, 'A4410134'),
(24, 1, '1234'),
(27, 1, '1234'),
(28, 1, '523452345');

-- --------------------------------------------------------

--
-- Table structure for table `inscriptions`
--

CREATE TABLE `inscriptions` (
  `pid` int NOT NULL,
  `eid` int NOT NULL,
  `uid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inscriptions`
--

INSERT INTO `inscriptions` (`pid`, `eid`, `uid`) VALUES
(2, 1, 1),
(2, 3, 1),
(4, 1, 1),
(4, 3, 1),
(2, 4, 2),
(5, 1, 2),
(4, 2, 3),
(5, 3, 3),
(0, 5, 6),
(24, 3, 6),
(24, 4, 6),
(27, 3, 6),
(28, 5, 6);

-- --------------------------------------------------------

--
-- Table structure for table `itypes`
--

CREATE TABLE `itypes` (
  `tid` int NOT NULL,
  `nom` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `itypes`
--

INSERT INTO `itypes` (`tid`, `nom`) VALUES
(1, 'Code Barre'),
(2, 'No RFID'),
(3, 'Passeport'),
(4, 'Nom et Prénom');

-- --------------------------------------------------------

--
-- Table structure for table `participations`
--

CREATE TABLE `participations` (
  `ptid` int NOT NULL,
  `eid` int NOT NULL,
  `pid` int NOT NULL,
  `date` datetime NOT NULL,
  `uid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `participations`
--

INSERT INTO `participations` (`ptid`, `eid`, `pid`, `date`, `uid`) VALUES
(2, 1, 2, '2017-05-05 10:03:00', 2),
(3, 1, 5, '2017-05-05 10:02:30', 3),
(5, 3, 2, '2017-03-02 10:00:00', 2),
(6, 3, 3, '2017-03-02 10:01:00', 2),
(7, 3, 4, '2017-03-02 10:05:00', 2),
(8, 3, 2, '2017-03-09 10:00:00', 3),
(9, 3, 2, '2017-03-18 10:00:00', 2),
(11, 4, 2, '2017-03-14 11:01:00', 2),
(12, 4, 3, '2017-03-14 11:00:00', 3),
(13, 4, 4, '2017-03-14 11:02:00', 3),
(14, 4, 5, '2017-03-14 11:02:00', 2),
(15, 4, 5, '2017-03-21 11:00:00', 2),
(16, 4, 5, '2017-03-30 11:00:00', 3),
(30, 2, 4, '2017-05-05 10:02:00', 6),
(32, 2, 4, '2017-05-05 10:02:00', 6),
(36, 1, 2, '2017-05-05 10:02:00', 6),
(37, 3, 5, '2017-05-05 10:02:00', 6),
(38, 2, 4, '2017-05-05 00:00:00', 6),
(41, 1, 2, '2017-05-05 10:00:03', 6),
(45, 1, 2, '2017-03-14 11:02:00', 6),
(47, 2, 4, '2020-08-12 19:34:00', 6),
(49, 1, 2, '2020-10-10 00:00:00', 6),
(50, 5, 28, '2020-10-11 00:04:00', 6),
(51, 5, 0, '2020-04-15 19:23:43', 6),
(52, 5, 28, '2020-04-15 19:23:43', 6),
(53, 4, 2, '2020-04-16 19:25:23', 6),
(54, 4, 2, '2020-04-16 19:25:23', 6),
(55, 4, 24, '2020-04-16 19:25:23', 6),
(56, 3, 4, '2020-04-30 19:27:20', 6),
(57, 3, 24, '2020-04-30 19:27:20', 6);

-- --------------------------------------------------------

--
-- Table structure for table `personnes`
--

CREATE TABLE `personnes` (
  `pid` int NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `personnes`
--

INSERT INTO `personnes` (`pid`, `nom`, `prenom`) VALUES
(0, 'Bruh', 'Bruh'),
(2, 'Petit', 'Nicolas'),
(3, 'Brouillard', 'Patrick'),
(4, 'Pires', 'Simon'),
(5, 'Dulot', 'André'),
(24, 'Test', 'Test'),
(25, 'Test', 'Test'),
(27, 'Test2', 'Test2'),
(28, 'Bruh', 'Bruh');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int NOT NULL,
  `login` varchar(30) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `login`, `mdp`, `role`) VALUES
(1, 'admin', '$2y$10$cAkeKn/Cb.JDRZ2RfEkJP.iWJfn6ZPFS95apU2qG50ZRAp75feZ8i', 'admin'),
(2, 'test', '$2y$10$rwE2jgPjPrw1i8DBi5xgY.aZuqV..6w9ZEFQmiYAy1G3slnJpKFVy', 'user'),
(3, 'test2', '$2y$10$CWdR4CMwVmeTY4imSDiU2.Gj16M85FC1sDhzHRxjh0SUDGJ6cbD2G', 'user'),
(5, 'tester', '$2y$10$1JBuZw/XtR3sOaGgvfM.BexXxC4vx1ioo6BDFp6NaFGfyWWmR0DyS', 'admin'),
(6, 'user', '$2y$10$7GjK6D3sZDtqGHwSuLGeQ.tcYhsz5Xc4HnHFZsp421KYIQaVelz2u', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `evenements`
--
ALTER TABLE `evenements`
  ADD PRIMARY KEY (`eid`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `identifications`
--
ALTER TABLE `identifications`
  ADD PRIMARY KEY (`pid`,`tid`),
  ADD KEY `tid` (`tid`);

--
-- Indexes for table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD PRIMARY KEY (`pid`,`eid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `eid` (`eid`);

--
-- Indexes for table `itypes`
--
ALTER TABLE `itypes`
  ADD PRIMARY KEY (`tid`);

--
-- Indexes for table `participations`
--
ALTER TABLE `participations`
  ADD PRIMARY KEY (`ptid`),
  ADD KEY `eid` (`eid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `personnes`
--
ALTER TABLE `personnes`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `evenements`
--
ALTER TABLE `evenements`
  MODIFY `eid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `itypes`
--
ALTER TABLE `itypes`
  MODIFY `tid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `participations`
--
ALTER TABLE `participations`
  MODIFY `ptid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `personnes`
--
ALTER TABLE `personnes`
  MODIFY `pid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `evenements`
--
ALTER TABLE `evenements`
  ADD CONSTRAINT `evenements_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `identifications`
--
ALTER TABLE `identifications`
  ADD CONSTRAINT `identifications_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `itypes` (`tid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `identifications_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `personnes` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD CONSTRAINT `inscriptions_ibfk_1` FOREIGN KEY (`eid`) REFERENCES `evenements` (`eid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscriptions_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `personnes` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscriptions_ibfk_3` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `participations`
--
ALTER TABLE `participations`
  ADD CONSTRAINT `participations_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participations_ibfk_2` FOREIGN KEY (`eid`) REFERENCES `evenements` (`eid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participations_ibfk_3` FOREIGN KEY (`pid`) REFERENCES `personnes` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
