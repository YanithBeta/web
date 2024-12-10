-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-12-2024 a las 23:42:29
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nuevo3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `telefono`, `correo`) VALUES
(1, 'yanet', '4831274102', 'yanet@gmail.com'),
(2, 'jazmin', 'tolentino', 'jaz@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_personal` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido_paterno` varchar(100) NOT NULL,
  `apellido_materno` varchar(100) NOT NULL,
  `puesto` varchar(100) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `sueldo` decimal(10,2) NOT NULL,
  `estatus` enum('Activo','Inactivo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_personal`, `nombre`, `apellido_paterno`, `apellido_materno`, `puesto`, `fecha_ingreso`, `telefono`, `direccion`, `correo`, `sueldo`, `estatus`) VALUES
(1, 'ANA', 'jhsjhsjhsj', 'ANAALIZ', 'ge', '2024-11-25', '48312768', 'gggg', 'ANA@1.com', '400.00', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(35) NOT NULL,
  `cod_barras` varchar(8) NOT NULL,
  `cantidad` int(25) NOT NULL,
  `proveedor` varchar(35) NOT NULL,
  `especificaciones` varchar(20) NOT NULL,
  `fecha_caducidad` date NOT NULL,
  `costo_compra` varchar(25) NOT NULL,
  `costo_venta` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `cod_barras`, `cantidad`, `proveedor`, `especificaciones`, `fecha_caducidad`, `costo_compra`, `costo_venta`) VALUES
(14, 'CHETOS', '02', 100, 'angel', '200MG', '2024-10-06', '20', '20'),
(18, 'Pepsi', '505050', 100, 'COCACOLA', '1 LITRO', '2024-10-10', '20', '50'),
(19, 'Sabritas', '50505', 2, 'eduardo', 'ruflex', '2024-11-20', '20', '20'),
(21, 'Yogurt', '101010', 4, 'eduardo', 'Lala', '2025-01-31', '30', '100');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_devueltos`
--

CREATE TABLE `productos_devueltos` (
  `id_devolucion` int(11) NOT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `motivo` text DEFAULT NULL,
  `fecha_devolucion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos_devueltos`
--

INSERT INTO `productos_devueltos` (`id_devolucion`, `id_venta`, `id_producto`, `cantidad`, `motivo`, `fecha_devolucion`) VALUES
(15, 10, 14, 5, 'CADUCADO', '2024-11-29 05:08:31'),
(16, 10, 14, 2, 'caducado', '2024-11-29 15:37:07'),
(17, 10, 18, 2, 'caducaso', '2024-11-29 15:37:21'),
(18, 10, 18, 1, 'caducado', '2024-11-29 15:37:44'),
(19, 10, 19, 1, 'ff', '2024-11-29 15:38:59'),
(20, 10, 18, 1, 'vvv', '2024-11-29 15:39:31'),
(21, 10, 21, 2, 'x', '2024-11-29 15:39:43'),
(22, 10, 21, 1, 'b', '2024-11-29 15:40:10'),
(23, 11, 14, 2, 'caducado', '2024-11-29 19:52:27'),
(24, 11, 14, 1, 'caducado', '2024-12-03 18:38:39'),
(25, 11, 14, 2, 'caducado', '2024-12-03 18:39:03'),
(26, 11, 19, 1, 'c', '2024-12-08 17:59:38'),
(27, 12, 19, 2, 'caducado', '2024-12-08 18:03:37'),
(28, 12, 19, 1, 'c', '2024-12-08 18:16:10'),
(29, 12, 19, 1, 'caducidad', '2024-12-08 18:21:36'),
(30, 12, 19, 1, 'v', '2024-12-08 18:58:35'),
(31, 12, 19, 1, 'c', '2024-12-08 19:01:53'),
(32, 12, 19, 1, 'c', '2024-12-08 19:09:52'),
(33, 12, 19, 1, 'c', '2024-12-08 19:36:11'),
(34, 12, 19, 1, 'por caducado', '2024-12-08 19:37:01'),
(35, 13, 14, 1, 'caducado', '2024-12-08 19:41:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `a_paterno` varchar(35) NOT NULL,
  `a_materno` varchar(35) NOT NULL,
  `clave` varchar(8) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `correo` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `a_paterno`, `a_materno`, `clave`, `telefono`, `correo`) VALUES
(2, 'miguel', 'PEREZ', 'Zuñiga', '21isc09', '80001', 'miguel@gamil.com'),
(4, 'Hector', 'Solis', 'Alvineda', '24isc09', '80001', 'hector@gamil.com'),
(5, 'Yolanda', 'Martínez', 'Cruz', '24isc098', '800800', 'yolanda@gamil.com'),
(6, 'German', 'Hernández', 'Ramírez', '24isc092', '80080001', 'german@gamil.com'),
(8, 'Yolanda', 'Garcia', 'Martinez', '24isc098', '800800', 'yolanda@gamil.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `fecha_venta` date NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `metodo_pago` enum('Transferencia','Tarjeta','Efectivo') NOT NULL,
  `efectivo_recibido` decimal(10,2) DEFAULT NULL,
  `cambio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_cliente`, `id_usuario`, `id_producto`, `fecha_venta`, `cantidad`, `precio_unitario`, `total`, `metodo_pago`, `efectivo_recibido`, `cambio`) VALUES
(23, 1, 2, 14, '2024-11-24', 0, '20.00', '40.00', 'Tarjeta', '50.00', '10.00'),
(24, 1, 4, 18, '2024-11-24', 1, '50.00', '250.00', 'Tarjeta', '500.00', '250.00'),
(25, 1, 6, 21, '2024-11-24', 3, '100.00', '300.00', 'Tarjeta', '500.00', '0.00'),
(26, 1, 8, 18, '2024-11-24', 3, '50.00', '150.00', 'Efectivo', '500.00', '200.00'),
(27, 1, 8, 18, '2024-11-24', -1, '50.00', '-50.00', 'Efectivo', NULL, NULL),
(28, 1, 2, 18, '2024-11-24', 1, '50.00', '50.00', 'Tarjeta', '500.00', '250.00'),
(29, 1, 2, 18, '2024-11-24', -2, '50.00', '-100.00', 'Tarjeta', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas2`
--

CREATE TABLE `ventas2` (
  `id_venta` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `fecha_venta` date DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `total_venta` decimal(10,2) DEFAULT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `banco` varchar(50) DEFAULT NULL,
  `numero_tarjeta` varchar(16) DEFAULT NULL,
  `efectivo_recibido` decimal(10,2) DEFAULT NULL,
  `cambio` decimal(10,2) DEFAULT NULL,
  `comision` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas2`
--

INSERT INTO `ventas2` (`id_venta`, `id_cliente`, `id_usuario`, `id_producto`, `fecha_venta`, `cantidad`, `precio_unitario`, `total_venta`, `metodo_pago`, `banco`, `numero_tarjeta`, `efectivo_recibido`, `cambio`, `comision`) VALUES
(1, 1, 2, 18, '2024-11-28', 5, '50.00', '250.00', 'Transferencia', NULL, NULL, NULL, NULL, '5.00'),
(2, 1, 4, 14, '2024-11-28', 6, '20.00', '120.00', 'Tarjeta', 'Banco Azteca', '1234 34556789098', NULL, NULL, '2.40'),
(3, 1, 4, 18, '2024-12-05', 5, '50.00', '250.00', 'Efectivo', NULL, NULL, '500.00', '250.00', NULL),
(4, 1, 4, 18, '2024-12-05', 5, '50.00', '250.00', 'Efectivo', NULL, NULL, '500.00', '250.00', NULL),
(5, 1, 4, 18, '2024-12-05', 5, '50.00', '250.00', 'Efectivo', NULL, NULL, '500.00', '250.00', NULL),
(6, 1, 4, 18, '2024-11-28', 5, '50.00', '250.00', 'Transferencia', NULL, NULL, NULL, NULL, '5.00'),
(7, 1, 2, 14, '2024-11-28', 5, '20.00', '100.00', 'Transferencia', NULL, NULL, NULL, NULL, '2.00'),
(8, 1, 4, 18, '2024-11-30', 0, '50.00', '100.00', 'Tarjeta', 'BBVA', '1000 ', NULL, NULL, '2.00'),
(9, 1, 8, 18, '2024-11-29', 3, '100.00', '1000.00', 'Transferencia', NULL, NULL, NULL, NULL, '20.00'),
(10, 1, 2, 18, '2024-11-28', 6, '20.00', '300.00', 'Tarjeta', 'BBVA', '1000 ', NULL, NULL, '6.00'),
(11, 1, 2, 19, '2024-11-29', 1, '20.00', '100.00', 'Tarjeta', 'Banco Azteca', '1000 ', NULL, NULL, '2.00'),
(12, 1, 2, 19, '2024-12-08', 1, '20.00', '20.00', 'Tarjeta', 'BBVA', '1000 23894930049', NULL, NULL, '4.00'),
(13, 1, 2, 14, '2024-12-08', 4, '20.00', '80.00', 'Tarjeta', 'BBVA', '1000 38929828498', NULL, NULL, '2.00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_personal`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `productos_devueltos`
--
ALTER TABLE `productos_devueltos`
  ADD PRIMARY KEY (`id_devolucion`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `ventas2`
--
ALTER TABLE `ventas2`
  ADD PRIMARY KEY (`id_venta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_personal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `productos_devueltos`
--
ALTER TABLE `productos_devueltos`
  MODIFY `id_devolucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `ventas2`
--
ALTER TABLE `ventas2`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos_devueltos`
--
ALTER TABLE `productos_devueltos`
  ADD CONSTRAINT `productos_devueltos_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas2` (`id_venta`),
  ADD CONSTRAINT `productos_devueltos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `ventas_ibfk_3` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
