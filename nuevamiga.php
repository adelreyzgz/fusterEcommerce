<?php

$titleHead = '';
$titleHead2 = '';

$productosURL = ${"lang_".$idioma}['productos']['url'];
$accesoriosURL = ${"lang_".$idioma}['accesoriosurl'];
$productosTitle = ${"lang_".$idioma}['productos']['title'];
$accesoriosTitle = ${"lang_".$idioma}['accesorios'];
$accesoriosTitle = ${"lang_".$idioma}['accesorios'];
$pluralM = ${"lang_".$idioma}['marca']['pluralM'];

$separador = '<span class="separadorr"></span>';
$rutaInicio = '<a class="inicio" href="/'.$idioma.'/" title="Home"></a>';
$ruta = '';
$rutaFinal = '';
$urlTempCategoria = '';
$urlTempMarca = '';
$rutaCategoria = "";
$rutaPadres = "";
$nombreC = '';
$imagenM = '';

if(isset($_GET['catpadre']) && $_GET['catpadre']){
    $idCategoria = $_GET['catpadre'];
    $query = $cxn_bd->prepare("SELECT id, nombre, idPadre FROM ".$idioma."_categorias WHERE id = $idCategoria");
    if($query){
        if($query->execute()){
            $data = $query->get_result();
            $result = $data->fetch_all(MYSQLI_ASSOC);
            $id = $result[0]['id'];
            $nombreC = $result[0]['nombre'];
            $idPadre = $result[0]['idPadre'];
            $idCAT = $result[0]['id'];
            $nombreCURL = cleanName($nombreC);
            $titleHead2 .= ' '.$nombreC;
            $rutaCategoria = $nombreC;
            
            $rutaPadres = findPadres($idPadre, $cxn_bd, $separador, $idioma);
        }
    }
}

if(  isset($_GET['module']) && (
   (strpos($_GET['module'], "/accesorios/listado-accesorios.php") != false)
   ||
   (strpos($_GET['module'], "/accesorios/accesorios.php") != false)
   ||
   (strpos($_GET['module'], "/accesorios/detalle-accesorios.php") != false)
   )) {
   $ruta = '<a href="'.$idioma.'/'.$productosURL.'/'.$accesoriosURL.'/" title="'.$accesoriosTitle.'">'.$accesoriosTitle.'</a>';
   $titleHead = $accesoriosTitle;
   $rutaProd = '';
   if($rutaCategoria != ''){
        if(isset($_GET['prodId']) && $_GET['prodId']){
            $prodId = $_GET['prodId'];

            $query = $cxn_bd->prepare("
            SELECT re.*, ".$idioma."_imagenes.fullsize_wm, ".$idioma."_imagenes.title FROM ".$idioma."_repuestos as re
            JOIN rel_repuestos_imagenes as relimg on relimg.idRepuesto = re.id
            JOIN ".$idioma."_imagenes on ".$idioma."_imagenes.id = relimg.idImagen
            WHERE re.id = $prodId AND tipo = 0"); 
            
            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    if($result = $data->fetch_all(MYSQLI_ASSOC)){
                        $id = $result[0]['id'];
                        $nombreP = $result[0]['nombre'];
                        $titlePP = $result[0]['title'];
                        $rutaProd = $nombreP;
                        $nombreClean = cleanName($nombreP);
                        $titleHead2 .= ' '.$nombreClean;
                    } 
                }
            }
        }
        
        if($rutaProd != ''){
            // http://www.fusterrepuestos.local/es/accesorios/cid188/rotulas-cilindricas/
            $rutaCategoria = '<a href="'.$idioma.'/'.$accesoriosURL.'/cid'.$idCAT.'/'.$nombreCURL.'/" title="'.$rutaCategoria.'">'.$rutaCategoria.'</a>';
            $ruta .= $separador.$rutaPadres.$separador.$rutaCategoria.$separador.$rutaProd; 
           
        }else{
            $ruta .= $separador.$rutaPadres.$separador.$rutaCategoria;
        }

    }


}else{
    $ruta = '<a href="'.$idioma.'/'.$productosURL.'/" title="'.$productosTitle.'">'.$productosTitle.'</a>';
    $titleHead = $productosTitle;

    if($rutaCategoria != ''){ 
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
                    $idMARCA = $result[0]['id'];
                    $nombreURL = cleanName($result[0]['marca']);
                    $titleHead2 .= ' '.$nombreURL;
                    $rutaMarca = $nombreC."_".$nombreM;
                }
            }
        }

        if($rutaMarca != ''){ 

            $rutaProd = "";
            $nombreP = '';
            $nombreClean = '';
            $titlePP = '';

            // http://www.fusterrepuestos.local/es/productos/cid52/cables-de-acelerador/
            $rutaCategoria = '<a href="'.$idioma.'/'.$productosURL.'/cid'.$idCAT.'/'.$nombreCURL.'/" title="'.$rutaCategoria.'">'.$rutaCategoria.'_'.$pluralM.'</a>';
            
            if(isset($_GET['prodId']) && $_GET['prodId']){
                $prodId = $_GET['prodId'];

                $query = $cxn_bd->prepare("
                SELECT re.*, ".$idioma."_imagenes.fullsize_wm, ".$idioma."_imagenes.title FROM ".$idioma."_repuestos as re
                JOIN rel_repuestos_imagenes as relimg on relimg.idRepuesto = re.id
                JOIN ".$idioma."_imagenes on ".$idioma."_imagenes.id = relimg.idImagen
                WHERE re.id = $prodId AND tipo = 1"); //7448 problemas porq la img no tiene symbolic
                if($query){
                    if($query->execute()){
                        $data = $query->get_result();
                        if($result = $data->fetch_all(MYSQLI_ASSOC)){
                            $id = $result[0]['id'];
                            $nombreP = $result[0]['nombre'];
                            $titlePP = $result[0]['title'];
                            $rutaProd = $nombreP;
                            $nombreClean = cleanName($nombreP);
                            $titleHead2 .= ' '.$nombreClean;
                        } 
                    }
                }
            }
            
            if($rutaProd != ''){
                $rutaMarca = '<a href="'.$idioma.'/'.$productosURL.'/mid'.$idMARCA.'/cid'.$idCAT.'/'.$nombreCURL.'/'.$nombreURL.'/" title="'.$nombreM.'">'.$rutaMarca.'</a>';
                $ruta .= $separador.$rutaPadres.$separador.$rutaCategoria.$separador.$rutaMarca.$separador.$rutaProd; 
            }else{
                $ruta .= $separador.$rutaPadres.$separador.$rutaCategoria.$separador.$rutaMarca;
            }
        }else{
            $ruta .= $separador.$rutaPadres.$separador.$rutaCategoria."_".$pluralM; 
        }
    }else{
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
                    $rutaMarca = $nombreM;
                    $titleHead2 .= ' '.$nombreURL;
                    $ruta .= $separador.$rutaMarca;
                }
            }
        }
    }

    

}

if(isset($_GET['module'])){
   switch($_GET['module']){
       case 'modules/puntoVenta/punto-venta.php' : $ruta = ${"lang_".$idioma}['puntodeventa']['title'];$titleHead= ${"lang_".$idioma}['puntodeventa']['title'];break;
       case 'modules/compania/compania.php' : $ruta = ${"lang_".$idioma}['empresa']['title'];$titleHead= ${"lang_".$idioma}['empresa']['title'];break;
       case 'modules/contacto/contacto.php' : $ruta = ${"lang_".$idioma}['contacto']['title'];$titleHead= ${"lang_".$idioma}['contacto']['title'];break;
       case 'modules/legales/politica-privacidad.php' : $ruta = ${"lang_".$idioma}['politicaprivacidad'];$titleHead= ${"lang_".$idioma}['politicaprivacidad'];break;
       case 'modules/legales/politica-cookies.php' : $ruta = ${"lang_".$idioma}['politicacookies'];$titleHead= ${"lang_".$idioma}['politicacookies'];break;
       case 'modules/legales/aviso-legal.php' : $ruta = ${"lang_".$idioma}['avisolegal'];$titleHead= ${"lang_".$idioma}['avisolegal'];break;
       case 'modules/faqs/faqs.php' : $ruta = ${"lang_".$idioma}['preguntasfrecuentes'];$titleHead= ${"lang_".$idioma}['preguntasfrecuentes'];break;
       case 'modules/login/acceso.php' : $ruta = ${"lang_".$idioma}['acceso'];$titleHead= ${"lang_".$idioma}['acceso'];break;
   }
}


if($titleHead2){
    $titleHead = $titleHead.' '.$titleHead2; 
}

$titleHead = $titleHead.' - '.${"lang_".$idioma}['titlePage']; 

$rutaFinal = $rutaInicio.$separador.$ruta;

?>