-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 03 Octobre 2017 à 04:16
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

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
(1, '2017-09-05'),
(2, '2017-09-05'),
(3, '2017-09-10'),
(4, '2017-09-12'),
(5, '2017-09-13'),
(6, '2017-09-04'),
(7, '2017-09-01'),
(8, '2017-09-09'),
(9, '2017-09-12');

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE `joueur` (
  `id_joueur` int(10) UNSIGNED NOT NULL,
  `classement` varchar(2) NOT NULL,
  `disponibilté` varchar(40) NOT NULL DEFAULT 'Pas  dispo',
  `bannir` tinyint(4) NOT NULL,
  `FK_personne` int(10) UNSIGNED NOT NULL,
  `FK_pool` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `joueur`
--

INSERT INTO `joueur` (`id_joueur`, `classement`, `disponibilté`, `bannir`, `FK_personne`, `FK_pool`) VALUES
(20, 'E0', 'dispo', 0, 1, 4),
(21, 'E2', 'Pas dispo', 0, 2, 4),
(22, 'E2', 'dispo', 0, 9, 4),
(23, 'E4', 'Pas dispo', 0, 10, 4),
(24, 'E6', 'Pas dispo', 0, 12, 4),
(25, 'E6', 'dispo', 0, 13, 4),
(26, 'C6', 'Pas dispo', 0, 14, 4),
(27, 'D6', 'dispo', 0, 15, 4),
(28, 'D4', 'Pas dispo', 0, 16, 4),
(29, 'D2', 'Pas dispo', 0, 17, 4),
(30, 'D0', 'dispo', 0, 18, 4),
(31, 'D2', 'Pas dispo', 0, 19, 4),
(32, 'D0', 'Pas dispo', 0, 20, 4),
(33, 'B2', 'dispo', 0, 21, 3),
(34, 'B4', 'Pas dispo', 0, 22, 3),
(35, 'C4', 'dispo', 0, 23, 3),
(36, 'C6', 'Pas dispo', 0, 24, 3),
(37, 'B0', 'dispo', 0, 25, 3),
(38, 'B2', '', 0, 26, 3);

-- --------------------------------------------------------

--
-- Structure de la table `match`
--

CREATE TABLE `match` (
  `id_match` int(10) UNSIGNED NOT NULL,
  `FK_rencontre` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `match`
--

INSERT INTO `match` (`id_match`, `FK_rencontre`) VALUES
(2, 1),
(1, 2);

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
(9, 'Kone', 'Ibrahim', 'ib@ib.ib', '123456', '356a192b7913b04c54574d18c28d46e6395428ab', 'sdgjsefnfkniu', 1, '2017-06-20 17:27:51', 'Autre', '0000-00-00 00:00:00'),
(10, 'kone', 'Ibrahim', 'ib.kone12@yahoo.fr', NULL, '356a192b7913b04c54574d18c28d46e6395428ab', 'esfezfez', 0, '2017-06-20 17:29:11', '', '0000-00-00 00:00:00'),
(12, 'Van de Put', 'Samuel', 'sam.vdp@hotmail.com', '0498076742', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'fdc0bea64465ded62ff829f70b93bbaf', 0, '2017-06-20 17:29:22', 'Masculin', '2017-06-06 00:00:00'),
(13, 'Masclet', 'Laurence', 'lau.masclet@gmail.com', '0474875421', NULL, NULL, 2, '2017-09-28 23:10:54', 'F', '2017-09-28 00:00:00'),
(14, 'LHaij', 'Samir', 'Samir.LHaij@gmail.com', '0456123456', NULL, NULL, 2, '2017-09-28 23:11:59', 'M', '2017-09-19 00:00:00'),
(15, 'Michael', 'Remi', 'michael.remi@gmail.com', '0489745612', NULL, NULL, 2, '2017-09-28 23:13:06', 'M', '2017-09-03 00:00:00'),
(16, 'Huberty', 'Floriant', 'Floriant.Hub@gmail.com', '0478598642', NULL, NULL, 2, '2017-09-28 23:14:31', '', '2017-09-13 00:00:00'),
(17, 'Daussin', 'Alain', 'Alain.Daussin@gmail.com', '0479456894', NULL, NULL, 2, '2017-09-28 23:16:54', '', '2017-09-02 00:00:00'),
(18, 'Xavier', 'Inghels', 'Xa.Inghels@gmail.com', '0456987945', NULL, NULL, 2, '2017-09-28 23:17:55', '', '2017-09-14 00:00:00'),
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
(1, 22, 5, 5),
(2, 35, 7, 4);

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
-- Index pour la table `joueur`
--
ALTER TABLE `joueur`
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
  MODIFY `id_interclub` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `joueur`
--
ALTER TABLE `joueur`
  MODIFY `id_joueur` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT pour la table `match`
--
ALTER TABLE `match`
  MODIFY `id_match` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
  MODIFY `id_rencontre` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD CONSTRAINT `equipe_ibfk_1` FOREIGN KEY (`FK_division`) REFERENCES `division` (`id_division`);

--
-- Contraintes pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD CONSTRAINT `joueur_ibfk_1` FOREIGN KEY (`FK_personne`) REFERENCES `personnes` (`id_personne`),
  ADD CONSTRAINT `joueur_ibfk_2` FOREIGN KEY (`FK_pool`) REFERENCES `pool` (`id_pool`);

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
  ADD CONSTRAINT `rencontre_ibfk_1` FOREIGN KEY (`FK_joueur`) REFERENCES `joueur` (`id_joueur`),
  ADD CONSTRAINT `rencontre_ibfk_2` FOREIGN KEY (`FK_interclub`) REFERENCES `interclub` (`id_interclub`),
  ADD CONSTRAINT `rencontre_ibfk_3` FOREIGN KEY (`FK_equipe`) REFERENCES `equipe` (`id_equipe`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
