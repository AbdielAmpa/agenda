<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'bd_agenda';

// Conexión a la base de datos
$conexion = new mysqli($host, $username, $password, $database);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión con la base de datos: " . $conexion->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8
$conexion->set_charset("utf8");
?>