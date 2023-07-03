<script>
/*global $:true */
const removeAccents = (str) => {
  return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
} 


var palabra1 = 'accesorios';
var fotoPal = 'Foto';
var refPal = 'Ref';

if(idioma == 'en'){
palabra1 = 'accesories';
fotoPal = 'Photo';
refPal = 'Ref';
}
if(idioma == 'fr'){
palabra1 = 'accessoires';
fotoPal = 'Photo';
refPal = 'Réf';
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
	var P4URL = (path.split('/'))[3];

    var idCategoria = P1;
	var arrayData = [];
	var arrayIdProducts = [];
	var json_tabla = [];

	$.ajax({
		method: "GET",
		url: "<?=$base;?>000_admin/_rest/api.php?action=comprobarTipoAccesorioList&cat="+idCategoria
	}).done(function(response) {
		if(response){
			var data = JSON.parse(response);
			var result = data.result;
			if(data.code == 2){
				cargaVistaNormal();
			}else{
				arrayIdProducts = result[0].arrayIdProducts;
				json_tabla = result[0].json_tabla;
				console.log('INFOOO')
				console.log(arrayIdProducts)
				var template = '<div class="imagen-cotas"><img src="assets/images/PC/'+result[0].imagenFondo+'" alt="'+P4URL+'" title="'+P4URL+'"></div>';

				if(idioma == 'en'){
					template += '<div id="leyendas"><p class="leyendacotas">Measurements in mm.</p><p class="leyendafiltros">Using <kbd>Shift</kbd> plus Click on a group header will toggle the view of all groups in that table.</p></div><div id="listadoTabl"><div class="loading"><div class="spinner-border" style="border: .25em solid #e6e2dc;border-right-color: transparent;" role="status"></div></div>  </div>';
				}else if(idioma == 'fr'){
					template += '<div id="leyendas"><p class="leyendacotas">Measurements in mm.</p><p class="leyendafiltros">Using <kbd>Shift</kbd> plus Click on a group header will toggle the view of all groups in that table.</p></div><div id="listadoTabl"><div class="loading"><div class="spinner-border" style="border: .25em solid #e6e2dc;border-right-color: transparent;" role="status"></div></div>  </div>';
				}else{
					template += '<div id="leyendas"><p class="leyendacotas">Medidas en mm.</p><p class="leyendafiltros">Al usar <kbd>Shift</kbd> + clic en el encabezado de un grupo, se ordenará la vista de todos los grupos en la tabla.</p></div><div id="listadoTabl"><div class="loading"><div class="spinner-border" style="border: .25em solid #e6e2dc;border-right-color: transparent;" role="status"></div></div> </div>';
				}

				$('#listadoAccesorios').html(template);

				cargaVistaTabla();
			}
		}
	});	


	function cargaVistaNormal(){
		$.ajax({
			method: "GET",
			url: "<?=$base;?>000_admin/_rest/api.php?action=listarAccesoriosByCategoria&cat="+idCategoria
		}).done(function(response) {
			if(response){
				var data = JSON.parse(response);
				var result = data.result;
				var p = 0;
				if(data.code == 1 && result.length > 0){

					result.forEach(function(row, index) {
						var id = row['id'];
						var nombre = row['nombre'];
						$.ajax({
							method: "GET",
							url: "<?=$base;?>000_admin/_rest/api.php?action=listarCaractByIdAccesorio&cat="+idCategoria+"&idProd="+id
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
									var tipodisplay = 'display: initial;';

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
												var nombreCategoria = (path.split('/'))[3];
												var idCat = path.match(/\/cid([0-9]+)\//).pop();
												var idp = row["id"];
																													
												var imgProd = "assets/images/default.png";
												if(row['thumbnails']){
													imgProd = "assets/images/repuestos/fotos/"+idioma+"/" + row['thumbnails'];
												}

												dataShow3 += '\
												<div id="producto---" class="views-row views-row-'+p+' all '+identificadorClean+'">\
													<div class="field-content"></div>\
													<div class="bloque-imagen">\
														<div class="imagen-producto">\
															<img src="'+imgProd+'" alt="'+nombreUrl+'" title="'+nombreUrl+'" />\
														</div>\
													</div>\
													<div class="bloque_detalle">\
														<div class="field-content">\
															<h4 class="titulo-producto">\
																<a href="'+idioma+'/'+palabra1+'/cid'+idCat+'/pid'+idp+'/'+nombreCategoria+'/'+nombreUrl+'/">'+row["nombre"]+'</a>\
																<span class="precioProductos">   </span>\
															</h4>\
														</div>\
														<div class="referencia-producto">Ref. Fuster: '+row["noRefFuster"]+'</div>\
														<div class="field-items">\
														<div class="field-item even" style="'+tipodisplay+'">'+dataShowCaract+'</div>\
														</div>\
														<div class="divCarrito">\
															<span class="cantLetter"> Cant. </span><input type="number" name="precio" value="1" class="inputPrecio">\
															<a href="#" class="addCarrito"  data-refFuster='+row["noRefFuster"]+'> Añadir al Carrito </a>\
														</div>\
													</div>\
												</div>\
												';
												
											});

										}
										$('#listadoAccesorios').html(dataShow3);
									}
								}
							}
						});
					});
				
				}
			}
		});	
		
		$(document).on('click',  '.btnFiltroProd', function(){ 
			var id = $(this).attr('data-id');
			$('#listadoIdent div').removeClass( "btnFiltroProdAtv" );
			$('#listadoAccesorios .all').hide();

			$(this).addClass( "btnFiltroProdAtv" );
			$('#listadoAccesorios .'+id+'').show();
		});
	}

	function padLeadingZeros(num) {
		var s = "0" + num;
		return s.substr(s.length-2);
	}

	function cargaVistaTabla(){	
		
		var listadoAccesorios = '';
		var guiaFinal = [];

		$.ajax({
			method: "POST",
			data: { idProductos: arrayIdProducts, idCategoria: idCategoria },
			url: "<?=$base;?>000_admin/_rest/api.php?action=buscarAccesoriosByIdProducto"
		}).done(function(response) {
			var p = 0;
			var contenido = '';
			var listadoFiltros = '';
			var ordenCaracteristicas = [];
			var json = JSON.parse(json_tabla)[0];
			var arrayC = json.split(',');
			
			var filtro = '';
			for (let i = 0; i < arrayC.length; i++) {
				var element = arrayC[i].split('|');
				ordenCaracteristicas.push(element[0]);
				guiaFinal.push(element[1]);

				filtro += '\
					<th class="bloque-filtro">\
						<label>'+element[1]+' </label>\
						<span id="txt-filtro-'+element[0]+'">\
							<select class="filtroSelect" data-cls="idC'+element[0]+'" id="filtro-'+element[0]+'">\
								<option value=""> - </option>\
							</select>\
						</span>\
					</th>';
			}


			if(localStorage.getItem("userLogged") != "-" && localStorage.getItem("userToken") != "-"){
				listadoFiltros = '\
				<tr>\
					<th class="bloque-filtro"><label>'+refPal+'</label></th>\
					<th class="bloque-filtro"><label>'+fotoPal+'</label></th>\
					<th class="bloque-filtro"><label>Precio</label></th>\
				';
			}else{
				listadoFiltros = '\
				<tr>\
				<th class="bloque-filtro"><label>'+refPal+'</label></th>\
					<th class="bloque-filtro"><label>'+fotoPal+'</label></th>\
				';
			}
			

			listadoFiltros += filtro;
			listadoFiltros += '</tr>';

			if(response){
				var data = JSON.parse(response);
				var result = data.result;
				if(result){
					result.forEach(function(row, index) {
						var id = row['id'];
						var nombre = row['nombre'];
						var noRefFuster = row['noRefFuster'];

						var nombreUrl = cleanName(row["nombre"]);
						var nombreCategoria = (path.split('/'))[3];
						var idCat = path.match(/\/cid([0-9]+)\//).pop();
						var idp = row["id"];
						
						var imgProd = "assets/images/default.png";
						if(row['thumbnails']){
							imgProd = "assets/images/repuestos/fotos/"+idioma+"/" + row['thumbnails'];
						}

						$.ajax({
							method: "GET",
							url: "<?=$base;?>000_admin/_rest/api.php?action=listarCaractByIdAccesorio&cat="+idCategoria+"&idProd="+id
						}).done(function(response) {
							if(response){
								p++;
								var data = JSON.parse(response);
								var caractElement = data.caract;
								var listadoCaracteristicas = '';
								
								for (let i = 0; i < ordenCaracteristicas.length; i++) {
									const orden = ordenCaracteristicas[i];
									var encontro = false;
									for (let j = 0; j < caractElement.length; j++) {

										if(caractElement[j].id == orden){

											var valorCaract = caractElement[j].valor;
											let arr = valorCaract.split(',');

											if(arr.length>1){
												if (!isNaN(arr[0])) {
													console.log(arr)
													if(arr[0].length == 1){
														valorCaract = "0" + valorCaract;
													}
												}
											}

											if (!isNaN(valorCaract)) {
												if(valorCaract.length == 1){
													valorCaract = "0" + valorCaract;
												}
											}

											listadoCaracteristicas += '<td class="tecni idC'+caractElement[j].id+'" data-value="'+valorCaract+'">'+valorCaract+'</td>';
											encontro = true;
										}

										if(j == caractElement.length-1){
											if(!encontro)
											{
												listadoCaracteristicas += '<td class="tecni"></td>';
											}
										}
									}
								}

								if(localStorage.getItem("userLogged") != "-" && localStorage.getItem("userToken") != "-"){
								listadoAccesorios += '\
								<tr id="producto-1-1-3084" style="display: table-row;">\
									<td class="refer">\
										<a href="'+idioma+'/'+palabra1+'/cid'+idCat+'/pid'+idp+'/'+nombreCategoria+'/'+nombreUrl+'/" title="">'+noRefFuster+'</a>\
									</td>\
									<td class="image">\
										<img id="foto-producto"	src="'+imgProd+'" alt="'+nombreUrl+'-'+noRefFuster+'" title="'+nombreUrl+'-'+noRefFuster+'">\
									</td>\
									<td class="precio">\
										<span class="precioProductos" style="font-size: 15px;">   </span>\
									</td>\
									'+listadoCaracteristicas+'\
									<td class="carrito">\
										<input type="number" name="precio" value="1" class="inputPrecio" style="width: 54px;border: 0px solid #a2a2a2;margin-top: 0px;margin-right: 6px;">\
										<a href="#" class="addCarrito"  data-refFuster='+noRefFuster+' style="padding: 4.2px 15px;padding-bottom: 4px;"> \
											<img src="assets/images/carrito_bold.svg" style="width: 21px;">\
										</a>\
									</td>\
								</tr>';
								}else{
								listadoAccesorios += '\
								<tr id="producto-1-1-3084" style="display: table-row;">\
									<td class="refer">\
										<a href="'+idioma+'/'+palabra1+'/cid'+idCat+'/pid'+idp+'/'+nombreCategoria+'/'+nombreUrl+'/" title="">'+noRefFuster+'</a>\
									</td>\
									<td class="image">\
										<img id="foto-producto"	src="'+imgProd+'" alt="'+nombreUrl+'-'+noRefFuster+'" title="'+nombreUrl+'-'+noRefFuster+'">\
									</td>\
									'+listadoCaracteristicas+'\
								</tr>';
								}
							
								if(p == result.length){
									
									var listadoColumnas = '';
									listadoColumnas += '<th>'+refPal+'</th>';
									listadoColumnas += '<th>'+fotoPal+'</th>';
									if(localStorage.getItem("userLogged") != "-" && localStorage.getItem("userToken") != "-"){
									listadoColumnas += '<th>Precio</th>';
									}
									
									for (let index = 0; index < guiaFinal.length; index++) {
										const element = guiaFinal[index];
										listadoColumnas += '<th>'+element+'</th>';
									}
									
									if(localStorage.getItem("userLogged") != "-" && localStorage.getItem("userToken") != "-"){
										listadoColumnas += '<th></th>';
									}

									contenido = '\
									<div id="wrapper-accesorios-productos">\
										<table id="accesorios-productos">\
										<thead>\
											<tr>\
												'+listadoColumnas+'\
											</tr>\
										</thead>\
											<tbody>\
												'+listadoAccesorios+'\
											</tbody>\
										<tfoot>\
											<tr>\
												'+listadoColumnas+'\
											</tr>\
										</tfoot>\
										</table>\
									</div>\
									';

									$('#listadoTabl').html(contenido);

									$('#accesorios-productos thead tr')
										.clone(true)
										.addClass('filters')
										.appendTo('#accesorios-productos thead');
										var cursorPosition = '';
										var table = $('#accesorios-productos').DataTable({
										orderCellsTop: true,
										order: [[2, 'asc']],
										columnDefs: [
											{ "type": "string", "targets": '_all'}
										],
										pageLength: 200,
    									lengthMenu: [10, 20, 50, 100, 200, 500],
										initComplete: function () {
											var api = this.api();
								
											// For each column
											api
												.columns()
												.eq(0)
												.each(function (colIdx) {
													// Set the header cell to contain the input element
													var cell = $('.filters th').eq(
														$(api.column(colIdx).header()).index()
													);
													var title = $(cell).text();
													$(cell).html('<input type="text" placeholder="' + title + '" />');
								
													// On every keypress in this input
													$(
														'input',
														$('.filters th').eq($(api.column(colIdx).header()).index())
													)
														.off('keyup change')
														.on('change', function (e) {
															// Get the search value
															$(this).attr('title', $(this).val());
															var regexr = '({search})'; //$(this).parents('th').find('select').val();
								
															cursorPosition = this.selectionStart;
															// Search the column for that value
															api
																.column(colIdx)
																.search(
																	this.value != ''
																		? regexr.replace('{search}', '(((' + this.value + ')))')
																		: '',
																	this.value != '',
																	this.value == ''
																)
																.draw();
														})
														.on('keyup', function (e) {
															e.stopPropagation();
								
															$(this).trigger('change');
															$(this)
																.focus()[0]
																.setSelectionRange(cursorPosition, cursorPosition);
														});
												});
										},
									});
								}
							}
						});
					});
						
				}
			}
		});
		
	}

});

</script>






