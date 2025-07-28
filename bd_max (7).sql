-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-07-2025 a las 05:05:31
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_max`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `puntuacion` int(11) DEFAULT NULL CHECK (`puntuacion` between 1 and 5),
  `comentario` text DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calificaciones`
--

INSERT INTO `calificaciones` (`id`, `pedido_id`, `puntuacion`, `comentario`, `fecha`) VALUES
(1, 3, 5, 'Excelente servicio y comida deliciosa', '2025-07-17 21:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `activo`) VALUES
(1, 'Comida', 'Productos alimenticios', 1),
(2, 'Bebida', 'Bebidas de todo tipo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combos`
--

CREATE TABLE `combos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `combos`
--

INSERT INTO `combos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `activo`, `fecha_creacion`) VALUES
(1, 'Combo Clásico', 'Hamburguesa + Coca Cola', 550.00, 'combo_clasico.jpg', 1, '2025-07-01 00:00:00'),
(2, 'Combo Pizza', 'Pizza + Cerveza Artesanal', 800.00, 'combo_pizza.jpg', 1, '2025-07-01 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedido`
--

CREATE TABLE `detalles_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `combo_id` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_pedido`
--

INSERT INTO `detalles_pedido` (`id`, `pedido_id`, `producto_id`, `combo_id`, `cantidad`, `precio_unitario`, `observaciones`) VALUES
(1, 1, NULL, 1, 1, 550.00, NULL),
(2, 2, 3, NULL, 1, 350.00, 'Aderezo aparte'),
(3, 2, 4, NULL, 1, 100.00, NULL),
(4, 3, NULL, 2, 1, 800.00, 'Pizza bien cocida'),
(5, 4, 7, NULL, 1, 300.00, 'Sin mayonesa'),
(6, 4, 8, NULL, 1, 120.00, NULL),
(7, 5, 9, NULL, 1, 280.00, NULL),
(8, 5, 10, NULL, 1, 150.00, 'Café con 2 de azúcar'),
(9, 6, 3, NULL, 2, 350.00, NULL),
(10, 6, 2, NULL, 1, 150.00, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rol` enum('admin','cocina','repartidor') DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `email`, `password`, `rol`, `activo`) VALUES
(1, 'Admin Principal', 'admin@gmail.com', '12345678', 'admin', 1),
(2, 'Cocinero Juan', 'cocinero@gmail.com', '12345678', 'cocina', 1),
(3, 'Repartidor', 'repa@gmail.com', '12345678', 'repartidor', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_estados`
--

CREATE TABLE `historial_estados` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `estado_anterior` enum('pendiente','confirmado','en_preparacion','en_camino','entregado','cancelado') DEFAULT NULL,
  `estado_nuevo` enum('pendiente','confirmado','en_preparacion','en_camino','entregado','cancelado') DEFAULT NULL,
  `fecha_cambio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_estados`
--

INSERT INTO `historial_estados` (`id`, `pedido_id`, `estado_anterior`, `estado_nuevo`, `fecha_cambio`) VALUES
(1, 2, 'pendiente', 'confirmado', '2025-07-16 13:50:00'),
(2, 2, 'confirmado', 'en_preparacion', '2025-07-16 14:00:00'),
(3, 2, 'en_preparacion', 'en_camino', '2025-07-16 14:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `tipo` enum('email','whatsapp') NOT NULL,
  `contenido` text NOT NULL,
  `fecha_envio` datetime DEFAULT current_timestamp(),
  `estado` enum('pendiente','enviado','fallido') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `pedido_id`, `tipo`, `contenido`, `fecha_envio`, `estado`) VALUES
(1, 5, 'whatsapp', 'Su pedido #PED789123 ha sido confirmado y está en preparación', '2025-07-19 15:35:00', 'enviado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

CREATE TABLE `ofertas` (
  `id` int(11) NOT NULL,
  `tipo` enum('producto','combo') NOT NULL,
  `referencia_id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `descuento_porcentaje` int(11) DEFAULT NULL CHECK (`descuento_porcentaje` between 1 and 100),
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `activa` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL DEFAULT 'Pedido',
  `correo_electronico` varchar(100) DEFAULT NULL,
  `repartidor_id` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `estado` enum('pendiente','confirmado','en_preparacion','en_camino','entregado','cancelado') DEFAULT 'pendiente',
  `estado_pago` enum('pendiente','pagado','devuelto') DEFAULT 'pendiente',
  `total` decimal(10,2) NOT NULL,
  `metodo_pago` enum('efectivo','tarjeta','transferencia') NOT NULL,
  `observaciones` text DEFAULT NULL,
  `direccion_entrega` text NOT NULL,
  `entre` varchar(250) NOT NULL,
  `indicacion` varchar(250) NOT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `codigo_seguimiento` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `nombre`, `correo_electronico`, `repartidor_id`, `fecha`, `estado`, `estado_pago`, `total`, `metodo_pago`, `observaciones`, `direccion_entrega`, `entre`, `indicacion`, `latitud`, `longitud`, `codigo_seguimiento`) VALUES
(1, 'Pedido #1', NULL, NULL, '2025-07-15 12:30:00', 'pendiente', 'pendiente', 550.00, 'efectivo', 'Sin cebolla por favor', 'Calle Falsa 123, Ciudad', '', '', NULL, NULL, 'PED123456'),
(2, 'Pedido #2', NULL, 1, '2025-07-16 13:45:00', 'en_camino', 'pagado', 450.00, 'tarjeta', 'Aderezo aparte', 'Avenida Siempreviva 742, Ciudad', '', '', NULL, NULL, 'PED654321'),
(3, 'Pedido #3', NULL, 1, '2025-07-17 20:15:00', 'entregado', 'pagado', 800.00, 'transferencia', 'Pizza bien cocida', 'Calle Principal 456, Ciudad', '', '', NULL, NULL, 'PED987654'),
(4, 'Pedido #4', NULL, NULL, '2025-07-18 12:00:00', 'en_preparacion', 'pendiente', 420.00, 'efectivo', 'Sin mayonesa', 'Boulevard Central 789, Ciudad', '', '', NULL, NULL, 'PED456789'),
(5, 'Pedido #5', NULL, 2, '2025-07-19 15:30:00', 'confirmado', 'pagado', 430.00, 'tarjeta', 'Café con 2 de azúcar', 'Calle Secundaria 321, Ciudad', '', '', NULL, NULL, 'PED789123'),
(6, 'Pedido', NULL, NULL, '2025-07-28 01:54:46', 'pendiente', 'pendiente', 850.00, 'efectivo', '', '-25.281582666666665, -57.72986233333334', '', '', -25.28158267, -57.72986233, '057695F7');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `tipo` enum('comida','bebida','vianda') NOT NULL,
  `subcategoria_id` int(11) DEFAULT NULL,
  `subcategoria` varchar(50) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `tipo`, `subcategoria_id`, `subcategoria`, `activo`, `fecha_creacion`) VALUES
(1, 'Hamburguesa Clásica', 'Hamburguesa con queso, lechuga y tomate', 450.00, 'hamburguesa.jpg', 'comida', 1, NULL, 1, '2025-07-01 00:00:00'),
(2, 'Coca Cola', 'Refresco de 500ml', 150.00, 'cocacola.jpg', 'bebida', 5, NULL, 1, '2025-07-01 00:00:00'),
(3, 'Ensalada César', 'Ensalada con pollo, croutones y aderezo césar', 350.00, 'uploads/productos/1753669544_66be1465c4657dc8e2c1.png', 'comida', 3, NULL, 1, '2025-07-01 00:00:00'),
(4, 'Agua Mineral', 'Agua mineral 500ml', 100.00, 'agua.jpg', 'bebida', 6, NULL, 1, '2025-07-01 00:00:00'),
(5, 'Pizza Margarita', 'Pizza con salsa de tomate y mozzarella', 600.00, 'pizza.jpg', 'comida', 2, NULL, 1, '2025-07-01 00:00:00'),
(6, 'Cerveza Artesanal', 'Cerveza rubia 330ml', 250.00, 'cerveza.jpg', 'bebida', 7, NULL, 1, '2025-07-01 00:00:00'),
(7, 'Sándwich de Pollo', 'Sándwich con pollo grillado y vegetales', 300.00, 'sandwich.jpg', 'comida', NULL, NULL, 1, '2025-07-01 00:00:00'),
(8, 'Jugo Natural', 'Jugo de naranja natural 300ml', 120.00, 'jugo.jpg', 'bebida', NULL, NULL, 1, '2025-07-01 00:00:00'),
(9, 'Tarta de Manzana', 'Postre de manzana con base de masa quebrada', 280.00, 'tarta.jpg', 'comida', 4, NULL, 1, '2025-07-01 00:00:00'),
(10, 'Café Americano', 'Café negro 200ml', 150.00, 'cafe.jpg', 'bebida', 8, NULL, 1, '2025-07-01 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_en_combos`
--

CREATE TABLE `productos_en_combos` (
  `combo_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_en_combos`
--

INSERT INTO `productos_en_combos` (`combo_id`, `producto_id`, `cantidad`) VALUES
(1, 1, 1),
(1, 2, 1),
(2, 5, 1),
(2, 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repartidores`
--

CREATE TABLE `repartidores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `vehiculo` varchar(50) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `disponible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `repartidores`
--

INSERT INTO `repartidores` (`id`, `nombre`, `telefono`, `vehiculo`, `activo`, `email`, `password`, `disponible`) VALUES
(1, 'Carlos López', '1199887766', 'Moto', 1, 'carlos.lopez@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0),
(2, 'Ana Torres', '1122334455', 'Bicicleta', 1, 'ana.torres@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
(3, 'Repartidor Test', '', NULL, 1, 'repartidor@test.com', '$2y$10$eYhYyc0tPI/ELKblUie0leu65ai1O6pdtJE4KVqvaTKfbvJuEySQ2', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `slides`
--

CREATE TABLE `slides` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `subtitulo` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) NOT NULL,
  `link_destino` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `orden` int(11) DEFAULT 0,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `stock`
--

INSERT INTO `stock` (`id`, `producto_id`, `fecha`, `cantidad`) VALUES
(1, 1, '2025-07-18', 50),
(2, 2, '2025-07-18', 100),
(3, 3, '2025-07-18', 30),
(4, 4, '2025-07-18', 80);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

CREATE TABLE `subcategorias` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `subcategorias`
--

INSERT INTO `subcategorias` (`id`, `categoria_id`, `nombre`, `descripcion`, `activo`) VALUES
(1, 1, 'hamburguesas', 'Hamburguesas y sandwiches', 1),
(2, 1, 'pizzas', 'Pizzas de varios tipos', 1),
(3, 1, 'ensaladas', 'Ensaladas frescas', 1),
(4, 1, 'postres', 'Postres y dulces', 1),
(5, 2, 'gaseosas', 'Refrescos carbonatados', 1),
(6, 2, 'Aguas', 'Aguas minerales y saborizadas', 1),
(7, 2, 'cervezas', 'Cervezas artesanales e industriales', 1),
(8, 2, 'cafés', 'Cafés y bebidas calientes', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones_repartidores`
--

CREATE TABLE `ubicaciones_repartidores` (
  `id` int(11) NOT NULL,
  `repartidor_id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `latitud` decimal(10,8) NOT NULL,
  `longitud` decimal(11,8) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubicaciones_repartidores`
--

INSERT INTO `ubicaciones_repartidores` (`id`, `repartidor_id`, `pedido_id`, `latitud`, `longitud`, `fecha`) VALUES
(1, 2, 5, -34.60372200, -58.38159200, '2025-07-19 15:40:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `combos`
--
ALTER TABLE `combos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `combo_id` (`combo_id`),
  ADD KEY `idx_detalles_pedido` (`pedido_id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `historial_estados`
--
ALTER TABLE `historial_estados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Indices de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `referencia_id` (`referencia_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_seguimiento` (`codigo_seguimiento`),
  ADD KEY `repartidor_id` (`repartidor_id`),
  ADD KEY `idx_pedidos_estado` (`estado`),
  ADD KEY `idx_pedidos_fecha` (`fecha`),
  ADD KEY `idx_latitud_longitud` (`latitud`,`longitud`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_productos_activos` (`activo`),
  ADD KEY `subcategoria_id` (`subcategoria_id`);

--
-- Indices de la tabla `productos_en_combos`
--
ALTER TABLE `productos_en_combos`
  ADD PRIMARY KEY (`combo_id`,`producto_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `repartidores`
--
ALTER TABLE `repartidores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `producto_id` (`producto_id`,`fecha`),
  ADD KEY `idx_stock_fecha` (`fecha`);

--
-- Indices de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `ubicaciones_repartidores`
--
ALTER TABLE `ubicaciones_repartidores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `idx_ubicaciones_repartidor` (`repartidor_id`,`pedido_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `combos`
--
ALTER TABLE `combos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `historial_estados`
--
ALTER TABLE `historial_estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `repartidores`
--
ALTER TABLE `repartidores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ubicaciones_repartidores`
--
ALTER TABLE `ubicaciones_repartidores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `calificaciones_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`);

--
-- Filtros para la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  ADD CONSTRAINT `detalles_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalles_pedido_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `detalles_pedido_ibfk_3` FOREIGN KEY (`combo_id`) REFERENCES `combos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `historial_estados`
--
ALTER TABLE `historial_estados`
  ADD CONSTRAINT `historial_estados_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`);

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`);

--
-- Filtros para la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD CONSTRAINT `ofertas_ibfk_1` FOREIGN KEY (`referencia_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`repartidor_id`) REFERENCES `repartidores` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`subcategoria_id`) REFERENCES `subcategorias` (`id`);

--
-- Filtros para la tabla `productos_en_combos`
--
ALTER TABLE `productos_en_combos`
  ADD CONSTRAINT `productos_en_combos_ibfk_1` FOREIGN KEY (`combo_id`) REFERENCES `combos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `productos_en_combos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD CONSTRAINT `subcategorias_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `ubicaciones_repartidores`
--
ALTER TABLE `ubicaciones_repartidores`
  ADD CONSTRAINT `ubicaciones_repartidores_ibfk_1` FOREIGN KEY (`repartidor_id`) REFERENCES `repartidores` (`id`),
  ADD CONSTRAINT `ubicaciones_repartidores_ibfk_2` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
