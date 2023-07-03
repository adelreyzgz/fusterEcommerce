<?php
 
 $productosURL = ${"lang_".$idioma}['productos']['url'];
 $accesoriosURL = ${"lang_".$idioma}['accesoriosurl'];
 $productosTitle = ${"lang_".$idioma}['productos']['title'];
 $accesoriosTitle = ${"lang_".$idioma}['accesorios'];
 $separador = '<span class="separadorr"></span>';
 $rutaInicio = '<a class="inicio" href="/" title="Home"></a>';
 $ruta = '';
 $rutaFinal = '';

if(isset($_GET['module'])){
    switch($_GET['module']){
        case 'modules/puntoVenta/punto-venta.php' : $ruta = ${"lang_".$idioma}['puntodeventa']['title'];break;
        case 'modules/compania/compania.php' : $ruta = ${"lang_".$idioma}['empresa']['title'];break;
        case 'modules/contacto/contacto.php' : $ruta = ${"lang_".$idioma}['contacto']['title'];break;
        case 'modules/legales/politica-privacidad.php' : $ruta = ${"lang_".$idioma}['politicaprivacidad'];break;
        case 'modules/legales/politica-cookies.php' : $ruta = ${"lang_".$idioma}['politicacookies'];break;
        case 'modules/legales/aviso-legal.php' : $ruta = ${"lang_".$idioma}['avisolegal'];break;
        case 'modules/faqs/faqs.php' : $ruta = ${"lang_".$idioma}['preguntasfrecuentes'];break;
        case 'modules/login/acceso.php' : $ruta = ${"lang_".$idioma}['acceso'];break;
    }
}


 $rutaFinal = $rutaInicio.$separador.$ruta;



?>








































//  if(  isset($_GET['module']) && (
//      (strpos($_GET['module'], "/accesorios/listado-accesorios.php") != false)
//      ||
//      (strpos($_GET['module'], "/accesorios/accesorios.php") != false)
//      ||
//      (strpos($_GET['module'], "/accesorios/detalle-accesorios.php") != false)
//      )) {
//      $rutaProductos = '<a href="'.$idioma.'/'.$productosURL.'/'.$accesoriosURL.'/" title="'.$accesoriosTitle.'">'.$accesoriosTitle.'</a>';
//  }else{
//      $rutaProductos = '<a href="'.$idioma.'/'.$productosURL.'/" title="'.$productosTitle.'">'.$productosTitle.'</a>';
//  }

//  if(  isset($_GET['module']) && $_GET['module'] == "modules/puntoVenta/punto-venta.php" ){
//      $rutaProductos = ${"lang_".$idioma}['puntodeventa']['title'];
//  }

//  if(  isset($_GET['module']) && $_GET['module'] == "modules/compania/compania.php" ){
//      $rutaProductos = ${"lang_".$idioma}['empresa']['title'];
//  }

//  if(  isset($_GET['module']) && $_GET['module'] == "modules/contacto/contacto.php" ){
//      $rutaProductos = ${"lang_".$idioma}['contacto']['title'];
//  }

//  if(  isset($_GET['module']) && $_GET['module'] == "modules/legales/politica-privacidad.php" ){
//      $rutaProductos = ${"lang_".$idioma}['politicaprivacidad'];
//  }

//  if(  isset($_GET['module']) && $_GET['module'] == "modules/legales/politica-cookies.php" ){
//      $rutaProductos = ${"lang_".$idioma}['politicacookies'];
//  }

//  if(  isset($_GET['module']) && $_GET['module'] == "modules/legales/aviso-legal.php" ){
//      $rutaProductos = ${"lang_".$idioma}['avisolegal'];
//  }

//  if(  isset($_GET['module']) && $_GET['module'] == "modules/faqs/faqs.php" ){
//      $rutaProductos = ${"lang_".$idioma}['preguntasfrecuentes'];
//  }

//  if(  isset($_GET['module']) && $_GET['module'] == "modules/login/acceso.php" ){
//      $rutaProductos = ${"lang_".$idioma}['acceso'];
//  }

//  $rutaFinalProductos = $rutaInicio.$separador.$rutaProductos;


 ?>