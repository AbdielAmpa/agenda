<?php
session_start();
require_once('../agenda/conexion.php');
require_once('../agenda/Clase/Contacto.php');

$contacto = new Contacto($conexion);
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $telefono = $_POST['telefono'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $resultado = $contacto->registrarContacto($nombre, $email, $telefono, $password);
    if ($resultado === true) {
        header("Location: login.php");
        exit;
    } else {
        $error = htmlspecialchars($resultado);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
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
            background-color: #f8f9fa;
            /* Color de fondo claro */
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            /* Fondo blanco semi-transparente */
            padding: 30px;
            /* Espaciado interno */
            border-radius: 10px;
            /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Sombra para efecto de elevación */
            width: 100%;
            /* Ancho completo */
            max-width: 400px;
            /* Ancho máximo del contenedor */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Registrarse</h1>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-success">Registrarse</button>
            <a href="login.php" class="btn btn-link">Iniciar Sesión</a>
        </form>
    </div>
</body>

</html>