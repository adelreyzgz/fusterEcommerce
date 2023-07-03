<script>
/*global $:true */

var $ = $.noConflict();
$(document).ready(function($) {
	"use strict";

    
    $( "#edit-email" ).keypress(function() {
        $('#errorGeneral').html('');
        $('#errorEmail').html('');
    });
    $( "#edit-password" ).keypress(function() {
        $('#errorGeneral').html('');
        $('#errorEmail').html('');
    });


    $('.btnLogin').click(function (e) {
        e.preventDefault();
        var usuario = $('#edit-usuario').val();
        var password = $('#edit-password').val();
        var msg = '';

        var boton = $('.btnLogin').html();
        $('.btnLogin').html('<div class="loading" style="padding: 0px;">\
                            <div class="spinner-border"  style="border: .25em solid #e6e2dc;border-right-color: transparent;width: 14px;height: 14px;" role="status"></div>\
                            </div>');

        // url             https://apiecommercefuster.ideaconsulting.es
        // client_id       984B0011-C9CD-4ED2-8DD9-B5773350BC2F
        // client_secret   xQESeMSGW1mTdPo1oAOEki1E892AdZ0LfBFzleXY
        // token           eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5ODRCMDAxMS1DOUNELTRFRDItOEREOS1CNTc3MzM1MEJDMkYiLCJqdGkiOiI0NDM3N2UwYmNlYzg2ZGZiYTU3YTFiNTJkMzcwMmFhMmYxNWYwNjdkZGMwYzc1MjliOWM1ODQzYWM4MjJmMzUwNjg3N2U1ZGQzYzJhMTgwNyIsImlhdCI6MTY4NzQ2OTQwNS43NTA0ODYsIm5iZiI6MTY4NzQ2OTQwNS43NTA0OSwiZXhwIjoxNzE5MDkxODA1LjcwODYyOCwic3ViIjoiMDAxLTI3MzMwIiwic2NvcGVzIjpbXX0.eDJN3R2_RSg5WmXpM2EoE8l_A-SWrHXY-l9TNNLQ73XL-fW32a3PP5hsVEnkwJDqVHqrLwGKbGndnI3mzYvwpPfTrifG9rQUEnVO5dA4Tecsi9_K5cDNXHMF5paOEsSUV8e18cCdBQfmnFjMZBp22CiAFy8snyv3ejpy0TRl0HuIcGv62E-JVZJ_QyjWndBbVOSMIucok5UXVCHduDdjcx2NIenWQHVp78HEpK5xE5dUYhvZRA_Q7q3rTxBWeBfDY3MXmLbFroIO_6bUvMwtTa8jQXvUbdK06AyASvDaybOhbT1p_SipKXfOpm2hdhwJlNF8ekZ17sJhmdQCPcsNYgLc8nbJPvfX-Ql95ntCbTDVMTtVv5dCCzHt-7RiqCBaleGGXe2bQg791RWUlCsvHnhQGDRAEeH1BI6t3wthE2unPGY03GclZu9W2zi5350YNGYQmuVDvRVNZwQC557uqEwwr90-AQEV3ozBHsHmRdTB2dHy2HvMZqhyNY10RAOIYh6NEPsb9dlDyzGA36FQcIlw8DcP2cMjoPrSIlyTIRbazHkF_HJbm2c-k1psRkwn-JoCdh6eKgbQlP7qRxgFSndlzgoiHjdvwKKvBnGGKDnN6ixbjYAQQAPZp83WcmO-_MJ5QeLYsLyYJq2EncbrJ_M_8ekFbTy9tmgns82GCdo
        // "username": "B27019736",
        // "password": "prueba",
        

        localStorage.setItem("access_token_fuster", '');
        localStorage.setItem("user_data_fuster", '');
        localStorage.setItem("user_cart_fuster", '');
        localStorage.setItem("user_data_address_fuster", '');

        $.ajax({
            method: "POST",
            data: {
                "username": usuario,
                "password": password,
                "grant_type": "password",
                "client_id": "984B0011-C9CD-4ED2-8DD9-B5773350BC2F",
                "client_secret": "xQESeMSGW1mTdPo1oAOEki1E892AdZ0LfBFzleXY"
            },
            url: "https://apiecommercefuster.ideaconsulting.es/oauth/token"
        }).done(function(response) {
            if(response){
                // alert('SUCCESS - Autenticación de usuario correcta.');
                // console.log(response);
                var access_token_fuster = response.access_token;
                localStorage.setItem("access_token_fuster", access_token_fuster);

                //PETICION WHOIAM
                    $.ajax({
                        method: "GET",
                        headers: {
                            "Authorization": "Bearer " + access_token_fuster
                        },
                        url: 'https://apiecommercefuster.ideaconsulting.es/api/whoiam'
                    }).done(function(response) {
                        if(response){
                            // alert('SUCCESS - Verificación de usuario logueado correcta.');
                            // console.log(response);
                            localStorage.setItem("user_data_fuster", JSON.stringify(response));

                            $.ajax({
                                method: "GET",
                                headers: {
                                    "Authorization": "Bearer " + access_token_fuster
                                },
                                url: 'https://apiecommercefuster.ideaconsulting.es/api/delivery-addresses'
                            }).done(function(response) {
                                if(response){
                                    // alert('SUCCESS - Carga de direcciones de envio');

                                    localStorage.setItem("user_data_address_fuster", JSON.stringify(response));
                                    window.location.replace("./");
                                }
                            }).fail(function(response) {
                                alert('ERROR - No se pudo cargar las direcciones de envio.');
                                // console.log('FALLO Carga Datos')
                                localStorage.setItem("access_token_fuster", '');
                                localStorage.setItem("user_data_fuster", '');
                                localStorage.setItem("user_data_address_fuster", '');
                                localStorage.setItem("user_cart_fuster", '');
                                $('.btnLogin').html(boton);
                            });
                            
                        }
                    }).fail(function(response) {
                        alert('ERROR - No se pudo verificar el usuario logueado.');
                        // console.log('FALLO VERIFICACION')
                        localStorage.setItem("access_token_fuster", '');
                        localStorage.setItem("user_data_fuster", '');
                        localStorage.setItem("user_data_address_fuster", '');
                        localStorage.setItem("user_cart_fuster", '');
                        $('.btnLogin').html(boton);
                    });
            }
        }).fail(function(response) {	
            var resp = response.responseJSON;
            alert('ERROR - No se pudo autenticar el usuario.');
            // console.log('FALLO AUTENTICACION')
            // console.log(resp.error); //invalid_grant
            // console.log(resp.error_description) // The user credentials were incorrect.
            // console.log(resp.message) // The user credentials were incorrect.
            $('.btnLogin').html(boton);
            localStorage.setItem("access_token_fuster", '');
            localStorage.setItem("user_data_fuster", '');
            localStorage.setItem("user_data_address_fuster", '');
            localStorage.setItem("user_cart_fuster", '');

        });
	});


});

</script>