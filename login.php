<?php
session_start();
require_once('../agenda/conexion.php');
require_once('../agenda/Clase/Contacto.php');

$contacto = new Contacto($conexion);
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = $_POST['password'];

    $resultado = $contacto->iniciarSesion($email, $password);
    
    if (is_array($resultado)) {
        $_SESSION['usuario'] = $resultado['nombre'];
        $_SESSION['autenticado'] = true; // Indica que el usuario está autenticado
        header("Location: panel.php"); // Redirige al panel de usuario
        exit;
    } else {
        $error = htmlspecialchars($resultado); // Muestra el error de forma segura
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Iniciar Sesión</h1>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
