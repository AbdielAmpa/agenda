<?php
class Contacto
{
    public $nombre, $correo, $telefono, $conexion;

    public function __construct($conexion, $nombre = null, $correo = null, $telefono = null)
    {
        $this->conexion = $conexion;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->telefono = $telefono;
    }

    // Método para registrar un contacto
    public function registrarContacto($nombre, $correo, $telefono, $password)
    {
        $sql = "INSERT INTO contactos (nombre, correo, telefono, password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $nombre, $correo, $telefono, $password);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return true;
        } else {
            $error = mysqli_error($this->conexion);
            mysqli_stmt_close($stmt);
            return "Error al registrar el contacto: $error";
        }
    }

    // Método para obtener todos los contactos
    public function obtenerContactos()
    {
        $sql = "SELECT * FROM contactos ORDER BY nombre ASC";
        $resultado = $this->conexion->query($sql);
        $contactos = [];

        if ($resultado) {
            while ($row = $resultado->fetch_assoc()) {
                $contactos[] = $row;
            }
        }
        return $contactos;
    }

    // Método para mostrar cumpleaños
    public function mostrarCumpleaños()
    {
        $sql = "SELECT * FROM cumpleaños ORDER BY fecha ASC";
        $resultado = $this->conexion->query($sql);
        $cumpleanos = [];

        if ($resultado) {
            while ($row = $resultado->fetch_assoc()) {
                $cumpleanos[] = $row;
            }
        }
        return $cumpleanos;
    }

    // Método para agregar cumpleaños
    public function agregarCumpleaños($nombre, $fechaCumple, $email, $telefono)
    {
        $sql = "INSERT INTO cumpleaños (nombre, fecha, email, telefono) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $nombre, $fechaCumple, $email, $telefono);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return true;
        } else {
            $error = mysqli_error($this->conexion);
            mysqli_stmt_close($stmt);
            return "Error al registrar el cumpleaños: $error";
        }
    }

    // Método para iniciar sesión
    public function iniciarSesion($correo, $password)
    {
        $sql = "SELECT * FROM contactos WHERE correo = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "s", $correo);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $contacto = mysqli_fetch_assoc($resultado);
            if (password_verify($password, $contacto['password'])) {
                mysqli_stmt_close($stmt);
                return $contacto;
            } else {
                mysqli_stmt_close($stmt);
                return "Contraseña incorrecta.";
            }
        } else {
            mysqli_stmt_close($stmt);
            return "El contacto no existe.";
        }
    }

    // Método para editar cumpleaños
    public function editarCumpleaños($id, $nombre, $fecha, $email, $telefono)
    {
        $sql = "UPDATE cumpleaños SET nombre = ?, fecha = ?, email = ?, telefono = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $nombre, $fecha, $email, $telefono, $id);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return true;
        } else {
            $error = mysqli_error($this->conexion);
            mysqli_stmt_close($stmt);
            return "Error al editar el cumpleaños: $error";
        }
    }

    // Método para eliminar cumpleaños
    public function eliminarCumpleaños($id)
    {
        $sql = "DELETE FROM cumpleaños WHERE id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return true;
        } else {
            $error = mysqli_error($this->conexion);
            mysqli_stmt_close($stmt);
            return "Error al eliminar el cumpleaños: $error";
        }
    }
}
?>
