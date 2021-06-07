-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 07-06-2021 a las 12:25:45
-- Versión del servidor: 10.0.28-MariaDB-2+b1
-- Versión de PHP: 7.3.27-1~deb10u1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `complucine`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(15) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `admin`:
--   `id`
--       `users` -> `id`
--

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`) VALUES
(0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cinema`
--

CREATE TABLE `cinema` (
  `id` int(15) UNSIGNED NOT NULL,
  `name` varchar(10) NOT NULL,
  `direction` varchar(120) NOT NULL,
  `phone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `cinema`:
--

--
-- Volcado de datos para la tabla `cinema`
--

INSERT INTO `cinema` (`id`, `name`, `direction`, `phone`) VALUES
(1, 'Cinema 1st', 'Calle de ejemplo 111', '77777777'),
(3, 'Cinema 2st', 'Calle falsa 123', '123456789'),
(6, 'Cinema 3st', 'Calle falsa 456', '987654321'),
(7, 'Cinema 4st', 'Calle falsa 789', '222222222');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `film`
--

CREATE TABLE `film` (
  `id` int(15) UNSIGNED NOT NULL,
  `tittle` varchar(60) NOT NULL,
  `duration` int(3) UNSIGNED NOT NULL,
  `language` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `img` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `film`:
--

--
-- Volcado de datos para la tabla `film`
--

INSERT INTO `film` (`id`, `tittle`, `duration`, `language`, `description`, `img`) VALUES
(1, 'iron_man', 120, 'Español', 'Un empresario millonario construye un traje blindado y lo usa para combatir el crimen y el terrorismo.', 'iron_man.jpg'),
(2, 'iron_man_2', 120, 'Español', 'Con el mundo ahora consciente de que él es Iron Man, el millonario inventor Tony Stark debe forjar nuevas alianzas y confrontar a un enemigo nuevo y poderoso.', 'iron_man_2.jpg'),
(3, 'iron_man_3', 120, 'Español', 'El descarado y brillante Tony Stark, tras ver destruido todo su universo personal, debe encontrar y enfrentarse a un enemigo cuyo poder no conoce límites. Este viaje pondrá a prueba su entereza una y otra vez, y le obligará a confiar en su ingenio.', 'iron_man_3.jpg'),
(4, 'capitan_america_el_primer_vengador', 120, 'Español', 'Tras tres meses de someterse a un programa de entrenamiento físico y táctico, encomiendan a Steve Rogers su primera misión como Capitán América. Armado con un escudo indestructible, emprende la guerra contra la perversa organización HYDRA.', 'capitan_america_el_primer_vengador.jpg'),
(5, 'capitan_america_el_soldado_de_invierno', 120, 'Español', 'Capitán América, Viuda Negra y un nuevo aliado, Falcon, se enfrentan a un enemigo inesperado mientras intentan exponer una conspiración que pone en riesgo al mundo.', 'capitan_america_el_soldado_de_invierno.jpg'),
(6, 'capitan_america_civil_war', 180, 'Español', 'Después de que otro incidente internacional, en el que se ven envueltos los Vengadores, produzca daños colaterales, la presión política obliga a poner en marcha un sistema para depurar responsabilidades.', 'capitan_america_civil_war.jpg'),
(7, 'marvel_avengers', 120, 'Español', 'El director de la Agencia SHIELD decide reclutar a un equipo para salvar al mundo de un desastre casi seguro cuando un enemigo inesperado surge como una gran amenaza para la seguridad mundial.', 'marvel_avengers.jpg'),
(8, 'avengers_age_of_ultron', 120, 'Español', 'Los Vengadores se reúnen de nuevo y juntan sus fuerzas con las de los recién llegados Quicksilver y Bruja Escarlata para luchar contra un robot maquiavélico llamado Ultrón, el cual Tony Stark creó con el fin de defender la paz, pero resultó defectuoso y ahora pretende exterminar a toda la humanidad.', 'avengers_age_of_ultron.jpg'),
(9, 'avengers_inifinity_war', 180, 'Español', 'Los superhéroes se alían para vencer al poderoso Thanos, el peor enemigo al que se han enfrentado. Si Thanos logra reunir las seis gemas del infinito: poder, tiempo, alma, realidad, mente y espacio, nadie podrá detenerlo.', 'avengers_inifinity_war.jpg'),
(10, 'avengers_end_game', 180, 'Español', 'Los Vengadores restantes deben encontrar una manera de recuperar a sus aliados para un enfrentamiento épico con Thanos, el malvado que diezmó el planeta y el universo.', 'avengers_end_game.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hall`
--

CREATE TABLE `hall` (
  `number` int(15) UNSIGNED NOT NULL,
  `idcinema` int(15) UNSIGNED NOT NULL,
  `numrows` int(3) NOT NULL,
  `numcolumns` int(3) NOT NULL,
  `total_seats` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `hall`:
--   `idcinema`
--       `cinema` -> `id`
--

--
-- Volcado de datos para la tabla `hall`
--

INSERT INTO `hall` (`number`, `idcinema`, `numrows`, `numcolumns`, `total_seats`) VALUES
(1, 1, 12, 8, 60),
(1, 3, 12, 8, 88),
(2, 1, 14, 8, 97),
(2, 3, 12, 8, 78);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `manager`
--

CREATE TABLE `manager` (
  `id` int(15) UNSIGNED NOT NULL,
  `idcinema` int(15) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `manager`:
--   `idcinema`
--       `cinema` -> `id`
--   `id`
--       `users` -> `id`
--

--
-- Volcado de datos para la tabla `manager`
--

INSERT INTO `manager` (`id`, `idcinema`) VALUES
(1, 1),
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promotion`
--

CREATE TABLE `promotion` (
  `id` int(15) UNSIGNED NOT NULL,
  `tittle` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `code` varchar(15) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `img` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `promotion`:
--

--
-- Volcado de datos para la tabla `promotion`
--

INSERT INTO `promotion` (`id`, `tittle`, `description`, `code`, `active`, `img`) VALUES
(1, 'Promo Palomitas', '3x2 en palomitas.', '0x00001A', 0, 'promo_palomitas.jpg'),
(4, 'Promo Vuelve', 'Promoción vuelve al cine.', '0x00002B', 1, 'promo_vuelve.jpg'),
(5, 'Promo Miercoles', 'Promoción de los miércoles.', '0x00003C', 0, 'promo_miercoles.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase`
--

CREATE TABLE `purchase` (
  `iduser` int(15) UNSIGNED NOT NULL,
  `idsession` int(15) UNSIGNED NOT NULL,
  `idhall` int(15) UNSIGNED NOT NULL,
  `idcinema` int(15) UNSIGNED NOT NULL,
  `numrow` int(3) UNSIGNED NOT NULL,
  `numcolum` int(3) UNSIGNED NOT NULL,
  `time_purchase` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `purchase`:
--   `idhall`
--       `seat` -> `idhall`
--   `idcinema`
--       `seat` -> `idcinema`
--   `numrow`
--       `seat` -> `numrow`
--   `numcolum`
--       `seat` -> `numcolum`
--   `idsession`
--       `session` -> `id`
--   `iduser`
--       `users` -> `id`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seat`
--

CREATE TABLE `seat` (
  `idhall` int(15) UNSIGNED NOT NULL,
  `idcinema` int(15) UNSIGNED NOT NULL,
  `numrow` int(3) UNSIGNED NOT NULL,
  `numcolum` int(3) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `seat`:
--   `idhall`
--       `hall` -> `number`
--   `idcinema`
--       `hall` -> `idcinema`
--

--
-- Volcado de datos para la tabla `seat`
--

INSERT INTO `seat` (`idhall`, `idcinema`, `numrow`, `numcolum`, `active`) VALUES
(1, 1, 1, 1, 0),
(1, 3, 1, 1, 0),
(1, 1, 1, 2, 0),
(1, 3, 1, 2, 0),
(1, 1, 1, 3, 0),
(1, 3, 1, 3, -1),
(1, 1, 1, 4, -1),
(1, 3, 1, 4, -1),
(1, 1, 1, 5, -1),
(1, 3, 1, 5, -1),
(1, 1, 1, 6, 0),
(1, 3, 1, 6, -1),
(1, 1, 1, 7, 0),
(1, 3, 1, 7, 0),
(1, 1, 1, 8, 0),
(1, 3, 1, 8, 0),
(1, 1, 2, 1, 0),
(1, 3, 2, 1, 0),
(1, 1, 2, 2, 0),
(1, 3, 2, 2, 0),
(1, 1, 2, 3, 0),
(1, 3, 2, 3, -1),
(1, 1, 2, 4, -1),
(1, 3, 2, 4, -1),
(1, 1, 2, 5, -1),
(1, 3, 2, 5, -1),
(1, 1, 2, 6, 0),
(1, 3, 2, 6, -1),
(1, 1, 2, 7, 0),
(1, 3, 2, 7, 0),
(1, 1, 2, 8, 0),
(1, 3, 2, 8, 0),
(1, 1, 3, 1, 0),
(1, 3, 3, 1, 0),
(1, 1, 3, 2, 0),
(1, 3, 3, 2, 0),
(1, 1, 3, 3, 0),
(1, 3, 3, 3, 0),
(1, 1, 3, 4, -1),
(1, 3, 3, 4, 0),
(1, 1, 3, 5, -1),
(1, 3, 3, 5, 0),
(1, 1, 3, 6, 0),
(1, 3, 3, 6, 0),
(1, 1, 3, 7, 0),
(1, 3, 3, 7, 0),
(1, 1, 3, 8, 0),
(1, 3, 3, 8, 0),
(1, 1, 4, 1, -1),
(1, 3, 4, 1, 0),
(1, 1, 4, 2, -1),
(1, 3, 4, 2, 0),
(1, 1, 4, 3, -1),
(1, 3, 4, 3, 0),
(1, 1, 4, 4, -1),
(1, 3, 4, 4, 0),
(1, 1, 4, 5, -1),
(1, 3, 4, 5, 0),
(1, 1, 4, 6, -1),
(1, 3, 4, 6, 0),
(1, 1, 4, 7, -1),
(1, 3, 4, 7, 0),
(1, 1, 4, 8, -1),
(1, 3, 4, 8, 0),
(1, 1, 5, 1, -1),
(1, 3, 5, 1, 0),
(1, 1, 5, 2, -1),
(1, 3, 5, 2, 0),
(1, 1, 5, 3, -1),
(1, 3, 5, 3, 0),
(1, 1, 5, 4, -1),
(1, 3, 5, 4, 0),
(1, 1, 5, 5, -1),
(1, 3, 5, 5, 0),
(1, 1, 5, 6, -1),
(1, 3, 5, 6, 0),
(1, 1, 5, 7, -1),
(1, 3, 5, 7, 0),
(1, 1, 5, 8, -1),
(1, 3, 5, 8, 0),
(1, 1, 6, 1, 0),
(1, 3, 6, 1, 0),
(1, 1, 6, 2, 0),
(1, 3, 6, 2, 0),
(1, 1, 6, 3, 0),
(1, 3, 6, 3, 0),
(1, 1, 6, 4, -1),
(1, 3, 6, 4, 0),
(1, 1, 6, 5, -1),
(1, 3, 6, 5, 0),
(1, 1, 6, 6, 0),
(1, 3, 6, 6, 0),
(1, 1, 6, 7, 0),
(1, 3, 6, 7, 0),
(1, 1, 6, 8, 0),
(1, 3, 6, 8, 0),
(1, 1, 7, 1, 0),
(1, 3, 7, 1, 0),
(1, 1, 7, 2, 0),
(1, 3, 7, 2, 0),
(1, 1, 7, 3, 0),
(1, 3, 7, 3, 0),
(1, 1, 7, 4, -1),
(1, 3, 7, 4, 0),
(1, 1, 7, 5, -1),
(1, 3, 7, 5, 0),
(1, 1, 7, 6, 0),
(1, 3, 7, 6, 0),
(1, 1, 7, 7, 0),
(1, 3, 7, 7, 0),
(1, 1, 7, 8, 0),
(1, 3, 7, 8, 0),
(1, 1, 8, 1, 0),
(1, 3, 8, 1, 0),
(1, 1, 8, 2, 0),
(1, 3, 8, 2, 0),
(1, 1, 8, 3, 0),
(1, 3, 8, 3, 0),
(1, 1, 8, 4, -1),
(1, 3, 8, 4, 0),
(1, 1, 8, 5, -1),
(1, 3, 8, 5, 0),
(1, 1, 8, 6, 0),
(1, 3, 8, 6, 0),
(1, 1, 8, 7, 0),
(1, 3, 8, 7, 0),
(1, 1, 8, 8, 0),
(1, 3, 8, 8, 0),
(1, 1, 9, 1, 0),
(1, 3, 9, 1, 0),
(1, 1, 9, 2, 0),
(1, 3, 9, 2, 0),
(1, 1, 9, 3, 0),
(1, 3, 9, 3, 0),
(1, 1, 9, 4, -1),
(1, 3, 9, 4, 0),
(1, 1, 9, 5, -1),
(1, 3, 9, 5, 0),
(1, 1, 9, 6, 0),
(1, 3, 9, 6, 0),
(1, 1, 9, 7, 0),
(1, 3, 9, 7, 0),
(1, 1, 9, 8, 0),
(1, 3, 9, 8, 0),
(1, 1, 10, 1, 0),
(1, 3, 10, 1, 0),
(1, 1, 10, 2, 0),
(1, 3, 10, 2, 0),
(1, 1, 10, 3, 0),
(1, 3, 10, 3, 0),
(1, 1, 10, 4, -1),
(1, 3, 10, 4, 0),
(1, 1, 10, 5, -1),
(1, 3, 10, 5, 0),
(1, 1, 10, 6, 0),
(1, 3, 10, 6, 0),
(1, 1, 10, 7, 0),
(1, 3, 10, 7, 0),
(1, 1, 10, 8, 0),
(1, 3, 10, 8, 0),
(1, 1, 11, 1, 0),
(1, 3, 11, 1, 0),
(1, 1, 11, 2, 0),
(1, 3, 11, 2, 0),
(1, 1, 11, 3, 0),
(1, 3, 11, 3, 0),
(1, 1, 11, 4, -1),
(1, 3, 11, 4, 0),
(1, 1, 11, 5, -1),
(1, 3, 11, 5, 0),
(1, 1, 11, 6, 0),
(1, 3, 11, 6, 0),
(1, 1, 11, 7, 0),
(1, 3, 11, 7, 0),
(1, 1, 11, 8, 0),
(1, 3, 11, 8, 0),
(1, 1, 12, 1, 0),
(1, 3, 12, 1, 0),
(1, 1, 12, 2, 0),
(1, 3, 12, 2, 0),
(1, 1, 12, 3, 0),
(1, 3, 12, 3, 0),
(1, 1, 12, 4, -1),
(1, 3, 12, 4, 0),
(1, 1, 12, 5, -1),
(1, 3, 12, 5, 0),
(1, 1, 12, 6, 0),
(1, 3, 12, 6, 0),
(1, 1, 12, 7, 0),
(1, 3, 12, 7, 0),
(1, 1, 12, 8, 0),
(1, 3, 12, 8, 0),
(2, 1, 1, 1, 1),
(2, 3, 1, 1, -1),
(2, 1, 1, 2, 1),
(2, 3, 1, 2, -1),
(2, 1, 1, 3, 1),
(2, 3, 1, 3, -1),
(2, 1, 1, 4, 1),
(2, 3, 1, 4, 0),
(2, 1, 1, 5, 1),
(2, 3, 1, 5, 0),
(2, 1, 1, 6, 1),
(2, 3, 1, 6, -1),
(2, 1, 1, 7, 1),
(2, 3, 1, 7, -1),
(2, 1, 1, 8, 1),
(2, 3, 1, 8, -1),
(2, 1, 2, 1, 1),
(2, 3, 2, 1, -1),
(2, 1, 2, 2, 1),
(2, 3, 2, 2, -1),
(2, 1, 2, 3, 1),
(2, 3, 2, 3, -1),
(2, 1, 2, 4, 1),
(2, 3, 2, 4, 0),
(2, 1, 2, 5, 1),
(2, 3, 2, 5, 0),
(2, 1, 2, 6, 1),
(2, 3, 2, 6, -1),
(2, 1, 2, 7, 1),
(2, 3, 2, 7, -1),
(2, 1, 2, 8, 1),
(2, 3, 2, 8, -1),
(2, 1, 3, 1, 1),
(2, 3, 3, 1, -1),
(2, 1, 3, 2, -1),
(2, 3, 3, 2, -1),
(2, 1, 3, 3, -1),
(2, 3, 3, 3, -1),
(2, 1, 3, 4, -1),
(2, 3, 3, 4, 0),
(2, 1, 3, 5, 1),
(2, 3, 3, 5, 0),
(2, 1, 3, 6, 1),
(2, 3, 3, 6, -1),
(2, 1, 3, 7, 1),
(2, 3, 3, 7, -1),
(2, 1, 3, 8, 1),
(2, 3, 3, 8, -1),
(2, 1, 4, 1, 1),
(2, 3, 4, 1, 0),
(2, 1, 4, 2, -1),
(2, 3, 4, 2, 0),
(2, 1, 4, 3, -1),
(2, 3, 4, 3, 0),
(2, 1, 4, 4, -1),
(2, 3, 4, 4, 0),
(2, 1, 4, 5, 1),
(2, 3, 4, 5, 0),
(2, 1, 4, 6, 1),
(2, 3, 4, 6, 0),
(2, 1, 4, 7, 1),
(2, 3, 4, 7, 0),
(2, 1, 4, 8, 1),
(2, 3, 4, 8, 0),
(2, 1, 5, 1, 1),
(2, 3, 5, 1, 0),
(2, 1, 5, 2, -1),
(2, 3, 5, 2, 0),
(2, 1, 5, 3, -1),
(2, 3, 5, 3, 0),
(2, 1, 5, 4, -1),
(2, 3, 5, 4, 0),
(2, 1, 5, 5, 1),
(2, 3, 5, 5, 0),
(2, 1, 5, 6, 1),
(2, 3, 5, 6, 0),
(2, 1, 5, 7, 1),
(2, 3, 5, 7, 0),
(2, 1, 5, 8, 1),
(2, 3, 5, 8, 0),
(2, 1, 6, 1, 1),
(2, 3, 6, 1, 0),
(2, 1, 6, 2, 1),
(2, 3, 6, 2, 0),
(2, 1, 6, 3, 1),
(2, 3, 6, 3, 0),
(2, 1, 6, 4, 1),
(2, 3, 6, 4, 0),
(2, 1, 6, 5, 1),
(2, 3, 6, 5, 0),
(2, 1, 6, 6, 1),
(2, 3, 6, 6, 0),
(2, 1, 6, 7, 1),
(2, 3, 6, 7, 0),
(2, 1, 6, 8, 1),
(2, 3, 6, 8, 0),
(2, 1, 7, 1, 1),
(2, 3, 7, 1, 0),
(2, 1, 7, 2, 1),
(2, 3, 7, 2, 0),
(2, 1, 7, 3, 1),
(2, 3, 7, 3, 0),
(2, 1, 7, 4, 1),
(2, 3, 7, 4, 0),
(2, 1, 7, 5, -1),
(2, 3, 7, 5, 0),
(2, 1, 7, 6, -1),
(2, 3, 7, 6, 0),
(2, 1, 7, 7, 1),
(2, 3, 7, 7, 0),
(2, 1, 7, 8, 1),
(2, 3, 7, 8, 0),
(2, 1, 8, 1, 1),
(2, 3, 8, 1, 0),
(2, 1, 8, 2, 1),
(2, 3, 8, 2, 0),
(2, 1, 8, 3, 1),
(2, 3, 8, 3, 0),
(2, 1, 8, 4, 1),
(2, 3, 8, 4, 0),
(2, 1, 8, 5, -1),
(2, 3, 8, 5, 0),
(2, 1, 8, 6, -1),
(2, 3, 8, 6, 0),
(2, 1, 8, 7, 1),
(2, 3, 8, 7, 0),
(2, 1, 8, 8, 1),
(2, 3, 8, 8, 0),
(2, 1, 9, 1, 1),
(2, 3, 9, 1, 0),
(2, 1, 9, 2, 1),
(2, 3, 9, 2, 0),
(2, 1, 9, 3, 1),
(2, 3, 9, 3, 0),
(2, 1, 9, 4, 1),
(2, 3, 9, 4, 0),
(2, 1, 9, 5, -1),
(2, 3, 9, 5, 0),
(2, 1, 9, 6, -1),
(2, 3, 9, 6, 0),
(2, 1, 9, 7, 1),
(2, 3, 9, 7, 0),
(2, 1, 9, 8, 1),
(2, 3, 9, 8, 0),
(2, 1, 10, 1, 1),
(2, 3, 10, 1, 0),
(2, 1, 10, 2, 1),
(2, 3, 10, 2, 0),
(2, 1, 10, 3, 1),
(2, 3, 10, 3, 0),
(2, 1, 10, 4, 1),
(2, 3, 10, 4, 0),
(2, 1, 10, 5, 1),
(2, 3, 10, 5, 0),
(2, 1, 10, 6, 1),
(2, 3, 10, 6, 0),
(2, 1, 10, 7, 1),
(2, 3, 10, 7, 0),
(2, 1, 10, 8, 1),
(2, 3, 10, 8, 0),
(2, 1, 11, 1, 1),
(2, 3, 11, 1, 0),
(2, 1, 11, 2, 1),
(2, 3, 11, 2, 0),
(2, 1, 11, 3, 1),
(2, 3, 11, 3, 0),
(2, 1, 11, 4, 1),
(2, 3, 11, 4, 0),
(2, 1, 11, 5, 1),
(2, 3, 11, 5, 0),
(2, 1, 11, 6, 1),
(2, 3, 11, 6, 0),
(2, 1, 11, 7, 1),
(2, 3, 11, 7, 0),
(2, 1, 11, 8, 1),
(2, 3, 11, 8, 0),
(2, 1, 12, 1, 1),
(2, 3, 12, 1, 0),
(2, 1, 12, 2, 1),
(2, 3, 12, 2, 0),
(2, 1, 12, 3, 1),
(2, 3, 12, 3, 0),
(2, 1, 12, 4, 1),
(2, 3, 12, 4, 0),
(2, 1, 12, 5, 1),
(2, 3, 12, 5, 0),
(2, 1, 12, 6, 1),
(2, 3, 12, 6, 0),
(2, 1, 12, 7, 1),
(2, 3, 12, 7, 0),
(2, 1, 12, 8, 1),
(2, 3, 12, 8, 0),
(2, 1, 13, 1, 1),
(2, 1, 13, 2, 1),
(2, 1, 13, 3, 1),
(2, 1, 13, 4, 1),
(2, 1, 13, 5, 1),
(2, 1, 13, 6, 1),
(2, 1, 13, 7, 1),
(2, 1, 13, 8, 1),
(2, 1, 14, 1, 1),
(2, 1, 14, 2, 1),
(2, 1, 14, 3, 1),
(2, 1, 14, 4, 1),
(2, 1, 14, 5, 1),
(2, 1, 14, 6, 1),
(2, 1, 14, 7, 1),
(2, 1, 14, 8, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `session`
--

CREATE TABLE `session` (
  `id` int(15) UNSIGNED NOT NULL,
  `idfilm` int(15) UNSIGNED NOT NULL,
  `idhall` int(15) UNSIGNED NOT NULL,
  `idcinema` int(15) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `seat_price` float NOT NULL,
  `format` varchar(20) NOT NULL,
  `seats_full` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `session`:
--   `idfilm`
--       `film` -> `id`
--   `idhall`
--       `hall` -> `number`
--   `idcinema`
--       `hall` -> `idcinema`
--

--
-- Volcado de datos para la tabla `session`
--

INSERT INTO `session` (`id`, `idfilm`, `idhall`, `idcinema`, `date`, `start_time`, `seat_price`, `format`, `seats_full`) VALUES
(19, 1, 2, 1, '2021-05-14', '19:00:00', 12, '2d', 0),
(20, 1, 2, 1, '2021-05-15', '19:00:00', 12, '2d', 0),
(21, 3, 1, 1, '2021-05-24', '15:00:00', 5, '2D', 0),
(22, 3, 1, 1, '2021-05-25', '15:00:00', 5, '2D', 0),
(23, 3, 1, 1, '2021-05-26', '15:00:00', 5, '2D', 0),
(24, 3, 1, 1, '2021-05-27', '15:00:00', 5, '2D', 0),
(25, 3, 1, 1, '2021-05-28', '15:00:00', 5, '2D', 0),
(26, 3, 1, 1, '2021-05-29', '15:00:00', 5, '2D', 0),
(27, 3, 1, 1, '2021-05-30', '15:00:00', 5, '2D', 0),
(28, 3, 1, 1, '2021-05-31', '15:00:00', 5, '2D', 0),
(29, 3, 1, 1, '2021-06-01', '15:00:00', 5, '2D', 0),
(30, 3, 1, 1, '2021-06-02', '15:00:00', 5, '2D', 0),
(31, 3, 1, 1, '2021-06-03', '15:00:00', 5, '2D', 0),
(32, 3, 1, 1, '2021-06-04', '15:00:00', 5, '2D', 0),
(33, 3, 1, 1, '2021-06-05', '15:00:00', 5, '2D', 0),
(34, 3, 1, 1, '2021-06-06', '15:00:00', 5, '2D', 0),
(35, 3, 1, 1, '2021-06-07', '15:00:00', 5, '2D', 0),
(36, 3, 1, 1, '2021-06-08', '15:00:00', 5, '2D', 0),
(37, 3, 1, 1, '2021-06-09', '15:00:00', 5, '2D', 0),
(38, 3, 1, 1, '2021-06-10', '15:00:00', 5, '2D', 0),
(39, 3, 1, 1, '2021-06-11', '15:00:00', 5, '2D', 0),
(40, 3, 1, 1, '2021-06-12', '15:00:00', 5, '2D', 0),
(41, 3, 1, 1, '2021-06-13', '15:00:00', 5, '2D', 0),
(42, 3, 1, 1, '2021-06-14', '15:00:00', 5, '2D', 0),
(43, 3, 1, 1, '2021-06-15', '15:00:00', 5, '2D', 0),
(44, 3, 1, 1, '2021-06-16', '15:00:00', 5, '2D', 0),
(45, 3, 1, 1, '2021-06-17', '15:00:00', 5, '2D', 0),
(46, 3, 1, 1, '2021-06-18', '15:00:00', 5, '2D', 0),
(47, 3, 1, 1, '2021-06-19', '15:00:00', 5, '2D', 0),
(48, 3, 1, 1, '2021-06-20', '15:00:00', 5, '2D', 0),
(49, 3, 1, 1, '2021-06-21', '15:00:00', 5, '2D', 0),
(50, 3, 1, 1, '2021-06-22', '15:00:00', 5, '2D', 0),
(51, 3, 1, 1, '2021-06-23', '15:00:00', 5, '2D', 0),
(52, 2, 1, 1, '2021-05-24', '14:00:00', 5, '3D', 0),
(53, 4, 1, 1, '2021-05-24', '16:00:00', 5, 'o.v.', 0),
(54, 4, 1, 1, '2021-05-25', '16:00:00', 5, 'o.v.', 0),
(55, 4, 1, 1, '2021-05-26', '16:00:00', 5, 'o.v.', 0),
(56, 4, 1, 1, '2021-05-27', '16:00:00', 5, 'o.v.', 0),
(57, 4, 1, 1, '2021-05-28', '16:00:00', 5, 'o.v.', 0),
(58, 4, 1, 1, '2021-05-29', '16:00:00', 5, 'o.v.', 0),
(59, 4, 1, 1, '2021-05-30', '16:00:00', 5, 'o.v.', 0),
(60, 4, 1, 1, '2021-05-31', '16:00:00', 5, 'o.v.', 0),
(61, 4, 1, 1, '2021-06-01', '16:00:00', 5, 'o.v.', 0),
(62, 4, 1, 1, '2021-06-02', '16:00:00', 5, 'o.v.', 0),
(63, 4, 1, 1, '2021-06-03', '16:00:00', 5, 'o.v.', 0),
(64, 4, 1, 1, '2021-06-04', '16:00:00', 5, 'o.v.', 0),
(65, 4, 1, 1, '2021-06-05', '16:00:00', 5, 'o.v.', 0),
(66, 4, 1, 1, '2021-06-06', '16:00:00', 5, 'o.v.', 0),
(67, 4, 1, 1, '2021-06-07', '16:00:00', 5, 'o.v.', 0),
(68, 4, 1, 1, '2021-06-08', '16:00:00', 5, 'o.v.', 0),
(69, 4, 1, 1, '2021-06-09', '16:00:00', 5, 'o.v.', 0),
(70, 4, 1, 1, '2021-06-10', '16:00:00', 5, 'o.v.', 0),
(71, 4, 1, 1, '2021-06-11', '16:00:00', 5, 'o.v.', 0),
(72, 4, 1, 1, '2021-06-12', '16:00:00', 5, 'o.v.', 0),
(73, 4, 1, 1, '2021-06-13', '16:00:00', 5, 'o.v.', 0),
(74, 4, 1, 1, '2021-06-14', '16:00:00', 5, 'o.v.', 0),
(75, 4, 1, 1, '2021-06-15', '16:00:00', 5, 'o.v.', 0),
(76, 4, 1, 1, '2021-06-16', '16:00:00', 5, 'o.v.', 0),
(77, 4, 1, 1, '2021-06-17', '16:00:00', 5, 'o.v.', 0),
(78, 4, 1, 1, '2021-06-18', '16:00:00', 5, 'o.v.', 0),
(79, 4, 1, 1, '2021-06-19', '16:00:00', 5, 'o.v.', 0),
(80, 4, 1, 1, '2021-06-20', '16:00:00', 5, 'o.v.', 0),
(81, 4, 1, 1, '2021-06-21', '16:00:00', 5, 'o.v.', 0),
(82, 4, 1, 1, '2021-06-22', '16:00:00', 5, 'o.v.', 0),
(83, 4, 1, 1, '2021-06-23', '16:00:00', 5, 'o.v.', 0),
(84, 7, 2, 1, '2021-05-24', '17:00:00', 3, 'o.v. con subtitulos', 0),
(85, 7, 2, 1, '2021-05-25', '17:00:00', 3, 'v.o. con subtitulos', 0),
(86, 7, 2, 1, '2021-05-26', '17:00:00', 3, 'v.o. con subtitulos', 0),
(87, 7, 2, 1, '2021-05-27', '17:00:00', 3, 'v.o. con subtitulos', 0),
(88, 7, 2, 1, '2021-05-28', '17:00:00', 3, 'v.o. con subtitulos', 0),
(89, 7, 2, 1, '2021-05-29', '17:00:00', 3, 'v.o. con subtitulos', 0),
(90, 7, 2, 1, '2021-05-30', '17:00:00', 3, 'v.o. con subtitulos', 0),
(91, 7, 2, 1, '2021-05-31', '17:00:00', 3, 'v.o. con subtitulos', 0),
(92, 7, 2, 1, '2021-06-01', '17:00:00', 3, 'v.o. con subtitulos', 0),
(93, 7, 2, 1, '2021-06-02', '17:00:00', 3, 'v.o. con subtitulos', 0),
(94, 7, 2, 1, '2021-06-03', '17:00:00', 3, 'v.o. con subtitulos', 0),
(95, 7, 2, 1, '2021-06-04', '17:00:00', 3, 'v.o. con subtitulos', 0),
(96, 7, 2, 1, '2021-06-05', '17:00:00', 3, 'v.o. con subtitulos', 0),
(97, 7, 2, 1, '2021-06-06', '17:00:00', 3, 'v.o. con subtitulos', 0),
(98, 7, 2, 1, '2021-06-07', '17:00:00', 3, 'v.o. con subtitulos', 0),
(99, 7, 2, 1, '2021-06-08', '17:00:00', 3, 'v.o. con subtitulos', 0),
(100, 7, 2, 1, '2021-06-09', '17:00:00', 3, 'v.o. con subtitulos', 0),
(101, 7, 2, 1, '2021-06-10', '17:00:00', 3, 'v.o. con subtitulos', 0),
(102, 7, 2, 1, '2021-06-11', '17:00:00', 3, 'v.o. con subtitulos', 0),
(103, 7, 2, 1, '2021-06-12', '17:00:00', 3, 'v.o. con subtitulos', 0),
(104, 7, 2, 1, '2021-06-13', '17:00:00', 3, 'v.o. con subtitulos', 0),
(105, 7, 2, 1, '2021-06-14', '17:00:00', 3, 'v.o. con subtitulos', 0),
(106, 7, 2, 1, '2021-06-15', '17:00:00', 3, 'v.o. con subtitulos', 0),
(107, 7, 2, 1, '2021-06-16', '17:00:00', 3, 'v.o. con subtitulos', 0),
(108, 7, 2, 1, '2021-06-17', '17:00:00', 3, 'v.o. con subtitulos', 0),
(109, 7, 2, 1, '2021-06-18', '17:00:00', 3, 'v.o. con subtitulos', 0),
(110, 7, 2, 1, '2021-06-19', '17:00:00', 3, 'v.o. con subtitulos', 0),
(111, 7, 2, 1, '2021-06-20', '17:00:00', 3, 'v.o. con subtitulos', 0),
(112, 7, 2, 1, '2021-06-21', '17:00:00', 3, 'v.o. con subtitulos', 0),
(113, 7, 2, 1, '2021-06-22', '17:00:00', 3, 'v.o. con subtitulos', 0),
(114, 7, 2, 1, '2021-06-23', '17:00:00', 3, 'v.o. con subtitulos', 0),
(115, 7, 2, 1, '2021-06-24', '17:00:00', 3, 'v.o. con subtitulos', 0),
(116, 10, 2, 1, '2021-05-24', '18:00:00', 9, 'estandar', 0),
(117, 10, 2, 1, '2021-05-25', '18:00:00', 9, 'estandar', 0),
(118, 10, 2, 1, '2021-05-26', '18:00:00', 9, 'estandar', 0),
(119, 10, 2, 1, '2021-05-27', '18:00:00', 9, 'estandar', 0),
(120, 10, 2, 1, '2021-05-28', '18:00:00', 9, 'estandar', 0),
(121, 10, 2, 1, '2021-05-29', '18:00:00', 9, 'estandar', 0),
(122, 10, 2, 1, '2021-05-30', '18:00:00', 9, 'estandar', 0),
(123, 10, 2, 1, '2021-05-31', '18:00:00', 9, 'estandar', 0),
(124, 10, 2, 1, '2021-06-01', '18:00:00', 9, 'estandar', 0),
(125, 10, 2, 1, '2021-06-02', '18:00:00', 9, 'estandar', 0),
(126, 10, 2, 1, '2021-06-03', '18:00:00', 9, 'estandar', 0),
(127, 10, 2, 1, '2021-06-04', '18:00:00', 9, 'estandar', 0),
(128, 10, 2, 1, '2021-06-05', '18:00:00', 9, 'estandar', 0),
(129, 10, 2, 1, '2021-06-06', '18:00:00', 9, 'estandar', 0),
(130, 10, 2, 1, '2021-06-07', '18:00:00', 9, 'estandar', 0),
(131, 10, 2, 1, '2021-06-08', '18:00:00', 9, 'estandar', 0),
(132, 10, 2, 1, '2021-06-09', '18:00:00', 9, 'estandar', 0),
(133, 10, 2, 1, '2021-06-10', '18:00:00', 9, 'estandar', 0),
(134, 10, 2, 1, '2021-06-11', '18:00:00', 9, 'estandar', 0),
(135, 10, 2, 1, '2021-06-12', '18:00:00', 9, 'estandar', 0),
(136, 10, 2, 1, '2021-06-13', '18:00:00', 9, 'estandar', 0),
(137, 10, 2, 1, '2021-06-14', '18:00:00', 9, 'estandar', 0),
(138, 10, 2, 1, '2021-06-15', '18:00:00', 9, 'estandar', 0),
(139, 10, 2, 1, '2021-06-16', '18:00:00', 9, 'estandar', 0),
(140, 10, 2, 1, '2021-06-17', '18:00:00', 9, 'estandar', 0),
(141, 10, 2, 1, '2021-06-18', '18:00:00', 9, 'estandar', 0),
(142, 10, 2, 1, '2021-06-19', '18:00:00', 9, 'estandar', 0),
(143, 10, 2, 1, '2021-06-20', '18:00:00', 9, 'estandar', 0),
(144, 10, 2, 1, '2021-06-21', '18:00:00', 9, 'estandar', 0),
(145, 10, 2, 1, '2021-06-22', '18:00:00', 9, 'estandar', 0),
(146, 10, 2, 1, '2021-06-23', '18:00:00', 9, 'estandar', 0),
(147, 10, 1, 3, '2021-06-02', '14:00:00', 3, 'estandar', 0),
(148, 10, 1, 3, '2021-06-03', '14:00:00', 3, 'estandar', 0),
(149, 10, 1, 3, '2021-06-04', '14:00:00', 3, 'estandar', 0),
(150, 10, 1, 3, '2021-06-05', '14:00:00', 3, 'estandar', 0),
(151, 10, 1, 3, '2021-06-06', '14:00:00', 3, 'estandar', 0),
(152, 10, 1, 3, '2021-06-07', '14:00:00', 3, 'estandar', 0),
(153, 10, 1, 3, '2021-06-08', '14:00:00', 3, 'estandar', 0),
(154, 10, 1, 3, '2021-06-09', '14:00:00', 3, 'estandar', 0),
(155, 10, 1, 3, '2021-06-10', '14:00:00', 3, 'estandar', 0),
(156, 10, 1, 3, '2021-06-11', '14:00:00', 3, 'estandar', 0),
(157, 10, 1, 3, '2021-06-12', '14:00:00', 3, 'estandar', 0),
(158, 7, 1, 3, '2021-06-02', '16:00:00', 3, '2D', 0),
(159, 7, 1, 3, '2021-06-03', '16:00:00', 3, '2D', 0),
(160, 7, 1, 3, '2021-06-04', '16:00:00', 3, '2D', 0),
(161, 7, 1, 3, '2021-06-05', '16:00:00', 3, '2D', 0),
(162, 7, 1, 3, '2021-06-06', '16:00:00', 3, '2D', 0),
(163, 7, 1, 3, '2021-06-07', '16:00:00', 3, '2D', 0),
(164, 7, 1, 3, '2021-06-08', '16:00:00', 3, '2D', 0),
(165, 7, 1, 3, '2021-06-09', '16:00:00', 3, '2D', 0),
(166, 7, 1, 3, '2021-06-10', '16:00:00', 3, '2D', 0),
(167, 7, 1, 3, '2021-06-11', '16:00:00', 3, '2D', 0),
(168, 7, 1, 3, '2021-06-12', '16:00:00', 3, '2D', 0),
(169, 6, 2, 3, '2021-06-02', '18:20:00', 2, '6', 0),
(170, 6, 2, 3, '2021-06-03', '18:20:00', 2, '6', 0),
(171, 6, 2, 3, '2021-06-04', '18:20:00', 2, '6', 0),
(172, 6, 2, 3, '2021-06-05', '18:20:00', 2, '6', 0),
(173, 6, 2, 3, '2021-06-06', '18:20:00', 2, '6', 0),
(174, 6, 2, 3, '2021-06-07', '18:20:00', 2, '6', 0),
(175, 6, 2, 3, '2021-06-08', '18:20:00', 2, '6', 0),
(176, 6, 2, 3, '2021-06-09', '18:20:00', 2, '6', 0),
(177, 6, 2, 3, '2021-06-10', '18:20:00', 2, '6', 0),
(178, 6, 2, 3, '2021-06-11', '18:20:00', 2, '6', 0),
(179, 6, 2, 3, '2021-06-12', '18:20:00', 2, '6', 0),
(180, 8, 2, 3, '2021-06-02', '07:00:00', 5, 'Version de Zack Snei', 0),
(181, 8, 2, 3, '2021-06-03', '07:00:00', 5, 'Version de Zack Snei', 0),
(182, 8, 2, 3, '2021-06-04', '07:00:00', 5, 'Version de Zack Snei', 0),
(183, 8, 2, 3, '2021-06-05', '07:00:00', 5, 'Version de Zack Snei', 0),
(184, 8, 2, 3, '2021-06-06', '07:00:00', 5, 'Version de Zack Snei', 0),
(185, 8, 2, 3, '2021-06-07', '07:00:00', 5, 'Version de Zack Snei', 0),
(186, 8, 2, 3, '2021-06-08', '07:00:00', 5, 'Version de Zack Snei', 0),
(187, 8, 2, 3, '2021-06-09', '07:00:00', 5, 'Version de Zack Snei', 0),
(188, 8, 2, 3, '2021-06-10', '07:00:00', 5, 'Version de Zack Snei', 0),
(189, 8, 2, 3, '2021-06-11', '07:00:00', 5, 'Version de Zack Snei', 0),
(190, 8, 2, 3, '2021-06-12', '07:00:00', 5, 'Version de Zack Snei', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(15) UNSIGNED NOT NULL,
  `username` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `passwd` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `rol` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Usuarios';

--
-- RELACIONES PARA LA TABLA `users`:
--

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `passwd`, `rol`) VALUES
(0, 'admin', 'admin@complucine.sytes.ne', 'shDBCKnEbWZFc', 'admin'),
(1, 'manager', 'manager@complucine.sytes.net', 'shTS9RK/eJPoQ', 'manager'),
(2, 'user', 'user@complucine.sytes.net', 'shO5etd.DYKWg', 'user'),
(3, 'manager2', 'manager2@complucine.sytes.net', '$2y$10$IAoCBP5mWz.dEIV7qsy1guyoOpfrfovwDBOEL9wVFn2oM1x9nx2xW', 'manager'),
(7, 'fernando', 'fer@complucine.sytes.net', '$2y$10$/3yjEh4d7AOY3RyNjXIIkO5H2hg7/kiHiToJa92tCBPd7s3UPtB.G', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD KEY `PK_A_USER` (`id`);

--
-- Indices de la tabla `cinema`
--
ALTER TABLE `cinema`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `U_TITTLE_LANGUAGE` (`tittle`,`language`);

--
-- Indices de la tabla `hall`
--
ALTER TABLE `hall`
  ADD PRIMARY KEY (`number`,`idcinema`),
  ADD KEY `FK_CINEMA` (`idcinema`);

--
-- Indices de la tabla `manager`
--
ALTER TABLE `manager`
  ADD KEY `PK_M_USER` (`id`),
  ADD KEY `PK_M_CINEMA` (`idcinema`);

--
-- Indices de la tabla `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `purchase`
--
ALTER TABLE `purchase`
  ADD KEY `PK_P_SEAT` (`idhall`,`numrow`,`numcolum`),
  ADD KEY `FK_P_SESSION` (`idsession`),
  ADD KEY `FK_P_USER` (`iduser`),
  ADD KEY `FK_P_SEAT` (`idhall`,`idcinema`,`numrow`,`numcolum`);

--
-- Indices de la tabla `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`idhall`,`numrow`,`numcolum`,`idcinema`) USING BTREE,
  ADD KEY `FK_HALL` (`idhall`,`idcinema`);

--
-- Indices de la tabla `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_FILM` (`idfilm`),
  ADD KEY `FK_HALL_` (`idhall`,`idcinema`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cinema`
--
ALTER TABLE `cinema`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `film`
--
ALTER TABLE `film`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `hall`
--
ALTER TABLE `hall`
  MODIFY `number` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `promotion`
--
ALTER TABLE `promotion`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `session`
--
ALTER TABLE `session`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `PK_A_USER` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `hall`
--
ALTER TABLE `hall`
  ADD CONSTRAINT `FK_CINEMA` FOREIGN KEY (`idcinema`) REFERENCES `cinema` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `PK_M_CINEMA` FOREIGN KEY (`idcinema`) REFERENCES `cinema` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `PK_M_USER` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `FK_P_SEAT` FOREIGN KEY (`idhall`,`idcinema`,`numrow`,`numcolum`) REFERENCES `seat` (`idhall`, `idcinema`, `numrow`, `numcolum`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_P_SESSION` FOREIGN KEY (`idsession`) REFERENCES `session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_P_USER` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `seat`
--
ALTER TABLE `seat`
  ADD CONSTRAINT `FK_HALL` FOREIGN KEY (`idhall`,`idcinema`) REFERENCES `hall` (`number`, `idcinema`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `FK_FILM` FOREIGN KEY (`idfilm`) REFERENCES `film` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_HALL_` FOREIGN KEY (`idhall`,`idcinema`) REFERENCES `hall` (`number`, `idcinema`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
