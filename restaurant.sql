-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 16 Novembre 2017 à 16:09
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `restaurant`
--

-- --------------------------------------------------------

--
-- Structure de la table `consumption`
--

CREATE TABLE IF NOT EXISTS `consumption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meal` int(50) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `consumption`
--

INSERT INTO `consumption` (`id`, `meal`, `quantity`, `amount`, `createdAt`) VALUES
(4, 1, '1.00', '90.00', '2017-11-15 22:21:37'),
(5, 1, '1.00', '90.00', '2017-11-15 22:32:27'),
(6, 4, '2.00', '115.00', '2017-11-16 13:18:08'),
(7, 0, '0.00', '0.00', '2017-11-16 13:18:09'),
(8, 4, '2.00', '115.00', '2017-11-16 13:18:28'),
(9, 0, '0.00', '0.00', '2017-11-16 13:18:28'),
(10, 4, '2.00', '115.00', '2017-11-16 13:21:11'),
(11, 4, '2.00', '115.00', '2017-11-16 13:22:18'),
(12, 4, '2.00', '115.00', '2017-11-16 13:24:44');

-- --------------------------------------------------------

--
-- Structure de la table `consumption_product`
--

CREATE TABLE IF NOT EXISTS `consumption_product` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `consumption` int(50) NOT NULL,
  `meal` int(50) NOT NULL,
  `product` int(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `consumption_product`
--

INSERT INTO `consumption_product` (`id`, `consumption`, `meal`, `product`, `created_at`, `unit_price`, `quantity`) VALUES
(1, 4, 1, 1, '2017-11-15 22:21:37', '25.00', '0.02'),
(2, 4, 1, 2, '2017-11-15 22:21:37', '4.00', '0.10'),
(3, 4, 1, 3, '2017-11-15 22:21:37', '6.00', '0.15'),
(4, 5, 1, 1, '2017-11-15 22:32:27', '25.00', '0.02'),
(5, 5, 1, 2, '2017-11-15 22:32:27', '4.00', '0.10'),
(6, 5, 1, 3, '2017-11-15 22:32:27', '6.00', '0.15'),
(7, 12, 4, 1, '2017-11-16 13:24:44', '25.00', '0.04'),
(8, 12, 4, 2, '2017-11-16 13:24:44', '4.00', '0.20'),
(9, 12, 4, 3, '2017-11-16 13:24:44', '6.00', '0.40');

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `customer`
--

INSERT INTO `customer` (`id`, `name`, `address`, `created_at`) VALUES
(1, 'khalid', 'casablanca', '2017-10-30 18:13:17');

-- --------------------------------------------------------

--
-- Structure de la table `discount`
--

CREATE TABLE IF NOT EXISTS `discount` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `customer` int(50) NOT NULL,
  `meal` int(50) NOT NULL,
  `discount` decimal(20,0) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `cin` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `workType` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `employee`
--

INSERT INTO `employee` (`id`, `name`, `prenom`, `cin`, `address`, `phone`, `salary`, `workType`, `image`, `created_at`) VALUES
(1, 'essalhi', 'khalid', '22222', 'hay sadri', '0656011827', '4500.00', 'cuisin', 'profile-default-male.png', '2017-10-29 22:01:06'),
(3, 'aaaa', 'aaa', 'aaa', 'aaa', 'aaa', '3000.00', 'ménage', 'profile-default-male.png', '2017-10-30 10:57:14'),
(9, 'test', 'test', 'test', 'test', 'test', '3000.00', 'cuisin', 'profile-default-male.png', '2017-10-31 15:35:07');

-- --------------------------------------------------------

--
-- Structure de la table `employee_event`
--

CREATE TABLE IF NOT EXISTS `employee_event` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `employee` int(50) NOT NULL,
  `day` date NOT NULL,
  `remarque` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=124 ;

--
-- Contenu de la table `employee_event`
--

INSERT INTO `employee_event` (`id`, `employee`, `day`, `remarque`, `created_at`) VALUES
(21, 6, '2017-10-08', 'long event', '2017-10-28 22:38:11'),
(27, 6, '2017-12-01', '', '2017-10-28 22:48:05'),
(28, 6, '2017-10-17', 'aaa', '2017-10-28 23:20:30'),
(31, 6, '2017-10-16', 'absence 300', '2017-10-28 23:22:08'),
(33, 6, '2017-09-05', 'absence', '2017-10-28 23:22:52'),
(37, 6, '2017-10-27', 'paiement', '2017-10-28 23:32:31'),
(38, 6, '2017-10-18', 'avance 300', '2017-10-29 15:23:02'),
(41, 6, '2017-10-24', '', '2017-10-29 20:32:41'),
(43, 6, '2017-10-12', 'absence 50', '2017-10-29 20:34:10'),
(44, 6, '2017-10-19', 'absence', '2017-10-29 20:43:57'),
(46, 6, '2017-10-09', 'absence', '2017-10-29 20:44:31'),
(47, 6, '2017-10-20', 'absence', '2017-10-29 20:48:28'),
(48, 6, '2017-10-13', 'absence', '2017-10-29 20:48:49'),
(51, 6, '2017-10-11', 'avance 300', '2017-10-29 20:55:25'),
(52, 1, '2017-10-09', 'remarque', '2017-10-29 22:22:54'),
(53, 1, '2017-10-10', 'remarque2', '2017-10-29 22:25:42'),
(66, 1, '2017-10-19', 'absence fff', '2017-10-29 23:01:04'),
(67, 1, '2017-11-02', 'remarque', '2017-10-29 23:03:37'),
(68, 1, '2017-11-03', 'absence', '2017-10-29 23:03:44'),
(73, 1, '2017-11-04', 'absence', '2017-10-29 23:25:35'),
(74, 1, '2017-10-20', 'test', '2017-10-29 23:27:59'),
(75, 1, '2017-10-12', 'absence', '2017-10-29 23:28:08'),
(77, 1, '2017-10-30', 'avance 30', '2017-10-29 23:28:45'),
(88, 3, '2017-10-30', 'remarque', '2017-10-30 10:59:42'),
(89, 3, '2017-10-25', 'absence 30', '2017-10-30 11:00:08'),
(90, 4, '2017-10-17', 'aaaa', '2017-10-30 11:05:55'),
(91, 4, '2017-10-31', 'absence 30', '2017-10-30 11:06:15'),
(92, 4, '2017-10-30', 'avance 30', '2017-10-30 11:09:58'),
(93, 5, '2017-10-30', 'sss', '2017-10-30 11:11:15'),
(94, 5, '2017-10-24', 'absence 30', '2017-10-30 11:11:26'),
(95, 5, '2017-10-25', 'absence 30', '2017-10-30 11:13:02'),
(96, 6, '2017-10-25', 'aaaa', '2017-10-30 11:13:45'),
(97, 7, '2017-10-24', 'ffff', '2017-10-30 11:14:26'),
(98, 7, '2017-10-23', 'absence 30', '2017-10-30 11:14:39'),
(99, 7, '2017-10-25', 'ffff', '2017-10-30 11:15:13'),
(100, 7, '2017-10-22', 'rrrr', '2017-10-30 11:15:59'),
(101, 7, '2017-10-26', 'absence 30', '2017-10-30 11:16:16'),
(105, 8, '2017-10-31', 'test', '2017-10-30 11:18:47'),
(109, 8, '2017-10-23', 'avance 500', '2017-10-30 11:43:19'),
(110, 8, '2017-10-24', 'absence 100', '2017-10-30 11:43:26'),
(111, 8, '2017-10-25', '', '2017-10-30 11:43:32'),
(112, 8, '2017-11-03', 'avance 500', '2017-10-30 11:43:53'),
(113, 1, '2017-10-23', 'avance 300', '2017-10-31 15:34:12'),
(114, 9, '2017-10-17', 'avance 500', '2017-10-31 15:35:23'),
(115, 9, '2017-10-19', 'absence 100', '2017-10-31 15:35:38'),
(117, 9, '2017-11-02', 'avance 500', '2017-10-31 15:36:47'),
(118, 1, '2017-11-05', 'retard', '2017-11-01 02:16:31'),
(119, 1, '2017-11-08', 'avance 500', '2017-11-01 02:17:02'),
(120, 1, '2017-11-09', 'absence 150', '2017-11-01 02:17:25'),
(121, 1, '2017-11-16', 'absence 100', '2017-11-01 15:57:10'),
(122, 1, '2017-11-21', 'retard', '2017-11-01 16:54:11'),
(123, 1, '2017-11-22', '', '2017-11-01 16:54:26');

-- --------------------------------------------------------

--
-- Structure de la table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(50) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `group`
--

INSERT INTO `group` (`id`, `num`, `name`, `image`) VALUES
(1, 1, 'Global', 'restaurant.jpg'),
(2, 2, 'Pizza', 'pizza2.jpg'),
(3, 3, 'Boisson', 'Boisson.jpg'),
(4, 4, 'Salade', 'Salade.jpg'),
(5, 5, 'Dessert', 'dessert.jpg'),
(6, 5, 'Dessert', 'dessert.jpg'),
(7, 0, 'PAINS', 'restaurant.jpg'),
(8, 6, 'SANDWICHES/PANINIS', 'restaurant.jpg'),
(9, 7, 'BONBONS', 'restaurant.jpg'),
(10, 8, 'BOISSONS', 'restaurant.jpg'),
(11, 9, 'REVENTES', 'dessert.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `meal`
--

CREATE TABLE IF NOT EXISTS `meal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `externalCode` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `group` int(50) NOT NULL DEFAULT '1',
  `cost` varchar(100) NOT NULL,
  `sellPrice` varchar(100) NOT NULL,
  `profit` varchar(100) NOT NULL,
  `products_count` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `externalCode` (`externalCode`),
  KEY `fk_grade_id` (`group`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=108 ;

--
-- Contenu de la table `meal`
--

INSERT INTO `meal` (`id`, `externalCode`, `name`, `group`, `cost`, `sellPrice`, `profit`, `products_count`, `created_at`) VALUES
(1, '000000000000000001', 'BAGUETTE', 1, '1.8', '90', '88.2', '3', '2017-11-14 18:11:16'),
(2, '000000000000000002', '1/2 BAGUETTE', 1, '', '45', '', '0', '2017-11-14 18:11:16'),
(3, '000000000000000003', 'BAGUETTE DE CAMPAGNE', 1, '', '100', '', '0', '2017-11-14 18:11:16'),
(4, '000000000000000004', 'BAGUETTE AUX 3 CEREALES', 7, '2.1', '115', '112.9', '3', '2017-11-14 18:11:16'),
(5, '000000000000000005', 'BAGUETTE AU PAVOT', 1, '', '110', '', '0', '2017-11-14 18:11:16'),
(6, '000000000000000006', 'BAGUETTE AU SESAME', 1, '', '110', '', '0', '2017-11-14 18:11:16'),
(7, '000000000000000007', 'BLONDINE', 1, '', '105', '', '0', '2017-11-14 18:11:16'),
(8, '000000000000000008', 'FICELLE', 1, '', '70', '', '0', '2017-11-14 18:11:16'),
(9, '000000000000000009', 'FICELLE AU LARD', 1, '', '90', '', '0', '2017-11-14 18:11:16'),
(10, '000000000000000010', 'GROS PAIN RUSTIQUE', 1, '', '210', '', '0', '2017-11-14 18:11:17'),
(11, '000000000000000011', 'PAVE DE CAMPAGNE', 1, '', '215', '', '0', '2017-11-14 18:11:17'),
(12, '000000000000000012', 'PAVE AUX CEREALES', 1, '', '220', '', '0', '2017-11-14 18:11:17'),
(13, '000000000000000013', 'PAVE COMPLET', 1, '', '215', '', '0', '2017-11-14 18:11:17'),
(14, '000000000000000014', 'PAVE AU SEIGLE', 1, '', '215', '', '0', '2017-11-14 18:11:17'),
(15, '000000000000000015', 'POILANE', 1, '', '230', '', '0', '2017-11-14 18:11:17'),
(16, '000000000000000016', 'DIVERS PAIN', 1, '', '0', '', '0', '2017-11-14 18:11:17'),
(17, '000000000000000020', 'CROISSANT NATURE', 1, '', '100', '', '0', '2017-11-14 18:11:17'),
(18, '000000000000000021', 'CROUSSANT AU BEURRE', 1, '', '110', '', '0', '2017-11-14 18:11:17'),
(19, '000000000000000022', 'CROISSANT AUX AMANDES', 1, '', '120', '', '0', '2017-11-14 18:11:17'),
(20, '000000000000000023', 'PAIN AU CHOCOLAT', 1, '', '110', '', '0', '2017-11-14 18:11:17'),
(21, '000000000000000024', 'CHAUSSON AUX POMMES', 1, '', '120', '', '0', '2017-11-14 18:11:17'),
(22, '000000000000000025', 'CRAVATE', 1, '', '110', '', '0', '2017-11-14 18:11:18'),
(23, '000000000000000026', 'PALMIER', 1, '', '100', '', '0', '2017-11-14 18:11:18'),
(24, '000000000000000027', 'BEIGNET NATURE', 1, '', '120', '', '0', '2017-11-14 18:11:18'),
(25, '000000000000000028', 'BEIGNET FRAMBOISE', 1, '', '140', '', '0', '2017-11-14 18:11:18'),
(26, '000000000000000029', 'BEIGNET CHOCOLAT', 1, '', '140', '', '0', '2017-11-14 18:11:18'),
(27, '000000000000000030', 'PAIN AUX RAISINS', 1, '', '120', '', '0', '2017-11-14 18:11:18'),
(28, '000000000000000031', 'DIVERS VIENNOISERIE', 1, '', '0', '', '0', '2017-11-14 18:11:18'),
(29, '000000000000000040', 'ECLAIR AU CHOCOLAT', 1, '', '120', '', '0', '2017-11-14 18:11:18'),
(30, '000000000000000041', 'ECLAIR AU CAFE', 1, '', '120', '', '0', '2017-11-14 18:11:18'),
(31, '000000000000000042', 'RELIGIEUSE', 1, '', '130', '', '0', '2017-11-14 18:11:18'),
(32, '000000000000000043', 'PARIS-BREST', 1, '', '130', '', '0', '2017-11-14 18:11:18'),
(33, '000000000000000044', 'OPERA', 1, '', '130', '', '0', '2017-11-14 18:11:18'),
(34, '000000000000000045', 'MILLE FEUILLES', 1, '', '130', '', '0', '2017-11-14 18:11:18'),
(35, '000000000000000046', 'BOULE CHOCO', 1, '', '120', '', '0', '2017-11-14 18:11:18'),
(36, '000000000000000047', 'SAINT HONORE', 1, '', '130', '', '0', '2017-11-14 18:11:18'),
(37, '000000000000000048', 'DIVORCES', 1, '', '130', '', '0', '2017-11-14 18:11:18'),
(38, '000000000000000049', 'FLAN PATISSIER', 1, '', '110', '', '0', '2017-11-14 18:11:18'),
(39, '000000000000000050', 'BABA AU RHUM', 1, '', '120', '', '0', '2017-11-14 18:11:18'),
(40, '000000000000000051', 'TARTELETTE AUX FRAISES', 1, '', '120', '', '0', '2017-11-14 18:11:18'),
(41, '000000000000000052', 'TARTELETTE AUX FRAMBOISES', 1, '', '120', '', '0', '2017-11-14 18:11:18'),
(42, '000000000000000053', 'TARTELETTE AUX ABRICOTS', 1, '', '120', '', '0', '2017-11-14 18:11:18'),
(43, '000000000000000054', 'TARTELETTE AUX POMMES', 1, '', '120', '', '0', '2017-11-14 18:11:19'),
(44, '000000000000000055', 'DIVERS PATISSERIE', 1, '', '0', '', '0', '2017-11-14 18:11:19'),
(45, '000000000000000060', 'GATEAU AU 3 CHOCOLATS', 1, '', '1200', '', '0', '2017-11-14 18:11:19'),
(46, '000000000000000061', 'GATEAU CHOCOLAT CARAMEL', 1, '', '1100', '', '0', '2017-11-14 18:11:19'),
(47, '000000000000000062', 'GATEAU VANILLE FRAISE', 1, '', '1100', '', '0', '2017-11-14 18:11:19'),
(48, '000000000000000063', 'GATEAU FRAMBOISES CHOCOLAT', 1, '', '1200', '', '0', '2017-11-14 18:11:19'),
(49, '000000000000000064', 'FRAMBOISIER', 1, '', '1250', '', '0', '2017-11-14 18:11:19'),
(50, '000000000000000065', 'FRAISIER', 1, '', '1250', '', '0', '2017-11-14 18:11:19'),
(51, '000000000000000066', 'FORET NOIRE', 1, '', '1300', '', '0', '2017-11-14 18:11:19'),
(52, '000000000000000067', 'DIVERS GATEAU', 1, '', '0', '', '0', '2017-11-14 18:11:19'),
(53, '000000000000000080', 'QUICHE LORRAINE', 1, '', '450', '', '0', '2017-11-14 18:11:19'),
(54, '000000000000000081', 'QUICHE AUX POIREAUX', 1, '', '400', '', '0', '2017-11-14 18:11:19'),
(55, '000000000000000082', 'QUICHE AU GRUYERE', 1, '', '400', '', '0', '2017-11-14 18:11:19'),
(56, '000000000000000083', 'FEUILLETE POULET CURRY', 1, '', '500', '', '0', '2017-11-14 18:11:19'),
(57, '000000000000000084', 'FEUILLETE JAMBON CHAMPIGNONS', 1, '', '500', '', '0', '2017-11-14 18:11:19'),
(58, '000000000000000085', 'ROULE AU FROMAGE', 1, '', '500', '', '0', '2017-11-14 18:11:19'),
(59, '000000000000000086', 'CROQUE-MONSIEUR', 1, '', '450', '', '0', '2017-11-14 18:11:19'),
(60, '000000000000000087', 'CROQUE-MADAME', 1, '', '500', '', '0', '2017-11-14 18:11:19'),
(61, '000000000000000088', 'PIZZA MARGARITA', 1, '', '400', '', '0', '2017-11-14 18:11:19'),
(62, '000000000000000089', 'PIZZA REINE', 1, '', '450', '', '0', '2017-11-14 18:11:19'),
(63, '000000000000000090', 'PIZZA AU THON', 1, '', '500', '', '0', '2017-11-14 18:11:19'),
(64, '000000000000000091', 'PIZZA MERGUEZ', 1, '', '550', '', '0', '2017-11-14 18:11:19'),
(65, '000000000000000092', 'DIVERS QUICHE/PIZZA', 1, '', '0', '', '0', '2017-11-14 18:11:20'),
(66, '000000000000000100', 'SANDWICH JAMBON BEURRE', 1, '', '360', '', '0', '2017-11-14 18:11:20'),
(67, '000000000000000101', 'SANDWICH JAMBON DE PAYS', 1, '', '380', '', '0', '2017-11-14 18:11:20'),
(68, '000000000000000102', 'SANDWICH ROSETTE', 1, '', '380', '', '0', '2017-11-14 18:11:20'),
(69, '000000000000000103', 'SANDWICH CAMEMBERT', 1, '', '380', '', '0', '2017-11-14 18:11:20'),
(70, '000000000000000104', 'SANDWICH THON CRUDITES', 1, '', '420', '', '0', '2017-11-14 18:11:20'),
(71, '000000000000000105', 'SANDWICH POULET CRUDITES', 1, '', '420', '', '0', '2017-11-14 18:11:20'),
(72, '000000000000000106', 'PANINI JAMBON', 1, '', '400', '', '0', '2017-11-14 18:11:20'),
(73, '000000000000000107', 'PANINI AUX 3 FROMAGES', 1, '', '440', '', '0', '2017-11-14 18:11:20'),
(74, '000000000000000108', 'PANINI AU THON', 1, '', '430', '', '0', '2017-11-14 18:11:20'),
(75, '000000000000000109', 'PANINI AU POULET', 1, '', '430', '', '0', '2017-11-14 18:11:20'),
(76, '000000000000000110', 'PANINI FROMAGE A RACLETTE', 1, '', '440', '', '0', '2017-11-14 18:11:20'),
(77, '000000000000000111', 'BAGNAT JAMBON', 1, '', '430', '', '0', '2017-11-14 18:11:20'),
(78, '000000000000000112', 'BAGNAT THON CRUDITES', 1, '', '450', '', '0', '2017-11-14 18:11:20'),
(79, '000000000000000113', 'BAGNAT POULET CRUDITES', 1, '', '450', '', '0', '2017-11-14 18:11:20'),
(80, '000000000000000114', 'DIVERS SANDWICH/PANINI', 1, '', '0', '', '0', '2017-11-14 18:11:20'),
(81, '000000000000000120', 'BONBONS EN VRAC (kg)', 1, '', '10', '', '0', '2017-11-14 18:11:20'),
(82, '000000000000000121', 'BONBON (piece)', 1, '', '15', '', '0', '2017-11-14 18:11:20'),
(83, '000000000000000122', 'SUCETTE', 1, '', '30', '', '0', '2017-11-14 18:11:20'),
(84, '000000000000000123', 'MALABAR', 1, '', '15', '', '0', '2017-11-14 18:11:20'),
(85, '000000000000000124', 'CARAMBAR', 1, '', '15', '', '0', '2017-11-14 18:11:20'),
(86, '000000000000000125', 'HOLLYWOOD', 1, '', '120', '', '0', '2017-11-14 18:11:21'),
(87, '000000000000000126', 'DIVERS BONBON', 1, '', '0', '', '0', '2017-11-14 18:11:21'),
(88, '000000000000000140', 'COCA COLA', 1, '', '120', '', '0', '2017-11-14 18:11:21'),
(89, '000000000000000141', 'COCA LIGHT', 1, '', '120', '', '0', '2017-11-14 18:11:21'),
(90, '000000000000000142', 'COCA ZERO', 1, '', '120', '', '0', '2017-11-14 18:11:21'),
(91, '000000000000000143', 'ORANGINA', 1, '', '120', '', '0', '2017-11-14 18:11:21'),
(92, '000000000000000144', 'SCHWEPPES', 1, '', '120', '', '0', '2017-11-14 18:11:21'),
(93, '000000000000000145', 'SCHWEPPES AGRUMES', 1, '', '120', '', '0', '2017-11-14 18:11:21'),
(94, '000000000000000146', 'PERRIER', 1, '', '120', '', '0', '2017-11-14 18:11:21'),
(95, '000000000000000147', 'PETITE EAU', 1, '', '90', '', '0', '2017-11-14 18:11:21'),
(96, '000000000000000148', 'EAU 1,50L', 1, '', '110', '', '0', '2017-11-14 18:11:21'),
(97, '000000000000000149', 'HEINEKEN', 1, '', '140', '', '0', '2017-11-14 18:11:21'),
(98, '000000000000000150', 'BAVARIA 8.6', 1, '', '190', '', '0', '2017-11-14 18:11:21'),
(99, '000000000000000151', 'DIVERS BOISSON', 1, '', '0', '', '0', '2017-11-14 18:11:21'),
(100, '000000000000000160', 'LEVURE', 1, '', '320', '', '0', '2017-11-14 18:11:21'),
(101, '000000000000000161', 'FARINE', 1, '', '320', '', '0', '2017-11-14 18:11:21'),
(102, '000000000000000162', 'BISCOTTES', 1, '', '320', '', '0', '2017-11-14 18:11:21'),
(103, '000000000000000163', 'BISCOTTES SANS SEL', 1, '', '320', '', '0', '2017-11-14 18:11:21'),
(104, '000000000000000164', 'CHOCOLAT NOIR (kg)', 1, '', '320', '', '0', '2017-11-14 18:11:21'),
(105, '000000000000000165', 'CHOCOLAT AU LAIT (kg)', 1, '', '320', '', '0', '2017-11-14 18:11:22'),
(106, '000000000000000166', 'CHOCOLAT BLANC (kg)', 1, '', '300', '', '0', '2017-11-14 18:11:22'),
(107, '000000000000000167', 'DIVERS REVENTE', 1, '', '0', '', '0', '2017-11-14 18:11:22');

-- --------------------------------------------------------

--
-- Structure de la table `meal_product`
--

CREATE TABLE IF NOT EXISTS `meal_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(100) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `unit` varchar(200) DEFAULT NULL,
  `unitConvert` varchar(50) NOT NULL DEFAULT '1',
  `consumptionRate` decimal(10,2) DEFAULT NULL,
  `meal` int(100) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'current',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `meal_product`
--

INSERT INTO `meal_product` (`id`, `product`, `quantity`, `unit`, `unitConvert`, `consumptionRate`, `meal`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '20', 'Gramme', '0.001', '0.28', 1, 'current', '2017-11-14 18:22:28', '2017-11-14 18:22:29'),
(2, 2, '100', 'Gramme', '0.001', '0.22', 1, 'current', '2017-11-14 18:22:28', '2017-11-14 18:22:29'),
(3, 3, '150', 'Gramme', '0.001', '0.50', 1, 'current', '2017-11-14 18:22:28', '2017-11-14 18:22:29'),
(4, 1, '20', 'Gramme', '0.001', '0.24', 4, 'current', '2017-11-16 13:23:51', '2017-11-16 13:23:51'),
(5, 2, '100', 'Gramme', '0.001', '0.19', 4, 'current', '2017-11-16 13:23:51', '2017-11-16 13:23:51'),
(6, 3, '200', 'Gramme', '0.001', '0.57', 4, 'current', '2017-11-16 13:23:51', '2017-11-16 13:23:51');

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `provider` int(50) NOT NULL,
  `tva` decimal(10,2) NOT NULL,
  `ttc` decimal(10,2) NOT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Contenu de la table `order`
--

INSERT INTO `order` (`id`, `provider`, `tva`, `ttc`, `status`, `created_at`) VALUES
(1, 1, '0.00', '500.00', 'received', '2017-10-14 15:30:02'),
(2, 1, '0.20', '500.00', 'pending', '2017-10-14 15:31:54'),
(3, 1, '0.20', '500.00', 'pending', '2017-10-14 16:11:10'),
(4, 1, '0.20', '500.00', 'pending', '2017-10-15 20:35:16'),
(5, 1, '0.20', '500.00', 'received', '2017-10-24 13:57:10'),
(6, 1, '0.20', '500.00', 'received', '2017-10-24 14:12:33'),
(7, 1, '0.20', '500.00', 'received', '2017-10-24 18:53:08'),
(8, 2, '0.20', '500.00', 'received', '2017-10-24 22:06:35'),
(9, 2, '0.20', '500.00', 'pending', '2017-10-24 22:10:36'),
(10, 2, '0.20', '500.00', 'received', '2017-10-24 22:15:46'),
(11, 2, '0.20', '500.00', 'pending', '2017-10-24 22:38:58'),
(12, 2, '0.20', '6.00', 'pending', '2017-10-25 11:53:28'),
(13, 1, '0.20', '16.00', 'pending', '2017-10-31 15:32:13'),
(14, 1, '0.20', '160.00', 'pending', '2017-10-31 20:47:48'),
(15, 1, '0.20', '160.00', 'pending', '2017-10-31 20:51:11'),
(16, 1, '0.20', '1280.00', 'pending', '2017-10-31 20:52:29'),
(17, 1, '0.20', '16.00', 'pending', '2017-10-31 20:56:38'),
(18, 1, '0.20', '16.00', 'pending', '2017-10-31 20:57:47'),
(19, 1, '0.20', '16.00', 'pending', '2017-10-31 20:59:51'),
(20, 1, '0.20', '16.00', 'received', '2017-10-31 21:00:44'),
(21, 2, '0.20', '10.20', 'pending', '2017-11-01 02:42:39'),
(22, 2, '0.20', '10.60', 'received', '2017-11-01 02:49:24'),
(23, 1, '0.20', '64.00', 'received', '2017-11-01 02:56:30'),
(24, 1, '0.20', '120.00', 'received', '2017-11-01 03:12:09');

-- --------------------------------------------------------

--
-- Structure de la table `orderdetails`
--

CREATE TABLE IF NOT EXISTS `orderdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(50) NOT NULL,
  `order_id` int(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Contenu de la table `orderdetails`
--

INSERT INTO `orderdetails` (`id`, `product`, `order_id`, `quantity`, `created_at`) VALUES
(1, 4, 1, 1, '2017-10-14 15:30:02'),
(2, 46, 1, 2, '2017-10-14 15:30:02'),
(3, 4, 2, 1, '2017-10-14 15:31:55'),
(4, 46, 2, 2, '2017-10-14 15:31:55'),
(5, 47, 2, 5, '2017-10-14 15:31:55'),
(6, 48, 3, 20, '2017-10-14 16:11:10'),
(7, 4, 4, 10, '2017-10-15 20:35:16'),
(8, 46, 4, 5, '2017-10-15 20:35:16'),
(9, 42, 5, 1, '2017-10-24 13:57:11'),
(10, 42, 6, 10, '2017-10-24 14:12:33'),
(11, 48, 7, 50, '2017-10-24 18:53:09'),
(12, 60, 8, 5, '2017-10-24 22:06:35'),
(13, 61, 8, 6, '2017-10-24 22:06:35'),
(14, 61, 9, 4, '2017-10-24 22:10:37'),
(15, 60, 10, 1, '2017-10-24 22:15:46'),
(16, 60, 11, 1, '2017-10-24 22:38:58'),
(17, 60, 12, 5, '2017-10-25 11:53:28'),
(18, 7, 13, 1, '2017-10-31 15:32:13'),
(19, 23, 14, 10, '2017-10-31 20:47:48'),
(20, 23, 15, 10, '2017-10-31 20:51:11'),
(21, 23, 16, 80, '2017-10-31 20:52:29'),
(22, 23, 17, 1, '2017-10-31 20:56:38'),
(23, 23, 18, 1, '2017-10-31 20:57:47'),
(24, 23, 19, 1, '2017-10-31 20:59:51'),
(25, 23, 20, 1, '2017-10-31 21:00:44'),
(26, 27, 21, 1, '2017-11-01 02:42:40'),
(27, 28, 21, 5, '2017-11-01 02:42:41'),
(28, 11, 22, 3, '2017-11-01 02:49:24'),
(29, 12, 22, 5, '2017-11-01 02:49:24'),
(30, 7, 23, 4, '2017-11-01 02:56:30'),
(31, 7, 24, 1, '2017-11-01 03:12:09'),
(32, 14, 24, 50, '2017-11-01 03:12:09'),
(33, 15, 24, 1, '2017-11-01 03:12:09');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `totalQuantity` decimal(10,2) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `unit_price2` varchar(255) NOT NULL,
  `provider` int(50) DEFAULT NULL,
  `min_quantity` decimal(10,2) DEFAULT NULL,
  `daily_quantity` decimal(10,2) DEFAULT NULL,
  `quotation` int(50) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `externalCode` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id`, `name`, `totalQuantity`, `unit`, `unit_price2`, `provider`, `min_quantity`, `daily_quantity`, `quotation`, `status`, `created_at`, `updated_at`, `externalCode`) VALUES
(1, 'olive', '9.92', 'kg', '', 0, '2.00', '0.00', NULL, 'active', '2017-11-14 18:16:06', '2017-11-16 13:24:44', 0),
(2, 'tomate', '14.60', 'kg', '', 0, '2.00', '0.00', NULL, 'active', '2017-11-14 18:16:06', '2017-11-16 13:24:44', 0),
(3, 'farine', '29.30', 'kg', '', 0, '5.00', '0.00', NULL, 'active', '2017-11-14 18:17:16', '2017-11-16 13:24:44', 0);

-- --------------------------------------------------------

--
-- Structure de la table `provider`
--

CREATE TABLE IF NOT EXISTS `provider` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `provider`
--

INSERT INTO `provider` (`id`, `title`, `name`, `prenom`, `address`, `phone`, `mail`, `image`) VALUES
(1, 'fournisseur général', 'ESSALHI', 'khalid', 'Hay sadri', '656011827', 'khalid.essalhi8@gmail.com', 'itsMe2.jpg'),
(2, 'Fournisseur fromage', 'Brahim', 'prenom', 'Casablanca', '065788888', 'ahmed@test.com', 'profile-default-male.png'),
(3, 'test', 'Test2', 'prenom', 'Test', '0123457821', 'test@email.com', 'profile-default-male.png'),
(4, 'a', 'a', 'prenom', 'a', 'a', 'a', 'profile-default-male.png');

-- --------------------------------------------------------

--
-- Structure de la table `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `article` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `purchase`
--

INSERT INTO `purchase` (`id`, `article`, `price`, `created_at`) VALUES
(1, 'khhalid', '500.00', '2017-10-30 15:14:57'),
(2, 'TV', '5000.00', '2017-10-30 15:15:22'),
(3, 'test', '25.30', '2017-10-30 15:16:14');

-- --------------------------------------------------------

--
-- Structure de la table `quantity`
--

CREATE TABLE IF NOT EXISTS `quantity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(50) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'stock',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `quantity`
--

INSERT INTO `quantity` (`id`, `product`, `quantity`, `unit_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '9.92', '25.00', 'active', '2017-11-14 18:16:06', '2017-11-16 13:24:44'),
(2, 2, '14.60', '4.00', 'active', '2017-11-14 18:16:06', '2017-11-16 13:24:44'),
(3, 3, '29.30', '6.00', 'active', '2017-11-14 18:17:16', '2017-11-16 13:24:44');

-- --------------------------------------------------------

--
-- Structure de la table `quotation`
--

CREATE TABLE IF NOT EXISTS `quotation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider` int(50) NOT NULL,
  `number` int(50) DEFAULT NULL,
  `reception_date` date NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Contenu de la table `quotation`
--

INSERT INTO `quotation` (`id`, `provider`, `number`, `reception_date`, `createdAt`) VALUES
(1, 1, 100, '0000-00-00', '2017-10-13 14:45:48'),
(2, 1, 2512, '2017-11-10', '2017-10-13 14:48:19'),
(3, 1, 25120, '0000-00-00', '2017-10-13 14:49:16'),
(4, 1, 25120, '1970-01-01', '2017-10-13 15:43:30'),
(5, 1, 25120, '0000-00-00', '2017-10-13 15:46:29'),
(6, 1, 25120, '0000-00-00', '2017-10-13 16:08:27'),
(7, 1, 25120, '0000-00-00', '2017-10-13 16:09:23'),
(8, 1, 25120, '0000-00-00', '2017-10-13 16:09:42'),
(9, 1, 25120, '0000-00-00', '2017-10-13 16:11:19'),
(10, 1, 25120, '0000-00-00', '2017-10-13 16:11:55'),
(23, 1, 25120, '1970-01-01', '2017-10-14 13:05:34'),
(24, 1, 25120, '2017-11-10', '2017-10-14 13:06:15'),
(25, 1, 0, '0000-00-00', '2017-10-14 14:21:18'),
(26, 1, 0, '0000-00-00', '2017-10-14 14:22:12'),
(27, 1, 0, '0000-00-00', '2017-10-14 14:31:53');

-- --------------------------------------------------------

--
-- Structure de la table `regularcost`
--

CREATE TABLE IF NOT EXISTS `regularcost` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `article` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `periodicity` varchar(255) DEFAULT NULL,
  `reminderDate` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `regularcost`
--

INSERT INTO `regularcost` (`id`, `article`, `price`, `periodicity`, `reminderDate`, `created_at`) VALUES
(1, 'aaaa', '0.00', 'daily', '0000-00-00', '2017-10-30 16:31:35'),
(2, 'xxxx', '50.00', 'weekely', '2017-11-02', '2017-10-30 16:32:28'),
(3, 'aass', '400.00', 'daily', '0000-00-00', '2017-10-30 17:01:13'),
(4, 'xxx', '0.00', 'daily', '0000-00-00', '2017-10-30 17:01:55'),
(5, 'sss', '0.00', 'daily', '0000-00-00', '2017-10-30 17:03:09'),
(6, 'khalid', '1000.00', 'daily', '2017-10-30', '2017-10-30 17:05:41'),
(7, 'wifi', '2000.00', 'monthly', '2017-11-01', '2017-10-31 15:38:45');

-- --------------------------------------------------------

--
-- Structure de la table `reparation`
--

CREATE TABLE IF NOT EXISTS `reparation` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `article` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `problem` varchar(255) DEFAULT NULL,
  `repairer` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `reparation`
--

INSERT INTO `reparation` (`id`, `article`, `price`, `problem`, `repairer`, `created_at`) VALUES
(1, 'aaa', '0.00', 'aaaa', 'aaaa', '2017-10-30 14:52:59'),
(2, 'chaise', '30.00', 'chaise cassé', 'Youness', '2017-10-30 14:54:23'),
(3, 'chaise', '50.00', 'chaise cassé', 'Youness', '2017-10-30 14:54:56');

-- --------------------------------------------------------

--
-- Structure de la table `salary`
--

CREATE TABLE IF NOT EXISTS `salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee` int(50) NOT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `advance` int(11) DEFAULT NULL,
  `remain` int(11) DEFAULT NULL,
  `paymentDate` date DEFAULT NULL,
  `absence` int(50) DEFAULT NULL,
  `delay` int(50) DEFAULT NULL,
  `substraction` decimal(10,2) DEFAULT NULL,
  `paid` varchar(20) NOT NULL DEFAULT 'false',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_employee_paymentDate` (`employee`,`paymentDate`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Contenu de la table `salary`
--

INSERT INTO `salary` (`id`, `employee`, `salary`, `advance`, `remain`, `paymentDate`, `absence`, `delay`, `substraction`, `paid`, `created_at`) VALUES
(35, 4, '4000.00', 30, 3940, '2017-10-31', 1, 0, '30.00', 'false', '2017-10-30 10:54:59'),
(38, 5, '1000.00', 0, 940, '2017-10-31', 2, 0, '60.00', 'false', '2017-10-30 11:11:15'),
(39, 7, '3000.00', 0, 2940, '2017-10-31', 2, 0, '60.00', 'false', '2017-10-30 11:16:04'),
(40, 8, '6000.00', 500, 5400, '2017-10-31', 1, 0, '100.00', 'false', '2017-10-30 11:16:47'),
(41, 8, '6000.00', 500, 5500, '2017-11-30', 0, 0, '0.00', 'false', '2017-10-30 11:24:51'),
(42, 1, '4500.00', 330, 4170, '2017-10-31', 2, 0, '0.00', 'true', '2017-10-31 15:34:13'),
(43, 9, '3000.00', 500, 2400, '2017-10-31', 1, 0, '100.00', 'true', '2017-10-31 15:35:23'),
(44, 9, '3000.00', 500, 2500, '2017-11-30', 0, 0, '0.00', 'true', '2017-10-31 15:36:47'),
(45, 1, '4500.00', 500, 3750, '2017-11-30', 4, 2, '250.00', 'false', '2017-11-01 02:16:31');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `su` int(11) DEFAULT '0',
  `type` varchar(15) NOT NULL,
  `position` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(40) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `birthday` date NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `su`, `type`, `position`, `email`, `password`, `first_name`, `last_name`, `gender`, `birthday`, `mobile`, `address`, `salary`, `createdAt`) VALUES
(6, 1, 'admin', 'Super Admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'Khalid', 'ESSALHI', 'male', '2016-12-27', '15245645646', 'asdfsdafasd', '4000.00', '2017-09-24 11:18:04'),
(7, 1, 'employee', 'Employee Super', 'employee@employee.com', 'fa5473530e4d1a5a1e1eb53d2fedb10c', 'EMPLOYEE', 'EDISON', 'male', '2015-11-30', '2323', 'qwsdasd', '5000.00', '2017-09-24 11:18:04');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `meal`
--
ALTER TABLE `meal`
  ADD CONSTRAINT `fk_grade_id` FOREIGN KEY (`group`) REFERENCES `group` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
