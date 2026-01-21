<?php
// Script para insertar datos de prueba (las tablas ya existen)

require_once 'vendor/autoload.php';
require_once 'config/database.php';

// Conexión directa a MySQL
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conexion->connect_error) {
    die('❌ Error de conexión: ' . $conexion->connect_error);
}

// Insertar mesas
$conexion->query("
    INSERT IGNORE INTO mesas (numero, plazas, activa) VALUES
    (1, 2, 1),
    (2, 2, 1),
    (3, 4, 1),
    (4, 4, 1),
    (5, 6, 1),
    (6, 6, 1)
");

// Insertar tramos horarios
$conexion->query("
    INSERT IGNORE INTO tramos_horarios (nombre, hora_inicio, hora_fin, activo) VALUES
    ('Comida', '13:00', '15:00', 1),
    ('Merienda', '17:00', '19:00', 1),
    ('Cena', '20:00', '23:00', 1),
    ('Brunch', '11:00', '13:00', 1)
");

echo "✅ Datos de prueba insertados correctamente\n";
echo "📊 Mesas: 6\n";
echo "⏰ Tramos horarios: 4\n";

$conexion->close();
?>

