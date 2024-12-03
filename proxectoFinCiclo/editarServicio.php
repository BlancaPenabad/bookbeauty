<?php
include "lib/bd/base_datos.php";

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$conexion = get_conexion();
seleccionar_bd_gestorCitas($conexion);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_servicio = $_POST['id_servicio'];
    $nombre_servicio = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $duracion = $_POST['duracion'];

    // Llamar a la función de actualización
    if (updateServicio($conexion, $id_servicio, $nombre_servicio, $duracion, $precio, $descripcion)) {
        echo "<script>alert('Servicio actualizado con éxito');</script>";
        header('Location: dashboard_admin.php'); // Redirige de vuelta al dashboard
        exit();
    } else {
        echo "<script>alert('Hubo un error al actualizar el servicio');</script>";
    }
}

cerrar_conexion($conexion);
?>