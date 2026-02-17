<?php
// Script de prueba para insertar producto
session_start();

// Simular sesión de usuario
$_SESSION['usuario_id'] = 1;
$_SESSION['username'] = 'SUPERADMIN';

require_once __DIR__ . '/controllers/ProductoController.php';
require_once __DIR__ . '/models/Producto.php';

echo "<h2>Prueba de Inserción de Producto</h2>";

// Crear producto de prueba
$producto = new Producto(999, 'Producto de Prueba', 99.99);

// Crear controlador
$controller = new ProductoController();

// Intentar insertar
echo "<h3>Insertando producto...</h3>";
echo "<pre>";
print_r($producto);
echo "</pre>";

$resultado = $controller->insertarInicio($producto);

echo "<h3>Resultado:</h3>";
echo "<pre>";
print_r($resultado);
echo "</pre>";

// Verificar productos
echo "<h3>Productos en la base de datos:</h3>";
$productos = $controller->obtenerTodos();
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Código</th><th>Nombre</th><th>Precio</th></tr>";
foreach ($productos as $p) {
    echo "<tr>";
    echo "<td>{$p->id}</td>";
    echo "<td>{$p->codigo}</td>";
    echo "<td>{$p->nombre}</td>";
    echo "<td>{$p->precio}</td>";
    echo "</tr>";
}
echo "</table>";
?>
