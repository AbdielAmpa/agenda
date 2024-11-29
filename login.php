<?php
session_start();
require_once('../agenda/conexion.php');
require_once('../agenda/Clase/Contacto.php');

$contacto = new Contacto($conexion);
$error = '';
$contactos = $contacto->obtenerContactos(); // Método para obtener contactos registrados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validar email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email no válido.";
    } else {
        $resultado = $contacto->iniciarSesion($email, $password);

        if (is_array($resultado)) {
            $_SESSION['usuario'] = $resultado['nombre'];
            $_SESSION['autenticado'] = true;
            session_regenerate_id(true); // Regenerar ID de sesión
            header("Location: panel.php");
            exit;
        } else {
            $error = htmlspecialchars($resultado);
        }
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
            <a href="register.php" class="btn btn-link">Registrarse</a>
        </form>

        <h3 class="mt-5">Contactos Registrados</h3>
        <?php if ($contactos): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contactos as $contacto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($contacto['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($contacto['correo']); ?></td>
                            <td><?php echo htmlspecialchars($contacto['telefono']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay contactos registrados.</p>
        <?php endif; ?>


    </div>

    <script>
        function editContact(id, nombre, email, telefono) {
            document.getElementById('nombre').value = nombre;
            document.getElementById('email').value = email;
            document.getElementById('telefono').value = telefono;
            document.querySelector('input[name="action"]').value = 'edit';
            document.querySelector('input[name="id"]').value = id;
        }
    </script>
</body>
</html>
