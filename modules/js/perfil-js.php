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

	// {"IDCustomer":"001-27330","CodCustomer":"27330","CompanyName":"RECAMBIOS INFRA, S.L.","ZipCode":"27003","Address":"RUA DE LA AGRICULTURA P-113A","City":"LUGO","Phone1":"982214348","Email":"proveedores@recambiosinfra.com","VATNumber":"B27019736","Discount1":"50.0000000000","Discount2":"0.0000000000","Discount3":"0.0000000000","Country":"ESPAÑA","State":"Galicia","County":"Lugo"}

	var datosUserLogin = JSON.parse(localStorage.getItem('user_data_fuster'));
	var datosUserAddressLogin = JSON.parse(localStorage.getItem('user_data_address_fuster'));

	$('.datos-perfil').html('\
		<div id="perfilData">\
		<h4 style="margin-bottom: 15px;margin-top: 50px;">Información de Perfil</h4>\
		<p style="color:#141213;padding: 7px;">\
			<span style="font-weight: 600;"> Nombre: </span>\
			<span> '+datosUserLogin.CompanyName+' </span>\
		</p>\
		<p style="color:#141213;padding: 7px;">\
			<span style="font-weight: 600;"> Dirección: </span>\
			<span> '+datosUserLogin.Address+' </span>\
		</p>\
		<p style="color:#141213;padding: 7px;">\
			<span style="font-weight: 600;"> Código Postal: </span>\
			<span> '+datosUserLogin.ZipCode+' </span>\
		</p>\
		<p style="color:#141213;padding: 7px;">\
			<span style="font-weight: 600;"> Ciudad: </span>\
			<span> '+datosUserLogin.City+' </span>\
		</p>\
		<p style="color:#141213;padding: 7px;">\
			<span style="font-weight: 600;"> País: </span>\
			<span> '+datosUserLogin.Country+' </span>\
		</p>\
		<p style="color:#141213;padding: 7px;">\
			<span style="font-weight: 600;"> Correo: </span>\
			<span> '+datosUserLogin.Email+' </span>\
		</p>\
		<p style="color:#141213;padding: 7px;">\
			<span style="font-weight: 600;"> Teléfono: </span>\
			<span> '+datosUserLogin.Phone1+' </span>\
		</p>\
		</div>\
		<hr style="margin: 77px;margin-bottom: 74px;">\
		\
	');

	var direcciones = '';
	datosUserAddressLogin = datosUserAddressLogin.data;

	direcciones +='<div id="direccionesData">\
	<h4 style="margin-bottom: 25px;">Direcciones de Envio</h4>\
	';

	for (let index = 0; index < datosUserAddressLogin.length; index++) {
		const element = datosUserAddressLogin[index];

		var defecto = '';
		if(element.DefaultAddress && element.DefaultAddress == "1"){
			defecto = '<p style="color:#141213;padding: 7px;">\
				<span style="font-weight: 600;color: #db3838;"> Dirección de envio por defecto </span>\
				</p>';
		}

		var n = parseFloat(index)+parseFloat(1);

		direcciones +='\
			<fieldset style="border: 1px solid gainsboro;">\
			<legend style="font-size: 19px;"> Dirección de envio #'+n+': </legend>\
			'+defecto+'\
			<p style="color:#141213;padding: 7px;">\
				<span style="font-weight: 600;"> Dirección: </span>\
				<span> '+element.Address+' </span>\
			</p>\
			<p style="color:#141213;padding: 7px;">\
				<span style="font-weight: 600;"> Código Postal: </span>\
				<span> '+element.ZipCode+' </span>\
			</p>\
			<p style="color:#141213;padding: 7px;">\
				<span style="font-weight: 600;"> Ciudad: </span>\
				<span> '+element.City+' </span>\
			</p>\
			<p style="color:#141213;padding: 7px;">\
				<span style="font-weight: 600;"> País: </span>\
				<span> '+element.Country+' </span>\
			</p>\
			</fieldset>\
		';
	}

	direcciones +='</div>';

	console.log(direcciones)
	$('.datos-perfil').append(direcciones);

	$('#cerrar-sesion').click(function (e) {
        e.preventDefault();
		localStorage.setItem("access_token_fuster", '');
		localStorage.setItem("user_data_fuster", '');
		localStorage.setItem("user_data_address_fuster", '');
        localStorage.setItem("user_cart_fuster", '');
		window.location.replace("./");
	});

	var id = datosUserLogin.IDCustomer;
	$.ajax({
		method: "GET",
		url: "<?=$base;?>000_admin/_rest/api.php?action=getPedidos&idUser="+id
	}).done(function(response) {
		if(response){
			var data = JSON.parse(response);
			var resultG = data.result;

			var pedidos = '';
			
			for (let index = 0; index < resultG.length; index++) {
				const element = resultG[index];
				pedidos += '\
				<tr>\
					<td>'+element.pedido+'</td>\
					<td>'+element.fecha+'r</td>\
					<td>'+element.hora+'</td>\
					<td>'+element.cantidad+'</td>\
					<td>'+element.valor+' €</td>\
					<td><a href="'+idioma+'/perfil/np-'+element.pedido+'/">VER DETALLE</a></td>\
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


	var id = datosUserLogin.IDCustomer;

	var access_token = localStorage.getItem("access_token_fuster");
	if(access_token){
		// INICIO INTERCEPTOR
		console.log('INICIO INTERCEPTOR')
		var arrayRefFusterI = '';

			$.ajax({
				method: "GET",
				headers: {
					"Authorization": "Bearer " + access_token
				},
				url: 'https://apiecommercefuster.ideaconsulting.es/api/orders'
			}).done(function(response) {
				// INICIO REQUEST INTERCEPTOR
					var responseERP = response.data;
					for (let i = 0; i < responseERP.length; i++) {
						const respElement = responseERP[i];
						for (let j = 0; j < result.length; j++) {
							const element = result[j];
							if(respElement.CodArticle == element.noRefFuster){
								result[j].IDArticle = respElement.IDArticle;
								result[j].Price = Math.round(respElement.Price);
								result[j].Stock = Math.round(respElement.Stock);
								result[j].Description = respElement.Description;

							}
						}
					}

					// OBJETO MODIFICADO CON DATOS DEL ERP
					console.log('OBJETO MODIFICADO CON DATOS DEL ERP');
					console.log('--------------')
					// --------------

					//----------------------------------------

					// --------------

				// FIN REQUEST INTERCEPTOR
			}).fail(function(response) {
				console.log(response);
			});
	}


	$.ajax({
		method: "GET",
		url: "<?=$base;?>000_admin/_rest/api.php?action=getPedidos&idUser="+id
	}).done(function(response) {
		if(response){
			var data = JSON.parse(response);
			var resultG = data.result;

			var pedidos = '';
			
			for (let index = 0; index < resultG.length; index++) {
				const element = resultG[index];
				pedidos += '\
				<tr>\
					<td>'+element.pedido+'</td>\
					<td>'+element.fecha+'r</td>\
					<td>'+element.hora+'</td>\
					<td>'+element.cantidad+'</td>\
					<td>'+element.valor+' €</td>\
					<td><a href="'+idioma+'/perfil/np-'+element.pedido+'/">VER DETALLE</a></td>\
				</tr>\
				';
			}
			
			$('#pedidos').html(pedidos);

			$('#example2').DataTable( {
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