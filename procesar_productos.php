<?php
include('conec.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $cod_barras = $_POST['cod_barras'];
    $cantidad = $_POST['cantidad'];
    $proveedor = $_POST['proveedor'];
    $especificaciones = $_POST['especificaciones'];
    $fecha_caducidad = $_POST['fecha_caducidad'];
    $costo_compra = $_POST['costo_compra'];
    $costo_venta = $_POST['costo_venta'];

    if (isset($_POST['modificar'])) {
        // Consulta SQL para actualizar el producto
        $sql = "UPDATE productos SET 
                    nombre_producto = '$nombre_producto',
                    cod_barras = '$cod_barras',
                    cantidad = '$cantidad',
                    proveedor = '$proveedor',
                    especificaciones = '$especificaciones',
                    fecha_caducidad = '$fecha_caducidad',
                    costo_compra = '$costo_compra',
                    costo_venta = '$costo_venta'
                WHERE id_producto = '$id_producto'";

        if (mysqli_query($conn, $sql)) {
            header("Location: productos.php");
            exit();
        } else {
            echo "Error al actualizar el producto: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['guardar'])) {
        // Consulta SQL para insertar un nuevo producto
        $sql = "INSERT INTO productos (nombre_producto, cod_barras, cantidad, proveedor, especificaciones, fecha_caducidad, costo_compra, costo_venta) 
                VALUES ('$nombre_producto', '$cod_barras', '$cantidad', '$proveedor', '$especificaciones', '$fecha_caducidad', '$costo_compra', '$costo_venta')";

        if (mysqli_query($conn, $sql)) {
            header("Location: productos.php");
            exit();
        } else {
            echo "Error al guardar el producto: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['eliminar'])) {
        // Consulta SQL para eliminar un producto
        $sql = "DELETE FROM productos WHERE id_producto = '$id_producto'";

        if (mysqli_query($conn, $sql)) {
            header("Location: productos.php");
            exit();
        } else {
            echo "Error al eliminar el producto: " . mysqli_error($conn);
        }
    }
}
?>

