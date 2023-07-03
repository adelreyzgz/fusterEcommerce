<div id="page">
    <div id="main">
        <?php
            include 'modules/lateral/buscador-avanzado.php';
        ?>

        <div id="content" class="column ocultBusca" role="main">
            <style>
                #page-title{display:block;}

                @media (max-width:800px) {
                    #page-title{display:none !important;}
                }

            </style>
            <h1 class="page__title title" id="page-title"><?=${"lang_".$idioma}['accesorios'];?></h1>
            <ul class="wrapper listadoCate" id='listadoCategorias'>
                <div class='loading'>
                    <div class="spinner-border"  style='border: .25em solid #e6e2dc;border-right-color: transparent;' role="status"></div>
                </div>
            </ul>
        </div>

        
        <div id="content" class="column resultadoBusqueda" role="main">
            
            <h1 class="page__title title" id="page-title"><?=${"lang_".$idioma}['todoslosrecambios'];?></h1>

            <div class="view view-buscador-oems view-id-buscador_oems view-display-id-block view-dom-id-b78c951cc1652722a1159b75a4efda35">
                <div class="view-content listadoSinResultadoBusqueda" id='listadoSinResultadoBusqueda' style='display:none'>
                    <h3 class="rotulo-marca"><?=${"lang_".$idioma}['nodebedejarcamposvacio'];?></h3>
                    <div class="sugerencias-buscar">
                        <?=${"lang_".$idioma}['sugerencias'];?>
                    </div>  
                    </div>
                    <div class="view-content listadoAccesoriosBusqueda" id='listadoAccesoriosBusqueda'>
                </div>
                <div class="view-content listadoProductosBusqueda" id='listadoProductosBusqueda'>
                    <div class='loading'>
                        <div class="spinner-border"  style='border: .25em solid #e6e2dc;border-right-color: transparent;' role="status"></div>
                    </div>    
                </div>
            </div>
        </div>  
    </div>
</div>