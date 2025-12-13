-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 12 déc. 2025 à 12:54
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `coup_de_sifflet`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id_admin`, `nom`, `email`, `mot_de_passe`) VALUES
(3, 'Admin', 'Admin@Admin', '$2y$10$ePcGb50EhXQ98KKB4SMBN.MHQE2E1NinUPdux2oIxdP9nBymDGfUq');

-- --------------------------------------------------------

--
-- Structure de la table `classement`
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
-- Structure de la table `electeur`
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
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
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
-- Structure de la table `jeton_vote`
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
-- Structure de la table `scrutin`
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
-- Structure de la table `vote`
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
-- Structure de la table `vote_effectue`
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
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `classement`
--
ALTER TABLE `classement`
  ADD CONSTRAINT `fk_classement_equipe` FOREIGN KEY (`id_equipe`) REFERENCES `equipe` (`id_equipe`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_classement_vote` FOREIGN KEY (`id_vote`) REFERENCES `vote` (`id_vote`) ON DELETE CASCADE;

--
-- Contraintes pour la table `jeton_vote`
--
ALTER TABLE `jeton_vote`
  ADD CONSTRAINT `fk_jeton_scrutin` FOREIGN KEY (`id_scrutin`) REFERENCES `scrutin` (`id_scrutin`) ON DELETE CASCADE;

--
-- Contraintes pour la table `scrutin`
--
ALTER TABLE `scrutin`
  ADD CONSTRAINT `fk_scrutin_admin` FOREIGN KEY (`id_admin`) REFERENCES `administrateur` (`id_admin`) ON DELETE CASCADE;

--
-- Contraintes pour la table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `fk_vote_jeton` FOREIGN KEY (`id_jeton`) REFERENCES `jeton_vote` (`id_jeton`) ON DELETE CASCADE;

--
-- Contraintes pour la table `vote_effectue`
--
ALTER TABLE `vote_effectue`
  ADD CONSTRAINT `fk_vote_effectue_electeur` FOREIGN KEY (`id_electeur`) REFERENCES `electeur` (`id_electeur`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_vote_effectue_scrutin` FOREIGN KEY (`id_scrutin`) REFERENCES `scrutin` (`id_scrutin`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
