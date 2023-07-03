<script>
/*global $:true */

var $ = $.noConflict();
$(document).ready(function($) {
	"use strict";

	var indiceActivo=-1
	

	var path = window.location.pathname;
	var pid = path.match(/\/pid([0-9]+)\//).pop();
	var P3URL = (path.split('/'))[8];


	var palabra88 = 'Dibujo Técnico';

	if(idioma == 'en'){
		palabra88 = 'Dibujo Técnico';
	}

	if(idioma == 'fr'){
		palabra88 = 'Dibujo Técnico';
	}


	var c = { header: "ui-icon-circle-arrow-e", activeHeader: "ui-icon-circle-arrow-s" };
	if (indiceActivo > -1) {
		jQuery("#accordion").accordion({ active: indiceActivo, collapsible: !1, icons: c, heightStyle: content });
	} else {
		jQuery("#accordion").accordion({ active: !1, collapsible: !0, icons: c, heightStyle: content });
	}

	jQuery('#toggle-marcas').click(function(){jQuery('#acordeon-marcas').toggle();});
	jQuery("#toggle-buscador").click(function(){jQuery("#formBusca").toggle();});
	
	$("#lightgallery").lightGallery(); 


	$.ajax({
		method: "GET",
		url: "<?=$base;?>000_admin/_rest/api.php?action=dibujarDibujoTecnicoAccesorio&idProd="+pid
	}).done(function(response) {
		if(response){
			var data = JSON.parse(response);
			var result = data.result;
			var puntosInteres = data.puntosInteres;
			var datashow55 = '';
			for (let i = 0; i < result.length; i++) {
				var row = result[i];
				var imagenFondo = row['imagenFondo'];
				var ancho = row['ancho'];
				var alto = row['alto'];
				var coordenadaFija = JSON.parse(row['coordenada']);
				var xfija = coordenadaFija[0];
				var yfija = coordenadaFija[1];
			
				var idPlano = row['idPlano'];
				var tipoP = row['tipo'];


				if(tipoP == 'PP'){
					datashow55 += '\
						<div class="despiece">\
							<h3 class="sub-titulo">'+palabra88+'</h3>\
							<div class="dibujo-tecnico">\
							<img src="assets/images/'+tipoP+'/'+imagenFondo+'" alt="'+tipoP+'-'+ P3URL+'" title="'+tipoP+'-'+ P3URL +'" id="imagen0" width="'+ancho+'">\
							</div>\
						</div>';
					i = result.length;
				}

			}

			$('.contenedorDespieces').html(datashow55);
		}
	});	
});

function lanzarslide() { var objeto = document.getElementById("enlaceimagen" + contagen); objeto.click(); }

function cambiar_foto(archivo, conti) { 
	var objeto = document.getElementById("foto-producto"); 
	var objeto2 = document.getElementById("foto-ampliada"); 
	objeto.src = archivo; contagen = conti; 
}

function imagen_modal_avan(avance) { var objeto = document.getElementById("imagen-modal"); objeto.src = "<?=$base;?>sites/default/files/productos/es/000000000/000000000003_mangueta-derecha-960.jpg"; }


</script>