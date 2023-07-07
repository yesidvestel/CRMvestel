-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 06-07-2023 a las 20:55:38
-- Versión del servidor: 10.6.12-MariaDB-0ubuntu0.22.04.1
-- Versión de PHP: 8.2.6

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
  `db_name` varchar(100) NOT NULL,
  `param_us_import` varchar(50) NOT NULL DEFAULT 'importequipo/usuarios_upload',
  `sitio_integra_mikrotik` varchar(10) NOT NULL DEFAULT 'SI',
  `valida_tarifa_new_edit_invoice_read_only` varchar(10) NOT NULL DEFAULT 'SI'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sitios_web`
--

INSERT INTO `sitios_web` (`id`, `url`, `db_user`, `db_pass`, `db_name`, `param_us_import`, `sitio_integra_mikrotik`, `valida_tarifa_new_edit_invoice_read_only`) VALUES
(1, 'http://localhost/CRMvestel/', 'root', '', 'crm_28_04_2023', 'importequipo/usuarios_upload', 'SI', 'SI'),
(2, 'https://www.saves-ottis.com/', 'admincrm', 'Vestel1957', 'admin_crmvestel', 'importequipo/usuarios_upload_vestel_digital', 'NO', 'NO'),
(3, 'https://www.mydic-vestel.com', 'crmdemo', 'democrm1957', 'admin_crm', 'importequipo/usuarios_upload', 'SI', 'SI'),
(4, 'https://www.saves-casanet.com/', 'Casanet', 'adminCasanet', 'admin_casanet', 'importequipo/usuarios_upload', 'NO', 'SI'),
(5, 'http://www.saves-vestel.com/', 'root', 'tVsur@2019*', 'crm', 'importequipo/usuarios_upload', 'SI', 'SI');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
CREATE USER 'admin_sitios_web'@'localhost' IDENTIFIED BY '1b0a6e90bc2fc1a1d638592bd51f3253';
GRANT ALL PRIVILEGES ON *.* TO 'admin_sitios_web'@'localhost';
FLUSH PRIVILEGES;