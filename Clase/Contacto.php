<?php
class Contacto
{
    public $nombre, $correo, $telefono, $conexion;

    public function __construct($conexion, $nombre = null, $correo = null, $telefono = null)
    {
        $this->conexion = $conexion;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->telefono = $telefono; // Manejo del teléfono
    }

    // Método para registrar un contacto
    public function registrarContacto($nombre, $correo, $telefono, $password)
    {
        $sql = "INSERT INTO contactos (nombre, correo, telefono, password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $nombre, $correo, $telefono, $password);

        if (mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            return "Error al registrar el contacto: " . mysqli_error($this->conexion);
        }

        mysqli_stmt_close($stmt);
    }

    // Método para mostrar cumpleaños
    public static function mostrarCumpleaños($conexion)
    {
        $sql = "SELECT * FROM cumpleaños";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "Nombre: " . $fila["nombre"] . " - Fecha: " . $fila["fecha"] . "<br>";
            }
        } else {
            echo "No hay cumpleaños registrados.";
        }

        mysqli_stmt_close($stmt);
    }

    // Método para agregar cumpleaños
    public function agregarCumpleaños($nombre, $fechaCumple)
    {
        $sql = "INSERT INTO cumpleaños (nombre, fecha) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $nombre, $fechaCumple);

        if (mysqli_stmt_execute($stmt)) {
            echo "Cumpleaños registrado correctamente.";
        } else {
            echo "Error al registrar el cumpleaños: " . mysqli_error($this->conexion);
        }

        mysqli_stmt_close($stmt);
    }

    // Método para iniciar sesión
    public function iniciarSesion($correo, $password)
    {
        $sql = "SELECT * FROM contactos WHERE correo = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "s", $correo);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultado) > 0) {
            $contacto = mysqli_fetch_assoc($resultado);
            if (password_verify($password, $contacto['password'])) {
                return $contacto; // Devuelve el contacto
            } else {
                return "Contraseña incorrecta.";
            }
        } else {
            return "El contacto no existe.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>
