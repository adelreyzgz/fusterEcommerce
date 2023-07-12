<script>
/*global $:true */

var nombreT = 'Nombre';
var dirT = 'Dirección';
var codPT = 'Código Postal';
var ciudadT = 'Ciudad';
var paisT = 'País';
var correoT = 'Correo';
var telefT = 'Teléfono';

if(idioma == 'en'){
	nombreT = 'Name';
	dirT = 'Address';
	codPT = 'Postal Code';
	ciudadT = 'City';
	paisT = 'Country';
	correoT = 'Mail';
	telefT = 'Phone';
}
if(idioma == 'fr'){
	nombreT = 'Nom';
	dirT = 'Adresse';
	codPT = 'Code postal';
	ciudadT = 'Ville';
	paisT = 'Pays';
	correoT = 'Mail';
	telefT = 'Téléphone';
}

var $ = $.noConflict();
$(document).ready(function($) {
	"use strict";
	var datosUserLogin = JSON.parse(localStorage.getItem('user_data_fuster'));
	var datosUserAddressLogin = JSON.parse(localStorage.getItem('user_data_address_fuster'));

	$('.datos-perfil').html('\
		<div id="perfilData">\
		<h4 style="margin-bottom: 15px;margin-top: 50px;">Información de Perfil</h4>\
		<p style="color:#141213;padding: 7px;">\
			<span style="font-weight: 600;"> '+nombreT+': </span>\
			<span> '+datosUserLogin.CompanyName+' </span>\
		</p>\
		<p style="color:#141213;padding: 7px;">\
			<span style="font-weight: 600;"> '+dirT+': </span>\
			<span> '+datosUserLogin.Address+' </span>\
		</p>\
		<p style="color:#141213;padding: 7px;">\
			<span style="font-weight: 600;"> '+codPT+': </span>\
			<span> '+datosUserLogin.ZipCode+' </span>\
		</p>\
		<p style="color:#141213;padding: 7px;">\
			<span style="font-weight: 600;"> '+ciudadT+': </span>\
			<span> '+datosUserLogin.City+' </span>\
		</p>\
		<p style="color:#141213;padding: 7px;">\
			<span style="font-weight: 600;"> '+paisT+': </span>\
			<span> '+datosUserLogin.Country+' </span>\
		</p>\
		<p style="color:#141213;padding: 7px;">\
			<span style="font-weight: 600;"> '+correoT+': </span>\
			<span> '+datosUserLogin.Email+' </span>\
		</p>\
		<p style="color:#141213;padding: 7px;">\
			<span style="font-weight: 600;"> '+telefT+': </span>\
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