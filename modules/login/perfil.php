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
                <div style="width: 148px;color: #ac0e0e;cursor: pointer;" id='cerrar-sesion'>(Cerrar Sesión)</div>
            </h1>
            <div class='field field-name-body field-type-text-with-summary field-label-hidden'>
                <div class='field-items' style="width: 100%;">
                    <div class='field-item even' property='content:encoded'>
                        <div>
                            <a href="http://www.fusterrepuestos.local/es/perfil/">Información de Perfil</a> | 
                            <a href="http://www.fusterrepuestos.local/es/perfil/direcciones/">Direcciones de Envio</a> | 
                            <a href="http://www.fusterrepuestos.local/es/perfil/pedidos/">Historial de Pedidos Webs</a> | 
                            <a href="http://www.fusterrepuestos.local/es/perfil/ordenes/">Historial de Ordenes</a> | 
                            <a href="http://www.fusterrepuestos.local/es/perfil/facturas/">Historial de Facturas</a> 
                        </div>
                        
                        <div class="datos-perfil" style="margin-top: 45px;margin-bottom: 69px;">
                            
    
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>