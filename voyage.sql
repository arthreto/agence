-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 30 avr. 2026 à 09:11
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `voyage`
--
CREATE DATABASE IF NOT EXISTS `voyage` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `voyage`;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `reservation_id` int NOT NULL AUTO_INCREMENT,
  `voyage_id` int NOT NULL,
  `user_id` int NOT NULL,
  `nbPersonnes` int NOT NULL,
  `statut` varchar(20) NOT NULL,
  `dateArrivee` date NOT NULL,
  `dateDepart` date NOT NULL,
  PRIMARY KEY (`reservation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `voyage_id`, `user_id`, `nbPersonnes`, `statut`, `dateArrivee`, `dateDepart`) VALUES
(2, 3, 1, 1, 'W', '2026-05-05', '2026-05-13');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rank` enum('Client','Admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Client',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`ID`, `email`, `pseudo`, `password`, `rank`) VALUES
(1, 'arthur.Vdlpro@gmail.com', 'LeGoat', '$2y$10$TDSB7Fy4JSYk9CT8yMJuh.13FA/Kx8FPq.HtNt6v0NlWD6Bz.edKq', 'Admin'),
(1130, 'other@gmail.com', 'Sympathique personne', '$2y$10$hOl396K.zQojDkU.lFc5Y.h1PCGkPwTXx44s1Qt3FDUyxXOPVoWMu', 'Client');

-- --------------------------------------------------------

--
-- Structure de la table `voyages`
--

DROP TABLE IF EXISTS `voyages`;
CREATE TABLE IF NOT EXISTS `voyages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `prix` smallint NOT NULL,
  `meilleurPeriode` varchar(200) NOT NULL,
  `activite` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `voyages`
--

INSERT INTO `voyages` (`id`, `description`, `nom`, `image`, `prix`, `meilleurPeriode`, `activite`) VALUES
(1, 'Petit village sympathique', 'ARNAC-LA-POSTE', 'rsc/arnaclaposte.jpg', 4, 'Octobre - Novembre', 'Degustation - Camping - Aucune connexion'),
(3, 'L\'endroit idéal si vous n\'êtes pas alcoolique anonyme', 'BOURRE', 'rsc/bourre.jpg', 50, 'Toute la vie', 'Découverte de Loire Craft'),
(4, 'La ville des robots', 'DETROIT', 'rsc/detroit.png', 67, 'L\'hiver', 'Découverte technologique'),
(5, 'Profitez d\'une formation banger avec des professeurs attentioné et à l\'écoute pour que les élèves', 'Sainte-Marguerite', 'rsc/marguerite.jpg', 2000, 'Période Scolaire', 'Cybersecurité avec Lavoine');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
