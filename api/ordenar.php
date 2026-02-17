<?php
/**
 * API de Ordenamiento
 * Endpoint: POST /api/ordenar.php
 * Implementa algoritmos de ordenamiento personalizados
 */

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Incluir dependencias
require_once __DIR__ . '/../controllers/ProductoController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../utils/Ordenamiento.php';

// Verificar autenticación
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$authController = new AuthController();
if (!$authController->verificarSesion()) {
    http_response_code(401);
    echo json_encode([
        'exito' => false,
        'mensaje' => 'No autorizado'
    ]);
    exit;
}

// Solo permitir método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'exito' => false,
        'mensaje' => 'Método no permitido. Use POST'
    ]);
    exit;
}

// Obtener parámetros
$data = json_decode(file_get_contents("php://input"), true);
$algoritmo = $data['algoritmo'] ?? 'burbuja'; // burbuja o quicksort
$campo = $data['campo'] ?? 'precio'; // precio o nombre

// Obtener todos los productos
$productoController = new ProductoController();
$productos = $productoController->obtenerTodos();

// Verificar que haya productos
if (empty($productos)) {
    http_response_code(200);
    echo json_encode([
        'exito' => true,
        'mensaje' => 'No hay productos para ordenar',
        'productos' => [],
        'algoritmo' => $algoritmo,
        'campo' => $campo,
        'tiempo_ms' => 0
    ]);
    exit;
}

// Medir tiempo de ejecución
$tiempoInicio = microtime(true);

// Ejecutar ordenamiento según el algoritmo y campo
if ($algoritmo === 'burbuja') {
    if ($campo === 'precio') {
        Ordenamiento::bubbleSortPorPrecio($productos);
    } else {
        Ordenamiento::bubbleSortPorNombre($productos);
    }
} else if ($algoritmo === 'quicksort') {
    if ($campo === 'precio') {
        Ordenamiento::quickSortPorPrecio($productos);
    } else {
        Ordenamiento::quickSortPorNombre($productos);
    }
} else {
    http_response_code(400);
    echo json_encode([
        'exito' => false,
        'mensaje' => 'Algoritmo no válido (burbuja o quicksort)'
    ]);
    exit;
}

// Calcular tiempo de ejecución
$tiempoFin = microtime(true);
$tiempoEjecucion = ($tiempoFin - $tiempoInicio) * 1000; // Convertir a milisegundos

// Convertir productos a arrays
$productosArray = array_map(function($producto) {
    return $producto->toArray();
}, $productos);

// Preparar respuesta
http_response_code(200);
echo json_encode([
    'exito' => true,
    'mensaje' => 'Productos ordenados correctamente',
    'productos' => $productosArray,
    'algoritmo' => $algoritmo,
    'campo' => $campo,
    'tiempo_ms' => round($tiempoEjecucion, 4),
    'total' => count($productos)
], JSON_UNESCAPED_UNICODE);
?>
