<style>
    .filters th:nth-child(2) input{
        display: initial;
    }

    input:active, input:focus {
        outline: none;
        border: 1px solid #4c4c4c;
    }

    #facturas a{
        color: #b69d19 !important;
        text-decoration: none;
        display: flex;
        justify-content: left;
        align-items: center;
    }

    #facturas a:hover {
        color: #000 !important;
        text-decoration: none;
    }
</style>  
<div id="page">
    <div id="main">
        <div id='content' class='column ocultBusca' role='main' style="width: 100%;">
            <h1 class='page__title title' id='page-title' style="display: flex;justify-content: space-between;">
                <div style="width: 238px;"><?=${"lang_".$idioma}['facturasB'];?></div>
                <div style="width: 148px;color: #ac0e0e;cursor: pointer;" id='cerrar-sesion'>(<?=${"lang_".$idioma}['cerrarSesion'];?>)</div>
            </h1>
            <div class='field field-name-body field-type-text-with-summary field-label-hidden'>
                <div class='field-items' style="width: 100%;">
                    <div class='field-item even' property='content:encoded'>
                    <div>
                            <a href="http://www.fusterrepuestos.local/<?=$idioma;?>/perfil/"><?=${"lang_".$idioma}['datosPerfil'];?></a> | 
                            <a href="http://www.fusterrepuestos.local/<?=$idioma;?>/perfil/direcciones/"><?=${"lang_".$idioma}['direccionesB'];?></a> | 
                            <a href="http://www.fusterrepuestos.local/<?=$idioma;?>/perfil/pedidos/"><?=${"lang_".$idioma}['pedidosB'];?></a> | 
                            <a href="http://www.fusterrepuestos.local/<?=$idioma;?>/perfil/ordenes/"><?=${"lang_".$idioma}['ordenesB'];?></a> | 
                            <a href="http://www.fusterrepuestos.local/<?=$idioma;?>/perfil/facturas/"><?=${"lang_".$idioma}['facturasB'];?></a> 
                        </div>
                        
                        <div id="facturasData"  style="margin-top: 45px;margin-bottom: 69px;">
	                        <h4 style="margin-bottom: 25px;"><?=${"lang_".$idioma}['facturasB'];?></h4>

                            <table id="example3" class="display" style="width:100%;padding-top: 18px;">
                                <thead>
                                    <tr>
                                        <th><?=${"lang_".$idioma}['facturaT'];?></th>
                                        <th><?=${"lang_".$idioma}['fechaT'];?></th>
                                        <th><?=${"lang_".$idioma}['totalBT'];?> (€)</th>
                                        <th><?=${"lang_".$idioma}['estadoT'];?></th>
                                        <th><?=${"lang_".$idioma}['accionT'];?></th>
                                    </tr>
                                </thead>
                                <tbody id="facturas">
                                    <tr>
                                        <td colspan="5">
                                            <div class="loading"><div class="spinner-border" style="border: .25em solid #e6e2dc;border-right-color: transparent;" role="status"></div></div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th><?=${"lang_".$idioma}['facturaT'];?></th>
                                        <th><?=${"lang_".$idioma}['fechaT'];?></th>
                                        <th><?=${"lang_".$idioma}['totalBT'];?> (€)</th>
                                        <th><?=${"lang_".$idioma}['estadoT'];?></th>
                                        <th><?=${"lang_".$idioma}['accionT'];?></th>
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