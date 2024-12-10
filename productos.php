<?php
include('conec.php'); // Incluir la conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
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
        <h1 class="text-center mb-4" style="color: #5e35b1;">Gestión de Productos</h1>

        <!-- Formulario para agregar o modificar un producto -->
        <div class="card shadow mb-4">
            <div class="card-header text-center">
                <h5><i class="fas fa-box-open"></i> Formulario de Productos</h5>
            </div>
            <div class="card-body">
                <form action="procesar_productos.php" method="POST" >
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="id_producto" class="form-label">ID del Producto (Para modificar):</label>
                            <input type="text" class="form-control" id="id_producto" name="id_producto" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="nombre_producto" class="form-label">Nombre del Producto:</label>
                            <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="cod_barras" class="form-label">Código de Barras:</label>
                            <input type="text" class="form-control" id="cod_barras" name="cod_barras" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cantidad" class="form-label">Cantidad:</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="proveedor" class="form-label">Proveedor:</label>
                            <input type="text" class="form-control" id="proveedor" name="proveedor" required>
                        </div>
                        <div class="col-md-6">
                            <label for="especificaciones" class="form-label">Especificaciones:</label>
                            <input type="text" class="form-control" id="especificaciones" name="especificaciones" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha_caducidad" class="form-label">Fecha de Caducidad:</label>
                            <input type="date" class="form-control" id="fecha_caducidad" name="fecha_caducidad" required>
                        </div>
                        <div class="col-md-3">
                            <label for="costo_compra" class="form-label">Costo de Compra:</label>
                            <input type="number" class="form-control" id="costo_compra" name="costo_compra" step="0.01" required>
                        </div>
                        <div class="col-md-3">
                            <label for="costo_venta" class="form-label">Costo de Venta:</label>
                            <input type="number" class="form-control" id="costo_venta" name="costo_venta" step="0.01" required>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" name="guardar" class="btn btn-custom me-md-2"><i class="fas fa-save"></i> Guardar</button>
                        <button type="submit" name="modificar" class="btn btn-warning me-md-2"><i class="fas fa-edit"></i> Modificar</button>
                        <button type="submit" name="eliminar" class="btn btn-danger me-md-2"><i class="fas fa-trash"></i> Eliminar</button>
                        <button type="button" class="btn btn-secondary" onclick="limpiarFormulario()"><i class="fas fa-ban"></i> Cancelar</button>


                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla que mostrará los productos -->
        <div class="card shadow">
            <div class="card-header text-center">
                <h5><i class="fas fa-list"></i> Lista de Productos</h5>
            </div>
            <div class="card-body">
                <table id="tabla-productos" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Código de Barras</th>
                            <th>Cantidad</th>
                            <th>Proveedor</th>
                            <th>Especificaciones</th>
                            <th>Fecha Caducidad</th>
                            <th>Costo Compra</th>
                            <th>Costo Venta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Consulta para obtener los productos
                        $sql = "SELECT * FROM productos";
                        $result = mysqli_query($conn, $sql);

                        // Mostrar los productos en la tabla
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
            $('#tabla-productos').DataTable();

            // Al hacer clic en una fila de la tabla, se rellenan los campos del formulario
            $('#tabla-productos tbody').on('click', 'tr', function() {
                var rowData = $(this).children("td").map(function() {
                    return $(this).text();
                }).get();

                // Rellenar el formulario con los datos de la fila seleccionada
                $('#id_producto').val(rowData[0]);
                $('#nombre_producto').val(rowData[1]);
                $('#cod_barras').val(rowData[2]);
                $('#cantidad').val(rowData[3]);
                $('#proveedor').val(rowData[4]);
                $('#especificaciones').val(rowData[5]);
                $('#fecha_caducidad').val(rowData[6]);
                $('#costo_compra').val(rowData[7]);
                $('#costo_venta').val(rowData[8]);
            });
        });
    </script>

</body>

</html>
