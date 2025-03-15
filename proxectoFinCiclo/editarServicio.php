<?php

include "lib/bd/base_datos.php";

session_start();

if (!isset($_SESSION['usuario'])) {
    echo json_encode(["error" => true, "mensajes" => ["No tienes permiso para realizar esta acción."]]);
    exit();
}

$conexion = get_conexion();
seleccionar_bd_gestorCitas($conexion);

$mensajes = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_servicio'])) {
    $id_servicio = $_POST['id_servicio'];
    $nombre_servicio = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = $_POST['precio'];
    $duracion = $_POST['duracion'];

    /* VALIDACIONES */
    if (empty($nombre_servicio) || empty($descripcion) || empty($precio) || empty($duracion)) {
        $mensajes[] = "Todos los campos son obligatorios.";
    }

    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]{1,50}$/", $nombre_servicio)) {
        $mensajes[] = "Nombre no válido. Solo letras y máximo 50 caracteres.";
    }

    if (strlen($descripcion) < 10) {
        $mensajes[] = "La descripción debe tener al menos 10 caracteres.";
    }

    if (!is_numeric($precio) || $precio <= 0) {
        $mensajes[] = "El precio debe ser un número positivo.";
    }

    if (!is_numeric($duracion) || $duracion <= 0) {
        $mensajes[] = "La duración debe ser un número positivo.";
    }

    if (!empty($mensajes)) {
        echo json_encode(["error" => true, "mensajes" => $mensajes]);
        exit();
    }

    if (updateServicio($conexion, $id_servicio, $nombre_servicio, $duracion, $precio, $descripcion)) {
        echo json_encode(["error" => false, "mensaje" => "Servicio actualizado con éxito"]);
    } else {
        echo json_encode(["error" => true, "mensajes" => ["Error al actualizar el servicio."]]);
    }
}

cerrar_conexion($conexion);
?>