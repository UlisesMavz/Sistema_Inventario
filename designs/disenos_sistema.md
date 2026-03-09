# 📐 Diseños del Sistema de Inventario

Este documento contiene los tres diseños principales del sistema: Casos de Uso, Diagrama UML de Clases, y Diseño de Base de Datos.

---

## 1. Diagrama de Casos de Uso

### Diagrama

```mermaid
graph TB
    subgraph "Sistema de Inventario"
        UC1[Iniciar Sesión]
        UC2[Insertar Producto]
        UC3[Eliminar Producto]
        UC4[Buscar Producto]
        UC5[Ordenar Productos]
        UC6[Visualizar Inventario]
        UC7[Cerrar Sesión]
    end
    
    Usuario([Usuario Autenticado])
    Sistema([Sistema])
    BD[(Base de Datos)]
    
    Usuario -->|realiza| UC1
    Usuario -->|realiza| UC2
    Usuario -->|realiza| UC3
    Usuario -->|realiza| UC4
    Usuario -->|realiza| UC5
    Usuario -->|realiza| UC6
    Usuario -->|realiza| UC7
    
    UC1 -->|valida| Sistema
    UC2 -->|persiste| BD
    UC3 -->|elimina de| BD
    UC4 -->|consulta| BD
    UC5 -->|obtiene de| BD
    UC6 -->|consulta| BD
    
    UC2 -.incluye.-> UC2A[Validar Datos]
    UC2 -.incluye.-> UC2B[Verificar Código Único]
    UC2 -.incluye.-> UC2C[Actualizar Posiciones]
    
    UC4 -.extiende.-> UC4A[Búsqueda Lineal]
    UC4 -.extiende.-> UC4B[Búsqueda Binaria]
    
    UC5 -.extiende.-> UC5A[Bubble Sort]
    UC5 -.extiende.-> UC5B[Quick Sort]
```

### Explicación del Diagrama de Casos de Uso

#### Actores del Sistema

**1. Usuario Autenticado**
- **Descripción**: Persona que ha iniciado sesión en el sistema
- **Responsabilidades**: Gestionar el inventario de productos
- **Acciones**: Puede realizar todas las operaciones CRUD y consultas

**2. Sistema**
- **Descripción**: Componente que procesa la lógica de negocio
- **Responsabilidades**: Validar datos, ejecutar algoritmos, coordinar operaciones
- **Interacciones**: Intermediario entre usuario y base de datos

**3. Base de Datos**
- **Descripción**: Almacenamiento persistente de información
- **Responsabilidades**: Guardar, recuperar y eliminar datos
- **Tecnología**: MySQL

#### Casos de Uso Principales

##### UC1: Iniciar Sesión
- **Actor**: Usuario
- **Precondición**: Usuario tiene credenciales válidas
- **Flujo Principal**:
  1. Usuario ingresa nombre de usuario y NIP
  2. Sistema valida credenciales contra BD
  3. Sistema verifica hash de contraseña
  4. Sistema crea sesión
  5. Sistema redirige a dashboard
- **Postcondición**: Usuario autenticado con sesión activa
- **Excepciones**: Credenciales inválidas → Mostrar error

##### UC2: Insertar Producto
- **Actor**: Usuario Autenticado
- **Precondición**: Usuario tiene sesión activa
- **Flujo Principal**:
  1. Usuario ingresa código, nombre, precio
  2. Usuario selecciona tipo de inserción (inicio/final/posición)
  3. Sistema valida datos (UC2A)
  4. Sistema verifica código único (UC2B)
  5. Sistema actualiza posiciones si es necesario (UC2C)
  6. Sistema inserta producto en BD
  7. Sistema registra log de operación
  8. Sistema muestra confirmación
- **Postcondición**: Producto insertado en la posición correcta
- **Excepciones**: 
  - Código duplicado → Rechazar inserción
  - Datos inválidos → Mostrar errores de validación

**Casos de Uso Incluidos:**
- **UC2A: Validar Datos**
  - Verificar que código sea numérico
  - Verificar que nombre no esté vacío
  - Verificar que precio sea >= 0
  
- **UC2B: Verificar Código Único**
  - Consultar BD para verificar si código existe
  - Retornar error si ya existe
  
- **UC2C: Actualizar Posiciones**
  - Si inserción al inicio: incrementar posición de todos
  - Si inserción en posición específica: ajustar posiciones afectadas

##### UC3: Eliminar Producto
- **Actor**: Usuario Autenticado
- **Precondición**: Existen productos en el inventario
- **Flujo Principal**:
  1. Usuario selecciona tipo de eliminación (inicio/final/código)
  2. Sistema solicita confirmación
  3. Usuario confirma
  4. Sistema elimina producto de BD
  5. Sistema registra log
  6. Sistema actualiza vista
- **Postcondición**: Producto eliminado del inventario
- **Excepciones**: 
  - Inventario vacío → Mostrar mensaje
  - Código no existe → Mostrar error

##### UC4: Buscar Producto
- **Actor**: Usuario Autenticado
- **Precondición**: Usuario tiene sesión activa
- **Flujo Principal**:
  1. Usuario ingresa criterio de búsqueda (código o nombre)
  2. Usuario selecciona algoritmo (lineal o binaria)
  3. Sistema ejecuta búsqueda
  4. Sistema mide tiempo de ejecución
  5. Sistema muestra resultado y tiempo
- **Postcondición**: Producto encontrado o mensaje de no encontrado
- **Extensiones**:
  - **UC4A: Búsqueda Lineal** - O(n), funciona con datos desordenados
  - **UC4B: Búsqueda Binaria** - O(log n), requiere ordenamiento previo

##### UC5: Ordenar Productos
- **Actor**: Usuario Autenticado
- **Precondición**: Existen productos en el inventario
- **Flujo Principal**:
  1. Usuario selecciona criterio (precio, nombre, código)
  2. Usuario selecciona algoritmo (Bubble Sort o Quick Sort)
  3. Sistema ejecuta ordenamiento
  4. Sistema mide tiempo de ejecución
  5. Sistema muestra productos ordenados y tiempo
- **Postcondición**: Productos mostrados en orden especificado
- **Extensiones**:
  - **UC5A: Bubble Sort** - O(n²), simple pero lento
  - **UC5B: Quick Sort** - O(n log n), rápido para grandes volúmenes

##### UC6: Visualizar Inventario
- **Actor**: Usuario Autenticado
- **Precondición**: Usuario tiene sesión activa
- **Flujo Principal**:
  1. Sistema consulta productos ordenados por posición
  2. Sistema muestra tabla con todos los productos
  3. Sistema muestra contador total
- **Postcondición**: Usuario ve inventario completo

##### UC7: Cerrar Sesión
- **Actor**: Usuario Autenticado
- **Precondición**: Usuario tiene sesión activa
- **Flujo Principal**:
  1. Usuario hace clic en "Cerrar Sesión"
  2. Sistema destruye sesión
  3. Sistema redirige a página de login
- **Postcondición**: Sesión terminada

#### Relaciones entre Casos de Uso

**Include (Incluye)**: Relación obligatoria
- UC2 **incluye** UC2A, UC2B, UC2C
- Siempre se ejecutan como parte de insertar producto

**Extend (Extiende)**: Relación opcional
- UC4 **se extiende** a UC4A o UC4B
- UC5 **se extiende** a UC5A o UC5B
- El usuario elige cuál ejecutar

---


## . Diseño de Base de Datos

### Diagrama Entidad-Relación

```mermaid
erDiagram
    
    
    USUARIOS {
        int id PK "AUTO_INCREMENT"
        varchar nombre_usuario UK "UNIQUE, NOT NULL"
        varchar password_hash "NOT NULL"
        varchar nombre_completo "NOT NULL"
    }
    
    PRODUCTOS {
        int id PK "AUTO_INCREMENT"
        int posicion "NOT NULL, DEFAULT 0, INDEX"
        int codigo UK "UNIQUE, NOT NULL, INDEX"
        varchar nombre "NOT NULL, INDEX"
        decimal precio "NOT NULL, INDEX"
        timestamp fecha_creacion "DEFAULT CURRENT_TIMESTAMP"
    }
    
```


### Explicación del Diseño de Base de Datos

#### Características Generales

**Motor de Almacenamiento**: InnoDB
- ✅ Soporta transacciones ACID
- ✅ Integridad referencial con FOREIGN KEYS
- ✅ Bloqueo a nivel de fila
- ✅ Recuperación ante fallos

**Charset**: utf8mb4
- ✅ Soporta emojis y caracteres especiales
- ✅ Compatibilidad internacional completa
- ✅ Estándar moderno de Unicode

**Collation**: utf8mb4_unicode_ci
- ✅ Comparaciones case-insensitive
- ✅ Ordenamiento correcto de caracteres especiales

#### Tabla: usuarios

**Propósito**: Almacenar información de autenticación

**Campos**:

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | INT AUTO_INCREMENT | Clave primaria única |
| `nombre_usuario` | VARCHAR(50) UNIQUE | Username para login, debe ser único |
| `password_hash` | VARCHAR(255) | Contraseña hasheada con bcrypt |
| `nombre_completo` | VARCHAR(100) | Nombre real del usuario |
| `fecha_creacion` | TIMESTAMP | Fecha de registro automática |

**Índices**:
- `PRIMARY KEY (id)`: Búsqueda rápida por ID
- `UNIQUE (nombre_usuario)`: Garantiza unicidad de usernames
- `INDEX (nombre_usuario)`: Optimiza búsquedas en login

**Seguridad**:
- Contraseñas hasheadas con `password_hash()` de PHP
- Nunca almacena passwords en texto plano
- Hash bcrypt con salt automático

**Ejemplo de Datos**:
```sql
INSERT INTO usuarios (nombre_usuario, password_hash, nombre_completo) VALUES
('Horacio', '$2y$10$...hash...', 'Horacio Martínez'),
('Omar', '$2y$10$...hash...', 'Omar López');
```

#### Tabla: productos

**Propósito**: Almacenar inventario de productos

**Campos**:

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | INT AUTO_INCREMENT | Clave primaria única |
| `posicion` | INT NOT NULL | Posición en la lista (para ordenamiento) |
| `codigo` | INT UNIQUE | Código único del producto |
| `nombre` | VARCHAR(100) | Nombre descriptivo |
| `precio` | DECIMAL(10,2) | Precio con 2 decimales |
| `fecha_creacion` | TIMESTAMP | Fecha de creación automática |
| `fecha_modificacion` | TIMESTAMP | Actualización automática |

**Campo Especial: `posicion`**
- **¿Por qué existe?**: Simula comportamiento de lista enlazada
- **Función**: Mantiene orden independiente del ID
- **Ventaja**: Permite inserción al inicio/final sin depender de ID auto-incremental
- **Ejemplo**:
  ```
  id | posicion | codigo | nombre
  5  | 1        | 105    | Webcam     ← Insertado al inicio
  1  | 2        | 101    | Laptop     ← Posición incrementada
  2  | 3        | 102    | Mouse      ← Posición incrementada
  ```

**Índices**:
- `PRIMARY KEY (id)`: Identificación única
- `UNIQUE (codigo)`: Garantiza códigos únicos
- `INDEX (posicion)`: Optimiza `ORDER BY posicion`
- `INDEX (codigo)`: Optimiza búsquedas por código
- `INDEX (nombre)`: Optimiza búsquedas por nombre
- `INDEX (precio)`: Optimiza ordenamiento por precio

**¿Por qué tantos índices?**
- Sistema realiza búsquedas frecuentes
- Ordenamiento es operación común
- Índices aceleran consultas SELECT
- Costo: Espacio adicional (aceptable para este volumen)

**Constraints**:
- `NOT NULL` en campos críticos
- `UNIQUE` en código para evitar duplicados
- `DEFAULT 0` en posicion para nuevos productos

**Timestamps Automáticos**:
- `fecha_creacion`: Se establece al insertar
- `fecha_modificacion`: Se actualiza automáticamente con `ON UPDATE CURRENT_TIMESTAMP`

#### Tabla: logs

**Propósito**: Auditoría de operaciones del sistema

**Campos**:

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | INT AUTO_INCREMENT | Clave primaria única |
| `usuario_id` | INT FK | Referencia a usuario que realizó la acción |
| `operacion` | VARCHAR(50) | Tipo de operación (INSERT_INICIO, DELETE_CODIGO, etc.) |
| `detalles` | TEXT | Información adicional en formato JSON o texto |
| `producto_id` | INT FK NULL | Referencia a producto afectado (si aplica) |
| `fecha` | TIMESTAMP | Momento exacto de la operación |

**Relaciones (Foreign Keys)**:

1. **`usuario_id` → `usuarios.id`**
   - `ON DELETE CASCADE`: Si se elimina usuario, se eliminan sus logs
   - Mantiene integridad referencial
   
2. **`producto_id` → `productos.id`**
   - `ON DELETE SET NULL`: Si se elimina producto, el log permanece pero producto_id = NULL
   - Preserva historial aunque producto ya no exista

**Índices**:
- `INDEX (usuario_id)`: Consultar logs por usuario
- `INDEX (fecha)`: Consultar logs por rango de fechas
- `INDEX (operacion)`: Filtrar por tipo de operación

**Tipos de Operaciones Registradas**:
- `LOGIN`: Inicio de sesión
- `LOGOUT`: Cierre de sesión
- `INSERT_INICIO`: Inserción al inicio
- `INSERT_FINAL`: Inserción al final
- `INSERT_POSICION`: Inserción en posición específica
- `DELETE_INICIO`: Eliminación del primero
- `DELETE_FINAL`: Eliminación del último
- `DELETE_CODIGO`: Eliminación por código

**Ejemplo de Log**:
```sql
INSERT INTO logs (usuario_id, operacion, detalles, producto_id) VALUES
(1, 'INSERT_INICIO', 'Producto: Laptop Dell, Precio: 15000', 5);
```

#### Relaciones entre Tablas

```
USUARIOS (1) ──────── (N) LOGS
   │
   └─ Un usuario puede generar múltiples logs
   
PRODUCTOS (1) ──────── (N) LOGS
   │
   └─ Un producto puede aparecer en múltiples logs
```

**Cardinalidad**:
- `USUARIOS` → `LOGS`: 1:N (Uno a Muchos)
- `PRODUCTOS` → `LOGS`: 1:N (Uno a Muchos)

#### Normalización

**Forma Normal Alcanzada**: 3FN (Tercera Forma Normal)

**1FN (Primera Forma Normal)**:
- ✅ Todos los atributos son atómicos
- ✅ No hay grupos repetitivos
- ✅ Cada campo contiene un solo valor

**2FN (Segunda Forma Normal)**:
- ✅ Cumple 1FN
- ✅ Todos los atributos no clave dependen completamente de la clave primaria
- ✅ No hay dependencias parciales

**3FN (Tercera Forma Normal)**:
- ✅ Cumple 2FN
- ✅ No hay dependencias transitivas
- ✅ Cada atributo no clave depende solo de la clave primaria

**Ventajas de la Normalización**:
- Elimina redundancia de datos
- Facilita actualizaciones
- Previene anomalías de inserción/actualización/eliminación
- Mejora integridad de datos

#### Estrategia de Índices

**Índices Primarios** (PRIMARY KEY):
- `usuarios.id`
- `productos.id`
- `logs.id`

**Índices Únicos** (UNIQUE):
- `usuarios.nombre_usuario`
- `productos.codigo`

**Índices Secundarios** (INDEX):
- `productos.posicion` → Para `ORDER BY posicion`
- `productos.nombre` → Para búsquedas por nombre
- `productos.precio` → Para ordenamiento por precio
- `logs.usuario_id` → Para consultas de auditoría
- `logs.fecha` → Para reportes por fecha
- `logs.operacion` → Para filtrar por tipo

**Análisis de Rendimiento**:
```sql
-- Sin índice en posicion: O(n log n) sort
SELECT * FROM productos ORDER BY posicion;

-- Con índice en posicion: O(n) scan del índice
SELECT * FROM productos ORDER BY posicion;
```

#### Consideraciones de Diseño

**1. ¿Por qué INT para código y no VARCHAR?**
- ✅ Más eficiente en búsquedas (comparación numérica)
- ✅ Menor espacio de almacenamiento
- ✅ Índices más pequeños y rápidos
- ✅ Compatibilidad con código C++ original
- ❌ Limitación: No soporta códigos alfanuméricos

**2. ¿Por qué DECIMAL(10,2) para precio?**
- ✅ Precisión exacta (no errores de redondeo como FLOAT)
- ✅ Estándar para valores monetarios
- ✅ 10 dígitos totales, 2 decimales
- ✅ Soporta precios hasta 99,999,999.99

**3. ¿Por qué InnoDB y no MyISAM?**
- ✅ Transacciones ACID
- ✅ Foreign Keys
- ✅ Recuperación ante fallos
- ✅ Mejor para aplicaciones modernas

**4. ¿Por qué ON DELETE CASCADE en logs?**
- Si se elimina un usuario, sus logs también se eliminan
- Mantiene consistencia
- Evita logs huérfanos

**5. ¿Por qué ON DELETE SET NULL en logs.producto_id?**
- Preserva historial de operaciones
- Aunque el producto ya no exista, el log indica que existió
- Útil para auditoría

---

## Resumen de Diseños

### Casos de Uso
- **7 casos de uso principales**
- **3 actores** (Usuario, Sistema, BD)
- **Relaciones include y extend**
- **Flujos detallados** para cada caso

### UML de Clases
- **11 clases** en 4 capas
- **Patrón MVC** implementado
- **Principios SOLID** aplicados
- **Separación clara** de responsabilidades

### Base de Datos
- **3 tablas** normalizadas a 3FN
- **2 relaciones** con foreign keys
- **12 índices** para optimización
- **Motor InnoDB** con transacciones

---

**Documento creado para**: Sistema de Inventario  
**Fecha**: Febrero 2026  
**Propósito**: Documentación de diseño del sistema
