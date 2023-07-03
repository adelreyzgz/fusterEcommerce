<script>
/*global $:true */

var $ = $.noConflict();
$(document).ready(function($) {
	"use strict";

    if(localStorage.getItem("user_cart_fuster")){
            var cart = JSON.parse(localStorage.getItem("user_cart_fuster"));
            console.log(cart);
            var html = '';
            for (let index = 0; index < cart.length; index++) {
                const element = cart[index];
                var total = parseFloat(element.valor) * parseFloat(element.price);
                
                html += '\
                <tr>\
                    <td><img src="'+element.img+'" style="width: 35px;height: 35px;"></td>\
                    <td>'+element.ref+'</td>\
                    <td>'+element.ref+'</td>\
                    <td>'+element.price+'</td>\
                    <td>'+element.valor+'</td>\
                    <td>'+total+'</td>\
                    <td><a href="#" data-idProd='+element.idProd+'>Eliminar</a></td>\
                </tr>\
                ';
            }

            console.log(html)
            $('#cartTable').append(html);
    }
});

</script>