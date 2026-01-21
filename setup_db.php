<?php
/**
 * Script para verificar y crear las tablas necesarias
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';

use Illuminate\Database\Capsule\Manager as DB;

// Verificar conexión
try {
    DB::connection()->getPdo();
    echo "✅ Conexión a base de datos exitosa\n\n";
} catch (Exception $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}

// SQL para crear las tablas
$sql = <<<SQL
-- Tabla usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `usuario_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL UNIQUE,
  `nombre` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla mesas
CREATE TABLE IF NOT EXISTS `mesas` (
  `mesa_id` int NOT NULL AUTO_INCREMENT,
  `numero` int NOT NULL UNIQUE,
  `plazas` int NOT NULL,
  `activa` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mesa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla tramos_horarios
CREATE TABLE IF NOT EXISTS `tramos_horarios` (
  `tramo_id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tramo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla reservas
CREATE TABLE IF NOT EXISTS `reservas` (
  `reserva_id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `mesa_id` int NOT NULL,
  `tramo_id` int NOT NULL,
  `fecha_reserva` date NOT NULL,
  `numero_personas` int NOT NULL,
  `comentarios` text,
  `estado` enum('confirmada','cancelada') DEFAULT 'confirmada',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`reserva_id`),
  FOREIGN KEY (`usuario_id`) REFERENCES `usuario`(`usuario_id`) ON DELETE CASCADE,
  FOREIGN KEY (`mesa_id`) REFERENCES `mesas`(`mesa_id`) ON DELETE CASCADE,
  FOREIGN KEY (`tramo_id`) REFERENCES `tramos_horarios`(`tramo_id`) ON DELETE CASCADE,
  UNIQUE KEY `unique_reservation` (`mesa_id`, `tramo_id`, `fecha_reserva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL;

// Ejecutar SQL
$statements = array_filter(array_map('trim', explode(';', $sql)));

foreach ($statements as $statement) {
    if (!empty($statement)) {
        try {
            DB::statement($statement);
            echo "✅ Ejecutado: " . substr($statement, 0, 50) . "...\n";
        } catch (Exception $e) {
            echo "⚠️  Error: " . $e->getMessage() . "\n";
        }
    }
}

echo "\n✅ Tablas verificadas/creadas correctamente\n";

// Insertar datos de prueba
echo "\n📝 Insertando datos de prueba...\n";

// Verificar si ya existen usuarios
$userCount = DB::table('usuario')->count();
if ($userCount == 0) {
    // Insertar usuario de prueba
    DB::table('usuario')->insert([
        'email' => 'admin@test.com',
        'nombre' => 'Admin Test',
        'password' => password_hash('123456', PASSWORD_BCRYPT),
    ]);
    echo "✅ Usuario de prueba creado: admin@test.com / 123456\n";
} else {
    echo "ℹ️  Ya existen usuarios en la BD\n";
}

// Insertar mesas si no existen
$mesaCount = DB::table('mesas')->count();
if ($mesaCount == 0) {
    DB::table('mesas')->insert([
        ['numero' => 1, 'plazas' => 2],
        ['numero' => 2, 'plazas' => 2],
        ['numero' => 3, 'plazas' => 4],
        ['numero' => 4, 'plazas' => 4],
        ['numero' => 5, 'plazas' => 6],
        ['numero' => 6, 'plazas' => 8],
    ]);
    echo "✅ Mesas creadas (6 mesas)\n";
} else {
    echo "ℹ️  Ya existen mesas en la BD\n";
}

// Insertar tramos horarios si no existen
$tramoCount = DB::table('tramos_horarios')->count();
if ($tramoCount == 0) {
    DB::table('tramos_horarios')->insert([
        ['nombre' => 'Comida 12:00', 'hora_inicio' => '12:00:00', 'hora_fin' => '14:00:00'],
        ['nombre' => 'Comida 14:00', 'hora_inicio' => '14:00:00', 'hora_fin' => '16:00:00'],
        ['nombre' => 'Cena 19:00', 'hora_inicio' => '19:00:00', 'hora_fin' => '21:00:00'],
        ['nombre' => 'Cena 21:00', 'hora_inicio' => '21:00:00', 'hora_fin' => '23:00:00'],
    ]);
    echo "✅ Tramos horarios creados (4 tramos)\n";
} else {
    echo "ℹ️  Ya existen tramos horarios en la BD\n";
}

echo "\n✅ ¡Sistema de base de datos listo!\n";
?>
