<?php

if($idioma == 'es'){
    if(isset($_GET['marca']) && $_GET['marca'] && !isset($_GET['catpadre'])){
        echo "<title>Tractores $nombreM | Repuestos Fuster</title>
        <meta name='description' content='Fabricación y distribución de recambios para tractores $nombreM. Repuestos no originales. Piezas para todos modelos de tractores $nombreM. Entrega 24 h.'>
        <meta property='og:title' content='Tractores $nombreM | Repuestos Fuster' />
        <meta property='og:image'
            content='http://www.fusterrepuestos.local/assets/images/marcas/jpg/$imagenM.jpg' />
        <meta property='og:description'
            content='Fabricación y distribución de recambios para tractores $nombreM. Repuestos no originales. Piezas para todos modelos de tractores $nombreM. Entrega 24 h.' />";
    }else if(isset($_GET['catpadre']) && $_GET['catpadre'] && !isset($_GET['marca']) ){
        echo "<title>$titleHead2 | Repuestos Fuster</title>
        <meta name='description' content='$titleHead2 - Piezas para todos modelos de tractores CASE-IH. FIAT. JOHN DEERE. LANDINI. McCORMICK. NEW HOLLAND. Entrega 24 h.'>
        <meta property='og:title' content='$titleHead2 | Repuestos Fuster' />
        <meta property='og:description'
            content='$titleHead2 - Piezas para todos modelos de tractores CASE-IH. FIAT. JOHN DEERE. LANDINI. McCORMICK. NEW HOLLAND. Entrega 24 h.' />";
    }else if(isset($_GET['prodId']) && $_GET['prodId'] ){
        echo "<title>$titleHead2 | Repuestos Fuster</title>
        <meta name='description' content='$titleHead2 - Piezas para todos modelos de tractores CASE-IH. FIAT. JOHN DEERE. LANDINI. McCORMICK. NEW HOLLAND. Entrega 24 h.'>
        <meta property='og:title' content='$titleHead2 | Repuestos Fuster' />
        <meta property='og:description'
            content='$titleHead2 - Piezas para todos modelos de tractores CASE-IH. FIAT. JOHN DEERE. LANDINI. McCORMICK. NEW HOLLAND. Entrega 24 h.' />";
    }else{
        echo "<title>$titleHead</title>
        <meta name='description' content='Bienvenido al sitio web de Repuestos Fuster. En él encontrarás toda clase de recambios para tractores agrícolas de las principales marcas y modelos.'>
        <meta property='og:title' content='$titleHead | Repuestos Fuster' />
        <meta property='og:description'
            content='Bienvenido al sitio web de Repuestos Fuster. En él encontrarás toda clase de recambios para tractores agrícolas de las principales marcas y modelos.' />";
    }
}else if($idioma == 'en'){
    if(isset($_GET['marca']) && $_GET['marca'] && !isset($_GET['catpadre'])){
        echo "<title>Tractors $nombreM | Repuestos Fuster</title>
        <meta name='description' content='Manufacture and distribution of spare parts for $nombreM tractors. Non-original spare parts. Parts for all models of tractors $nameM. 24 hour delivery.'>
        <meta property='og:title' content='Tractors $nombreM | Repuestos Fuster' />
        <meta property='og:image'
            content='http://www.fusterrepuestos.local/assets/images/marcas/jpg/$imagenM.jpg' />
        <meta property='og:description'
            content='Manufacture and distribution of spare parts for $nombreM tractors. Non-original spare parts. Parts for all models of tractors $nameM. 24 hour delivery.' />";
    }else if(isset($_GET['catpadre']) && $_GET['catpadre'] && !isset($_GET['marca']) ){
        echo "<title>$titleHead2 | Repuestos Fuster</title>
        <meta name='description' content='$titleHead2 - Parts for all CASE-IH tractor models. FIAT. JOHN DEERE. LANDINI. McCORMICK. NEW HOLLAND. 24 hour delivery.'>
        <meta property='og:title' content='$titleHead2 | Repuestos Fuster' />
        <meta property='og:description'
            content='$titleHead2 - Parts for all CASE-IH tractor models. FIAT. JOHN DEERE. LANDINI. McCORMICK. NEW HOLLAND. 24 hour delivery.' />";
    }else if(isset($_GET['prodId']) && $_GET['prodId'] ){
        echo "<title>$titleHead2 | Repuestos Fuster</title>
        <meta name='description' content='$titleHead2 - Parts for all CASE-IH tractor models. FIAT. JOHN DEERE. LANDINI. McCORMICK. NEW HOLLAND. 24 hour delivery.'>
        <meta property='og:title' content='$titleHead2 | Repuestos Fuster' />
        <meta property='og:description'
            content='$titleHead2 - Parts for all CASE-IH tractor models. FIAT. JOHN DEERE. LANDINI. McCORMICK. NEW HOLLAND. 24 hour delivery.' />";
    }else{
        echo "<title>$titleHead</title>
        <meta name='description' content='Welcome to the Repuestos Fuster website. In it you will find all kinds of spare parts for agricultural tractors of the main brands and models.'>
        <meta property='og:title' content='$titleHead | Repuestos Fuster' />
        <meta property='og:description'
            content='Welcome to the Repuestos Fuster website. In it you will find all kinds of spare parts for agricultural tractors of the main brands and models.' />";
    }
}else if($idioma == 'fr'){
    if(isset($_GET['marca']) && $_GET['marca'] && !isset($_GET['catpadre'])){
        echo "<title>Tracteurs $nombreM | Repuestos Fuster</title>
        <meta name='description' content='Fabrication et distribution de pièces détachées pour $nombreM tracteurs. Pièces de rechange non originales. Pièces pour tous les modèles de tracteurs $nameM. Livraison 24h/24.'>
        <meta property='og:title' content='Tracteurs $nombreM | Repuestos Fuster' />
        <meta property='og:image'
            content='http://www.fusterrepuestos.local/assets/images/marcas/jpg/$imagenM.jpg' />
        <meta property='og:description'
            content='Fabrication et distribution de pièces détachées pour $nombreM tracteurs. Pièces de rechange non originales. Pièces pour tous les modèles de tracteurs $nameM. Livraison 24h/24.' />";
    }else if(isset($_GET['catpadre']) && $_GET['catpadre'] && !isset($_GET['marca']) ){
        echo "<title>$titleHead2 | Repuestos Fuster</title>
        <meta name='description' content='$titleHead2 - Pièces pour tous les modèles de tracteurs CASE-IH. DÉCRET. JOHN DEERE. LANDINI. McCORMICK. NOUVELLE HOLLANDE. Livraison 24h'>
        <meta property='og:title' content='$titleHead2 | Repuestos Fuster' />
        <meta property='og:description'
            content='$titleHead2 - Pièces pour tous les modèles de tracteurs CASE-IH. DÉCRET. JOHN DEERE. LANDINI. McCORMICK. NOUVELLE HOLLANDE. Livraison 24h' />";
    }else if(isset($_GET['prodId']) && $_GET['prodId'] ){
        echo "<title>$titleHead2 | Repuestos Fuster</title>
        <meta name='description' content='$titleHead2 - Pièces pour tous les modèles de tracteurs CASE-IH. DÉCRET. JOHN DEERE. LANDINI. McCORMICK. NOUVELLE HOLLANDE. Livraison 24h/24'>
        <meta property='og:title' content='$titleHead2 | Repuestos Fuster' />
        <meta property='og:description'
            content='$titleHead2 - Pièces pour tous les modèles de tracteurs CASE-IH. DÉCRET. JOHN DEERE. LANDINI. McCORMICK. NOUVELLE HOLLANDE. Livraison 24h' />";
    }else{
        echo "<title>$titleHead</title>
        <meta name='description' content='Bienvenue sur le site de Repuestos Fuster. Vous y trouverez toutes sortes de pièces détachées pour tracteurs agricoles des principales marques et modèles.'>
        <meta property='og:title' content='$titleHead | Repuestos Fuster' />
        <meta property='og:description'
            content='Bienvenue sur le site de Repuestos Fuster. Vous y trouverez toutes sortes de pièces détachées pour tracteurs agricoles des principales marques et modèles.' />";
    }
}
?>
  