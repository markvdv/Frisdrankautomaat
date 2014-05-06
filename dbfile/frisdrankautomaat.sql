-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Genereertijd: 06 mei 2014 om 11:47
-- Serverversie: 5.6.14
-- PHP-versie: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `frisdrankautomaat`
--
CREATE DATABASE IF NOT EXISTS `frisdrankautomaat` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `frisdrankautomaat`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(30) NOT NULL,
  `password` char(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Gegevens worden uitgevoerd voor tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `frisdrank`
--

CREATE TABLE IF NOT EXISTS `frisdrank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` char(15) NOT NULL,
  `aantal` int(2) NOT NULL,
  `prijs` int(3) NOT NULL DEFAULT '60',
  `coords` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Gegevens worden uitgevoerd voor tabel `frisdrank`
--

INSERT INTO `frisdrank` (`id`, `type`, `aantal`, `prijs`, `coords`) VALUES
(1, 'Coca Cola1', 18, 60, '395,230,420,240'),
(2, 'Coca Cola2', 15, 60, '395,242,420,252'),
(3, 'Cola Light', 19, 60, '395,254,420,264'),
(4, 'Sprite', 20, 60, '395,266,420,276'),
(5, 'Fanta Orange', 20, 80, '395,278,420,288'),
(6, 'Fanta Green', 20, 120, '395,290,420,300');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `munt`
--

CREATE TABLE IF NOT EXISTS `munt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `waarde` int(3) NOT NULL,
  `aantal` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=201 ;

--
-- Gegevens worden uitgevoerd voor tabel `munt`
--

INSERT INTO `munt` (`id`, `waarde`, `aantal`) VALUES
(10, 10, 10),
(20, 20, 6),
(50, 50, 10),
(100, 100, 8),
(200, 200, 10);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
