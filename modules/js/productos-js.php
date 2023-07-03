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

	var palabra1 = 'productos';
	if(idioma == 'en'){
	palabra1 = 'products';
	}
	if(idioma == 'fr'){
	palabra1 = 'produits';
	}
	if(path.match(/\/mid([0-9]+)\//)){
		if(path.match(/\/modelos/)){
			var P1M = path.match(/\/mid([0-9]+)\//).pop();
			var P2URL = (path.split('/'))[4];

			var PModelos = (path.split('/'))[5];
			const myArray = PModelos.split("-");
			myArray.splice(0, 1);
			myArray.splice(myArray.length - 1, 1);
			
			PModelos = '';
			for (let index = 0; index < myArray.length; index++) {
				PModelos += myArray[index]+",";
			}
			// console.log(myArray);			

			$.ajax({
				method: "GET",
				url: "<?=$base;?>000_admin/_rest/api.php?action=listarCategoriasByMarca&marc="+P1M+"&mod="+PModelos
			}).done(function(response) {
				if(response){
					var data = JSON.parse(response);
					var result = data.result;

					var dataShow = '';
					var cant = 0;
					if(data.code == 1 && result.length > 0){
						
						var aux = 0;
						result.forEach(function(row, index) {
							var hijos = row.hijos;
							if(hijos.length > 0){
								aux++;
							}
						});

						var cantFilas = result.length/4;
						
						console.log(result);
						console.log('cantFilas:' + cantFilas);

						result.forEach(function(row, index) {
							if(cant % 4 == 0){
								dataShow += '<div class="masonryColumnBis">';
							}
								
							var nombre = row.nbPadre;
							var hijos = row.hijos;
							var imgPadre = row.imgPadre;
							var idP = row.idPadre;

							if(hijos.length > 0){
								cant++;
								dataShow += '\
									<li class="producto-item">\
										<div class="miniatura-item">\
											<img\
												src="assets/images/categorias/'+imgPadre+'.png"\
												alt="..."\
												title="..."\
												width="100"\
												height="86"\
											/>\
											<h3>'+nombre+'</h3>\
										</div>\
										<ul>';
										hijos.forEach(function(row2, index2) {
											var nombreHijo = row2.categorias;
											var cantidadHijo = row2.cantidadRepuestos;
											var idHijo = row2.categoriasId;
											var nombreHijoURL = cleanName(nombreHijo);

											dataShow += '\
											<li>\
												<div class="product-category"><a href="#" class="clickHijoCateBusqueda" data-id="'+idHijo+'" data-marca="'+P1M+'"  data-modelo="'+PModelos+'">'+nombreHijo+'</a><span>'+cantidadHijo+'</span></div>\
											</li>';

										});
										// <div class="product-category"><a href="'+idioma+'/'+palabra1+'/mid'+P1M+'/cid'+idHijo+'/'+P2URL+'/'+nombreHijoURL+'/">'+nombreHijo+'</a><span>'+cantidadHijo+'</span></div>\


									dataShow += '\
										</ul>\
									</li>';
							}
										
							if(cant % 4 == 0){
								dataShow += '</div>';
								cant=0;
							}
						});

						$('#listadoCategorias').html(dataShow);

					}
				}
			});
		}else{
			var P1M = path.match(/\/mid([0-9]+)\//).pop();
			var P2URL = (path.split('/'))[4];
			$.ajax({
				method: "GET",
				url: "<?=$base;?>000_admin/_rest/api.php?action=listarCategoriasByMarca&marc="+P1M
			}).done(function(response) {
				if(response){
					var data = JSON.parse(response);
					var result = data.result;

					var dataShow = '';
					var cant = 0;
					if(data.code == 1 && result.length > 0){
						
						var aux = 0;
						result.forEach(function(row, index) {
							var hijos = row.hijos;
							if(hijos.length > 0){
								aux++;
							}
						});

						var cantFilas = result.length/4;
						
						console.log(result);
						console.log('cantFilas:' + cantFilas);

						result.forEach(function(row, index) {
							if(cant % 4 == 0){
								dataShow += '<div class="masonryColumnBis">';
							}
								
							var nombre = row.nbPadre;
							var hijos = row.hijos;
							var imgPadre = row.imgPadre;
							var idP = row.idPadre;

							if(hijos.length > 0){
								cant++;
								dataShow += '\
									<li class="producto-item">\
										<div class="miniatura-item">\
											<img\
												src="assets/images/categorias/'+imgPadre+'.png"\
												alt="..."\
												title="..."\
												width="100"\
												height="86"\
											/>\
											<h3>'+nombre+'</h3>\
										</div>\
										<ul>';
										hijos.forEach(function(row2, index2) {
											var nombreHijo = row2.categorias;
											var cantidadHijo = row2.cantidadRepuestos;
											var idHijo = row2.categoriasId;
											var nombreHijoURL = cleanName(nombreHijo);

											dataShow += '\
											<li>\
												<div class="product-category"><a href="'+idioma+'/'+palabra1+'/mid'+P1M+'/cid'+idHijo+'/'+P2URL+'/'+nombreHijoURL+'/">'+nombreHijo+'</a><span>'+cantidadHijo+'</span></div>\
											</li>';

										});

									dataShow += '\
										</ul>\
									</li>';
							}
										
							if(cant % 4 == 0){
								dataShow += '</div>';
								cant=0;
							}
						});

						$('#listadoCategorias').html(dataShow);

					}
				}
			});
		}
	}else{
		$.ajax({
			method: "GET",
			url: "<?=$base;?>000_admin/_rest/api.php?action=listarCategoriasInicio"
		}).done(function(response) {
			if(response){
				var data = JSON.parse(response);
				var result = data.result;
				console.log(result)
				var dataShow = '';
				var cant = 0;
				if(data.code == 1 && result.length > 0){
					result.forEach(function(row, index) {
						if(cant % 5 == 0){
							dataShow += '<div class="masonryColumnBis">';
						}
							cant++;
							var nombre = row.nbPadre;
							var hijos = row.hijos;
							var imgPadre = row.imgPadre;
							var idP = row.idPadre;

							dataShow += '\
								<li class="producto-item">\
									<div class="miniatura-item">\
										<img\
										src="assets/images/categorias/'+imgPadre+'.png"\
											alt="..."\
											title="..."\
											width="100"\
											height="86"\
										/>\
										<h3  style="font-weight: 700;">'+nombre+'</h3>\
									</div>\
									<ul>';
									hijos.forEach(function(row2, index2) {
										var nombreHijo = row2.nombre;
										var cantidadHijo = row2.cantidad;
										var idHijo = row2.id;
										var nombreHijoURL = cleanName(nombreHijo);

										dataShow += '\
										<li>\
											<div class="product-category"><a href="'+idioma+'/'+palabra1+'/cid'+idHijo+'/'+nombreHijoURL+'/">'+nombreHijo+'</a><span>'+cantidadHijo+'</span></div>\
										</li>';

										
									});

									if(idioma == 'es'){
											if(idP == 11){
												dataShow += '\
												<li>\
													<div class="product-category">Asientos</div>\
													<ul style="margin-top: 7px;margin-bottom: 7px;">\
														\
														<li class="group"  style="margin-right: 0px;display: flex;align-items: center;">\
															<label for="item-2-0" style="font-weight: 400;">\
															<a href="es/'+palabra1+'/cid10322/asientos-mecanicos/">Asientos mecánicos</a></label>\
															<span>8</span>\
														</li>\
														<li class="group"  style="margin-right: 0px;display: flex;align-items: center;">\
															<label for="item-2-0" style="font-weight: 400;">\
															<a href="es/'+palabra1+'/cid10323/asientos-neumaticos/">Asientos neumáticos</a></label>\
															<span>1</span>\
														</li>\
														<li class="group"  style="margin-right: 0px;display: flex;align-items: center;">\
															<label for="item-2-0" style="font-weight: 400;">\
															<a href="es/'+palabra1+'/cid10324/despiece-asientos/">Despiece asientos</a></label>\
															<span>1</span>\
														</li>\
													</ul>\
													\
												</li>';
											}
										}else{
											if(idioma == 'fr'){
												if(idP == 11){
													dataShow += '\
													<li>\
														<div class="product-category">Seat</div>\
														<ul style="margin-top: 7px;margin-bottom: 7px;">\
															\
															<li class="group"  style="margin-right: 0px;display: flex;align-items: center;">\
																<label for="item-2-0" style="font-weight: 400;">\
																<a href="fr/'+palabra1+'/cid10322/sieges-mecaniques/">Sièges mécaniques</a></label>\
																<span>8</span>\
															</li>\
															<li class="group"  style="margin-right: 0px;display: flex;align-items: center;">\
																<label for="item-2-0" style="font-weight: 400;">\
																<a href="fr/'+palabra1+'/cid10323/sieges-pneumatiques/">Sièges pneumatiques</a></label>\
																<span>1</span>\
															</li>\
															<li class="group"  style="margin-right: 0px;display: flex;align-items: center;">\
																<label for="item-2-0" style="font-weight: 400;">\
																<a href="fr/'+palabra1+'/cid10324/composants-siege/">Composants du siège</a></a></label>\
																<span>1</span>\
															</li>\
														</ul>\
														\
													</li>';
												}
											}

											if(idioma == 'en'){
												if(idP == 11){
													dataShow += '\
													<li>\
														<div class="product-category">Seat</div>\
														<ul style="margin-top: 7px;margin-bottom: 7px;">\
															\
															<li class="group"  style="margin-right: 0px;display: flex;align-items: center;">\
																<label for="item-2-0" style="font-weight: 400;">\
																<a href="en/'+palabra1+'/cid10322/mechanical-seats/">Mechanical seats</a></label>\
																<span>8</span>\
															</li>\
															<li class="group"  style="margin-right: 0px;display: flex;align-items: center;">\
																<label for="item-2-0" style="font-weight: 400;">\
																<a href="en/'+palabra1+'/cid10323/pneumatic-seats/">Pneumatic seats</a></label>\
																<span>1</span>\
															</li>\
															<li class="group"  style="margin-right: 0px;display: flex;align-items: center;">\
																<label for="item-2-0" style="font-weight: 400;">\
																<a href="en/'+palabra1+'/cid10324/seat-components/">Seat components</a></label>\
																<span>1</span>\
															</li>\
														</ul>\
														\
													</li>';
												}
											}
										}


								dataShow += '\
									</ul>\
								</li>';
						if(cant % 4 == 0){
							dataShow += '</div>';
							cant=0;
						}
					});

					$('#listadoCategorias').html(dataShow);

				}
			}
		});
	}

	$.ajax({
		method: "GET",
		url: "<?=$base;?>000_admin/_rest/api.php?action=listarMarcasLateral"
	}).done(function(response) {
		if(response){
			var data = JSON.parse(response);
			var result = data.result;
			var dataShow = '';
			var dataShow2 = '';
			var i = 0;
			if(data.code == 1 && result.length > 0){
				result.forEach(function(row, index) {
					if(row['orden'] != -1){
						var id = row['id'];
						var marca = row['marca'];
						var marcaURL = cleanName(row['marca']);

						if(idioma == 'es'){
							dataShow += '<li class="item-fabricante"><a href="es/productos/mid'+id+'/'+marcaURL+'/"> '+marca+' </a></li>';
						}else if(idioma == 'fr'){
							dataShow += '<li class="item-fabricante"><a href="fr/produits/mid'+id+'/'+marcaURL+'/"> '+marca+' </a></li>';
						}else{
							dataShow += '<li class="item-fabricante"><a href="en/products/mid'+id+'/'+marcaURL+'/"> '+marca+' </a></li>';
						}
						i++;
					}

					if(row['orden'] == -1){
						var id = row['id'];
						var marca = row['marca'];
						var marcaURL = cleanName(row['marca']);

						if(idioma == 'es'){
							dataShow2 += '<li class="item-fabricante"><a href="es/productos/mid'+id+'/'+marcaURL+'/"> '+marca+' </a></li>';
						}if(idioma == 'fr'){
							dataShow2 += '<li class="item-fabricante"><a href="fr/produits/mid'+id+'/'+marcaURL+'/"> '+marca+' </a></li>';
						}else{
							dataShow2 += '<li class="item-fabricante"><a href="en/products/mid'+id+'/'+marcaURL+'/"> '+marca+' </a></li>';
						}
					}
				});
			}
		}

		$('#lista-fabricantes').html(dataShow);
		$('#lista-fabricantes2').html(dataShow2);


	});
});
</script>