<?php
include('conec.php'); // Incluir la conexión a la base de datos

// Configurar encabezados para la descarga de CSV
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="reporte_ventas.csv"');

// Abrir la salida para escritura
$output = fopen('php://output', 'w');

// Escribir la cabecera del archivo CSV
fputcsv($output, array('ID Venta', 'Cliente', 'Vendedor', 'Producto', 'Fecha', 'Cantidad', 'Precio Unitario', 'Total', 'Método de Pago'));

// Consulta para obtener las ventas
$sql_ventas = "SELECT ventas.*, clientes.nombre AS cliente_nombre, usuarios.nombre AS vendedor_nombre, productos.nombre_producto
               FROM ventas
               JOIN clientes ON ventas.id_cliente = clientes.id_cliente
               JOIN usuarios ON ventas.id_usuario = usuarios.id_usuario
               JOIN productos ON ventas.id_producto = productos.id_producto";
$result_ventas = mysqli_query($conn, $sql_ventas);

// Escribir cada fila de datos en el archivo CSV
while ($venta = mysqli_fetch_assoc($result_ventas)) {
    fputcsv($output, array(
        $venta['id_venta'],
        $venta['cliente_nombre'],
        $venta['vendedor_nombre'],
        $venta['nombre_producto'],
        $venta['fecha_venta'],
        $venta['cantidad'],
        number_format($venta['precio_unitario'], 2),
        number_format($venta['total'], 2),
        $venta['metodo_pago']
    ));
}

// Cerrar el archivo y la conexión
fclose($output);
mysqli_close($conn);
exit();
