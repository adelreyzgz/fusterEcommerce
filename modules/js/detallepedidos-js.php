<script>
/*global $:true */

var $ = $.noConflict();
$(document).ready(function($) {
	"use strict";

	
	var datosUserLogin = JSON.parse(localStorage.getItem('user_data_fuster'));
	var datosUserAddressLogin = JSON.parse(localStorage.getItem('user_data_address_fuster'));

	var path = window.location.pathname;
	var pedidoId = path.match(/\/np-([a-zA-Z0-9-]+)\//).pop();
	var id = datosUserLogin.IDCustomer;
	var nbDistribuidor = datosUserLogin.CompanyName;
	var pedidoRef = '';
	$('#pedidoIdd').html(pedidoId);

	$.ajax({
		method: "GET",
		url: "<?=$base;?>000_admin/_rest/api.php?action=getPedidoById&idUser="+id+"&idPedido="+pedidoId
	}).done(function(response) {
		if(response){
			var data = JSON.parse(response);
			var resultG = data.result;
			var pedidos = '';
			for (let index = 0; index < resultG.length; index++) {
				const element = resultG[index];

				var distr= 'NbDistribuidor';
				var direEnv=element.direccionDefecto;
				var fechaSol= 'fechaSolicitado';
				var tottal= 'total';
				pedidoRef = element.pedido;
				$('.distr').html(nbDistribuidor);
				$('.direEnv').html(direEnv);
				$('.fechaSol').html(fechaSol);
				$('.tottal').html(tottal+' €');

				pedidos += '\
				<tr>\
					<td>refFuster</td>\
					<td>cantidad</td>\
					<td>precio</td>\
					<td>total</td>\
				</tr>\
				';
			}
			
			$('#pedidos').html(pedidos);

			$('#example3 thead tr')
				.clone(true)
				.addClass('filters')
				.appendTo('#example3 thead');
		
			const d = new Date();
			var titleN = 'Productos del Pedido - '+pedidoRef+' - '+d;
			var table = $('#example3').DataTable({
				"pageLength": 25,
				language: {
					"emptyTable":     "No hay datos disponibles",
					"lengthMenu":     "Mostrar _MENU_ registros",
					"info":           "Mostrando _START_ de _END_ de un total de _TOTAL_ entradas",
					"infoEmpty":      "Mostrando 0 de 0 de un total de 0 entradas",
					"infoFiltered":   "(filtrado de un total de _MAX_ total entradas)",
					"search":         "Buscar:",
					"zeroRecords":    "No se encontraron datos",
					"paginate": {
						"first":      "Primera",
						"last":       "Última",
						"next":       "Siguiente",
						"previous":   "Anterior"
					},
				},
				dom: 'Bfrtip',
				buttons: [
					{
						extend: 'excel',
						text: 'Export data products to excel',
						title: titleN,
						exportOptions: {
							columns: [0,1,2,3],
							modifier: {
								page: 'current'
							}
						},
						customize: function(xlsx) {

							var filtros = $('#pedids .filters input');
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

							filas += Addrow(51,1, [{ k: 'A', v: 'Productos del Pedido - '+pedidoRef+'' }, { k: 'B', v: '' }, { k: 'C', v: '' }]);
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
							var rplace = tdo.replace('<row xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" r="8"><c t="inlineStr" r="A8" s="51"><is><t xml:space="preserve">'+titleN+'</t></is></c></row>', "");

							sheet.childNodes[0].childNodes[1].innerHTML = rplace;

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
							$(cell).html('<input type="text" placeholder="Filtro ' + title + '" style="padding: 6px;padding-left: 8px;border: 1px solid lightgray;" />');
		
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
		}
	});
	

});

</script>