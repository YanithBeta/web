<?php
// Incluir el archivo de conexión a la base de datos
include('conec.php');

// Verificar la conexión
if (!$conn) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Obtener los datos del formulario
$id_venta = $_POST['id_venta']; 
$id_producto = $_POST['id_producto']; 
$cantidad_devolver = $_POST['cantidad']; 
$motivo = $_POST['motivo']; 
$accion = $_POST['accion']; 
$nuevo_producto = isset($_POST['nuevo_producto']) ? $_POST['nuevo_producto'] : null;

// 1. Registrar la devolución en productos_devueltos
$sql_devolucion = "INSERT INTO productos_devueltos (id_venta, id_producto, cantidad, motivo) 
                   VALUES ('$id_venta', '$id_producto', '$cantidad_devolver', '$motivo')";
mysqli_query($conn, $sql_devolucion);

// 2. Actualizar el inventario del producto devuelto
if ($accion == 'devolver') {
    // Devolver el producto al inventario
    $sql_actualizar_producto = "UPDATE productos SET stock = stock + $cantidad_devolver WHERE id_producto = '$id_producto'";
    mysqli_query($conn, $sql_actualizar_producto);

    // Actualizar la cantidad en el ticket de venta
    // Obtener la cantidad actual de la venta
    $sql_venta = "SELECT cantidad FROM ventas2 WHERE id_venta = '$id_venta' AND id_producto = '$id_producto'";
    $result_venta = mysqli_query($conn, $sql_venta);
    $venta = mysqli_fetch_assoc($result_venta);

    if ($venta) {
        $nueva_cantidad = $venta['cantidad'] - $cantidad_devolver;

        // Asegurarse de que la nueva cantidad no sea negativa
        if ($nueva_cantidad >= 0) {
            // Actualizar la cantidad en la tabla de ventas2
            $sql_actualizar_venta = "UPDATE ventas2 SET cantidad = $nueva_cantidad WHERE id_venta = '$id_venta' AND id_producto = '$id_producto'";
            if (mysqli_query($conn, $sql_actualizar_venta)) {
                echo "Cantidad actualizada correctamente en el ticket.";
            } else {
                echo "Error al actualizar la cantidad en el ticket.";
            }
        } else {
            echo "Error: No puedes devolver más de lo que se vendió.";
            exit;
        }
    } else {
        echo "Error: No se encontró la venta para actualizar.";
        exit;
    }

} elseif ($accion == 'cambiar') {
    // Si es un cambio, actualizamos el inventario del producto devuelto
    $sql_actualizar_producto_original = "UPDATE productos SET stock = stock + $cantidad_devolver WHERE id_producto = '$id_producto'";
    mysqli_query($conn, $sql_actualizar_producto_original);

    // Actualizamos el inventario del nuevo producto
    $sql_actualizar_producto_nuevo = "UPDATE productos SET stock = stock - $cantidad_devolver WHERE id_producto = '$nuevo_producto'";
    mysqli_query($conn, $sql_actualizar_producto_nuevo);

    // Registrar el cambio en la tabla de ventas
    $sql_actualizar_venta = "UPDATE ventas2 SET id_producto = '$nuevo_producto' WHERE id_venta = '$id_venta' AND id_producto = '$id_producto'";
    mysqli_query($conn, $sql_actualizar_venta);
}

// Redirigir de vuelta al ticket con la devolución registrada
header("Location: ticket.php?id_venta=$id_venta");
exit;
?>
