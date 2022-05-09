-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 16 jan. 2022 à 19:33
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `restaurant`
--
CREATE DATABASE IF NOT EXISTS `restaurant` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `restaurant`;

-- --------------------------------------------------------

--
-- Structure de la table `asseoir`
--

CREATE TABLE `asseoir` (
  `numTable` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `dateServ` date NOT NULL DEFAULT current_timestamp(),
  `etat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `asseoir`
--

INSERT INTO `asseoir` (`numTable`, `client`, `dateServ`, `etat`) VALUES
(1, 8, '2022-01-15', 1),
(1, 9, '2022-01-15', 1),
(1, 13, '2021-09-13', 0),
(2, 8, '2021-03-13', 0),
(2, 9, '2021-04-09', 0),
(2, 15, '2021-12-31', 0),
(3, 10, '2021-05-24', 0),
(3, 10, '2022-01-15', 1),
(3, 14, '2021-10-16', 0),
(3, 14, '2022-01-15', 1),
(3, 15, '2022-01-04', 0),
(4, 8, '2021-03-15', 0),
(4, 12, '2021-07-02', 0),
(5, 8, '2021-02-04', 0),
(5, 8, '2021-03-16', 0),
(5, 12, '2021-08-16', 0),
(5, 14, '2021-12-05', 0),
(6, 9, '2021-04-20', 0),
(6, 9, '2021-05-10', 0),
(6, 10, '2021-05-15', 0),
(6, 12, '2021-06-26', 0),
(6, 12, '2021-08-20', 0),
(6, 14, '2021-12-15', 0),
(6, 14, '2021-12-29', 0),
(7, 12, '2021-06-15', 0),
(7, 12, '2022-01-15', 1),
(7, 13, '2022-01-15', 1),
(8, 8, '2021-02-04', 0),
(8, 8, '2021-04-07', 0),
(8, 9, '2021-04-15', 0),
(8, 10, '2021-05-20', 0),
(8, 13, '2021-08-25', 0),
(8, 13, '2021-09-15', 0),
(8, 14, '2021-11-19', 0),
(8, 15, '2021-12-31', 0),
(8, 15, '2022-01-15', 1);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `idClient` int(11) NOT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `dateNaiss` date DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `tel` varchar(100) DEFAULT NULL,
  `mdp` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`idClient`, `nom`, `prenom`, `dateNaiss`, `email`, `tel`, `mdp`) VALUES
(8, 'MOKHTARI', 'Billal', '2001-10-04', 'mokhtaribillal1@gmail.com', '0667789399', '0330eb856c5bdbf230ec53fddcd957fe'),
(9, 'OULD KACI', 'Amine', '2002-11-22', 'a_ouldkaci@estin.dz', '0672099674', 'f871d8b221c69622975f52d7d6e606fc'),
(10, 'BELLAHCENE', 'Adel', '1997-01-01', 'a_bellahcene@estin.dz', '0667099822', '46aa9c982a6c65041ca8b10e5fc99210'),
(11, 'ZENINE', 'Mehdi', '2001-05-04', 'm_zenine@estin.dz', '0778221309', '8aa8944c119cc333b79912ecf2d18ab9'),
(12, 'BELLAYALI', 'Rezkia', '2001-08-03', 'r_bellayali@estin.dz', '0556789001', '895ff2505615cdc485fb79dcfbf5c40d'),
(13, 'HOUCHATI', 'Laarvi', '2001-01-28', 'l_houchati@gmail.com', '0756005012', '90a2c3bd64c0f0fd8b0ce7a16e7d9756'),
(14, 'Bouchlaghem', 'Bachir', '1994-10-12', 'b_bouchlaghem@gmail.com', '335677904355', 'bedd1ae7535bf3eb46e868c870f9e029'),
(15, 'BEDJOU', 'Celina', '2001-10-12', 'celina.bedjou@caen.fr', '336789230122', '084de18dec37505a42177457ab338c47');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `numCmd` int(11) NOT NULL,
  `dateCmd` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `client` int(11) DEFAULT NULL,
  `etat` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`numCmd`, `dateCmd`, `client`, `etat`) VALUES
(32, '2021-02-04 11:20:53', 8, 1),
(33, '2021-02-04 11:34:53', 8, 1),
(34, '2021-03-13 11:34:53', 8, 1),
(35, '2021-03-15 16:34:53', 8, 1),
(36, '2021-03-16 16:34:53', 8, 1),
(37, '2021-04-07 15:34:53', 8, 1),
(38, '2021-12-29 16:34:53', 14, 1),
(39, '2021-12-15 16:34:53', 14, 1),
(40, '2021-12-05 16:34:53', 14, 1),
(41, '2021-11-19 16:34:55', 14, 1),
(42, '2021-10-16 15:34:53', 14, 1),
(43, '2021-09-13 15:34:53', 13, 1),
(44, '2021-08-25 15:34:53', 13, 1),
(45, '2021-09-15 15:34:53', 13, 1),
(46, '2021-05-15 15:34:53', 10, 1),
(47, '2021-05-20 15:34:53', 10, 1),
(48, '2021-05-24 15:34:53', 10, 1),
(49, '2021-04-20 15:34:53', 9, 1),
(50, '2021-04-15 15:34:53', 9, 1),
(51, '2021-05-10 15:34:53', 9, 1),
(52, '2021-04-09 15:34:53', 9, 1),
(53, '2021-06-15 15:34:53', 12, 1),
(54, '2021-08-16 15:34:53', 12, 1),
(55, '2021-06-26 15:34:53', 12, 1),
(56, '2021-07-02 15:34:53', 12, 1),
(57, '2021-08-20 15:34:53', 12, 1),
(58, '2021-12-31 16:34:53', 15, 1),
(59, '2021-12-31 16:34:53', 15, 1),
(60, '2022-01-04 16:34:53', 15, 1),
(61, '2022-01-15 16:29:56', 15, 1);

-- --------------------------------------------------------

--
-- Structure de la table `consommations`
--

CREATE TABLE `consommations` (
  `numCons` int(11) NOT NULL,
  `nom` varchar(40) DEFAULT NULL,
  `prix` float DEFAULT NULL,
  `type` varchar(8) DEFAULT NULL CHECK (`type` in ('entrée','plat','dessert')),
  `photo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `consommations`
--

INSERT INTO `consommations` (`numCons`, `nom`, `prix`, `type`, `photo`) VALUES
(1, 'Frites viande hachée', 180, 'plat', '1640362446.jpg'),
(2, 'Pizza simple', 250, 'plat', '1640362459.webp'),
(3, 'Tacos M', 450, 'plat', '1640362658.png'),
(4, 'Frites salade', 120, 'plat', '1640362709.jpeg'),
(5, 'Frites poulet', 200, 'plat', '1640362918.jpg'),
(6, 'Tacos Giga', 800, 'plat', '1640362929.jpg'),
(7, 'Frites', 90, 'plat', '1640362899.jpg'),
(14, 'Couscous', 150, 'plat', '1640442027.png'),
(15, 'Boisson Coca Cola 50cl', 70, 'dessert', '1640442109.jpg'),
(16, 'Jus iFruit', 100, 'dessert', '1640442144.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

CREATE TABLE `contenir` (
  `consommation` int(11) NOT NULL,
  `commande` int(11) NOT NULL,
  `qte` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `contenir`
--

INSERT INTO `contenir` (`consommation`, `commande`, `qte`) VALUES
(1, 36, 1),
(1, 43, 1),
(1, 44, 1),
(1, 46, 1),
(1, 51, 3),
(2, 32, 1),
(2, 41, 1),
(2, 42, 1),
(2, 49, 1),
(2, 53, 1),
(2, 56, 1),
(3, 33, 1),
(3, 46, 1),
(3, 49, 1),
(3, 53, 2),
(3, 57, 1),
(4, 34, 2),
(4, 35, 1),
(4, 36, 2),
(4, 38, 1),
(4, 40, 1),
(4, 43, 2),
(4, 44, 1),
(4, 51, 2),
(4, 53, 1),
(4, 56, 1),
(4, 60, 2),
(4, 61, 1),
(5, 34, 1),
(5, 35, 1),
(5, 38, 2),
(5, 40, 1),
(5, 42, 1),
(5, 43, 1),
(5, 44, 1),
(5, 48, 2),
(5, 52, 1),
(5, 53, 2),
(5, 54, 1),
(5, 56, 2),
(5, 57, 1),
(5, 58, 1),
(5, 59, 1),
(5, 60, 1),
(6, 40, 2),
(6, 42, 2),
(6, 43, 1),
(6, 44, 1),
(6, 47, 1),
(6, 54, 1),
(6, 59, 2),
(6, 61, 1),
(7, 32, 1),
(7, 35, 3),
(7, 37, 2),
(7, 39, 2),
(7, 48, 1),
(7, 50, 1),
(7, 55, 1),
(14, 34, 1),
(14, 37, 3),
(14, 45, 1),
(14, 50, 1),
(14, 52, 1),
(14, 55, 1),
(14, 58, 1),
(14, 60, 1),
(14, 61, 1),
(15, 32, 2),
(15, 39, 3),
(15, 41, 1),
(15, 46, 1),
(15, 48, 1),
(15, 50, 2),
(15, 54, 1),
(15, 55, 2),
(15, 57, 1),
(15, 58, 1),
(15, 61, 1),
(16, 33, 1),
(16, 37, 1),
(16, 40, 1),
(16, 45, 2),
(16, 47, 1),
(16, 51, 1),
(16, 55, 2);

-- --------------------------------------------------------

--
-- Structure de la table `serveurs`
--

CREATE TABLE `serveurs` (
  `numServ` int(11) NOT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `prenom` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `serveurs`
--

INSERT INTO `serveurs` (`numServ`, `nom`, `prenom`) VALUES
(2, 'MEKSAOUI', 'Aris'),
(3, 'OURARI', 'Tina'),
(4, 'LACHI', 'Billal');

-- --------------------------------------------------------

--
-- Structure de la table `tables`
--

CREATE TABLE `tables` (
  `numTable` int(11) NOT NULL,
  `Serveur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tables`
--

INSERT INTO `tables` (`numTable`, `Serveur`) VALUES
(6, NULL),
(1, 2),
(5, 2),
(4, 3),
(7, 3),
(8, 3),
(3, 4);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `asseoir`
--
ALTER TABLE `asseoir`
  ADD PRIMARY KEY (`numTable`,`client`,`dateServ`),
  ADD KEY `client` (`client`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`idClient`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `tel` (`tel`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`numCmd`),
  ADD KEY `client` (`client`);

--
-- Index pour la table `consommations`
--
ALTER TABLE `consommations`
  ADD PRIMARY KEY (`numCons`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD PRIMARY KEY (`consommation`,`commande`),
  ADD KEY `commande` (`commande`);

--
-- Index pour la table `serveurs`
--
ALTER TABLE `serveurs`
  ADD PRIMARY KEY (`numServ`);

--
-- Index pour la table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`numTable`),
  ADD KEY `Serveur` (`Serveur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `numCmd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `consommations`
--
ALTER TABLE `consommations`
  MODIFY `numCons` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `serveurs`
--
ALTER TABLE `serveurs`
  MODIFY `numServ` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `tables`
--
ALTER TABLE `tables`
  MODIFY `numTable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `asseoir`
--
ALTER TABLE `asseoir`
  ADD CONSTRAINT `fk_clientAsseoir` FOREIGN KEY (`client`) REFERENCES `clients` (`idClient`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`client`) REFERENCES `clients` (`idClient`),
  ADD CONSTRAINT `fk_clientCmd` FOREIGN KEY (`client`) REFERENCES `clients` (`idClient`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `FK_contenir_consom` FOREIGN KEY (`consommation`) REFERENCES `consommations` (`numCons`),
  ADD CONSTRAINT `contenir_ibfk_2` FOREIGN KEY (`commande`) REFERENCES `commandes` (`numCmd`),
  ADD CONSTRAINT `fk_cmdCont` FOREIGN KEY (`commande`) REFERENCES `commandes` (`numCmd`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_consContenir` FOREIGN KEY (`consommation`) REFERENCES `consommations` (`numCons`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `tables`
--
ALTER TABLE `tables`
  ADD CONSTRAINT `fk_table` FOREIGN KEY (`Serveur`) REFERENCES `serveurs` (`numServ`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `tables_ibfk_1` FOREIGN KEY (`Serveur`) REFERENCES `serveurs` (`numServ`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
