<div id="page">
    <div id="main">
        <?php
            include 'modules/lateral/buscador-avanzado.php';
        ?>

        <div id='content' class='column ocultBusca' role='main'>
            <h1 class='page__title title' id='page-title' style="display: flex;justify-content: space-between;">
                <div style="width: 148px;">Datos del pedido web</div>
                <div style="width: 148px;color: #ac0e0e;cursor: pointer;" id='cerrar-sesion'>(Cerrar Sesión)</div>
            </h1>
            <div class='field field-name-body field-type-text-with-summary field-label-hidden'>
                <div class='field-items' style="width: 100%;">
                    <div class='field-item even' property='content:encoded'>
                        <div>
                            <a href="http://www.fusterrepuestos.local/es/perfil/">Volver al Perfil</a> 
                        </div>

                        <div class="datos-pedido" style="margin-top: 50px;margin-bottom: 15px;">
	                        <h4 style="margin-bottom: 25px;">Detalles del Pedido Web - <span id='pedidoIdd'></span></h4>

                            <div id='datosGenerales' style="margin-bottom: 38px;">
                                <ul style="line-height: 28px;">
                                    <li style='color:#000'>Distribuidor: <span class='distr' style='color:#765517'></span></li>
                                    <li style='color:#000'>Dirección de envio por defecto: <span class='direEnv' style='color:#765517'></span></li>
                                    <li style='color:#000'>Fecha de solicitud: <span class='fechaSol' style='color:#765517'></span></li>
                                    <li style='color:#000'>Total: <span class='tottal' style='color:#765517'></span></li>
                                </ul>
                            </div>

                            <table id="example" class="display" style="width:100%;padding-top: 18px;">
                                <thead>
                                    <tr>
                                        <th>refFuster</th>
                                        <th>Cantidad</th>
                                        <th>Precio (€)</th>
                                        <th>Total (€)</th>
                                    </tr>
                                </thead>
                                <tbody id="pedidos">
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>refFuster</th>
                                        <th>Cantidad</th>
                                        <th>Precio (€)</th>
                                        <th>Total (€)</th>
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