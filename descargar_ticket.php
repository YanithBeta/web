<?php
include('conec.php'); // Incluir la conexión a la base de datos
require('fpdf/fpdf.php'); // Incluir la librería FPDF

// Verificar si se pasó el id_venta
if (isset($_GET['id_venta'])) {
    $id_venta = $_GET['id_venta'];

    // Obtener los datos de la venta
    $sql_venta = "SELECT v.id_venta, c.nombre AS cliente, u.nombre AS vendedor, p.nombre_producto, v.fecha_venta, v.cantidad, 
                        v.precio_unitario, v.total_venta, v.metodo_pago, v.banco, v.numero_tarjeta, v.efectivo_recibido, v.cambio, v.comision, v.id_producto
                 FROM ventas2 v
                 JOIN clientes c ON v.id_cliente = c.id_cliente
                 JOIN usuarios u ON v.id_usuario = u.id_usuario
                 JOIN productos p ON v.id_producto = p.id_producto
                 WHERE v.id_venta = '$id_venta'"; // Obtener la venta específica
    $result_venta = mysqli_query($conn, $sql_venta);
    $venta = mysqli_fetch_assoc($result_venta);

    // Crear el objeto FPDF
    $pdf = new FPDF();
    $pdf->AddPage();
    
    // Establecer fuente
    $pdf->SetFont('Arial', 'B', 16);
    
    // Título del ticket
    $pdf->SetTextColor(0, 102, 204); // Azul para el título
    $pdf->Cell(0, 10, 'Ticket de Venta', 0, 1, 'C');
    $pdf->Ln(10);

    // Detalles de la venta
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0); // Color de texto negro

    // Encabezado de los detalles
    $pdf->Cell(50, 10, 'Venta ID: ', 0, 0);
    $pdf->Cell(0, 10, $venta['id_venta'], 0, 1);
    $pdf->Cell(50, 10, 'Fecha: ', 0, 0);
    $pdf->Cell(0, 10, $venta['fecha_venta'], 0, 1);
    $pdf->Cell(50, 10, 'Cliente: ', 0, 0);
    $pdf->Cell(0, 10, $venta['cliente'], 0, 1);
    $pdf->Cell(50, 10, 'Vendedor: ', 0, 0);
    $pdf->Cell(0, 10, $venta['vendedor'], 0, 1);
    $pdf->Cell(50, 10, 'Producto: ', 0, 0);
    $pdf->Cell(0, 10, $venta['nombre_producto'], 0, 1);
    $pdf->Cell(50, 10, 'Cantidad: ', 0, 0);
    $pdf->Cell(0, 10, $venta['cantidad'], 0, 1);
    $pdf->Cell(50, 10, 'Precio Unitario: ', 0, 0);
    $pdf->Cell(0, 10, '$' . number_format($venta['precio_unitario'], 2), 0, 1);
    $pdf->Cell(50, 10, 'Total Venta: ', 0, 0);
    $pdf->Cell(0, 10, '$' . number_format($venta['total_venta'], 2), 0, 1);

    // Método de pago
    if ($venta['metodo_pago'] == 'Efectivo') {
        $pdf->Cell(50, 10, 'Efectivo Recibido: ', 0, 0);
        $pdf->Cell(0, 10, '$' . number_format($venta['efectivo_recibido'], 2), 0, 1);
        $pdf->Cell(50, 10, 'Cambio: ', 0, 0);
        $pdf->Cell(0, 10, '$' . number_format($venta['cambio'], 2), 0, 1);
    } elseif ($venta['metodo_pago'] == 'Tarjeta') {
        $pdf->Cell(50, 10, 'Tarjeta: ', 0, 0);
        $pdf->Cell(0, 10, $venta['numero_tarjeta'], 0, 1);
        $pdf->Cell(50, 10, 'Banco: ', 0, 0);
        $pdf->Cell(0, 10, $venta['banco'], 0, 1);
    } else {
        $pdf->Cell(50, 10, 'Método de Pago: ', 0, 0);
        $pdf->Cell(0, 10, $venta['metodo_pago'], 0, 1);
    }

    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetTextColor(0, 102, 204); // Color del total en azul
    $pdf->Cell(50, 10, 'Total a Pagar: ', 0, 0);
    $pdf->Cell(0, 10, '$' . number_format($venta['total_venta'], 2), 0, 1);
    $pdf->Ln(5);

    // Pie de página
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->SetTextColor(150, 150, 150); // Gris para el pie de página
    $pdf->Cell(0, 10, 'Gracias por su compra! Visítenos nuevamente.', 0, 1, 'C');

    // Descargar el archivo PDF
    $pdf->Output('ticket_venta_' . $venta['id_venta'] . '.pdf', 'D'); // 'D' for download
} else {
    echo "Error: No se encontró la venta.";
}
?>
