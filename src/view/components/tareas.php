<?php

include '../utils/conexion.php';

global $conn;

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

$sql = "SELECT * FROM tareas";
$resultado = $conn->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    
    ?>
	<h2>Listado de tareas</h2>
	<table border='1'>
            <tr>
                <th>Título</th>
                <th>Nivel de importancia</th>
                <th>Descripción</th>
            </tr>
	<?php

    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>{$fila['titulo']}</td>
                <td>{$fila['nivel_importancia']}</td>
                <td>{$fila['descripcion_tarea']}</td>
              </tr>";
    }

    echo "</table>";
} else {
    
    echo "No hay tareas almacenadas.";
}

$conn->close();
?>