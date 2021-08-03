-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Gru 2020, 10:56
-- Wersja serwera: 10.4.14-MariaDB
-- Wersja PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `przychodnia`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lekarze`
--

CREATE TABLE `lekarze` (
  `id` int(11) NOT NULL,
  `imie` text COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` text COLLATE utf8_polish_ci NOT NULL,
  `specjalizacja` text COLLATE utf8_polish_ci NOT NULL,
  `numer_gabinetu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `lekarze`
--

INSERT INTO `lekarze` (`id`, `imie`, `nazwisko`, `specjalizacja`, `numer_gabinetu`) VALUES
(1, 'Paweł', 'Pawłowski', 'Ginekolog', 69),
(5, 'Anna', 'Oczodołna', 'Okulista', 666),
(6, 'Roman', 'Lubny', 'Kolanoskopczyk', 101),
(7, 'Adam', 'Kleks', 'Dematolog', 109);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pacjenci`
--

CREATE TABLE `pacjenci` (
  `id` int(11) NOT NULL,
  `imie` text COLLATE utf8_polish_ci NOT NULL,
  `Nazwisko` text COLLATE utf8_polish_ci NOT NULL,
  `data_urodzenia` date NOT NULL,
  `Pesel` varchar(11) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pacjenci`
--

INSERT INTO `pacjenci` (`id`, `imie`, `Nazwisko`, `data_urodzenia`, `Pesel`) VALUES
(1, 'Ryszard', 'Witkowski', '1974-02-18', '74021800554'),
(12, 'Rafał', 'Tuturutrtutu', '1988-01-05', '88010500285'),
(13, 'Andrzej', 'Pita', '1889-08-09', '89080900254');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `user` text COLLATE utf8_polish_ci NOT NULL,
  `pass` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `user`, `pass`, `email`) VALUES
(1, 'adam', '$2y$10$kVzjxTcAw2onb/DRmv2qaOyU0AW/SSji9aWUzdZUw7BCiNa8QquTu', 'adam@gmail.com'),
(19, 'Admin', '$2y$10$5LuCV0lpMVrrPolRuofaCefDyWsUxklPShJUfig/Za8HnXNqTgJFe', 'admin@admin.com'),
(20, 'Anna', '$2y$10$HbIZ8iW3SlfLUCieSCoJs.5BuNIJdnMRalUdaU/UMJ0iAclNAcHp2', 'anna@gmail.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wizyta`
--

CREATE TABLE `wizyta` (
  `id_wizyta` int(11) NOT NULL,
  `data` date NOT NULL,
  `godzina` time NOT NULL,
  `lekarz` text COLLATE utf8_polish_ci NOT NULL,
  `opis` text COLLATE utf8_polish_ci NOT NULL,
  `stan` text COLLATE utf8_polish_ci NOT NULL DEFAULT 'Nie zatwierdzono'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `wizyta`
--

INSERT INTO `wizyta` (`id_wizyta`, `data`, `godzina`, `lekarz`, `opis`, `stan`) VALUES
(6, '2020-12-18', '05:55:00', 'Roman Lubny Kolanoskopczyk', 'Boli dupa', 'Zatwierdzono'),
(7, '2020-12-09', '15:00:00', 'Adam Kleks Dematolog', 'Wysypka skórna', 'Zatwierdzono');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `lekarze`
--
ALTER TABLE `lekarze`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `pacjenci`
--
ALTER TABLE `pacjenci`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indeksy dla tabeli `wizyta`
--
ALTER TABLE `wizyta`
  ADD PRIMARY KEY (`id_wizyta`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `lekarze`
--
ALTER TABLE `lekarze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `pacjenci`
--
ALTER TABLE `pacjenci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT dla tabeli `wizyta`
--
ALTER TABLE `wizyta`
  MODIFY `id_wizyta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
