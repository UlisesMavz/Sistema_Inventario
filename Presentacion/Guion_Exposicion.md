# Guión de Exposición Técnico: Sistema de Inventario HA&KU

*Guión estructurado por sección de diapositiva. Cada bloque integra la información técnica del documento de trabajo, redactada en lenguaje expositivo natural.*

---

## **ULISES** - Diapositiva 1/16 — Portada



## **HÉCTOR** - Diapositiva 2/16 — Justificación

"La teoría de algoritmos exige que el estudiante implemente, mida y compare, no solo que conozca el pseudocódigo. Este proyecto surge precisamente para cerrar esa brecha. Al trabajar con un sistema de inventario funcional —con autenticación, operaciones CRUD y una interfaz completa— los algoritmos operan sobre datos reales en MySQL, lo que introduce el concepto de **transferencia de datos entre capas**: el algoritmo no trabaja en RAM, sino en objetos PHP reconstruidos desde consultas SQL. Esto cambia el análisis de rendimiento respecto a la teoría clásica.

Adicionalmente, decidimos simular una lista enlazada mediante un campo `posicion` en la base de datos —en lugar de confiar en el orden de inserción implícito de SQL—, una técnica que no suele aparecer en los libros pero que es muy común en sistemas de producción donde se necesita un **orden personalizado persistente**."

---

## **KASS** - Diapositiva 3/16 — Objetivo General

"Nuestro objetivo general fue: diseñar, implementar y analizar un sistema web de gestión de inventario que demuestre la aplicación práctica de algoritmos clásicos de **ordenamiento y búsqueda** sobre una estructura de datos persistida en una **base de datos relacional**, empleando **arquitectura MVC** y **metodología ágil colaborativa**. En otras palabras, no buscamos solo que el sistema funcionara, sino que cada decisión arquitectónica fuera demostrable y medible."

---

## **HÉCTOR** - Diapositiva 4/16 — Objetivos Particulares

"Para lograrlo, nos fijamos seis objetivos técnicos precisos:

Primero, implementar Bubble Sort, Quick Sort, Búsqueda Lineal y Búsqueda Binaria **en PHP puro**, sin usar funciones nativas de ordenamiento como `sort()` para demostrar el conocimiento real de la lógica interna de cada algoritmo.

Segundo, simular el comportamiento de una **lista enlazada en MySQL** con un campo `posicion` entero, replicando las operaciones de inserción en cabeza, en cola y en posición arbitraria.

Tercero, **medir el tiempo de ejecución en milisegundos** de cada operación usando `microtime(true)` y presentar ese dato al usuario en la interfaz.

Cuarto, diseñar una **arquitectura MVC limpia** con una API RESTful como capa de comunicación entre el frontend JavaScript y el backend PHP.

Quinto, **aplicar principios de seguridad**: consultas preparadas con PDO para prevenir SQL Injection, y una gestión de sesiones robusta con cierre de sesión en servidor que impide acceder al dashboard por historial del navegador.

Sexto, usar una **metodología ágil adaptada** para coordinar el trabajo de los cuatro integrantes del equipo."

---

## **ALAN** - Diapositiva 5/16 — Diseño de Casos de Uso

"En la fase de diseño modelamos las interacciones principales del sistema. Los casos de uso más relevantes son cinco:

**CU-01** — El usuario inicia sesión: ingresa credenciales, el sistema valida contra el hash Bcrypt en la base de datos, crea la sesión PHP y redirige al dashboard.

**CU-02** — Insertar producto: el usuario llena un formulario, JavaScript hace un `POST` al API, el API verifica la sesión activa y `ProductoController` actualiza posiciones y ejecuta el `INSERT`.

**CU-03** — Ordenar productos: el usuario elige algoritmo y campo, el API recupera todos los productos, el algoritmo los ordena **en memoria PHP** y devuelve la lista —sin modificar la BD— como JSON que el JS renderiza en la tabla.

**CU-04** — Buscar producto: `GET` la lista completa, se aplica Búsqueda Lineal o Binaria, y se devuelve el producto junto con el tiempo de ejecución y el número de comparaciones realizadas.

**CU-05** — Cerrar sesión: el servidor destruye `$_SESSION` con `session_destroy()` y el cliente limpia el `localStorage`, además de configurar cabeceras `Cache-Control: no-store` y el evento `pageshow` para impedir el acceso al dashboard por caché del navegador. Esta fue una lección crítica: una autenticación solo en el cliente es insuficiente."

---

## **ULISES** - Diapositiva 6/16 — Patrón de Arquitectura MVC

"El sistema se construyó bajo el patrón MVC así:

La **Vista** es el frontend — archivos HTML5 estáticos (`index.html`, `dashboard.html`) vinculados a CSS externos y scripts JavaScript. Toda su comunicación con el servidor ocurre mediante **Fetch API** de forma asíncrona. No existe PHP mezclado con HTML.

El **Controlador** comprende los archivos de la carpeta `controllers/` y `api/`. Los controladores `AuthController.php` y `ProductoController.php` contienen la lógica de negocio: autenticar usuarios, insertar productos, invocar los algoritmos. Los archivos `api/` actúan como *routers*: validan el método HTTP, verifican la sesión activa y delegan al controlador.

El **Modelo** son las clases `Producto.php` y `Usuario.php`. Encapsulan los atributos de cada entidad, métodos de validación (`validar()`), y métodos de conversión `toArray()` y `fromArray()` para facilitar la serialización JSON.

Una ventaja arquitectónica clave: la **base de datos puede cambiarse completamente** sin tocar el frontend, y la **interfaz puede rediseñarse** sin afectar la lógica de negocio."

---

## **ULISES** - Diapositiva 7/16 — Base de Datos Relacional y Modelo E-R

"Usamos **MySQL** como motor de persistencia, que nos garantiza las propiedades **ACID**: Atomicidad, Consistencia, Aislamiento y Durabilidad. Eso significa que si una operación falla a mitad, la base de datos no queda en un estado inconsistente.

Antes de ver las tablas, conviene definir tres conceptos clave del modelo relacional:

**Llave Primaria (Primary Key):** Es un campo o conjunto de campos que identifica de forma única cada registro en una tabla. Ningún valor puede repetirse ni ser nulo. Piénsenlo como el número de control de cada estudiante: no puede haber dos iguales. En nuestro caso, la columna `id` de la tabla `productos` es una llave primaria auto-incremental —MySQL la genera y la incrementa solo cada vez que insertamos un producto nuevo.

**Llave Foránea (Foreign Key):** Es un campo en una tabla que apunta a la llave primaria de otra tabla, estableciendo una relación entre ellas e impidiendo datos huérfanos. Si en una tabla de 'Ventas' quiero registrar qué producto se vendió, pongo la `id` del producto como llave foránea. Si intentas insertar una venta con un `id_producto` que no existe en `productos`, el motor lo rechaza automáticamente. En nuestro diseño actual no implementamos llaves foráneas porque el sistema no requería entidades relacionadas entre sí de esa manera —`usuarios` y `productos` son independientes, no existe una tabla de ventas o historial que los vincule.

**Índices:** Un índice es una estructura de datos auxiliar que el motor de base de datos construye y mantiene para acelerar las búsquedas sobre un campo, de forma similar a como el índice de un libro te permite ir directo a la página sin leer todo. Sin índice, una consulta `SELECT * FROM productos WHERE codigo = 5001` revisa **todos** los registros de la tabla (O(n)). Con un índice sobre `codigo`, la búsqueda es logarítmica.

En el sistema HA&KU definimos índices sobre tres campos específicos:
- **`posicion`:** porque todas las consultas de lista conectadas a la simulación de lista enlazada ordenan por este campo con `ORDER BY posicion ASC`.
- **`codigo`:** porque las operaciones de búsqueda y eliminación por código hacen `WHERE codigo = :valor` constantemente.
- **`nombre`:** porque la búsqueda por nombre también necesita comparaciones rápidas.

Esto complementa directamente los algoritmos que implementamos: cuando el usuario pide Búsqueda Binaria, el arreglo ya llega de MySQL en el orden correcto (gracias al índice de `posicion`) sin costo extra de ordenamiento en el servidor.

Finalmente, la tabla `usuarios` almacena credenciales con la contraseña guardada como un *hash* **Bcrypt** generado con `password_hash()` de PHP —nunca en texto plano—, protegiéndonos contra ataques de fuerza bruta y tablas arcoíris. Y toda la comunicación con la base de datos se realiza exclusivamente mediante **PDO con prepared statements**, mitigando inyección SQL."


---

## **ULISES** -Diapositiva 8/16 — Simulación de Lista Enlazada en MySQL

"Este es el punto de diseño más singular del proyecto. Una lista enlazada clásica en C++ usa punteros: `struct Nodo { int codigo; Nodo* siguiente; }`. La inserción en cabeza tiene complejidad **O(1)** porque solo se actualiza un apuntador.

En una base de datos relacional, los registros no tienen orden garantizado. Para replicar la semántica de lista enlazada, añadimos el campo `posicion (INT)` a la tabla de productos. Así:

**Insertar en cabeza** — O(n): primero `UPDATE productos SET posicion = posicion + 1`, luego `INSERT ... posicion = 1`.

**Insertar al final** — O(1): `SELECT MAX(posicion) + 1`, luego `INSERT`.

**Insertar en posición k** — O(n): `UPDATE productos SET posicion = posicion + 1 WHERE posicion >= k`, luego `INSERT`.

**Eliminar** — O(n): `DELETE WHERE posicion = :pos`, luego `UPDATE SET posicion = posicion - 1 WHERE posicion > :pos`.

Aceptamos el costo de O(n) en la inserción a cambio de **persistencia**, **atomicidad** (transacciones SQL) y **concurrencia**. Nada de esto es posible con una lista enlazada en RAM."

---

## **KASS** - Diapositiva 14/16 — API RESTfulDiapositiva 9/16 — Sistema en Funcionamiento

"Aquí pueden ver el sistema funcional. La interfaz está dividida en paneles para **listar**, **insertar** (eligiendo si va al inicio, al final o en una posición), **eliminar**, **buscar** (seleccionando Algorithm Lineal o Binaria y el campo) y **ordenar** (seleccionando Bubble Sort o Quick Sort).

Dos funciones del panel de administración que destacan son `Seed` y `Wipe`. Con `Seed` podemos generar lotes de 20, 50 o 100 productos de prueba automáticamente. Con `Wipe` vaciamos la base de datos, pero con una verificación de contraseña que valida contra el hash Bcrypt del servidor, protegiendo la operación destructiva."

---

##  **ULISES** - Diapositiva 10/16 — Diagrama de Clases UML

"El Diagrama de Clases UML nos muestra la estructura interna del backend PHP. Vamos clase por clase:

**`Database`** — Es el punto de entrada a la base de datos. Contiene los atributos privados `host`, `db_name`, `username` y `password`, y expone un único método público: `getConnection()`, que retorna una instancia PDO configurada con `ERRMODE_EXCEPTION` para que cualquier error SQL lanze una excepción capturable. El patrón que usa es similar al *Singleton*: provee una conexión reutilizable. Todas las clases que necesitan acceder a MySQL pasan obligatoriamente por aquí.

**`Producto`** — Es la clase de entidad o **Modelo**. Representa un producto del inventario con atributos públicos: `id`, `posicion`, `codigo`, `nombre`, `precio`, `stock`, `stock_minimo`, `categoria` y `marca_proveedor`. Tiene tres métodos clave:
- `validar()` — verifica que los atributos sean correctos antes de persistir (por ejemplo, que el precio sea positivo o el stock no sea negativo) y retorna un arreglo de errores.
- `toArray()` — convierte el objeto en un arreglo asociativo para serialización JSON cuando el API devuelve respuestas al frontend.
- `fromArray()` — construye un objeto `Producto` a partir de un arreglo, útil al reconstruir los registros SQL en objetos PHP.

**`ProductoController`** — Es el **Controlador** central del sistema. Depende de `Database` para obtener la conexión PDO, y opera directamente sobre objetos `Producto`. Sus métodos implementan la lógica de negocio completa:
- `obtenerTodos()` — ejecuta `SELECT * FROM productos ORDER BY posicion ASC` y retorna el arreglo de objetos `Producto`.
- `insertarInicio()`, `insertarFinal()`, `insertarPosicion()` — los tres tipos de inserción que simulan la lista enlazada.
- `eliminarInicio()`, `eliminarFinal()`, `eliminarPorCodigo()` — los tres tipos de eliminación con compactación del campo `posicion`.
- `actualizarProducto()` — actualiza los datos de un producto existente mediante un `UPDATE` con PDO.

**`Ordenamiento`** — Clase **estática** dedicada exclusivamente a los algoritmos de ordenamiento. Al ser estática, no necesita instanciarse: se llama directamente como `Ordenamiento::quickSortPorPrecio($productos)`. Sus métodos reciben el arreglo de objetos `Producto` **por referencia** (`&$productos`) para no duplicar la memoria. Métodos disponibles: `bubbleSortPorPrecio()`, `bubbleSortPorNombre()`, `quickSortPorPrecio()` y `quickSortPorNombre()` — la lógica de partición de Quick Sort está encapsulada en el método privado `particionPrecio()`.

**`Busqueda`** — Clase **estática** con los cuatro algoritmos de búsqueda: `busquedaLinealPorCodigo()`, `busquedaLinealPorNombre()`, `busquedaBinariaPorCodigo()` y `busquedaBinariaPorNombre()`. Cada método recibe el arreglo de productos, el valor buscado, y devuelve el objeto `Producto` encontrado o `null`.

La división entre `Ordenamiento`, `Busqueda` y `ProductoController` es una decisión deliberada de diseño: respeta el **Principio de Responsabilidad Única**, donde ninguna clase hace más de una cosa. Si mañana necesitáramos agregar un nuevo algoritmo, solo tocamos la clase `Ordenamiento` sin tocar nada más del sistema."


---

## **ALAN** - Diapositiva 11/16 — Bubble Sort (PHP)

"Antes de entrar al algoritmo, conviene recordar qué es una **Lista Enlazada** y por qué es central en este proyecto.

Una lista enlazada es una estructura de datos lineal formada por nodos. Cada nodo tiene dos partes: el **dato** (en nuestro caso, los atributos de un producto: código, nombre, precio, stock) y un **puntero** que apunta al siguiente nodo. A diferencia de un arreglo normal donde los elementos están contiguos en memoria, los nodos de una lista enlazada pueden estar dispersos; solo el puntero los mantiene conectados. Las operaciones características son insertar en cabeza (O(1)), insertar en cola (O(n) sin puntero al final), buscar (O(n)) y eliminar.

¿Cómo simulamos esto en MySQL? Con el campo `posicion (INT)` de la tabla `productos`. Cada producto almacena su lugar en la secuencia lógica. La consulta `SELECT * FROM productos ORDER BY posicion ASC` reproduce fielmente el recorrido de una lista desde la cabeza hasta la cola. Cuando queremos insertar un producto al inicio, hacemos `UPDATE productos SET posicion = posicion + 1` para desplazar todos los nodos y luego `INSERT ... posicion = 1`, tal como actualizaríamos el puntero `head` en una lista real.

Ahora sí, Bubble Sort: ¿cómo trabaja sobre esta estructura?

Cuando el usuario solicita ordenar por precio, el sistema ejecuta `ProductoController::obtenerTodos()`, que trae todos los registros con `ORDER BY posicion ASC`. Esto nos entrega un arreglo PHP de objetos `Producto` **en el orden lógico de la lista enlazada simulada**. A partir de ahí, `Ordenamiento::bubbleSortPorPrecio(&$productos)` toma ese arreglo **por referencia** y aplica el algoritmo:

El algoritmo recorre el arreglo con dos bucles anidados. El bucle externo va de 0 a n-1 pasadas. El interno va de 0 a n-1-i, comparando `$productos[j]->precio` con `$productos[j+1]->precio`. Si están en orden incorrecto, los intercambia usando una variable temporal. Si en una pasada completa no hubo ningún intercambio (detectado por la bandera `$huboIntercambio`), el bucle se rompe anticipadamente —esta es la optimización O(n) en el mejor caso.

El resultado es un arreglo PHP reordenado **en memoria**, sin modificar la base de datos. El campo `posicion` de MySQL no cambia; solo la presentación al usuario cambia. Si el usuario presiona 'actualizar', el inventario vuelve a su orden original de lista enlazada.

Complejidades:
- **Peor caso:** O(n²) — arreglo en orden inverso.
- **Caso promedio:** O(n²).
- **Mejor caso:** O(n) — gracias a la bandera `$huboIntercambio`.
- **Espacio:** O(1) — in-place, opera sobre el mismo arreglo.
- **Estabilidad:** Estable.

Resultados reales de tiempo (incluye carga SQL + ejecución PHP):
- n=20: ~0.2 ms | n=50: ~0.8 ms | n=100: ~2.1 ms"

---

## **HÉCTOR** - Diapositiva 12/16 — Quick Sort (PHP)

"Quick Sort opera sobre la misma estructura: el arreglo PHP de objetos `Producto` cargado desde MySQL en el orden de la lista enlazada simulada (`ORDER BY posicion ASC`).

La diferencia con Bubble Sort es su estrategia: **Divide y Vencerás**. El método `quickSortPorPrecio(&$productos, $low, $high)` selecciona el último elemento del subarreglo como **pivote** y llama a `particionPrecio()`. Este método privado reorganiza el subarreglo de modo que todos los productos con precio menor al pivote queden a su izquierda y los mayores a su derecha, retornando la posición final del pivote. Quick Sort se llama recursivamente sobre ambas mitades hasta que los subarreglos tengan un solo elemento.

La recursión usa la pila de llamadas del intérprete PHP, con profundidad O(log n) en el caso promedio. En el peor caso, si el pivote siempre cae en el extremo (arreglo ya ordenado con pivote como último elemento), la recursión llega a O(n) niveles y la complejidad total sube a O(n²) —por eso en sistemas de producción se usa la estrategia de pivote aleatorio o mediana de tres. En nuestro caso académico usamos el último elemento como pivote, lo que es suficiente para demostrar el comportamiento asintótico.

Al igual que Bubble Sort, el ordenamiento Quick Sort ocurre **en memoria PHP**. El campo `posicion` de la lista enlazada simulada no se toca: el inventario persiste en su orden original en MySQL. El usuario ve la tabla reordenada por precio, pero si recarga la página, vuelve al orden de inserción de la lista.

Complejidades:
- **Peor caso:** O(n²).
- **Caso promedio y mejor caso:** O(n log n).
- **Espacio:** O(log n) en la pila de recursión.
- **Estabilidad:** No estable.

Resultados reales:
- n=20: ~0.1 ms | n=50: ~0.3 ms | n=100: ~0.6 ms

Quick Sort es **~3.5× más rápido** que Bubble Sort para n=100 (0.6 ms vs 2.1 ms), validando la diferencia teórica O(n log n) vs O(n²)."

---

## **ALAN** - Diapositiva 13/16 — Búsqueda Lineal y Binaria

"Los algoritmos de búsqueda también operan sobre el arreglo PHP cargado desde la base de datos vía `ProductoController::obtenerTodos()`, que entrega los productos **en el orden de posición de la lista enlazada simulada** gracias al `ORDER BY posicion ASC`.

**Búsqueda Lineal:** El método `busquedaLinealPorCodigo($productos, $valor)` recorre secuencialmente el arreglo —en el mismo orden en que están los nodos de la lista enlazada— comparando el campo `codigo` de cada objeto `Producto` con el valor buscado. Funciona sin importar si el arreglo está ordenado o no. Su complejidad es O(n) en el peor caso (el código no existe o está al final) y O(1) en el mejor (está en la posición 1 de la lista, es decir, el nodo cabeza).

**Búsqueda Binaria:** El método `busquedaBinariaPorCodigo($productos, $valor)` es más eficiente pero exige un prerrequisito: que el arreglo esté **ordenado por el campo de búsqueda**. Aquí entra la cadena de dependencia entre algoritmos: antes de correr la búsqueda binaria por código, el sistema ejecuta `quickSortPorCodigo()` para garantizar el orden numérico. Una vez ordenado, la búsqueda divide el arreglo a la mitad en cada iteración: toma el índice central, compara el `codigo` de ese producto con el buscado; si es mayor, descarta la mitad derecha; si es menor, descarta la izquierda. Repite hasta encontrar el elemento o confirmar que no existe.

Es importante aclarar que **la búsqueda no altera el campo `posicion`** ni el orden de la lista enlazada en MySQL. Los productos se traen ordenados por posición, se reordenan en memoria para la búsqueda binaria si es necesario, y el resultado es simplemente el objeto `Producto` encontrado junto con el tiempo de ejecución medido en milisegundos."


---


## **KASS** - Diapositiva 14/16 — API RESTful

"Para entender cómo se comunican el frontend y el backend de HA&KU, primero hay que saber qué es una API REST.

**¿Qué es una API?** (Interfaz de Programación de Aplicaciones). Es un contrato entre dos programas que define cómo pueden comunicarse entre sí. En lugar de que el usuario interactúe directamente con la base de datos, la API actúa como intermediario: recibe peticiones, ejecuta la lógica y devuelve respuestas en un formato estándar.

**¿Qué es REST?** REST (*Representational State Transfer*) es un estilo arquitectónico para sistemas distribuidos.No es un protocolo ni una librería, sino un conjunto de restricciones de diseño que, cuando se respetan, producen sistemas web altamente desacoplados, escalables e interoperables.

Las seis restricciones REST aplicadas a nuestro sistema son:

1. **Cliente-Servidor:** El frontend (HTML/JS) y el backend (PHP/MySQL) están completamente separados. Cualquier cliente —una app móvil, otra página web, incluso Postman— puede consumir nuestra API sin cambiar el servidor.

2. **Sin estado (Stateless):** Cada petición HTTP debe contener toda la información necesaria para ser procesada. En HA&KU esto se cumple porque cada llamada incluye automáticamente la *cookie* de sesión PHP gracias al parámetro `credentials: 'include'` de la Fetch API. El servidor no recuerda quién eres entre llamadas; lo verifica en cada petición.

3. **Caché:** El servidor declara `Cache-Control: no-cache` en las rutas protegidas para evitar que datos del inventario sean servidos desde la caché del navegador —un dato desactualizado podría confundir al usuario.

4. **Interfaz uniforme:** Todos los recursos se identifican mediante **URIs** (direcciones) y se manipulan usando los métodos estándar del protocolo HTTP, que indican la intención de la operación:
   - `GET` → Recuperar sin modificar.
   - `POST` → Crear un recurso o ejecutar una acción.
   - `PUT` → Actualizar un recurso existente.
   - `DELETE` → Eliminar un recurso.

5. **Sistema en capas:** El cliente no necesita saber si se conecta directamente al servidor final o a un proxy intermedio.

6. **Código bajo demanda (opcional):** El servidor puede enviar código ejecutable al cliente, como scripts JavaScript.

Así quedan mapeados nuestros endpoints al estilo REST:

| Verbo HTTP | Endpoint | Acción en HA&KU |
|---|---|---|
| `GET` | `/api/productos.php` | Obtener lista completa ordenada por posición |
| `POST` | `/api/productos.php` | Insertar producto (inicio, final o posición k) |
| `PUT` | `/api/productos.php` | Editar datos de un producto existente |
| `DELETE` | `/api/productos.php` | Eliminar por código, inicio o final |
| `POST` | `/api/buscar.php` | Ejecutar búsqueda lineal o binaria |
| `POST` | `/api/ordenar.php` | Ejecutar Bubble Sort o Quick Sort en memoria |
| `POST` | `/api/login.php` | Autenticar credenciales con verificación Bcrypt |
| `POST` | `/api/logout.php` | Destruir sesión PHP en el servidor |

Todas las respuestas siguen el mismo contrato JSON uniforme:
```json
{ "exito": true, "mensaje": "...", "datos": {...}, "tiempo_ms": 0.43 }
```

Esto hace que el frontend sea 100% independiente del backend: mientras se respete la forma de la respuesta JSON, podemos cambiar internamente todo PHP sin tocar ni una línea de JavaScript."


---
## **KASS** - Diapositiva 15/16 — ARQUICTECTURA DEL SISTEMA

## **ULISES** - Diapositiva 16/16 — Conclusiones y Metodología Ágil

Primero, los **algoritmos son independientes del lenguaje**, pero el entorno condiciona el rendimiento absoluto. La complejidad Big-O describe el comportamiento asintótico correcto, pero el overhead de PHP, la serialización de objetos y la consulta SQL infla los tiempos absolutos respecto a C++.

Segundo, la **simulación de lista enlazada en SQL es viable** pero con un compromiso: la inserción en cabeza es O(n) en SQL frente a O(1) con punteros en C++. Para inventarios de escala modesta, el costo es aceptable; a escala industrial se optaría por otras estrategias.

Tercero, la **seguridad debe diseñarse desde el inicio**. El bug del botón 'Atrás' que permitía acceder al dashboard tras el logout nos mostró que la autenticación solo en el cliente (localStorage) es insuficiente sin destruir la sesión PHP en el servidor.

Cuarto, la **arquitectura MVC facilitó el trabajo colaborativo**. Al dividir por capas (backend, frontend, algoritmos, integración), los conflictos de código se minimizaron y fue posible el desarrollo paralelo de ambas capas."
