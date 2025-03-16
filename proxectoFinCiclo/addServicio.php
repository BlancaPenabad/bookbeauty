<?php

include "lib/bd/base_datos.php";
include "lib/bd/utilidades.php";

session_start();

if(isset($_GET['logout'])){
  logout();
}


if(!isset($_SESSION['usuario'])){
    header('Location: login.php');
    exit();
}

$conexion = get_conexion();
seleccionar_bd_bookBeauty($conexion);

//Obtengo el ID del administrador loggeado para mostrar los datos de su negocio
$id_administrador = $_SESSION['id_administrador'];
$negocio = datos_negocio($conexion, $id_administrador);

//Obtengo  datos de los servicios del negocio del administrador loggeado
$servicios = datos_servicios($conexion, $id_administrador);

if($negocio === null){
  $nombre_negocio = "No tienes negocio";
  $id_negocio = " ";
  $mostrar_formulario = false; 
  
}else{
  $id_negocio = $negocio['id_negocio'];
  $nombre_negocio = $negocio['nombre'];
  $mostrar_formulario = true; 
}

$mensajes = array();

if (isset($_POST['enviar']) && $mostrar_formulario) {
    $nombre_servicio = test_input($_POST['servName']);
    $descripcion = test_input($_POST['description']);
    $precio = test_input($_POST['price']);
    $duracion = test_input($_POST['minutes']);

    /* VALIDACIONES */
    if (empty($nombre_servicio) || strlen($nombre_servicio) > 255) {
        $mensajes[] = array("error", "El nombre del servicio es obligatorio y no debe superar los 255 caracteres.");
    }

    if (empty($descripcion) || strlen($descripcion) > 300) {
        $mensajes[] = array("error", "La descripción es obligatoria y no debe superar los 300 caracteres.");
    }

    if (!is_numeric($precio) || $precio < 0) {
        $mensajes[] = array("error", "El precio debe ser un número válido y no puede ser negativo.");
    }

    if (!is_numeric($duracion) || $duracion < 0) {
        $mensajes[] = array("error", "La duración debe ser un número válido y no puede ser negativa.");
    }

    if (empty($mensajes)) {
        if (addServicio($conexion, $nombre_servicio, $duracion, $precio, $descripcion, $id_negocio)) {
            $mensajes[] = array("success", "Servicio añadido correctamente.");
        } else {
            $mensajes[] = array("error", "Error al añadir el servicio.");
        }
    }
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
    <title>Nuevo servicio </title>
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
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Nuevo servicio</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        
      </div>
      <a href="dashboard_admin.php" class="login-boton">Atrás</a>
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

    <?php if (!$mostrar_formulario): ?>
            <!-- Mensaje si no hay negocio -->
            <div class="alert alert-warning" role="alert">
                No tienes ningún negocio registrado. Por favor, registra un negocio antes de añadir servicios.
            </div>
        <?php else: ?>

        <h1>Nuevo servicio para  <?= htmlspecialchars($nombre_negocio); ?> </h1>
            <form id="form" class="mx-auto" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="mb-3">
                    <label for="servName" class="form-label">Nombre del servicio:</label>
                    <input type="text" class="form-control" id="servName" name="servName" >
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descripcion:</label>
                    <textarea rows="4" cols="50" maxlength="200" placeholder="Escribe la descripción del servicio aquí..." class="form-control" id="description" name="description"></textarea>
                    <small id="charCount" class="text-muted" style="font-size: 0.6rem;">0 / 200 caracteres</small>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Precio:</label>
                    <input type="number" step="0.01" min="0"  class="form-control" id="price" name="price">
                </div>
                <div class="mb-3">
                    <label for="minutes" class="form-label">Duración (minutos):</label>
                    <input type="number" min="0"  class="form-control" id="minutes" name="minutes">
                </div>
                <input type="submit" class="btn btn-primary"  name="enviar"  value="Añadir servicio">
                <div class="mensaje">
                    <?= get_mensajes_html_format($mensajes); ?>
                </div>
            </form>
    <?php endif; ?>
    </div>
</section>
<!--End Hero Section -->
<!--Footer -->
<footer>
  <div class="footerBottom">
      <p><small>Copyright &copy;2025; Diseñado por <span class="designer">Blanca Penabad Villar</span></small></p>
    </div>
</footer>


    <!--Bootstrap JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form");

    form.addEventListener("submit", function (event) {
        let errores = [];

        let nombre = document.getElementById("servName");
        let descripcion = document.getElementById("description");
        let precio = document.getElementById("price");
        let duracion = document.getElementById("minutes");

        document.querySelectorAll(".is-invalid").forEach(el => el.classList.remove("is-invalid"));
        document.querySelectorAll(".invalid-feedback").forEach(el => el.remove());

        if (nombre.value.trim() === "") {
            errores.push({input: nombre, mensaje: "El nombre del servicio es obligatorio."});
        } else if (nombre.value.length > 255) {
            errores.push({input: nombre, mensaje: "El nombre no debe superar los 255 caracteres."});
        }

        if (descripcion.value.trim() === "") {
            errores.push({input: descripcion, mensaje: "La descripción es obligatoria."});
        } else if (descripcion.value.length > 300) {
            errores.push({input: descripcion, mensaje: "Máximo 300 caracteres en la descripción."});
        }

        const patronPrecio = /^\d+(\.\d{1,2})?$/;
        if (!patronPrecio.test(precio.value) || parseFloat(precio.value) <= 0) {
            errores.push({input: precio, mensaje: "El precio debe ser un número válido con hasta 2 decimales y mayor a 0."});
        }

        if (!/^\d+$/.test(duracion.value) || parseInt(duracion.value) <= 0) {
            errores.push({input: duracion, mensaje: "La duración debe ser un número entero mayor a 0."});
        }

        if (errores.length > 0) {
            event.preventDefault(); 
            errores.forEach(error => {
                error.input.classList.add("is-invalid");
                let divError = document.createElement("div");
                divError.className = "invalid-feedback";
                divError.textContent = error.mensaje;
                error.input.parentNode.appendChild(divError);
            });
        }
    });

    document.querySelectorAll("input, textarea").forEach(input => {
        input.addEventListener("input", function () {
            this.classList.remove("is-invalid");
            if (this.nextElementSibling && this.nextElementSibling.classList.contains("invalid-feedback")) {
                this.nextElementSibling.remove();
            }
        });
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const description = document.getElementById("description");
    const charCount = document.getElementById("charCount");

    description.addEventListener("input", function () {
        let length = description.value.length;
        charCount.textContent = `${length} / 200 caracteres`;

        if (length > 200) {
            description.value = description.value.substring(0, 200);
            charCount.textContent = "200 / 200 caracteres";
        }
    });
});
</script>
</body>
</html>