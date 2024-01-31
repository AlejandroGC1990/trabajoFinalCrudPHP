<?php
//Login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['login-email'];
    $password = $_POST['login-password'];
    if ($email == 'usuario@ejemplo.com' && $password == 'contraseña') {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Credenciales inválidas. Por favor, inténtalo de nuevo.";
    }
}

//Register
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    header("Location: dashboard.php");
    exit();
}
