<?php

include 'config.php';

function addTask($titulo, $valor, $description, $img)
{
    global $conn;

    $imgFileName = $_FILES['image']['name'];
    $imgTempName = $_FILES['image']['tmp_name'];
    $imgFolder = "uploads/";
    $imgPath = $imgFolder . $imgFileName;

    if (move_uploaded_file($imgTempName, $imgPath)) {
        $sql = "INSERT INTO tasks (titulo, valor, description, img) VALUES ('$titulo', '$valor', '$description', '$imgPath')";
        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function editTask($id, $titulo, $valor, $description, $img)
{
    global $conn;

    $imgFileName = $_FILES['image']['name'];
    $imgTempName = $_FILES['image']['tmp_name'];
    $imgFolder = "uploads/";
    $imgPath = $imgFolder . $imgFileName;

    if (move_uploaded_file($imgTempName, $imgPath)) {
        $sql = "UPDATE tasks SET titulo='$titulo', valor='$valor', description='$description', img='$imgPath' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function deleteTask($id)
{
    global $conn;
    $sql = "DELETE FROM tasks WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

function getTasks()
{
    global $conn;
    $tasks = array();
    $sql = "SELECT * FROM tasks";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
    }
    return $tasks;
}
?>