<?php


    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    //$usuario_bd = "fuster1";
    $usuario_bd = "root";
    //$contrasena_bd = "WoCsidJAQ";
    $contrasena_bd = "Ncijeo9q7ZaYgcu8HyLU";
    //$servidor_bd = "localhost";
    $servidor_bd = "127.0.0.1:3307";
    $basededatos_bd = "fuster1_version2";

    $cxn_bd = new mysqli($servidor_bd, $usuario_bd, $contrasena_bd, $basededatos_bd);
    print_r($cxn_bd) ;
    if ($cxn_bd->connect_error) { die("Connection failed: " . $cxn_bd->connect_error); }

    $cxn_bd->set_charset("utf8");

    $query = $cxn_bd->prepare("SELECT nombre FROM es_repuestos; ");

    if($query){
      if($query->execute()){
        $data = $query->get_result();
      }
    }

	echo "<br><br><br>";
    print_r($data)	;
?>