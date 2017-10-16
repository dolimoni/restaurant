-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 17 Octobre 2017 à 00:30
-- Version du serveur :  10.1.21-MariaDB
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `hotel`
--

-- --------------------------------------------------------

--
-- Structure de la table `chambres`
--

CREATE TABLE `chambres` (
  `id_chambre` varchar(11) NOT NULL,
  `nbr_lits` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `observation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `chambres`
--

INSERT INTO `chambres` (`id_chambre`, `nbr_lits`, `status`, `observation`) VALUES
('chambre_1', 2, 1, ''),
('chambre_10', 4, 1, ''),
('chambre_11', 2, 1, ''),
('chambre_12', 2, 1, ''),
('chambre_13', 3, 1, ''),
('chambre_14', 3, 1, ''),
('chambre_15', 3, 1, ''),
('chambre_16', 4, 1, ''),
('chambre_17', 4, 1, ''),
('chambre_18', 1, 1, ''),
('chambre_19', 2, 1, ''),
('chambre_2', 3, 1, ''),
('chambre_20', 1, 1, ''),
('chambre_3', 4, 1, ''),
('chambre_4', 1, 1, ''),
('chambre_5', 2, 1, ''),
('chambre_6', 2, 1, ''),
('chambre_7', 3, 1, ''),
('chambre_8', 2, 1, ''),
('chambre_9', 4, 1, '');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `prenom` varchar(25) NOT NULL,
  `tel` varchar(25) NOT NULL,
  `datenaissance` varchar(10) NOT NULL,
  `lieunaissance` varchar(25) NOT NULL,
  `nationalite` varchar(25) NOT NULL,
  `profession` varchar(25) NOT NULL,
  `cinsejour` varchar(25) NOT NULL,
  `num_passeport` varchar(25) NOT NULL,
  `num_entree_maroc` varchar(25) NOT NULL,
  `date_entree` varchar(25) NOT NULL,
  `lieu_provenance` varchar(25) NOT NULL,
  `destination` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`id_client`, `nom`, `prenom`, `tel`, `datenaissance`, `lieunaissance`, `nationalite`, `profession`, `cinsejour`, `num_passeport`, `num_entree_maroc`, `date_entree`, `lieu_provenance`, `destination`) VALUES
(1, 'abida', 'omar', '0635359166', '09/01/1993', 'casablanca', 'marocain', 'professeur', 'bh222222', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int(11) NOT NULL,
  `id_client` varchar(255) NOT NULL,
  `id_chambre` varchar(30) NOT NULL,
  `logement` decimal(50,0) NOT NULL,
  `paiment_de_jour` decimal(50,0) NOT NULL,
  `autre` decimal(50,0) NOT NULL,
  `reste` decimal(50,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `chambres`
--
ALTER TABLE `chambres`
  ADD PRIMARY KEY (`id_chambre`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_reservation`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
