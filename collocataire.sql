-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 26 Novembre 2013 à 21:28
-- Version du serveur: 5.5.28
-- Version de PHP: 5.4.4-10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `collocataire`
--

-- --------------------------------------------------------

--
-- Structure de la table `achat`
--

CREATE TABLE IF NOT EXISTS `achat` (
  `date` date NOT NULL,
  `paye` tinyint(1) NOT NULL DEFAULT '0',
  `prix` float NOT NULL,
  `fk_utilisateur` varchar(25) NOT NULL,
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date_paye` date DEFAULT NULL,
  `commentaire` varchar(250) DEFAULT NULL,
  `auto` tinyint(1) NOT NULL DEFAULT '0',
  `paye_to` varchar(25) NOT NULL COMMENT 'Achat pour un autre coloc',
  `is_deleted` tinyint(4) NOT NULL COMMENT 'suppression logique',
  PRIMARY KEY (`id`),
  KEY `fk_utilisateur` (`fk_utilisateur`),
  KEY `paye_to` (`paye_to`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=156 ;

--
-- Contenu de la table `achat`
--

INSERT INTO `achat` (`date`, `paye`, `prix`, `fk_utilisateur`, `id`, `date_paye`, `commentaire`, `auto`, `paye_to`, `is_deleted`) VALUES
('2013-01-06', 1, 128, 'alison', 21, '2013-01-19', 'Appartement', 0, '', 0),
('2013-01-07', 1, 80, 'alison', 22, '2013-01-19', 'EDF', 0, '', 0),
('2013-01-21', 1, 55, 'alison', 23, '2013-01-19', 'E.Leclerc', 0, '', 0),
('2013-01-26', 1, 60, 'alison', 25, '2013-01-19', 'Courses Leclerc', 0, '', 0),
('2013-02-04', 0, 29.8, 'trall', 29, NULL, 'Courses perso Adrien', 0, '', 0),
('2013-02-07', 0, 11, 'adrien', 30, NULL, 'Balai toilette sac poubelle ', 0, '', 0),
('2013-02-17', 0, 50, 'trall', 31, NULL, 'Covoiturage gfi', 1, '', 0),
('2013-02-17', 0, 32, 'clement', 32, NULL, 'Moyenne des factures Free pour internet', 1, '', 0),
('2013-02-15', 0, 60, 'alison', 33, NULL, 'Course Leclerc', 0, '', 0),
('2013-02-15', 0, 57.36, 'adrien', 34, NULL, 'Courses drive', 0, '', 0),
('2013-02-18', 0, 7.95, 'adrien', 36, NULL, 'Volants ', 0, '', 0),
('2013-02-11', 0, 180.2, 'trall', 37, NULL, 'Courses Leclerc', 0, '', 0),
('2013-02-12', 0, 10, 'toto', 44, NULL, 'aefaef', 0, '', 0),
('2013-02-14', 0, 10.54, 'toto', 47, NULL, 'aefaeaec', 0, '', 0),
('2013-02-26', 0, 93, 'adrien', 48, NULL, 'Achat courses drive leclerc + boulangerie 20 €', 0, '', 0),
('2013-02-28', 0, 12, 'toto', 49, NULL, 'Test achat', 0, '', 0),
('2013-02-20', 0, 5.5, 'titi', 50, NULL, 'Test achat', 0, '', 0),
('2013-02-28', 0, 75.4, 'tata', 51, NULL, '', 0, '', 0),
('2013-03-30', 0, 98.54, 'toto', 52, NULL, 'Test', 0, '', 0),
('2013-03-01', 0, 12.24, 'tutu', 53, NULL, 'Test', 0, '', 0),
('2013-02-02', 0, 12.25, 'toto', 55, NULL, 'Test', 0, 'tutu', 0),
('2013-02-27', 0, 6, 'adrien', 56, NULL, 'Place de cine Die Hard', 0, 'trall', 0),
('2013-03-08', 0, 12, 'toto', 57, NULL, 'test', 0, '', 0),
('2013-03-14', 0, 59.4, 'trall', 59, NULL, '', 0, '', 0),
('2013-03-14', 0, 24.45, 'adrien', 60, NULL, 'Course Leclerc', 0, '', 0),
('2013-03-16', 0, 140, 'toto', 61, NULL, 'test', 0, 'tata', 0),
('2013-03-17', 0, 32, 'clement', 62, NULL, 'Moyenne des factures Free pour internet', 0, '', 0),
('2013-03-19', 0, 50, 'trall', 63, NULL, 'Covoiturage gfi', 1, '', 0),
('2013-03-18', 0, 5, 'trall', 64, NULL, 'Place ciné Oz', 0, 'adrien', 0),
('2013-03-27', 0, 97, 'adrien', 65, NULL, 'Course drive', 0, '', 0),
('2013-03-27', 0, 1.94, 'adrien', 66, NULL, 'Pour que tu te lave :-)', 0, 'trall', 0),
('2013-03-27', 0, 6.9, 'trall', 67, NULL, 'Ciné "Mon film préféré" JI JO', 0, 'adrien', 0),
('2013-04-10', 0, 31.19, 'trall', 68, NULL, 'Achat Leclerc + 2 tickets resto', 0, '', 0),
('2013-04-06', 0, 19.58, 'adrien', 69, NULL, 'Courses', 0, '', 0),
('2013-04-17', 0, 32, 'clement', 70, NULL, 'Moyenne des factures Free pour internet', 0, '', 0),
('2013-04-19', 0, 50, 'trall', 71, NULL, 'Covoiturage gfi', 1, '', 0),
('2013-04-25', 0, 1.5, 'trall', 72, NULL, 'La 3D pour Iron Man3', 0, 'adrien', 0),
('2013-04-30', 0, 86, 'adrien', 73, NULL, 'courses leclerc drive', 0, '', 0),
('2013-05-14', 0, 139.22, 'adrien', 74, NULL, 'Course Leclerc drive ', 0, '', 0),
('2013-05-17', 0, 32, 'clement', 75, NULL, 'Moyenne des factures Free pour internet', 0, '', 0),
('2013-05-19', 0, 50, 'trall', 76, NULL, 'Covoiturage gfi', 1, '', 0),
('2013-05-31', 0, 53.32, 'adrien', 77, NULL, 'Courses drive ', 0, '', 0),
('2013-06-13', 0, 64, 'trall', 78, NULL, '10 tickets de cinéma', 0, '', 0),
('2013-06-12', 0, 1.5, 'trall', 79, NULL, 'La 3D de star trek ! Ca spoke :D', 0, 'adrien', 0),
('2013-06-13', 0, 41.73, 'trall', 80, NULL, 'Courses Leclerc sur place', 0, '', 0),
('2013-06-14', 0, 42.5, 'trall', 81, NULL, 'Patron c''est ma tournée ! Tavernier une autre !', 0, '', 0),
('2013-06-17', 0, 32, 'clement', 82, NULL, 'Moyenne des factures Free pour internet', 0, '', 0),
('2013-06-18', 0, 7, 'trall', 83, NULL, 'Pour poser ton cul pret de Yannick', 0, 'adrien', 0),
('2013-06-19', 0, 50, 'trall', 84, NULL, 'Covoiturage gfi', 1, '', 0),
('2013-07-03', 0, 43.8, 'trall', 85, NULL, 'Courses Leclerc physique', 0, '', 0),
('2013-07-08', 0, 36.13, 'adrien', 86, NULL, 'Course physique', 0, '', 0),
('2013-07-08', 0, 62.15, 'adrien', 87, NULL, 'Course physique 13/06/13', 0, '', 0),
('2013-07-11', 0, 13.16, 'adrien', 88, NULL, 'Courses physique ', 0, '', 0),
('2013-07-04', 0, 6.5, 'trall', 89, NULL, 'pinte au duplex', 0, 'adrien', 0),
('2013-07-12', 0, 15.8, 'adrien', 90, NULL, 'Ciné : monstre académie', 0, '', 0),
('2013-07-17', 0, 32, 'clement', 91, NULL, 'Moyenne des factures Free pour internet', 0, '', 0),
('2013-07-19', 0, 50, 'trall', 92, NULL, 'Covoiturage gfi', 1, '', 0),
('2013-07-31', 0, 147, 'adrien', 93, NULL, 'Courses + ciné + perso clem pour protéger sa sensible peau', 0, '', 0),
('2013-08-05', 0, 30, 'trall', 94, NULL, 'Co-voiturage Le mans + trevin 6/8/13 + quick\r\n24  + 1 + 5', 0, 'adrien', 0),
('2013-08-09', 0, 7, 'trall', 95, NULL, '', 0, 'adrien', 0),
('2013-08-19', 0, 50, 'trall', 97, NULL, 'Covoiturage gfi', 1, '', 0),
('2013-08-22', 0, 59.4, 'adrien', 98, NULL, 'Courses drive', 0, '', 0),
('2013-08-22', 0, 12.8, 'adrien', 99, NULL, 'Cine "Gerard Magax au pays des voleurs & Elysium"', 0, 'trall', 0),
('2013-09-02', 0, 95, 'adrien', 100, NULL, 'Charges restantes dues', 0, '', 0),
('2013-10-04', 0, 30, 'toto', 101, NULL, 'test', 1, '', 0),
('2013-10-01', 0, 40, 'clement', 102, NULL, 'Electricité mois de septembre', 0, '', 0),
('2013-09-09', 0, 396, 'clement', 103, NULL, 'Loyer du mois de septembre', 0, '', 0),
('2013-09-14', 0, 118, 'clement', 104, NULL, '2 X Chaises de bar', 0, '', 0),
('2013-10-12', 0, 40, 'clement', 105, NULL, 'Meuble de cuisine', 0, '', 0),
('2013-10-14', 0, 31, 'clement', 106, NULL, 'Bonbonne de gaz achat a intermarché', 0, '', 0),
('2013-10-03', 0, 80, 'clement', 107, NULL, 'Courses de Leclerc saint maixent', 0, '', 0),
('2013-08-26', 0, 490, 'clement', 108, NULL, 'Prêt cloture', 0, 'alison', 0),
('2013-06-29', 0, 150, 'clement', 109, NULL, 'Voyage ireland', 0, 'alison', 0),
('2013-10-05', 0, 30, 'toto', 110, NULL, 'test', 1, '', 0),
('2013-09-13', 0, 80, 'alison', 111, NULL, 'Courses inter', 0, '', 0),
('2013-09-27', 0, 40, 'alison', 112, NULL, 'Courses inter lusignan', 0, '', 0),
('2013-10-06', 0, 30, 'toto', 113, NULL, 'test', 1, '', 0),
('2013-10-07', 0, 20, 'clement', 114, NULL, 'Facture internet sosh mensuel, Rouillé', 1, '', 0),
('2013-10-07', 0, 30, 'toto', 115, NULL, 'test', 1, '', 0),
('2013-10-08', 0, 30, 'toto', 116, NULL, 'test', 1, '', 0),
('2013-10-09', 0, 30, 'toto', 119, NULL, 'test', 1, '', 0),
('2013-10-08', 0, 22, 'alison', 121, NULL, 'Premier paiement assurance habitation ', 0, '', 0),
('2013-10-10', 0, 30, 'toto', 122, NULL, 'test', 1, '', 0),
('2013-10-11', 0, 30, 'toto', 123, NULL, 'test', 1, '', 0),
('2013-10-10', 0, 67, 'clement', 124, NULL, '  castorama', 0, '', 0),
('2013-10-12', 0, 30, 'toto', 125, NULL, 'test', 1, '', 0),
('2013-10-13', 0, 30, 'toto', 126, NULL, 'test', 1, '', 0),
('2013-10-14', 0, 30, 'toto', 127, NULL, 'test', 1, '', 0),
('2013-10-15', 0, 30, 'toto', 128, NULL, 'test', 1, '', 0),
('2013-10-16', 0, 30, 'toto', 129, NULL, 'test', 1, '', 0),
('2013-10-17', 0, 30, 'toto', 130, NULL, 'test', 1, '', 0),
('2013-10-18', 0, 30, 'toto', 131, NULL, 'test', 1, '', 0),
('2013-10-19', 0, 30, 'toto', 132, NULL, 'test', 1, '', 0),
('2013-10-20', 0, 30, 'toto', 133, NULL, 'test', 1, '', 0),
('2013-10-21', 0, 30, 'toto', 134, NULL, 'test', 1, '', 0),
('2013-10-23', 0, 21, 'alison', 137, NULL, 'courses inter', 0, '', 0),
('2013-10-18', 0, 26, 'alison', 138, NULL, 'courses inter', 0, '', 0),
('2013-10-23', 0, 40, 'alison', 139, NULL, 'courses leclerc\r\n', 0, '', 0),
('2013-10-22', 0, 50, 'alison', 140, NULL, 'contrôle technique peugeot', 0, 'clement', 0),
('2013-10-15', 0, 20, 'toto', 144, NULL, 'Test Achats', 0, 'tutu', 0),
('2013-10-22', 0, 12.5, 'toto', 145, NULL, ' Mon test    ', 0, '', 0),
('2013-10-31', 0, 36, 'clement', 146, NULL, '2 * table de chevet', 0, '', 0),
('2013-10-30', 0, 30.32, 'clement', 147, NULL, 'Courses Drive E.Leclerc', 0, '', 0),
('2013-11-07', 0, 20, 'clement', 148, NULL, 'Facture internet sosh mensuel, Rouillé', 1, '', 0),
('2013-11-07', 0, 100, 'alison', 149, NULL, 'courses leclerc', 0, '', 0),
('2013-11-08', 0, 13.91, 'alison', 150, NULL, 'Assurance habitation', 1, '', 0),
('2013-11-13', 0, 45.25, 'clement', 151, NULL, 'Course leclerc', 0, '', 0),
('2013-11-16', 0, 20, 'toto', 152, NULL, 'taetaet', 1, '', 1),
('2013-11-20', 0, 30, 'toto', 153, NULL, '  testset', 0, '', 0),
('2013-11-23', 0, 87.75, 'clement', 154, NULL, '  courses inter', 0, '', 0),
('2013-11-02', 0, 35.4, 'clement', 155, NULL, ' aliment noblesse gamm vert', 0, 'alison', 0);

-- --------------------------------------------------------

--
-- Structure de la table `attachment`
--

CREATE TABLE IF NOT EXISTS `attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_achat` int(11) NOT NULL,
  `file` longblob NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_achat` (`fk_achat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `attachment`
--

INSERT INTO `attachment` (`id`, `fk_achat`, `file`, `type`) VALUES
INSERT INTO `attachment` (`id`, `fk_achat`, `file`, `type`) VALUES
INSERT INTO `attachment` (`id`, `fk_achat`, `file`, `type`) VALUES
INSERT INTO `attachment` (`id`, `fk_achat`, `file`, `type`) VALUES
(6, 124, 0x30, ''),
(7, 154, 0x30, ''),
(8, 155, 0x30, '');

-- --------------------------------------------------------

--
-- Structure de la table `event_achat`
--

CREATE TABLE IF NOT EXISTS `event_achat` (
  `nom` varchar(25) NOT NULL,
  `fk_utilisateur` varchar(25) NOT NULL,
  `prix` float NOT NULL,
  `frequence` varchar(11) NOT NULL,
  `commentaire` varchar(250) DEFAULT NULL,
  `date_debut` date NOT NULL,
  PRIMARY KEY (`nom`),
  KEY `fk_utilisateur` (`fk_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `event_achat`
--

INSERT INTO `event_achat` (`nom`, `fk_utilisateur`, `prix`, `frequence`, `commentaire`, `date_debut`) VALUES
('INTERNET_EVT', 'clement', 20, 'MONTH', 'Facture internet sosh mensuel, Rouillé', '2013-10-07');

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE IF NOT EXISTS `groupe` (
  `nom` varchar(20) NOT NULL,
  PRIMARY KEY (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `groupe`
--

INSERT INTO `groupe` (`nom`) VALUES
('Alison_Clem'),
('GFI'),
('Test Groupe');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `login` varchar(25) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `fk_groupe` varchar(20) NOT NULL,
  `mail` varchar(30) NOT NULL,
  PRIMARY KEY (`login`),
  KEY `fk_groupe` (`fk_groupe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`login`, `mdp`, `fk_groupe`, `mail`) VALUES
('admin', 'f1c91e78ca2314b1982719ea92b2e691', 'admin', ''),
('adrien', '25d55ad283aa400af464c76d713c07ad', 'GFI', 'adrien.didenot@wanadoo.fr'),
('alison', 'c2dc59e47fc59d1a2cb7629fb0f25451', 'Alison_Clem', 'alisonjazz@hotmail.fr'),
('clement', 'b01fdb37dbf6beeda6b6c50e8bfc072b', 'Alison_Clem', 'chevalier.clement1@gmail.com'),
('tata', '202cb962ac59075b964b07152d234b70', 'Test Groupe', ''),
('titi', '202cb962ac59075b964b07152d234b70', 'Test Groupe', 'titi@mail.com'),
('toto', 'b01fdb37dbf6beeda6b6c50e8bfc072b', 'Test Groupe', 'clement141fr@yahoo.fr'),
('trall', 'b01fdb37dbf6beeda6b6c50e8bfc072b', 'GFI', 'chevalier.clement1@gmail.com'),
('tutu', '202cb962ac59075b964b07152d234b70', 'Test Groupe', '');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `achat`
--
ALTER TABLE `achat`
  ADD CONSTRAINT `achat_ibfk_2` FOREIGN KEY (`fk_utilisateur`) REFERENCES `utilisateur` (`login`) ON DELETE CASCADE;

--
-- Contraintes pour la table `attachment`
--
ALTER TABLE `attachment`
  ADD CONSTRAINT `attachment_ibfk_1` FOREIGN KEY (`fk_achat`) REFERENCES `achat` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `event_achat`
--
ALTER TABLE `event_achat`
  ADD CONSTRAINT `event_achat_ibfk_1` FOREIGN KEY (`fk_utilisateur`) REFERENCES `utilisateur` (`login`) ON DELETE CASCADE;

DELIMITER $$
--
-- Événements
--
CREATE DEFINER=`root`@`localhost` EVENT `INTERNET_EVT` ON SCHEDULE EVERY 1 MONTH STARTS '2013-10-07 00:00:00' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Facture internet sosh mensuel, Rouillé' DO INSERT INTO `collocataire`.achat (prix,commentaire,fk_utilisateur,date,auto) VALUES('20','Facture internet sosh mensuel, Rouillé','clement',CURDATE(),'1')$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;