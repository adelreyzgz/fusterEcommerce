


<script>
/*global $:true */
// Open the Modal
function openModalVideo() {
    document.getElementById("myModal").style.display = "block";
}

// Close the Modal
function closeModalVideo() {
    document.getElementById("myModal").style.display = "none";
}


var $ = $.noConflict();
$(document).ready(function($) {
	"use strict";
    
	jQuery("#toggle-productos").click(function(){jQuery(".accordionss").toggle();});

	$(document).on('click',  '#ver-mas-marcas', function(){ $('#mas-marcas').toggle(); });

    /* MANEJO BOTONES IDIOMA */
    $(document).on('click',  'a', function(){
        if($(this).attr('data-lang-es')){
            localStorage.setItem("lang_es", $(this).attr('data-lang-es'));
        }else{
            localStorage.setItem("lang_es", "");
        }
        if($(this).attr('data-lang-en')){
            localStorage.setItem("lang_en", $(this).attr('data-lang-en'));
        }else{
            localStorage.setItem("lang_en", "");
        }
        if($(this).attr('data-lang-fr')){
            localStorage.setItem("lang_fr", $(this).attr('data-lang-fr'));
        }else{
            localStorage.setItem("lang_fr", "");
        }
    });

    if((localStorage.getItem("lang_en") && localStorage.getItem("lang_en")!='') && (localStorage.getItem("lang_es") && localStorage.getItem("lang_es")!='') && (localStorage.getItem("lang_fr") && localStorage.getItem("lang_fr")!='')){
        var urlActual = window.location.pathname;
        if(urlActual.indexOf("/en/"+localStorage.getItem("lang_en")) == -1 && urlActual.indexOf("/es/"+localStorage.getItem("lang_es")) == -1 && urlActual.indexOf("/fr/"+localStorage.getItem("lang_fr")) == -1){
            $('#btnLangEn').attr("href", "http://www.fusterrepuestos.local/en/");
            $('#btnLangEs').attr("href", "http://www.fusterrepuestos.local/es/");
            $('#btnLangFr').attr("href", "https://www.repuestosfuster.fr/fr/");
        }else{
            $('#btnLangEn').attr("href", "http://www.fusterrepuestos.local/en/"+localStorage.getItem("lang_en"));
            $('#btnLangEn').attr("data-lang-en", localStorage.getItem("lang_en"));
            $('#btnLangEn').attr("data-lang-es", localStorage.getItem("lang_es"));
            $('#btnLangEn').attr("data-lang-fr", localStorage.getItem("lang_fr"));

            $('#btnLangEs').attr("href", "http://www.fusterrepuestos.local/es/"+localStorage.getItem("lang_es"));
            $('#btnLangEs').attr("data-lang-es", localStorage.getItem("lang_es"));
            $('#btnLangEs').attr("data-lang-en", localStorage.getItem("lang_en"));
            $('#btnLangEs').attr("data-lang-fr", localStorage.getItem("lang_fr"));

            $('#btnLangFr').attr("href", "https://www.repuestosfuster.fr/fr/"+localStorage.getItem("lang_fr"));
            $('#btnLangFr').attr("data-lang-es", localStorage.getItem("lang_es"));
            $('#btnLangFr').attr("data-lang-en", localStorage.getItem("lang_en"));
            $('#btnLangFr').attr("data-lang-fr", localStorage.getItem("lang_fr"));

        }
    }else{
        $('#btnLangFr').attr("href", "https://www.repuestosfuster.fr/fr/");
        $('#btnLangEn').attr("href", "http://www.fusterrepuestos.local/en/");
        $('#btnLangEs').attr("href", "http://www.fusterrepuestos.local/es/");
    }
    /* FIN MANEJO BOTONES IDIOMA */

    var contador = 1;
	$(".menu_bar").click(function(){
        if (contador == 1) {
            $('nav').animate({
            top: '119px'
            });
            contador = 0
        } else {
            contador = 1;
            $('nav').animate({
            top: '-100%'
            })
        }
    });

    $("#animated-thumbnails-gallery")
    .justifiedGallery({
        captions: false,
        lastRow: "hide",
        rowHeight: 180,
        margins: 5
    })
    .on("jg.complete", function () {
        window.lightGallery(
        document.getElementById("animated-thumbnails-gallery"),
        {
            autoplayFirstVideo: false,
            pager: false,
            galleryId: "nature",
            plugins: [lgZoom, lgThumbnail],
            mobileSettings: {
            controls: false,
            showCloseIcon: false,
            download: false,
            rotate: false
            }
        }
        );
    });


    $.ajax({
		method: "GET",
		url: "<?=$base;?>000_admin/_rest/api.php?action=listarMarcasLateral"
	}).done(function(response) {
		if(response){
			var data = JSON.parse(response);
			var result = data.result;
			var dataShow = '';
			var dataShow2 = '';
			var i = 0;
			if(data.code == 1 && result.length > 0){
				result.forEach(function(row, index) {
					if(row['orden'] != -1){
						var id = row['id'];
						var marca = row['marca'];
						var marcaURL = cleanName(row['marca']);

						if(idioma == 'es'){
							dataShow += '<li class="item-fabricante"><a href="es/productos/mid'+id+'/'+marcaURL+'/"> '+marca+' </a></li>';
						}else if(idioma == 'fr'){
							dataShow += '<li class="item-fabricante"><a href="fr/produits/mid'+id+'/'+marcaURL+'/"> '+marca+' </a></li>';
						}else{
							dataShow += '<li class="item-fabricante"><a href="en/products/mid'+id+'/'+marcaURL+'/"> '+marca+' </a></li>';
						}
						i++;
					}

					if(row['orden'] == -1){
						var id = row['id'];
						var marca = row['marca'];
						var marcaURL = cleanName(row['marca']);
                        if(id != '9136' && id != '220'){
                            if(idioma == 'es'){
                                dataShow2 += '<li class="item-fabricante"><a href="es/productos/mid'+id+'/'+marcaURL+'/"> '+marca+' </a></li>';
                            }else if(idioma == 'fr'){
                                dataShow2 += '<li class="item-fabricante"><a href="fr/produits/mid'+id+'/'+marcaURL+'/"> '+marca+' </a></li>';
                            }else{
                                dataShow2 += '<li class="item-fabricante"><a href="en/products/mid'+id+'/'+marcaURL+'/"> '+marca+' </a></li>';
                            }
                        }
					}
				});
			}
		}

		$('#lista-fabricantes').html(dataShow);
		$('#lista-fabricantes2').html(dataShow2);

	});


    $(document).on('click', '.addCarrito',  function(e){
        e.preventDefault();
        var element = $(this);
        var botonAddCart = $(this).html();
        $(this).html('<div class="spinner-border"  style="border: .25em solid #e6e2dc;border-right-color: transparent;width: 14px;height: 14px;" role="status"></div>');

        var valor = $(this).parent().children('.inputPrecio').val();
        var ref = $(this).attr('data-refFuster');
        var idarticle = $(this).attr('data-idarticle');
        var price = $(this).attr('data-price');
        var stock = $(this).attr('data-stock');
        var img = $(this).attr('data-img');
        var idProd = $(this).attr('data-idProd');
        var description = $(this).attr('data-description');

        var cart = [];

        var producto = {
            "ref": ref,
            "idarticle": idarticle,
            "description": description,
            "price": price,
            "stock": stock,
            "valor": valor,
            "img": img,
            "idProd": idProd
        };

        var cant = -1;

        if(localStorage.getItem("user_cart_fuster")){
            var cart = JSON.parse(localStorage.getItem("user_cart_fuster"));

            for (let index = 0; index < cart.length; index++) {
                if(cart[index].ref == ref){
                        cart[index].valor = parseInt(cart[index].valor) + parseInt(valor);
                        cant++;
                }
            }
        }

        if(cant == -1){
            cart.push(producto);
        }

        localStorage.setItem('user_cart_fuster', JSON.stringify(cart));
        
        var userCartLS = JSON.parse(window.localStorage.getItem("user_cart_fuster"));
        var cantidad = 0;
        for (let index = 0; index < userCartLS.length; index++) {
            cantidad += parseInt(userCartLS[index].valor);
        }
        $('.cantProdCart').html(cantidad);

        setTimeout(function(){
            element.html('<img src="assets/checkCart.png" style="width: 16px;height: 16px;">');
            element.parent().children('.inputPrecio').val(0);
            setTimeout(function(){
                element.html(botonAddCart)
            }, 1000);
        }, 500);

    });
    
});

var urlA = window.location.pathname;
var host = window.location.host;

var idioma = 'es';
if(urlA.indexOf("/en/") != -1){
    idioma = 'en';
}else if(urlA.indexOf("/fr/") != -1){
    idioma = 'fr';
}else if(host.indexOf("r.fr") != -1){
    idioma = 'fr';
}


function onStorageEvent(storageEvent){
    console.log("add cart");
}

window.addEventListener('storage', onStorageEvent, false);


function cleanName(cadena){
	// Convertimos el texto a analizar a minúsculas
	cadena = cadena.toLowerCase();

	//Reemplazamos la A y a
	var find = ['Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª']
	var replace = ['A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a']
	find.forEach((value, index) => {
		cadena = cadena.replace(new RegExp(value, 'g'), replace[index])
	})
    //Reemplazamos la E y e
	var find = ['É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê']
	var replace = ['E', 'E', 'E', 'E', 'e', 'e', 'e', 'e']
	find.forEach((value, index) => {
		cadena = cadena.replace(new RegExp(value, 'g'), replace[index])
	})
    //Reemplazamos la I y i
	var find = ['Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î']
	var replace = ['I', 'I', 'I', 'I', 'i', 'i', 'i', 'i']
	find.forEach((value, index) => {
		cadena = cadena.replace(new RegExp(value, 'g'), replace[index])
	})
    //Reemplazamos la O y o
	var find = ['Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô']
	var replace = ['O', 'O', 'O', 'O', 'o', 'o', 'o', 'o']
	find.forEach((value, index) => {
		cadena = cadena.replace(new RegExp(value, 'g'), replace[index])
	})
    //Reemplazamos la U y u
	var find = ['Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û']
	var replace = ['U', 'U', 'U', 'U', 'u', 'u', 'u', 'u']
	find.forEach((value, index) => {
		cadena = cadena.replace(new RegExp(value, 'g'), replace[index])
	})
    //Reemplazamos la N, n, C y c
	var find = ['Ñ', 'ñ', 'Ç', 'ç']
	var replace = ['N', 'n', 'C', 'c']
	find.forEach((value, index) => {
		cadena = cadena.replace(new RegExp(value, 'g'), replace[index])
	})
    //Reemplazamos caracteres especiales
	var find = [' ']
	find.forEach((value, index) => {
		cadena = cadena.replace(new RegExp(value, 'g'), '-')
	})

    // '(', ')'
    cadena = cadena.replace(/\(/g, "");
    cadena = cadena.replace(/\)/g, "");
    cadena = cadena.replace(/\+/g, "");
    cadena = cadena.replace(/\,/g, "");
    cadena = cadena.replace(/\//g, "");
    cadena = cadena.replace(/['"]+/g, '');
    cadena = cadena.replace(/['”]+/g, '');
    cadena = cadena.replace(/\./g, "");
    cadena = cadena.trim();
    return cadena;
}

</script>