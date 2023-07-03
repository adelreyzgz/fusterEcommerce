<?php

define('NUEVA_LINEA_FILE', "\n");
define('EXT', '.jpg');
function logToFile($fileName, $log, $open=false, $end=false)
{
	$diaActual = date('Y-m-d', time());
	$logFile = '/home/fuster1/domains/repuestosfuster.com/logs/' . $fileName . ' - ' . $diaActual . '.log';

	if ($open) {
		$log = '/////////// Process Starts at: ' . date('Y-m-d H:i:s') . ' /////////// ' . NUEVA_LINEA_FILE . $log;
		// $file = fopen($logFile, 'a');
	}

	if (!empty($log)) {
		$file = fopen($logFile, 'a');
		fwrite($file, $log . NUEVA_LINEA_FILE);
		fclose($file);
	}

	if ($end) {
		$file = fopen($logFile, 'a');
		$endlog = NUEVA_LINEA_FILE . '/////////// Process Ends at: ' . date('Y-m-d H:i:s') . ' ////////////// ' . NUEVA_LINEA_FILE;
		fwrite($file, $endlog);
		fclose($file);
	}
}

function marca_de_agua($f_entrada, $tipo, $f_salida)
{
	// DOCUMENTACIÓN : procedimiento extraído de "php/marca_de_agua.php" (incluido también en "feeds.php")

	if (!file_exists($f_entrada)) {
		return (false);
	}
	//
	switch ($tipo) {
		case 'A': // si se pasa un 'A' (máx=1200) se pasa a 960.
		case 'B':
			$max = 960;
			$f_MA = 'LOGO_GDE.png';
			break;
		case 'C':
			$max = 480;
			$f_MA = 'LOGO_PEQ.png';
			break;
		case 'D':
			$max = 120;
			$f_MA = '';
			break;
		default:
			exit();
	}
	//
	$img_origen = imagecreatefromjpeg($f_entrada);
	$marca_agua = imagecreatefrompng($f_MA);
	//
	$ancho_origen = imagesx($img_origen);
	$alto_origen = imagesy($img_origen);
	$ancho = $ancho_origen;
	$alto = $alto_origen;
	$ancho_MA = imagesx($marca_agua);
	$alto_MA = imagesy($marca_agua);
	//
	// reducción condicional a dimensiones máximas
	//
	if ($alto > $ancho) {
		if ($alto > $max) {
			$ancho = round(($max / $alto) * $ancho);
			$alto = $max;
		}
	} else {
		if ($ancho > $max) {
			$alto = round(($max / $ancho) * $alto);
			$ancho = $max;
		}
	}

	if ($max == 120) {
		$dx_img = 0;
		$dy_img = 0;
		$dx_MA = 0;
		$dy_MA = 0;
		$ancho_MA = $ancho;
		$alto_MA = $alto;
		$img_final = imagecreatetruecolor($ancho, $alto);
	} else {
		$dx_img = round(($max - $ancho) / 2);
		$dy_img = round(($max - $alto) / 2);
		$dx_MA = round(($max - $ancho_MA) / 2);
		$dy_MA = round(($max - $alto_MA) / 2);
		$img_final = imagecreatetruecolor($max, $max);
	}

	$blanco = imagecolorallocate($img_final, 255, 255, 255);
	imagefill($img_final, 0, 0, $blanco);
	imagecopyresampled($img_final, $img_origen, $dx_img, $dy_img, 0, 0, $ancho, $alto, $ancho_origen, $alto_origen);
	imagecopy($img_final, $marca_agua, $dx_MA, $dy_MA, 0, 0, $ancho_MA, $alto_MA);
	imagejpeg($img_final, $f_salida);
	imagedestroy($img_final);
	return (true);
}

function conecta()
//función que conecta con la base de datos del administrador web
{
	$host = "localhost";
	$bbdd = "fuster1_admin";
	$user = "fuster1_jesus";
	$pass = "YBevy5V7JX5SF";
	$conexion = new mysqli($host, $user, $pass, $bbdd);
	mysqli_set_charset($conexion, "utf8");
	return $conexion;
}

function db_query($conn, $sql)
//Capa de abstracción para la conexión a la base de datos, usando mysqli y controlando la salida de errores.
{
	$res = mysqli_query($conn, $sql) or die($sql . " " . mysqli_error($conn));
	return $res;
}


/////// PROCESO 2 : Guardar el fichero ///////
function guardaFicheros($id, $nombre, $imgFile)
{
	$base = str_pad($id, 6, '0', STR_PAD_LEFT);
	$f_B = 'F_' . $base . '_B' . EXT;
	$f_C = 'F_' . $base . '_C' . EXT;
	$f_D = 'F_' . $base . '_D' . EXT;
	$f_BM = 'F_' . $base . '_BM' . EXT;
	$f_CM = 'F_' . $base . '_CM' . EXT;

	$img_origen = imagecreatefromjpeg($nombre);
	$ancho = imagesx($img_origen);
	$alto = imagesy($img_origen);

	$nuevo_alto_C = 0;
	$nuevo_ancho_C = 0;
	$nuevo_alto_D = 0;
	$nuevo_ancho_D = 0;

	$nombre_identica = '../admin/DAM/FOTOS/' . $f_B;
	$nombre_resampleada_C = '../admin/DAM/FOTOS/' . $f_C;
	$nombre_resampleada_D = '../admin/DAM/FOTOS/' . $f_D;
	$nombre_marca_agua_B = '../admin/DAM/FOTOS/' . $f_BM;
	$nombre_marca_agua_C = '../admin/DAM/FOTOS/' . $f_CM;

	copy($imgFile, "/home/fuster1/domains/repuestosfuster.com/public_html/curl/" . $nombre_identica);

			// marca de agua
	marca_de_agua($nombre_identica, 'B', $nombre_marca_agua_B);
	marca_de_agua($nombre_identica, 'C', $nombre_marca_agua_C);
	marca_de_agua($nombre_identica, 'D', $nombre_resampleada_D);

	return $base;
}

/////// PROCESO 3 : consolidar registro en "dam" ///////
function consolidarRegistro($id, $base, $texto, $medida)
{
	// 	$sJson = '{"TAG_ES":"","TAG_IN":"","TAG_FR":""}';
	//	$sql1 = "INSERT INTO d_textos (json) VALUES ('" . $sJson . "')";
	//	echo "<br />" . $sql1;
	//	$res1 = db_query($con, $sql1);
	
	//conectamos con la base de datos
	$con = conecta();
	//iniciamos transacción
	$con->autocommit(true);

	$f_B = 'F_' . $base . '_B' . EXT;
	$f_C = 'F_' . $base . '_C' . EXT;
	$f_D = 'F_' . $base . '_D' . EXT;
	$f_BM = 'F_' . $base . '_BM' . EXT;
	$f_CM = 'F_' . $base . '_CM' . EXT;

	$sql = 'UPDATE dam SET fichero_B="' . $f_B . '", fichero_C="' . $f_C . '", fichero_D="' . $f_D . '", fichero_BM="' . $f_BM . '", id_d_textos=' . $texto . ', medida=' . $medida . ', borrado = 0 WHERE id=' . $id;
	$res = db_query($con, $sql);
	$log = 'db_query($con, $sql) ' . $sql;

	logToFile('update_fotos_up', $logStart);
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

$log = '';
$logStart = "///////// CONEXIÓN CURL ESTABLECIDA ////////////////" . NUEVA_LINEA_FILE;
logToFile('update_fotos_up', $logStart, true);

//decomprimimos el zip subido con las nuevas fotos
if (!empty($_POST["file"])) {

	$log = "DATOS POST: " . nl2br(print_r($_POST, true)) . " " . NUEVA_LINEA_FILE;
	$log .= "-----> DESCOMPRIMO <-----" . NUEVA_LINEA_FILE;
	system("unzip /home/fuster1/domains/repuestosfuster.com/data/updates/new/" . $_POST["file"] . " -d /home/fuster1/domains/repuestosfuster.com/data/updates/new");

	//conectamos con la base de datos
	$con = conecta();
	//iniciamos transacción
	$con->autocommit(true);

	$publicacion = 1; // Estándar
	$nombre_identica = '';
	$nombre_resampleada_C = '';
	$nombre_resampleada_D = '';
	$id = '';
	$base = '';
	$f_B = '';
	$f_C = '';
	$f_D = '';

	//
	// PROCESO 1: REGISTRAMOS EL ID
	//
	if (isset($_POST["fotos"])) {
		$fotos = $_POST['fotos'];

		// Start Log
		$log .= NUEVA_LINEA_FILE . '///// PROCESO 1: REGISTRAMOS EL ID /////' . NUEVA_LINEA_FILE;

		$log .= NUEVA_LINEA_FILE . "ARRAY DE FOTOS";
		$log .= NUEVA_LINEA_FILE . print_r($fotos, true) . NUEVA_LINEA_FILE;

		$productoanterior = 0;
		$productonuevo = 0;
		foreach ($fotos as $foto) {
			$fotodatos = explode("#", $foto);
			$nombre = str_pad($fotodatos[0], 12, '0', STR_PAD_LEFT) . "___web_t3#" . $fotodatos[0] . "#" . $fotodatos[1] . "#" . $fotodatos[3] . "#" . $fotodatos[4] . "#" . $fotodatos[5] . EXT;
			$imgFile = "/home/fuster1/domains/repuestosfuster.com/data/updates/new/C:/xampp/htdocs/endphasys_fotos/subidos/" . $nombre;

			$log .= NUEVA_LINEA_FILE . " ***** F   O   T   O ***** ===> " . $nombre . NUEVA_LINEA_FILE;

			//localizo el directorio
			$miid = $fotodatos[5];
			$micode = $fotodatos[2];
			$id_producto = $fotodatos[3];
			$texto = $fotodatos[4];
			$medida = $fotodatos[1];
			$productonuevo = $id_producto;

			//buscamos el ID real de la foto
			$sqlreal = "SELECT id_dam FROM dam_registro WHERE id_producto = " . $id_producto;
			$resreal = db_query($con, $sqlreal);
			$numreal = mysqli_num_rows($resreal);
			if ($numreal > 0 && $numreal < 2) {
				if ($productoanterior != $productonuevo) {
					$rowreal = mysqli_fetch_object($resreal);
					$idreal = $rowreal->id_dam;
				} else {
					$idreal = $miid;
				}
			} else {
				$idreal = $miid;
			}
			$productoanterior = $id_producto;

			$sql4 = "SELECT * FROM dam_actualizaciones WHERE id = " . $miid;
			$res4 = db_query($con, $sql4);
			$num4 = mysqli_num_rows($res4);
			if ($num4 > 0) {

				$log .= NUEVA_LINEA_FILE . '/////// Ya existía la imagen, así que actualizo su codefoto ///////' . NUEVA_LINEA_FILE;

				$sql5 = "UPDATE dam_actualizaciones SET fecha_ref = '" . $micode . "' WHERE id = " . $miid;
				$res5 = db_query($con, $sql5);
				$log .= NUEVA_LINEA_FILE . 'db_query($con, $sql5)' . $sql5 . NUEVA_LINEA_FILE;

				$sql = 'UPDATE dam SET tipo = "F" , fichero_B = "", fichero_C = "", fichero_D = "", publicacion = ' . $publicacion . ', id_d_textos = ' . $texto . ', medida = ' . $medida . ', borrado = 0 WHERE id = ' . $idreal;
				$res = db_query($con, $sql);
				$log .= "[[DAM]] => " . $sql . NUEVA_LINEA_FILE;

				$id = $idreal;

				$log .= NUEVA_LINEA_FILE . '/////// PROCESO 2 : Guardar el fichero ///////' . NUEVA_LINEA_FILE;
				$base = guardaFicheros($id, $nombre, $imgFile);

				$log .= NUEVA_LINEA_FILE . '/////// PROCESO 3 : consolidar registro en "dam" e insertar "dam_registro", previa creación de registro en "d_textos". ///////' . NUEVA_LINEA_FILE;
				consolidarRegistro($id, $base, $texto, $medida);

				//miramos si está asignada la foto al producto y si no la añadimos (casos erroneos anteriores)
				$sqll = "SELECT id FROM dam_registro WHERE id_dam = " . $id . " AND id_producto = " . $id_producto;
				$resl = db_query($con, $sqll);
				$numl = mysqli_num_rows($resl);
				if ($numl == 0) {
					$sql3 = 'INSERT INTO dam_registro (id_dam, id_producto, publicacion) VALUES (' . $id . ',' . $id_producto . ',' . $publicacion . ');';
					$log .= '$sql3' . $sql3 . NUEVA_LINEA_FILE;
					$res3 = db_query($con, $sql3);
				} else {
					$sql4 = 'UPDATE dam_registro SET borrado = 0 WHERE id_dam = ' . $id . ' AND id_producto = ' . $id_producto;
					$log .= '$sql4' . $sql4 . NUEVA_LINEA_FILE;
					$res4 = db_query($con, $sql4);
				}
			} else {

				$log .= NUEVA_LINEA_FILE . '/////// No existe la imagen, así que la creamos ///////' . NUEVA_LINEA_FILE;

				$sql6 = "INSERT INTO dam_actualizaciones (id, fecha_ref) VALUES (" . $miid . ", '" . $micode . "')";
				$res6 = db_query($con, $sql6);
				$log .= NUEVA_LINEA_FILE . 'db_query($con, $sql6)' . $sql6 . NUEVA_LINEA_FILE;

				$sql = 'INSERT INTO dam (id, tipo, fichero_B, fichero_C, fichero_D, publicacion) VALUES (' . $miid . ', "F", "", "", "", ' . $publicacion . ');';
				$res = db_query($con, $sql);
				$log .= "[[DAM]] => " . $sql . NUEVA_LINEA_FILE;

				//$id = mysqli_insert_id($con);
				$id = $miid;

				$log .= NUEVA_LINEA_FILE . '/////// PROCESO 2 : Guardar el fichero ///////' . NUEVA_LINEA_FILE;
				$base = guardaFicheros($id, $nombre, $imgFile);

				$log .= NUEVA_LINEA_FILE . '/////// PROCESO 3 : consolidar registro en "dam" e insertar "dam_registro", previa creación de registro en "d_textos". ///////' . NUEVA_LINEA_FILE;
				consolidarRegistro($id, $base, $texto, $medida);

				$sql3 = 'INSERT INTO dam_registro (id_dam, id_producto, publicacion) VALUES (' . $id . ',' . $id_producto . ',' . $publicacion . ');';
				$log .= '$sql3' . $sql3 . NUEVA_LINEA_FILE;
				$res3 = db_query($con, $sql3);
			}

			$log .= NUEVA_LINEA_FILE . ' borramos la imagen procesada ///////' . NUEVA_LINEA_FILE;

			//borramos la imagen procesada
			unlink($imgFile);
		}
	}

	logToFile('update_fotos_up', $log, false, true);

	$con->commit();
	$con->close();

	//borramos el zip procesado
	unlink("/home/fuster1/domains/repuestosfuster.com/data/updates/new/" . $_POST["file"]);

	return $cadena;

} else {
	$log = 'ERROR: NO EXISTEN DATOS DE POST[FILE]';
	logToFile('update_fotos_up', $log, false, true);
}

exit();

?>
