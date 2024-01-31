<?php
    $env = parse_ini_file('./../.env');
    
    $host = $env['DB_HOST'];
    $usuario = $env['DB_USUARIO'];
    $pass = $env['DB_PASS'];
    $bd = $env['DB_NAME'];
