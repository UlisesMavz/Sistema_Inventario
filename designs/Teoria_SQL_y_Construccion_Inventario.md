# 🗄️ Teoría de SQL y Construcción de la Base de Datos

Este documento explica los fundamentos de SQL (Structured Query Language) a través de la construcción paso a paso de nuestra base de datos para el **Sistema de Inventario**. Aprenderás tanto la teoría académica como su aplicación práctica en un entorno profesional.

---

## 1. Introducción a SQL y RDBMS

**SQL** es el lenguaje estándar para interactuar con **Sistemas de Gestión de Bases de Datos Relacionales (RDBMS)** como MySQL o MariaDB. Los datos en SQL se organizan en **tablas** compuestas por filas (registros) y columnas (campos).

Nuestra base de datos se llama `inventario_db`. Al inicio de cualquier script, es una buena práctica definir el entorno:

```sql
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET NAMES utf8mb4;
```
*   **START TRANSACTION**: Inicia un grupo de operaciones que deben completarse juntas (o ninguna si hay un error), asegurando la integridad.
*   **utf8mb4**: El estándar moderno de codificación que permite caracteres especiales y emojis.

---

## 2. DDL: Definición de la Estructura (Data Definition Language)

El DDL se utiliza para definir, modificar o eliminar la estructura de los objetos de la base de datos.

### A. Tipos de Datos
Elegir el tipo de dato correcto es vital para la eficiencia y precisión:

1.  **INT (Integer)**: Números enteros. Usado para `id` y `codigo`.
2.  **VARCHAR(longitud)**: Texto de longitud variable. El número indica el máximo de caracteres. Usado en `nombre` y `username`.
3.  **DECIMAL(precision, escala)**: Ideal para dinero. `DECIMAL(10,2)` significa 10 dígitos en total y 2 decimales. Nunca uses `FLOAT` para precios por errores de redondeo.
4.  **TIMESTAMP**: Registra fecha y hora. `current_timestamp()` lo hace automático.

### B. Creación de Tablas
Veamos cómo construimos la tabla `productos` integrando la teoría:

```sql
CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT 0,
  `codigo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB;
```
*   **NOT NULL**: El campo es obligatorio.
*   **DEFAULT**: Valor que toma si no se especifica uno.
*   **ON UPDATE**: Actualiza la fecha automáticamente cuando el registro cambia.

---

## 3. Integridad y Restricciones (Constraints)

Las restricciones aseguran que los datos sigan reglas de negocio estrictas. Se aplican generalmente con `ALTER TABLE`.

### Primary Key (Clave Primaria)
Es el identificador único de cada fila. No puede ser NULL y no puede repetirse.
```sql
ALTER TABLE `productos` ADD PRIMARY KEY (`id`);
ALTER TABLE `productos` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
```
*   **AUTO_INCREMENT**: SQL genera el número automáticamente (1, 2, 3...), evitando que el programador tenga que buscar el último ID.

### Unique Key (Clave Única)
A diferencia de la PK, puede haber varias llaves únicas. Asegura que valores como el código de barras no se dupliquen.
```sql
ALTER TABLE `productos` ADD UNIQUE KEY `codigo` (`codigo`);
```

---

## 4. Optimización con Índices

Un **Índice (INDEX)** es como el índice al final de un libro: permite a la base de datos encontrar información sin leer toda la tabla fila por fila.

```sql
ALTER TABLE `productos`
  ADD KEY `idx_codigo` (`codigo`),
  ADD KEY `idx_nombre` (`nombre`),
  ADD KEY `idx_posicion` (`posicion`);
```
*   **¿Cuándo usarlos?**: En columnas que aparecen frecuentemente en el `WHERE` de tus búsquedas o el `ORDER BY` de tu dashboard.
*   **Costo**: Hacen las búsquedas rápidas, pero las inserciones un poco más lentas porque el índice debe actualizarse.

---

## 5. Integridad Referencial (Foreign Keys)

Las **Llaves Foráneas (FK)** vinculan una tabla con otra, creando una relación "padre-hijo".

```sql
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` 
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) 
  ON DELETE SET NULL;
```
*   **Relación**: Cada log pertenece a un usuario.
*   **ON DELETE SET NULL**: Si borramos un usuario, sus registros de actividad (logs) no se borran, simplemente el campo `usuario_id` queda vacío. Esto es vital para auditoría.

---

## 6. DML: Manipulación de Datos (Data Manipulation Language)

Una vez creada la estructura, usamos DML para trabajar con los datos reales.

### INSERT INTO
Agrega nuevos registros a la tabla.
```sql
INSERT INTO `productos` (`codigo`, `nombre`, `precio`) VALUES
(101, 'Laptop Dell', 15999.99),
(102, 'Mouse Logitech', 299.50);
```

### El proceso de Finalización
```sql
COMMIT;
```
El comando `COMMIT` guarda permanentemente todos los cambios realizados en la transacción actual.

---

## Referencia Rápida de Comandos SQL

| Comando | Tipo | Acción |
| :--- | :--- | :--- |
| `CREATE` | DDL | Crea un nuevo objeto (tabla/BD) |
| `ALTER` | DDL | Modifica una estructura existente |
| `DROP` | DDL | Elimina un objeto permanentemente |
| `SELECT` | DQL | Consulta y recupera datos |
| `INSERT` | DML | Agrega nuevos registros |
| `UPDATE` | DML | Modifica registros existentes |
| `DELETE` | DML | Elimina registros específicos |

> **Nota para el Estudiante**: Una buena base de datos no es la que guarda más datos, sino la que garantiza que los datos guardados sean precisos e íntegros en todo momento.
