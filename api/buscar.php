<?php
/**
 * API de Búsqueda
 * Endpoint: GET /api/buscar.php
 * Implementa algoritmos de búsqueda personalizados
 */

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Incluir dependencias
require_once __DIR__ . '/../controllers/ProductoController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../utils/Busqueda.php';

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

// Solo permitir método GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        'exito' => false,
        'mensaje' => 'Método no permitido. Use GET'
    ]);
    exit;
}

// Obtener parámetros
$tipo = $_GET['tipo'] ?? 'lineal'; // lineal o binaria
$campo = $_GET['campo'] ?? 'codigo'; // codigo o nombre
$valor = $_GET['valor'] ?? '';

// Validar parámetros
if (empty($valor)) {
    http_response_code(400);
    echo json_encode([
        'exito' => false,
        'mensaje' => 'Falta el valor a buscar'
    ]);
    exit;
}

// Obtener todos los productos
$productoController = new ProductoController();
$productos = $productoController->obtenerTodos();

// Medir tiempo de ejecución
$tiempoInicio = microtime(true);

// Ejecutar búsqueda según el tipo y campo
$productoEncontrado = null;

if ($tipo === 'lineal') {
    if ($campo === 'codigo') {
        $productoEncontrado = Busqueda::busquedaLinealPorCodigo($productos, (int)$valor);
    } else {
        $productoEncontrado = Busqueda::busquedaLinealPorNombre($productos, $valor);
    }
} else if ($tipo === 'binaria') {
    if ($campo === 'codigo') {
        $productoEncontrado = Busqueda::busquedaBinariaPorCodigo($productos, (int)$valor);
    } else {
        $productoEncontrado = Busqueda::busquedaBinariaPorNombre($productos, $valor);
    }
} else {
    http_response_code(400);
    echo json_encode([
        'exito' => false,
        'mensaje' => 'Tipo de búsqueda no válido (lineal o binaria)'
    ]);
    exit;
}

// Calcular tiempo de ejecución
$tiempoFin = microtime(true);
$tiempoEjecucion = ($tiempoFin - $tiempoInicio) * 1000; // Convertir a milisegundos

// Preparar respuesta
if ($productoEncontrado !== null) {
    http_response_code(200);
    echo json_encode([
        'exito' => true,
        'mensaje' => 'Producto encontrado',
        'producto' => $productoEncontrado->toArray(),
        'algoritmo' => $tipo,
        'campo' => $campo,
        'tiempo_ms' => round($tiempoEjecucion, 4)
    ], JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404);
    echo json_encode([
        'exito' => false,
        'mensaje' => 'Producto no encontrado',
        'algoritmo' => $tipo,
        'campo' => $campo,
        'tiempo_ms' => round($tiempoEjecucion, 4)
    ], JSON_UNESCAPED_UNICODE);
}
?>
