<?php
require('fpdf/fpdf.php'); // Incluye la librería FPDF
include('conec.php'); // Conexión a la base de datos

// Consulta para obtener los empleados
$sql = "SELECT * FROM empleados";
$result = mysqli_query($conn, $sql);

// Crear instancia de FPDF con tamaño carta
$pdf = new FPDF('P', 'mm', 'A4'); // 'P' para orientación vertical, 'mm' para milímetros y 'A4' para tamaño carta
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12); // Fuente más pequeña para el título

// Título del reporte
$pdf->SetTextColor(255, 255, 255); // Color blanco para el texto del título
$pdf->SetFillColor(135, 206, 235); // Color de fondo azul claro
$pdf->Cell(0, 10, 'Reporte de Empleados', 0, 1, 'C', true);
$pdf->Ln(5); // Salto de línea

// Encabezados de la tabla con colores
$pdf->SetFont('Arial', 'B', 9); // Fuente más pequeña para los encabezados
$pdf->SetFillColor(135, 206, 235); // Color de fondo para las celdas de encabezado (azul claro)
$pdf->SetTextColor(0, 0, 0); // Color de texto negro para los encabezados

$pdf->Cell(12, 8, 'ID', 1, 0, 'C', true);
$pdf->Cell(20, 8, 'Nombre', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Apellido Paterno', 1, 0, 'C', true);
$pdf->Cell(23, 8, 'Puesto', 1, 0, 'C', true);
$pdf->Cell(23, 8, 'Fecha Ingreso', 1, 0, 'C', true);
$pdf->Cell(23, 8, 'Teléfono', 1, 0, 'C', true);
$pdf->Cell(23, 8, 'Dirección', 1, 0, 'C', true);
$pdf->Cell(23, 8, 'Sueldo', 1, 0, 'C', true);
$pdf->Cell(23, 8, 'Estatus', 1, 1, 'C', true); // La última celda hace salto de línea

// Datos de la tabla con estilo y color
$pdf->SetFont('Arial', '', 8); // Fuente más pequeña para los datos
$pdf->SetTextColor(0, 0, 0); // Color de texto negro para los datos
$pdf->SetFillColor(245, 245, 245); // Color de fondo claro para las celdas de datos (gris claro)

if (mysqli_num_rows($result) > 0) {
    $fill = false; // Alternar el color de fondo de las filas
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(12, 8, $row['id_personal'], 1, 0, 'C', $fill);
        $pdf->Cell(20, 8, $row['nombre'], 1, 0, 'C', $fill);
        $pdf->Cell(25, 8, $row['apellido_paterno'], 1, 0, 'C', $fill);
        $pdf->Cell(23, 8, $row['puesto'], 1, 0, 'C', $fill);
        $pdf->Cell(23, 8, $row['fecha_ingreso'], 1, 0, 'C', $fill);
        $pdf->Cell(23, 8, $row['telefono'], 1, 0, 'C', $fill);
        $pdf->Cell(23, 8, $row['direccion'], 1, 0, 'C', $fill);
        $pdf->Cell(23, 8, $row['sueldo'], 1, 0, 'C', $fill);
        $pdf->Cell(23, 8, $row['estatus'], 1, 1, 'C', $fill); // Salto de línea después de cada fila
        $fill = !$fill; // Cambia el color de fondo para la siguiente fila
    }
} else {
    $pdf->Cell(0, 10, 'No hay empleados registrados.', 1, 1, 'C');
}

// Output del PDF
$pdf->Output();
?>
