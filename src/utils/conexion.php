<?php
    $env = parse_ini_file('./../.env');
    
    $host = $env['DB_HOST'];
    $usuario = $env['DB_USUARIO'];
    $pass = $env['DB_PASS'];
    $bd = $env['DB_NAME'];

$conn = new mysqli($host, $usuario, $pass, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
