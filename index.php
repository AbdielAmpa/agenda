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
    <style>
        body {
            height: 100vh;
            /* Altura completa de la ventana */
            display: flex;
            /* Usar flexbox */
            justify-content: center;
            /* Centrar horizontalmente */
            align-items: center;
            /* Centrar verticalmente */
            margin: 0;
            /* Eliminar margen por defecto */
            background-color: #5833ff;
            /* Color de fondo claro */
        }

        .container {
            text-align: center;
            /* Centra el texto */
            background-color: rgba(255, 255, 255, 0.9);
            /* Fondo blanco semi-transparente */
            padding: 20px;
            /* Espaciado interno */
            border-radius: 10px;
            /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Sombra para efecto de elevación */
        }
    </style>
</head>

<body>
    <div class="container mt-5 text-center">
        <h1>Bienvenido a la Agenda Digital</h1>
        <?php if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true): ?>
            <p>Hola, <?php echo htmlspecialchars($_SESSION['usuario']); ?>! Estás autenticado.</p>
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