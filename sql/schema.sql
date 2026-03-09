-- ============================================
-- Sistema de Inventario - Esquema de Base de Datos
-- ============================================

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS inventario_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE inventario_db;

-- ============================================
-- Tabla: usuarios
-- Almacena información de usuarios del sistema
-- ============================================
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(100) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Tabla: productos
-- Almacena el inventario de productos
-- ============================================
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    posicion INT NOT NULL DEFAULT 0,
    codigo INT NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    stock_minimo INT NOT NULL DEFAULT 5,
    categoria VARCHAR(100) NOT NULL DEFAULT 'General',
    marca_proveedor VARCHAR(100) NOT NULL DEFAULT 'Genérico',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_posicion (posicion),
    INDEX idx_codigo (codigo),
    INDEX idx_nombre (nombre),
    INDEX idx_precio (precio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Funcionalidad de logs eliminada a petición del usuario.

-- ============================================
-- Datos iniciales
-- ============================================

-- Insertar superadministrador único (password: ADMIN)
INSERT INTO usuarios (username, password, nombre_completo) VALUES
('ADMIN', '$2y$10$lh4fdkHFBufzts20VQJ6uuKvNyrl3pALrjTJawAXgQowZ2en22IX.', 'Super Administrador');

-- Insertar productos de ejemplo
INSERT INTO productos (codigo, nombre, precio) VALUES
(101, 'Laptop Dell', 15999.99),
(102, 'Mouse Logitech', 299.50),
(103, 'Teclado Mecánico', 1299.00),
(104, 'Monitor Samsung 24"', 3499.00),
(105, 'Webcam HD', 899.99);
