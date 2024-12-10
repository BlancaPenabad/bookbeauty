<?php
include "lib/bd/base_datos.php";
include "lib/bd/utilidades.php";

if (isset($_GET['codigo_unico'])) {
    $codigo_unico = $_GET['codigo_unico'];

    $conexion = get_conexion();
    seleccionar_bd_gestorCitas($conexion);

    $consulta = $conexion->prepare("SELECT * FROM citas WHERE codigo_unico = :codigo_unico");
    $consulta->bindParam(":codigo_unico", $codigo_unico);
    $consulta->execute();

    if ($consulta->rowCount() > 0) {
        // Cita encontrada
        $cita = $consulta->fetch(PDO::FETCH_ASSOC);
    } else {
        // No se encontró la cita
        $error_message = "No se encontró ninguna cita con ese código único.";
    }

    cerrar_conexion($conexion);
} else {
    $error_message = "El código único es obligatorio.";
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
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php else: ?>
            <h1>Detalles de tu cita:</h1>
        <?php endif; ?>
    </div>
</section>
<!--End Hero Section -->

<!--Detalles de la cita-->
<section>
    <div class="contenedor-tabla">
        <?php if (isset($cita)): ?>
            <table class="table table-bordered custom-table">
                <tbody>
                    <tr>
                        <td><strong>Tratamiento</strong></td>
                        <td><?= htmlspecialchars($cita['id_servicio']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Fecha</strong></td>
                        <td><?= htmlspecialchars($cita['fecha']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nombre</strong></td>
                        <td><?= htmlspecialchars($cita['nombre_cliente']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td><?= htmlspecialchars($cita['email_cliente']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Teléfono</strong></td>
                        <td><?= htmlspecialchars($cita['tlf_cliente']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Código de la cita</strong></td>
                        <td><?= htmlspecialchars($cita['codigo_unico']); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</section>
<!--End Detalles de la cita -->

<!-- Footer -->
<footer>
  <div class="footerBottom">
      <p><small>Copyright &copy;2024; Designed by <span class="designer">Blanca Penabad Villar</span></small></p>
  </div>
</footer>
<!-- End Footer -->

<!--Bootstrap JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>