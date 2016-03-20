-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-10-2015 a las 05:19:54
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `avtrempdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE IF NOT EXISTS `empleado` (
`emp_conse` int(11) NOT NULL,
  `emp_nombre` varchar(45) DEFAULT NULL,
  `emp_apellido` varchar(45) DEFAULT NULL,
  `emp_documento` varchar(15) DEFAULT NULL,
  `emp_fechanacimiento` date DEFAULT NULL,
  `emp_ciudadresidencia` varchar(45) DEFAULT NULL,
  `emp_profesion` varchar(45) DEFAULT NULL,
  `emp_genero` varchar(1) DEFAULT NULL,
  `emp_observacion` text,
  `emp_fecharegistro` date DEFAULT NULL,
  `emp_telefono` varchar(20) DEFAULT NULL,
  `emp_movil` varchar(10) DEFAULT NULL,
  `emp_correoelectronico` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`emp_conse`, `emp_nombre`, `emp_apellido`, `emp_documento`, `emp_fechanacimiento`, `emp_ciudadresidencia`, `emp_profesion`, `emp_genero`, `emp_observacion`, `emp_fecharegistro`, `emp_telefono`, `emp_movil`, `emp_correoelectronico`) VALUES
(1, 'Claudia', 'Gonzalez', 'doc', '2013-02-06', 'resi', 'profe', 'g', 'obs', NULL, 'tel', '', 'corr'),
(2, 'Jorge', 'Ubaque', '525225', '2015-01-01', 'BogotÃ¡', 'Ingeniero', 'M', 'buen empleado', NULL, '3556666', '3114445556', 'jeus@umssys.com'),
(3, 'Arturo', 'Calle', '45523212', '0000-00-00', '', 'asdfd', '', '', NULL, '', '', 'asdfs@.'),
(9, 'Guillermo', 'Arevalo', '4455', '2013-02-04', 'Bogota', 'Ingeniero', '', '', NULL, '', '', 'Ingeniero@prueba.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
 ADD PRIMARY KEY (`emp_conse`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
MODIFY `emp_conse` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
