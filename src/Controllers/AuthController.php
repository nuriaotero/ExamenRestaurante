<?php
declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use App\Models\Usuario;


class AuthController extends Controller
{
    public function login(): void
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $this->procesar();
            return;
        }
        $this->view('auth/login', []);
    }

    public function register(): void
    {
        if (isset($_POST['email']) && isset($_POST['nombre_completo']) && isset($_POST['password'])) {
            //procesar registro
            try {
                // Generar username único
                $base_username = explode('@', $_POST['email'])[0];
                $username = $base_username;
                $counter = 1;
                while (Usuario::where('username', $username)->exists()) {
                    $username = $base_username . $counter;
                    $counter++;
                }
                
                $usuario = new Usuario();
                $usuario->email = $_POST['email'];
                $usuario->nombre_completo = $_POST['nombre_completo'];
                $usuario->username = $username;
                $usuario->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $usuario->activo = 1;
                $usuario->save();
                
                // Redirigir al login con mensaje de éxito
                $_SESSION['registro_exitoso'] = true;
                header('Location: ' . BASE_URL . '?url=auth/login');
                exit;
            } catch (\Exception $e) {
                error_log('Error de registro: ' . $e->getMessage());
                $this->view('auth/register', [
                    'error' => 'Error al registrar el usuario: ' . $e->getMessage()
                ]);
                return;
            }
        }
        $this->view('auth/register', []);
    }
    private function procesar(): void
    {
        //usar el modelo User para validar el login
        //buscar usuario por email
        $usuario = Usuario::where('email', $_POST['email'])->first();
        
        if ($usuario && password_verify($_POST['password'], $usuario->password)) {
            // Credenciales correctas
            $_SESSION['usuario_id'] = $usuario->id;
            $_SESSION['usuario_nombre'] = $usuario->nombre_completo;
            
            // Debug
            error_log('✅ Login exitoso para: ' . $_POST['email']);
            error_log('   Usuario ID: ' . $usuario->id);
            error_log('   Session usuario_id: ' . $_SESSION['usuario_id']);
            
            header('Location: ' . BASE_URL . '?url=reserva/index');
            exit;
        } else {
            // Credenciales incorrectas
            error_log('❌ Login fallido para: ' . $_POST['email']);
            if (!$usuario) {
                error_log('   Razón: Usuario no encontrado');
            } else {
                error_log('   Razón: Contraseña incorrecta');
            }
            
            $this->view('auth/login', [
                'error' => 'Email o contraseña incorrectos.'
            ]);
        }
    }

    public function logout(): void
    {
        // Destruir la sesión
        session_destroy();
        header('Location: ' . BASE_URL);
        exit;
    }   


}
