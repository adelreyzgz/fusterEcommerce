
<style>
    .filters th input{
        display: initial !important;
    }

    input:active, input:focus {
        outline: none;
        border: 1px solid #4c4c4c;
    }

    #ordenes a{
        color: #b69d19 !important;
        text-decoration: none;
        display: flex;
        justify-content: left;
        align-items: center;
    }

    #ordenes a:hover {
        color: #000 !important;
        text-decoration: none;
    }
</style>
<div id="page">
    <div id="main">
        <div id='content' class='column ocultBusca' role='main' style="width: 100%;">
            <h1 class='page__title title' id='page-title' style="display: flex;justify-content: space-between;">
                <div style="width: 218px;"><?=${"lang_".$idioma}['detallesordenesB'];?></div>
                <div style="width: 148px;color: #ac0e0e;cursor: pointer;" id='cerrar-sesion'>(<?=${"lang_".$idioma}['cerrarSesion'];?>)</div>
            </h1>
            <div class='field field-name-body field-type-text-with-summary field-label-hidden'>
                <div class='field-items' style="width: 100%;">
                    <div class='field-item even' property='content:encoded'>
                        <div>
                            <a href="http://www.fusterrepuestos.local/<?=$idioma;?>/perfil/ordenes/"><?=${"lang_".$idioma}['volveral'];?> <?=${"lang_".$idioma}['ordenesB'];?></a> 
                        </div>

                        <div class="loading"><div class="spinner-border" style="border: .25em solid #e6e2dc;border-right-color: transparent;" role="status"></div></div>

                        <div class="datos-orden" id="pedids" style="margin-top: 50px;margin-bottom: 15px;display:none;">
	                        <h4 style="margin-bottom: 25px;"><?=${"lang_".$idioma}['detallesordenesB'];?> - <span id='ordenId'></span></h4>

                            <div id='datosGenerales' style="margin-bottom: 38px;">
                                <ul style="line-height: 28px;">
                                    <li style='color:#000'><?=${"lang_".$idioma}['distribuidorT'];?>: <span class='distr' style='color:#765517'></span></li>
                                    <li style='color:#000'><?=${"lang_".$idioma}['direnvT'];?>: <span class='direEnv' style='color:#765517'></span></li>
                                    <li style='color:#000'><?=${"lang_".$idioma}['totalMT'];?>: <span class='tottal' style='color:#765517'></span></li>
                                </ul>
                            </div>

                            <table id="example3" class="display" style="width:100%;padding-top: 18px;">
                                <thead>
                                    <tr>
                                        <th>refFuster</th>
                                        <th><?=${"lang_".$idioma}['cantidadT'];?></th>
                                        <th><?=${"lang_".$idioma}['precioT'];?> (€)</th>
                                        <th><?=${"lang_".$idioma}['totalMT'];?> (€)</th>
                                    </tr>
                                </thead>
                                <tbody id="ordenes">
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>refFuster</th>
                                        <th><?=${"lang_".$idioma}['cantidadT'];?></th>
                                        <th><?=${"lang_".$idioma}['precioT'];?> (€)</th>
                                        <th><?=${"lang_".$idioma}['totalMT'];?> (€)</th>
                                    </tr>
                                </tfoot>
                            </table>
    
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>