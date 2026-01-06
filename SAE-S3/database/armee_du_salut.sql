-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 06 jan. 2026 à 17:59
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `armee_du_salut`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$i1MBsjA4xSJRhNRXwJilJ.7WgmYmpbHPkomtWcmaTGFEdk9KcFQKi', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `benevole`
--

CREATE TABLE `benevole` (
  `id_benevole` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `profession` varchar(100) DEFAULT NULL,
  `regime_alimentaire` varchar(100) DEFAULT NULL,
  `limitation_physique` text DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `benevole`
--

INSERT INTO `benevole` (`id_benevole`, `nom`, `prenom`, `email`, `telephone`, `ville`, `profession`, `regime_alimentaire`, `limitation_physique`, `date_creation`) VALUES
(3, 'Sobe', 'Osman', 'so@gmail.com', '', '', '', '', '', '2025-12-23 18:57:45'),
(5, 'le neun', 'titouan', 'lt@gmail.com', '', 'toulouse', '', 'Végétarien', '', '2025-12-23 18:59:05'),
(6, 'maxence', 'amalfi', 'ma@gmail.com', '', '', '', '', '', '2025-12-23 19:25:27'),
(7, 'Veer', 'Tanim', 'vt@gmail.com', '', 'lille', '', 'Sans Gluten', '', '2025-12-23 19:25:56');

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

CREATE TABLE `media` (
  `id_media` int(11) NOT NULL,
  `nom_fichier` varchar(255) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `date_ajout` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mission`
--

CREATE TABLE `mission` (
  `id_mission` int(11) NOT NULL,
  `titre` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `lieu` varchar(150) NOT NULL,
  `nb_benevoles_requis` int(11) DEFAULT 0,
  `statut` enum('prevu','en_cours','termine') DEFAULT 'prevu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `mission`
--

INSERT INTO `mission` (`id_mission`, `titre`, `description`, `date_debut`, `date_fin`, `lieu`, `nb_benevoles_requis`, `statut`) VALUES
(1, 'Collecte de denrées alimentaires', '', '2026-01-23 16:39:00', '2025-12-17 16:39:00', '', 5, 'prevu');

-- --------------------------------------------------------

--
-- Structure de la table `partenaire`
--

CREATE TABLE `partenaire` (
  `id_partenaire` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `type` enum('Entreprise','Institution','Fondation','Autre') NOT NULL DEFAULT 'Entreprise',
  `contact` varchar(100) DEFAULT NULL COMMENT 'Nom de la personne à contacter',
  `email` varchar(100) DEFAULT NULL,
  `type_soutien` enum('Financier','Matériel','Logistique','Mécénat') DEFAULT 'Financier',
  `date_ajout` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `partenaire`
--

INSERT INTO `partenaire` (`id_partenaire`, `nom`, `type`, `contact`, `email`, `type_soutien`, `date_ajout`) VALUES
(1, 'Mairie de Paris', 'Institution', 'Service Action Sociale', NULL, 'Financier', '2025-12-17 17:01:46'),
(2, 'Carrefour Market', 'Entreprise', 'Directeur du magasin', NULL, 'Matériel', '2025-12-17 17:01:46'),
(3, 'Fondation Abbé Pierre', 'Fondation', 'Secrétariat', NULL, 'Logistique', '2025-12-17 17:01:46');

-- --------------------------------------------------------

--
-- Structure de la table `participation`
--

CREATE TABLE `participation` (
  `id_benevole` int(11) NOT NULL,
  `id_mission` int(11) NOT NULL,
  `date_inscription` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `benevole`
--
ALTER TABLE `benevole`
  ADD PRIMARY KEY (`id_benevole`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id_media`);

--
-- Index pour la table `mission`
--
ALTER TABLE `mission`
  ADD PRIMARY KEY (`id_mission`);

--
-- Index pour la table `partenaire`
--
ALTER TABLE `partenaire`
  ADD PRIMARY KEY (`id_partenaire`);

--
-- Index pour la table `participation`
--
ALTER TABLE `participation`
  ADD PRIMARY KEY (`id_benevole`,`id_mission`),
  ADD KEY `id_mission` (`id_mission`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `benevole`
--
ALTER TABLE `benevole`
  MODIFY `id_benevole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `media`
--
ALTER TABLE `media`
  MODIFY `id_media` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `mission`
--
ALTER TABLE `mission`
  MODIFY `id_mission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `partenaire`
--
ALTER TABLE `partenaire`
  MODIFY `id_partenaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `participation`
--
ALTER TABLE `participation`
  ADD CONSTRAINT `participation_ibfk_1` FOREIGN KEY (`id_benevole`) REFERENCES `benevole` (`id_benevole`) ON DELETE CASCADE,
  ADD CONSTRAINT `participation_ibfk_2` FOREIGN KEY (`id_mission`) REFERENCES `mission` (`id_mission`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
