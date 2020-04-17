-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 02. Apr 2020 um 19:55
-- Server-Version: 10.3.16-MariaDB
-- PHP-Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `poker`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `players`
--

CREATE TABLE `players` (
                           `id` int(11) NOT NULL,
                           `authentication_id` char(64) NOT NULL,
                           `name` text NOT NULL,
                           `session_id` int(11) NOT NULL,
                           `card1` char(3) NOT NULL,
                           `card2` char(3) NOT NULL,
                           `money` int(11) NOT NULL,
                           `current_bet` int(11) NOT NULL,
                           `total_bet` int(11) NOT NULL,
                           `state` tinyint NOT NULL,
                           `is_updated` tinyint(1) NOT NULL,
                           `last_update` int(11) NOT NULL,
                           `time_since_turn` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sessions`
--

CREATE TABLE `sessions` (
                            `id` int(11) NOT NULL,
                            `global_id` char(64) NOT NULL,
                            `name` text NOT NULL,
                            `start_money` int(11) NOT NULL,
                            `start_date` int(11) NOT NULL,
                            `card1` char(3) NOT NULL,
                            `card2` char(3) NOT NULL,
                            `card3` char(3) NOT NULL,
                            `card4` char(3) NOT NULL,
                            `card5` char(3) NOT NULL,
                            `state` tinyint(4) NOT NULL,
                            `round` tinyint(4) NOT NULL,
                            `pot` int(11) NOT NULL,
                            `dealer` int(11) NOT NULL,
                            `player_last_raised` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `players`
--
ALTER TABLE `players`
    ADD PRIMARY KEY (`id`),
    ADD KEY `foreign key` (`session_id`) USING BTREE;

--
-- Indizes für die Tabelle `sessions`
--
ALTER TABLE `sessions`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `unique` (`global_id`) USING BTREE;

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `players`
--
ALTER TABLE `players`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `sessions`
--
ALTER TABLE `sessions`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `players`
--
ALTER TABLE `players`
    ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
