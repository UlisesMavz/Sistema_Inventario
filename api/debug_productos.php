<?php
// Verificación rápida de productos
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Producto.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    // Verificar si existe el campo posicion
    $stmt = $conn->query("SHOW COLUMNS FROM productos LIKE 'posicion'");
    $tienePosicion = $stmt->rowCount() > 0;
    
    // Obtener productos
    $query = "SELECT * FROM productos ORDER BY " . ($tienePosicion ? "posicion" : "id") . " ASC LIMIT 5";
    $stmt = $conn->query($query);
    $productos = [];
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $productos[] = $row;
    }
    
    echo json_encode([
        'tiene_posicion' => $tienePosicion,
        'total' => count($productos),
        'productos' => $productos
    ], JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    echo json_encode([
        'error' => $e->getMessage()
    ]);
}
?>
