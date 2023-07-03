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
		\
		<hr>\
		\
	');

	var direcciones = '';
	datosUserAddressLogin = datosUserAddressLogin.data;
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
			<legend> Dirección de envio #'+n+': </legend>\
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
});

</script>