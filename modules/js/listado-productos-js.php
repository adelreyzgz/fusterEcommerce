<script>
/*global $:true */
const removeAccents = (str) => {
  return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
} 

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
	var P3 = path.match(/\/mid([0-9]+)\//).pop();
	var P2URL = (path.split('/'))[5];
	var P4URL = (path.split('/'))[6];

    var idCategoria = P1;
    var idMarca = P3;
	var arrayData = [];
	$.ajax({
		method: "GET",
		url: "<?=$base;?>000_admin/_rest/api.php?action=listarProductosByMarcaYCategoria&cat="+idCategoria+"&marc="+idMarca
	}).done(function(response) {
		if(response){
			var data = JSON.parse(response);
			var result = data.result;
			var p = 0;
			// console.log(result)
			if(data.code == 1 && result.length > 0){
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

									console.log('responseERP', responseERP)
									console.log('result', result)

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
				// FIN INTERCEPTOR

				function logicaOld(result){

					result.forEach(function(row, index) {
						var id = row['id'];
						var nombre = row['nombre'];
							$.ajax({
								method: "GET",
								url: "<?=$base;?>000_admin/_rest/api.php?action=listarRefOemsAndCaractByIdProducto&cat="+idCategoria+"&marc="+idMarca+"&idProd="+id
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
										var dataShow3 = '';
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

											var categorias= [];
											var temporales= [];
											var retorno=[];
											for(var i=0;i<datos.length;i++){
												let name=removeAccents(datos[i].nombre);
												let indice = name.indexOf(" ");
												if(indice >- 1){
												var catTemp = name.substring(0, indice);
												}else{
												var catTemp = name;
												}
												var idCat = -1;
												for(var j=0;j<categorias.length;j++){
												if(categorias[j].nameCat==catTemp){
													idCat=categorias[j].id;
												}
												}
												if(idCat>-1){
												var elemento=[];
												elemento=retorno[idCat].element;
												elemento.push(datos[i]);
												retorno[idCat].element=elemento;
												}else{
												if(temporales.length>=1){
													var contador = 1;
													var locojio = false;
													for(var k=0;k<temporales.length;k++){
													if(temporales[k].nombre==catTemp){
														var arrayNewDatos=[];
														arrayNewDatos.push(temporales[k].element);
														arrayNewDatos.push(datos[i]);
														var jsonnewElemet={
														"nombre":catTemp,
														"element":arrayNewDatos
														}
														retorno.push(jsonnewElemet);
														let indiceCat=retorno.length-1;
														var jsonnewElemetCateE={
														"nameCat":catTemp,
														"id":indiceCat
														}
														categorias.push(jsonnewElemetCateE);
													
														var auxArray=[];
														for(var z=0;z<temporales.length;z++){
														if(temporales[z].nombre!=catTemp){
															auxArray.push(temporales[z])

														}
														}
														temporales=auxArray;
														locojio = true;
													}
													}
													if(!locojio){
													var arrayNewDatos=[];
													arrayNewDatos.push(datos[i]);
													var jsonnewElemet={
														"nombre":catTemp,
														"element":datos[i]
													}
													temporales.push(jsonnewElemet)
													
													}
												}else{
													var jsonnewElemet={
													"nombre":catTemp,
													"element":datos[i]
													}
													temporales.push(jsonnewElemet);
												}
												var cont=datos.length-1
												}
												if(i==datos.length-1){
												for(var a=0;a<temporales.length;a++){
													var nameT=temporales[a].nombre
													var lemen=[];
													lemen.push(temporales[a].element)
													
													var exist=1;
													for(var b=0;b<retorno.length;b++){
													if(nameT==retorno[b].nombre){
														exist=2;
													}
													
													}
													if(exist==1){
													var jsonnewElemetTU={
														"nombre":nameT,
														"element":lemen
													}
													retorno.push(jsonnewElemetTU)
													}
												}
												}

											}
											/* FIN CODE DIANA */    
											var unosolo = '';
											if(retorno.length > 1){
												if(idioma == 'en'){
													$('#listadoIdent').append("<div class='btnFiltroProd btnFiltroProdAtv' data-id='all'>All</div>");
												}else if(idioma == 'fr'){
													$('#listadoIdent').append("<div class='btnFiltroProd btnFiltroProdAtv' data-id='all'>Tout</div>");
												}else{
													$('#listadoIdent').append("<div class='btnFiltroProd btnFiltroProdAtv' data-id='all'>Todos</div>");
												}
											}else{
												unosolo = 'btnFiltroProdAtv';
											}

											// ORGANIZAR ARRAY
											function SortArrayN(x, y){
												if (x.nombre < y.nombre) {return -1;}
												if (x.nombre > y.nombre) {return 1;}
												return 0;
											}
											retorno = retorno.sort(SortArrayN);

											for (let index = 0; index < retorno.length; index++) {
												arrayData = retorno[index].element;
												var identificador = retorno[index].nombre;
												var identificadorClean = cleanName(identificador);
												
												if(arrayData.length > 0){
													$('#listadoIdent').append("<div class='btnFiltroProd "+unosolo+"' data-id='"+identificadorClean+"'>"+identificador+"</div>");
												}
												
												arrayData.forEach(function(row, index) {
													var resultRefOemById = row.refOems;
													var resultCaractId = row.caract;
													dataShowRefOem = '';
													dataShowCaract = '';
													var tipodisplay = 'display: initial;';

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

																		
													var imgProd = "assets/images/default.png";
													if(row['thumbnails']){
														imgProd = "assets/images/repuestos/fotos/"+idioma+"/" + row['thumbnails'];
													}

													var nombreUrl = cleanName(row["nombre"]);
													var nombreMarca = (path.split('/'))[5];
													var idMar = path.match(/\/mid([0-9]+)\//).pop();
													var nombreCategoria = (path.split('/'))[6];
													var idCat = path.match(/\/cid([0-9]+)\//).pop();
													var idp = row["id"];


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
													<div id="producto---" class="views-row views-row-'+p+' all '+identificadorClean+'">\
														<div class="field-content"></div>\
														<div class="bloque-imagen">\
															<div class="imagen-producto">\
																<img src="'+imgProd+'" alt="'+nombreUrl+'" title="'+nombreUrl+'"/>\
															</div>\
														</div>\
														<div class="bloque_detalle">\
															<div class="field-content">\
																<h4 class="titulo-producto">\
																	<a href="'+idioma+'/'+palabra1+'/mid'+idMar+'/cid'+idCat+'/pid'+idp+'/'+nombreMarca+'/'+nombreCategoria+'/'+nombreUrl+'/">'+row["nombre"]+'</a>\
																	<span class="precioProductos">  Precio: '+row["Price"]+'€ </span>\
																</h4>\
															</div>\
															<div class="referencia-producto">Ref. Fuster: '+row["noRefFuster"]+'</div>\
															<div class="field-items">\
																<div class="field-item even" style="'+tipodisplay+'">'+dataShowCaract+'</div>\
															</div>\
															<div class="divCarrito">\
																<span class="cantLetter"> Cant. </span><input min="0" max="50" type="number" value="0" name="precio" class="inputPrecio">\
																<a href="#" style="width: 156px;display: inline-block;text-align: center;" class="addCarrito" \
																data-refFuster='+row["noRefFuster"]+'  \
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

												});

											}
											$('#listadoProductos').html(dataShow3);
										}
									}
								}
							});
					});
				}
			}
		}
	});	
	
	
	$(document).on('click',  '.btnFiltroProd', function(){ 
		var id = $(this).attr('data-id');
		$('#listadoIdent div').removeClass( "btnFiltroProdAtv" );
		$('#listadoProductos .all').hide();

		$(this).addClass( "btnFiltroProdAtv" );
		$('#listadoProductos .'+id+'').show();
	});

});
</script>