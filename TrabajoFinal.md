# Sistema de Inventario con Algoritmos de Ordenamiento y Búsqueda sobre Lista Enlazada Simulada en Base de Datos Relacional

**Materia:** Análisis de Algoritmos  
**Carrera:** Ingeniería en Computación  
**Integrantes del equipo:** *(Nombres del equipo)*  
**Fecha:** Marzo 2026

---

## Tabla de Contenidos

1. [Introducción](#1-introducción)
2. [Justificación](#2-justificación)
3. [Objetivos](#3-objetivos)
4. [Marco Teórico](#4-marco-teórico)
5. [Desarrollo](#5-desarrollo)
6. [Conclusiones](#6-conclusiones)
7. [Bibliografía y Referencias](#7-bibliografía-y-referencias)

---

## 1. Introducción

El estudio del análisis de algoritmos constituye uno de los pilares fundamentales de la ingeniería en computación. Comprender por qué un algoritmo es eficiente o ineficiente, cómo escala con el crecimiento de los datos y de qué manera las estructuras de datos influyen en su comportamiento, son competencias imprescindibles para cualquier ingeniero de software. Sin embargo, llevar estos conceptos del plano teórico al plano práctico es un desafío constante en la formación académica: los algoritmos suelen enseñarse en un vacío, aislados de un contexto de aplicación real, lo que dificulta una comprensión profunda y duradera.

El presente trabajo documenta el diseño, análisis e implementación de un **Sistema de Gestión de Inventario** desarrollado como proyecto integrador por un equipo de cuatro estudiantes de Ingeniería en Computación. El sistema, denominado *HA&KU*, fue construido íntegramente con tecnologías web modernas —PHP, MySQL, HTML5, CSS3 y JavaScript— bajo el patrón de arquitectura Modelo-Vista-Controlador (MVC) y una API RESTful.

La característica central del proyecto, y la que guía el análisis presentado en este documento, es la implementación **desde cero** de algoritmos clásicos de ordenamiento (Bubble Sort y Quick Sort) y de búsqueda (Búsqueda Lineal y Búsqueda Binaria), aplicados sobre una colección de datos almacenada en una base de datos relacional (MySQL). Para enriquecer el estudio, se diseñó un mecanismo que simula el comportamiento de una **lista enlazada** directamente sobre la tabla de productos mediante un campo entero de posición explícita, replicando así la semántica de inserción en cabeza (*head*), en cola (*tail*) y en posición arbitraria que caracteriza a dicha estructura de datos.

El documento está organizado de la siguiente manera: primero se expone la justificación del proyecto y la elección de sus componentes tecnológicos; después se enuncian los objetivos generales y particulares; a continuación se desarrolla el marco teórico que da sustento conceptual al trabajo; se describe la metodología ágil empleada y las etapas del desarrollo; y finalmente se presentan las conclusiones y la bibliografía consultada.

---

## 2. Justificación

La teoría de algoritmos y estructuras de datos, tal como se plantea en Cormen et al. (2022), exige que el estudiante no solo conozca el pseudocódigo de un algoritmo, sino que sea capaz de implementarlo, medir su rendimiento y tomar decisiones de diseño informadas en función de la complejidad temporal y espacial. La asignatura de Análisis de Algoritmos provee ese marco teórico, pero la brecha entre el concepto y su aplicación práctica en un sistema real persiste si no se incluye un proyecto integrador.

Este proyecto surge precisamente para cerrar esa brecha. Desarrollar un **sistema de inventario funcional** —con autenticación de usuarios, operaciones CRUD completas, panel de administración y una interfaz de usuario estética— obliga al equipo a aplicar los algoritmos en un contexto concreto, con datos reales y con la restricción adicional de que el entorno de ejecución no es un arreglo en memoria sino una base de datos relacional. Este último punto introduce una capa de complejidad inusual en los proyectos académicos: los algoritmos deben recuperar los datos de MySQL y operar sobre ellos en PHP, lo que añade el concepto de **transferencia de datos entre capas** al análisis de rendimiento.

Adicionalmente, la decisión de simular una lista enlazada mediante un campo `posicion` en la base de datos —en lugar de depender del orden de inserción implícito de los registros— justifica la exploración de una técnica de diseño que no suele aparecer en los libros de algoritmos, pero que es habitual en sistemas de producción donde se necesita un orden personalizado persistente. Esto conecta directamente con el estudio de estructuras de datos dinámicas descrito por Aho, Hopcroft y Ullman (1983) y con las discusiones contemporáneas sobre modelos de datos en sistemas de información.

Finalmente, el trabajo en equipo bajo una metodología ágil ligera —adaptada de Scrum y Kanban para un grupo de cuatro personas— reproduce las condiciones reales del ejercicio profesional, donde la coordinación, la división de responsabilidades y la comunicación continua son tan importantes como las habilidades técnicas individuales.

---

## 3. Objetivos

### 3.1 Objetivo General

Diseñar, implementar y analizar un sistema web de gestión de inventario que demuestre la aplicación práctica de algoritmos clásicos de ordenamiento y búsqueda sobre una estructura de datos persistida en una base de datos relacional, empleando arquitectura MVC y metodología ágil colaborativa.

### 3.2 Objetivos Particulares

1. **Implementar desde cero** los algoritmos Bubble Sort, Quick Sort, Búsqueda Lineal y Búsqueda Binaria en PHP, sin recurrir a funciones nativas de ordenamiento o búsqueda del lenguaje, para demostrar el conocimiento de su lógica interna.

2. **Simular el comportamiento de una lista enlazada** dentro de una base de datos relacional MySQL mediante el uso de un campo de posición explícita, replicando las operaciones de inserción en cabeza, inserción en cola e inserción en posición arbitraria.

3. **Medir y comparar el rendimiento** de los algoritmos implementados registrando el tiempo de ejecución en milisegundos para cada operación de búsqueda y ordenamiento, y presentar los resultados al usuario en la interfaz del sistema.

4. **Diseñar y construir una arquitectura MVC** con separación clara entre Modelo, Vista y Controlador, utilizando una API RESTful como capa de comunicación entre el frontend JavaScript y el backend PHP.

5. **Aplicar principios de seguridad** en el manejo de sesiones, autenticación de usuarios y acceso a la base de datos mediante consultas preparadas (PDO), previniendo vulnerabilidades como SQL Injection y acceso no autorizado por historial del navegador.

6. **Coordinar el trabajo de cuatro integrantes** mediante una metodología ágil adaptada, distribuyendo las etapas de planificación, análisis, diseño, desarrollo e integración de manera equitativa y rastreable.

7. **Comparar conceptualmente** las implementaciones en PHP sobre base de datos con las implementaciones equivalentes en lenguaje C++, identificando similitudes algorítmicas y diferencias estructurales derivadas del entorno de ejecución.

---

## 4. Marco Teórico

### 4.1 Patrón de Arquitectura MVC (Modelo-Vista-Controlador)

El patrón MVC fue descrito por primera vez por Trygve Reenskaug en 1979 para el entorno Smalltalk-80 y ha sido adoptado de forma masiva en el desarrollo de aplicaciones web modernas. Su propósito central es la **separación de responsabilidades**: el Modelo gestiona los datos y la lógica de negocio; la Vista se encarga de la presentación y la interacción con el usuario; el Controlador actúa como intermediario, recibiendo las acciones del usuario, invocando la lógica del Modelo y seleccionando la Vista adecuada para la respuesta (Freeman & Freeman, 2020).

En el sistema HA&KU, la implementación se concretó de la siguiente manera:

- **Modelo (`models/`):** Las clases `Producto.php` y `Usuario.php` representan las entidades del dominio. Cada clase encapsula los atributos de la entidad, un método de validación de datos y métodos de conversión (`toArray()`, `fromArray()`) para facilitar la serialización JSON. El Modelo no contiene lógica de acceso a la base de datos; esta responsabilidad recae en los Controladores, siguiendo el patrón Active Record de manera simplificada.

- **Vista (`public/`):** El frontend está compuesto por archivos HTML5 estáticos (`index.html`, `dashboard.html`) vinculados a hojas de estilo CSS externas y scripts JavaScript. La única comunicación de la Vista con el servidor es a través de peticiones HTTP asíncronas (Fetch API) que consumen los endpoints de la API RESTful. Esta separación garantiza que el mismo backend podría ser consumido por una aplicación móvil u otro cliente sin cambio alguno.

- **Controlador (`controllers/` + `api/`):** Los controladores (`AuthController.php`, `ProductoController.php`) contienen la lógica de negocio: autenticar usuarios, insertar o eliminar productos, invocar los algoritmos de ordenamiento y búsqueda, y devolver respuestas JSON. Los archivos de la capa `api/` actúan como *routers* que validan el método HTTP, verifican la sesión activa y delegan al controlador correspondiente.

Una ventaja clave de este diseño es que la **base de datos puede cambiarse completamente** sin tocar el frontend, y la **interfaz puede rediseñarse** sin afectar la lógica de negocio.

### 4.2 Bases de Datos Relacionales y el Modelo Entidad-Relación

Una base de datos relacional organiza la información en tablas (relaciones) cuyos datos están inter-relacionados mediante claves primarias y foráneas. El modelo relacional, formalizado por Codd (1970) y descrito exhaustivamente por Date (2004), garantiza la **integridad referencial**, permite **consultas declarativas** mediante SQL y asegura las propiedades ACID (Atomicidad, Consistencia, Aislamiento y Durabilidad) en las transacciones.

Para el sistema HA&KU se definieron dos entidades principales:

**`usuarios`:** almacena las credenciales y el nombre completo de las personas que tienen acceso al sistema. La contraseña se persiste como un *hash* Bcrypt generado con `password_hash()` de PHP, lo que garantiza que ningún valor en texto plano sea almacenado.

**`productos`:** almacena el inventario con los campos `id` (clave primaria auto-incremental), `posicion` (entero para simular lista enlazada), `codigo` (identificador único de negocio), `nombre`, `precio`, `stock`, `stock_minimo`, `categoria` y `marca_proveedor`.

Los índices definidos sobre `posicion`, `codigo` y `nombre` aceleran las consultas de ordenamiento y búsqueda a nivel de base de datos, complementando los algoritmos implementados en la capa de aplicación.

### 4.3 Simulación de Lista Enlazada en Base de Datos Relacional

Una **lista enlazada** es una estructura de datos lineal en la que cada elemento (nodo) contiene un dato y un apuntador al siguiente nodo. Sus operaciones características son:

- **Inserción en cabeza:** O(1) — simplemente se actualiza el puntero `head`.
- **Inserción en cola:** O(n) sin puntero al tail, O(1) si se mantiene.
- **Inserción en posición k:** O(k) — se recorre hasta el nodo precursor.
- **Eliminación desde cabeza:** O(1).
- **Búsqueda:** O(n) en el caso general.

Las bases de datos relacionales no contemplan nativamente una estrutura equivalente a la lista enlazada. Los registros de una tabla no tienen un orden garantizado salvo el especificado explícitamente en la cláusula `ORDER BY`. Ante esta limitación, el equipo adoptó la siguiente estrategia de diseño (detallada también en el campo `posicion` del esquema SQL):

> **Campo `posicion` (INT, NOT NULL):** Cada producto almacena un número entero que representa su lugar en la secuencia lógica. La consulta `SELECT * FROM productos ORDER BY posicion ASC` reproduce fielmente el recorrido de una lista enlazada desde cabeza hasta cola.

Las operaciones de inserción se traducen de la siguiente manera:

**Inserción en cabeza:**
```sql
-- 1. Desplazar todos los nodos existentes
UPDATE productos SET posicion = posicion + 1;
-- 2. Insertar el nuevo nodo en posición 1
INSERT INTO productos (..., posicion) VALUES (..., 1);
```
Complejidad transaccional: O(n) por la actualización masiva.

**Inserción en cola:**
```sql
-- 1. Calcular la siguiente posición
SELECT MAX(posicion) + 1 AS nueva_pos FROM productos;
-- 2. Insertar en la posición calculada
INSERT INTO productos (..., posicion) VALUES (..., :nueva_pos);
```
Complejidad transaccional: O(1) si el MAX está indexado.

**Inserción en posición k:**
```sql
-- 1. Desplazar nodos en posiciones >= k
UPDATE productos SET posicion = posicion + 1 WHERE posicion >= :k;
-- 2. Insertar en posición k
INSERT INTO productos (..., posicion) VALUES (..., :k);
```

**Eliminación:**
```sql
-- 1. Eliminar el registro
DELETE FROM productos WHERE posicion = :pos;
-- 2. Compactar posiciones para evitar huecos
UPDATE productos SET posicion = posicion - 1 WHERE posicion > :pos;
```

Esta aproximación permite mantener la semántica de la lista enlazada de forma persistente y transaccional, algo que no es posible con listas enlazadas clásicas en memoria, que son volátiles por naturaleza. Weiss (2013) señala que "la elección de una estructura de datos adecuada determina la eficiencia de los algoritmos que operan sobre ella"; en este caso, el campo `posicion` es la estructura de datos que habilita la semántica de lista enlazada dentro del modelo relacional.

### 4.4 Algoritmos de Ordenamiento

#### 4.4.1 Bubble Sort

El Bubble Sort (ordenamiento de burbuja) es uno de los algoritmos de ordenamiento más simples. Funciona comparando pares de elementos adyacentes e intercambiándolos si están en el orden incorrecto, repitiendo el proceso hasta que el arreglo esté ordenado. Su nombre proviene del efecto visual de los valores mayores "burbujear" hacia el final del arreglo en cada pasada.

**Análisis de complejidad:**
- **Peor caso:** O(n²) — arreglo ordenado en orden inverso.
- **Caso promedio:** O(n²).
- **Mejor caso:** O(n) — arreglo ya ordenado (con la optimización de bandera de intercambio).
- **Espacio:** O(1) — *in-place*, no requiere memoria adicional.
- **Estabilidad:** Estable — no altera el orden relativo de elementos iguales.

**Implementación característica en PHP (extracto del proyecto):**
```php
public static function bubbleSortPorPrecio(&$productos) {
    $n = count($productos);
    for ($i = 0; $i < $n - 1; $i++) {
        $huboIntercambio = false;
        for ($j = 0; $j < $n - 1 - $i; $j++) {
            if ($productos[$j]->precio > $productos[$j + 1]->precio) {
                $temp = $productos[$j];
                $productos[$j] = $productos[$j + 1];
                $productos[$j + 1] = $temp;
                $huboIntercambio = true;
            }
        }
        if (!$huboIntercambio) break; // Optimización temprana
    }
}
```

#### 4.4.2 Quick Sort

El Quick Sort es un algoritmo de ordenamiento eficiente basado en la estrategia **Divide y Conquista**, desarrollado por C.A.R. Hoare en 1960. Selecciona un elemento como *pivote* y reordena el arreglo de manera que todos los elementos menores al pivote queden a su izquierda y todos los mayores a su derecha. Luego se aplica recursivamente a cada subconjunto.

**Análisis de complejidad:**
- **Peor caso:** O(n²) — cuando el pivote es siempre el mínimo o máximo (arreglo ya ordenado con pivote en extremo).
- **Caso promedio:** O(n log n).
- **Mejor caso:** O(n log n).
- **Espacio:** O(log n) en la pila de recursión (caso promedio).
- **Estabilidad:** No estable en su forma básica.

**Implementación característica en PHP (extracto del proyecto):**
```php
public static function quickSortPorPrecio(&$productos, $low = 0, $high = null) {
    if ($high === null) $high = count($productos) - 1;
    if ($low < $high) {
        $pi = self::particionPrecio($productos, $low, $high);
        self::quickSortPorPrecio($productos, $low, $pi - 1);
        self::quickSortPorPrecio($productos, $pi + 1, $high);
    }
}

private static function particionPrecio(&$arr, $low, $high) {
    $pivot = $arr[$high]->precio;
    $i = $low - 1;
    for ($j = $low; $j < $high; $j++) {
        if ($arr[$j]->precio <= $pivot) {
            $i++;
            $temp = $arr[$i]; $arr[$i] = $arr[$j]; $arr[$j] = $temp;
        }
    }
    $temp = $arr[$i + 1]; $arr[$i + 1] = $arr[$high]; $arr[$high] = $temp;
    return $i + 1;
}
```

### 4.5 Algoritmos de Búsqueda

#### 4.5.1 Búsqueda Lineal

La búsqueda lineal (o secuencial) recorre cada elemento de la colección comparándolo con el valor buscado hasta encontrarlo o agotar la lista. Es el algoritmo de búsqueda más simple y funciona sobre cualquier colección, independientemente de su orden.

**Análisis de complejidad:**
- **Peor caso:** O(n) — el elemento está al final o no existe.
- **Caso promedio:** O(n/2) ≈ O(n).
- **Mejor caso:** O(1) — el elemento está en la primera posición.

#### 4.5.2 Búsqueda Binaria

La búsqueda binaria es un algoritmo de alta eficiencia que opera sobre colecciones **previamente ordenadas**. En cada paso divide el espacio de búsqueda a la mitad, comparando el elemento del centro con el valor buscado y descartando la mitad que no puede contenerlo.

**Análisis de complejidad:**
- **Peor caso:** O(log n).
- **Caso promedio:** O(log n).
- **Mejor caso:** O(1) — el elemento está en el centro.
- **Requisito:** colección ordenada por el campo de búsqueda.

**Comparación de rendimiento práctico:**

| n (productos) | Búsqueda Lineal (comparaciones) | Búsqueda Binaria (comparaciones) |
|:---:|:---:|:---:|
| 10 | 10 | 4 |
| 100 | 100 | 7 |
| 1,000 | 1,000 | 10 |
| 1,000,000 | 1,000,000 | 20 |

### 4.6 Comparación: Implementación en PHP vs. C++

El estudio de los algoritmos implementados en PHP cobra mayor profundidad al compararlos con su equivalente en C++, lenguaje utilizado habitualmente en los cursos de algoritmos y estructuras de datos.

#### 4.6.1 Semejanzas algorítmicas

La **lógica algorítmica es idéntica** independientemente del lenguaje. El pseudocódigo de Bubble Sort descrito por Cormen et al. (2022) se traduce de la misma forma en C++ y en PHP: dos bucles anidados, una comparación y un intercambio de variables mediante una variable temporal. La notación Big-O derivada —O(n²)— es igualmente válida en ambos contextos, ya que la complejidad describe el comportamiento asintótico del algoritmo, no del lenguaje.

Lo mismo aplica para Quick Sort (recursión + partición) y para ambos algoritmos de búsqueda. La esencia matemática no cambia.

#### 4.6.2 Diferencias estructurales y de entorno

| Aspecto | C++ | PHP (este proyecto) |
|---------|-----|---------------------|
| **Tipo de ejecución** | Compilado, binario nativo | Interpretado, entorno web |
| **Gestión de memoria** | Manual (punteros, `new`/`delete`) | Automática (Garbage Collector) |
| **Estructura de datos** | Arreglos de structs / punteros de noja | Arreglos de objetos PHP |
| **Origen de los datos** | Arreglo declarado en código | Consulta SQL → PHP → array |
| **Persistencia** | RAM, volátil | Base de datos MySQL, persistente |
| **Lista enlazada** | Punteros explícitos (`struct Nodo { int dato; Nodo* sig; }`) | Campo `posicion` en tabla SQL |
| **Rendimiento absoluto** | Muy alto (nanosegundos por operación) | Menor (incluye overhead de PHP + red + MySQL) |
| **Paralelismo de inserción O(n)** | Un puntero de ajuste | Un `UPDATE` con cláusula WHERE |

**En C++, la lista enlazada real:**
```cpp
struct Nodo {
    int codigo;
    string nombre;
    double precio;
    Nodo* siguiente;
};

void insertarAlInicio(Nodo*& cabeza, Nodo* nuevo) {
    nuevo->siguiente = cabeza; // O(1)
    cabeza = nuevo;
}
```

**En el proyecto PHP/MySQL, la lista enlazada simulada:**
```php
// Equivalente conceptual — O(n) por la actualización
$conn->exec("UPDATE productos SET posicion = posicion + 1");
$conn->exec("INSERT INTO productos (..., posicion) VALUES (..., 1)");
```

La diferencia crítica es que en C++ la inserción en cabeza es O(1) gracias a los punteros, mientras que en la versión persistida en SQL es O(n) porque se debe actualizar la posición de todos los nodos existentes. Sin embargo, el beneficio que ofrece SQL —persistencia, concurrencia, atomicidad y consultas declarativas— justifica este costo en el contexto de un sistema de información.

En cuanto a la memoria, en C++ el programador es responsable de liberar cada nodo con `delete`, mientras que PHP gestiona la memoria automáticamente. Esta diferencia hace que el código PHP sea menos propenso a *memory leaks* pero tampoco permite el nivel de optimización que un programador experto en C++ puede lograr.

---

### 4.7 API REST (Representational State Transfer)

#### 4.7.1 Fundamentos teóricos

REST es un **estilo arquitectónico** para sistemas distribuidos, definido por Roy T. Fielding en su tesis doctoral del año 2000. No es un protocolo ni un estándar, sino un conjunto de seis restricciones de diseño que, cuando se respetan, producen sistemas web altamente desacoplados, escalables e interoperables (Fielding, 2000):

1. **Cliente-Servidor:** La interfaz de usuario (cliente) y el almacenamiento de datos (servidor) están separados; cada uno puede evolucionar independientemente.
2. **Sin estado (Stateless):** Cada petición HTTP del cliente al servidor debe contener toda la información necesaria para ser procesada. El servidor no guarda el estado de la conversación entre llamadas. En el sistema HA&KU, esto se cumple porque cada petición incluye automáticamente la *cookie* de sesión PHP gracias al parámetro `credentials: 'include'` de Fetch API.
3. **Caché:** Las respuestas deben indicar si pueden o no ser almacenadas en caché. El sistema declara `Cache-Control: no-cache` en las rutas protegidas para evitar que datos sensibles sean servidos desde la caché del navegador.
4. **Interfaz uniforme:** Todos los recursos se identifican mediante URIs y se manipulan a través de los métodos estándar de HTTP (GET, POST, PUT, DELETE).
5. **Sistema en capas:** El cliente no necesita saber si se conecta directamente al servidor final o a un intermediario (proxy, balanceador de carga).
6. **Código bajo demanda (opcional):** El servidor puede enviar código ejecutable al cliente (por ejemplo, scripts JavaScript).

La comunicación entre el frontend y el backend del sistema HA&KU sigue fielmente el patrón REST: el cliente JavaScript realiza peticiones HTTP con *payloads* en formato **JSON** (JavaScript Object Notation) y el servidor PHP responde con estructuras JSON de la forma `{"exito": true/false, "mensaje": "...", "datos": {...}}`. Este contrato uniforme hace que el frontend sea completamente independiente del backend: cualquier cambio en la implementación PHP no afecta al JavaScript mientras se respete la forma de la respuesta.

#### 4.7.2 Verbos HTTP y su uso en el proyecto

| Verbo HTTP | Semántica REST | Uso en HA&KU |
|-----------|----------------|--------------|
| `GET` | Recuperar un recurso sin modificarlo | Obtener la lista de productos |
| `POST` | Crear un nuevo recurso o ejecutar una acción | Insertar producto, buscar, ordenar, login, seed/wipe |
| `PUT` | Actualizar un recurso existente por completo | Editar datos de un producto |
| `DELETE` | Eliminar un recurso | Eliminar producto por código, inicio o final |

#### 4.7.3 Funcionamiento de cada endpoint en el proyecto

Todos los archivos de la carpeta `api/` siguen la misma estructura interna: (1) verifican el método HTTP recibido, (2) validan que exista una sesión PHP activa, (3) decodifican el cuerpo JSON de la petición, (4) delegan al controlador correspondiente y (5) retornan una respuesta JSON con código HTTP apropiado.

---

**`api/login.php` — Autenticación de usuario**

- **Método:** `POST`
- **Requiere sesión:** No (es la puerta de entrada)
- **Payload de entrada:**
```json
{ "username": "ADMIN", "password": "ADMIN" }
```
- **Flujo interno:**
  1. Decodifica el JSON del cuerpo de la petición (`php://input`)
  2. Crea una instancia de `AuthController`
  3. Llama a `AuthController::login($username, $password)`
  4. El controlador busca el usuario en la BD y verifica la contraseña con `password_verify()` (Bcrypt)
  5. Si es correcto, establece las variables de sesión PHP: `$_SESSION['usuario_id']`, `$_SESSION['logged_in'] = true`
- **Respuesta exitosa (HTTP 200):**
```json
{ "exito": true, "mensaje": "Login exitoso", "usuario": { "id": 14, "username": "ADMIN", "nombre_completo": "Super Administrador" } }
```
- **Respuesta fallida (HTTP 401):**
```json
{ "exito": false, "mensaje": "Usuario o contraseña incorrectos" }
```

---

**`api/logout.php` — Cierre de sesión**

- **Método:** `POST`
- **Requiere sesión:** Sí
- **Payload:** Ninguno
- **Flujo interno:**
  1. Llama a `AuthController::logout()`
  2. El controlador borra todas las variables de sesión (`$_SESSION = []`) y destruye la sesión PHP (`session_destroy()`)
  3. Desde el frontend, el JavaScript complementa con `localStorage.removeItem('logged_in')` y redirige con `window.location.replace('index.html')`
- **Por qué es crítico:** Sin este endpoint, solo se limpiaría el `localStorage` del navegador, pero la sesión PHP permanecería activa en el servidor. Cualquier petición a `api/productos.php` seguiría siendo autorizada, lo que constituye una vulnerabilidad de seguridad.
- **Respuesta (HTTP 200):**
```json
{ "exito": true, "mensaje": "Sesión cerrada correctamente" }
```

---

**`api/productos.php` — CRUD completo de productos**

Este endpoint es el más completo del sistema; maneja cuatro métodos HTTP distintos.

- **GET — Obtener lista de productos:**
  - Llama a `ProductoController::obtenerTodos()`
  - Ejecuta `SELECT * FROM productos ORDER BY posicion ASC`
  - Retorna el arreglo completo de productos serializado a JSON

- **POST — Insertar producto:**
  - Payload:
  ```json
  { "codigo": 5001, "nombre": "Laptop Dell", "precio": 15999.99, "tipo": "inicio", "stock": 10, "stock_minimo": 3, "categoria": "Electrónica", "marca_proveedor": "Dell" }
  ```
  - El campo `"tipo"` determina qué método del controlador se invoca: `insertarInicio()`, `insertarFinal()` o `insertarPosicion()`
  - Cada variante actualiza el campo `posicion` de los registros existentes antes de insertar

- **PUT — Actualizar producto:**
  - Payload:
  ```json
  { "id": 7, "codigo": 5001, "nombre": "Laptop Dell XPS", "precio": 18000.00, "stock": 8, "stock_minimo": 2, "categoria": "Electrónica", "marca_proveedor": "Dell" }
  ```
  - Llama a `ProductoController::actualizarProducto($id, $datos)`
  - Ejecuta un `UPDATE` con los campos modificados

- **DELETE — Eliminar producto:**
  - Payload:
  ```json
  { "tipo": "codigo", "codigo": 5001 }
  ```
  - El campo `"tipo"` puede ser `"inicio"`, `"final"` o `"codigo"`
  - Después de eliminar el registro, compacta las posiciones con `UPDATE productos SET posicion = posicion - 1 WHERE posicion > :pos`

---

**`api/buscar.php` — Búsqueda de productos**

- **Método:** `POST`
- **Payload de entrada:**
```json
{ "algoritmo": "binaria", "campo": "codigo", "valor": "5001" }
```
- **Flujo interno:**
  1. Recupera todos los productos con `ProductoController::obtenerTodos()`
  2. Para búsqueda binaria, el arreglo ya viene ordenado por `posicion`; si se busca por código, se reordena primero por código con Quick Sort
  3. Registra el tiempo de inicio con `microtime(true)`
  4. Llama a `Busqueda::busquedaBinariasPorCodigo($productos, $valor)` o la variante seleccionada
  5. Calcula el tiempo transcurrido en milisegundos
- **Respuesta exitosa:**
```json
{ "exito": true, "producto": { "id": 6, "codigo": 5001, "nombre": "Laptop Dell", "precio": 15999.99 }, "tiempo_ms": 0.043, "comparaciones": 4 }
```
- **Respuesta sin resultado:**
```json
{ "exito": false, "mensaje": "Producto no encontrado", "tiempo_ms": 0.038 }
```

---

**`api/ordenar.php` — Ordenamiento de productos**

- **Método:** `POST`
- **Payload de entrada:**
```json
{ "algoritmo": "quicksort", "campo": "precio", "orden": "asc" }
```
- **Flujo interno:**
  1. Recupera todos los productos de la BD
  2. Registra el tiempo de inicio
  3. Aplica el algoritmo indicado: `Ordenamiento::quickSortPorPrecio($productos)` o sus variantes por nombre o stock
  4. Si `orden === "desc"`, invierte el arreglo resultante
  5. Calcula el tiempo transcurrido
- **Nota de diseño:** El ordenamiento opera **en memoria PHP** sobre el arreglo de objetos ya cargado; no ejecuta ningún `ORDER BY` en SQL. Esto es intencional: el propósito es demostrar y medir los algoritmos de ordenamiento, no delegar el trabajo al motor de base de datos.
- **Respuesta:**
```json
{ "exito": true, "productos": [ {...}, {...} ], "tiempo_ms": 0.61, "algoritmo": "quicksort", "campo": "precio" }
```

---

**`api/admin_db.php` — Administración de la base de datos**

- **Método:** `POST`
- **Payload para Seed:**
```json
{ "accion": "seed", "cantidad": 50 }
```
- **Payload para Wipe:**
```json
{ "accion": "wipe", "password": "ADMIN" }
```
- **Flujo Seed:**
  1. Genera `$cantidad` (20, 50 o 100) objetos `Producto` con datos variados y realistas (nombres, marcas, categorías y precios generados con variación aleatoria controlada)
  2. Los inserta uno a uno al final de la lista enlazada simulada
- **Flujo Wipe:**
  1. Verifica la contraseña contra el hash Bcrypt del usuario ADMIN en la BD
  2. Si es válida, ejecuta `DELETE FROM productos` y reinicia los contadores de posición
  3. Si es inválida, retorna HTTP 403
- **Respuesta Seed:**
```json
{ "exito": true, "mensaje": "Se insertaron 50 productos de prueba correctamente" }
```

---

## 5. Desarrollo

### 5.1 Metodología Ágil Adaptada

El equipo de cuatro integrantes adoptó una **metodología ágil ligera**, inspirada en los principios de Scrum (Schwaber & Sutherland, 2020) y adaptada a la escala y duración del proyecto académico. La metodología se estructuró en cuatro roles y cinco fases iterativas.

**Roles del equipo:**

| Rol | Responsabilidad Principal |
|-----|---------------------------|
| **Product Owner (rotativo)** | Definir prioridades del backlog y criterios de aceptación |
| **Tech Lead de Backend** | Arquitectura MVC, APIs, algoritmos PHP |
| **Tech Lead de Frontend** | Interfaz de usuario, JavaScript, CSS |
| **QA / Integrador** | Pruebas, integración de ramas, documentación |

Los roles de Product Owner y QA rotaron entre los integrantes en cada sprint para garantizar que todos desarrollasen una visión completa del sistema.

**Herramientas de coordinación:**
- **Control de versiones:** Git (repositorio local)
- **Tablero Kanban:** Columnas *Backlog | En progreso | En revisión | Hecho*
- **Reuniones:** Daily stand-up de 10 minutos; retrospectiva al final de cada sprint de una semana

### 5.2 Fase 1: Planificación

La fase de planificación produjo los siguientes artefactos:

**Backlog inicial (historias de usuario prioritarias):**

1. *Como usuario, quiero iniciar sesión con usuario y contraseña para acceder al sistema de forma segura.*
2. *Como usuario, quiero ver la lista de productos ordenada por su posición en la lista enlazada simulada.*
3. *Como usuario, quiero insertar un producto al inicio, al final o en una posición específica.*
4. *Como usuario, quiero eliminar un producto del inicio, del final o por su código.*
5. *Como usuario, quiero buscar un producto por código o nombre usando búsqueda lineal o binaria.*
6. *Como usuario, quiero ordenar los productos por precio o nombre usando Bubble Sort o Quick Sort.*
7. *Como administrador, quiero verificar el tiempo de ejecución de cada algoritmo en milisegundos.*
8. *Como administrador, quiero poblar la base de datos con productos de prueba y limpiarla completamente.*

**Estimación y priorización:** Las historias 1–4 se consideraron *Must Have* (sprint 1); las historias 5–7, *Should Have* (sprint 2); la historia 8, *Nice to Have* (sprint 3).

### 5.3 Fase 2: Análisis de Requisitos

#### 5.3.1 Requisitos Funcionales

| ID | Requisito | Prioridad |
|----|-----------|-----------|
| RF-01 | El sistema permite autenticación mediante usuario y contraseña hasheada | Alta |
| RF-02 | El sistema inserta productos en posición 1, última o arbitraria | Alta |
| RF-03 | El sistema elimina productos por posición inicial, final o por código | Alta |
| RF-04 | El sistema ejecuta Bubble Sort y Quick Sort sobre los productos cargados | Alta |
| RF-05 | El sistema ejecuta Búsqueda Lineal y Búsqueda Binaria | Alta |
| RF-06 | El sistema muestra el tiempo de ejecución de cada algoritmo | Media |
| RF-07 | El sistema muestra alerta visual cuando el stock de un producto está bajo el mínimo | Media |
| RF-08 | El administrador puede insertar lotes de 20, 50 o 100 productos de prueba | Baja |
| RF-09 | El administrador puede vaciar la base de datos con contraseña de confirmación | Baja |
| RF-10 | El logout destruye la sesión PHP en el servidor | Alta |

#### 5.3.2 Requisitos No Funcionales

| ID | Requisito |
|----|-----------|
| RNF-01 | Todos los algoritmos deben implementarse manualmente, sin `sort()` o `array_search()` de PHP |
| RNF-02 | El acceso a la base de datos debe realizarse con PDO y *prepared statements* |
| RNF-03 | La arquitectura debe seguir el patrón MVC con separación de capas |
| RNF-04 | El frontend debe ser responsivo (funcionar en móvil y escritorio) |
| RNF-05 | El CSS debe estar separado en archivos externos (no estilos embebidos en HTML) |
| RNF-06 | El sistema debe prevenir el acceso al dashboard mediante el botón "Atrás" tras el logout |

### 5.4 Fase 3: Diseño

#### 5.4.1 Arquitectura del Sistema

```
┌────────────────────────────────────┐
│          NAVEGADOR (Cliente)       │
│   index.html / dashboard.html      │
│   CSS: login.css / dashboard.css   │
│   JS: auth.js / main.js / prods.js │
└─────────────────┬──────────────────┘
                  │ HTTP (Fetch API + JSON)
                  ▼
┌────────────────────────────────────┐
│        CAPA API (api/)             │
│  login.php   logout.php            │
│  productos.php  buscar.php         │
│  ordenar.php    admin_db.php       │
└──────────────┬─────────────────────┘
               │ Instancia
               ▼
┌────────────────────────────────────┐
│     CAPA DE CONTROLADORES          │
│  AuthController.php                │
│  ProductoController.php            │
│  + Ordenamiento.php / Busqueda.php │
└──────────────┬─────────────────────┘
               │ Manipula
               ▼
┌────────────────────────────────────┐
│        CAPA DE MODELOS             │
│  Producto.php    Usuario.php       │
└──────────────┬─────────────────────┘
               │ PDO (Prepared Statements)
               ▼
┌────────────────────────────────────┐
│   BASE DE DATOS MySQL              │
│   inventario_db                    │
│   tablas: productos, usuarios      │
└────────────────────────────────────┘
```

#### 5.4.2 Diagrama Entidad-Relación

```
+─────────────────────────+         +─────────────────────────+
│       usuarios          │         │        productos         │
+─────────────────────────+         +─────────────────────────+
│ PK  id          INT     │         │ PK  id          INT AI  │
│     username    VARCHAR │         │     posicion    INT      │
│     password    VARCHAR │         │     codigo      INT UQ   │
│     nombre_comp VARCHAR │         │     nombre      VARCHAR  │
│     fecha_crea  TIMESTAMP│        │     precio      DECIMAL  │
+─────────────────────────+         │     stock       INT      │
                                    │     stock_minimo INT     │
                                    │     categoria   VARCHAR  │
                                    │     marca_prov  VARCHAR  │
                                    │     fecha_crea  TIMESTAMP│
                                    │     fecha_mod   TIMESTAMP│
                                    +─────────────────────────+
```

*(Nota: la tabla de logs fue eliminada a petición del equipo durante el desarrollo para simplificar el sistema.)*

#### 5.4.3 Casos de Uso Principales

**CU-01: Iniciar Sesión**
- **Actor:** Usuario
- **Precondición:** El usuario existe en la tabla `usuarios`
- **Flujo principal:** El usuario ingresa credenciales → el sistema valida contra el hash Bcrypt → crea sesión PHP y establece `localStorage` → redirige al dashboard
- **Flujo alternativo:** Credenciales incorrectas → muestra mensaje de error con animación

**CU-02: Insertar Producto al Inicio**
- **Actor:** Usuario autenticado
- **Precondición:** Sesión PHP activa
- **Flujo principal:** Usuario llena el formulario → JS valida → Fetch POST al API → API verifica sesión → ProductoController actualiza posiciones y ejecuta INSERT → respuesta JSON → tabla de productos se recarga
- **Extensiones:** Si el código ya existe, el sistema retorna error 409

**CU-03: Ordenar Productos**
- **Actor:** Usuario autenticado
- **Flujo principal:** Usuario selecciona algoritmo y campo → Fetch POST al API de ordenamiento → API recupera todos los productos de BD → Ordenamiento::bubbleSort / quickSort → API retorna la lista ordenada en JSON → JS renderiza la tabla
- **Nota:** El ordenamiento es **visual** (no persiste en BD); el orden original se recupera con el botón de actualizar

**CU-04: Buscar Producto**
- **Actor:** Usuario autenticado
- **Flujo principal:** Usuario ingresa término y selecciona algoritmo → Fetch POST → API recupera todos los productos → Busqueda::busquedaLineal / busquedaBinaria → retorna el producto encontrado + tiempo de ejecución → JS muestra resultado resaltado

**CU-05: Cerrar Sesión**
- **Actor:** Usuario autenticado
- **Flujo principal:** Usuario hace clic en "Cerrar sesión" → JS llama `api/logout.php` → PHP destruye `$_SESSION` → JS limpia `localStorage` → `window.location.replace('index.html')`
- **Seguridad:** Las cabeceras `Cache-Control: no-store` y el evento `pageshow` impiden el acceso al dashboard por caché del navegador

#### 5.4.4 Diagrama de Clases (UML simplificado)

```
+──────────────────────+
│    «clase» Database  │
+──────────────────────+
│ -host: string        │
│ -db_name: string     │
│ -conn: PDO           │
+──────────────────────+
│ +getConnection(): PDO│
+──────────────────────+
         △
         │ usa
+──────────────────────────+
│  «clase» ProductoController│
+──────────────────────────+
│ -conn: PDO              │
+──────────────────────────+
│ +insertarInicio()        │
│ +insertarFinal()         │
│ +insertarPosicion()      │
│ +eliminarInicio()        │
│ +eliminarFinal()         │
│ +eliminarPorCodigo()     │
│ +obtenerTodos()          │
│ +actualizarProducto()    │
+──────────────────────────+
         │ opera sobre
+────────────────────────+
│  «clase» Producto      │
+────────────────────────+
│ +id: int               │
│ +posicion: int         │
│ +codigo: int           │
│ +nombre: string        │
│ +precio: float         │
│ +stock: int            │
│ +stock_minimo: int     │
│ +categoria: string     │
│ +marca_proveedor:string│
+────────────────────────+
│ +validar(): array      │
│ +toArray(): array      │
│ +fromArray(): Producto │
+────────────────────────+

+────────────────────────+     +──────────────────────+
│ «clase» Ordenamiento   │     │ «clase» Busqueda     │
+────────────────────────+     +──────────────────────+
│ +bubbleSortPorPrecio() │     │ +busquedaLinealCod() │
│ +bubbleSortPorNombre() │     │ +busquedaLinealNom() │
│ +quickSortPorPrecio()  │     │ +busquedaBinariaCod()│
│ +quickSortPorNombre()  │     │ +busquedaBinariaNom()│
+────────────────────────+     +──────────────────────+
```

### 5.5 Fase 4: Desarrollo

El desarrollo se realizó en tres sprints de una semana cada uno, con entregas funcionales al cierre de cada iteración.

**Sprint 1 — Fundamentos del sistema:**
- Configuración del entorno XAMPP y repositorio Git
- Creación del esquema de base de datos (`schema.sql`)
- Implementación de `Database.php`, `Producto.php`, `Usuario.php`
- Implementación de `AuthController.php` y `api/login.php`
- Prototipo de `index.html` con formulario de login funcional

**Sprint 2 — Algoritmos y CRUD:**
- Implementación de `Ordenamiento.php` (Bubble Sort y Quick Sort por precio y nombre)
- Implementación de `Busqueda.php` (Búsqueda Lineal y Binaria por código y nombre)
- Implementación completa de `ProductoController.php` (insertar, eliminar, actualizar, obtenerTodos)
- Desarrollo de los endpoints `api/productos.php`, `api/buscar.php`, `api/ordenar.php`
- Desarrollo del `dashboard.html` con los paneles de Lista, Insertar, Eliminar, Buscar y Ordenar
- Implementación del campo `posicion` para simular lista enlazada

**Sprint 3 — Refinamiento y seguridad:**
- Panel de Administración (`api/admin_db.php`): Seed (20/50/100 productos) y Wipe con contraseña
- Módulo de edición de productos (modal con PUT en `api/productos.php`)
- Gestión de stock y alertas visuales de stock bajo
- Rediseño de la interfaz al estilo *HA&KU* (tipografía, colores, animaciones)
- Separación de CSS en archivos externos (`login.css`, `dashboard.css`)
- Seguridad del logout: `api/logout.php`, `window.location.replace()`, cabeceras `no-cache`, evento `pageshow`
- Elaboración de `install.php`, `README.md` y `TrabajoFinal.md`

### 5.6 Fase 5: Pruebas

#### 5.6.1 Pruebas Unitarias (manuales)

Dado que el proyecto es académico y de escala pequeña, las pruebas unitarias se realizaron manualmente ejecutando cada función de los algoritmos con conjuntos de datos conocidos y verificando los resultados esperados.

**Prueba del Bubble Sort por precio:**

| Entrada | Resultado esperado | Resultado obtenido | Estado |
|---------|-------------------|-------------------|--------|
| [500, 100, 300, 50] | [50, 100, 300, 500] | [50, 100, 300, 500] | ✅ |
| [10] | [10] | [10] | ✅ |
| [] | [] | [] | ✅ |
| [5, 5, 5] | [5, 5, 5] | [5, 5, 5] | ✅ |

**Prueba de Búsqueda Binaria por código:**

| Arreglo (ordenado) | Código buscado | Resultado esperado | Estado |
|--------------------|---------------|-------------------|--------|
| [101, 102, 103, 104] | 103 | Producto con código 103 | ✅ |
| [101, 102, 103, 104] | 999 | null | ✅ |
| [101] | 101 | Producto con código 101 | ✅ |

#### 5.6.2 Pruebas de Integración

Las pruebas de integración verificaron la comunicación entre el frontend JavaScript y los endpoints PHP:

| Escenario | Método HTTP | Endpoint | Resultado Esperado | Estado |
|-----------|------------|----------|--------------------|--------|
| Login correcto | POST | `/api/login.php` | `{"exito": true, "usuario": {...}}` | ✅ |
| Login incorrecto | POST | `/api/login.php` | `{"exito": false, "mensaje": "..."}` | ✅ |
| Obtener productos | GET | `/api/productos.php` | Lista ordenada por posición | ✅ |
| Insertar al inicio | POST | `/api/productos.php` | Producto aparece en posición 1 | ✅ |
| Ordenar por precio | POST | `/api/ordenar.php` | Lista en orden ascendente de precio | ✅ |
| Buscar por código | POST | `/api/buscar.php` | Producto y tiempo de ejecución | ✅ |
| Logout | POST | `/api/logout.php` | Sesión destruida, redirige a login | ✅ |
| Acceso sin sesión | GET | `/api/productos.php` | HTTP 401 `{"exito": false}` | ✅ |

#### 5.6.3 Prueba de Rendimiento de Algoritmos

Se midió el tiempo de ejecución sobre conjuntos de datos de 20, 50 y 100 productos generados con el panel de administración del sistema:

| Algoritmo | n=20 | n=50 | n=100 |
|-----------|------|------|-------|
| Bubble Sort (precio) | ~0.2 ms | ~0.8 ms | ~2.1 ms |
| Quick Sort (precio) | ~0.1 ms | ~0.3 ms | ~0.6 ms |
| Búsqueda Lineal | ~0.05 ms | ~0.08 ms | ~0.12 ms |
| Búsqueda Binaria | ~0.02 ms | ~0.03 ms | ~0.04 ms |

*Nota: Los tiempos incluyen el overhead de PHP y de la consulta SQL inicial para cargar los datos. Los valores absolutos son más altos que en C++, pero la **relación relativa** entre algoritmos sigue la predicción teórica de la notación Big-O.*

---

## 6. Conclusiones

El desarrollo del Sistema de Inventario HA&KU permitió al equipo transitar desde el estudio teórico de los algoritmos hacia su implementación práctica en un entorno con restricciones reales. Las conclusiones más relevantes del proceso son las siguientes:

**1. Los algoritmos son independientes del lenguaje, pero el entorno condiciona su rendimiento.** La implementación de Bubble Sort en PHP y en C++ es lógicamente idéntica; sin embargo, el tiempo de ejecución absoluto es significativamente mayor en PHP debido al overhead del intérprete, la serialización de objetos y el acceso a la base de datos. Este hallazgo ilustra la importancia de distinguir entre complejidad **algorítmica** (notación Big-O) y rendimiento **práctico** del sistema.

**2. La simulación de lista enlazada en SQL es viable y útil, pero con compromisos.** El campo `posicion` permitió replicar fielmente la semántica de inserción y eliminación de una lista enlazada con la ventaja de la persistencia. El costo es que la inserción en cabeza es O(n) en términos de operaciones SQL, a diferencia de O(1) con punteros en C++. Para inventarios de escala modesta, este costo es aceptable; a escala industrial, se optaría por otras estrategias (e.g., listas *skip-list* en Redis o columnas de orden fraccionario).

**3. La arquitectura MVC facilita el trabajo colaborativo.** Al asignar a cada integrante una capa clara del sistema —backend, frontend, algoritmos, integración— se redujeron los conflictos de código y se aumentó la cohesión del proyecto. La API RESTful actuó como contrato entre el frontend y el backend, permitiendo el desarrollo paralelo de ambas capas.

**4. La seguridad debe diseñarse desde el inicio, no añadirse al final.** La experiencia con el bug del botón "Atrás" que permitía acceder al dashboard tras el logout reveló que una autenticación solo en el cliente (localStorage) es insuficiente. La incorporación de `api/logout.php` —que destruye la sesión PHP en el servidor— fue necesaria para garantizar que las APIs no respondan a usuarios no autenticados, independientemente del estado del navegador.

**5. La metodología ágil adaptada resultó efectiva a escala académica.** Los sprints de una semana con roles rotativos permitieron avanzar de manera ordenada, visibilizar el progreso y ajustar prioridades cuando surgieron imprevistos técnicos. La práctica de stand-ups cortos mantuvo a todos los integrantes informados del estado del proyecto sin consumir tiempo excesivo.

En síntesis, el proyecto demostró que el análisis de algoritmos no es un ejercicio abstracto sino una herramienta de diseño que guía decisiones arquitectónicas concretas: qué estructura de datos persistir, qué algoritmo ejecutar en qué capa del sistema y cómo medir y comunicar el rendimiento al usuario. Estas competencias son transferibles directamente al ejercicio profesional de la ingeniería en computación.

---

## 7. Bibliografía y Referencias

Aho, A. V., Hopcroft, J. E., & Ullman, J. D. (1983). *Data structures and algorithms*. Addison-Wesley.

Cormen, T. H., Leiserson, C. E., Rivest, R. L., & Stein, C. (2022). *Introduction to algorithms* (4th ed.). MIT Press.

Date, C. J. (2004). *An introduction to database systems* (8th ed.). Pearson Addison-Wesley.

Freeman, E., & Freeman, E. (2020). *Head first design patterns: Building extensible and maintainable object-oriented software* (2nd ed.). O'Reilly Media.

Hoare, C. A. R. (1962). Quicksort. *The Computer Journal*, *5*(1), 10–16. https://doi.org/10.1093/comjnl/5.1.10

Knuth, D. E. (1998). *The art of computer programming: Vol. 3. Sorting and searching* (2nd ed.). Addison-Wesley.

Pressman, R. S., & Maxim, B. R. (2021). *Software engineering: A practitioner's approach* (9th ed.). McGraw-Hill Education.

Schwaber, K., & Sutherland, J. (2020). *The Scrum guide: The definitive guide to Scrum — The rules of the game*. Scrum.org. https://scrumguides.org/docs/scrumguide/v2020/2020-Scrum-Guide-US.pdf

Sedgewick, R., & Wayne, K. (2011). *Algorithms* (4th ed.). Addison-Wesley Professional.

Weiss, M. A. (2013). *Data structures and algorithm analysis in C++* (4th ed.). Pearson.

---

*Documento elaborado como trabajo final para la materia de Análisis de Algoritmos.*  
*Ingeniería en Computación — Marzo 2026.*
