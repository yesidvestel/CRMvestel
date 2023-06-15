-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2023 a las 20:37:05
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_general_params`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sitios_web`
--

CREATE TABLE `sitios_web` (
  `id` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `db_user` varchar(100) NOT NULL,
  `db_pass` varchar(100) NOT NULL,
  `db_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sitios_web`
--

INSERT INTO `sitios_web` (`id`, `url`, `db_user`, `db_pass`, `db_name`) VALUES
(1, 'http://localhost/CRMvestel/', 'root', '', 'crm_28_04_2023'),
(2, 'https://www.vesteldigital.com.co', 'admincrm', 'Vestel1957', 'admin_crmvestel'),
(3, 'https://www.mydic-vestel.com', 'crmdemo', 'democrm1957', 'admin_crm');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `sitios_web`
--
ALTER TABLE `sitios_web`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `sitios_web`
--
ALTER TABLE `sitios_web`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;
ALTER TABLE `sitios_web` ADD `param_us_import` VARCHAR(50) NOT NULL DEFAULT 'importequipo/usuarios_upload' AFTER `db_name`;
UPDATE `sitios_web` SET `param_us_import` = 'importequipo/usuarios_upload_vestel_digital' WHERE `sitios_web`.`id` = 2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
