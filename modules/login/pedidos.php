<style>
    .filters th:nth-child(2) input{
        display: initial;
    }

    input:active, input:focus {
        outline: none;
        border: 1px solid #4c4c4c;
    }

    #pedidos a{
        color: #b69d19 !important;
        text-decoration: none;
        display: flex;
        justify-content: left;
        align-items: center;
    }

    #pedidos a:hover {
        color: #000 !important;
        text-decoration: none;
    }
</style>  
<div id="page">
    <div id="main">
        <div id='content' class='column ocultBusca' role='main' style="width: 100%;">
            <h1 class='page__title title' id='page-title' style="display: flex;justify-content: space-between;">
                <div style="width: 238px;">Historial de Pedidos Webs</div>
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
                        
                        
                        <div id="pedidosData" style="margin-top: 45px;margin-bottom: 69px;">
	                        <h4 style="margin-bottom: 25px;">Historial de Pedidos Webs</h4>

                            <table id="example3" class="display" style="width:100%;padding-top: 18px;">
                                <thead>
                                    <tr>
                                        <th>Pedido</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Cantidad</th>
                                        <th>Valor (€)</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="pedidos">
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Pedido</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Cantidad</th>
                                        <th>Valor (€)</th>
                                        <th>Acción</th>
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