<?php
// src/Views/mesa/index.php
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
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 10px; padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .nav a:hover { background: #0056b3; }
        .tabla { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .tabla th, .tabla td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        .tabla th { background: #007bff; color: white; }
        .tabla tr:hover { background: #f9f9f9; }
        .btn { padding: 8px 12px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; }
        .btn:hover { background: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $titulo ?></h1>
        <div class="nav">
            <a href="<?= BASE_URL ?>">Inicio</a>
            <a href="<?= BASE_URL ?>?url=reserva/index">Mis Reservas</a>
            <a href="<?= BASE_URL ?>?url=auth/logout">Logout</a>
        </div>
        
        <table class="tabla">
            <thead>
                <tr>
                    <th>Mesa Nº</th>
                    <th>Plazas</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mesas as $mesa): ?>
                    <tr>
                        <td><?= htmlspecialchars($mesa->numero) ?></td>
                        <td><?= htmlspecialchars($mesa->plazas) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>?url=mesa/ver/<?= $mesa->id ?>" class="btn">Ver Detalles</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
