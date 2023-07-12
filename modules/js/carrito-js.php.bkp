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
                
                var cmp = '<input min="0" max="50" type="number" value="'+element.valor+'" data-id='+element.idProd+' name="precio" class="inputPrecio" style="width: 70px;">';

                html += '\
                <tr id="tr-'+element.idProd+'" class="listProdCart">\
                    <td><img src="'+element.img+'" style="width: 35px;height: 35px;"></td>\
                    <td>'+element.description+'</td>\
                    <td>'+element.ref+'</td>\
                    <td>'+element.price+'</td>\
                    <td>'+cmp+'</td>\
                    <td>'+total+'</td>\
                    <td><a href="#" class="eliminarCarrito" data-idProd='+element.idProd+'> \
                    <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="48"><path d="M261-120q-24.75 0-42.375-17.625T201-180v-570h-41v-60h188v-30h264v30h188v60h-41v570q0 24-18 42t-42 18H261Zm438-630H261v570h438v-570ZM367-266h60v-399h-60v399Zm166 0h60v-399h-60v399ZM261-750v570-570Z"/></svg>\
                    Eliminar</a></td>\
                </tr>\
                ';
            }

            console.log(html)
            $('#cartTable').append(html);

            var direcciones = JSON.parse(localStorage.getItem("user_data_address_fuster"));
            direcciones = direcciones.data;

            var Address = '';
            var Country = '';
            var ZipCode = '';

            for (let index = 0; index < direcciones.length; index++) {
                const element = direcciones[index];
                if(element.DefaultAddress && element.DefaultAddress == "1"){
                    Address = element.Address;
                    Country = element.Country;
                    ZipCode = element.ZipCode;
                }
                
            }

            var usr = JSON.parse(localStorage.getItem("user_data_fuster"));
            usr = usr.CompanyName;

            $('.dirEnvio').html(Address);
            $('.dirEnvio').append(', '+Country);
            $('.dirEnvio').append(', CP: '+ZipCode);

            $('.distribuid').html(usr);

            // DefaultAddress

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