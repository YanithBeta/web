
<?php
include('conec.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $accion = $_POST['accion'];

   
    if ($accion === 'Registrar') {
        $sql = "INSERT INTO usuarios (nombre, correo) VALUES ('$nombre', '$correo')";
        if (mysqli_query($conexion, $sql)) {
            echo "Registro exitoso.";
        } else {
            echo "Error: " . mysqli_error($conexion);
        }
    }
    
    
    elseif ($accion === 'Modificar') {
        $id = $_POST['id']; 
        $sql = "UPDATE usuarios SET nombre='$nombre', correo='$correo' WHERE id=$id";
        if (mysqli_query($conexion, $sql)) {
            echo "Modificación exitosa.";
        } else {
            echo "Error: " . mysqli_error($conexion);
        }
    }
    
   
    elseif ($accion === 'Eliminar') {
        $id = $_POST['id']; 
        $sql = "DELETE FROM usuarios WHERE id=$id";
        if (mysqli_query($conexion, $sql)) {
            echo "Eliminación exitosa.";
        } else {
            echo "Error: " . mysqli_error($conexion);
        }
    }
}
?>
