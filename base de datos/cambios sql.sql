﻿ALTER TABLE `datos_archivo_excel_cargue` ADD `metodo_pago` VARCHAR(50) NOT NULL AFTER `id_customer`;
-----------------------------------------------------------------------------------------------------
ALTER TABLE `customers` ADD `fecha_genera_estado_user` DATE NULL AFTER `usu_estado`;

--------------------------------------- cambios sql cargue ---------------------------------------------------------------------------
ALTER TABLE `datos_archivo_excel_cargue` ADD `metodo_pago` VARCHAR(50) NOT NULL AFTER `id_customer`;
---------------------------------------------------------------------------------------------------------------------------------------
ALTER TABLE `invoice_items` ADD `tipo_retencion` ENUM('Retefuente Servicios','Compras','Personas no declarantes','Reteiva') NULL AFTER `fecha_creacion`;
ALTER TABLE `invoices` ADD `tipo_retencion` ENUM('Retefuente Servicios','Compras','Personas no declarantes','Reteiva') NULL AFTER `resivos_guardados`;
----------------------------------------------------------------------------------------------------------------------------------------

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
(1, 'Todo', 1, 'prof.ottis01@gmail.com', 'NWUxMjEzZTYtZGFjOS00MGEzLTk3NDMtMTY1NmNmNjQxZjEwOkUqYiooRDUxdU4=');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;


INSERT INTO `accounts` (`id`, `acn`, `holder`, `sede`, `adate`, `lastbal`, `code`, `direccion`, `telefono`, `departamento`) VALUES (NULL, '8301319932', 'Ottis', '1', '0000-00-00 00:00:00', '161383529.00', 'Cuenta Ottis', '', NULL, '')

-----------------------subir excel --------------------------------------------
ALTER TABLE `datos_archivo_excel_cargue` CHANGE `ref_efecty` `ref_efecty` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
-------------------CAMBIOS DE IMPORT USUARIOS VESTEL DIGITAL ------------------

ALTER TABLE `customers` ADD `coor1` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `dats_last_report`;
ALTER TABLE `customers` ADD `coor2` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `coor1`;

------------------------- TRASLADO -------------------------------------------
ALTER TABLE `temporales` ADD `tid_traslado` INT NULL AFTER `pago`;
-------------------AGREGANDO CAMBIO DE PAYU A WOMPI -----------------------------------------------------------

INSERT INTO `accounts` ( `acn`, `holder`, `sede`, `adate`, `lastbal`, `code`, `direccion`, `telefono`, `departamento`) VALUES
('9874561235', 'WOMPI', 0, '0000-00-00 00:00:00', '100796461.00', 'Cuenta WOMPI', '', NULL, '');

-------------------cambios para cargue de transacciones mediante achivo excel- -------------------------
CREATE TABLE `files_carga_transaccional` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` enum('Archivo Cargado','Procesando','Transacciones Cargadas') NOT NULL,
  `nombre_real_file` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `files_carga_transaccional`
--
ALTER TABLE `files_carga_transaccional`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `files_carga_transaccional`
--
ALTER TABLE `files_carga_transaccional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `datos_archivo_excel_cargue` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `documento` varchar(30) NOT NULL,
  `monto` int(11) NOT NULL,
  `estado` enum('Inicial','Cargado','Error','Usuario No Existe') NOT NULL,
  `id_archivo` int(11) NOT NULL,
  `ref_efecty` varchar(50) NOT NULL,
  `id_customer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `datos_archivo_excel_cargue`
--
ALTER TABLE `datos_archivo_excel_cargue`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `datos_archivo_excel_cargue`
--
ALTER TABLE `datos_archivo_excel_cargue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
INSERT INTO `accounts` ( `acn`, `holder`, `sede`, `adate`, `lastbal`, `code`, `direccion`, `telefono`, `departamento`) VALUES
('8301319931', 'EFECTY', 0, '0000-00-00 00:00:00', '3796461.00', 'Cuenta EFECTY', '', NULL, '');
//desde aca para arriba no a ejecutado cambios en el servidor
-------------cambios ips users ips_users_mk---------------
DROP TABLE ips_users_mk;


CREATE TABLE `ips_users_mk` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ip_local` varchar(100) NOT NULL,
  `ip_remota` varchar(100) NOT NULL,
  `tegnologia` varchar(40) NOT NULL,
  `sede` int(11) NOT NULL,
  `defecto` tinyint(4) DEFAULT NULL,
  `perfiles` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ips_users_mk`
--

INSERT INTO `ips_users_mk` (`id`, `nombre`, `ip_local`, `ip_remota`, `tegnologia`, `sede`, `defecto`, `perfiles`) VALUES
(1, 'Yopal', '10.0.0.1', '10.0.0.2', '', 2, 1, '3Megas,5Megas,5MegasD,10Megas,10MegasSt,10MegasD,15Megas,15MegasD,20Megas,20MegasSt,20MegasD,30Megas,30MegasSt,30MegasD,40Megas,40MegasSt,40MegasD,50Megas,50MegasSt,50MegasD,60Megas,60MegasSt,60MegasD,70Megas,70MegasSt,70MegasD,80Megas,80MegasSt,80MegasD,90Megas,90MegasSt,90MegasD,100Megas,100MegasSt,100MegasD,Cortados'),
(2, 'Yopal GPON', '10.100.0.1', '10.100.0.2', 'GPON', 2, NULL, ''),
(3, 'aguazul', '10.100.0.1', '10.100.0.2', '', 6, NULL, '3Megas,5Megas,5MegasD,10Megas,10MegasSt,10MegasD,15Megas,15MegasD,20Megas,20MegasSt,20MegasD,30Megas,30MegasSt,30MegasD,40Megas,40MegasSt,40MegasD,50Megas,50MegasSt,50MegasD,60Megas,60MegasSt,60MegasD,70Megas,70MegasSt,70MegasD,80Megas,80MegasSt,80MegasD,90Megas,90MegasSt,90MegasD,100Megas,100MegasSt,100MegasD,Cortados'),
(4, 'tauramena', '10.100.0.1', '10.100.0.2', '', 7, NULL, '3Megas,5Megas,5MegasD,10Megas,10MegasSt,10MegasD,15Megas,15MegasD,20Megas,20MegasSt,20MegasD,30Megas,30MegasSt,30MegasD,40Megas,40MegasSt,40MegasD,50Megas,50MegasSt,50MegasD,60Megas,60MegasSt,60MegasD,70Megas,70MegasSt,70MegasD,80Megas,80MegasSt,80MegasD,90Megas,90MegasSt,90MegasD,100Megas,100MegasSt,100MegasD,Cortados'),
(5, 'villavo', '10.0.0.1', '10.0.0.2', '', 8, NULL, '100MegasR,200MegasR,300MegasR,Cortados'),
(6, 'monterrey', '10.1.100.1', '10.1.100.2', '', 4, NULL, '3Megas,5Megas,5MegasD,10Megas,10MegasSt,10MegasD,15Megas,15MegasD,20Megas,20MegasSt,20MegasD,30Megas,30MegasSt,30MegasD,40Megas,40MegasSt,40MegasD,50Megas,50MegasSt,50MegasD,60Megas,60MegasSt,60MegasD,70Megas,70MegasSt,70MegasD,80Megas,80MegasSt,80MegasD,90Megas,90MegasSt,90MegasD,100Megas,100MegasSt,100MegasD,Cortados'),
(7, 'villanueva', '80.0.0.1', '80.0.0.2', '', 3, 1, '3Megas,5Megas,5MegasD,10Megas,10MegasSt,10MegasD,15Megas,15MegasD,20Megas,20MegasSt,20MegasD,30Megas,30MegasSt,30MegasD,40Megas,40MegasSt,40MegasD,50Megas,50MegasSt,50MegasD,60Megas,60MegasSt,60MegasD,70Megas,70MegasSt,70MegasD,80Megas,80MegasSt,80MegasD,90Megas,90MegasSt,90MegasD,100Megas,100MegasSt,100MegasD,Cortados'),
(8, 'villanueva gpon', '10.20.0.1', '10.20.0.2', 'GPON', 3, NULL, '');
COMMIT;

------------------------------------------------------------

--- cambios para sede accede multiple --------------------------------------------
Update aauth_users set sede_accede='-0-' where id=8
Update aauth_users set sede_accede='-0-' where id=13
Update aauth_users set sede_accede='-0-' where id=17
Update aauth_users set sede_accede='-0-' where id=18
Update aauth_users set sede_accede='-0-' where id=20
Update aauth_users set sede_accede='-0-' where id=22
Update aauth_users set sede_accede='-0-' where id=24
Update aauth_users set sede_accede='-5-' where id=25
Update aauth_users set sede_accede='-0-' where id=27
Update aauth_users set sede_accede='-2-' where id=28
Update aauth_users set sede_accede='-2-' where id=29
Update aauth_users set sede_accede='-2-' where id=31
Update aauth_users set sede_accede='-0-' where id=32
Update aauth_users set sede_accede='-4-' where id=33
Update aauth_users set sede_accede='-4-' where id=34
Update aauth_users set sede_accede='-4-' where id=35
Update aauth_users set sede_accede='-4-' where id=36
Update aauth_users set sede_accede='-3-' where id=37
Update aauth_users set sede_accede='-0-' where id=38
Update aauth_users set sede_accede='-7-' where id=41
Update aauth_users set sede_accede='-2-' where id=43
Update aauth_users set sede_accede='-0-' where id=44
Update aauth_users set sede_accede='-0-' where id=45
Update aauth_users set sede_accede='-3-' where id=48
Update aauth_users set sede_accede='-3-' where id=51
Update aauth_users set sede_accede='-3-' where id=52
Update aauth_users set sede_accede='-3-' where id=53
Update aauth_users set sede_accede='-0-' where id=55
Update aauth_users set sede_accede='-7-' where id=56
Update aauth_users set sede_accede='-0-' where id=57
Update aauth_users set sede_accede='-2-' where id=62
Update aauth_users set sede_accede='-2-' where id=63
Update aauth_users set sede_accede='-2-' where id=64
Update aauth_users set sede_accede='-3-' where id=68
Update aauth_users set sede_accede='-3-' where id=70
Update aauth_users set sede_accede='-2-' where id=71
Update aauth_users set sede_accede='-3-' where id=74
Update aauth_users set sede_accede='-2-' where id=76
Update aauth_users set sede_accede='-0-' where id=82
Update aauth_users set sede_accede='-2-' where id=83
Update aauth_users set sede_accede='-2-' where id=86
Update aauth_users set sede_accede='-2-' where id=87
Update aauth_users set sede_accede='-0-' where id=89
Update aauth_users set sede_accede='-2-' where id=90
Update aauth_users set sede_accede='-0-' where id=91
Update aauth_users set sede_accede='-2-' where id=93
Update aauth_users set sede_accede='-0-' where id=94
Update aauth_users set sede_accede='-0-' where id=95
Update aauth_users set sede_accede='-0-' where id=96
Update aauth_users set sede_accede='-0-' where id=98
Update aauth_users set sede_accede='-4-' where id=99
Update aauth_users set sede_accede='-2-' where id=101
Update aauth_users set sede_accede='-3-' where id=102
Update aauth_users set sede_accede='-0-' where id=103
Update aauth_users set sede_accede='-3-' where id=105
Update aauth_users set sede_accede='-3-' where id=106
Update aauth_users set sede_accede='-2-' where id=108
Update aauth_users set sede_accede='-4-' where id=109
Update aauth_users set sede_accede='-2-' where id=110
Update aauth_users set sede_accede='-3-' where id=111
Update aauth_users set sede_accede='-6-' where id=112
Update aauth_users set sede_accede='-6-' where id=113
Update aauth_users set sede_accede='-2-' where id=114
Update aauth_users set sede_accede='-3-' where id=115
Update aauth_users set sede_accede='-3-' where id=116
Update aauth_users set sede_accede='-0-' where id=117
Update aauth_users set sede_accede='-0-' where id=119
Update aauth_users set sede_accede='-3-' where id=120
Update aauth_users set sede_accede='-0-' where id=121
Update aauth_users set sede_accede='-3-' where id=124

---------cambios ips- -----------------------------------------------------------------------

CREATE TABLE `ips_users_mk` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ip_local` varchar(100) NOT NULL,
  `ip_remota` varchar(100) NOT NULL,
  `tegnologia` varchar(40) NOT NULL,
  `sede` int(11) NOT NULL,
  `defecto` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ips_users_mk`
--

INSERT INTO `ips_users_mk` (`id`, `nombre`, `ip_local`, `ip_remota`, `tegnologia`, `sede`, `defecto`) VALUES
(1, 'Yopal', '10.0.0.1', '10.0.0.2', '', 2, 1),
(2, 'Yopal GPON', '10.100.0.1', '10.100.0.2', 'GPON', 2, NULL),
(3, 'aguazul', '10.100.0.1', '10.100.0.2', '', 6, NULL),
(4, 'tauramena', '10.100.0.1', '10.100.0.2', '', 7, NULL),
(5, 'villavo', '10.0.0.1', '10.0.0.2', '', 8, NULL),
(6, 'monterrey', '10.1.100.1', '10.1.100.2', '', 4, NULL),
(7, 'villanueva', '80.0.0.1', '80.0.0.2', '', 3, 1),
(8, 'villanueva gpon', '10.20.0.1', '10.20.0.2', 'GPON', 3, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ips_users_mk`
--
ALTER TABLE `ips_users_mk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ips_users_mk`
--
ALTER TABLE `ips_users_mk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
---------------------------------------------------------------------------------
ALTER TABLE `customers` ADD `dats_last_report` VARCHAR(2000) NULL AFTER `ids_transacciones_rp`;
-----------mas cambios mikrotiks--------------------------------------------
ALTER TABLE `mikrotiks` ADD `estado_coneccion` TINYINT NULL AFTER `defecto`;
DELETE FROM `variables_de_entorno` WHERE `variables_de_entorno`.`id` = 3

-----------------------------------------------------------------------------
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `mikrotiks` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `puerto` varchar(15) NOT NULL,
  `tegnologia` varchar(40) NOT NULL,
  `sede` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `defecto` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `mikrotiks` (`id`, `nombre`, `ip`, `puerto`, `tegnologia`, `sede`, `usuario`, `password`, `defecto`) VALUES
(1, 'Yopal', '190.14.233.186', '5051', '', 2, 'api.crmvestel', 'Vestel1957', 1),
(2, 'Ip_Villanueva_GPON', '190.14.238.115', '8728', 'GPON', 3, 'api.crmvestel', 'Vestel1957', 1),
(3, 'Ip_Villanueva_EPON', '190.2.214.186', '5000', 'EPON', 3, 'api.crmvestel', 'Vestel1957', NULL),
(4, 'Ip_Villanueva_EOC', '190.2.214.186', '5000', 'EOC', 3, 'api.crmvestel', 'Vestel1957', NULL),
(5, 'ip_Monterrey', '190.14.248.42', '8728', '', 4, 'api.crmvestel', 'Vestel1957', 1),
(6, 'ip_Aguazul', '186.148.180.74', '8728', '', 6, 'api.crmvestel', 'Vestel1957', 1),
(7, 'ip_tauramena', '190.2.209.162', '5051', '', 7, 'api.crmvestel', 'Vestel1957', 1),
(8, 'ip_villavo', '200.91.204.50', '8728', '', 8, 'api.crmvestel', 'Vestel1957', 1);

ALTER TABLE `mikrotiks`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mikrotiks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
-------------update ever error ---------------
UPDATE `product_warehouse` SET `id_tecnico` = 'EverMorenoTEC' WHERE `product_warehouse`.`id` = 36;

------------------------- cambios servicios especiales net -----------------------
ALTER TABLE `invoices` CHANGE `combo` `combo` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
UPDATE `invoices` SET `combo` = 'Hilo Oscuro Medelink' WHERE `invoices`.`id` = 209159;

----------------------NOTIFICACION DE CAMPOS FALTANTES CUSTOMER---------------
CREATE TABLE `crm3`.`config_campos_faltantes_customer` (`id` INT NOT NULL AUTO_INCREMENT , `ck_celular1` TINYINT NOT NULL , `ck_celular2` TINYINT NOT NULL , `ck_correo` TINYINT NOT NULL , `description` VARCHAR(1000) NOT NULL , `estado` ENUM('Activo','Inactivo') NOT NULL , `id_customer` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

---------------------- FILTROS ACTAS --------------------------------------------------------------------
ALTER TABLE `transferencia_products_orden` ADD `fecha` DATETIME NULL AFTER `cantidad`;
----------------------ACTAS--------------------------------------------------------------------
ALTER TABLE `acta_transferencias` ADD `estado` ENUM('Recibida') NULL AFTER `id_usuario_que_transfiere`, ADD `id_usuario_recibe` INT NULL AFTER `estado`, ADD `fecha_recepcion` DATETIME NULL AFTER `id_usuario_recibe`;

--------------------------------------------------sql ACTAS DE TRANSFERENCIAS de MATERIAl---------------------
INSERT INTO `modulos` (`id_modulo`, `rol`, `nombre`, `id_padre`, `codigo`, `orden`, `icono`) VALUES (NULL, 'Hijo', 'Administrar Actas de Transferencias', '14', 'invadminstrar_actas', '0', NULL);


CREATE TABLE `crm`.`acta_transferencias` (`id` INT NOT NULL AUTO_INCREMENT , `fecha` DATETIME NOT NULL , `almacen_origen` INT NOT NULL , `almacen_destino` INT NOT NULL , `observaciones` VARCHAR(700)  NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `acta_transferencias` ADD `id_usuario_que_transfiere` INT NOT NULL AFTER `observaciones`;


CREATE TABLE `crm`.`items_acta_transferencias` (`id` INT NOT NULL AUTO_INCREMENT , `id_transferencia` INT NOT NULL , `cantidad` INT NOT NULL , `id_acta_transferencia` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

---------------------------------------------------------------------------
Nuevo Calendario

INSERT INTO `modulos` (`id_modulo`, `rol`, `nombre`, `id_padre`, `codigo`, `orden`, `icono`) VALUES (NULL, 'Padre', 'Nuevo Calendario', NULL, 'calnew', '19', 'icon-calendar2');


-------------------------------------------------------------------------------
-------------------------------------------------------------------------------------transferencias
ALTER TABLE `meta_data` ADD `col3` INT NULL AFTER `col2`;
------------------------------notificaciones------------------------------------------
CREATE TABLE `crm`.`notificaciones_tarea` 


(`id` INT NOT NULL AUTO_INCREMENT ,


 `descripcion` VARCHAR(10) NULL , 


`fecha` DATETIME NOT NULL , `id_tarea` INT NOT NULL , 


`estado` ENUM('emitida','aceptada') NOT NULL ,

`id_notificar` INT NOT NULL,

 PRIMARY KEY (`id`)) ENGINE = InnoDB;
 -------------------------------------------------------------------------------------


--cambios modificaciones resivos de pago--------------------------------------------------

ALTER TABLE `customers` ADD `ids_transacciones_rp` VARCHAR(170) NULL AFTER `fecha_cambio`;
        
        CREATE TABLE `crm`.`recibos_de_pago` (`id` INT NOT NULL AUTO_INCREMENT , `date` DATETIME NOT NULL , `file_name` VARCHAR(200) NOT NULL ,`tid` INT NOT NULL, PRIMARY KEY (`id`)) ENGINE = InnoDB;
        
        CREATE TABLE `crm`.`transactions_ids_recibos_de_pago` (`id` INT NOT NULL AUTO_INCREMENT , `id_recibo_de_pago` INT NOT NULL , `id_transaccion` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;        

-------------------------------------------------------------------------------------------

ALTER TABLE `accounts` ADD `direccion` VARCHAR(500) NOT NULL AFTER `code`;
ALTER TABLE `accounts` ADD `departamento` VARCHAR(500) NOT NULL AFTER `direccion`;
ALTER TABLE `accounts` ADD `telefono` VARCHAR(50) NULL AFTER `direccion`;
UPDATE `app_system` SET `logo` = '1574342263394687344.png' WHERE `app_system`.`id` = 1;

UPDATE `accounts` SET `departamento` = 'Casanare' WHERE `accounts`.`id` = 1;
UPDATE `accounts` SET `departamento` = 'Casanare' WHERE `accounts`.`id` = 3;
UPDATE `accounts` SET `departamento` = 'Casanare' WHERE `accounts`.`id` = 4;
UPDATE `accounts` SET `departamento` = 'Casanare' WHERE `accounts`.`id` = 5;
UPDATE `accounts` SET `direccion` = 'Carrera 20 N° 26 - 80 Provivienda' WHERE `accounts`.`id` = 3;
UPDATE `accounts` SET `direccion` = 'Carrera 7 N° 11 - 47 Bello Horizonte' WHERE `accounts`.`id` = 1;
UPDATE `accounts` SET `direccion` = 'Calle 20A N° 13 - 36 Barrio Esteros' WHERE `accounts`.`id` = 5;


UPDATE `accounts` SET `telefono` = '(320) 431-8846' WHERE `accounts`.`id` = 1;
UPDATE `accounts` SET `telefono` = '(320) 234-3866' WHERE `accounts`.`id` = 3;
UPDATE `accounts` SET `telefono` = '(314) 353-3265' WHERE `accounts`.`id` = 5;
-----------------------------------------------------

ALTER TABLE `transactions` ADD `id_orden_payu` VARCHAR(30) NULL AFTER `no_mostrar`;


INSERT INTO `accounts` (`id`, `acn`, `holder`, `sede`, `adate`, `lastbal`, `code`) VALUES (NULL, '967931', 'PAYU', '0', '', '31642', 'Cuenta PAYU');

//estadisticas servicios

ALTER TABLE `estadisticas_servicios` ADD `debido_cortados` INT NULL AFTER `debido_activos`;
ALTER TABLE `estadisticas_servicios` ADD `debido_cartera` INT NULL AFTER `debido_cortados`;
ALTER TABLE `estadisticas_servicios` ADD `debido_suspendidos` INT NULL AFTER `debido_cartera`;
ALTER TABLE `estadisticas_servicios` ADD `debido_retirados` INT NULL AFTER `debido_suspendidos`;
ALTER TABLE `estadisticas_servicios` ADD `n_internet_vill` INT NULL AFTER `debido_retirados`;
ALTER TABLE `estadisticas_servicios` ADD `n_tv_vill` INT NULL AFTER `n_internet_vill`;
ALTER TABLE `estadisticas_servicios` ADD `internet_y_tv_act_vill` INT NULL AFTER `n_tv_vill`;
ALTER TABLE `estadisticas_servicios` ADD `cor_int_vill` INT NULL AFTER `internet_y_tv_act_vill`;
ALTER TABLE `estadisticas_servicios` ADD `cor_tv_vill` INT NULL AFTER `cor_int_vill`;
ALTER TABLE `estadisticas_servicios` ADD `internet_y_tv_cor_vill` INT NULL AFTER `cor_tv_vill`;
ALTER TABLE `estadisticas_servicios` ADD `car_int_vill` INT NULL AFTER `internet_y_tv_cor_vill`;
ALTER TABLE `estadisticas_servicios` ADD `car_tv_vill` INT NULL AFTER `car_int_vill`;
ALTER TABLE `estadisticas_servicios` ADD `internet_y_tv_car_vill` INT NULL AFTER `car_tv_vill`;
ALTER TABLE `estadisticas_servicios` ADD `sus_int_vill` INT NULL AFTER `internet_y_tv_car_vill`;
ALTER TABLE `estadisticas_servicios` ADD `sus_tv_vill` INT NULL AFTER `sus_int_vill`;
ALTER TABLE `estadisticas_servicios` ADD `internet_y_tv_sus_vill` INT NULL AFTER `sus_tv_vill`;
ALTER TABLE `estadisticas_servicios` ADD `ret_int_vill` INT NULL AFTER `internet_y_tv_sus_vill`;
ALTER TABLE `estadisticas_servicios` ADD `ret_tv_vill` INT NULL AFTER `ret_int_vill`;
ALTER TABLE `estadisticas_servicios` ADD `internet_y_tv_ret_vill` INT NULL AFTER `ret_tv_vill`;
ALTER TABLE `estadisticas_servicios` ADD `debido_act_vill` INT NULL AFTER `internet_y_tv_ret_vill`;
ALTER TABLE `estadisticas_servicios` ADD `debido_cor_vill` INT NULL AFTER `debido_act_vill`;
ALTER TABLE `estadisticas_servicios` ADD `debido_car_vill` INT NULL AFTER `debido_cor_vill`;
ALTER TABLE `estadisticas_servicios` ADD `debido_sus_vill` INT NULL AFTER `debido_car_vill`;
ALTER TABLE `estadisticas_servicios` ADD `debido_ret_vill` INT NULL AFTER `debido_sus_vill`;
ALTER TABLE `estadisticas_servicios` ADD `n_internet_mon` INT NULL AFTER `debido_ret_vill`;
ALTER TABLE `estadisticas_servicios` ADD `n_tv_mon` INT NULL AFTER `n_internet_mon`;
ALTER TABLE `estadisticas_servicios` ADD `internet_y_tv_act_mon` INT NULL AFTER `n_tv_mon`;
ALTER TABLE `estadisticas_servicios` ADD `cor_int_mon` INT NULL AFTER `internet_y_tv_act_mon`;
ALTER TABLE `estadisticas_servicios` ADD `cor_tv_mon` INT NULL AFTER `cor_int_mon`;
ALTER TABLE `estadisticas_servicios` ADD `internet_y_tv_cor_mon` INT NULL AFTER `cor_tv_mon`;
ALTER TABLE `estadisticas_servicios` ADD `car_int_mon` INT NULL AFTER `internet_y_tv_cor_mon`;
ALTER TABLE `estadisticas_servicios` ADD `car_tv_mon` INT NULL AFTER `car_int_mon`;
ALTER TABLE `estadisticas_servicios` ADD `internet_y_tv_car_mon` INT NULL AFTER `car_tv_mon`;
ALTER TABLE `estadisticas_servicios` ADD `sus_int_mon` INT NULL AFTER `internet_y_tv_car_mon`;
ALTER TABLE `estadisticas_servicios` ADD `sus_tv_mon` INT NULL AFTER `sus_int_mon`;
ALTER TABLE `estadisticas_servicios` ADD `internet_y_tv_sus_mon` INT NULL AFTER `sus_tv_mon`;
ALTER TABLE `estadisticas_servicios` ADD `ret_int_mon` INT NULL AFTER `internet_y_tv_sus_mon`;
ALTER TABLE `estadisticas_servicios` ADD `ret_tv_mon` INT NULL AFTER `ret_int_mon`;
ALTER TABLE `estadisticas_servicios` ADD `internet_y_tv_ret_mon` INT NULL AFTER `ret_tv_mon`;
ALTER TABLE `estadisticas_servicios` ADD `debido_act_mon` INT NULL AFTER `internet_y_tv_ret_mon`;
ALTER TABLE `estadisticas_servicios` ADD `debido_cor_mon` INT NULL AFTER `debido_act_mon`;
ALTER TABLE `estadisticas_servicios` ADD `debido_car_mon` INT NULL AFTER `debido_cor_mon`;
ALTER TABLE `estadisticas_servicios` ADD `debido_sus_mon` INT NULL AFTER `debido_car_mon`;
ALTER TABLE `estadisticas_servicios` ADD `debido_ret_mon` INT NULL AFTER `debido_sus_mon`;
----------------------------------------------------------------------------------------------------------------------------------------
CREATE TABLE `vestel_com_co_crm_202231794677`.`data_reception` ( `id` INT NULL AUTO_INCREMENT , `data` TEXT NOT NULL , `fecha` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

--------------------------------------------------------------------------------------------------------
ALTER TABLE `transactions` ADD `no_mostrar` TINYINT(5) NOT NULL DEFAULT '0' AFTER `estado`;
----------------------------------------------------------------------------------------------
ACUERDOS DE PAGO
ALTER TABLE `llamadas` ADD `fecha_vence` DATE NULL AFTER `hra`;
----------------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm3`.`orden_de_pago` (
  `id_orden_de_pago` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `data` VARCHAR(2000) NULL DEFAULT NULL,
  `metodo_pago` VARCHAR(45) NULL DEFAULT NULL,
  `monto` INT(11) NULL DEFAULT NULL,
  `fecha` DATETIME NULL DEFAULT NULL,
  `user_id` INT(11) NOT NULL,
  PRIMARY KEY (`id_orden_de_pago`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;
ALTER TABLE `goals` ADD `users` ENUM('Link Publicado','Pagado','Cancelado','Expirado') NOT NULL AFTER `user_id`;
ALTER TABLE `goals` ADD `users` BIGINT(20) NULL DEFAULT NULL AFTER `netincome`;
ALTER TABLE `orden_de_pago` ADD `expire_date` DATETIME NULL DEFAULT NULL AFTER `nombre_referencia`;
------------------------------------------------------------------------------------
ALTER TABLE `users` ADD `img_profile` VARCHAR(100) NULL AFTER `cid`;
----------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm5`.`servicios_adicionales` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tid_invoice` INT(11) NOT NULL,
  `pid` INT(11) NOT NULL,
  `valor` VARCHAR(50) NOT NULL COMMENT 'valor es decir la cantidad o valor de lo que solicita ejemplo 5 repetidores',
  `subtotal` INT(11) NOT NULL,
  `total` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-------------------------------------------------------------------------------------------------------------
ALTER TABLE `customers` ADD `ultimo_estado` VARCHAR(50) NULL AFTER `firma_digital`, ADD `fecha_cambio` DATETIME NULL AFTER `ultimo_estado`;
--------------------------------------------------------------------------------
ALTER TABLE `aauth_users` ADD `fecha_ultimo_evento` DATE NULL AFTER `tar`;
-------------------------------------------------------------------------------
ALTER TABLE `equipos` ADD `imagen` INT NOT NULL AFTER `master`;
----------------------------------------------------------------------
INSERT INTO `variables_de_entorno` (`id`, `valor`, `nombre_api`) VALUES (NULL, '{\"user\":\"sistemas@vestel.com.co\",\"password\":\"Vestel1957*\"}', 'payu');
---------------------------------------------------------------------------
ALTER TABLE `events` ADD `id_tarea` INT NULL AFTER `idorden`;
----------------------------------------------------------------------------------------------
ALTER TABLE `transferencia_products_orden` ADD `id_tarea` INT NULL AFTER `proy_id`;
--------------------------------------------------------------------------------------------
ALTER TABLE `aauth_users` ADD `redcon` TINYINT(4) NULL AFTER `redbod`;
ALTER TABLE `aauth_users` ADD `dathistorial` TINYINT(4) NULL AFTER `datimp`;

--------------------------------------------------------------------------------------------
ALTER TABLE `invoice_items` ADD `fecha_creacion` DATETIME NULL AFTER `id_usuario_crea`;
ALTER TABLE `invoice_items` ADD `id_usuario_crea` INT NULL AFTER `tax_removed`;




CREATE TABLE IF NOT EXISTS `crm`.`historial_crm` (
  `id` BIGINT(19) UNSIGNED NOT NULL AUTO_INCREMENT,
  `modulo` VARCHAR(250) NULL DEFAULT NULL,
  `accion` VARCHAR(250) NULL DEFAULT NULL,
  `id_usuario` VARCHAR(250) NULL DEFAULT NULL,
  `fecha` DATETIME NULL DEFAULT NULL,
  `descripcion` VARCHAR(2000) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;
ALTER TABLE `historial_crm` ADD `id_fila` INT NOT NULL COMMENT 'id de la fila creada o editada en el modulo' AFTER `descripcion`;
ALTER TABLE `historial_crm` ADD `tabla` VARCHAR(100) NOT NULL AFTER `id_fila`;
ALTER TABLE `historial_crm` ADD `nombre_columna` VARCHAR(100) NOT NULL AFTER `tabla`;
-------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`archivos_historias_tareas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_tarea` INT(11) NULL DEFAULT NULL,
  `id_historia_tarea` INT(11) NULL DEFAULT NULL,
  `nombre` VARCHAR(250) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS `crm`.`historial_tareas` (
  `id_historial_tareas` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_usuario_historial` INT(11) NULL DEFAULT NULL,
  `id_tarea` INT(11) NULL DEFAULT NULL,
  `comentario` TEXT NULL DEFAULT NULL,
  `fecha` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id_historial_tareas`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE `historial_tareas` ADD `titulo` VARCHAR(250) NULL AFTER `fecha`;

ALTER TABLE `historial_tareas` ADD `color` VARCHAR(20) NULL AFTER `titulo`;



--------------------------------------------------------------------------------------
ALTER TABLE `todolist` ADD `puntuacion` SMALLINT NULL DEFAULT NULL AFTER `rid`;

------------------------------------------------------------------------------------------------
INSERT INTO `products` (`pid`, `pcat`, `warehouse`, `sede`, `product_name`, `product_code`, `product_price`, `fproduct_price`, `taxrate`, `disrate`, `qty`, `product_des`, `alert`, `id_prod_transfer`) VALUES (NULL, '4', '30', '4', '15MegasD', '15MGD', '299900', '299900', '0', '0', '50000', '', '0', '0')
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
ALTER TABLE `customers` ADD `firma_digital` TINYINT NULL DEFAULT NULL AFTER `tegnologia_instalacion`;
--------------------------------------------------------------------------------------------------------
ALTER TABLE `estadisticas_servicios` ADD `internet_y_tv` INT NULL AFTER `n_tv`;
-----------------------------------------------------------------------------------
ALTER TABLE `invoice_items` ADD `tax_removed` INT NULL AFTER `product_des`;

----------------------------------------------------------------------------------------
ALTER TABLE `tickets` CHANGE `status` `status` ENUM('Realizando','Resuelto','Anulada','Pendiente') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
-------------------------------------------------------------------------------------------------------------------------------------------------------------------
ALTER TABLE `invoices` CHANGE `resivos_guardados` `resivos_guardados` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `temporales` CHANGE `puntos` `puntos` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
------------------------------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`estadisticas_servicios` (
  `id_estadisticas_servicios` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `n_internet` INT(11) NOT NULL,
  `n_tv` INT(11) NOT NULL,
  `n_activo` INT(11) NOT NULL,
  `fecha` DATE NOT NULL,
  PRIMARY KEY (`id_estadisticas_servicios`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;
-------------------------------------------sql para estadisticas---------------------------------------

SELECT * FROM `transactions` WHERE `note` LIKE '%Saldo 2021%'; 
update transactions set tid=-1 where note like "%Saldo 2021%";
-----------------------------------------para verificar y colocar bandera para saber cuales son las transacciones de caja----------------------
UPDATE `variables_de_entorno` SET `valor` = '{\"username\":\"api.crmvestel\",\"password\":\"duber123\",\"ip_Yopal\":\"190.14.233.186:8728\",\"Ip_Villanueva_GPON\":\"190.14.238.114:8728\",\"Ip_Villanueva_EPON\":\"190.14.238.114:8780\",\"Ip_Villanueva_EOC\":\"190.14.238.114:8780\",\"ip_Monterrey\":\"190.14.248.42:8728\"}' WHERE `variables_de_entorno`.`id` = 3
ALTER TABLE `customers` ADD `tegnologia_instalacion` VARCHAR(25) NULL AFTER `credit`;
ALTER TABLE `aauth_users` ADD `datservicios` tinyint(4) NULL AFTER `dathistorial`;
-----------------------------------------------------------------------------------------------------------------
ALTER TABLE `estadisticas_servicios` 
ADD `cor_int` INT(11) NULL DEFAULT NULL AFTER `n_activo`, 
ADD `cor_tv` INT(11) NULL DEFAULT NULL AFTER `cor_int`, 
ADD `car_int` INT(11) NULL DEFAULT NULL AFTER `cor_tv`,
ADD `car_tv` INT(11) NULL DEFAULT NULL AFTER `car_int`,
ADD `sus_int` INT(11) NULL DEFAULT NULL AFTER `car_tv`,
ADD `sus_tv` INT(11) NULL DEFAULT NULL AFTER `sus_int`,
ADD `ret_int` INT(11) NULL DEFAULT NULL AFTER `sus_tv`,
ADD `ret_tv` INT(11) NULL DEFAULT NULL AFTER `ret_int`;
----------------------------------------------------------------------------------------------------------
CAMBIOS METAS DE GASTOS
---------------------------------------------------------
ALTER TABLE `goals` 
ADD `vesagro` BIGINT(20) NOT NULL AFTER `users`, 
ADD `servicios` BIGINT(20) NOT NULL AFTER `vesagro`, 
ADD `compras` BIGINT(20) NOT NULL AFTER `servicios`, 
ADD `creditos` BIGINT(20) NOT NULL AFTER `compras`,
ADD `nomina` BIGINT(20) NOT NULL AFTER `creditos`,
ADD `socios` BIGINT(20) NOT NULL AFTER `nomina`,
ADD `oficial` BIGINT(20) NOT NULL AFTER `socios`;
---------------------------------------------------------------------------------------
ALTER TABLE `tickets` ADD `asignacion_movil` INT NULL DEFAULT NULL AFTER `par`;
-----------------------------cambios para poder cambiar variables desde el sistema para ejemplo cellvos o otras integraciones-------------
CREATE TABLE IF NOT EXISTS `variables_de_entorno` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `valor` VARCHAR(2000) NULL,
  `nombre_api` VARCHAR(70) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;
INSERT INTO `variables_de_entorno` (`id`, `valor`, `nombre_api`) VALUES (NULL, '{"account":"00486800430","password":"Tvsur2018","api_key":"8529863e6706e0659cb610dfaded9c36db43e989"}', 'cellvoz');
------------mas----
INSERT INTO `variables_de_entorno` (`id`, `valor`, `nombre_api`) VALUES (NULL, '{"username":"VESGATELEVISIONSAS\\\\\\\\VESGAT17681@apionmicrosoft.com","password":")QP>x3(9dN","Authorization_basic":"U2lpZ29XZWI6QUJBMDhCNkEtQjU2Qy00MEE1LTkwQ0YtN0MxRTU0ODkxQjYx"}', 'siigo')
INSERT INTO `variables_de_entorno` (`id`, `valor`, `nombre_api`) VALUES (NULL, '{"username":"api.crmvestel","password":"duber123","ip_Yopal":"190.14.233.186:8728","ip_Villanueva":"190.14.238.114:8728","ip_Monterrey":"190.14.248.42:8728"}', 'MikroTik')
---------------------------------------------------------------------------------------------------------------------------
----------------------------cambios guardar resivos---------------------------------------------
ALTER TABLE `invoices` ADD `resivos_guardados` VARCHAR(500) NOT NULL AFTER `tipo_factura`;
-----------------------------cambios para notacredito y notadebito---------------
ALTER TABLE `invoices` ADD `tipo_factura` VARCHAR(50) NOT NULL AFTER `multi`;
---------------------------cambios en customers para agilizar filtros----------------------------------
ALTER TABLE `customers` ADD `debit` VARCHAR(250) NULL AFTER `checked_seleccionado`, ADD `credit` VARCHAR(250) NULL AFTER `debit`;
--------------------------------------------------------------------------------------------------------
-----------------------------cambios para agregar a la db la seleccion al cortar o enviar mensajes-----------------
ALTER TABLE `customers` ADD `checked_seleccionado` INT NOT NULL DEFAULT '0' AFTER `f_elec_puntos`;
-----------------------------cambios para agregar estados a los servicios de la factura-----------------
ALTER TABLE `invoices` ADD `estado_tv` ENUM('Cortado','Suspendido') NULL AFTER `television`;
ALTER TABLE `invoices` ADD `estado_combo` ENUM('Cortado','Suspendido') NULL AFTER `combo`;
--------------------------------------------------------------------------------------------------------
---------------------------cambios para agregar estado abonado a ordenes de compra------------------------
ALTER TABLE `purchase` CHANGE `status` `status` ENUM('pendiente','cancelado','abonado','recibido','recibido parcial','finalizado','anulado') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'pendiente';

------cambios para la facturacion electronica automatica--------------------------------------------
ALTER TABLE `facturacion_electronica_siigo` ADD `creado_con_multiple` TINYINT NULL AFTER `s2TaxValue`;
ALTER TABLE `customers` ADD `facturar_electronicamente` TINYINT NULL AFTER `balance`;
ALTER TABLE `customers` ADD `f_elec_tv` TINYINT NULL AFTER `facturar_electronicamente`, ADD `f_elec_internet` TINYINT NULL AFTER `f_elec_tv`, ADD `f_elec_puntos` TINYINT NULL AFTER `f_elec_internet`;
-----------------------------------------------------------------------------------------------------
------cambios sobre ordenes de compra -------------
ALTER TABLE `purchase` CHANGE `status` `status` ENUM('pendiente','cancelado','recibido','recibido parcial','finalizado','anulado') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'pendiente';
----------------------------nuevos cambios--------------
ALTER TABLE `purchase` ADD `actualizar_stock` TINYINT NULL AFTER `term`;
ALTER TABLE `purchase` ADD `almacen_seleccionado` INT NULL AFTER `actualizar_stock`;
ALTER TABLE `purchase_items` ADD `qty_en_almacen` INT NULL AFTER `product_des`;
--------------------------------------
ALTER TABLE `transferencia_products_orden` CHANGE `tickets_id` `tickets_id` INT(11) NULL;
ALTER TABLE `equipos` ADD `master` VARCHAR(150) NOT NULL AFTER `observacion`;
ALTER TABLE `tickets` ADD `problema` VARCHAR(150) NOT NULL AFTER `status`;

ALTER TABLE `invoices` CHANGE `ron` `ron` ENUM('Activo','Instalar','Cortado','Suspendido','Exonerado','Cartera','Convenio','Depurado','Retirado','Compromiso') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
-------------------------------
ALTER TABLE `anulaciones` ADD `razon_anulacion` TEXT NOT NULL AFTER `transactions_id`;
ALTER TABLE `anulaciones` ADD `usuario_anula` VARCHAR(100) NOT NULL AFTER `razon_anulacion`;


Cambios para seleccionar sede
ALTER TABLE `tickets` 
ADD `finicial` DATE() NULL AFTER `ip_address`;
ADD `hinicial` TIME() NULL AFTER `finicial`;
ADD `fcierre` DATE() NULL AFTER `hinicial`;
ADD `hcierre` TIME() NULL AFTER `fcierre`;

creo que el sql deve de ser asi puesto que ip_adres es de la tabla aauth_users

ALTER TABLE `aauth_users` ADD `finicial` DATE NULL AFTER `ip_address`;
ALTER TABLE `aauth_users` ADD `hinicial` TIME NULL AFTER `finicial`;
ALTER TABLE `aauth_users` ADD `fcierre` DATE NULL AFTER `hinicial`;
ALTER TABLE `aauth_users` ADD `hcierre` TIME NULL AFTER `fcierre`;
ALTER TABLE `customers` ADD `f_contrato` DATE NULL AFTER `documento`;
ALTER TABLE `customers` ADD `estrato` VARCHAR(20) NULL AFTER `f_contrato`;
//nuevos campos tabla equipos
ALTER TABLE `equipos` ADD `t_instalacion` VARCHAR(10) NULL AFTER `marca`;
ALTER TABLE `equipos` ADD `puerto` INT NULL AFTER `t_instalacion`;
ALTER TABLE `equipos` ADD `vlan` INT NULL AFTER `puerto`;
ALTER TABLE `equipos` ADD `nat` INT NULL AFTER `vlan`;
//nuevos campos tabla 
ALTER TABLE `temporales` ADD `residencia` VARCHAR(50) NULL AFTER `barrio`;
ALTER TABLE `temporales` ADD `referencia` VARCHAR(50) NULL AFTER `residencia`;
ALTER TABLE `events` ADD `asigno` INT NULL AFTER `rol`;
ALTER TABLE `transferencia_products_orden` ADD `proy_id` INT NULL AFTER `tickets_id`;
//nuevos campos tabla historiales
ALTER TABLE `historiales` ADD `colaborador` VARCHAR(20) NULL AFTER `observacion`;
//nuevos campos tabla de cuentas
ALTER TABLE `accounts` ADD `sede` INT NULL AFTER `holder`;
//nuevos campos tabla tickets
ALTER TABLE `tickets` ADD `col` VARCHAR(30) NULL AFTER `cid`;

//nuevos campos tabla employee_profile
ALTER TABLE `employee_profile` ADD `dto` int(50) NOT NULL AFTER `name`;
ALTER TABLE `employee_profile` ADD `ingreso` date DEFAULT NULL AFTER `dto`;
ALTER TABLE `employee_profile` ADD `rh` varchar(10) NOT NULL AFTER `ingreso`;
ALTER TABLE `employee_profile` ADD `eps` varchar(50) NOT NULL AFTER `rh`;
ALTER TABLE `employee_profile` ADD `pensiones` varchar(50) NOT NULL AFTER `eps`;

//nuevos campos tabla grupos
ALTER TABLE `custromers_group` ADD `dir` int(50) NOT NULL AFTER `summary`;
ALTER TABLE `app_system` CHANGE `email` `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;









------------------------------------------


CREATE TABLE `encuestas` (
  `id` int(50) NOT NULL,
  `idemp` int(10) NOT NULL,
  `idtec` varchar(50) NOT NULL,
  `norden` int(10) NOT NULL,
  `detalle` varchar(100) NOT NULL,
  `presentacion` int(10) NOT NULL,
  `trato` int(10) NOT NULL,
  `estado` int(10) NOT NULL,
  `tiempo` text NOT NULL,
  `recomendar` text NOT NULL,
  `observacion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;
COMMIT;
----------------------------------------------------------------------------------------------------------
CATEGORIA DE PROVEEDORES
---------------------------------------------------------
ALTER TABLE `supplier` 
ADD `categoria` int(10) NOT NULL AFTER `id`, 
ADD `pago` varchar(20) NOT NULL AFTER `region`;
INSERT INTO `modulos`(`rol`, `nombre`, `id_padre`, `codigo`, `orden`, `icono`) VALUES ('Hijo','Proveedor de servicios',75,'proser',0,null)
UPDATE `modulos` SET `nombre`='Proveedor de Productos' WHERE `id_modulo`=77
----------------------------------------------------------------------------------------------------------
METAS ORDENES DE COMPRA
---------------------------------------------------------
ALTER TABLE `goals` 
ADD `purchase` BIGINT(20) NOT NULL AFTER `oficial` 
----------------------------------------------------------------------------------------------------------
HISTORIAL DE ESTADOS
---------------------------------------------------------
ALTER TABLE `estados` 
ADD `col` int(10) NOT NULL AFTER `estado` 
----------------------------------------------------------------------------------------------------------
CONEXIONES AJUSTE 2
---------------------------------------------------------
ALTER TABLE `vlans` CHANGE `detalle` `det_vlan` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE `naps` CHANGE `vlan` `idvlan` INT(11) NOT NULL;
ALTER TABLE `naps` CHANGE `detalle` `dir_nap` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE `puertos` CHANGE `nap` `idnap` INT(11) NOT NULL;
ALTER TABLE `puertos` CHANGE `vlan` `idvlan` INT(11) NOT NULL;
-----------------------------------------------------------------------------------------------------------------
ALTER TABLE `formularioats` 
ADD `tarea9` varchar(100) NULL DEFAULT NULL AFTER `tarea8`,
ADD `tarea10` varchar(100) NULL DEFAULT NULL AFTER `tarea9`,
ADD `riesgo9` varchar(100) NULL DEFAULT NULL AFTER `riesgo8`,
ADD `riesgo10` varchar(100) NULL DEFAULT NULL AFTER `riesgo9`,
ADD `consecuencia9` varchar(100) NULL DEFAULT NULL AFTER `consecuencia8`,
ADD `consecuencia10` varchar(100) NULL DEFAULT NULL AFTER `consecuencia9`,
ADD `control9` varchar(100) NULL DEFAULT NULL AFTER `control8`,
ADD `control10` varchar(100) NULL DEFAULT NULL AFTER `control9`;
-----------------------------------------------------------------------------------------------------------------
ALTER TABLE `vlans` 
ADD `olt` varchar(100) NULL DEFAULT NULL AFTER `vlan`,
ADD `bandeja` int(10) NULL DEFAULT NULL AFTER `olt`,
ADD `puertolt` int(10) NULL DEFAULT NULL AFTER `bandeja`;

ALTER TABLE `purchase` CHANGE `status` `status` ENUM('pendiente','cancelado','abonado','recibido','recibido parcial','finalizado','anulado','aprobado') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'pendiente';
-----------------------------------------------------------------------------------------------------------------
ALTER TABLE `purchase` 
ADD `aid` int(5) NULL DEFAULT 0 AFTER `eid`;
-----------------------------------------------------------------------------------------------------------------
INSERT INTO `modulos` (`id_modulo`, `rol`, `nombre`, `id_padre`, `codigo`, `orden`, `icono`) VALUES (NULL, 'Hijo', 'Adm. ordenes de servicio', '20', 'comadmser', '0', NULL);
----------------------------------------------------------------------------------------------------------PROMOCIONES 4 G
------------------------
ALTER TABLE `promos` 
ADD `colaborador` varchar(100) NULL DEFAULT NULL AFTER `porcentaje`;
----------------------------------------------------------------------------------------------------------
CATEGORIAS DE ORDENES 1 G
--------------------------------------
ALTER TABLE `purchase` 
ADD `idcat` varchar(50) NULL DEFAULT NULL AFTER `csd`;
----------------------------------------------------------------------------------------------------------
NUEVAS METAS 1 G
--------------------------------------
ALTER TABLE `goals` 
ADD `internet` BIGINT(20) NOT NULL AFTER `oficial`,
ADD `programadora` BIGINT(20) NOT NULL AFTER `internet`,
ADD `impuestos` BIGINT(20) NOT NULL AFTER `programadora`,
ADD `publicos` BIGINT(20) NOT NULL AFTER `impuestos`,
ADD `comisiones` BIGINT(20) NOT NULL AFTER `publicos`,
ADD `celulares` BIGINT(20) NOT NULL AFTER `comisiones`;
----------------------------------------------------------------------------------------------------------
HISTORIAL INVENTARIOS 1 G
--------------------------------------
INSERT INTO `modulos` (`id_modulo`, `rol`, `nombre`, `id_padre`, `codigo`, `orden`, `icono`) VALUES (NULL, 'Hijo', 'Historial', '14', 'inhis', '0', NULL);
----------------------------------------------------------------------------------------------------------
HISTORIAL ORDENES 1 G
--------------------------------------
INSERT INTO `modulos` (`id_modulo`, `rol`, `nombre`, `id_padre`, `codigo`, `orden`, `icono`) VALUES (NULL, 'Hijo', 'Historial ordenes', '20', 'comhis', '0', NULL);
----------------------------------------------------------------------------------------------------------
EMPLEADOS AREA 1 G
--------------------------------------
ALTER TABLE `employee_profile` 
ADD `area` int(10) NOT NULL AFTER `country`;
----------------------------------------------------------------------------------------------------------
ACTUALIZACION DE CONTRATO 1 G
--------------------------------------
ALTER TABLE `temporales` 
ADD `pago` varchar(10) NULL DEFAULT NULL AFTER `puntos`;
----------------------------------------------------------------------------------------------------------
PROMOCION EN FACTURAS
---------------------------------------------------------
ALTER TABLE `invoices` 
__________________________________________________________________________________________________________
NUEVOS CAMPOS AGREGAR USUARIO
----------------------------------------------------------------------------------------------------------
ALTER TABLE `customers`
ADD `suscripcion` VARCHAR(15) NOT NULL AFTER `estrato`,
ADD `divicion` VARCHAR(15) NOT NULL AFTER `referencia`,
ADD `divnum1` INT NOT NULL AFTER `divicion`,
ADD `divicion2` VARCHAR(15) NOT NULL AFTER `divnum1`,
ADD `divnum2` INT NOT NULL AFTER `divicion2`,
ADD `dirsuscriptor` VARCHAR(100) NOT NULL AFTER `divnum2`;
__________________________________________________________________________________________________________
PROMOCIONES 2
----------------------------------------------------------------------------------------------------------
ALTER TABLE `invoices` ADD `promo2` INT NOT NULL DEFAULT '0' AFTER `promo`;
__________________________________________________________________________________________________________
CLAUSULA
----------------------------------------------------------------------------------------------------------
ALTER TABLE `customers` ADD `clausula` INT NOT NULL DEFAULT '0' AFTER `dirsuscriptor`;
-----------------------------------------------------------------------------------------------------------
cambios en facturacion electronica

ALTER TABLE `invoices` ADD `facturacion_electronica` ENUM('Crear Factura Electronica','Factura Electronica Creada') NULL AFTER `tipo_retencion`;
ALTER TABLE `invoices` ADD `fecha_f_electronica_generada` DATE NULL AFTER `facturacion_electronica`;
ALTER TABLE `invoices` ADD `servicios_facturados_electronicamente` VARCHAR(50) NULL AFTER `fecha_f_electronica_generada`;
ALTER TABLE `invoices` ADD `fecha_modifica_promo` DATE NULL AFTER `promo2`;
ALTER TABLE `invoices` CHANGE `promo` `promo` INT(10) NULL DEFAULT NULL; 
UPDATE `invoices` SET `promo` = NULL WHERE `invoices`.`promo` = 0; 
ALTER TABLE `invoices` ADD `fecha_modifica_promo2` DATE NULL AFTER `promo2`;
ALTER TABLE `invoices` CHANGE `promo2` `promo2` INT(10) NULL DEFAULT NULL; 
UPDATE `invoices` SET `promo2` = NULL WHERE `invoices`.`promo2` = 0;
----------------------------------------------------------------------------------------------------------
AGRAGANDO SEDES DINAMICAS 1 G
--------------------------------------
ALTER TABLE `estadisticas_servicios` 
ADD `n_internet_6` int(10) NOT NULL AFTER `debido_ret_mon`,
ADD `n_tv_6` int(10) NOT NULL AFTER `n_internet_6`,
ADD `internet_y_tv_act_6` int(10) NOT NULL AFTER `n_tv_6`,
ADD `cor_int_6` int(10) NOT NULL AFTER `internet_y_tv_act_6`,
ADD `cor_tv_6` int(10) NOT NULL AFTER `cor_int_6`,
ADD `internet_y_tv_cor_6` int(10) NOT NULL AFTER `cor_tv_6`,
ADD `car_int_6` int(10) NOT NULL AFTER `internet_y_tv_cor_6`,
ADD `car_tv_6` int(10) NOT NULL AFTER `car_int_6`,
ADD `internet_y_tv_car_6` int(10) NOT NULL AFTER `car_tv_6`,
ADD `sus_int_6` int(10) NOT NULL AFTER `internet_y_tv_car_6`,
ADD `sus_tv_6` int(10) NOT NULL AFTER `sus_int_6`,
ADD `internet_y_tv_sus_6` int(10) NOT NULL AFTER `sus_tv_6`,
ADD `ret_int_6` int(10) NOT NULL AFTER `internet_y_tv_sus_6`,
ADD `ret_tv_6` int(10) NOT NULL AFTER `ret_int_6`,
ADD `internet_y_tv_ret_6` int(10) NOT NULL AFTER `ret_tv_6`,
ADD `debido_act_6` int(10) NOT NULL AFTER `internet_y_tv_ret_6`,
ADD `debido_cor_6` int(10) NOT NULL AFTER `debido_act_6`,
ADD `debido_car_6` int(10) NOT NULL AFTER `debido_cor_6`,
ADD `debido_sus_6` int(10) NOT NULL AFTER `debido_car_6`,
ADD `debido_ret_6` int(10) NOT NULL AFTER `debido_sus_6`,
ADD `n_internet_7` int(10) NOT NULL AFTER `debido_ret_6`,
ADD `n_tv_7` int(10) NOT NULL AFTER `n_internet_7`,
ADD `internet_y_tv_act_7` int(10) NOT NULL AFTER `n_tv_7`,
ADD `cor_int_7` int(10) NOT NULL AFTER `internet_y_tv_act_7`,
ADD `cor_tv_7` int(10) NOT NULL AFTER `cor_int_7`,
ADD `internet_y_tv_cor_7` int(10) NOT NULL AFTER `cor_tv_7`,
ADD `car_int_7` int(10) NOT NULL AFTER `internet_y_tv_cor_7`,
ADD `car_tv_7` int(10) NOT NULL AFTER `car_int_7`,
ADD `internet_y_tv_car_7` int(10) NOT NULL AFTER `car_tv_7`,
ADD `sus_int_7` int(10) NOT NULL AFTER `internet_y_tv_car_7`,
ADD `sus_tv_7` int(10) NOT NULL AFTER `sus_int_7`,
ADD `internet_y_tv_sus_7` int(10) NOT NULL AFTER `sus_tv_7`,
ADD `ret_int_7` int(10) NOT NULL AFTER `internet_y_tv_sus_7`,
ADD `ret_tv_7` int(10) NOT NULL AFTER `ret_int_7`,
ADD `internet_y_tv_ret_7` int(10) NOT NULL AFTER `ret_tv_7`,
ADD `debido_act_7` int(10) NOT NULL AFTER `internet_y_tv_ret_7`,
ADD `debido_cor_7` int(10) NOT NULL AFTER `debido_act_7`,
ADD `debido_car_7` int(10) NOT NULL AFTER `debido_cor_7`,
ADD `debido_sus_7` int(10) NOT NULL AFTER `debido_car_7`,
ADD `debido_ret_7` int(10) NOT NULL AFTER `debido_sus_7`,
ADD `n_internet_8` int(10) NOT NULL AFTER `debido_ret_7`,
ADD `n_tv_8` int(10) NOT NULL AFTER `n_internet_8`,
ADD `internet_y_tv_act_8` int(10) NOT NULL AFTER `n_tv_8`,
ADD `cor_int_8` int(10) NOT NULL AFTER `internet_y_tv_act_8`,
ADD `cor_tv_8` int(10) NOT NULL AFTER `cor_int_8`,
ADD `internet_y_tv_cor_8` int(10) NOT NULL AFTER `cor_tv_8`,
ADD `car_int_8` int(10) NOT NULL AFTER `internet_y_tv_cor_8`,
ADD `car_tv_8` int(10) NOT NULL AFTER `car_int_8`,
ADD `internet_y_tv_car_8` int(10) NOT NULL AFTER `car_tv_8`,
ADD `sus_int_8` int(10) NOT NULL AFTER `internet_y_tv_car_8`,
ADD `sus_tv_8` int(10) NOT NULL AFTER `sus_int_8`,
ADD `internet_y_tv_sus_8` int(10) NOT NULL AFTER `sus_tv_8`,
ADD `ret_int_8` int(10) NOT NULL AFTER `internet_y_tv_sus_8`,
ADD `ret_tv_8` int(10) NOT NULL AFTER `ret_int_8`,
ADD `internet_y_tv_ret_8` int(10) NOT NULL AFTER `ret_tv_8`,
ADD `debido_act_8` int(10) NOT NULL AFTER `internet_y_tv_ret_8`,
ADD `debido_cor_8` int(10) NOT NULL AFTER `debido_act_8`,
ADD `debido_car_8` int(10) NOT NULL AFTER `debido_cor_8`,
ADD `debido_sus_8` int(10) NOT NULL AFTER `debido_car_8`,
ADD `debido_ret_8` int(10) NOT NULL AFTER `debido_sus_8`;

------------------------------------------------------ modulo cargar excel permisos ------------------
INSERT INTO `modulos` (`id_modulo`, `rol`, `nombre`, `id_padre`, `codigo`, `orden`, `icono`) VALUES (NULL, 'Hijo', 'Cargar Excel', '27', 'tescargarexcel', '0', NULL);
------------------------cambios para pruebas facturacion electronica-----------------------------------------
  ALTER TABLE `facturacion_electronica_siigo` ADD `json` VARCHAR(7000) NULL AFTER `creado_con_multiple`, ADD `tid` INT NULL AFTER `json`;
  ALTER TABLE `facturacion_electronica_siigo` ADD `fecha_ejecucion` DATETIME NULL AFTER `fecha`;
  ALTER TABLE `facturacion_electronica_siigo` ADD `tipo` ENUM('facturada','error') NOT NULL DEFAULT 'facturada' AFTER `tid`;
ALTER TABLE `facturacion_electronica_siigo` ADD `metodo_pago` ENUM('credito','efectivo') NULL AFTER `tipo`;
ALTER TABLE `invoices` ADD `metodo_pago_f_e` ENUM('credito','efectivo') NULL AFTER `servicios_facturados_electronicamente`;

ALTER TABLE `facturacion_electronica_siigo` CHANGE `tipo` `tipo` ENUM('facturada','error','actualizada') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'facturada';
ALTER TABLE `invoices` ADD `fecha_actualizacion` DATETIME NULL AFTER `metodo_pago_f_e`;
----------------------------------------------------------------------------------------------------------
NUEVOS CAMPOS CONTRATO
--------------------------------------
ALTER TABLE `equipos`
ADD `metros` INT(4) NULL AFTER `imagen`,
ADD `accesorios` VARCHAR(20) NULL AFTER `metros`;

ALTER TABLE clausula ADD meses INT(2) NULL AFTER nombre;

---------------------------------------permisos eliminar productos ----------------------------
INSERT INTO `modulos` (`id_modulo`, `rol`, `nombre`, `id_padre`, `codigo`, `orden`, `icono`) VALUES (NULL, 'Hijo', 'Eliminar Productos', '14', 'eliminar_productos', '0', NULL)
------------------------------GENIEACS--------------------------------------------------------------
ALTER TABLE `equipos` ADD `id_genieacs` VARCHAR(500) NULL AFTER `accesorios`;
----------------------------------------------------------------------------------
INSERT INTO `product_warehouse` (`id`, `title`, `extra`, `id_tecnico`) VALUES (NULL, 'Almacén Clientes', 'EQUIPOS QUE ESTAN EN EL CLIENTE', NULL);

-----------------erorres yopal
http://localhost/CRMvestel/invoices/view?id=291579
UPDATE `invoices` SET `combo` = '10 Megas' WHERE `invoices`.`id` = 297284;


http://localhost/CRMvestel/invoices/view?id=297644
ALTER TABLE `invoices` CHANGE `combo` `combo` VARCHAR(100);
UPDATE `invoices` SET `combo` = 'Mensualidad 1500 Usuario software SAVE' WHERE `invoices`.`id` = 303350;

----------------------------------------------------------------------------------------------------------
FECHA DE INGRESO
--------------------------------------
ALTER TABLE `customers` ADD `f_ingreso` DATE NULL AFTER `f_contrato`;
----------------------------------------------------------------------------
caso de ayv cambios sql
UPDATE `products` SET `pid` = '158' WHERE `products`.`pid` = 25;
DELETE FROM `invoice_items` WHERE `invoice_items`.`tid` = 1428
-------------------------------------------------------------------
INSERT INTO `products` (`pid`, `pcat`, `warehouse`, `sede`, `product_name`, `product_code`, `product_price`, `fproduct_price`, `taxrate`, `disrate`, `qty`, `product_des`, `alert`, `id_prod_transfer`, `tipo_servicio`, `pertence_a_tv_o_net`, `valores`) VALUES ('158', '5', '7', '0', 'Punto Adicional', 'TvP', '5000', '5000', '0', '0', '999999775', '', '0', NULL, 'Recurrente', 'Tv', '');
--------------------------- GENIEACS ----------------------------

CREATE TABLE `genieacs_conections` (
  `id_conexion` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ip_remota` varchar(100) NOT NULL,
  `puerto` int(10) NOT NULL,
  `sede` int(10) NOT NULL,
  `comentarios` varchar(500) NOT NULL,
  `id_user_actualiza` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `genieacs_conections`
--

INSERT INTO `genieacs_conections` (`id_conexion`, `nombre`, `ip_remota`, `puerto`, `sede`, `comentarios`, `id_user_actualiza`) VALUES
(1, 'Yopal', '190.14.233.186', 7557, 2, 'comnexion yopal 1', 8);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `genieacs_conections`
--
ALTER TABLE `genieacs_conections`
  ADD PRIMARY KEY (`id_conexion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `genieacs_conections`
--
ALTER TABLE `genieacs_conections`
  MODIFY `id_conexion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;


INSERT INTO `modulos` (`id_modulo`, `rol`, `nombre`, `id_padre`, `codigo`, `orden`, `icono`) VALUES (NULL, 'Hijo', 'Genieacs', '110', 'genieacs_conection_l', '0', NULL)


------------------------siigo ottis
ALTER TABLE `customers` ADD `sucursal_siigo` INT NULL AFTER `coor2`;
------------------------------------ promo sistema clientes ----------------
ALTER TABLE `invoices` ADD `promo_sistema_clientes1` TINYINT NULL AFTER `fecha_actualizacion`;
----------------------------------------------------------------------------------------------------------
COORDENADAS EN NAPS
--------------------------------------

ALTER TABLE `naps` ADD `coor1` VARCHAR(50) NULL AFTER `dir_nap`, ADD `coor2` VARCHAR(50) NULL AFTER `coor1`;
----------------------------------------------------------------------------------------------------------
PERMISOS TRANSFERENCIA EQUIPOS
--------------------------------------

INSERT INTO `modulos` (`id_modulo`, `rol`, `nombre`, `id_padre`, `codigo`, `orden`, `icono`) VALUES (NULL, 'Hijo', 'Transferencias', '9', 'redtrans', '0', NULL);
INSERT INTO `modulos` (`id_modulo`, `rol`, `nombre`, `id_padre`, `codigo`, `orden`, `icono`) VALUES (NULL, 'Hijo', 'Adm transferencias', '9', 'redadmtrans', '0', NULL);

---------- promos clientes --------


-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-10-2024 a las 18:49:06
-- Versión del servidor: 11.1.2-MariaDB-log
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `admin_vestel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_clientes`
--

CREATE TABLE `estados_clientes` (
  `id_estado` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `estados_clientes`
--

INSERT INTO `estados_clientes` (`id_estado`, `nombre`) VALUES
(1, 'Activo'),
(2, 'Cartera'),
(3, 'Compromiso'),
(4, 'Cortado'),
(5, 'Depurado'),
(6, 'Evento'),
(7, 'Exonerado'),
(8, 'Instalar'),
(9, 'Por retirar'),
(10, 'Reportado'),
(11, 'Retirado'),
(12, 'Suspendido');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estados_clientes`
--
ALTER TABLE `estados_clientes`
  ADD PRIMARY KEY (`id_estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estados_clientes`
--
ALTER TABLE `estados_clientes`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE `promos` ADD `id_estado_clientes` INT NOT NULL AFTER `colaborador`;
ALTER TABLE `promos` CHANGE `pro_nombre` `pro_nombre` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;


ALTER TABLE `documents` ADD `carpeta` INT NOT NULL AFTER `id`;


ALTER TABLE `purchase` ADD `recibe` INT NOT NULL AFTER `almacen_seleccionado`, ADD `fcha_recibido` DATETIME NULL AFTER `recibe`;

ALTER TABLE `invoices` CHANGE `ron` `ron` ENUM('Activo','Instalar','Cortado','Suspendido','Exonerado','Cartera','Compromiso','Depurado','Retirado','Anulado','Reportado','Evento','Dado de Baja','Por retirar','Cuentas dificil cobro','No instalado','Por definir') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL;