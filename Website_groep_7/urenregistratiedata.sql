-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 21 jun 2023 om 14:31
-- Serverversie: 10.4.27-MariaDB
-- PHP-versie: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `urenregistratiedata`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `ID` int(11) NOT NULL,
  `gebruikersnaam` varchar(50) NOT NULL,
  `wachtwoord` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `Voornaam` varchar(50) NOT NULL,
  `Tussenvoegsel` varchar(10) NOT NULL,
  `Achternaam` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`ID`, `gebruikersnaam`, `wachtwoord`, `email`, `Voornaam`, `Tussenvoegsel`, `Achternaam`) VALUES
(26, 'TinoGilde', 'tino2005', 'tino.changoe@student.gildeopleidingen.nl', 'Tino', '', 'Changoe'),
(27, 'hamza', '1234', 'hamzasheikdon4@gmail.com', 'Hamza', '', 'Sheikdon'),
(29, 'Admin', 'Gilde123', 'tino.changoe@student.gildeopleidingen.nl', 'Admin', '', ''),
(30, 'finngilde', 'finnagang', 'hamzasheikdon4@gmail.com', 'finn', '', 'swaghoven'),
(31, 'AdrianJapierdoleBV', 'adrian', 'Adrian.Krupa@Student.GildeOpleidingen.nl', 'Adrian', '', 'Krupa'),
(32, 'test', 'test123', 'hamzasheikdon4@gmail.com', '4', 'g', 'swaghoven'),
(34, 'fwfw', 'dwadwa', 'fwfw@gmail.com', 'wffwf', 'fwfw', 'fwfw');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `medewerkers`
--

CREATE TABLE `medewerkers` (
  `ID` int(11) NOT NULL,
  `Voornaam` varchar(20) NOT NULL,
  `Achternaam` varchar(20) NOT NULL,
  `Tussenvoegsel` varchar(20) NOT NULL,
  `Functie` varchar(20) NOT NULL,
  `StartDatum` date NOT NULL,
  `EindDatum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `medewerkers`
--

INSERT INTO `medewerkers` (`ID`, `Voornaam`, `Achternaam`, `Tussenvoegsel`, `Functie`, `StartDatum`, `EindDatum`) VALUES
(2, 'wffwf', 'fwfw', 'fwfw', '', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `projecten`
--

CREATE TABLE `projecten` (
  `ID` int(11) NOT NULL,
  `projectNaam` varchar(50) NOT NULL,
  `startDatum` date NOT NULL,
  `Einddatum` date NOT NULL,
  `Informatie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `urenreg`
--

CREATE TABLE `urenreg` (
  `OV_Nummer` varchar(100) NOT NULL,
  `Voornaam` varchar(50) NOT NULL,
  `Achternaam` varchar(50) NOT NULL,
  `Tussenvoegsel` text NOT NULL,
  `projectdatum` date NOT NULL,
  `Uren` int(100) NOT NULL,
  `Projectnummer` int(100) NOT NULL,
  `Projectnaam` varchar(100) NOT NULL,
  `Werkzaamheden` text NOT NULL,
  `ID` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `urenreg`
--

INSERT INTO `urenreg` (`OV_Nummer`, `Voornaam`, `Achternaam`, `Tussenvoegsel`, `projectdatum`, `Uren`, `Projectnummer`, `Projectnaam`, `Werkzaamheden`, `ID`) VALUES
('0', 'Igor', 'Laska', '', '2004-07-17', 3, 1, 'PHP', 'navbars afgemaakt + alle paginas werken met nav', 3),
('0', 'Igor', 'Laska', '', '2004-07-17', 3, 1, 'PHP', 'base van sitestructuur is af, begin aan uitzoeken voor project', 4),
('0', 'Igor', 'Laska', '', '2004-07-17', 3, 1, 'PHP', 'Achtergronden af + besproken hoe en wat met PO', 5),
('0', 'Igor', 'Laska', '', '2004-07-17', 3, 1, 'PHP', 'veel informatie oopgezocht en de base voor html pages af', 6),
('0', 'Igor', 'Laska', '', '2004-07-17', 3, 1, 'PHP', 'urenreg container gemaakt', 7),
('0', 'Igor', 'Laska', '', '2004-07-17', 3, 1, 'PHP', 'een database gemaakt voor urenreg', 8),
('0', 'Igor', 'Laska', '', '2004-07-17', 3, 1, 'PHP', 'een database gemaakt voor urenreg', 9),
('0', 'Igor', 'Laska', '', '2004-07-17', 3, 1, 'PHP', 'een connectie proberen aan te maken aan de database', 10),
('0', 'Igor', 'Laska', '', '2004-07-17', 3, 1, 'PHP', 'connectie werkend + inputs gemaakt voor invoer werkend', 11),
('0', 'Igor', 'Laska', '', '2004-07-17', 3, 1, 'PHP', 'informatie opgezocht hoe je info kan displayen in (html table)', 12),
('0', 'Igor', 'Laska', '', '2004-07-17', 3, 1, 'PHP', 'informatie opgezocht hoe je info kan displayen in (html table)', 13),
('0', 'Igor', 'Laska', '', '2004-07-17', 3, 1, 'PHP', 'een connectie proberen aan te maken voor de tabel', 14),
('0', 'Dilano', 'Jenneskens', '', '0001-01-01', 3, 2, 'Server', 'trello samengesteld en een start gemaakt aan userstory 1 | 3 uur', 15),
('0', 'Dilano', 'Jenneskens', '', '0001-01-01', 3, 2, 'Server', 'onderzocht wat nodig was voor userstory 1 en verder gewerkt eraan | 3 uur', 16),
('0', 'Dilano', 'Jenneskens', '', '0001-01-01', 3, 2, 'Server', 'deels geholpen met de startpagina en algemene kennis ophalen | 2,5 uur', 17),
('0', 'Dilano', 'Jenneskens', '', '0001-01-01', 3, 2, 'Server', 'Vsphere opgezet en bezig aan de tweede virtual machine | 3 uur', 18),
('0', 'Dilano', 'Jenneskens', '', '0001-01-01', 3, 2, 'Server', 'Vsphere debuggen, man dit is vervelend om mee om te gaan | 3 uur', 19),
('0', 'Dilano', 'Jenneskens', '', '0001-01-01', 3, 2, 'Server', 'Progressie op de Vsphere client, nu nog een ISO erop zetten | 2,5 uur', 20),
('0', 'Dilano', 'Jenneskens', '', '0001-01-01', 3, 2, 'Server', 'Vsphere client werkt, ben nu bezig met een apache server | 2,5 uur', 21),
('0', 'Dilano', 'Jenneskens', '', '0001-01-01', 3, 2, 'Server', 'apache server staat ingesteld, nu nog een php integratie toevoegen | 3 uur', 22),
('0', 'Dilano', 'Jenneskens', '', '0001-01-01', 3, 2, 'Server', 'ben letterlijk de hele dag bezig geweest met info opzoeken over php integratie, maar heb nog niks gevonden | 3 uur', 23),
('0', 'Dilano', 'Jenneskens', '', '0001-01-01', 3, 2, 'Server', 'heb gevonden hoe ik de php integratie werkend kan maken, daar ben ik nu mee bezig | 3 uur', 24),
('0', 'Sten', 'Hendrikx', '', '2005-02-13', 3, 1, 'PHP', 'Folder aanmaken, trello aanmaken en starten met html. 3u', 25),
('0', 'Sten', 'Hendrikx', '', '2005-05-13', 3, 1, 'PHP', 'Tutorials bekijken, css toevoegen aan html bestand. 3u', 26),
('0', 'Sten', 'Hendrikx', '', '2005-05-13', 3, 1, 'PHP', 'Focussen op css, taskbar maken met popups. 3u', 28),
('0', 'Sten', 'Hendrikx', '', '2005-05-13', 3, 1, 'PHP', 'Verder aan html en css. 3u', 29),
('0', 'Sten', 'Hendrikx', '', '2005-05-13', 3, 1, 'PHP', 'Tweede taskbaar aangemaakt, menu scherm en dingen verbetert. 3u', 30),
('0', 'Sten', 'Hendrikx', '', '2005-02-15', 3, 1, 'PHP', 'Online gewerkt. 3u', 31),
('0', 'Sten', 'Hendrikx', '', '2005-02-13', 3, 1, 'PHP', 'Pagina verbeterd, overleg gehad. 3u', 32),
('0', 'Sten', 'Hendrikx', '', '2005-02-13', 3, 1, 'PHP', 'Gepraat met Remzi over de site samen met Igor, afspraken gemaakt. 3u', 33),
('0', 'Sten', 'Hendrikx', '', '2005-02-13', 3, 1, 'PHP', 'Besproken met de groep over wat we gaan inleveren. 3u', 34),
('0', 'Sten', 'Hendrikx', '', '2005-02-13', 3, 1, 'PHP', 'Online gewerkt. 3u', 35),
('0', 'Sten', 'Hendrikx', '', '2005-02-13', 3, 1, 'PHP', 'Gekeken naar het PHP gedeelte, alvast een MyAdmin aangemaakt. 3u', 36),
('0', 'Sten', 'Hendrikx', '', '2005-02-13', 3, 1, 'PHP', 'Online gewerkt. 3u', 37),
('0', 'Sten', 'Hendrikx', '', '2005-02-13', 3, 1, 'PHP', 'Php videos gekeken. 3u		', 38),
('0', 'Sten', 'Hendrikx', '', '2005-02-13', 3, 1, 'PHP', 'Online gewerkt. 3u		', 39),
('0', 'Sten', 'Hendrikx', '', '2005-02-13', 3, 1, 'PHP', 'online gewerkt. 3u', 40),
('0', 'Sten', 'Hendrikx', '', '2005-02-13', 3, 1, 'PHP', '15/03/23	 Pop ups en redirects gemaakt. 3u', 41),
('26', 'Tino ', 'Changoe ', '', '2023-05-03', 10, 5, 'PHP', 'werken', 50),
('26', 'Tino ', 'Changoe', '', '2023-05-04', 6, 5, 'Database', 'werken', 52),
('26', 'Tino ', 'Changoe', '', '2023-05-03', 2, 3, 'Website', 'werken', 116),
('26', 'Tino ', 'Changoe', '', '2023-05-04', 2, 3, 'Website', 'werken', 124),
('26', 'Tino ', 'Changoe', '', '2023-05-04', 2, 3, 'Website', 'werken', 126),
('26', 'Tino ', 'Changoe', '', '2023-05-04', 2, 3, 'Website', 'werken', 127),
('26', 'Tino ', 'Changoe', '', '2023-05-12', 1, 2, 'PHP', 'werken', 129),
('26', 'Tino ', 'Changoe', '', '2023-05-11', 6, 5, 'Website', 'werken', 130),
('26', 'Tino ', 'Changoe', '', '2023-05-10', 4, 5, 'Website', 'werken', 131),
('26', 'Tino ', 'Changoe', '', '2023-05-10', 3, 4, 'Website', 'werken', 132),
('26', 'Tino ', 'Changoe', '', '2023-05-04', 3, 4, 'Website', 'werken', 133),
('26', 'Tino ', 'Changoe', '', '2023-05-04', 5, 3, 'Website', 'werken', 134),
('26', 'Tino ', 'Changoe', '', '2023-05-11', 2, 65, 'Website', 'werken', 135),
('26', 'Tino ', 'Changoe', '', '2023-05-03', 2, 3, 'Website', 'werken', 136),
('26', 'Tino ', 'Changoe', '', '2023-05-05', 3, 4, 'Website', 'werken', 137),
('30', 'finn ', 'swaghoven ', '', '2023-05-10', 22, 33, 'PHP', 'werken', 138),
('30', 'finn ', 'swaghoven ', '', '2023-05-04', 22, 100, 'Server', 'hamzagang', 139),
('26', 'Tino ', 'Changoe', '', '2023-05-04', 10, 2, 'Website', 'werken', 140),
('26', 'Tino ', 'Changoe', '', '2023-05-10', 24, 7, 'PHP', 'werken', 141),
('26', 'Tino ', 'Changoe', '', '2023-05-03', 2, 3, 'Website', 'werken', 142),
('26', 'Tino ', 'Changoe', '', '2023-05-31', 6, 3, 'Website', 'werken', 143),
('26', 'Tino ', 'Changoe', '', '2023-05-31', 2, 3, 'Database', 'werken', 144),
('26', 'Tino ', 'Changoe', '', '2023-05-31', 4, 3, 'Server', 'werken', 145),
('26', 'Tino ', 'Changoe', '', '2023-06-08', 2, 2, 'Server', 'werken', 146),
('26', 'Tino ', 'Changoe', '', '2023-06-01', 2, 3, 'Website', 'werken', 147),
('26', 'Tino ', 'Changoe', '', '2023-06-01', 2, 2, 'Website', 'werken', 148),
('26', 'Tino ', 'Changoe', '', '2023-05-30', 6, 3, 'Website', 'werken', 149),
('26', 'Tino ', 'Changoe', '', '2023-05-30', 6, 3, 'Website', 'werken', 150),
('26', 'Tino ', 'Changoe', '', '2023-05-30', 6, 3, 'Website', 'werken', 151),
('26', 'Tino ', 'Changoe', '', '2023-05-30', 6, 3, 'Website', 'werken', 152),
('26', 'Tino ', 'Changoe', '', '2023-05-30', 6, 3, 'Website', 'werken', 153),
('26', 'Tino ', 'Changoe', '', '2023-05-30', 6, 3, 'Website', 'werken', 154),
('26', 'Tino ', 'Changoe', '', '2023-05-30', 6, 3, 'Website', 'werken', 155);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `gebruikersnaam` (`gebruikersnaam`);

--
-- Indexen voor tabel `medewerkers`
--
ALTER TABLE `medewerkers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `projecten`
--
ALTER TABLE `projecten`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `urenreg`
--
ALTER TABLE `urenreg`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT voor een tabel `medewerkers`
--
ALTER TABLE `medewerkers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `projecten`
--
ALTER TABLE `projecten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `urenreg`
--
ALTER TABLE `urenreg`
  MODIFY `ID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
