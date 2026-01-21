<?php
declare(strict_types=1);

namespace Core\Middleware;

class SessionMiddleware
{
    /**
     * Controladores públicos (sin login)
     */
    protected array $publicControllers = [
        'HomeController',
        'AuthController'
    ];

    /**
     * Métodos públicos concretos (opcional)
     * Ej: LoginController@index
     */
    protected array $publicMethods = [
        'AuthController@login',
        'AuthController@register'
    ];

    public function handle(string $controller, string $method): void
    {
        error_log("🔍 Middleware: Controller=$controller, Method=$method");
        error_log("   usuario_id en sesión: " . (isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 'NO'));
        
        // Si el controlador es público → pasar
        if (in_array($controller, $this->publicControllers)) {
            error_log("   ✅ Controlador público, permitido");
            return;
        }

        // Si el método concreto es público → pasar
        if (in_array("$controller@$method", $this->publicMethods)) {
            error_log("   ✅ Método público, permitido");
            return;
        }

        // Comprobamos sesión
        if (!$this->isAuthenticated()) {
            error_log("   ❌ No autenticado, redirigiendo a HOME");
            header('Location: ' . BASE_URL);
            exit;
        }
        
        error_log("   ✅ Autenticado, permitido");
    }

    protected function isAuthenticated(): bool
    {
        return isset($_SESSION['usuario_id']);
    }
}
