<?php

include "lib/bd/base_datos.php";
include "lib/bd/utilidades.php";

$conexion = get_conexion();
seleccionar_bd_gestorCitas($conexion);
session_start();

if (isset($_SESSION['usuario'])){
  header('Location: dashboard_admin.php');
}

$mensajes = array();
$usuario = "";
$password = "";

if (isset($_GET['id_servicio'], $_GET['fecha'], $_GET['nombre_cliente'], $_GET['email_cliente'], $_GET['tlf_cliente'], $_GET['codigo_unico'])) {
  $id_servicio = $_GET['id_servicio'];
  $fecha = $_GET['fecha'];
  $nombre_cliente = $_GET['nombre_cliente'];
  $email_cliente = $_GET['email_cliente'];
  $tlf_cliente = $_GET['tlf_cliente'];
  $codigo_unico = $_GET['codigo_unico'];
} else {
  $mensajes[] = array("error", "Ha ocurrido un error.");
 }

 $servicio = get_id_negocio($conexion,$id_servicio);

 if($servicio){
  $id_negocio = $servicio['id_negocio'];
  $nombre_servicio = $servicio['nombre'];

  $negocio = datos_negocio_id($conexion, $id_negocio);
        if ($negocio) {
            $nombre_negocio = $negocio['nombre'];  
        } else {
            $nombre_negocio = "Negocio no encontrado";
        }
    } else {
        $nombre_negocio = "Negocio no encontrado";
        $nombre_servicio = "Servicio no encontrado";
    }

?>


<!DOCTYPE html>
<html lang="es">
<head>
<!--
    Autora: Blanca Penabad Villar
    Email: a22blancapv@iessanclemente.net
-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
<!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="style.css" rel="stylesheet">
    
</head>
<body>
<!--Navbar-->
<header>
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand me-auto" href="index.php">Book<b>Beauty</b></a>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">BookBeauty</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
      </div>
      <a href="javascript:history.back()" class="login-boton">Volver atrás</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>
</header>
<!--End Navbar-->

<!--Hero Section -->
<section class="hero-section">
    <div class="container d-flex align-items-center justify-content-center fs-1 text-white flex-column"> 
    <?= get_mensajes_html_format($mensajes); ?>
        <h1>Tu cita en <?=htmlspecialchars($nombre_negocio);?> ha sido confirmada  <?=htmlspecialchars($nombre_cliente);?>  ¡Gracias por reservar con BookBeauty!</h1>
    </div>
    <div class="contenedor-tabla">
            <h2>Detalles de tu cita</h2>
            <table class="table table-bordered custom-table">
                
                <tbody>
                    <tr>
                        <td>Tratamiento</td>
                        <td><?= htmlspecialchars($nombre_servicio); ?></td>
                    </tr>
                    <tr>
                        <td>Fecha</td>
                        <td><?= htmlspecialchars($fecha); ?></td>
                    </tr>
                    <tr>
                        <td>Nombre</td>
                        <td><?= htmlspecialchars($nombre_cliente); ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?= htmlspecialchars($email_cliente); ?></td>
                    </tr>
                    <tr>
                        <td>Teléfono</td>
                        <td><?= htmlspecialchars($tlf_cliente); ?></td>
                    </tr>
                    <tr>
                        <td>Código de la cita</td>
                        <td><?= htmlspecialchars($codigo_unico); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
</section>
<!--End Hero Section -->

<!-- Footer -->
<footer>
  <div class="footerBottom">
      <p><small>Copyright &copy;2025; Designed by <span class="designer">Blanca Penabad Villar</span></small></p>
    </div>
</footer>
<!-- End Footer -->

    <!--Bootstrap JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>