<script>
/*global $:true */

var $ = $.noConflict();
$(document).ready(function($) {
	"use strict";

	var indiceActivo=-1

	var c = { header: "ui-icon-circle-arrow-e", activeHeader: "ui-icon-circle-arrow-s" };
	if (indiceActivo > -1) {
		jQuery("#accordion").accordion({ active: indiceActivo, collapsible: !1, icons: c, heightStyle: content });
	} else {
		jQuery("#accordion").accordion({ active: !1, collapsible: !0, icons: c, heightStyle: content });
	}

	jQuery('#toggle-marcas').click(function(){jQuery('#acordeon-marcas').toggle();});
	jQuery("#toggle-buscador").click(function(){jQuery("#formBusca").toggle();});

	var path = window.location.pathname;
	var P1 = path.match(/\/cid([0-9]+)\//).pop();
	var P2URL = (path.split('/'))[4];
    var idCategoria = P1;

	$.ajax({
		method: "GET",
		url: "<?=$base;?>000_admin/_rest/api.php?action=listarMarcasConProductos&cat="+idCategoria
	}).done(function(response) {
		if(response){
			var data = JSON.parse(response);
			var result = data.result;
			var dataShow3 = '';
			var i = 0;
			if(data.code == 1 && result.length > 0){
				result.forEach(function(row, index) {
					if(row['orden'] != -1){
						var id = row['id'];
						var marca = row['marca'];
						var imagen = row['imagen'];
						var marcaURL = cleanName(row['marca']);
						i++;

						var classs = '';
						if(i < 4){
							classs = 'marcaiz';
						}else if( i > 3 && i < 7){
							classs = 'marcader';
						}

						if(i == 6){
							i=0
						}

						var palabra1 = 'productos';
						if(idioma == 'en'){
					 	palabra1 = 'products';
						}
						if(idioma == 'fr'){
						palabra1 = 'produits';
						}
						dataShow3 += '\
						<div id="producto---" class="views-row views-row-'+i+'">\
							<div class="views-field views-field-field-marca">\
								<div class="field-content">\
									<a class="'+classs+'" href="'+idioma+'/'+palabra1+'/mid'+id+'/cid'+idCategoria+'/'+marcaURL+'/'+P2URL+'/">\
										<h3 class="rotulo-marca bloque-marca">\
											'+marca+'\
											<img class="'+classs+'" src="assets/images/marcas/'+imagen+'.png"/>\
										</h3>\
									</a>\
								</div>\
							</div>\
						</div>\
						';

					}
				});
			}
		}

		$('#list-tractores').html(dataShow3);
	});
	
});

</script>