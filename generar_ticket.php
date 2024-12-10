<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Venta y Devolución</title>
    <style>
        /* Estilo general */
        body {
            font-family: Arial, sans-serif;
            width: 300px;
            margin: 0 auto;
            text-align: center;
            background-color: #f3f4f6;
            color: #333;
        }
        .ticket, .devolucion {
            border: 2px dashed #8e44ad;
            padding: 15px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .ticket h2, .devolucion h2 {
            color: #8e44ad;
            font-size: 1.6em;
            margin: 0;
            padding: 10px 0;
            border-bottom: 1px solid #8e44ad;
        }
        .ticket p, .devolucion p {
            margin: 8px 0;
            font-size: 1em;
        }
        .ticket .total {
            font-size: 1.3em;
            font-weight: bold;
            color: #d35400;
        }
        .highlight {
            color: #2980b9;
            font-weight: bold;
        }
        .footer {
            font-size: 0.9em;
            color: #555;
        }
    </style>
</head>
<body>

    <!-- Contenedor para el ticket -->
    <div id="ticket-container"></div>

    <!-- Formulario de devolución -->
    <div class="devolucion" id="devolucion-form-container" style="display: none;">
        <h2>Formulario de Devolución</h2>
        <form id="devolucion-form">
            <p><strong>Motivo de Devolución:</strong></p>
            <textarea name="motivo" id="motivo" rows="3" style="width: 100%;" required></textarea>
            <input type="hidden" name="id_venta" id="id_venta">
            <button type="submit" style="margin-top: 10px; padding: 8px 15px; background-color: #e74c3c; color: white; border: none; border-radius: 4px; cursor: pointer;">Procesar Devolución</button>
        </form>
        <p id="devolucion-msg" style="color: green; display: none;">¡Devolución procesada correctamente!</p>
    </div>

    <script>
        // Función para cargar la última venta en el ticket
        function cargarTicket() {
            fetch('obtener_ultima_venta.php')
                .then(response => response.json())
                .then(data => {
                    // Verificar que no haya un error en la respuesta
                    if (!data.error) {
                        document.getElementById('ticket-container').innerHTML = `
                            <div class="ticket">
                                <h2>Bodeguita - Ticket de Venta</h2>
                                <p><strong>Fecha:</strong> <span class="highlight">${data.fecha_venta}</span></p>
                                <p><strong>Cliente:</strong> <span class="highlight">${data.cliente_nombre}</span></p>
                                <p><strong>Vendedor:</strong> <span class="highlight">${data.vendedor_nombre}</span></p>
                                <hr>
                                <p><strong>Producto:</strong> <span class="highlight">${data.nombre_producto}</span></p>
                                <p><strong>Cantidad:</strong> <span class="highlight">${data.cantidad}</span></p>
                                <p><strong>Precio Unitario:</strong> $<span class="highlight">${parseFloat(data.precio_unitario).toFixed(2)}</span></p>
                                <p class="total"><strong>Total:</strong> $<span class="highlight">${parseFloat(data.total).toFixed(2)}</span></p>
                                <hr>
                                <p><strong>Método de Pago:</strong> <span class="highlight">${data.metodo_pago}</span></p>
                                ${data.metodo_pago === 'Efectivo' ? `
                                    <p><strong>Efectivo Recibido:</strong> $<span class="highlight">${parseFloat(data.efectivo_recibido).toFixed(2)}</span></p>
                                    <p><strong>Cambio:</strong> $<span class="highlight">${parseFloat(data.cambio).toFixed(2)}</span></p>` : ''}
                                <hr>
                                <p class="footer">¡Gracias por su compra!</p>
                            </div>
                        `;
                        document.getElementById('id_venta').value = data.id_venta; // Set the venta ID for devoluciones
                         // Show devolución form
                    } else {
                        document.getElementById('ticket-container').innerHTML = `<p>${data.error}</p>`;
                       
                    }
                })
                .catch(error => console.error('Error al cargar el ticket:', error));
        }

        // Llamar a la función para cargar el ticket al inicio
        cargarTicket();

        // Actualizar el ticket cada 5 segundos
        setInterval(cargarTicket, 5000);

           </script>

</body>
</html>
