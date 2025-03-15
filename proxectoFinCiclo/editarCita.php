<?php

include "lib/bd/base_datos.php";
include "lib/bd/utilidades.php";


$conexion = get_conexion(); 
seleccionar_bd_bookBeauty($conexion);

$mensajes = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_cita'])) {
    $id_cita = $_POST['id_cita'];
    $id_servicio = $_POST['id_servicio'];
    $fecha = $_POST['fecha'];
    $cliente = $_POST['cliente'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

   // VALIDACIONES
   if (empty($id_servicio) || empty($fecha) || empty($cliente) || empty($telefono)) {
    $mensajes[] = 'Por favor, complete todos los campos.';
    }

    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]{1,50}$/", $cliente)) {
        $mensajes[] = 'Nombre no valido. Solo letras y maximo 50 caracteres.';
    }

    if (!preg_match("/^[0-9]{9,15}$/", $telefono)) {
        $mensajes[] = 'Telefono no valido. Solo numeros entre 9 y 15 digitos.';
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensajes[] = 'Correo electronico no valido.';
    }

    
    if (strtotime($fecha) === false) {
        $mensajes[] = "Fecha no valida.";
    }

    if (!empty($mensajes)) {
        echo json_encode(["error" => true, "mensajes" => $mensajes]);
        exit();
    }

    if (updateCita($conexion, $id_cita, $id_servicio, $fecha, $cliente, $email, $telefono)) {
        echo json_encode(["error" => false, "mensaje" => "Cita actualizada con exito"]);
    } else {
        echo json_encode(["error" => true, "mensajes" => ["Error al actualizar la cita."]]);
    }
}

cerrar_conexion($conexion);
?>