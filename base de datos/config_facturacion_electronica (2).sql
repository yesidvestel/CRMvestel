-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-07-2023 a las 00:17:17
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crm_saves`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_facturacion_electronica`
--

CREATE TABLE `config_facturacion_electronica` (
  `id` int(11) NOT NULL,
  `nombre` enum('Tv','Internet','Todo') NOT NULL,
  `numero` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `access_key` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `config_facturacion_electronica`
--

INSERT INTO `config_facturacion_electronica` (`id`, `nombre`, `numero`, `username`, `access_key`) VALUES
(1, 'Tv', 1, 'contabilidad@vestel.com.co', 'MDc2YzZlMzAtZGI2Yy00OGFkLWFjZjktZTNlNGUxNDZkODk5Ok9SUDkhOXowQ0E='),
(2, 'Internet', 2, 'contabilidad@vestel.com.co', 'YjMzZWY4MzYtMDMxMC00MjBlLTg0NzItZTAzYzFjMDcwMTc2OjQpcTh0Rk8hNkI=');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `config_facturacion_electronica`
--
ALTER TABLE `config_facturacion_electronica`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `config_facturacion_electronica`
--
ALTER TABLE `config_facturacion_electronica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
