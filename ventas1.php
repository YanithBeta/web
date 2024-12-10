<?php
include('conec.php'); // Incluir la conexión a la base de datos

// Obtener lista de productos, clientes y usuarios desde la base de datos
$sql_productos = "SELECT id_producto, nombre_producto, cod_barras, fecha_caducidad, costo_venta FROM productos";
$result_productos = mysqli_query($conn, $sql_productos);

$sql_clientes = "SELECT id_cliente, nombre FROM clientes";
$result_clientes = mysqli_query($conn, $sql_clientes);

$sql_usuarios = "SELECT id_usuario, nombre FROM usuarios";
$result_usuarios = mysqli_query($conn, $sql_usuarios);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro y Visualización de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F5F5F5;
        }

        .card-header,
        .table thead {
            background-color: #bbdefb;
            color: #5e35b1;
        }

        .btn-primary {
            background-color: #7e57c2;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card mb-4">
            <div class="card-header text-center">
                <h3>Registro de Venta</h3>
            </div>
            <div class="card-body">
                <form action="registrar_venta.php" method="post">
                    <!-- Información del Cliente -->
                    <div class="mb-3">
                        <label for="cliente" class="form-label">Cliente</label>
                        <select id="cliente" name="id_cliente" class="form-control" required>
                            <option value="">Seleccione un cliente</option>
                            <?php while ($cliente = mysqli_fetch_assoc($result_clientes)) {
                                echo "<option value='{$cliente['id_cliente']}'>{$cliente['nombre']}</option>";
                            } ?>
                        </select>
                    </div>

                    <!-- Información del Vendedor -->
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Vendedor</label>
                        <select id="usuario" name="id_usuario" class="form-control" required>
                            <option value="">Seleccione un vendedor</option>
                            <?php while ($usuario = mysqli_fetch_assoc($result_usuarios)) {
                                echo "<option value='{$usuario['id_usuario']}'>{$usuario['nombre']}</option>";
                            } ?>
                        </select>
                    </div>

                    <!-- Información del Producto -->
                    <div class="mb-3">
                        <label for="producto" class="form-label">Producto</label>
                        <select id="producto" name="id_producto" class="form-control" required>
                            <option value="">Seleccione un producto</option>
                            <?php while ($row = mysqli_fetch_assoc($result_productos)) {
                                echo "<option value='{$row['id_producto']}' data-precio='{$row['costo_venta']}'>{$row['nombre_producto']} - {$row['cod_barras']}</option>";
                            } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="Fecha_venta" class="form-label">Fecha de Venta</label>
                        <input type="date" id="Fecha_venta" name="Fecha_venta" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" id="cantidad" name="cantidad" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio Unitario</label>
                        <input type="number" id="precio" name="precio" class="form-control" required readonly>
                    </div>

                    <div class="mb-3">
                        <label for="total" class="form-label">Total por Producto</label>
                        <input type="number" id="total_producto" name="total_producto" class="form-control" required readonly>
                    </div>

                    <!-- Métodos de Pago -->
                    <div class="mb-3">
                        <label for="metodo_pago" class="form-label">Método de Pago</label>
                        <select id="metodo_pago" name="metodo_pago" class="form-control" required>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Efectivo">Efectivo</option>
                        </select>
                    </div>

                    <!-- Bancos -->
                    <div id="bancos_div" class="mb-3" style="display: none;">
                        <label for="banco" class="form-label">Selecciona tu Banco</label>
                        <select id="banco" name="banco" class="form-control">
                            <option value="BBVA">BBVA (+8%)</option>
                            <option value="Banco Azteca">Banco Azteca (+10%)</option>
                            <option value="otro">Otro (+15%)</option>
                        </select>
                    </div>

                    <!-- Número de Tarjeta -->
                    <div id="tarjeta_div" class="mb-3" style="display: none;">
                        <label for="numero_tarjeta" class="form-label">Número de Tarjeta</label>
                        <input type="text" id="numero_tarjeta" name="numero_tarjeta" class="form-control" maxlength="16" placeholder="Ingresa los 16 dígitos" >
                    </div>

                    <!-- PIN de Tarjeta -->
                    <div id="pin_div" class="mb-3" style="display: none;">
                        <label for="pin" class="form-label">PIN</label>
                        <input type="password" id="pin" name="pin" class="form-control" maxlength="4">
                    </div>

                    <!-- Efectivo -->
                    <div id="efectivo_recibido" class="mb-3" style="display: none;">
                        <label for="efectivo" class="form-label">Efectivo Recibido</label>
                        <input type="number" id="efectivo" name="efectivo" class="form-control">
                    </div>

                    <!-- Cambio -->
                    <div id="cambio_mostrar" class="mb-3" style="display: none;">
                        <label for="cambio" class="form-label">Cambio</label>
                        <input type="number" id="cambio" name="cambio" class="form-control" readonly>
                    </div>

                    <!-- Total Venta -->
                    <div class="mb-3">
                        <label for="total_input" class="form-label">Total Venta</label>
                        <input type="number" id="total_input" name="total_input" class="form-control" required readonly>
                    </div>

                    <!-- Comisión -->
                    <div class="mb-3">
                        <label for="comision" class="form-label">Comisión</label>
                        <input type="number" id="comision" name="comision" class="form-control" readonly>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Registrar Venta</button>

                </form>
            </div>
        </div>
    </div>

    <script>
        const metodoPago = document.getElementById("metodo_pago");
        const bancosDiv = document.getElementById("bancos_div");
        const tarjetaDiv = document.getElementById("tarjeta_div");
        const pinDiv = document.getElementById("pin_div");
        const efectivoRecibidoDiv = document.getElementById("efectivo_recibido");
        const cambioDiv = document.getElementById("cambio_mostrar");
        const cantidadInput = document.getElementById("cantidad");
        const precioInput = document.getElementById("precio");
        const totalProductoInput = document.getElementById("total_producto");
        const totalVentaInput = document.getElementById("total_input");
        const comisionInput = document.getElementById("comision");
        const numeroTarjetaInput = document.getElementById("numero_tarjeta");

        metodoPago.addEventListener("change", function() {
            bancosDiv.style.display = "none";
            tarjetaDiv.style.display = "none";
            pinDiv.style.display = "none";
            efectivoRecibidoDiv.style.display = "none";
            cambioDiv.style.display = "none";

            if (this.value === "Tarjeta") {
                bancosDiv.style.display = "block";
                tarjetaDiv.style.display = "block";
                pinDiv.style.display = "block";
                // Mostrar los primeros 4 dígitos según el banco seleccionado
                actualizarTarjeta();
            } else if (this.value === "Efectivo") {
                efectivoRecibidoDiv.style.display = "block";
                cambioDiv.style.display = "block";
            }
        });

        document.getElementById("producto").addEventListener("change", function() {
            const precio = this.options[this.selectedIndex].getAttribute("data-precio");
            precioInput.value = precio;
            actualizarTotalProducto();
        });

        cantidadInput.addEventListener("input", actualizarTotalProducto);

        function actualizarTotalProducto() {
            const cantidad = parseFloat(cantidadInput.value);
            const precio = parseFloat(precioInput.value);
            if (!isNaN(cantidad) && !isNaN(precio)) {
                const totalProducto = cantidad * precio;
                totalProductoInput.value = totalProducto.toFixed(2);
                actualizarTotalVenta();
            }
        }

        function actualizarTotalVenta() {
            const totalProducto = parseFloat(totalProductoInput.value);
            let totalVenta = totalProducto;

            if (metodoPago.value === "Tarjeta") {
                const banco = document.getElementById("banco").value;
                if (banco === "BBVA") totalVenta *= 1.08;
                else if (banco === "Banco Azteca") totalVenta *= 1.10;
                else if (banco === "otro") totalVenta *= 1.15;
            }

            totalVentaInput.value = totalVenta.toFixed(2);

            // Calcular la comisión (suponiendo una comisión fija del 2% del total de venta)
            const comision = totalVenta * 0.02;
            comisionInput.value = comision.toFixed(2);
        }

        // Función para actualizar el número de tarjeta según el banco seleccionado
        function actualizarTarjeta() {
            const banco = document.getElementById("banco").value;
            let primerosDigitos = "";

            if (banco === "BBVA") {
                primerosDigitos = "1000"; // Ejemplo de primeros 4 dígitos
            } else if (banco === "Banco Azteca") {
                primerosDigitos = "1111"; // Ejemplo de primeros 4 dígitos
            } else if (banco === "otro") {
                primerosDigitos = "1123"; // Ejemplo de primeros 4 dígitos
            }

            numeroTarjetaInput.value = primerosDigitos + " "; // Mostrar los primeros 4 dígitos
        }

        // Agregar la lógica para el cambio al escuchar el input de "efectivo"
document.getElementById("efectivo").addEventListener("input", function() {
    const efectivo = parseFloat(this.value);
    const totalVenta = parseFloat(totalVentaInput.value);

    if (!isNaN(efectivo) && !isNaN(totalVenta) && efectivo >= totalVenta) {
        const cambio = efectivo - totalVenta;
        cambioDiv.style.display = "block";  // Asegurarse de que el cambio se muestre
        document.getElementById("cambio").value = cambio.toFixed(2);  // Mostrar el cambio calculado
    } else {
        cambioDiv.style.display = "none";  // Ocultar el campo de cambio si el efectivo no cubre el total
    }
});
    </script>

<!-- Tabla de Ventas -->
<div class="card shadow-sm rounded-3">
    <div class="card-header text-center bg-dark text-white">
        <h5><i class="fas fa-list"></i> Lista de Ventas</h5>
    </div>
    <div class="card-body p-4">
        <table id="tabla-ventas" class="table table-hover table-sm">
            <thead class="thead-light">
                <tr>
                    <th>ID Venta</th>
                    <th>ID Cliente</th>
                    <th>ID Vendedor</th>
                    <th>ID Producto</th>
                    <th>Fecha Venta</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total Venta</th>
                    <th>Método de Pago</th>
                    <th>Banco</th>
                    <th>Número Tarjeta</th>
                    <th>Efectivo Recibido</th>
                    <th>Cambio</th>
                    <th>Comisión</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta para obtener las ventas
                $sql = "SELECT v.id_venta, v.id_cliente, v.id_usuario, v.id_producto, v.fecha_venta, v.cantidad, v.precio_unitario, 
                               v.total_venta, v.metodo_pago, v.banco, v.numero_tarjeta, v.efectivo_recibido, v.cambio, v.comision
                        FROM ventas2 v";
                $result = mysqli_query($conn, $sql);

                // Mostrar las ventas en la tabla
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['id_venta']}</td>
                            <td>{$row['id_cliente']}</td>
                            <td>{$row['id_usuario']}</td>
                            <td>{$row['id_producto']}</td>
                            <td>{$row['fecha_venta']}</td>
                            <td>{$row['cantidad']}</td>
                            <td>{$row['precio_unitario']}</td>
                            <td>{$row['total_venta']}</td>
                            <td>{$row['metodo_pago']}</td>
                            <td>{$row['banco']}</td>
                            <td>{$row['numero_tarjeta']}</td>
                            <td>{$row['efectivo_recibido']}</td>
                            <td>{$row['cambio']}</td>
                            <td>{$row['comision']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery (necesario para DataTables) -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        // Inicializar la tabla DataTables
        $('#tabla-ventas').DataTable({
            "paging": true,    // Activar paginación
            "searching": true, // Activar búsqueda
            "ordering": true,  // Activar ordenación
            "info": true,      // Mostrar información de la tabla
            "lengthChange": true,  // Permitir cambiar el número de registros por página
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json" // Idioma en español
            }
        });
    });
</script>

</script>


</body>

</html>
