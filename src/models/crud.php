<?php

include './../utils/conexion.php';

class Crud{
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function getTasksByUser($Id_usuario){
        $sql = "SELECT * FROM tareas WHERE Id_usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $Id_usuario);
        $stmt->execute();

        $result = $stmt->get_result();
        $tareas = $result->fetch_all(MYSQLI_ASSOC);

        return $tareas;
    }
    
    function addTask($Id_usuario, $titulo, $nivel_importancia, $descripcion_tarea){

        // Sanitizar y escapar los datos para prevenir inyección SQL
        $titulo = mysqli_real_escape_string($this->conn, $titulo);
        $nivel_importancia = mysqli_real_escape_string($this->conn, $nivel_importancia);
        $descripcion_tarea = mysqli_real_escape_string($this->conn, $descripcion_tarea);

        $sql = "INSERT INTO tareas (Id_usuario, titulo, nivel_importancia, descripcion_tarea) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $Id_usuario, $titulo, $nivel_importancia, $descripcion_tarea);

        if ($stmt->execute()) {
            // Enviar mensaje de éxito
            return true;
        } else {
            // Manejar el error de la consulta SQL
            echo "Error al agregar la tarea: " . $this->conn->error;
            return false;
        }
    }


    function deleteTask($Id_usuario, $Id_tarea){

        $sql = "DELETE FROM tareas WHERE Id_tarea=? AND Id_usuario=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $Id_tarea, $Id_usuario);

        if ($stmt->execute()) {
            // Enviar mensaje de éxito
            return true;
        } else {
            // Manejar el error de la consulta SQL
            echo "Error al eliminar la tarea: " . $this->conn->error;
            return false;
        }
    }

    function updateTask($Id_usuario, $Id_tarea, $titulo, $nivel_importancia, $descripcion_tarea){
        $sql = "UPDATE tareas SET titulo = ?, nivel_importancia = ?, descripcion_tarea = ? WHERE Id_tarea = ? AND Id_usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $titulo, $nivel_importancia, $descripcion_tarea, $Id_tarea, $Id_usuario);

        if ($stmt->execute()) {
            // Enviar mensaje de éxito
            return true;
        } else {
            // Manejar el error de la consulta SQL
            echo "Error al actualizar la tarea: " . $this->conn->error;
            return false;
        }
    }
}