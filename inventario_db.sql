-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-02-2026 a las 05:28:03
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
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `accion` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `logs`
--

INSERT INTO `logs` (`id`, `usuario_id`, `accion`, `descripcion`, `fecha`) VALUES
(1, 9, 'LOGIN', 'Usuario inició sesión', '2026-02-16 02:48:55'),
(2, 9, 'LOGIN', 'Usuario inició sesión', '2026-02-16 02:50:47'),
(3, 9, 'LOGIN', 'Usuario inició sesión', '2026-02-16 02:50:52'),
(4, 9, 'INSERT_INICIO', 'Producto insertado al inicio: Yakult', '2026-02-16 02:52:11'),
(5, 9, 'LOGIN', 'Usuario inició sesión', '2026-02-16 03:02:07'),
(6, 9, 'INSERT_INICIO', 'Producto insertado al inicio: Yakult', '2026-02-16 03:02:48'),
(7, 9, 'INSERT_INICIO', 'Producto insertado al inicio: Yakult', '2026-02-16 03:03:41'),
(8, 9, 'LOGIN', 'Usuario inició sesión', '2026-02-16 05:40:34'),
(9, 9, 'INSERT_INICIO', 'Producto insertado al inicio: Memoria RAM', '2026-02-16 05:41:04'),
(10, 9, 'INSERT_INICIO', 'Producto insertado al inicio: Producto de Prueba', '2026-02-16 05:47:07'),
(11, 9, 'INSERT_INICIO', 'Producto insertado al inicio: Test API', '2026-02-16 05:47:07'),
(12, 9, 'INSERT_INICIO', 'Producto insertado al inicio: Yogurt', '2026-02-16 05:48:49'),
(13, 9, 'LOGIN', 'Usuario inició sesión', '2026-02-16 05:49:20'),
(14, 9, 'INSERT_INICIO', 'Producto insertado al inicio: Libreta', '2026-02-16 05:49:41'),
(15, 9, 'INSERT_INICIO', 'Producto insertado al inicio: Producto ', '2026-02-16 05:51:11'),
(16, 9, 'DELETE_CODIGO', 'Producto eliminado con código: 101', '2026-02-16 05:57:39'),
(17, 9, 'INSERT_POSICION', 'Producto insertado en posición 1: RAM', '2026-02-16 05:58:31'),
(18, 9, 'LOGIN', 'Usuario inició sesión', '2026-02-16 06:03:29'),
(19, 9, 'LOGIN', 'Usuario inició sesión', '2026-02-16 06:04:34'),
(20, 9, 'INSERT_FINAL', 'Producto insertado al final: Poemxxxs', '2026-02-16 06:05:03'),
(21, 9, 'LOGIN', 'Usuario inició sesión', '2026-02-16 06:08:01'),
(22, 9, 'DELETE_INICIO', 'Producto eliminado del inicio: Mouse Logitech', '2026-02-16 06:08:42'),
(23, 9, 'DELETE_INICIO', 'Producto eliminado del inicio: Teclado Mecánico', '2026-02-16 06:08:55'),
(24, 9, 'INSERT_INICIO', 'Producto insertado al inicio: SW', '2026-02-16 06:09:33'),
(25, 9, 'INSERT_FINAL', 'Producto insertado al final: Monaschinas', '2026-02-16 06:10:15'),
(26, 9, 'DELETE_FINAL', 'Producto eliminado del final: Monaschinas', '2026-02-16 06:23:34'),
(27, 9, 'DELETE_INICIO', 'Producto eliminado del inicio: Monitor Samsung 24\"', '2026-02-16 06:23:36'),
(28, 9, 'INSERT_INICIO', 'Producto insertado al inicio: poemas1', '2026-02-16 06:40:27'),
(29, 9, 'INSERT_FINAL', 'Producto insertado al final: poema2', '2026-02-16 06:41:16'),
(30, 9, 'LOGIN', 'Usuario inició sesión', '2026-02-16 06:43:43'),
(31, 9, 'DELETE_CODIGO', 'Producto eliminado con código: 105', '2026-02-16 06:43:58'),
(32, 9, 'LOGIN', 'Usuario inició sesión', '2026-02-17 02:16:11'),
(33, 9, 'DELETE_CODIGO', 'Producto eliminado con código: 123456789', '2026-02-17 02:17:49'),
(34, 9, 'DELETE_CODIGO', 'Producto eliminado con código: 1', '2026-02-17 02:17:57'),
(35, 9, 'DELETE_CODIGO', 'Producto eliminado con código: 99', '2026-02-17 02:18:09'),
(36, 9, 'LOGIN', 'Usuario inició sesión', '2026-02-17 02:42:06'),
(37, 9, 'INSERT_INICIO', 'Producto insertado al inicio: Tortas de don sucio', '2026-02-17 02:43:23');

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
(50, 16, 55, 'poema2', 11.00, '2026-02-16 06:41:16', '2026-02-17 02:43:23'),
(51, 1, 83, 'Tortas de don sucio', 50.00, '2026-02-17 02:43:23', '2026-02-17 02:43:23');

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
(1, 'Horacio', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Horacio Martinez', '2026-02-16 02:41:47'),
(2, 'Omar', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Omar Rodriguez', '2026-02-16 02:41:47'),
(3, 'Erick', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Erick Gonzalez', '2026-02-16 02:41:47'),
(4, 'WalterJr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Walter Junior', '2026-02-16 02:41:47'),
(9, 'SUPERADMIN', '$2y$10$5.sNxcwVTJE9iw2J71GmauLDayD7USaRisyH5XSZFucJsLrqQcmXy', 'Super Administrador', '2026-02-16 02:48:36');

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

--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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

--
-- Filtros para la tabla `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
