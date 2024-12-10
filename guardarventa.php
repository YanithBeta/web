<?php
include('conec.php'); // Conexión a la base de datos
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener y sanitizar los datos del formulario
    $id_cliente = mysqli_real_escape_string($conn, $_POST['id_cliente']);
    $id_producto = mysqli_real_escape_string($conn, $_POST['id_producto']);
    $cantidad = mysqli_real_escape_string($conn, $_POST['cantidad']);
    $precio = mysqli_real_escape_string($conn, $_POST['precio']);
    $total = mysqli_real_escape_string($conn, $_POST['total']);
    $metodo_pago = mysqli_real_escape_string($conn, $_POST['metodo_pago']);
    $efectivo_recibido = isset($_POST['efectivo']) ? mysqli_real_escape_string($conn, $_POST['efectivo']) : null;
    $cambio = isset($_POST['cambio']) ? mysqli_real_escape_string($conn, $_POST['cambio']) : null;
    $id_usuario = $_SESSION['usuario']; // Suponiendo que el usuario está almacenado en la sesión

    // Insertar la venta en la base de datos
    $sql = "INSERT INTO ventas (id_cliente, id_usuario, id_producto, cantidad, precio_unitario, total, metodo_pago, efectivo_recibido, cambio, fecha_venta) 
            VALUES ('$id_cliente', '$id_usuario', '$id_producto', '$cantidad', '$precio', '$total', '$metodo_pago', '$efectivo_recibido', '$cambio', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "Venta registrada correctamente.";
    } else {
        echo "Error al registrar la venta: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
