-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 28 Septembre 2017 à 13:13
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
  `nom` varchar(50) NOT NULL,
  `FK_equipe` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

CREATE TABLE `equipe` (
  `id_equipe` int(10) UNSIGNED NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `interclub`
--

CREATE TABLE `interclub` (
  `id_interclub` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE `joueur` (
  `id_joueur` int(10) UNSIGNED NOT NULL,
  `classement` varchar(2) NOT NULL,
  `FK_personne` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `match`
--

CREATE TABLE `match` (
  `id_match` int(10) UNSIGNED NOT NULL,
  `FK_rencontre` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(12, 'Van de Put', 'Samuel', 'sam.vdp@hotmail.com', '0498076742', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'fdc0bea64465ded62ff829f70b93bbaf', 0, '2017-06-20 17:29:22', 'Masculin', '2017-06-06 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `pool`
--

CREATE TABLE `pool` (
  `id_pool` int(10) UNSIGNED NOT NULL,
  `FK_division` int(10) UNSIGNED NOT NULL,
  `FK_joueur` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Index pour les tables exportées
--

--
-- Index pour la table `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id_division`),
  ADD KEY `FK_equipe` (`FK_equipe`);

--
-- Index pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`id_equipe`);

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
  ADD KEY `FK_personne` (`FK_personne`);

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
  ADD UNIQUE KEY `FK_joueur` (`FK_joueur`),
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
  MODIFY `id_division` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `equipe`
--
ALTER TABLE `equipe`
  MODIFY `id_equipe` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `interclub`
--
ALTER TABLE `interclub`
  MODIFY `id_interclub` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `joueur`
--
ALTER TABLE `joueur`
  MODIFY `id_joueur` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `match`
--
ALTER TABLE `match`
  MODIFY `id_match` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `personnes`
--
ALTER TABLE `personnes`
  MODIFY `id_personne` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `pool`
--
ALTER TABLE `pool`
  MODIFY `id_pool` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `rencontre`
--
ALTER TABLE `rencontre`
  MODIFY `id_rencontre` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `division`
--
ALTER TABLE `division`
  ADD CONSTRAINT `division_ibfk_1` FOREIGN KEY (`FK_equipe`) REFERENCES `equipe` (`id_equipe`);

--
-- Contraintes pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD CONSTRAINT `joueur_ibfk_1` FOREIGN KEY (`FK_personne`) REFERENCES `personnes` (`id_personne`);

--
-- Contraintes pour la table `match`
--
ALTER TABLE `match`
  ADD CONSTRAINT `match_ibfk_1` FOREIGN KEY (`FK_rencontre`) REFERENCES `rencontre` (`id_rencontre`);

--
-- Contraintes pour la table `pool`
--
ALTER TABLE `pool`
  ADD CONSTRAINT `pool_ibfk_1` FOREIGN KEY (`FK_division`) REFERENCES `division` (`id_division`),
  ADD CONSTRAINT `pool_ibfk_2` FOREIGN KEY (`FK_joueur`) REFERENCES `joueur` (`id_joueur`);

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
