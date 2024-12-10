<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #e3f2fd;
        }

        .navbar {
            background-color: #5e35b1;
        }

        .navbar-brand,
        .nav-link {
            color: white !important;
        }

        .nav-link:hover {
            background-color: #7e57c2;
        }

        .card-header {
            background-color: #bbdefb;
            color: #5e35b1;
        }

        .card-body {
            background-color: #e3f2fd;
        }

        .form-container {
            display: none;
        }
    </style>
</head>

<body>

    <!-- Menú de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Sistema de Gestión</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="mostrarFormulario('productos')"><i class="fas fa-box"></i> Gestión de Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="mostrarFormulario('usuarios')"><i class="fas fa-user"></i> Gestión de Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="mostrarFormulario('ventas1')"><i class="fas fa-shopping-cart"></i> Gestión de Ventas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Botón para descargar el reporte de ventas -->
    <div class="text-center mt-4">
    <a href="reporte_ventas_pdf.php" style="display: inline-block; padding: 8px 16px; font-size: 14px; color: #fff; text-decoration: none; border-radius: 25px; background: linear-gradient(45deg, #4caf50, #8bc34a); box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.15); font-weight: bold; transition: all 0.2s ease; margin-right: 10px;">
        <i class="fas fa-file-download" style="margin-right: 6px;"></i> Descargar Reporte de Ventas
    </a>
    
    <a href="ticket.php" style="display: inline-block; padding: 8px 16px; font-size: 14px; color: #fff; text-decoration: none; border-radius: 25px; background: linear-gradient(45deg, #ff4081, #ff80ab); box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.15); font-weight: bold; transition: all 0.2s ease;">
        <i class="fas fa-file-download" style="margin-right: 6px;"></i> Descargar Ticket de Ventas
    </a>
</div>

<div class="text-center mt-4">
    <a href="reporte_producto_simple.php" style="display: inline-block; padding: 8px 16px; font-size: 14px; color: #fff; text-decoration: none; border-radius: 25px; background: linear-gradient(45deg, #4caf50, #8bc34a); box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.15); font-weight: bold; transition: all 0.2s ease; margin-right: 10px;">
        <i class="fas fa-file-download" style="margin-right: 6px;"></i> Reporte Productos
    </a>

    <a href="reporte_usuarios_pdf.php" style="display: inline-block; padding: 8px 16px; font-size: 14px; color: #fff; text-decoration: none; border-radius: 25px; background: linear-gradient(45deg, #ff4081, #ff80ab); box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.15); font-weight: bold; transition: all 0.2s ease;">
        <i class="fas fa-file-download" style="margin-right: 6px;"></i> Reporte Usuarios
    </a>

    <a href="ventafiltro.php" style="display: inline-block; padding: 8px 16px; font-size: 14px; color: #fff; text-decoration: none; border-radius: 25px; background: linear-gradient(45deg, #ff4081, #ff80ab); box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.15); font-weight: bold; transition: all 0.2s ease;">
        <i class="fas fa-file-download" style="margin-right: 6px;"></i>  filtros_Ventas
    </a>

    <a href="reporte_empleado.php" style="display: inline-block; padding: 8px 16px; font-size: 14px; color: #fff; text-decoration: none; border-radius: 25px; background: linear-gradient(45deg, #4caf50, #8bc34a); box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.15); font-weight: bold; transition: all 0.2s ease; margin-right: 10px;">
        <i class="fas fa-file-download" style="margin-right: 6px;"></i> Reporte Empleados
    </a>

</div>

    <!-- Contenedor Principal -->
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header text-center">
                <h3>Bienvenido al Sistema de Gestión</h3>
            </div>
            <div class="card-body text-center">
                <p>Seleccione una de las opciones en el menú de navegación para gestionar productos, usuarios o ventas.</p>
            </div>
        </div>

        <!-- Formulario de Productos -->
        <div class="form-container mt-4" id="productos">
            <?php include('productos.php'); ?>
        </div>

        <!-- Formulario de Usuarios -->
        <div class="form-container mt-4" id="usuarios">
            <?php include('usuarios.php'); ?>
        </div>



        <!-- Formulario de Ventas -->
        <div class="form-container mt-4" id="ventas1">
            <?php include('ventas1.php'); ?>
        </div>

       

    <!-- JavaScript para mostrar y ocultar formularios -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function mostrarFormulario(formularioId) {
            // Ocultar todos los formularios
            document.querySelectorAll('.form-container').forEach(form => form.style.display = 'none');

            // Mostrar el formulario seleccionado
            document.getElementById(formularioId).style.display = 'block';
        }
    </script>
</body>

</html>
