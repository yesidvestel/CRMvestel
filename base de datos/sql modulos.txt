CREATE TABLE `modulos` (
  `id_modulo` int(10) UNSIGNED NOT NULL,
  `rol` enum('Padre','Hijo') DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `id_padre` int(11) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `orden` tinyint(4) NOT NULL,
  `icono` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id_modulo`, `rol`, `nombre`, `id_padre`, `codigo`, `orden`, `icono`) VALUES
(1, 'Padre', 'COBRANZA', NULL, 'co', 1, 'icon-plus'),
(2, 'Hijo', 'Apertura', 1, 'coape', 0, NULL),
(3, 'Hijo', 'Nueva Factura', 1, 'conue', 0, NULL),
(4, 'Hijo', 'Administrar facturas', 1, 'coadm', 0, NULL),
(5, 'Hijo', 'Cierre', 1, 'cocie', 0, NULL),
(6, 'Hijo', 'Facturacion', 1, 'cofa', 0, NULL),
(7, 'Hijo', 'Facturacion electronica', 1, 'cofae', 0, NULL),
(8, 'Hijo', 'Notas Debito/Credito', 1, 'conotas', 0, NULL),
(9, 'Padre', 'REDES', NULL, 'red', 2, 'icon-wifi3'),
(10, 'Hijo', 'Ingresar equipo', 9, 'reding', 0, NULL),
(11, 'Hijo', 'Administrar equipos', 9, 'redadm', 0, NULL),
(12, 'Hijo', 'Conexiones', 9, 'redcon', 0, NULL),
(13, 'Hijo', 'Bodega de equipos', 9, 'redbod', 0, NULL),
(14, 'Padre', 'INVENTARIOS', NULL, 'inv', 3, 'icon-truck2'),
(15, 'Hijo', 'Ingresar material', 14, 'inving', 0, NULL),
(16, 'Hijo', 'Administrar material', 14, 'invadm', 0, NULL),
(17, 'Hijo', 'Categorias material', 14, 'invcat', 0, NULL),
(18, 'Hijo', 'Almacenes', 14, 'invalm', 0, NULL),
(19, 'Hijo', 'Traspasos', 14, 'invtrs', 0, NULL),
(20, 'Padre', 'ORDEN DE COMPRA', NULL, 'com', 4, 'icon-file'),
(21, 'Hijo', 'Nueva orden', 20, 'comnue', 0, NULL),
(22, 'Hijo', 'Administrar ordenes', 20, 'comadm', 0, NULL),
(23, 'Padre', 'USUARIOS', NULL, 'us', 5, 'icon-group'),
(24, 'Hijo', 'Nuevo usuario', 23, 'usnue', 0, NULL),
(25, 'Hijo', 'Administrar usuarios', 23, 'usadm', 0, NULL),
(26, 'Hijo', 'Administrar grupos', 23, 'usgru', 0, NULL),
(27, 'Padre', 'TESORERIA', NULL, 'tes', 6, 'icon-exchange'),
(28, 'Hijo', 'Ver transacciones', 27, 'testran', 0, NULL),
(29, 'Hijo', 'Ver anulaciones', 27, 'tesanu', 0, NULL),
(30, 'Hijo', 'Nueva trasaccion', 27, 'tesnuetransac', 0, NULL),
(31, 'Hijo', 'Nueva transferencia', 27, 'tesnuetransfer', 0, NULL),
(32, 'Hijo', 'Ingresos', 27, 'tesing', 0, NULL),
(33, 'Hijo', 'Gastos', 27, 'tesgas', 0, NULL),
(34, 'Hijo', 'Transferencias', 27, 'testransfer', 0, NULL),
(35, 'Padre', 'EMPLEADOS', NULL, 'emp', 7, 'icon-users'),
(36, 'Padre', 'COMPLEMENTOS', NULL, 'comp', 8, 'icon-anchor'),
(37, 'Hijo', 'Recaptchat', 36, 'comprec', 0, NULL),
(38, 'Hijo', 'Url corta', 36, 'compurl', 0, NULL),
(39, 'Hijo', 'Twilio', 36, 'comptwi', 0, NULL),
(40, 'Hijo', 'Currency', 36, 'compcurr', 0, NULL),
(41, 'Padre', 'TICKET', NULL, 'tik', 9, 'icon-ticket'),
(42, 'Hijo', 'Nuevo ticket', 41, 'tiknue', 0, NULL),
(43, 'Hijo', 'Administrar entrada', 41, 'tikadm', 0, NULL),
(44, 'Padre', 'PLANTILLAS', NULL, 'pla', 10, 'icon-table3'),
(45, 'Hijo', 'Correo', 44, 'placor', 0, NULL),
(46, 'Hijo', 'Mensajes', 44, 'plamen', 0, NULL),
(47, 'Hijo', 'Temas', 44, 'platem', 0, NULL),
(48, 'Hijo', 'Correo', 47, 'placor', 0, NULL),
(49, 'Hijo', 'Mensajes', 47, 'plamen', 0, NULL),
(50, 'Hijo', 'Temas', 47, 'platem', 0, NULL),
(51, 'Padre', 'MOVILES', NULL, 'mo', 11, 'icon-sitemap'),
(52, 'Hijo', 'Correo', 51, 'monue', 0, NULL),
(53, 'Hijo', 'Mensajes', 51, 'moadm', 0, NULL),
(54, 'Padre', 'DATOS E INFORMES', NULL, 'dat', 12, 'icon-file-archive-o'),
(55, 'Hijo', 'Estadisticas', 54, 'datest', 0, NULL),
(56, 'Hijo', 'Declaraciones', 54, 'datdec', 0, NULL),
(57, 'Hijo', 'Reporte tecnico', 54, 'datrep', 0, NULL),
(58, 'Hijo', 'Usu. declaraciones', 54, 'datusu', 0, NULL),
(59, 'Hijo', 'Prov. declaraciones', 54, 'datpro', 0, NULL),
(60, 'Hijo', 'Calcular ingresos', 54, 'dating', 0, NULL),
(61, 'Hijo', 'Calcular gastos', 54, 'datgas', 0, NULL),
(62, 'Hijo', 'Trans. clientes', 54, 'dattrans', 0, NULL),
(63, 'Hijo', 'Impuestos', 54, 'datimp', 0, NULL),
(64, 'Hijo', 'Historial CRM', 54, 'dathistorial', 0, NULL),
(65, 'Hijo', 'Estadisticas Servicios', 54, 'datservicios', 0, NULL),
(67, 'Hijo', 'Empresa', 110, 'confemp', 0, NULL),
(68, 'Hijo', 'Facturacion y lenguaje', 110, 'conffa', 0, NULL),
(69, 'Hijo', 'Moneda', 110, 'confmon', 0, NULL),
(70, 'Hijo', 'Formato fecha', 110, 'conffec', 0, NULL),
(71, 'Hijo', 'Categorias transaccion', 110, 'confcat', 0, NULL),
(72, 'Hijo', 'Fijar metas', 110, 'confmet', 0, NULL),
(73, 'Hijo', 'Api rest', 110, 'confrest', 0, NULL),
(74, 'Hijo', 'Correo', 110, 'confcorr', 0, NULL),
(75, 'Padre', 'PROVEEDORES', NULL, 'pro', 14, 'icon-ios-people'),
(76, 'Hijo', 'Nuevo proveedor', 75, 'pronue', 0, NULL),
(77, 'Hijo', 'Administrar proveedor', 75, 'proadm', 0, NULL),
(78, 'Padre', 'ENCUESTAS', NULL, 'enc', 15, 'icon-android-clipboard'),
(79, 'Hijo', 'Lista de llamadas', 78, 'encllam', 0, NULL),
(80, 'Hijo', 'Nueva encuesta', 78, 'encnue', 0, NULL),
(81, 'Hijo', 'Lista encuestas', 78, 'encenc', 0, NULL),
(82, 'Hijo', 'Nueva ATS', 78, 'encats', 0, NULL),
(83, 'Hijo', 'Lista ATS', 78, 'encatslis', 0, NULL),
(84, 'Padre', 'PROYECTOS', NULL, 'proy', 16, 'icon-file'),
(85, 'Hijo', 'Nuevo proyecto', 84, 'proynue', 0, NULL),
(86, 'Hijo', 'Administrar proyectos', 84, 'proyadm', 0, NULL),
(87, 'Padre', 'NOTAS', NULL, 'not', 17, 'icon-android-clipboard'),
(88, 'Padre', 'CALENDARIO', NULL, 'cal', 18, 'icon-calendar2'),
(89, 'Padre', 'DOCUMENTOS', NULL, 'doct', 19, 'icon-android-download'),
(90, 'Padre', 'CUENTAS', NULL, 'cuen', 20, 'icon-bank'),
(91, 'Hijo', 'Cuenta de administración', 90, 'cuenadm', 0, NULL),
(92, 'Hijo', 'Nueva cuenta', 90, 'cuennue', 0, NULL),
(93, 'Hijo', 'Hoja de balance', 90, 'cuenbal', 0, NULL),
(94, 'Hijo', 'Declaración de cuenta', 90, 'cuendec', 0, NULL),
(95, 'Padre', 'CONFIGURAR PAGO', NULL, 'pag', 21, 'icon-cc'),
(96, 'Hijo', 'Configuración pago', 90, 'pagconf', 0, NULL),
(97, 'Hijo', 'Vía de pago', 90, 'pagvia', 0, NULL),
(98, 'Hijo', 'Moneda de pago', 90, 'pagmon', 0, NULL),
(99, 'Hijo', 'Cambio de divisas', 90, 'pagcam', 0, NULL),
(100, 'Hijo', 'Cuentas bancarias', 90, 'pagban', 0, NULL),
(101, 'Padre', 'TAREAS', NULL, 'tar', 22, 'icon-android-done-all'),
(102, 'Hijo', 'Termino facturación', 110, 'confterm', 0, NULL),
(103, '', 'Trabajo automático', 110, 'confaut', 0, NULL),
(104, '', 'Seguridad', 110, 'confseg', 0, NULL),
(105, '', 'Tema', 110, 'conftem', 0, NULL),
(106, '', 'Soporte', 110, 'confsop', 0, NULL),
(107, '', 'Acerca de', 110, 'conface', 0, NULL),
(108, '', 'Update', 110, 'confupt', 0, NULL),
(109, '', 'APIS', 110, 'confapi', 0, NULL),
(110, 'Padre', 'CONFIGURACIONES', NULL, 'conf', 13, 'icon-cog'),
(111, 'Padre', 'PRUEBA', NULL, 'pruebacod', 23, 'icon-wifi3'),
(112, 'Hijo', 'item1', 111, 'item1c', 0, NULL),
(113, 'Hijo', 'item2', 111, 'item2c', 0, NULL),
(114, 'Hijo', 'item3', 111, 'coditem3', 0, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

CREATE TABLE `permisos_usuario` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `is_checked` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `permisos_usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `permisos_usuario`
--
ALTER TABLE `permisos_usuario`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6616;