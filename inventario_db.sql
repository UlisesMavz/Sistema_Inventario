-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-03-2026 a las 02:43:58
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
-- Base de datos: `inventario_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT 0,
  `codigo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stock` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) NOT NULL DEFAULT 5,
  `categoria` varchar(100) NOT NULL DEFAULT 'General',
  `marca_proveedor` varchar(100) NOT NULL DEFAULT 'Genérico'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `posicion`, `codigo`, `nombre`, `precio`, `fecha_creacion`, `fecha_modificacion`, `stock`, `stock_minimo`, `categoria`, `marca_proveedor`) VALUES
(2, 2, 5625, 'Nescafé 120g', 74.80, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 38, 14, 'Abarrotes', 'Nestlé'),
(3, 3, 5449, 'Doritos Nacho 50g', 18.54, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 40, 6, 'Botanas', 'Sabritas'),
(4, 4, 5632, 'Coca Cola 600ml', 16.84, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 41, 6, 'Refrescos y Bebidas', 'Coca-Cola'),
(5, 5, 9002, 'Leche Alpura Clásica', 27.16, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 36, 18, 'Lácteos', 'Alpura'),
(6, 6, 2449, 'Mouse Logitech', 270.00, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 19, 18, 'Electrónica', 'Logitech'),
(7, 7, 3966, 'Plumas BIC', 55.00, '2026-03-10 00:40:49', '2026-03-10 01:01:53', 0, 13, 'Papelería', 'BIC'),
(8, 8, 9880, 'Yogurt Lala Fresa', 11.88, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 45, 17, 'Lácteos', 'Lala'),
(9, 9, 304, 'Cuaderno Scribe', 36.75, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 38, 19, 'Papelería', 'Scribe'),
(10, 10, 843, 'Coca Cola 600ml', 17.39, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 20, 18, 'Refrescos y Bebidas', 'Coca-Cola'),
(11, 11, 785, 'Coca Cola 600ml', 18.32, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 28, 8, 'Refrescos y Bebidas', 'Coca-Cola'),
(12, 12, 2594, 'Yogurt Lala Fresa', 14.75, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 20, 17, 'Lácteos', 'Lala'),
(13, 13, 5106, 'Detergente Ariel 1kg', 39.56, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 27, 7, 'Limpieza del Hogar', 'Genérico'),
(14, 14, 2125, 'Coca Cola 600ml', 18.50, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 20, 10, 'Refrescos y Bebidas', 'Coca-Cola'),
(15, 15, 4841, 'Nescafé 120g', 98.60, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 32, 10, 'Abarrotes', 'Nestlé'),
(16, 16, 3428, 'Yogurt Lala Fresa', 12.75, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 20, 7, 'Lácteos', 'Lala'),
(17, 17, 9141, 'Sabritas Saladas 40g', 18.87, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 5, 20, 'Botanas', 'Sabritas'),
(18, 18, 2852, 'Bimbo Pan Blanco', 44.55, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 8, 14, 'Abarrotes', 'Bimbo'),
(19, 19, 9052, 'Laptop Lenovo ThinkPad', 12600.00, '2026-03-10 00:40:49', '2026-03-10 00:40:49', 37, 15, 'Electrónica', 'Lenovo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `nombre_completo`, `fecha_creacion`) VALUES
(14, 'ADMIN', '$2y$10$lh4fdkHFBufzts20VQJ6uuKvNyrl3pALrjTJawAXgQowZ2en22IX.', 'Super Administrador', '2026-02-26 04:29:39');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `idx_codigo` (`codigo`),
  ADD KEY `idx_nombre` (`nombre`),
  ADD KEY `idx_precio` (`precio`),
  ADD KEY `idx_posicion` (`posicion`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
