-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 24 avr. 2019 à 11:44
-- Version du serveur :  10.1.31-MariaDB
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projetfinal`
--

-- --------------------------------------------------------

--
-- Structure de la table `quizz`
--

CREATE TABLE `quizz` (
  `id` int(11) NOT NULL,
  `question` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `option1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `option2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `option3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `correction` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `quizz`
--

INSERT INTO `quizz` (`id`, `question`, `option1`, `option2`, `option3`, `correction`) VALUES
(1, 'Quel célèbre dictateur dirigea l’URSS du milieu des années 1920 à 1953 ?\r\n', 'trotski', 'lenine', 'staline', 3),
(2, 'Dans quel pays peut-on trouver la Catalogne, l’Andalousie et la Castille ?', 'L’Espagne', 'L’Italie', 'Le portugal', 1),
(3, 'Qui a dit “ Le sort en est jeté” (Alea jacta est)?', 'Hitler', 'Napoleon', 'Jules Cesar', 3),
(4, 'À qui doit-on la chanson “ I Shot the Sheriff” ?', 'bob marley', 'eric clapton', 'ub40', 1),
(5, 'Quel pays a remporté la coupe du monde de football en 2014 ?', 'L\'Argentine', 'L’Italie', 'L’Allemagne', 3),
(6, 'Dans quelle ville italienne se situe l’action de la pièce de Shakespeare “Roméo et Juliette” ?', 'milan', 'verone', 'rome', 2),
(7, 'Par quel mot désigne-t-on une belle-mère cruelle ?', 'une jocrisse', 'une godiche', 'une maratre', 3),
(8, 'Qui était le dieu de la guerre dans la mythologie grecque ?', 'apollon', 'hermes', 'ares', 3),
(9, 'Quel est l’impératif du verbe feindre à la première personne du pluriel ?', 'Feignons', 'Feins', 'Feignez', 1),
(10, 'Quel roi de France proclama l’Édit de Nantes ?', 'Lousi XVI', 'François 1er', 'Henri IV', 3),
(11, 'À quel écrivain attribue-t-on la rédaction de l’Illiade et l’Odyssée ?', 'Virgile', 'Homere', 'euripide', 2),
(12, 'Qui s’est déclaré “premier flic de France” ?', 'Manuel valls', 'Charles de Gaulle', 'Georges Clemenceau', 3),
(13, 'Quel acteur américain incarne le héros du film de Christopher Nolan de 2014 “Interstellar” ?', 'leonardo di caprio', 'brad pitt', 'matthew mcconaughey', 3),
(14, 'Quel est le plus long fleuve en France ?', 'le rhone', 'le loire', 'le rhin', 2),
(15, 'Le drapeau russe est blanc, bleu et…?', 'rouge', 'jaune', 'vert', 1),
(16, 'Quel journal a été attaqué par des terroristes islamistes en janvier 2015 ?', 'liberation', 'charlie hebdo', 'le monde', 2),
(17, 'Quel animal andin de la famille des camélidés est élevé pour sa laine ?', 'le lama', 'le chameau', 'le yak', 1),
(18, 'Quelle est la date de la signature de l’armistice de la Première Guerre mondiale ?', '11 novembre 1918', '11 novembre 1919', '8 mai 1918', 1),
(19, 'Quel pays a décidé par referendum de quitter l’Union européenne ?', 'la suede', 'le royaume-uni', 'la pologne', 2),
(20, 'Dans quelle ville le Colisée (l\'amphithéâtre Flavien) se trouve-t-il ?', 'nimes', 'venise', 'rome', 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `quizz`
--
ALTER TABLE `quizz`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `quizz`
--
ALTER TABLE `quizz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
