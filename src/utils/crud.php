<?php

include 'conexion.php';

function addTask($Id_usuario, $titulo, $nivel_importancia, $descripcion_tarea)
{
    global $conn;

    // Sanitizar y escapar los datos para prevenir inyección SQL
    $titulo = mysqli_real_escape_string($conn, $titulo);
    $nivel_importancia = mysqli_real_escape_string($conn, $nivel_importancia);
    $descripcion_tarea = mysqli_real_escape_string($conn, $descripcion_tarea);

    $sql = "INSERT INTO tareas (Id_usuario, titulo, nivel_importancia, descripcion_tarea) VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $Id_usuario, $titulo, $nivel_importancia, $descripcion_tarea);
    
    if ($stmt->execute()) {
        // Enviar mensaje de éxito
        echo "patata";
        return true;
    } else {
        // Manejar el error de la consulta SQL
        echo "Error al agregar la tarea: " . $conn->error;
        return false;
    }
}

function editTask($Id_usuario, $Id_tarea, $titulo, $nivel_importancia, $descripcion_tarea)
{
    global $conn;

    // Sanitizar y escapar los datos para prevenir inyección SQL
    $titulo = mysqli_real_escape_string($conn, $titulo);
    $nivel_importancia = mysqli_real_escape_string($conn, $nivel_importancia);
    $descripcion_tarea = mysqli_real_escape_string($conn, $descripcion_tarea);

    $sql = "UPDATE tareas SET titulo='$titulo', nivel_importancia='$nivel_importancia', descripcion_tarea='$descripcion_tarea' WHERE id='$Id_tarea' AND id_usuario='$Id_usuario'";
    if ($conn->query($sql) === TRUE) {
        // Enviar mensaje de éxito
        
        return true;
    } else {
        // Manejar el error de la consulta SQL
        echo "Error al editar la tarea: " . $conn->error;
        return false;
    }
}

function deleteTask($Id_usuario, $Id_tarea)
{
    global $conn;
    $sql = "DELETE FROM tareas WHERE id='$Id_tarea' AND id_usuario='$Id_usuario'";
    if ($conn->query($sql) === TRUE) {
        // Enviar mensaje de éxito
        return true;
    } else {
        // Manejar el error de la consulta SQL
        echo "Error al eliminar la tarea: " . $conn->error;
        return false;
    }
}

function getTasks($Id_usuario)
{
    global $conn;
    $tasks = array();
    $sql = "SELECT * FROM tareas WHERE id_usuario=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $Id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
    }
    return $tasks;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'getTasks') {
    $tasks = getTasks($Id_usuario);
    foreach ($tasks as $task) {
        echo "<div>" . $task['titulo'] . "</div>"; // Puedes personalizar la presentación según tu diseño
    }
    exit;
}