<?php
/**
 * Script de migración para agregar campo posicion a productos existentes
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Migración: Agregar Campo Posición</h1>";

try {
    require_once __DIR__ . '/../config/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    
    if (!$conn) {
        throw new Exception("No se pudo conectar a la base de datos");
    }
    
    echo "<h2>Verificando estructura actual...</h2>";
    
    // Verificar si el campo posicion ya existe
    $stmt = $conn->query("SHOW COLUMNS FROM productos LIKE 'posicion'");
    
    if ($stmt->rowCount() > 0) {
        echo "✅ El campo 'posicion' ya existe en la tabla productos<br>";
    } else {
        echo "⚠️ El campo 'posicion' NO existe. Agregando...<br>";
        
        // Agregar campo posicion
        $conn->exec("ALTER TABLE productos ADD COLUMN posicion INT NOT NULL DEFAULT 0 AFTER id");
        echo "✅ Campo 'posicion' agregado exitosamente<br>";
        
        // Actualizar posiciones de productos existentes
        echo "<h3>Actualizando posiciones de productos existentes...</h3>";
        $conn->exec("SET @pos = 0");
        $conn->exec("UPDATE productos SET posicion = (@pos := @pos + 1) ORDER BY id");
        echo "✅ Posiciones actualizadas<br>";
        
        // Crear índice
        try {
            $conn->exec("CREATE INDEX idx_posicion ON productos(posicion)");
            echo "✅ Índice creado<br>";
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate key name') !== false) {
                echo "⚠️ El índice ya existe<br>";
            } else {
                throw $e;
            }
        }
    }
    
    echo "<h2>Estructura actualizada:</h2>";
    $stmt = $conn->query("DESCRIBE productos");
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['Field']}</td>";
        echo "<td>{$row['Type']}</td>";
        echo "<td>{$row['Null']}</td>";
        echo "<td>{$row['Key']}</td>";
        echo "<td>{$row['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h2>Productos actuales con posiciones:</h2>";
    $stmt = $conn->query("SELECT id, posicion, codigo, nombre, precio FROM productos ORDER BY posicion");
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Posición</th><th>Código</th><th>Nombre</th><th>Precio</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['posicion']}</td>";
        echo "<td>{$row['codigo']}</td>";
        echo "<td>{$row['nombre']}</td>";
        echo "<td>\${$row['precio']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<hr>";
    echo "<h2>✅ Migración completada exitosamente</h2>";
    echo "<p><a href='../public/dashboard.html'>Ir al Dashboard</a></p>";
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>❌ Error en la migración</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
