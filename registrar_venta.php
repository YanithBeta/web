<?php
include('conec.php'); // Incluir la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $id_cliente = $_POST['id_cliente'];
    $id_usuario = $_POST['id_usuario'];
    $id_producto = $_POST['id_producto'];
    $fecha_venta = $_POST['Fecha_venta'];
    $cantidad = $_POST['cantidad'];
    $precio_unitario = $_POST['precio'];
    $total_venta = $_POST['total_producto'];
    $metodo_pago = $_POST['metodo_pago'];
    $banco = isset($_POST['banco']) ? $_POST['banco'] : NULL;
    $numero_tarjeta = isset($_POST['numero_tarjeta']) ? $_POST['numero_tarjeta'] : NULL;
    $efectivo_recibido = isset($_POST['efectivo']) ? $_POST['efectivo'] : NULL;
    $cambio = isset($_POST['cambio']) ? $_POST['cambio'] : NULL;
    $comision = $_POST['comision'];

    // Insertar los datos según el método de pago seleccionado
    if ($metodo_pago == 'Transferencia') {
        // Consulta para Transferencia
        $sql_insert = "INSERT INTO ventas2 (id_cliente, id_usuario, id_producto, fecha_venta, cantidad, precio_unitario, total_venta, metodo_pago, comision) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_insert);
        if ($stmt === false) {
            die("Error al preparar la consulta SQL: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "iiissddsd", $id_cliente, $id_usuario, $id_producto, $fecha_venta, $cantidad, $precio_unitario, $total_venta, $metodo_pago, $comision);
    } elseif ($metodo_pago == 'Tarjeta') {
        // Consulta para Tarjeta
        $sql_insert = "INSERT INTO ventas2 (id_cliente, id_usuario, id_producto, fecha_venta, cantidad, precio_unitario, total_venta, metodo_pago, banco, numero_tarjeta, comision) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_insert);
        if ($stmt === false) {
            die("Error al preparar la consulta SQL: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "iiissddsssd", $id_cliente, $id_usuario, $id_producto, $fecha_venta, $cantidad, $precio_unitario, $total_venta, $metodo_pago, $banco, $numero_tarjeta, $comision);
    } elseif ($metodo_pago == 'Efectivo') {
        // Consulta para Efectivo
        $sql_insert = "INSERT INTO ventas2 (id_cliente, id_usuario, id_producto, fecha_venta, cantidad, precio_unitario, total_venta, metodo_pago, efectivo_recibido, cambio) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_insert);
        if ($stmt === false) {
            die("Error al preparar la consulta SQL: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "iiissddssd", $id_cliente, $id_usuario, $id_producto, $fecha_venta, $cantidad, $precio_unitario, $total_venta, $metodo_pago, $efectivo_recibido, $cambio);
    } else {
        echo "Método de pago no válido";
        exit;
    }

    // Ejecutar la consulta
if (mysqli_stmt_execute($stmt)) {
    // Redirigir a "venta1.php" después de registrar la venta con éxito
    header("Location: ventas1.php");
    exit(); // Asegúrate de llamar a exit() para evitar que se ejecute más código después de la redirección
} else {
    // Si hay un error al registrar, muestra un mensaje de error
    echo "Error al registrar la venta: " . mysqli_error($conn);
}

}
?>
