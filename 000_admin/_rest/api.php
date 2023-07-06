<?php
    session_start();
    require 'cnx/conect.php';
    
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }


    if(isset($_GET['generateSiteMap']) && $_GET['generateSiteMap']){

        //PRODUCTOS 
        //http://www.fusterrepuestos.local/000_admin/_rest/api.php?generateSiteMap=en&tipo=1
        //http://www.fusterrepuestos.local/000_admin/_rest/api.php?generateSiteMap=es&tipo=1

        //ACCESORIOS 
        //http://www.fusterrepuestos.local/000_admin/_rest/api.php?generateSiteMap=en
        //http://www.fusterrepuestos.local/000_admin/_rest/api.php?generateSiteMap=es


        // FILTRAR   ->>>> //</l 
        
        $idiomaSiteMap = $_GET['generateSiteMap'];
        $xml = '<xmp>';

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

        function url_actual(){
            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                $url = "https://"; 
            }else{
                $url = "http://"; 
            }
            return $url . $_SERVER['HTTP_HOST'];
        }
        $host = url_actual();

        if(isset($_GET['tipo']) && $_GET['tipo']==1){

            $query = $cxn_bd->prepare("SELECT re.id, re.nombre, re.noRefFuster, rel2.idMarca, marcas.marca as nombreMarca, rel3.idCategoria, ".$idiomaSiteMap."_categorias.nombre as nombreCategoria FROM ".$idiomaSiteMap."_repuestos as re 
            JOIN rel_repuestos_refoem as rel1 ON re.id = rel1.idRepuesto 
            JOIN rel_repuestos_categorias as rel3 ON re.id = rel3.idRepuesto 
            JOIN ".$idiomaSiteMap."_categorias on rel3.idCategoria = ".$idiomaSiteMap."_categorias.id
            JOIN rel_refoem_marcas_series_modelo as rel2 ON rel2.idRefOem = rel1.idRefOem
            JOIN marcas on marcas.id = rel2.idMarca
            WHERE re.tipo = 1 and rel3.tipoProd = 1 GROUP By re.id, nombreCategoria, nombreMarca  ORDER BY re.nombre asc");

            // echo "SELECT re.id, re.nombre, re.noRefFuster, rel2.idMarca, marcas.marca as nombreMarca, rel3.idCategoria, ".$idiomaSiteMap."_categorias.nombre as nombreCategoria FROM ".$idiomaSiteMap."_repuestos as re 
            // JOIN rel_repuestos_refoem as rel1 ON re.id = rel1.idRepuesto 
            // JOIN rel_repuestos_categorias as rel3 ON re.id = rel3.idRepuesto 
            // JOIN ".$idiomaSiteMap."_categorias on rel3.idCategoria = ".$idiomaSiteMap."_categorias.id
            // JOIN rel_refoem_marcas_series_modelo as rel2 ON rel2.idRefOem = rel1.idRefOem
            // JOIN marcas on marcas.id = rel2.idMarca
            // WHERE re.tipo = 1 and rel3.tipoProd = 1 GROUP By re.id, nombreCategoria, nombreMarca  ORDER BY re.nombre asc";

            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    while($row = $data->fetch_assoc()){
    
                        $idProd = $row["id"];
                        $nombreProd = cleanName($row["nombre"]);
                        $idMarca = $row["idMarca"];
                        $nombreMarca = cleanName($row["nombreMarca"]);
                        $idCategoria = $row["idCategoria"];
                        $nombreCategoria = cleanName($row["nombreCategoria"]);
                        $fecha = date("Y-m-d");
                        $hora = date("H:i:s"); 
                        $fechaF = $fecha."T".$hora."+00:00"; // 2001-03-10 17:16:18 (el formato DATETIME de MySQL) 2022-07-22T02:08:02+00:00
    
                        $productos = 'productos';
                        if($idiomaSiteMap == 'en'){
                            $productos = 'products';
                        }
                        if($idiomaSiteMap == 'fr'){
                            $productos = 'produits';
                        }

                        $xml .= "
                        <url>
                            <loc>".$host."/".$idiomaSiteMap."/".$productos."/mid".$idMarca."/cid".$idCategoria."/pid".$idProd."/".$nombreMarca."/".$nombreCategoria."/".$nombreProd."/</loc>
                            <lastmod>".$fechaF."</lastmod>
                            <priority>0.90</priority>
                        </url>
                        ";
                    }
                }
            }
        }else{

            $query = $cxn_bd->prepare("SELECT re.id, re.nombre, rel3.idCategoria, ".$idiomaSiteMap."_categorias.nombre as nombreCategoria FROM ".$idiomaSiteMap."_repuestos as re 
            JOIN rel_repuestos_categorias as rel3 ON re.id = rel3.idRepuesto 
            JOIN ".$idiomaSiteMap."_categorias on rel3.idCategoria = ".$idiomaSiteMap."_categorias.id
            WHERE re.tipo = 0 and rel3.tipoProd = 0 GROUP BY re.id, nombreCategoria ORDER BY re.nombre asc; ");
    
            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    while($row = $data->fetch_assoc()){
    
                        $idProd = $row["id"];
                        $nombreProd = cleanName($row["nombre"]);
                        $idCategoria = $row["idCategoria"];
                        $nombreCategoria = cleanName($row["nombreCategoria"]);
                        $fecha = date("Y-m-d");
                        $hora = date("H:i:s"); 
                        $fechaF = $fecha."T".$hora."+00:00"; // 2001-03-10 17:16:18 (el formato DATETIME de MySQL) 2022-07-22T02:08:02+00:00
                        $accesorios = 'accesorios';
                        if($idiomaSiteMap == 'en'){
                            $accesorios = 'accesories';
                        }
                        if($idiomaSiteMap == 'fr'){
                            $accesorios = 'accessoires';
                        }

                        $xml .= "
                        <url>
                            <loc>".$host."/".$idiomaSiteMap."/".$accesorios."/cid".$idCategoria."/pid".$idProd."/".$nombreCategoria."/".$nombreProd."/</loc>
                            <lastmod>".$fechaF."</lastmod>
                            <priority>0.90</priority>
                        </url>
                        ";
                    }
                }
            }
        }

        $xml .= '</xmp>';
        echo $xml;

        die;
    }

    $result = '';
    $msg = '';
    $code = 0;
    
    if(isset($_SESSION['idioma'])){
        $idioma = $_SESSION['idioma'];
    }else{
        $idioma = 'es';
    }

    $host= $_SERVER["HTTP_HOST"];

    if($host == "repuestosfuster.fr" || $host == "www.repuestosfuster.fr"){
        $_SESSION['idioma'] = 'fr';
        $idioma = "fr";
    }


    if(isset($_GET['action']) && $_GET['action']){
        $action = $_GET['action'];

        if($action == 'listarMarcasLateral'){

            $query = $cxn_bd->prepare("SELECT id, marca, orden, imagen FROM marcas WHERE id <> 222 order by orden");
            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    $result = $data->fetch_all(MYSQLI_ASSOC); 
                }
            }

            if ($result) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $result);
            echo json_encode($response);
        }

        if($action == 'listarMarcasConProductos' && isset($_GET['cat']) && $_GET['cat']){

            $idCategoria = $_GET['cat'];
            $query = $cxn_bd->prepare("SELECT unionT.id, unionT.marca, count(unionT.id) as cantidad, unionT.imagen FROM (SELECT DISTINCT marcas.id, marcas.marca, marcas.imagen, rel_repuestos_refoem.idRepuesto FROM marcas JOIN rel_refoem_marcas_series_modelo as rel ON rel.idMarca = marcas.id JOIN rel_repuestos_refoem ON rel.idRefOem = rel_repuestos_refoem.idRefOem JOIN rel_repuestos_categorias ON rel_repuestos_categorias.idRepuesto = rel_repuestos_refoem.idRepuesto WHERE marcas.id != 222 AND rel_repuestos_categorias.idCategoria=$idCategoria ORDER BY marcas.marca ASC) as unionT GROUP BY unionT.marca; ");

            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    $result = $data->fetch_all(MYSQLI_ASSOC); 
                }
            }

            if ($result) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $result);
            echo json_encode($response);
        }

        if($action == 'buscarTractoresByNombreProd'){

            $data = [];
            $query = '';
            $producto = trim($_POST['producto']);

            $result = preg_replace('/ de la | de los | de | y | con | la  | el | lo | del  | los  | las  | para  | por  | contra  | desde  | en  | durante  | entre  | hacia | hasta  | mediante  | para  | sin  | sobre /m'," ", $producto);
            $stringSeparado = explode(' ', $result);
            $strgQ = "( ";
            for ($i=0; $i < count($stringSeparado); $i++) { 
                if(count($stringSeparado)>1){
                    if($i < count($stringSeparado)-1){
                        $strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" AND ';
                    }else{
                        $strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" ';
                    }
                }else{$strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" ';}           
            }
            $strgQ .= " )";


            $query = $cxn_bd->prepare("SELECT unionT.id, unionT.prodId, unionT.marca, count(unionT.id) as cantidad, unionT.imagen FROM (SELECT DISTINCT marcas.id, re.id as prodId, marcas.marca, marcas.imagen, rel_repuestos_refoem.idRepuesto FROM marcas 
            
            JOIN rel_refoem_marcas_series_modelo as rel ON rel.idMarca = marcas.id 
            
            JOIN rel_repuestos_refoem ON rel.idRefOem = rel_repuestos_refoem.idRefOem 

            JOIN ".$idioma."_repuestos as re ON rel_repuestos_refoem.idRepuesto = re.id 
            
            WHERE $strgQ and marcas.id != 222 ORDER BY marcas.marca ASC) as unionT GROUP BY unionT.marca; ");

            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 
                }
            }

            if ($data) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $data);
            echo json_encode($response);
            
        }
        
        if($action == 'listarProductosByMarcaYCategoria' && isset($_GET['cat']) && $_GET['cat']  && isset($_GET['marc']) && $_GET['marc']){

            $idCategoria = $_GET['cat'];
            $idMarca = $_GET['marc'];

            $query = $cxn_bd->prepare("
            SELECT re.id, re.nombre, re.noRefFuster, ".$idioma."_imagenes.thumbnails FROM ".$idioma."_repuestos as re 
            JOIN rel_repuestos_refoem as rel1 ON re.id = rel1.idRepuesto 
            JOIN rel_repuestos_categorias as rel3 ON re.id = rel3.idRepuesto 
            JOIN rel_refoem_marcas_series_modelo as rel2 ON rel2.idRefOem = rel1.idRefOem 
            LEFT JOIN rel_repuestos_imagenes as relimg on relimg.idRepuesto = re.id
            LEFT JOIN ".$idioma."_imagenes on ".$idioma."_imagenes.id = relimg.idImagen
            WHERE rel2.idMarca = $idMarca AND rel3.idCategoria = $idCategoria and re.tipo = 1 and relimg.principal = 1  GROUP BY re.id ORDER BY re.nombre asc; 
            ");

            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    $result = $data->fetch_all(MYSQLI_ASSOC); 
                }
            }

            if ($result) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $result);
            echo json_encode($response);
        }

        if($action == 'listarAccesoriosByCategoria' && isset($_GET['cat']) && $_GET['cat']){

            $idCategoria = $_GET['cat'];

            $query = $cxn_bd->prepare("
            SELECT re.id, re.nombre, re.noRefFuster, ".$idioma."_imagenes.thumbnails FROM ".$idioma."_repuestos as re 
            JOIN rel_repuestos_categorias as rel3 ON re.id = rel3.idRepuesto 
            LEFT JOIN rel_repuestos_imagenes as relimg on relimg.idRepuesto = re.id
          LEFT  JOIN ".$idioma."_imagenes on ".$idioma."_imagenes.id = relimg.idImagen
            WHERE rel3.idCategoria = $idCategoria and re.tipo = 0 GROUP BY re.id ORDER BY re.nombre asc; 
            ");

            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    $result = $data->fetch_all(MYSQLI_ASSOC); 
                }
            }

            if ($result) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $result);
            echo json_encode($response);
        }

        if($action == 'listarRefOemsAndCaractByIdProducto' && isset($_GET['idProd']) && $_GET['idProd'] && isset($_GET['cat']) && $_GET['cat']  && isset($_GET['marc']) && $_GET['marc']){

            $idCategoria = $_GET['cat'];
            $idMarca = $_GET['marc'];
            $idProd = $_GET['idProd'];
            $query = $cxn_bd->prepare("
            SELECT DISTINCT rep.id as idRepuesto, ref.referencia as refOem FROM refoem as ref JOIN rel_repuestos_refoem as rel1 on ref.id = rel1.idRefOem JOIN ".$idioma."_repuestos as rep on rel1.idRepuesto = rep.id JOIN rel_repuestos_categorias as rel3 ON rep.id = rel3.idRepuesto JOIN rel_refoem_marcas_series_modelo as rel2 ON rel2.idRefOem = rel1.idRefOem WHERE rep.id = $idProd AND rep.tipo = 1 AND rel2.idMarca = $idMarca AND rel3.idCategoria = $idCategoria; 
            ");
            

            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    if($result = $data->fetch_all(MYSQLI_ASSOC)){

                    }else{
                        $result = '-';
                    }
                }
            }

            $query = $cxn_bd->prepare("
            SELECT caract.alias, rel1.valor FROM ".$idioma."_caracteristicas as caract JOIN rel_repuestos_caracteristicas as rel1 ON caract.id = rel1.idCaracteristica JOIN ".$idioma."_repuestos as rep on rel1.idRepuesto = rep.id WHERE rep.id = $idProd AND rep.tipo = 1;
            ");

            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    if($result2 = $data->fetch_all(MYSQLI_ASSOC)){

                    }else{
                        $result2 = '-';
                    }
                }
            }

            if ($result && $result2) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "refOems"=> $result, "caract"=> $result2);
            echo json_encode($response);
        }

        if($action == 'listarCaractByIdAccesorio' && isset($_GET['idProd']) && $_GET['idProd'] && isset($_GET['cat']) && $_GET['cat']){

            $idCategoria = $_GET['cat'];
            $idProd = $_GET['idProd'];

            $query = $cxn_bd->prepare("
            SELECT caract.alias, rel1.valor, caract.id  FROM ".$idioma."_caracteristicas as caract JOIN rel_repuestos_caracteristicas as rel1 ON caract.id = rel1.idCaracteristica JOIN ".$idioma."_repuestos as rep on rel1.idRepuesto = rep.id WHERE rep.id = $idProd AND rep.tipo = 0;
            ");

            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    if($result2 = $data->fetch_all(MYSQLI_ASSOC)){

                    }else{
                        $result2 = '-';
                    }
                }
            }

            if ($result2) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "caract"=> $result2);
            echo json_encode($response);
        }

        if($action == 'listarRefOemsAndCaractByIdProductoBusqueda' && isset($_GET['idProd']) && $_GET['idProd']  && isset($_GET['marc']) && $_GET['marc']){

            $idMarca = $_GET['marc'];
            $idProd = $_GET['idProd'];
            $query = $cxn_bd->prepare("
            SELECT DISTINCT rep.id as idRepuesto, ref.referencia as refOem FROM refoem as ref JOIN rel_repuestos_refoem as rel1 on ref.id = rel1.idRefOem JOIN ".$idioma."_repuestos as rep on rel1.idRepuesto = rep.id JOIN rel_repuestos_categorias as rel3 ON rep.id = rel3.idRepuesto JOIN rel_refoem_marcas_series_modelo as rel2 ON rel2.idRefOem = rel1.idRefOem WHERE rep.id = $idProd AND rep.tipo = 1 AND rel2.idMarca = $idMarca ; 
            ");
            

            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    if($result = $data->fetch_all(MYSQLI_ASSOC)){

                    }else{
                        $result = '-';
                    }
                }
            }

            $query = $cxn_bd->prepare("
            SELECT caract.alias, rel1.valor FROM ".$idioma."_caracteristicas as caract JOIN rel_repuestos_caracteristicas as rel1 ON caract.id = rel1.idCaracteristica JOIN ".$idioma."_repuestos as rep on rel1.idRepuesto = rep.id WHERE rep.id = $idProd AND rep.tipo = 1;
            ");

            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    if($result2 = $data->fetch_all(MYSQLI_ASSOC)){

                    }else{
                        $result2 = '-';
                    }
                }
            }

            if ($result && $result2) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "refOems"=> $result, "caract"=> $result2);
            echo json_encode($response);
        }

        if($action == 'listarCaractByIdProductoBusquedaAccesorios' && isset($_GET['idProd']) && $_GET['idProd']){


            $idProd = $_GET['idProd'];

            $query = $cxn_bd->prepare("
            SELECT DISTINCT rep.id as idRepuesto, rep.noRefFuster as refOem FROM ".$idioma."_repuestos as rep WHERE rep.id = $idProd AND rep.tipo = 0; 
            ");  

            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    if($result = $data->fetch_all(MYSQLI_ASSOC)){

                    }else{
                        $result = '-';
                    }
                }
            }

            $query = $cxn_bd->prepare("
            SELECT caract.alias, rel1.valor FROM ".$idioma."_caracteristicas as caract JOIN rel_repuestos_caracteristicas as rel1 ON caract.id = rel1.idCaracteristica JOIN ".$idioma."_repuestos as rep on rel1.idRepuesto = rep.id WHERE rep.id = $idProd AND rep.tipo = 0;
            ");

            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    if($result2 = $data->fetch_all(MYSQLI_ASSOC)){

                    }else{
                        $result2 = '-';
                    }
                }
            }

            if ($result && $result2) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "refOems"=> $result, "caract"=> $result2);
            echo json_encode($response);
        }

        if($action == 'listarCategoriasInicio'){
            $result = [];
            $asientos = [];

            $query = $cxn_bd->prepare("Select count(id) as cantidad from rel_repuestos_categorias where idCategoria = 10322 group by idCategoria");
            $query->execute();
            $data = $query->get_result();
            $row = $data->fetch_assoc();
            $cant = $row["cantidad"];
            array_push($asientos, $cant);

            $query = $cxn_bd->prepare("Select count(id) as cantidad from rel_repuestos_categorias where idCategoria = 10323 group by idCategoria");
            $query->execute();
            $data = $query->get_result();
            $row = $data->fetch_assoc();
            $cant = $row["cantidad"];
            array_push($asientos, $cant);

            $query = $cxn_bd->prepare("Select count(id) as cantidad from rel_repuestos_categorias where idCategoria = 10324 group by idCategoria");
            $query->execute();
            $data = $query->get_result();
            $row = $data->fetch_assoc();
            $cant = $row["cantidad"];
            array_push($asientos, $cant);

            $query = $cxn_bd->prepare("SELECT id, nombre, imagen FROM ".$idioma."_categorias WHERE idPadre = 0 ORDER BY nombre");
            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    while($row = $data->fetch_assoc()){
                        if(isset($row["id"])){
                            $idPadre = $row["id"];
                            $nbPadre = $row["nombre"];
                            $imgPadre = $row["imagen"];

                            $query = $cxn_bd->prepare("SELECT count(ca.id) as cantidad, ca.id, ca.nombre FROM ".$idioma."_categorias as ca JOIN rel_repuestos_categorias as re ON ca.id = re.idCategoria WHERE ca.idPadre = $idPadre GROUP BY ca.id ORDER BY ca.nombre");

                            if($query){
                                if($query->execute()){
                                    $data2 = $query->get_result();
                                    $hijos = $data2->fetch_all(MYSQLI_ASSOC); 
                                    $element= array("idPadre"=>$idPadre, "nbPadre"=>$nbPadre, "imgPadre"=>$imgPadre, "hijos"=> $hijos);
                                    array_push($result, $element);
                                }
                            }
                        }
                    }
                }
            }

            if ($result) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $result, "asientos"=> $asientos);
            echo json_encode($response);
        }

        if($action == 'comprobarTipoAccesorioList' && isset($_GET['cat']) && $_GET['cat']){
            $result = [];
            $categoria = $_GET['cat'];

            $query = $cxn_bd->prepare("SELECT tab.idPlano, idCategoria, imagenFondo, ancho, alto, arrayIdProducts, json_tabla  FROM rel_categorias_planos as rel
             JOIN planos on rel.idPlano = planos.id
             JOIN tablacaracteristicas as tab on rel.idPlano = tab.idPlano
             WHERE idCategoria = $categoria"); //test 10939
    
            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    $result = $data->fetch_all(MYSQLI_ASSOC); 
                }
            }

            if ($result) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = '-';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $result);
            echo json_encode($response);
        }

        if($action == 'buscarAccesoriosByIdProducto' && isset($_POST['idCategoria']) && $_POST['idCategoria']){
            $result = [];
            $idCategoria = $_POST['idCategoria'];
            $idProductos = $_POST['idProductos'];

            $idProductos = str_replace( '[', '', $idProductos ); 
            $idProductos = str_replace( ']', '', $idProductos ); 
            $idProductos = trim($idProductos, ',');

            $query = $cxn_bd->prepare("
            SELECT re.id, re.nombre, re.noRefFuster, ".$idioma."_imagenes.thumbnails, ".$idioma."_imagenes.thumbnails_wm FROM ".$idioma."_repuestos as re 
            JOIN rel_repuestos_categorias as rel3 ON re.id = rel3.idRepuesto 
            LEFT JOIN rel_repuestos_imagenes as relimg on relimg.idRepuesto = re.id
          LEFT  JOIN ".$idioma."_imagenes on ".$idioma."_imagenes.id = relimg.idImagen
            WHERE rel3.idCategoria = $idCategoria and re.id IN ($idProductos) and re.tipo = 0 GROUP BY re.id ORDER BY re.nombre asc; 
            ");

            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    $result = $data->fetch_all(MYSQLI_ASSOC); 
                }
            }

            if ($result) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $result);
            echo json_encode($response);
        }

        if($action == 'listarCategoriasByMarca' && isset($_GET['marc']) && $_GET['marc']){
            $result = [];
            $idMarca = $_GET['marc'];
            $query = $cxn_bd->prepare("SELECT id, nombre, imagen FROM ".$idioma."_categorias WHERE idPadre = 0 ORDER BY nombre");
            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    while($row = $data->fetch_assoc()){
                        if(isset($row["id"])){
                            $idPadre = $row["id"];
                            $nbPadre = $row["nombre"];
                            $imgPadre = $row["imagen"];

                            if(isset($_GET["mod"])){
                                $modelos = $_GET["mod"];
                                $modelos = trim($modelos, ',');
                                $query = $cxn_bd->prepare("
                                SELECT count(unionT.idRepuesto) as cantidadRepuestos, unionT.categoriasId, unionT.categorias FROM (
                                    SELECT DISTINCT rep.id as idRepuesto, categorias.id as categoriasId, categorias.nombre as categorias FROM ".$idioma."_repuestos AS rep
                                    JOIN rel_repuestos_categorias AS rel1 ON rel1.idRepuesto = rep.id
                                    JOIN ".$idioma."_categorias AS categorias ON categorias.id = rel1.idCategoria
                                    JOIN rel_repuestos_refoem AS rel2 ON rep.id = rel2.idRepuesto
                                    JOIN rel_refoem_marcas_series_modelo AS rel3 ON rel2.idRefOem = rel3.idRefOem
                                    JOIN modelos on modelos.id = rel3.idModelo
                                    WHERE (categorias.idPadre = $idPadre) AND rel3.idMarca = $idMarca AND modelos.id IN (".$modelos.")
                                    
                                ) as unionT GROUP BY unionT.categoriasId
                                ");

                                
                                //lo quite porq salia asiento mecanico en todo  || categorias.idPadre = 10321
                            }else{
                                $query = $cxn_bd->prepare("
                                SELECT count(unionT.idRepuesto) as cantidadRepuestos, unionT.categoriasId, unionT.categorias FROM (
                                    SELECT DISTINCT rep.id as idRepuesto, categorias.id as categoriasId, categorias.nombre as categorias FROM ".$idioma."_repuestos AS rep
                                    JOIN rel_repuestos_categorias AS rel1 ON rel1.idRepuesto = rep.id
                                    JOIN ".$idioma."_categorias AS categorias ON categorias.id = rel1.idCategoria
                                    JOIN rel_repuestos_refoem AS rel2 ON rep.id = rel2.idRepuesto
                                    JOIN rel_refoem_marcas_series_modelo AS rel3 ON rel2.idRefOem = rel3.idRefOem
                                    WHERE (categorias.idPadre = $idPadre) AND rel3.idMarca = $idMarca
                                   
                                ) as unionT GROUP BY unionT.categoriasId
                                "); 
                                //lo quite porq salia asiento mecanico en todo  || categorias.idPadre = 10321

                            }

                            if($query){
                                if($query->execute()){
                                    $data2 = $query->get_result();
                                    $hijos = $data2->fetch_all(MYSQLI_ASSOC); 
                                    if($idPadre != 11){
                                        $element= array("idPadre"=>$idPadre, "nbPadre"=>$nbPadre, "imgPadre"=>$imgPadre, "hijos"=> $hijos);
                                        array_push($result, $element);
                                    }
                                }
                            }

                            if($idPadre == 11){
                                if(isset($_GET["mod"])){
                                    $modelos = $_GET["mod"];
                                    $modelos = trim($modelos, ',');
                                    $query = $cxn_bd->prepare("
                                    SELECT count(unionT.idRepuesto) as cantidadRepuestos, unionT.categoriasId, unionT.categorias FROM (
                                        SELECT DISTINCT rep.id as idRepuesto, categorias.id as categoriasId, categorias.nombre as categorias FROM ".$idioma."_repuestos AS rep
                                        JOIN rel_repuestos_categorias AS rel1 ON rel1.idRepuesto = rep.id
                                        JOIN ".$idioma."_categorias AS categorias ON categorias.id = rel1.idCategoria
                                        JOIN rel_repuestos_refoem AS rel2 ON rep.id = rel2.idRepuesto
                                        JOIN rel_refoem_marcas_series_modelo AS rel3 ON rel2.idRefOem = rel3.idRefOem
                                        JOIN modelos on modelos.id = rel3.idModelo
                                        WHERE (categorias.idPadre = 10321) AND rel3.idMarca = $idMarca AND modelos.id IN (".$modelos.")
                                        
                                    ) as unionT GROUP BY unionT.categoriasId
                                    ");
                                    //lo quite porq salia asiento mecanico en todo  || categorias.idPadre = 10321
                                }else{
                                    $query = $cxn_bd->prepare("
                                    SELECT count(unionT.idRepuesto) as cantidadRepuestos, unionT.categoriasId, unionT.categorias FROM (
                                        SELECT DISTINCT rep.id as idRepuesto, categorias.id as categoriasId, categorias.nombre as categorias FROM ".$idioma."_repuestos AS rep
                                        JOIN rel_repuestos_categorias AS rel1 ON rel1.idRepuesto = rep.id
                                        JOIN ".$idioma."_categorias AS categorias ON categorias.id = rel1.idCategoria
                                        JOIN rel_repuestos_refoem AS rel2 ON rep.id = rel2.idRepuesto
                                        JOIN rel_refoem_marcas_series_modelo AS rel3 ON rel2.idRefOem = rel3.idRefOem
                                        WHERE (categorias.idPadre = 10321) AND rel3.idMarca = $idMarca
                                        
                                    ) as unionT GROUP BY unionT.categoriasId
                                    "); 
                                    //lo quite porq salia asiento mecanico en todo  || categorias.idPadre = 10321
    
                                }
                                
                                if($query){
                                    if($query->execute()){
                                        $data2 = $query->get_result();
                                        $hijos2 = $data2->fetch_all(MYSQLI_ASSOC); 
                                        $resultadwo = array_merge($hijos, $hijos2);
                                        $element= array("idPadre"=>$idPadre, "nbPadre"=>$nbPadre, "imgPadre"=>$imgPadre, "hijos"=> $resultadwo);
                                        array_push($result, $element);
                                    }
                                }
                            }
                            
                        }
                    }
                }
            }

            if ($result) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $result);
            echo json_encode($response);
        }

        if($action == 'listarCategoriasByMarcaModelo' && isset($_POST['marca']) && $_POST['marca']){
            $marca = trim($_POST['marca']);
            @$modelo = $_POST['modelo'];

            if(@count($modelo)>0){
                $modelo = implode(",", $modelo);
            }

            $result = [];
            $query = $cxn_bd->prepare("SELECT id, nombre, imagen FROM ".$idioma."_categorias WHERE idPadre = 0 ORDER BY nombre");
            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    while($row = $data->fetch_assoc()){
                        if(isset($row["id"])){
                            $idPadre = $row["id"];
                            $nbPadre = $row["nombre"];
                            $imgPadre = $row["imagen"];

                            $query = $cxn_bd->prepare("
                            SELECT count(unionT.idRepuesto) as cantidadRepuestos, unionT.categoriasId, unionT.categorias FROM (
                                SELECT rep.id as idRepuesto, categorias.id as categoriasId, categorias.nombre as categorias FROM ".$idioma."_repuestos AS rep
                                JOIN rel_repuestos_categorias AS rel1 ON rel1.idRepuesto = rep.id
                                JOIN ".$idioma."_categorias AS categorias ON categorias.id = rel1.idCategoria
                                JOIN rel_repuestos_refoem AS rel2 ON rep.id = rel2.idRepuesto
                                JOIN rel_refoem_marcas_series_modelo AS rel3 ON rel2.idRefOem = rel3.idRefOem
                                JOIN modelos on modelos.id = rel3.idModelo
                                WHERE (categorias.idPadre = $idPadre || categorias.idPadre = 10321) AND rel3.idMarca = $marca AND modelos.id IN (".$modelo.")
                                GROUP BY rep.id
                            ) as unionT GROUP BY unionT.categoriasId
                            ");

                            if($query){
                                if($query->execute()){
                                    $data2 = $query->get_result();
                                    $hijos = $data2->fetch_all(MYSQLI_ASSOC); 
                                    $element= array("idPadre"=>$idPadre, "nbPadre"=>$nbPadre, "imgPadre"=>$imgPadre, "hijos"=> $hijos);
                                    array_push($result, $element);
                                }
                            }
                        }
                    }
                }
            }

            if ($result) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $result);
            echo json_encode($response);
        }

        if($action == 'detalleProducto' && isset($_GET['idProd']) && $_GET['idProd'] && isset($_GET['idMarc']) && $_GET['idMarc']){
            $result = [];
            $idProd = $_GET['idProd'];
            $idMarca = $_GET['idMarc'];

            $query = $cxn_bd->prepare("
            SELECT listado.*, cat2.nombre as catPadre, cat2.id as idPadre FROM ( SELECT rep.nombre, rep.esKit, rep.refComp, rep.noRefFuster, refoem.referencia as refOem, cat.nombre as categoria, cat.id as idCategoria, cat.idRaiz as idRaiz, cat.idPadre as idP, marcas.marca, series.serie, modelos.modelo, modelos.id as idMod FROM ".$idioma."_repuestos as rep JOIN rel_repuestos_refoem as rel1 ON rel1.idRepuesto = rep.id JOIN refoem ON refoem.id = rel1.idRefOem JOIN rel_refoem_marcas_series_modelo as rel2 ON rel1.idRefOem = rel2.idRefOem JOIN marcas ON marcas.id = rel2.idMarca JOIN series ON series.id = rel2.idSerie JOIN modelos ON modelos.id = rel2.idModelo 
            JOIN rel_repuestos_categorias as rel3 ON rel3.idRepuesto = rep.id 
            JOIN ".$idioma."_categorias as cat ON cat.id = rel3.idCategoria 
            WHERE rep.id = ".$idProd." AND rep.tipo = 1 AND marcas.id = ".$idMarca." AND rel3.tipoProd = 1) as listado JOIN ".$idioma."_categorias as cat2 ON listado.idP = cat2.id ORDER BY listado.refOem, listado.serie, listado.modelo ASC ; 
            ");

            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 
                    $result = $data;
                }
            }

            if ($result) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $result);
            echo json_encode($response);
        }
        
        if($action == 'dibujarDespiece' && isset($_GET['idProd']) && $_GET['idProd'] && isset($_GET['idMarc']) && $_GET['idMarc']){
            $result = [];
            $idProd = $_GET['idProd'];
            $idMarca = $_GET['idMarc'];

            $query = $cxn_bd->prepare("
            SELECT ref.referencia as referencia FROM refoem as ref 
            join rel_repuestos_refoem as rel1 on rel1.idRefOem = ref.id 
            join ".$idioma."_repuestos on rel1.idRepuesto = ".$idioma."_repuestos.id             
            join rel_refoem_marcas_series_modelo as rel4 on rel4.idRefOem = rel1.idRefOem
            where rel1.idRepuesto = $idProd and ".$idioma."_repuestos.tipo = 1 and rel4.idMarca=$idMarca;");
            $cantidad = 0; //1158
            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC);
                    $dataAux = [];

                    for ($i=0; $i < count($data); $i++) { 
                        $listado = $data[$i];

                        if(count($dataAux) == 0){
                            array_push($dataAux, $listado['referencia']);
                        }else{
                            $encontrado = -1;
                            for ($j=0; $j < count($dataAux); $j++) { 
                                if($dataAux[$j] == $listado['referencia']){
                                    $encontrado = 1;
                                }
                            }

                            if($encontrado == -1){
                                array_push($dataAux, $listado['referencia']);
                            }
                        }
                    }

                    for ($i=0; $i < count($dataAux); $i++) { 
                        $ref = $dataAux[$i];
                        $cantidad++;
                        $query = $cxn_bd->prepare("
                        SELECT * FROM puntosinteres join planos on planos.id = puntosinteres.idPlano where arrayRefFuster like '%\"$ref\"%';");
                        if($query){
                            if($query->execute()){
                                $queryData = $query->get_result();
                                if($queryData->num_rows > 0){
                                   
                                    $data2 = $queryData->fetch_all(MYSQLI_ASSOC);
                                    for ($j=0; $j < count($data2) ; $j++) { 
                                        $row = $data2[$j];
                                        $cant = 0;
                                        if(count($result)>0){
                                            for ($h=0; $h < count($result); $h++) { 
                                                if($row['idPlano'] == $result[$h]['idPlano']){
                                                    $cant++;
                                                }
                                            }
                                            if($cant == 0){
                                                array_push($result, $data2[$j]);
                                            }
                                        }else{
                                            array_push($result, $data2[$j]);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $puntosInteres = [];
                    for ($i=0; $i < count($result); $i++) { 
                        $id = $result[$i]['idPlano'];
                        $query = $cxn_bd->prepare("
                        SELECT * FROM puntosinteres where idPlano = $id;");
                        if($query){
                            if($query->execute()){
                                $queryData = $query->get_result();
                                $data2 = $queryData->fetch_all(MYSQLI_ASSOC);
                                array_push($puntosInteres, $data2);
                            }
                        }
                    }
                }
            }

            if ($result) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $result, "puntosInteres"=> $puntosInteres);
            echo json_encode($response);
        }

        if($action == 'dibujarDibujoTecnicoAccesorio' && isset($_GET['idProd']) && $_GET['idProd']){
            $result = [];
            $idProd = $_GET['idProd'];
            $puntosInteres = [];
            $query = $cxn_bd->prepare("
            SELECT noRefFuster as referencia FROM ".$idioma."_repuestos             
            where ".$idioma."_repuestos.id = $idProd and ".$idioma."_repuestos.tipo = 0;");
            $cantidad = 0; 
            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC);
                    $dataAux = [];

                    for ($i=0; $i < count($data); $i++) { 
                        $listado = $data[$i];

                        if(count($dataAux) == 0){
                            array_push($dataAux, $listado['referencia']);
                        }else{
                            $encontrado = -1;
                            for ($j=0; $j < count($dataAux); $j++) { 
                                if($dataAux[$j] == $listado['referencia']){
                                    $encontrado = 1;
                                }
                            }

                            if($encontrado == -1){
                                array_push($dataAux, $listado['referencia']);
                            }
                        }
                    }

                    for ($i=0; $i < count($dataAux); $i++) { 
                        $ref = $dataAux[$i];
                        $cantidad++;
                        $query = $cxn_bd->prepare("
                        SELECT * FROM puntosinteres join planos on planos.id = puntosinteres.idPlano where arrayRefFuster like '%\"$ref\"%';");

                        if($query){
                            if($query->execute()){
                                $queryData = $query->get_result();
                                if($queryData->num_rows > 0){
                                   
                                    $data2 = $queryData->fetch_all(MYSQLI_ASSOC);
                                    for ($j=0; $j < count($data2) ; $j++) { 
                                        $row = $data2[$j];
                                        $cant = 0;
                                        if(count($result)>0){
                                            for ($h=0; $h < count($result); $h++) { 
                                                if($row['idPlano'] == $result[$h]['idPlano']){
                                                    $cant++;
                                                }
                                            }
                                            if($cant == 0){
                                                array_push($result, $data2[$j]);
                                            }
                                        }else{
                                            array_push($result, $data2[$j]);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $puntosInteres = [];
                    for ($i=0; $i < count($result); $i++) { 
                        $id = $result[$i]['idPlano'];
                        $query = $cxn_bd->prepare("
                        SELECT * FROM puntosinteres where idPlano = $id;");
                        if($query){
                            if($query->execute()){
                                $queryData = $query->get_result();
                                $data2 = $queryData->fetch_all(MYSQLI_ASSOC);
                                array_push($puntosInteres, $data2);
                            }
                        }
                    }
                }
            }

            if ($result) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $result, "puntosInteres"=> $puntosInteres);
            echo json_encode($response);
        }

        if($action == 'dibujarEmbrague' && isset($_GET['idProd']) && $_GET['idProd'] && isset($_GET['idMarc']) && $_GET['idMarc']){
            $result = [];            
            $nombre = [];
            $idProd = $_GET['idProd'];
            $idMarca = $_GET['idMarc'];

            $query = $cxn_bd->prepare("
            SELECT ref.referencia as referencia FROM refoem as ref 
            join rel_repuestos_refoem as rel1 on rel1.idRefOem = ref.id 
            join ".$idioma."_repuestos on rel1.idRepuesto = ".$idioma."_repuestos.id             
            join rel_refoem_marcas_series_modelo as rel4 on rel4.idRefOem = rel1.idRefOem
            where rel1.idRepuesto = $idProd and ".$idioma."_repuestos.tipo = 1 and rel4.idMarca=$idMarca group by referencia;
            ");
            $cantidad = 0;
            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
		    $data = $queryData->fetch_all(MYSQLI_ASSOC);
//		    print_r($data);exit;
                    $dataAux = [];

                    for ($i=0; $i < count($data); $i++) { 
                        $listado = $data[$i];

                        if(count($dataAux) == 0){
                            array_push($dataAux, $listado['referencia']);
                        }else{
                            $encontrado = -1;
                            for ($j=0; $j < count($dataAux); $j++) { 
                                if($dataAux[$j] == $listado['referencia']){
                                    $encontrado = 1;
                                }
                            }

                            if($encontrado == -1){
                                array_push($dataAux, $listado['referencia']);
                            }
                        }
                    }

                    for ($i=0; $i < count($dataAux); $i++) { 
                        $ref = $dataAux[$i];
                        $cantidad++;
                        $query = $cxn_bd->prepare("
                        SELECT * FROM embragues where referencias like '%$ref%' and marca=$idMarca;");
                        if($query){
                            if($query->execute()){

                                $queryData = $query->get_result();
                                if($queryData->num_rows > 0){

                                    $data2 = $queryData->fetch_all(MYSQLI_ASSOC);
                                    $c = 0;


                                    for ($j=0; $j < count($data2) ; $j++) { 
                                        $nombreEmbrague = $data2[$j]['nombre'];

                                        $reff = explode('*',$data2[$j]['referencias']);
                                        unset($reff[0]);
                                        $reff = array_values($reff);
                                        $reff = implode("','",$reff);

                                        $query = $cxn_bd->prepare("SELECT re.id, re.nombre, re2.nombre as nbesp, ".$idioma."_imagenes.thumbnails, refoem.referencia, re.noRefFuster, cat.id as idCategoria, cat.nombre as nombreCategoria  FROM ".$idioma."_repuestos as re
                                        JOIN rel_repuestos_refoem ON re.id = rel_repuestos_refoem.idRepuesto 
                                        JOIN refoem ON refoem.id = rel_repuestos_refoem.idRefOem 
                                        JOIN rel_repuestos_categorias as relca on relca.idRepuesto = re.id
                                        JOIN ".$idioma."_categorias as cat on cat.id = relca.idCategoria
                                        JOIN rel_repuestos_imagenes as relimg on relimg.idRepuesto = re.id
                                        JOIN ".$idioma."_imagenes on ".$idioma."_imagenes.id = relimg.idImagen
                                        JOIN es_repuestos as re2 on re.id = re2.id
                                        WHERE (refoem.referencia IN ('".$reff."') OR re.noRefFuster IN ('".$reff."')) and re.tipo = 1 and relca.tipoProd = 1 group by re.id;
                                        ");

                                        if($query->execute()){
                                            $queryData3 = $query->get_result();
                                            if($queryData3->num_rows > 0){
                                                $data3 = $queryData3->fetch_all(MYSQLI_ASSOC);
                                                array_push($result, $data3);
                                                array_push($nombre, $nombreEmbrague);
                                            }
                                        }

                                    }
                                }
                            }
                        }
                    }

                    
                }
            }

            if ($result) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

	    $response= array("code"=>$code,"msg"=>$msg, "result"=> $result , "nombre"=> $nombre);
            echo json_encode($response);
        }
        
        if($action == 'listarCategoriasAccesorios'){
            $result = [];
            $familiaFinal = [];
            $idBuscar = 13;
            $result = esArbol($idBuscar, $cxn_bd, $idioma);

            // print_r($result);

            $id10= 0;  $id9= 0;  $id8= 0;  $id7= 0;  $id6= 0;  $id5= 0;  $id4= 0;  $id3= 0;  $id2= 0;  $id1 = 0;  
            for ($i=0; $i < count($result); $i++) { 
                $idAnalizar = $result[$i]['id'];
                $nombre = $result[$i]['nombre'];
                $hijos = json_encode($result[$i]['hijos']);
                $padress = '';
                $id10 = construirPadre($idAnalizar, $cxn_bd, $idioma);
                //print_r($id10);echo "------------<br>";

                if($id10){
					//echo "****a*****<br><br><br>";
					$aux = json_decode($id10);
                    $padress .= $aux->nombre;
					//print_r($padress);echo "***********<br><br><br>";

                    $id9 = construirPadre($aux->id, $cxn_bd, $idioma);
                    if($id9){$aux = json_decode($id9);
                        $padress .= ','. $aux->nombre;
                        $id8 = construirPadre($aux->id, $cxn_bd, $idioma);
                        if($id8){$aux = json_decode($id8);
                            $padress .= ','. $aux->nombre;
                            $id7 = construirPadre($aux->id, $cxn_bd, $idioma);
                            if($id7){$aux = json_decode($id7);
                                $padress .= ','. $aux->nombre;
                                $id6 = construirPadre($aux->id, $cxn_bd, $idioma);
                                if($id6){$aux = json_decode($id6);
                                    $padress .= ','. $aux->nombre;
                                    $id5 = construirPadre($aux->id, $cxn_bd, $idioma);
                                    if($id5){$aux = json_decode($id5);
                                        $padress .= ','. $aux->nombre;
                                        $id4 = construirPadre($aux->id, $cxn_bd, $idioma);
                                        if($id4){$aux = json_decode($id4);
                                            $padress .= ','. $aux->nombre;
                                            $id3 = construirPadre($aux->id, $cxn_bd, $idioma);
                                            if($id3){$aux = json_decode($id3);
                                                $padress .= ','. $aux->nombre;
                                                $id2 = construirPadre($aux->id, $cxn_bd, $idioma);
                                                if($id2){
                                                    $aux = json_decode($id2);
                                                    $padress .= ','. $aux->nombre;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                

                array_push($familiaFinal, '{
                    "padres": "'.$padress.'",
                    "idCategoria": '.$idAnalizar.',
                    "nombre": "'.$nombre.'",
                    "hijos": '.$hijos.'
                }');

                
            }

            $result = $familiaFinal;

            if ($result) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $result);
            echo json_encode($response);
        }

        if($action == 'categoriasHijas'){

            $result = [];
            $idCategoria = $_GET['idCategoria'];

            $query = $cxn_bd->prepare("SELECT * FROM ".$idioma."_categorias where idPadre = $idCategoria order by nombre");

            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 
                    $result = $data;
                }
            }

            if ($result) {
                $msg = 'Consulta ejecutada con exito';
                $code = 1;
            }else{
                $msg = 'Error al ejecutar consulta';
                $code = 2;
            }
            
            $response= array("code"=>$code,"msg"=>$msg, "result"=> $result);
            echo json_encode($response);
        }

        if($action == 'buscarRefSelect'){
            $data = [];
            $query = '';
            if(isset($_GET['q'])){
                $busqueda = trim($_GET['q']);
                $query = $cxn_bd->prepare("(SELECT referencia as 'id', referencia as 'text' 
                FROM refoem JOIN rel_repuestos_refoem ON refoem.id = rel_repuestos_refoem.idRefOem 
                where referencia LIKE '%$busqueda%' LIMIT 50)
                UNION 
                (SELECT noRefFuster as 'id', noRefFuster as 'text' 
                FROM ".$idioma."_repuestos where noRefFuster LIKE '%$busqueda%' order by text asc LIMIT 50) order by text asc;");
            }else{
                $query = $cxn_bd->prepare("(SELECT referencia as 'id', referencia as 'text' 
                FROM refoem JOIN rel_repuestos_refoem ON refoem.id = rel_repuestos_refoem.idRefOem LIMIT 50)
                UNION 
                (SELECT noRefFuster as 'id', noRefFuster as 'text' 
                FROM ".$idioma."_repuestos order by text asc LIMIT 50) order by text asc; ");
            }
            
            // EN LAS CONSULTAS EL ORDER BY PONER : CAST(text as INT)
            
            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 
                }
            }


            $arrayNumero = [];
            $arrayOtros = [];
            $arrayFinal = [];
            for ($i=0; $i < count($data); $i++) { 
                if(is_numeric($data[$i]['text'])){
                    array_push($arrayNumero, $data[$i]);
                }else{
                    array_push($arrayOtros, $data[$i]);
                }
            }

            for ($i=0; $i < count($arrayNumero) ; $i++) { 
                array_push($arrayFinal, $arrayNumero[$i]);
            }

            for ($i=0; $i < count($arrayOtros) ; $i++) { 
                array_push($arrayFinal, $arrayOtros[$i]);
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $arrayFinal);
            echo json_encode($response);
        }

        if($action == 'buscarNombreProducto'){
            $data = [];
            $query = '';
            if(isset($_GET['q'])){
                $busqueda = trim($_GET['q']);
                $query = $cxn_bd->prepare("SELECT nombre as 'id', nombre as 'text' FROM ".$idioma."_repuestos where nombre LIKE '%$busqueda%' group by nombre order by nombre");
            }else{
                $query = $cxn_bd->prepare("SELECT nombre as 'id', nombre as 'text' FROM ".$idioma."_repuestos where tipo = 1 group by nombre order by nombre");
            }

            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 
                }
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $data);
            echo json_encode($response);
        }

        if($action == 'buscarNombreProductoByMarca'){
            $data = [];
            $query = '';
            $marca =  trim($_GET['marca']);

            if(isset($_GET['q'])){
                $busqueda = trim($_GET['q']);
                $result = preg_replace('/ de la | de los | de | y | con | la  | el | lo | del  | los  | las  | para  | por  | contra  | desde  | en  | durante  | entre  | hacia | hasta  | mediante  | para  | sin  | sobre /m'," ", $busqueda);
                $stringSeparado = explode(' ', $result);
                $strgQ = "( ";
                for ($i=0; $i < count($stringSeparado); $i++) { 
                    if(count($stringSeparado)>1){
                        if($i < count($stringSeparado)-1){
                            $strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" AND ';
                        }else{
                            $strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" ';
                        }
                    }else{$strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" ';}  
                }
                $strgQ .= " )";
                
                $query = $cxn_bd->prepare("SELECT re.nombre as 'id', re.nombre as 'text' FROM ".$idioma."_repuestos  as re
                JOIN rel_repuestos_refoem ON re.id = rel_repuestos_refoem.idRepuesto 
                JOIN refoem ON refoem.id = rel_repuestos_refoem.idRefOem 
                JOIN rel_refoem_marcas_series_modelo as rel on refoem.id = rel.idRefOem
                JOIN marcas on marcas.id = rel.idMarca
                WHERE $strgQ and marcas.id = $marca and re.tipo = 1 group by re.nombre order by re.nombre;
                ");
            }else{
                $query = $cxn_bd->prepare("SELECT re.nombre as 'id', re.nombre as 'text' FROM ".$idioma."_repuestos  as re
                JOIN rel_repuestos_refoem ON re.id = rel_repuestos_refoem.idRepuesto 
                JOIN refoem ON refoem.id = rel_repuestos_refoem.idRefOem 
                JOIN rel_refoem_marcas_series_modelo as rel on refoem.id = rel.idRefOem
                JOIN marcas on marcas.id = rel.idMarca
                WHERE marcas.id = $marca and re.tipo = 1 group by re.nombre order by re.nombre;");
            }

            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 
                }
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $data);
            echo json_encode($response);
        }

        if($action == 'buscarNombreMarca'){
            $data = [];
            if(isset($_GET['q'])){
                $busqueda = trim($_GET['q']);
                $query = $cxn_bd->prepare("SELECT id, marca as 'text' FROM marcas where marca LIKE '%$busqueda%' and marcas.id <> 9136 and marcas.id <> 220 order by marca");
            }else{
                $query = $cxn_bd->prepare("SELECT id, marca as 'text' FROM marcas where marcas.id <> 9136 and marcas.id <> 220 order by marca");
            }

            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 
                }
            }

            $a = array('id' => -1, 'text'=> 'ACCESORIOS' );
            array_unshift($data, $a);

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $data);
            echo json_encode($response);
        }

        if($action == 'buscarModeloByNombreyMarca'){
            $data = [];
            $query = '';
            $marca = trim($_GET['marca']);

            if(isset($_GET['q'])){
                $busqueda = trim($_GET['q']);
                if($marca == '-'){
                    $query = $cxn_bd->prepare("SELECT modelos.id, modelo as 'text', series.serie FROM modelos JOIN rel_series_modelos on rel_series_modelos.idModelo = modelos.id JOIN series on rel_series_modelos.idSerie = series.id where modelo LIKE '%$busqueda%' group by modelos.id order by modelo");
                }else{
                    $query = $cxn_bd->prepare("SELECT modelos.id, modelo as 'text', series.serie FROM modelos JOIN rel_series_modelos on rel_series_modelos.idModelo = modelos.id JOIN series on rel_series_modelos.idSerie = series.id join rel_refoem_marcas_series_modelo as rel1 on rel1.idModelo = modelos.id where modelo LIKE '%$busqueda%' and rel1.idMarca = $marca group by modelos.id  order by modelo");
                }
            }else{
                if($marca == '-'){
                    $query = $cxn_bd->prepare("SELECT modelos.id, modelo as 'text', series.serie FROM modelos JOIN rel_series_modelos on rel_series_modelos.idModelo = modelos.id JOIN series on rel_series_modelos.idSerie = series.id group by modelos.id order by modelo;");
                }else{
                    $query = $cxn_bd->prepare("SELECT modelos.id, modelo as 'text', series.serie FROM modelos JOIN rel_series_modelos on rel_series_modelos.idModelo = modelos.id JOIN series on rel_series_modelos.idSerie = series.id join rel_refoem_marcas_series_modelo as rel1 on rel1.idModelo = modelos.id where rel1.idMarca = $marca group by modelos.id  order by modelo");
                }
            }
            
            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 


                    $arraySeries = [];
                    for ($i=0; $i < count($data) ; $i++) { 
                       if(count($arraySeries) == 0){
                        array_push($arraySeries, $data[$i]['serie'] );
                       }else{
                            $encontro = false;
                            for ($j=0; $j < count($arraySeries); $j++) { 
                                if($arraySeries[$j] == $data[$i]['serie']){
                                    $encontro = true;
                                }
                            }

                            if(!$encontro){
                                array_push($arraySeries, $data[$i]['serie'] );
                            }
                       }
                    }


                    $arrayFinal = '[';

                    for ($i=0; $i < count($arraySeries); $i++) { 
                        $aux = '';
                        for ($j=0; $j < count($data) ; $j++) { 
                            if($data[$j]['serie'] == $arraySeries[$i]){
                                $id = $data[$j]['id'];
                                $text = $data[$j]['text'];
                                $aux .= '{ "id": "'.$id.'", "text": "'.$text.'" },';
                            }
                        }

                        $aux = trim($aux, ',');

                        $serie = $arraySeries[$i];
                        $arrayFinal .= '{"text": "'.$serie.'","children": ['.$aux.']},';
                    }

                    $arrayFinal = trim($arrayFinal, ',');
                    $arrayFinal .= ']';
                }
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $arrayFinal);
            echo json_encode($response);
        }

        if($action == 'buscarModeloByNombreProdyMarca'){
            $data = [];
            $query = '';
            $marca = trim($_GET['marca']);
            $producto = trim($_GET['producto']);
            $result = preg_replace('/ de la | de los | de | y | con | la  | el | lo | del  | los  | las  | para  | por  | contra  | desde  | en  | durante  | entre  | hacia | hasta  | mediante  | para  | sin  | sobre /m'," ", $producto);
            $stringSeparado = explode(' ', $result);
            $strgQ = "( ";
            for ($i=0; $i < count($stringSeparado); $i++) { 
                if(count($stringSeparado)>1){
                    if($i < count($stringSeparado)-1){
                        $strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" AND ';
                    }else{
                        $strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" ';
                    }
                }else{$strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" ';}  
            }
            $strgQ .= " )";
            if(isset($_GET['q'])){
                $busqueda = trim($_GET['q']);
                $query = $cxn_bd->prepare("SELECT modelos.id, modelo as 'text', series.serie FROM modelos JOIN rel_series_modelos on rel_series_modelos.idModelo = modelos.id JOIN series on rel_series_modelos.idSerie = series.id
                join rel_refoem_marcas_series_modelo as rel1 on rel1.idModelo = modelos.id
                JOIN rel_repuestos_refoem as rel2 on rel2.idRefOem = rel1.idRefOem
                JOIN ".$idioma."_repuestos as re on re.id = rel2.idRepuesto
                where modelo LIKE '%$busqueda%' and $strgQ and rel1.idMarca = $marca group by modelo  order by modelo
                ");
            }else{
                $query = $cxn_bd->prepare("SELECT modelos.id, modelo as 'text', series.serie FROM modelos JOIN rel_series_modelos on rel_series_modelos.idModelo = modelos.id JOIN series on rel_series_modelos.idSerie = series.id
                join rel_refoem_marcas_series_modelo as rel1 on rel1.idModelo = modelos.id 
                JOIN rel_repuestos_refoem as rel2 on rel2.idRefOem = rel1.idRefOem
                JOIN ".$idioma."_repuestos as re on re.id = rel2.idRepuesto
                where rel1.idMarca = $marca and $strgQ group by modelo  order by modelo");
            }
            
            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 

                    $arraySeries = [];
                    for ($i=0; $i < count($data) ; $i++) { 
                       if(count($arraySeries) == 0){
                        array_push($arraySeries, $data[$i]['serie'] );
                       }else{
                            $encontro = false;
                            for ($j=0; $j < count($arraySeries); $j++) { 
                                if($arraySeries[$j] == $data[$i]['serie']){
                                    $encontro = true;
                                }
                            }

                            if(!$encontro){
                                array_push($arraySeries, $data[$i]['serie'] );
                            }
                       }
                    }


                    $arrayFinal = '[';

                    for ($i=0; $i < count($arraySeries); $i++) { 
                        $aux = '';
                        for ($j=0; $j < count($data) ; $j++) { 
                            if($data[$j]['serie'] == $arraySeries[$i]){
                                $id = $data[$j]['id'];
                                $text = $data[$j]['text'];
                                $aux .= '{ "id": "'.$id.'", "text": "'.$text.'" },';
                            }
                        }

                        $aux = trim($aux, ',');

                        $serie = $arraySeries[$i];
                        $arrayFinal .= '{"text": "'.$serie.'","children": ['.$aux.']},';
                    }

                    $arrayFinal = trim($arrayFinal, ',');
                    $arrayFinal .= ']';
                }
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $arrayFinal);
            echo json_encode($response);
        }

        if($action == 'buscarMarcaByNombre'){    
            $data = [];
            $query = '';
            $nombre = trim($_GET['nombre']);
            
            if(isset($_GET['q']) && $_GET['q']){
                $busqueda = $_GET['q'];
                if($nombre == '-'){
                    $query = $cxn_bd->prepare("SELECT id, marca as 'text' FROM marcas where marca LIKE '%$busqueda%' order by marca");
                }else{
                    $result = preg_replace('/ de la | de los | de | y | con | la  | el | lo | del  | los  | las  | para  | por  | contra  | desde  | en  | durante  | entre  | hacia | hasta  | mediante  | para  | sin  | sobre /m'," ", $nombre);
                    $stringSeparado = explode(' ', $result);
                    $strgQ = "( ";
                    for ($i=0; $i < count($stringSeparado); $i++) { 
                        if(count($stringSeparado)>1){
                            if($i < count($stringSeparado)-1){
                                $strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" AND ';
                            }else{
                                $strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" ';
                            }
                        }else{$strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" ';}       
                    }
                    $strgQ .= " )";
                    $query = $cxn_bd->prepare(
                        "SELECT marcas.id, marca as 'text' FROM marcas 
                        JOIN rel_refoem_marcas_series_modelo as rel1 on rel1.idMarca = marcas.id 
                        JOIN rel_repuestos_refoem as rel2 on rel2.idRefOem = rel1.idRefOem
                        JOIN ".$idioma."_repuestos as re on re.id = rel2.idRepuesto
                        where $strgQ and marca LIKE '%$busqueda%' GROUP by marca order by marca"
                        );
                }
            }else{
                if($nombre == '-'){
                    $query = $cxn_bd->prepare("SELECT id, marca as 'text' FROM marcas order by marca");
                }else{
                    $result = preg_replace('/ de la | de los | de | y | con | la  | el | lo | del  | los  | las  | para  | por  | contra  | desde  | en  | durante  | entre  | hacia | hasta  | mediante  | para  | sin  | sobre /m'," ", $nombre);
                    $stringSeparado = explode(' ', $result);
                    
                    $strgQ = "( ";
                    for ($i=0; $i < count($stringSeparado); $i++) { 
                        if(count($stringSeparado)>1){
                            if($i < count($stringSeparado)-1){
                                $strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" AND ';
                            }else{
                                $strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" ';
                            }
                        }else{$strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" ';}            
                    }
                    $strgQ .= " )";

                    $query = $cxn_bd->prepare("SELECT marcas.id, marca as 'text' FROM marcas 
                    JOIN rel_refoem_marcas_series_modelo as rel1 on rel1.idMarca = marcas.id 
                    JOIN rel_repuestos_refoem as rel2 on rel2.idRefOem = rel1.idRefOem
                    JOIN ".$idioma."_repuestos as re on re.id = rel2.idRepuesto
                    where $strgQ GROUP by marca order by marca");
                }
            }
            
            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 
                }
            }

            $data22 = [];
            $query = '';
            $producto = trim($_GET['nombre']);

            $result = preg_replace('/ de la | de los | de | y | con | la  | el | lo | del  | los  | las  | para  | por  | contra  | desde  | en  | durante  | entre  | hacia | hasta  | mediante  | para  | sin  | sobre /m'," ", $producto);
            $stringSeparado = explode(' ', $result);
            $strgQ = "( ";
            for ($i=0; $i < count($stringSeparado); $i++) { 
                if(count($stringSeparado)>1){
                    if($i < count($stringSeparado)-1){
                        $strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" AND ';
                    }else{
                        $strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" ';
                    }
                }else{$strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" ';}            
            }
            $strgQ .= " )";

            $query = $cxn_bd->prepare("SELECT re.id, re.nombre, re.noRefFuster, ".$idioma."_categorias.id as idCat, ".$idioma."_categorias.nombre as nbCategoria, ".$idioma."_imagenes.thumbnails
            FROM ".$idioma."_repuestos  as re
            JOIN rel_repuestos_categorias as rel4 on rel4.idRepuesto = re.id
            JOIN ".$idioma."_categorias ON ".$idioma."_categorias.id = rel4.idCategoria
            LEFT JOIN rel_repuestos_imagenes as relimg on relimg.idRepuesto = re.id
            LEFT  JOIN ".$idioma."_imagenes on ".$idioma."_imagenes.id = relimg.idImagen
            WHERE $strgQ and re.tipo = 0  and rel4.tipoProd = 0 group by re.id LIMIT 1;
            ");
            
            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data22 = $queryData->fetch_all(MYSQLI_ASSOC); 
                    if(count($data22)>0){
                        $a = array('id' => -1, 'text'=> 'ACCESORIOS' );
                        array_unshift($data, $a);
                    }
                }
            }
            
            $response= array("code"=>$code,"msg"=>$msg, "result"=> $data);
            echo json_encode($response);
        }

        if($action == 'buscarByRefOem'){
            $data = [];
            $query = '';
            $refOem = trim($_POST['refOem']);
            
            $refComp1 = ','.$refOem;
            $refComp11 = ', '.$refOem;

            $refComp2 = $refOem.',';
            $refComp3 = ','.$refOem.',';
            $refComp33 = ', '.$refOem.',';


            $query = $cxn_bd->prepare("SELECT listado.*, cat2.nombre as catPadre, cat2.id as idPadre FROM ( SELECT distinct re.id, re.nombre, re.noRefFuster, marcas.marca as nbMarca, marcas.id as idMar, ".$idioma."_categorias.id as idCat, ".$idioma."_categorias.idPadre as idP, ".$idioma."_categorias.nombre as nbCategoria, ".$idioma."_imagenes.thumbnails FROM ".$idioma."_repuestos  as re
            JOIN rel_repuestos_refoem ON re.id = rel_repuestos_refoem.idRepuesto 
            JOIN refoem ON refoem.id = rel_repuestos_refoem.idRefOem 
            JOIN rel_refoem_marcas_series_modelo as rel on refoem.id = rel.idRefOem
            JOIN marcas on marcas.id = rel.idMarca
            JOIN rel_repuestos_categorias as rel4 on rel4.idRepuesto = re.id
            JOIN ".$idioma."_categorias ON ".$idioma."_categorias.id = rel4.idCategoria
            LEFT JOIN rel_repuestos_imagenes as relimg on relimg.idRepuesto = re.id
            LEFT  JOIN ".$idioma."_imagenes on ".$idioma."_imagenes.id = relimg.idImagen
            WHERE (refoem.referencia = '$refOem' OR re.noRefFuster= '$refOem' OR re.refComp LIKE '%$refComp1' OR re.refComp LIKE '%$refComp11' OR re.refComp LIKE '$refComp2%' OR re.refComp LIKE '%$refComp3%' OR re.refComp LIKE '%$refComp33%') and re.tipo = 1  and rel4.tipoProd = 1 and relimg.principal = 1
            and (
                ".$idioma."_categorias.nombre not like '%Conjunto Embrague%' 
                and ".$idioma."_categorias.nombre not like '%Clutch Ensemble%' 
                and ".$idioma."_categorias.nombre not like '%Cto. Embrague%' 
                and ".$idioma."_categorias.nombre not like '%Cto.Embrague%'
                and ".$idioma."_categorias.nombre not like '%Ensemble Embrayage%'
                )
           ) as listado JOIN ".$idioma."_categorias as cat2 ON listado.idP = cat2.id");
            //group by marcas.marca pifia
            
            
            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 
                }
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $data);
            echo json_encode($response);
        }

        if($action == 'buscarByRefOemConjunto'){
            $data = [];
            $query = '';

            $refOem = explode('*',$_POST['refOem']);

            for ($i=1; $i < count($refOem) ; $i++) { 
                $ref = $refOem[$i];

                $refComp1 = ','.$ref;
                $refComp2 = $ref.',';
                $refComp3 = ','.$ref.',';
                $refComp11 = ', '.$ref;
                $refComp33 = ', '.$ref.',';

                
                $query = $cxn_bd->prepare("SELECT re.id, re.nombre, ".$idioma."_imagenes.thumbnails, re.noRefFuster, marcas.marca as nbMarca, marcas.id as idMar, ".$idioma."_categorias.id as idCat, ".$idioma."_categorias.nombre as nbCategoria FROM ".$idioma."_repuestos  as re
                JOIN rel_repuestos_refoem ON re.id = rel_repuestos_refoem.idRepuesto 
                JOIN refoem ON refoem.id = rel_repuestos_refoem.idRefOem 
                JOIN rel_refoem_marcas_series_modelo as rel on refoem.id = rel.idRefOem
                JOIN marcas on marcas.id = rel.idMarca
                JOIN rel_repuestos_categorias as rel4 on rel4.idRepuesto = re.id
                JOIN ".$idioma."_categorias ON ".$idioma."_categorias.id = rel4.idCategoria
                JOIN rel_repuestos_imagenes as relimg on relimg.idRepuesto = re.id
                JOIN ".$idioma."_imagenes on ".$idioma."_imagenes.id = relimg.idImagen
                WHERE (refoem.referencia = '$ref' OR re.noRefFuster= '$ref' OR re.refComp LIKE '%$refComp1' OR re.refComp LIKE '%$refComp11' OR re.refComp LIKE '$refComp2%' OR re.refComp LIKE '%$refComp3%' OR re.refComp LIKE '%$refComp33%') and re.tipo = 1  and rel4.tipoProd = 1 GROUP BY re.id;
                ");

                $query22 = $cxn_bd->prepare("SELECT re.id, re.nombre, re.noRefFuster, marcas.marca as nbMarca, marcas.id as idMar, ".$idioma."_categorias.id as idCat, ".$idioma."_categorias.nombre as nbCategoria FROM ".$idioma."_repuestos  as re
                JOIN rel_repuestos_refoem ON re.id = rel_repuestos_refoem.idRepuesto 
                JOIN refoem ON refoem.id = rel_repuestos_refoem.idRefOem 
                JOIN rel_refoem_marcas_series_modelo as rel on refoem.id = rel.idRefOem
                JOIN marcas on marcas.id = rel.idMarca
                JOIN rel_repuestos_categorias as rel4 on rel4.idRepuesto = re.id
                JOIN ".$idioma."_categorias ON ".$idioma."_categorias.id = rel4.idCategoria
                WHERE (refoem.referencia = '$ref' OR re.noRefFuster= '$ref' OR re.refComp LIKE '%$refComp1' OR re.refComp LIKE '%$refComp11' OR re.refComp LIKE '$refComp2%' OR re.refComp LIKE '%$refComp3%' OR re.refComp LIKE '%$refComp33%') and re.tipo = 1  and rel4.tipoProd = 1 GROUP BY re.id;
                ");
            
                if($query){
                    if($query->execute()){
                        $queryData = $query->get_result();
                        $dataA = $queryData->fetch_all(MYSQLI_ASSOC); 
                        if(count($dataA)) { 
                            array_push($data,$dataA);
                        }else{
                            if($query22->execute()){
                                $queryData22 = $query22->get_result();
                                $dataA22 = $queryData22->fetch_all(MYSQLI_ASSOC); 
                                if(count($dataA22)) { 
                                    array_push($data,$dataA22);
                                }
                            }
                        }
                    }
                }
            }
            
            $response= array("code"=>$code,"msg"=>$msg, "result"=> $data);
            echo json_encode($response);
        }

        function findPadres($idPad, $cxn_bd, $separador, $idioma, $idCategoriaSuperior){
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
                                $rutaPadres = findPadres($idPadre, $cxn_bd, $separador, $idioma, $idCategoriaSuperior);
                            }else{
                                return $result[0]['nombre'];
                            }

                            if($rutaPadres){
                                if($idCategoriaSuperior != $id){
                                    return $rutaPadres.$separador.$result[0]['nombre'];
                                }else{
                                    return $rutaPadres;
                                }
                            }else{
                                if($idCategoriaSuperior != $id){
                                    return $result[0]['nombre'];
                                }
                            }
                            

                    }
                }
            }
        }

        if($action == 'buscarByRefOemAccesorios'){
            $data = [];
            $query = '';
            $refOem = trim($_POST['refOem']);
            $separador = '<span class="separadorr"></span>';

            $query = $cxn_bd->prepare("SELECT re.id, re.nombre, re.noRefFuster, ".$idioma."_categorias.id as idCat, ".$idioma."_categorias.nombre as nbCategoria, ".$idioma."_imagenes.thumbnails
            FROM ".$idioma."_repuestos  as re
            JOIN rel_repuestos_categorias as rel4 on rel4.idRepuesto = re.id
            JOIN ".$idioma."_categorias ON ".$idioma."_categorias.id = rel4.idCategoria
            LEFT JOIN rel_repuestos_imagenes as relimg on relimg.idRepuesto = re.id
            LEFT  JOIN ".$idioma."_imagenes on ".$idioma."_imagenes.id = relimg.idImagen
            WHERE (re.noRefFuster= '$refOem') and re.tipo = 0  and rel4.tipoProd = 0 and relimg.principal = 1; 
            ");// group by re.id lo quite porq sino salia un solo accesorio cuando el mismo estaba en dos cat diferentes
            $arrayFinal = [];
            $auxArray = [];
            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 
                    for ($i=0; $i < count($data); $i++) { 
                        $idCategoria = $data[$i]['idCat'];
                        $rutaPadres = findPadres($idCategoria, $cxn_bd, $separador, $idioma, $idCategoria);
                        $data[$i]['rutaPadres'] = $rutaPadres;
                    }
                }
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $data);
            echo json_encode($response);
        }

        if($action == 'buscarNombrAccesorios'){
            $data = [];
            $query = '';
            $producto = trim($_POST['nombre']);

            $result = preg_replace('/ de la | de los | de | y | con | la  | el | lo | del  | los  | las  | para  | por  | contra  | desde  | en  | durante  | entre  | hacia | hasta  | mediante  | para  | sin  | sobre /m'," ", $producto);
            $stringSeparado = explode(' ', $result);
            $strgQ = "( ";
            for ($i=0; $i < count($stringSeparado); $i++) { 
                if(count($stringSeparado)>1){
                    if($i < count($stringSeparado)-1){
                        $strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" AND ';
                    }else{
                        $strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" ';
                    }
                }else{$strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" ';}  
            }
            $strgQ .= " )";

            $query = $cxn_bd->prepare("SELECT re.id, re.nombre, re.noRefFuster, ".$idioma."_categorias.id as idCat, ".$idioma."_categorias.nombre as nbCategoria, ".$idioma."_imagenes.thumbnails
            FROM ".$idioma."_repuestos  as re
            JOIN rel_repuestos_categorias as rel4 on rel4.idRepuesto = re.id
            JOIN ".$idioma."_categorias ON ".$idioma."_categorias.id = rel4.idCategoria
            LEFT JOIN rel_repuestos_imagenes as relimg on relimg.idRepuesto = re.id
            LEFT  JOIN ".$idioma."_imagenes on ".$idioma."_imagenes.id = relimg.idImagen
            WHERE $strgQ and re.tipo = 0  and rel4.tipoProd = 0 group by re.id;
            ");
            
            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 
                }
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $data);
            echo json_encode($response);
        }

        if($action == 'buscarByProdMarcMode'){
            $data = [];
            $query = '';
            $producto = trim($_POST['producto']);
            $marca = trim($_POST['marca']);
            @$modelo = $_POST['modelo'];

            $result = preg_replace('/ de la | de los | de | y | con | la  | el | lo | del  | los  | las  | para  | por  | contra  | desde  | en  | durante  | entre  | hacia | hasta  | mediante  | para  | sin  | sobre /m'," ", $producto);
            $stringSeparado = explode(' ', $result);
            $strgQ = "( ";
            for ($i=0; $i < count($stringSeparado); $i++) { 
                if(count($stringSeparado)>1){
                    if($i < count($stringSeparado)-1){
                        $strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" AND ';
                    }else{
                        $strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" ';
                    }
                }else{$strgQ .= ' re.nombre LIKE "%'.$stringSeparado[$i].'%" ';}        
            }
            $strgQ .= " )";

            if(@count($modelo)>0 && is_array($modelo)){
                $modelo = implode(",", $modelo);

            }

            if($marca == -1){
                
            }else{
                if((!$modelo || $modelo=="") && $producto){
                    $query = $cxn_bd->prepare("SELECT listado.*, cat2.nombre as catPadre, cat2.id as idPadre FROM ( SELECT re.id, re.nombre, re.noRefFuster, marcas.marca as nbMarca, marcas.id as idMar, ".$idioma."_categorias.id as idCat, ".$idioma."_categorias.idPadre as idP, ".$idioma."_categorias.nombre as nbCategoria, ".$idioma."_imagenes.thumbnails FROM ".$idioma."_repuestos  as re
                    JOIN rel_repuestos_refoem ON re.id = rel_repuestos_refoem.idRepuesto 
                    JOIN refoem ON refoem.id = rel_repuestos_refoem.idRefOem 
                    JOIN rel_refoem_marcas_series_modelo as rel on refoem.id = rel.idRefOem
                    JOIN marcas on marcas.id = rel.idMarca
                    JOIN rel_repuestos_categorias as rel4 on rel4.idRepuesto = re.id
                    JOIN ".$idioma."_categorias ON ".$idioma."_categorias.id = rel4.idCategoria
                    LEFT JOIN rel_repuestos_imagenes as relimg on relimg.idRepuesto = re.id
                    LEFT  JOIN ".$idioma."_imagenes on ".$idioma."_imagenes.id = relimg.idImagen
                    WHERE $strgQ and marcas.id = $marca and re.tipo = 1  and rel4.tipoProd = 1 group by re.id) as listado JOIN ".$idioma."_categorias as cat2 ON listado.idP = cat2.id");
                }else{
                    $query = $cxn_bd->prepare("SELECT listado.*, cat2.nombre as catPadre, cat2.id as idPadre FROM (SELECT re.id, re.nombre, re.noRefFuster, marcas.marca as nbMarca, marcas.id as idMar, ".$idioma."_categorias.id as idCat, ".$idioma."_categorias.idPadre as idP, ".$idioma."_categorias.nombre as nbCategoria, ".$idioma."_imagenes.thumbnails FROM ".$idioma."_repuestos  as re
                    JOIN rel_repuestos_refoem ON re.id = rel_repuestos_refoem.idRepuesto 
                    JOIN refoem ON refoem.id = rel_repuestos_refoem.idRefOem 
                    JOIN rel_refoem_marcas_series_modelo as rel on refoem.id = rel.idRefOem
                    JOIN marcas on marcas.id = rel.idMarca
                    JOIN rel_repuestos_categorias as rel4 on rel4.idRepuesto = re.id
                    JOIN ".$idioma."_categorias ON ".$idioma."_categorias.id = rel4.idCategoria
                    LEFT JOIN rel_repuestos_imagenes as relimg on relimg.idRepuesto = re.id
                    LEFT  JOIN ".$idioma."_imagenes on ".$idioma."_imagenes.id = relimg.idImagen
                    WHERE $strgQ and rel.idModelo IN ($modelo) and marcas.id = $marca and re.tipo = 1  and rel4.tipoProd = 1 group by re.id) as listado JOIN ".$idioma."_categorias as cat2 ON listado.idP = cat2.id;
                    ");

                }
            }
            
            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 
                }
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $data);
            echo json_encode($response);
        }

        if($action == 'buscarByCateMarcMode'){
            $data = [];
            $query = '';
            $categoria = trim($_POST['categoria']);
            $marca = trim($_POST['marca']);
            @$modelo = $_POST['modelo'];

            if($modelo){
                $modelo = trim($modelo, ',');
            }
            
            $query = $cxn_bd->prepare("SELECT listado.*, cat2.nombre as catPadre, cat2.id as idPadre FROM (SELECT re.id, re.nombre, re.noRefFuster, marcas.marca as nbMarca, marcas.id as idMar, ".$idioma."_categorias.id as idCat, ".$idioma."_categorias.idPadre as idP, ".$idioma."_categorias.nombre as nbCategoria, ".$idioma."_imagenes.thumbnails FROM ".$idioma."_repuestos  as re
            JOIN rel_repuestos_refoem ON re.id = rel_repuestos_refoem.idRepuesto 
            JOIN refoem ON refoem.id = rel_repuestos_refoem.idRefOem 
            JOIN rel_refoem_marcas_series_modelo as rel on refoem.id = rel.idRefOem
            JOIN marcas on marcas.id = rel.idMarca
            JOIN rel_repuestos_categorias as rel4 on rel4.idRepuesto = re.id
            JOIN ".$idioma."_categorias ON ".$idioma."_categorias.id = rel4.idCategoria
            LEFT JOIN rel_repuestos_imagenes as relimg on relimg.idRepuesto = re.id
            LEFT  JOIN ".$idioma."_imagenes on ".$idioma."_imagenes.id = relimg.idImagen
            WHERE rel.idModelo IN ($modelo) and marcas.id = $marca and ".$idioma."_categorias.id = $categoria and re.tipo = 1 and relimg.principal = 1 and rel4.tipoProd = 1 group by re.id) as listado JOIN ".$idioma."_categorias as cat2 ON listado.idP = cat2.id;
            ");
            
            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 
                }
            }

            $response= array("code"=>$code,"msg"=>$msg, "result"=> $data);
            echo json_encode($response);
        }

        if($action == 'loginUser' && isset($_POST['user']) && $_POST['user']){
            $user = trim($_POST['user']);
            $pass = trim($_POST['pass']);
            
            $result = [];
            $query = $cxn_bd->prepare("SELECT id_tiendas from tiendas where user='$user' and pass='$pass' and activa='si';");
            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 
                    if(count($data)==1){
                        $token = md5(time());
                        $query = $cxn_bd->prepare("UPDATE tiendas set token='$token' where user='$user' and pass='$pass' and activa='si';");
                        if($query->execute()){
                            $msg = 'Consulta ejecutada con exito';
                            $id = $data[0]['id_tiendas'];
                            $response= array("code"=>55,"msg"=>$msg, "result"=> $token, "idU"=> $id, "emailU"=> $user);
                        }else{
                            $msg = 'Error login1';
                            $response= array("code"=>66,"msg"=>$msg, "result"=> '');}
                    }else{
                        $msg = 'Error login2';
                        $response= array("code"=>66,"msg"=>$msg, "result"=> '');}
                }else{
                    $msg = 'Error login3';
                    $response= array("code"=>66,"msg"=>$msg, "result"=> '');}
            }

            echo json_encode($response);
        }

        if($action == 'loginUser2Verify' && isset($_POST['token']) && $_POST['token']){
            $token = trim($_POST['token']);
            $id = trim($_POST['id']);
            
            $result = [];
            $query = $cxn_bd->prepare("SELECT id_tiendas from tiendas where id_tiendas=$id and token='$token' and activa='si';");
            if($query){
                if($query->execute()){
                    $queryData = $query->get_result();
                    $data = $queryData->fetch_all(MYSQLI_ASSOC); 
                    if(count($data)>0){
                        $msg = 'Consulta ejecutada con exito';
                        $response= array("code"=>555,"msg"=>$msg, "result"=> '');
                    }else{
                        $msg = 'Error login2';
                        $response= array("code"=>66,"msg"=>$msg, "result"=> '');}
                }else{
                    $msg = 'Error login3';
                    $response= array("code"=>66,"msg"=>$msg, "result"=> '');}
            }

            echo json_encode($response);
        }
        
        
        if($action == 'getPedidos'){
            $id = trim($_GET['idUser']);

            $result = [];
            $query = $cxn_bd->prepare("SELECT * FROM pedidos where idTienda='$id' ");
            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    $data = $data->fetch_all(MYSQLI_ASSOC);
                    if(count($data)>0){
                        $msg = 'Consulta ejecutada con exito';
                        $response= array("code"=>555,"msg"=>$msg, "result"=> $data);
                    }else{
                        $msg = 'Error get pedidos';
                        $response= array("code"=>66,"msg"=>$msg, "result"=> '');
                    }
                }
            }else{
                $msg = 'Error get pedidos';
                $response= array("code"=>66,"msg"=>$msg, "result"=> '');
            }

            echo json_encode($response);
        }
        
        
        if($action == 'getPedidoById'){
            $id = trim($_GET['idUser']);
            $idPedido = trim($_GET['idPedido']);

            $result = [];
            $query = $cxn_bd->prepare("SELECT * FROM pedidos where idTienda='$id' and pedido='$idPedido'");
            if($query){
                if($query->execute()){
                    $data = $query->get_result();
                    $data = $data->fetch_all(MYSQLI_ASSOC);
                    if(count($data)>0){
                        $msg = 'Consulta ejecutada con exito';
                        $response= array("code"=>555,"msg"=>$msg, "result"=> $data);
                    }else{
                        $msg = 'Error get pedidos';
                        $response= array("code"=>66,"msg"=>$msg, "result"=> '');
                    }
                }
            }else{
                $msg = 'Error get pedidos';
                $response= array("code"=>66,"msg"=>$msg, "result"=> '');
            }

            echo json_encode($response);
        }
    }


    function construirPadre($idAnalizar, $cxn_bd, $idiomaa){

        if($idAnalizar == 13){
            return 0;
        }

        if($idAnalizar == 0){
            return 0;
        }

        $query = $cxn_bd->prepare("SELECT idPadre FROM ".$idiomaa."_categorias WHERE id = ".$idAnalizar."");

        if($query->execute()){
            $data2 = $query->get_result();
            if($row2 = $data2->fetch_all(MYSQLI_ASSOC)){
                $ida = $row2[0]['idPadre'];

                if($ida == 13){
                    return 0;
                }
        
                if($ida == 0){
                    return 0;
                }

                $query = $cxn_bd->prepare("SELECT nombre FROM ".$idiomaa."_categorias WHERE id = ".$ida."");

                if($query->execute()){
                    $data2 = $query->get_result();
                    if($row3 = $data2->fetch_all(MYSQLI_ASSOC)){
                        $idpad = $ida;
                        $nombpad = $row3[0]['nombre']; 
                        return '{"id": '.$idpad.', "nombre": "'.$nombpad.'"}';
                    }
                }
            }
        }
    }

    function buscarCategConHijos($idBuscar, $cxn_bd, $idiomaa){
        $query = $cxn_bd->prepare("SELECT count(id) as cantidad FROM ".$idiomaa."_categorias WHERE idPadre = ".$idBuscar."");
        if($query->execute()){
            $data2 = $query->get_result();
            $row2 = $data2->fetch_all(MYSQLI_ASSOC); 
            if($row2[0]['cantidad']>0){
                return "ARBOL";
            }else{
                return "RAIZ";
            }
        }
    }
    
    function esArbol($idBuscar, $cxn_bd, $idiomaa, &$resultado = []){
        $query = $cxn_bd->prepare("SELECT id, nombre, idPadre FROM ".$idiomaa."_categorias WHERE idPadre = $idBuscar ORDER BY nombre");
        if($query->execute()){
            $data2 = $query->get_result();
            while($row2 = $data2->fetch_assoc()){
                $idBuscar = $row2['id'];
                $queEs = buscarCategConHijos($idBuscar, $cxn_bd, $idiomaa);
                $nombre = $row2['nombre'];
                if($queEs == 'RAIZ'){
                    $query = $cxn_bd->prepare("SELECT idRepuesto FROM rel_repuestos_categorias WHERE idCategoria = ".$idBuscar." and idRepuesto <> 0");
                    if($query){
                        if($query->execute()){
                            $data3 = $query->get_result();
                            $hijos = '';
                            // while($rw = $data3->fetch_assoc()){
                            // $hijos .= $rw['idRepuesto'].','; 
                            // }
                            $hijos = $data3->fetch_all(MYSQLI_ASSOC); 
                            if(count($hijos)>0){
                                $element= array("id"=>$idBuscar, "nombre"=>$nombre, "hijos"=> count($hijos));
                                // $element= array("id"=>$idBuscar, "nombre"=>$nombre, "hijos"=> $hijos);
                                array_push($resultado, $element);
                            }
                        }
                    }
                }else if($queEs == 'ARBOL'){
                    esArbol($idBuscar, $cxn_bd, $idiomaa, $resultado);
                }
            }

            return $resultado;
        }
    }
?>
