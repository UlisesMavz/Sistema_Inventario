<?php
/**
 * Clase Producto
 * Representa un producto en el inventario
 * Esta clase modela la estructura de datos similar a la struct Producto del código C++
 */
class Producto {
    // Propiedades del producto
    public $id;
    public $posicion;
    public $codigo;
    public $nombre;
    public $precio;
    public $fecha_creacion;
    public $fecha_modificacion;
    
    /**
     * Constructor
     * @param int $codigo Código único del producto
     * @param string $nombre Nombre del producto
     * @param float $precio Precio del producto
     * @param int $id ID de la base de datos (opcional)
     */
    public function __construct($codigo = null, $nombre = null, $precio = null, $id = null) {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->precio = $precio;
    }
    
    /**
     * Convierte el objeto Producto a un array asociativo
     * @return array Array con los datos del producto
     */
    public function toArray() {
        return [
            'id' => $this->id,
            'posicion' => $this->posicion,
            'codigo' => $this->codigo,
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'fecha_creacion' => $this->fecha_creacion,
            'fecha_modificacion' => $this->fecha_modificacion
        ];
    }
    
    /**
     * Crea un objeto Producto desde un array asociativo
     * @param array $data Array con los datos del producto
     * @return Producto Objeto Producto creado
     */
    public static function fromArray($data) {
        $producto = new Producto(
            $data['codigo'] ?? null,
            $data['nombre'] ?? null,
            $data['precio'] ?? null,
            $data['id'] ?? null
        );
        
        $producto->posicion = $data['posicion'] ?? 0;
        $producto->fecha_creacion = $data['fecha_creacion'] ?? null;
        $producto->fecha_modificacion = $data['fecha_modificacion'] ?? null;
        
        return $producto;
    }
    
    /**
     * Valida que los datos del producto sean correctos
     * @return array Array con 'valido' (bool) y 'errores' (array)
     */
    public function validar() {
        $errores = [];
        
        // Validar código
        if ($this->codigo === null || $this->codigo === '' || !is_numeric($this->codigo)) {
            $errores[] = "El código debe ser un número válido";
        }
        
        // Validar nombre
        if ($this->nombre === null || trim($this->nombre) === '') {
            $errores[] = "El nombre no puede estar vacío";
        }
        
        // Validar precio
        if ($this->precio === null || $this->precio === '' || !is_numeric($this->precio) || $this->precio < 0) {
            $errores[] = "El precio debe ser un número válido mayor o igual a 0";
        }
        
        return [
            'valido' => empty($errores),
            'errores' => $errores
        ];
    }
    
    /**
     * Convierte el objeto a formato JSON
     * @return string JSON del producto
     */
    public function toJSON() {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }
}
?>
