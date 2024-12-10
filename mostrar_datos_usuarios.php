<?php
include('conec.php'); 


$sql = "SELECT * FROM usuarios";
$result = mysqli_query($conn, $sql);


while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['id_usuario']}</td>
            <td>{$row['nombre']}</td>
            <td>{$row['a_paterno']}</td>
            <td>{$row['a_materno']}</td>
            <td>{$row['clave']}</td>
            <td>{$row['telefono']}</td>
            <td>{$row['correo']}</td>
          </tr>";
}
?>
