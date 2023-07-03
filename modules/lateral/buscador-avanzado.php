<div id="seccion_lateral" class="lateral-home">
    <div class="region region-seccion-lateral lateralSearch">
        <div id="block-block-1" class="block block-block first odd">
            <h3><?=${"lang_".$idioma}['buscadoravanzado'];?></h3>
            <span id="toggle-buscador"></span>
            <div id='formBusca'>
                <form action="<?=$base;?>es/busca-producto" method="get" id="fuster-buscador" accept-charset="UTF-8">
                    <div>

                        <div class="form-item form-type-textfield form-item-reference" role="application">
                            <label class="label-es" for="edit-reference"><?=${"lang_".$idioma}['ndereferencia'];?> </label>
                            <select class="js-data-refoem"></select>
                        </div>

                        <button class="form-submit btonsearchlateral buscarByNoRef" type="button">
                            <span class="sr-only"><?=${"lang_".$idioma}['buscar'];?></span>                   
                        </button>
                        
                    </div>
                </form>


                <form action="<?=$base;?>es/busca-producto" method="get" id="fuster-buscador2" accept-charset="UTF-8">
                    <div>
                        <div class="form-item form-type-textfield form-item-product" role="application">
                            <label class="label-es" for="edit-product"><?=${"lang_".$idioma}['producto'];?> </label>

                            <select class="js-data-producto"></select>                            

                        </div>
                        <p class='msgErrProd'> <?=${"lang_".$idioma}['filtrarporproducto'];?> </p>

                        <div class="form-item form-type-select form-item-brand">
                            <label class="label-es" for="edit-brand"><?=${"lang_".$idioma}['marca']['title'];?> </label>
                            <p class='msgErrMarc'> <?=${"lang_".$idioma}['seleccioneunamarca'];?> </p>
                            <select class="js-data-marca"></select>
                        </div>
                        <div class="form-item form-type-select form-item-model form-disabled" >
                            <label class="label-es" for="edit-model"><?=${"lang_".$idioma}['modelo'];?> </label>
                            <select class="js-data-modelo" name="modelosSelect[]" multiple="multiple"></select>
                        </div>

                        <button class="form-submit btonsearchlateral buscarByProdMarcMod" type="button">
                            <span class="sr-only"><?=${"lang_".$idioma}['buscar'];?></span>
                        </button>

                    </div>
                </form>
            </div>
        </div>
       
        <div id="block-views-listado-secciones-block" class="block block-views even accor">
            <h3 class="titulo-bloque"><?=${"lang_".$idioma}['productos']['title'];?></h3><span id="toggle-productos"></span>
            
            <?php if($idioma == "es"){ ?>
                <div id="block-views-listado-secciones-block" class="block block-views even accor">
                    <div id="accordion" class="accordionss ui-accordion ui-widget ui-helper-reset accordionIZQ" role="tablist">
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-0" aria-controls="ui-accordion-accordion-panel-0" aria-selected="false" tabindex="0">
                            <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Cables
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-0" aria-labelledby="ui-accordion-accordion-header-0" role="tabpanel" aria-expanded="false" aria-hidden="true">
                            <ul>
                            <li class="active">
                                <a href="es/productos/cid52/cables-de-acelerador/">Cables de acelerador</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid50/cables-de-embrague-y-toma-de-fuerza/">Cables de embrague y toma de fuerza</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid51/cables-de-pares/">Cables de pares</a>
                            </li>
                            </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-1" aria-controls="ui-accordion-accordion-panel-1" aria-selected="false" tabindex="0">
                            <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Caja de cambios
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-1" aria-labelledby="ui-accordion-accordion-header-1" role="tabpanel" aria-expanded="false" aria-hidden="true">
                            <ul>
                            <li class="active">
                                <a href="es/productos/cid31/caja-de-cambios/">Caja de cambios</a>
                            </li>
                            </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-2" aria-controls="ui-accordion-accordion-panel-2" aria-selected="false" tabindex="0">
                            <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Carrocería y Cabina
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-2" aria-labelledby="ui-accordion-accordion-header-2" role="tabpanel" aria-expanded="false" aria-hidden="true">
                            <ul>
                            <li class="active">
                                <a href="es/productos/cid47/accesorios/">Accesorios</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid46/carroceria/">Carrocería</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid49/cerraduras/">Cerraduras</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid48/cristal/">Cristal</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid45/pegatinas/">Pegatinas</a>
                            </li>
                            <li class="active">
                                    <span style='color: #151213;font-size: 13px;line-height: 18px;font-weight: 600;'>Asientos</span>
                                    <ul style="margin-left: 15px;">
                                        <li style='color: #151213;font-size: 13px;line-height: 22px;font-weight: 600;'><a href='es/productos/cid10322/asientos-mecanicos/'>Asientos mecánicos</a></li>
                                        <li style='color: #151213;font-size: 13px;line-height: 22px;font-weight: 600;'><a href='es/productos/cid10323/asientos-neumaticos/'>Asientos neumáticos</a></li>
                                        <li style='color: #151213;font-size: 13px;line-height: 22px;font-weight: 600;'><a href='es/productos/cid10324/despiece-asientos/'>Despiece asientos</a></li>
                                    </ul>
                            </li>
                            </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-3" aria-controls="ui-accordion-accordion-panel-3" aria-selected="false" tabindex="0">
                            <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Eje delantero doble tracción (4WD)
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-3" aria-labelledby="ui-accordion-accordion-header-3" role="tabpanel" aria-expanded="false" aria-hidden="true">
                            <ul>
                            <li class="active">
                                <a href="es/productos/cid30/caja-de-direccion/">Caja de dirección</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid29/puente-delantero/">Puente delantero</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid28/rotula-de-direccion/">Rótula de dirección</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid27/transmision-delantera/">Transmisión delantera</a>
                            </li>
                            </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-4" aria-controls="ui-accordion-accordion-panel-4" aria-selected="false" tabindex="0">
                            <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Eje delantero simple tracción (2WD)
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-4" aria-labelledby="ui-accordion-accordion-header-4" role="tabpanel" aria-expanded="false" aria-hidden="true">
                            <ul>
                            <li class="active">
                                <a href="es/productos/cid26/caja-de-direccion/">Caja de dirección</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid23/mangueta/">Mangueta</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid25/puente-delantero/">Puente delantero</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid24/rotula-de-direccion/">Rótula de dirección</a>
                            </li>
                            </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-5" aria-controls="ui-accordion-accordion-panel-5" aria-selected="false" tabindex="0">
                            <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Electricidad
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-5" aria-labelledby="ui-accordion-accordion-header-5" role="tabpanel" aria-expanded="false" aria-hidden="true">
                            <ul>
                            <li class="active">
                                <a href="es/productos/cid42/alternadores/">Alternadores</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid44/faros/">Faros</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid43/instrumentos-e-interruptores/">Instrumentos e interruptores</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid41/motor-de-arranque/">Motor de arranque</a>
                            </li>
                            </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-6" aria-controls="ui-accordion-accordion-panel-6" aria-selected="false" tabindex="0">
                            <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Elevador hidráulico
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-6" aria-labelledby="ui-accordion-accordion-header-6" role="tabpanel" aria-expanded="false" aria-hidden="true">
                            <ul>
                            <li class="active">
                                <a href="es/productos/cid34/bomba-hidraulica/">Bomba hidráulica</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid36/eje-control-sensibilidad/">Eje control sensibilidad</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid35/eje-elevador/">Eje elevador</a>
                            </li>
                            </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-7" aria-controls="ui-accordion-accordion-panel-7" aria-selected="false" tabindex="0">
                            <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Embrague
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-7" aria-labelledby="ui-accordion-accordion-header-7" role="tabpanel" aria-expanded="false" aria-hidden="true">
                            <ul>
                            <li class="active">
                                <a href="es/productos/cid22/embrague/">Embrague</a>
                            </li>
                            </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-8" aria-controls="ui-accordion-accordion-panel-8" aria-selected="false" tabindex="0">
                            <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Enganche
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-8" aria-labelledby="ui-accordion-accordion-header-8" role="tabpanel" aria-expanded="false" aria-hidden="true">
                            <ul>
                            <li class="active">
                                <a href="es/productos/cid40/barra-paralela/">Barra paralela</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid9577/enganche-delantero/">Enganche delantero</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid39/tensor-lateral/">Tensor lateral</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid37/tensor-vertical/">Tensor vertical</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid38/tercer-punto/">Tercer punto</a>
                            </li>
                            </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-9" aria-controls="ui-accordion-accordion-panel-9" aria-selected="false" tabindex="0">
                            <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Frenos
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-9" aria-labelledby="ui-accordion-accordion-header-9" role="tabpanel" aria-expanded="false" aria-hidden="true">
                            <ul>
                            <li class="active">
                                <a href="es/productos/cid33/frenos/">Frenos</a>
                            </li>
                            </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-10" aria-controls="ui-accordion-accordion-panel-10" aria-selected="false" tabindex="0">
                            <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Motor
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-10" aria-labelledby="ui-accordion-accordion-header-10" role="tabpanel" aria-expanded="false" aria-hidden="true">
                            <ul>
                            <li class="active">
                                <a href="es/productos/cid16/bomba-de-agua/">Bomba de agua</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid20/bomba-de-alimentacion/">Bomba de alimentación</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid15/ciguenal-equilibrador/">Cigüeñal, equilibrador</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid9354/correas/">Correas</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid18/deposito-combustible/">Depósito combustible</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid14/equipo-motor/">Equipo motor</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid9942/filtro-de-aceite/">Filtro de aceite</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid19/filtro-de-aire/">Filtro de aire</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid17/radiador/">Radiador</a>
                            </li>
                            <li class="active">
                                <a href="es/productos/cid21/silencioso/">Silencioso</a>
                            </li>
                            </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-11" aria-controls="ui-accordion-accordion-panel-11" aria-selected="false" tabindex="0">
                            <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Transmisión y Toma de fuerza
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-11" aria-labelledby="ui-accordion-accordion-header-11" role="tabpanel" aria-expanded="false" aria-hidden="true">
                            <ul>
                                <li class="active">
                                    <a href="es/productos/cid32/transmision-y-toma-de-fuerza/">Transmisión y Toma de fuerza</a>									
                                </li>								
                            </ul>							
                        </div>
                    </div>
                </div>
            <?php }else if($idioma == "en") { ?>
                <div id="block-views-listado-secciones-block" class="block block-views even accor">
                    <div id="accordion" class="accordionss ui-accordion ui-widget ui-helper-reset accordionIZQ" role="tablist">
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-0" aria-controls="ui-accordion-accordion-panel-0" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Brakes
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-0" aria-labelledby="ui-accordion-accordion-header-0" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="en/products/cid33/brakes/">Brakes</a>
                            </li>
                        </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-1" aria-controls="ui-accordion-accordion-panel-1" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Cab and body parts
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-1" aria-labelledby="ui-accordion-accordion-header-1" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="en/products/cid47/accessories/">Accessories</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid46/body-parts/">Body parts</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid45/decal-and-emblem/">Decal and emblem</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid48/glass/">Glass</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid49/handles-and-locks/">Handles and locks</a>
                            </li>
                            <li class="active">
                                    <span style='color: #151213;font-size: 13px;line-height: 18px;font-weight: 600;'>Seat</span>
                                    <ul style="margin-left: 15px;">
                                        <li style='color: #151213;font-size: 13px;line-height: 22px;font-weight: 600;'><a href='en/products/cid10322/seats-mechanical/'>Mechanical seats</a></li>
                                        <li style='color: #151213;font-size: 13px;line-height: 22px;font-weight: 600;'><a href='en/products/cid10323/seats-pneumatic/'>Pneumatic seats</a></li>
                                        <li style='color: #151213;font-size: 13px;line-height: 22px;font-weight: 600;'><a href='en/products/cid10324/components-seat/'>Seat components</a></li>
                                    </ul>
                            </li>
                        </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-2" aria-controls="ui-accordion-accordion-panel-2" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Cables
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-2" aria-labelledby="ui-accordion-accordion-header-2" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="en/products/cid50/clutch-and-pto-cable/">Clutch and PTO cable</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid51/stop-cable/">Stop cable</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid52/throttle-cable/">Throttle cable</a>
                            </li>
                        </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-3" aria-controls="ui-accordion-accordion-panel-3" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Clutch
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-3" aria-labelledby="ui-accordion-accordion-header-3" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="en/products/cid22/clutch/">Clutch</a>
                            </li>
                        </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-4" aria-controls="ui-accordion-accordion-panel-4" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Electrical components
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-4" aria-labelledby="ui-accordion-accordion-header-4" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="en/products/cid42/alternators/">Alternators</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid43/instrumentation/">Instrumentation</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid44/lighting/">Lighting</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid41/starter/">Starter</a>
                            </li>
                        </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-5" aria-controls="ui-accordion-accordion-panel-5" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Engine
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-5" aria-labelledby="ui-accordion-accordion-header-5" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="en/products/cid19/air-filter/">Air filter</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid9354/belt/">Belt</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid15/crankshaft-and-balancer-shaft/">Crankshaft and balancer shaft</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid21/exhaust/">Exhaust</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid20/fuel-pump/">Fuel pump</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid18/fuel-tank/">Fuel tank</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid9942/oil-filter/">Oil filter</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid14/piston-and-liner-kit/">Piston and liner kit</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid17/radiator/">Radiator</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid16/water-pump/">Water pump</a>
                            </li>
                        </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-6" aria-controls="ui-accordion-accordion-panel-6" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Front axle 2WD
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-6" aria-labelledby="ui-accordion-accordion-header-6" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="en/products/cid25/front-axle/">Front axle</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid23/spindles/">Spindles</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid26/steering-box/">Steering box</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid24/tie-rods/">Tie rods</a>
                            </li>
                        </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-7" aria-controls="ui-accordion-accordion-panel-7" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Front axle 4WD
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-7" aria-labelledby="ui-accordion-accordion-header-7" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="en/products/cid27/4wd-axle/">4WD axle</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid29/front-axle/">Front axle</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid30/steering-box/">Steering box</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid28/tie-rods/">Tie rods</a>
                            </li>
                        </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-8" aria-controls="ui-accordion-accordion-panel-8" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Gearbox
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-8" aria-labelledby="ui-accordion-accordion-header-8" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="en/products/cid31/gearbox/">Gearbox</a>
                            </li>
                        </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-9" aria-controls="ui-accordion-accordion-panel-9" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Lifting drive
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-9" aria-labelledby="ui-accordion-accordion-header-9" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="en/products/cid34/hydraulic-pump/">Hydraulic pump</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid35/lift-shaft/">Lift shaft</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid36/lowerlink-sensing-shaft/">Lowerlink sensing shaft</a>
                            </li>
                        </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-10" aria-controls="ui-accordion-accordion-panel-10" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Linkage
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-10" aria-labelledby="ui-accordion-accordion-header-10" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="en/products/cid9577/front-hitch/">Front hitch</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid37/levelling-box/">Levelling box</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid40/lower-link-arm/">Lower link arm</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid39/stabiliser/">Stabiliser</a>
                            </li>
                            <li class="active">
                            <a href="en/products/cid38/top-link/">Top link</a>
                            </li>
                        </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-11" aria-controls="ui-accordion-accordion-panel-11" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Transmission and PTO
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-11" aria-labelledby="ui-accordion-accordion-header-11" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="en/products/cid32/transmission-and-pto/">Transmission and PTO</a>
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>
                            
                <!-- CAMBIAR IDIOMA FRANCES -->
            <?php }else{ ?>
                <div id="block-views-listado-secciones-block" class="block block-views even accor">
                    <div id="accordion" class="accordionss ui-accordion ui-widget ui-helper-reset accordionIZQ" role="tablist">
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-0" aria-controls="ui-accordion-accordion-panel-0" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Freinage
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-0" aria-labelledby="ui-accordion-accordion-header-0" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="fr/produits/cid33/freinage/">Freinage</a>
                            </li>
                        </ul>
                        </div>





                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-1" aria-controls="ui-accordion-accordion-panel-1" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Carrosserie et cabine
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-1" aria-labelledby="ui-accordion-accordion-header-1" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="fr/produits/cid47/accessoires/">Accesoires</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid46/carrosserie/">Carrosserie</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid45/decalcomanie/">Décalcomanie</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid48/vitres/">Vitres</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid49/poignee-et-serrure/">Poignée et serrure</a>
                            </li>
                            <li class="active">
                                    <span style='color: #151213;font-size: 13px;line-height: 18px;font-weight: 600;'>Sièges</span>
                                    <ul style="margin-left: 15px;">
                                        <li style='color: #151213;font-size: 13px;line-height: 22px;font-weight: 600;'><a href='fr/produits/cid10322/sieges-mecaniques/'>Sièges mécaniques</a></li>
                                        <li style='color: #151213;font-size: 13px;line-height: 22px;font-weight: 600;'><a href='fr/produits/cid10323/sieges-pneumatiques/'>Sièges pneumatiques</a></li>
                                        <li style='color: #151213;font-size: 13px;line-height: 22px;font-weight: 600;'><a href='fr/produits/cid10324/composant-sieges/'>Composant sièges</a></li>
                                    </ul>
                            </li>
                        </ul>
                        </div>


                        <!-- list -->
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-2" aria-controls="ui-accordion-accordion-panel-2" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Cables
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-2" aria-labelledby="ui-accordion-accordion-header-2" role="tabpanel" aria-expanded="false" aria-hidden="true">
                            <ul>
                                <li class="active">
                                <a href="fr/produits/cid50/cable-embrayage-et-pris-de-force/">Cable d'embrayage et pris de force</a>
                                </li>
                                <li class="active">
                                <a href="fr/produits/cid51/cable-arret/">Cable d'arret</a>
                                </li>
                                <li class="active">
                                <a href="fr/produits/cid52/cable-accelerateur/">Cable d'accelerateur</a>
                                </li>
                            </ul>
                        </div>



                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-3" aria-controls="ui-accordion-accordion-panel-3" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Embrayage
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-3" aria-labelledby="ui-accordion-accordion-header-3" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="fr/produits/cid22/embrayage/">Embrayage</a>
                            </li>
                        </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-4" aria-controls="ui-accordion-accordion-panel-4" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Electricité
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-4" aria-labelledby="ui-accordion-accordion-header-4" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="fr/produits/cid42/alternateurs/">Alternateurs</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid43/instrumentation/">Instrumentation</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid44/eclairage/">Eclairage</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid41/démarreur/">Démarreur</a>
                            </li>
                        </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-5" aria-controls="ui-accordion-accordion-panel-5" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Moteur
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-5" aria-labelledby="ui-accordion-accordion-header-5" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="fr/produits/cid19/filtre-a-air/">Filtre à air</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid9354/courroies/">Courroies</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid15/vilebrequin-et-arbre-d-equilibrage/">Vilebrequin et arbre d'equilibrage</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid21/echappement/">Echappement</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid20/pompe-d-alimentation/">Pompe d'alimentation</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid18/Reservoir/">Réservoir</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid9942/filtre-a-huile/">Filtre à huile</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid14/ensemble-chemise-piston-segments/">Ensemble chemise-piston-segments</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid17/radiateur/">Radiateur</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid16/pompe-a-eau/">Pompe à eau</a>
                            </li>
                        </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-6" aria-controls="ui-accordion-accordion-panel-6" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Pont avant 2WD
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-6" aria-labelledby="ui-accordion-accordion-header-6" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="fr/produits/cid25/pont-avant/">Pont avant</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid23/fusee-de-direction/">Fusée de direction</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid26/colonne-de-direction/">Colonne de direction</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid24/rotule-de-direction/">Rotule de direction</a>
                            </li>
                        </ul>
                        </div>



                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-7" aria-controls="ui-accordion-accordion-panel-7" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Pont avant 4WD
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-7" aria-labelledby="ui-accordion-accordion-header-7" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="en/produits/cid27/transmission-d-avant/">Transmission d'avant</a>
                            </li>
                            <li class="active">
                            <a href="en/produits/cid29/pont-avant/">Pont avant</a>
                            </li>
                            <li class="active">
                            <a href="en/produits/cid30/colonne-de-direction/">Colonne de direction</a>
                            </li>
                            <li class="active">
                            <a href="en/produits/cid28/rotule-de-direction/">Rotule de direction</a>
                            </li>
                        </ul>
                        </div>


                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-8" aria-controls="ui-accordion-accordion-panel-8" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Boite de vitesse
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-8" aria-labelledby="ui-accordion-accordion-header-8" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="fr/produits/cid31/boite-de-vitesse/">Boite de vitesse</a>
                            </li>
                        </ul>
                        </div>


                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-9" aria-controls="ui-accordion-accordion-panel-9" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Relevage hydraulique
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-9" aria-labelledby="ui-accordion-accordion-header-9" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="fr/produits/cid34/pompe-hydraulique/">Pompe hydraulique</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid35/arbre-de-relevage/">Arbre de relevage</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid36/barre-de-controle-d-effort/">Barre de contrôle d'effort</a>
                            </li>
                        </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-10" aria-controls="ui-accordion-accordion-panel-10" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Attelage
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-10" aria-labelledby="ui-accordion-accordion-header-10" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="fr/produits/cid9577/attelage-avant/">Attelage avant</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid37/tirant-de-relevage/">Tirant de relevage</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid40/bras-de-relevage/">Bras de relevage</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid39/stabilisateur/">Stabilisateur</a>
                            </li>
                            <li class="active">
                            <a href="fr/produits/cid38/barre-de-poussee/">Barre de poussée</a>
                            </li>
                        </ul>
                        </div>
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-accordion-header-11" aria-controls="ui-accordion-accordion-panel-11" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon ui-icon-circle-arrow-e"></span>Transmission et Prise de force
                        </h3>
                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-accordion-panel-11" aria-labelledby="ui-accordion-accordion-header-11" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        <ul>
                            <li class="active">
                            <a href="fr/produits/cid32/transmission-et-prise-de-force/">Transmission et Prise de force</a>
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        
        <div id="block-views-listado-de-fabricantes-2-block" class="block block-views first odd">
            <h3><?=${"lang_".$idioma}['marca']['plural'];?></h3>
            <span id="toggle-marcas"></span>
            <div id="acordeon-marcas">
                <div class="view view-listado-de-fabricantes-2 view-id-listado_de_fabricantes_2 view-display-id-block view-dom-id-6f2811a859a0239858dacb1b3fb295d1">
                    <div class="view-content">
                        <div class="lista-fabricantes">
                            <ul id='lista-fabricantes'>
                                
                            </ul>
                        </div>
                    </div>
                </div>
                <span id="ver-mas-marcas"><?=${"lang_".$idioma}['verotrasmarcas'];?></span>
                <div id="mas-marcas">
                    <div class="view view-listado-de-fabricantes-2 view-id-listado_de_fabricantes_2 view-display-id-mas_fabricantes view-dom-id-d9602306be4857fa683dda60ddf32e51">
                        <div class="view-content">
                            <div class="lista-fabricantes">
                                <ul id='lista-fabricantes2'>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="block-block-2" class="block block-block last odd">
            <div id="block-views-listado-secciones-block2" class="block block-views even">
                <h3 class="titulo-bloque flechaderecha">
                <a href="<?=$idioma?>/<?=${"lang_".$idioma}['productos']['url'];?>/<?=${"lang_".$idioma}['accesoriosurl'];?>/" title="<?=${"lang_".$idioma}['accesorios'];?>"><?=${"lang_".$idioma}['accesorios'];?></a>           
                </h3>
            </div>
        </div>
    </div>
</div>
