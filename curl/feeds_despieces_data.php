<?php
	if(!isset($_GET["data"])) die();
	$tipo = $_GET["data"];
	if($tipo != "despieces" && $tipo != "despieces_lineas") die();
	
	$fichero = array(
						"despieces" => "despiece_plano;ref;oem;x;y;orden;familia;img;ancho;alto;marca\n1;379623;;944;407;1;0;6;1200;550;0\n1;389219;;944;459;2;0;6;1200;500;0\n1;379624;;1081;485;3;0;6;1200;550;0\n1;3272;;723;239;4;0;0;1200;550;0\n1;3273;;1045;21;5;0;6;1200;550;0\n1;312465;;64;185;6;0;6;1200;550;0\n1;3521439;;349;169;7;0;6;1200;550;0\n1;320159;;107;485;8;0;0;1200;550;0"
						,
						"despieces_lineas" => "id_despieces;x1;y1;x2;y2\n1;1045;21;1039;47\n1;1039;47;989;31\n1;1039;47;1087;63\n1;349;169;324;202\n1;324;202;211;185\n1;324;202;312;213\n1;324;202;384;243"
						
	);
	
	print $fichero[$tipo];
	exit;
?>