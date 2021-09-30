-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-09-2021 a las 23:28:43
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

--
-- Volcado de datos para la tabla `jugador`
--

INSERT INTO `jugador` (`id`, `telefono`, `nombre`, `sexo`, `correo`, `nro_identidad`, `fecha_nacimiento`, `alias`, `ocupacion`, `comentario`, `nivel`, `elo`, `ranking`, `tipo`, `ciudad_id`) VALUES
(1, '', 'Olvis  Rodriguez Aguilar', 'M', 'olvis@nauta.cu', '83110925385', '0000-00-00', 'olvis', 'Cuenta Propista', '', 'Principiante', 345, 'MD', 'P', 1),
(2, '58544051', 'Yousmel Acosta Tejeda', 'M', 'yousmel@nauta.cu', '82090532269', '0000-00-00', 'yousmel', 'Cuenta Propista', '', 'Principiante', 360, 'MD', 'P', 1),
(3, '53096202', 'Salvador Cabrales Hernandez', 'M', 'salvador@nauta.cu', '69111527544', '0000-00-00', 'salvador', 'Cuenta Propista', '', 'Medio', 375, 'MD', 'P', 1),
(4, '59176095', 'Leonardo Benitez Lezcay', 'M', 'leonardo@nauta.cu', '70050618102', '0000-00-00', 'leonardo', 'Cuenta Propista', '', 'Avanzado', 390, 'MD', 'P', 1),
(5, '', 'Yandri Marelli Batista', 'M', 'yandri@nauta.cu', '88112635062', '0000-00-00', 'yandri', 'Cuenta Propista', '', 'Medio', 405, 'MD', 'P', 1),
(6, '', 'Robert Leyva Sosa', 'M', 'robert@nauta.cu', '80100424908', '0000-00-00', 'robert', 'Cuenta Propista', '', 'Medio', 420, 'MD', 'P', 1),
(7, '', 'Randi de Cordoba Caballero Rojas', 'M', 'randi de cordoba@nauta.cu', '79061125489', '0000-00-00', 'randi de cordoba', 'INDER', '', 'Avanzado', 435, 'MD', 'P', 1),
(8, '', 'Nataniel Fabier', 'M', 'nataniel@nauta.cu', '98120223097', '0000-00-00', 'nataniel', 'Desvinculado', '', 'Medio', 450, 'MD', 'P', 1),
(9, '', 'Reiniel Michel Castaneda', 'M', 'reiniel@nauta.cu', '85010228829', '0000-00-00', 'reiniel', 'Campesino', '', 'Avanzado', 465, 'MD', 'P', 1),
(10, '', 'Ramon Mengana Ordunez', 'M', 'ramon@nauta.cu', '70050618102', '0000-00-00', 'ramon', 'Cultura Municipal', '', 'Medio', 480, 'MD', 'P', 1),
(11, '', 'Maikel Tabio Perez', 'M', 'maikel@nauta.cu', '78090733560', '0000-00-00', 'maikel', 'Cuenta Propia', '', 'Medio', 495, 'MD', 'P', 1),
(12, '', 'Ernesto Padilla Matos', 'M', 'ernesto@nauta.cu', '75052112529', '0000-00-00', 'ernesto', 'P. Caimanera', '', 'Avanzado', 510, 'MD', 'P', 1),
(13, '', 'Yunior Torres Ochoa', 'M', 'yunior@nauta.cu', '82042426066', '0000-00-00', 'yunior', 'Cuenta Propia EU', '', 'Medio', 525, 'MD', 'P', 1),
(14, '', 'Jose Orlando San Nicolas', 'M', 'jose orlando@nauta.cu', '90070441969', '0000-00-00', 'jose orlando', 'Gaviota Islazul', '', 'Medio', 540, 'MD', 'P', 1),
(15, '', 'Yunior Garcia Batista', 'M', 'yunior@nauta.cu', '89012140421', '0000-00-00', 'yunior', 'INDER', '', 'Avanzado', 555, 'MD', 'P', 1),
(16, '', 'Victor Manuel Rojas Fajardo', 'M', 'victor manuel@nauta.cu', '69113000700', '0000-00-00', 'victor manuel', 'Cuenta propia', '', 'Medio', 570, 'MD', 'P', 1),
(17, '', 'Ordenis Olivares', 'M', 'ordenis@nauta.cu', '70050618102', '0000-00-00', 'ordenis', 'Cuenta Propista', '', 'Avanzado', 585, 'MD', 'P', 1),
(18, '', 'Carlos Martinez', 'M', 'carlos@nauta.cu', '70050618102', '0000-00-00', 'carlos', 'Cuenta Propista', '', 'Medio', 600, 'MD', 'P', 1),
(19, '', 'Hector Matos Marzo', 'M', 'hector@nauta.cu', '52062700305', '0000-00-00', 'hector', 'Comercio', '', 'Avanzado', 615, 'MD', 'P', 1),
(20, '', 'Marcial Aladro Iribar', 'M', 'marcial@nauta.cu', '68090807345', '0000-00-00', 'marcial', 'Cuenta Propista', '', 'Medio', 630, 'MD', 'P', 1),
(21, '', 'Ronald Castillo Bell', 'M', 'ronald@nauta.cu', '70050618102', '0000-00-00', 'ronald', 'Est. Politecnico Antonio Robert', '', 'Medio', 645, 'MD', 'P', 1),
(22, '', 'Pedro Castillo Torres', 'M', 'pedro@nauta.cu', '62020718184', '0000-00-00', 'pedro', 'Desvinculado', '', 'Avanzado', 660, 'MD', 'P', 1),
(23, '', 'Addiel Durand Jay', 'M', 'addiel@nauta.cu', '89101845807', '0000-00-00', 'addiel', 'Cuenta Propista', '', 'Medio', 675, 'MD', 'P', 1),
(24, '', 'Nelson Perez Frometa', 'M', 'nelson@nauta.cu', '88091435061', '0000-00-00', 'nelson', 'Cuenta Propista', '', 'Avanzado', 690, 'MD', 'P', 1),
(25, '', 'Javier Bombale Dutil', 'M', 'javier@nauta.cu', '69062927128', '0000-00-00', 'javier', 'HGD Higienista', '', 'Medio', 705, 'MD', 'P', 1),
(26, '', 'Geovanis Samon Leyva', 'M', 'geovanis@nauta.cu', '74021411276', '0000-00-00', 'geovanis', 'Agricultor', '', 'Avanzado', 720, 'MD', 'P', 1),
(27, '', 'Jorge Luis Faure Ayarde', 'M', 'jorge luis@nauta.cu', '68122528504', '0000-00-00', 'jorge luis', 'Cuentapropista', '', 'Medio', 735, 'MD', 'P', 1),
(28, '', 'Arismel Brugal Labrada', 'M', 'arismel@nauta.cu', '82120432026', '0000-00-00', 'arismel', 'Campesino', '', 'Avanzado', 750, 'MD', 'P', 1),
(29, '', 'Yandi Corrales Castellano', 'M', 'yandi@nauta.cu', '70050618102', '0000-00-00', 'yandi', 'Cuenta Propista', '', 'Medio', 765, 'MD', 'P', 1),
(30, '', 'Rolando Scull Diaz', 'M', 'rolando@nauta.cu', '70050618102', '0000-00-00', 'rolando', 'Cuenta Propista', '', 'Avanzado', 780, 'MD', 'P', 1),
(31, '', 'Alexis Padilla Falcon', 'M', 'alexis@nauta.cu', '69051910003', '0000-00-00', 'alexis', 'Gastronomia', '', 'Medio', 795, 'MD', 'P', 1),
(32, '', 'Magyordis Cardosa Perez', 'M', 'magyordis@nauta.cu', '83061425620', '0000-00-00', 'magyordis', 'INDER', '', 'Avanzado', 810, 'MD', 'P', 1),
(33, '', 'Amauri Londres Garcia', 'M', 'amauri@nauta.cu', '74040511580', '0000-00-00', 'amauri', 'Farmacia y Optica', '', 'Medio', 825, 'MD', 'P', 1),
(34, '', 'Eugenio Alvarez Odelin', 'M', 'eugenio@nauta.cu', '83102625329', '0000-00-00', 'eugenio', 'Cuentapropista', '', 'Avanzado', 840, 'MD', 'P', 1),
(35, '', 'Luis Carlos Velazquez Colina', 'M', 'luis carlos@nauta.cu', '79010419004', '0000-00-00', 'luis carlos', 'Holguin', '', 'Medio', 855, 'MD', 'P', 1),
(36, '', 'Asiel De los Angeles Caballero', 'M', 'asiel@nauta.cu', '70050618102', '0000-00-00', 'asiel', 'Holguin', '', 'Avanzado', 870, 'MD', 'P', 1),
(37, '', 'Harold Edemio Navas Borges', 'M', 'harold edemio@nauta.cu', '93103019888', '0000-00-00', 'harold edemio', 'Estudiante Univ. Ciencias Med. Holguin', '', 'Medio', 885, 'MD', 'P', 1),
(38, '', 'Angel Alberto Pena Silva', 'M', 'angel alberto@nauta.cu', '87070426427', '0000-00-00', 'angel alberto', 'Desvinculado', '', 'Avanzado', 900, 'MD', 'P', 1),
(39, '', 'Yuri Alexis Ramon Calzadilla', 'M', 'yuri alexis@nauta.cu', '79052020061', '0000-00-00', 'yuri alexis', 'Promotor Cultural', '', 'Medio', 915, 'MD', 'P', 1),
(40, '', 'Roberto Franco', 'M', 'roberto@nauta.cu', '70050618102', '0000-00-00', 'roberto', 'Cuenta Propista', '', 'Medio', 930, 'MD', 'P', 1),
(41, '', 'Ramon Garcia Repilado', 'M', 'ramon@nauta.cu', '55082407924', '0000-00-00', 'ramon', 'Univ. Ote. Fac.Ing.Mec.', '', 'Avanzado', 945, 'MD', 'P', 1),
(42, '', 'German Estrada Fong', 'M', 'german@nauta.cu', '66100411165', '0000-00-00', 'german', 'Cuenta propia (Escritor)', '', 'Medio', 960, 'MD', 'P', 1),
(43, '', 'Javier Idalgo Suarez', 'M', 'javier@nauta.cu', '70050618102', '0000-00-00', 'javier', 'INDER', '', 'Avanzado', 975, 'MD', 'P', 1),
(44, '', 'Alejandro Aguilera Perez', 'M', 'alejandro@nauta.cu', '92081143386', '0000-00-00', 'alejandro', 'Turismo', '', 'Medio', 990, 'MD', 'P', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `numero` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`id`, `evento_id`, `numero`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 2, 1),
(7, 2, 2);

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

--
-- Volcado de datos para la tabla `pareja`
--

INSERT INTO `pareja` (`id`, `nombre`, `evento_id`, `jugador1_id`, `jugador2_id`) VALUES
(1, 'Olvis -Yousmel ', 1, 3, 4),
(2, 'Salvador -Leonardo', 1, 5, 6),
(3, 'Yandri-Robert', 1, 7, 8),
(4, 'Randi de Cordoba-Nataniel', 1, 9, 10),
(5, 'Reiniel-Ramon ', 1, 11, 12),
(6, 'Maikel-Ernesto', 1, 13, 14),
(7, 'Yunior-Jose Orlando', 1, 15, 16),
(8, 'Yunior-Victor Manuel', 1, 17, 18),
(9, 'Ordenis -Carlos', 1, 19, 20),
(10, 'Hector-Marcial', 1, 21, 22),
(11, 'Ronald-Pedro', 1, 23, 24),
(12, 'Addiel-Nelson', 1, 25, 26),
(13, 'Javier-Geovanis', 1, 27, 28),
(14, 'Jorge Luis-Arismel', 1, 29, 30),
(15, 'Yandi-Rolando', 1, 31, 32),
(16, 'Alexis -Magyordis', 1, 33, 34),
(17, 'Amauri-Eugenio ', 1, 35, 36),
(18, 'Luis Carlos-Asiel', 1, 37, 38),
(19, 'Harold Edemio-Angel Alberto', 1, 39, 40),
(20, 'Yuri Alexis -Roberto', 1, 41, 42),
(21, 'Ramon-German', 1, 43, 44),
(22, 'Javier-Alejandro', 1, 45, 46);

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
(5, 2, 1, '2021-09-28 16:49:35', '2021-09-28 16:49:35', 1, b'1', NULL),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pareja`
--
ALTER TABLE `pareja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `ronda`
--
ALTER TABLE `ronda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
