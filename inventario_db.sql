-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-03-2026 a las 05:21:55
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

-- Tabla logs eliminada a petición del usuario.

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
  `stock` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) NOT NULL DEFAULT 5,
  `categoria` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'General',
  `marca_proveedor` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Genérico',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `posicion`, `codigo`, `nombre`, `precio`, `fecha_creacion`, `fecha_modificacion`) VALUES
(23, 6, 100, 'Yakult', 20.00, '2026-02-16 03:03:41', '2026-02-17 02:43:23'),
(34, 7, 123, 'Memoria RAM', 1000.00, '2026-02-16 05:41:04', '2026-02-17 02:43:23'),
(35, 8, 999, 'Producto de Prueba', 99.99, '2026-02-16 05:47:07', '2026-02-17 02:43:23'),
(36, 9, 888, 'Test API', 88.88, '2026-02-16 05:47:07', '2026-02-17 02:43:23'),
(37, 10, 200, 'Yogurt', 100.00, '2026-02-16 05:48:49', '2026-02-17 02:43:23'),
(43, 11, 107, 'Libreta', 35.00, '2026-02-16 05:49:41', '2026-02-17 02:43:23'),
(44, 12, 202, 'Producto ', 100.00, '2026-02-16 05:51:11', '2026-02-17 02:43:23'),
(45, 13, 21, 'RAM', 20.00, '2026-02-16 05:58:31', '2026-02-17 02:43:23'),
(47, 15, 199, 'SW', 99999999.99, '2026-02-16 06:09:33', '2026-02-17 02:43:23'),
(49, 2, 124, 'poemas1', 15.00, '2026-02-16 06:40:27', '2026-02-17 02:43:23'),
(50, 16, 55, 'poema2', 11.00, '2026-02-16 06:41:16', '2026-02-17 02:43:23');

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
(9, 'ADMIN', '$2y$10$lh4fdkHFBufzts20VQJ6uuKvNyrl3pALrjTJawAXgQowZ2en22IX.', 'Super Administrador', '2026-02-16 02:48:36');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_fecha` (`fecha`),
  ADD KEY `idx_usuario` (`usuario_id`);

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

-- (Logs eliminados)

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

-- (Filtros logs eliminados)
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
