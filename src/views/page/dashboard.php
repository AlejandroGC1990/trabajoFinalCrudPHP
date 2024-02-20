<?php

session_start();

if (!isset($_SESSION['Id_usuario'])) {
    header("Location: ./../../../../index.php");
    exit();
}

$Id_usuario = $_SESSION['Id_usuario'];

// include './../../../private/conexion.php';
include  './../../utils/conexion.php';
include_once '../../controllers/TareaController.php';

$tareaController = new TareaController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si las claves están presentes en $_POST antes de acceder a ellas
    if (isset($_POST['titulo']) && isset($_POST['nivel_importancia']) && isset($_POST['descripcion_tarea'])) {
        // Procesar los datos del formulario
        $titulo = $_POST['titulo'];
        $nivel_importancia = $_POST['nivel_importancia'];
        $descripcion_tarea = $_POST['descripcion_tarea'];

        if (!empty($titulo) && !empty($nivel_importancia) && !empty($descripcion_tarea)) {
            $tareaController->agregarTarea(
                $Id_usuario,
                $titulo,
                $nivel_importancia,
                $descripcion_tarea
            );
        }
    }
}

$tareas = $tareaController->obtenerTareas($Id_usuario);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD App</title>
    <link rel="stylesheet" href="../../styles/dashboard.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../../utils/script.js"></script>
</head>

<body>
    <div class="main-container">
        <div class="menu-container">
            <div class="create-form-container" id="task-form">
                <h3>Añadir tarea</h3>
                <form action="dashboard.php" method="POST">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" pattern="[a-zA-Z0-9\s]+"
                        title="Por favor, ingrese un título válido (solo letras, números y espacios)" required><br>
                    <label for="nivel_importancia">Importancia:</label>
                    <select id="nivel_importancia" name="nivel_importancia" required>
                        <option value="bajo">Bajo</option>
                        <option value="medio">Medio</option>
                        <option value="alto">Alto</option>
                    </select><br>

                    <label for="descripcion_tarea">Descripción:</label>
                    <textarea id="descripcion_tarea" name="descripcion_tarea" required></textarea><br>

                    <input type="submit" value="Guardar Tarea">
                </form>
            </div>
        </div>

        <div class="task-table" id="tasks">
            <?php include_once '../components/tareas.php'; ?>
        </div>
    </div>

    <script> recargarPagina(); </script>
</body>

</html>