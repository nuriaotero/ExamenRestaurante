<?php
// src/Views/reserva/editar.php
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
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 10px; padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .nav a:hover { background: #0056b3; }
        .error { margin: 15px 0; padding: 10px; background: #f8d7da; border-left: 4px solid #dc3545; color: #721c24; border-radius: 4px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #007bff; box-shadow: 0 0 5px rgba(0,123,255,0.5); }
        .btn-submit { background: #ffc107; color: #333; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        .btn-submit:hover { background: #e0a800; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $titulo ?></h1>
        <div class="nav">
            <a href="<?= BASE_URL ?>?url=reserva/index">Mis Reservas</a>
        </div>

        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>?url=reserva/editar/<?= $reserva->id ?>">
            <div class="form-group">
                <label for="mesa_id">Mesa:</label>
                <select name="mesa_id" id="mesa_id" required>
                    <?php foreach ($mesas as $m): ?>
                        <option value="<?= $m->id ?>" <?= $m->id == $reserva->mesa_id ? 'selected' : '' ?>>
                            Mesa #<?= htmlspecialchars($m->numero) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="tramo_horario_id">Tramo Horario:</label>
                <select name="tramo_horario_id" id="tramo_horario_id" required>
                    <?php foreach ($tramos as $t): ?>
                        <option value="<?= $t->id ?>" <?= $t->id == $reserva->tramo_horario_id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t->nombre) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="fecha_reserva">Fecha de la Reserva:</label>
                <input type="date" name="fecha_reserva" id="fecha_reserva" value="<?= htmlspecialchars($reserva->fecha_reserva) ?>" required>
            </div>

            <div class="form-group">
                <label for="numero_personas">Número de Personas:</label>
                <input type="number" name="numero_personas" id="numero_personas" value="<?= htmlspecialchars($reserva->numero_personas) ?>" min="1" max="20" required>
            </div>

            <div class="form-group">
                <label for="comentarios">Comentarios (opcional):</label>
                <textarea name="comentarios" id="comentarios" rows="4"><?= htmlspecialchars($reserva->comentarios ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn-submit">Actualizar Reserva</button>
        </form>
    </div>
</body>
</html>
