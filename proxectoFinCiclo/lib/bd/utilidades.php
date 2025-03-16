<?php

require_once __DIR__ . '/../../../vendor/autoload.php';  

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function test_input($datos){
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

function get_mensajes_html_format($mensajes){
    
    $resultado = "";

    if(count($mensajes) > 0) {
        foreach ($mensajes as $mensaje){
            if($mensaje[0] == "error"){
                $resultado .= '<div class="alert alert-danger" role="alert">' . $mensaje[1] . '</div>';   
            }elseif($mensaje[0] == "success"){
                $resultado .= '<div class="alert alert-success" role="alert">' . $mensaje[1] . '</div>';
            }
        }
    }
    return $resultado;
}
  
function is_logged(){
    if(!isset($_SESSION)){
        session_start();
    }
    if(isset($_SESSION['usuario'])){
        return true;
    }else{
        return false;
    }
}

function logout(){


    $_SESSION = array();
    session_destroy();

    if(isset($_COOKIE['usuario'])){
        setcookie('usuario', '', time() - 3600, '/');
    }
    header('Location: login.php');
    exit();

}

function enviarCorreoConfirmacion($email, $nombre_cliente, $nombre_negocio, $fecha, $codigo_unico) {
    $mail = new PHPMailer(true);

    $mail->CharSet = 'UTF-8';

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'a22blancapv@iessanclemente.net';  //Mi correo de Gmail
        $mail->Password = 'mukh fyqy bslf amub'; // Contraseña de aplicación
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('a22blancapv@iessanclemente.net', 'BookBeauty');
        $mail->addAddress($email);  // Email del cliente

        $mail->isHTML(true);
        $mail->Subject = 'Confirmación de cita en ' . $nombre_negocio;
        $mail->Body    = "Hola <b>$nombre_cliente</b>,<br><br>
                          Tu cita ha sido confirmada en <b>$nombre_negocio</b>.<br>
                          <b>Fecha y Hora:</b> $fecha<br>
                          <b>Código de cita:</b> $codigo_unico<br><br>
                          ¡Te esperamos!<br><br>
                          Gracias por utilizar nuestro sistema de reservas.";

        $mail->send();
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}

function enviarCorreoConfirmacionNegocio($email_negocio, $nombre_cliente, $nombre_negocio, $fecha, $codigo_unico, $servicio_nombre) {
    $mail = new PHPMailer(true);

    $mail->CharSet = 'UTF-8';

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'a22blancapv@iessanclemente.net';  
        $mail->Password = 'mukh fyqy bslf amub'; 
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('a22blancapv@iessanclemente.net', 'BookBeauty');
        $mail->addAddress($email_negocio);  // Email del negocio

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Nueva cita reservada en ' . $nombre_negocio;
        $mail->Body    = "Hola,<br><br>
                          Se ha reservado una nueva cita en <b>$nombre_negocio</b>.<br><br>
                          <b>Detalles de la cita:</b><br>
                          <b>Cliente:</b> $nombre_cliente<br>
                          <b>Servicio:</b> $servicio_nombre<br>
                          <b>Fecha y Hora:</b> $fecha<br>
                          <b>Código de cita:</b> $codigo_unico<br><br>
                          Por favor, revisa la reserva en tu sistema de gestión.<br><br>
                          Gracias.";

        // Enviar el correo
        $mail->send();
    } catch (Exception $e) {
        echo "Error al enviar el correo al negocio: {$mail->ErrorInfo}";
    }
}


?>