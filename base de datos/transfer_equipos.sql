-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-09-2024 a las 23:36:53
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
-- Base de datos: `crmvestel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_equipos`
--

CREATE TABLE `transfer_equipos` (
  `teid` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `almacen_origen` varchar(50) NOT NULL,
  `almacen_destino` varchar(50) NOT NULL,
  `observaciones` varchar(50) NOT NULL,
  `id_usuario_que_transfiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `transfer_equipos`
--

INSERT INTO `transfer_equipos` (`teid`, `fecha`, `almacen_origen`, `almacen_destino`, `observaciones`, `id_usuario_que_transfiere`) VALUES
(1, '2024-09-13 09:34:26', '12', '10', '<p>enviado</p>', 8),
(2, '2024-09-13 09:41:05', '12', '10', '', 8),
(3, '2024-09-13 09:46:34', '8', '12', '', 8),
(4, '2024-09-13 09:48:35', '12', '10', '<p>cambio</p>', 8),
(5, '2024-09-13 09:53:18', '12', '8', '', 8);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `transfer_equipos`
--
ALTER TABLE `transfer_equipos`
  ADD PRIMARY KEY (`teid`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `transfer_equipos`
--
ALTER TABLE `transfer_equipos`
  MODIFY `teid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
