Scripts Base de datos
********************************************************************************************************************************************************************************
Yordi Guevara - 23-01-2021: Creacion de traslados
********************************************************************************************************************************************************************************

CREATE TABLE `traslado` (
  `id` int(18) NOT NULL,
  `idUsuario` int(18) NOT NULL,
  `idEmpresa_sale` int(18) NOT NULL,
  `idEmpresa_entra` int(18) NOT NULL,
  `estado` varchar(3) NOT NULL,
  `fechaAlta` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `traslado`
--
ALTER TABLE `traslado`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `traslado`
--
ALTER TABLE `traslado`
  MODIFY `id` int(18) NOT NULL AUTO_INCREMENT;
COMMIT;



--
-- Estructura de tabla para la tabla `traslado_nota`
--

CREATE TABLE `traslado_nota` (
  `id` int(18) NOT NULL,
  `idTraslado` int(18) NOT NULL,
  `nota` text NOT NULL,
  `id_usuario` int(18) NOT NULL,
  `add_fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `traslado_nota`
--
ALTER TABLE `traslado_nota`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `traslado_nota`
--
ALTER TABLE `traslado_nota`
  MODIFY `id` int(18) NOT NULL AUTO_INCREMENT;
COMMIT;



--
-- Estructura de tabla para la tabla `traslado_inventario`
--

CREATE TABLE `traslado_inventario` (
  `id` int(18) NOT NULL,
  `idTraslado` int(18) NOT NULL,
  `idInventario` int(18) NOT NULL,
  `cantidad` int(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `traslado_inventario`
--
ALTER TABLE `traslado_inventario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `traslado_inventario`
--
ALTER TABLE `traslado_inventario`
  MODIFY `id` int(18) NOT NULL AUTO_INCREMENT;
COMMIT;



********************************************************************************************************************************************************************************
********************************************************************************************************************************************************************************
********************************************************************************************************************************************************************************
