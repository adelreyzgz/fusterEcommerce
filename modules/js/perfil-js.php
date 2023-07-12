<script>
/*global $:true */

var $ = $.noConflict();
$(document).ready(function($) {
	"use strict";
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
	');

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