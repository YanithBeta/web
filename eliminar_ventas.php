<?php
include('conec.php'); // Conexión a la base de datos

$operation = $_POST['operation'] ?? null;

if ($operation === 'delete_last') {
    // Eliminar la última venta (ID más alto)
    $sql = "DELETE FROM ventas1 ORDER BY id_venta DESC LIMIT 1";
} elseif ($operation === 'delete_all') {
    // Eliminar todas las ventas
    $sql = "DELETE FROM ventas1";
} else {
    // Si la operación no es válida, redirigir con un mensaje de error
    header('Location: ventas1.php?message=OperacionNoValida');
    exit;
}

$result = mysqli_query($conn, $sql);

if ($result) {
    // Redirigir a la página principal con un mensaje de éxito
    header('Location: ventas1.php?message=OperacionExitosa');
} else {
    // Redirigir con un mensaje de error
    $error = mysqli_error($conn);
    header("Location: ventas1.php?message=Error: $error");
}
?>
