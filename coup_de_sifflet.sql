-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 10, 2025 at 12:57 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coup_de_sifflet`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classement`
--

DROP TABLE IF EXISTS `classement`;
CREATE TABLE IF NOT EXISTS `classement` (
  `id_vote` char(36) NOT NULL,
  `id_equipe` int NOT NULL,
  `rang` smallint NOT NULL,
  PRIMARY KEY (`id_vote`,`id_equipe`),
  UNIQUE KEY `unique_rang` (`id_vote`,`rang`),
  KEY `fk_classement_equipe` (`id_equipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `electeur`
--

DROP TABLE IF EXISTS `electeur`;
CREATE TABLE IF NOT EXISTS `electeur` (
  `id_electeur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_electeur`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
CREATE TABLE IF NOT EXISTS `equipe` (
  `id_equipe` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `pays` varchar(100) DEFAULT NULL,
  `ligue` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_equipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jeton_vote`
--

DROP TABLE IF EXISTS `jeton_vote`;
CREATE TABLE IF NOT EXISTS `jeton_vote` (
  `id_jeton` char(36) NOT NULL,
  `id_scrutin` int NOT NULL,
  `etat` varchar(20) DEFAULT 'disponible',
  `date_emission` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_jeton`),
  KEY `fk_jeton_scrutin` (`id_scrutin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scrutin`
--

DROP TABLE IF EXISTS `scrutin`;
CREATE TABLE IF NOT EXISTS `scrutin` (
  `id_scrutin` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) DEFAULT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `statut` varchar(20) DEFAULT NULL,
  `id_admin` int NOT NULL,
  PRIMARY KEY (`id_scrutin`),
  KEY `id_admin` (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

DROP TABLE IF EXISTS `vote`;
CREATE TABLE IF NOT EXISTS `vote` (
  `id_vote` char(36) NOT NULL,
  `id_jeton` char(36) NOT NULL,
  `date_vote` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_vote`),
  KEY `fk_vote_jeton` (`id_jeton`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vote_effectue`
--

DROP TABLE IF EXISTS `vote_effectue`;
CREATE TABLE IF NOT EXISTS `vote_effectue` (
  `id_electeur` int NOT NULL,
  `id_scrutin` int NOT NULL,
  `a_vote` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_electeur`,`id_scrutin`),
  KEY `fk_vote_effectue_scrutin` (`id_scrutin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classement`
--
ALTER TABLE `classement`
  ADD CONSTRAINT `fk_classement_equipe` FOREIGN KEY (`id_equipe`) REFERENCES `equipe` (`id_equipe`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_classement_vote` FOREIGN KEY (`id_vote`) REFERENCES `vote` (`id_vote`) ON DELETE CASCADE;

--
-- Constraints for table `jeton_vote`
--
ALTER TABLE `jeton_vote`
  ADD CONSTRAINT `fk_jeton_scrutin` FOREIGN KEY (`id_scrutin`) REFERENCES `scrutin` (`id_scrutin`) ON DELETE CASCADE;

--
-- Constraints for table `scrutin`
--
ALTER TABLE `scrutin`
  ADD CONSTRAINT `fk_scrutin_admin` FOREIGN KEY (`id_admin`) REFERENCES `administrateur` (`id_admin`) ON DELETE CASCADE;

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `fk_vote_jeton` FOREIGN KEY (`id_jeton`) REFERENCES `jeton_vote` (`id_jeton`) ON DELETE CASCADE;

--
-- Constraints for table `vote_effectue`
--
ALTER TABLE `vote_effectue`
  ADD CONSTRAINT `fk_vote_effectue_electeur` FOREIGN KEY (`id_electeur`) REFERENCES `electeur` (`id_electeur`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_vote_effectue_scrutin` FOREIGN KEY (`id_scrutin`) REFERENCES `scrutin` (`id_scrutin`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
