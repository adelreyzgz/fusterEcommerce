
<div id="page">
    <div id="main">
        <?php
            include 'modules/lateral/buscador-avanzado.php';
        ?>

        <div id="content" class="column ocultBusca"  role="main">
            
            <h1 class="page__title title nombreProdHtml" id="page-title"><?=$nombreP?> <?=$refFusterP;?> - <?=$nombreM;?> </h1>
            
            <?php
            if(isset($_SESSION['enviadoMail']) && $_SESSION['enviadoMail']){
                $_SESSION['enviadoMail'] = 0;
            ?>
                <div class="messages--status messages status" style="margin-bottom: 30px;"><h2 class="element-invisible">Mensaje de estado</h2>Su solicitud ha sido enviada. Contactaremos con Vd. lo antes posible.</div>
            <?php } ?>


            <?php
            if(isset($_SESSION['enviadoMail']) && $_SESSION['enviadoMail'] == -1){
                $_SESSION['enviadoMail'] = 0;
            ?>
                <div class="messages--status messages status" style="margin-bottom: 30px;background-color: #ffcaca;border-color: #ffcaca;color: #505654 !important;background-image: url(../../assets/images/message-24-error.png);"><h2 class="element-invisible">Mensaje de estado</h2>Su solicitud no ha sido enviada. Por favor intentelo nuevamente.</div>
            <?php } ?>


            <article class="node-112905 node node-producto node-promoted view-mode-full clearfix" about="/es/content/tuerca-hexagonal-izquierda-cabeza-32-mms-0" typeof="sioc:Item foaf:Document">
                <div class="ficha-producto">

                    <?php
                        $mostr = '';
                        if(!$imgProd2){
                            $mostr = 'display:none;';
                        }
                    ?>
                    <div class="ficha-foto">
                        <script>contagen = 0;</script>
                        <a href="javascript: void(0);" onclick="lanzarslide();" id="foto-ampliada"><img
                                id="foto-producto"
                                src="<?=$imgProd;?>"
                                alt="<?=$titlePP;?>" title="<?=$titlePP;?>"></a>
                        <ul id="lightgallery">
                            <li style='<?=$mostr;?>' data-responsive="<?=$imgProd;?> 240, <?=$imgProd;?> 480, <?=$imgProd;?> 960"
                                data-src="<?=$imgProd;?>"
                                data-sub-html="">
                                <a href="javascript:void(0);"
                                    onclick="cambiar_foto('<?=$imgProd;?>',	0);"><img
                                        id="enlaceimagen0" class="img-responsive"
                                        src="<?=$imgProd;?>"
                                        alt="<?=$titlePP;?>" title="<?=$titlePP;?>"></a>
                            </li>

                            <?php
                                    if($imgProd2){
                            ?>
                                <li data-responsive="<?=$imgProd2;?> 240, <?=$imgProd2;?> 480, <?=$imgProd2;?> 960"
                                data-src="<?=$imgProd2;?>"
                                data-sub-html="">
                                    <a href="javascript:void(0);"
                                    onclick="cambiar_foto('<?=$imgProd2;?>', 1);"><img
                                        id="enlaceimagen1" class="img-responsive"
                                        src="<?=$imgProd2;?>"
                                        alt="<?=$titlePP;?>" title="<?=$titlePP;?>"></a>
                                </li>
                            <?php
                                }
                            ?>

                            <?php
                                if($imgProd3){
                            ?>
                                <li data-responsive="<?=$imgProd3;?> 240, <?=$imgProd3;?> 480, <?=$imgProd3;?> 960"
                                data-src="<?=$imgProd3;?>"
                                data-sub-html="">
                                    <a href="javascript:void(0);"
                                    onclick="cambiar_foto('<?=$imgProd3;?>',	1);"><img
                                        id="enlaceimagen1" class="img-responsive"
                                        src="<?=$imgProd3;?>"
                                        alt="<?=$titlePP;?>" title="<?=$titlePP;?>"></a>
                                </li>
                            <?php
                                }
                            ?>
                            
                        </ul>
                    </div>

                    
                    <div class="ficha-info">
                        <div class='ficha-general'>
                            <div class="field field-name-field-field-rf-producto field-type-text field-label-above">
                                <div class="field-label fl" style=""><span><?=${"lang_".$idioma}['ndereferencia'];?>:</span></div>
                                <div class="field-items">
                                    <div class="field-item even"><p><?=$refFusterP;?> <span class="precioProductos" style="margin-left:10px;">   </span></p></div>
                                </div>
                               
                            </div>
                            <div class="field field-name-field-descripcion-producto field-type-text field-label-above">
                                <div class="field-label fl" style=""><span><?=${"lang_".$idioma}['descripcion'];?>:</span></div>
                                <div class="field-items">
                                    <div class="field-item even"><p><?=$descripcionP;?></p></div>
                                </div>
                            </div>

                            <?php if($caracteristicas){ ?>
                                <div class="field field-name-field-descripcion-producto field-type-text field-label-above">
                                    <div class="field-label fl" style=""><span><?=${"lang_".$idioma}['datostecnicos'];?>:</span></div>
                                    <div class="field-items">
                                        <div class="field-item even">
                                            <?php
                                            $j = 0;
                                            $dCaract = '';
                                            foreach ($caracteristicas as $valor){
                                                $j++;
                                                if($j==count($caracteristicas)){
                                                     $dCaract .='<div class="bloque-caracteristica"><label>'.$valor["alias"].'</label>'.$valor["valor"].'<span class="tuberia"></span></div>';
                                                }else{
                                                     $dCaract .='<div class="bloque-caracteristica"><label>'.$valor["alias"].'</label>'.$valor["valor"].'<span class="tuberia">|</span></div>';
                                                }
                                            }

                                            echo $dCaract;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="divCarrito">
                                
                            </div>
                        </div>

                        <div class='listadoResumen'>
                           
                        </div>
                    </div>
                    

                    <div class='contenedorDespieces'>
                        <div class='loading'>
                            <div class="spinner-border"  style='border: .25em solid #e6e2dc;border-right-color: transparent;' role="status"></div>
                        </div>
                    </div>

                    <div class="ficha-embrague">
                        <div class='loading'>
                            <div class="spinner-border"  style='border: .25em solid #e6e2dc;border-right-color: transparent;' role="status"></div>
                        </div>
                    </div>

                    <div class="consulta-rss">
                        <script>
                            jQuery(function() {
                                jQuery('#consultar').click(function() {
                                    jQuery('.consultar-formulario').toggle();
                                    return false;
                                });
                            });
                        </script>
                        <div class="consultar-boton">
                            <p>
                            <img src="assets/icons/icon-ask.png" alt="Ask icon" width="50" height="50"><?=${"lang_".$idioma}['tienesAlgunaPreg'];?> <span id="consultar"><?=${"lang_".$idioma}['consultar'];?></span>
                            </p>
                        </div>
                        <div class="social-botones">
                            <?php
                                $url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]
                            ?>
                            <img class="compartir-icon" onclick="window.print()" src="assets/icons/icon-print.png" alt="Imprimir" title="Imprimir">
                            <img class="compartir-icon" onclick="window.open('//www.facebook.com/sharer.php?u=<?=$url;?>', 'sharer', 'toolbar=0,status=0,width=660,height=445');" src="assets/icons/icon-fb.png" alt=" Share on Facebook" title="Compartir en Facebook">
                            <img class="compartir-icon" onclick="window.open('https://twitter.com/intent/tweet?text= <?=$nombreP?>, Ref. <?=$refFusterP;?>', 'sharertwt', 'toolbar=0,status=0,width=660,height=445');" src="assets/icons/icon-tw.png" alt="Compartir en Twitter" title="Compartir en Twitter">
                            <img class="compartir-icon" onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&amp;url=<?=$url;?>;title=Repuestos%20Fuster&amp;summary=<?=$nombreP?>, Ref. <?=$refFusterP;?>&amp;source=Repuestos%20Fuster', 'sharer','toolbar=0,status=0,width=660,height=445');" src="assets/icons/icon-in.png" alt="Compartir en LinkedIn" title="Compartir en LinkedIn">
                        </div>
                    </div>

                    <div class="consultar-formulario" style="display: none;">
                        <h4><?=${"lang_".$idioma}['solicitudInf'];?> <?=$nombreP?> REF: <?=$refFusterP;?></h4>
                        <form action="000_admin/_rest/api_sendmail.php" method="post" id="fuster-producto-info-form" accept-charset="UTF-8">
                        <div>
                            <div class="form-item form-type-textfield form-item-name">
                            <label for="edit-name"><?=${"lang_".$idioma}['nombre'];?> <span class="form-required" title="<?=${"lang_".$idioma}['campoObligatorio'];?>">*</span>
                            </label>
                            <input placeholder="<?=${"lang_".$idioma}['nombre'];?>" type="text" id="edit-name" required name="name" value="" size="60" maxlength="128" class="form-text required">
                            </div>
                            <div class="form-item form-type-textfield form-item-email">
                            <label for="edit-email"><?=${"lang_".$idioma}['email'];?> <span class="form-required" title="<?=${"lang_".$idioma}['campoObligatorio'];?>">*</span>
                            </label>
                            <input placeholder="<?=${"lang_".$idioma}['email'];?>" type="text" id="edit-email" required name="email" value="" size="60" maxlength="128" class="form-text required">
                            </div>
                            <div class="form-item form-type-textfield form-item-phone">
                            <label for="edit-phone"><?=${"lang_".$idioma}['telefono'];?> <span class="form-required" title="<?=${"lang_".$idioma}['campoObligatorio'];?>">*</span>
                            </label>
                                <input placeholder="<?=${"lang_".$idioma}['telefono'];?>" type="text" required id="edit-phone" name="phone" value="" size="60" maxlength="128" class="form-text required">
                            </div>
                            <input type="hidden" name="notienda" value="1">
                            <div class="form-item form-type-textarea form-item-message">
                            <label for="edit-message"><?=${"lang_".$idioma}['mensaje'];?> </label>
                            <div class="form-textarea-wrapper resizable textarea-processed resizable-textarea">
                                <textarea id="edit-message" name="message" cols="60" rows="5" class="form-textarea"></textarea>
                                <div class="grippie"></div>
                            </div>
                            </div>
                            <div id="edit-privacy1" class="form-checkboxes">
                                <div class="form-item form-type-checkbox form-item-privacy1-1">
                                    <label class="option" for="edit-privacy1-1">
                                    <p class="contact-text"><?=${"lang_".$idioma}['infoDatosCaracterPerso'];?></p>
                                    </label>
                                </div>
                            </div>
                            <div id="edit-privacy" class="form-checkboxes" style="margin-bottom: 10px;">
                            <div class="form-item form-type-checkbox form-item-privacy-1">
                                <input type="checkbox" id="edit-privacy-1" name="privacy[1]" class="form-checkbox" required>
                                <label class="option" style="margin-left: 6px;margin-top: 3px;" for="edit-privacy-1"><?=${"lang_".$idioma}['heleidoyacepto'];?> <a href="<?=$idioma;?>/<?=${"lang_".$idioma}['url']['politica-privacidad'];?>/" target="_blank"><?=${"lang_".$idioma}['politicaprivacidad'];?></a>. </label>
                            </div>
                            </div>

                            <input type="submit" class="form-submit btonsearchlateral" style="width: 151px;font-size: 13px;" value="<?=${"lang_".$idioma}['enviarConsulta'];?>">

                            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                            <input type="hidden" name="action" value="process">
                            <input type="hidden" name="ref" value="<?=$refFusterP;?>">
                            <input type="hidden" name="urlprev" value="<?=$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];?>">

                            <!-- <input type="submit" id="edit-submit--3" name="op" value="Enviar consulta" class="form-submit"> -->
                        </div>
                        </form>
                    </div>
                </div>
            </article>
        </div>

        <?php 
            include 'modules/busqueda/resultadoBusqueda.php';
        ?>
    </div>
</div>