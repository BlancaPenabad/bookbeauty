<?php

include_once "lib/bd/base_datos.php";
$conexion = get_conexion();
seleccionar_bd_gestorCitas($conexion);
$negocio = datos_negocio_id($conexion, $_GET['id_negocio']);

if (isset($_POST['submit'])){
    if(!empty($_POST['fecha']) && !empty($_POST['hora']) && !empty($_POST['nombre']) && !empty($_POST['email']) && !empty($_POST['optionSelect'])){
        $asunto = "Cita confirmada";
        $nombre_cliente = $_POST['nombre'];
        $email_cliente = $_POST['email'];
        $fecha_cita = $_POST['fecha'] . ' ' . $_POST['hora'];
        $id_servicio = $_POST['opcionSelect'];
        $nombre_negocio = $negocio['nombre'];
        $nombre_servicio = $servicio['nombre'];

        $servicio = datos_servicios_id($conexion, $id_servicio);

        $msg = "Estimado/a " . $nombre_cliente . ",\n\n";
        $msg .= "Tu cita ha sido confirmada en " . $nombre_negocio . "Aquí están los detalles: ".".\n\n";
        $msg .= "Servicio: " . $nombre_servicio . "\n";
        $msg .= "Fecha y hora: " . $fecha_cita . "\n";
        $msg .= "Nombre: " . $nombre_cliente . "\n";
        $msg .= "Muchas gracias por confiar en " . $nombre_negocio . ". ¡Te esperamos!\n";

        $header = "From: noreply@example.com" . "\r\n";
        $header.= "Reply to: noreply@example.com" . "\r\n";
        $header.= "X-Mailer: PHP/" . phpversion();

        $mail= @mail($email_cliente, $asunto, $msg, $header);
        if($mail){
            echo "<h4>¡Mail enviado exitosamente!</h4>";
        }else {
            echo "<h4>Hubo un error al enviar el correo.</h4>";
        }
    } else {
        echo "<h4>Por favor, complete todos los campos del formulario.</h4>";
    
    }
}

?>