<?php
require('fpdf/fpdf.php');
include('conec.php'); // Conexión a la base de datos

class PDF extends FPDF
{
    // Encabezado del reporte
    function Header()
    {
        // Fondo de color para el encabezado
        $this->SetFillColor(93, 173, 226); // Azul claro
        $this->Rect(0, 0, $this->GetPageWidth(), 20, 'F');
        
        // Fuente y título del encabezado
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(255, 255, 255); // Blanco
        $this->Cell(0, 10, 'Reporte de Usuarios', 0, 1, 'C');
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

    // Encabezados de la tabla de usuarios
    function HeaderTable()
    {
        $this->SetFillColor(52, 152, 219); // Azul intermedio
        $this->SetTextColor(255, 255, 255); // Blanco
        $this->SetFont('Arial', 'B', 9); // Tamaño de fuente más grande para encabezado
        
        // Ajustar ancho de columnas
        $this->Cell(20, 9, 'ID', 1, 0, 'C', true);
        $this->Cell(30, 9, 'Nombre', 1, 0, 'C', true);
        $this->Cell(35, 9, 'Apellido Paterno', 1, 0, 'C', true);
        $this->Cell(35, 9, 'Apellido Materno', 1, 0, 'C', true);
        $this->Cell(30, 9, 'Telefono', 1, 0, 'C', true);
        $this->Cell(50, 9, 'Correo', 1, 1, 'C', true);

        // Resetear color de texto
        $this->SetTextColor(0, 0, 0);
    }

    // Datos de la tabla de usuarios
    function ViewTable($conn)
    {
        $this->SetFont('Arial', '', 9); // Tamaño de fuente más grande para contenido
        $sql = "SELECT * FROM usuarios";
        $result = mysqli_query($conn, $sql);

        $fill = false; // Alternar color de fondo de las filas

        while ($row = mysqli_fetch_assoc($result)) {
            $this->SetFillColor(240, 248, 255); // Azul muy claro para filas alternas
            $this->Cell(20, 9, $row['id_usuario'], 1, 0, 'C', $fill);
            $this->Cell(30, 9, $row['nombre'], 1, 0, 'C', $fill);
            $this->Cell(35, 9, $row['a_paterno'], 1, 0, 'C', $fill);
            $this->Cell(35, 9, $row['a_materno'], 1, 0, 'C', $fill);
            $this->Cell(30, 9, $row['telefono'], 1, 0, 'C', $fill);
            $this->Cell(50, 9, $row['correo'], 1, 1, 'C', $fill);

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
