<?php
//definición de constantes
define("RUTA_GESTOR_FOTOS","E:/www/repuestosfuster/FUSTER_GESTOR_FOTOS/");

function db_query($conn, $sql)
//Capa de abstracción para la conexión a la base de datos, usando mysqli y controlando la salida de errores.
{	
	$res = mysqli_query($conn, $sql) or die($sql . " " . mysqli_error($conn));
	//$res = mysqli_query($conn, $sql);
	return $res;
}

function rellena_ceros($valor, $longitud)
//función que rellena con ceros a la izquieda una cadena
{
 	$res = str_pad($valor, $longitud, '0', STR_PAD_LEFT);
 	return $res;
}

function agregar_zip($dir, $zip)
//función para añadir varios ficheros a un mismo zip
{
  //verificamos si $dir es un directorio
  if (is_dir($dir)) {
    //abrimos el directorio y lo asignamos a $da
    if ($da = opendir($dir)) {
      //leemos del directorio hasta que termine
      while (($archivo = readdir($da)) !== false) {
        //Si es un directorio imprimimos la ruta y llamamos recursivamente esta función
        //para que verifique dentro del nuevo directorio por mas directorios o archivos
        if (is_dir($dir . $archivo) && $archivo != "." && $archivo != "..") {
          //echo "<strong>Creando directorio: $dir$archivo</strong><br/>";
          agregar_zip($dir . $archivo . "/", $zip);
          //si encuentra un archivo imprimimos la ruta donde se encuentra
          //y agregamos el archivo al zip junto con su ruta 
        } elseif (is_file($dir . $archivo) && $archivo != "." && $archivo != "..") {
          //echo "- Agregando archivo: $dir$archivo <br/>";
          $zip->addFile($dir . $archivo, $dir . $archivo);
        }
      }
      //cerramos el directorio abierto en el momento
      closedir($da);
    }
  }
}

function formatear_para_json ($sJ)
{
	return (str_replace ("'", "''", $sJ)); // apóstrofe francés
}	
	
function salir_eliminando_ultimo_registro ($motivo)
{
	global $id;
	//
	$sql = 'DELETE FROM dam WHERE id=' . $id . ' LIMIT 1';
	$res = mysql_query($sql) or die($sql . ' ' . mysql_error());
	//
	switch ($motivo)
		{
			case 1 : echo('se ha encontrado una dimensión nula en la imagen.'); break;
			case 2 : echo('extensión de fichero no soportada.'); break;
			case 3 : echo('se ha encontrado un error en el nombre del fichero de la imagen.'); break;
			default : echo('error desconocido'); break;
		}
	exit();
}


?>