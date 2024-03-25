<?php

include_once '../../models/crud.php';
include_once '../../utils/conexion.php';
// include_once './../../../private/conexion.php';

class TareaController {
    private $model;
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
        $this->model = new Crud($conn);
    }

    public function obtenerTareas($Id_usuario) {
        return $this->model->getTasksByUser($Id_usuario); 
    }

    public function agregarTarea($Id_usuario, $titulo, $nivel_importancia, $descripcion_tarea) {
        $this->model->addTask($Id_usuario, $titulo, $nivel_importancia, $descripcion_tarea);
    }

    public function eliminarTarea($Id_tarea, $Id_usuario) {
        return $this->model->deleteTask($Id_tarea, $Id_usuario);
    }

    public function actualizarTarea($Id_usuario, $idTarea, $titulo, $nivelImportancia, $descripcion) {
        return $this->model->updateTask($Id_usuario, $idTarea, $titulo, $nivelImportancia, $descripcion);
    }
}