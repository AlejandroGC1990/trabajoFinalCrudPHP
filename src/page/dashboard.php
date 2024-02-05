<?php
session_start();

if(!isset($_SESSION['Id_usuario'])) {
    header("Location: ./../../../index.php");
    exit();
} 

$Id_usuario = $_SESSION['Id_usuario'];

include '../utils/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar los datos del formulario
    $titulo = $_POST['titulo'];
    $nivel_importancia = $_POST['nivel_importancia'];
    $descripcion_tarea = $_POST['descripcion_tarea'];

    // Prevenir inyección de SQL usando consultas preparadas
    $stmt = $conn->prepare("INSERT INTO tareas (Id_usuario, titulo, nivel_importancia, descripcion_tarea) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $Id_usuario, $titulo, $nivel_importancia, $descripcion_tarea);

    if ($stmt->execute()) {
        // Tarea agregada exitosamente
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error al agregar la tarea: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD App</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>CRUD App</h1>
    <div id="task-form">
        <h2>Añadir/Editar Tarea</h2>       
        <form action="dashboard.php" method="POST">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" pattern="[a-zA-Z0-9\s]+" title="Por favor, ingrese un título válido (solo letras, números y espacios)" required><br>

            <label for="nivel_importancia">Importancia:</label>
            <select id="nivel_importancia" name="nivel_importancia" required>
                <option value="bajo">Bajo</option>
                <option value="medio">Medio</option>
                <option value="alto">Alto</option>
            </select><br>

            <label for="descripcion_tarea">Descripción:</label>
            <textarea id="descripcion_tarea" name="descripcion_tarea" required></textarea><br>

            <!-- Cambié el tipo de botón a submit para enviar el formulario -->
            <input type="submit" value="Guardar Tarea">
        </form>
    </div>

    <?php include './../components/tareas.php' ?>
</body>
</html>