<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4" style="color: #5e35b1;">Gestión de Empleados</h1>

    <div class="card shadow">
        <div class="card-header text-center">
            <h5><i class="fas fa-user-tie"></i> Registro de Empleados</h5>
        </div>
        <div class="card-body">
            <form action="procesar_empleado.php" method="POST">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="id_personal" class="form-label">ID (solo para modificar o eliminar):</label>
                        <input type="text" class="form-control" id="id_personal" name="id_personal" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="apellido_paterno" class="form-label">Primer Apellido:</label>
                        <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" required>
                    </div>
                    <div class="col-md-6">
                        <label for="apellido_materno" class="form-label">Segundo Apellido:</label>
                        <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="puesto" class="form-label">Puesto:</label>
                        <input type="text" class="form-control" id="puesto" name="puesto" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="fecha_ingreso" class="form-label">Fecha de Ingreso:</label>
                        <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
                    </div>
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="correo" class="form-label">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="col-md-6">
                        <label for="sueldo" class="form-label">Sueldo:</label>
                        <input type="number" class="form-control" id="sueldo" name="sueldo" step="0.01" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="estatus" class="form-label">Estatus:</label>
                        <select class="form-control" id="estatus" name="estatus" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
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

    <!-- Tabla para mostrar empleados -->
    <div class="card shadow mt-5">
        <div class="card-header text-center">
            <h5><i class="fas fa-list"></i> Lista de Empleados</h5>
        </div>
        <div class="card-body">
            <table id="tabla-empleados" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Primer Apellido</th>
                        <th>Segundo Apellido</th>
                        <th>Puesto</th>
                        <th>Fecha de Ingreso</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Correo</th>
                        <th>Sueldo</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Conexión a la base de datos
                    include('conec.php');
                    $sql = "SELECT * FROM empleados";
                    $result = mysqli_query($conn, $sql);

                    // Mostrar los empleados en la tabla
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
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.querySelector("#tabla-empleados");

        table.addEventListener("click", function (e) {
            if (e.target.closest("tr")) {
                const rowData = Array.from(e.target.closest("tr").children).map(td => td.textContent);

                // Rellenar el formulario con los datos de la fila seleccionada
                document.getElementById("id_personal").value = rowData[0];
                document.getElementById("nombre").value = rowData[1];
                document.getElementById("apellido_paterno").value = rowData[2];
                document.getElementById("apellido_materno").value = rowData[3];
                document.getElementById("puesto").value = rowData[4];
                document.getElementById("fecha_ingreso").value = rowData[5];
                document.getElementById("telefono").value = rowData[6];
                document.getElementById("direccion").value = rowData[7];
                document.getElementById("correo").value = rowData[8];
                document.getElementById("sueldo").value = rowData[9];
                document.getElementById("estatus").value = rowData[10];
            }
        });
    });
</script>
</body>
</html>
