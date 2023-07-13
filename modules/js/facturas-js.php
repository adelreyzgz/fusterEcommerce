<script>
/*global $:true */



var detalleT = 'DETALLES';
var reporteT = 'Reporte de Facturas';
var nohayT = "No hay datos disponibles";
var mostrarT = "Mostrar _MENU_ registros";
var mostrandoT = "Mostrando _START_ de _END_ de un total de _TOTAL_ entradas";
var mostrando2T = "Mostrando 0 de 0 de un total de 0 entradas";
var filtrafoT = "(filtrado de un total de _MAX_ total entradas)";
var buscarT = "Buscar:";
var noseenconT = "No se encontraron datos";
var primeraT = "Primera";
var ultimaT = "Última";
var siguienteT = "Siguiente";
var anteriorT = "Anterior";
var exportT = "Export data to excel";
var listadoT = "Listado de Facturas";
var filtroT = "Filtro";
var descargarT = "DESCARGAR";

if(idioma == 'en'){
	detalleT = 'DETAILS';
	reporteT = 'Report of Invoices';
	nohayT = "No data available";
	mostrarT = "Show _MENU_ records";
	mostrandoT = "Displaying _START_ of _END_ of a total of _TOTAL_ entries";
	mostrando2T = "Showing 0 of 0 of a total of 0 entries";
	filtrafoT = "(filtered from a total of _MAX_ total entries)";
	buscarT = "Find:";
	noseenconT = "No data found";
	primeraT = "First";
	ultimaT = "Last";
	siguienteT = "Next";
	anteriorT = "Previous";
	exportT = "Export data to excel";
	listadoT = "List of Invoices";
	filtroT = "Filter";
	descargarT = "DOWNLOAD";
}
if(idioma == 'fr'){
	detalleT = 'DÉTAILS' ;
	reporteT = 'Rapport de factures' ;
	nohayT = "Aucune donnée disponible" ;
	mostrarT = "Afficher les enregistrements _MENU_" ;
	mostrandoT = "Affichage de _START_ sur _END_ sur un total de _TOTAL_ entrées" ;
	mostrando2T = "Afficher 0 sur 0 sur un total de 0 entrées" ;
	filtrafoT = "(filtré à partir d'un total de _MAX_ entrées totales)" ;
	buscarT = "Rechercher :" ;
	noseenconT = "Aucune donnée trouvée" ;
	primeraT = "Premier" ;
	ultimaT = "Dernier" ;
	siguienteT = "Suivant" ;
	anteriorT = "Précédent" ;
	exportT = "Exporter les données vers Excel" ;
	listadoT = "Liste des factures" ;
	filtroT = "Filtre" ;	
	descargarT = "TELECHARGER";

}


var $ = $.noConflict();
$(document).ready(function($) {
	"use strict";
	
	var datosUserLogin = JSON.parse(localStorage.getItem('user_data_fuster'));
	var datosUserAddressLogin = JSON.parse(localStorage.getItem('user_data_address_fuster'));

	var indiceActivo=-1
	var id = datosUserLogin.IDCustomer;
	var nbDistribuidor = datosUserLogin.CompanyName;

	var id = datosUserLogin.IDCustomer;
	var facturas= '';
	var access_token = localStorage.getItem("access_token_fuster");
	if(access_token){
		$.ajax({
			method: "GET",
			headers: {
				"Authorization": "Bearer " + access_token
			},
			url: 'https://apiecommercefuster.ideaconsulting.es/api/invoices'
		}).done(function(response) {
				var responseERP = response.data;
				for (let i = 0; i < responseERP.length; i++) {
					const element = responseERP[i];

					const d1 = new Date(element.InvoiceDate);
					var result2 = formatDate(d1);
					var a = parseFloat(element.TotalInvoice);
					
					facturas += '\
					<tr>\
						<td>'+element.CodInvoice+'</td>\
						<td>'+result2+'</td>\
						<td>'+a.toFixed(2)+'</td>\
						<td>'+element.InvoicePaymentStatus+'</td>\
						<td style="text-align:left">\
						<a data-code="'+element.CodInvoice+'" data-id="'+element.IDInvoice+'" class="generarFactura fact'+element.CodInvoice+'" href="#">'+descargarT+'</a>\
                        <div class="loading'+element.CodInvoice+'" style="display:none;"><div class="spinner-border" style="border: .25em solid #e6e2dc;border-right-color: transparent;" role="status"></div></div>\
						</td>\
					</tr>\
					';
				}

				$('#facturas').html(facturas);

				$('#example3 thead tr')
					.clone(true)
					.addClass('filters')
					.appendTo('#example3 thead');
			
				const d = new Date();
				var titleN = ''+reporteT+' - '+d;
				var table = $('#example3').DataTable({
					"pageLength": 50,
					language: {
						"emptyTable":     nohayT,
						"lengthMenu":     mostrarT,
						"info":           mostrandoT,
						"infoEmpty":      mostrando2T,
						"infoFiltered":   filtrafoT,
						"search":         buscarT,
						"zeroRecords":    noseenconT,
						"paginate": {
							"first":      primeraT,
							"last":       ultimaT,
							"next":       siguienteT,
							"previous":   anteriorT 
						},
					},
					dom: 'Bfrtip',
					buttons: [
						{
							extend: 'excel',
							text: exportT,
							title: titleN,
							exportOptions: {
								columns: [0,1,2,3],
								modifier: {
									page: 'current'
								}
							},
							customize: function(xlsx) {

								var filtros = $('#facturasData .filters input');
								var sheet = xlsx.xl.worksheets['sheet1.xml'];
								var downrows = filtros.length + 3;
								var clRow = $('row', sheet);

								
								//update Row
								clRow.each(function () {
									var attr = $(this).attr('r');
									var ind = parseInt(attr);
									ind = ind + downrows;
									$(this).attr("r",ind);
								});
						
								// Update  row > c
								$('row c ', sheet).each(function () {
									var attr = $(this).attr('r');
									var pre = attr.substring(0, 1);
									var ind = parseInt(attr.substring(1, attr.length));
									ind = ind + downrows;
									$(this).attr("r", pre + ind);
								});
						
								function Addrow(who,index,data) {
									var s = who;
									
									var msg='<row r="'+index+'">'
									for(var i=0;i<data.length;i++){
										var key=data[i].k;
										var value=data[i].v;
										msg += '<c t="inlineStr" r="' + key + index + '" s="'+s+'">';
										msg += '<is>';
										msg +=  '<t>'+value+'</t>';
										msg+=  '</is>';
										msg+='</c>';
									}
									msg += '</row>';
									return msg;
								}
						
								//insert
								var filas = '';
								var valor = '';
								var cant = 2;

								filas += Addrow(51,1, [{ k: 'A', v: listadoT }, { k: 'B', v: '' }, { k: 'C', v: '' }]);
								filas += Addrow(5,2, [{ k: 'A', v: '' }, { k: 'B', v: '' }, { k: 'C', v: '' }]);

								for (let index = 0; index < filtros.length-1; index++) {
									const element = filtros[index];
									cant++;
									var val = '-';
									if(element.value){
										val = element.value;
									}
									valor = element.placeholder+ ': ' +val;
									filas += Addrow(2,cant, [{ k: 'A', v: valor }, { k: 'B', v: '' }, { k: 'C', v: '' }]);
								}

								cant++;
								filas += Addrow(5,cant, [{ k: 'A', v: '' }, { k: 'B', v: '' }, { k: 'C', v: '' }]);

								sheet.childNodes[0].childNodes[1].innerHTML = filas + sheet.childNodes[0].childNodes[1].innerHTML;

								var col = $('col', sheet);
								col.each(function () {
									$(this).attr('width', 40);
								});

								
								var tdo = sheet.childNodes[0].childNodes[1].innerHTML;
								var rplace = tdo.replace('<row xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" r="9"><c t="inlineStr" r="A9" s="51"><is><t xml:space="preserve">'+titleN+'</t></is></c></row>', "");

								sheet.childNodes[0].childNodes[1].innerHTML = rplace;

								console.log(sheet.childNodes[0].childNodes[1].innerHTML);

							}
						}
					],
					orderCellsTop: true,
					initComplete: function () {
						var api = this.api();
						api
							.columns()
							.eq(0)
							.each(function (colIdx) {
								var cell = $('.filters th').eq(
									$(api.column(colIdx).header()).index()
								);
								var title = $(cell).text();
								$(cell).html('<input type="text" placeholder="'+filtroT+' ' + title + '" style="padding: 6px;padding-left: 8px;border: 1px solid lightgray;" />');
			
								$(
									'input',
									$('.filters th').eq($(api.column(colIdx).header()).index())
								)
									.off('keyup change')
									.on('change', function (e) {
										// Get the search value
										$(this).attr('title', $(this).val());
										var regexr = '({search})'; //$(this).parents('th').find('select').val();
			
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
											.focus()[0];
									});
							});
					},
				});
		}).fail(function(response) {
			console.log(response);
		});
	}

	$(document).on('click', '.generarFactura', function(e) {
		e.preventDefault();
		var access_token = localStorage.getItem("access_token_fuster");
		var idFactura = $(this).data('id');
		var codeFactura = $(this).data('code');
		$('.fact'+codeFactura+'').hide();
		$('.loading'+codeFactura+'').show();
		if(access_token){

			var xhr = new XMLHttpRequest();
			xhr.open("GET", 'https://apiecommercefuster.ideaconsulting.es/api/invoices/'+idFactura+'/download');
			xhr.responseType = "arraybuffer";
			xhr.setRequestHeader("Authorization", "Bearer " + access_token);
			xhr.onload = function () {
				if (this.status === 200) {
				var blob = new Blob([xhr.response], {type: "application/pdf"});
					var objectUrl = URL.createObjectURL(blob);
					window.open(objectUrl);

					$('.fact'+codeFactura+'').show();
					$('.loading'+codeFactura+'').hide();
				}else{
					$('.fact'+codeFactura+'').show();
					$('.loading'+codeFactura+'').hide();
				}
			};
			xhr.send();

		}
	});

	function formatDate(date) {
		var d = new Date(date),
			month = '' + (d.getMonth() + 1),
			day = '' + d.getDate(),
			year = d.getFullYear();

		if (month.length < 2) 
			month = '0' + month;
		if (day.length < 2) 
			day = '0' + day;

		return [year, month, day].join('-');
	}

	$('#cerrar-sesion').click(function (e) {
        e.preventDefault();
		localStorage.setItem("access_token_fuster", '');
		localStorage.setItem("user_data_fuster", '');
		localStorage.setItem("user_data_address_fuster", '');
        localStorage.setItem("user_cart_fuster", '');
		window.location.replace("./"+idioma+"/");
	});
});

</script>