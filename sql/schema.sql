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
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_posicion (posicion),
    INDEX idx_codigo (codigo),
    INDEX idx_nombre (nombre),
    INDEX idx_precio (precio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Tabla: logs
-- Registra todas las operaciones realizadas
-- ============================================
CREATE TABLE IF NOT EXISTS logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    accion VARCHAR(50) NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    INDEX idx_fecha (fecha),
    INDEX idx_usuario (usuario_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Datos iniciales
-- ============================================

-- Insertar superadministrador único (password: 2023350794)
INSERT INTO usuarios (username, password, nombre_completo) VALUES
('SUPERADMIN', '$2y$10$5.sNxcwVTJE9iw2J71GmauLDayD7USaRisyH5XSZFucJsLrqQcmXy', 'Super Administrador');

-- Insertar productos de ejemplo
INSERT INTO productos (codigo, nombre, precio) VALUES
(101, 'Laptop Dell', 15999.99),
(102, 'Mouse Logitech', 299.50),
(103, 'Teclado Mecánico', 1299.00),
(104, 'Monitor Samsung 24"', 3499.00),
(105, 'Webcam HD', 899.99);
