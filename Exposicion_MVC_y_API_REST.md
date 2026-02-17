# 📚 Exposición Detallada: Modelo MVC y API REST

## Índice
1. [El Modelo MVC](#el-modelo-mvc)
2. [La API REST](#la-api-rest)
3. [Integración MVC + REST API](#integración-mvc--rest-api)

---

## El Modelo MVC

### ¿Qué es MVC?

**MVC** (Model-View-Controller) es un **patrón de arquitectura de software** que separa una aplicación en tres componentes interconectados pero independientes:

```
┌─────────────────────────────────────────────────────┐
│                   APLICACIÓN                         │
├─────────────────────────────────────────────────────┤
│                                                      │
│  ┌──────────┐      ┌──────────┐      ┌──────────┐  │
│  │   VIEW   │ ←──→ │CONTROLLER│ ←──→ │  MODEL   │  │
│  │ (Vista)  │      │(Control) │      │ (Modelo) │  │
│  └──────────┘      └──────────┘      └──────────┘  │
│       ↑                  ↑                  ↑        │
│   Presenta           Coordina          Gestiona     │
│     datos             lógica            datos       │
└─────────────────────────────────────────────────────┘
```

### Analogía del Mundo Real: Un Restaurante

Para entender MVC, imagina un restaurante:

#### 🍽️ **VIEW (Vista)** = El Mesero
- **Responsabilidad**: Interactuar con el cliente (usuario)
- **Función**: 
  - Mostrar el menú (interfaz)
  - Tomar el pedido (capturar entrada)
  - Servir la comida (mostrar resultados)
- **NO hace**: No cocina, no decide precios, no gestiona inventario

**En nuestro proyecto**:
```html
<!-- public/dashboard.html -->
<form id="insertForm">
    <input type="number" id="insertCodigo" placeholder="Código">
    <input type="text" id="insertNombre" placeholder="Nombre">
    <input type="number" id="insertPrecio" placeholder="Precio">
    <button type="submit">Insertar</button>
</form>
```

#### 🎯 **CONTROLLER (Controlador)** = El Gerente
- **Responsabilidad**: Coordinar entre mesero y cocina
- **Función**:
  - Recibir pedidos del mesero
  - Validar que el pedido sea posible
  - Comunicarse con la cocina
  - Decidir qué hacer según la situación
- **NO hace**: No interactúa directamente con clientes, no cocina

**En nuestro proyecto**:
```php
// controllers/ProductoController.php
class ProductoController {
    public function insertarInicio($producto) {
        // 1. Validar datos (¿el pedido es válido?)
        $validacion = $producto->validar();
        if (!$validacion['valido']) {
            return ['exito' => false, 'mensaje' => 'Datos inválidos'];
        }
        
        // 2. Verificar reglas de negocio (¿hay stock?)
        if ($this->codigoExiste($producto->codigo)) {
            return ['exito' => false, 'mensaje' => 'Código duplicado'];
        }
        
        // 3. Coordinar con el modelo (enviar a cocina)
        // Actualizar posiciones
        $this->conn->exec("UPDATE productos SET posicion = posicion + 1");
        
        // Insertar producto
        $query = "INSERT INTO productos (codigo, nombre, precio, posicion) 
                  VALUES (:codigo, :nombre, :precio, 1)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([...]);
        
        // 4. Registrar la acción (log)
        $this->registrarLog('INSERT_INICIO', "Producto insertado");
        
        // 5. Retornar resultado
        return ['exito' => true, 'mensaje' => 'Producto insertado'];
    }
}
```

#### 📦 **MODEL (Modelo)** = La Cocina + Almacén
- **Responsabilidad**: Gestionar datos y lógica de negocio
- **Función**:
  - Representar los datos (ingredientes)
  - Validar datos (¿el ingrediente es fresco?)
  - Interactuar con la base de datos (almacén)
  - Aplicar reglas de negocio
- **NO hace**: No decide qué mostrar al usuario, no maneja peticiones HTTP

**En nuestro proyecto**:
```php
// models/Producto.php
class Producto {
    public $id;
    public $codigo;
    public $nombre;
    public $precio;
    public $posicion;
    
    // Representación de datos
    public function __construct($codigo, $nombre, $precio, $id = null) {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->id = $id;
    }
    
    // Validación de reglas de negocio
    public function validar() {
        $errores = [];
        
        // Regla: El código debe ser numérico
        if (!is_numeric($this->codigo)) {
            $errores[] = "El código debe ser un número válido";
        }
        
        // Regla: El nombre no puede estar vacío
        if (empty(trim($this->nombre))) {
            $errores[] = "El nombre es obligatorio";
        }
        
        // Regla: El precio debe ser >= 0
        if (!is_numeric($this->precio) || $this->precio < 0) {
            $errores[] = "El precio debe ser mayor o igual a 0";
        }
        
        return [
            'valido' => empty($errores),
            'errores' => $errores
        ];
    }
    
    // Conversión de datos
    public function toArray() {
        return [
            'id' => $this->id,
            'codigo' => $this->codigo,
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'posicion' => $this->posicion
        ];
    }
}
```

### Flujo Completo en MVC

Veamos qué pasa cuando un usuario inserta un producto:

```
1. USUARIO escribe en el formulario:
   Código: 100
   Nombre: "Laptop Dell"
   Precio: 15000
   
2. VIEW (dashboard.html + productos.js):
   ┌─────────────────────────────────────┐
   │ Usuario hace clic en "Insertar"     │
   │ JavaScript captura el evento        │
   │ Valida que los campos no estén      │
   │ vacíos (validación básica)          │
   └─────────────────────────────────────┘
                    ↓
   Envía petición HTTP POST a la API
                    ↓
3. CONTROLLER (ProductoController.php):
   ┌─────────────────────────────────────┐
   │ Recibe datos JSON                   │
   │ {codigo: 100, nombre: "Laptop",     │
   │  precio: 15000, tipo: "inicio"}     │
   │                                     │
   │ Crea objeto Producto                │
   │ $producto = new Producto(100, ...)  │
   └─────────────────────────────────────┘
                    ↓
4. MODEL (Producto.php):
   ┌─────────────────────────────────────┐
   │ Valida los datos                    │
   │ ¿Es 100 un número? ✓                │
   │ ¿"Laptop" no está vacío? ✓          │
   │ ¿15000 >= 0? ✓                      │
   │                                     │
   │ Retorna: {valido: true}             │
   └─────────────────────────────────────┘
                    ↓
5. CONTROLLER continúa:
   ┌─────────────────────────────────────┐
   │ Verifica reglas de negocio          │
   │ ¿El código 100 ya existe? NO ✓      │
   │                                     │
   │ Ejecuta lógica de inserción:        │
   │ - Incrementa posiciones             │
   │ - Inserta en BD                     │
   │ - Registra log                      │
   │                                     │
   │ Retorna: {exito: true, mensaje:...} │
   └─────────────────────────────────────┘
                    ↓
6. VIEW recibe respuesta:
   ┌─────────────────────────────────────┐
   │ JavaScript procesa JSON             │
   │ Muestra notificación: "✓ Producto   │
   │ insertado correctamente"            │
   │ Recarga tabla de productos          │
   └─────────────────────────────────────┘
```

### ¿Por Qué Usar MVC?

#### 1. **Separación de Responsabilidades** (Separation of Concerns)

**Sin MVC** (todo mezclado):
```php
<!-- producto_insertar.php - TODO EN UN ARCHIVO -->
<?php
// Lógica de negocio mezclada con HTML
if ($_POST) {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    
    // Validación mezclada
    if (empty($codigo)) {
        echo "<p style='color:red'>Error: código vacío</p>";
    }
    
    // SQL mezclado
    $query = "INSERT INTO productos VALUES ($codigo, '$nombre', $precio)";
    mysqli_query($conn, $query);
    
    // HTML mezclado
    echo "<p style='color:green'>Producto insertado</p>";
}
?>

<!-- Formulario HTML mezclado -->
<form method="POST">
    <input name="codigo">
    <input name="nombre">
    <input name="precio">
    <button>Insertar</button>
</form>
```

**Problemas**:
- ❌ Difícil de mantener (todo está junto)
- ❌ Difícil de testear (no puedes probar lógica sin HTML)
- ❌ Difícil de reutilizar (¿cómo usar esto en una app móvil?)
- ❌ Difícil de trabajar en equipo (todos tocan el mismo archivo)

**Con MVC** (separado):
```
View (HTML/JS)     → Solo presentación
Controller (PHP)   → Solo lógica de coordinación
Model (PHP)        → Solo datos y validación
```

**Beneficios**:
- ✅ Fácil de mantener (cada archivo tiene un propósito)
- ✅ Fácil de testear (puedes probar cada componente por separado)
- ✅ Fácil de reutilizar (la API sirve para web, móvil, desktop)
- ✅ Fácil de trabajar en equipo (diseñador → View, backend → Controller/Model)

#### 2. **Mantenibilidad**

**Escenario**: Cambiar el diseño de la interfaz

**Sin MVC**:
```
❌ Tienes que tocar archivos con lógica de negocio
❌ Riesgo de romper funcionalidad
❌ Difícil encontrar qué cambiar
```

**Con MVC**:
```
✅ Solo tocas archivos de View (HTML/CSS/JS)
✅ La lógica de negocio no se afecta
✅ Cambios aislados y seguros
```

#### 3. **Escalabilidad**

**Escenario**: Agregar una app móvil

**Sin MVC**:
```
❌ Tienes que reescribir toda la lógica
❌ Duplicación de código
❌ Difícil mantener consistencia
```

**Con MVC**:
```
✅ Reutilizas Controller y Model
✅ Solo creas nueva View (app móvil)
✅ Misma lógica, diferentes interfaces
```

#### 4. **Testabilidad**

**Sin MVC**:
```php
// ¿Cómo pruebas esto sin ejecutar todo el HTML?
<?php
if ($_POST) {
    // lógica
    echo "<html>...</html>";
}
?>
```

**Con MVC**:
```php
// Puedes probar el Controller independientemente
$controller = new ProductoController();
$producto = new Producto(100, "Laptop", 15000);
$resultado = $controller->insertarInicio($producto);

assert($resultado['exito'] === true);
```

---

## La API REST

### ¿Qué es una API?

**API** = **Application Programming Interface** (Interfaz de Programación de Aplicaciones)

**Definición simple**: Es un "contrato" que define cómo dos programas pueden comunicarse entre sí.

**Analogía**: Un menú de restaurante
- El menú (API) te dice qué puedes pedir (endpoints disponibles)
- Tú haces un pedido (request)
- La cocina te prepara la comida (procesa)
- El mesero te trae el plato (response)

### ¿Qué es REST?

**REST** = **Representational State Transfer**

**Definición**: Es un estilo de arquitectura para diseñar APIs que usa HTTP de manera estándar.

### Principios de REST

#### 1. **Cliente-Servidor**

Separación clara entre:
- **Cliente**: Interfaz de usuario (frontend)
- **Servidor**: Lógica de negocio y datos (backend)

```
┌─────────────┐                    ┌─────────────┐
│   CLIENTE   │ ←── HTTP/JSON ───→ │  SERVIDOR   │
│  (Browser)  │                    │    (PHP)    │
│             │                    │             │
│ - HTML      │                    │ - Lógica    │
│ - CSS       │                    │ - Base de   │
│ - JavaScript│                    │   Datos     │
└─────────────┘                    └─────────────┘
```

**Ventaja**: Pueden evolucionar independientemente

#### 2. **Stateless (Sin Estado)**

Cada petición es **independiente** y contiene toda la información necesaria.

**Ejemplo NO stateless** (con estado):
```
1. Cliente: "Hola, soy Juan"
   Servidor: "Ok, te recuerdo"
   
2. Cliente: "Dame mis productos"
   Servidor: "Ok Juan, aquí están" (recuerda quién eres)
   
3. Cliente: "Inserta producto X"
   Servidor: "Ok Juan, insertado" (aún recuerda)
```

**Problema**: Si el servidor se reinicia, olvida quién eres.

**Ejemplo stateless** (sin estado):
```
1. Cliente: "Hola, soy Juan (token: abc123), dame mis productos"
   Servidor: "Ok, aquí están" (no guarda nada)
   
2. Cliente: "Soy Juan (token: abc123), inserta producto X"
   Servidor: "Ok, insertado" (verifica token cada vez)
   
3. Cliente: "Soy Juan (token: abc123), dame productos"
   Servidor: "Ok, aquí están" (siempre verifica)
```

**Ventaja**: Escalable (puedes tener múltiples servidores)

**En nuestro proyecto**:
```javascript
// Cada petición incluye credenciales
fetch('/api/productos.php', {
    method: 'POST',
    credentials: 'include', // Incluye cookie de sesión
    body: JSON.stringify({...})
});
```

#### 3. **Recursos**

Todo en REST es un **recurso** identificado por una URL.

**Ejemplos**:
```
/api/productos          → Colección de productos
/api/productos/123      → Producto específico (código 123)
/api/usuarios           → Colección de usuarios
/api/usuarios/5         → Usuario específico (ID 5)
```

#### 4. **Métodos HTTP**

REST usa los métodos HTTP estándar:

| Método   | Acción      | Ejemplo                          | SQL Equivalente |
|----------|-------------|----------------------------------|-----------------|
| `GET`    | Leer        | `GET /api/productos`             | `SELECT`        |
| `POST`   | Crear       | `POST /api/productos`            | `INSERT`        |
| `PUT`    | Actualizar  | `PUT /api/productos/123`         | `UPDATE`        |
| `DELETE` | Eliminar    | `DELETE /api/productos/123`      | `DELETE`        |

**En nuestro proyecto**:
```php
// api/productos.php
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        // Obtener todos los productos
        $productos = $productoController->obtenerTodos();
        echo json_encode(['exito' => true, 'productos' => $productos]);
        break;
        
    case 'POST':
        // Insertar nuevo producto
        $data = json_decode(file_get_contents("php://input"), true);
        $producto = new Producto($data['codigo'], $data['nombre'], $data['precio']);
        $resultado = $productoController->insertarInicio($producto);
        echo json_encode($resultado);
        break;
        
    case 'DELETE':
        // Eliminar producto
        $data = json_decode(file_get_contents("php://input"), true);
        $resultado = $productoController->eliminarPorCodigo($data['codigo']);
        echo json_encode($resultado);
        break;
}
```

#### 5. **Representación JSON**

Los datos se intercambian en formato **JSON** (JavaScript Object Notation).

**¿Por qué JSON?**
- ✅ Ligero (menos bytes que XML)
- ✅ Fácil de leer para humanos
- ✅ Nativo en JavaScript
- ✅ Soportado en todos los lenguajes

**Ejemplo**:
```json
{
    "exito": true,
    "total": 3,
    "productos": [
        {
            "id": 1,
            "codigo": 101,
            "nombre": "Laptop Dell",
            "precio": 15000.00,
            "posicion": 1
        },
        {
            "id": 2,
            "codigo": 102,
            "nombre": "Mouse Logitech",
            "precio": 299.50,
            "posicion": 2
        }
    ]
}
```

### ¿Por Qué Usar API REST en Este Proyecto?

#### Razón 1: **Separación Frontend-Backend**

**Arquitectura Tradicional** (PHP genera HTML):
```php
<!-- productos.php -->
<?php
$productos = obtenerProductos();
?>
<html>
    <table>
        <?php foreach ($productos as $p): ?>
            <tr>
                <td><?= $p['codigo'] ?></td>
                <td><?= $p['nombre'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</html>
```

**Problemas**:
- ❌ Frontend y backend acoplados
- ❌ Cada cambio requiere recargar página completa
- ❌ No puedes usar el backend desde una app móvil
- ❌ Difícil crear interfaces dinámicas

**Arquitectura REST API**:
```javascript
// Frontend (JavaScript)
async function cargarProductos() {
    const response = await fetch('/api/productos.php');
    const data = await response.json();
    
    // Actualizar solo la tabla, sin recargar página
    mostrarEnTabla(data.productos);
}
```

```php
// Backend (PHP)
<?php
$productos = $productoController->obtenerTodos();
echo json_encode([
    'exito' => true,
    'productos' => $productos
]);
?>
```

**Ventajas**:
- ✅ Frontend y backend independientes
- ✅ Actualizaciones sin recargar página (mejor UX)
- ✅ Mismo backend para web, móvil, desktop
- ✅ Interfaces dinámicas y reactivas

#### Razón 2: **Reutilización**

Con una API REST, puedes crear múltiples clientes:

```
                    ┌─────────────────┐
                    │   API REST      │
                    │  (Backend PHP)  │
                    └────────┬────────┘
                             │
        ┌────────────────────┼────────────────────┐
        │                    │                    │
   ┌────▼────┐         ┌────▼────┐         ┌────▼────┐
   │   Web   │         │  Móvil  │         │ Desktop │
   │ Browser │         │   App   │         │   App   │
   └─────────┘         └─────────┘         └─────────┘
```

**Ejemplo real**:
- **Web**: `dashboard.html` usa la API
- **Móvil**: App Android/iOS usa la misma API
- **Desktop**: Aplicación Electron usa la misma API
- **Otro sistema**: Otro sistema puede consumir la API

#### Razón 3: **Mejor Experiencia de Usuario**

**Sin API** (recarga completa):
```
Usuario hace clic → Recarga toda la página → Espera → Ve resultado
                    (pierde scroll, estado, etc.)
```

**Con API** (actualización parcial):
```
Usuario hace clic → Petición AJAX → Actualiza solo tabla → Ve resultado
                    (mantiene scroll, estado, etc.)
```

**Ejemplo en nuestro proyecto**:
```javascript
// Insertar producto sin recargar página
async function insertarProducto(e) {
    e.preventDefault(); // Evitar recarga
    
    const datos = {
        codigo: parseInt(document.getElementById('insertCodigo').value),
        nombre: document.getElementById('insertNombre').value,
        precio: parseFloat(document.getElementById('insertPrecio').value),
        tipo: document.getElementById('insertTipo').value
    };
    
    // Petición a API
    const response = await fetch('../api/productos.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        credentials: 'include',
        body: JSON.stringify(datos)
    });
    
    const resultado = await response.json();
    
    if (resultado.exito) {
        mostrarNotificacion('✓ Producto insertado', 'success');
        cargarProductos(); // Actualizar solo la tabla
        document.getElementById('insertForm').reset();
    } else {
        mostrarNotificacion('✗ ' + resultado.mensaje, 'error');
    }
}
```

#### Razón 4: **Escalabilidad**

**Escenario**: Tu aplicación crece y necesitas:
- Balanceo de carga
- Múltiples servidores
- Caché
- CDN

**Con API REST**:
```
                    ┌─────────────┐
                    │   CDN       │
                    │  (Archivos  │
                    │  estáticos) │
                    └─────────────┘
                           │
┌──────────┐        ┌─────▼──────┐        ┌─────────────┐
│ Cliente  │───────→│ Balanceador│───────→│  Servidor 1 │
│ (Browser)│        │  de Carga  │   │    │   (API)     │
└──────────┘        └────────────┘   │    └─────────────┘
                                     │
                                     │    ┌─────────────┐
                                     └───→│  Servidor 2 │
                                          │   (API)     │
                                          └─────────────┘
```

#### Razón 5: **Estándar de la Industria**

REST es el estándar más usado:
- Twitter API
- Facebook API
- Google APIs
- GitHub API
- Stripe API

**Ventajas de seguir estándares**:
- ✅ Documentación abundante
- ✅ Herramientas disponibles (Postman, Swagger)
- ✅ Desarrolladores familiarizados
- ✅ Mejores prácticas establecidas

### Estructura de una Petición/Respuesta REST

#### Petición (Request)

```http
POST /api/productos.php HTTP/1.1
Host: localhost
Content-Type: application/json
Cookie: PHPSESSID=abc123...

{
    "codigo": 100,
    "nombre": "Laptop Dell",
    "precio": 15000,
    "tipo": "inicio"
}
```

**Componentes**:
1. **Método**: `POST` (crear)
2. **Endpoint**: `/api/productos.php`
3. **Headers**: Metadatos (tipo de contenido, cookies)
4. **Body**: Datos en JSON

#### Respuesta (Response)

```http
HTTP/1.1 201 Created
Content-Type: application/json

{
    "exito": true,
    "mensaje": "Producto insertado al inicio correctamente"
}
```

**Componentes**:
1. **Status Code**: `201` (creado exitosamente)
2. **Headers**: Tipo de contenido
3. **Body**: Resultado en JSON

#### Códigos de Estado HTTP

| Código | Significado              | Cuándo usarlo                    |
|--------|--------------------------|----------------------------------|
| 200    | OK                       | Operación exitosa (GET, PUT)     |
| 201    | Created                  | Recurso creado (POST)            |
| 400    | Bad Request              | Datos inválidos                  |
| 401    | Unauthorized             | No autenticado                   |
| 404    | Not Found                | Recurso no existe                |
| 500    | Internal Server Error    | Error del servidor               |

**En nuestro proyecto**:
```php
// api/productos.php

// Verificar autenticación
if (!$authController->verificarSesion()) {
    http_response_code(401); // Unauthorized
    echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
    exit;
}

// Inserción exitosa
http_response_code(201); // Created
echo json_encode(['exito' => true, 'mensaje' => 'Producto insertado']);

// Error de validación
http_response_code(400); // Bad Request
echo json_encode(['exito' => false, 'mensaje' => 'Datos inválidos']);
```

---

## Integración MVC + REST API

### Cómo Trabajan Juntos

```
┌─────────────────────────────────────────────────────────────┐
│                        CLIENTE                               │
│  ┌────────────────────────────────────────────────────┐     │
│  │  VIEW (HTML/CSS/JavaScript)                        │     │
│  │  - dashboard.html                                  │     │
│  │  - productos.js                                    │     │
│  └────────────────────┬───────────────────────────────┘     │
└───────────────────────┼─────────────────────────────────────┘
                        │
                        │ HTTP Request (JSON)
                        │
┌───────────────────────▼─────────────────────────────────────┐
│                     SERVIDOR                                 │
│  ┌────────────────────────────────────────────────────┐     │
│  │  API REST (api/productos.php)                      │     │
│  │  - Recibe petición HTTP                            │     │
│  │  - Verifica autenticación                          │     │
│  │  - Decodifica JSON                                 │     │
│  └────────────────────┬───────────────────────────────┘     │
│                       │                                      │
│  ┌────────────────────▼───────────────────────────────┐     │
│  │  CONTROLLER (ProductoController.php)               │     │
│  │  - Coordina lógica de negocio                      │     │
│  │  - Llama al modelo                                 │     │
│  │  - Ejecuta operaciones en BD                       │     │
│  └────────────────────┬───────────────────────────────┘     │
│                       │                                      │
│  ┌────────────────────▼───────────────────────────────┐     │
│  │  MODEL (Producto.php)                              │     │
│  │  - Valida datos                                    │     │
│  │  - Representa estructura                           │     │
│  └────────────────────┬───────────────────────────────┘     │
│                       │                                      │
│  ┌────────────────────▼───────────────────────────────┐     │
│  │  DATABASE (MySQL)                                  │     │
│  │  - Almacena datos                                  │     │
│  └────────────────────────────────────────────────────┘     │
└─────────────────────────────────────────────────────────────┘
```

### Ejemplo Completo: Insertar Producto

#### 1. Frontend (View)

```javascript
// public/js/productos.js

async function insertarProducto(e) {
    e.preventDefault();
    
    // Capturar datos del formulario
    const datos = {
        codigo: parseInt(document.getElementById('insertCodigo').value),
        nombre: document.getElementById('insertNombre').value,
        precio: parseFloat(document.getElementById('insertPrecio').value),
        tipo: 'inicio'
    };
    
    try {
        // Petición a la API REST
        const response = await fetch('../api/productos.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include',
            body: JSON.stringify(datos)
        });
        
        const resultado = await response.json();
        
        if (resultado.exito) {
            mostrarNotificacion(resultado.mensaje, 'success');
            cargarProductos(); // Recargar tabla
        } else {
            mostrarNotificacion(resultado.mensaje, 'error');
        }
        
    } catch (error) {
        console.error('Error:', error);
        mostrarNotificacion('Error de conexión', 'error');
    }
}
```

#### 2. API REST

```php
// api/productos.php

<?php
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/ProductoController.php';
require_once __DIR__ . '/../models/Producto.php';

// Verificar autenticación
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$authController = new AuthController();
if (!$authController->verificarSesion()) {
    http_response_code(401);
    echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
    exit;
}

// Manejar petición
$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'POST') {
    // Decodificar JSON
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Crear objeto Producto (MODEL)
    $producto = new Producto(
        $data['codigo'],
        $data['nombre'],
        $data['precio']
    );
    
    // Llamar al controlador
    $productoController = new ProductoController();
    
    switch ($data['tipo']) {
        case 'inicio':
            $resultado = $productoController->insertarInicio($producto);
            break;
        case 'final':
            $resultado = $productoController->insertarFinal($producto);
            break;
        case 'posicion':
            $resultado = $productoController->insertarPosicion(
                $producto,
                $data['posicion']
            );
            break;
    }
    
    // Retornar respuesta JSON
    http_response_code($resultado['exito'] ? 201 : 400);
    echo json_encode($resultado);
}
?>
```

#### 3. Controller

```php
// controllers/ProductoController.php

class ProductoController {
    private $conn;
    
    public function insertarInicio($producto) {
        // Validar usando el MODEL
        $validacion = $producto->validar();
        if (!$validacion['valido']) {
            return [
                'exito' => false,
                'mensaje' => implode(', ', $validacion['errores'])
            ];
        }
        
        // Verificar reglas de negocio
        if ($this->codigoExiste($producto->codigo)) {
            return [
                'exito' => false,
                'mensaje' => 'El código de producto ya existe'
            ];
        }
        
        try {
            // Lógica de inserción
            $this->conn->exec("UPDATE productos SET posicion = posicion + 1");
            
            $query = "INSERT INTO productos (codigo, nombre, precio, posicion) 
                      VALUES (:codigo, :nombre, :precio, 1)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':codigo', $producto->codigo);
            $stmt->bindParam(':nombre', $producto->nombre);
            $stmt->bindParam(':precio', $producto->precio);
            
            if ($stmt->execute()) {
                $this->registrarLog('INSERT_INICIO', "Producto: {$producto->nombre}");
                return [
                    'exito' => true,
                    'mensaje' => 'Producto insertado al inicio correctamente'
                ];
            }
            
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [
                'exito' => false,
                'mensaje' => 'Error al insertar producto'
            ];
        }
    }
}
```

#### 4. Model

```php
// models/Producto.php

class Producto {
    public $codigo;
    public $nombre;
    public $precio;
    public $posicion;
    
    public function validar() {
        $errores = [];
        
        if ($this->codigo === null || !is_numeric($this->codigo)) {
            $errores[] = "El código debe ser un número válido";
        }
        
        if (empty(trim($this->nombre))) {
            $errores[] = "El nombre es obligatorio";
        }
        
        if (!is_numeric($this->precio) || $this->precio < 0) {
            $errores[] = "El precio debe ser mayor o igual a 0";
        }
        
        return [
            'valido' => empty($errores),
            'errores' => $errores
        ];
    }
}
```

---

## Conclusión

### MVC nos da:
- ✅ **Organización**: Código estructurado y mantenible
- ✅ **Separación**: Cada componente tiene su responsabilidad
- ✅ **Testabilidad**: Componentes independientes
- ✅ **Escalabilidad**: Fácil agregar funcionalidades

### REST API nos da:
- ✅ **Flexibilidad**: Múltiples clientes (web, móvil, desktop)
- ✅ **Estándar**: Siguiendo mejores prácticas de la industria
- ✅ **UX Mejorada**: Actualizaciones sin recargar página
- ✅ **Escalabilidad**: Arquitectura distribuida

### Juntos (MVC + REST API):
```
Frontend independiente (View)
    ↕ JSON
API REST (punto de entrada)
    ↕
Controller (lógica de negocio)
    ↕
Model (datos y validación)
    ↕
Database (persistencia)
```

Esta arquitectura es **profesional**, **escalable** y **mantenible**, siguiendo los estándares de la industria del desarrollo de software moderno.
