<?php

include_once '../controllers/TareaController.php';

$tareaController = new TareaController();
$Id_usuario = $_SESSION['Id_usuario'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "delete") {
    // Verificar si se han enviado los datos necesarios
    if(isset($_POST['Id_tarea']) && !empty($_POST['Id_tarea'])) {
        // Obtener el Id_tarea desde el formulario
        $Id_tarea = $_POST['Id_tarea'];
        // Eliminar la tarea
        $tareaController->eliminarTarea($Id_tarea, $Id_usuario);
        // Recargar la página para reflejar los cambios
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$tareas = $tareaController->obtenerTareas($Id_usuario);

if ($tareas) {

    ?>
    <h2>Listado de tareas</h2>
    <table border='1'>
        <tr>
            <th>Título</th>
            <th>Nivel de importancia</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
        <?php
        foreach ($tareas as $tarea) {

        // while ($fila = $resultado->fetch_assoc()) {
            // echo "
            ?>
            <tr>
                <!-- <td>{$fila['titulo']}</td>
                <td>{$fila['nivel_importancia']}</td>
                <td>{$fila['descripcion_tarea']}</td> -->
                <td><?php echo $tarea['titulo']; ?></td>
                <td><?php echo $tarea['nivel_importancia']; ?></td>
                <td><?php echo $tarea['descripcion_tarea']; ?></td>
                
                <td>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: inline;">
                        <input type="hidden" name="Id_usuario" value="<?php echo $Id_usuario; ?>">
                        <input type="hidden" name="Id_tarea" value="<?php echo $tarea['Id_tarea']; ?>">
                        <input type="hidden" name="action" value="update">
                        <button type="submit">Actualizar</button>
                    </form>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: inline;">
                        <input type="hidden" name="Id_usuario" value="<?php echo $Id_usuario; ?>">
                        <input type="hidden" name="Id_tarea" value="<?php echo $tarea['Id_tarea']; ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php
        }
        ?>
        </table>
        <?php
        // echo "</table>";
} else {

    echo "No hay tareas almacenadas.";
}

?>
<!-- $conn->close(); -->