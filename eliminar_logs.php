<?php
// Configuración de conexión
$host = "localhost";
$username = "root";
$password = "";
$dbname = "inventario_db";

echo "<style>body{font-family: sans-serif; padding: 2em; background: #f0f2f5;} .box{background: white; padding: 2em; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);}</style>";
echo "<div class='box'>";
echo "<h1>🗑️ Eliminación de Tabla de Logs</h1>";

try {
    // 1. Conectar a MySQL
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 2. Eliminar la tabla logs
    $query = "DROP TABLE IF EXISTS logs";
    $conn->exec($query);
    
    echo "<p style='color: green;'>✅ <strong>¡Éxito!</strong> La tabla <code>logs</code> ha sido eliminada permanentemente de la base de datos <code>inventario_db</code>.</p>";
    echo "<p>El sistema ahora funciona de manera completamente silenciosa sin generar historial de actividad.</p>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>❌ <strong>Error:</strong> No se pudo eliminar la tabla o conectarse a la base de datos.</p>";
    echo "<p>Detalle técnico: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<br><a href='public/index.html' style='background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;'>Volver al Sistema</a>";
echo "</div>";
?>
