<?php

include "lib/bd/base_datos.php";
include "lib/bd/utilidades.php";


$conexion = get_conexion();
seleccionar_bd_gestorCitas($conexion);
$mensajes = array();

if (isset($_GET['id_negocio'])) {
  $id_negocio = $_GET['id_negocio'];
}

$negocio = datos_negocio_id($conexion, $id_negocio);
$servicios = datos_servicios_id($conexion, $id_negocio);

if($negocio == null){
  $nombre_negocio = "No tienes negocio";
  $telefono_negocio = "";
  $direccion_negocio = "";
  $foto_negocio = "";
}else{
  $nombre_negocio = $negocio['nombre'];
  $telefono_negocio = $negocio['telefono'];
  $direccion_negocio = $negocio['direccion'];
  $foto_negocio = $negocio['foto_negocio'];
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $id_servicio = $_POST['opcionSelect'];
  $fecha = $_POST['fecha'].' '.$_POST['hora'];
  $nombre_cliente = $_POST['nombre'];
  $email_cliente = $_POST['email'];
  $tlf_cliente = $_POST['tlf'];

  $codigo_unico = strtoupper(uniqid('CITA', true));

    $resultado = addCita($conexion, $id_servicio, $fecha, $nombre_cliente, $email_cliente, $tlf_cliente, $codigo_unico);

    if ($resultado) {
      $mensajes[] = array("success", "Tu cita se ha registrado correctamente. ¡Gracias!");
      header('Location: cita_confirmada.php');
      exit;
  } else {
      $mensajes[] = array("error", "Ha ocurrido un error.");
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
    <title>Zona administrador</title>
<!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<!--Header & Navbar-->
<header>
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand me-auto" href="#">GESTOR <b>CITAS</b></a>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">DASHBOARD CITAS</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
           
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#miNegocio">EL NEGOCIO</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#servicios">SERVICIOS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#reservas">RESERVA TU CITA</a>
            </li>
          </ul>
        </div>
      </div>
          <a href="index.php" role="button" class="login-boton">Atrás</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>
</header>
<!--End Header & Navbar-->

<!--Main-->
<main>
  <div class="containerII">
    <section class="ceroI" id="home" style="background: linear-gradient(rgba(4,9,30,0.3), rgba(4,9,30,0.3)), url('lib/images/<?= htmlspecialchars($foto_negocio); ?>') no-repeat center;  min-height: 100vh; background-size: cover; width: 100%; position: relative; padding-top: 20vh; padding-bottom: 10vh; flex: 1;">
      <div class="textoHome">
        <h1><?= htmlspecialchars($nombre_negocio); ?></h1>
        <p>La manera más fácil de reservar belleza</p>
        <a href="#servicios" class="home-btn">Ver servicios</a>
        <a href="#reservas" class="home-btn">Reserva tu cita</a>
      </div>
    </section>
    <section class="uno"  id="miNegocio">
        <h2>Negocio: <?= htmlspecialchars($nombre_negocio); ?></h2>
        <div class="accordion">
          <div class="accordion-item">
            <div class="accordion-header">
              <h3>Teléfono</h3>
            </div>
            <div class="accordion-content">
              <p><?= htmlspecialchars($telefono_negocio); ?></p>
            </div>
          </div>
          <div class="accordion-item">
            <div class="accordion-header">
              <h3>Dirección</h3>
            </div>
            <div class="accordion-content">
              <p><?= htmlspecialchars($direccion_negocio); ?></p>
            </div>
          </div>
          <div class="accordion-item">
            <div class="accordion-header">
              <h3>Texto</h3>
            </div>
            <div class="accordion-content">
              <p>Texto</p>
            </div>
          </div>
        </div>
    </section>
    <section class="dos"  id="servicios">
      <div class="container d-flex align-items-center justify-content-center fs-1 text-white flex-column"> 
        <div id="reserva" class="reserva-container">
        <h2>Servicios de <?= htmlspecialchars($nombre_negocio); ?></h2>
        <div class="container">
        <?php if ($servicios && count($servicios) > 0): ?>
          <div class="table-responsive">
              <table class="table table-bordered table-striped">
                  <thead>
                      <tr> 
                          <th>Nombre</th>
                          <th>Descripción</th>
                          <th>Precio</th>
                          <th>Duración</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($servicios as $index => $servicio): ?>
                          <tr>
                              <td><?= htmlspecialchars($servicio['nombre']); ?></td>
                              <td><?= htmlspecialchars($servicio['descripcion']); ?></td>
                              <td><?= number_format($servicio['precio'], 2); ?>€</td>
                              <td><?= htmlspecialchars($servicio['duracion']); ?> minutos</td>
                              <td>
                              <a href="#reservas" class="btn btn-warning btn-sm">Reservar</a>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
            </div>
        <?php else: ?>
            <p>No hay servicios disponibles.</p>
        <?php endif; ?>
    </div>
        </div>
    </div>
    </section>
    <section class="tres"  id="reservas">
    <?= get_mensajes_html_format($mensajes); ?>
      <div class="container d-flex align-items-center justify-content-center fs-1 text-white flex-column"> 
        <h2 id="h2Reserva">Reserva tu cita en <b><?= htmlspecialchars($nombre_negocio); ?></b></h2>
        <h2>Rápido, sencillo y sin necesidad de darte de alta!</h2>
        <div id="reserva" class="reserva-container">
          <form class="reserva-form" method="POST" action="">
              <label for="opcionSelect">Servicios:</label>
                <select id="opcionSelect" name="opcionSelect" required>
                    <option value="" disabled selected>Elige una opción</option>
                    <?php if ($servicios && count($servicios) > 0): ?>
                        <?php foreach ($servicios as $servicio): ?>
                            <option value="<?= htmlspecialchars($servicio['id_servicio']); ?>">
                                <?= htmlspecialchars($servicio['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">No hay servicios disponibles</option>
                    <?php endif; ?>
                </select>
              <label for="fecha">Fecha y hora:</label>
              <div class="fecha-hora-container">
                <input type="text" id="fecha" name="fecha" required>
                <input type="time" id="hora" name="hora" required>
              </div>
              <label for="nombre">Nombre:</label>
              <input type="text" id="nombre" name="nombre" required>
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" required>
              <label for="email">Teléfono:</label>
              <input type="text" id="tlf" name="tlf" required>
              <button type="submit" class="btn btn-primary">Reservar</button>
          </form>
        </div>
    </div>
    </section>
    </section>
    
  </div>
  <a href="#" class="to-top">
    <i class="fa-solid fa-chevron-up"></i>
  </a>
</main>
<!--End Main -->
<script>
    document.querySelectorAll('.accordion-header').forEach(header => {
      header.addEventListener('click', () => {
          const content = header.nextElementSibling;
          const button = header.querySelector('.accordion-button');
    
          content.classList.toggle('show'); // Muestra u oculta el contenido
          button.textContent = button.textContent === '+' ? '-' : '+'; // Cambia el símbolo
      });
    });
    
    const toTop = document.querySelector(".to-top");
    
    window.addEventListener("scroll", () => {
      if(window.scrollY > 100) {
        toTop.classList.add("active");
      }else{
        toTop.classList.remove("active");
      }
    })
    
    
    flatpickr("#fecha", {
            disable: [
                function(date) {
                    // Deshabilitar sábados (6) y domingos (0)
                    return (date.getDay() === 0 || date.getDay() === 6);
                }
            ],
            dateFormat: "Y-m-d", // Formato de fecha
            minDate: "today", // Deshabilitar fechas pasadas
            locale:{
              firstDayOfWeek:1
            }
        });
    
        flatpickr("#hora", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i", // Formato de hora
        altFormat: "h:i", // Formato alternativo para mostrar
        time_24hr: true,
        minTime: "10:00", // Hora mínima
        maxTime: "20:00", // Hora máxima
        minuteIncrement: 30, // Intervalo de minutos
    
        onReady: function() {
            this.calendarContainer.classList.add('custom-timepicker'); // Para estilos personalizados si lo deseas
        }
    });
</script>
    <?php cerrar_conexion($conexion);?>
</body>
</html>