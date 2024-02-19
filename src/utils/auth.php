<?php

//include './conexion.php';
 include './../../private/conexion.php';

session_start();

function registerUser($email, $password)
{
    global $conn;

    $sql = "INSERT INTO usuarios (email, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        $Id_usuario = $stmt->insert_id; 
        $_SESSION['Id_usuario'] = $Id_usuario; 
        echo "Registro exitoso";
    } else {
        echo "Error al registrar al usuario: " . $stmt->error;
    }
}

function loginUser($email, $password)
{
    global $conn;

    $sql = "SELECT * FROM usuarios WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            $_SESSION['Id_usuario'] = $user['Id_usuario'];
            echo "Inicio de sesión exitoso";
        } else {
            echo "Credenciales incorrectas.";
        }
    } else {
        echo "Credenciales incorrectas.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'register') {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                registerUser($email, $password);
            } else {
                echo "Error: Todos los campos son requeridos para el registro.";
            }
        } elseif ($action === 'login') {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);

                if (!empty($email) && !empty($password)) {
                    loginUser($email, $password);
                } else {
                    echo "Error: Todos los campos son requeridos para iniciar sesión.";
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