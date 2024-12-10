<?php
include('conec.php'); // Incluir la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se presionó el botón "Cancelar última venta"
    if (isset($_POST['cancelar_ultima'])) {
        // Cancelar la última venta (la de ID más alto)
        $sql_cancelar_ultima = "DELETE FROM ventas ORDER BY id_venta DESC LIMIT 1";
        
        if (mysqli_query($conn, $sql_cancelar_ultima)) {
            echo "<script>alert('Última venta cancelada exitosamente'); window.location.href='ventas.php';</script>";
        } else {
            echo "Error al cancelar la última venta: " . mysqli_error($conn);
        }
    }

    // Verificar si se presionó el botón "Cancelar todas las ventas"
    if (isset($_POST['cancelar_todas'])) {
        // Cancelar todas las ventas
        $sql_cancelar_todas = "DELETE FROM ventas";
        
        if (mysqli_query($conn, $sql_cancelar_todas)) {
            echo "<script>alert('Todas las ventas han sido canceladas'); window.location.href='ventas.php';</script>";
        } else {
            echo "Error al cancelar todas las ventas: " . mysqli_error($conn);
        }
    }
}

echo "<script>alert('Última venta cancelada exitosamente'); window.location.href='ventas.php';</script>";
header("Location: ventas.php");
exit;
// Cerrar conexión a la base de datos
mysqli_close($conn);
?>
