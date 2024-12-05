<?php

include "lib/bd/base_datos.php";
include "lib/bd/utilidades.php";


$conexion = get_conexion(); 
seleccionar_bd_gestorCitas($conexion);

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

    $cliente = trim($cliente);
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]{1,50}$/", $cliente)) {
        $mensajes[] = 'Nombre no válido. Solo letras y máximo 50 caracteres.';
    }

    if (!preg_match("/^[0-9]{9,15}$/", $telefono)) {
        $mensajes[] = 'Teléfono no válido. Sólo números entre 9 y 15 dígitos.';
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensajes[] = 'Correo electrónico inválido.';
    }

    
    if (count($mensajes) > 0) { 
        foreach ($mensajes as $error) {
            echo "<script>alert('$error'); window.location.href = 'dashboard_admin.php';</script>";
        }
    } else {
        if(updateCita($conexion, $id_cita, $id_servicio, $fecha, $cliente, $email, $telefono)) {
            echo "<script>alert('Cita actualizada con éxito');</script>";
            header('Location: dashboard_admin.php'); 
            exit();
        } else {
            echo "<script>alert('Error al actualizar la cita.');</script>";
        }
    }

}

cerrar_conexion($conexion);
?>