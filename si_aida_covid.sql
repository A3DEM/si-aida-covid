-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mar. 17 mai 2022 à 12:52
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `si_aida_covid`
--

-- --------------------------------------------------------

--
-- Structure de la table `maladie`
--

CREATE TABLE `maladie` (
  `idMaladie` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `persone_vaccination`
--

CREATE TABLE `persone_vaccination` (
  `idPersonne` int(11) NOT NULL,
  `idVaccination` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `idPersonne` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `dateNaissance` date DEFAULT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `role` int(11) NOT NULL,
  `identifiant` varchar(24) NOT NULL,
  `motdepasse` varchar(50) DEFAULT NULL,
  `idVaccin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `personne`
--

INSERT INTO `personne` (`idPersonne`, `nom`, `prenom`, `dateNaissance`, `adresse`, `role`, `identifiant`, `motdepasse`, `idVaccin`) VALUES
(1, 'duran', 'adem', '2002-02-21', '42 Bd Stoessel, Mulhouse 681000', 0, 'ademduran', 'akimbo', 1),
(2, 'abdelkrim', 'fares', '2000-02-23', '61 Rue Albert Camus, Mulhouse 68200', 0, 'faresabdelkrim', 'menteur', 1);

-- --------------------------------------------------------

--
-- Structure de la table `possède`
--

CREATE TABLE `possède` (
  `idPersonne` int(11) NOT NULL,
  `idMaladie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `typevaccin`
--

CREATE TABLE `typevaccin` (
  `idVaccin` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `typevaccin`
--

INSERT INTO `typevaccin` (`idVaccin`, `nom`) VALUES
(1, 'Pfizer'),
(2, 'Moderna'),
(3, 'AstraZeneca'),
(4, 'Janssen');

-- --------------------------------------------------------

--
-- Structure de la table `vaccination`
--

CREATE TABLE `vaccination` (
  `idVaccination` int(11) NOT NULL,
  `numDose` int(11) DEFAULT NULL,
  `estVaccine` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `maladie`
--
ALTER TABLE `maladie`
  ADD PRIMARY KEY (`idMaladie`);

--
-- Index pour la table `persone_vaccination`
--
ALTER TABLE `persone_vaccination`
  ADD PRIMARY KEY (`idPersonne`,`idVaccination`),
  ADD KEY `idVaccination` (`idVaccination`);

--
-- Index pour la table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`idPersonne`),
  ADD KEY `idVaccin` (`idVaccin`);

--
-- Index pour la table `possède`
--
ALTER TABLE `possède`
  ADD PRIMARY KEY (`idPersonne`,`idMaladie`),
  ADD KEY `idMaladie` (`idMaladie`);

--
-- Index pour la table `typevaccin`
--
ALTER TABLE `typevaccin`
  ADD PRIMARY KEY (`idVaccin`);

--
-- Index pour la table `vaccination`
--
ALTER TABLE `vaccination`
  ADD PRIMARY KEY (`idVaccination`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `maladie`
--
ALTER TABLE `maladie`
  MODIFY `idMaladie` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `persone_vaccination`
--
ALTER TABLE `persone_vaccination`
  MODIFY `idPersonne` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `personne`
--
ALTER TABLE `personne`
  MODIFY `idPersonne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `possède`
--
ALTER TABLE `possède`
  MODIFY `idPersonne` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `typevaccin`
--
ALTER TABLE `typevaccin`
  MODIFY `idVaccin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `vaccination`
--
ALTER TABLE `vaccination`
  MODIFY `idVaccination` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `persone_vaccination`
--
ALTER TABLE `persone_vaccination`
  ADD CONSTRAINT `persone_vaccination_ibfk_1` FOREIGN KEY (`idPersonne`) REFERENCES `personne` (`idPersonne`),
  ADD CONSTRAINT `persone_vaccination_ibfk_2` FOREIGN KEY (`idVaccination`) REFERENCES `vaccination` (`idVaccination`);

--
-- Contraintes pour la table `personne`
--
ALTER TABLE `personne`
  ADD CONSTRAINT `personne_ibfk_1` FOREIGN KEY (`idVaccin`) REFERENCES `typevaccin` (`idVaccin`);

--
-- Contraintes pour la table `possède`
--
ALTER TABLE `possède`
  ADD CONSTRAINT `possède_ibfk_1` FOREIGN KEY (`idPersonne`) REFERENCES `personne` (`idPersonne`),
  ADD CONSTRAINT `possède_ibfk_2` FOREIGN KEY (`idMaladie`) REFERENCES `maladie` (`idMaladie`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
