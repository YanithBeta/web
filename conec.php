<?php
// Parámetros de conexión a MySQL
$servidor = "localhost";
$usuario = "root";
$password = "";  // La contraseña para root en XAMPP suele estar vacía
$bd = "nuevo3"; // Cambia esto al nombre de tu base de datos

// Crear la conexión
$conn = mysqli_connect($servidor, $usuario, $password, $bd);

// Verificar si la conexión falla
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>