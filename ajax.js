// productos.php

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
$(document).ready(function() {
  
    function cargarProductos() {
        $.ajax({
            url: "mostrar_datos.php", 
            type: "GET",
            success: function(data) {
                $('#tabla-productos tbody').html(data); 
            }
        });
    }
    cargarProductos();
   
    $("form").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: "procesar_productos.php", 
            type: "POST",
            data: $(this).serialize(), 
            success: function(response) {
                alert("Producto guardado con éxito");
                cargarProductos(); 
            }
        });
    });
});

function cargarUsuarios() {
    $.ajax({
        url: "mostrar_usuarios.php", 
        type: "GET",
        success: function(data) {
            $('#tabla-usuarios tbody').html(data); 
        }
    });
}


cargarUsuarios();


$("#form-usuarios").on("submit", function(e) {
    e.preventDefault();
    $.ajax({
        url: "procesar_usuarios.php", 
        type: "POST",
        data: $(this).serialize(), 
        success: function(response) {
            alert("Usuario guardado con éxito");
            cargarUsuarios(); 
        }
    });
});

function mostrarFormulario(formulario) {
    // Ocultar todos los formularios
    document.getElementById('productos').style.display = 'none';
    document.getElementById('usuarios').style.display = 'none';
    document.getElementById('ventas').style.display = 'none';

    // Mostrar el formulario seleccionado
    document.getElementById(formulario).style.display = 'block';
}




    $(document).ready(function () {
        $('#tabla-ventas').DataTable();

        // Botón para eliminar la última venta
        $('#eliminar-ultima-venta').click(function () {
            if (confirm('¿Estás seguro de que deseas eliminar la última venta?')) {
                fetch('eliminar_ventas.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'operation=delete_last'
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Última venta eliminada correctamente.');
                            location.reload(); // Recargar la página
                        } else {
                            alert('Error al eliminar la última venta.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        // Botón para eliminar todas las ventas
        $('#eliminar-todas-ventas').click(function () {
            if (confirm('¿Estás seguro de que deseas eliminar todas las ventas?')) {
                fetch('eliminar_ventas.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'operation=delete_all'
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Todas las ventas han sido eliminadas.');
                            location.reload(); // Recargar la página
                        } else {
                            alert('Error al eliminar todas las ventas.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    });


    metodoPago.addEventListener("change", function () {
        bancosDiv.style.display = "none";
        tarjetaDiv.style.display = "none";
        pinDiv.style.display = "none";
        efectivoRecibidoDiv.style.display = "none";
        cambioDiv.style.display = "none";
    
        // Limpia el estado "required" de todos los campos
        numeroTarjetaInput.removeAttribute("required");
        document.getElementById("banco").removeAttribute("required");
    
        if (this.value === "Tarjeta") {
            bancosDiv.style.display = "block";
            tarjetaDiv.style.display = "block";
            pinDiv.style.display = "block";
    
            // Activa "required" para número de tarjeta y banco
            numeroTarjetaInput.setAttribute("required", "true");
            document.getElementById("banco").setAttribute("required", "true");
    
            // Mostrar los primeros 4 dígitos según el banco seleccionado
            actualizarTarjeta();
        } else if (this.value === "Efectivo") {
            efectivoRecibidoDiv.style.display = "block";
            cambioDiv.style.display = "block";
        }
    });
    
    document.querySelector("form").addEventListener("submit", function (event) {
        if (metodoPago.value === "Tarjeta") {
            const numeroTarjeta = numeroTarjetaInput.value.trim();
            const bancoSeleccionado = document.getElementById("banco").value;
    
            if (numeroTarjeta.length !== 16 || bancoSeleccionado === "") {
                alert("Por favor, completa los datos de la tarjeta correctamente.");
                event.preventDefault(); // Detener el envío del formulario
            }
        }
    });
    