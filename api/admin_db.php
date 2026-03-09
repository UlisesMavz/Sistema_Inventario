<?php
/**
 * API de Administración de Base de Datos
 * Endpoint: /api/admin_db.php
 * Maneja operaciones críticas como Vaciar y Rellenar la base de datos
 */

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Incluir dependencias
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../models/Producto.php';

// Verificar autenticación y rol de Administrador
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$authController = new AuthController();
if (!$authController->verificarSesion() || $_SESSION['perfil'] !== 'Administrador') {
    http_response_code(403);
    echo json_encode([
        'exito' => false,
        'mensaje' => 'Acceso denegado. Se requieren permisos de Administrador.'
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

$data = json_decode(file_get_contents("php://input"), true);
$accion = $data['accion'] ?? '';

$db = new Database();
$conn = $db->getConnection();

switch ($accion) {
    case 'wipe':
        // VACIAR LA BD
        $password = $data['password'] ?? '';
        
        if (empty($password)) {
            http_response_code(400);
            echo json_encode(['exito' => false, 'mensaje' => 'La contraseña es obligatoria para esta acción crítica.']);
            exit;
        }
        
        // Validar contraseña del admin actual
        $username = $_SESSION['usuario'];
        $query = "SELECT password_hash FROM usuarios WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        if ($stmt->rowCount() == 0) {
            http_response_code(404);
            echo json_encode(['exito' => false, 'mensaje' => 'Usuario no encontrado.']);
            exit;
        }
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verificar si la contraseña es correcta (Admin de prueba o hash real)
        $password_valida = password_verify($password, $user['password_hash']) || ($username === 'ADMIN' && $password === 'ADMIN');
        
        if (!$password_valida) {
            http_response_code(401);
            echo json_encode(['exito' => false, 'mensaje' => 'Contraseña de administrador incorrecta.']);
            exit;
        }
        
        try {
            // Truncar tabla
            $conn->exec("TRUNCATE TABLE productos");
            http_response_code(200);
            echo json_encode(['exito' => true, 'mensaje' => 'Base de datos vaciada y reiniciada con éxito.']);
        } catch (PDOException $e) {
            error_log("Error al vaciar BD: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['exito' => false, 'mensaje' => 'Error al vaciar BD: ' . $e->getMessage()]);
        }
        break;
        
    case 'seed':
        // RELLENAR LA BD CON DATOS DE PRUEBA
        try {
            $productos_dummy = [
                [101, 'Coca Cola 600ml', 18.50, 45, 10, 'Refrescos y Bebidas', 'Coca-Cola'],
                [102, 'Bimbo Pan Blanco', 45.00, 20, 15, 'Abarrotes', 'Bimbo'],
                [103, 'Leche Alpura Clásica', 28.00, 12, 10, 'Lácteos', 'Alpura'],
                [104, 'Sabritas Saladas 40g', 17.00, 8, 20, 'Botanas', 'Sabritas'],
                [105, 'Jabón Zote Blanco', 22.50, 50, 15, 'Limpieza del Hogar', 'Genérico'],
                [106, 'Laptop Lenovo ThinkPad', 15000.00, 2, 5, 'Electrónica', 'Lenovo'],
                [107, 'Cuaderno Profesional Scribe', 35.00, 100, 30, 'Papelería', 'Scribe'],
                [108, 'Pasta Dental Colgate', 38.00, 25, 10, 'Higiene Personal', 'Colgate'],
                [109, 'Café soluble Nescafé 120g', 85.00, 30, 8, 'Abarrotes', 'Nestlé'],
                [110, 'Yogurt Lala Fresa', 12.50, 60, 20, 'Lácteos', 'Lala'],
                [111, 'Doritos Nacho 50g', 18.00, 3, 15, 'Botanas', 'Sabritas'],
                [112, 'Agua Ciel 1L', 15.00, 80, 20, 'Refrescos y Bebidas', 'Coca-Cola'],
                [113, 'Detergente Ariel 1kg', 46.00, 40, 10, 'Limpieza del Hogar', 'Genérico'],
                [114, 'Mouse Inalámbrico Logitech', 250.00, 15, 5, 'Electrónica', 'Logitech'],
                [115, 'Plumas BIC (Paquete 10)', 55.00, 40, 10, 'Papelería', 'BIC']
            ];
            
            $query = "INSERT IGNORE INTO productos (codigo, nombre, precio, stock, stock_minimo, categoria, marca_proveedor, posicion) 
                      VALUES (:codigo, :nombre, :precio, :stock, :stock_minimo, :categoria, :marca_proveedor, :posicion)";
            
            $stmt = $conn->prepare($query);
            $count = 0;
            
            foreach ($productos_dummy as $index => $prod) {
                $posicion = $index + 1; // 1-indexed para seguir la lógica del sistema
                
                $dataInsert = [
                    ':codigo' => $prod[0],
                    ':nombre' => $prod[1],
                    ':precio' => $prod[2],
                    ':stock' => $prod[3],
                    ':stock_minimo' => $prod[4],
                    ':categoria' => $prod[5],
                    ':marca_proveedor' => $prod[6],
                    ':posicion' => $posicion
                ];
                
                if ($stmt->execute($dataInsert) && $stmt->rowCount() > 0) {
                    $count++;
                }
            }
            
            http_response_code(200);
            echo json_encode([
                'exito' => true, 
                'mensaje' => "BD rellenada con éxito. $count productos insertados.",
                'insertados' => $count
            ]);
            
        } catch (PDOException $e) {
            error_log("Error al rellenar BD: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['exito' => false, 'mensaje' => 'Error al rellenar BD: ' . $e->getMessage()]);
        }
        break;
        
    default:
        http_response_code(400);
        echo json_encode(['exito' => false, 'mensaje' => 'Acción no válida. Se esperaba "wipe" o "seed".']);
}
?>
