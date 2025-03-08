<?php
include "lib/bd/base_datos.php";
include "lib/bd/utilidades.php";

if (isset($_GET['codigo_unico'])) {
    $codigo_unico = $_GET['codigo_unico'];

    $conexion = get_conexion();
    seleccionar_bd_gestorCitas($conexion);

    $mensajes = array();

    $consulta = $conexion->prepare("SELECT * FROM citas WHERE codigo_unico = :codigo_unico");
    $consulta->bindParam(":codigo_unico", $codigo_unico);
    $consulta->execute();

    if ($consulta->rowCount() > 0) {
        // Cita encontrada
        $cita = $consulta->fetch(PDO::FETCH_ASSOC);

        $id_servicio = $cita['id_servicio'];
        $servicio = $conexion->prepare("SELECT nombre FROM servicios WHERE id_servicio = :id_servicio");
        $servicio->bindParam(':id_servicio', $id_servicio);
        $servicio->execute();
        $servicio_data = $servicio->fetch(PDO::FETCH_ASSOC);
        $nombre_servicio = $servicio_data ? $servicio_data['nombre'] : 'Servicio no encontrado';
        
        $negocio_data = get_id_negocio($conexion, $id_servicio);
        if ($negocio_data) {
            $id_negocio = $negocio_data['id_negocio'];
            $negocio = $conexion->prepare("SELECT nombre FROM negocios WHERE id_negocio = :id_negocio");
            $negocio->bindParam(':id_negocio', $id_negocio);
            $negocio->execute();
            $negocio_data = $negocio->fetch(PDO::FETCH_ASSOC);
            $nombre_negocio = $negocio_data ? $negocio_data['nombre'] : 'Negocio no encontrado';
        } else {
            $nombre_negocio = 'Negocio no encontrado';
        }

    } else {
        $error_message = "No se encontró ninguna cita con ese código único.";
    }

    cerrar_conexion($conexion);
} else {
    $error_message = "El código único es obligatorio.";
}

if (isset($_POST['eliminar_cita'])) {
    $id_cita = $_POST['id_cita'];
    if (deleteCita($conexion, $id_cita)) {
        $mensajes = array("success", "Alta de usuario correcta.");
    } else {
        $mensajes = array("success", "Alta de usuario correcta.");
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
<?= get_mensajes_html_format($mensajes); ?>
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
                        <td><strong>Negocio</strong></td>
                        <td><?= htmlspecialchars($nombre_negocio); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tratamiento</strong></td>
                        <td><?= htmlspecialchars($nombre_servicio); ?></td>
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
        <div class="d-flex justify-content-between">
            <a href="editarCita.php?codigo_unico=<?= htmlspecialchars($cita['codigo_unico']); ?>" class="btn btn-warning">Editar</a>
            <form method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta cita?');">
                <input type="hidden" name="id_cita" value="<?= htmlspecialchars($cita['id']); ?>">
                <button type="submit" name="eliminar_cita" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</section>
<!--End Detalles de la cita -->

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