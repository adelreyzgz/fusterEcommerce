<?php
    // PROD
    // $usuario_bd = "root";
    // $contrasena_bd = "Ncijeo9q7ZaYgcu8HyLU";
    // $servidor_bd = "127.0.0.1:3307";
    // $basededatos_bd = "fuster1_version2";

    // DEV
    $usuario_bd = "adelrey";
    $contrasena_bd = "adelrey";
    $servidor_bd = "127.0.0.1";
    $basededatos_bd = "repuestosfusterfinal";

    // STAGE
    // $usuario_bd = "admin_fuster_version2";
    // $contrasena_bd = "Ysr7f!78MlXkoubo";
    // $servidor_bd = "localhost";
    // $basededatos_bd = "admin_fuster_version2";

    $cxn_bd = new mysqli($servidor_bd, $usuario_bd, $contrasena_bd, $basededatos_bd);
    if ($cxn_bd->connect_error) { die("Connection failed: " . $cxn_bd->connect_error); }

    $cxn_bd->set_charset("utf8");
?>
