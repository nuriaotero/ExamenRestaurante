<?php

use Illuminate\Database\Capsule\Manager as Capsule;
require_once __DIR__ . '/../config.php';

// Crear instancia de Eloquent
$capsule = new Capsule;

// Configuración de la base de datos
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => DB_HOST,
    'database'  => DB_NAME,
    'username'  => DB_USER,
    'password'  => DB_PASS,
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Hacer Eloquent global
$capsule->setAsGlobal();

// Iniciar Eloquent
$capsule->bootEloquent();