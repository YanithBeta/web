<?php
include('conec.php'); // Conexión a la base de datos
session_start();

// Consultar todos los clientes para mostrarlos en la tabla
$sql_clientes = "SELECT * FROM clientes";
$result_clientes = mysqli_query($conn, $sql_clientes);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color:#F5F5F5;">

<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <h3>Gestión de Clientes</h3>
        </div>
        <div class="card-body">
            <form action="procesar_cliente.php" method="post">
                <!-- ID del Cliente (solo para modificación) -->
                <input type="hidden" id="id_cliente" name="id_cliente">

                <!-- Información del Cliente -->
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" id="correo" name="correo" class="form-control" required>
                </div>

                <!-- Botones de acción -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" name="guardar" class="btn btn-primary">Guardar</button>
                    <button type="submit" name="modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                    <button type="reset" class="btn btn-secondary" onclick="limpiarFormulario()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de Clientes Registrados -->
    <div class="card mt-4">
        <div class="card-header text-center">
            <h4>Lista de Clientes</h4>
        </div>
        <div class="card-body">
            <table id="tabla-clientes" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_clientes)) : ?>
                        <tr onclick="cargarDatos(<?php echo $row['id_cliente'] . ', \'' . $row['nombre'] . '\', \'' . $row['telefono'] . '\', \'' . $row['correo'] . '\''; ?>)">
                            <td><?php echo $row['id_cliente']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['telefono']; ?></td>
                            <td><?php echo $row['correo']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tabla-clientes').DataTable();

        // Al hacer clic en una fila de la tabla, se rellenan los campos del formulario
        $('#tabla-clientes tbody').on('click', 'tr', function() {
            var rowData = $(this).children("td").map(function() {
                return $(this).text();
            }).get();

            // Rellenar el formulario con los datos de la fila seleccionada
            $('#id_cliente').val(rowData[0]);
            $('#nombre').val(rowData[1]);
            $('#telefono').val(rowData[2]);
            $('#correo').val(rowData[3]);
        });
    });

    // Función para limpiar el formulario
    function limpiarFormulario() {
        $('#id_cliente').val('');
        $('#nombre').val('');
        $('#telefono').val('');
        $('#correo').val('');
    }
</script>
</body>
</html>
