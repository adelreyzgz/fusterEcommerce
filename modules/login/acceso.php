<div id="page">
    <div id="main">
        <?php
            include 'modules/lateral/buscador-avanzado.php';
        ?>

        <div id='content' class='column ocultBusca' role='main'>
            <h1 class='page__title title' id='page-title'><?=${"lang_".$idioma}['acceso'];?></h1>
            <div class='field field-name-body field-type-text-with-summary field-label-hidden'>
                <div class='field-items' style="width: 360px;">
                    <div class='field-item even' property='content:encoded'>
                        <p style="color:#141213;">
                            <?=${"lang_".$idioma}['introduzca'];?>
                        </p>

                        <div class="formulario-contacto">

                            <div id='errorGeneral' style="font-size: 14px;color: #F26440; margin-top: 10px; margin-bottom: -16px;"></div>

                            <form action="" method="post" id="fuster-login-site-form" accept-charset="UTF-8">
                                <div>
                                    <div class="form-item form-type-textfield form-item-email" style="margin-bottom: 4px;">
                                        <label for="edit-email" style="font-weight: 700;"><?=${"lang_".$idioma}['usuario'];?>*</label>
                                        <input type="text" id="edit-usuario" name="usuario" value="" required size="60" maxlength="128" class="form-text required" style="padding: 9px 14px;color: #929292;height: 39px;" placeholder="Introduzca su usuario" />
                                    </div>
                                    <div id='errorEmail' style="font-size: 14px;color: #F26440; margin-bottom: 25px;"></div>

                                    <div class="form-item form-type-textfield form-item-password" style="margin-bottom: 25px;overflow-x: hidden;">
                                        <label for="edit-password"></label>

                                        <label for="edit-password" style="width: 100%;">
                                            <div style="display: flex;justify-content: space-between;font-weight: 700;">
                                                <?=${"lang_".$idioma}['password'];?>*
                                                <a href="" class='olvidado'><?=${"lang_".$idioma}['hasolvidado'];?></a>
                                            </div>
                                        </label>
                                        <input type="password" id="edit-password" name="password" value="" required size="60" maxlength="128" class="form-text required" style="padding: 9px 14px;color: #929292;height: 39px;"  placeholder="*******"/>
                                    </div>
                                    <button class="form-submit btnbuscarContact btnLogin" style="width: 100%;">
                                        <?=${"lang_".$idioma}['continuar'];?>
                                    </button>
                                </div>
                            </form>
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