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
                        <div class="datos-perfil">
                            
    
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