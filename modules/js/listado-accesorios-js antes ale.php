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
	var P4URL = (path.split('/'))[4];

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
												var nombreCategoria = (path.split('/'))[4];
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

	function compararElementos(num1,num2,ordenFC) {
		var retorno=-1;
		if(num1==num2){
			retorno = 3;
		}else{
			var contNum1=0;
		var contNum2=0;
		var tipoNum1=1;
		var tipoNum2=1;
		


		for (let yy = 0; yy < num1.length; yy++) {
			if(!isNaN(num1[yy]) || num1[yy] == ','  || num1[yy] == '.'){
				contNum1++;
			}
		}

		for (let yy = 0; yy < num2.length; yy++) {
			if(!isNaN(num2[yy]) || num2[yy] == ','  || num2[yy] == '.'){
				contNum2++;
			}
		}

		var totalNum1 = parseFloat(num1.length);
		var totalNum2 = parseFloat(num2.length);

		if(contNum1 == totalNum1){
			var a2 = num1.split(',');
			tipoNum1=2;
			if(a2.length > 1){
				num1=a2[0]+'.'+a2[1];
			}
			num1 = parseFloat(num1) * 1;
			
		}

		if(contNum2 == totalNum2){
			var a2 = num2.split(',');
			tipoNum2=2;
			if(a2.length > 1){
				num2=a2[0]+'.'+a2[1];
			}
			num2 = parseFloat(num2) * 1;
		}

		if(tipoNum1==tipoNum2){
			if(ordenFC==1){
				if(tipoNum1==2){
					if(num1<num2){
					retorno=1;
					}else{
						retorno=2;
					}
				}else{
					var auxArr=[];
					auxArr.push(num1)
					auxArr.push(num2)
					auxArr.sort();
					if(num1==auxArr[0]){
					retorno=1;
					}else{
						retorno=2;
					}

				}
				
			}else{
				if(tipoNum1==2){
					if(num1>num2){
					retorno=1;
					}else{
						retorno=2;
					}
				}else{
					var auxArr=[];
					auxArr.push(num1)
					auxArr.push(num2)
					auxArr.sort();
					if(num1==auxArr[1]){
					retorno=1;
					}else{
						retorno=2;
					}

				}
			}

		}else{
			if(tipoNum1==2){
				retorno=1;
			}else {retorno =2;}
		}
		}
		
		return retorno;
		

	}

	function cargaVistaTabla(){	
		
		var listadoAccesorios = '';
		var guiaFinal = [];
		var idGuiaFinal = [];
		var idElementoOrden = [];
		var tipoOrden = [];
		var arrayPadres = [];
		var arrayPadresVisitados = [];
		var valoresColumn = [];
		valoresColumn[0] = [0];
		valoresColumn[1] = [0];
		var valoresColumnD = [];
		valoresColumnD[0] = -1;
		valoresColumnD[1] = -1;



		var arraytd=[];
		var arraycol1=[];
		var arraycol2=[];
		var arrayNew22 = [];
		var numColOrde1=-1;
		var numColOrde2=-1;
		var ordenColOrde1=-1;
		var ordenColOrde2=-1;

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

			var jsonOrden = JSON.parse(json_tabla)[1];
			var arrayOrd = jsonOrden.split(',');

			if(arrayOrd[0]){
				var aux = arrayOrd[0].split('|');
				idElementoOrden.push(aux[0]);
				if(aux[1] == 'ASC'){
					tipoOrden.push('asc');
					ordenColOrde1=1;
				}else if(aux[1] == 'DESC'){
					tipoOrden.push('desc');
					ordenColOrde1=2;
				}
			}
			
			if(arrayOrd[1]){
				var aux = arrayOrd[1].split('|');
				idElementoOrden.push(aux[0]);
				if(aux[1] == 'ASC'){
					ordenColOrde2=1;
					tipoOrden.push('asc');
				}else if(aux[1] == 'DESC'){
					ordenColOrde2=2;
					tipoOrden.push('desc');
				}
			}

			var filtro = '';
			
			for (let i = 0; i < arrayC.length; i++) {
				var element = arrayC[i].split('|');
				ordenCaracteristicas.push(element[0]);
				guiaFinal.push(element[1]);
				idGuiaFinal.push(element[0]);

				var auxx = element[0];
				arrayPadres['id_' + auxx] = [];

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
						var nombreCategoria = (path.split('/'))[4];
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
								//var caractElement = data.caract;
								

								/*var caractElementAuxD = data.caract;
							
								var arrayAuxF=[];
								for (let k = 0; k < caractElementAuxD.length; k++) {
									arrayAuxF.push(caractElementAuxD[k]);
									
									if(parseInt(caractElementAuxD[k].id)==parseInt(idElementoOrden[0])){
										arraycol1.push(caractElementAuxD[k].valor)
									}else if(parseInt(caractElementAuxD[k].id)==parseInt(idElementoOrden[1])){
										arraycol2.push(caractElementAuxD[k].valor)
									}
									
								}
								arraytd.push(arrayAuxF);
								console.log("arraycol2",arraycol2)
								
								for (let w = 0; w < arraycol1.length; w++) {
									for (let q = w+1; q < arraycol1.length; q++) {
										var tipoOrdenFC1=2;
										var tipoOrdenFC2=2;
										var comparacion=compararElementos(arraycol1[w],arraycol1[q],tipoOrdenFC1);
										
										if( comparacion==2){
											var elementTd=arraytd[q];
											var paux1=arraycol1[q];
											var paux2=arraycol2[q];
											arraytd[q] = arraytd[w];
											arraytd[w] = elementTd;
											arraycol1[q] = arraycol1[w];
											arraycol1[w] = paux1;
											arraycol2[q] = arraycol2[w];
											arraycol2[w] = paux2;

										}else if( comparacion==3){
											
										console.log("arraycol1[w]",arraycol2[w])
										console.log("arraycol1[q]",arraycol2[q])
											var comparacion1=compararElementos(arraycol2[w],arraycol2[q],tipoOrdenFC1);
										console.log("comparacion",comparacion1)

											if( comparacion1==2){
												var elementTd=arraytd[q];
												var paux1=arraycol1[q];
												var paux2=arraycol2[q];
												arraytd[q] = arraytd[w];
												arraytd[w] = elementTd;
												arraycol1[q] = arraycol1[w];
												arraycol1[w] = paux1;
												arraycol2[q] = arraycol2[w];
												arraycol2[w] = paux2;

											}
										}

									}
								}*/
								

								var listadoCaracteristicas = '';
								var caractElement = [];
								listadoCaracteristicas = '';
								caractElement = data.caract;
								for (let i = 0; i < ordenCaracteristicas.length; i++) {
									const orden = ordenCaracteristicas[i];
									var encontro = false;
									for (let j = 0; j < caractElement.length; j++) {
										

										if(caractElement[j].id == orden){
											var valorCaract = caractElement[j].valor;
											var id = caractElement[j].id;

											if($.inArray(valorCaract, arrayPadres['id_'+id]) < 0){
												arrayPadres['id_'+id].push(valorCaract);
											}
											var AuxTDL=valorCaract;
											var cantDTA = 0;
											for (let l = 0; l < valorCaract.length; l++) {
												if(!isNaN(valorCaract[l]) || valorCaract[l] == ','  || valorCaract[l] == '.'){
													cantDTA++;
												}
											}
											var total12D = parseFloat(valorCaract.length);
											if(cantDTA == total12D){
												var a = valorCaract.split(',');

												if(a.length > 1){
													valorCaract=a[0]+'.'+a[1];
												}
											}

											listadoCaracteristicas += '<td class="tecni idC'+caractElement[j].id+'  '+noRefFuster+'   " data-value="'+valorCaract+'"  data-id="'+noRefFuster+'">'+valorCaract+'</td>';
											encontro = true;
										}

										if(j == caractElement.length-1){
											if(!encontro)
											{
												listadoCaracteristicas += '<td class="tecni"></td>';
											}
										}
									}

									console.log("arrayPadres", arrayPadres);
								}

								listadoAccesorios += '\
								<tr id="'+noRefFuster+'" style="display: table-row;">\
									<td class="refer">\
										<a href="'+idioma+'/'+palabra1+'/cid'+idCat+'/pid'+idp+'/'+nombreCategoria+'/'+nombreUrl+'/" title="">'+noRefFuster+'</a>\
									</td>\
									<td class="image">\
										<img id="foto-producto"	src="'+imgProd+'" alt="'+nombreUrl+'-'+noRefFuster+'" title="'+nombreUrl+'-'+noRefFuster+'">\
									</td>\
									'+listadoCaracteristicas+'\
								</tr>';


								
								arrayNew22.push(data.caract);

								if(p == result.length){
									
									for (let index99 = 0; index99 < arrayNew22.length; index99++) {
										
										
									}







									var listadoColumnas = '';
									listadoColumnas += '<th>'+refPal+'</th>';
									listadoColumnas += '<th>'+fotoPal+'</th>';
									// if(localStorage.getItem("userLogged") != "-" && localStorage.getItem("userToken") != "-"){
									// 	listadoColumnas += '<th>Precio</th>';
									// }

									

									for (let index = 0; index < guiaFinal.length; index++) {
										const element = guiaFinal[index];
										
										var option = '<option class="filtroselect" value="-">-</option>';
										var rrr = arrayPadres['id_' + idGuiaFinal[index]];
										
										var rrNumero = [];
										var rrLetra = [];

										for (let o = 0; o < rrr.length; o++) {
											
											var elemn = rrr[o];
											var cant = 0;

											for (let y = 0; y < elemn.length; y++) {
												if(!isNaN(elemn[y]) || elemn[y] == ','  || elemn[y] == '.'){
													cant++;
												}
											}

											var total = parseFloat(elemn.length);

											if(cant == total){
												var a = rrr[o].split(',');

												if(a.length > 1){
													rrNumero.push(a[0]+'.'+a[1]);
												}else{
													rrNumero.push(rrr[o]);	
												}
											}else{
												rrLetra.push(rrr[o]);		
											}

										}

										var arrayNewNumber=[];

										for (let w = 0; w < rrNumero.length; w++) {
											for (let q = w+1; q < rrNumero.length; q++) {

												var num1 = parseFloat(rrNumero[w]) * 1;
												var num2 = parseFloat(rrNumero[q]) * 1;

												if(num1>num2){
													var paux = num1;
													rrNumero[w] = num2;
													rrNumero[q] = paux;
												}
											}
										}

										rrLetra.sort();


										for (let h = 0; h < rrNumero.length; h++) {
											
											if(rrNumero[h]!="—"&&rrNumero[h]!="-"){
											option += '<option class="filtroselect" value="'+rrNumero[h]+'">'+rrNumero[h]+'</option>';
											}
										}

										for (let h = 0; h < rrLetra.length; h++) {
											if(rrLetra[h]!="—"&&rrLetra[h]!="-"){
											option += '<option class="filtroselect" value="'+rrLetra[h]+'">'+rrLetra[h]+'</option>';
											}
										}

										var valdd = parseFloat(index) + 2;
										valoresColumn[valdd] = [];
										valoresColumnD[valdd] = "";

										listadoColumnas += '<th class="bloque-filtro" data-num="'+valdd+'" >'+element+'<br>\
										<span><select id="selec'+valdd+'" class="filtroo"> \
										'+option+'\
										</select></span>\
										</th>';
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
										</table>\
									</div>\
									';

									$('#listadoTabl').html(contenido);

								}
							}
						});
					});
						
				}
			}
		});



		$(document).on('change', '.filtroo', function(e) {
			
			
			var selec = (this.parentElement.parentElement).getAttribute('data-num');
			var val = this.value;
			var auz=[];

			
			if(val=="_"){
				cargaVistaTabla();
			}else{
				if(val!="-"){
					$('#accesorios-productos tr').each(function(){
					$(this).show();
					});
					rastreator(val, selec);
				}
				
			}

			
			
			
			
			function rastreator(elem, selec){
				var rastrearA=$('#accesorios-productos tr');
					
				var rastrear=[];
				for (let a = 0; a < rastrearA.length; a++) {
					rastrear.push(rastrearA[a]);
					
				}
			
				var contenido=elem;
				var noColumna = selec;
				if($.inArray(noColumna, arrayPadresVisitados) < 0){
					if(val!="_"){
						arrayPadresVisitados.push(noColumna);
					
						
					}
					
				}else{
					//valoresColumn[noColumna]=[];
					/*if(val=="_"){
						var pos=$.inArray(noColumna, arrayPadresVisitados);
						var arrayNew=[];
						for (let index = 0; index < arrayPadresVisitados.length; index++) {
							if(arrayPadresVisitados[index]!=noColumna){
								arrayNew.push(arrayPadresVisitados[index]);
							}
							
						}
						arrayPadresVisitados=[];
						arrayPadresVisitados=arrayNew;
						
					}*/
				}
				var newConD=0;
							
				for (let z = 0; z < arrayPadresVisitados.length; z++) {
					var contA=0;
					newConD=z;
					
					var posC = 0;
					var x = arrayPadresVisitados[z];
					var vacio=z-1;
					var valorSelectX = $('#selec'+x).val();
					var auxRemove =[];
					var auxArraySelect =[];
					valoresColumnD[x]=valorSelectX;
					

					if(z<1){
						var indiceIni=1;
					}else{
						var indiceIni=0;
					}	
					valoresColumn[x]=[];
					
					for (let indiceRast = indiceIni; indiceRast < rastrear.length; indiceRast++) {
						var AuxER=(rastrear[indiceRast].children);
						var texto=AuxER[x].getAttribute("data-value");
						var elementhijoId=AuxER[x].getAttribute("data-id");
						var auxTem=[];
						for (let y = 0; y < valoresColumn[x].length; y++) {
							auxTem.push(valoresColumn[x][y]);
							
						}
						if($.inArray(texto, auxTem) < 0 ){
							if( texto!=valoresColumnD[x]){
								auxTem.push(texto);
								valoresColumn[x]=[];

								for (let y = 0; y < auxTem.length; y++) {
									valoresColumn[x].push(auxTem[y]);
								
								}

							}

						}

						if(texto == valorSelectX){
							$("#"+elementhijoId).show();
							auxRemove.push($("#"+elementhijoId));
							//var listado =$("#"+elementhijoId).find('td');

						}else{
							//ELIMINAR DE RASTREAR
							$("#"+elementhijoId).hide();
						 	contA++;
						
							
						}
						posC++;
						

					}

					
					if(contA==rastrear.length){
						
						var auz33=[];
					
						for (let v = 0; v < newConD; v++) {
							auz33.push(arrayPadresVisitados[v])
														
						}
						arrayPadresVisitados = [];
						for (let v = 0; v < auz33.length; v++) {
							arrayPadresVisitados.push(auz33[v])
														
						}
						for (let v = 0; v < rastrear.length; v++) {
							var elementhijoId2=((rastrear[v].attributes)[0]).value;
							$("#"+elementhijoId2).show();
						
						}
						
						


					}else{
						rastrear = [];
						
						for (let mm = 0; mm < auxRemove.length; mm++) {
							rastrear[mm]=auxRemove[mm][0];
							
						}
						
					}

					auz=rastrear;

					/*var loc = [];
					for (let index = 0; index < valoresColumn.length; index++) {
						var estas=2;
						for (let g = 0; g < loc.length; g++) {
							if(loc[g]==valoresColumn[index]){
								estas=1;
							}
						if(estas==2){

						}
						
					}
						
					}*/
					
					
					
					
				}
			
				

				for (let d = 0; d < auz.length; d++) {
					var AuxER12=(auz[d].children);
					for (let kk = 2; kk < AuxER12.length; kk++) {
						
						var texto12=AuxER12[kk].getAttribute("data-value");
						
						var esPadre=2;
						for (let ee = 0; ee < arrayPadresVisitados.length; ee++) {
							var parNum=parseInt(arrayPadresVisitados[ee]) 
						if(kk==parNum){
							esPadre=1;
						}
							
						}
						if(	esPadre==2){
							if(d==0){
								valoresColumn[kk]=[];
							}
							 var auxChild=[];
							
							for (let h = 0; h <valoresColumn[kk].length; h++) {
								auxChild.push(valoresColumn[kk][h]);
								
								
							}
							
							
							if($.inArray(texto12, auxChild) < 0){
								auxChild.push(texto12);
								valoresColumn[kk]=auxChild;

								valoresColumn[kk]=[];

								for (let y = 0; y < auxChild.length; y++) {
									valoresColumn[kk].push(auxChild[y]);
								
								}
							}


						}
					}
					
					
				}

			
				
			
				for (let x = 2; x < valoresColumn.length; x++) {
					var option2 = '';
					var esPadre1=2;
					for (let ee = 0; ee < arrayPadresVisitados.length; ee++) {
						var parPad=parseInt(arrayPadresVisitados[ee]);
						if(x==parPad){
							esPadre1=1;
						}
						
					}
					if(	esPadre1==2){
						option2= '<option class="filtroselect" value="-">-</option>';		
					}else{
						var option2= '<option class="filtroselect" value="'+valoresColumnD[x]+'">'+valoresColumnD[x]+'</option>';	
						
					}
					var rrr2 = valoresColumn[x];
					var rrNumero2 = [];
					var rrLetra2 = [];
					for (let oo = 0; oo < rrr2.length; oo++) {
						var elemn2 = rrr2[oo];
						var cant2 = 0;

						for (let yy = 0; yy < elemn2.length; yy++) {
							if(!isNaN(elemn2[yy]) || elemn2[yy] == ','  || elemn2[yy] == '.'){
								cant2++;
							}
						}

						var total2 = parseFloat(elemn2.length);

						if(cant2 == total2){
							var a2 = rrr2[oo].split(',');

							if(a2.length > 1){
								rrNumero2.push(a2[0]+'.'+a2[1]);
							}else{
								rrNumero2.push(rrr2[oo]);	
							}
						}else{
							rrLetra2.push(rrr2[oo]);		
						}

					}

					var arrayNewNumber2=[];

					for (let ww = 0; ww < rrNumero2.length; ww++) {
						for (let qq = ww+1; qq < rrNumero2.length; qq++) {

							var num11 = parseFloat(rrNumero2[ww]) * 1;
							var num22 = parseFloat(rrNumero2[qq]) * 1;

							if(num11>num22){
								var paux2 = num11;
								rrNumero2[ww] = num22;
								rrNumero2[qq] = paux2;
							}
						}
					}

					rrLetra2.sort();

					
					for (let hh = 0; hh < rrNumero2.length; hh++) {

						
						if(rrNumero2[hh]!="—"&&rrNumero2[hh]!="-"){
							option2 += '<option class="filtroselect" value="'+rrNumero2[hh]+'">'+rrNumero2[hh]+'</option>';
						}
					}

					for (let hh = 0; hh < rrLetra2.length; hh++) {
						if(rrLetra2[hh]!="—"&&rrLetra2[hh]!="-"){
							option2 += '<option class="filtroselect" value="'+rrLetra2[hh]+'">'+rrLetra2[hh]+'</option>';
						}
						
					}
					option2+= '<option class="filtroselect" value="_">Todo</option>';	
					

					$('#selec'+x).html(option2);


					
				}

			}
			

		});
		
		
	}

});



						
</script>






