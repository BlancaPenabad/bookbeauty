<?php

include "lib/bd/base_datos.php";
include "lib/bd/utilidades.php";

$conexion = get_conexion();
seleccionar_bd_gestorCitas($conexion);

$mensajes = array();

if (isset($_POST['enviar'])) {
    $user = test_input($_POST['usuario']);
    $pass = test_input($_POST['password']);

    /* VALIDACIONES */
    if (empty($user) || !preg_match('/^[a-zA-Z0-9_]+$/', $user) || strlen($user) > 50) {
        $mensajes[] = array("error", "Nombre de usuario inválido. Sólo puede contener letras, números y guion bajo, y no debe superar los 50 caracteres.");
    }

    if (strlen($pass) < 6) {
        $mensajes[] = array("error", "La contraseña debe tener al menos 6 caracteres.");
    }

    if (empty($mensajes)) {
        $stmt = $conexion->prepare("SELECT id FROM administrador WHERE usuario = :usuario");
        $stmt->bindParam(':usuario', $user);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $mensajes[] = array("error", "El nombre de usuario ya está en uso.");
        } else {
            if (alta_admin($conexion, $user, $pass)) {
                $mensajes[] = array("success", "Alta de usuario correcta.");
            } else {
                $mensajes[] = array("error", "Alta de usuario incorrecta.");
            }
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
    <title>Registro administradores</title>
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
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Registro</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        
      </div>
      <a href="index.php" class="login-boton">Atrás</a>
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
        <h1>Registro de administradores</h1>
            <form id="form" class="mx-auto" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="mb-3">
                    <label for="userName" class="form-label">Nombre de usuario:</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" >
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <input type="submit" class="btn btn-primary"  name="enviar"  value="Registrarse">
                <div class="mensaje">
                    <?= get_mensajes_html_format($mensajes); ?>
                </div>
            </form>
    </div>
</section>
<!--End Hero Section -->

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("form").addEventListener("submit", function(event) {
        let errores = [];
        
        let usuario = document.getElementById("usuario");
        let password = document.getElementById("password");
        
        let usuarioValor = usuario.value.trim();
        let passwordValor = password.value.trim();

        let patronUsuario = /^[a-zA-Z0-9_]+$/;

        // Validar usuario
        if (usuarioValor === "" || !patronUsuario.test(usuarioValor) || usuarioValor.length > 50) {
            errores.push("El nombre de usuario solo puede contener letras, números y guion bajo, y no debe superar los 50 caracteres.");
            usuario.classList.add("is-invalid"); 
        } else {
            usuario.classList.remove("is-invalid");
        }

        // Validar contraseña
        if (passwordValor.length < 6) {
            errores.push("La contraseña debe tener al menos 6 caracteres.");
            password.classList.add("is-invalid"); 
        } else {
            password.classList.remove("is-invalid");
        }

        if (errores.length > 0) {
            alert(errores.join("\n"));
            event.preventDefault();
        }
    });
});
</script>
    <!--Bootstrap JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>