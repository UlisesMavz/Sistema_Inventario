<?php
/**
 * API de Login
 * Endpoint: POST /api/login.php
 * Maneja la autenticación de usuarios
 */

// Headers para permitir CORS y definir tipo de contenido
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Incluir controlador de autenticación
require_once __DIR__ . '/../controllers/AuthController.php';

// Solo permitir método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'exito' => false,
        'mensaje' => 'Método no permitido. Use POST'
    ]);
    exit;
}

// Obtener datos del cuerpo de la petición
$data = json_decode(file_get_contents("php://input"), true);

// Validar que se recibieron los datos necesarios
if (!isset($data['username']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode([
        'exito' => false,
        'mensaje' => 'Faltan datos requeridos (username, password)'
    ]);
    exit;
}

// Crear instancia del controlador
$authController = new AuthController();

// Intentar login
$resultado = $authController->login($data['username'], $data['password']);

// Establecer código de respuesta HTTP
if ($resultado['exito']) {
    http_response_code(200);
} else {
    http_response_code(401);
}

// Retornar respuesta en JSON
echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>
