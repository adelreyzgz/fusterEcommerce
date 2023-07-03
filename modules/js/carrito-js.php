<script>
/*global $:true */

var $ = $.noConflict();
$(document).ready(function($) {
	"use strict";
    console.log(localStorage.getItem("user_cart_fuster"))
    if(localStorage.getItem("user_cart_fuster")){
            var cart = JSON.parse(localStorage.getItem("user_cart_fuster"));
            console.log(cart);
            var html = '';
            for (let index = 0; index < cart.length; index++) {
                const element = cart[index];
                var total = parseFloat(element.valor) * parseFloat(element.price);
                
                html += '\
                <tr id="tr-'+element.idProd+'" class="listProdCart">\
                    <td><img src="'+element.img+'" style="width: 35px;height: 35px;"></td>\
                    <td>'+element.ref+'</td>\
                    <td>'+element.ref+'</td>\
                    <td>'+element.price+'</td>\
                    <td>'+element.valor+'</td>\
                    <td>'+total+'</td>\
                    <td><a href="#" class="eliminarCarrito" data-idProd='+element.idProd+'>Eliminar</a></td>\
                </tr>\
                ';
            }

            console.log(html)
            $('#cartTable').append(html);
    }
});

$(document).on('click','.eliminarCarrito',function(e){
    event.preventDefault();
    var id=$(this).attr('data-idProd');
    var element="#liHijos"+id;
    var newCart=[];
    console.log("el id",id)
    var cart = JSON.parse(localStorage.getItem("user_cart_fuster"));
    for (let index = 0; index < cart.length; index++) {
        const element = cart[index];
        console.log("elemento", element);
        if(element["idProd"]!=id){
            newCart.push(element);
        }
    }
    localStorage.setItem("user_cart_fuster",JSON.stringify(newCart));
    $("#tr-"+id).remove();

        
});
$(document).on('click','#limpiarCarrito',function(e){
    event.preventDefault();
    var id=$(this).attr('data-idProd');
    var newCart=[];
    localStorage.setItem("user_cart_fuster",JSON.stringify(newCart));
    $(".listProdCart").remove();
});

</script>