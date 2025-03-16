<?php

include "lib/bd/base_datos.php";
include "lib/bd/utilidades.php";

$conexion = get_conexion();
seleccionar_bd_bookBeauty($conexion);

$mensajes = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_cita'])) {
    $id_cita = $_POST['id_cita'];
    $fecha = trim($_POST['fecha']);
    $nombre_cliente = trim($_POST['nombre_cliente']);
    $email_cliente = trim($_POST['email_cliente']);
    $tlf_cliente = trim($_POST['tlf_cliente']);

    /* VALIDACIONES */
    if (empty($fecha) || empty($nombre_cliente) || empty($email_cliente) || empty($tlf_cliente)) {
        $mensajes[] = "Todos los campos son obligatorios.";
    }

    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]{1,50}$/", $nombre_cliente)) {
        $mensajes[] = "El nombre del cliente no es válido.";
    }

    if (!filter_var($email_cliente, FILTER_VALIDATE_EMAIL)) {
        $mensajes[] = "El email no es válido.";
    }

    if (!preg_match("/^\d{9,15}$/", $tlf_cliente)) {
        $mensajes[] = "El teléfono debe tener entre 9 y 15 dígitos.";
    }

    if (!empty($mensajes)) {
        echo json_encode(["error" => true, "mensajes" => $mensajes]);
        exit();
    }

    if (updateCita($conexion, $id_cita, null, $fecha, $nombre_cliente, $email_cliente, $tlf_cliente)) {
        echo json_encode(["error" => false, "mensaje" => "Cita actualizada con éxito"]);
    } else {
        echo json_encode(["error" => true, "mensajes" => ["Error al actualizar la cita."]]);
    }
}

cerrar_conexion($conexion);
?>