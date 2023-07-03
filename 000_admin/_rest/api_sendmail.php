<?php
session_start();

include('../../libs/phpmailer/src/PHPMailer.php');
include('../../libs/phpmailer/src/SMTP.php');

 
if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Max-Age: 86400');
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
      header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
      header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
}


$host= $_SERVER["HTTP_HOST"];


if (isset($_POST['action']) && ($_POST['action'] == 'process')) {

    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
    $recaptcha_secret = '6Ld5Iq8jAAAAAAL8W_NgUyns3dWNMcikV4HuCJFh'; 
    $recaptcha_response = $_POST['recaptcha_response']; 
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
    $recaptcha = json_decode($recaptcha); 
    // var_dump($recaptcha);
    
    $urlprev = trim($_POST['urlprev']);
      
    if($urlprev){

      if($recaptcha->score >= 0.7){

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $message = trim($_POST['message']);
        $ref = trim($_POST['ref']);
      
        $mail = new PHPMailer(true);
        # Config:
        // $mail->SMTPDebug = 3;
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
        // $mail->addAddress("proyectos@stdcore.com", 'proyectos@stdcore.com');
        // $mail->addAddress("alejandro.delrey@stdcore.com", 'alejandro.delrey@stdcore.com');

        if($message){
          $message = 'Mensaje:<br>' .$message ;
        }
        $mail->Subject = "Solicitud de Contacto Fuster Web";
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
                <img src="http://www.fusterrepuestos.local/assets/images/logo.png" style="height: 60px;width: 150px;"><br><br>
                <strong>Solicitud de Contacto</strong>
                <br>
                Nombre: '.$name.'<br>
                Correo: '.$email.'<br>
                Telefono: '.$phone.'<br>
                Ref.: '.$ref.'<br>
                '.$message.'
            </body>
        </html>
        ';

        if ($mail->send()) {
          $_SESSION['enviadoMail'] = 1;
          // código para procesar los campos y enviar el form
          header('Location:https://' . $urlprev);exit;
        }else{
          $_SESSION['enviadoMail'] = -1;
          header('Location:https://' . $urlprev);exit;
        }
      }else{
        $_SESSION['enviadoMail'] = -1;
        header('Location:https://' . $urlprev);exit;
      }
    }
}


if($host == "repuestosfuster.fr" || $host == "www.repuestosfuster.fr"){
  header('Location: https://www.repuestosfuster.fr/');exit;
}else{
  header('Location: http://www.fusterrepuestos.local/');exit;
}



?>