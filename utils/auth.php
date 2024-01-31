<?php
include 'conexion.php';
function registerUser($email, $password)
{
    global $conn;

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (email, password) VALUES ('$email', '$hashedPassword')";
    if ($conn->query($sql) === TRUE) {
        return "Registro exitoso. Por favor, inicia sesión.";
    } else {
        return "Error al registrar al usuario: " . $conn->error;
    }
}

function loginUser($email, $password)
{
    global $conn;

    $sql = "SELECT * FROM usuarios WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            return true;
        }
    }
    return false;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'register') {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                echo registerUser($email, $password);
            } else {
                echo "Error: Todos los campos son requeridos para el registro.";
            }
        } elseif ($action === 'login') {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                if (loginUser($email, $password)) {
                    echo "Inicio de sesión exitoso.";
                } else {
                    echo "Credenciales incorrectas.";
                }
            } else {
                echo "Error: Todos los campos son requeridos para iniciar sesión.";
            }
        } else {
            echo "Error: Acción no válida.";
        }
    } else {
        echo "Error: No se proporcionó ninguna acción.";
    }
} else {
    echo "Error: Método de solicitud no válido.";
}

