<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Reservas de Restaurante</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .container { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); max-width: 400px; width: 100%; }
        h1 { color: #333; margin-bottom: 30px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #555; font-weight: bold; }
        input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 5px rgba(102, 126, 234, 0.3); }
        button { width: 100%; padding: 12px; background: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; }
        button:hover { background: #5568d3; }
        .error { color: #dc3545; margin-bottom: 20px; padding: 12px; background: #f8d7da; border-radius: 5px; }
        .register-link { text-align: center; margin-top: 20px; }
        .register-link a { color: #667eea; text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Iniciar Sesión</h1>
        <?php if (isset($_SESSION['registro_exitoso'])): ?>
            <div style="color: #155724; margin-bottom: 20px; padding: 12px; background: #d4edda; border-radius: 5px;">
                ✅ ¡Registro exitoso! Por favor, inicia sesión con tus credenciales.
            </div>
            <?php unset($_SESSION['registro_exitoso']); ?>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
            <!-- DEBUG -->
            <div style="font-size: 12px; color: #666; margin-top: 10px; padding: 8px; background: #f0f0f0; border-radius: 4px;">
                <strong>Debug:</strong> Formulario enviado a <?= BASE_URL ?>?url=auth/login<br>
                POST recibido: email=<?= $_POST['email'] ?? 'no recibido' ?><br>
                Sesión usuario_id: <?= $_SESSION['usuario_id'] ?? 'no establecido' ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?= BASE_URL ?>?url=auth/login">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <div class="register-link">
            ¿No tienes cuenta? <a href="<?= BASE_URL ?>?url=auth/register">Regístrate aquí</a>
        </div>
    </div>
</body>
</html>