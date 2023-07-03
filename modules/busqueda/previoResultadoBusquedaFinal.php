<div id="page">
    <div id="main">
        <?php
            include 'modules/lateral/buscador-avanzado.php';
        ?>

        <div id="content" class="column ocultBusca"  role="main">
            
            <h1 class="page__title title" id="page-title"><?=${"lang_".$idioma}['marca']['plural'];?></h1>
            
            <div id='list-tractoress'>
                <div class='loading'>
                    <div class="spinner-border"  style='border: .25em solid #e6e2dc;border-right-color: transparent;' role="status"></div>
                </div> 
            </div>
        </div>

        <?php 
            include 'modules/busqueda/resultadoBusqueda.php';
        ?>
    </div>
</div>