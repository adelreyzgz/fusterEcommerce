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

        <?php 
            include 'modules/busqueda/resultadoBusqueda.php';
        ?>
    </div>
</div>