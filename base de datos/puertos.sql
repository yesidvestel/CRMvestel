-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-09-2022 a las 18:06:04
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puertos`
--

CREATE TABLE `puertos` (
  `idp` int(11) NOT NULL,
  `sede` int(11) NOT NULL,
  `vlan` int(11) NOT NULL,
  `nap` int(11) NOT NULL,
  `puerto` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `asignado` int(11) NOT NULL,
  `detalle` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `puertos`
--

INSERT INTO `puertos` (`idp`, `sede`, `vlan`, `nap`, `puerto`, `estado`, `asignado`, `detalle`) VALUES
(1, 4, 1, 1, 1, 'Ocupado', 1, 'calle 34 # 19 - 67'),
(2, 4, 1, 1, 2, 'Disponible', 0, 'calle 34 # 19 - 67');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `puertos`
--
ALTER TABLE `puertos`
  ADD PRIMARY KEY (`idp`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `puertos`
--
ALTER TABLE `puertos`
  MODIFY `idp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
