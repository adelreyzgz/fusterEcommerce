<script>
/*global $:true */
function formatoMoneda(number) {
    const formateado = number.toLocaleString("es", {
        style: "currency",
        currency: "EUR"
    });
   var str = formateado.substring(0, formateado.length - 1);
  return str;
}

function formatoMonedaSimbolo(number) {
    const formateado = number.toLocaleString("es", {
        style: "currency",
        currency: "EUR"
    });
  return formateado;
}

function formatDateFull() {
    var d = new Date(date);
    month = '' + (d.getMonth() + 1);
    day = '' + d.getDate();
    year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}



var $ = $.noConflict();
$(document).ready(function($) {
	"use strict";
    
    if(localStorage.getItem("user_cart_fuster")){
            var cart = JSON.parse(localStorage.getItem("user_cart_fuster"));
            console.log(cart);
            var html = '';
            var costoTotalOrdenInicial =0;
            for (let index = 0; index < cart.length; index++) {
                const element = cart[index];
                console.log("listar",element)
                var priceM=parseFloat(element.price);
                var total = parseFloat(element.valor) * parseFloat(element.price);
                
                var cmp = '<input min="0" max="50" type="number" value="'+element.valor+'" data-id='+element.idProd+' name="precio" class="inputPrecio" style="width: 70px;">';

                html += '\
                <tr id="tr-'+element.idProd+'" class="listProdCart">\
                    <td><img src="'+element.img+'" style="width: 35px;height: 35px;"></td>\
                    <td>'+element.description+'</td>\
                    <td>'+element.ref+'</td>\
                    <td>'+formatoMoneda(priceM)+'</td>\
                    <td id="cantidad-'+element.idProd+'">'+cmp+'</td>\
                    <td id="totalMoney-'+element.idProd+'">'+formatoMoneda(total)+'</td>\
                    <td><a href="#" class="eliminarCarrito" data-idProd='+element.idProd+'> \
                        <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="48"><path d="M261-120q-24.75 0-42.375-17.625T201-180v-570h-41v-60h188v-30h264v30h188v60h-41v570q0 24-18 42t-42 18H261Zm438-630H261v570h438v-570ZM367-266h60v-399h-60v399Zm166 0h60v-399h-60v399ZM261-750v570-570Z"/></svg>\
                    Eliminar</a></td>\
                </tr>\
                ';
                costoTotalOrdenInicial += parseFloat(element.valor) * parseFloat(element.price);

            }
            $('#costoTotal').html(formatoMonedaSimbolo(costoTotalOrdenInicial));

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

    $(document).on('click', '#AddProdCodigoF',  function(e){
        e.preventDefault();
        var codigo=$("#codigoB").val();
        var errores=0;
        var cantidadInput=$("#cantidadB").val();
        var cart=[];
        if(codigo=="" && cantidadInput==""){
            alert("Rellene los campos");
            errores++;
        }else{
            if(codigo==""){
                alert("el codigo no puede ser vacio");
                errores++
            } 
            
            if(cantidadInput=="" ){
                alert("la cantidad no puede ser vacios");
                errores++
            }else if(cantidadInput==0 ){
                alert("Introduzca una cantidad superior a 0");
                errores++
            }
            if(errores==0){
                $.ajax({
                    method: "POST",
                    data: { refOem: codigo },
                    url: "<?=$base;?>000_admin/_rest/api.php?action=cartBuscarProdByRefOem"
                }).done(function(response) {
                        if(response){
                            var data = JSON.parse(response);
                            var result = data.result;
                            if(result.length > 0){
                                var ref=result[0]["noRefFuster"];
                                var img=result[0]["foto"];
                                var idProd=result[0]["id"];
                                var nombre=result[0]["nombre"];
                                
                                var access_token = localStorage.getItem("access_token_fuster");
                                if(access_token){
                                    // INICIO INTERCEPTOR
                                    console.log('INICIO INTERCEPTOR')
                                    var arrayRefFusterI = '';
                                    if(result[0]["noRefFuster"]){
                                        arrayRefFusterI = '["'+result[0]["noRefFuster"]+'"]';
                                    }
                                    if(arrayRefFusterI!=""){
                                        $.ajax({
                                            method: "GET",
                                            headers: {
                                                "Authorization": "Bearer " + access_token
                                            },
                                            url: 'https://apiecommercefuster.ideaconsulting.es/api/articles?codArticles='+arrayRefFusterI
                                        }).done(function(response) {
                                            // INICIO REQUEST INTERCEPTOR
                                                var responseERP = response.data;
                                                if(responseERP.length){
                                                    const respElement = responseERP[0];
                                                    var idarticle = respElement.IDArticle;
                                                    var codarticle = respElement.CodArticle;
                                                    var description = respElement.Description;
                                                    var price = Math.round(respElement.Price);
                                                    var stock = Math.round(respElement.stock);
                                                    var valor=cantidadInput;
                                                    var producto = {
                                                        "ref": ref,
                                                        "idarticle": idarticle,
                                                        "codarticle": codarticle,
                                                        "description": description,
                                                        "price": price,
                                                        "stock": stock,
                                                        "valor": valor,
                                                        "img": img,
                                                        "idProd": idProd
                                                    };
                                                    var cant = -1;
                                                    var cmp = '<input min="0" max="50" type="number" value="'+valor+'" data-id='+idProd+' name="precio" class="inputPrecio" style="width: 70px;">';

                                                    if(localStorage.getItem("user_cart_fuster")){
                                                        var cart = JSON.parse(localStorage.getItem("user_cart_fuster"));
                                                        for (let index = 0; index < cart.length; index++) {
                                                            if(cart[index].ref == ref){
                                                                var newCant=parseInt(cart[index].valor) + parseInt(valor);
                                                                var newTotal=newCant*cart[index].price;
                                                                
                                                                    $('#totalMoney-'+idProd).html(formatoMoneda(newTotal));
                                                                    cart[index].valor = parseInt(cart[index].valor) + parseInt(valor);
                                                                    cant++;
                                                                    var sum=cart[index].valor;
                                                                    cmp = '<input min="0" max="50" type="number" value="'+sum+'" data-id='+idProd+' name="precio" class="inputPrecio" style="width: 70px;">';
                                                                    $('#cantidad-'+idProd).html(cmp);

                                                                    

                                                            }
                                                        }
                                                    }
                                                    if(cant == -1){
                                                        cart.push(producto);
                                                        var totalMoney=price*valor;
                                                        var htmlTr = '\
                                                            <tr id="tr-'+idProd+'" class="listProdCart">\
                                                                <td><img src="'+img+'" style="width: 35px;height: 35px;"></td>\
                                                                <td>'+description+'</td>\
                                                                <td>'+ref+'</td>\
                                                                <td>'+formatoMoneda(price)+'</td>\
                                                                <td id="cantidad-'+idProd+'">'+cmp+'</td>\
                                                                <td id="totalMoney-'+idProd+'">'+totalMoney+'</td>\
                                                                <td><a href="#" class="eliminarCarrito" data-idProd='+idProd+'><svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="48"><path d="M261-120q-24.75 0-42.375-17.625T201-180v-570h-41v-60h188v-30h264v30h188v60h-41v570q0 24-18 42t-42 18H261Zm438-630H261v570h438v-570ZM367-266h60v-399h-60v399Zm166 0h60v-399h-60v399ZM261-750v570-570Z"/></svg>Eliminar</a>\
                                                                </td>\
                                                            </tr>\
                                                            ';
                                                        $('#cartTable').append(htmlTr);
                                                    }
                                                   localStorage.setItem('user_cart_fuster', JSON.stringify(cart));
                                                 var userCartLS = JSON.parse(window.localStorage.getItem("user_cart_fuster"));
                                                    var cantidad = 0;
                                                    var costoTotalOrden=0;
                                                    for (let index = 0; index < userCartLS.length; index++) {
                                                        cantidad += parseInt(userCartLS[index].valor);
                                                        costoTotalOrden += parseFloat(userCartLS[index].valor) * parseFloat(userCartLS[index].price);
                                                    }

                                                    $('.cantProdCart').html(cantidad);
                                                    $('#costoTotal').html(formatoMonedaSimbolo(costoTotalOrden));
                                                    $("#codigoB").val("");
                                                    $("#cantidadB").val(0);

                                                }
                                        }).fail(function(response) {
                                            console.log(response);
                                        });
                                    }
                                }
                            }else{
                                alert("no existe esa referencia")
                            }
                        }
                });
            }
        }
 
    });

    $(document).on('click', '#actualizarCarrito',  function(e){
        e.preventDefault();
        var carrito= JSON.parse(localStorage.getItem("user_cart_fuster"));
        $(".inputPrecio").each(function(){
            var idProd= $(this).attr('data-id');
            var cantidad=$(this).val();
            for (let index = 0; index < carrito.length; index++) {
                if(carrito[index].idProd == idProd){
                    carrito[index].valor = cantidad;
                }
            }
        	
        });
        localStorage.setItem("user_cart_fuster",JSON.stringify(carrito));
        location.reload();
 
    });

    $( "#file" ).on( "update", function() {
        let file = evt.target.files[0];
        let reader = new FileReader();
        reader.onload = (e) => {
            // Cuando el archivo se terminó de cargar
            let lines = parseCSV(e.target.result);
            //let output = reverseMatrix(lines);
            
        };
        // Leemos el contenido del archivo seleccionado
        reader.readAsBinaryString(file);
    } );


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

$(document).on('click','#finalizarPedido',function(e){
    event.preventDefault();
    
    var access_token = localStorage.getItem("access_token_fuster");
    $.ajax({
        method: "GET",
        headers: {
            "Authorization": "Bearer " + access_token
        },
        url: 'https://apiecommercefuster.ideaconsulting.es/api/delivery-addresses'
    }).done(function(response) {
            if(response){
                console.log(response.data)

                var IDDeliveryAddress=response.data[0].IDCustomerDeliveryAddress;
                var arr = response.data;

                for (let index = 0; index < arr.length; index++) {
                    const element = arr[index];

                    if(element.DefaultAddress && element.DefaultAddress == "1"){
                        IDDeliveryAddress = response.data[0].IDCustomerDeliveryAddress;
                    }
                }
                
                var productos="";
                var productos1=[];
                var cart = JSON.parse(localStorage.getItem("user_cart_fuster"));
                
                console.log(cart)

                for (let index = 0; index < cart.length; index++) {
                    const element = cart[index];
                    var aux=  {
                        "CodArticle":element.ref,
                        "Comment":"",
                        "Quantity":element.valor
                    };
                    productos1.push(aux)
                    
                }
                
                var fecha = new Date();
                var mesActual = fecha.getMonth() + 1; 
                if(mesActual.length <2){
                    mesActual="0"+mesActual
                }
                var diaH=fecha.getDate();
                if(diaH.length <2){
                    diaH="0"+diaH
                }
                var anno = fecha.getFullYear();
                var hoy =anno+"-07"+"-"+diaH+"T00:00:00";
                var access_token = localStorage.getItem("access_token_fuster");
               
                var settings = {
                "url": "https://apiecommercefuster.ideaconsulting.es/api/preoffers",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "Authorization": "Bearer " + access_token
                },

                "data": JSON.stringify({
                    "ReceptionDate": hoy,
                    "SalesQuoteDate": hoy,
                    "IDDeliveryAddress": IDDeliveryAddress,
                    "Comment": "",
                    "PreSalesQuoteLines": productos1
                }),
                };

                $.ajax(settings).done(function (response) {
                    if(response.data.IDPreSalesQuoteWIO){
                        var settings = {
                            "url": "https://apiecommercefuster.ideaconsulting.es/api/offers",
                            "method": "POST",
                            "timeout": 0,
                            "headers": {
                                "Accept": "application/json",
                                "Content-Type": "application/json",
                                "Authorization": "Bearer " + access_token
                            },

                            "data": JSON.stringify({
                                "IDPreSalesQuoteWIO": response.data.IDPreSalesQuoteWIO
                            }),
                        };

                        $.ajax(settings).done(function (response) { 
                            console.log(response)
                        });
                    }
                });
        }
    })

});

$(document).on('click','#limpiarCarrito',function(e){
    event.preventDefault();
    var id=$(this).attr('data-idProd');
    var newCart=[];
    localStorage.setItem("user_cart_fuster",JSON.stringify(newCart));
    $(".listProdCart").remove();
});
var arrayReferencias=[];
var arrayContReferencias=[];

function parseCSV(text) {
    var retorno=[];
    arrayReferencias=[];
    arrayContReferencias=[];
  // Obtenemos las lineas del texto
  let lines = text.replace(/\r/g, '').split('\n');
  lines.map(line => {
    // Por cada linea obtenemos los valores
    let values = line.split(',');
    if(values[0]!="" && values[1]!=""){
        var key="ref-"+ values[0];
        if(arrayReferencias.includes(values[0])){
            var num1Aux=arrayContReferencias[key];
            var sum=parseFloat(num1Aux)+parseFloat(values[1]); 
            arrayContReferencias[key]=sum;
        }else{
            arrayReferencias.push(values[0])
            arrayContReferencias[key]=values[1];
        }
        

    }
  });
  retorno[0]=arrayReferencias;
  retorno[1]=arrayContReferencias; 
  return retorno;
}

function llenarbyCsv() {
        var cantidades=arrayContReferencias;
        var arrayRef=arrayReferencias;
        var listRef="";
        var arrayFotos=[];
        var errores=0;
        var cart=[];
        if(arrayRef.length = 0 || cantidades.length){
            alert("EL archivo debe tener las referencias fuster y la cantidad de unidades por cada producto");
            errores++;
        }else{
            var cart = JSON.parse(localStorage.getItem("user_cart_fuster"));
            for(var i=0;i<arrayRef.length;i++){
                alert("test "+arrayRef[i])
                var ref=arrayRef[i];
                var esta=1;
                for (let index = 0; index < cart.length; index++) {
                    if(cart[index].ref == ref){
                        alert("la ref es:"+ref)
                        var indiceCont="ref-"+ ref;
                        var newCant=parseInt(cart[index].valor) + parseInt(cantidades[indiceCont]);
                        cart[index].valor = newCant;
                        esta=2;
                    }
                }
                
                if(esta==1){
                    if(listRef==""){
                        listRef=arrayRef[i];
                    }else{
                        listRef+=","+arrayRef[i];
                    }
                }
                
            }
            alert(listRef)
            if(listRef!=""){
                $.ajax({
                    method: "POST",
                    data: { refOem: listRef },
                    url: "<?=$base;?>000_admin/_rest/api.php?action=cartBuscarProdByRefOemList"
                }).done(function(response) {
                        if(response){
                            var data = JSON.parse(response);
                            var result = data.result;
                            if(result.length > 0){
                                for(var a=0;a<result.length;a++){
                                    var refPet1=result[0]["noRefFuster"];
                                    var img=result[0]["foto"];
                                    var auxRefI="ref-"+refPet1;
                                    arrayFotos[auxRefI]=img;
                                }
                                var access_token = localStorage.getItem("access_token_fuster");
                                if(access_token){
                                    // INICIO INTERCEPTOR
                                    console.log('INICIO INTERCEPTOR')
                                    var arrayRefFusterI = '';
                                    if(result.length){
                                        arrayRefFusterI = '["'+listRef+'"]';
                                    }
                                    if(arrayRefFusterI!=""){
                                        $.ajax({
                                            method: "GET",
                                            headers: {
                                                "Authorization": "Bearer " + access_token
                                            },
                                            url: 'https://apiecommercefuster.ideaconsulting.es/api/articles?codArticles='+arrayRefFusterI
                                        }).done(function(response) {
                                            // INICIO REQUEST INTERCEPTOR
                                                var responseERP = response.data;
                                               /*if(responseERP.length){
                                                    const respElement = responseERP[0];
                                                    var idarticle = respElement.IDArticle;
                                                    var description = respElement.Description;
                                                    var price = Math.round(respElement.Price);
                                                    var stock = Math.round(respElement.stock);
                                                    var valor=cantidadInput;
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
                                                    var cmp = '<input min="0" max="50" type="number" value="'+valor+'" data-id='+idProd+' name="precio" class="inputPrecio" style="width: 70px;">';

                                                    if(localStorage.getItem("user_cart_fuster")){
                                                        var cart = JSON.parse(localStorage.getItem("user_cart_fuster"));
                                                        for (let index = 0; index < cart.length; index++) {
                                                            if(cart[index].ref == ref){
                                                                var newCant=parseInt(cart[index].valor) + parseInt(valor);
                                                                var newTotal=newCant*cart[index].price;
                                                                
                                                                    $('#totalMoney-'+idProd).html(formatoMoneda(newTotal));
                                                                    cart[index].valor = parseInt(cart[index].valor) + parseInt(valor);
                                                                    cant++;
                                                                    var sum=cart[index].valor;
                                                                    cmp = '<input min="0" max="50" type="number" value="'+sum+'" data-id='+idProd+' name="precio" class="inputPrecio" style="width: 70px;">';
                                                                    $('#cantidad-'+idProd).html(cmp);

                                                                    

                                                            }
                                                        }
                                                    }
                                                    if(cant == -1){
                                                        cart.push(producto);
                                                        var totalMoney=price*valor;
                                                        var htmlTr = '\
                                                            <tr id="tr-'+idProd+'" class="listProdCart">\
                                                                <td><img src="'+img+'" style="width: 35px;height: 35px;"></td>\
                                                                <td>'+description+'</td>\
                                                                <td>'+ref+'</td>\
                                                                <td>'+formatoMoneda(price)+'</td>\
                                                                <td id="cantidad-'+idProd+'">'+cmp+'</td>\
                                                                <td id="totalMoney-'+idProd+'">'+totalMoney+'</td>\
                                                                <td><a href="#" class="eliminarCarrito" data-idProd='+idProd+'><svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="48"><path d="M261-120q-24.75 0-42.375-17.625T201-180v-570h-41v-60h188v-30h264v30h188v60h-41v570q0 24-18 42t-42 18H261Zm438-630H261v570h438v-570ZM367-266h60v-399h-60v399Zm166 0h60v-399h-60v399ZM261-750v570-570Z"/></svg>Eliminar</a>\
                                                                </td>\
                                                            </tr>\
                                                            ';
                                                        $('#cartTable').append(htmlTr);
                                                    }
                                                   localStorage.setItem('user_cart_fuster', JSON.stringify(cart));
                                                 var userCartLS = JSON.parse(window.localStorage.getItem("user_cart_fuster"));
                                                    var cantidad = 0;
                                                    var costoTotalOrden=0;
                                                    for (let index = 0; index < userCartLS.length; index++) {
                                                        cantidad += parseInt(userCartLS[index].valor);
                                                        costoTotalOrden += parseFloat(userCartLS[index].valor) * parseFloat(userCartLS[index].price);
                                                    }

                                                    $('.cantProdCart').html(cantidad);
                                                    $('#costoTotal').html(formatoMonedaSimbolo(costoTotalOrden));
                                                    $("#codigoB").val("");
                                                    $("#cantidadB").val(0);

                                                }*/
                                        }).fail(function(response) {
                                            console.log(response);
                                        });
                                    }
                                }
                            }else{
                                alert("no existe esa referencia")
                            }
                        }
                });
            }
        }
 
};

/*function reverseMatrix(matrix){
  let output = [];
  // Por cada fila
  matrix.forEach((values, row) => {
    // Vemos los valores y su posicion
    values.forEach((value, col) => {
      // Si la posición aún no fue creada
      if (output[col] === undefined) output[col] = [];
      output[col][row] = value;
    });
  });
  return output;
}*/


function readFile(evt) {
  let file = evt.target.files[0];
  let reader = new FileReader();
  reader.onload = (e) => {
    // Cuando el archivo se terminó de cargar
    let lines = parseCSV(e.target.result);
    llenarbyCsv(lines);
   
  };
  // Leemos el contenido del archivo seleccionado
  reader.readAsBinaryString(file);
}

document.getElementById('file').addEventListener('change', readFile, false);

</script>