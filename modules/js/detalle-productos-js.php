<style>
	.lin{
		stroke: #000;
		stroke-width: 5;
	}

	.lineas{
		position:absolute;top: 0;left: 0;width: 100%;height: 100%;z-index: 1;
	}

	.raya{
		position:absolute;width: 100%;height: 100%;
	}

	.punto{
		background-color: #31bdde;width: 24px;border-radius: 64px;height: 24px;
	}


	line {
	stroke: black;
	stroke-width: 1;
	stroke-linecap: round;
	}
</style>
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
	var cid = path.match(/\/cid([0-9]+)\//).pop();
	var mid = path.match(/\/mid([0-9]+)\//).pop();
	var pid = path.match(/\/pid([0-9]+)\//).pop();
	var P1URL = (path.split('/'))[6];
	var P2URL = (path.split('/'))[7];
	var P3URL = (path.split('/'))[8];

	
	var palabra1 = 'productos';
	var palabra2 = 'Serie';
	var palabra3 = '(Haz clic en el número deseado para ver la ficha de producto)';
	var palabra4 = 'Haz clic en el número deseado para ver la ficha de producto';
	var palabra5 = 'Conjunto de embrague';
	var palabra6 = 'Sección';
	var palabra7 = 'Despiece';
	var palabra88 = 'Dibujo Técnico';
	var palabraCompRef = 'Compuesto por REF.';

	if(idioma == 'en'){
	palabra1 = 'products';
	palabra2 = 'Serie';
	palabra3 = '(Click on the desired number to see the product sheet)';
	palabra4 = 'Click on the desired number to see the product sheet';
	palabra5 = 'Clutch Assembly';
	palabra6 = 'Section';
	palabra7 = 'Exploded view';
	palabra88 = 'Dibujo Técnico';
	palabraCompRef = 'Composed by REF.';

	}

	if(idioma == 'fr'){
	palabra1 = 'produits';
	palabra2 = 'Série';
	palabra3 = '(Cliquez sur le numéro souhaité pour voir la fiche produit)';
	palabra4 = 'Cliquez sur le numéro souhaité pour voir la fiche produit';
	palabra5 = "Assemblage d'embrayage";
	palabra6 = 'Section';
	palabra7 = 'Vue éclatée';
	palabra88 = 'Dibujo Técnico';
	var eskit=0;
	var refComponen="";
	palabraCompRef = 'Composé par REF.';

	}
	
	$.ajax({
		method: "GET",
		url: "<?=$base;?>000_admin/_rest/api.php?action=detalleProducto&idProd="+pid+"&idMarc="+mid
	}).done(function(response) {
		if(response){
			var data = JSON.parse(response);
			var result = data.result;


			var i = 0;
			eskit=result[0].esKit;
			refComponen=result[0].refComp;
			var arrayGeneral = [];
			var arrayRefOem = [];
			var arraySerie = [];
			var arrayModel = [];

			var aRefOemC = [];
			var aSerieC = [];
			var aModelC = [];
			var marca = '';
			var refUNI = '';
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
								for (let i = 0; i < responseERP.length; i++) {
									const respElement = responseERP[i];
									for (let j = 0; j < result.length; j++) {
										const element = result[j];
										if(respElement.CodArticle == element.noRefFuster){
											result[j].IDArticle = respElement.IDArticle;
											result[j].Description = respElement.Description;
											result[j].Price = Math.round(respElement.Price);
											result[j].Stock = Math.round(respElement.Stock);
										}
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
					marca = data.result[0].marca
					var listadoRefCate = [];
					$.each( result, function( i, row ){
							var $insert = false;

							listadoRefCate.push({
								'refOem' : row.refOem,
								'categoria' : row.idCategoria,
								'nbCategoria' : row.categoria,
								'padreID' : row.idPadre,
								'padre' : row.catPadre
							})

							refUNI = row.noRefFuster;
							if($.inArray(row.refOem, aRefOemC) == -1){

								aRefOemC = [];
								aSerieC = [];
								aModelC = [];
								
								aRefOemC.push(row.refOem);
								arrayRefOem.push(row.refOem);

								$.each( result, function( j, row2 ){
									if($.inArray(row2.serie, aSerieC) == -1 && row2.refOem == row.refOem){		

										$.each( result, function( h, row3 ){
											if($.inArray(row3.idMod, aModelC) == -1 && row3.refOem == row.refOem && row3.serie == row2.serie ){
												aModelC.push(row3.idMod);
												arrayModel.push(row3.modelo);
												$insert = true;
											}
										});

										aSerieC.push(row2.serie);
										arraySerie.push({ 
											"serie"    : row2.serie,
											"modelos"  : arrayModel,
										});
										
										arrayModel = [];
									}
								});

							}

							if($insert){
								$insert = false;
								arrayGeneral.push({ 
									"refOem"    : arrayRefOem,
									"series"  : arraySerie,
								});

								arraySerie = [];
								arrayRefOem = [];
							}
						
					});
					
					var arrayCopy = JSON.parse( JSON.stringify( arrayGeneral ) );

					for ( var k = 0, p = arrayGeneral.length; k < p; k++ ) {
						if(arrayGeneral[k]){
							var aux2 = arrayGeneral[k];
							for ( var j = 0, l = arrayCopy.length; j < l; j++ ) {
								var serieGeneral = JSON.stringify(aux2.series);
								var serieCopy = JSON.stringify(arrayCopy[j].series);
							
								if((serieGeneral == serieCopy) && ($.inArray(arrayCopy[j].refOem[0], aux2.refOem) == -1)){
									var aux = arrayCopy[j].refOem[0];
									aux2.refOem.push(aux);
								}
							};
						}
					}
					
					for ( var k = 0, p = arrayGeneral.length; k < p; k++ ) {
						arrayGeneral[k].refOem = (arrayGeneral[k].refOem).sort();
					}
					
					function removeDuplicates(originalArray, prop) {
						var newArray = [];
						var lookupObject  = {};

						for(var i in originalArray) {
							lookupObject[originalArray[i][prop]] = originalArray[i];
						}

						for(i in lookupObject) {
							newArray.push(lookupObject[i]);
						}
						return newArray;
					}

					var uniqueArray = removeDuplicates(arrayGeneral, "refOem");
					
					var template = '';
					var nombreProd = 'x' + $('.nombreProdHtml').text();

					if(nombreProd.indexOf("Kit")>-1 || nombreProd.indexOf("kit")>-1  || nombreProd.indexOf("Conjunto")>-1){
						var arrayContadorMax = [];
						for (let index = 0; index < uniqueArray.length; index++) {
							var arr = uniqueArray[index].refOem;
							arrayContadorMax.push(arr.length);
						}

						var mayor = 0;
						var pos = 0;
						for(i = 0; i < arrayContadorMax.lenght; i++){
							if (arrayContadorMax[i] > mayor)
							{
								mayor = arrayContadorMax[i];
								pos = i;
							};
						}

						var uniqueArray2 = uniqueArray[pos];
						uniqueArray = [];
						uniqueArray.push(uniqueArray2);

					}

					for ( var k = 0, p = uniqueArray.length; k < p; k++ ) {

						var series = uniqueArray[k].series;
						var refOem = uniqueArray[k].refOem;
						var templateSeries = '';
						
						for ( var j = 0, w = series.length; j < w; j++ ) {
							templateSeries +='\
								<ul class="nombre-serie">\
									<li class="nombre-serie">'+palabra2+': '+series[j].serie+'</li>\
								</ul>\
							';

							var modelos = series[j].modelos;
							for ( var r = 0, u = modelos.length; r < u; r++ ) {
								templateSeries +='\
									<li>'+modelos[r]+'</li>\
								';
							}

						}

						var aCategoriaC = [];

						for ( var i = 0, w = refOem.length; i < w; i++ ) {
							for ( var j = 0, t = listadoRefCate.length; j < t; j++ ) {

								if(refOem[i] == listadoRefCate[j].refOem){
									if($.inArray(listadoRefCate[j].categoria, aCategoriaC) == -1){
										aCategoriaC.push(listadoRefCate[j].categoria);
									}
								}
							}
						}

						var secciones = '';
						var templateRefOem = '';
						var templateSecRefTotal = '';

						for ( var i = 0, y = aCategoriaC.length; i < y; i++ ) {

							var idCat = aCategoriaC[i];
							var idPad = '';
							var nbCat = '';
							var nbPad = '';

							for ( var o = 0, s = listadoRefCate.length; o < s; o++ ) {
								if(listadoRefCate[o].categoria == idCat){
									idPad = listadoRefCate[o].padreID;
									nbCat = listadoRefCate[o].nbCategoria;
									nbPad = listadoRefCate[o].padre;
									break;
								}
							}

							var nbCatURL = cleanName(nbCat);
							var url = ''+idioma+'/'+palabra1+'/mid'+mid+'/cid'+idCat+'/'+P1URL+'/'+nbCatURL+'/';
							var separador = '<span class="separadorr"></span>';
							var categoriaRow = nbPad + separador + '<a href="'+url+'">'+ nbCat +'</a>';
							var separado = nbCat.split(' ');				

							if((separado[0] == 'Conjunto' && separado[1] == 'Embrague') 
							|| (separado[0] == 'Cto.' && separado[1] == 'Embrague') 
							|| (separado[0] == 'Clutch' && separado[1] == 'Ensemble') 
							|| (separado[0] == 'Cto.Embrague') 
							|| (separado[0] == 'Ensemble' && separado[1] == 'Embrayage') ){
								
							}else{
								var ignoreRef = [];

								secciones = '<div class="field field-name-field-ref-oem field-type-text field-label-above" style="margin-bottom: -8px;margin-top: 15px;">\
									<div class="field-label">\
										<span>'+palabra6+':</span>\
									</div>\
									<div class="field-items">\
										<div class="field-item even">\
											<span style="padding: 1px 0;display: block;"> '+categoriaRow+'</span>\
										</div>\
									</div>\
								</div>';
								
								if(separado[0] != 'Cto.Embrague'){
								var tiene = false;
								templateRefOem = '<div class="field field-name-field-ref-oem field-type-text field-label-above">\
									<div class="field-label"><span>REF. OEM:</span></div>\
									<div class="field-items">\
										<div class="field-item even">\
											<ul>';

								for ( var j = 0, w = refOem.length; j < w; j++ ) {
									for ( var h = 0, t = listadoRefCate.length; h < t; h++ ) {
										if(aCategoriaC[i] == listadoRefCate[h].categoria 
										&& refOem[j] == listadoRefCate[h].refOem 
										&& $.inArray(refOem[j], ignoreRef) == -1 ) 
										{

											if(refOem[j] != refUNI){
												tiene = true;
												ignoreRef.push(refOem[j]);
												templateRefOem +='\
													<li style="margin-top: 1px;">'+refOem[j]+'</li>\
												';
											}
										}
									}
								}

								templateRefOem += '</ul>\
										</div>\
									</div>\
								</div>';	
								}
								var arrayRefComponen=refComponen.split(",");
								var templateRefomponen="";

								if(eskit== 'si'){
									templateRefomponen += '<div class="field field-name-field-ref-oem field-type-text field-label-above">\
										<div class="field-label"><span>'+palabraCompRef+':</span></div>\
										<div class="field-items">\
											<div class="field-item even">\
												<ul>';

									for ( var j = 0; j < arrayRefComponen.length;  j++ ) {
										templateRefomponen +='<li style="margin-top: 1px;">'+arrayRefComponen[j]+'</li>';
									}

									templateRefomponen += '</ul>\
											</div>\
										</div>\
									</div>';	
								}
								if(!tiene){
									templateRefOem = '';
								}
								templateSecRefTotal += secciones + templateRefOem  + templateRefomponen;
							}
							
						}

						template += '\
						<div class="ficha-oem">\
							<div class="field field-name-field-marca-tractor field-type-text field-label-above">\
								<div class="field-label"><span><?=${"lang_".$idioma}["marcadeltractor"];?>:</span></div>\
								<div class="field-items">\
									<div class="field-item even" style="font-size: 14px;font-weight: 600;">'+marca+'</div>\
								</div>\
							</div>\
							<div class="field field-name-field-modelo-tractor field-type-text field-label-above">\
								<div class="field-label"><span><?=${"lang_".$idioma}["modelodeltractor"];?>:</span></div>\
								<div class="field-items">\
									<div class="field-item even">\
										<ul>\
										'+templateSeries+'\
										</ul>\
									</div>\
								</div>\
							</div>\
							'+templateSecRefTotal+'\
						</div>\
						';
					}

					$('.listadoResumen').html(template);

					$('.divCarrito').html('<span class="cantLetter"> Cant. </span><input min="0" max="50" type="number" value="0" name="precio" class="inputPrecio">\
					<a href="#" style="width: 156px;display: inline-block;text-align: center;" class="addCarrito" \
					data-refFuster='+data.result[0].noRefFuster+'  \
					data-idarticle='+data.result[0].IDArticle+'\
					data-description="'+data.result[0].Description+'"\
					data-price='+data.result[0].Price+'\
					data-stock='+data.result[0].Stock+'\
					data-img="'+$("#foto-producto").attr("src")+'"\
					data-idProd='+pid+'> Añadir al Carrito </a>');
				}
			}
		}
	});

	$.ajax({
		method: "GET",
		url: "<?=$base;?>000_admin/_rest/api.php?action=dibujarDespiece&idProd="+pid+"&idMarc="+mid
	}).done(function(response) {
		if(response){
			var data = JSON.parse(response);
			var result = data.result;
			var puntosInteres = data.puntosInteres;
			var datashow55 = '';
			var entro = false;
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
				
				if(idPlano==529 && ancho == 725 && alto == 457){ancho = 1200; alto = 783;}

				if(tipoP == 'PP' && !entro){
					datashow55 += '\
						<div class="despiece">\
							<h3 class="sub-titulo">'+palabra88+'</h3>\
							<div class="dibujo-tecnico">\
							<img src="assets/images/'+tipoP+'/'+imagenFondo+'" alt="'+tipoP+'-'+ P3URL+'" title="'+tipoP+'-'+ P3URL +'" id="imagen0" width="'+ancho+'">\
							</div>\
						</div>';
					entro = true;
				}else if(tipoP == 'PD'){
					if(ancho >= 900){
						datashow55 += '\
						<div class="despiece">\
							<h3 class="sub-titulo">'+palabra7+' <span style="color: #6c6c6c;font-size: 12px;">'+palabra3+'</span></h3>\
							<div class="hotspot-demo" style="overflow-x: auto;">\
								<div class="hotspot-demo-1" id="plano'+idPlano+'" style="width: 900px;">\
								<img src="assets/images/'+tipoP+'/'+imagenFondo+'" alt="'+tipoP+'-'+ P3URL+'" title="'+tipoP+'-'+ P3URL +'" id="imagen0" width="900">\
									<div class="spots">';
					}else {
						datashow55 += '\
						<div class="despiece">\
							<h3 class="sub-titulo">'+palabra7+' <span style="color: #6c6c6c;font-size: 12px;">'+palabra3+'</span></h3>\
							<div class="hotspot-demo" style="overflow-x: auto;">\
								<div class="hotspot-demo-1" id="plano'+idPlano+'" style="width: '+ancho+'px;">\
								<img src="assets/images/'+tipoP+'/'+imagenFondo+'" alt="'+tipoP+'-'+ P3URL+'" title="'+tipoP+'-'+ P3URL +'" id="imagen0" width="'+ancho+'">\
									<div class="spots" style="z-index: 2;">';
					}
				
					var c = 0;
					var globosVisitados = new Array();

					for (let index = 0; index < puntosInteres[i].length; index++) {
						var row2 = puntosInteres[i][index];
						var encontro = -1;
						
						$.each( globosVisitados, function( key, value ) {
							if(value.ref == row2.arrayRefFuster){
								encontro = value.c;
							}
						});

                      	if(row2.arrayRefFuster != '[]'){
							console.log('entro')
							console.log(row2.arrayRefFuster)
						}else{
							console.log('vacio')
							console.log(row2.arrayRefFuster)
						}

                      
						if(row2.arrayRefFuster != '[]'){
							if(encontro == -1){
								c++;
								globosVisitados.push({
									"row": row2,
									"c": c,
									"ref": row2.arrayRefFuster
								});
							}else{
								globosVisitados.push({
									"row": row2,
									"c": encontro,
									"ref": row2.arrayRefFuster
								});
							}
						}
					}
                  	
                  	console.log('*******', globosVisitados);

					for (let index = 0; index < globosVisitados.length; index++) {
						var row2 = globosVisitados[index].row;
						var coordenada = JSON.parse(row2.coordenada);
						if(coordenada.length<3){
							var x = coordenada[0];
							var y = coordenada[1];
							console.log("y: ", y);


							if(ancho>2000){
								var top = y*100/alto+0.1;
								var left = x*100/ancho+1;
								var tipoUnidad = '%';
							}else if(ancho>1900){
								var top = y*100/alto-4.5;
								var left = x*100/ancho-1;
								var tipoUnidad = '%';
							}else if(ancho>1200){
								var top = y*100/alto-4;
								var left = x*100/ancho-0.6;
								var tipoUnidad = '%';
							}else if(ancho>1190){
								var top = y/1.40;
								var left = x/1.36;
								var tipoUnidad = 'px';
							}else if(ancho<=1190){
								var top = y*100/alto;
								var left = x*100/ancho;
								var tipoUnidad = '%';
							}
							
							var refM = JSON.parse(globosVisitados[index].ref);
							var list = '';

							for (let index = 0; index < refM.length; index++) {
								list += '*'+refM[index];
							}

							if(row2.idPlano == idPlano){
								if(x == xfija && y == yfija){

									console.log('Si x == xfija && y == yfija');
									console.log('GLOBO: ', globosVisitados[index].c)
									console.log("----");

									datashow55 += '\
									<div id="spot-'+idPlano+'-'+index+'" data-ref="'+list+'" style="position: absolute; top: '+top+''+tipoUnidad+'; left:'+left+''+tipoUnidad+';">\
										<span class="spot" data-ref="'+list+'" data-idplano="'+idPlano+'" data-idplanocapa="#despiece_info-'+idPlano+'"  style="background-color: #141213;color: white;cursor:pointer;" >'+globosVisitados[index].c+'</span>\
									</div>';

								}else{
									//PINTAR EL GLOBO DE OTRO COLOR
									console.log('No x == xfija && y == yfija');
									console.log('GLOBO: ', globosVisitados[index].c)
									console.log("----");

									datashow55 += '\
									<div id="spot-'+idPlano+'-'+index+'" data-ref="'+list+'" style="position: absolute; top: '+top+''+tipoUnidad+'; left:'+left+''+tipoUnidad+';">\
										<span  class="spot" data-ref="'+list+'" data-idplano="'+idPlano+'" data-idplanocapa="#despiece_info-'+idPlano+'" style="color: white;cursor:pointer;" >'+globosVisitados[index].c+'</span>\
									</div>';
								}
								
							}
						}
					}

					console.log("-----------------");

					datashow55 += '\
									</div>';

					// datashow55 += '\
					// <div class="lineas">';

					// var lin = '<div class="svgLinesDiv">';

					// var numero = 0;
					// for (let index = 0; index < globosVisitados.length; index++) {
					// 	var row2 = globosVisitados[index].row;
					// 	var coordenada = JSON.parse(row2.coordenada);
					// 	if(coordenada.length>2){
					// 		numero++;

					// 		var x1 = coordenada[0];
					// 		var y1 = coordenada[1];
					// 		console.log('var x1', coordenada[0])
					// 		console.log('var y1', coordenada[1])
					// 		console.log('var x2', coordenada[2])
					// 		console.log('var y2', coordenada[3])
					// 		console.log('-------')

					// 		coordenada[0] = ((y1*100)/alto) - 2;
					// 		coordenada[1] = ((x1*100)/ancho) - 2;
							
					// 		var x2 = coordenada[2];
					// 		var y2 = coordenada[3];
					// 		coordenada[2] = ((y2*100)/alto) - 2;
					// 		coordenada[3] = ((x2*100)/ancho) - 2;
						
					// 		var anchoo = ancho; //900
					// 		var altoo = alto; //448

					// 		if(ancho >= 900){
					// 			anchoo = 900;
					// 			altoo = alto * 75 / 100;
					// 		}

					// 		x1 = (coordenada[1] + parseFloat(2)) * anchoo / 100;
					// 		y1 = (coordenada[0] + parseFloat(2)) * altoo / 100;
					// 		x2 = ((coordenada[3] + parseFloat(2)) * anchoo / 100);
					// 		y2 = ((coordenada[2] + parseFloat(2)) * altoo / 100);


					// 		if(alto>1700){
					// 			y1 = y1 - 120;
					// 			y2 = y2 - 120;
					// 		}else if(alto>1500){
					// 			y1 = y1 - 340;
					// 			y2 = y2 - 340;
					// 		}

					// 		datashow55 += '\
					// 		<svg class="raya">\
					// 		<line x1="'+x1+'" y1="'+y1+'" x2="'+x2+'" y2="'+y2+'" />\
					// 		</svg>\
					// 		';

					// 	}
					// }
					
					// lin += '\
					// </div>';

					// datashow55 += lin+'\
					// </div>';

					

					datashow55 += '\
								</div>\
							</div>\
							<p>'+palabra4+'</p>\
							<div id="despiece_info-'+idPlano+'" class="despiece-listado listadoProductosBusquedaA" style="padding-top: 25px;">\
						</div>';
				}

			}

			$('.contenedorDespieces').html(datashow55);

			// var canvas = document.getElementById("dibujo");
			// var ctx = canvas.getContext("2d");
		
			// var numero = 0;
			// for (let index = 0; index < globosVisitados.length; index++) {
			// 	var row2 = globosVisitados[index].row;
			// 	var coordenada = JSON.parse(row2.coordenada);
			// 	if(coordenada.length>2){
			// 			numero++;

			// 			var x = coordenada[0];
			// 			var y = coordenada[1];
			// 			coordenada[0] = ((y*100)/alto) - 2;
			// 			coordenada[1] = ((x*100)/ancho) - 2;
						
			// 			var x = coordenada[2];
			// 			var y = coordenada[3];
			// 			coordenada[2] = ((y*100)/alto) - 2;
			// 			coordenada[3] = ((x*100)/ancho) - 2;

			// 			ctx.moveTo(coordenada[1],coordenada[0]);
			// 			ctx.lineTo(coordenada[2],coordenada[3]);
			// 	}
			// }

			
			// ctx.strokeStyle = "#f00";
			// ctx.stroke();


		}
	});	

	$(document).on('click',  '.spot', function(){ 
		var busqueda = $(this).attr("data-ref");
		var capa = $(this).attr("data-idplanocapa");
		var idPlano = $(this).attr("data-idplano");

		$('html, body').animate({scrollTop: $(capa).offset().top - 200}, 1200);

		var arrayData = [];
		$.ajax({
		method: "POST",
		data: { refOem: busqueda },
		url: "<?=$base;?>000_admin/_rest/api.php?action=buscarByRefOemConjunto"
		}).done(function(response) {
			if(response){
				var data = JSON.parse(response);
				var access_token = localStorage.getItem("access_token_fuster");

				if(access_token){
					var result = data.result[0];
					// INICIO INTERCEPTOR
					console.log('INICIO INTERCEPTOR')
					var arrayRefFusterI = '';

					for (let index = 0; index < result.length; index++) {
						const element = result[index];

						console.log('element', element)

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

					console.log('arrayRefFusterI', arrayRefFusterI)
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
										if(respElement.CodArticle == element.noRefFuster){
											result[j].IDArticle = respElement.IDArticle;
											result[j].Description = respElement.Description;
											result[j].Price = Math.round(respElement.Price);
											result[j].Stock = Math.round(respElement.Stock);
										}
									}
								}

								// OBJETO MODIFICADO CON DATOS DEL ERP
								console.log('OBJETO MODIFICADO CON DATOS DEL ERP');
								console.log('--------------')
								// --------------

								logicaOld2(result);

								// --------------

							// FIN REQUEST INTERCEPTOR
						}).fail(function(response) {
							console.log(response);
						});
					}
				}else{
					var result = data.result;
					logicaOld3(result);
				}
				// FIN INTERCEPTOR


				function logicaOld2(busqueda){
					var result = [];
					console.log('BUSQUEDA', busqueda)
					for (let i = 0; i < busqueda.length; i++) {
						var elemento = busqueda[i];
						if(result.length == 0){
							result.push(elemento);
						}else{
							var encontro = -1;
							for (let j = 0; j < result.length; j++) {
								if(elemento.id == result[j].id){
									encontro++;
								}
							}

							if(encontro == -1){
								result.push(elemento);
							}
						}
					}
					
					console.log('result', result)

					var p = 0;
					if(result.length > 0){
						$(capa).html('');
						var marcasIgnore = [];
						result.forEach(function(row, index) {
							var idMarcaS = row['idMar'];
							var nbMarcaS = row['nbMarca'];

							if($.inArray(idMarcaS, marcasIgnore) == -1){
								marcasIgnore.push(idMarcaS);
								$(capa).append('<div class="M'+idMarcaS+'P'+idPlano+'" style="margin-bottom: 28px;"><h3 class="rotulo-marca">'+nbMarcaS+'</h3></div>');
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
														var refFuster = row["noRefFuster"];
														var dataShow3 = '';
														var resultRefOemById = row.refOems;
														var resultCaractId = row.caract;
														dataShowRefOem = '';
														dataShowCaract = '';
														var tipodisplay = 'display: initial;';
														if(resultRefOemById != '-'){
															dataShowRefOem = '<div class="producto-oems">\
																<div class="field-label"><span>REF. OEM:</span></div>\
																<div class="field-items">\
																	<div class="field-item even">\
																		<ul>';
																resultRefOemById.forEach(function(row2, index2) {	

																	dataShowRefOem +='\
																	<li style="margin-top: 1px;">'+row2['refOem']+'</li>';
																});

															dataShowRefOem += '</ul>\
																	</div>\
																</div>\
															</div>';	
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
														var nombreMarca = cleanName(row["nbMarca"]);
														var idMar = row["idMar"];
														var nombreCategoria = cleanName(row["nbCategoria"]);
														var idCat = row["idCat"];
														var idp = row["id"];

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
																		<span class="precioProductos">  Precio: '+row["Price"]+'€ </span>\
																	</h4>\
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
															<div class="bloque-oem">\
																'+dataShowRefOem+'\
															</div>\
														</div>\
														';
													

														$('div.M'+idMar+'P'+idPlano+'').append(dataShow3);
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

				function logicaOld3(busqueda){
					var result = [];

					for (let i = 0; i < busqueda.length; i++) {
						var listado = busqueda[i];
						for (let k = 0; k < listado.length; k++) {
							var elemento = listado[k];

							if(result.length == 0){
								result.push(elemento);
							}else{
								var encontro = -1;
								for (let j = 0; j < result.length; j++) {
									if(elemento.id == result[j].id){
										encontro++;
									}
								}

								if(encontro == -1){
									result.push(elemento);
								}
							}
						}
					}
					
					var p = 0;
					if(result.length > 0){
						$(capa).html('');
						var marcasIgnore = [];
						result.forEach(function(row, index) {
							var idMarcaS = row['idMar'];
							var nbMarcaS = row['nbMarca'];

							if($.inArray(idMarcaS, marcasIgnore) == -1){
								marcasIgnore.push(idMarcaS);
								$(capa).append('<div class="M'+idMarcaS+'P'+idPlano+'" style="margin-bottom: 28px;"><h3 class="rotulo-marca">'+nbMarcaS+'</h3></div>');
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
														var refFuster = row["noRefFuster"];
														var dataShow3 = '';
														var resultRefOemById = row.refOems;
														var resultCaractId = row.caract;
														dataShowRefOem = '';
														dataShowCaract = '';
														var tipodisplay = 'display: initial;';
														if(resultRefOemById != '-'){
															dataShowRefOem = '<div class="producto-oems">\
																<div class="field-label"><span>REF. OEM:</span></div>\
																<div class="field-items">\
																	<div class="field-item even">\
																		<ul>';
																resultRefOemById.forEach(function(row2, index2) {	

																	dataShowRefOem +='\
																	<li style="margin-top: 1px;">'+row2['refOem']+'</li>';
																});

															dataShowRefOem += '</ul>\
																	</div>\
																</div>\
															</div>';	
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
														var nombreMarca = cleanName(row["nbMarca"]);
														var idMar = row["idMar"];
														var nombreCategoria = cleanName(row["nbCategoria"]);
														var idCat = row["idCat"];
														var idp = row["id"];

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
																<div class="field-items">\
																<div class="field-item even" style="'+tipodisplay+'">'+dataShowCaract+'</div>\
																</div>\
																<div class="divCarrito">\
																	<span class="cantLetter"> Cant. </span><input type="number" name="precio" value="1" class="inputPrecio">\
																	<a href="#" class="addCarrito"  data-refFuster='+row["noRefFuster"]+'> Añadir al Carrito </a>\
																</div>\
															</div>\
															<div class="bloque-oem">\
																'+dataShowRefOem+'\
															</div>\
														</div>\
														';
													

														$('div.M'+idMar+'P'+idPlano+'').append(dataShow3);
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
	});

	$.ajax({
		method: "GET",
		url: "<?=$base;?>000_admin/_rest/api.php?action=dibujarEmbrague&idProd="+pid+"&idMarc="+mid
	}).done(function(response) {
		$('.ficha-embrague').html('');

		if(response){
			var data = JSON.parse(response);
			var result = data.result;
			var nombre = data.nombre;

			var visitados = [];
			var resultFinal = [];
			var x = 1;
			if(nombre.length==1){
				x = 0;
			}
			
			for (let i = 0; i < nombre.length - x; i++) {
				var c = -1;
				for (let h = 0; h < visitados.length; h++) {
					if(i == visitados[h]){
						c++;
					}					
				}

				if(c == -1){
					var inserto = false;

					var aux = [];
					for (let j = i+1; j < nombre.length; j++) {
						if(nombre[i] == nombre[j]){
							aux.push(result[i].concat(result[j]));
							visitados.push(j);
							inserto = true;
						}	
					}

					if(!inserto){
						resultFinal.push(result[i]);
					}else{
						var f = aux[0];
						for (let t = 1; t < aux.length; t++) {
							f = f.concat(aux[t]);
						}
						resultFinal.push(f);
					}

				}

			}

			var auxSeleccionado = [];
			for (let index = 0; index < nombre.length; index++) {
				var element = nombre[index];
				if(auxSeleccionado.length == 0){
					auxSeleccionado.push(element);
				}else{
					var c = -1;
					for (let j = 0; j < auxSeleccionado.length; j++) {
						var elementAux = auxSeleccionado[j];
						if(element == elementAux){
							c++;
						}
					}

					if(c==-1){
						auxSeleccionado.push(element);
					}
				}
			}


			for (let i = 0; i < resultFinal.length; i++) {
				var element = resultFinal[i];
				var key = 'id';
				var arrayUniqueByKey = [...new Map(element.map(item => [item[key], item])).values()];
				resultFinal[i] = arrayUniqueByKey;
			}

			if(auxSeleccionado.length > 0){
				$('.ficha-embrague').append('<h3 class="sub-titulo">'+palabra5+'</h3>');
			}
			
			for (let i = 0; i < auxSeleccionado.length; i++) {
				var embrague = auxSeleccionado[i];
				
				var template = '<h4 class="num_conjunto_embrague">'+embrague+'</h4>\
									<table id="embrague-'+embrague+'" class="table embragues stacktable large-only">\
										<tbody>\
											<tr>\
												<td>\
													<div class="embrague-position-wrapper">';
													
				var templatePrensa = '<div class="parte-embrague prensa">';
				var templateDiscoInterior = '<div class="parte-embrague discoInterior">';
				var templateDiscoExterior = '<div class="parte-embrague discoExterior">';
				var templateRodamientoEmbrague = '<div class="parte-embrague rodamientoEmbrague">';
				var templateResto = '<div class="parte-embrague discoResto" style="display: flex;width: 50%;">';
								
				var templateRodamientoExterior = '<div class="parte-embrague rodamientoExterior">';
				var templateRodamientoInterior = '<div class="parte-embrague rodamientoInterior">';
				var templateRodamientoPiloto = '<div class="parte-embrague rodamientoPiloto">';
				var templateSoporteRodamiento = '<div class="parte-embrague rodamientoSoporte">';

				var prensaC = 0;
				var discoIC = 0;
				var discoEC = 0;
				var rodamientoEmbC = 0;
				var rodamientoPilC = 0;
				var soporteRodaC = 0;
				var rodamientoExtC = 0;
				var rodamientoIntC = 0;
				

				for (let j = 0; j < resultFinal[i].length; j++) {
					const element = resultFinal[i][j].nbesp;
					const refFuster = resultFinal[i][j].noRefFuster;
					const nombre = resultFinal[i][j].nombre;
					const idCategoria = resultFinal[i][j].idCategoria;
					const nombreCategoria = cleanName(resultFinal[i][j].nombreCategoria);
					const nombreURL = cleanName(resultFinal[i][j].nombre);

					var imgProd = "assets/images/default.png";
					if(resultFinal[i][j].thumbnails){
						imgProd = "assets/images/repuestos/fotos/"+idioma+"/" + resultFinal[i][j].thumbnails;
					}

					const id = resultFinal[i][j].id;

					var url = ''+idioma+'/'+palabra1+'/mid'+mid+'/cid'+idCategoria+'/pid'+id+'/'+P1URL+'/'+nombreCategoria+'/'+nombreURL+'/';


					// <div>\
					// 	<input type="number" name="precio" value="1" class="inputPrecio" style="height: 26px;width: 54px;border: 0px solid #a2a2a2;margin-top: 0px;margin-right: 6px;">\
					// 	<a href="#" class="addCarrito"  data-refFuster='+refFuster+' style="padding: 2.2px 15px;padding-bottom: 4px;"> \
					// 		<img src="assets/images/carrito_bold.svg" style="width: 18px;">\
					// 	</a>\
					// </div>\

					var separado = element.split(' '); 
					if((separado[0] == 'Prensa') || (separado[0] == 'Clutch' && separado[1] =='assembly') || (separado[0] == 'Mecanisme' && separado[1] =="d'embrayage")){
						prensaC++;
						templatePrensa += '\
						<div class="contenido-embrague" style="width: 140px;height: 202px;border: 1px solid #ebebeb;margin-bottom: 5px;padding-left: 5px;padding-right: 5px;">\
							<a href="'+url+'">\
								<img id="foto-producto" style="height: 130px;width: 130px;"	src="'+imgProd+'" alt="'+nombreURL+'-'+refFuster+'" title="'+nombreURL+'-'+refFuster+'">\
								<p class="refer">Ref. '+refFuster+'</p>\
								<p style="height: 45px;line-height: 15px;">'+nombre+'</p>\
								<span class="precioProductos" style="font-size: 15px;">   </span>\
							</a>\
						</div>';
					}else if((separado[0] == 'Disco' && separado[1] =='Interior')  || (separado[0] == 'Clutch' && separado[1] =='main')){
						discoIC++;
						templateDiscoInterior += '\
						<div class="contenido-embrague" style="width: 140px;height: 202px;border: 1px solid #ebebeb;margin-bottom: 5px;padding-left: 5px;padding-right: 5px;">\
							<a href="'+url+'">\
								<img id="foto-producto" style="height: 130px;width: 130px;"	src="'+imgProd+'" alt="'+nombreURL+'-'+refFuster+'" title="'+nombreURL+'-'+refFuster+'" >\
								<p class="refer">Ref. '+refFuster+'</p>\
								<p style="height: 45px;line-height: 15px;">'+nombre+'</p>\
								<span class="precioProductos" style="font-size: 15px;">   </span>\
							</a>\
						</div>'; 
					}else if((separado[0] == 'Disco' && separado[1] =='Exterior') || (separado[0] == 'Clutch' && separado[1] =='plate') || (separado[0] == 'Disque' && separado[1] =="d'avancement")){
						discoEC++;
						templateDiscoExterior += '\
						<div class="contenido-embrague" style="width: 140px;height: 202px;border: 1px solid #ebebeb;margin-bottom: 5px;padding-left: 5px;padding-right: 5px;">\
							<a href="'+url+'">\
								<img id="foto-producto" style="height: 130px;width: 130px;"	src="'+imgProd+'" alt="'+nombreURL+'-'+refFuster+'" title="'+nombreURL+'-'+refFuster+'">\
								<p class="refer">Ref. '+refFuster+'</p>\
								<p style="height: 45px;line-height: 15px;">'+nombre+'</p>\
								<span class="precioProductos" style="font-size: 15px;">   </span>\
							</a>\
						</div>';
					}else if((separado[0] == 'Rodamiento' && separado[1] =='embrague')){
						rodamientoEmbC++;
						templateRodamientoEmbrague += '\
						<div class="contenido-embrague" style="width: 140px;height: 202px;border: 1px solid #ebebeb;margin-bottom: 5px;padding-left: 5px;padding-right: 5px;">\
							<a href="'+url+'">\
								<img id="foto-producto" style="height: 130px;width: 130px;"	src="'+imgProd+'" alt="'+nombreURL+'-'+refFuster+'" title="'+nombreURL+'-'+refFuster+'">\
								<p class="refer">Ref. '+refFuster+'</p>\
								<p style="height: 45px;line-height: 15px;">'+nombre+'</p>\
								<span class="precioProductos" style="font-size: 15px;">   </span>\
							</a>\
						</div>';
					}else if((separado[0] == 'Rodamiento' && separado[1] =='piloto')){
						rodamientoPilC++;
						templateRodamientoPiloto += '\
						<div class="contenido-embrague" style="width: 140px;height: 202px;border: 1px solid #ebebeb;margin-bottom: 5px;padding-left: 5px;padding-right: 5px;">\
							<a href="'+url+'">\
								<img id="foto-producto" style="height: 130px;width: 130px;"	src="'+imgProd+'" alt="'+nombreURL+'-'+refFuster+'" title="'+nombreURL+'-'+refFuster+'">\
								<p class="refer">Ref. '+refFuster+'</p>\
								<p style="height: 45px;line-height: 15px;">'+nombre+'</p>\
								<span class="precioProductos" style="font-size: 15px;">   </span>\
							</a>\
						</div>';
					}else if((separado[0] == 'Soporte' && separado[1] =='rodamiento')){
						soporteRodaC++;
						templateSoporteRodamiento += '\
						<div class="contenido-embrague" style="width: 140px;height: 202px;border: 1px solid #ebebeb;margin-bottom: 5px;padding-left: 5px;padding-right: 5px;">\
							<a href="'+url+'">\
								<img id="foto-producto" style="height: 130px;width: 130px;"	src="'+imgProd+'" alt="'+nombreURL+'-'+refFuster+'" title="'+nombreURL+'-'+refFuster+'">\
								<p class="refer">Ref. '+refFuster+'</p>\
								<p style="height: 45px;line-height: 15px;">'+nombre+'</p>\
								<span class="precioProductos" style="font-size: 15px;">   </span>\
							</a>\
						</div>';
					}else if((separado[0] == 'Rod.' && separado[1] =='Exterior') || (separado[0] == 'Rodamiento' && separado[1] =='Exterior')){
						rodamientoExtC++;
						templateRodamientoExterior += '\
						<div class="contenido-embrague" style="width: 140px;height: 202px;border: 1px solid #ebebeb;margin-bottom: 5px;padding-left: 5px;padding-right: 5px;">\
							<a href="'+url+'">\
								<img id="foto-producto" style="height: 130px;width: 130px;"	src="'+imgProd+'" alt="'+nombreURL+'-'+refFuster+'" title="'+nombreURL+'-'+refFuster+'">\
								<p class="refer">Ref. '+refFuster+'</p>\
								<p style="height: 45px;line-height: 15px;">'+nombre+'</p>\
								<span class="precioProductos" style="font-size: 15px;">   </span>\
							</a>\
						</div>';
					}else if((separado[0] == 'Rodamiento' && separado[1] =='interior')){
						rodamientoIntC++;
						templateRodamientoInterior += '\
						<div class="contenido-embrague" style="width: 140px;height: 202px;border: 1px solid #ebebeb;margin-bottom: 5px;padding-left: 5px;padding-right: 5px;">\
							<a href="'+url+'">\
								<img id="foto-producto" style="height: 130px;width: 130px;"	src="'+imgProd+'" alt="'+nombreURL+'-'+refFuster+'" title="'+nombreURL+'-'+refFuster+'">\
								<p class="refer">Ref. '+refFuster+'</p>\
								<p style="height: 45px;line-height: 15px;">'+nombre+'</p>\
								<span class="precioProductos" style="font-size: 15px;">   </span>\
							</a>\
						</div>';
					}else{ // Rodamiento
						templateResto += '\
						<div class="contenido-embrague" style="margin-right: 5px;width: 140px;height: 202px;border: 1px solid #ebebeb;margin-bottom: 5px;padding-left: 5px;padding-right: 5px;">\
							<a href="'+url+'">\
								<img id="foto-producto" style="height: 130px;width: 130px;"	src="'+imgProd+'" alt="'+nombreURL+'-'+refFuster+'" title="'+nombreURL+'-'+refFuster+'">\
								<p class="refer">Ref. '+refFuster+'</p>\
								<p style="height: 45px;line-height: 15px;">'+nombre+'</p>\
								<span class="precioProductos" style="font-size: 15px;">   </span>\
							</a>\
						</div>';
					}

				}

				templatePrensa += '</div>';
				templateDiscoInterior += '</div>';
				templateDiscoExterior += '</div>';
				templateResto += '</div>';
				templateRodamientoEmbrague += '</div>';

				templateRodamientoExterior += '</div>';
				templateRodamientoInterior += '</div>';
				templateRodamientoPiloto += '</div>';
				templateSoporteRodamiento += '</div>';

				if(!prensaC){templatePrensa = '';}
				if(!discoIC){templateDiscoInterior = '';}
				if(!discoEC){templateDiscoExterior = '';}
				if(!rodamientoEmbC){templateRodamientoEmbrague = '';}
				if(!rodamientoPilC){templateRodamientoPiloto = '';}
				if(!soporteRodaC){templateSoporteRodamiento = '';}
				if(!rodamientoExtC){ templateRodamientoExterior= '';}
				if(!rodamientoIntC){ templateRodamientoInterior= '';}

				template += '\
								'+templatePrensa+'\
								'+templateDiscoInterior+'\
								'+templateDiscoExterior+'\
								'+templateRodamientoEmbrague+'\
								'+templateRodamientoExterior+'\
								'+templateRodamientoInterior+'\
								'+templateRodamientoPiloto+'\
								'+templateSoporteRodamiento+'\
								'+templateResto+'\
								</div>\
							</td>\
						</tr>\
					</tbody>\
				</table>';
				
				$('.ficha-embrague').append(template);
			}

		}
	});	

	$("#lightgallery").lightGallery(); 
});

function lanzarslide() { var objeto = document.getElementById("enlaceimagen" + contagen); objeto.click(); }

function cambiar_foto(archivo, conti) { 
	var objeto = document.getElementById("foto-producto"); 
	var objeto2 = document.getElementById("foto-ampliada"); 
	objeto.src = archivo; contagen = conti; 
}

function imagen_modal_avan(avance) { var objeto = document.getElementById("imagen-modal"); objeto.src = "<?=$base;?>sites/default/files/productos/es/000000000/000000000003_mangueta-derecha-960.jpg"; }

</script>