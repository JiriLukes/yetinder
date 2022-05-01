-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Ned 01. kvě 2022, 23:24
-- Verze serveru: 10.4.24-MariaDB
-- Verze PHP: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Databáze: `yetinder`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `rating`
--

CREATE TABLE `rating` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idyeti` int(11) NOT NULL,
  `rdate` date NOT NULL,
  `rval` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `rating`
--

INSERT INTO `rating` (`id`, `idyeti`, `rdate`, `rval`) VALUES
(1, 9, '2022-04-27', 2),
(2, 9, '2022-04-27', 2),
(3, 9, '2022-04-27', 2),
(4, 7, '2022-04-27', 5),
(5, 2, '2022-04-27', 4),
(6, 5, '2022-04-27', 3),
(7, 11, '2022-04-27', 1),
(8, 10, '2022-04-27', 4),
(9, 3, '2022-04-27', 2),
(10, 7, '2022-04-27', 2),
(11, 7, '2022-04-27', 2),
(12, 13, '2022-04-27', 4),
(13, 3, '2022-04-27', 3),
(14, 3, '2022-04-27', 3),
(15, 3, '2022-04-28', 2),
(16, 3, '2022-04-28', 2),
(17, 3, '2022-04-28', 3),
(18, 3, '2022-04-28', 2),
(19, 3, '2022-04-28', 4),
(20, 3, '2022-04-28', 5),
(21, 3, '2022-04-28', 1),
(22, 3, '2022-04-28', 3),
(23, 3, '2022-04-28', 4),
(24, 3, '2022-04-28', 5),
(25, 5, '2022-04-28', 1),
(26, 12, '2022-04-28', 2),
(27, 6, '2022-04-28', 4),
(28, 6, '2022-04-28', 1),
(29, 7, '2022-04-28', 2),
(30, 10, '2022-04-28', 1),
(31, 10, '2022-04-28', 2),
(32, 10, '2022-04-28', 4),
(33, 8, '2022-04-28', 2),
(34, 1, '2022-04-28', 5),
(35, 1, '2022-04-28', 4),
(36, 19, '2022-04-29', 2),
(37, 19, '2022-04-29', 3),
(38, 19, '2022-04-29', 3),
(39, 19, '2022-04-29', 3),
(40, 13, '2022-04-29', 3),
(41, 9, '2022-04-30', 1),
(42, 10, '2022-04-30', 2),
(43, 10, '2022-05-01', 4),
(44, 3, '2022-05-01', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `yeti`
--

CREATE TABLE `yeti` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `height` float DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `yeti`
--

INSERT INTO `yeti` (`id`, `name`, `photo`, `rating`, `description`, `height`, `weight`, `address`) VALUES
(1, 'Tod', '00.jpg', 4.5, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 1.2, 20, 'Strážné'),
(2, 'Mike', '01.jpg', 4, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 0.8, 15, 'Pec pod Sněžkou'),
(3, 'Hoodie', '02.jpg', 2.8571, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 2, 40, 'Benecko'),
(4, 'Sid', '03.jpg', 0, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 0.5, 18, 'Špindlerův Mlýn'),
(5, 'Brian', '10.jpg', 2, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 0.76, 22, 'Jánské Lázně'),
(6, 'Celia', '11.jpg', 2.5, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 2.5, 70, 'Harrachov'),
(7, 'Lootie', '12.jpg', 2.75, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 1.6, 20, 'Rokytnice'),
(8, 'Eggbert', '13.jpg', 2, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 1.1, 30, 'Maršov'),
(9, 'Lou', '20.jpg', 1.75, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 0.6, 22, 'Malá Úpa'),
(10, 'Flint', '21.jpg', 2.8333, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 1.6, 50, 'Rezek'),
(11, 'Kitty', '22.jpg', 1, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 0.4, 11, 'Vítkovice'),
(12, 'Blocky', '30.jpg', 2, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 1.8, 80, 'Vrchlabí'),
(13, 'Rolf', '31.jpg', 3.5, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 0.9, 30, 'Lánov');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `rating`
--
ALTER TABLE `rating`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexy pro tabulku `yeti`
--
ALTER TABLE `yeti`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `rating`
--
ALTER TABLE `rating`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pro tabulku `yeti`
--
ALTER TABLE `yeti`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;
