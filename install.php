<?php
// Script de instalación automática para el Sistema de Inventario
// Ejecutar esto en el navegador: http://localhost/Sistema_Inventario/install.php

// Configuración de conexión (XAMPP por defecto)
$host = "localhost";
$username = "root";
$password = "";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalación - HA&amp;KU Inventario</title>

    <!-- Importar fuentes HA&KU -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Cinzel:wght@400;600&family=Jost:wght@300;400;500&display=swap');

        :root {
            --ink: #1a1410;
            --parchment: #f7f3ee;
            --cream: #faf7f2;
            --accent: #6b4f35;
            --success-color: #2b6140;
            --danger-color: #8b3030;
            --line: rgba(26,20,16,0.15);
            --radius: 2px;
            --shadow-lg: 0 8px 40px rgba(26,20,16,0.12);
        }

        body {
            font-family: 'Jost', sans-serif;
            background-color: var(--cream);
            color: var(--ink);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
            background-image: 
                radial-gradient(ellipse at 20% 20%, rgba(107,79,53,0.06) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 80%, rgba(107,79,53,0.05) 0%, transparent 60%);
        }

        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
            opacity: 0.4;
            z-index: -1;
            pointer-events: none;
        }

        .botanical-bg {
            position: fixed; inset: 0; width: 100%; height: 100vh; pointer-events: none; z-index: -2;
        }

        .install-card {
            background: var(--parchment);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 40px;
            width: 100%;
            max-width: 600px;
            box-shadow: var(--shadow-lg);
            position: relative;
            z-index: 10;
        }

        h1, h2, h3 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 400;
            color: var(--ink);
            margin-top: 0;
            margin-bottom: 20px;
        }

        h1 { font-size: clamp(24px, 5vw, 32px); text-align: center; }
        h2 { font-size: clamp(20px, 4vw, 24px); margin-top: 30px; border-top: 1px solid var(--line); padding-top: 20px; }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0 0 20px 0;
        }

        li {
            padding: 12px 16px;
            margin-bottom: 8px;
            background: rgba(43,97,64,0.05);
            border-left: 3px solid var(--success-color);
            border-radius: var(--radius);
            font-size: 14px;
        }

        li.error {
            background: rgba(139,48,48,0.05);
            border-color: var(--danger-color);
        }

        .credentials {
            background: var(--cream);
            border: 1px solid var(--line);
            padding: 20px;
            border-radius: var(--radius);
            text-align: center;
            margin-bottom: 30px;
        }

        .credentials strong { font-family: 'Cinzel', serif; letter-spacing: 0.1em; }

        .btn-submit {
            width: 100%;
            padding: 15px 24px;
            background: var(--ink);
            color: var(--parchment);
            border: none;
            border-radius: var(--radius);
            font-family: 'Cinzel', serif;
            font-size: 13px;
            font-weight: 400;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background: var(--accent);
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(107,79,53,0.25);
        }

        @media (max-width: 480px) {
            .install-card { padding: 24px 20px; }
        }
    </style>
</head>
<body>

  <!-- Botanical Background SVG -->
  <svg class="botanical-bg" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
    <g opacity="0.07" transform="translate(-40, -60)">
      <path d="M80,180 Q120,120 160,100 Q200,80 220,120 Q240,160 200,180 Q160,200 120,170 Q90,150 80,180Z" fill="none" stroke="#3d342a" stroke-width="1.5"/>
      <path d="M80,180 Q60,220 40,260" fill="none" stroke="#3d342a" stroke-width="1"/>
      <path d="M120,170 Q100,210 90,250" fill="none" stroke="#3d342a" stroke-width="0.8"/>
      <circle cx="150" cy="50" r="2" fill="#3d342a"/>
      <path d="M150,50 Q145,30 148,20" fill="none" stroke="#3d342a" stroke-width="1"/>
      <path d="M150,50 Q155,30 158,20" fill="none" stroke="#3d342a" stroke-width="1"/>
    </g>
    <g opacity="0.07" transform="translate(1300, 720)">
      <path d="M0,80 Q40,40 80,20 Q120,0 140,40 Q160,80 120,100 Q80,120 40,90Z" fill="none" stroke="#3d342a" stroke-width="1.5"/>
      <path d="M80,60 Q60,100 50,140" fill="none" stroke="#3d342a" stroke-width="1"/>
    </g>
  </svg>

<div class="install-card">
    <h1>🚀 Instalación HA&amp;KU</h1>

<?php
try {
    // 1. Conectar a MySQL sin seleccionar base de datos
    $conn = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<ul>";
    
    // 2. Crear base de datos si no existe
    $conn->exec("CREATE DATABASE IF NOT EXISTS inventario_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<li>✅ Base de datos 'inventario_db' verificada.</li>";
    
    // 3. Seleccionar base de datos
    $conn->exec("USE inventario_db");
    
    // 4. Leer y ejecutar schema.sql
    $sqlFile = __DIR__ . '/sql/schema.sql';
    if (!file_exists($sqlFile)) {
        throw new Exception("No se encontró el archivo sql/schema.sql");
    }
    
    $sqlContent = file_get_contents($sqlFile);
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
                 echo "<li class='error'>⚠️ Ejecutando: " . htmlspecialchars(substr($query, 0, 50)) . "... (" . $e->getMessage() . ")</li>";
            }
        }
    }
    
    echo "<li>✅ Tablas y relaciones creadas exitosamente.</li>";
    echo "</ul>";

    echo "<h2>✨ Sistema Preparado</h2>";
    echo "<div class='credentials'>";
    echo "<p>Credenciales de acceso super-administrador:</p>";
    echo "<p>Usuario: <strong>ADMIN</strong><br>Contraseña: <strong>ADMIN</strong></p>";
    echo "</div>";

    echo "<a href='public/index.html' class='btn-submit'>Ir al Login del Sistema</a>";
    
} catch(PDOException $e) {
    echo "<h2>❌ Error de Base de Datos</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p>Verifica que XAMPP (MySQL) esté iniciado.</p>";
} catch(Exception $e) {
    echo "<h2>❌ Error General</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>

</div>
</body>
</html>
