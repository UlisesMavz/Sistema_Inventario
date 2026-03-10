<?php
/**
 * API de Logout
 * Endpoint: POST /api/logout.php
 * Destruye la sesión PHP del servidor
 */

header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-cache, no-store, must-revalidate');

require_once __DIR__ . '/../controllers/AuthController.php';

$authController = new AuthController();
$resultado = $authController->logout();

http_response_code(200);
echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>
