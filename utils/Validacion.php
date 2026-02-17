<?php
/**
 * Clase Validacion
 * Implementa validaciones personalizadas DESDE CERO sin usar librerías externas
 * Demuestra manejo de validación de datos y sanitización
 */
class Validacion {
    
    /**
     * Valida que un valor sea un entero válido
     * Implementación manual sin usar filter_var o is_int directamente
     * 
     * @param mixed $valor Valor a validar
     * @return bool True si es un entero válido
     */
    public static function esEntero($valor) {
        // Eliminar espacios en blanco
        $valor = trim($valor);
        
        // Verificar que no esté vacío
        if ($valor === '' || $valor === null) {
            return false;
        }
        
        // Verificar si es numérico y si al convertirlo a int y luego a string
        // sigue siendo igual (esto descarta decimales)
        if (is_numeric($valor)) {
            $intVal = (int)$valor;
            $strVal = (string)$intVal;
            return $valor == $strVal;
        }
        
        return false;
    }
    
    /**
     * Valida que un valor sea un número flotante válido
     * 
     * @param mixed $valor Valor a validar
     * @return bool True si es un flotante válido
     */
    public static function esFlotante($valor) {
        // Eliminar espacios en blanco
        $valor = trim($valor);
        
        // Verificar que no esté vacío
        if ($valor === '' || $valor === null) {
            return false;
        }
        
        // Verificar si es numérico
        return is_numeric($valor);
    }
    
    /**
     * Valida que un string no esté vacío
     * 
     * @param mixed $valor Valor a validar
     * @return bool True si es un string válido no vacío
     */
    public static function esStringValido($valor) {
        // Verificar que sea string
        if (!is_string($valor)) {
            return false;
        }
        
        // Verificar que no esté vacío después de quitar espacios
        return trim($valor) !== '';
    }
    
    /**
     * Sanitiza un string eliminando caracteres peligrosos
     * Implementación manual de sanitización básica
     * 
     * @param string $valor String a sanitizar
     * @return string String sanitizado
     */
    public static function sanitizarString($valor) {
        // Convertir a string si no lo es
        $valor = (string)$valor;
        
        // Eliminar espacios al inicio y final
        $valor = trim($valor);
        
        // Eliminar barras invertidas
        $valor = stripslashes($valor);
        
        // Convertir caracteres especiales a entidades HTML
        $valor = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
        
        return $valor;
    }
    
    /**
     * Sanitiza un entero
     * 
     * @param mixed $valor Valor a sanitizar
     * @return int|null Entero sanitizado o null si no es válido
     */
    public static function sanitizarEntero($valor) {
        if (self::esEntero($valor)) {
            return (int)$valor;
        }
        return null;
    }
    
    /**
     * Sanitiza un flotante
     * 
     * @param mixed $valor Valor a sanitizar
     * @return float|null Flotante sanitizado o null si no es válido
     */
    public static function sanitizarFlotante($valor) {
        if (self::esFlotante($valor)) {
            return (float)$valor;
        }
        return null;
    }
    
    /**
     * Valida y sanitiza datos de un producto
     * 
     * @param array $datos Array con los datos del producto
     * @return array Array con 'valido' (bool), 'datos' (array sanitizado), 'errores' (array)
     */
    public static function validarProducto($datos) {
        $errores = [];
        $datosSanitizados = [];
        
        // Validar código
        if (!isset($datos['codigo']) || !self::esEntero($datos['codigo'])) {
            $errores[] = "El código debe ser un número entero válido";
        } else {
            $datosSanitizados['codigo'] = self::sanitizarEntero($datos['codigo']);
        }
        
        // Validar nombre
        if (!isset($datos['nombre']) || !self::esStringValido($datos['nombre'])) {
            $errores[] = "El nombre no puede estar vacío";
        } else {
            $datosSanitizados['nombre'] = self::sanitizarString($datos['nombre']);
        }
        
        // Validar precio
        if (!isset($datos['precio']) || !self::esFlotante($datos['precio'])) {
            $errores[] = "El precio debe ser un número válido";
        } else {
            $precio = self::sanitizarFlotante($datos['precio']);
            if ($precio < 0) {
                $errores[] = "El precio no puede ser negativo";
            } else {
                $datosSanitizados['precio'] = $precio;
            }
        }
        
        return [
            'valido' => empty($errores),
            'datos' => $datosSanitizados,
            'errores' => $errores
        ];
    }
    
    /**
     * Valida credenciales de usuario
     * 
     * @param string $username Nombre de usuario
     * @param string $password Contraseña
     * @return array Array con 'valido' (bool) y 'errores' (array)
     */
    public static function validarCredenciales($username, $password) {
        $errores = [];
        
        // Validar username
        if (!self::esStringValido($username)) {
            $errores[] = "El nombre de usuario no puede estar vacío";
        }
        
        // Validar password
        if (!self::esStringValido($password)) {
            $errores[] = "La contraseña no puede estar vacía";
        }
        
        return [
            'valido' => empty($errores),
            'errores' => $errores
        ];
    }
}
?>
