<?php
declare(strict_types=1);

namespace Core;

use Core\Middleware\SessionMiddleware;

class Router
{
    protected string $controllerNamespace = 'App\\Controllers';

    public function dispatch(): void
    {
        $url = $_GET['url'] ?? '';
        $url = trim($url, '/');
        $segments = explode('/', $url);

        $controllerName = !empty($segments[0])
            ? ucfirst($segments[0]) . 'Controller'
            : 'HomeController';

        $method = $segments[1] ?? 'index';
        $params = array_slice($segments, 2);

        $controllerClass = $this->controllerNamespace . '\\' . $controllerName;

        if (!class_exists($controllerClass)) {
            die('404 - Controlador no encontrado');
        }

        // 🔐 Middleware de sesión
        $middleware = new SessionMiddleware();
        $middleware->handle($controllerName, $method);

        $controller = new $controllerClass();

        if (!method_exists($controller, $method)) {
            die('404 - Método no encontrado');
        }

        call_user_func_array([$controller, $method], $params);
    }
}
