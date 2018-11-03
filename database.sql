-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  sam. 03 nov. 2018 à 16:28
-- Version du serveur :  10.1.30-MariaDB
-- Version de PHP :  7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `senforage`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

CREATE TABLE `abonnement` (
  `id` int(10) UNSIGNED NOT NULL,
  `idClient` int(10) UNSIGNED NOT NULL,
  `idCompteur` int(10) UNSIGNED NOT NULL,
  `numero` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `abonnement`
--

INSERT INTO `abonnement` (`id`, `idClient`, `idCompteur`, `numero`, `date`, `description`) VALUES
(2, 3, 7, '123458', '2018-10-11', 'Test 3');

-- --------------------------------------------------------

--
-- Structure de la table `Chef`
--

CREATE TABLE `Chef` (
  `id` int(10) UNSIGNED NOT NULL,
  `idVillage` int(10) UNSIGNED NOT NULL,
  `prenom` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` char(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `Chef`
--

INSERT INTO `Chef` (`id`, `idVillage`, `prenom`, `nom`, `telephone`) VALUES
(2, 1, 'abdou', 'dione', '2217366786'),
(3, 2, 'talla', 'fall', '706678678'),
(4, 3, 'ansou', 'diene', '766678678');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(10) UNSIGNED NOT NULL,
  `idChef` int(10) UNSIGNED NOT NULL,
  `idVillage` int(10) UNSIGNED NOT NULL,
  `nomFamille` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` char(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `idChef`, `idVillage`, `nomFamille`, `telephone`) VALUES
(3, 4, 3, 'diallo', '2217366786');

-- --------------------------------------------------------

--
-- Structure de la table `compteur`
--

CREATE TABLE `compteur` (
  `id` int(10) UNSIGNED NOT NULL,
  `idEtatCompteur` tinyint(1) UNSIGNED NOT NULL,
  `numero` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `pointeur` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `compteur`
--

INSERT INTO `compteur` (`id`, `idEtatCompteur`, `numero`, `pointeur`) VALUES
(7, 3, '45678', 2300),
(8, 1, '456788', 3000),
(9, 3, 'C-2839', 21200);

-- --------------------------------------------------------

--
-- Structure de la table `consommation`
--

CREATE TABLE `consommation` (
  `id` int(10) UNSIGNED NOT NULL,
  `idCompteur` int(10) UNSIGNED NOT NULL,
  `idTarif` smallint(5) UNSIGNED NOT NULL,
  `quantiteChiffre` mediumint(8) UNSIGNED NOT NULL,
  `quantiteLettre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `consommation`
--

INSERT INTO `consommation` (`id`, `idCompteur`, `idTarif`, `quantiteChiffre`, `quantiteLettre`, `date`) VALUES
(3, 8, 2, 30000, 'trante milles', '2018-10-24'),
(8, 8, 2, 90000, 'quarte vingt dix milles', '2018-09-30'),
(9, 8, 2, 70000, 'soixante dix milles', '2018-10-31'),
(10, 8, 2, 90000, 'quarte vingt dix milles', '2018-07-31'),
(11, 7, 2, 70000, 'soixante dix milles', '2018-10-17'),
(12, 8, 2, 70000, 'soixante dix milles', '2018-07-20');

-- --------------------------------------------------------

--
-- Structure de la table `etatCompteur`
--

CREATE TABLE `etatCompteur` (
  `id` tinyint(1) UNSIGNED NOT NULL,
  `label` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `etatCompteur`
--

INSERT INTO `etatCompteur` (`id`, `label`) VALUES
(1, 'actif'),
(2, 'inactif'),
(3, 'nouveau');

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `id` int(10) UNSIGNED NOT NULL,
  `idConsommation` int(10) UNSIGNED NOT NULL,
  `numero` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `montant` int(10) UNSIGNED NOT NULL,
  `dateFacturation` date NOT NULL,
  `dateLimitePaiement` date NOT NULL,
  `paye` tinyint(1) NOT NULL,
  `datePaiement` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `facture`
--

INSERT INTO `facture` (`id`, `idConsommation`, `numero`, `montant`, `dateFacturation`, `dateLimitePaiement`, `paye`, `datePaiement`) VALUES
(3, 3, '0003BGWGS9', 12000, '2018-11-03', '2018-12-05', 0, '0000-00-00'),
(8, 8, '0008CY1FB2', 36000, '2018-11-03', '2018-12-05', 0, '0000-00-00'),
(9, 9, '000948OOBB', 28000, '2018-11-03', '2018-12-05', 1, '2018-11-03'),
(10, 10, '00103LWX84', 36000, '2018-11-03', '2018-12-05', 1, '2018-11-03'),
(11, 11, '001146MQ29', 28000, '2018-11-03', '2018-12-05', 1, '2018-11-03'),
(12, 12, '0012AQFF6X', 28000, '2018-11-03', '2018-12-05', 1, '2018-11-03');

-- --------------------------------------------------------

--
-- Structure de la table `tarif`
--

CREATE TABLE `tarif` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `prixLitre` float UNSIGNED NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `tarif`
--

INSERT INTO `tarif` (`id`, `prixLitre`, `date`) VALUES
(1, 0.5, '2018-10-10'),
(2, 0.4, '2018-10-10');

-- --------------------------------------------------------

--
-- Structure de la table `village`
--

CREATE TABLE `village` (
  `id` int(10) UNSIGNED NOT NULL,
  `nom` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `village`
--

INSERT INTO `village` (`id`, `nom`) VALUES
(1, 'darou'),
(2, 'tayba'),
(3, 'tilene');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idClient` (`idClient`) USING BTREE,
  ADD KEY `idCompteur` (`idCompteur`) USING BTREE;

--
-- Index pour la table `Chef`
--
ALTER TABLE `Chef`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idVillage` (`idVillage`) USING BTREE;

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idChef` (`idChef`) USING BTREE,
  ADD KEY `idVillage` (`idVillage`) USING BTREE;

--
-- Index pour la table `compteur`
--
ALTER TABLE `compteur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEtatCompteur` (`idEtatCompteur`) USING BTREE;

--
-- Index pour la table `consommation`
--
ALTER TABLE `consommation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCompteur` (`idCompteur`) USING BTREE,
  ADD KEY `idTarif` (`idTarif`) USING BTREE;

--
-- Index pour la table `etatCompteur`
--
ALTER TABLE `etatCompteur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idConsommation` (`idConsommation`) USING BTREE;

--
-- Index pour la table `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `village`
--
ALTER TABLE `village`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `abonnement`
--
ALTER TABLE `abonnement`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `Chef`
--
ALTER TABLE `Chef`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `compteur`
--
ALTER TABLE `compteur`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `consommation`
--
ALTER TABLE `consommation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `etatCompteur`
--
ALTER TABLE `etatCompteur`
  MODIFY `id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `tarif`
--
ALTER TABLE `tarif`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `village`
--
ALTER TABLE `village`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD CONSTRAINT `abonnement_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `abonnement_ibfk_2` FOREIGN KEY (`idCompteur`) REFERENCES `compteur` (`id`);

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_2` FOREIGN KEY (`idChef`) REFERENCES `Chef` (`id`);

--
-- Contraintes pour la table `compteur`
--
ALTER TABLE `compteur`
  ADD CONSTRAINT `compteur_ibfk_1` FOREIGN KEY (`idEtatCompteur`) REFERENCES `etatCompteur` (`id`);

--
-- Contraintes pour la table `consommation`
--
ALTER TABLE `consommation`
  ADD CONSTRAINT `consommation_ibfk_1` FOREIGN KEY (`idCompteur`) REFERENCES `compteur` (`id`),
  ADD CONSTRAINT `consommation_ibfk_2` FOREIGN KEY (`idTarif`) REFERENCES `tarif` (`id`);

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`idConsommation`) REFERENCES `consommation` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
