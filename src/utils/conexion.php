<?php
    $env = parse_ini_file('./../../.env');
    
    $host = $env['DB_HOST'];
    $usuario = $env['DB_USUARIO'];
    $pass = $env['DB_PASS'];
    $bd = $env['DB_NAME'];
    echo $env['DB_HOST'];

$conn = new mysqli($host, $usuario, $pass, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


//! PASARLE LA ID_USUARIO A DASHBOARD PÀRA QUE PUEDA GUARDAR EL ID_USUARIO EN LA BD
//! MIRAR LA LÓGICA DEL ID_TAREA, CREO QUE NO LE LLEGA