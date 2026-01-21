<?php
declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use App\Models\Reserva;
use App\Models\Mesa;
use App\Models\TramoHorario;

class ReservaController extends Controller
{
    /**
     * Listar reservas del usuario autenticado
     */
    public function index(): void
    {
        // Verificar autenticación
        if (!isset($_SESSION['usuario_id'])) {
            $this->redirect(BASE_URL . '?url=auth/login');
            return;
        }

        $usuario_id = $_SESSION['usuario_id'];
        $reservas = Reserva::where('usuario_id', $usuario_id)
            ->orderBy('fecha_reserva', 'DESC')
            ->get();

        // Enriquecer con datos de mesa y tramo
        $reservas_enriquecidas = [];
        foreach ($reservas as $reserva) {
            $mesa = Mesa::find($reserva->mesa_id);
            $tramo = TramoHorario::find($reserva->tramo_horario_id);
            $reservas_enriquecidas[] = [
                'reserva' => $reserva,
                'mesa' => $mesa,
                'tramo' => $tramo
            ];
        }

        $this->view('reserva/index', [
            'titulo' => 'Mis Reservas',
            'reservas' => $reservas_enriquecidas,
        ]);
    }

    /**
     * Ver detalles de una reserva
     */
    public function ver(int $id): void
    {
        // Verificar autenticación
        if (!isset($_SESSION['usuario_id'])) {
            $this->redirect(BASE_URL . '?url=auth/login');
            return;
        }

        $reserva = Reserva::find($id);

        if (!$reserva || $reserva->usuario_id != $_SESSION['usuario_id']) {
            die('404 - Reserva no encontrada o no autorizado');
        }

        $mesa = Mesa::find($reserva->mesa_id);
        $tramo = TramoHorario::find($reserva->tramo_horario_id);

        $this->view('reserva/ver', [
            'titulo' => 'Detalles de la Reserva',
            'reserva' => $reserva,
            'mesa' => $mesa,
            'tramo' => $tramo,
        ]);
    }

    /**
     * Crear nueva reserva
     */
    public function crear(): void
    {
        // Verificar autenticación
        if (!isset($_SESSION['usuario_id'])) {
            $this->redirect(BASE_URL . '?url=auth/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario_id = $_SESSION['usuario_id'];
            $mesa_id = (int)$_POST['mesa_id'];
            $tramo_horario_id = (int)$_POST['tramo_horario_id'];
            $fecha_reserva = $_POST['fecha_reserva'];
            $numero_personas = (int)$_POST['numero_personas'];
            $comentarios = $_POST['comentarios'] ?? '';

            // Verificar que la mesa no esté reservada en esa fecha/tramo
            $existe = Reserva::where('mesa_id', $mesa_id)
                ->where('tramo_horario_id', $tramo_horario_id)
                ->where('fecha_reserva', $fecha_reserva)
                ->where('estado', '!=', 'cancelada')
                ->first();

            if ($existe) {
                $error = 'Esta mesa ya está reservada para esa fecha y horario';
                $mesas = Mesa::where('activa', true)->get();
                $tramos = TramoHorario::where('activo', true)->get();

                $this->view('reserva/crear', [
                    'titulo' => 'Nueva Reserva',
                    'mesas' => $mesas,
                    'tramos' => $tramos,
                    'error' => $error,
                ]);
                return;
            }

            // Crear reserva
            $reserva = new Reserva();
            $reserva->usuario_id = $usuario_id;
            $reserva->mesa_id = $mesa_id;
            $reserva->tramo_horario_id = $tramo_horario_id;
            $reserva->fecha_reserva = $fecha_reserva;
            $reserva->numero_personas = $numero_personas;
            $reserva->comentarios = $comentarios;
            $reserva->estado = 'confirmada';
            $reserva->save();

            $_SESSION['mensaje'] = 'Reserva creada correctamente';
            $this->redirect(BASE_URL . '?url=reserva/index');
            return;
        }

        $mesas = Mesa::where('activa', true)->get();
        $tramos = TramoHorario::where('activo', true)->get();

        $this->view('reserva/crear', [
            'titulo' => 'Nueva Reserva',
            'mesas' => $mesas,
            'tramos' => $tramos,
        ]);
    }

    /**
     * Editar reserva
     */
    public function editar(int $id): void
{
    // Verificar autenticación
    if (!isset($_SESSION['usuario_id'])) {
        $this->redirect(BASE_URL . '?url=auth/login');
        return;
    }

    $reserva = Reserva::find($id);

    if (!$reserva || $reserva->usuario_id != $_SESSION['usuario_id']) {
        die('404 - Reserva no encontrada o no autorizado');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Capturar datos del formulario
        $mesa_id = (int)($_POST['mesa_id'] ?? 0);
        $tramo_horario_id = (int)($_POST['tramo_horario_id'] ?? 0);
        $fecha_reserva = $_POST['fecha_reserva'] ?? '';
        $numero_personas = (int)($_POST['numero_personas'] ?? 1);
        $comentarios = $_POST['comentarios'] ?? '';

        // Validaciones básicas
        if (!$mesa_id || !$tramo_horario_id || !$fecha_reserva) {
            $error = 'Todos los campos de mesa, fecha y horario son obligatorios.';
        } else {
            // Verificar que la nueva combinación no exista en otra reserva
            $existe = Reserva::where('mesa_id', $mesa_id)
                ->where('tramo_horario_id', $tramo_horario_id)
                ->where('fecha_reserva', $fecha_reserva)
                ->where('estado', '!=', 'cancelada')
                ->where('id', '!=', $id) // Excluir la reserva actual
                ->first();

            if ($existe) {
                $error = 'Esta mesa ya está reservada para esa fecha y horario';
            }
        }

        if (isset($error)) {
            $mesas = Mesa::where('activa', true)->get();
            $tramos = TramoHorario::where('activo', true)->get();
            $mesa = Mesa::find($reserva->mesa_id);
            $tramo = TramoHorario::find($reserva->tramo_horario_id);

            $this->view('reserva/editar', [
                'titulo' => 'Editar Reserva',
                'reserva' => $reserva,
                'mesa' => $mesa,
                'tramo' => $tramo,
                'mesas' => $mesas,
                'tramos' => $tramos,
                'error' => $error,
            ]);
            return;
        }

        // Actualizar la reserva
        $reserva->mesa_id = $mesa_id;
        $reserva->tramo_horario_id = $tramo_horario_id;
        $reserva->fecha_reserva = $fecha_reserva;
        $reserva->numero_personas = $numero_personas;
        $reserva->comentarios = $comentarios;
        $reserva->save();

        $_SESSION['mensaje'] = 'Reserva actualizada correctamente';
        $this->redirect(BASE_URL . '?url=reserva/index');
        return;
    }

    // Datos para el formulario de edición
    $mesas = Mesa::where('activa', true)->get();
    $tramos = TramoHorario::where('activo', true)->get();
    $mesa = Mesa::find($reserva->mesa_id);
    $tramo = TramoHorario::find($reserva->tramo_horario_id);

    $this->view('reserva/editar', [
        'titulo' => 'Editar Reserva',
        'reserva' => $reserva,
        'mesa' => $mesa,
        'tramo' => $tramo,
        'mesas' => $mesas,
        'tramos' => $tramos,
    ]);
}


    /**
     * Cancelar reserva
     */
    public function cancelar(int $id): void
    {
        // Verificar autenticación
        if (!isset($_SESSION['usuario_id'])) {
            $this->redirect(BASE_URL . '?url=auth/login');
            return;
        }

        $reserva = Reserva::find($id);

        if (!$reserva || $reserva->usuario_id != $_SESSION['usuario_id']) {
            die('404 - Reserva no encontrada o no autorizado');
        }

        $reserva->estado = 'cancelada';
        $reserva->save();

        $_SESSION['mensaje'] = 'Reserva cancelada correctamente';
        $this->redirect(BASE_URL . '?url=reserva/index');
    }
}
