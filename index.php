<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Registro</title>
    <link rel="stylesheet" href="./src/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <form id="login-form" action="#" method="POST">
            <h2>Iniciar Sesión</h2>
            <label for="login-email">Correo electrónico:</label>
            <input type="email" id="login-email" name="email" required /><br />

            <label for="login-password">Contraseña:</label>
            <input type="password" id="login-password" name="password" required /><br />

            <input type="submit" value="Iniciar Sesión" />

            <p>
                ¿Aún no tienes una cuenta?
                <a href="#" id="toggle-form">Regístrate aquí</a>
            </p>
        </form>

        <form id="register-form" action="#" method="POST" style="display: none">
            <h2>Registro de Usuario</h2>
            <label for="register-email">Correo electrónico:</label>
            <input type="email" id="register-email" name="email" required /><br />

            <label for="register-password">Contraseña:</label>
            <input type="password" id="register-password" name="password" required /><br />

            <input type="submit" value="Registrarse" />
        </form>

        <div id="message"></div>
    </div>

    <script>
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
                        window.location.href = './src/page/dashboard.php';
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
                        window.location.href = './src/page/dashboard.php'; // Corrección de la ruta
                    },
                    error: function (xhr, status, error) {
                        console.error("Error en la solicitud AJAX:", error);
                    }
                });
            });
        });
    </script>
</body>

</html>