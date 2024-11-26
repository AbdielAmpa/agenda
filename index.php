<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenido a la Agenda Digital</h1>
        <?php if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true): ?>
            <p>Hola, <?php echo $_SESSION['usuario']; ?>! Estás autenticado.</p>
            <a href="panel.php" class="btn btn-primary">Ir al Panel</a>
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        <?php else: ?>
            <p>Por favor, inicia sesión o regístrate para acceder a más funciones.</p>
            <a href="login.php" class="btn btn-success">Iniciar Sesión</a>
            <a href="register.php" class="btn btn-info">Registrarse</a>
        <?php endif; ?>
    </div>
</body>
</html>
