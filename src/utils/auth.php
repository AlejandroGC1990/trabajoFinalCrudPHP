<?php
include 'conexion.php';

function registerUser($email, $password)
{
    global $conn;

    $sql = "INSERT INTO usuarios (email, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        header("Location: ./../../page/dashboard.html");
        exit;
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
            header("Location: ./../../page/dashboard.html");
            exit;
        } else {
            echo "Credenciales incorrectas.";
        }
    } else {
        return false;
    }
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
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);

                if (!empty($email) && !empty($password)) {
                    if (loginUser($email, $password)) {
                        echo "Inicio de sesión exitoso.";
                    } else {
                        echo "Credenciales incorrectas.";
                    }
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
