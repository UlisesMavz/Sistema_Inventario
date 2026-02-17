<?php
/**
 * Clase Busqueda
 * Implementa algoritmos de búsqueda DESDE CERO sin usar funciones nativas de PHP
 * Demuestra conocimiento de análisis de algoritmos y complejidad computacional
 */
class Busqueda {
    
    
    /*
     * ═══════════════════════════════════════════════════════════════════════
     * PSEUDOCÓDIGO: BÚSQUEDA LINEAL POR CÓDIGO
     * ═══════════════════════════════════════════════════════════════════════
     * 
     * COMPLEJIDAD TEMPORAL:
     *   - Mejor caso:    O(1)  → Elemento está en la primera posición
     *   - Caso promedio: O(n)  → Elemento está en el medio
     *   - Peor caso:     O(n)  → Elemento está al final o no existe
     * 
     * COMPLEJIDAD ESPACIAL: O(1) → No usa memoria adicional
     * 
     * LÓGICA DEL ALGORITMO:
     * 
     * FUNCIÓN busquedaLinealPorCodigo(productos[], codigo)
     *   n ← longitud(productos)
     *   
     *   // Recorrer secuencialmente cada elemento
     *   PARA i ← 0 HASTA n-1 HACER                          // O(n) iteraciones
     *     
     *     // Comparar el código del producto actual con el buscado
     *     SI productos[i].codigo = codigo ENTONCES
     *       RETORNAR productos[i]  // Encontrado!
     *     FIN SI
     *     
     *   FIN PARA
     *   
     *   // Si llegamos aquí, no se encontró
     *   RETORNAR NULL
     * FIN FUNCIÓN
     * 
     * ANÁLISIS DE COMPLEJIDAD:
     *   - En el mejor caso: 1 comparación (elemento en posición 0)
     *   - En el peor caso: n comparaciones (elemento al final o no existe)
     *   - En promedio: n/2 comparaciones = O(n)
     * 
     * VENTAJAS:
     *   - Simple de implementar
     *   - Funciona con arrays ordenados y desordenados
     *   - No requiere preprocesamiento
     * 
     * DESVENTAJAS:
     *   - Lento para arrays grandes
     *   - No aprovecha si el array está ordenado
     * 
     * ═══════════════════════════════════════════════════════════════════════
     */
    
    /**
     * BÚSQUEDA LINEAL - Por Código
     * Complejidad: O(n) - Recorre todo el array en el peor caso
     * 
     * Algoritmo: Recorre secuencialmente cada elemento del array hasta encontrar
     * el código buscado o llegar al final.
     * 
     * Ventaja: Funciona con arrays ordenados y desordenados
     * Desventaja: Lento para arrays grandes
     * 
     * @param array $productos Array de objetos Producto
     * @param int $codigo Código a buscar
     * @return Producto|null Producto encontrado o null
     */
    public static function busquedaLinealPorCodigo($productos, $codigo) {
        // Recorrer cada producto en el array
        for ($i = 0; $i < count($productos); $i++) {
            // Comparar el código del producto actual con el código buscado
            if ($productos[$i]->codigo == $codigo) {
                // Retornar el producto encontrado
                return $productos[$i];
            }
        }
        
        // Si no se encontró, retornar null
        return null;
    }
    
    /**
     * BÚSQUEDA LINEAL - Por Nombre
     * Complejidad: O(n)
     * 
     * @param array $productos Array de objetos Producto
     * @param string $nombre Nombre a buscar
     * @return Producto|null Producto encontrado o null
     */
    public static function busquedaLinealPorNombre($productos, $nombre) {
        // Recorrer cada producto
        for ($i = 0; $i < count($productos); $i++) {
            // Comparación exacta de nombres (case-sensitive)
            if ($productos[$i]->nombre === $nombre) {
                return $productos[$i];
            }
        }
        
        return null;
    }
    
    
    /*
     * ═══════════════════════════════════════════════════════════════════════
     * PSEUDOCÓDIGO: BÚSQUEDA BINARIA POR CÓDIGO
     * ═══════════════════════════════════════════════════════════════════════
     * 
     * COMPLEJIDAD TEMPORAL:
     *   - Mejor caso:    O(1)      → Elemento está en el medio
     *   - Caso promedio: O(log n)  → Divide el espacio a la mitad cada vez
     *   - Peor caso:     O(log n)  → Elemento al inicio/final o no existe
     * 
     * COMPLEJIDAD ESPACIAL: O(1) → Solo usa variables para índices
     * 
     * REQUISITO: Array DEBE estar ordenado por código
     * 
     * TÉCNICA: Divide y Conquista (iterativa)
     * 
     * LÓGICA DEL ALGORITMO:
     * 
     * FUNCIÓN busquedaBinariaPorCodigo(productos[], codigo)
     *   // Primero ordenar el array (si no está ordenado)
     *   productos ← ordenarPorCodigo(productos)
     *   
     *   // Inicializar límites de búsqueda
     *   low ← 0
     *   high ← longitud(productos) - 1
     *   
     *   // Mientras el rango de búsqueda sea válido
     *   MIENTRAS low <= high HACER                         // O(log n) iteraciones
     *     
     *     // Calcular el índice del elemento medio
     *     mid ← (low + high) / 2  // División entera
     *     
     *     // Comparar el elemento medio con el código buscado
     *     SI productos[mid].codigo = codigo ENTONCES
     *       RETORNAR productos[mid]  // ¡Encontrado!
     *       
     *     SINO SI productos[mid].codigo < codigo ENTONCES
     *       // El código buscado está en la mitad SUPERIOR
     *       // Descartar la mitad inferior
     *       low ← mid + 1
     *       
     *     SINO
     *       // El código buscado está en la mitad INFERIOR
     *       // Descartar la mitad superior
     *       high ← mid - 1
     *       
     *     FIN SI
     *     
     *   FIN MIENTRAS
     *   
     *   // Si salimos del bucle, no se encontró
     *   RETORNAR NULL
     * FIN FUNCIÓN
     * 
     * ANÁLISIS DE COMPLEJIDAD:
     *   - En cada iteración, el espacio de búsqueda se reduce a la mitad
     *   - Iteración 1: n elementos
     *   - Iteración 2: n/2 elementos
     *   - Iteración 3: n/4 elementos
     *   - ...
     *   - Iteración k: n/(2^k) elementos
     *   - Termina cuando n/(2^k) = 1, es decir, k = log₂(n)
     *   - Por lo tanto: O(log n)
     * 
     * EJEMPLO con 8 elementos buscando código 7:
     *   Array: [1, 3, 5, 7, 9, 11, 13, 15]
     *   
     *   Iteración 1: low=0, high=7, mid=3 → productos[3]=7 ✓ ENCONTRADO!
     *   
     * EJEMPLO con 8 elementos buscando código 14:
     *   Array: [1, 3, 5, 7, 9, 11, 13, 15]
     *   
     *   Iteración 1: low=0, high=7, mid=3 → productos[3]=7 < 14 → low=4
     *   Iteración 2: low=4, high=7, mid=5 → productos[5]=11 < 14 → low=6
     *   Iteración 3: low=6, high=7, mid=6 → productos[6]=13 < 14 → low=7
     *   Iteración 4: low=7, high=7, mid=7 → productos[7]=15 > 14 → high=6
     *   low > high → NO ENCONTRADO
     * 
     * VENTAJAS sobre Búsqueda Lineal:
     *   - Mucho más rápido para arrays grandes
     *   - log₂(1,000,000) = 20 comparaciones vs 1,000,000 en lineal
     *   - Aprovecha que el array está ordenado
     * 
     * DESVENTAJAS:
     *   - Requiere que el array esté ordenado
     *   - Si no está ordenado, hay que ordenarlo primero (costo adicional)
     * 
     * ═══════════════════════════════════════════════════════════════════════
     */
    
    /**
     * BÚSQUEDA BINARIA - Por Código
     * Complejidad: O(log n) - Mucho más eficiente que búsqueda lineal
     * 
     * Algoritmo: Divide el array a la mitad en cada iteración, comparando el
     * elemento del medio con el valor buscado. Descarta la mitad que no contiene
     * el valor.
     * 
     * REQUISITO: El array DEBE estar ordenado por código
     * 
     * Ventaja: Muy rápido para arrays grandes
     * Desventaja: Requiere array ordenado
     * 
     * @param array $productos Array de objetos Producto (DEBE estar ordenado por código)
     * @param int $codigo Código a buscar
     * @return Producto|null Producto encontrado o null
     */
    public static function busquedaBinariaPorCodigo($productos, $codigo) {
        // Primero, ordenar el array por código usando bubble sort
        // (en una aplicación real, se asumiría que ya está ordenado)
        $productos = self::ordenarPorCodigo($productos);
        
        // Índices de búsqueda
        $low = 0;
        $high = count($productos) - 1;
        
        // Mientras el rango de búsqueda sea válido
        while ($low <= $high) {
            // Calcular el índice medio
            // Usamos división entera manual
            $mid = (int)(($low + $high) / 2);
            
            // Comparar el código del elemento medio con el código buscado
            if ($productos[$mid]->codigo == $codigo) {
                // Encontrado! Retornar el producto
                return $productos[$mid];
            } 
            else if ($productos[$mid]->codigo < $codigo) {
                // El código buscado está en la mitad superior
                // Descartar la mitad inferior
                $low = $mid + 1;
            } 
            else {
                // El código buscado está en la mitad inferior
                // Descartar la mitad superior
                $high = $mid - 1;
            }
        }
        
        // No se encontró el producto
        return null;
    }
    
    /**
     * BÚSQUEDA BINARIA - Por Nombre
     * Complejidad: O(log n)
     * 
     * REQUISITO: El array DEBE estar ordenado alfabéticamente por nombre
     * 
     * @param array $productos Array de objetos Producto (DEBE estar ordenado por nombre)
     * @param string $nombre Nombre a buscar
     * @return Producto|null Producto encontrado o null
     */
    public static function busquedaBinariaPorNombre($productos, $nombre) {
        // Ordenar el array por nombre
        $productos = self::ordenarPorNombre($productos);
        
        $low = 0;
        $high = count($productos) - 1;
        
        while ($low <= $high) {
            $mid = (int)(($low + $high) / 2);
            
            // Comparación alfabética usando strcmp
            // strcmp retorna: 0 si son iguales, <0 si el primero es menor, >0 si el primero es mayor
            $comparacion = strcmp($productos[$mid]->nombre, $nombre);
            
            if ($comparacion == 0) {
                // Encontrado!
                return $productos[$mid];
            } 
            else if ($comparacion < 0) {
                // El nombre buscado está en la mitad superior
                $low = $mid + 1;
            } 
            else {
                // El nombre buscado está en la mitad inferior
                $high = $mid - 1;
            }
        }
        
        return null;
    }
    
    /**
     * Función auxiliar: Ordenar productos por código (Bubble Sort)
     * Se usa para preparar el array antes de búsqueda binaria
     * 
     * @param array $productos Array de productos
     * @return array Array ordenado por código
     */
    private static function ordenarPorCodigo($productos) {
        $n = count($productos);
        
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - 1 - $i; $j++) {
                if ($productos[$j]->codigo > $productos[$j + 1]->codigo) {
                    // Intercambio manual
                    $temp = $productos[$j];
                    $productos[$j] = $productos[$j + 1];
                    $productos[$j + 1] = $temp;
                }
            }
        }
        
        return $productos;
    }
    
    /**
     * Función auxiliar: Ordenar productos por nombre (Bubble Sort)
     * 
     * @param array $productos Array de productos
     * @return array Array ordenado por nombre
     */
    private static function ordenarPorNombre($productos) {
        $n = count($productos);
        
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - 1 - $i; $j++) {
                if (strcmp($productos[$j]->nombre, $productos[$j + 1]->nombre) > 0) {
                    // Intercambio manual
                    $temp = $productos[$j];
                    $productos[$j] = $productos[$j + 1];
                    $productos[$j + 1] = $temp;
                }
            }
        }
        
        return $productos;
    }
}
?>
