<script>
/*global $:true */

var $ = $.noConflict();
$(document).ready(function($) {
	"use strict";

	var path = window.location.pathname;
	// console.log(path)
	// var idMarca = path.match(/\/mid([0-9]+)\//).pop();
	// var idCategoria = path.match(/\/cid([0-9]+)\//).pop();
	var marcaBusqueda = path.match(/\/mid([0-9]+)\//).pop();;


	function getQueryParams(qs) {
		qs = qs.split("+").join(" ");
		var params = {},
			tokens,
			re = /[?&]?([^=]+)=([^&]*)/g;
		while (tokens = re.exec(qs)) {
			params[decodeURIComponent(tokens[1])]
				= decodeURIComponent(tokens[2]);
		}
		return params;
	}

	var $_GET = getQueryParams(document.location.search);

	var idiom = 'es'; 
	var idioma = 'es';

	if($_GET.idioma){
		idiom = $_GET.idioma;
		idioma = $_GET.idioma;
	}else{
		var url = document.location.href;
		if(url.indexOf("/en/") > -1){
			idiom = 'en';
			idioma = 'en';
		}
		if(url.indexOf("/fr/") > -1){
			idiom = 'fr';
			idioma = 'fr';
		}

		var host = window.location.host;
		if(host.indexOf("r.fr") != -1){
			idioma = 'fr';
			idiom = 'fr';
		}
	}


	$(document).on('select2:open', () => {
		document.querySelector('.select2-search__field').focus();
	});

	
	$('.js-data-producto2').select2({
		tags: true,
		placeholder: "<?=${"lang_".$idioma}['producto'];?>",
		allowClear: true,
		ajax: {
			url: "<?=$base;?>000_admin/_rest/api.php?action=buscarNombreProductoByMarca&marca="+marcaBusqueda,
			delay: 500,
			processResults: function (response) {
			var data = JSON.parse(response);
			return {
				results: data.result
			};
			}
		}
	});

	$('.js-data-modelo2').select2({
		placeholder: "<?=${"lang_".$idioma}['modelodeltractor'];?>",
		allowClear: true,
		ajax: {
			url: "<?=$base;?>000_admin/_rest/api.php?action=buscarModeloByNombreyMarca&marca="+marcaBusqueda,
			delay: 500,
			processResults: function (response) {
				var data = JSON.parse(response);
				var result = JSON.parse(data.result);

				return {
					results: result
				};
			}
		}
	});

	$(document).on('change',  '.js-data-producto2', function(){
		var productoBusqueda = $('.js-data-producto2').val();

		if(productoBusqueda){
			productoBusqueda = productoBusqueda.split('+')[0];
		}

		$('.js-data-modelo2').val('');
		$('.js-data-modelo2').prop('disabled', false);
		
		if(!productoBusqueda){
			$('.js-data-modelo2').select2({
				placeholder: "<?=${"lang_".$idioma}['modelodeltractor'];?>",
				allowClear: true,
				ajax: {
					url: "<?=$base;?>000_admin/_rest/api.php?action=buscarModeloByNombreyMarca&marca="+marcaBusqueda,
					delay: 500,
					processResults: function (response) {
						var data = JSON.parse(response);
						var result = JSON.parse(data.result);

						return {
							results: result
						};
					}
				}
			});
		}else{
			$('.js-data-modelo2').select2({
				placeholder: "<?=${"lang_".$idioma}['modelodeltractor'];?>",
				allowClear: true,
				ajax: {
					url: "<?=$base;?>000_admin/_rest/api.php?action=buscarModeloByNombreProdyMarca&producto="+productoBusqueda+"&marca="+marcaBusqueda+"",
					delay: 500,
					processResults: function (response) {
						var data = JSON.parse(response);
						var result = JSON.parse(data.result);

						return {
							results: result
						};
					}
				}
			});
		}
		
    });
	

	$(document).on('click',  '.buscarByProdMarcModSecundary', function(){ 
		$('.listadoSinResultadoBusqueda').hide();
		
		var producto = $('.js-data-producto2').val();

		var marca = marcaBusqueda;
		var modelo = $('.js-data-modelo2').val();

		console.log(producto)
		console.log(modelo)
		alert('REVISANDO SISTEMA, Por favor - no trabajar. Gracias')
		if((producto =='' && !modelo.length) || (producto == null && !modelo.length ) ){
			
			console.log('NO ENCONTRO')
		}else{

			if(producto){
				producto = producto.split('+')[0];
			}

			$('.accesorios').html('');
			$('#listadoProductosBusqueda').html('');
			
			if(idioma == 'en'){
				$('.breadcrumb-container').html('<a class="inicio" href="/" title="Home"></a><span class="separadorr"></span><a href="en/products/" title="Products">Products</a><span class="separadorr"></span>Search');
			}else if(idioma == 'fr'){
				$('.breadcrumb-container').html('<a class="inicio" href="/" title="Accueil"></a><span class="separadorr"></span><a href="fr/produits/" title="Products">Produits</a><span class="separadorr"></span>Recherche');
			}else{
				$('.breadcrumb-container').html('<a class="inicio" href="/" title="Inicio"></a><span class="separadorr"></span><a href="es/productos/" title="Productos">Productos</a><span class="separadorr"></span>Busqueda');
			}
			

			$('.msgErrMarc2').hide();
			$('.msgErrProd2').hide();
			var error = 2;

			var palabra1 = 'productos';
			if(idioma == 'en'){
			palabra1 = 'products';
			}
			
			if(idioma == 'fr'){
			palabra1 = 'produits';
			}
			if(producto){
				$('.ocultBusca').hide();

				var arrayData = [];
				$.ajax({
				method: "POST",
				data: { producto: producto, marca: marca, modelo: modelo },
				url: "<?=$base;?>000_admin/_rest/api.php?action=buscarByProdMarcMode"
				}).done(function(response) {
					if(response){
						var data = JSON.parse(response);
						var result = data.result;
						var p = 0;
						if(result.length > 0){
							$('#listadoProductosBusqueda').html('');
							var marcasIgnore = [];
							result.forEach(function(row, index) {
								var idMarcaS = row['idMar'];
								var nbMarcaS = row['nbMarca'];

								if($.inArray(idMarcaS, marcasIgnore) == -1){
									marcasIgnore.push(idMarcaS);
									$('#listadoProductosBusqueda').append('<div class="M'+idMarcaS+'" style="margin-bottom: 28px;"><h3 class="rotulo-marca">'+nbMarcaS+'</h3></div>');
								}
							});

							for (let u = 0; u < marcasIgnore.length; u++) {
								var idMarcaS = marcasIgnore[u];

								result.forEach(function(row, index) {
									if(row['idMar'] == idMarcaS){
										var id = row['id'];
										var nombre = row['nombre'];
										
										$.ajax({
											method: "GET",
											url: "<?=$base;?>000_admin/_rest/api.php?action=listarRefOemsAndCaractByIdProductoBusqueda&marc="+idMarcaS+"&idProd="+id
										}).done(function(response) {
											if(response){
												p++;
												var data = JSON.parse(response);
												row.refOems = data.refOems;
												row.caract = data.caract;
												arrayData.push(row);

												if(p == result.length){
													var dataShowRefOem = '';
													var dataShowCaract = '';
													if(arrayData){
														// ORGANIZAR ARRAY
														function SortArray(x, y){
															if (x.nombre < y.nombre) {return -1;}
															if (x.nombre > y.nombre) {return 1;}
															return 0;
														}
														arrayData = arrayData.sort(SortArray);

														/* datos es la variable donde va informacon  */
														var datos = arrayData;
														arrayData.forEach(function(row, index) {
															var tipodisplay = 'display: initial;';

															var dataShow3 = '';
															var resultRefOemById = row.refOems;
															var resultCaractId = row.caract;
															dataShowRefOem = '';
															dataShowCaract = '';
															if(resultRefOemById != '-'){
																resultRefOemById.forEach(function(row2, index2) {
																	dataShowRefOem +='<li>'+row2["refOem"]+'</li>';
																});
															}
															
															var j = 0;
															if(resultCaractId != '-'){
																tipodisplay = 'display: inline-table;';

																resultCaractId.forEach(function(row2, index2) {
																	j++;
																	if(j==resultCaractId.length){
																		dataShowCaract +='<div class="bloque-caracteristica"><label>'+row2["alias"]+'</label>'+row2["valor"]+'<span class="tuberia"></span></div>';
																	}else{
																		dataShowCaract +='<div class="bloque-caracteristica"><label>'+row2["alias"]+'</label>'+row2["valor"]+'<span class="tuberia">|</span></div>';
																	}
																});
															}

															var nombreUrl = cleanName(row["nombre"]);
															var nombreMarca = cleanName(row["nbMarca"]);
															var idMar = row["idMar"];
															var nombreCategoria = cleanName(row["nbCategoria"]);
															var idCat = row["idCat"];
															var idp = row["id"];
															var catPadre = row["catPadre"];

															var imgProd = "assets/images/default.png";
															if(row['thumbnails']){
																imgProd = "assets/images/repuestos/fotos/"+idioma+"/" + row['thumbnails'];
															}


															var palabra1 = 'productos';
															if(idioma == 'en'){
																palabra1 = 'products';
															}
															if(idioma == 'fr'){
																palabra1 = 'produits';
															}

															var nct = row["nbCategoria"];
															console.log( nct.indexOf('to. Embragu') );
																if(  nct.indexOf('to. Embragu') == -1 ){

																	dataShow3 += '\
																	<div id="producto---" class="views-row views-row-'+p+'">\
																		<div class="field-content"></div>\
																		<div class="bloque-imagen">\
																			<div class="imagen-producto">\
																				<img src="'+imgProd+'" alt="'+nombreUrl+'-'+row["noRefFuster"]+'" title="'+nombreUrl+'-'+row["noRefFuster"]+'" />\
																			</div>\
																		</div>\
																		<div class="bloque_detalle">\
																			<div class="field-content">\
																				<h4 class="titulo-producto">\
																					<a href="'+idioma+'/'+palabra1+'/mid'+idMar+'/cid'+idCat+'/pid'+idp+'/'+nombreMarca+'/'+nombreCategoria+'/'+nombreUrl+'/">'+row["nombre"]+'</a>\
																					<span class="precioProductos">   </span>\
																				</h4>\
																			</div>\
																			<div class="referencia-producto">Ref. Fuster: '+row["noRefFuster"]+'</div>\
																			\
																			<div class="seccion-familia-producto">'+catPadre+'<span class="separadorr"> </span>\
																			<a href="'+idioma+'/'+palabra1+'/mid'+idMar+'/cid'+idCat+'/'+nombreMarca+'/'+nombreCategoria+'/">'+nct+'</a>\
																			<br></div>\
																			\
																			<div class="field-items">\
																				<div class="field-item even" style="'+tipodisplay+'">'+dataShowCaract+'</div>\
																			</div>\
																			<div class="divCarrito">\
																				<span class="cantLetter"> Cant. </span><input type="number" value="1" name="precio" class="inputPrecio">\
																				<a href="#" class="addCarrito"  data-refFuster='+row["noRefFuster"]+'> Añadir al Carrito </a>\
																			</div>\
																		</div>\
																		<div class="bloque-oem">\
																			<div class="producto-oems">\
																				<strong>Ref. OEM: </strong>\
																				<ul>'+dataShowRefOem+'</ul>\
																			</div>\
																		</div>\
																	</div>\
																	';
																}

															$('div.M'+idMar+'').append(dataShow3);
														});
														
													}
												}
											}
										});
									}
								});
							}
							
				
						}
					}
				});

				
				if(error == 1){
					$('#listadoSinResultadoBusqueda').show();
				}
				
				$('.resultadoBusqueda').show();
			}else{
				$('.ocultBusca').show();
				$('.resultadoBusqueda').hide();

				$('#listadoCategorias').html("<div class='loading'>\
							<div class='spinner-border'  style='border: .25em solid #e6e2dc;border-right-color: transparent;' role='status'></div>\
						</div>");


				var P1M = path.match(/\/mid([0-9]+)\//).pop();
				var P2URL = (path.split('/'))[4];
				$.ajax({
					method: "POST",
					data: { marca: marca, modelo: modelo },
					url: "<?=$base;?>000_admin/_rest/api.php?action=listarCategoriasByMarcaModelo"
				}).done(function(response) {
					if(response){
						$('#listadoCategorias').html('');
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
												<h3  style="font-weight: 700;">'+nombre+'</h3>\
											</div>\
											<ul>';
											hijos.forEach(function(row2, index2) {
												var nombreHijo = row2.categorias;
												var cantidadHijo = row2.cantidadRepuestos;
												var idHijo = row2.categoriasId;
												var nombreHijoURL = cleanName(nombreHijo);

												dataShow += '\
												<li>\
													<div class="product-category"><a href="#" class="clickHijoCateBusqueda" data-id="'+idHijo+'" data-marca="'+marca+'"  data-modelo="'+modelo+'">'+nombreHijo+'</a><span>'+cantidadHijo+'</span></div>\
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

		}
	});
	
	
	
	
	$(document).on('click',  '.clickHijoCateBusqueda', function(event){ 
		event.preventDefault();

		$('.listadoSinResultadoBusqueda').hide();

		var marca = $(this).attr("data-marca");
		var modelo = $(this).attr("data-modelo");
		var idCategoria = $(this).attr("data-id");


		$('.accesorios').html('');
		$('#listadoProductosBusqueda').html('');

		if(idioma == 'en'){
			$('.breadcrumb-container').html('<a class="inicio" href="/" title="Home"></a><span class="separadorr"></span><a href="en/products/" title="Products">Products</a><span class="separadorr"></span>Search');
		}else if(idioma == 'fr'){
			$('.breadcrumb-container').html('<a class="inicio" href="/" title="Accueil"></a><span class="separadorr"></span><a href="fr/produits/" title="Produits">Produits</a><span class="separadorr"></span>Recherche');
		}else{
			$('.breadcrumb-container').html('<a class="inicio" href="/" title="Inicio"></a><span class="separadorr"></span><a href="es/productos/" title="Productos">Productos</a><span class="separadorr"></span>Busqueda');
		}
		

		$('.msgErrMarc2').hide();
		$('.msgErrProd2').hide();
		var error = 2;

		var palabra1 = 'productos';
		if(idioma == 'en'){
		palabra1 = 'products';
		}
		if(idioma == 'fr'){
		palabra1 = 'produits';
		}
		$('.ocultBusca').hide();

		var arrayData = [];
		$.ajax({
		method: "POST",
		data: { categoria: idCategoria, marca: marca, modelo: modelo },
		url: "<?=$base;?>000_admin/_rest/api.php?action=buscarByCateMarcMode"
		}).done(function(response) {
			if(response){
				var data = JSON.parse(response);
				var result = data.result;
				var p = 0;
				if(result.length > 0){
					$('#listadoProductosBusqueda').html('');
					var marcasIgnore = [];
					result.forEach(function(row, index) {
						var idMarcaS = row['idMar'];
						var nbMarcaS = row['nbMarca'];

						if($.inArray(idMarcaS, marcasIgnore) == -1){
							marcasIgnore.push(idMarcaS);
							$('#listadoProductosBusqueda').append('<div class="M'+idMarcaS+'" style="margin-bottom: 28px;"><h3 class="rotulo-marca">'+nbMarcaS+'</h3></div>');
						}
					});

					for (let u = 0; u < marcasIgnore.length; u++) {
						var idMarcaS = marcasIgnore[u];

						result.forEach(function(row, index) {
							if(row['idMar'] == idMarcaS){
								var id = row['id'];
								var nombre = row['nombre'];
								
								$.ajax({
									method: "GET",
									url: "<?=$base;?>000_admin/_rest/api.php?action=listarRefOemsAndCaractByIdProductoBusqueda&marc="+idMarcaS+"&idProd="+id
								}).done(function(response) {
									if(response){
										p++;
										var data = JSON.parse(response);
										row.refOems = data.refOems;
										row.caract = data.caract;
										arrayData.push(row);

										if(p == result.length){
											var dataShowRefOem = '';
											var dataShowCaract = '';
											if(arrayData){
												// ORGANIZAR ARRAY
												function SortArray(x, y){
													if (x.nombre < y.nombre) {return -1;}
													if (x.nombre > y.nombre) {return 1;}
													return 0;
												}
												arrayData = arrayData.sort(SortArray);

												/* datos es la variable donde va informacon  */
												var datos = arrayData;
												arrayData.forEach(function(row, index) {
													var dataShow3 = '';
													var tipodisplay = 'display: initial;';

													var resultRefOemById = row.refOems;
													var resultCaractId = row.caract;
													dataShowRefOem = '';
													dataShowCaract = '';
													if(resultRefOemById != '-'){
														resultRefOemById.forEach(function(row2, index2) {
															dataShowRefOem +='<li>'+row2["refOem"]+'</li>';
														});
													}
													
													var j = 0;
													if(resultCaractId != '-'){
														tipodisplay = 'display: inline-table;';

														resultCaractId.forEach(function(row2, index2) {
															j++;
															if(j==resultCaractId.length){
																dataShowCaract +='<div class="bloque-caracteristica"><label>'+row2["alias"]+'</label>'+row2["valor"]+'<span class="tuberia"></span></div>';
															}else{
																dataShowCaract +='<div class="bloque-caracteristica"><label>'+row2["alias"]+'</label>'+row2["valor"]+'<span class="tuberia">|</span></div>';
															}
														});
													}

													var nombreUrl = cleanName(row["nombre"]);
													var nombreMarca = cleanName(row["nbMarca"]);
													var idMar = row["idMar"];
													var nombreCategoria = cleanName(row["nbCategoria"]);
													var idCat = row["idCat"];
													var idp = row["id"];
													var catPadre = row["catPadre"];

													var imgProd = "assets/images/default.png";
													if(row['thumbnails']){
														imgProd = "assets/images/repuestos/fotos/"+idioma+"/" + row['thumbnails'];
													}


													var palabra1 = 'productos';
													if(idioma == 'en'){
														palabra1 = 'products';
													}
													if(idioma == 'fr'){
														palabra1 = 'produits';
													}
													
													var nct = row["nbCategoria"];
													console.log( nct.indexOf('to. Embragu') );
														if(  nct.indexOf('to. Embragu') == -1 ){

															dataShow3 += '\
															<div id="producto---" class="views-row views-row-'+p+'">\
																<div class="field-content"></div>\
																<div class="bloque-imagen">\
																	<div class="imagen-producto">\
																		<img src="'+imgProd+'" alt="'+nombreUrl+'-'+row["noRefFuster"]+'" title="'+nombreUrl+'-'+row["noRefFuster"]+'" />\
																	</div>\
																</div>\
																<div class="bloque_detalle">\
																	<div class="field-content">\
																		<h4 class="titulo-producto">\
																			<a href="'+idioma+'/'+palabra1+'/mid'+idMar+'/cid'+idCat+'/pid'+idp+'/'+nombreMarca+'/'+nombreCategoria+'/'+nombreUrl+'/">'+row["nombre"]+'</a>\
																			<span class="precioProductos">   </span>\
																		</h4>\
																	</div>\
																	<div class="referencia-producto">Ref. Fuster: '+row["noRefFuster"]+'</div>\
																	\
																	<div class="seccion-familia-producto">'+catPadre+'<span class="separadorr"> </span>\
																	<a href="'+idioma+'/'+palabra1+'/mid'+idMar+'/cid'+idCat+'/'+nombreMarca+'/'+nombreCategoria+'/">'+nct+'</a>\
																	<br></div>\
																	\
																	<div class="field-items">\
																		<div class="field-item even" style="'+tipodisplay+'">'+dataShowCaract+'</div>\
																	</div>\
																	<div class="divCarrito">\
																		<span class="cantLetter"> Cant. </span><input type="number" value="1" name="precio" class="inputPrecio">\
																		<a href="#" class="addCarrito"  data-refFuster='+row["noRefFuster"]+'> Añadir al Carrito </a>\
																	</div>\
																</div>\
																<div class="bloque-oem">\
																	<div class="producto-oems">\
																		<strong>Ref. OEM: </strong>\
																		<ul>'+dataShowRefOem+'</ul>\
																	</div>\
																</div>\
															</div>\
															';
														}

													$('div.M'+idMar+'').append(dataShow3);
												});
												
											}
										}
									}
								});
							}
						});
					}
				
				}
			}
		});

		
		if(error == 1){
			$('#listadoSinResultadoBusqueda').show();
		}
		
		$('.resultadoBusqueda').show();

	});
});



</script>