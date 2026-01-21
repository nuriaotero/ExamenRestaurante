<?php
declare(strict_types=1);
session_start();
/*
|--------------------------------------------------------------------------
| FRONT CONTROLLER
|--------------------------------------------------------------------------
| Punto único de entrada de la aplicación
| Inicializa:
|  - Autoload de Composer
|  - ORM Eloquent
|  - Router
|--------------------------------------------------------------------------
*/

// -------------------------------------------------
// 1. Autoload de Composer
// -------------------------------------------------
require_once __DIR__ . '/vendor/autoload.php';

// -------------------------------------------------
// 2. Configuración e inicialización de Eloquent
// -------------------------------------------------

$dbConfig = require_once __DIR__ . '/config/database.php';



// -------------------------------------------------
// 3. Arranque del Router
// -------------------------------------------------
require_once __DIR__ . '/core/Router.php';

use Core\Router;

$router = new Router();
$router->dispatch();
