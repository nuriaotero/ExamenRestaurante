<?php
/**
 * Script para debuggear el login
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';

use App\Models\Usuario;

// Simular el POST del login
$_POST['email'] = 'admin@test.com';
$_POST['password'] = '123456';

echo "🔍 Debuggear Login\n";
echo "==================\n\n";

echo "1️⃣ POST Data:\n";
echo "   Email: " . $_POST['email'] . "\n";
echo "   Password: " . $_POST['password'] . "\n\n";

echo "2️⃣ Buscando usuario...\n";
$usuario = Usuario::where('email', $_POST['email'])->first();

if ($usuario) {
    echo "   ✅ Usuario encontrado\n";
    echo "   ID: " . $usuario->id . "\n";
    echo "   Email: " . $usuario->email . "\n";
    echo "   Nombre: " . $usuario->nombre_completo . "\n";
    echo "   Password hash: " . substr($usuario->password, 0, 30) . "...\n\n";
    
    echo "3️⃣ Verificando contraseña...\n";
    if (password_verify($_POST['password'], $usuario->password)) {
        echo "   ✅ Contraseña correcta\n";
        echo "   Login exitoso - debería redirigir a reserva/index\n";
    } else {
        echo "   ❌ Contraseña incorrecta\n";
    }
} else {
    echo "   ❌ Usuario NO encontrado\n";
}
?>
