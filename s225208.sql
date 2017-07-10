-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 22, 2017 alle 20:23
-- Versione del server: 10.1.21-MariaDB
-- Versione PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auctions`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

DROP TABLE IF EXISTS `utenti`;
CREATE TABLE `utenti` (
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `THR` double DEFAULT '1',
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`email`, `password`, `THR`, `time_stamp`) VALUES
('a@p.it', 'ec6ef230f1828039ee794566b9c58adc', 1, '2017-06-22 18:23:17'),
('b@p.it', '1d665b9b1467944c128a5575119d1cfd', 1, '2017-06-22 18:23:17'),
('c@p.it', '7bc3ca68769437ce986455407dab2a1f', 1, '2017-06-22 18:18:15');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`email`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
