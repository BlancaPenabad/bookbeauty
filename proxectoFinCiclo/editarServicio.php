<?php
include "lib/bd/base_datos.php";

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$conexion = get_conexion();
seleccionar_bd_gestorCitas($conexion);

$mensajes = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_servicio = $_POST['id_servicio'];
    $nombre_servicio = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $duracion = $_POST['duracion'];

    // VALIDACIONES
    if (empty($nombre_servicio)) {
        $mensajes[] = "El nombre del servicio no puede estar vacío.";
    } 

    if (empty($descripcion)) {
        $mensajes[] = "La descripción del servicio no puede estar vacía.";
    }

    if (!is_numeric($precio) || $precio <= 0) {
        $mensajes[] = "El precio debe ser un número positivo.";
    }

    if (!is_numeric($duracion) || $duracion <= 0) {
        $mensajes[] = "La duración debe ser un número positivo.";
    }

    if (count($mensajes) > 0) {
        foreach ($mensajes as $error) {
            echo "<script>alert('$error'); window.location.href = 'dashboard_admin.php';</script>";
        }
    } else {
        if (updateServicio($conexion, $id_servicio, $nombre_servicio, $duracion, $precio, $descripcion)) {
            echo "<script>alert('Servicio actualizado con éxito');</script>";
            header('Location: dashboard_admin.php'); 
            exit();
        } else {
            echo "<script>alert('Error al actualizar el servicio.');</script>";
        }
    }
}

cerrar_conexion($conexion);
?>