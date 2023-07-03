<div id="page">
    <div id="main">
        <?php
            include 'modules/lateral/buscador-avanzado.php';
        ?>

        <div id="content" class="column ocultBusca"  role="main">
            
            <h1 class="page__title title" id="page-title"><?=${"lang_".$idioma}['sobrenuestracompania'];?></h1>
             
            <div class="field field-name-body field-type-text-with-summary field-label-hidden">
                <div class="field-items">
                    <div class="field-item even" property="content:encoded">
                        <div class="header-empresa">
                            <img src="http://www.repuestosfuster.com/sites/all/themes/zenfuster/img/header-empresa.jpg" alt="Our company" title="Repuestos Fuster" width="900" height="220" />
                            <p></p>
                            <p>
                                <?=${"lang_".$idioma}['fabricanterepuestos'];?>
                            </p>
                        </div>

                        <div class="txt-empresa bloques-empresa">
                            <h2 class="sub-titulo"><?=${"lang_".$idioma}['profesionalycompromiso'];?></h2>
                            <div class="videoEmpresa">
                                <div class="vidInner">
                                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/4N9eOh5bpMA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                                <div  class="historiaInner">
                                    <?=${"lang_".$idioma}['historia'];?>
                                </div>
                            </div>
                        </div>

                        <div class="bloques-empresa">
                            <h2><?=${"lang_".$idioma}['calidadydisponibilidad'];?></h2>
                            <ul>
                                <li>
                                    <div>
                                        <img src="http://www.repuestosfuster.com/sites/all/themes/zenfuster/img/header-taller.jpg" alt="Production" title="Production" width="800" height="520" />
                                        <p style='font-size: 24px;'><?=${"lang_".$idioma}['taller'];?></p>
                                    </div>
                                    <?=${"lang_".$idioma}['infotaller'];?>
                                </li>
                                <li>
                                    <div>
                                        <img src="http://www.repuestosfuster.com/sites/all/themes/zenfuster/img/header-almacen.jpg" alt="Warehouse" title="Warehouse" width="800" height="520" />
                                        <p style='font-size: 24px;'><?=${"lang_".$idioma}['almacen'];?></p>
                                    </div>
                                    <?=${"lang_".$idioma}['infoalmacen'];?>
                                </li>
                            </ul>
                        </div>
                        <div class="bloques-empresa">
                            <h2><?=${"lang_".$idioma}['sietedecadas'];?></h2>
                            <ul>
                                <li>
                                    <?=${"lang_".$idioma}['infosietedecadas'];?>
                                </li>
                                <li>
                                    <div><img src="http://www.repuestosfuster.com/sites/all/themes/zenfuster/img/experiencia-empresa.jpg" alt="Tractor" title="Tractor" width="300" height="520" /></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php 
            include 'modules/busqueda/resultadoBusqueda.php';
        ?>
    </div>
</div>