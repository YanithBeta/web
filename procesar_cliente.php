<?php
include('conec.php'); // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    // Guardar un nuevo cliente
    if (isset($_POST['guardar'])) {
        $sql = "INSERT INTO clientes (nombre, telefono, correo) VALUES ('$nombre', '$telefono', '$correo')";
        if (mysqli_query($conn, $sql)) {
            header("Location: cliente.php");
            exit();
        } else {
            echo "Error al guardar el cliente: " . mysqli_error($conn);
        }
    }

    // Modificar un cliente existente
    elseif (isset($_POST['modificar']) && $id_cliente != '') {
        $sql = "UPDATE clientes SET nombre = '$nombre', telefono = '$telefono', correo = '$correo' WHERE id_cliente = '$id_cliente'";
        if (mysqli_query($conn, $sql)) {
            header("Location: cliente.php");
            exit();
        } else {
            echo "Error al modificar el cliente: " . mysqli_error($conn);
        }
    }

    // Eliminar un cliente existente
    elseif (isset($_POST['eliminar']) && $id_cliente != '') {
        $sql = "DELETE FROM clientes WHERE id_cliente = '$id_cliente'";
        if (mysqli_query($conn, $sql)) {
            header("Location: cliente.php");
            exit();
        } else {
            echo "Error al eliminar el cliente: " . mysqli_error($conn);
        }
    }
}
?>
