# 📚 Trabajo Final - Análisis de Algoritmos

**Sistema de Gestión de Inventario con Algoritmos de Ordenamiento y Búsqueda**

---

## 📋 Información del Proyecto

**Materia**: Análisis de Algoritmos  
**Carrera**: Ingeniería de Software  
**Institución**: Universidad en México  
**Tipo de Proyecto**: Trabajo en Equipo  
**Tecnologías**: PHP, MySQL, HTML, CSS, JavaScript  
**Fecha**: Febrero 2026

---

## 1. Introducción

El presente documento describe el desarrollo de un **Sistema de Gestión de Inventario** implementado como proyecto final para la materia de Análisis de Algoritmos. El sistema fue desarrollado en equipo con el objetivo de demostrar conocimientos prácticos en la implementación y análisis de algoritmos de ordenamiento y búsqueda.

### 1.1 Contexto del Proyecto

En el ámbito de la Ingeniería de Software, el análisis de algoritmos es fundamental para desarrollar aplicaciones eficientes y escalables. Este proyecto surge de la necesidad de aplicar los conocimientos teóricos adquiridos en clase a un caso de uso real: la gestión de inventarios.

### 1.2 Alcance

El sistema implementa:
- **Dos algoritmos de ordenamiento** con diferentes complejidades temporales
- **Dos algoritmos de búsqueda** con diferentes eficiencias
- **Arquitectura MVC** para separación de responsabilidades
- **API REST** para comunicación cliente-servidor
- **Interfaz web moderna** para interacción con el usuario
- **Sistema de medición de rendimiento** para comparar algoritmos

### 1.3 Importancia Académica

Este proyecto permite:
1. Implementar algoritmos desde cero sin usar funciones nativas del lenguaje
2. Comparar empíricamente la eficiencia de diferentes algoritmos
3. Aplicar conceptos de complejidad temporal y espacial
4. Desarrollar un sistema completo usando buenas prácticas de programación

---

## 2. Objetivos

### 2.1 Objetivo General

Desarrollar un sistema de gestión de inventario que implemente algoritmos de ordenamiento y búsqueda desde cero, permitiendo analizar y comparar su rendimiento en un entorno real de aplicación web.

### 2.2 Objetivos Específicos

#### 2.2.1 Objetivos Técnicos

1. **Implementar algoritmos de ordenamiento**:
   - Bubble Sort con complejidad O(n²)
   - Quick Sort con complejidad O(n log n)
   - Ambos aplicables a diferentes criterios (precio, nombre, código)

2. **Implementar algoritmos de búsqueda**:
   - Búsqueda Lineal con complejidad O(n)
   - Búsqueda Binaria con complejidad O(log n)
   - Ambos aplicables a diferentes atributos

3. **Desarrollar arquitectura escalable**:
   - Patrón MVC para organización del código
   - API REST para desacoplamiento frontend-backend
   - Base de datos relacional con normalización

4. **Medir y comparar rendimiento**:
   - Implementar sistema de medición de tiempos de ejecución
   - Mostrar resultados al usuario para comparación empírica
   - Validar complejidades teóricas con datos reales

#### 2.2.2 Objetivos Académicos

1. **Demostrar comprensión de análisis de algoritmos**:
   - Calcular complejidad temporal y espacial
   - Identificar mejor caso, caso promedio y peor caso
   - Aplicar notación Big O correctamente

2. **Aplicar técnicas algorítmicas**:
   - Divide y Conquista (Quick Sort)
   - Recursión (Quick Sort)
   - Búsqueda eficiente (Binary Search)
   - Optimizaciones (bandera en Bubble Sort)

3. **Desarrollar habilidades de programación**:
   - Implementación manual sin librerías
   - Código limpio y documentado
   - Manejo de estructuras de datos

#### 2.2.3 Objetivos de Aprendizaje

1. Comprender la importancia de elegir el algoritmo correcto según el contexto
2. Identificar trade-offs entre simplicidad y eficiencia
3. Aplicar conocimientos teóricos a problemas reales
4. Trabajar en equipo en un proyecto de software

---

## 3. Justificación

### 3.1 Justificación Académica

#### 3.1.1 Relevancia para la Materia

El proyecto de Sistema de Inventario es ideal para Análisis de Algoritmos porque:

**Permite implementar múltiples algoritmos**:
- Diferentes complejidades (O(n), O(n²), O(n log n), O(log n))
- Diferentes técnicas (iterativa, recursiva, divide y conquista)
- Diferentes aplicaciones (ordenamiento, búsqueda)

**Facilita comparación empírica**:
- Medición de tiempos reales de ejecución
- Visualización de diferencias de rendimiento
- Validación de análisis teórico

**Requiere análisis completo**:
- Mejor caso, caso promedio, peor caso
- Complejidad temporal y espacial
- Optimizaciones y trade-offs

#### 3.1.2 Aplicación Práctica

El sistema no es solo un ejercicio académico, sino una aplicación real que:
- Resuelve un problema común en empresas (gestión de inventario)
- Usa tecnologías actuales de la industria (PHP, MySQL, REST API)
- Implementa arquitectura profesional (MVC)
- Puede ser extendido y mejorado

### 3.2 Justificación Técnica

#### 3.2.1 Elección de Algoritmos de Ordenamiento

**Bubble Sort (O(n²))**:

*¿Por qué implementarlo?*
- Es el algoritmo más simple de entender e implementar
- Sirve como baseline para comparación
- Demuestra por qué los algoritmos O(n²) no escalan bien

*Ventajas*:
- Código simple y fácil de depurar
- Estable (mantiene orden relativo de elementos iguales)
- Requiere O(1) espacio adicional

*Desventajas*:
- Muy lento para conjuntos grandes
- No aprovecha datos parcialmente ordenados (sin optimización)

**Quick Sort (O(n log n))**:

*¿Por qué implementarlo?*
- Es uno de los algoritmos más eficientes en la práctica
- Demuestra la técnica de Divide y Conquista
- Muestra la importancia de la recursión

*Ventajas*:
- Muy rápido en promedio
- Funciona bien con datos aleatorios
- Usado en implementaciones reales (sort() de muchos lenguajes)

*Desventajas*:
- Peor caso O(n²) si pivote mal elegido
- Requiere O(log n) espacio por recursión
- No es estable

**Comparación Justificada**:

| Aspecto | Bubble Sort | Quick Sort |
|---------|-------------|------------|
| Complejidad Promedio | O(n²) | O(n log n) |
| Complejidad Espacial | O(1) | O(log n) |
| Estabilidad | Estable | No estable |
| Complejidad de Código | Simple | Moderada |
| Uso Práctico | Educativo | Producción |

#### 3.2.2 Elección de Algoritmos de Búsqueda

**Búsqueda Lineal (O(n))**:

*¿Por qué implementarla?*
- Es la búsqueda más básica y universal
- Funciona con datos ordenados y desordenados
- Sirve como baseline para comparación

*Ventajas*:
- Funciona con cualquier estructura de datos
- No requiere preprocesamiento
- Simple de implementar

*Desventajas*:
- Lenta para conjuntos grandes
- No aprovecha si los datos están ordenados

**Búsqueda Binaria (O(log n))**:

*¿Por qué implementarla?*
- Demuestra la eficiencia de Divide y Conquista
- Muestra la importancia del ordenamiento previo
- Es dramáticamente más rápida que lineal

*Ventajas*:
- Extremadamente rápida (log₂(1,000,000) = 20 comparaciones)
- Eficiente para búsquedas repetidas
- Complejidad logarítmica

*Desventajas*:
- Requiere datos ordenados
- Costo de ordenamiento si no están ordenados

**Comparación Justificada**:

| Aspecto | Lineal | Binaria |
|---------|--------|---------|
| Complejidad | O(n) | O(log n) |
| Requisito | Ninguno | Datos ordenados |
| Búsquedas en 1M elementos | 1,000,000 | 20 |
| Uso | Datos pequeños/desordenados | Datos grandes/ordenados |

### 3.3 Justificación de Arquitectura

#### 3.3.1 Patrón MVC

**¿Por qué MVC?**
- Separa lógica de negocio, presentación y datos
- Facilita mantenimiento y escalabilidad
- Permite trabajo en equipo (cada miembro en una capa)
- Es estándar en la industria

**Capas implementadas**:
- **Model**: Producto, Usuario (representan datos)
- **View**: HTML/CSS/JavaScript (interfaz de usuario)
- **Controller**: ProductoController, AuthController (lógica de negocio)

#### 3.3.2 API REST

**¿Por qué REST?**
- Desacopla frontend de backend
- Permite reutilización (web, móvil, desktop)
- Facilita pruebas independientes
- Es estándar de la industria

**Endpoints implementados**:
- `GET /api/productos.php` - Obtener todos los productos
- `POST /api/productos.php` - Insertar producto
- `DELETE /api/productos.php` - Eliminar producto
- `GET /api/buscar.php` - Buscar producto
- `POST /api/ordenar.php` - Ordenar productos

#### 3.3.3 Base de Datos Relacional

**¿Por qué MySQL?**
- Persistencia de datos
- Integridad referencial
- Consultas eficientes con índices
- Escalabilidad

**Diseño normalizado (3FN)**:
- Elimina redundancia
- Previene anomalías
- Facilita actualizaciones

### 3.4 Justificación de Implementación Manual

**¿Por qué no usar funciones nativas?**

En lugar de usar:
```php
// Funciones nativas de PHP
sort($productos);           // ❌ No permitido
usort($productos, ...);     // ❌ No permitido
array_search($codigo);      // ❌ No permitido
in_array($codigo);          // ❌ No permitido
```

Implementamos todo manualmente:
```php
// Implementación manual
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

**Razones**:
1. **Demostrar comprensión profunda**: No solo usar, sino entender cómo funciona
2. **Análisis de complejidad**: Contar operaciones reales
3. **Aprendizaje**: Enfrentar desafíos de implementación
4. **Objetivo académico**: El proyecto es para aprender, no para producción

---

## 4. Estructura del Proyecto

### 4.1 Arquitectura General

```
┌─────────────────────────────────────────────────────────┐
│                   CAPA DE PRESENTACIÓN                  │
│              (HTML, CSS, JavaScript)                    │
│  ┌──────────────┐              ┌──────────────┐        │
│  │  index.html  │              │dashboard.html│        │
│  │   (Login)    │              │  (Dashboard) │        │
│  └──────┬───────┘              └──────┬───────┘        │
└─────────┼──────────────────────────────┼───────────────┘
          │                              │
          │        HTTP/JSON (REST API)  │
          │                              │
┌─────────▼──────────────────────────────▼───────────────┐
│                   CAPA DE APLICACIÓN                    │
│                      (PHP Backend)                      │
│  ┌────────────────────────────────────────────────┐    │
│  │              APIs REST                         │    │
│  │  login.php | productos.php | buscar.php       │    │
│  └────────────────────┬───────────────────────────┘    │
│  ┌────────────────────▼───────────────────────────┐    │
│  │           CONTROLADORES (MVC)                  │    │
│  │  AuthController | ProductoController           │    │
│  └────────────────────┬───────────────────────────┘    │
│  ┌────────────────────▼───────────────────────────┐    │
│  │            MODELOS (MVC)                       │    │
│  │         Producto | Usuario                     │    │
│  └────────────────────┬───────────────────────────┘    │
│  ┌────────────────────▼───────────────────────────┐    │
│  │            UTILIDADES                          │    │
│  │  Ordenamiento | Busqueda | Validacion         │    │
│  └────────────────────────────────────────────────┘    │
└─────────────────────────┬───────────────────────────────┘
                          │
┌─────────────────────────▼───────────────────────────────┐
│                  CAPA DE DATOS                          │
│                  MySQL Database                         │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐             │
│  │ usuarios │  │productos │  │   logs   │             │
│  └──────────┘  └──────────┘  └──────────┘             │
└─────────────────────────────────────────────────────────┘
```

### 4.2 Estructura de Directorios

```
Sistema_Inventario/
│
├── config/                      # Configuración
│   └── database.php            # Conexión a BD (Patrón Singleton)
│
├── models/                      # Modelos (Entidades)
│   ├── Producto.php            # Modelo de Producto
│   └── Usuario.php             # Modelo de Usuario
│
├── controllers/                 # Controladores (Lógica de Negocio)
│   ├── AuthController.php      # Autenticación y sesiones
│   └── ProductoController.php  # CRUD de productos
│
├── utils/                       # Utilidades (Algoritmos)
│   ├── Ordenamiento.php        # ⭐ Bubble Sort y Quick Sort
│   ├── Busqueda.php            # ⭐ Búsqueda Lineal y Binaria
│   └── Validacion.php          # Validaciones de datos
│
├── api/                         # APIs REST
│   ├── login.php               # POST /api/login.php
│   ├── productos.php           # GET, POST, DELETE /api/productos.php
│   ├── buscar.php              # GET /api/buscar.php
│   └── ordenar.php             # POST /api/ordenar.php
│
├── public/                      # Frontend (Accesible vía web)
│   ├── css/
│   │   └── styles.css          # Estilos CSS
│   ├── js/
│   │   ├── auth.js             # Lógica de autenticación
│   │   ├── main.js             # Utilidades generales
│   │   └── productos.js        # Gestión de productos
│   ├── index.html              # Página de login
│   └── dashboard.html          # Dashboard principal
│
├── sql/                         # Scripts de Base de Datos
│   ├── schema.sql              # Esquema completo
│   └── migrate_posicion.php    # Script de migración
│
├── designs/                     # Documentación de Diseño
│   └── disenos_sistema.md      # Diagramas UML, Casos de Uso, BD
│
└── README.md                    # Documentación general
```

### 4.3 Componentes Principales

#### 4.3.1 Capa de Datos

**Base de Datos: `inventario_db`**

Tablas:
1. **`usuarios`**: Almacena credenciales de acceso
   - `id`, `nombre_usuario`, `password_hash`, `nombre_completo`
   - Contraseñas hasheadas con bcrypt

2. **`productos`**: Almacena inventario
   - `id`, `posicion`, `codigo`, `nombre`, `precio`
   - Campo `posicion` para simular lista enlazada
   - Índices en `posicion`, `codigo`, `nombre`, `precio`

3. **`logs`**: Auditoría de operaciones
   - `id`, `usuario_id`, `operacion`, `detalles`, `producto_id`
   - Foreign keys a `usuarios` y `productos`

#### 4.3.2 Capa de Aplicación

**Algoritmos Implementados** (⭐ Componentes principales):

**`utils/Ordenamiento.php`**:
- `bubbleSortPorPrecio()` - O(n²)
- `bubbleSortPorNombre()` - O(n²)
- `quickSortPorPrecio()` - O(n log n)
- `quickSortPorNombre()` - O(n log n)

**`utils/Busqueda.php`**:
- `busquedaLinealPorCodigo()` - O(n)
- `busquedaLinealPorNombre()` - O(n)
- `busquedaBinariaPorCodigo()` - O(log n)
- `busquedaBinariaPorNombre()` - O(log n)

**Controladores**:
- `ProductoController`: Gestiona CRUD y usa algoritmos
- `AuthController`: Gestiona autenticación

**Modelos**:
- `Producto`: Representa un producto con validación
- `Usuario`: Representa un usuario con verificación de password

#### 4.3.3 Capa de Presentación

**Frontend**:
- `index.html`: Página de login con validación
- `dashboard.html`: Interfaz principal con:
  - Formulario de inserción
  - Tabla de productos
  - Controles de búsqueda y ordenamiento
  - Medición de tiempos de ejecución

**JavaScript**:
- Comunicación con API vía Fetch
- Actualización dinámica de la interfaz
- Validación de formularios

---

## 5. Análisis del Proyecto

### 5.1 Algoritmos de Ordenamiento Implementados

#### 5.1.1 Bubble Sort

**Descripción**:
Algoritmo de ordenamiento simple que compara elementos adyacentes y los intercambia si están en orden incorrecto. El elemento más grande "burbujea" hacia el final en cada iteración.

**Pseudocódigo**:
```
FUNCIÓN bubbleSortPorPrecio(productos[])
  n ← longitud(productos)
  
  PARA i ← 0 HASTA n-2 HACER
    huboIntercambio ← FALSO
    
    PARA j ← 0 HASTA n-2-i HACER
      SI productos[j].precio > productos[j+1].precio ENTONCES
        INTERCAMBIAR(productos[j], productos[j+1])
        huboIntercambio ← VERDADERO
      FIN SI
    FIN PARA
    
    SI huboIntercambio = FALSO ENTONCES
      ROMPER  // Optimización: ya está ordenado
    FIN SI
  FIN PARA
  
  RETORNAR productos
FIN FUNCIÓN
```

**Análisis de Complejidad**:

*Complejidad Temporal*:
- **Mejor caso**: O(n) - Array ya ordenado, solo una pasada
- **Caso promedio**: O(n²) - Requiere múltiples pasadas
- **Peor caso**: O(n²) - Array ordenado inversamente

*Complejidad Espacial*:
- O(1) - Solo usa variable temporal para intercambio

*Análisis Matemático*:
```
Bucle externo: n-1 iteraciones
Bucle interno: (n-1), (n-2), ..., 1 iteraciones

Total de comparaciones:
(n-1) + (n-2) + ... + 1 = n(n-1)/2 = (n² - n)/2

Eliminando constantes y términos menores:
O(n²)
```

**Optimización Implementada**:
- Bandera `huboIntercambio` para detener si no hay cambios
- Reduce complejidad a O(n) si el array ya está ordenado

**Ventajas**:
- ✅ Simple de implementar y entender
- ✅ Estable (mantiene orden relativo)
- ✅ No requiere memoria adicional
- ✅ Funciona bien con datos casi ordenados (con optimización)

**Desventajas**:
- ❌ Muy lento para conjuntos grandes
- ❌ O(n²) comparaciones en promedio
- ❌ No es práctico para producción

**Casos de Uso**:
- Conjuntos pequeños (< 50 elementos)
- Datos casi ordenados
- Propósitos educativos

#### 5.1.2 Quick Sort

**Descripción**:
Algoritmo de ordenamiento eficiente que usa la técnica de Divide y Conquista. Selecciona un pivote, particiona el array en elementos menores y mayores que el pivote, y ordena recursivamente cada partición.

**Pseudocódigo**:
```
FUNCIÓN quickSortPorPrecio(productos[], low, high)
  SI low >= high ENTONCES
    RETORNAR productos
  FIN SI
  
  // DIVIDIR
  pivotIndex ← particionPrecio(productos, low, high)
  
  // CONQUISTAR
  quickSortPorPrecio(productos, low, pivotIndex - 1)
  quickSortPorPrecio(productos, pivotIndex + 1, high)
  
  RETORNAR productos
FIN FUNCIÓN

FUNCIÓN particionPrecio(productos[], low, high)
  pivot ← productos[high].precio
  i ← low - 1
  
  PARA j ← low HASTA high-1 HACER
    SI productos[j].precio < pivot ENTONCES
      i ← i + 1
      INTERCAMBIAR(productos[i], productos[j])
    FIN SI
  FIN PARA
  
  INTERCAMBIAR(productos[i+1], productos[high])
  RETORNAR i + 1
FIN FUNCIÓN
```

**Análisis de Complejidad**:

*Complejidad Temporal*:
- **Mejor caso**: O(n log n) - Particiones balanceadas
- **Caso promedio**: O(n log n) - Particiones relativamente balanceadas
- **Peor caso**: O(n²) - Pivote siempre es el menor/mayor (raro)

*Complejidad Espacial*:
- O(log n) - Por la pila de recursión

*Análisis Matemático*:
```
Ecuación de recurrencia:
T(n) = 2T(n/2) + O(n)

Donde:
- 2T(n/2): Dos llamadas recursivas con mitad de elementos
- O(n): Trabajo de partición

Por el Teorema Maestro:
T(n) = O(n log n)

Explicación:
- Altura del árbol de recursión: log n
- Trabajo en cada nivel: O(n)
- Total: O(n) × log n = O(n log n)
```

**Ventajas**:
- ✅ Muy rápido en promedio
- ✅ Funciona bien con datos aleatorios
- ✅ Usado en implementaciones reales
- ✅ Divide y Conquista es elegante

**Desventajas**:
- ❌ Peor caso O(n²) (raro pero posible)
- ❌ No es estable
- ❌ Requiere espacio para recursión
- ❌ Más complejo de implementar

**Casos de Uso**:
- Conjuntos grandes (> 100 elementos)
- Datos aleatorios
- Cuando se necesita velocidad
- Producción (con optimizaciones)

#### 5.1.3 Comparación Empírica

**Prueba con 13 productos**:

| Algoritmo | Tiempo Promedio | Comparaciones |
|-----------|-----------------|---------------|
| Bubble Sort | ~0.8 ms | ~78 |
| Quick Sort | ~0.4 ms | ~40 |

**Prueba teórica con 1,000 productos**:

| Algoritmo | Comparaciones Teóricas |
|-----------|------------------------|
| Bubble Sort | ~500,000 (n²) |
| Quick Sort | ~10,000 (n log n) |

**Conclusión**: Quick Sort es **50x más rápido** para 1,000 elementos.

### 5.2 Algoritmos de Búsqueda Implementados

#### 5.2.1 Búsqueda Lineal

**Descripción**:
Algoritmo de búsqueda simple que recorre secuencialmente cada elemento del array hasta encontrar el valor buscado o llegar al final.

**Pseudocódigo**:
```
FUNCIÓN busquedaLinealPorCodigo(productos[], codigo)
  n ← longitud(productos)
  
  PARA i ← 0 HASTA n-1 HACER
    SI productos[i].codigo = codigo ENTONCES
      RETORNAR productos[i]
    FIN SI
  FIN PARA
  
  RETORNAR NULL
FIN FUNCIÓN
```

**Análisis de Complejidad**:

*Complejidad Temporal*:
- **Mejor caso**: O(1) - Elemento en primera posición
- **Caso promedio**: O(n) - Elemento en el medio
- **Peor caso**: O(n) - Elemento al final o no existe

*Complejidad Espacial*:
- O(1) - No usa memoria adicional

*Análisis Matemático*:
```
Mejor caso: 1 comparación
Peor caso: n comparaciones
Caso promedio: n/2 comparaciones

Eliminando constantes:
O(n)
```

**Ventajas**:
- ✅ Simple de implementar
- ✅ Funciona con datos ordenados y desordenados
- ✅ No requiere preprocesamiento
- ✅ Funciona con cualquier estructura de datos

**Desventajas**:
- ❌ Lento para conjuntos grandes
- ❌ No aprovecha si los datos están ordenados
- ❌ O(n) comparaciones en promedio

**Casos de Uso**:
- Conjuntos pequeños
- Datos desordenados
- Búsquedas únicas (no repetidas)

#### 5.2.2 Búsqueda Binaria

**Descripción**:
Algoritmo de búsqueda eficiente que usa Divide y Conquista. Divide el espacio de búsqueda a la mitad en cada iteración, comparando el elemento del medio con el valor buscado.

**Requisito**: Array DEBE estar ordenado.

**Pseudocódigo**:
```
FUNCIÓN busquedaBinariaPorCodigo(productos[], codigo)
  // Ordenar si es necesario
  productos ← ordenarPorCodigo(productos)
  
  low ← 0
  high ← longitud(productos) - 1
  
  MIENTRAS low <= high HACER
    mid ← (low + high) / 2
    
    SI productos[mid].codigo = codigo ENTONCES
      RETORNAR productos[mid]
    SINO SI productos[mid].codigo < codigo ENTONCES
      low ← mid + 1
    SINO
      high ← mid - 1
    FIN SI
  FIN MIENTRAS
  
  RETORNAR NULL
FIN FUNCIÓN
```

**Análisis de Complejidad**:

*Complejidad Temporal*:
- **Mejor caso**: O(1) - Elemento en el medio
- **Caso promedio**: O(log n) - Divide espacio a la mitad
- **Peor caso**: O(log n) - Elemento al inicio/final o no existe

*Complejidad Espacial*:
- O(1) - Solo usa variables para índices

*Análisis Matemático*:
```
En cada iteración, el espacio se reduce a la mitad:
Iteración 1: n elementos
Iteración 2: n/2 elementos
Iteración 3: n/4 elementos
...
Iteración k: n/(2^k) elementos

Termina cuando n/(2^k) = 1
Resolviendo: k = log₂(n)

Por lo tanto: O(log n)
```

**Ejemplo con 8 elementos**:
```
Array: [1, 3, 5, 7, 9, 11, 13, 15]
Buscar: 7

Iteración 1: low=0, high=7, mid=3 → productos[3]=7 ✓ ENCONTRADO!
Total: 1 comparación

Buscar: 14

Iteración 1: low=0, high=7, mid=3 → productos[3]=7 < 14 → low=4
Iteración 2: low=4, high=7, mid=5 → productos[5]=11 < 14 → low=6
Iteración 3: low=6, high=7, mid=6 → productos[6]=13 < 14 → low=7
Iteración 4: low=7, high=7, mid=7 → productos[7]=15 > 14 → high=6
low > high → NO ENCONTRADO
Total: 4 comparaciones
```

**Ventajas**:
- ✅ Extremadamente rápido
- ✅ log₂(1,000,000) = 20 comparaciones
- ✅ Eficiente para búsquedas repetidas
- ✅ Complejidad logarítmica

**Desventajas**:
- ❌ Requiere datos ordenados
- ❌ Costo de ordenamiento si no están ordenados
- ❌ Más complejo de implementar

**Casos de Uso**:
- Conjuntos grandes
- Datos ordenados
- Búsquedas repetidas
- Cuando se necesita velocidad

#### 5.2.3 Comparación Empírica

**Prueba con 13 productos**:

| Búsqueda | Tiempo Promedio | Comparaciones |
|----------|-----------------|---------------|
| Lineal | ~0.2 ms | ~7 (promedio) |
| Binaria | ~0.1 ms | ~4 (máximo) |

**Prueba teórica con 1,000,000 productos**:

| Búsqueda | Comparaciones Teóricas |
|----------|------------------------|
| Lineal | ~500,000 (n/2) |
| Binaria | ~20 (log n) |

**Conclusión**: Binaria es **25,000x más rápida** para 1,000,000 elementos.

### 5.3 Técnicas Algorítmicas Aplicadas

#### 5.3.1 Divide y Conquista

**Aplicado en**: Quick Sort, Búsqueda Binaria

**Principio**:
1. **Dividir**: Partir el problema en subproblemas más pequeños
2. **Conquistar**: Resolver cada subproblema recursivamente
3. **Combinar**: Unir las soluciones

**Ventajas**:
- Reduce complejidad de O(n²) a O(n log n)
- Aprovecha recursión
- Elegante y eficiente

#### 5.3.2 Recursión

**Aplicado en**: Quick Sort

**Características**:
- Función que se llama a sí misma
- Caso base para terminar
- Reduce tamaño del problema en cada llamada

**Análisis de Espacio**:
- Cada llamada recursiva usa espacio en la pila
- Quick Sort: O(log n) espacio por profundidad del árbol

#### 5.3.3 Optimizaciones

**Bubble Sort**:
- Bandera `huboIntercambio` para detener anticipadamente
- Reduce rango en cada pasada (`n - 1 - i`)

**Búsqueda Binaria**:
- Ordenamiento previo automático
- División entera manual para evitar errores de punto flotante

### 5.4 Medición de Rendimiento

**Sistema Implementado**:
```php
$inicio = microtime(true);
// Ejecutar algoritmo
$resultado = Ordenamiento::quickSortPorPrecio($productos);
$fin = microtime(true);
$tiempo = ($fin - $inicio) * 1000; // Convertir a milisegundos
```

**Resultados Mostrados al Usuario**:
- Tiempo de ejecución en milisegundos
- Número de elementos procesados
- Algoritmo utilizado

**Importancia**:
- Validación empírica de análisis teórico
- Comparación visual entre algoritmos
- Comprensión práctica de eficiencia

---

## 6. Glosario

### Términos de Análisis de Algoritmos

**Algoritmo**: Conjunto finito de instrucciones bien definidas para resolver un problema.

**Análisis de Algoritmos**: Proceso de determinar la cantidad de recursos (tiempo, espacio) que un algoritmo requiere.

**Big O (Notación O)**: Notación matemática que describe el límite superior del crecimiento de una función. Representa el peor caso de complejidad.

**Búsqueda Binaria**: Algoritmo de búsqueda eficiente (O(log n)) que divide el espacio de búsqueda a la mitad en cada iteración. Requiere datos ordenados.

**Búsqueda Lineal**: Algoritmo de búsqueda simple (O(n)) que recorre secuencialmente cada elemento.

**Bubble Sort**: Algoritmo de ordenamiento simple (O(n²)) que compara elementos adyacentes y los intercambia si están en orden incorrecto.

**Caso Base**: Condición en recursión que detiene las llamadas recursivas.

**Caso Promedio**: Comportamiento esperado de un algoritmo con entrada típica.

**Complejidad Espacial**: Cantidad de memoria adicional que un algoritmo requiere en función del tamaño de entrada.

**Complejidad Temporal**: Cantidad de tiempo que un algoritmo requiere en función del tamaño de entrada.

**Divide y Conquista**: Técnica algorítmica que divide un problema en subproblemas más pequeños, los resuelve recursivamente y combina las soluciones.

**Estabilidad**: Propiedad de un algoritmo de ordenamiento que mantiene el orden relativo de elementos iguales.

**Mejor Caso**: Escenario más favorable para un algoritmo (menor cantidad de operaciones).

**O(1) - Constante**: Tiempo de ejecución no depende del tamaño de entrada.

**O(log n) - Logarítmica**: Tiempo de ejecución crece logarítmicamente con el tamaño de entrada. Muy eficiente.

**O(n) - Lineal**: Tiempo de ejecución crece linealmente con el tamaño de entrada.

**O(n log n) - Lineal-Logarítmica**: Tiempo de ejecución crece en proporción a n multiplicado por log n. Eficiente para ordenamiento.

**O(n²) - Cuadrática**: Tiempo de ejecución crece cuadráticamente con el tamaño de entrada. Ineficiente para conjuntos grandes.

**Peor Caso**: Escenario menos favorable para un algoritmo (mayor cantidad de operaciones).

**Pivote**: Elemento seleccionado en Quick Sort para particionar el array.

**Quick Sort**: Algoritmo de ordenamiento eficiente (O(n log n)) que usa divide y conquista.

**Recursión**: Técnica donde una función se llama a sí misma para resolver subproblemas.

### Términos de Programación

**API (Application Programming Interface)**: Conjunto de definiciones y protocolos para comunicación entre componentes de software.

**CRUD**: Create, Read, Update, Delete - Operaciones básicas de persistencia de datos.

**Frontend**: Parte de la aplicación con la que el usuario interacta directamente (interfaz).

**Backend**: Parte de la aplicación que procesa lógica de negocio y gestiona datos (servidor).

**JSON (JavaScript Object Notation)**: Formato ligero de intercambio de datos.

**MVC (Model-View-Controller)**: Patrón de arquitectura que separa datos (Model), presentación (View) y lógica (Controller).

**PDO (PHP Data Objects)**: Interfaz de PHP para acceso a bases de datos que previene SQL injection.

**REST (Representational State Transfer)**: Estilo de arquitectura para servicios web que usa HTTP.

**Singleton**: Patrón de diseño que garantiza una única instancia de una clase.

### Términos de Base de Datos

**Foreign Key (Clave Foránea)**: Campo que referencia la clave primaria de otra tabla.

**Índice**: Estructura de datos que mejora la velocidad de búsqueda en una tabla.

**Normalización**: Proceso de organizar datos para reducir redundancia.

**Primary Key (Clave Primaria)**: Campo que identifica únicamente cada registro en una tabla.

**Transacción**: Conjunto de operaciones que se ejecutan como una unidad atómica.

---

## 7. Conclusiones

### 7.1 Conclusiones Técnicas

#### 7.1.1 Sobre Algoritmos de Ordenamiento

1. **La complejidad importa**: La diferencia entre O(n²) y O(n log n) es dramática para conjuntos grandes. Quick Sort es aproximadamente 50 veces más rápido que Bubble Sort para 1,000 elementos.

2. **Trade-off simplicidad vs eficiencia**: Bubble Sort es más simple de implementar y entender, pero Quick Sort es mucho más eficiente. La elección depende del contexto.

3. **Optimizaciones marcan la diferencia**: La bandera `huboIntercambio` en Bubble Sort reduce la complejidad de O(n²) a O(n) para datos ordenados.

4. **Recursión es poderosa**: Quick Sort demuestra cómo la recursión y Divide y Conquista pueden resolver problemas complejos elegantemente.

#### 7.1.2 Sobre Algoritmos de Búsqueda

1. **El ordenamiento previo vale la pena**: Aunque ordenar tiene costo, permite usar búsqueda binaria que es 25,000 veces más rápida que lineal para 1,000,000 elementos.

2. **Logaritmos son mágicos**: La complejidad O(log n) significa que duplicar el tamaño de entrada solo agrega una comparación más. log₂(1,000,000) = 20 comparaciones.

3. **Contexto determina el algoritmo**: Búsqueda lineal es mejor para conjuntos pequeños o desordenados. Búsqueda binaria es mejor para conjuntos grandes ordenados.

#### 7.1.3 Sobre Implementación Manual

1. **Comprender es más importante que usar**: Implementar algoritmos desde cero proporciona comprensión profunda que no se obtiene usando funciones nativas.

2. **Contar operaciones es revelador**: Al implementar manualmente, se puede contar exactamente cuántas comparaciones e intercambios se realizan, validando el análisis teórico.

3. **Los detalles importan**: Pequeños detalles como división entera vs flotante, o el orden de comparaciones, pueden afectar el rendimiento.

### 7.2 Conclusiones Académicas

#### 7.2.1 Aprendizajes Clave

1. **Análisis teórico se valida empíricamente**: Los tiempos medidos en el sistema confirman las complejidades teóricas (O(n²), O(n log n), O(n), O(log n)).

2. **Notación Big O es práctica**: No es solo teoría abstracta. La diferencia entre O(n) y O(log n) es observable y significativa en aplicaciones reales.

3. **Estructuras de datos y algoritmos van de la mano**: El campo `posicion` en la base de datos simula una lista enlazada, demostrando cómo las estructuras de datos afectan el diseño.

4. **Técnicas algorítmicas son reutilizables**: Divide y Conquista se aplica tanto en Quick Sort como en Búsqueda Binaria, demostrando que las técnicas trascienden algoritmos específicos.

#### 7.2.2 Cumplimiento de Objetivos

**Objetivos Técnicos**:
- ✅ Implementados 2 algoritmos de ordenamiento (Bubble Sort, Quick Sort)
- ✅ Implementados 2 algoritmos de búsqueda (Lineal, Binaria)
- ✅ Desarrollada arquitectura MVC escalable
- ✅ Implementado sistema de medición de rendimiento

**Objetivos Académicos**:
- ✅ Demostrada comprensión de análisis de algoritmos
- ✅ Aplicadas técnicas algorítmicas (Divide y Conquista, Recursión)
- ✅ Desarrolladas habilidades de programación (código limpio, documentado)

**Objetivos de Aprendizaje**:
- ✅ Comprendida la importancia de elegir el algoritmo correcto
- ✅ Identificados trade-offs entre simplicidad y eficiencia
- ✅ Aplicados conocimientos teóricos a problemas reales
- ✅ Trabajado en equipo en proyecto de software

### 7.3 Conclusiones de Diseño

#### 7.3.1 Arquitectura

1. **MVC facilita organización**: La separación en Model-View-Controller permitió que diferentes miembros del equipo trabajaran en paralelo sin conflictos.

2. **API REST desacopla frontend y backend**: Esto permitió desarrollar y probar cada capa independientemente.

3. **Base de datos normalizada previene problemas**: La normalización a 3FN eliminó redundancia y facilitó actualizaciones.

#### 7.3.2 Decisiones de Diseño

1. **Campo `posicion` fue clave**: Permitió simular lista enlazada en base de datos relacional, manteniendo orden independiente del ID.

2. **Índices mejoran rendimiento**: Los índices en `posicion`, `codigo`, `nombre` y `precio` aceleraron las consultas significativamente.

3. **Prepared Statements previenen SQL Injection**: El uso de PDO con prepared statements garantizó seguridad.

### 7.4 Conclusiones de Trabajo en Equipo

1. **Documentación es esencial**: La documentación detallada (README, arquitectura, diseños) facilitó la colaboración.

2. **Estándares de código ayudan**: Seguir convenciones de nombres y estructura hizo el código más legible.

3. **División de tareas fue efectiva**: Asignar capas MVC a diferentes miembros permitió trabajo paralelo.

### 7.5 Reflexiones Finales

#### 7.5.1 Importancia del Análisis de Algoritmos

Este proyecto demostró que el análisis de algoritmos no es solo teoría académica, sino una habilidad práctica esencial para desarrollar software eficiente. La diferencia entre elegir Bubble Sort o Quick Sort puede significar la diferencia entre una aplicación lenta e inutilizable y una aplicación rápida y profesional.

#### 7.5.2 Aplicabilidad en la Industria

Aunque implementamos algoritmos desde cero con fines educativos, en la industria se usan librerías optimizadas. Sin embargo, comprender cómo funcionan internamente permite:
- Elegir la librería correcta
- Identificar cuellos de botella
- Optimizar código cuando sea necesario
- Diseñar algoritmos personalizados para problemas específicos

#### 7.5.3 Preparación Profesional

Este proyecto nos preparó para:
- Entrevistas técnicas (preguntas comunes sobre algoritmos)
- Desarrollo de software real (arquitectura, APIs, bases de datos)
- Trabajo en equipo (colaboración, documentación, estándares)
- Toma de decisiones técnicas (trade-offs, optimizaciones)

### 7.6 Trabajo Futuro

**Posibles Mejoras**:

1. **Algoritmos Adicionales**:
   - Merge Sort (O(n log n) estable)
   - Heap Sort (O(n log n) sin recursión)
   - Interpolation Search (mejor que binaria para datos uniformes)

2. **Optimizaciones**:
   - Quick Sort con selección aleatoria de pivote
   - Hybrid Sort (Quick Sort + Insertion Sort para subarrays pequeños)
   - Caché de resultados de búsqueda

3. **Funcionalidades**:
   - Exportar a CSV/PDF
   - Gráficas de rendimiento
   - Comparación visual de algoritmos
   - Modo de demostración paso a paso

4. **Escalabilidad**:
   - Paginación para grandes conjuntos
   - Búsqueda con autocompletado
   - Filtros avanzados

### 7.7 Conclusión General

El desarrollo de este Sistema de Gestión de Inventario cumplió exitosamente con los objetivos académicos de la materia de Análisis de Algoritmos. Se implementaron y analizaron algoritmos fundamentales de ordenamiento y búsqueda, se validaron empíricamente las complejidades teóricas, y se desarrolló una aplicación web completa usando arquitectura profesional.

El proyecto demostró que:
- **Los algoritmos importan**: La elección correcta puede mejorar el rendimiento 50x o más
- **La teoría se valida en la práctica**: Las complejidades O(n²), O(n log n), O(n) y O(log n) son observables
- **La implementación manual enseña**: Comprender cómo funcionan los algoritmos internamente es invaluable
- **El diseño de software es integral**: Algoritmos, estructuras de datos, arquitectura y seguridad trabajan juntos

Este proyecto no solo cumplió con los requisitos académicos, sino que proporcionó experiencia práctica valiosa en desarrollo de software, preparándonos para desafíos profesionales futuros.

---

## Referencias

### Documentación del Proyecto

1. **README.md** - Documentación general del sistema
2. **Sistema_Inventario_Arquitectura.md** - Arquitectura detallada del sistema
3. **Exposicion_MVC_y_API_REST.md** - Explicación de patrones MVC y REST
4. **disenos_sistema.md** - Diagramas UML, Casos de Uso y Base de Datos
5. **walkthrough.md** - Guía completa de implementación

### Código Fuente

1. **utils/Ordenamiento.php** - Implementación de Bubble Sort y Quick Sort
2. **utils/Busqueda.php** - Implementación de Búsqueda Lineal y Binaria
3. **controllers/ProductoController.php** - Lógica de negocio
4. **sql/schema.sql** - Esquema de base de datos

### Bibliografía Recomendada

1. Cormen, T. H., Leiserson, C. E., Rivest, R. L., & Stein, C. (2009). *Introduction to Algorithms* (3rd ed.). MIT Press.

2. Sedgewick, R., & Wayne, K. (2011). *Algorithms* (4th ed.). Addison-Wesley.

3. Skiena, S. S. (2008). *The Algorithm Design Manual* (2nd ed.). Springer.

---

**Fin del Documento**

*Sistema de Gestión de Inventario - Proyecto Final de Análisis de Algoritmos*  
*Ingeniería de Software - México - 2026*
