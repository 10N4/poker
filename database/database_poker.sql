-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `database_poker`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `games`
--

CREATE TABLE `games` (
  `ID` int(11) NOT NULL,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `startdate` date NOT NULL,
  `card1` char(3) NOT NULL,
  `card2` char(3) NOT NULL,
  `card3` char(3) NOT NULL,
  `card4` char(3) NOT NULL,
  `card5` char(3) NOT NULL,
  `gamestate` int(11) NOT NULL,
  `start_money` int(11) NOT NULL,
  `pot` int(11) NOT NULL,
  `small_blind` int(11) NOT NULL,
  `player_last_raised` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `players`
--

CREATE TABLE `players` (
  `ID` int(11) NOT NULL,
  `name` text NOT NULL,
  `game_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_paused` tinyint(1) NOT NULL,
  `cookie_id` varchar(32) NOT NULL,
  `card1` varchar(3) NOT NULL,
  `card2` varchar(3) NOT NULL,
  `money` int(11) NOT NULL,
  `current_bet` int(11) NOT NULL,
  `total_bet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `game_id` (`game_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `games`
--
ALTER TABLE `games`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `players`
--
ALTER TABLE `players`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
