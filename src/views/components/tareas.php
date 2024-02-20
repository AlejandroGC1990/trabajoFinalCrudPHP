<?php

include_once '../../controllers/TareaController.php';

$tareaController = new TareaController();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['Id_usuario'])) {
    header("Location: login.php");
    exit();
}

$Id_usuario = $_SESSION['Id_usuario'];

// Manejar la acción de editar tarea
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['Id_tarea'], $_POST['titulo'], $_POST['nivel_importancia'], $_POST['descripcion'])) {
        $Id_tarea = $_POST['Id_tarea'];
        $titulo = $_POST['titulo'];
        $nivel_importancia = $_POST['nivel_importancia'];
        $descripcion = $_POST['descripcion'];
        // Llamar al método de actualización en el controlador
        $resultado = $tareaController->actualizarTarea($Id_usuario, $Id_tarea, $titulo, $nivel_importancia, $descripcion);
        // Recargar la lista de tareas después de eliminar una tarea
        $tareas = $tareaController->obtenerTareas($Id_usuario);
        if ($resultado) {
            echo "Tarea actualizada correctamente.";
        } else {
            echo "Error al actualizar la tarea.";
        }
    }
}
// Manejar la acción de eliminar tarea
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "delete") {
    // Verificar si se han enviado los datos necesarios
    if (isset($_POST['Id_tarea']) && !empty($_POST['Id_tarea'])) {
        // Obtener el Id_tarea desde el formulario
        $Id_tarea = $_POST['Id_tarea'];
        // Eliminar la tarea
        $tareaController->eliminarTarea($Id_tarea, $Id_usuario);
        // Recargar la lista de tareas después de eliminar una tarea
        $tareas = $tareaController->obtenerTareas($Id_usuario);
    }
}
// Obtener la lista de tareas después de eliminar una tarea, si no se eliminó ninguna, obtener la lista normal
if (!isset($tareas)) {
    $tareas = $tareaController->obtenerTareas($Id_usuario);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD App</title>
    <link rel="stylesheet" href="../../styles/dashboard.css">
</head>

<body>
    <div class="task-container">
        <?php if ($tareas): ?>
            <?php foreach ($tareas as $tarea): ?>
                <div class="task <?php echo strtolower($tarea['nivel_importancia']); ?>">
                    <form action="dashboard.php" method="POST">

                        <h3><input type="text" name="titulo" value="<?php echo $tarea['titulo']; ?>"></h3>
                        <select id="nivel_importancia" name="nivel_importancia" required>
                            <option value="<?php echo $tarea['nivel_importancia']; ?>">
                                <?php echo $tarea['nivel_importancia']; ?>
                            </option>
                            <option value="bajo">Bajo</option>
                            <option value="medio">Medio</option>
                            <option value="alto">Alto</option>
                        </select><br>
                        <!-- <input type="text" name="descripcion" class="description" value="<?php echo $tarea['descripcion_tarea']; ?>"> -->
                        <textarea name="descripcion" class="description"><?php echo $tarea['descripcion_tarea']; ?></textarea>

                        <div class="task-buttons">
                            <input type="hidden" name="Id_usuario" value="<?php echo $Id_usuario; ?>">
                            <input type="hidden" name="Id_tarea" value="<?php echo $tarea['Id_tarea']; ?>">
                            <input type="hidden" name="action" value="update">
                            <button class="buttonUpdate" type="submit" name="update">Actualizar</button>
                        </div>
                    </form>
                    <div class="task-buttons">
                        <form action="dashboard.php" method="POST">
                            <?php if ($tareas): ?>
                                <input type="hidden" name="Id_usuario" value="<?php echo $Id_usuario; ?>">
                                <input type="hidden" name="Id_tarea" value="<?php echo $tarea['Id_tarea']; ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="delete">Eliminar</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- Si no hay tareas disponibles, mostrar un mensaje indicando que no hay tareas almacenadas -->
        <p>No hay tareas almacenadas.</p>
    <?php endif; ?>
    </div>
</body>

</html>