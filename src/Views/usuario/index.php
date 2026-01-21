<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    vista del usuario
    //muestrar los usuarios
    <?php foreach ($usuarios as $usuario): ?>
        <p>Usuario: <?= htmlspecialchars($usuario->nombre) ?> - Email: <?= htmlspecialchars($usuario->email) ?></p>
    <?php endforeach; ?>
</body>
</html>