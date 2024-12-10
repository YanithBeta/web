<?php
include('conec.php'); // Conexión a la base de datos

// Consulta para obtener todos los empleados
$sql = "SELECT * FROM empleados";
$result = mysqli_query($conn, $sql);

// Verificamos si la consulta tuvo resultados
if (mysqli_num_rows($result) > 0) {
    // Generamos las filas de la tabla para cada empleado
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['id_personal']}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['apellido_paterno']}</td>
                <td>{$row['apellido_materno']}</td>
                <td>{$row['puesto']}</td>
                <td>{$row['fecha_ingreso']}</td>
                <td>{$row['telefono']}</td>
                <td>{$row['direccion']}</td>
                <td>{$row['correo']}</td>
                <td>{$row['sueldo']}</td>
                <td>{$row['estatus']}</td>
              </tr>";
    }
} else {
    // Si no hay registros, mostramos un mensaje
    echo "<tr><td colspan='11'>No hay empleados registrados.</td></tr>";
}
?>
