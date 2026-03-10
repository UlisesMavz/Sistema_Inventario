# 🌿 HA&KU — Sistema de Inventario

Sistema de gestión de inventario desarrollado con **XAMPP (MySQL + PHP)** y frontend en **HTML/CSS/JavaScript** bajo la estética minimalista *HA&KU*. **Todos los algoritmos de ordenamiento y búsqueda están implementados desde cero** para demostrar conocimientos de análisis de algoritmos y estructuras de datos.

---

## 🎯 Características Principales

### Algoritmos Implementados desde Cero

#### Ordenamiento (`utils/Ordenamiento.php`)
| Algoritmo | Complejidad | Campo |
|-----------|-------------|-------|
| Bubble Sort | O(n²) | Precio, Nombre, Stock |
| Quick Sort | O(n log n) | Precio, Nombre, Stock |

#### Búsqueda (`utils/Busqueda.php`)
| Algoritmo | Complejidad | Campo |
|-----------|-------------|-------|
| Búsqueda Lineal | O(n) | Código, Nombre |
| Búsqueda Binaria | O(log n) | Código, Nombre |

### Funcionalidades del Sistema
- ✅ Autenticación de usuarios con sesiones PHP + localStorage
- ✅ Seguridad: Logout destruye sesión en servidor; no se puede acceder con el botón "Atrás"
- ✅ Insertar productos (inicio, final, posición específica) — simula lista enlazada
- ✅ Eliminar productos (inicio, final, por código)
- ✅ Editar productos desde un modal interactivo
- ✅ Buscar productos con medición de rendimiento en ms
- ✅ Ordenar productos con medición de rendimiento en ms
- ✅ Gestión de Stock con alertas visuales (stock bajo / agotado)
- ✅ Categoría y Marca/Proveedor por producto
- ✅ Panel de Administración: Seed de BD (20/50/100 productos) y Wipe con contraseña
- ✅ Interfaz moderna, responsiva y animada (diseño pergamino-tinta)
- ✅ Separación de responsabilidades: HTML / CSS en archivos externos / JS

---

## 📁 Estructura del Proyecto

```
Sistema_Inventario/
├── config/
│   └── database.php              # Conexión PDO a MySQL
├── models/
│   ├── Producto.php              # Modelo de producto
│   └── Usuario.php               # Modelo de usuario
├── controllers/
│   ├── AuthController.php        # Autenticación y sesiones
│   └── ProductoController.php    # Gestión CRUD de productos
├── utils/
│   ├── Ordenamiento.php          # Bubble Sort y Quick Sort (desde cero)
│   ├── Busqueda.php              # Búsqueda Lineal y Binaria (desde cero)
│   └── Validacion.php            # Validaciones de datos
├── api/
│   ├── login.php                 # POST — Iniciar sesión
│   ├── logout.php                # POST — Cerrar sesión (destruye sesión PHP)
│   ├── productos.php             # GET/POST/PUT/DELETE — CRUD de productos
│   ├── buscar.php                # GET — Búsqueda de productos
│   ├── ordenar.php               # POST — Ordenamiento de productos
│   └── admin_db.php              # POST — Seed y Wipe de base de datos
├── public/
│   ├── css/
│   │   ├── dashboard.css         # Estilos del dashboard
│   │   ├── login.css             # Estilos de la página de login
│   │   └── styles.css            # Estilos globales
│   ├── js/
│   │   ├── auth.js               # Lógica de autenticación
│   │   ├── main.js               # Utilidades, logout, anti-caché
│   │   └── productos.js          # Gestión de productos (CRUD, ordenar, buscar)
│   ├── index.html                # Página de Login
│   └── dashboard.html            # Dashboard principal
├── sql/
│   └── schema.sql                # Esquema actualizado de la BD
├── install.php                   # Instalador automático (ejecutar 1 vez)
└── inventario_db.sql             # Backup/dump completo de la BD
```

---

## 🚀 Instalación y Configuración

### Requisitos Previos
- **XAMPP** instalado (Apache + MySQL + PHP 8+)
- Navegador web moderno (Chrome, Edge, Firefox)

### Pasos de Instalación

#### 1. Iniciar XAMPP
- Abrir XAMPP Control Panel
- Iniciar **Apache** y **MySQL**

#### 2. Instalar la Base de Datos (automático)
Abrir en el navegador:
```
http://localhost/Sistema_Inventario/install.php
```
Este script crea la base de datos `inventario_db` y todas las tablas automáticamente.

> **Alternativa manual:** Importar `inventario_db.sql` desde phpMyAdmin (`http://localhost/phpmyadmin`)

#### 3. Acceder a la Aplicación
```
http://localhost/Sistema_Inventario/public/index.html
```

---

## 👤 Credenciales de Acceso

| Usuario | Contraseña |
|---------|------------|
| `ADMIN` | `ADMIN`    |

---

## 💻 Uso del Sistema

### Login
- Ingresar usuario y contraseña
- Al cerrar sesión, la sesión PHP se destruye en el servidor — el botón "Atrás" **no** permite reentrar

### Panel: Lista de Productos
- Visualiza todos los productos con su posición en la lista enlazada, stock y estado
- Botón **↺ Actualizar** para recargar desde la BD

### Panel: Insertar Producto
Completa todos los campos y selecciona el tipo de inserción:
- **Al Inicio** — Posición 1 (head de la lista enlazada)
- **Al Final** — Última posición (tail)
- **Posición Específica** — Nodo intermedio

### Panel: Eliminar Producto
- **Eliminar del Inicio** / **Eliminar del Final** — Por posición
- **Eliminar por Código** — Nodo arbitrario

### Panel: Buscar Producto
Selecciona algoritmo y campo:
- **Búsqueda Lineal O(n)** — Por código o nombre
- **Búsqueda Binaria O(log n)** — Por código o nombre *(requiere datos ordenados)*

Muestra el resultado con tiempo de ejecución en ms y la posición exacta en la BD.

### Panel: Ordenar Productos
Selecciona algoritmo y campo de ordenamiento:
- **Bubble Sort O(n²)** / **Quick Sort O(n log n)**
- Campos: Precio · Nombre · Stock Crítico

> La lista ordenada se muestra inmediatamente. El botón **↺ Actualizar** retorna el orden original de la BD.

### Panel: Admin Base de Datos
- **Seed** — Inserta 20, 50 o 100 productos de prueba variados
- **Wipe** — Elimina **todos** los productos (requiere contraseña de admin)

---

## 🔧 Configuración de Base de Datos

Edita `config/database.php` si necesitas cambiar las credenciales de MySQL:

```php
private $host     = "localhost";
private $db_name  = "inventario_db";
private $username = "root";
private $password = ""; // Cambiar si tienes contraseña en MySQL
```

---

## 📊 Pseudocódigo de Algoritmos

### Bubble Sort
```php
for ($i = 0; $i < $n - 1; $i++) {
    for ($j = 0; $j < $n - 1 - $i; $j++) {
        if ($productos[$j]->precio > $productos[$j + 1]->precio) {
            $temp = $productos[$j];
            $productos[$j] = $productos[$j + 1];
            $productos[$j + 1] = $temp;
        }
    }
}
```

### Búsqueda Binaria
```php
$low = 0; $high = count($productos) - 1;
while ($low <= $high) {
    $mid = (int)(($low + $high) / 2);
    if ($productos[$mid]->codigo == $codigo) return $productos[$mid];
    else if ($productos[$mid]->codigo < $codigo) $low = $mid + 1;
    else $high = $mid - 1;
}
```

---

## 🎓 Conceptos Demostrados

| Concepto | Dónde |
|----------|-------|
| Complejidad Temporal Big O | Ordenamiento y Búsqueda |
| Divide y Conquista | Quick Sort |
| Recursión | Quick Sort |
| Lista Enlazada Simulada | `posicion` en tabla `productos` |
| Arquitectura MVC | Controllers / Models / Views |
| API RESTful | Endpoints en `api/` |
| Seguridad (sesiones, SQL Injection) | PDO + `AuthController` |
| Separación de Responsabilidades | HTML / CSS / JS en archivos separados |

---

## 🐛 Solución de Problemas

**Error: "No se puede conectar a la base de datos"**
- Verifica que MySQL esté activo en XAMPP
- Verifica credenciales en `config/database.php`
- Verifica que `inventario_db` exista en phpMyAdmin

**Error: "No autorizado" en las APIs**
- Cierra sesión y vuelve a iniciar sesión
- Si persiste, limpia las cookies del navegador (F12 → Application → Cookies → Clear)

**Los productos no aparecen en la tabla**
- Verifica que Apache esté activo
- Abre la consola del navegador (F12) y revisa errores en la pestaña Network

**El botón "Atrás" muestra el dashboard después de cerrar sesión**
- Asegúrate de que el servidor Apache esté en ejecución (el logout llama a `api/logout.php`)

---

## 📝 Notas Técnicas

- **Sin librerías externas**: Todos los algoritmos son implementación manual
- **PDO con prepared statements**: Previene SQL Injection
- **Sesiones PHP**: La sesión se destruye en el servidor al hacer logout
- **Cache-Control headers**: Las páginas protegidas incluyen `no-cache, no-store, must-revalidate`
- **Diseño Responsivo**: Adapta el layout a móvil y escritorio con media queries

---

*Sistema desarrollado como proyecto educativo para demostrar conocimientos en Análisis de Algoritmos, Estructuras de Datos, Desarrollo Full-Stack y Arquitectura MVC.*

---
