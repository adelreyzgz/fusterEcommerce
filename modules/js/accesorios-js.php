<script>
/*global $:true */
const removeAccents = (str) => {
  return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}


var palabra1 = 'accesorios';
if(idioma == 'en'){
palabra1 = 'accesories';
}else if(idioma == 'fr'){
palabra1 = 'accessoires';
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



	
	var raices = [];
	$.ajax({
		method: "GET",
		url: "<?=$base;?>000_admin/_rest/api.php?action=categoriasHijas&idCategoria=13"
	}).done(function(response) {
		if(response){
			var data = JSON.parse(response);
			var resultG = data.result;
			var dataShow = '';
			var cant = 0;
			if(data.code == 1 && resultG.length > 0){
				$.ajax({
					method: "GET",
					url: "<?=$base;?>000_admin/_rest/api.php?action=listarCategoriasAccesorios"
				}).done(function(response) {
					if(response){
						var data = JSON.parse(response);
						var result2 = data.result;
						for (let index = 0; index < result2.length; index++) {
							var element = result2[index];
							element = JSON.parse(element);
							var aux = element.padres;
							aux = aux.split(',');
							aux = aux.reverse();
							element.padres = aux;
							result2[index] = element;
						}

						var retorno = [];
						var datos = result2;
						var cantidadt = 0;
						var arrayPadresGeneral = [];

						for (var j = 0; j < datos.length; j++) {
							var padres = datos[j].padres;
							var idTemp = [];
							var elementTemp = [];
							var padreElement = [];
							var newFather = 0;
							var element = [];
							var arrayRaiz = [];
							var cont = padres.length - 1;
							var elementRaiz = [];

							for (var e = padres.length - 1; e >= 0; e--) {
								var statusP = 1;
								var indiceD = e - 1;
								var padreRef = "NotDRVO"
								if (indiceD > -1) {
									padreRef = padres[indiceD]

								}

								for (var z = 0; z < arrayPadresGeneral.length; z++) {
									var a = removeAccents(arrayPadresGeneral[z].nombre);
									a.toLowerCase();
									var b = removeAccents(padres[e]);
									b.toLowerCase();

									var c = removeAccents(arrayPadresGeneral[z].padre);
									c.toLowerCase();
									var d = removeAccents(padreRef);
									d.toLowerCase();


									if ((a == b) && (c == d)) {
										statusP = 2;
									}
								}
								if (statusP == 1) {
									var padreElArrayP = [];
									for (var m = indiceD; m >= 0; m--) {
										padreElArrayP.push(padres[m])
									}
									var jsonRaizP = {
										"padres": padreElArrayP,
										"padre": padreRef,
										"nombre": padres[e]
									}
									arrayPadresGeneral.push(jsonRaizP)
								}
							}

							for (var i = 0; i < padres.length; i++) {
								var padreItem = padres[i];


								if (i == 0 && i != cont) {
									var indiceRaiz = -1;
									var elementRaiz = [];

									var cantidad = 0;
									if (retorno.length >= 1) {
										for (var k = 0; k < retorno.length; k++) {
											var a = removeAccents(retorno[k].name);
											a.toLowerCase();
											var b = removeAccents(padreItem);
											b.toLowerCase();
											if (a == b) {
												indiceRaiz = k;
												elementRaiz = retorno[k].categorias;

												cantidad = parseFloat(retorno[k].cantidad) + parseFloat(0);;
											}
										}
										var jsonRaiz = {
											"cantidad": cantidad,
											"categorias": elementRaiz,
											"name": padreItem
										}
										elementTemp.push(jsonRaiz)
										arrayRaiz.push(indiceRaiz);


									} else {
										var jsonRaiz = {
											"cantidad": cantidad,
											"categorias": elementRaiz,
											"name": padreItem
										}
										elementTemp.push(jsonRaiz)
										arrayRaiz.push(indiceRaiz);
									}

								} else if (i == cont) {
									var cantidadSum = parseFloat(0) + parseFloat(datos[j].hijos);
									var indicePadretA = elementTemp.length;
									var elementActual = [];
									var cantidad = 0;

									if (i == 0) {
										if (retorno.length >= 1) {
											var auxStatus = 1;
											var datosAuxUnic = [];
											for (var f = 0; f < retorno.length; f++) {
												var a = removeAccents(retorno[f].name);

												a.toLowerCase();
												var b = removeAccents(padreItem);
												b.toLowerCase();
												if (retorno[f].name) {
													if (a == b) {
														auxStatus = 2;
														indiceRaiz = f;
														datosAuxUnic = retorno[f].categorias;
														datosAuxUnic.push(datos[j])
														cantDia
														var auxCantN = retorno[f].cantidad
														cantidad = parseFloat(auxCantN) + parseFloat(datos[j].hijos);

														cantidad = 0;
														var lwlw = [];
														for (var dia = 0; dia < datosAuxUnic.length; dia++) {
															if (datosAuxUnic[dia].hijos) {
																cantidad = parseFloat(cantidad) + parseFloat(datosAuxUnic[dia].hijos)
															} else {
																cantidad = parseFloat(cantidad) + parseFloat(datosAuxUnic[dia].cantidad)
															}

														}



													}
												}

											}
											if (auxStatus == 2) {
												var jsonRaiz = {
													"cantidad": cantidad,
													"categorias": datosAuxUnic,
													"name": padreItem
												}
												retorno[indiceRaiz] = jsonRaiz
											} else {
												cantidad = parseFloat(0) + parseFloat(datos[j].hijos);
												datosAuxUnic.push(datos[j])
												cantidad = 0;
												for (var dia = 0; dia < datosAuxUnic.length; dia++) {
													if (datosAuxUnic[dia].name) {
														cantidad = parseFloat(cantidad) + parseFloat(datosAuxUnic[dia].cantidad)

													} else {
														cantidad = parseFloat(cantidad) + parseFloat(datosAuxUnic[dia].hijos)
													}

												}
												var jsonRaiz = {
													"cantidad": cantidad,
													"categorias": datosAuxUnic,
													"name": padreItem
												}
												retorno.push(jsonRaiz)
											}



											elementTemp.push(retorno[k])
											arrayRaiz.push(indiceRaiz);


										} else {
											var datosAuxUnic = [];
											var cantidad = parseFloat(0) + parseFloat(datos[j].hijos);
											datosAuxUnic.push(datos[j])
											var jsonRaiz = {
												"cantidad": cantidad,
												"categorias": datosAuxUnic,
												"name": padreItem
											}
											retorno.push(jsonRaiz)
										}
									} else {
										var elementActual = elementTemp[indicePadretA - 1].categorias;
										var indiceRaiz = -1;
										var elementRaiz = [];
										var aunCa = parseFloat(0) + parseFloat(datos[j].hijos);
										var aunCa1 = 0;
										if (elementActual.length >= 1) {
											var statusT = 1;
											for (var z = 0; z < elementActual.length; z++) {
												if (elementActual[z].name) {
													var a = removeAccents(elementActual[z].name);
													a.toLowerCase();
													var b = removeAccents(padreItem);
													b.toLowerCase();
													if (a == b) {
														statusT = 2;
														indiceRaiz = z;
														elementRaiz = elementActual[z].categorias;
														cantidad = parseFloat(elementActual[z].cantidad) + parseFloat(datos[j].hijos);


													}
												}

											}
											var jsonRaiz = {
												"cantidad": cantidad,
												"categorias": elementRaiz,
												"name": padreItem
											}
											elementTemp.push(jsonRaiz)
											arrayRaiz.push(indiceRaiz);
										} else {
											if (i > 0) {
												var jsonRaiz = {
													"cantidad": 0,
													"categorias": elementRaiz,
													"name": padreItem
												}
												elementTemp.push(jsonRaiz)
												arrayRaiz.push(-1);
											}

										}
										var auxont = elementTemp.length - 1;
										var sumCont = parseFloat(datos[j].hijos) + parseFloat(0)
										for (var t = elementTemp.length - 1; t >= 0; t--) {

											var elementAux = elementTemp[t].categorias;
											var cont = elementTemp[t].cantidad;
											var nameFcat = elementTemp[t].name;
											var siguiente = t - 1;
											var anterior = t + 1;


											if (t == auxont) {
												var cont = parseFloat(sumCont) + parseFloat(elementTemp[t].cantidad)
												var cantDia = 0;

												elementAux.push(datos[j])
												for (var dian = 0; dian < elementAux.length; dian++) {
													if (elementAux[dian].name) {
														cantDia = parseFloat(cantDia) + parseFloat(elementAux[dian].cantidad)

													} else {
														cantDia = parseFloat(cantDia) + parseFloat(elementAux[dian].hijos)
													}

												}

												var jsonRaiz = {
													"cantidad": cantDia,
													"categorias": elementAux,
													"name": nameFcat
												}
												elementTemp[t] = jsonRaiz;
											} else if (siguiente > -1) {
												elementAux = elementTemp[t].categorias;
												var ind = arrayRaiz[anterior];
												if (arrayRaiz[anterior] == -1) {
													var cont = parseFloat(sumCont) + parseFloat(elementTemp[t].cantidad)


													var cantDia = 0;
													for (var dian = 0; dian < elementAux.length; dian++) {
														if (elementAux[dian].name) {
															cantDia = parseFloat(cantDia) + parseFloat(elementAux[dian].cantidad)
														} else {
															cantDia = parseFloat(cantDia) + parseFloat(elementAux[dian].hijos)
														}

													}
													cantDia = parseFloat(cantDia) + parseFloat(elementTemp[anterior].cantidad)
													elementAux.push(elementTemp[anterior])
													var jsonRaiz = {
														"cantidad": cantDia,
														"categorias": elementAux,
														"name": nameFcat
													}
													elementTemp[t] = jsonRaiz;
												} else {
													var cont = parseFloat(sumCont) + parseFloat(elementTemp[t].cantidad)
													elementAux[ind] = elementTemp[anterior]

													var cantDia = 0;
													for (var dian = 0; dian < elementAux.length; dian++) {
														if (elementAux[dian].name) {
															cantDia = parseFloat(cantDia) + parseFloat(elementAux[dian].cantidad)

														} else {
															cantDia = parseFloat(cantDia) + parseFloat(elementAux[dian].hijos)
														}

													}


													var jsonRaiz = {
														"cantidad": cantDia,
														"categorias": elementAux,
														"name": nameFcat
													}
													elementTemp[t] = jsonRaiz;
												}


											} else {
												elementAux = elementTemp[t].categorias;
												var indUlt = arrayRaiz[1];
												if (indUlt == -1) {

													elementAux.push(elementTemp[1])
													var cantDia = 0;
													for (var dian = 0; dian < elementAux.length; dian++) {
														if (elementAux[dian].name) {
															cantDia = parseFloat(cantDia) + parseFloat(elementAux[dian].cantidad)
														} else {
															cantDia = parseFloat(cantDia) + parseFloat(elementAux[dian].hijos)

														}

													}
													var jsonRaiz = {
														"cantidad": cantDia,
														"categorias": elementAux,
														"name": nameFcat
													}
													elementTemp[0] = jsonRaiz;
												} else {
													elementAux[indUlt] = elementTemp[1]
													var cantDia = 0;
													for (var dian = 0; dian < elementAux.length; dian++) {
														if (elementAux[dian].name) {
															cantDia = parseFloat(cantDia) + parseFloat(elementAux[dian].cantidad)
														} else {
															cantDia = parseFloat(cantDia) + parseFloat(elementAux[dian].hijos)

														}

													}
													var jsonRaiz = {
														"cantidad": cantDia,
														"categorias": elementAux,
														"name": nameFcat
													}
													elementTemp[0] = jsonRaiz;
												}


												var ind = arrayRaiz[0];
												if (ind == -1) {
													retorno.push(elementTemp[0]);
												} else {
													retorno[ind] = elementTemp[0];
												}
											}

										}
									}



								} else {
									var indicePadretA = elementTemp.length - 1;
									var elementActual = [];
									var cantidad = 0;
									elementActual = elementTemp[indicePadretA].categorias;
									var indiceRaiz = -1;
									var elementRaiz = [];
									if (elementActual.length >= 1) {
										var auxStatus = 1;
										for (var z = 0; z < elementActual.length; z++) {
											if (elementActual[z].name) {
												var a = removeAccents(elementActual[z].name);
												a.toLowerCase();
												var b = removeAccents(padreItem);
												b.toLowerCase();
												if (a == b) {
													indiceRaiz = z;
													elementRaiz = elementActual[z].categorias;
													cantidad = parseFloat(0) + parseFloat(elementActual[z].cantidad);
													auxStatus == 2;

												}
											}

										}
										var jsonRaiz = {
											"cantidad": cantidad,
											"categorias": elementRaiz,
											"name": padreItem
										}
										elementTemp.push(jsonRaiz)
										arrayRaiz.push(indiceRaiz);
									} else {
										var jsonRaiz = {
											"cantidad": 0,
											"categorias": elementRaiz,
											"name": padreItem
										}
										elementTemp.push(jsonRaiz)
										arrayRaiz.push(-1);
									}




								}

							}


						}

						function getHijos(elemento, newPadreD, padre, listElementos) {
							var padresGenerales = padre;

							var datos = listElementos;
							var retornos2 = []
							var padres = [];
							for (var i = 0; i < padresGenerales.length; i++) {
								var a = removeAccents(padresGenerales[i].nombre);
								a.toLowerCase();
								var b = removeAccents(elemento);
								b.toLowerCase();
								var c = removeAccents(padresGenerales[i].padre);
								c.toLowerCase();
								var d = removeAccents(newPadreD);
								d.toLowerCase();


								if ((a == b) && (c == d)) {
									padres = padresGenerales[i].padres;
								}
							}

							var arrayTemp = []
							if (padres.length >= 1) {

							} else { }
							for (var i = 0; i < datos.length; i++) {
								if (datos[i].name == padres[padres.length - 1]) {
									arrayTemp.push(datos[i])
								}
							}

							for (var i = padres.length - 2; i >= 0; i--) {
								var elementActual = [];
								elementActual = arrayTemp[arrayTemp.length - 1].categorias;
								for (var m = 0; m < elementActual.length; m++) {
									if (elementActual[m].name == padres[i]) {
										arrayTemp.push(elementActual[m]);
									}
								}
							}

							var Padreelement = [];
							if (padres.length >= 1) {
								Padreelement = arrayTemp[arrayTemp.length - 1].categorias;
							} else {
								Padreelement = datos;
							}

							var aux = [];
							for (var w = 0; w < Padreelement.length; w++) {
								if (Padreelement[w].name == elemento) {
									aux = Padreelement[w].categorias
								}
							}

							for (var w = 0; w < aux.length; w++) {
								var espadre = 0;
								var nombreE = "";
								var cantidad = 0;
								var id = -1;

								if (aux[w].name) {
									espadre = 1;
									nombreE = aux[w].name;
									cantidad = aux[w].cantidad
								} else {
									nombreE = aux[w].nombre;
									cantidad = aux[w].hijos
									id = aux[w].idCategoria
								}
								var jsonRaiz = {
									"cantidad": cantidad,
									"name": nombreE,
									"esPadre": espadre,
									"id": id
								}

								retornos2.push(jsonRaiz)
							}
							return retornos2;
						}

						$(document).on('click',  '.clickCate', function(){ 

							var hermano = $(this).next();
							if(hermano.length == 1){
								hermano.remove(); 
							}else{
								var name = $(this).attr('data-name');
								var namePadre = $(this).attr('data-name-padre');

								var hijos = getHijos(name,  namePadre, arrayPadresGeneral, retorno);

								var data = '';
								data += '<ul style="margin-top: 7px;margin-bottom: 7px;">';
								for (let t = 0; t < hijos.length; t++) {
									var element = hijos[t];
									var cleanNombre = cleanName(element.name);
									var cantHijos = element.cantidad;
									if(element.esPadre){
										data += '\
											<li>\
												<div class="group clickCate" data-name-padre="'+name+'"  data-name="'+element.name+'" style="margin-right: 0px;">\
												<div><img class="fuster-icon-list-t" alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUAQMAAAC3R49OAAAAA1BMVEX///+nxBvIAAAAAXRSTlMAQObYZgAAAAxJREFUeNpjYKAuAAAAUAABzc0khgAAAABJRU5ErkJggg==" width="6" height="6">\
												<label class="" data-name="'+element.name+'" for="item-2-0">'+element.name+'</label>\
												</div>\
												<span>'+cantHijos+'</span>\
												</div>\
											</li>';
									}else{
										data += '\
											<li class="group"  style="margin-right: 0px;">\
												<label for="item-2-0">\
												<a href="'+idioma+'/'+palabra1+'/cid'+element.id+'/'+cleanNombre+'/">'+element.name+'</a></label>\
												<span>'+cantHijos+'</span>\
											</li>';
									}
								}
								data += '</ul>';

								$(this).parent().append(data);
							}
						});

						retorno.forEach(function(row, index) {
							var hijos = row.categorias;
							var nombre = row.name;
							var position = index;
							if(nombre!=""){
								if(cant % 5 == 0){
									dataShow += '<div class="masonryColumnBis" style="width: 50%;">';
								}
								cant++;	

								
								var imgPadre = '';
								
								if(idioma == 'fr'){
									switch(row.name){
										case 'Carrosserie et cabine':
											imgPadre = 'carroceria';
										break;
										case 'Electricité':
											imgPadre = 'electricidad';
										break;
										case 'Attelage':
											imgPadre = 'enganche';
										break;
										case 'Hydraulique':
											imgPadre = 'hidraulico';
										break;
										case "Bague d'etanchéité par dimension":
											imgPadre = 'reten';
										break;
										case 'Roulement par dimension':
											imgPadre = 'rodamiento';
										break;
										case 'Rotules':
											imgPadre = 'rotula';
										break;
										case 'Boulons et écrous':
											imgPadre = 'tuerca';
										break;
										case 'Transmission et Prise de force':
											imgPadre = 'transmision';
										break;
										case 'Flexibles':
											imgPadre = 'tuberia';
										break;
									}
								}else if(idioma == 'en'){
									switch(row.name){
										case 'Cab and body parts' :
											imgPadre = 'carroceria';
										break;
										case 'Electrical components':
											imgPadre = 'electricidad';
										break;
										case 'Linkage':
											imgPadre = 'enganche';
										break;
										case 'Hydraulics':
											imgPadre = 'hidraulico';
										break;
										case 'Oil seal by size':
											imgPadre = 'reten';
										break;
										case 'Bearings by size':
											imgPadre = 'rodamiento';
										break;
										case 'Tie rods':
											imgPadre = 'rotula';
										break;
										case 'Bolts and nuts':
											imgPadre = 'tuerca';
										break;
										case 'Transmission and PTO':
											imgPadre = 'transmision';
										break;
										case 'Hoses':
											imgPadre = 'tuberia';
										break;
									}
								}else{
									switch(row.name){
										case 'Carrocería y cabina':
											imgPadre = 'carroceria';
										break;
										case 'Electricidad':
											imgPadre = 'electricidad';
										break;
										case 'Enganche':
											imgPadre = 'enganche';
										break;
										case 'Hidráulica':
											imgPadre = 'hidraulico';
										break;
										case 'Retenes por medidas':
											imgPadre = 'reten';
										break;
										case 'Rodamientos por medidas':
											imgPadre = 'rodamiento';
										break;
										case 'Rótulas':
											imgPadre = 'rotula';
										break;
										case 'Tornillos y tuercas':
											imgPadre = 'tuerca';
										break;
										case 'Transmisión y toma de fuerza':
											imgPadre = 'transmision';
										break;
										case 'Tuberías':
											imgPadre = 'tuberia';
										break;
									}
								}
								

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
											<h3  style="font-weight: 700;" class="pos-'+position+'" >'+nombre+'</h3>\
										</div>\
										<div class="css-treeview">\
										<ul>';
									
										for (let index = 0; index < hijos.length; index++) {
											var element = hijos[index];
											var idCategoria = element.idCategoria;
											var cantHijos = 0;
											if(element.hijos){
												cantHijos = element.hijos;
											}
											if(element.nombre){
												var cleanNombre = cleanName(element.nombre);

												dataShow += '\
												<li class="group">\
													<label for="item-2-0">&nbsp; &nbsp;\
													<a href="'+idioma+'/'+palabra1+'/cid'+idCategoria+'/'+cleanNombre+'/">'+element.nombre+'</a></label>\
													<span>'+cantHijos+'</span>\
												</li>';
												
											}else{
												dataShow += '\
												<li>\
													<div class="group clickCate" data-name-padre="'+nombre+'" data-name="'+element.name+'" >\
													<div><img class="fuster-icon-list-t" alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUAQMAAAC3R49OAAAAA1BMVEX///+nxBvIAAAAAXRSTlMAQObYZgAAAAxJREFUeNpjYKAuAAAAUAABzc0khgAAAABJRU5ErkJggg==" width="6" height="6">\
													<label class="" data-name="'+element.name+'" for="item-2-0">'+element.name+'</label>\
													</div>\
													<span>'+element.cantidad+'</span>\
													</div>\
												</li>';
											}
											
										}

								dataShow += '\
									</ul>\
								</li>';

								if(cant % 5 == 0){
									dataShow += '</div>';
									cant=0;
								}
							}
						});
						$('#listadoCategorias').html(dataShow);
					}
				});				
			}
		}
	});
});

</script>

