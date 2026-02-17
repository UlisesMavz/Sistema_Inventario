<?php
// Incluir dependencias
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../utils/Validacion.php';

/**
 * Clase ProductoController
 * Maneja todas las operaciones CRUD de productos
 * Simula el comportamiento de lista enlazada del código C++
 */
class ProductoController {
    private $db;
    private $conn;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }
    
    /**
     * Inserta un producto al INICIO de la lista
     * Equivalente a InsertarIn() del código C++
     * 
     * @param Producto $producto Producto a insertar
     * @return array Array con 'exito' (bool) y 'mensaje' (string)
     */
    public function insertarInicio($producto) {
        // Validar producto
        $validacion = $producto->validar();
        if (!$validacion['valido']) {
            return [
                'exito' => false,
                'mensaje' => implode(', ', $validacion['errores'])
            ];
        }
        
        try {
            // Verificar si el código ya existe
            if ($this->codigoExiste($producto->codigo)) {
                return [
                    'exito' => false,
                    'mensaje' => 'El código de producto ya existe'
                ];
            }
            
            // Incrementar posición de todos los productos existentes
            $updateQuery = "UPDATE productos SET posicion = posicion + 1";
            $this->conn->exec($updateQuery);
            
            // Insertar nuevo producto en posición 1 (inicio)
            $query = "INSERT INTO productos (codigo, nombre, precio, posicion) 
                      VALUES (:codigo, :nombre, :precio, 1)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':codigo', $producto->codigo);
            $stmt->bindParam(':nombre', $producto->nombre);
            $stmt->bindParam(':precio', $producto->precio);
            
            if ($stmt->execute()) {
                $this->registrarLog('INSERT_INICIO', "Producto insertado al inicio: {$producto->nombre}");
                return [
                    'exito' => true,
                    'mensaje' => 'Producto insertado al inicio correctamente'
                ];
            }
            
            return [
                'exito' => false,
                'mensaje' => 'Error al ejecutar la inserción'
            ];
            
        } catch (PDOException $e) {
            error_log("Error al insertar producto: " . $e->getMessage());
            return [
                'exito' => false,
                'mensaje' => 'Error al insertar producto: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Inserta un producto al FINAL de la lista
     * Equivalente a InsertarFin() del código C++
     * 
     * @param Producto $producto Producto a insertar
     * @return array Array con 'exito' (bool) y 'mensaje' (string)
     */
    public function insertarFinal($producto) {
        $validacion = $producto->validar();
        if (!$validacion['valido']) {
            return [
                'exito' => false,
                'mensaje' => implode(', ', $validacion['errores'])
            ];
        }
        
        try {
            if ($this->codigoExiste($producto->codigo)) {
                return [
                    'exito' => false,
                    'mensaje' => 'El código de producto ya existe'
                ];
            }
            
            // Obtener la última posición
            $maxPosQuery = "SELECT COALESCE(MAX(posicion), 0) + 1 as nueva_posicion FROM productos";
            $stmt = $this->conn->query($maxPosQuery);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $nuevaPosicion = $row['nueva_posicion'];
            
            // Insertar al final
            $query = "INSERT INTO productos (codigo, nombre, precio, posicion) 
                      VALUES (:codigo, :nombre, :precio, :posicion)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':codigo', $producto->codigo);
            $stmt->bindParam(':nombre', $producto->nombre);
            $stmt->bindParam(':precio', $producto->precio);
            $stmt->bindParam(':posicion', $nuevaPosicion);
            
            if ($stmt->execute()) {
                $this->registrarLog('INSERT_FINAL', "Producto insertado al final: {$producto->nombre}");
                return [
                    'exito' => true,
                    'mensaje' => 'Producto insertado al final correctamente'
                ];
            }
            
            return [
                'exito' => false,
                'mensaje' => 'Error al ejecutar la inserción'
            ];
            
        } catch (PDOException $e) {
            error_log("Error al insertar producto: " . $e->getMessage());
            return [
                'exito' => false,
                'mensaje' => 'Error al insertar producto: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Inserta un producto en una posición específica
     * Equivalente a InsertarEsp() del código C++
     * 
     * @param Producto $producto Producto a insertar
     * @param int $posicion Posición donde insertar (0-indexed)
     * @return array Array con 'exito' (bool) y 'mensaje' (string)
     */
    public function insertarPosicion($producto, $posicion) {
        $validacion = $producto->validar();
        if (!$validacion['valido']) {
            return [
                'exito' => false,
                'mensaje' => implode(', ', $validacion['errores'])
            ];
        }
        
        try {
            if ($this->codigoExiste($producto->codigo)) {
                return [
                    'exito' => false,
                    'mensaje' => 'El código de producto ya existe'
                ];
            }
            
            $query = "INSERT INTO productos (codigo, nombre, precio) 
                      VALUES (:codigo, :nombre, :precio)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':codigo', $producto->codigo);
            $stmt->bindParam(':nombre', $producto->nombre);
            $stmt->bindParam(':precio', $producto->precio);
            
            if ($stmt->execute()) {
                $this->registrarLog('INSERT_POSICION', "Producto insertado en posición {$posicion}: {$producto->nombre}");
                return [
                    'exito' => true,
                    'mensaje' => "Producto insertado en posición {$posicion} correctamente"
                ];
            }
            
        } catch (PDOException $e) {
            error_log("Error al insertar producto: " . $e->getMessage());
            return [
                'exito' => false,
                'mensaje' => 'Error al insertar producto'
            ];
        }
    }
    
    /**
     * Elimina el primer producto de la lista
     * Equivalente a EliminarIn() del código C++
     * 
     * @return array Array con 'exito' (bool) y 'mensaje' (string)
     */
    public function eliminarInicio() {
        try {
            // Obtener el primer producto (el más antiguo)
            $query = "SELECT id, nombre FROM productos ORDER BY id ASC LIMIT 1";
            $stmt = $this->conn->query($query);
            
            if ($stmt->rowCount() == 0) {
                return [
                    'exito' => false,
                    'mensaje' => 'La lista está vacía'
                ];
            }
            
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Eliminar el producto
            $deleteQuery = "DELETE FROM productos WHERE id = :id";
            $deleteStmt = $this->conn->prepare($deleteQuery);
            $deleteStmt->bindParam(':id', $producto['id']);
            
            if ($deleteStmt->execute()) {
                $this->registrarLog('DELETE_INICIO', "Producto eliminado del inicio: {$producto['nombre']}");
                return [
                    'exito' => true,
                    'mensaje' => 'Producto eliminado del inicio correctamente'
                ];
            }
            
        } catch (PDOException $e) {
            error_log("Error al eliminar producto: " . $e->getMessage());
            return [
                'exito' => false,
                'mensaje' => 'Error al eliminar producto'
            ];
        }
    }
    
    /**
     * Elimina el último producto de la lista
     * Equivalente a EliminarFin() del código C++
     * 
     * @return array Array con 'exito' (bool) y 'mensaje' (string)
     */
    public function eliminarFinal() {
        try {
            // Obtener el último producto (el más reciente)
            $query = "SELECT id, nombre FROM productos ORDER BY id DESC LIMIT 1";
            $stmt = $this->conn->query($query);
            
            if ($stmt->rowCount() == 0) {
                return [
                    'exito' => false,
                    'mensaje' => 'La lista está vacía'
                ];
            }
            
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Eliminar el producto
            $deleteQuery = "DELETE FROM productos WHERE id = :id";
            $deleteStmt = $this->conn->prepare($deleteQuery);
            $deleteStmt->bindParam(':id', $producto['id']);
            
            if ($deleteStmt->execute()) {
                $this->registrarLog('DELETE_FINAL', "Producto eliminado del final: {$producto['nombre']}");
                return [
                    'exito' => true,
                    'mensaje' => 'Producto eliminado del final correctamente'
                ];
            }
            
        } catch (PDOException $e) {
            error_log("Error al eliminar producto: " . $e->getMessage());
            return [
                'exito' => false,
                'mensaje' => 'Error al eliminar producto'
            ];
        }
    }
    
    /**
     * Elimina un producto por su código
     * 
     * @param int $codigo Código del producto a eliminar
     * @return array Array con 'exito' (bool) y 'mensaje' (string)
     */
    public function eliminarPorCodigo($codigo) {
        try {
            $query = "DELETE FROM productos WHERE codigo = :codigo";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':codigo', $codigo);
            
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $this->registrarLog('DELETE_CODIGO', "Producto eliminado con código: {$codigo}");
                return [
                    'exito' => true,
                    'mensaje' => 'Producto eliminado correctamente'
                ];
            } else {
                return [
                    'exito' => false,
                    'mensaje' => 'Producto no encontrado'
                ];
            }
            
        } catch (PDOException $e) {
            error_log("Error al eliminar producto: " . $e->getMessage());
            return [
                'exito' => false,
                'mensaje' => 'Error al eliminar producto'
            ];
        }
    }
    
    /**
     * Obtiene todos los productos
     * Equivalente a Mostrar() del código C++
     * 
     * @return array Array de objetos Producto
     */
    public function obtenerTodos() {
        try {
            $query = "SELECT id, codigo, nombre, precio, posicion, fecha_creacion, fecha_modificacion 
                      FROM productos 
                      ORDER BY posicion ASC";
            
            $stmt = $this->conn->query($query);
            $productos = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $productos[] = Producto::fromArray($row);
            }
            
            return $productos;
            
        } catch (PDOException $e) {
            error_log("Error al obtener productos: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Cuenta el número total de productos
     * Equivalente a ContarNodos() del código C++
     * 
     * @return int Número de productos
     */
    public function contarProductos() {
        try {
            $query = "SELECT COUNT(*) as total FROM productos";
            $stmt = $this->conn->query($query);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)$row['total'];
            
        } catch (PDOException $e) {
            error_log("Error al contar productos: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Verifica si un código de producto ya existe
     * 
     * @param int $codigo Código a verificar
     * @return bool True si el código existe
     */
    private function codigoExiste($codigo) {
        try {
            $query = "SELECT COUNT(*) as total FROM productos WHERE codigo = :codigo";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'] > 0;
            
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Registra una acción en la tabla de logs
     * 
     * @param string $accion Tipo de acción
     * @param string $descripcion Descripción de la acción
     */
    private function registrarLog($accion, $descripcion) {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $usuarioId = $_SESSION['usuario_id'] ?? null;
            
            $query = "INSERT INTO logs (usuario_id, accion, descripcion) 
                      VALUES (:usuario_id, :accion, :descripcion)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':usuario_id', $usuarioId);
            $stmt->bindParam(':accion', $accion);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Error al registrar log: " . $e->getMessage());
        }
    }
}
?>
