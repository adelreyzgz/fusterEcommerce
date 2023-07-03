<div id="page">
    <div id="main">
        <?php
            include 'modules/lateral/buscador-avanzado.php';
        ?>
        <?php
            $enviado = false;


            if(isset($_POST) && $_POST['name'] != ''){

            $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
            $recaptcha_secret = '6Ld5Iq8jAAAAAAL8W_NgUyns3dWNMcikV4HuCJFh'; 
            $recaptcha_response = $_POST['recaptcha_response']; 
            $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
            $recaptcha = json_decode($recaptcha); 
            
            if($recaptcha->score >= 0.7){
                
                    $nombre = $_POST['name'];
                    $email = $_POST['email'];
                    $subject = $_POST['subject'];
                    $message = $_POST['message'];
                    $template = '
                        <html xmlns:v="urn:schemas-microsoft-com:vml">
                    
                            <head>
                    
                                <style type="text/css">
                                    .contenedor {
                                        font-family: sans-serif;
                                        text-align: left;
                                        width: 600px;
                                        background: #ffffff !important;
                                        border: 1px solid #e7e7e7;
                                        padding: 0px 35px;
                                    }
                    
                                    td {
                                        padding: 35px 10px;
                                        color: #38454C;
                                        font-family: Sans-serif;
                                        font-size: 12px;
                                    }
                    
                                    a.btn {
                                        text-decoration: none;
                                        background-color: #ECF5F4;
                                        color: #000;
                                        font-weight: 600;
                                        font-size: 12px;
                                        padding: 10px 29px;
                                    }
                    
                                    .relleno {
                                        background-color: #ECF5F4;
                                        padding: 29px 40px;
                                    }
                                </style>
                    
                            </head>
                    
                            <body>
                                <div style="text-align:left;width:100%;">
                                    <table class="contenedor"
                                        style="background: #ffffff !important;background-color: #ffffff !important;text-align:center;">
                    
                                        <tr>
                                            <td style="text-align: center;padding: 22px 10px;">
                                                <img src="<?=$base;?>assets/images/logo.png"
                                                    style="width: 100%;margin-top: 18px;">
                                            </td>
                                        </tr>
                    
                                        <tr>
                                            <td style="text-align: center;padding: 0px 10px;">
                                                Nombre: '.$nombre.'<br>
                                                Email: '.$email.'<br>
                                                Asunto: '.$subject.'<br>
                                                Mensaje: '.$message.'<br>
                                            </td>
                                        </tr>
                    
                                    </table>
                                </div>
                            </body>
                    
                        </html>
                    ';
                
                    #-> MAIL:
                    $mail_host = 'mail.repuestosfuster.com';
                    $mail_isSMTP = true;
                    $mail_SMTPAuth = true;
                    $mail_SMTPSecure = 'TLS';
                    $mail_isSSL = true;
                    $mail_Port = 587;
                    $mail_user = 'info@repuestosfuster.com';
                    $mail_pass = 'LBZ6vVJBV';
                    $mail_from = 'info@repuestosfuster.com';
                    $mail_fromName = 'STD Core';

                    include('libs/phpmailer/src/PHPMailer.php');
                    include('libs/phpmailer/src/SMTP.php');
                    try
                    {
                        $mail = new PHPMailer(true);

                        # Config:
                        $mail->Host = 'mail.repuestosfuster.com';
                        if (true === true) { $mail->isSMTP(); }
                        $mail->SMTPAuth = true;
                        $mail->SMTPSecure = '';
                        if (true == true) { $mail->SMTPOptions = array('ssl'=>array('verify_peer'=>true, 'verify_peer_name'=>true, 'allow_self_signed'=>false)); }
                        $mail->Port = 25;
                        $mail->Username = 'no-reply@repuestosfuster.com';
                        $mail->Password = 'OA9b3PXo1';
                        $mail->From = 'no-reply@repuestosfuster.com';
                        $mail->FromName = 'no-reply@repuestosfuster.com';

                        # Mail:
                        $mail->isHTML(true);
                        $mail->addAddress("fuster@repuestosfuster.com", 'fuster@repuestosfuster.com');
                        $mail->addAddress("alejandro.delrey@stdcore.com", 'alejandro.delrey@stdcore.com');


                        $mail->Subject = "Solicitud de Contacto Fuster";
                        $mail->Body = '
                        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="https://www.w3.org/1999/xhtml" style="font-family: Montserrat, sans-serif;">
                            <head>
                                <link href="https://fonts.googleapis.com/css?family=Montserrat:thin,extra-light,light,100,200,300,400,500,600,700,800" rel="stylesheet"> 
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                <!--[if (mso 9)]>
                                    <style type="text/css">
                                        body {font-family: sans-serif !important;}
                                    </style>
                                <![endif]--> 
                                <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> 
                                <style type="text/css">

                                </style>
                            </head>
                            <body id="body" class="" style="font-size: 21px;color:#555;background: #fff;font-family: Montserrat, sans-serif;max-width: 830px;">
                                Nombre: '.$nombre.'  <br>
                                Correo: '.$email.'   <br>
                                Asunto: '.$subject.'   <br>
                                Mensaje: '.$message.'  <br>
                                Origen: PAG. CONTACTO  <br>
                            </body>
                        </html>
                        ';

                        if ($mail->send()) { $enviado = true; }
                        
                    }
                    catch (Exception $e) {
                    }
            }else{
                $_SESSION['enviadoMail'] = -1;
            }

        }

        ?>


        <div id="content" class="column ocultBusca"  role="main">
            <a id="main-content"></a>
            <h1 class="page__title title" id="page-title"><?=${"lang_".$idioma}['contactanosotros'];?></h1>

                <?php if($enviado){
                    if($idioma == 'es'){
                        echo '<div class="messages--status messages status">Gracias por contactar con nosotros. En breve, nos pondremos en contacto con Vd.</div>';
                    }else if($idioma == 'fr'){
                        echo '<div class="messages--status messages status">Gracias por contactar con nosotros. En breve, nos pondremos en contacto con Vd.</div>';
                    }else{
                        echo '<div class="messages--status messages status">Merci de nous contacter. Nous vous contacterons sous peu.</div>';
                    }
                }
                ?>


                <div class="field field-name-body field-type-text-with-summary field-label-hidden">
                    <div class="field-items">
                        <div class="field-item even" property="content:encoded">
                            <div class="ficha-contacto">
                                <div class="contacto-logo"><img alt="Repuestos Fuster" src="<?=$base;?>sites/all/themes/zenfuster/img/logo-contacto.gif" title="Repuestos Fuster" width="330" height="130" /></div>
                                <div class="contacto-txt">
                                    <p>
                                        <img alt="Polígono Industrial Plaza. Zaragoza" src="<?=$base;?>sites/all/themes/zenfuster/img/ico-map.png" title="Polígono Industrial Plaza. Zaragoza" width="50" height="50" />Polígono
                                        Industrial Plaza, Calle Turiaso, 28.<br />
                                        50197 Zaragoza (Zaragoza). España
                                    </p>
                                    <p><img alt="+34 976 77 07 96" src="<?=$base;?>sites/all/themes/zenfuster/img/ico-phone.png" title="+34 976 77 07 96" width="50" height="50" />+34 976 77 07 96</p>
                                    <p><img alt="+34 669 105 394" src="<?=$base;?>sites/all/themes/zenfuster/img/ico-whatsapp.png" title="+34 669 105 394" width="50" height="50" />+34 669 105 394</p>
                                    <p>
                                        <img alt="fuster@repuestosfuster.com" src="<?=$base;?>sites/all/themes/zenfuster/img/ico-mail.png" title="fuster@repuestosfuster.com" width="50" height="50" />
                                        <a href="mailto:fuster@repuestosfuster.com" title="fuster@repuestosfuster.com" style='color: #141213;text-decoration: none;'>
                                            fuster@repuestosfuster.com
                                        </a>
                                    </p>
                                    <div class="logos-rrss">
                                        <p>
                                            <img alt="Logo Facebook" src="<?=$base;?>sites/all/themes/zenfuster/images/facebook-yellow.svg" title="Contactar a través de Facebook" width="50" height="50" />
                                            <a href="https://www.facebook.com/RepuestosFuster" target="_blank" title="<?=${"lang_".$idioma}['contactatravez'];?> Facebook">
                                                <?=${"lang_".$idioma}['atravez'];?> Facebook</a>
                                        </p>
                                        <p>
                                            <img alt="Logo Twitter" src="<?=$base;?>sites/all/themes/zenfuster/images/twitter-yellow.svg" title="Contactar a través de Twitter" width="50" height="50" />
                                            <a href="https://twitter.com/RepuestosFuster" target="_blank" title="<?=${"lang_".$idioma}['contactatravez'];?> Twitter"><?=${"lang_".$idioma}['atravez'];?> Twitter</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="formulario-contacto">
     
                                <h2><?=${"lang_".$idioma}['formulariocontacto'];?></h2>
                                <p><?=${"lang_".$idioma}['rellenaformulario'];?></p>
                                <p></p>

                                <form action="" method="post" id="fuster-contact-site-form" accept-charset="UTF-8" style="justify-content: center;display: flex;flex-direction: column;align-items: center;">
                                    <div style="width: 370px;">
                                        <div class="form-item form-type-textfield form-item-name" style="display: flex;justify-content: left;margin-bottom: 14px;">
                                            <label for="edit-name" style="margin-right: 24px;width: 88px;text-align: right;"><?=${"lang_".$idioma}['nombre'];?> <span class="form-required" title="Este campo es obligatorio.">*</span></label>
                                            <input type="text" id="edit-name" name="name" value="" required size="60" maxlength="128" class="form-text required" />
                                        </div>
                                        <div class="form-item form-type-textfield form-item-email" style="display: flex;justify-content: left;margin-bottom: 14px;">
                                            <label for="edit-email" style="margin-right: 24px;width: 88px;text-align: right;"><?=${"lang_".$idioma}['email'];?> <span class="form-required" title="Este campo es obligatorio.">*</span></label>
                                            <input type="text" id="edit-email" name="email" value="" required size="60" maxlength="128" class="form-text required" />
                                        </div>
                                        <div class="form-item form-type-textfield form-item-subject" style="display: flex;justify-content: left;margin-bottom: 14px;">
                                            <label for="edit-subject" style="margin-right: 24px;width: 88px;text-align: right;"><?=${"lang_".$idioma}['asunto'];?> <span class="form-required" title="Este campo es obligatorio.">*</span></label>
                                            <input type="text" id="edit-subject" name="subject" value="" required size="60" maxlength="128" class="form-text required" />
                                        </div>
                                        <div class="form-item form-type-textarea form-item-message" style="display: flex;justify-content: left;margin-bottom: 14px;">
                                            <label for="edit-message" style="margin-right: 24px;width: 88px;text-align: right;"><?=${"lang_".$idioma}['mensaje'];?> <span class="form-required" title="Este campo es obligatorio.">*</span></label>
                                            <div class="form-textarea-wrapper resizable textarea-processed resizable-textarea">
                                                <textarea id="edit-message" name="message" cols="44" rows="5" required class="form-textarea required"></textarea>
                                                <div class="grippie"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="width: 80%;text-align: center;display: flex;flex-direction: column;align-items: center;">
                                        <div id="edit-privacy1" class="form-checkboxes" style="margin-top: 8px;">
                                            <div class="form-item form-type-checkbox form-item-privacy1-1">
                                                <label class="option" for="edit-privacy1-1">
                                                    <p class="contact-text">
                                                        <?=${"lang_".$idioma}['avisolegaltext'];?>
                                                    </p>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="edit-privacy" class="form-checkboxes" style="width: 312px;">
                                            <div class="form-item form-type-checkbox form-item-privacy-1">
                                                <input type="checkbox" id="edit-privacy-1" name="privacy[1]" value="1" class="form-checkbox" required style='height: 21px;' />
                                                <label class="option" for="edit-privacy-1"><?=${"lang_".$idioma}['heleido'];?> <a href="<?=$idioma;?>/<?=${"lang_".$idioma}['url']['politica-privacidad'];?>/" target="_blank"><?=${"lang_".$idioma}['politicayprivacidad'];?></a>. </label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">

                                        <input class="form-submit btnbuscarContact btnbuscar2" value='<?=${"lang_".$idioma}['enviar'];?>' style="" type="submit" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <?php 
            include 'modules/busqueda/resultadoBusqueda.php';
        ?>
    </div>
</div>