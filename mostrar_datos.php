<?php
include('conec.php'); // Incluir conexión a la base de datos

// Obtener los productos de la base de datos
$sql = "SELECT * FROM productos";
$result = mysqli_query($conn, $sql);

// Generar las filas de la tabla con los datos
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['id_producto']}</td>
            <td>{$row['nombre_producto']}</td>
            <td>{$row['cod_barras']}</td>
            <td>{$row['cantidad']}</td>
            <td>{$row['proveedor']}</td>
            <td>{$row['especificaciones']}</td>
            <td>{$row['fecha_caducidad']}</td>
            <td>{$row['costo_compra']}</td>
            <td>{$row['costo_venta']}</td>
          </tr>";
}
?>
