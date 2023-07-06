<script>
/*global $:true */

var $ = $.noConflict();
$(document).ready(function($) {
	"use strict";

	
	var datosUserLogin = JSON.parse(localStorage.getItem('user_data_fuster'));
	var datosUserAddressLogin = JSON.parse(localStorage.getItem('user_data_address_fuster'));

	var indiceActivo=-1
	var path = window.location.pathname;
	var pedidoId = path.match(/\/np-([a-zA-Z0-9-]+)\//).pop();
	var id = datosUserLogin.IDCustomer;
	var nbDistribuidor = datosUserLogin.CompanyName;

	$('#pedidoIdd').html(pedidoId);

	var c = { header: "ui-icon-circle-arrow-e", activeHeader: "ui-icon-circle-arrow-s" };
	if (indiceActivo > -1) {
		jQuery("#accordion").accordion({ active: indiceActivo, collapsible: !1, icons: c, heightStyle: content });
	} else {
		jQuery("#accordion").accordion({ active: !1, collapsible: !0, icons: c, heightStyle: content });
	}

	jQuery('#toggle-marcas').click(function(){jQuery('#acordeon-marcas').toggle();});
	jQuery("#toggle-buscador").click(function(){jQuery("#formBusca").toggle();});

	// {"IDCustomer":"001-27330","CodCustomer":"27330","CompanyName":"RECAMBIOS INFRA, S.L.","ZipCode":"27003","Address":"RUA DE LA AGRICULTURA P-113A","City":"LUGO","Phone1":"982214348","Email":"proveedores@recambiosinfra.com","VATNumber":"B27019736","Discount1":"50.0000000000","Discount2":"0.0000000000","Discount3":"0.0000000000","Country":"ESPAÑA","State":"Galicia","County":"Lugo"}

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

				var distr=element.pedido;
				var direEnv=element.direccionDefecto;
				var fechaSol=element.pedido;
				var tottal=element.pedido;
				
				$('.distr').html(nbDistribuidor);
				$('.direEnv').html(direEnv);
				$('.fechaSol').html(fechaSol);
				$('.tottal').html(tottal+' €');

				pedidos += '\
				<tr>\
					<td>'+element.pedido+'</td>\
					<td>'+element.fecha+'r</td>\
					<td>'+element.hora+'</td>\
					<td>'+element.hora+'</td>\
				</tr>\
				';
			}
			
			$('#pedidos').html(pedidos);

			$('#example').DataTable( {
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
			} );
		}
	});
	

});

</script>