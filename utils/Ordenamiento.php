<?php
/**
 * Clase Ordenamiento
 * Implementa algoritmos de ordenamiento DESDE CERO sin usar funciones nativas de PHP
 * Demuestra conocimiento de análisis de algoritmos y complejidad computacional
 */
class Ordenamiento {
    
    
    /*
     * ═══════════════════════════════════════════════════════════════════════
     * PSEUDOCÓDIGO: BUBBLE SORT POR PRECIO
     * ═══════════════════════════════════════════════════════════════════════
     * 
     * COMPLEJIDAD TEMPORAL:
     *   - Mejor caso:    O(n)   → Array ya ordenado, solo una pasada
     *   - Caso promedio: O(n²)  → Requiere múltiples pasadas
     *   - Peor caso:     O(n²)  → Array ordenado inversamente
     * 
     * COMPLEJIDAD ESPACIAL: O(1) → Solo usa variable temporal para intercambio
     * 
     * LÓGICA DEL ALGORITMO:
     * 
     * FUNCIÓN bubbleSortPorPrecio(productos[])
     *   n ← longitud(productos)
     *   
     *   SI n < 2 ENTONCES
     *     RETORNAR productos  // Ya está ordenado
     *   FIN SI
     *   
     *   // Bucle externo: n-1 pasadas máximo
     *   PARA i ← 0 HASTA n-2 HACER                    // O(n) iteraciones
     *     huboIntercambio ← FALSO
     *     
     *     // Bucle interno: comparar elementos adyacentes
     *     PARA j ← 0 HASTA n-2-i HACER                // O(n-i) iteraciones
     *       
     *       // Comparar precios de elementos adyacentes
     *       SI productos[j].precio > productos[j+1].precio ENTONCES
     *         // Intercambiar elementos (burbujear el mayor hacia arriba)
     *         temp ← productos[j]
     *         productos[j] ← productos[j+1]
     *         productos[j+1] ← temp
     *         huboIntercambio ← VERDADERO
     *       FIN SI
     *       
     *     FIN PARA
     *     
     *     // Optimización: si no hubo intercambios, ya está ordenado
     *     SI huboIntercambio = FALSO ENTONCES
     *       ROMPER  // Terminar anticipadamente
     *     FIN SI
     *     
     *   FIN PARA
     *   
     *   RETORNAR productos
     * FIN FUNCIÓN
     * 
     * ANÁLISIS DE COMPLEJIDAD:
     *   - Bucle externo ejecuta n-1 veces en el peor caso
     *   - Bucle interno ejecuta (n-1), (n-2), ..., 1 veces
     *   - Total de comparaciones: (n-1) + (n-2) + ... + 1 = n(n-1)/2 = O(n²)
     *   - Con optimización: O(n) si ya está ordenado
     * 
     * ═══════════════════════════════════════════════════════════════════════
     */
    
    /**
     * BUBBLE SORT - Ordenamiento por Precio (Ascendente)
     * Complejidad: O(n²) en el peor y caso promedio, O(n) en el mejor caso
     * 
     * Algoritmo: Compara elementos adyacentes y los intercambia si están en orden incorrecto.
     * El elemento más grande "burbujea" hacia el final en cada iteración.
     * 
     * @param array $productos Array de objetos Producto
     * @return array Array ordenado de productos
     */
    public static function bubbleSortPorPrecio(&$productos) {
        $n = count($productos);
        
        // Si hay menos de 2 elementos, ya está ordenado
        if ($n < 2) {
            return $productos;
        }
        
        // Bucle externo: n-1 pasadas
        for ($i = 0; $i < $n - 1; $i++) {
            $huboIntercambio = false;
            
            // Bucle interno: comparar elementos adyacentes
            // En cada pasada, el elemento más grande se mueve al final
            for ($j = 0; $j < $n - 1 - $i; $j++) {
                // Comparar precios de productos adyacentes
                if ($productos[$j]->precio > $productos[$j + 1]->precio) {
                    // Intercambio manual sin usar funciones nativas
                    $temp = $productos[$j];
                    $productos[$j] = $productos[$j + 1];
                    $productos[$j + 1] = $temp;
                    
                    $huboIntercambio = true;
                }
            }
            
            // Optimización: si no hubo intercambios, el array ya está ordenado
            if (!$huboIntercambio) {
                break;
            }
        }
        
        return $productos;
    }
    
    /**
     * BUBBLE SORT - Ordenamiento por Nombre (Alfabético)
     * Complejidad: O(n²)
     * 
     * @param array $productos Array de objetos Producto
     * @return array Array ordenado de productos
     */
    public static function bubbleSortPorNombre(&$productos) {
        $n = count($productos);
        
        if ($n < 2) {
            return $productos;
        }
        
        for ($i = 0; $i < $n - 1; $i++) {
            $huboIntercambio = false;
            
            for ($j = 0; $j < $n - 1 - $i; $j++) {
                // Comparación alfabética manual (strcmp devuelve >0 si el primero es mayor)
                if (strcmp($productos[$j]->nombre, $productos[$j + 1]->nombre) > 0) {
                    // Intercambio manual
                    $temp = $productos[$j];
                    $productos[$j] = $productos[$j + 1];
                    $productos[$j + 1] = $temp;
                    
                    $huboIntercambio = true;
                }
            }
            
            if (!$huboIntercambio) {
                break;
            }
        }
        
        return $productos;
    }
    
    
    /*
     * ═══════════════════════════════════════════════════════════════════════
     * PSEUDOCÓDIGO: QUICK SORT POR PRECIO
     * ═══════════════════════════════════════════════════════════════════════
     * 
     * COMPLEJIDAD TEMPORAL:
     *   - Mejor caso:    O(n log n) → Particiones balanceadas
     *   - Caso promedio: O(n log n) → Particiones relativamente balanceadas
     *   - Peor caso:     O(n²)      → Pivote siempre es el menor/mayor (raro)
     * 
     * COMPLEJIDAD ESPACIAL: O(log n) → Por la pila de recursión
     * 
     * TÉCNICA: Divide y Conquista
     * 
     * LÓGICA DEL ALGORITMO:
     * 
     * FUNCIÓN quickSortPorPrecio(productos[], low, high)
     *   // Caso base: si hay 0 o 1 elementos, ya está ordenado
     *   SI low >= high ENTONCES
     *     RETORNAR productos
     *   FIN SI
     *   
     *   // DIVIDIR: Particionar el array
     *   pivotIndex ← particionPrecio(productos, low, high)  // O(n)
     *   
     *   // CONQUISTAR: Ordenar recursivamente las dos mitades
     *   quickSortPorPrecio(productos, low, pivotIndex - 1)   // T(n/2)
     *   quickSortPorPrecio(productos, pivotIndex + 1, high)  // T(n/2)
     *   
     *   RETORNAR productos
     * FIN FUNCIÓN
     * 
     * FUNCIÓN particionPrecio(productos[], low, high)
     *   // Seleccionar el último elemento como pivote
     *   pivot ← productos[high].precio
     *   i ← low - 1  // Índice del elemento más pequeño
     *   
     *   // Recorrer todos los elementos excepto el pivote
     *   PARA j ← low HASTA high-1 HACER                      // O(n) iteraciones
     *     
     *     // Si el elemento actual es menor que el pivote
     *     SI productos[j].precio < pivot ENTONCES
     *       i ← i + 1
     *       // Intercambiar productos[i] con productos[j]
     *       INTERCAMBIAR(productos[i], productos[j])
     *     FIN SI
     *     
     *   FIN PARA
     *   
     *   // Colocar el pivote en su posición correcta
     *   INTERCAMBIAR(productos[i+1], productos[high])
     *   
     *   RETORNAR i + 1  // Posición final del pivote
     * FIN FUNCIÓN
     * 
     * ANÁLISIS DE COMPLEJIDAD:
     *   - Ecuación de recurrencia: T(n) = 2T(n/2) + O(n)
     *   - Por el Teorema Maestro: T(n) = O(n log n)
     *   - Altura del árbol de recursión: log n
     *   - Trabajo en cada nivel: O(n)
     *   - Total: O(n) × log n = O(n log n)
     * 
     * VENTAJAS sobre Bubble Sort:
     *   - Mucho más rápido para arrays grandes
     *   - Divide el problema en subproblemas más pequeños
     *   - Aprovecha la técnica divide y conquista
     * 
     * ═══════════════════════════════════════════════════════════════════════
     */
    
    /**
     * QUICK SORT - Ordenamiento por Precio (Ascendente)
     * Complejidad: O(n log n) en promedio, O(n²) en el peor caso
     * 
     * Algoritmo: Divide y conquista. Selecciona un pivote y particiona el array
     * en elementos menores y mayores que el pivote, luego ordena recursivamente.
     * 
     * @param array $productos Array de objetos Producto
     * @param int $low Índice inferior
     * @param int $high Índice superior
     * @return array Array ordenado de productos
     */
    public static function quickSortPorPrecio(&$productos, $low = 0, $high = null) {
        // Inicializar high en la primera llamada
        if ($high === null) {
            $high = count($productos) - 1;
        }
        
        // Caso base: si low es menor que high, continuar ordenando
        if ($low < $high) {
            // Obtener el índice de partición
            $pi = self::particionPrecio($productos, $low, $high);
            
            // Ordenar recursivamente los elementos antes y después de la partición
            self::quickSortPorPrecio($productos, $low, $pi - 1);
            self::quickSortPorPrecio($productos, $pi + 1, $high);
        }
        
        return $productos;
    }
    
    /**
     * Función auxiliar de partición para QuickSort por precio
     * Selecciona el último elemento como pivote y coloca elementos menores a la izquierda
     * 
     * @param array $productos Array de productos
     * @param int $low Índice inferior
     * @param int $high Índice superior
     * @return int Índice de la posición final del pivote
     */
    private static function particionPrecio(&$productos, $low, $high) {
        // Seleccionar el último elemento como pivote
        $pivot = $productos[$high]->precio;
        
        // Índice del elemento más pequeño
        $i = $low - 1;
        
        // Recorrer el array
        for ($j = $low; $j < $high; $j++) {
            // Si el elemento actual es menor que el pivote
            if ($productos[$j]->precio < $pivot) {
                $i++;
                
                // Intercambiar productos[i] y productos[j]
                $temp = $productos[$i];
                $productos[$i] = $productos[$j];
                $productos[$j] = $temp;
            }
        }
        
        // Intercambiar productos[i+1] y productos[high] (el pivote)
        $temp = $productos[$i + 1];
        $productos[$i + 1] = $productos[$high];
        $productos[$high] = $temp;
        
        return $i + 1;
    }
    
    /**
     * QUICK SORT - Ordenamiento por Nombre (Alfabético)
     * Complejidad: O(n log n) en promedio
     * 
     * @param array $productos Array de objetos Producto
     * @param int $low Índice inferior
     * @param int $high Índice superior
     * @return array Array ordenado de productos
     */
    public static function quickSortPorNombre(&$productos, $low = 0, $high = null) {
        if ($high === null) {
            $high = count($productos) - 1;
        }
        
        if ($low < $high) {
            $pi = self::particionNombre($productos, $low, $high);
            
            self::quickSortPorNombre($productos, $low, $pi - 1);
            self::quickSortPorNombre($productos, $pi + 1, $high);
        }
        
        return $productos;
    }
    
    /**
     * Función auxiliar de partición para QuickSort por nombre
     * 
     * @param array $productos Array de productos
     * @param int $low Índice inferior
     * @param int $high Índice superior
     * @return int Índice de la posición final del pivote
     */
    private static function particionNombre(&$productos, $low, $high) {
        // Seleccionar el último elemento como pivote
        $pivot = $productos[$high]->nombre;
        
        $i = $low - 1;
        
        for ($j = $low; $j < $high; $j++) {
            // Comparación alfabética
            if (strcmp($productos[$j]->nombre, $pivot) < 0) {
                $i++;
                
                // Intercambio manual
                $temp = $productos[$i];
                $productos[$i] = $productos[$j];
                $productos[$j] = $temp;
            }
        }
        
        // Colocar el pivote en su posición correcta
        $temp = $productos[$i + 1];
        $productos[$i + 1] = $productos[$high];
        $productos[$high] = $temp;
        
        return $i + 1;
    }
}
?>
