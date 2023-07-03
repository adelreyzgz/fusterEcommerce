<div id="page">
    <div id="main">
        <?php
            include 'modules/lateral/buscador-avanzado.php';
        ?>

        <div id="content" class="column ocultBusca"  role="main">
        
            <h1 class="page__title title" id="page-title"><?=$nombreC;?></h1>
            <div class='listadoIdent' id='listadoIdent'>

            </div>
            <div class="view view-buscador-oems view-id-buscador_oems view-display-id-block view-dom-id-b78c951cc1652722a1159b75a4efda35">
                <div class="view-content listadoProductos" id='listadoProductos'>
                    <div class='loading'>
                        <div class="spinner-border"  style='border: .25em solid #e6e2dc;border-right-color: transparent;' role="status"></div>
                    </div>    
                </div>
            </div>
        </div>

        <?php 
            include 'modules/busqueda/resultadoBusqueda.php';
        ?>
    </div>
</div>