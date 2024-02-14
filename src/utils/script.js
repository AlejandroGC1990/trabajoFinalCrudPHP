// Función para manejar el cambio entre formularios (Iniciar Sesión / Registro)
$(document).ready(function () {
    // Manejar el cambio entre formularios
    $("#toggle-form").click(function (e) {
        e.preventDefault();
        $("#login-form, #register-form").toggle();
    });

    // Manejar el envío del formulario de registro
    $("#register-form").submit(function (event) {
        event.preventDefault(); // Prevenir el envío del formulario por defecto

        // Obtener los valores del formulario de registro
        var email = $("#register-email").val();
        var password = $("#register-password").val();

        // Enviar la solicitud AJAX al servidor
        $.ajax({
            type: "POST",
            url: "./src/utils/auth.php",
            data: {
                action: "register",
                email: email,
                password: password
            },
            success: function (response) {
                // Mostrar la respuesta del servidor en el elemento div
                $("#message").text(response);
                console.log("Registro exitoso");
                // window.location.href = './src/page/dashboard.php';
                window.location.href = './src/views/page/dashboard.php';
            },
            
            error: function (xhr, status, error) {
                console.error("Error en la solicitud AJAX:", error);
            }
        });
    });

    // Manejar el envío del formulario de inicio de sesión
    $("#login-form").submit(function (event) {
        // Prevenir el envío del formulario por defecto
        event.preventDefault();

        // Obtener los valores del formulario de inicio de sesión
        var email = $("#login-email").val();
        var password = $("#login-password").val();

        // Enviar la solicitud AJAX al servidor
        $.ajax({
            type: "POST",
            url: "./src/utils/auth.php",
            data: {
                action: "login",
                email: email,
                password: password
            },
            success: function (response) {
                // Mostrar la respuesta del servidor en el elemento div
                $("#message").text(response);
                console.log("Inicio de sesión exitoso");
                // window.location.href = './src/page/dashboard.php'; // Corrección de la ruta
                window.location.href = './src/views/page/dashboard.php';
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud AJAX:", error);
            }
        });
    });
});

//Recarga la página cuando se crea, actualiza o elimina una tarea
function recargarPagina() {
    $(document).ready(function() {
        $('#task-form form, #tabla-tareas form').submit(function(e) {
            e.preventDefault(); // Evitar que el formulario se envíe normalmente
            var form = $(this);
            $.post(form.attr('action'), form.serialize(), function(data) {
                // Recargar la página
                location.reload();
            });
        });
    });
}

