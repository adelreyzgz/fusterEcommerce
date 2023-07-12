<script>
/*global $:true */

var $ = $.noConflict();
$(document).ready(function($) {
	"use strict";

	var path = window.location.pathname;
	// console.log(path)
	// var idMarca = path.match(/\/mid([0-9]+)\//).pop();
	// var idCategoria = path.match(/\/cid([0-9]+)\//).pop();

	// $(document).on('select2:open', () => {
	// 	document.querySelector('.select2-search__field').focus();
	// });

	$(document)
    // Attach event handler with some delay, waiting for the search field to be set up
    .on('select2:open', event => setTimeout(
        // Trigger focus using DOM API
        () => $(event.target).data('select2').dropdown.$search.get(0).focus(),
        10));
		

	function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this,
                args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function() {
                callback.apply(context, args);
            }, ms || 0);
        };
    }


	$('#reference').keyup(delay(function(e) {
        var a = $("#reference").val().length;
        if (a > 2) {
            buscar();
        } 
    }, 600));
	

	$('.js-data-refoem').select2({
		tags: true,
		placeholder: "<?=${"lang_".$idioma}['ndereferencia'];?>",
    	allowClear: true,
		ajax: {
			url: "<?=$base;?>000_admin/_rest/api.php?action=buscarRefSelect",
			delay: 100,
			processResults: function (response) {
			var data = JSON.parse(response);
			return {
				results: data.result
			};
			}
		}
	});

	$('.js-data-producto').select2({
		tags: true,
		placeholder: "<?=${"lang_".$idioma}['producto'];?>",
		allowClear: true,
		ajax: {
			url: "<?=$base;?>000_admin/_rest/api.php?action=buscarNombreProducto",
			delay: 100,
			processResults: function (response) {
			var data = JSON.parse(response);
			return {
				results: data.result
			};
			}
		}
	});

	var marcaBusqueda = '-';
	var prodBusqueda = '-';


	var productoBusqueda = $('.js-data-producto').val();
	var valooo = '';
	
	if(productoBusqueda){
		valooo = "r=1&action=buscarMarcaByNombre&nombre="+productoBusqueda;
	}else{
		valooo = "r=2&action=buscarNombreMarca";
	}

	$('.js-data-marca').select2({
		placeholder: "<?=${"lang_".$idioma}['marcadeltractor'];?>",
		allowClear: true,
		ajax: {
			url: "<?=$base;?>000_admin/_rest/api.php?"+valooo,
			delay: 100,
			processResults: function (response) {
			var data = JSON.parse(response);
			return {
				results: data.result
			};
			}
		}
	});

	$('.js-data-modelo').prop('disabled', 'disabled');

	$(document).on('change',  '.js-data-marca', function(){
		var marcaBusqueda = $('.js-data-marca').val();
		var prodBusqueda = $('.js-data-producto').val();
		
		if(prodBusqueda){
			prodBusqueda = prodBusqueda.split('+')[0];
		}

		$('.js-data-modelo').val('');
		console.log(marcaBusqueda)
		if(marcaBusqueda && marcaBusqueda != -1){
			$('.js-data-modelo').prop('disabled', false);

			if(!prodBusqueda){
				console.log('entro A')
				$('.js-data-modelo').select2({
					placeholder: "<?=${"lang_".$idioma}['modelodeltractor'];?>",
					allowClear: true,
					ajax: {
						url: "<?=$base;?>000_admin/_rest/api.php?action=buscarModeloByNombreyMarca&marca="+marcaBusqueda,
						delay: 100,
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
				$('.js-data-modelo').select2({
					placeholder: "<?=${"lang_".$idioma}['modelodeltractor'];?>",
					allowClear: true,
					ajax: {
						url: "<?=$base;?>000_admin/_rest/api.php?action=buscarModeloByNombreProdyMarca&producto="+prodBusqueda+"&marca="+marcaBusqueda+"",
						delay: 100,
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
		}else{
			marcaBusqueda = '-';
			$('.js-data-modelo').prop('disabled', 'disabled');
		}

		

    });

	$(document).on('change',  '.js-data-producto', function(){
		var productoBusqueda = $('.js-data-producto').val();
		if(productoBusqueda){
			productoBusqueda = productoBusqueda.split('+')[0];
			$('.js-data-marca').val('');
			$('.js-data-modelo').val('');
			$('.js-data-modelo').prop('disabled', 'disabled');
		
			$('.js-data-marca').select2({
				placeholder: "<?=${"lang_".$idioma}['marcadeltractor'];?>",
				allowClear: true,
				ajax: {
					url: "<?=$base;?>000_admin/_rest/api.php?d=s&action=buscarMarcaByNombre&nombre="+productoBusqueda,
					delay: 100,
					processResults: function (response) {
					var data = JSON.parse(response);
					return {
						results: data.result
					};
					}
				}
			});
		}else{
			$('.js-data-marca').select2({
				placeholder: "<?=${"lang_".$idioma}['marcadeltractor'];?>",
				allowClear: true,
				ajax: {
					url: "<?=$base;?>000_admin/_rest/api.php?action=buscarNombreMarca",
					delay: 100,
					processResults: function (response) {
					var data = JSON.parse(response);
					return {
						results: data.result
					};
					}
				}
			});
		}

    });




	/*
	Capturar variables GET para ver si es una busqueda
	y los onclick de ejecutar la busqueda que van a la nueva pagina resultadoBusquedaFinal
	*/

	// window.location.href = '/?lang='+idioma+'&emailS='+valorcamp;

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
	
	//   refOem	"K 965331" no encuentra nada paraesta referencia
	if($_GET.busqueda == 'buscarByNoRef'){

		// var refOem = $('.js-data-refoem').val();
		var refOem = $_GET.refOem;
		if(refOem){
			$('.onlyMarcaSeleccionada').hide();
			$('.ocultBusca').hide();
			$('.listadoSinResultadoBusqueda').hide();
			$('.accesorios').html('');
			$('#listadoProductosBusqueda').html('');
			if(idioma == 'en'){
				$('.breadcrumb-container').html('<a class="inicio" href="/" title="Home"></a><span class="separadorr"></span><a href="en/products/" title="Products">Products</a><span class="separadorr"></span>Search');
			}else if(idioma == 'fr'){
				$('.breadcrumb-container').html('<a class="inicio" href="/" title="Accueil"></a><span class="separadorr"></span><a href="fr/produits/" title="Produits">Produits</a><span class="separadorr"></span>Recherche');
			}else{
				$('.breadcrumb-container').html('<a class="inicio" href="/" title="Inicio"></a><span class="separadorr"></span><a href="es/productos/" title="Productos">Productos</a><span class="separadorr"></span>Busqueda');
			}
			
			var tiene = false;
			if(refOem){
				var arrayData2 = [];
				$.ajax({
				method: "POST",
				data: { refOem: refOem },
				url: "<?=$base;?>000_admin/_rest/api.php?action=buscarByRefOemAccesorios"
				}).done(function(response) {
					if(response){
						var data = JSON.parse(response);
						var result = data.result;
						var p = 0;
						if(result.length > 0){
							tiene = true;
							$('#listadoAccesoriosBusqueda').html('');
							if(idioma == 'en'){
								$('#listadoAccesoriosBusqueda').append('<div class="accesorios" style="margin-bottom: 28px;"><h3 class="rotulo-marca">Accesories</h3></div>');
							}else if(idioma == 'fr'){
								$('#listadoAccesoriosBusqueda').append('<div class="accesorios" style="margin-bottom: 28px;"><h3 class="rotulo-marca">Accessoires</h3></div>');
							}else{
								$('#listadoAccesoriosBusqueda').append('<div class="accesorios" style="margin-bottom: 28px;"><h3 class="rotulo-marca">Accesorios</h3></div>');
							}
							
							result.forEach(function(row, index) {
									var id = row['id'];
									var nombre = row['nombre'];
									$.ajax({
										method: "GET",
										url: "<?=$base;?>000_admin/_rest/api.php?action=listarCaractByIdProductoBusquedaAccesorios&idProd="+id
									}).done(function(response) {
										if(response){
											p++;
											var data = JSON.parse(response);
											row.caract = data.caract;
											arrayData2.push(row);

											if(p == result.length){
												var dataShowCaract = '';
												if(arrayData2){
													// ORGANIZAR ARRAY
													function SortArray(x, y){
														if (x.nombre < y.nombre) {return -1;}
														if (x.nombre > y.nombre) {return 1;}
														return 0;
													}
													arrayData2 = arrayData2.sort(SortArray);

													/* datos es la variable donde va informacon  */
													var datos = arrayData2;
													arrayData2.forEach(function(row, index) {
														var dataShow3 = '';
														var tipodisplay = 'display: initial;';
														var resultCaractId = row.caract;
														dataShowCaract = '';
														
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
														var nombreCategoria = cleanName(row["nbCategoria"]);
														var idCat = row["idCat"];
														var idp = row["id"];
														var nbcc = row["nbCategoria"];
														var rutaPadres = row["rutaPadres"];

														var imgProd = "assets/images/default.png";
														if(row['thumbnails']){
															imgProd = "assets/images/repuestos/fotos/"+idioma+"/" + row['thumbnails'];
														}

														var palabra11 = 'accesorios';
														if(idioma == 'en'){
															palabra11 = 'accesories';
														}
														if(idioma == 'fr'){
															palabra11 = 'accessoires';
														}
														dataShow3 += '\
														<div id="producto---" class="views-row views-row-'+p+'">\
															<div class="field-content"></div>\
															<div class="bloque-imagen">\
																<div class="imagen-producto">\
																	<img src="'+imgProd+'" alt="'+nombreUrl+'" title="'+nombreUrl+'" />\
																</div>\
															</div>\
															<div class="bloque_detalle">\
																<div class="field-content">\
																	<h4 class="titulo-producto">\
																		<a href="'+idioma+'/'+palabra11+'/cid'+idCat+'/pid'+idp+'/'+nombreCategoria+'/'+nombreUrl+'/">'+row["nombre"]+'</a>\
																		<span class="precioProductos">   </span>\
																	</h4>\
																</div>\
																<div class="referencia-producto">Ref. Fuster: '+row["noRefFuster"]+'</div>\
																	\
																<div class="seccion-familia-producto" >'+rutaPadres+'\
																<span class="separadorr"></span>\
																<a href="'+idioma+'/'+palabra11+'/cid'+idCat+'/'+nombreCategoria+'/">'+nbcc+'</a>\
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
														</div>\
														';
														

														$('.accesorios').append(dataShow3);
													});
													
												}
											}
										}
									});
							});
				
						}
					}

					var arrayData = [];
					$.ajax({
					method: "POST",
					data: { refOem: refOem },
					url: "<?=$base;?>000_admin/_rest/api.php?action=buscarByRefOem"
					}).done(function(response) {
						if(response){
							var data = JSON.parse(response);
							var result = data.result;
							var p = 0;
							if(result.length > 0){
								// FIN INTERCEPTOR
								var access_token = localStorage.getItem("access_token_fuster");

								if(access_token){
									// INICIO INTERCEPTOR
									console.log('INICIO INTERCEPTOR')
									var arrayRefFusterI = '';

									for (let index = 0; index < result.length; index++) {
										const element = result[index];

										if(!index){
											arrayRefFusterI += '[';
										}

										arrayRefFusterI += '"'+element.noRefFuster+'"';
										
										if(index < (result.length-1)){
											arrayRefFusterI += ',';
										}

										if(index == (result.length-1)){
											arrayRefFusterI += ']';
										}
									}

									if(arrayRefFusterI){
										$.ajax({
											method: "GET",
											headers: {
												"Authorization": "Bearer " + access_token
											},
											url: 'https://apiecommercefuster.ideaconsulting.es/api/articles?codArticles='+arrayRefFusterI
										}).done(function(response) {
											// INICIO REQUEST INTERCEPTOR
												var responseERP = response.data;
												for (let i = 0; i < responseERP.length; i++) {
													const respElement = responseERP[i];
													for (let j = 0; j < result.length; j++) {
														const element = result[j];
														if(respElement.CodArticle == element.noRefFuster && respElement.Price){
															result[j].IDArticle = respElement.IDArticle;
															result[j].Price = parseFloat(respElement.Price).toFixed(2);
															result[j].Stock = Math.round(respElement.Stock);
															result[j].Description = respElement.Description;

														}
													}
												}

												for (let j = 0; j < result.length; j++) {
													const element = result[j];
													if(!element.Price){
														result.splice(j, 1);
													}
												}
												// OBJETO MODIFICADO CON DATOS DEL ERP
												console.log('OBJETO MODIFICADO CON DATOS DEL ERP');
												console.log('--------------')
												// --------------

												logicaOld(result);

												// --------------

											// FIN REQUEST INTERCEPTOR
										}).fail(function(response) {
											console.log(response);
										});
									}
								}else{
									logicaOld(result);
								}

								function logicaOld(result){
									tiene = true;
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
																				if(row2["refOem"] != row.noRefFuster){
																					dataShowRefOem +='<li>'+row2["refOem"]+'</li>';
																				}
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
																		
																		if(  nct.indexOf('to. Embragu') == -1  && nct.indexOf('to.Embragu') == -1  ){
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
																							<span class="precioProductos"> Precio: '+row["Price"]+'€   </span>\
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
																						<a href="#" class="addCarrito" data-refFuster='+row["noRefFuster"]+'  \
																						data-idarticle='+row["IDArticle"]+'\
																						data-description="'+row["Description"]+'"\
																						data-price='+row["Price"]+'\
																						data-stock='+row["Stock"]+'\
																						data-img="'+imgProd+'"\
																						data-idProd='+idp+'\> Añadir al Carrito </a>\
																					</div>\
																				</div>\
																				';

																			if( nct.indexOf('Embrague') == -1 && dataShowRefOem){
																				dataShow3 += '\
																					<div class="bloque-oem">\
																						<div class="producto-oems">\
																							<strong>Ref. OEM: </strong>\
																							<ul>'+dataShowRefOem+'</ul>\
																						</div>\
																					</div>\
																				';
																			}
																			
																			dataShow3 += '</div>';
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
								
					
							}else{
								if(!tiene){
									$('#listadoSinResultadoBusqueda').show();
								}
							}
						}
					});	
				});	
				
				

			}else{
				$('#listadoSinResultadoBusqueda').show();
			}
			
			$('.resultadoBusqueda').show();
		}else{$('#listadoSinResultadoBusqueda').show();}
	}else if($_GET.busqueda == 'buscarByProdMarcMod'){
		
		var producto = $_GET.producto;
		var marca = $_GET.marca;
		var modelo = $_GET.modelo;

		$('.onlyMarcaSeleccionada').hide();
		$('.ocultBusca').hide();
		$('.listadoSinResultadoBusqueda').hide();

		if(producto == "null" || producto == null){
			producto = '';
		}

		if(producto){
			producto = producto.split('+')[0];
		}

		$('.accesorios').html('');
		$('#listadoProductosBusqueda').html('');

		$('.breadcrumb-container').html('<a class="inicio" href="/" title="Home"></a><span class="separadorr"></span><a href="es/productos/" title="Productos">Productos</a><span class="separadorr"></span>Busqueda')

		if(idioma == 'en'){
			$('.breadcrumb-container').html('<a class="inicio" href="/" title="Home"></a><span class="separadorr"></span><a href="en/products/" title="Products">Products</a><span class="separadorr"></span>Search');
		}if(idioma == 'fr'){
			$('.breadcrumb-container').html('<a class="inicio" href="/" title="Accueil"></a><span class="separadorr"></span><a href="fr/produits/" title="Produits">Produits</a><span class="separadorr"></span>Recherche');
		}else{
			$('.breadcrumb-container').html('<a class="inicio" href="/" title="Inicio"></a><span class="separadorr"></span><a href="es/productos/" title="Productos">Productos</a><span class="separadorr"></span>Busqueda');
		}
			

		var palabra1 = 'productos';
		if(idioma == 'en'){
			palabra1 = 'products';
		}
		if(idioma == 'fr'){
			palabra1 = 'produits';
		}
		
		if(producto && marca){
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
						var access_token = localStorage.getItem("access_token_fuster");
						if(access_token){
							// INICIO INTERCEPTOR
							console.log('INICIO INTERCEPTOR')
							var arrayRefFusterI = '';

							for (let index = 0; index < result.length; index++) {
								const element = result[index];

								if(!index){
									arrayRefFusterI += '[';
								}

								arrayRefFusterI += '"'+element.noRefFuster+'"';
								
								if(index < (result.length-1)){
									arrayRefFusterI += ',';
								}

								if(index == (result.length-1)){
									arrayRefFusterI += ']';
								}
							}

							if(arrayRefFusterI){
								$.ajax({
									method: "GET",
									headers: {
										"Authorization": "Bearer " + access_token
									},
									url: 'https://apiecommercefuster.ideaconsulting.es/api/articles?codArticles='+arrayRefFusterI
								}).done(function(response) {
									// INICIO REQUEST INTERCEPTOR
										var responseERP = response.data;
										for (let i = 0; i < responseERP.length; i++) {
											const respElement = responseERP[i];
											for (let j = 0; j < result.length; j++) {
												const element = result[j];
												if(respElement.CodArticle == element.noRefFuster && respElement.Price){
													result[j].IDArticle = respElement.IDArticle;
													result[j].Description = respElement.Description;
													result[j].Price = parseFloat(respElement.Price).toFixed(2);
													result[j].Stock = Math.round(respElement.Stock);
												}

											}
										}

										for (let j = 0; j < result.length; j++) {
											const element = result[j];
											if(!element.Price){
												result.splice(j, 1);
											}
										}

										// OBJETO MODIFICADO CON DATOS DEL ERP
										console.log('OBJETO MODIFICADO CON DATOS DEL ERP');
										console.log('--------------')
										// --------------

										logicaOld(result);

										// --------------

									// FIN REQUEST INTERCEPTOR
								}).fail(function(response) {
									console.log(response);
								});
							}
						}else{
							logicaOld(result);
						}
						function logicaOld(result){
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
																if(row2["refOem"] != row["noRefFuster"]){
																	dataShowRefOem +='<li>'+row2["refOem"]+'</li>';
																}
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

														var oemsDIV = '';
														if(dataShowRefOem){
															oemsDIV = '<div class="bloque-oem">\
																<div class="producto-oems">\
																	<strong>Ref. OEM: </strong>\
																	<ul>'+dataShowRefOem+'</ul>\
																</div>\
															</div>';
														}
														
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
																		<span class="precioProductos">  Precio: '+row["Price"]+'€</span>\
																	</h4>\
																</div>\
																<div class="referencia-producto">Ref. Fuster: '+row["noRefFuster"]+'</div>\
																<div class="field-items">\
																	<div class="field-item even" style="'+tipodisplay+'">'+dataShowCaract+'</div>\
																</div>\
																<div class="divCarrito">\
																	<span class="cantLetter"> Cant. </span><input type="number" value="1" name="precio" class="inputPrecio">\
																	<a href="#" class="addCarrito"  data-refFuster='+row["noRefFuster"]+'  \
																	data-idarticle='+row["IDArticle"]+'\
																	data-description="'+row["Description"]+'"\
																	data-price='+row["Price"]+'\
																	data-stock='+row["Stock"]+'\
																	data-img="'+imgProd+'"\
																	data-idProd='+idp+'> Añadir al Carrito </a>\
																	</div>\
															</div>\
															'+oemsDIV+'\
														</div>\
														';
													

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
				}
			});
		}
		
		$('.resultadoBusqueda').show();
	}else if($_GET.busqueda == 'buscarByProdAccesorio'){
		var producto = $_GET.producto;
		$('.onlyMarcaSeleccionada').hide();
			$('.ocultBusca').hide();
			$('.listadoSinResultadoBusqueda').hide();
			$('.accesorios').html('');
			$('#listadoProductosBusqueda').html('');
			if(idioma == 'en'){
				$('.breadcrumb-container').html('<a class="inicio" href="/" title="Home"></a><span class="separadorr"></span><a href="en/products/accesories/" title="Products">Accesories</a><span class="separadorr"></span>Search');
			}if(idioma == 'fr'){
				$('.breadcrumb-container').html('<a class="inicio" href="/" title="Accueil"></a><span class="separadorr"></span><a href="fr/produits/accessoires/" title="Produits">Accessoires</a><span class="separadorr"></span>Recherche');
			}else{
				$('.breadcrumb-container').html('<a class="inicio" href="/" title="Inicio"></a><span class="separadorr"></span><a href="es/productos/accesorios/" title="Productos">Accesorios</a><span class="separadorr"></span>Busqueda');
			}
			
			if(producto){
				var arrayData2 = [];
				$.ajax({
				method: "POST",
				data: { nombre: producto },
				url: "<?=$base;?>000_admin/_rest/api.php?action=buscarNombrAccesorios"
				}).done(function(response) {
					if(response){
						var data = JSON.parse(response);
						var result = data.result;
						var p = 0;
						if(result.length > 0){
							$('#listadoAccesoriosBusqueda').html('');
							if(idioma == 'en'){
								$('#listadoAccesoriosBusqueda').append('<div class="accesorios" style="margin-bottom: 28px;"><h3 class="rotulo-marca">Accesories</h3></div>');
							}else if(idioma == 'fr'){
								$('#listadoAccesoriosBusqueda').append('<div class="accesorios" style="margin-bottom: 28px;"><h3 class="rotulo-marca">Accessoires</h3></div>');
							}else{
								$('#listadoAccesoriosBusqueda').append('<div class="accesorios" style="margin-bottom: 28px;"><h3 class="rotulo-marca">Accesorios</h3></div>');
							}
							
							result.forEach(function(row, index) {
									var id = row['id'];
									var nombre = row['nombre'];
									$.ajax({
										method: "GET",
										url: "<?=$base;?>000_admin/_rest/api.php?action=listarCaractByIdProductoBusquedaAccesorios&idProd="+id
									}).done(function(response) {
										if(response){
											p++;
											var data = JSON.parse(response);
											row.caract = data.caract;
											arrayData2.push(row);

											if(p == result.length){
												var dataShowCaract = '';
												if(arrayData2){
													// ORGANIZAR ARRAY
													function SortArray(x, y){
														if (x.nombre < y.nombre) {return -1;}
														if (x.nombre > y.nombre) {return 1;}
														return 0;
													}
													arrayData2 = arrayData2.sort(SortArray);

													/* datos es la variable donde va informacon  */
													var datos = arrayData2;
													arrayData2.forEach(function(row, index) {
														var dataShow3 = '';
														var tipodisplay = 'display: initial;';
														var resultCaractId = row.caract;
														dataShowCaract = '';
														
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
														var nombreCategoria = cleanName(row["nbCategoria"]);
														var idCat = row["idCat"];
														var idp = row["id"];

														var imgProd = "assets/images/default.png";
														if(row['thumbnails']){
															imgProd = "assets/images/repuestos/fotos/"+idioma+"/" + row['thumbnails'];
														}

														var palabra11 = 'accesorios';
														if(idioma == 'en'){
															palabra11 = 'accesories';
														}
														if(idioma == 'fr'){
															palabra11 = 'accessoires';
														}
														dataShow3 += '\
														<div id="producto---" class="views-row views-row-'+p+'">\
															<div class="field-content"></div>\
															<div class="bloque-imagen">\
																<div class="imagen-producto">\
																	<img src="'+imgProd+'" alt="'+nombreUrl+'" title="'+nombreUrl+'" />\
																</div>\
															</div>\
															<div class="bloque_detalle">\
																<div class="field-content">\
																	<h4 class="titulo-producto">\
																		<a href="'+idioma+'/'+palabra11+'/cid'+idCat+'/pid'+idp+'/'+nombreCategoria+'/'+nombreUrl+'/">'+row["nombre"]+'</a>\
																		<span class="precioProductos">   </span>\
																	</h4>\
																</div>\
																<div class="referencia-producto">Ref. Fuster: '+row["noRefFuster"]+'</div>\
																<div class="field-items">\
																	<div class="field-item even" style="'+tipodisplay+'">'+dataShowCaract+'</div>\
																</div>\
																<div class="divCarrito">\
																	<span class="cantLetter"> Cant. </span><input type="number" value="1" name="precio" class="inputPrecio">\
																	<a href="#" class="addCarrito"  data-refFuster='+row["noRefFuster"]+'> Añadir al Carrito </a>\
																</div>\
															</div>\
														</div>\
														';
														

														$('.accesorios').append(dataShow3);
													});
													
												}
											}
										}
									});
							});
				
						}
					}
				});	
				
			}else{
				$('#listadoSinResultadoBusqueda').show();
			}
			
			$('.resultadoBusqueda').show();
	}else if ( $_GET.busqueda == 'previobuscarByProdMarcMod'){
		var producto = $_GET.producto;

		if(producto){
			producto = producto.split('+')[0];
		}

		var arrayData = [];
		$.ajax({
			method: "POST",
			data: { producto: producto },
			url: "<?=$base;?>000_admin/_rest/api.php?action=buscarTractoresByNombreProd"
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
							var prodId = row['prodId'];
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
										<a class="'+classs+'" href="<?=$base;?>?module=modules/busqueda/resultadoBusquedaFinal.php&idioma='+idiom+'&busqueda=buscarByProdMarcMod&producto='+producto+'&marca='+id+'">\
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

			$('#list-tractoress').html(dataShow3);
		});
	}else if($_GET.busqueda == 'buscarByCatMarcMod'){
		
		var idCategoria = $_GET.categoria;
		var marca = $_GET.marca;
		var modelo = $_GET.modelo;

		$('.onlyMarcaSeleccionada').hide();
		$('.ocultBusca').hide();
		$('.listadoSinResultadoBusqueda').hide();

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
															if(row2["refOem"] != row["noRefFuster"]){
																dataShowRefOem +='<li>'+row2["refOem"]+'</li>';
															}
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


													var oemsDIV = '';
													if(dataShowRefOem){
														oemsDIV = '<div class="bloque-oem">\
															<div class="producto-oems">\
																<strong>Ref. OEM: </strong>\
																<ul>'+dataShowRefOem+'</ul>\
															</div>\
														</div>';
													}


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
																'+oemsDIV+'\
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
	}

	

	$(document).on('click',  '.buscarByNoRef', function(){ 
		var refOem = $('.js-data-refoem').val();
		window.location.href = '<?=$base;?>?module=modules/busqueda/resultadoBusquedaFinal.php&idioma='+idiom+'&busqueda=buscarByNoRef&refOem='+refOem+'';
	});
	
	$(document).on('click',  '.buscarByProdMarcMod', function(){ 
		var producto = $('.js-data-producto').val();
		var marca = $('.js-data-marca').val();
		var modelo = $('.js-data-modelo').val();

		$('.msgErrMarc').hide();
		$('.msgErrProd').hide();
		$('.msgErrMarc2').hide();
		$('.msgErrProd2').hide();
		var error = 2;
		// if(producto && !marca){
		// 	$('.msgErrMarc').show();
		// 	$('.msgErrMarc2').show();
		// 	error = 1;
		// }

		if(modelo=='' && marca && (producto == "null" || producto == null)){
			$('.msgErrProd').show();
			$('.msgErrProd2').show();
			error = 1;
		}

		if(error == 1){
			$('#listadoSinResultadoBusqueda').show();
		}else{

			$('.onlyMarcaSeleccionada').hide();
			$('.ocultBusca').hide();
			$('.listadoSinResultadoBusqueda').hide();

			if(producto == "null" || producto == null){
				producto = '';
			}

			var palabra1 = 'productos';
			if(idioma == 'en'){
				palabra1 = 'products';
			}
			if(idioma == 'fr'){
				palabra1 = 'produits';
			}
			if(!producto && marca){
				var cadena = '';
				var nombrMarc = $('.js-data-marca option').text();

				console.log(nombrMarc)
				nombrMarc = cleanName(nombrMarc);

				if(modelo){
					modelo = modelo.toString().split(',');
				}

				for (let index = 0; index < modelo.length; index++) {
					cadena += modelo[index]+'-';
				}

				if(cadena){
					$(location).attr('href','<?=$base;?>'+idioma+'/'+palabra1+'/mid'+marca+'/'+nombrMarc+'/modelos-'+cadena+'/');return; 
				}else{
					$(location).attr('href','<?=$base;?>'+idioma+'/'+palabra1+'/mid'+marca+'/'+nombrMarc+'/');return; 
				}
			}

			if(marca == "null" || marca == null || marca == -1 || !marca){
				window.location.href = '<?=$base;?>?module=modules/busqueda/previoResultadoBusquedaFinal.php&idioma='+idiom+'&busqueda=previobuscarByProdMarcMod&producto='+producto+'';
			}else{
				window.location.href = '<?=$base;?>?module=modules/busqueda/resultadoBusquedaFinal.php&idioma='+idiom+'&busqueda=buscarByProdMarcMod&producto='+producto+'&marca='+marca+'&modelo='+modelo+'';
			}
				
		}
	});
});



</script>