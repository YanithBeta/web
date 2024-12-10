<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "nuevo3");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Validar si se pasa el ID de venta
if (!isset($_GET['id_venta'])) {
    die("ID de venta no especificado.");
}

$id_venta = intval($_GET['id_venta']); // ID de la venta pasada por URL

// Obtener los datos de la venta
$query = "SELECT * FROM ventas WHERE id_venta = $id_venta";
$resultado = $conexion->query($query);

if ($resultado->num_rows > 0) {
    $venta = $resultado->fetch_assoc();
} else {
    die("Venta no encontrada.");
}

// Registrar devolución si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['devolver'])) {
    $cantidad_devolver = intval($_POST['cantidad_devolver']);
    
    // Validar cantidad
    if ($cantidad_devolver > 0 && $cantidad_devolver <= $venta['cantidad']) {
        $fecha_devolucion = date('Y-m-d');

        // Calcular el total de la devolución
        $total_devolucion = $cantidad_devolver * $venta['precio_unitario'];

        // Insertar devolución
        $query_devolucion = "INSERT INTO devoluciones (id_venta, id_producto, cantidad, fecha_devolucion) 
                             VALUES ($id_venta, {$venta['id_producto']}, $cantidad_devolver, '$fecha_devolucion')";
        
        if ($conexion->query($query_devolucion) === TRUE) {
            // Calcular nueva cantidad y nuevo total
            $nueva_cantidad = $venta['cantidad'] - $cantidad_devolver;
            $total_input = $venta['total'] - $total_devolucion;

            // Actualizar cantidad y total en la tabla ventas
            $conexion->query("UPDATE ventas SET cantidad = $nueva_cantidad, total = $total_input WHERE id_venta = $id_venta");

            // Actualizar valores localmente para reflejarlos en la página
            $venta['cantidad'] = $nueva_cantidad;
            $venta['total'] = $total_input;

            echo "<script>alert('Devolución registrada con éxito.');</script>";
        } else {
            echo "<script>alert('Error al registrar la devolución.');</script>";
        }
    } else {
        echo "<script>alert('Cantidad no válida para devolución.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Venta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }
        .ticket {
            width: 300px;
            padding: 20px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .ticket h1, .ticket h2, .ticket h3 {
            text-align: center;
            margin: 0;
        }
        .ticket h1 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .ticket h3 {
            font-size: 14px;
            margin-top: 10px;
        }
        .ticket p {
            margin: 5px 0;
            font-size: 12px;
        }
        .ticket .details {
            margin: 10px 0;
            border-top: 1px dashed #ddd;
            border-bottom: 1px dashed #ddd;
            padding: 10px 0;
        }
        .ticket .total {
            text-align: right;
            font-weight: bold;
        }
        .ticket .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 12px;
            color: #555;
        }
        .ticket .devolucion-form {
            margin-top: 10px;
        }
        .ticket .devolucion-form input[type="number"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }
        .ticket .devolucion-form button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .ticket .devolucion-form button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <h1>Nombre del Negocio</h1>
        <h2>Ticket de Venta</h2>
        <h3>Fecha: <?php echo $venta['fecha_venta']; ?></h3>

        <div class="details">
            <p><strong>ID Venta:</strong> <?php echo $venta['id_venta']; ?></p>
            <p><strong>Cliente:</strong> <?php echo $venta['id_cliente']; ?></p>
            <p><strong>Atendido por:</strong> Usuario <?php echo $venta['id_usuario']; ?></p>
            <p><strong>Producto:</strong> <?php echo $venta['id_producto']; ?></p>
            <p><strong>Cantidad:</strong> <?php echo $venta['cantidad']; ?></p>
            <p><strong>Precio Unitario:</strong> $<?php echo $venta['precio_unitario']; ?></p>
            <p class="total">Total: $<?php echo $venta['total']; ?></p>
            <p><strong>Método de Pago:</strong> <?php echo $venta['metodo_pago']; ?></p>
            <p><strong>Efectivo Recibido:</strong> $<?php echo $venta['efectivo_recibido']; ?></p>
            <p><strong>Cambio:</strong> $<?php echo $venta['cambio']; ?></p>
        </div>

        <div class="devolucion-form">
            <form method="POST">
                <label for="cantidad_devolver">Cantidad a devolver:</label>
                <input type="number" id="cantidad_devolver" name="cantidad_devolver" min="1" max="<?php echo $venta['cantidad']; ?>" required>
                <button type="submit" name="devolver">Registrar Devolución</button>
            </form>
        </div>

        <div class="footer">
            <p>Gracias por su compra</p>
            <p>Visítenos nuevamente</p>
        </div>
    </div>
</body>
</html>
