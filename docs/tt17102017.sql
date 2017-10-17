-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 17 Octobre 2017 à 16:31
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `tt`
--

-- --------------------------------------------------------

--
-- Structure de la table `division`
--

CREATE TABLE `division` (
  `id_division` int(10) UNSIGNED NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `division`
--

INSERT INTO `division` (`id_division`, `nom`) VALUES
(3, 'Division 3'),
(4, 'Division 4');

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

CREATE TABLE `equipe` (
  `id_equipe` int(10) UNSIGNED NOT NULL,
  `nom` varchar(50) NOT NULL,
  `FK_division` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `equipe`
--

INSERT INTO `equipe` (`id_equipe`, `nom`, `FK_division`) VALUES
(4, 'A', 3),
(5, 'A', 4),
(6, 'B', 4);

-- --------------------------------------------------------

--
-- Structure de la table `interclub`
--

CREATE TABLE `interclub` (
  `id_interclub` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `interclub`
--

INSERT INTO `interclub` (`id_interclub`, `date`) VALUES
(3, '2017-09-10'),
(4, '2017-09-16'),
(5, '2017-09-23');

-- --------------------------------------------------------

--
-- Structure de la table `joueurs`
--

CREATE TABLE `joueurs` (
  `id_joueur` int(10) UNSIGNED NOT NULL,
  `classement` varchar(2) NOT NULL,
  `disponibilite` tinyint(1) NOT NULL,
  `bannir` tinyint(4) NOT NULL,
  `FK_personne` int(10) UNSIGNED NOT NULL,
  `FK_pool` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `joueurs`
--

INSERT INTO `joueurs` (`id_joueur`, `classement`, `disponibilite`, `bannir`, `FK_personne`, `FK_pool`) VALUES
(20, 'E0', 1, 0, 1, 4),
(21, 'E2', 1, 0, 2, 4),
(22, 'E2', 0, 0, 9, 4),
(23, 'E4', 0, 0, 10, 4),
(24, 'E6', 0, 0, 12, 4),
(25, 'E6', 0, 0, 13, 4),
(26, 'C6', 0, 0, 14, 4),
(27, 'D6', 0, 0, 15, 4),
(28, 'D4', 0, 0, 16, 4),
(29, 'D2', 0, 0, 17, 4),
(30, 'D0', 0, 0, 18, 4),
(31, 'D2', 0, 0, 19, 4),
(32, 'D0', 1, 0, 20, 4),
(33, 'B2', 0, 0, 21, 3),
(34, 'B4', 1, 0, 22, 3),
(35, 'C4', 1, 0, 23, 3),
(36, 'C6', 1, 0, 24, 3),
(37, 'B0', 1, 0, 25, 3),
(38, 'B2', 0, 0, 26, 3);

-- --------------------------------------------------------

--
-- Structure de la table `match`
--

CREATE TABLE `match` (
  `id_match` int(10) UNSIGNED NOT NULL,
  `FK_rencontre` int(10) UNSIGNED NOT NULL,
  `victoire` varchar(2) DEFAULT NULL,
  `defaite` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `match`
--

INSERT INTO `match` (`id_match`, `FK_rencontre`, `victoire`, `defaite`) VALUES
(35, 3, 'C6', ''),
(36, 3, 'E0', ''),
(37, 3, '', 'C4'),
(38, 3, 'E2', ''),
(39, 5, '', 'C6'),
(40, 5, 'E0', ''),
(41, 5, '', 'C4'),
(42, 5, 'E2', ''),
(43, 6, 'C6', ''),
(44, 6, 'E0', ''),
(45, 6, '', 'C4'),
(46, 6, '', 'E2'),
(47, 7, '', 'C4'),
(48, 7, '', 'E0'),
(49, 7, '', 'C4'),
(50, 7, 'E2', ''),
(51, 8, '', 'E0'),
(52, 8, '', 'D4'),
(53, 8, 'E4', ''),
(54, 8, '', 'E2'),
(55, 9, 'E0', ''),
(56, 9, '', 'D4'),
(57, 9, 'E4', ''),
(58, 9, '', 'E2'),
(59, 10, 'E0', ''),
(60, 10, 'D4', ''),
(61, 10, 'E4', ''),
(62, 10, '', 'E2'),
(63, 11, '', 'E0'),
(64, 11, 'D4', ''),
(65, 11, 'E4', ''),
(66, 11, '', 'E2'),
(67, 12, 'B4', ''),
(68, 12, 'C0', ''),
(69, 12, '', 'B6'),
(70, 12, 'C2', ''),
(71, 13, '', 'B4'),
(72, 13, 'C0', ''),
(73, 13, 'B6', ''),
(74, 13, 'C2', ''),
(75, 14, '', 'B4'),
(76, 14, '', 'C0'),
(77, 14, '', 'B6'),
(78, 14, 'C2', ''),
(79, 15, '', 'B4'),
(80, 15, 'C0', ''),
(81, 15, '', 'B6'),
(82, 15, 'C2', ''),
(83, 16, 'E0', ''),
(84, 16, 'D4', ''),
(85, 16, 'D6', ''),
(86, 16, 'E2', ''),
(87, 17, '', 'E0'),
(88, 17, '', 'D4'),
(89, 17, '', 'D6'),
(90, 17, 'E2', ''),
(91, 18, 'E0', ''),
(92, 18, '', 'D4'),
(93, 18, 'D6', ''),
(94, 18, 'E2', ''),
(95, 19, '', 'E0'),
(96, 19, '', 'D4'),
(97, 19, '', 'D6'),
(98, 19, '', 'E2'),
(99, 20, 'E0', ''),
(100, 20, '', 'D6'),
(101, 20, 'E4', ''),
(102, 20, 'E2', ''),
(103, 21, 'E0', ''),
(104, 21, '', 'D6'),
(105, 21, 'E4', ''),
(106, 21, 'E2', ''),
(107, 22, 'E0', ''),
(108, 22, 'D6', ''),
(109, 22, 'E4', ''),
(110, 22, '', 'E2'),
(111, 23, 'E0', ''),
(112, 23, 'D6', ''),
(113, 23, 'E4', ''),
(114, 23, 'E2', ''),
(115, 24, 'B2', ''),
(116, 24, 'B6', ''),
(117, 24, 'C0', ''),
(118, 24, 'C2', ''),
(119, 25, '', 'B2'),
(120, 25, 'B6', ''),
(121, 25, 'C0', ''),
(122, 25, 'C2', ''),
(123, 26, '', 'B2'),
(124, 26, '', 'B6'),
(125, 26, 'C0', ''),
(126, 26, 'C2', ''),
(127, 27, 'B2', ''),
(128, 27, 'B6', ''),
(129, 27, '', 'C0'),
(130, 27, 'C2', ''),
(131, 28, 'C0', ''),
(132, 28, '', 'B4'),
(133, 28, 'B6', ''),
(134, 28, '', 'C2'),
(135, 29, '', 'C0'),
(136, 29, '', 'B4'),
(137, 29, 'B6', ''),
(138, 29, 'C2', ''),
(139, 30, 'C0', ''),
(140, 30, 'B4', ''),
(141, 30, 'B6', ''),
(142, 30, 'C2', ''),
(143, 31, 'C0', ''),
(144, 31, '', 'B4'),
(145, 31, 'B6', ''),
(146, 31, 'C2', ''),
(163, 36, '', 'E0'),
(164, 36, 'D4', ''),
(165, 36, 'E4', ''),
(166, 36, '', 'E2'),
(167, 37, 'E0', ''),
(168, 37, 'D4', ''),
(169, 37, 'D6', ''),
(170, 37, 'E2', ''),
(171, 38, 'E0', ''),
(172, 38, 'D6', ''),
(173, 38, 'E4', ''),
(174, 38, '', 'E2'),
(175, 39, 'E0', ''),
(176, 39, 'D6', ''),
(177, 39, 'E4', ''),
(178, 39, 'E2', ''),
(195, 32, 'D6', ''),
(196, 32, 'E2', ''),
(197, 32, '', 'D2'),
(198, 32, 'E4', ''),
(199, 33, 'D6', ''),
(200, 33, 'E2', ''),
(201, 33, '', 'D2'),
(202, 33, 'E4', ''),
(203, 34, '', 'D6'),
(204, 34, 'E2', ''),
(205, 34, '', 'D2'),
(206, 34, 'E4', ''),
(207, 35, '', 'D6'),
(208, 35, 'E2', ''),
(209, 35, '', 'D2'),
(210, 35, 'E4', '');

-- --------------------------------------------------------

--
-- Structure de la table `personnes`
--

CREATE TABLE `personnes` (
  `id_personne` int(10) UNSIGNED NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `niveau` tinyint(1) DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sexe` varchar(10) NOT NULL,
  `date_naissance` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `personnes`
--

INSERT INTO `personnes` (`id_personne`, `nom`, `prenom`, `email`, `telephone`, `password`, `token`, `niveau`, `date_creation`, `sexe`, `date_naissance`) VALUES
(1, 'Badet', 'Audrey', 'atelier.melineo@gmail.com', NULL, 'password', NULL, 0, '2017-05-22 19:54:06', 'femme', '0000-00-00 00:00:00'),
(2, 'Inghels', 'Xavier', 'xavier.inghels@gmail.com', '0473650892', 'password', NULL, 0, '2017-05-22 19:54:33', 'homme', '0000-00-00 00:00:00'),
(9, 'Kone', 'Ibrahim', 'ib@ib.ib', '123456', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'sdgjsefnfkniu', 1, '2017-06-20 17:27:51', 'Autre', '0000-00-00 00:00:00'),
(10, 'Jonathan', 'Cuisenaire', 'j.cuisenaire@yahoo.fr', NULL, '356a192b7913b04c54574d18c28d46e6395428ab', 'esfezfez', 0, '2017-06-20 17:29:11', '', '0000-00-00 00:00:00'),
(12, 'Van de Put', 'Samuel', 'sam.vdp@hotmail.com', '0498076742', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'fdc0bea64465ded62ff829f70b93bbaf', 5, '2017-06-20 17:29:22', 'Masculin', '2017-06-06 00:00:00'),
(13, 'Masclet', 'Laurence', 'lau.masclet@gmail.com', '0474875421', NULL, NULL, 2, '2017-09-28 23:10:54', 'F', '2017-09-28 00:00:00'),
(14, 'LHaij', 'Samir', 'Samir.LHaij@gmail.com', '0456123456', NULL, NULL, 2, '2017-09-28 23:11:59', 'M', '2017-09-19 00:00:00'),
(15, 'Michael', 'Remi', 'michael.remi@gmail.com', '0489745612', NULL, NULL, 2, '2017-09-28 23:13:06', 'M', '2017-09-03 00:00:00'),
(16, 'Huberty', 'Floriant', 'Floriant.Hub@gmail.com', '0478598642', NULL, NULL, 2, '2017-09-28 23:14:31', '', '2017-09-13 00:00:00'),
(17, 'Daussin', 'Alain', 'Alain.Daussin@gmail.com', '0479456894', NULL, NULL, 2, '2017-09-28 23:16:54', '', '2017-09-02 00:00:00'),
(18, 'Dumont', 'Michel', 'mich.dumont@gmail.com', '0456987945', NULL, NULL, 2, '2017-09-28 23:17:55', '', '2017-09-14 00:00:00'),
(19, 'Minten', 'Jonathan', 'Jona.Minten@gmail.com', '0498674859', NULL, NULL, 2, '2017-09-28 23:18:38', '', '2017-09-07 00:00:00'),
(20, 'Tang', 'Alexander', 'Alex.T@gmail.com', '0489564298', NULL, NULL, 2, '2017-09-28 23:19:24', '', '2017-09-21 00:00:00'),
(21, 'Fayt', 'Romain', 'Romain.F@gmail.com', '0444235689', NULL, NULL, 2, '2017-09-28 23:20:14', '', '2017-09-06 00:00:00'),
(22, 'Blaise', 'Geoffrey', 'Geo.bl@gmail.com', '0477144565', NULL, NULL, 2, '2017-09-29 00:13:46', '', '2017-09-10 00:00:00'),
(23, 'Dessoy', 'Arnaud', 'Arn.Dess@gmail.com', '0474856412', NULL, NULL, 2, '2017-09-29 00:14:16', '', '2017-09-14 00:00:00'),
(24, 'Quiriny', 'Domingo', 'Dom.Q@gmail.com', '0459858379', NULL, NULL, 2, '2017-09-29 00:22:27', '', '2017-09-10 00:00:00'),
(25, 'Lavis', 'Antoine', 'Antoine.L@gmail.com', '0477899231', NULL, NULL, 2, '2017-09-29 00:23:04', '', '2017-09-10 00:00:00'),
(26, 'Harray', 'Eric', 'Eric.H@gmail.com', '0474797856', NULL, NULL, 2, '2017-09-29 00:26:47', '', '2017-09-06 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `pool`
--

CREATE TABLE `pool` (
  `id_pool` int(10) UNSIGNED NOT NULL,
  `FK_division` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `pool`
--

INSERT INTO `pool` (`id_pool`, `FK_division`) VALUES
(3, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `rencontre`
--

CREATE TABLE `rencontre` (
  `id_rencontre` int(10) UNSIGNED NOT NULL,
  `FK_joueur` int(10) UNSIGNED NOT NULL,
  `FK_interclub` int(10) UNSIGNED NOT NULL,
  `FK_equipe` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `rencontre`
--

INSERT INTO `rencontre` (`id_rencontre`, `FK_joueur`, `FK_interclub`, `FK_equipe`) VALUES
(3, 20, 3, 5),
(5, 21, 3, 5),
(6, 22, 3, 5),
(7, 23, 3, 5),
(8, 24, 3, 6),
(9, 25, 3, 6),
(10, 26, 3, 6),
(11, 27, 3, 6),
(12, 33, 3, 4),
(13, 34, 3, 4),
(14, 35, 3, 4),
(15, 36, 3, 4),
(16, 32, 4, 5),
(17, 20, 4, 5),
(18, 21, 4, 5),
(19, 22, 4, 5),
(20, 23, 4, 6),
(21, 24, 4, 6),
(22, 25, 4, 6),
(23, 26, 4, 6),
(24, 37, 4, 4),
(25, 38, 4, 4),
(26, 33, 4, 4),
(27, 34, 4, 4),
(28, 35, 5, 4),
(29, 36, 5, 4),
(30, 37, 5, 4),
(31, 38, 5, 4),
(32, 28, 5, 5),
(33, 29, 5, 5),
(34, 30, 5, 5),
(35, 31, 5, 5),
(36, 27, 5, 6),
(37, 32, 5, 6),
(38, 25, 5, 6),
(39, 26, 5, 6);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id_division`);

--
-- Index pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`id_equipe`),
  ADD KEY `FK_division` (`FK_division`);

--
-- Index pour la table `interclub`
--
ALTER TABLE `interclub`
  ADD PRIMARY KEY (`id_interclub`);

--
-- Index pour la table `joueurs`
--
ALTER TABLE `joueurs`
  ADD PRIMARY KEY (`id_joueur`),
  ADD KEY `FK_personne` (`FK_personne`),
  ADD KEY `FK_pool` (`FK_pool`);

--
-- Index pour la table `match`
--
ALTER TABLE `match`
  ADD PRIMARY KEY (`id_match`),
  ADD KEY `FK_rencontre` (`FK_rencontre`);

--
-- Index pour la table `personnes`
--
ALTER TABLE `personnes`
  ADD PRIMARY KEY (`id_personne`);

--
-- Index pour la table `pool`
--
ALTER TABLE `pool`
  ADD PRIMARY KEY (`id_pool`),
  ADD UNIQUE KEY `FK_division` (`FK_division`);

--
-- Index pour la table `rencontre`
--
ALTER TABLE `rencontre`
  ADD PRIMARY KEY (`id_rencontre`),
  ADD KEY `FK_joueur` (`FK_joueur`),
  ADD KEY `FK_interclub` (`FK_interclub`),
  ADD KEY `FK_equipe` (`FK_equipe`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `division`
--
ALTER TABLE `division`
  MODIFY `id_division` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `equipe`
--
ALTER TABLE `equipe`
  MODIFY `id_equipe` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `interclub`
--
ALTER TABLE `interclub`
  MODIFY `id_interclub` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `joueurs`
--
ALTER TABLE `joueurs`
  MODIFY `id_joueur` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT pour la table `match`
--
ALTER TABLE `match`
  MODIFY `id_match` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;
--
-- AUTO_INCREMENT pour la table `personnes`
--
ALTER TABLE `personnes`
  MODIFY `id_personne` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `pool`
--
ALTER TABLE `pool`
  MODIFY `id_pool` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `rencontre`
--
ALTER TABLE `rencontre`
  MODIFY `id_rencontre` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD CONSTRAINT `equipe_ibfk_1` FOREIGN KEY (`FK_division`) REFERENCES `division` (`id_division`);

--
-- Contraintes pour la table `joueurs`
--
ALTER TABLE `joueurs`
  ADD CONSTRAINT `joueurs_ibfk_1` FOREIGN KEY (`FK_personne`) REFERENCES `personnes` (`id_personne`),
  ADD CONSTRAINT `joueurs_ibfk_2` FOREIGN KEY (`FK_pool`) REFERENCES `pool` (`id_pool`);

--
-- Contraintes pour la table `match`
--
ALTER TABLE `match`
  ADD CONSTRAINT `match_ibfk_1` FOREIGN KEY (`FK_rencontre`) REFERENCES `rencontre` (`id_rencontre`);

--
-- Contraintes pour la table `pool`
--
ALTER TABLE `pool`
  ADD CONSTRAINT `pool_ibfk_1` FOREIGN KEY (`FK_division`) REFERENCES `division` (`id_division`);

--
-- Contraintes pour la table `rencontre`
--
ALTER TABLE `rencontre`
  ADD CONSTRAINT `rencontre_ibfk_1` FOREIGN KEY (`FK_joueur`) REFERENCES `joueurs` (`id_joueur`),
  ADD CONSTRAINT `rencontre_ibfk_2` FOREIGN KEY (`FK_interclub`) REFERENCES `interclub` (`id_interclub`),
  ADD CONSTRAINT `rencontre_ibfk_3` FOREIGN KEY (`FK_equipe`) REFERENCES `equipe` (`id_equipe`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
