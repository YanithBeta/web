<?php
session_start();
include('conexion.php');

// Verifica que el usuario esté logueado y que sea un usuario regular
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] != 'usuario') {
    header('Location: index.php');
    exit();
}

// Seleccionar un administrador al azar para mostrar en la sección "Atiende"
$admin_query = "SELECT nombre FROM usuarios WHERE tipo_usuario = 'admin'";
$admin_result = mysqli_query($conn, $admin_query);
$admins = [];
while ($row = mysqli_fetch_assoc($admin_result)) {
    $admins[] = $row['nombre'];
}
$admin_aleatorio = $admins[array_rand($admins)];

// Generar un código único de venta
$codigo_venta = 'VENTA-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));

// Obtener la fecha actual
$fecha = date("Y-m-d");

// Consulta para obtener la lista de productos
$productos = mysqli_query($conn, "SELECT * FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Venta - MiniSuper</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function actualizarTotal() {
            let total = 0;
            document.querySelectorAll(".cantidad").forEach(function(cantidadInput) {
                let precio = parseFloat(cantidadInput.dataset.precio) || 0;
                let cantidad = parseFloat(cantidadInput.value) || 0;
                total += precio * cantidad;
            });
            document.getElementById("total").innerText = total.toFixed(2);
            document.getElementById("total_input").value = total;
            calcularComision(); // Actualizar comisión si está seleccionado tarjeta
        }

        function calcularCambio() {
            let total = parseFloat(document.getElementById("total_input").value);
            let efectivo = parseFloat(document.getElementById("efectivo").value) || 0;
            let cambio = efectivo - total;
            document.getElementById("cambio").innerText = cambio >= 0 ? cambio.toFixed(2) : 'Monto insuficiente';
            document.getElementById("cambio_input").value = cambio >= 0 ? cambio.toFixed(2) : 0;
        }

        function validarPago() {
            let metodoPago = document.getElementById("metodo_pago").value;
            if (metodoPago === "efectivo") {
                let total = parseFloat(document.getElementById("total_input").value);
                let efectivo = parseFloat(document.getElementById("efectivo").value);
                if (efectivo >= total) {
                    document.getElementById("form_venta").submit();
                } else {
                    alert("El monto en efectivo es insuficiente para cubrir el total de la venta.");
                }
            } else if (metodoPago === "tarjeta") {
                document.getElementById("form_venta").submit(); // Enviar formulario directamente para tarjeta
            } else if (metodoPago === "transferencia") {
                document.getElementById("form_venta").submit(); // Enviar formulario directamente para transferencia
            }
        }

        function calcularComision() {
            let banco = document.getElementById("banco").value;
            let total = parseFloat(document.getElementById("total_input").value);
            let comision = 0;

            if (banco === "banamex") {
                comision = total * 0.08;
            } else if (banco === "santander") {
                comision = total * 0.10;
            } else if (banco === "otro") {
                comision = total * 0.15;
            }

            let totalConComision = total + comision;
            document.getElementById("total_comision").innerText = totalConComision.toFixed(2);
            document.getElementById("total_final_input").value = totalConComision;
        }

        function mostrarOpcionesPago() {
            let metodoPago = document.getElementById("metodo_pago").value;
            document.getElementById("pago_efectivo").style.display = metodoPago === "efectivo" ? "block" : "none";
            document.getElementById("pago_tarjeta").style.display = metodoPago === "tarjeta" ? "block" : "none";
            document.getElementById("pago_transferencia").style.display = metodoPago === "transferencia" ? "block" : "none";
        }
    </script>
</head>
<body>
    <h2>MiniSuper El Rapidin</h2>
    <p>Fecha: <?php echo $fecha; ?></p>
    <p>Atiende: <?php echo $admin_aleatorio; ?></p>
    <p>Código de Venta: <?php echo $codigo_venta; ?></p>

    <h3>Venta de Productos</h3>
    <form id="form_venta" action="procesar_venta.php" method="post">
        <input type="hidden" name="codigo_venta" value="<?php echo $codigo_venta; ?>">

        <table>
            <tr><th>Producto</th><th>Precio</th><th>Cantidad</th></tr>
            <?php while ($producto = mysqli_fetch_assoc($productos)) : ?>
            <tr>
                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                <td><input type="number" name="productos[<?php echo $producto['id']; ?>]" data-precio="<?php echo $producto['precio']; ?>" class="cantidad" min="0" onchange="actualizarTotal()"></td>
            </tr>
            <?php endwhile; ?>
        </table>
        
        <p>Total: $<span id="total">0.00</span></p>
        <input type="hidden" name="total" id="total_input">

        <label for="metodo_pago">Método de Pago:</label>
        <select name="metodo_pago" id="metodo_pago" onchange="mostrarOpcionesPago()" required>
            <option value="">Seleccione</option>
            <option value="efectivo">Efectivo</option>
            <option value="tarjeta">Tarjeta</option>
            <option value="transferencia">Transferencia</option>
        </select>

        <!-- Opciones para Pago en Efectivo -->
        <div id="pago_efectivo" style="display:none;">
            <label for="efectivo">Efectivo recibido:</label>
            <input type="number" id="efectivo" oninput="calcularCambio()">
            <p>Cambio: $<span id="cambio">0.00</span></p>
            <input type="hidden" name="cambio" id="cambio_input">
        </div>

        <!-- Opciones para Pago con Tarjeta -->
        <div id="pago_tarjeta" style="display:none;">
            <label for="banco">Banco:</label>
            <select name="banco" id="banco" onchange="calcularComision()" required>
                <option value="banorte">Banorte</option>
                <option value="bbva">BBVA</option>
                <option value="banamex">Banamex</option>
                <option value="banco_azteca">Banco Azteca</option>
                <option value="santander">Santander</option>
                <option value="american_express">American Express</option>
                <option value="otro">Otro</option>
            </select>
            <label for="tarjeta">Número de Tarjeta:</label>
            <input type="text" name="tarjeta" id="tarjeta" maxlength="16" required pattern="\d{16}" placeholder="0000 0000 0000 0000">
            <p>Total con Comisión: $<span id="total_comision">0.00</span></p>
            <input type="hidden" name="total_final" id="total_final_input">
            <label for="pin">PIN de Tarjeta:</label>
            <input type="password" id="pin" maxlength="4" required placeholder="****">
        </div>

        <!-- Opciones para Transferencia -->
        <div id="pago_transferencia" style="display:none;">
            <p>Realizar pago a través de transferencia bancaria.</p>
        </div>

        <!-- Botón de Pago que valida según el método de pago seleccionado -->
        <button type="button" onclick="validarPago()">Pagar</button>
    </form>
</body>
</html>
