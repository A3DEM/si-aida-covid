-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  lun. 23 mai 2022 à 09:04
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

--
-- Déchargement des données de la table `maladie`
--

INSERT INTO `maladie` (`idMaladie`, `nom`) VALUES
(0, 'Aucune'),
(1, 'Diabète'),
(2, 'Tension'),
(3, 'Insuffisance rénale'),
(4, 'Insuffisance respiratoire'),
(5, 'Immunoinsuffisance');

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
(1, 'duran', 'adem', '1999-02-21', '42 Bd Stoessel, Mulhouse 681000', 1, 'ademduran', 'akimbo', 1),
(2, '667', 'Steward', '2000-02-23', '61 Rue Albert Camus, Mulhouse 68200', 1, 'faresabdelkrim', 'menteur', 1),
(3, 'Wick', 'John', '1990-07-21', 'Continental, New-York', 1, 'johnwick', 'doggo', 2),
(4, 'Vachter', 'Lazar', '1993-08-09', 'Avenue des Champs-Elysées', 1, 'django', 'frelon', 1),
(5, 'Zen', 'Chen', '2022-01-01', 'Boulevard de la SACEM', 1, 'zenchen667', 'ekip', 4),
(6, 'Schwarzer', 'Julien', '2022-01-01', '13 rue de la Maison Baron Rouge', 1, 'incroyablemec', 'otto', 4),
(7, 'Yaffa', 'Elie', '1982-01-01', 'En bas de chez toi', 1, 'booba', '92izi', 1),
(8, 'Gnakouri', 'Okou', '2022-01-01', 'L\'échec', 1, 'kaaris', 'deuxsept', 3),
(9, 'Wann', 'Alpha', '1993-08-09', 'Avenue des Champs-Elysées', 1, 'philly', 'flingo', 4);

-- --------------------------------------------------------

--
-- Structure de la table `possède`
--

CREATE TABLE `possède` (
  `idPersonne` int(11) NOT NULL,
  `idMaladie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `possède`
--

INSERT INTO `possède` (`idPersonne`, `idMaladie`) VALUES
(2, 1),
(7, 1),
(9, 1),
(1, 2),
(2, 2),
(7, 2),
(8, 2),
(2, 3),
(3, 3),
(7, 3),
(9, 3),
(2, 4),
(6, 4),
(7, 4),
(9, 4),
(2, 5),
(7, 5);

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
  `estVaccine` tinyint(1) DEFAULT NULL,
  `idPersonne` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `vaccination`
--

INSERT INTO `vaccination` (`idVaccination`, `numDose`, `estVaccine`, `idPersonne`) VALUES
(2, 1, 1, 3),
(3, 2, 1, 3),
(4, 1, 0, 4),
(10, 1, 1, 9),
(11, 2, 0, 9),
(20, 1, 1, 1),
(21, 2, 1, 1),
(22, 1, 0, 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `maladie`
--
ALTER TABLE `maladie`
  ADD PRIMARY KEY (`idMaladie`);

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
  ADD PRIMARY KEY (`idVaccination`),
  ADD KEY `idPersonne` (`idPersonne`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `maladie`
--
ALTER TABLE `maladie`
  MODIFY `idMaladie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `personne`
--
ALTER TABLE `personne`
  MODIFY `idPersonne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `possède`
--
ALTER TABLE `possède`
  MODIFY `idPersonne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `typevaccin`
--
ALTER TABLE `typevaccin`
  MODIFY `idVaccin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `vaccination`
--
ALTER TABLE `vaccination`
  MODIFY `idVaccination` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Contraintes pour les tables déchargées
--

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

--
-- Contraintes pour la table `vaccination`
--
ALTER TABLE `vaccination`
  ADD CONSTRAINT `vaccination_ibfk_1` FOREIGN KEY (`idPersonne`) REFERENCES `personne` (`idPersonne`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
