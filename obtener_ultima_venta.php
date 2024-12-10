<?php
include 'conexion.php'; // Conexión a la base de datos

$query = "SELECT * FROM ventas ORDER BY id_venta DESC LIMIT 1";
$result = $conexion->query($query);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data);
} else {
    echo json_encode(["error" => "No hay ventas registradas."]);
}
?>

