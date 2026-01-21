<?php
declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use App\Models\Mesa;

class MesaController extends Controller
{
    /**
     * Listar todas las mesas activas
     */
    public function index(): void
    {
        // Verificar autenticación
        if (!isset($_SESSION['usuario_id'])) {
            $this->redirect(BASE_URL . '?url=auth/login');
            return;
        }

        $mesas = Mesa::where('activa', true)->get();

        $this->view('mesa/index', [
            'titulo' => 'Mesas Disponibles',
            'mesas' => $mesas,
        ]);
    }

    /**
     * Ver detalles de una mesa
     */
    public function ver(int $id): void
    {
        // Verificar autenticación
        if (!isset($_SESSION['usuario_id'])) {
            $this->redirect(BASE_URL . '?url=auth/login');
            return;
        }

        $mesa = Mesa::find($id);

        if (!$mesa) {
            die('404 - Mesa no encontrada');
        }

        $this->view('mesa/ver', [
            'titulo' => 'Detalles de la Mesa',
            'mesa' => $mesa,
        ]);
    }
}
