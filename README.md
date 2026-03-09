# 📦 Sistema de Inventario 

Sistema de gestión de inventario desarrollado con XAMPP (MySQL + PHP) y frontend en HTML/CSS/JavaScript. **Todos los algoritmos de ordenamiento y búsqueda están implementados desde cero** para demostrar conocimientos de análisis de algoritmos.

## 🎯 Características Principales

### Algoritmos Implementados desde Cero

#### Ordenamiento
- **Bubble Sort** O(n²) - Por precio y nombre
- **Quick Sort** O(n log n) - Por precio y nombre

#### Búsqueda
- **Búsqueda Lineal** O(n) - Por código y nombre
- **Búsqueda Binaria** O(log n) - Por código y nombre

### Funcionalidades
- ✅ Autenticación de usuarios
- ✅ Insertar productos (inicio, final, posición específica)
- ✅ Eliminar productos (inicio, final, por código)
- ✅ Buscar productos con medición de rendimiento
- ✅ Ordenar productos con medición de rendimiento
- ✅ Interfaz moderna y responsiva
- ✅ Registro de auditoría (logs)

## 📁 Estructura del Proyecto

```
Sistema_Inventario/
├── config/
│   └── database.php          # Conexión a BD
├── models/
│   ├── Producto.php          # Modelo de producto
│   └── Usuario.php           # Modelo de usuario
├── controllers/
│   ├── AuthController.php    # Autenticación
│   └── ProductoController.php # Gestión de productos
├── utils/
│   ├── Ordenamiento.php      # Algoritmos de ordenamiento
│   ├── Busqueda.php          # Algoritmos de búsqueda
│   └── Validacion.php        # Validaciones
├── api/
│   ├── login.php             # API de login
│   ├── productos.php         # API CRUD de productos
│   ├── buscar.php            # API de búsqueda
│   └── ordenar.php           # API de ordenamiento
├── public/
│   ├── css/styles.css        # Estilos
│   ├── js/
│   │   ├── auth.js           # Autenticación
│   │   ├── main.js           # Utilidades
│   │   └── productos.js      # Gestión de productos
│   ├── index.html            # Login
│   └── dashboard.html        # Dashboard
└── sql/
    └── schema.sql            # Esquema de BD
```

## 🚀 Instalación y Configuración

### Requisitos Previos
- XAMPP instalado (Apache + MySQL + PHP)
- Navegador web moderno

### Pasos de Instalación

#### 1. Iniciar XAMPP
- Abrir XAMPP Control Panel
- Iniciar **Apache** y **MySQL**

#### 2. Crear la Base de Datos
1. Abrir phpMyAdmin: `http://localhost/phpmyadmin`
2. Crear nueva base de datos llamada `inventario_db`
3. Importar el archivo `sql/schema.sql` o ejecutar el siguiente comando:

```bash
mysql -u root -p inventario_db < sql/schema.sql
```

O copiar y pegar el contenido de `schema.sql` en la pestaña SQL de phpMyAdmin.

#### 3. Verificar la Ubicación del Proyecto
El proyecto debe estar en: `c:\xampp\htdocs\Sistema_Inventario\`

#### 4. Acceder a la Aplicación
Abrir en el navegador: `http://localhost/Sistema_Inventario/public/index.html`

## 👤 Credenciales de Acceso

| Usuario | Contraseña |
|---------|------------|
| ADMIN | ADMIN |

## 💻 Uso del Sistema

### 1. Login
- Ingresar usuario y NIP
- El sistema validará las credenciales

### 2. Gestión de Productos

#### Insertar Producto
- Completar código, nombre y precio
- Seleccionar tipo de inserción:
  - **Al Inicio**: Inserta al principio de la lista
  - **Al Final**: Inserta al final de la lista
  - **Posición Específica**: Inserta en una posición determinada

#### Eliminar Producto
- **Eliminar Inicio**: Elimina el primer producto
- **Eliminar Final**: Elimina el último producto
- **Por Código**: Elimina un producto específico

### 3. Búsqueda de Productos

#### Búsqueda Lineal
- Complejidad: O(n)
- Recorre todos los elementos secuencialmente
- Funciona con datos ordenados y desordenados

#### Búsqueda Binaria
- Complejidad: O(log n)
- Divide el espacio de búsqueda a la mitad en cada iteración
- **Requiere datos ordenados**
- Mucho más rápida para grandes conjuntos de datos

### 4. Ordenamiento de Productos

#### Bubble Sort
- Complejidad: O(n²)
- Algoritmo simple pero ineficiente para grandes conjuntos
- Útil para demostrar conceptos básicos

#### Quick Sort
- Complejidad: O(n log n) en promedio
- Algoritmo eficiente usando divide y conquista
- Recomendado para grandes conjuntos de datos

**El sistema muestra el tiempo de ejecución en milisegundos para comparar rendimiento**

## 🔧 Configuración de Base de Datos

Si necesitas cambiar las credenciales de MySQL, edita `config/database.php`:

```php
private $host = "localhost";
private $db_name = "inventario_db";
private $username = "root";
private $password = ""; // Cambiar si tienes contraseña
```

## 📊 Demostración de Algoritmos

### Ejemplo de Bubble Sort (Ordenamiento.php)
```php
// Implementación manual sin usar funciones nativas
for ($i = 0; $i < $n - 1; $i++) {
    for ($j = 0; $j < $n - 1 - $i; $j++) {
        if ($productos[$j]->precio > $productos[$j + 1]->precio) {
            // Intercambio manual
            $temp = $productos[$j];
            $productos[$j] = $productos[$j + 1];
            $productos[$j + 1] = $temp;
        }
    }
}
```

### Ejemplo de Búsqueda Binaria (Busqueda.php)
```php
// Implementación manual de búsqueda binaria
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
```

## 🎓 Conceptos de Análisis de Algoritmos Demostrados

1. **Complejidad Temporal**: Medición de tiempos de ejecución
2. **Notación Big O**: Clasificación de algoritmos
3. **Divide y Conquista**: Quick Sort
4. **Recursión**: Quick Sort
5. **Búsqueda Eficiente**: Comparación lineal vs binaria
6. **Manejo de Punteros**: Simulación con arrays en PHP
7. **Estructuras de Datos**: Listas enlazadas simuladas

## 🐛 Solución de Problemas

### Error: "No se puede conectar a la base de datos"
- Verificar que MySQL esté ejecutándose en XAMPP
- Verificar credenciales en `config/database.php`
- Verificar que la base de datos `inventario_db` exista

### Error: "No autorizado"
- Limpiar localStorage del navegador
- Volver a iniciar sesión

### Los productos no se muestran
- Verificar que Apache esté ejecutándose
- Abrir consola del navegador (F12) para ver errores
- Verificar que las rutas de las APIs sean correctas

## 📝 Notas Técnicas

- **Sin librerías externas**: Todos los algoritmos están implementados manualmente
- **PDO**: Se usa PDO para prevenir SQL injection
- **Sesiones PHP**: Manejo seguro de autenticación
- **REST API**: Arquitectura RESTful para comunicación cliente-servidor
- **Responsive Design**: Interfaz adaptable a diferentes dispositivos



Sistema desarrollado como proyecto educativo para demostrar conocimientos de:
- Análisis de Algoritmos
- Estructuras de Datos
- Desarrollo Full-Stack
- Arquitectura MVC

---

