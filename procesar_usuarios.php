<?php
include('conec.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $nombre = $_POST['nombre'];
    $a_paterno = $_POST['a_paterno'];
    $a_materno = $_POST['a_materno'];
    $clave = $_POST['clave'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    if (isset($_POST['modificar'])) {
               $sql = "UPDATE usuarios SET 
                    nombre = '$nombre',
                    a_paterno = '$a_paterno',
                    a_materno = '$a_materno',
                    clave = '$clave',
                    telefono = '$telefono',
                    correo = '$correo'
                WHERE id_usuario = '$id_usuario'";

        if (mysqli_query($conn, $sql)) {
            header("Location: usuarios.php");
            exit();
        } else {
            echo "Error al actualizar el usuario: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['guardar'])) {
                $sql = "INSERT INTO usuarios (nombre, a_paterno, a_materno, clave, telefono, correo) 
                VALUES ('$nombre', '$a_paterno', '$a_materno', '$clave', '$telefono', '$correo')";

        if (mysqli_query($conn, $sql)) {
            header("Location: usuarios.php");
            exit();
        } else {
            echo "Error al guardar el usuario: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['eliminar'])) {
                $sql = "DELETE FROM usuarios WHERE id_usuario = '$id_usuario'";
        if (mysqli_query($conn, $sql)) {
            header("Location: usuarios.php");
            exit();
        } else {
            echo "Error al eliminar el usuario: " . mysqli_error($conn);
        }
    }
}
?>

