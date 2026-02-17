# 📐 Arquitectura del Sistema de Inventario

## Índice
1. [Visión General](#visión-general)
2. [Estructura del Proyecto](#estructura-del-proyecto)
3. [Patrón de Arquitectura](#patrón-de-arquitectura)
4. [Componentes Principales](#componentes-principales)
5. [Flujo de Datos](#flujo-de-datos)
6. [Decisiones de Diseño](#decisiones-de-diseño)

---

## Visión General

### Propósito del Sistema
Sistema de gestión de inventario diseñado para demostrar conocimientos de:
- **Análisis de Algoritmos**: Implementación desde cero de algoritmos de ordenamiento y búsqueda
- **Desarrollo Full-Stack**: Backend PHP con MySQL y frontend JavaScript
- **Arquitectura de Software**: Patrón MVC (Model-View-Controller)
- **Buenas Prácticas**: Código limpio, documentado y mantenible

### Tecnologías Utilizadas
- **Backend**: PHP 7.4+
- **Base de Datos**: MySQL (MariaDB)
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Servidor**: XAMPP (Apache + MySQL)
- **Arquitectura**: REST API

---

## Estructura del Proyecto

```
Sistema_Inventario/
│
├── api/                    # Endpoints REST API
│   ├── auth.php           # Autenticación de usuarios
│   ├── productos.php      # CRUD de productos
│   ├── buscar.php         # Búsqueda de productos
│   └── ordenar.php        # Ordenamiento de productos
│
├── config/                 # Configuración del sistema
│   └── database.php       # Conexión a base de datos (Singleton)
│
├── controllers/            # Lógica de negocio
│   ├── AuthController.php        # Control de autenticación
│   └── ProductoController.php    # Control de productos
│
├── models/                 # Modelos de datos
│   ├── Usuario.php        # Modelo de usuario
│   └── Producto.php       # Modelo de producto
│
├── utils/                  # Utilidades y algoritmos
│   ├── Busqueda.php       # Algoritmos de búsqueda
│   └── Ordenamiento.php   # Algoritmos de ordenamiento
│
├── public/                 # Archivos públicos (frontend)
│   ├── index.html         # Página de login
│   ├── dashboard.html     # Panel principal
│   ├── css/
│   │   └── styles.css     # Estilos del sistema
│   └── js/
│       ├── main.js        # Funciones generales
│       └── productos.js   # Lógica de productos
│
├── sql/                    # Scripts de base de datos
│   ├── schema.sql         # Esquema de la BD
│   └── migrate_posicion.php  # Script de migración
│
├── install.php             # Instalador del sistema
└── README.md              # Documentación general
```

---

## Patrón de Arquitectura

### MVC (Model-View-Controller)

#### ¿Por qué MVC?

**Separación de Responsabilidades**
- **Mantenibilidad**: Cada componente tiene una responsabilidad única
- **Escalabilidad**: Fácil agregar nuevas funcionalidades
- **Testabilidad**: Componentes independientes son más fáciles de probar
- **Trabajo en Equipo**: Diferentes desarrolladores pueden trabajar en diferentes capas

#### Implementación en el Proyecto

```
┌─────────────┐
│    VIEW     │  ← Frontend (HTML/CSS/JS)
│ (public/)   │
└──────┬──────┘
       │
       ↓ HTTP Request
┌─────────────┐
│ CONTROLLER  │  ← Lógica de negocio (controllers/)
│   + API     │
└──────┬──────┘
       │
       ↓ Manipula
┌─────────────┐
│    MODEL    │  ← Datos y validación (models/)
└──────┬──────┘
       │
       ↓ Persiste
┌─────────────┐
│  DATABASE   │  ← MySQL
└─────────────┘
```

---

## Componentes Principales

### 1. API (api/)

**Propósito**: Endpoints REST para comunicación cliente-servidor

#### api/productos.php
**Responsabilidad**: CRUD completo de productos

**Operaciones**:
- `GET`: Obtener todos los productos
- `POST`: Insertar producto (inicio/final/posición)
- `DELETE`: Eliminar producto (inicio/final/por código)

**¿Por qué REST?**
- ✅ Estándar de la industria
- ✅ Stateless (sin estado entre peticiones)
- ✅ Fácil de consumir desde cualquier cliente
- ✅ Cacheable y escalable

**Ejemplo de flujo**:
```
Cliente (JS) → POST /api/productos.php
              ↓
         JSON: {codigo: 100, nombre: "Laptop", precio: 15000, tipo: "inicio"}
              ↓
         ProductoController->insertarInicio()
              ↓
         Respuesta: {exito: true, mensaje: "Producto insertado"}
```

#### api/buscar.php
**Responsabilidad**: Búsqueda de productos con algoritmos personalizados

**Algoritmos disponibles**:
- Búsqueda Lineal: O(n)
- Búsqueda Binaria: O(log n)

**¿Por qué implementar desde cero?**
- 📚 Demostrar conocimiento de complejidad algorítmica
- 🎯 Entender el funcionamiento interno
- 💡 Optimizar según necesidades específicas

#### api/ordenar.php
**Responsabilidad**: Ordenamiento de productos

**Algoritmos disponibles**:
- Bubble Sort: O(n²)
- Quick Sort: O(n log n)

---

### 2. Configuración (config/)

#### config/database.php

**Patrón**: Singleton

**¿Por qué Singleton?**
- ✅ Una sola conexión a BD durante toda la ejecución
- ✅ Ahorro de recursos
- ✅ Evita múltiples conexiones innecesarias
- ✅ Punto centralizado de configuración

**Implementación**:
```php
class Database {
    private $conn = null;
    
    public function getConnection() {
        if ($this->conn !== null) {
            return $this->conn; // Reutilizar conexión existente
        }
        // Crear nueva conexión solo si no existe
        $this->conn = new PDO($dsn, $user, $pass);
        return $this->conn;
    }
}
```

**Características**:
- PDO (PHP Data Objects) para seguridad
- Prepared Statements contra SQL Injection
- Manejo de errores con excepciones
- Configuración de charset UTF-8

---

### 3. Controladores (controllers/)

#### ProductoController.php

**Responsabilidad**: Lógica de negocio para productos

**Métodos principales**:

##### Inserción
```php
insertarInicio($producto)    // Inserta en posición 1
insertarFinal($producto)     // Inserta en última posición
insertarPosicion($producto, $pos)  // Inserta en posición específica
```

**¿Por qué usar posiciones?**
- 🎯 Simula comportamiento de lista enlazada
- 📊 Orden explícito y controlado
- 🔄 Permite reordenamiento sin cambiar IDs
- ✅ Independiente del orden de inserción en BD

**Implementación de "Insertar al Inicio"**:
```php
// 1. Incrementar posición de todos los productos
UPDATE productos SET posicion = posicion + 1

// 2. Insertar nuevo producto en posición 1
INSERT INTO productos (codigo, nombre, precio, posicion) 
VALUES (:codigo, :nombre, :precio, 1)
```

##### Eliminación
```php
eliminarInicio()           // Elimina el primero (posición 1)
eliminarFinal()            // Elimina el último
eliminarPorCodigo($codigo) // Elimina por código específico
```

##### Consulta
```php
obtenerTodos()             // Retorna todos ordenados por posición
buscarPorCodigo($codigo)   // Busca un producto específico
contarProductos()          // Cuenta total de productos
```

**Sistema de Logs**:
- Registra todas las operaciones
- Asocia acciones con usuario
- Útil para auditoría y debugging

---

### 4. Modelos (models/)

#### Producto.php

**Responsabilidad**: Representación de datos y validación

**Propiedades**:
```php
class Producto {
    public $id;           // ID auto-incremental (BD)
    public $posicion;     // Posición en la lista
    public $codigo;       // Código único del producto (INT)
    public $nombre;       // Nombre descriptivo
    public $precio;       // Precio decimal
    public $fecha_creacion;
    public $fecha_modificacion;
}
```

**¿Por qué código INT y no VARCHAR?**
- ✅ Mantiene compatibilidad con código C++ original
- ✅ Más eficiente en índices y búsquedas
- ✅ Menor espacio de almacenamiento
- ⚠️ Limitación: No soporta códigos alfanuméricos

**Validación**:
```php
public function validar() {
    $errores = [];
    
    // Código debe ser numérico
    if (!is_numeric($this->codigo)) {
        $errores[] = "El código debe ser un número válido";
    }
    
    // Nombre no puede estar vacío
    if (empty(trim($this->nombre))) {
        $errores[] = "El nombre es obligatorio";
    }
    
    // Precio debe ser >= 0
    if (!is_numeric($this->precio) || $this->precio < 0) {
        $errores[] = "El precio debe ser un número válido mayor o igual a 0";
    }
    
    return [
        'valido' => empty($errores),
        'errores' => $errores
    ];
}
```

**Métodos de conversión**:
- `toArray()`: Convierte objeto a array (para JSON)
- `fromArray()`: Crea objeto desde array (desde BD)

---

### 5. Utilidades (utils/)

#### Busqueda.php

**Propósito**: Implementación de algoritmos de búsqueda desde cero

##### Búsqueda Lineal
**Complejidad**: O(n)

**Cuándo usar**:
- ✅ Listas pequeñas (< 100 elementos)
- ✅ Datos no ordenados
- ✅ Búsqueda por nombre (no ordenable eficientemente)

**Implementación**:
```php
public static function busquedaLinealPorCodigo($productos, $codigo) {
    for ($i = 0; $i < count($productos); $i++) {
        if ($productos[$i]->codigo == $codigo) {
            return $productos[$i]; // Encontrado
        }
    }
    return null; // No encontrado
}
```

##### Búsqueda Binaria
**Complejidad**: O(log n)

**Requisito**: Array ordenado

**Cuándo usar**:
- ✅ Listas grandes (> 100 elementos)
- ✅ Datos ordenados por código
- ✅ Búsquedas frecuentes

**Implementación**:
```php
public static function busquedaBinariaPorCodigo($productos, $codigo) {
    $low = 0;
    $high = count($productos) - 1;
    
    while ($low <= $high) {
        $mid = (int)(($low + $high) / 2);
        
        if ($productos[$mid]->codigo == $codigo) {
            return $productos[$mid]; // Encontrado
        } else if ($productos[$mid]->codigo < $codigo) {
            $low = $mid + 1; // Buscar en mitad superior
        } else {
            $high = $mid - 1; // Buscar en mitad inferior
        }
    }
    return null; // No encontrado
}
```

**Ventaja de Búsqueda Binaria**:
- Para 1,000 productos: Lineal = 1,000 comparaciones, Binaria = ~10 comparaciones
- Para 1,000,000 productos: Lineal = 1,000,000, Binaria = ~20

#### Ordenamiento.php

**Propósito**: Implementación de algoritmos de ordenamiento desde cero

##### Bubble Sort
**Complejidad**: O(n²)

**Cuándo usar**:
- ✅ Listas pequeñas (< 50 elementos)
- ✅ Datos casi ordenados
- ✅ Simplicidad sobre eficiencia

**Algoritmo**:
```php
public static function bubbleSortPorPrecio(&$productos) {
    $n = count($productos);
    
    for ($i = 0; $i < $n - 1; $i++) {
        $huboIntercambio = false;
        
        for ($j = 0; $j < $n - 1 - $i; $j++) {
            if ($productos[$j]->precio > $productos[$j + 1]->precio) {
                // Intercambiar
                $temp = $productos[$j];
                $productos[$j] = $productos[$j + 1];
                $productos[$j + 1] = $temp;
                $huboIntercambio = true;
            }
        }
        
        // Optimización: si no hubo intercambios, ya está ordenado
        if (!$huboIntercambio) break;
    }
}
```

##### Quick Sort
**Complejidad**: O(n log n) promedio, O(n²) peor caso

**Cuándo usar**:
- ✅ Listas grandes (> 50 elementos)
- ✅ Rendimiento crítico
- ✅ Datos aleatorios

**Algoritmo (Divide y Conquista)**:
```php
public static function quickSortPorPrecio(&$productos, $low = 0, $high = null) {
    if ($high === null) {
        $high = count($productos) - 1;
    }
    
    if ($low < $high) {
        // Particionar
        $pi = self::particionPrecio($productos, $low, $high);
        
        // Ordenar recursivamente
        self::quickSortPorPrecio($productos, $low, $pi - 1);
        self::quickSortPorPrecio($productos, $pi + 1, $high);
    }
}
```

---

### 6. Frontend (public/)

#### Arquitectura del Frontend

**Separación de Responsabilidades**:
- `index.html`: Página de login
- `dashboard.html`: Interfaz principal
- `css/styles.css`: Estilos centralizados
- `js/main.js`: Funciones comunes (autenticación, notificaciones)
- `js/productos.js`: Lógica específica de productos

#### Comunicación con Backend

**Patrón**: Fetch API (Promesas)

**Ejemplo de petición**:
```javascript
async function cargarProductos() {
    try {
        const response = await fetch('../api/productos.php', {
            method: 'GET',
            credentials: 'include' // Incluir cookies de sesión
        });
        
        const data = await response.json();
        
        if (data.exito) {
            mostrarProductos(data.productos);
        } else {
            mostrarNotificacion(data.mensaje, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarNotificacion('Error al cargar productos', 'error');
    }
}
```

**¿Por qué Fetch API?**
- ✅ Nativo de JavaScript (no requiere jQuery)
- ✅ Basado en Promesas (async/await)
- ✅ Mejor manejo de errores
- ✅ Más moderno y estándar

---

## Flujo de Datos

### Flujo de Inserción de Producto

```
1. Usuario llena formulario
   ↓
2. JavaScript valida datos
   ↓
3. Fetch POST a /api/productos.php
   {codigo: 100, nombre: "Laptop", precio: 15000, tipo: "inicio"}
   ↓
4. API verifica sesión (AuthController)
   ↓
5. API decodifica JSON
   ↓
6. Crea objeto Producto
   ↓
7. ProductoController->insertarInicio()
   ↓
8. Producto->validar()
   ↓
9. Verifica código único
   ↓
10. UPDATE productos SET posicion = posicion + 1
    ↓
11. INSERT INTO productos (...) VALUES (..., 1)
    ↓
12. Registra log de operación
    ↓
13. Retorna JSON: {exito: true, mensaje: "..."}
    ↓
14. JavaScript muestra notificación
    ↓
15. Recarga tabla de productos
```

### Flujo de Búsqueda

```
1. Usuario ingresa código/nombre
   ↓
2. Selecciona algoritmo (lineal/binaria)
   ↓
3. Fetch POST a /api/buscar.php
   ↓
4. API obtiene todos los productos
   ↓
5. Busqueda::busquedaBinariaPorCodigo() o busquedaLinealPorNombre()
   ↓
6. Retorna producto encontrado o null
   ↓
7. JavaScript muestra resultado
```

---

## Decisiones de Diseño

### 1. ¿Por qué PHP y no Node.js?

**Razones**:
- ✅ XAMPP preinstalado (fácil setup)
- ✅ Sintaxis similar a C++ (familiaridad)
- ✅ Amplio uso en hosting compartido
- ✅ Madurez y estabilidad

### 2. ¿Por qué MySQL y no MongoDB?

**Razones**:
- ✅ Datos estructurados (productos tienen campos fijos)
- ✅ Relaciones claras (usuarios ↔ logs ↔ productos)
- ✅ ACID (transacciones confiables)
- ✅ Integridad referencial

### 3. ¿Por qué implementar algoritmos desde cero?

**Objetivo Educativo**:
- 📚 Demostrar conocimiento de complejidad algorítmica
- 🎯 Entender el funcionamiento interno
- 💡 Comparar eficiencia (O(n) vs O(log n))
- 🔬 Experimentar con diferentes enfoques

**En producción real**:
- Se usaría `array_search()`, `usort()`, etc.
- Pero el conocimiento de algoritmos es fundamental para:
  - Optimizar consultas SQL
  - Elegir estructuras de datos adecuadas
  - Resolver problemas complejos

### 4. ¿Por qué campo `posicion` en lugar de solo `id`?

**Problema con solo ID**:
```sql
-- Si insertamos productos en este orden:
INSERT ... VALUES (101, 'A', 100);  -- id=1
INSERT ... VALUES (102, 'B', 200);  -- id=2
INSERT ... VALUES (103, 'C', 300);  -- id=3

-- Y luego queremos "insertar al inicio" el producto 104:
-- No podemos cambiar el id=1 porque es auto-incremental
-- Resultado: 104 aparecería al final (id=4)
```

**Solución con posicion**:
```sql
-- Estado inicial:
id | posicion | codigo | nombre
1  | 1        | 101    | A
2  | 2        | 102    | B
3  | 3        | 103    | C

-- Insertar 104 al inicio:
UPDATE productos SET posicion = posicion + 1;  -- Incrementar todas
INSERT ... VALUES (104, 'D', 400, 1);          -- Insertar en posición 1

-- Resultado:
id | posicion | codigo | nombre
1  | 2        | 101    | A
2  | 3        | 102    | B
3  | 4        | 103    | C
4  | 1        | 104    | D  ← Aparece primero al ordenar por posicion

-- Consulta:
SELECT * FROM productos ORDER BY posicion ASC;
```

**Ventajas**:
- ✅ Simula lista enlazada con base de datos relacional
- ✅ Orden independiente del ID
- ✅ Permite reordenamiento sin cambiar claves primarias
- ✅ Compatible con operaciones de inserción específicas

### 5. ¿Por qué REST API y no páginas PHP tradicionales?

**REST API**:
```
Frontend (JS) ←→ API (JSON) ←→ Backend (PHP)
```

**PHP Tradicional**:
```
Browser → PHP genera HTML → Browser
```

**Ventajas de REST**:
- ✅ Separación frontend/backend
- ✅ Reutilizable (móvil, web, desktop)
- ✅ Mejor experiencia de usuario (sin recargas)
- ✅ Escalable (frontend y backend independientes)

### 6. ¿Por qué sesiones y no JWT?

**Sesiones PHP**:
- ✅ Más simple de implementar
- ✅ Servidor controla expiración
- ✅ Fácil invalidar (logout)
- ✅ Adecuado para aplicaciones pequeñas

**JWT sería mejor para**:
- Aplicaciones distribuidas
- Microservicios
- APIs públicas
- Aplicaciones móviles

---

## Seguridad

### Medidas Implementadas

#### 1. SQL Injection Prevention
```php
// ❌ INSEGURO
$query = "SELECT * FROM productos WHERE codigo = " . $_GET['codigo'];

// ✅ SEGURO (Prepared Statements)
$query = "SELECT * FROM productos WHERE codigo = :codigo";
$stmt = $conn->prepare($query);
$stmt->bindParam(':codigo', $codigo);
```

#### 2. Password Hashing
```php
// ❌ INSEGURO
INSERT INTO usuarios (password) VALUES ('123456');

// ✅ SEGURO
$hash = password_hash($password, PASSWORD_BCRYPT);
INSERT INTO usuarios (password) VALUES (:hash);
```

#### 3. Autenticación de Sesión
```php
// Verificar en cada petición API
if (!$authController->verificarSesion()) {
    http_response_code(401);
    echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
    exit;
}
```

#### 4. Validación de Datos
```php
// Backend valida SIEMPRE, aunque frontend también valide
$validacion = $producto->validar();
if (!$validacion['valido']) {
    return ['exito' => false, 'mensaje' => implode(', ', $validacion['errores'])];
}
```

---

## Escalabilidad

### Mejoras Futuras

#### 1. Caché
```php
// Implementar Redis/Memcached para productos frecuentes
$cache->set("producto_$codigo", $producto, 3600); // 1 hora
```

#### 2. Paginación
```sql
-- Limitar resultados para listas grandes
SELECT * FROM productos 
ORDER BY posicion 
LIMIT :offset, :limit;
```

#### 3. Índices de Base de Datos
```sql
-- Ya implementados:
CREATE INDEX idx_posicion ON productos(posicion);
CREATE INDEX idx_codigo ON productos(codigo);
CREATE INDEX idx_nombre ON productos(nombre);
```

#### 4. Compresión de Respuestas
```php
// Habilitar gzip en Apache
ob_start("ob_gzhandler");
```

---

## Conclusión

### Fortalezas del Diseño

✅ **Arquitectura Clara**: MVC bien definido
✅ **Código Educativo**: Algoritmos implementados desde cero
✅ **Seguridad**: Prepared statements, password hashing, validación
✅ **Mantenibilidad**: Código documentado y organizado
✅ **Escalabilidad**: Fácil agregar nuevas funcionalidades

### Áreas de Mejora

⚠️ **Testing**: Agregar pruebas unitarias y de integración
⚠️ **Logging**: Sistema de logs más robusto (archivos, niveles)
⚠️ **Configuración**: Variables de entorno para credenciales
⚠️ **Validación Frontend**: Mejorar feedback visual
⚠️ **Documentación API**: Swagger/OpenAPI

---

**Documento creado para**: Sistema de Inventario  
**Fecha**: Febrero 2026  
**Propósito**: Documentación técnica de arquitectura
