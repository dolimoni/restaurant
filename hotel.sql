-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 19 Octobre 2017 à 02:31
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `hotel`
--

-- --------------------------------------------------------

--
-- Structure de la table `booking`
--

CREATE TABLE IF NOT EXISTS `booking` (
  `id_reservation` int(11) NOT NULL AUTO_INCREMENT,
  `client` varchar(255) NOT NULL,
  `room` int(11) NOT NULL,
  `logement` decimal(50,0) NOT NULL,
  `paiment_de_jour` decimal(50,0) NOT NULL,
  `autre` decimal(50,0) NOT NULL,
  `reste` decimal(50,0) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reservation`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `booking`
--

INSERT INTO `booking` (`id_reservation`, `client`, `room`, `logement`, `paiment_de_jour`, `autre`, `reste`, `date`, `created_at`) VALUES
(1, '3', 6, '250', '250', '2017', '0', '0000-00-00', '2017-10-19 00:28:17'),
(2, '4', 4, '250', '250', '2017', '0', '0000-00-00', '2017-10-19 00:28:34');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `tel` varchar(25) NOT NULL,
  `dateofbirth` varchar(50) NOT NULL,
  `placeofbirth` varchar(25) NOT NULL,
  `nationality` varchar(25) NOT NULL,
  `profession` varchar(25) NOT NULL,
  `cin` varchar(255) NOT NULL,
  `passeportNumber` varchar(25) NOT NULL,
  `inMoroccoNumber` varchar(25) NOT NULL,
  `inMorocco` varchar(25) NOT NULL,
  `provenance` varchar(25) NOT NULL,
  `destination` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`id`, `firstName`, `lastName`, `tel`, `dateofbirth`, `placeofbirth`, `nationality`, `profession`, `cin`, `passeportNumber`, `inMoroccoNumber`, `inMorocco`, `provenance`, `destination`, `created_at`) VALUES
(1, 'abida', 'omar', '0635359166', '09/01/1993', 'casablanca', 'marocain', 'professeur', 'bh222222', '', '', '', '', '', '2017-10-17 00:51:53'),
(2, '', '', '', '', 'aa', '', '', '', '', '', '', '', '', '2017-10-19 00:26:49'),
(3, '', '', '', '', 'aa', '', '', '', '', '', '', '', '', '2017-10-19 00:28:17'),
(4, '', '', '', '', '', '', '', '', '', '', '', '', '', '2017-10-19 00:28:34');

-- --------------------------------------------------------

--
-- Structure de la table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nbr_lits` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `room`
--

INSERT INTO `room` (`id`, `nbr_lits`, `status`) VALUES
(1, 2, 1),
(2, 4, 1),
(3, 2, 1),
(4, 2, 0),
(5, 3, 1),
(6, 3, 0),
(7, 3, 1),
(8, 4, 1),
(9, 4, 1),
(10, 1, 2),
(11, 2, 1),
(12, 3, 1),
(13, 1, 1),
(14, 4, 3),
(15, 1, 1),
(16, 2, 1),
(17, 2, 1),
(18, 3, 1),
(19, 2, 1),
(20, 4, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
