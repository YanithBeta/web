<?php
include('conec.php'); // Conexión a la base de datos

// Variables para filtros
$fecha_inicio = null;
$fecha_fin = null;
$empleado = null;

// Verificar si se enviaron filtros o datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['filtro'])) {
        $filtro = $_POST['filtro'];

        // Filtrar por día
        if ($filtro == 'dia' && isset($_POST['fecha'])) {
            $fecha_inicio = $_POST['fecha'];
            $fecha_fin = $_POST['fecha']; // Inicio y fin son la misma fecha
        }
        // Filtrar por semana
        elseif ($filtro == 'semana' && isset($_POST['semana'])) {
            $semana = $_POST['semana'];
            $fecha_inicio = date('Y-m-d', strtotime("monday this week", strtotime($semana)));
            $fecha_fin = date('Y-m-d', strtotime("sunday this week", strtotime($semana)));
        }
        // Filtrar por mes
        elseif ($filtro == 'mes' && isset($_POST['mes'])) {
            $mes = $_POST['mes'];
            $fecha_inicio = date('Y-m-01', strtotime($mes));
            $fecha_fin = date('Y-m-t', strtotime($mes));
        }
        // Filtrar por empleado
        elseif ($filtro == 'empleados' && isset($_POST['empleados'])) {
            $empleados = $_POST['empleados'];
        }
    }

    // Registrar venta
    if (isset($_POST['registrar_venta'])) {
        $id_producto = $_POST['id_producto'];
        $id_usuario = $_POST['id_usuario'];
        $cantidad = $_POST['cantidad'];

        // Validar si el producto existe
        $producto_query = mysqli_query($conn, "SELECT costo_venta FROM productos WHERE id_producto = '$id_producto'");
        if ($producto_query && mysqli_num_rows($producto_query) > 0) {
            $producto = mysqli_fetch_assoc($producto_query);
            $precio_unitario = $producto['costo_venta'];
            $total = $precio_unitario * $cantidad;

            // Registrar la venta
            $fecha_venta = date('Y-m-d');
            $insert_venta = "INSERT INTO ventas1 (fecha_venta, id_producto, id_usuario, cantidad, precio_unitario, total) 
                             VALUES ('$fecha_venta', '$id_producto', '$id_usuario', '$cantidad', '$precio_unitario', '$total')";
            if (mysqli_query($conn, $insert_venta)) {
                echo "<script>alert('Venta registrada exitosamente');</script>";
            } else {
                echo "<script>alert('Error al registrar la venta.');</script>";
            }
        } else {
            echo "<script>alert('Producto no encontrado.');</script>";
        }
    }

    // Generar reporte en PDF
    if (isset($_POST['generar_pdf'])) {
        header("Location: generar_pdf.php");
        exit;
    }
}

// Construir consulta para mostrar ventas
$sql = "SELECT v.id_venta, v.fecha_venta, p.nombre_producto, v.cantidad, v.precio_unitario, v.total, u.nombre 
        FROM ventas1 v 
        INNER JOIN productos p ON v.id_producto = p.id_producto
        INNER JOIN usuarios u ON v.id_usuario = u.id_personal
        WHERE 1=1"; // '1=1' para condiciones dinámicas

if ($fecha_inicio && $fecha_fin) {
    $sql .= " AND v.fecha_venta BETWEEN '$fecha_inicio' AND '$fecha_fin'";
}
if ($empleado) {
    $sql .= " AND v.id_usuario = '$empleado'";
}

$sql .= " ORDER BY v.fecha_venta DESC";

$result = mysqli_query($conn, $sql);

// Obtener datos para dropdowns
$empleados_result = mysqli_query($conn, "SELECT * FROM usuarios");
$productos_result = mysqli_query($conn, "SELECT * FROM productos");
?>
