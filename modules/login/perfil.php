<div id="page">
    <div id="main">
        <?php
            include 'modules/lateral/buscador-avanzado.php';
        ?>

        <div id='content' class='column ocultBusca' role='main'>
            <h1 class='page__title title' id='page-title' style="display: flex;justify-content: space-between;">
                <div style="width: 148px;"><?=${"lang_".$idioma}['datosPerfil'];?></div>
                <div style="width: 148px;color: #ac0e0e;cursor: pointer;" id='cerrar-sesion'>(Cerrar Sesión)</div>
            </h1>
            <div class='field field-name-body field-type-text-with-summary field-label-hidden'>
                <div class='field-items' style="width: 100%;">
                    <div class='field-item even' property='content:encoded'>
                        <div>
                            <a href="http://www.fusterrepuestos.local/es/perfil/#perfilData">Información de Perfil</a> | 
                            <a href="http://www.fusterrepuestos.local/es/perfil/#direccionesData">Direcciones de Envio</a> | 
                            <a href="http://www.fusterrepuestos.local/es/perfil/#pedidosData">Historial de Pedidos</a> | 
                        </div>
                        <div class="datos-perfil">
                            
    
                        </div>

                        <hr style="margin: 77px;margin-bottom: 69px;">

                        <div id="pedidosData">
	                        <h4 style="margin-bottom: 25px;">Historial de Pedidos Webs</h4>

                            <table id="example" class="display" style="width:100%;padding-top: 18px;">
                                <thead>
                                    <tr>
                                        <th>Pedido</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Cantidad</th>
                                        <th>Valor</th>
                                        <th></th>
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
                                        <th>Valor</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <hr style="margin: 77px;margin-bottom: 69px;">

                        <div id="pedidosData">
	                        <h4 style="margin-bottom: 25px;">Historial de Ordenes</h4>

                            <table id="example2" class="display" style="width:100%;padding-top: 18px;">
                                <thead>
                                    <tr>
                                        <th>Orden</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Cantidad</th>
                                        <th>Valor</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="ordenes">
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Orden</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Cantidad</th>
                                        <th>Valor</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <hr style="margin: 77px;margin-bottom: 69px;">


                    </div>
                </div>
            </div>
        </div>

        <?php 
            include 'modules/busqueda/resultadoBusqueda.php';
        ?>
    </div>
</div>