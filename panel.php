<?php
session_start();
require_once('auth.php'); // Verifica si el contacto está autenticado
require_once('../agenda/conexion.php');
require_once('../agenda/Clase/Contacto.php');

$contacto = new Contacto($conexion);
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Manejo de operaciones para agregar cumpleaños
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $fechaCumple = mysqli_real_escape_string($conexion, $_POST['fechaCumple']);
        $contacto->agregarCumpleaños($nombre, $fechaCumple);
    }
}
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
            <input type="hidden" name="action" value="add">
            <button type="submit" class="btn btn-primary">Agregar Cumpleaños</button>
        </form>

        <h3>Cumpleaños</h3>
        <?php $contacto->mostrarCumpleaños($conexion); // Método para mostrar cumpleaños ?>
        
        <div class="text-center">
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </div>
</body>
</html>
