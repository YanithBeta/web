<?php
session_start();
include('conec.php'); // Asegúrate de que 'conec.php' está correctamente configurado.

$fecha_inicio = null;
$fecha_fin = null;
$empleado = null;
$whereClause = " WHERE 1=1"; // Base para condiciones WHERE

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Filtro por empleado
    if (!empty($_POST['empleados'])) {
        $empleado = $_POST['empleados'];
        $whereClause .= " AND v.id_usuario = '$empleado'";
    }

    // Filtro por día
    if (!empty($_POST['filtro']) && $_POST['filtro'] === 'dia' && !empty($_POST['fecha'])) {
        $fecha_inicio = $_POST['fecha'];
        $whereClause .= " AND v.fecha_venta = '$fecha_inicio'";
    }

    // Filtro por semana
    if (!empty($_POST['filtro']) && $_POST['filtro'] === 'semana' && !empty($_POST['semana'])) {
        $fecha_inicio = date('Y-m-d', strtotime("monday this week", strtotime($_POST['semana'])));
        $fecha_fin = date('Y-m-d', strtotime("sunday this week", strtotime($_POST['semana'])));
        $whereClause .= " AND v.fecha_venta BETWEEN '$fecha_inicio' AND '$fecha_fin'";
    }

    // Filtro por mes
    if (!empty($_POST['filtro']) && $_POST['filtro'] === 'mes' && !empty($_POST['mes'])) {
        $fecha_inicio = date('Y-m-01', strtotime($_POST['mes']));
        $fecha_fin = date('Y-m-t', strtotime($_POST['mes']));
        $whereClause .= " AND v.fecha_venta BETWEEN '$fecha_inicio' AND '$fecha_fin'";
    }
}

// Obtener lista de empleados
$empleados_result = mysqli_query($conn, "SELECT id_personal, nombre FROM empleados");

// Consulta de ventas
$ventas_query = "
    SELECT 
        v.fecha_venta AS fecha, 
        e.nombre AS empleado, 
        c.nombre AS cliente, 
        p.nombre_producto AS producto, 
        v.cantidad, 
        v.precio_unitario, 
        v.total_venta AS total, 
        v.metodo_pago 
    FROM ventas2 v
    LEFT JOIN empleados e ON v.id_usuario = e.id_personal
    LEFT JOIN clientes c ON v.id_cliente = c.id_cliente
    LEFT JOIN productos p ON v.id_producto = p.id_producto
    $whereClause";

$ventas_result = mysqli_query($conn, $ventas_query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script>
        function toggleFechaInputs() {
            let filtro = document.getElementById('filtro').value;
            document.getElementById('fechaDiv').style.display = filtro === 'dia' ? 'block' : 'none';
            document.getElementById('semanaDiv').style.display = filtro === 'semana' ? 'block' : 'none';
            document.getElementById('mesDiv').style.display = filtro === 'mes' ? 'block' : 'none';
        }
    </script>
</head>
<body onload="toggleFechaInputs()">
<div class="container mt-5">
    <h3>Reporte de Ventas</h3>
    <form method="POST">
        <div class="row">
            <div class="col">
                <label for="empleados">Empleado:</label>
                <select name="empleados" id="id_personal" class="form-control">
                    <option value="">--Seleccione--</option>
                    <?php while ($empleados = mysqli_fetch_assoc($empleados_result)): ?>
                        <option value="<?= $empleados['id_personal'] ?>" <?= isset($_POST['empleados']) && $_POST['empleados'] == $empleados['id_personal'] ? 'selected' : '' ?>>
                            <?= $empleados['nombre'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="col">
                <label for="filtro">Filtrar por:</label>
                <select name="filtro" id="filtro" class="form-control" onchange="toggleFechaInputs();">
                    <option value="">--Seleccione--</option>
                    <option value="dia" <?= isset($_POST['filtro']) && $_POST['filtro'] === 'dia' ? 'selected' : '' ?>>Día</option>
                    <option value="semana" <?= isset($_POST['filtro']) && $_POST['filtro'] === 'semana' ? 'selected' : '' ?>>Semana</option>
                    <option value="mes" <?= isset($_POST['filtro']) && $_POST['filtro'] === 'mes' ? 'selected' : '' ?>>Mes</option>
                </select>
            </div>

            <div class="col" id="fechaDiv" style="display: none;">
                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" class="form-control" value="<?= $_POST['fecha'] ?? '' ?>">
            </div>

            <div class="col" id="semanaDiv" style="display: none;">
                <label for="semana">Semana:</label>
                <input type="week" name="semana" class="form-control" value="<?= $_POST['semana'] ?? '' ?>">
            </div>

            <div class="col" id="mesDiv" style="display: none;">
                <label for="mes">Mes:</label>
                <input type="month" name="mes" class="form-control" value="<?= $_POST['mes'] ?? '' ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
    </form>
    <hr>
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Empleado</th>
                <th>Cliente</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
                <th>Método de Pago</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($ventas_result && mysqli_num_rows($ventas_result) > 0): ?>
                <?php while ($venta = mysqli_fetch_assoc($ventas_result)): ?>
                    <tr>
                        <td><?= $venta['fecha'] ?></td>
                        <td><?= $venta['empleado'] ?></td>
                        <td><?= $venta['cliente'] ?></td>
                        <td><?= $venta['producto'] ?></td>
                        <td><?= $venta['cantidad'] ?></td>
                        <td><?= $venta['precio_unitario'] ?></td>
                        <td><?= $venta['total'] ?></td>
                        <td><?= $venta['metodo_pago'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No hay ventas para mostrar</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
