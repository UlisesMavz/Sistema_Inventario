-- Script para agregar campo de posición a la tabla productos
-- Esto permite simular correctamente el comportamiento de lista enlazada

USE inventario_db;

-- Agregar campo posicion
ALTER TABLE productos ADD COLUMN posicion INT DEFAULT 0 AFTER id;

-- Actualizar posiciones de productos existentes
SET @pos = 0;
UPDATE productos SET posicion = (@pos := @pos + 1) ORDER BY id;

-- Crear índice para mejorar rendimiento
CREATE INDEX idx_posicion ON productos(posicion);

SELECT 'Campo posicion agregado exitosamente' as mensaje;
