-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 27-06-2015 a las 14:13:28
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `prueba`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE IF NOT EXISTS `publicaciones` (
  `consulta` varchar(50) NOT NULL,
  `id` varchar(20) NOT NULL,
  `eid` varchar(20) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `creador` varchar(50) NOT NULL,
  `nombre_publi` varchar(50) NOT NULL,
  `issn` int(11) NOT NULL,
  `volumen` int(11) NOT NULL,
  `rango_pags` varchar(11) NOT NULL,
  `fecha_portada` varchar(20) NOT NULL,
  `fecha_portada_0` varchar(20) NOT NULL,
  `doi` varchar(50) NOT NULL,
  `citas` varchar(500) NOT NULL,
  `veces_citado` int(11) NOT NULL,
  `afiliacion_nombre` varchar(50) NOT NULL,
  `afiliacion_ciudad` varchar(20) NOT NULL,
  `afiliacion_pais` varchar(20) NOT NULL,
  `tipo_publi` varchar(11) NOT NULL,
  `subtipo_publi` varchar(11) NOT NULL,
  `source_id` int(11) NOT NULL,
  `enlace_coautores` varchar(100) NOT NULL,
  `enlace_preview` varchar(100) NOT NULL,
  `enlace_citedby` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
