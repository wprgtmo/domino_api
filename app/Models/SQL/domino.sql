-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-09-2021 a las 03:37:23
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `domino`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boleta`
--

CREATE TABLE `boleta` (
  `id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `ronda_id` int(11) NOT NULL,
  `mesa_id` int(11) NOT NULL,
  `es_valida` bit(1) NOT NULL DEFAULT b'1',
  `fecha_registro` char(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boleta_pareja`
--

CREATE TABLE `boleta_pareja` (
  `id` int(11) NOT NULL,
  `boleta_id` int(11) NOT NULL,
  `pareja_id` int(11) NOT NULL,
  `salidor` bit(1) NOT NULL DEFAULT b'0',
  `tantos` int(11) NOT NULL,
  `resultado` int(11) NOT NULL DEFAULT 0,
  `ganador` bit(1) NOT NULL DEFAULT b'0',
  `inicio` datetime NOT NULL,
  `duracion` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `id` int(11) NOT NULL,
  `pais` varchar(120) NOT NULL,
  `pais_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `numero` smallint(6) NOT NULL,
  `boleta_id` int(11) NOT NULL,
  `pareja_ganadora` int(11) NOT NULL,
  `puntos` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `id` int(11) NOT NULL,
  `ciudad_id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `comentario` varchar(255) DEFAULT NULL,
  `cerrado` bit(1) NOT NULL DEFAULT b'0',
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  `creado` datetime NOT NULL,
  `actualizado` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`id`, `ciudad_id`, `nombre`, `comentario`, `cerrado`, `fecha_inicio`, `fecha_cierre`, `creado`, `actualizado`) VALUES
(1, 1, 'Clásico 2021', 'Clásico 2021 Guantánamo', b'0', '2021-09-25 18:46:27', '2021-09-25 18:46:27', '2021-09-25 18:46:27', '2021-09-25 18:46:27'),
(2, 1, 'Clásico 2022', 'Clásico 2022 Guantánamo', b'0', '2021-09-25 18:46:27', '2021-09-25 18:46:27', '2021-09-25 18:46:27', '2021-09-25 18:46:27'),
(3, 1, 'Clásico 2023 Actualiz', 'Clásico 2023 Guantánamo Actualizado', b'1', '2021-09-25 18:46:27', '2021-09-25 18:46:27', '2021-09-28 19:51:48', '2021-09-28 19:56:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugador`
--

CREATE TABLE `jugador` (
  `id` int(11) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `nombre` varchar(120) NOT NULL,
  `sexo` char(1) NOT NULL DEFAULT 'M',
  `correo` varchar(120) NOT NULL,
  `nro_identidad` varchar(30) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `alias` varchar(30) DEFAULT NULL,
  `ocupacion` varchar(120) DEFAULT NULL,
  `comentario` varchar(255) DEFAULT NULL,
  `nivel` varchar(30) NOT NULL,
  `elo` int(11) NOT NULL DEFAULT 0,
  `ranking` char(2) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `ciudad_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `numero` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pareja`
--

CREATE TABLE `pareja` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `jugador1_id` int(11) NOT NULL,
  `jugador2_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ronda`
--

CREATE TABLE `ronda` (
  `id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `numero` smallint(6) NOT NULL,
  `inicio` datetime DEFAULT NULL,
  `cierre` datetime DEFAULT NULL,
  `dia` smallint(6) NOT NULL,
  `cerrada` bit(1) NOT NULL DEFAULT b'0',
  `comentario` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ronda`
--

INSERT INTO `ronda` (`id`, `evento_id`, `numero`, `inicio`, `cierre`, `dia`, `cerrada`, `comentario`) VALUES
(1, 1, 1, '2021-09-28 16:49:35', '2021-09-28 16:49:35', 1, b'0', NULL),
(2, 1, 2, '2021-09-28 16:49:35', '2021-09-28 16:49:35', 1, b'0', NULL),
(3, 1, 3, '2021-09-28 16:49:35', '2021-09-28 16:49:35', 1, b'0', NULL),
(4, 1, 4, '2021-09-28 16:49:35', '2021-09-28 16:49:35', 1, b'0', NULL),
(5, 2, 1, '2021-09-28 16:49:35', '2021-09-28 16:49:35', 1, b'0', NULL),
(6, 2, 2, '2021-09-28 16:49:35', '2021-09-28 16:49:35', 1, b'0', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `boleta`
--
ALTER TABLE `boleta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `PK_ALT13` (`evento_id`,`mesa_id`,`ronda_id`),
  ADD KEY `Ref157` (`evento_id`),
  ADD KEY `Ref1158` (`ronda_id`),
  ADD KEY `Ref1059` (`mesa_id`);

--
-- Indices de la tabla `boleta_pareja`
--
ALTER TABLE `boleta_pareja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Ref1360` (`boleta_id`),
  ADD KEY `Ref1761` (`pareja_id`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Ref24` (`pais_id`);

--
-- Indices de la tabla `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `PK_ALT14` (`boleta_id`,`numero`),
  ADD KEY `Ref1362` (`boleta_id`),
  ADD KEY `Ref1763` (`pareja_ganadora`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Ref35` (`ciudad_id`);

--
-- Indices de la tabla `jugador`
--
ALTER TABLE `jugador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Ref312` (`ciudad_id`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `K_ALT10` (`evento_id`,`numero`),
  ADD KEY `Ref153` (`evento_id`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pareja`
--
ALTER TABLE `pareja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Ref167` (`evento_id`),
  ADD KEY `Ref1270` (`jugador1_id`),
  ADD KEY `Ref1271` (`jugador2_id`);

--
-- Indices de la tabla `ronda`
--
ALTER TABLE `ronda`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `PK_ALT11` (`evento_id`,`numero`),
  ADD KEY `Ref151` (`evento_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `boleta`
--
ALTER TABLE `boleta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `boleta_pareja`
--
ALTER TABLE `boleta_pareja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `jugador`
--
ALTER TABLE `jugador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pareja`
--
ALTER TABLE `pareja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ronda`
--
ALTER TABLE `ronda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
