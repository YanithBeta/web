<?php
require('fpdf/fpdf.php');
include('conec.php'); // Conexión a la base de datos

class PDF extends FPDF
{
    // Encabezado del reporte
    function Header()
    {
        // Fondo de color para el encabezado
        $this->SetFillColor(135, 206, 235); // Azul claro
        $this->Rect(0, 0, $this->GetPageWidth(), 20, 'F');
        
        // Fuente y texto del título
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(255, 255, 255); // Blanco
        $this->Cell(0, 10, 'Reporte de Productos', 0, 1, 'C');
        $this->Ln(10);
        
        // Resetear color de texto
        $this->SetTextColor(0, 0, 0);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128, 128, 128); // Gris
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }

    // Encabezados de la tabla de productos
    function HeaderTable()
    {
        $this->SetFillColor(135, 206, 235); // Azul claro
        $this->SetTextColor(0, 0, 0); // Texto negro
        $this->SetFont('Arial', 'B', 9); // Fuente más pequeña para los encabezados
        
        $this->Cell(12, 8, 'ID', 1, 0, 'C', true);
        $this->Cell(20, 8, 'Nombre', 1, 0, 'C', true);
        $this->Cell(25, 8, 'Cod. Barras', 1, 0, 'C', true);
        $this->Cell(20, 8, 'Cantidad', 1, 0, 'C', true);
        $this->Cell(20, 8, 'Proveedor', 1, 0, 'C', true);
        $this->Cell(30, 8, 'Especificaciones', 1, 0, 'C', true);
        $this->Cell(20, 8, 'Caducidad', 1, 0, 'C', true);
        $this->Cell(20, 8, 'Costo C.', 1, 0, 'C', true);
        $this->Cell(20, 8, 'Costo V.', 1, 1, 'C', true); // La última celda hace salto de línea
    }

    // Datos de la tabla de productos
    function ViewTable($conn)
    {
        $this->SetFont('Arial', '', 8); // Fuente más pequeña para los datos
        $this->SetTextColor(0, 0, 0); // Color de texto negro para los datos
        $this->SetFillColor(245, 245, 245); // Color de fondo gris claro para las celdas de datos

        $sql = "SELECT * FROM productos";
        $result = mysqli_query($conn, $sql);

        $fill = false; // Alternar color de fondo de las filas

        while ($row = mysqli_fetch_assoc($result)) {
            $this->Cell(12, 8, $row['id_producto'], 1, 0, 'C', $fill);
            $this->Cell(20, 8, $row['nombre_producto'], 1, 0, 'C', $fill);
            $this->Cell(25, 8, $row['cod_barras'], 1, 0, 'C', $fill);
            $this->Cell(20, 8, $row['cantidad'], 1, 0, 'C', $fill);
            $this->Cell(20, 8, $row['proveedor'], 1, 0, 'C', $fill);
            $this->Cell(30, 8, $row['especificaciones'], 1, 0, 'C', $fill);
            $this->Cell(20, 8, $row['fecha_caducidad'], 1, 0, 'C', $fill);
            $this->Cell(20, 8, number_format($row['costo_compra'], 2), 1, 0, 'C', $fill);
            $this->Cell(20, 8, number_format($row['costo_venta'], 2), 1, 1, 'C', $fill);

            $fill = !$fill; // Alternar el color de fondo para la siguiente fila
        }
    }
}

// Crear instancia de PDF y generar el contenido
$pdf = new PDF();
$pdf->AddPage();
$pdf->HeaderTable();
$pdf->ViewTable($conn);
$pdf->Output();
?>
