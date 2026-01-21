<?php
// src/Views/mesa/ver.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; }
        .detalle { margin: 20px 0; }
        .detalle p { margin: 10px 0; }
        .detalle label { font-weight: bold; color: #555; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 10px; padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .nav a:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $titulo ?></h1>
        <div class="nav">
            <a href="<?= BASE_URL ?>?url=mesa/index">Volver a Mesas</a>
            <a href="<?= BASE_URL ?>?url=auth/logout">Logout</a>
        </div>
        
        <div class="detalle">
            <p>
                <label>Mesa Nº:</label>
                <?= htmlspecialchars($mesa->numero) ?>
            </p>
            <p>
                <label>Plazas:</label>
                <?= htmlspecialchars($mesa->plazas) ?>
            </p>
            <p>
                <label>Estado:</label>
                <?= $mesa->activa ? 'Activa' : 'Inactiva' ?>
            </p>
        </div>
    </div>
</body>
</html>
