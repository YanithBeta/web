<?php
include('conec.php'); // Incluir la conexión a la base de datos


// Obtener lista de productos, clientes y usuarios desde la base de datos
$sql_productos = "SELECT id_producto, nombre_producto, cod_barras, fecha_caducidad, costo_venta FROM productos";
$result_productos = mysqli_query($conn, $sql_productos);

$sql_clientes = "SELECT id_cliente, nombre FROM clientes";
$result_clientes = mysqli_query($conn, $sql_clientes);

$sql_usuarios = "SELECT id_usuario, nombre FROM usuarios";
$result_usuarios = mysqli_query($conn, $sql_usuarios);

// Consultar ventas para mostrar en la tabla
$sql_ventas = "SELECT ventas.*, clientes.nombre AS cliente_nombre, usuarios.nombre AS vendedor_nombre, productos.nombre_producto
               FROM ventas
               JOIN clientes ON ventas.id_cliente = clientes.id_cliente
               JOIN usuarios ON ventas.id_usuario = usuarios.id_usuario
               JOIN productos ON ventas.id_producto = productos.id_producto";
$result_ventas = mysqli_query($conn, $sql_ventas);
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
        .card-header, .table thead {
            background-color: #bbdefb; /* Azul claro */
            color: #5e35b1; /* Morado oscuro */
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
                    <input type="number" id="precio" name="precio" class="form-control" required >
                </div>

                <div class="mb-3">
                    <label for="total" class="form-label">Total</label>
                    <input type="number" id="total" name="total" class="form-control" required readonly>
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

<div class="mb-3" id="efectivo_recibido" style="display: none;">
    <label for="efectivo" class="form-label">Efectivo Recibido</label>
    <input type="number" id="efectivo" name="efectivo" class="form-control">
</div>

<div class="mb-3" id="cambio_mostrar" style="display: none;">
    <label for="cambio" class="form-label">Cambio</label>
    <input type="number" id="cambio" name="cambio" class="form-control" readonly>
</div>

<!-- Botón para Registrar Venta -->
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <button type="submit" class="btn btn-primary w-100">Registrar Venta</button>
</div>
            </form>
        </div>
    </div>
<!-- Tabla de ventas registradas -->
<div class="card">
    <div class="card-header text-center">
        <h3>Ventas Registradas</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Cliente</th>
                    <th>Vendedor</th>
                    <th>Producto</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                    <th>Método de Pago</th>
                    <th>Efectivo Recibido</th>
                    <th>Cambio</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php while ($venta = mysqli_fetch_assoc($result_ventas)) {
                    echo "<tr>
                            <td>{$venta['id_venta']}</td>
                            <td>{$venta['cliente_nombre']}</td>
                            <td>{$venta['vendedor_nombre']}</td>
                            <td>{$venta['nombre_producto']}</td>
                            <td>{$venta['fecha_venta']}</td>
                            <td>{$venta['cantidad']}</td>
                            <td>{$venta['precio_unitario']}</td>
                            <td>{$venta['total']}</td>
                            <td>{$venta['metodo_pago']}</td>
                            <td>{$venta['efectivo_recibido']}</td>
                            <td>{$venta['cambio']}</td>
                          </tr>";
                          
                          
                } ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <form action="procesar_cancelacion.php" method="post">
                <button type="submit" name="cancelar_ultima" class="btn btn-warning me-md-2">
                    <i class="fas fa-edit"></i> Cancelar última venta
                </button>
                <button type="submit" name="cancelar_todas" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Cancelar todas las ventas
                </button>
            </form>
        </div>
    </div>
</div>

 
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const productoSelect = document.getElementById('producto');
    const cantidadInput = document.getElementById('cantidad');
    const fechaVentaInput = document.getElementById('Fecha_venta'); // Referencia al campo de fecha de venta
    const precioInput = document.getElementById('precio');
    const totalInput = document.getElementById('total');
    const metodoPagoSelect = document.getElementById('metodo_pago');
    const efectivoRecibidoDiv = document.getElementById('efectivo_recibido');
    const cambioMostrarDiv = document.getElementById('cambio_mostrar');
    const efectivoInput = document.getElementById('efectivo');
    const cambioInput = document.getElementById('cambio');
    

   


    productoSelect.addEventListener('change', function() {
            const selectedOption = productoSelect.options[productoSelect.selectedIndex];
            const precio = parseFloat(selectedOption.getAttribute('data-precio')) || 0;
            precioInput.value = precio.toFixed(2);
            calcularTotal();
        });

        cantidadInput.addEventListener('input', calcularTotal);

        function calcularTotal() {
            const cantidad = parseFloat(cantidadInput.value) || 0;
            const precio = parseFloat(precioInput.value) || 0;
            totalInput.value = (cantidad * precio).toFixed(2);
            calcularCambio();
        }

    // Mostrar campos de efectivo y cambio al seleccionar cualquier método de pago
    metodoPagoSelect.addEventListener('change', function() {
        efectivoRecibidoDiv.style.display = 'block';
        cambioMostrarDiv.style.display = 'block';
    });

    // Calcular el cambio cuando se ingresa el efectivo recibido
    efectivoInput.addEventListener('input', calcularCambio);

    function calcularCambio() {
        const efectivoRecibido = parseFloat(efectivoInput.value) || 0;
        const total = parseFloat(totalInput.value) || 0;
        cambioInput.value = (efectivoRecibido - total).toFixed(2);
    }
});

</script>
</body>
</html>

