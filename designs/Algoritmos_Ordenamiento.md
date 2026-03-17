# Análisis de Algoritmos de Ordenamiento — Sistema HA&KU

> Explicación técnica de la implementación en PHP de los algoritmos de ordenamiento utilizados en el sistema de inventario.

---

## 1. Ordenamiento de Burbuja (Bubble Sort)

### 1.1 Bubble Sort por Precio — `bubbleSortPorPrecio()`

El método `bubbleSortPorPrecio()` recibe por referencia un arreglo de objetos `Producto` y declara una variable entera `$n` con el total de elementos mediante `count($productos)`. El algoritmo opera con dos ciclos `for` anidados: el ciclo exterior, controlado por el índice `$i` que va de `0` a `$n-2`, representa cada pasada sobre el arreglo; al inicio de cada pasada se inicializa la bandera `$huboIntercambio` en `false`. El ciclo interior, controlado por el índice `$j` que va de `0` a `$n-2-$i`, compara el atributo `precio` del objeto en la posición `$j` contra el objeto en la posición `$j+1`; si el precio del elemento izquierdo supera al derecho, se realiza un intercambio de posiciones mediante la variable temporal `$temp`, asignando primero `$productos[$j]` a `$temp`, luego `$productos[$j+1]` a `$productos[$j]`, y finalmente `$temp` a `$productos[$j+1]`, estableciendo también `$huboIntercambio` en `true`. Al concluir el ciclo interior, si la bandera permanece en `false` se ejecuta un `break` que detiene anticipadamente el algoritmo, ya que indica que el arreglo quedó completamente ordenado sin necesidad de continuar. El resultado es un arreglo ordenado de menor a mayor precio con complejidad **O(n²)** en el peor caso y **O(n)** en el mejor caso cuando el arreglo ya estaba ordenado.

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
        if (!$huboIntercambio) break;
    }
    return $productos;
}
```

---

### 1.2 Bubble Sort por Nombre — `bubbleSortPorNombre()`

El método `bubbleSortPorNombre()` aplica la misma estructura de doble ciclo `for` anidado que su contraparte por precio, con la diferencia fundamental en el criterio de comparación. En lugar de evaluar valores numéricos, el ciclo interior invoca la función `strcmp($productos[$j]->nombre, $productos[$j+1]->nombre)`, que retorna un entero positivo cuando la cadena del primer argumento precede lexicográficamente a la del segundo, un valor negativo en el caso contrario, y cero cuando ambas cadenas son idénticas. Cuando el resultado de `strcmp` es mayor que cero, significa que el producto en la posición `$j` debe ubicarse después del producto en `$j+1` en orden alfabético, por lo que se procede al intercambio manual mediante la variable temporal `$temp` de la misma forma que en el método anterior. La bandera `$huboIntercambio` mantiene su función de optimización, permitiendo la terminación anticipada con `break` cuando una pasada completa transcurre sin ninguna transposición. El método produce un arreglo ordenado alfabéticamente de la A a la Z, con complejidad **O(n²)** en el peor caso y **O(n)** cuando ya está ordenado.

```php
public static function bubbleSortPorNombre(&$productos) {
    $n = count($productos);
    for ($i = 0; $i < $n - 1; $i++) {
        $huboIntercambio = false;
        for ($j = 0; $j < $n - 1 - $i; $j++) {
            if (strcmp($productos[$j]->nombre, $productos[$j + 1]->nombre) > 0) {
                $temp = $productos[$j];
                $productos[$j] = $productos[$j + 1];
                $productos[$j + 1] = $temp;
                $huboIntercambio = true;
            }
        }
        if (!$huboIntercambio) break;
    }
    return $productos;
}
```

---

## 2. Ordenamiento Rápido (Quick Sort)

### 2.1 Quick Sort por Precio — `quickSortPorPrecio()` + `particionPrecio()`

El método `quickSortPorPrecio()` también recibe el arreglo por referencia junto con los índices enteros `$low` y `$high` que delimitan el subarreglo activo; en la primera invocación `$high` es `null` y se inicializa automáticamente a `count($productos) - 1`. La condición `$low < $high` actúa como caso base de la recursión: si no se cumple, el subarreglo tiene cero o un elemento y ya está ordenado por definición, por lo que la función retorna sin realizar operación alguna. Cuando sí se cumple, se invoca el método privado `particionPrecio()`, que recibe el arreglo y los mismos índices `$low` y `$high`.

Dentro de `particionPrecio()`, el pivote se selecciona como el precio del último elemento del subarreglo, almacenado en `$pivot = $arr[$high]->precio`, y el índice `$i` se inicializa en `$low - 1` para marcar la frontera de los elementos menores al pivote. El ciclo `for` interno recorre con el índice `$j` desde `$low` hasta `$high - 1`; en cada iteración, si el precio de `$arr[$j]` resulta menor o igual a `$pivot`, se incrementa `$i` y se intercambian los objetos en las posiciones `$i` y `$j` mediante la variable temporal `$temp`, empujando así los elementos pequeños hacia el extremo izquierdo del subarreglo. Al concluir el ciclo, se realiza un último intercambio que coloca el pivote en su posición definitiva en `$arr[$i + 1]` y se retorna dicho índice como `$pi` al método llamador.

De regreso en `quickSortPorPrecio()`, el índice `$pi` divide el problema en dos subproblemas completamente independientes: la primera llamada recursiva opera sobre el subarreglo `[$low, $pi - 1]` (todos los elementos menores al pivote) y la segunda sobre `[$pi + 1, $high]` (todos los mayores), garantizando que el pivote nunca vuelva a ser considerado. Este proceso de partición y recursión continúa hasta que todos los subarreglos tienen longitud uno o cero, momento en que el arreglo completo queda ordenado de menor a mayor precio con complejidad promedio de **O(n log n)** y peor caso de **O(n²)**.

```php
public static function quickSortPorPrecio(&$productos, $low = 0, $high = null) {
    if ($high === null) $high = count($productos) - 1;
    if ($low < $high) {
        $pi = self::particionPrecio($productos, $low, $high);
        self::quickSortPorPrecio($productos, $low, $pi - 1);
        self::quickSortPorPrecio($productos, $pi + 1, $high);
    }
    return $productos;
}

private static function particionPrecio(&$arr, $low, $high) {
    $pivot = $arr[$high]->precio;
    $i = $low - 1;
    for ($j = $low; $j < $high; $j++) {
        if ($arr[$j]->precio < $pivot) {
            $i++;
            $temp = $arr[$i]; $arr[$i] = $arr[$j]; $arr[$j] = $temp;
        }
    }
    $temp = $arr[$i + 1]; $arr[$i + 1] = $arr[$high]; $arr[$high] = $temp;
    return $i + 1;
}
```

---

### 2.2 Quick Sort por Nombre — `quickSortPorNombre()` + `particionNombre()`

El método `quickSortPorNombre()` replica íntegramente la estructura recursiva de `quickSortPorPrecio()`, con la única variación en el método auxiliar `particionNombre()`. En este caso, el pivote se extrae como el atributo `nombre` del último elemento del subarreglo, almacenado en la variable `$pivot = $arr[$high]->nombre`. La condición de comparación dentro del ciclo `for` utiliza `strcmp($arr[$j]->nombre, $pivot) < 0`, que evalúa si el nombre del elemento actual precede alfabéticamente al nombre pivote; cuando esta condición se cumple, el índice `$i` se incrementa y se realiza el intercambio entre las posiciones `$i` y `$j`. Al finalizar el recorrido, el pivote nominal se sitúa en `$arr[$i + 1]` como su posición definitiva en el orden alfabético. Mediante las dos llamadas recursivas subsecuentes sobre `[$low, $pi - 1]` y `[$pi + 1, $high]`, el método garantiza que la totalidad del arreglo quede ordenado de la A a la Z con complejidad promedio **O(n log n)**.

```php
public static function quickSortPorNombre(&$productos, $low = 0, $high = null) {
    if ($high === null) $high = count($productos) - 1;
    if ($low < $high) {
        $pi = self::particionNombre($productos, $low, $high);
        self::quickSortPorNombre($productos, $low, $pi - 1);
        self::quickSortPorNombre($productos, $pi + 1, $high);
    }
    return $productos;
}

private static function particionNombre(&$arr, $low, $high) {
    $pivot = $arr[$high]->nombre;
    $i = $low - 1;
    for ($j = $low; $j < $high; $j++) {
        if (strcmp($arr[$j]->nombre, $pivot) < 0) {
            $i++;
            $temp = $arr[$i]; $arr[$i] = $arr[$j]; $arr[$j] = $temp;
        }
    }
    $temp = $arr[$i + 1]; $arr[$i + 1] = $arr[$high]; $arr[$high] = $temp;
    return $i + 1;
}
```

---

### 2.3 Quick Sort por Stock — `quickSortPorStock()` + `particionStock()`

El método `quickSortPorStock()` sigue la misma estructura recursiva que los anteriores Quick Sort, adaptando únicamente el criterio de partición al atributo `stock` de cada objeto `Producto`. En `particionStock()`, el pivote se define como `$pivot = $arr[$high]->stock` y la condición de comparación evalúa `$arr[$j]->stock < $pivot` con valores enteros que representan la cantidad disponible en el inventario. Los elementos con stock inferior al pivote se desplazan hacia la izquierda del subarreglo mediante el mismo mecanismo de intercambio con variable temporal, y al finalizar el ciclo el pivote queda en su posición definitiva `$arr[$i + 1]`. Las llamadas recursivas ordenan las dos particiones restantes hasta que el arreglo completo queda dispuesto de menor a mayor cantidad en existencia, lo que permite identificar de forma inmediata los productos con nivel de inventario más crítico al consultar los primeros elementos de la lista resultante. La complejidad promedio del método es **O(n log n)**.

```php
public static function quickSortPorStock(&$productos, $low = 0, $high = null) {
    if ($high === null) $high = count($productos) - 1;
    if ($low < $high) {
        $pi = self::particionStock($productos, $low, $high);
        self::quickSortPorStock($productos, $low, $pi - 1);
        self::quickSortPorStock($productos, $pi + 1, $high);
    }
    return $productos;
}

private static function particionStock(&$arr, $low, $high) {
    $pivot = $arr[$high]->stock;
    $i = $low - 1;
    for ($j = $low; $j < $high; $j++) {
        if ($arr[$j]->stock < $pivot) {
            $i++;
            $temp = $arr[$i]; $arr[$i] = $arr[$j]; $arr[$j] = $temp;
        }
    }
    $temp = $arr[$i + 1]; $arr[$i + 1] = $arr[$high]; $arr[$high] = $temp;
    return $i + 1;
}
```

---

## 3. Tabla Comparativa de Complejidad

| Algoritmo | Mejor caso | Caso promedio | Peor caso | Espacio |
|---|---|---|---|---|
| `bubbleSortPorPrecio()` | O(n) | O(n²) | O(n²) | O(1) |
| `bubbleSortPorNombre()` | O(n) | O(n²) | O(n²) | O(1) |
| `quickSortPorPrecio()` | O(n log n) | O(n log n) | O(n²) | O(log n) |
| `quickSortPorNombre()` | O(n log n) | O(n log n) | O(n²) | O(log n) |
| `quickSortPorStock()` | O(n log n) | O(n log n) | O(n²) | O(log n) |
