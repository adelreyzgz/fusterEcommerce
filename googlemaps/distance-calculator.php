<?php

	if(  !isset($_POST['lat']) || empty($_POST['lat']) || !isset($_POST['lng']) || empty($_POST['lng']) )  die();

	$lat = (float)$_POST['lat'];

	$lng = (float)$_POST['lng'];

	header('Access-Control-Allow-Origin: *');

	header('Content-Type: text/html; charset=utf-8');

	//$connection = mysqli_connect("localhost", "fuster1", "WoCsidJAQ");
	$connection = mysqli_connect("127.0.0.1:3307", "root", "Ncijeo9q7ZaYgcu8HyLU");

	$db_select = mysqli_select_db($connection, "fuster1_version2");

    mysqli_set_charset($connection, "utf8");

	$sql = "SELECT * FROM tiendas WHERE activa = 'si'"; // ORDER BY

	$res = mysqli_query($connection, $sql) or die($sql . " " . mysqli_error($connection) );

	$candidatos = array();

	while($row=mysqli_fetch_object($res)){

		$candidatos[$row->id_tiendas] = calcular_distancia($lat, $lng, $row->lat, $row->lng);

	} // while

	asort($candidatos, SORT_NUMERIC);

	$contador = 0;

	foreach($candidatos as $key => $value){

		$contador++;

		if($contador > 3){

			unset($candidatos[$key]);

			continue;

		} // if

		$sql3 = "SELECT * FROM tiendas WHERE id_tiendas = " . $key;

		$res3 = mysqli_query($connection, $sql3) or die($sql3 . " " . mysqli_error($connection));

		$row3 = mysqli_fetch_object($res3);

		$candidatos[$key] = array("distancia" => number_format(($value), 2, ",", ".") . " km.", "id_tiendas" => $row3->id_tiendas, "nombre" => limpiar_nombre($row3->nombre), "localidad" => limpiar_nombre($row3->municipio), "lng" => $row3->lng, "lat" => $row3->lat, "email" => $row3->email, "direccion" => limpiar_nombre($row3->direccion), "provincia" => convertir_provincia($row3->provincia), "pais" => convertir_pais($row3->pais), "telefono" => limpiar_nombre($row3->telefono), "email" => $row3->email, "cp" => limpiar_nombre($row3->cp));

	} // foreach

	$candidatos2 = array();

	foreach($candidatos as $candidato){

		$candidatos2[] = $candidato;

	} // foreach

	print json_encode($candidatos2);

	exit;

	

	function calcular_distancia($lat_orig, $ln_orig, $lat_dest, $ln_dest){

		return calculate_distance($lat_orig, $ln_orig, $lat_dest, $ln_dest, 'K');

	} // function

	

	

	function calculate_distance($lat1, $lon1, $lat2, $lon2, $unit='N') 

	{ 

		$theta = $lon1 - $lon2; 

		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 

		$dist = acos($dist); 

		$dist = rad2deg($dist); 

		$miles = $dist * 60 * 1.1515;

		$unit = strtoupper($unit);



		if ($unit == "K") {

			return ($miles * 1.609344); 

		} else if ($unit == "N") {

			return ($miles * 0.8684);

		} else {

			return $miles;

		}

	} // function calculate_distance

	

	function convertir_provincia($codigo){

        global $connection;

		$sql = "SELECT * FROM zzz_provincias WHERE codigo = '" . addslashes($codigo) . "'";

		$res = mysqli_query($connection, $sql);

		$num = mysqli_num_rows($res);

		if($num > 0){

			$row = mysqli_fetch_object($res);

			return $row->provincia;

		} // if

		return $codigo;

	} // function

	

	function convertir_pais($pais){

        global $connection;

		$sql = "SELECT * FROM zzz_paises WHERE codigo = '" . addslashes($pais) . "'";

		$res = mysqli_query($connection, $sql);

		$num = mysqli_num_rows($res);

		if($num > 0){

			$row = mysqli_fetch_object($res);

			return $row->pais;

		} // if

		return $pais;

	} // function

	

	function limpiar_nombre($texto){

		$texto = str_replace(array("\n", "<br />", "<br>", chr(13).chr(10), chr(13), chr(10), "'"), array(" ", " ", " " , " " , " " , " ",  "&#39;"), $texto);

		return $texto;

	} // function

