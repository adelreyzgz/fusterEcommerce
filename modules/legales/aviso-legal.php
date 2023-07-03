<div id="page">
    <div id="main">
        <?php
            include 'modules/lateral/buscador-avanzado.php';
        ?>

        <div id='content' class='column ocultBusca' role='main'>
            <h1 class='page__title title' id='page-title'><?=${"lang_".$idioma}['avisolegal'];?></h1>
            <div class='field field-name-body field-type-text-with-summary field-label-hidden'>
                <div class='field-items'>
                    <div class='field-item even' property='content:encoded'>
                        <?=${"lang_".$idioma}['infoavisolegal'];?>
                    </div>
                </div>
            </div>
        </div>

        <?php 
            include 'modules/busqueda/resultadoBusqueda.php';
        ?>
    </div>
</div>