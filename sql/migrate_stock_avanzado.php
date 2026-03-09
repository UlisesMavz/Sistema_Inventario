<?php
// Script de migración de Base de Datos para el Sistema de Stock Avanzado
// Ejecutar esto en el navegador: http://localhost/Sistema_Inventario/sql/migrate_stock_avanzado.php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "inventario_db";

echo "<style>body{font-family: sans-serif; padding: 2em; background: #f0f2f5;} .box{background: white; padding: 2em; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);}</style>";
echo "<div class='box'>";
echo "<h1>📦 Migración de DB: Sistema de Stock Avanzado</h1>";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Lista de columnas a agregar
    $columnas = [
        "stock" => "INT NOT NULL DEFAULT 0",
        "stock_minimo" => "INT NOT NULL DEFAULT 5",
        "categoria" => "VARCHAR(100) NOT NULL DEFAULT 'General'",
        "marca_proveedor" => "VARCHAR(100) NOT NULL DEFAULT 'Genérico'"
    ];

    foreach ($columnas as $columna => $definicion) {
        // Verificar si la columna ya existe
        $stmt = $conn->prepare("SHOW COLUMNS FROM productos LIKE ?");
        $stmt->execute([$columna]);
        
        if ($stmt->rowCount() == 0) {
            // La columna no existe, agregarla
            $query = "ALTER TABLE productos ADD COLUMN $columna $definicion";
            $conn->exec($query);
            echo "<p style='color: green;'>✅ Columna <strong>$columna</strong> agregada exitosamente.</p>";
        } else {
            echo "<p style='color: gray;'>ℹ️ La columna <strong>$columna</strong> ya existe, se omitió.</p>";
        }
    }
    
    echo "<h2>✨ Migración completada con éxito</h2>";
    echo "<p>Tu base de datos ahora está lista para el nuevo sistema de Stock, Categorías y Marcas.</p>";
    
} catch(PDOException $e) {
    echo "<h2 style='color: red;'>❌ Error de Migración</h2>";
    echo "<p>Detalle técnico: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<br><a href='../public/index.html' style='background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;'>Ir al Sistema</a>";
echo "</div>";
?>
