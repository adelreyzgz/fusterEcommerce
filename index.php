<?php
session_start();
require '000_admin/_rest/cnx/conect.php';

/*
$cantid = 0;
            $query = $cxn_bd->prepare("SELECT DISTINCT id FROM es_repuestos");
            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    $result = $data->fetch_all(MYSQLI_ASSOC);
		    $cantid = count($result);
		    echo $cantid;
                }
            }
 */


// include("convertURL.php");
function cleanName($cadena){
    // Convertimos el texto a analizar a minúsculas
    $cadena = strtolower($cadena);

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
    array('Ñ', 'ñ', 'Ç', 'ç', ' ', '(', ')', '+', ',', '/', '"', '”', "'"),
    array('N', 'n', 'C', 'c', '-', '', '', '', '', '', '', ''),
    $cadena
    );
    
    $cadena = trim($cadena);
    return $cadena;
}


$_SESSION['idioma'] = 'es';
$idioma = "es";
$base = "http://www.fusterrepuestos.local/";

if(isset($_GET['idioma'])){
    $idioma = $_GET['idioma'];
    $_SESSION['idioma'] = $_GET['idioma'];
}else{
    $idioma = "es";
}

$host= $_SERVER["HTTP_HOST"];

if($host == "repuestosfuster.fr" || $host == "www.repuestosfuster.fr"){
    $_SESSION['idioma'] = 'fr';
    $idioma = "fr";
    $base = "https://www.repuestosfuster.fr/";
}

?>
<!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="xmlrpc.php">
        <link rel="icon" type="image/png" href="favicon.png"/>
        <!-- <base href="http://www.fusterrepuestos.local/"> -->


        <base href="<?=$base;?>"> 

        <?php 
        // error_reporting(E_ALL);
        // ini_set('display_errors', '1');

        include("idioma/es.php");
        include("idioma/en.php");
        include("idioma/fr.php");

        ?>

        <?php include("modules/styles-css.php");?>

        <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"
        ></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"
        ></script>
        <!-- Modernizr -->
        <script src="assets/js/modernizr.js"></script>
        <!-- FlexSlider -->
        <script defer src="assets/js/jquery.flexslider.js"></script>
        <!-- LightGallery -->
        <script src="assets/js/prettify.js"></script>
        <script src="assets/js/jquery.justifiedGallery.min.js"></script>
        <script src="assets/lightgallery/js/lightgallery.js"></script>
        <script src="assets/lightgallery/js/lg-fullscreen.js"></script>
        <script src="assets/lightgallery/js/lg-thumbnail.js"></script>
        <script src="assets/lightgallery/js/lg-video.js"></script>
        <script src="assets/lightgallery/js/lg-autoplay.js"></script>
        <script src="assets/lightgallery/js/lg-zoom.js"></script>
        <script src="assets/js/demos.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> 
        <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script> 

        <script src="assets/js/slick.js" type="text/javascript" charset="utf-8"></script>

        <script src='https://www.google.com/recaptcha/api.js?render=6Ld5Iq8jAAAAAAoZc3YiMaHML0oAbpT9zbyzV86g'> 
        </script>
        <script>
            grecaptcha.ready(function() {
            grecaptcha.execute('6Ld5Iq8jAAAAAAoZc3YiMaHML0oAbpT9zbyzV86g', {action: 'formulario'})
            .then(function(token) {
            if(document.getElementById('recaptchaResponse')){
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            }
            });});

        </script>

        <?php

            $cantid = 0;
            $query = $cxn_bd->prepare("SELECT DISTINCT id FROM es_repuestos");
            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    $result = $data->fetch_all(MYSQLI_ASSOC);
                    $cantid = count($result);
                }
            }

            function findPadres($idPad, $cxn_bd, $separador, $idioma){
                $idCategoria = $idPad;
                $rutaPadres = '';
                $query = $cxn_bd->prepare("SELECT id, nombre, idPadre FROM ".$idioma."_categorias WHERE id = $idCategoria");
                if($query){
                    if($query->execute()){
                        $data = $query->get_result();
                        $result = $data->fetch_all(MYSQLI_ASSOC);
                        
                        if(isset($result[0])){
                            $id = $result[0]['id'];
                            $nombreC = $result[0]['nombre'];
                            $idPadre = $result[0]['idPadre'];
                            
                            if($idPadre != 13){
                                $rutaPadres = findPadres($idPadre, $cxn_bd, $separador, $idioma);
                            }else{
                                return $result[0]['nombre'];
                            }
    
    
                            if($rutaPadres){
                                return $rutaPadres.$separador.$result[0]['nombre'];
                            }else{
                                return $result[0]['nombre'];
                            }
    
                        }
    
    
                    }
                }
    
    
            }

            include("nuevamiga.php");
        ?>
        <?php
            
            $rutaCategoria = "";
            $rutaPadres = "";
            $nombreC = '';
        
            if(isset($_GET['catpadre']) && $_GET['catpadre']){
                $idCategoria = $_GET['catpadre'];
                $query = $cxn_bd->prepare("SELECT id, nombre, idPadre FROM ".$idioma."_categorias WHERE id = $idCategoria");
                if($query){
                    if($query->execute()){
                        $data = $query->get_result();
                        $result = $data->fetch_all(MYSQLI_ASSOC);
                        $id = $result[0]['id'];
                        $nombreC = $result[0]['nombre'];
                        
                        // $nombreURL = cleanName($result[0]['nombre']);
                        $idPadre = $result[0]['idPadre'];
                        // $rutaCategoria = '<a href="'.$idioma.'/'.$productosURL.'/cid'.$id.'/'.$nombreURL.'/" title="'.$nombre.'">'.$nombre.'</a>';

                        $rutaCategoria = $nombreC;

                        $rutaPadres = findPadres($idPadre, $cxn_bd, $separador, $idioma);

                    }
                }
            }

            $rutaMarca = "";
            $nombreM = '';
            $imagenM = '';
            if(isset($_GET['marca']) && $_GET['marca']){
                $idMarca = $_GET['marca'];
                $query = $cxn_bd->prepare("SELECT id, marca, imagen FROM marcas WHERE id = $idMarca");
                if($query){
                    if($query->execute()){
                        $data = $query->get_result();
                        $result = $data->fetch_all(MYSQLI_ASSOC); 
                        $id = $result[0]['id'];
                        $nombreM = $result[0]['marca'];
                        $imagenM = $result[0]['imagen'];
                        $nombreURL = cleanName($result[0]['marca']);
                        if($rutaCategoria!= ''){
                            $rutaMarca = '<a href="'.$idioma.'/'.$productosURL.'/mid'.$id.'/'.$nombreURL.'/" title="'.$nombreM.'">'.$nombreM.'</a>';
                        }else{
                            $rutaMarca = $nombreM;
                        }

                    }
                }
            }

            $rutaProducto = "";
            $nombreP = '';
            $nombreClean = '';
            $refFusterP = '';
            $descripcionP = '';
            $caracteristicas = ''; $titlePP = '';

            $imgProd2 = "";
            $imgProd3 = "";
            $imgProd = "assets/images/default.png";
            
            if(isset($_GET['prodId']) && $_GET['prodId']){
                $prodId = $_GET['prodId'];
                $tipo = 1;
                if(
                    (strpos($_GET['module'], "/accesorios/listado-accesorios.php") != false)
                    ||
                    (strpos($_GET['module'], "/accesorios/accesorios.php") != false)
                    ||
                    (strpos($_GET['module'], "/accesorios/detalle-accesorios.php") != false)
                    ) {
                    $tipo = 0;
                }

                $queryTestPrinciD = $cxn_bd->prepare("
                            SELECT re.*, ".$idioma."_imagenes.fullsize_wm, ".$idioma."_imagenes.title FROM ".$idioma."_repuestos as re
                            LEFT JOIN rel_repuestos_imagenes as relimg on relimg.idRepuesto = re.id
                            LEFT JOIN ".$idioma."_imagenes on ".$idioma."_imagenes.id = relimg.idImagen
                            WHERE re.id = $prodId AND tipo = $tipo and relimg.principal = 1"); //7448 problemas porq la img no tiene symbolic
                            if($queryTestPrinciD){
                                if($queryTestPrinciD->execute()){
                                    $dataTestPrinciD = $queryTestPrinciD->get_result();
                                    if($resultTestPrinciD = $dataTestPrinciD->fetch_all(MYSQLI_ASSOC)){
                                        $id = $resultTestPrinciD[0]['id'];
                                        $nombreP = $resultTestPrinciD[0]['nombre'];
                                        $refFusterP = $resultTestPrinciD[0]['noRefFuster'];
                                        $descripcionP = $resultTestPrinciD[0]['descripcion'];
                                        $titlePP = $resultTestPrinciD[0]['title'];
                                        $rutaProducto = $nombreP;

                                        $nombreClean = cleanName($nombreP);
                                        $imgProd = "assets/images/default.png";
                                        if($resultTestPrinciD[0]['fullsize_wm']){
                                            $imgProd = "assets/images/repuestos/fotos/".$idioma."/" . $resultTestPrinciD[0]['fullsize_wm'];
                                        }
                                        $query = $cxn_bd->prepare("
                                            SELECT re.*, ".$idioma."_imagenes.fullsize_wm, ".$idioma."_imagenes.title FROM ".$idioma."_repuestos as re
                                            LEFT JOIN rel_repuestos_imagenes as relimg on relimg.idRepuesto = re.id
                                            LEFT JOIN ".$idioma."_imagenes on ".$idioma."_imagenes.id = relimg.idImagen
                                            WHERE re.id = $prodId AND tipo = $tipo and relimg.principal <> 1"); //7448 problemas porq la img no tiene symbolic
                                            if($query){
                                                if($query->execute()){
                                                    $data = $query->get_result();
                                                    if($result = $data->fetch_all(MYSQLI_ASSOC)){
                                                        $imgProd2 = "";
                                                            if(isset($result[0]['fullsize_wm'])){
                                                                $imgProd2 = "assets/images/repuestos/fotos/".$idioma."/" . $result[0]['fullsize_wm'];
                                                            }

                                                        $imgProd3 = "";
                                                            if(isset($result[1]['fullsize_wm'])){
                                                                $imgProd3 = "assets/images/repuestos/fotos/".$idioma."/" . $result[1]['fullsize_wm'];
                                                            }

                                                    }
                                                }
                                            }
                                        $query = $cxn_bd->prepare("
                                        SELECT caract.alias, rel1.valor FROM ".$idioma."_caracteristicas as caract JOIN rel_repuestos_caracteristicas as rel1 ON caract.id = rel1.idCaracteristica JOIN ".$idioma."_repuestos as rep on rel1.idRepuesto = rep.id WHERE rep.id = $prodId AND rep.tipo = $tipo;
                                        ");
                
                                        if($query){
                                            if($query->execute()){
                                                $data = $query->get_result();
                                                $caracteristicas = $data->fetch_all(MYSQLI_ASSOC);
                                            }
                                        }
                                    
                                                


                                    }
                                }
                            }

                if($tipo != 1){
                    if(isset($_GET['catpadre']) && $_GET['catpadre']){
                        $idCategoria = $_GET['catpadre'];
                        $query = $cxn_bd->prepare("
                        SELECT planos.imagenFondo FROM rel_categorias_planos
                        JOIN planos on planos.id = rel_categorias_planos.idPlano
                        WHERE idCategoria = $idCategoria
                        ");

                        if($query){
                            if($query->execute()){
                                $data = $query->get_result();
                                $imgPlano = $data->fetch_all(MYSQLI_ASSOC);
                            }
                        }
                    }
                }
            }

            
            // if($rutaMarca != ''){ $rutaFinal .= $separador.$rutaMarca; }
            // if($rutaPadres != ''){ $rutaFinal .= $separador.$rutaPadres; }
            // if($rutaCategoria != ''){ $rutaFinal .= $separador.$rutaCategoria; }
            // if($rutaProducto != ''){ $rutaFinal .= $separador.$rutaProducto; }

        ?>
        <?php 
            include("seoData.php");
        ?>
    </head>

    <?php include("modules/header/header-desktop.php");?>
    
    <body>

        <?php 
            //var module (cuerpo del sitio)
            if(isset($_GET['module'])){
                ?>

                    <div style='background: #efefef;'>
                        <div class="breadcrumb-container">
                            <?=$rutaFinal?>
                        </div>
                    </div>

                <?php
                $module = $_GET['module'];
                include $module;   
            }else{
                include 'modules/inicio/inicio.php';
            }

        ?>

        <?php include("modules/footer/footer.php");?>
    </body>

    <?php include("modules/scripts-js.php");?>

    <?php 
        //var module_js (js especifico por página)
        if(isset($_GET['module_js'])){
            $module = $_GET['module_js'];
            include $module;   
        }else{
            include 'modules/js/inicio-js.php';
        }
        
    ?>
    <?php include("modules/js/buscador-avanzado-js.php");?>

    <?php 
        if(isset($_GET['module']) && $_GET['module']=='modules/productos/productos.php' && isset($_GET['marca'])){
            include("modules/js/buscador-avanzado-js2.php");
        }
    ?>

    <script>
        /*global $:true */

        var $ = $.noConflict();
        $(document).ready(function($) {
            "use strict";
                var datosUserLogin = '';

                if (window.localStorage.getItem('user_data_fuster') !== undefined
                    && window.localStorage.getItem('user_data_fuster')
                ) {
                    datosUserLogin = JSON.parse(localStorage.getItem('user_data_fuster'));
                    $('.carritoHeader').show();
                    $('.perfil').show();
                    $('#estilosCart').attr('href', 'assets/css/cartStyleTrue.css');
                }else{
                    $('.acceso').show();
                    $('#estilosCart').attr('href', 'assets/css/cartStyleFalse.css');
                }
                
                if(localStorage.getItem("user_cart_fuster")){
                    var userCartLS = JSON.parse(window.localStorage.getItem("user_cart_fuster"));
                    var cantidad = 0;
                    for (let index = 0; index < userCartLS.length; index++) {
                        cantidad += parseInt(userCartLS[index].valor);
                    }
                    $('.cantProdCart').html(cantidad);
                }
                
        });
    </script>

</body>
</html>
