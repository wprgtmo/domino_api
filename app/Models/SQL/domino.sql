-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-10-2021 a las 22:51:01
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
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `boleta`
--

INSERT INTO `boleta` (`id`, `evento_id`, `ronda_id`, `mesa_id`, `es_valida`, `fecha_registro`) VALUES
(68, 1, 38, 19, b'1', '2021-10-05 19:43:39'),
(67, 1, 38, 20, b'1', '2021-10-05 19:43:39'),
(66, 1, 38, 21, b'1', '2021-10-05 19:43:39'),
(65, 1, 38, 22, b'1', '2021-10-05 19:43:39'),
(64, 1, 38, 23, b'1', '2021-10-05 19:43:39'),
(63, 1, 38, 24, b'1', '2021-10-05 19:43:39'),
(62, 1, 38, 25, b'1', '2021-10-05 19:43:39'),
(61, 1, 38, 26, b'1', '2021-10-05 19:43:39'),
(60, 1, 38, 27, b'1', '2021-10-05 19:43:39'),
(59, 1, 38, 28, b'1', '2021-10-05 19:43:39'),
(58, 1, 38, 29, b'1', '2021-10-05 19:43:39');

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

--
-- Volcado de datos para la tabla `boleta_pareja`
--

INSERT INTO `boleta_pareja` (`id`, `boleta_id`, `pareja_id`, `salidor`, `tantos`, `resultado`, `ganador`, `inicio`, `duracion`) VALUES
(45, 68, 12, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(44, 68, 11, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(43, 67, 11, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(42, 67, 10, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(41, 66, 10, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(40, 66, 9, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(39, 65, 9, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(38, 65, 8, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(37, 64, 8, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(36, 64, 7, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(35, 63, 7, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(34, 63, 6, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(33, 62, 6, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(32, 62, 5, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(31, 61, 5, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(30, 61, 4, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(29, 60, 4, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(28, 60, 3, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(27, 59, 3, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(26, 59, 2, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(25, 58, 2, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39'),
(24, 58, 1, b'0', 0, 0, b'0', '2021-10-05 18:43:39', '2021-10-05 18:43:39');

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
  `estado` char(1) NOT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  `creado` datetime NOT NULL,
  `actualizado` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`id`, `ciudad_id`, `nombre`, `comentario`, `estado`, `fecha_inicio`, `fecha_cierre`, `creado`, `actualizado`) VALUES
(1, 1, 'Clásico 2021', 'Clásico 2021 Guantánamo', 'C', '2021-09-25 18:46:27', '2021-09-25 18:46:27', '2021-09-25 18:46:27', '2021-09-25 18:46:27'),
(2, 1, 'Clásico 2022', 'Clásico 2022 Guantánamo', 'I', '2021-09-25 18:46:27', '2021-09-25 18:46:27', '2021-09-25 18:46:27', '2021-09-25 18:46:27'),
(3, 1, 'Clásico 2023 Actualiz', 'Clásico 2023 Guantánamo Actualizado', 'C', '2021-09-25 18:46:27', '2021-09-25 18:46:27', '2021-09-28 19:51:48', '2021-09-28 19:56:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugador`
--

CREATE TABLE `jugador` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `correo` varchar(120) DEFAULT NULL,
  `nro_identidad` varchar(30) DEFAULT NULL,
  `alias` varchar(30) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `ocupacion` varchar(120) DEFAULT NULL,
  `comentario` varchar(255) DEFAULT NULL,
  `nivel` varchar(30) DEFAULT NULL,
  `elo` int(11) DEFAULT NULL,
  `ranking` char(2) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `ciudad_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `jugador`
--

INSERT INTO `jugador` (`id`, `nombre`, `telefono`, `sexo`, `foto`, `correo`, `nro_identidad`, `alias`, `fecha_nacimiento`, `ocupacion`, `comentario`, `nivel`, `elo`, `ranking`, `tipo`, `ciudad_id`) VALUES
(42, 'German Estrada Fong', '', 'M', 'public/assets/img/jugadores/jugador42.jpg', 'german@nauta.cu', '66100411165', 'german', '1966-10-04', 'Cuenta propia (Escritor)', '', 'Medio', 960, 'MD', 'P', 1),
(41, 'Ramon Garcia Repilado', '', 'M', 'public/assets/img/jugadores/jugador41.jpg', 'ramon@nauta.cu', '55082407924', 'ramon', '1955-08-24', 'Univ. Ote. Fac.Ing.Mec.', '', 'Avanzado', 945, 'MD', 'P', 1),
(40, 'Roberto Franco', '', 'M', 'public/assets/img/jugadores/jugador40.jpg', 'roberto@nauta.cu', '70050618102', 'roberto', '1970-05-06', 'Cuenta Propista', '', 'Medio', 930, 'MD', 'P', 1),
(39, 'Yuri Alexis Ramon Calzadilla', '', 'M', 'public/assets/img/jugadores/jugador39.jpg', 'yuri alexis@nauta.cu', '79052020061', 'yuri alexis', '1979-05-20', 'Promotor Cultural', '', 'Medio', 915, 'MD', 'P', 1),
(38, 'Angel Alberto Pena Silva', '', 'M', 'public/assets/img/jugadores/jugador38.jpg', 'angel alberto@nauta.cu', '87070426427', 'angel alberto', '1987-07-04', 'Desvinculado', '', 'Avanzado', 900, 'MD', 'P', 1),
(37, 'Harold Edemio Navas Borges', '', 'M', 'public/assets/img/jugadores/jugador37.jpg', 'harold edemio@nauta.cu', '93103019888', 'harold edemio', '1993-10-30', 'Estudiante Univ. Ciencias Med. Holguin', '', 'Medio', 885, 'MD', 'P', 1),
(36, 'Asiel De los Angeles Caballero', '', 'M', 'public/assets/img/jugadores/jugador36.jpg', 'asiel@nauta.cu', '70050618102', 'asiel', '1970-05-06', 'Holguin', '', 'Avanzado', 870, 'MD', 'P', 1),
(35, 'Luis Carlos Velazquez Colina', '', 'M', 'public/assets/img/jugadores/jugador35.jpg', 'luis carlos@nauta.cu', '79010419004', 'luis carlos', '1979-01-04', 'Holguin', '', 'Medio', 855, 'MD', 'P', 1),
(34, 'Eugenio Alvarez Odelin', '', 'M', 'public/assets/img/jugadores/jugador34.jpg', 'eugenio@nauta.cu', '83102625329', 'eugenio', '1983-10-26', 'Cuentapropista', '', 'Avanzado', 840, 'MD', 'P', 1),
(32, 'Magyordis Cardosa Perez', '', 'M', 'public/assets/img/jugadores/jugador32.jpg', 'magyordis@nauta.cu', '83061425620', 'magyordis', '1983-06-14', 'INDER', '', 'Avanzado', 810, 'MD', 'P', 1),
(33, 'Amauri Londres Garcia', '', 'M', 'public/assets/img/jugadores/jugador33.jpg', 'amauri@nauta.cu', '74040511580', 'amauri', '1974-04-05', 'Farmacia y Optica', '', 'Medio', 825, 'MD', 'P', 1),
(31, 'Alexis Padilla Falcon', '', 'M', 'public/assets/img/jugadores/jugador31.jpg', 'alexis@nauta.cu', '69051910003', 'alexis', '1969-05-19', 'Gastronomia', '', 'Medio', 795, 'MD', 'P', 1),
(29, 'Yandi Corrales Castellano', '', 'M', 'public/assets/img/jugadores/jugador29.jpg', 'yandi@nauta.cu', '70050618102', 'yandi', '1970-05-06', 'Cuenta Propista', '', 'Medio', 765, 'MD', 'P', 1),
(30, 'Rolando Scull Diaz', '', 'M', 'public/assets/img/jugadores/jugador30.jpg', 'rolando@nauta.cu', '70050618102', 'rolando', '1970-05-06', 'Cuenta Propista', '', 'Avanzado', 780, 'MD', 'P', 1),
(28, 'Arismel Brugal Labrada', '', 'M', 'public/assets/img/jugadores/jugador28.jpg', 'arismel@nauta.cu', '82120432026', 'arismel', '1982-12-04', 'Campesino', '', 'Avanzado', 750, 'MD', 'P', 1),
(27, 'Jorge Luis Faure Ayarde', '', 'M', 'public/assets/img/jugadores/jugador27.jpg', 'jorge luis@nauta.cu', '68122528504', 'jorge luis', '1968-12-25', 'Cuentapropista', '', 'Medio', 735, 'MD', 'P', 1),
(26, 'Geovanis Samon Leyva', '', 'M', 'public/assets/img/jugadores/jugador26.jpg', 'geovanis@nauta.cu', '74021411276', 'geovanis', '1974-02-14', 'Agricultor', '', 'Avanzado', 720, 'MD', 'P', 1),
(25, 'Javier Bombale Dutil', '', 'M', 'public/assets/img/jugadores/jugador25.jpg', 'javier@nauta.cu', '69062927128', 'javier', '1969-06-29', 'HGD Higienista', '', 'Medio', 705, 'MD', 'P', 1),
(24, 'Nelson Perez Frometa', '', 'M', 'public/assets/img/jugadores/jugador24.jpg', 'nelson@nauta.cu', '88091435061', 'nelson', '1988-09-14', 'Cuenta Propista', '', 'Avanzado', 690, 'MD', 'P', 1),
(23, 'Addiel Durand Jay', '', 'M', 'public/assets/img/jugadores/jugador23.jpg', 'addiel@nauta.cu', '89101845807', 'addiel', '1989-10-18', 'Cuenta Propista', '', 'Medio', 675, 'MD', 'P', 1),
(22, 'Pedro Castillo Torres', '', 'M', 'public/assets/img/jugadores/jugador22.jpg', 'pedro@nauta.cu', '62020718184', 'pedro', '1962-02-07', 'Desvinculado', '', 'Avanzado', 660, 'MD', 'P', 1),
(21, 'Ronald Castillo Bell', '', 'M', 'public/assets/img/jugadores/jugador21.jpg', 'ronald@nauta.cu', '70050618102', 'ronald', '1970-05-06', 'Est. Politecnico Antonio Robert', '', 'Medio', 645, 'MD', 'P', 1),
(20, 'Marcial Aladro Iribar', '', 'M', 'public/assets/img/jugadores/jugador20.jpg', 'marcial@nauta.cu', '68090807345', 'marcial', '1968-09-08', 'Cuenta Propista', '', 'Medio', 630, 'MD', 'P', 1),
(19, 'Hector Matos Marzo', '', 'M', 'public/assets/img/jugadores/jugador19.jpg', 'hector@nauta.cu', '52062700305', 'hector', '1952-06-27', 'Comercio', '', 'Avanzado', 615, 'MD', 'P', 1),
(18, 'Carlos Martinez', '', 'M', 'public/assets/img/jugadores/jugador18.jpg', 'carlos@nauta.cu', '70050618102', 'carlos', '1970-05-06', 'Cuenta Propista', '', 'Medio', 600, 'MD', 'P', 1),
(17, 'Ordenis Olivares', '', 'M', 'public/assets/img/jugadores/jugador17.jpg', 'ordenis@nauta.cu', '70050618102', 'ordenis', '1970-05-06', 'Cuenta Propista', '', 'Avanzado', 585, 'MD', 'P', 1),
(16, 'Victor Manuel Rojas Fajardo', '', 'M', 'public/assets/img/jugadores/jugador16.jpg', 'victor manuel@nauta.cu', '69113000700', 'victor manuel', '1969-11-30', 'Cuenta propia', '', 'Medio', 570, 'MD', 'P', 1),
(15, 'Yunior Garcia Batista', '', 'M', 'public/assets/img/jugadores/jugador15.jpg', 'yunior@nauta.cu', '89012140421', 'yunior', '1989-01-21', 'INDER', '', 'Avanzado', 555, 'MD', 'P', 1),
(14, 'Jose Orlando San Nicolas', '', 'M', 'public/assets/img/jugadores/jugador14.jpg', 'jose orlando@nauta.cu', '90070441969', 'jose orlando', '1990-07-04', 'Gaviota Islazul', '', 'Medio', 540, 'MD', 'P', 1),
(13, 'Yunior Torres Ochoa', '', 'M', 'public/assets/img/jugadores/jugador13.jpg', 'yunior@nauta.cu', '82042426066', 'yunior', '1982-04-24', 'Cuenta Propia EU', '', 'Medio', 525, 'MD', 'P', 1),
(12, 'Ernesto Padilla Matos', '', 'M', 'public/assets/img/jugadores/jugador12.jpg', 'ernesto@nauta.cu', '75052112529', 'ernesto', '1975-05-21', 'P. Caimanera', '', 'Avanzado', 510, 'MD', 'P', 1),
(11, 'Maikel Tabio Perez', '', 'M', 'public/assets/img/jugadores/jugador11.jpg', 'maikel@nauta.cu', '78090733560', 'maikel', '1978-09-07', 'Cuenta Propia', '', 'Medio', 495, 'MD', 'P', 1),
(10, 'Ramon Mengana Ordunez', '', 'M', 'public/assets/img/jugadores/jugador10.jpg', 'ramon@nauta.cu', '70050618102', 'ramon', '1970-05-06', 'Cultura Municipal', '', 'Medio', 480, 'MD', 'P', 1),
(9, 'Reiniel Michel Castaneda', '', 'M', 'public/assets/img/jugadores/jugador9.jpg', 'reiniel@nauta.cu', '85010228829', 'reiniel', '1985-01-02', 'Campesino', '', 'Avanzado', 465, 'MD', 'P', 1),
(8, 'Nataniel Fabier', '', 'M', 'public/assets/img/jugadores/jugador8.jpg', 'nataniel@nauta.cu', '98120223097', 'nataniel', '1998-12-02', 'Desvinculado', '', 'Medio', 450, 'MD', 'P', 1),
(7, 'Randi de Cordoba Caballero Rojas', '', 'M', 'public/assets/img/jugadores/jugador7.jpg', 'randi de cordoba@nauta.cu', '79061125489', 'randi de cordoba', '1979-06-11', 'INDER', '', 'Avanzado', 435, 'MD', 'P', 1),
(6, 'Robert Leyva Sosa', '', 'M', 'public/assets/img/jugadores/jugador6.jpg', 'robert@nauta.cu', '80100424908', 'robert', '1980-10-04', 'Cuenta Propista', '', 'Medio', 420, 'MD', 'P', 1),
(5, 'Yandri Marelli Batista', '', 'M', 'public/assets/img/jugadores/jugador5.jpg', 'yandri@nauta.cu', '88112635062', 'yandri', '1988-11-26', 'Cuenta Propista', '', 'Medio', 405, 'MD', 'P', 1),
(4, 'Leonardo Benitez Lezcay', '59176095', 'M', 'public/assets/img/jugadores/jugador4.jpg', 'leonardo@nauta.cu', '70050618102', 'leonardo', '1970-05-06', 'Cuenta Propista', '', 'Avanzado', 390, 'MD', 'P', 1),
(3, 'Salvador Cabrales Hernandez', '53096202', 'M', 'public/assets/img/jugadores/jugador3.jpg', 'salvador@nauta.cu', '69111527544', 'salvador', '1969-11-15', 'Cuenta Propista', '', 'Medio', 375, 'MD', 'P', 1),
(2, 'Yousmel Acosta Tejeda', '58544051', 'M', 'public/assets/img/jugadores/jugador2.jpg', 'yousmel@nauta.cu', '82090532269', 'yousmel', '1982-09-05', 'Cuenta Propista', '', 'Principiante', 360, 'MD', 'P', 1),
(1, 'Olvis Rodriguez Aguilar', '', 'M', 'public/assets/img/jugadores/jugador1.jpg', 'olvis@nauta.cu', '83110925385', 'olvis', '1983-11-09', 'Cuenta Propista', '', 'Principiante', 345, 'MD', 'P', 1),
(43, 'Javier Idalgo Suarez', '', 'M', 'public/assets/img/jugadores/jugador43.jpg', 'javier@nauta.cu', '70050618102', 'javier', '1970-05-06', 'INDER', '', 'Avanzado', 975, 'MD', 'P', 1),
(44, 'Alejandro Aguilera Perez', '', 'M', 'public/assets/img/jugadores/jugador44.jpg', 'alejandro@nauta.cu', '92081143386', 'alejandro', '1992-08-11', 'Turismo', '', 'Medio', 990, 'MD', 'P', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `numero` smallint(6) NOT NULL,
  `bonificacion` tinyint(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`id`, `evento_id`, `numero`, `bonificacion`) VALUES
(29, 1, 11, 0),
(28, 1, 10, 0),
(27, 1, 9, 0),
(26, 1, 8, 0),
(25, 1, 7, 0),
(24, 1, 6, 0),
(23, 1, 5, 0),
(22, 1, 4, 0),
(21, 1, 3, 0),
(20, 1, 2, 0),
(19, 1, 1, 0);

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
(38, 1, 1, '2021-10-05 18:43:39', '2021-10-05 18:43:39', 1, b'0', 'Ronda1');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `boleta_pareja`
--
ALTER TABLE `boleta_pareja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
