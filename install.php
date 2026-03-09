<?php
// Script de instalación automática para el Sistema de Inventario
// Ejecutar esto en el navegador: http://localhost/Sistema_Inventario/install.php

// Configuración de conexión (XAMPP por defecto)
$host = "localhost";
$username = "root";
$password = "";

try {
    // 1. Conectar a MySQL sin seleccionar base de datos
    $conn = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<style>body{font-family: sans-serif; padding: 2em; background: #f0f2f5;} ul{background: white; padding: 2em; border-radius: 8px;} li{margin: 0.5em 0;}</style>";
    echo "<h1>🚀 Instalación del Sistema de Inventario</h1>";
    echo "<ul>";
    
    // 2. Crear base de datos si no existe
    $conn->exec("CREATE DATABASE IF NOT EXISTS inventario_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<li>✅ Base de datos 'inventario_db' creada o verificada.</li>";
    
    // 3. Seleccionar base de datos
    $conn->exec("USE inventario_db");
    
    // 4. Leer y ejecutar schema.sql
    // Dividimos por ; para ejecutar instrucción por instrucción de forma segura
    $sqlFile = __DIR__ . '/sql/schema.sql';
    if (!file_exists($sqlFile)) {
        throw new Exception("No se encontró el archivo sql/schema.sql");
    }
    
    $sqlContent = file_get_contents($sqlFile);
    // Eliminar comentarios para evitar problemas al dividir
    $lines = explode("\n", $sqlContent);
    $cleanSql = "";
    foreach ($lines as $line) {
        if (substr(trim($line), 0, 2) != '--' && substr(trim($line), 0, 1) != '#') {
            $cleanSql .= $line . "\n";
        }
    }
    
    $queries = explode(';', $cleanSql);
    
    foreach ($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            try {
                $conn->exec($query);
            } catch (PDOException $e) {
                // Ignorar errores menores en inserciones duplicadas si es re-instalación
                 echo "<li>⚠️ Ejecutando: " . htmlspecialchars(substr($query, 0, 50)) . "... (" . $e->getMessage() . ")</li>";
            }
        }
    }
    
    echo "<li>✅ Tablas creadas (usuarios, productos, logs) y datos de ejemplo insertados.</li>";
    
    echo "</ul>";
    echo "<h2>✨ Instalación completada con éxito</h2>";
    echo "<p><strong>Credenciales de acceso:</strong></p>";
    echo "<p>Usuario: <strong>ADMIN</strong><br>Contraseña: <strong>ADMIN</strong></p>";
    echo "<p><a href='public/index.html' style='background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;'>Ir al Login del Sistema</a></p>";
    
} catch(PDOException $e) {
    echo "<h2>❌ Error de conexión o base de datos</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p>Verifica que XAMPP (MySQL) esté iniciado.</p>";
} catch(Exception $e) {
    echo "<h2>❌ Error General</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>
