-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 02-06-2021 a las 21:03:55
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `manager`
--

CREATE TABLE `manager` (
  `id` int(15) UNSIGNED NOT NULL,
  `idcinema` int(15) UNSIGNED NOT NULL
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
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `img` varchar(60) NOT NULL
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
  `format` varchar(20) NOT NULL,
  `seats_full` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
