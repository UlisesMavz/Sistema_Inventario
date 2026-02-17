<?php
/**
 * API de Productos
 * Endpoint: /api/productos.php
 * Maneja operaciones CRUD de productos
 */

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET, POST, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Incluir dependencias
require_once __DIR__ . '/../controllers/ProductoController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../models/Producto.php';

// Verificar autenticación
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$authController = new AuthController();
if (!$authController->verificarSesion()) {
    http_response_code(401);
    echo json_encode([
        'exito' => false,
        'mensaje' => 'No autorizado. Inicie sesión primero'
    ]);
    exit;
}

// Crear instancia del controlador de productos
$productoController = new ProductoController();

// Manejar diferentes métodos HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        // Obtener todos los productos
        $productos = $productoController->obtenerTodos();
        $total = $productoController->contarProductos();
        
        // Convertir productos a arrays
        $productosArray = array_map(function($producto) {
            return $producto->toArray();
        }, $productos);
        
        http_response_code(200);
        echo json_encode([
            'exito' => true,
            'total' => $total,
            'productos' => $productosArray
        ], JSON_UNESCAPED_UNICODE);
        break;
        
    case 'POST':
        // Insertar nuevo producto
        $data = json_decode(file_get_contents("php://input"), true);
        
        // Validar datos requeridos
        if (!isset($data['codigo']) || !isset($data['nombre']) || !isset($data['precio'])) {
            http_response_code(400);
            echo json_encode([
                'exito' => false,
                'mensaje' => 'Faltan datos requeridos (codigo, nombre, precio)'
            ]);
            exit;
        }
        
        // Crear producto
        $producto = new Producto($data['codigo'], $data['nombre'], $data['precio']);
        
        // Determinar tipo de inserción
        $tipo = $data['tipo'] ?? 'inicio'; // Por defecto: inicio
        
        switch ($tipo) {
            case 'inicio':
                $resultado = $productoController->insertarInicio($producto);
                break;
            case 'final':
                $resultado = $productoController->insertarFinal($producto);
                break;
            case 'posicion':
                $posicion = $data['posicion'] ?? 0;
                $resultado = $productoController->insertarPosicion($producto, $posicion);
                break;
            default:
                $resultado = $productoController->insertarInicio($producto);
        }
        
        http_response_code($resultado['exito'] ? 201 : 400);
        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
        break;
        
    case 'DELETE':
        // Eliminar producto
        $data = json_decode(file_get_contents("php://input"), true);
        
        // Determinar tipo de eliminación
        $tipo = $data['tipo'] ?? 'codigo';
        
        switch ($tipo) {
            case 'inicio':
                $resultado = $productoController->eliminarInicio();
                break;
            case 'final':
                $resultado = $productoController->eliminarFinal();
                break;
            case 'codigo':
                if (!isset($data['codigo'])) {
                    http_response_code(400);
                    echo json_encode([
                        'exito' => false,
                        'mensaje' => 'Falta el código del producto'
                    ]);
                    exit;
                }
                $resultado = $productoController->eliminarPorCodigo($data['codigo']);
                break;
            default:
                http_response_code(400);
                echo json_encode([
                    'exito' => false,
                    'mensaje' => 'Tipo de eliminación no válido'
                ]);
                exit;
        }
        
        http_response_code($resultado['exito'] ? 200 : 400);
        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
        break;
        
    default:
        http_response_code(405);
        echo json_encode([
            'exito' => false,
            'mensaje' => 'Método no permitido'
        ]);
}
?>
