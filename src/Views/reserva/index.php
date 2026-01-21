<?php
// src/Views/reserva/index.php
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
        .btn-crear { background: #28a745; }
        .btn-crear:hover { background: #218838; }
        .tabla { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .tabla th, .tabla td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        .tabla th { background: #007bff; color: white; }
        .tabla tr:hover { background: #f9f9f9; }
        .btn-accion { padding: 6px 10px; margin-right: 5px; color: white; text-decoration: none; border-radius: 4px; font-size: 12px; }
        .btn-ver { background: #17a2b8; }
        .btn-ver:hover { background: #138496; }
        .btn-editar { background: #ffc107; color: #333; }
        .btn-editar:hover { background: #e0a800; }
        .btn-cancelar { background: #dc3545; }
        .btn-cancelar:hover { background: #c82333; }
        .mensaje { padding: 10px; margin: 10px 0; background: #d4edda; color: #155724; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $titulo ?></h1>
        <div class="nav">
            <a href="<?= BASE_URL ?>">Inicio</a>
            <a href="<?= BASE_URL ?>?url=reserva/crear" class="btn-crear">+ Nueva Reserva</a>
            <a href="<?= BASE_URL ?>?url=mesa/index">Ver Mesas</a>
            <a href="<?= BASE_URL ?>?url=auth/logout">Logout</a>
        </div>
        
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="mensaje"><?= $_SESSION['mensaje'] ?></div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>
        
        <?php if (empty($reservas)): ?>
            <p style="text-align: center; margin-top: 30px; color: #999;">No hay reservas. <a href="<?= BASE_URL ?>?url=reserva/crear">Crear una nueva</a></p>
        <?php else: ?>
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Mesa</th>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Personas</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $item): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($item['mesa']->numero ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars(date('d/m/Y', strtotime($item['reserva']->fecha_reserva))) ?></td>
                            <td><?= htmlspecialchars($item['tramo']->nombre ?? 'N/A') ?> (<?= htmlspecialchars($item['tramo']->hora_inicio ?? '' . ' - ' . $item['tramo']->hora_fin ?? '') ?>)</td>
                            <td><?= htmlspecialchars($item['reserva']->numero_personas) ?></td>
                            <td><?= htmlspecialchars($item['reserva']->estado) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>?url=reserva/ver/<?= $item['reserva']->id ?>" class="btn-accion btn-ver">Ver</a>
                                <?php if ($item['reserva']->estado != 'cancelada'): ?>
                                    <a href="<?= BASE_URL ?>?url=reserva/editar/<?= $item['reserva']->id ?>" class="btn-accion btn-editar">Editar</a>
                                    <a href="<?= BASE_URL ?>?url=reserva/cancelar/<?= $item['reserva']->id ?>" class="btn-accion btn-cancelar" onclick="return confirm('¿Cancelar esta reserva?')">Cancelar</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
