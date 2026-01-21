<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Reservas - Restaurante</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .container { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); text-align: center; max-width: 500px; }
        h1 { color: #333; margin-bottom: 10px; font-size: 28px; }
        .subtitle { color: #666; margin-bottom: 30px; font-size: 16px; }
        .buttons { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
        .btn { padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; }
        .btn-login { background: #667eea; color: white; }
        .btn-login:hover { background: #5568d3; }
        .btn-register { background: #764ba2; color: white; }
        .btn-register:hover { background: #63408a; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🍽️ Sistema de Reservas</h1>
        <p class="subtitle">Reserva tu mesa en nuestro restaurante</p>
        <div class="buttons">
            <a href="<?= BASE_URL ?>?url=auth/login" class="btn btn-login">Iniciar Sesión</a>
            <a href="<?= BASE_URL ?>?url=auth/register" class="btn btn-register">Registrarse</a>
        </div>
    </div>
</body>
</html>