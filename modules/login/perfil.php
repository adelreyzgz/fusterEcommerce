<style>
    .filters th:nth-child(2) input{
        display: initial;
    }

    input:active, input:focus {
        outline: none;
        border: 1px solid #4c4c4c;
    }
</style>    

<div id="page">
    <div id="main">
        <div id='content' class='column ocultBusca' role='main' style="width: 100%;">
            <h1 class='page__title title' id='page-title' style="display: flex;justify-content: space-between;">
                <div style="width: 148px;"><?=${"lang_".$idioma}['datosPerfil'];?></div>
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
                        
                        <div class="datos-perfil" style="margin-top: 45px;margin-bottom: 69px;">
                            
    
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>