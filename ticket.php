<?php
include('conec.php'); // Incluir la conexión a la base de datos

// Obtener la última venta
$sql_venta = "SELECT v.id_venta, c.nombre AS cliente, u.nombre AS vendedor, p.nombre_producto, v.fecha_venta, v.cantidad, 
                    v.precio_unitario, v.total_venta, v.metodo_pago, v.banco, v.numero_tarjeta, v.efectivo_recibido, v.cambio, v.comision, v.id_producto
             FROM ventas2 v
             JOIN clientes c ON v.id_cliente = c.id_cliente
             JOIN usuarios u ON v.id_usuario = u.id_usuario
             JOIN productos p ON v.id_producto = p.id_producto
             ORDER BY v.id_venta DESC LIMIT 1"; // Obtener la última venta
$result_venta = mysqli_query($conn, $sql_venta);
$venta = mysqli_fetch_assoc($result_venta);

// Cálculo del total venta si no está presente o si se necesita actualizar
$total_venta = $venta['precio_unitario'] * $venta['cantidad'];

// Actualizar el total de la venta si es necesario
if ($venta['total_venta'] != $total_venta) {
    $sql_update = "UPDATE ventas2 SET total_venta = ? WHERE id_venta = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("di", $total_venta, $venta['id_venta']);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Venta</title>
    <style>
        /* Estilos para el ticket */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
        }
        .ticket {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .ticket h2 {
            text-align: center;
            font-size: 24px;
            color: #3a3a3a;
            margin-bottom: 20px;
        }
        .ticket p {
            margin: 5px 0;
            font-size: 14px;
            color: #3a3a3a;
        }
        .ticket .total {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-top: 10px;
        }
        .ticket .metodo {
            font-size: 14px;
            color: #555;
        }
        .ticket .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #aaa;
        }
        .formulario {
            margin-top: 40px;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .formulario h2 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
        }
        .formulario label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .formulario input, .formulario select, .formulario textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .formulario button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .formulario button:hover {
            background-color: #45a049;
        }
        .formulario select, .formulario textarea {
            font-size: 14px;
        }
        .formulario .footer {
            text-align: center;
            font-size: 12px;
            color: #aaa;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="ticket">
    <h2>Ticket de Venta</h2>
    <p><strong>Venta ID:</strong> <?= $venta['id_venta'] ?></p>
    <p><strong>Fecha:</strong> <?= $venta['fecha_venta'] ?></p>
    <p><strong>Cliente:</strong> <?= $venta['cliente'] ?></p>
    <p><strong>Vendedor:</strong> <?= $venta['vendedor'] ?></p>
    <p><strong>Producto:</strong> <?= $venta['nombre_producto'] ?></p>
    <p><strong>Cantidad:</strong> <?= $venta['cantidad'] ?></p>
    <p><strong>Precio Unitario:</strong> $<?= number_format($venta['precio_unitario'], 2) ?></p>
    <p><strong>Total Venta:</strong> $<?= number_format($total_venta, 2) ?></p>

    <?php if ($venta['metodo_pago'] == 'Efectivo') { ?>
        <p><strong>Efectivo Recibido:</strong> $<?= number_format($venta['efectivo_recibido'], 2) ?></p>
        <p><strong>Cambio:</strong> $<?= number_format($venta['cambio'], 2) ?></p>
    <?php } elseif ($venta['metodo_pago'] == 'Tarjeta') { ?>
        <p><strong>Tarjeta:</strong> <?= $venta['numero_tarjeta'] ?></p>
        <p><strong>Banco:</strong> <?= $venta['banco'] ?></p>
    <?php } else { ?>
        <p><strong>Método de Pago:</strong> <?= $venta['metodo_pago'] ?></p>
    <?php } ?>

    <p class="total"><strong>Total a Pagar:</strong> $<?= number_format($total_venta, 2) ?></p>
    
    <div class="footer">
        <p>Gracias por su compra!</p>
        <p>Visítenos nuevamente.</p>

        <!-- Botón para descargar el ticket en PDF -->
        <form action="descargar_ticket.php" method="GET">
            <input type="hidden" name="id_venta" value="<?= $venta['id_venta'] ?>"> <!-- Pasamos el id_venta al archivo PHP -->
            <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">Descargar Ticket en PDF</button>
        </form>
    </div>
</div>

<!-- Formulario de Devolución -->
<div class="formulario">
    <h2>Formulario de Devolución</h2>
    <form action="procesar_devolucion.php" method="POST">
        <input type="hidden" name="id_venta" value="<?= $venta['id_venta'] ?>">
        <input type="hidden" name="id_producto" value="<?= $venta['id_producto'] ?>">

        <label for="cantidad">Cantidad a Devolver:</label>
        <input type="number" name="cantidad" id="cantidad" min="1" max="<?= $venta['cantidad'] ?>" required>

        <label for="motivo">Motivo de la Devolución:</label>
        <textarea name="motivo" id="motivo" rows="4" required></textarea>
        
        <label for="accion">Acción:</label>
        <select name="accion" id="accion">
            <option value="devolver">Devolver Artículo</option>
            <option value="cambiar">Cambiar por otro Artículo</option>
        </select>
        
        <div id="producto-cambio" style="display: none;">
            <label for="nuevo_producto">Seleccionar Artículo para Cambio:</label>
            <select name="nuevo_producto" id="nuevo_producto">
                <?php
                // Aquí debes consultar los productos disponibles para cambio
                $sql_productos = "SELECT id_producto, nombre_producto FROM productos";
                $result_productos = mysqli_query($conn, $sql_productos);
                while ($producto = mysqli_fetch_assoc($result_productos)) {
                    echo '<option value="'.$producto['id_producto'].'">'.$producto['nombre_producto'].'</option>';
                }
                ?>
            </select>
        </div>

        <button type="submit">Procesar Devolución</button>
    </form>
</div>

<script>
    // Mostrar el selector de productos para cambio solo si se elige la opción de cambio
    document.getElementById("accion").addEventListener("change", function() {
        if (this.value == "cambiar") {
            document.getElementById("producto-cambio").style.display = "block";
        } else {
            document.getElementById("producto-cambio").style.display = "none";
        }
    });
</script>

</body>
</html>
