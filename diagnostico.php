<?php
/**
 * Script de diagnóstico completo para inserción de productos
 * Simula exactamente lo que hace el dashboard
 */

// Habilitar errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Diagnóstico de Inserción de Productos</h1>";
echo "<hr>";

// 1. Verificar sesión
echo "<h2>1. Verificación de Sesión</h2>";
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo "❌ <strong>ERROR:</strong> No hay sesión activa<br>";
    echo "Creando sesión de prueba...<br>";
    $_SESSION['usuario_id'] = 1;
    $_SESSION['username'] = 'SUPERADMIN';
    echo "✅ Sesión creada: usuario_id = 1, username = SUPERADMIN<br>";
} else {
    echo "✅ Sesión activa: usuario_id = {$_SESSION['usuario_id']}, username = {$_SESSION['username']}<br>";
}
echo "<hr>";

// 2. Verificar conexión a base de datos
echo "<h2>2. Verificación de Base de Datos</h2>";
try {
    require_once __DIR__ . '/config/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    
    if ($conn) {
        echo "✅ Conexión a base de datos exitosa<br>";
        
        // Verificar que la tabla productos existe
        $stmt = $conn->query("SHOW TABLES LIKE 'productos'");
        if ($stmt->rowCount() > 0) {
            echo "✅ Tabla 'productos' existe<br>";
            
            // Verificar estructura de la tabla
            $stmt = $conn->query("DESCRIBE productos");
            echo "<strong>Estructura de la tabla:</strong><br>";
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th></tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$row['Field']}</td>";
                echo "<td>{$row['Type']}</td>";
                echo "<td>{$row['Null']}</td>";
                echo "<td>{$row['Key']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "❌ <strong>ERROR:</strong> La tabla 'productos' NO existe<br>";
            echo "Por favor ejecuta: <a href='install.php'>install.php</a><br>";
        }
    } else {
        echo "❌ <strong>ERROR:</strong> No se pudo conectar a la base de datos<br>";
    }
} catch (Exception $e) {
    echo "❌ <strong>ERROR:</strong> " . $e->getMessage() . "<br>";
}
echo "<hr>";

// 3. Verificar modelo Producto
echo "<h2>3. Verificación del Modelo Producto</h2>";
try {
    require_once __DIR__ . '/models/Producto.php';
    $producto = new Producto(999, 'Producto de Prueba', 99.99);
    echo "✅ Modelo Producto cargado correctamente<br>";
    echo "<strong>Datos del producto:</strong><br>";
    echo "<pre>";
    print_r($producto);
    echo "</pre>";
    
    // Validar producto
    $validacion = $producto->validar();
    if ($validacion['valido']) {
        echo "✅ Validación del producto: EXITOSA<br>";
    } else {
        echo "❌ <strong>ERROR en validación:</strong><br>";
        foreach ($validacion['errores'] as $error) {
            echo "- $error<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ <strong>ERROR:</strong> " . $e->getMessage() . "<br>";
}
echo "<hr>";

// 4. Verificar ProductoController
echo "<h2>4. Verificación del ProductoController</h2>";
try {
    require_once __DIR__ . '/controllers/ProductoController.php';
    $controller = new ProductoController();
    echo "✅ ProductoController cargado correctamente<br>";
    
    // Intentar insertar producto
    echo "<h3>Intentando insertar producto...</h3>";
    $resultado = $controller->insertarInicio($producto);
    
    if ($resultado['exito']) {
        echo "✅ <strong>INSERCIÓN EXITOSA</strong><br>";
        echo "Mensaje: {$resultado['mensaje']}<br>";
    } else {
        echo "❌ <strong>ERROR EN INSERCIÓN:</strong><br>";
        echo "Mensaje: {$resultado['mensaje']}<br>";
    }
} catch (Exception $e) {
    echo "❌ <strong>ERROR:</strong> " . $e->getMessage() . "<br>";
    echo "<strong>Stack trace:</strong><br><pre>" . $e->getTraceAsString() . "</pre>";
}
echo "<hr>";

// 5. Mostrar productos actuales
echo "<h2>5. Productos en la Base de Datos</h2>";
try {
    $productos = $controller->obtenerTodos();
    $total = $controller->contarProductos();
    
    echo "<strong>Total de productos:</strong> $total<br><br>";
    
    if (count($productos) > 0) {
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Código</th><th>Nombre</th><th>Precio</th><th>Fecha Creación</th></tr>";
        foreach ($productos as $p) {
            echo "<tr>";
            echo "<td>{$p->id}</td>";
            echo "<td>{$p->codigo}</td>";
            echo "<td>{$p->nombre}</td>";
            echo "<td>\${$p->precio}</td>";
            echo "<td>{$p->fecha_creacion}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No hay productos en la base de datos.<br>";
    }
} catch (Exception $e) {
    echo "❌ <strong>ERROR:</strong> " . $e->getMessage() . "<br>";
}
echo "<hr>";

// 6. Simular petición API
echo "<h2>6. Simulación de Petición API</h2>";
echo "<strong>Datos que enviaría el dashboard:</strong><br>";
$datosAPI = [
    'codigo' => 888,
    'nombre' => 'Test API',
    'precio' => 88.88,
    'tipo' => 'inicio'
];
echo "<pre>";
echo json_encode($datosAPI, JSON_PRETTY_PRINT);
echo "</pre>";

echo "<strong>Procesando...</strong><br>";
$productoAPI = new Producto($datosAPI['codigo'], $datosAPI['nombre'], $datosAPI['precio']);
$resultadoAPI = $controller->insertarInicio($productoAPI);

if ($resultadoAPI['exito']) {
    echo "✅ Inserción vía API simulada: EXITOSA<br>";
} else {
    echo "❌ Inserción vía API simulada: FALLIDA<br>";
    echo "Error: {$resultadoAPI['mensaje']}<br>";
}

echo "<hr>";
echo "<h2>✅ Diagnóstico Completado</h2>";
echo "<p><a href='public/dashboard.html'>Ir al Dashboard</a> | <a href='install.php'>Reinstalar BD</a></p>";
?>
