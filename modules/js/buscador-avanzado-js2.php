<script>
/*global $:true */

var $ = $.noConflict();
$(document).ready(function($) {
	"use strict";

	var path = window.location.pathname;
	// console.log(path)
	// var idMarca = path.match(/\/mid([0-9]+)\//).pop();
	// var idCategoria = path.match(/\/cid([0-9]+)\//).pop();
	var marcaBusqueda = path.match(/\/mid([0-9]+)\//).pop();;


	function getQueryParams(qs) {
		qs = qs.split("+").join(" ");
		var params = {},
			tokens,
			re = /[?&]?([^=]+)=([^&]*)/g;
		while (tokens = re.exec(qs)) {
			params[decodeURIComponent(tokens[1])]
				= decodeURIComponent(tokens[2]);
		}
		return params;
	}

	var $_GET = getQueryParams(document.location.search);

	var idiom = 'es'; 
	var idioma = 'es';

	if($_GET.idioma){
		idiom = $_GET.idioma;
		idioma = $_GET.idioma;
	}else{
		var url = document.location.href;
		if(url.indexOf("/en/") > -1){
			idiom = 'en';
			idioma = 'en';
		}
		if(url.indexOf("/fr/") > -1){
			idiom = 'fr';
			idioma = 'fr';
		}

		var host = window.location.host;
		if(host.indexOf("r.fr") != -1){
			idioma = 'fr';
			idiom = 'fr';
		}
	}


	$(document).on('select2:open', () => {
		document.querySelector('.select2-search__field').focus();
	});

	
	$('.js-data-producto2').select2({
		tags: true,
		placeholder: "<?=${"lang_".$idioma}['producto'];?>",
		allowClear: true,
		ajax: {
			url: "<?=$base;?>000_admin/_rest/api.php?action=buscarNombreProductoByMarca&marca="+marcaBusqueda,
			delay: 500,
			processResults: function (response) {
			var data = JSON.parse(response);
			return {
				results: data.result
			};
			}
		}
	});

	$('.js-data-modelo2').select2({
		placeholder: "<?=${"lang_".$idioma}['modelodeltractor'];?>",
		allowClear: true,
		ajax: {
			url: "<?=$base;?>000_admin/_rest/api.php?action=buscarModeloByNombreyMarca&marca="+marcaBusqueda,
			delay: 500,
			processResults: function (response) {
				var data = JSON.parse(response);
				var result = JSON.parse(data.result);

				return {
					results: result
				};
			}
		}
	});

	$(document).on('change',  '.js-data-producto2', function(){
		var productoBusqueda = $('.js-data-producto2').val();

		if(productoBusqueda){
			productoBusqueda = productoBusqueda.split('+')[0];
		}

		$('.js-data-modelo2').val('');
		$('.js-data-modelo2').prop('disabled', false);
		
		if(!productoBusqueda){
			$('.js-data-modelo2').select2({
				placeholder: "<?=${"lang_".$idioma}['modelodeltractor'];?>",
				allowClear: true,
				ajax: {
					url: "<?=$base;?>000_admin/_rest/api.php?action=buscarModeloByNombreyMarca&marca="+marcaBusqueda,
					delay: 500,
					processResults: function (response) {
						var data = JSON.parse(response);
						var result = JSON.parse(data.result);

						return {
							results: result
						};
					}
				}
			});
		}else{
			$('.js-data-modelo2').select2({
				placeholder: "<?=${"lang_".$idioma}['modelodeltractor'];?>",
				allowClear: true,
				ajax: {
					url: "<?=$base;?>000_admin/_rest/api.php?action=buscarModeloByNombreProdyMarca&producto="+productoBusqueda+"&marca="+marcaBusqueda+"",
					delay: 500,
					processResults: function (response) {
						var data = JSON.parse(response);
						var result = JSON.parse(data.result);

						return {
							results: result
						};
					}
				}
			});
		}
		
    });
	

	$(document).on('click',  '.buscarByProdMarcModSecundary', function(){ 
		$('.listadoSinResultadoBusqueda').hide();
		
		var producto = $('.js-data-producto2').val();

		var marca = marcaBusqueda;
		var modelo = $('.js-data-modelo2').val();

		if((producto =='' && !modelo.length) || (producto == null && !modelo.length ) ){
		}else{

			// if(producto){
			// 	producto = producto.split('+')[0];
			// }

			// $('.accesorios').html('');
			// $('#listadoProductosBusqueda').html('');
			
			// if(idioma == 'en'){
			// 	$('.breadcrumb-container').html('<a class="inicio" href="/" title="Home"></a><span class="separadorr"></span><a href="en/products/" title="Products">Products</a><span class="separadorr"></span>Search');
			// }else if(idioma == 'fr'){
			// 	$('.breadcrumb-container').html('<a class="inicio" href="/" title="Accueil"></a><span class="separadorr"></span><a href="fr/produits/" title="Products">Produits</a><span class="separadorr"></span>Recherche');
			// }else{
			// 	$('.breadcrumb-container').html('<a class="inicio" href="/" title="Inicio"></a><span class="separadorr"></span><a href="es/productos/" title="Productos">Productos</a><span class="separadorr"></span>Busqueda');
			// }
			

			// $('.msgErrMarc2').hide();
			// $('.msgErrProd2').hide();
			// var error = 2;

			var palabra1 = 'productos';
			if(idioma == 'en'){
				palabra1 = 'products';
			}
			if(idioma == 'fr'){
				palabra1 = 'produits';
			}

			var modelo = $('.js-data-modelo2').val();

			if(producto){

				var producto = $('.js-data-producto2').val();

				window.location.href = '<?=$base;?>?module=modules/busqueda/resultadoBusquedaFinal.php&idioma='+idiom+'&busqueda=buscarByProdMarcMod&producto='+producto+'&marca='+marca+'&modelo='+modelo+'';

			}else{

				var cadena = '';
				var nombrMarc = $('.onlyMarcaSeleccionada #page-title').text();

				nombrMarc = cleanName(nombrMarc);
				modelo = modelo.toString().split(',');

				for (let index = 0; index < modelo.length; index++) {
					cadena += modelo[index]+'-';
				}

				if(cadena){
					$(location).attr('href','<?=$base;?>'+idioma+'/'+palabra1+'/mid'+marca+'/'+nombrMarc+'/modelos-'+cadena+'/');return; 
				}else{
					$(location).attr('href','<?=$base;?>'+idioma+'/'+palabra1+'/mid'+marca+'/'+nombrMarc+'/');return; 
				}
				
			}

		}
	});
	
	
	
	
	$(document).on('click',  '.clickHijoCateBusqueda', function(event){ 
		event.preventDefault();

		var marca = $(this).attr("data-marca");
		var modelo = $(this).attr("data-modelo");
		var idCategoria = $(this).attr("data-id");

		window.location.href = '<?=$base;?>?module=modules/busqueda/resultadoBusquedaFinal.php&idioma='+idiom+'&busqueda=buscarByCatMarcMod&categoria='+idCategoria+'&marca='+marca+'&modelo='+modelo+'';

	});
});



</script>