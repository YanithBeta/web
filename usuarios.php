<?php
include('conec.php'); // Incluir la conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #e3f2fd; /* Azul claro */
            color: #5e35b1; /* Morado */
        }

        .card-header {
            background-color: #bbdefb; /* Azul claro */
            color: #5e35b1; /* Morado oscuro */
        }

        .btn-custom {
            background-color: #b39ddb; /* Morado claro */
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #7e57c2; /* Morado más oscuro */
            color: white;
        }

        .table thead {
            background-color: #b39ddb; /* Morado claro */
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #e3f2fd; /* Azul claro */
        }

        .table-striped tbody tr:nth-of-type(even) {
            background-color: #bbdefb; /* Azul más oscuro */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center mb-4" style="color: #5e35b1;">Gestión de Usuarios</h1>

        <!-- Formulario para agregar o modificar un usuario -->
        <div class="card shadow mb-4">
            <div class="card-header text-center">
                <h5><i class="fas fa-user"></i> Formulario de Usuarios</h5>
            </div>
            <div class="card-body">
                <form id="form-usuarios" action="procesar_usuarios.php" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="id_usuario" class="form-label">ID del Usuario (Para modificar):</label>
                            <input type="text" class="form-control" id="id_usuario" name="id_usuario" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="a_paterno" class="form-label">Apellido Paterno:</label>
                            <input type="text" class="form-control" id="a_paterno" name="a_paterno" required>
                        </div>
                        <div class="col-md-6">
                            <label for="a_materno" class="form-label">Apellido Materno:</label>
                            <input type="text" class="form-control" id="a_materno" name="a_materno" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="clave" class="form-label">Clave:</label>
                            <input type="password" class="form-control" id="clave" name="clave" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="correo" class="form-label">Correo:</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" name="guardar" class="btn btn-custom me-md-2"><i class="fas fa-save"></i> Guardar</button>
                        <button type="submit" name="modificar" class="btn btn-warning me-md-2"><i class="fas fa-edit"></i> Modificar</button>
                        <button type="submit" name="eliminar" class="btn btn-danger me-md-2"><i class="fas fa-trash"></i> Eliminar</button>
                        <button type="reset" class="btn btn-secondary"><i class="fas fa-times"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla que mostrará los usuarios -->
        <div class="card shadow">
            <div class="card-header text-center">
                <h5><i class="fas fa-list"></i> Lista de Usuarios</h5>
            </div>
            <div class="card-body">
                <table id="tabla-usuarios" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Clave</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script>
        $(document).ready(function() {
            $('#tabla-usuarios').DataTable();

            // Al hacer clic en una fila de la tabla, se rellenan los campos del formulario
            $('#tabla-usuarios tbody').on('click', 'tr', function() {
                var rowData = $(this).children("td").map(function() {
                    return $(this).text();
                }).get();

                // Rellenar el formulario con los datos de la fila seleccionada
                $('#id_usuario').val(rowData[0]);
                $('#nombre').val(rowData[1]);
                $('#a_paterno').val(rowData[2]);
                $('#a_materno').val(rowData[3]);
                $('#clave').val(rowData[4]);
                $('#telefono').val(rowData[5]);
                $('#correo').val(rowData[6]);
            });
        });
    </script>

</body>

</html>
