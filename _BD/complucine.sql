-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-04-2021 a las 12:10:06
-- Versión del servidor: 10.0.28-MariaDB-2+b1
-- Versión de PHP: 7.3.27-1~deb10u1

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
-- Volcado de datos para la tabla `cinema`
--

INSERT INTO `cinema` (`id`, `name`, `direction`, `phone`) VALUES
(1, 'Cinema 1st', 'no tiene direccion', '666666666');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `film`
--

CREATE TABLE `film` (
  `id` int(15) UNSIGNED NOT NULL,
  `tittle` varchar(60) NOT NULL,
  `duration` int(3) UNSIGNED NOT NULL,
  `language` varchar(30) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `film`
--

INSERT INTO `film` (`id`, `tittle`, `duration`, `language`, `description`) VALUES
(1, 'iron_man', 120, 'spanish', 'Un empresario millonario construye un traje blindado y lo usa para combatir el crimen y el terrorismo.'),
(2, 'iron_man_2', 120, 'spanish', 'Con el mundo ahora consciente de que él es Iron Man, el millonario inventor Tony Stark debe forjar nuevas alianzas y confrontar a un enemigo nuevo y poderoso.'),
(3, 'iron_man_3', 120, 'spanish', 'El descarado y brillante Tony Stark, tras ver destruido todo su universo personal, debe encontrar y enfrentarse a un enemigo cuyo poder no conoce límites. Este viaje pondrá a prueba su entereza una y otra vez, y le obligará a confiar en su ingenio.'),
(4, 'capitan_america_el_primer_vengador', 120, 'spanish', 'Tras tres meses de someterse a un programa de entrenamiento físico y táctico, encomiendan a Steve Rogers su primera misión como Capitán América. Armado con un escudo indestructible, emprende la guerra contra la perversa organización HYDRA.'),
(5, 'capitan_america_el_soldado_de_invierno', 120, 'spanish', 'Capitán América, Viuda Negra y un nuevo aliado, Falcon, se enfrentan a un enemigo inesperado mientras intentan exponer una conspiración que pone en riesgo al mundo.'),
(6, 'capitan_america_civil_war', 180, 'spanish', 'Después de que otro incidente internacional, en el que se ven envueltos los Vengadores, produzca daños colaterales, la presión política obliga a poner en marcha un sistema para depurar responsabilidades.'),
(7, 'marvel_avengers', 120, 'spanish', 'El director de la Agencia SHIELD decide reclutar a un equipo para salvar al mundo de un desastre casi seguro cuando un enemigo inesperado surge como una gran amenaza para la seguridad mundial.'),
(8, 'avengers_age_of_ultron', 120, 'spanish', 'Los Vengadores se reúnen de nuevo y juntan sus fuerzas con las de los recién llegados Quicksilver y Bruja Escarlata para luchar contra un robot maquiavélico llamado Ultrón, el cual Tony Stark creó con el fin de defender la paz, pero resultó defectuoso y ahora pretende exterminar a toda la humanidad.'),
(9, 'avengers_inifinity_war', 180, 'spanish', 'Los superhéroes se alían para vencer al poderoso Thanos, el peor enemigo al que se han enfrentado. Si Thanos logra reunir las seis gemas del infinito: poder, tiempo, alma, realidad, mente y espacio, nadie podrá detenerlo.'),
(10, 'avengers_end_game', 180, 'spanish', 'Los Vengadores restantes deben encontrar una manera de recuperar a sus aliados para un enfrentamiento épico con Thanos, el malvado que diezmó el planeta y el universo.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hall`
--

CREATE TABLE `hall` (
  `number` int(15) UNSIGNED NOT NULL,
  `idcinema` int(15) UNSIGNED NOT NULL,
  `numrows` int(3) NOT NULL,
  `numcolumns` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `hall`
--

INSERT INTO `hall` (`number`, `idcinema`, `numrows`, `numcolumns`) VALUES
(1, 1, 20, 20),
(2, 1, 20, 20),
(3, 1, 20, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `manager`
--

CREATE TABLE `manager` (
  `id` int(15) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promotion`
--

CREATE TABLE `promotion` (
  `id` int(15) UNSIGNED NOT NULL,
  `tittle` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `code` varchar(15) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `format` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `session`
--

INSERT INTO `session` (`id`, `idfilm`, `idhall`, `idcinema`, `date`, `start_time`, `seat_price`, `format`) VALUES
(3, 4, 2, 1, '2021-04-16', '14:20:00', 5, 'Estandar'),
(4, 4, 2, 1, '2021-04-17', '14:20:00', 5, 'Estandar'),
(5, 4, 2, 1, '2021-04-18', '14:20:00', 5, 'Estandar'),
(6, 9, 2, 1, '2021-04-15', '18:00:00', 7, '3D'),
(7, 9, 1, 1, '2021-04-16', '18:00:00', 7, '3D'),
(8, 9, 1, 1, '2021-04-17', '18:00:00', 7, '3D'),
(9, 9, 1, 1, '2021-04-18', '18:00:00', 7, '3D'),
(10, 9, 1, 1, '2021-04-19', '18:00:00', 7, '3D'),
(11, 9, 1, 1, '2021-04-20', '18:00:00', 7, '3D'),
(12, 9, 1, 1, '2021-04-21', '18:00:00', 7, '3D'),
(13, 9, 1, 1, '2021-04-22', '18:00:00', 7, '3D'),
(14, 10, 1, 1, '2021-04-15', '18:00:00', 10, 'normal');

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
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `passwd`, `rol`) VALUES
(0, 'admin', 'admin@complucine.sytes.net', 'shDBCKnEbWZFc', 'admin'),
(1, 'manager', 'manager@complucine.sytes.net', 'shTS9RK/eJPoQ', 'manager'),
(2, 'user', 'user@complucine.sytes.net', 'shO5etd.DYKWg', 'user'),
(7, 'fernando', 'fer@complucine.sytes.net', '$2y$10$k/R4m.uN1IfZ0rdc5wwc2uaO9b0e5qK9WtOBloxlfkUuBjWPMC3PG', 'user');

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
  ADD KEY `PK_M_USER` (`id`);

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
  ADD PRIMARY KEY (`idhall`,`numrow`,`numcolum`),
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
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `film`
--
ALTER TABLE `film`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `hall`
--
ALTER TABLE `hall`
  MODIFY `number` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `session`
--
ALTER TABLE `session`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
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
  ADD CONSTRAINT `PK_M_USER` FOREIGN KEY (`id`) REFERENCES `users` (`id`);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
