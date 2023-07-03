<div id="page">
    <div id="main">
        <?php
            include 'modules/lateral/buscador-avanzado.php';
        ?>

        <div id="content" class="column secondarySearch"  role="main">
            
            <?php
                if(isset($_GET['marca']) && $_GET['marca']){
            ?>
                <div class='onlyMarcaSeleccionada'>
                    <h1 class="page__title title" id="page-title"><?=$nombreM;?></h1>
                    
                    <div class='marcaform'>
                        <div class="miniatura-filtrado">
                            <img src="assets/images/marcas/jpg/<?=$imagenM;?>.jpg" alt="">
                        </div>
                        <div>

                            <form action="<?=$base;?>en/search-product" method="post" accept-charset="UTF-8" id="fuster-buscador3">
                                <p><?=${"lang_".$idioma}['producto'];?></p>
                                <div class="form-item" style="display: flex;flex-direction: column;margin-bottom: 15px;">
                                    <select class="js-data-producto2"></select>                            
                                    <p class='msgErrProd2' style=""> <?=${"lang_".$idioma}['filtrarporproducto'];?> </p>
                                </div>

                                <p style="margin-top:18px;"><?=${"lang_".$idioma}['modelo'];?></p>
                                <div class="form-item" style="display: flex;flex-direction: column;margin-bottom: 15px;"> 
                                    <select class="js-data-modelo2"  name="modelosSelect2[]" multiple="multiple"></select>
                                </div>

                                <button class="form-submit btnbuscar buscarByProdMarcModSecundary" style="margin-top:18px;" type="button">
                                    <span class="sr-only"><?=${"lang_".$idioma}['buscar'];?></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>

            <div class='ocultBusca'>
                <h1 class="page__title title" id="page-title"><?=${"lang_".$idioma}['productos']['title'];?></h1>
                <ul class="wrapper listadoCate" id='listadoCategorias'>
                    <div class='loading'>
                        <div class="spinner-border"  style='border: .25em solid #e6e2dc;border-right-color: transparent;' role="status"></div>
                    </div>
                </ul>
            </div>

        </div>

        <?php 
            include 'modules/busqueda/resultadoBusqueda.php';
        ?>
        
    </div>
</div>