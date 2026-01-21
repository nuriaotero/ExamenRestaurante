<?php
declare(strict_types=1);

namespace Core;

class Controller
{
    /**
     * Carga una vista y le pasa datos
     *
     * @param string $view  Ruta de la vista (sin .php)
     *                      Ej: 'home/index'
     * @param array  $data  Datos para la vista
     */
    protected function view(string $view, array $data = []): void
    {
        // -------------------------------------------------
        // 1. Convertir array de datos en variables
        // -------------------------------------------------
        // Agregar BASE_URL a los datos si no está ya
        if (!isset($data['BASE_URL'])) {
            $data['BASE_URL'] = BASE_URL;
        }
        
        extract($data);

        // -------------------------------------------------
        // 2. Rutas de las vistas
        // -------------------------------------------------
        $viewFile   = __DIR__ . '/../src/Views/' . $view . '.php';
        

        if (!file_exists($viewFile)) {
            die("❌ Vista no encontrada: $view");
        }

       

        require_once $viewFile;

    }

    /**
     * Redirección HTTP
     */
    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}
