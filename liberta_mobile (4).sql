-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 19 mai 2025 à 19:27
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `liberta_mobile`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('superadmin','manager') COLLATE utf8mb4_unicode_ci DEFAULT 'manager',
  `actif` tinyint(1) DEFAULT '1',
  `cree_le` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `nom`, `email`, `mot_de_passe`, `role`, `actif`, `cree_le`) VALUES
(1, 'Admin Principal', 'admin@liberta.com', '$2y$10$X8ZfDPnMGi8uTgYKpFSKzeF05E8z.QSDSp1MS3mk..ZJmfEr7aZQy', 'superadmin', 1, '2025-05-13 13:12:35');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `date_commande` datetime DEFAULT CURRENT_TIMESTAMP,
  `total` decimal(10,2) NOT NULL,
  `statut` enum('en_attente','payee','expediee') COLLATE utf8mb4_unicode_ci DEFAULT 'en_attente',
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande_produit`
--

DROP TABLE IF EXISTS `commande_produit`;
CREATE TABLE IF NOT EXISTS `commande_produit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `commande_id` int NOT NULL,
  `produit_id` int NOT NULL,
  `quantite` int DEFAULT '1',
  `prix_au_moment` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `commande_id` (`commande_id`),
  KEY `produit_id` (`produit_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `forfait`
--

DROP TABLE IF EXISTS `forfait`;
CREATE TABLE IF NOT EXISTS `forfait` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `reseau` enum('4G','5G') COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` int DEFAULT NULL,
  `appels_illimites` tinyint(1) DEFAULT '1',
  `sms_illimites` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `forfait`
--

INSERT INTO `forfait` (`id`, `nom`, `prix`, `reseau`, `data`, `appels_illimites`, `sms_illimites`) VALUES
(1, '20 Go 4G/5G', 8.99, '4G', 20, 1, 1),
(2, '160 Go 4G/5G', 16.99, '5G', 160, 1, 1),
(3, '250 Go 4G/5G', 22.99, '5G', 250, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id`, `nom`) VALUES
(1, 'Apple'),
(2, 'Samsung'),
(3, 'Xiaomi');

-- --------------------------------------------------------

--
-- Structure de la table `modele`
--

DROP TABLE IF EXISTS `modele`;
CREATE TABLE IF NOT EXISTS `modele` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marque_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `marque_id` (`marque_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `modele`
--

INSERT INTO `modele` (`id`, `nom`, `marque_id`) VALUES
(1, 'iPhone 16 Pro', 1),
(2, 'iPhone 16', 1),
(3, 'iPhone 15', 1),
(4, 'Galaxy S25 Ultra', 2),
(5, 'Galaxy S24', 2),
(6, 'Galaxy A56', 2),
(7, 'Xiaomi 14 Pro', 3),
(8, 'Xiaomi Redmi Note 14 Pro', 3),
(9, 'Xiaomi 15 Ultra', 3),
(10, 'Xiaomi 14T', 3),
(11, 'iPhone 16 Pro', 1),
(12, 'iPhone 16', 1),
(13, 'iPhone 15', 1),
(14, 'Galaxy S25 Ultra', 2),
(15, 'Galaxy S24', 2),
(16, 'Galaxy A56', 2),
(17, 'Xiaomi 14 Pro', 3),
(18, 'Xiaomi Redmi Note 14 Pro', 3),
(19, 'Xiaomi 15 Ultra', 3),
(20, 'Xiaomi 14T', 3);

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `panier_produit`
--

DROP TABLE IF EXISTS `panier_produit`;
CREATE TABLE IF NOT EXISTS `panier_produit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `panier_id` int NOT NULL,
  `produit_id` int NOT NULL,
  `quantite` int DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `panier_id` (`panier_id`),
  KEY `produit_id` (`produit_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `prix` decimal(10,2) NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int DEFAULT '0',
  `type` enum('telephone','forfait') COLLATE utf8mb4_unicode_ci NOT NULL,
  `marque_id` int DEFAULT NULL,
  `modele_id` int DEFAULT NULL,
  `forfait_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `marque_id` (`marque_id`),
  KEY `modele_id` (`modele_id`),
  KEY `forfait_id` (`forfait_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `description`, `prix`, `image_url`, `stock`, `type`, `marque_id`, `modele_id`, `forfait_id`) VALUES
(1, 'iPhone 16 Pro', 'Apple iPhone 16 Pro dernière génération', 1399.99, 'iphone-16-pro.jpg', 15, 'telephone', 1, 1, NULL),
(2, 'Galaxy S25 Ultra', 'Samsung Galaxy S25 Ultra 5G', 1299.99, 'galaxy-s25-ultra.jpg', 12, 'telephone', 2, 4, NULL),
(3, 'Xiaomi 15 Ultra', 'Xiaomi 15 Ultra performance photo', 1099.99, 'xiaomi-15-ultra.jpg', 20, 'telephone', 3, 9, NULL),
(4, 'iPhone 16 Pro', 'Apple iPhone 16 Pro dernière génération', 1399.99, 'iphone-16-pro.jpg', 15, 'telephone', 1, 1, NULL),
(5, 'Galaxy S25 Ultra', 'Samsung Galaxy S25 Ultra 5G', 1299.99, 'galaxy-s25-ultra.jpg', 12, 'telephone', 2, 4, NULL),
(6, 'Xiaomi 15 Ultra', 'Xiaomi 15 Ultra performance photo', 1099.99, 'xiaomi-15-ultra.jpg', 20, 'telephone', 3, 9, NULL),
(7, 'iPhone 16 Pro', 'Apple iPhone 16 Pro dernière génération', 1399.99, 'iphone-16-pro.jpg', 15, 'telephone', 1, 1, NULL),
(8, 'Galaxy S25 Ultra', 'Samsung Galaxy S25 Ultra 5G', 1299.99, 'galaxy-s25-ultra.jpg', 12, 'telephone', 2, 4, NULL),
(9, 'Xiaomi 15 Ultra', 'Xiaomi 15 Ultra performance photo', 1099.99, 'xiaomi-15-ultra.jpg', 20, 'telephone', 3, 9, NULL),
(10, 'Forfait 20 Go', 'Forfait mobile 20 Go en 4G/5G', 8.99, NULL, 999, 'forfait', NULL, NULL, 1),
(11, 'Forfait 160 Go', 'Forfait mobile 160 Go 5G', 16.99, NULL, 999, 'forfait', NULL, NULL, 2),
(12, 'Forfait 250 Go', 'Forfait mobile 250 Go 5G', 22.99, NULL, 999, 'forfait', NULL, NULL, 3),
(13, 'iPhone 16 Pro + 160 Go', 'Pack iPhone 16 Pro avec forfait 160 Go', 1499.99, 'iphone-16-pro-pack.jpg', 10, 'telephone', 1, 1, 2),
(14, 'Galaxy S25 + 250 Go', 'Pack Galaxy S25 Ultra avec forfait 250 Go', 1399.99, 'galaxy-s25-pack.jpg', 8, 'telephone', 2, 4, 3);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('client','admin') COLLATE utf8mb4_unicode_ci DEFAULT 'client',
  `date_inscription` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
