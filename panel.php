<?php
session_start();
require_once('auth.php'); // Verifica si el contacto está autenticado
require_once('../agenda/conexion.php');
require_once('../agenda/Clase/Contacto.php');

$contacto = new Contacto($conexion);
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Manejo de operaciones para agregar, editar y eliminar cumpleaños
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'add') {
            $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
            $fechaCumple = mysqli_real_escape_string($conexion, $_POST['fechaCumple']);
            $email = mysqli_real_escape_string($conexion, $_POST['email']);
            $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
            
            // Agregar cumpleaños
            $contacto->agregarCumpleaños($nombre, $fechaCumple, $email, $telefono);
        } elseif ($_POST['action'] == 'edit') {
            $id = $_POST['id'];
            $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
            $fechaCumple = mysqli_real_escape_string($conexion, $_POST['fechaCumple']);
            $email = mysqli_real_escape_string($conexion, $_POST['email']);
            $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
            
            // Editar cumpleaños
            $contacto->editarCumpleaños($id, $nombre, $fechaCumple, $email, $telefono);
        } elseif ($_POST['action'] == 'delete') {
            $id = $_POST['id'];
            
            // Eliminar cumpleaños
            $contacto->eliminarCumpleaños($id);
        }
    }
}

$cumpleanos = $contacto->mostrarCumpleaños($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Panel Administrativo</h1>
        <form method="POST">
            <h3>Agregar Cumpleaños</h3>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="fechaCumple">Fecha de Cumpleaños:</label>
                <input type="date" class="form-control" id="fechaCumple" name="fechaCumple" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <input type="hidden" name="action" value="add">
            <button type="submit" class="btn btn-primary">Agregar Cumpleaños</button>
        </form>

        <h3 class="mt-5">Cumpleaños</h3>
        <?php if ($cumpleanos): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cumpleanos as $cumple): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cumple['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($cumple['fecha']); ?></td>
                            <td><?php echo htmlspecialchars($cumple['email']); ?></td>
                            <td><?php echo htmlspecialchars($cumple['telefono']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay cumpleaños registrados.</p>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </div>

    <script>
        function editBirthday(id, nombre, fecha, email, telefono) {
            document.getElementById('nombre').value = nombre;
            document.getElementById('fechaCumple').value = fecha;
            document.getElementById('email').value = email;
            document.getElementById('telefono').value = telefono;
            document.querySelector('input[name="action"]').value = 'edit';
            document.querySelector('input[name="id"]').value = id;
        }
    </script>
</body>
</html>
