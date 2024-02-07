<?php

include_once '../../controllers/TareaController.php';
// include_once '../controllers/TareaController.php';

// global $conn;
$tareaController = new TareaController();



// $sql = "SELECT * FROM tareas";
// $resultado = $conn->query($sql);

$Id_usuario = $_SESSION['Id_usuario'];
$tareas = $tareaController->obtenerTareas($Id_usuario);

// if ($resultado && $resultado->num_rows > 0) {
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
                    <form action="../controllers/TareaController.php" method="POST" style="display: inline;">
                        <input type="hidden" name="Id_usuario" value="<?php echo $Id_usuario; ?>">
                        <input type="hidden" name="Id_tarea" value="<?php echo $tarea['Id_tarea']; ?>">
                        <input type="hidden" name="action" value="update">
                        <button type="submit">Actualizar</button>
                    </form>
                    <form action="../controllers/TareaController.php" method="POST" style="display: inline;">
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