<?php
include('conec.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_personal = $_POST['id_personal'];
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $puesto = $_POST['puesto'];
    
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $sueldo = $_POST['sueldo'];
    $estatus = $_POST['estatus'];

    if (isset($_POST['modificar'])) {
        $sql = "UPDATE empleados SET 
                    nombre = '$nombre',
                    apellido_paterno = '$apellido_paterno',
                    apellido_materno = '$apellido_materno',
                    puesto = '$puesto',
                    
                    fecha_ingreso = '$fecha_ingreso',
                    telefono = '$telefono',
                    direccion = '$direccion',
                    correo = '$correo',
                    sueldo = '$sueldo',
                    estatus = '$estatus'
                WHERE id_personal = '$id_personal'";

        if (mysqli_query($conn, $sql)) {
            header("Location: empleados.php");
            exit();
        } else {
            echo "Error al actualizar el empleado: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['guardar'])) {
        $sql = "INSERT INTO empleados 
                (nombre, apellido_paterno, apellido_materno, puesto,  fecha_ingreso, telefono, direccion, correo, sueldo, estatus) 
                VALUES 
                ('$nombre', '$apellido_paterno', '$apellido_materno', '$puesto',  '$fecha_ingreso', '$telefono', '$direccion', '$correo', '$sueldo', '$estatus')";

        if (mysqli_query($conn, $sql)) {
            header("Location: empleados.php");
            exit();
        } else {
            echo "Error al guardar el empleado: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['eliminar'])) {
        $sql = "DELETE FROM empleados WHERE id_personal = '$id_personal'";
        if (mysqli_query($conn, $sql)) {
            header("Location: empleados.php");
            exit();
        } else {
            echo "Error al eliminar el empleado: " . mysqli_error($conn);
        }
    }
}
?>
