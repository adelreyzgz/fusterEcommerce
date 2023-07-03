<?php

/* CXN BD
$cxn_bd1 -> Base de Datos del Gestor
$cxn_bd2 -> Base de Datos del Sistema 2.0
*/




error_reporting(E_ALL);
ini_set('display_errors', '1');

require 'cnx/conect.php';


function cleanName($cadena){
	// Convertimos el texto a analizar a minúsculas
	$cadena = strtolower($cadena);
    
    //Reemplazamos la A y a
    $cadena = str_replace(
    array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
    array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
    $cadena
    );

    //Reemplazamos la E y e
    $cadena = str_replace(
    array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
    array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
    $cadena );

    //Reemplazamos la I y i
    $cadena = str_replace(
    array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
    array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
    $cadena );

    //Reemplazamos la O y o
    $cadena = str_replace(
    array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
    array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
    $cadena );

    //Reemplazamos la U y u
    $cadena = str_replace(
    array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
    array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
    $cadena );

    //Reemplazamos la N, n, C y c
    $cadena = str_replace(
    array('Ñ', 'ñ', 'Ç', 'ç'),
    array('N', 'n', 'C', 'c'),
    $cadena
    );

    //Reemplazamos caracteres especiales
    $cadena = str_replace(array("?", "^", "@", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&",
    "$", "#", "*", "(", ")" , "|", "~", "`", "!", "{", "}", "%", "+", "."), ' ', $cadena);
    
    $cadena = str_replace(array("'", "\""), '', $cadena);

    // //Reemplazamos preposiciones y conjunciones
    $term_eliminar = array(
        'de','para','al','con','la','a','ante','bajo','cabe','con','contra','de','desde','durante','en','entre','hacia','hasta','mediante','para','por','según','sin','so','sobre','tras','pero','mas','sino','o bien','ni','y','mientras que','o','u','bien','pues','puesto que','porque','como','que','si','aunque','aun cuando','así','mientras','para que','luego'
    );

    $cadena = explode(" ", $cadena);
    $newCadena = '';

    if(count($cadena)>0){
        for($i=0; $i<count($cadena); $i++){
            if(!in_array($cadena[$i], $term_eliminar)){
                $newCadena .= $cadena[$i]." ";
            }
        }
    }

    $newCadena = trim($newCadena);
    $newCadena = str_replace(array(' '), '-', $newCadena);

    return $newCadena;
}

/* Referencias OEMs */
echo "<h1>Referencias OEMs</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_RefOem.php';
echo "</div>";

/* Marcas */
echo "<h1>Marcas</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_Marcas.php';
echo "</div>";

/* Series */
echo "<h1>Series</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_Series.php';
echo "</div>";

/* Modelos */
echo "<h1>Modelos</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_Modelos.php';
echo "</div>";

/* rel Marcas Series */
echo "<h1>rel Marcas Series</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_rel_Marcas_Series.php';
echo "</div>";

/* rel Series Modelos */
echo "<h1>rel Series Modelos</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_rel_Series_Modelos.php';
echo "</div>";

/* rel refOem Marcas Series Modelos */
echo "<h1>rel refOem Marcas Series Modelos</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_rel_refOem_Marcas_Series_Modelos.php';
echo "</div>";

/* Repuestos ES */
echo "<h1>Repuestos ES</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_Repuestos_ES.php';
echo "</div>";

/* Repuestos EN */
echo "<h1>Repuestos EN</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_Repuestos_EN.php';
echo "</div>";

/* rel Repuestos RefOem */
echo "<h1>rel Repuestos RefOem</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_rel_repuestos_refoem.php';
echo "</div>";

/* Categorias ES */
echo "<h1>Categorias ES</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_Categoria_ES.php';
echo "</div>";

/* Categorias EN */
echo "<h1>Categorias EN</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_Categoria_EN.php';
echo "</div>";

/* Arbol Categorias ES EN */
echo "<h1>Arbol Categorias ES EN</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_Arbol_Categoria_ES_EN.php';
echo "</div>";

/* rel Repuestos Categorias */
echo "<h1>rel Repuestos Categorias</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_rel_repuestos_categorias.php';
echo "</div>";

/* Caracteristicas ES */
echo "<h1>Caracteristicas ES</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_Caracteristicas_ES.php';
echo "</div>";

/* Caracteristicas EN */
echo "<h1>Caracteristicas EN</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_Caracteristicas_EN.php';
echo "</div>";

/* rel Repuestos Caracteristicas */
echo "<h1>rel Repuestos Caracteristicas</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_rel_repuestos_caracteristicas.php';
echo "</div>";

// // /* Imagenes ES*/
echo "<h1>Imagenes ES</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_Imagenes_ES.php';
echo "</div>";

// // /* Imagenes EN*/
echo "<h1>Imagenes EN</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_Imagenes_EN.php';
echo "</div>";

// /* rel Repuestos Imagenes */
echo "<h1>rel Repuestos Imagenes</h1>";
echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_rel_Repuestos_Imagenes.php';
echo "</div>";

/* Imagenes ReName Productos ES*/
echo "<h1>Imagenes ReName Productos ES</h1>";
echo "<div style='max-height: 500px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_Imagenes_ReName_ES.php';
echo "</div>";

// /* Imagenes ReName Accesorios ES */
// echo "<h1>Imagenes ReName Accesorios ES</h1>";
// echo "<div style='max-height: 500px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
// require './procesos/proceso_Imagenes_ReName_Accesorios_ES.php';
// echo "</div>";

/* Imagenes ReName Productos EN*/
echo "<h1>Imagenes ReName Productos EN</h1>";
echo "<div style='max-height: 500px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
require './procesos/proceso_Imagenes_ReName_EN.php';
echo "</div>";

// /* Imagenes ReName Accesorios EN */
// echo "<h1>Imagenes ReName Accesorios EN</h1>";
// echo "<div style='max-height: 500px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
// require './procesos/proceso_Imagenes_ReName_Accesorios_EN.php';
// echo "</div>";

// /* Planos y Puntos de Interes */
// echo "<h1>Planos y Puntos de Interes</h1>";
// echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
// require './procesos/proceso_Planos.php';
// echo "</div>";

// /* Embragues */
// echo "<h1>Embragues</h1>";
// echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
// require './procesos/proceso_Embragues.php';
// echo "</div>";

// /* Planos Caracteristicas */
// echo "<h1>Planos de Características</h1>";
// echo "<div style='max-height: 200px;max-width:500px;overflow-y: scroll;border: 1px solid #c81c1c;padding: 28px;line-height: 22px;font-size: 16px;margin-bottom: 30px;'>";
// require './procesos/proceso_PlanosCaracteristicas.php';
// echo "</div>";


/* cierra la conexión */
$cxn_bd1->close();
$cxn_bd2->close();
?>
