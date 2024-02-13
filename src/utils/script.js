$(document).ready(function() {
    // Evento para abrir el formulario flotante al hacer clic en el botón "Editar"
    $('#tasks').on('click', '.editar-btn', function() {
        var fila = $(this).closest('tr');
        var titulo = fila.find('td:nth-child(1)').text();
        var nivelImportancia = fila.find('td:nth-child(2)').text();
        var descripcion = fila.find('td:nth-child(3)').text();

        // Llenar el formulario con los datos de la tarea seleccionada
        $('#titulo-edicion').val(titulo);
        $('#nivel_importancia-edicion').val(nivelImportancia);
        $('#descripcion_tarea-edicion').val(descripcion);

        // Mostrar el formulario flotante
        $('#formulario-edicion').show();
    });

    // Evento para cerrar el formulario flotante al hacer clic en el botón "Cancelar"
    $('#cancelar-edicion').click(function() {
        $('#formulario-edicion').hide();
    });

    // Evitar que se envíe el formulario al presionar Enter
    $('#formulario-edicion').on('keypress', 'input', function(event) {
        return event.keyCode != 13; // 13 es el código de tecla Enter
    });

    // Capturar la edición y enviarla al servidor al hacer clic en el botón "Actualizar"
    $('#form-edicion').submit(function(event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        var titulo = $('#titulo-edicion').val();
        var nivelImportancia = $('#nivel_importancia-edicion').val();
        var descripcion = $('#descripcion_tarea-edicion').val();

        // Enviar los datos al servidor mediante AJAX
        $.ajax({
            url: 'actualizar_tarea.php',
            method: 'POST',
            data: {
                titulo: titulo,
                nivelImportancia: nivelImportancia,
                descripcion: descripcion
            },
            success: function(response) {
                // Ocultar el formulario flotante después de la actualización
                $('#formulario-edicion').hide();
                // Recargar la página para reflejar los cambios (puedes hacer esto de manera más elegante sin recargar la página)
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});
