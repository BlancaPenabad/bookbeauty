<?php

include "lib/bd/base_datos.php";
include "lib/bd/utilidades.php";

session_start();

if (isset($_SESSION['usuario'])){
  header('Location: dashboard_admin.php');
}

$mensajes = array();
$usuario = "";
$password = "";


/* VALIDACIONES */
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])){
  if(!empty($_POST['usuario']) && is_string($_POST['usuario']) && strlen($_POST['usuario']) <= 50){
      $usuario = test_input($_POST['usuario']);
  }else{
      $mensajes[] = array("error", "Introduce un nombre de usuario válido: texto y menos de 50 caracteres.");
  }

  if(!empty($_POST['password']) && is_string($_POST['password']) && strlen($_POST['password']) <= 30){
      $password = test_input($_POST['password']);
  }else{
      $mensajes[] = array("error", "Introduce una contraseña válida: texto y menos de 30 caracteres.");
  }
}

if(empty($mensajes)){
  if(isset($_POST['login']) && isset($usuario) && isset($password)){
      login($usuario, $password);
      if(is_logged()){
          $mensajes[] = array("success", "Usuario validado correctamente");
          header('Location: dashboard_admin.php');
      }else{
          $mensajes[] = array("error", "Nombre o contraseña incorrecta.");
      }
  }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<!--
    Autora: Blanca Penabad Villar
    Email: practicas.daw@moonoff.com
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
      <a class="navbar-brand me-auto" href="index.php">GESTOR <b>CITAS</b></a>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">GESTOR CITAS</h5>
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
<?= get_mensajes_html_format($mensajes); ?>
    <div class="container d-flex align-items-center justify-content-center fs-1 text-white flex-column"> 
        <h1>Iniciar sesión</h1>
            <form class="mx-auto" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="mb-3">
                    <label for="userName" class="form-label">Nombre de usuario:</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" aria-describedby="emailHelp" placeholder="Nombre de usuario" value="<?= $usuario?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" value="<?= $password?>">
                    <div id="emailHelp" class="form-text">¿Has olvidado tu contraseña?</div>
                </div>
                
            <button type="submit" class="btn btn-primary" name="login">Login</button>
            </form>
    </div>
</section>
<!--End Hero Section -->

<!-- Footer -->
<footer>
  <div class="footerContainer">
    <div class="socialMediaIcons">
      <a href=""><i class="fa-brands fa-facebook"></i></a>
      <a href=""><i class="fa-brands fa-instagram"></i></a>
      <a href=""><i class="fa-brands fa-linkedin"></i></a>
      <a href=""><i class="fa-brands fa-twitter"></i></a>
    </div>
    <div class="footerNav">
      <ul>
        <li><a href="index.php">Sobre nosotros</a></li>
        <li><a href="index.php">Beneficios</a></li>
        <li><a href="index.php">Reserva tu cita</a></li>
        <li><a href="index.php">Contacto</a></li>
      </ul>
    </div>
  </div>
  <div class="footerBottom">
      <p><small>Copyright &copy;2024; Designed by <span class="designer">Blanca Penabad Villar</span></small></p>
    </div>
</footer>
<!-- End Footer -->

    <!--Bootstrap JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>