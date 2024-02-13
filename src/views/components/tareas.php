<?php

//!___________________________________________________________________________
// 1.QUE LA PÁGINA SE REINICIE AL GUARDAR TAREA, ELIMINAR Y ACTUALIZAR, SE GUARDAN LOS CAMBIOS, PERO 
//NO SE REFLEJAN LOS CAMBIOS HASTA QUE REINICIO LA PÁGINA
// 2. SOLO ME GUARDA 1 PALABRA EN EL TÍTULO Y DESCRIPCIÓN, NO ME GUARDA UNA FRASE ENTERA
//!____________________________________________________________________________


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

        if ($resultado) {
            echo "Tarea actualizada correctamente.";
        } else {
            echo "Error al actualizar la tarea.";
        }
    } 
} else {
    echo "Acceso denegado.";
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
        // header("Location: " . $_SERVER['PHP_SELF']);
        // exit();
    }
}

// Obtener la lista de tareas después de eliminar una tarea, si no se eliminó ninguna, obtener la lista normal
if (!isset($tareas)) {
    $tareas = $tareaController->obtenerTareas($Id_usuario);
}

if ($tareas) {
    ?>
    <h2>Listado de tareas</h2>
    <table id="tabla-tareas" border='1'>
        <tr>
            <th>Título</th>
            <th>Nivel de importancia</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($tareas as $index => $tarea): ?>
            <form action="dashboard.php" method="POST">
                <tr data-id="<?php echo $tarea['Id_tarea']; ?>">
                    <td><input type="text" name="titulo" value=<?php echo $tarea['titulo']; ?>></td>
                    <td>
                        <!-- <?php echo $tarea['nivel_importancia']; ?> -->
                        <select id="nivel_importancia" name="nivel_importancia" required>

                            <option value="<?php echo $tarea['nivel_importancia']; ?>">
                                <?php echo $tarea['nivel_importancia']; ?>
                            </option>
                            <option value="bajo">Bajo</option>
                            <option value="medio">Medio</option>
                            <option value="alto">Alto</option>
                        </select><br>
                    </td>
                    <td>
                        <input type="text" name="descripcion" value=<?php echo $tarea['descripcion_tarea']; ?>>
                    </td>

                    <td>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: inline;">
                            <input type="hidden" name="Id_usuario" value="<?php echo $Id_usuario; ?>">
                            <input type="hidden" name="Id_tarea" value="<?php echo $tarea['Id_tarea']; ?>">
                            <input type="hidden" name="action" value="update">
                            <button type="submit">Actualizar</button>
                        </form>
                        <?php if ($tareas): ?>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: inline;">
                                <input type="hidden" name="Id_usuario" value="<?php echo $Id_usuario; ?>">
                                <input type="hidden" name="Id_tarea" value="<?php echo $tarea['Id_tarea']; ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit">Eliminar</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            </form>
        <?php endforeach; ?>
    </table>
    <?php
} else {
    // Si no hay tareas disponibles, mostrar un mensaje indicando que no hay tareas almacenadas
    echo "No hay tareas almacenadas.";
}

