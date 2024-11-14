<?php

//Link descargar FULLCALENDAR calendario: https://www.youtube.com/watch?v=Nb_04gx20-A
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
crear_bd_gestorCitas($conexion);
seleccionar_bd_gestorCitas($conexion);
crear_tabla_administrador($conexion);

//Obtengo el ID del administrador loggeado para mostrar los datos de su negocio
$id_administrador = $_SESSION['id_administrador'];
$negocio = datos_negocio($conexion, $id_administrador);

//Obtengo  datos de los servicios del negocio del administrador loggeado
$servicios = datos_servicios($conexion, $id_administrador);

if($negocio === null){
  $nombre_negocio = "No tienes negocio";
  $telefono_negocio = " ";
}else{
  $nombre_negocio = $negocio['nombre'];
  $telefono_negocio = $negocio['telefono'];
  $direccion_negocio = $negocio['direccion'];
}


if (isset($_GET['delete_servicio'])) {
  $id_servicio = $_GET['delete_servicio'];

  if (is_numeric($id_servicio)) {

      if (deleteServicio($conexion, $id_servicio)) {
          echo "<script>alert('Servicio eliminado con éxito');</script>";
      } else {
          echo "<script>alert('Hubo un error al eliminar el servicio');</script>";
      }
      header("Location: dashboard_admin.php");
      exit();
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
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          locale:"es"
        });
        calendar.render();
      });
    </script>
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
              <a class="nav-link mx-lg-2" href="#miNegocio">MI NEGOCIO</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#servicios">MIS SERVICIOS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#opcionesI">MIS CITAS</a>
            </li>
          </ul>
        </div>
      </div>
          <a href="dashboard_admin.php?logout=true" role="button" class="login-boton">Cerrar sesión</a>
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
    <section class="cero" id="home">
      <div class="textoHome">
        <h1>Administradores</h1>
        <p>Zona restringida administradores</p>
        <a href="#servicios" class="home-btn">Mis servicios</a>
        <a href="#opcionesI" class="home-btn">Mis citas</a>
      </div>
    </section>
    <section class="dos"  id="miNegocio">
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
        <section class="analisis-datos">
          <div class="iconos">
            <div class="icono">
              <i class="fa-solid fa-gear"></i>
              <h4>EFICIENCIA</h4>
              <p>Texto</p>
            </div>
            <div class="icono">
              <i class="fa-solid fa-hand-holding-hand"></i>
              <h4>FIABILIDAD</h4>
              <p>Texto</p>
            </div>
            <div class="icono">
              <i class="fa-solid fa-clock"></i>        
              <h4>AHORRO DE TIEMPO</h4>
              <p>Texto</p>
            </div>
          </div>
        </section> 
    </section>
    <section class="tres"  id="servicios">
      <div class="container d-flex align-items-center justify-content-center fs-1 text-white flex-column"> 
        <h2 id="h2Reserva">Gestiona tus <b>SERVICIOS</b></h2>
        <div id="reserva" class="reserva-container">
        <h2>Servicios del Negocio</h2>
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
                              <form id="formulario-delete" action="dashboard_admin.php" method="get" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este servicio?');">
                                  <input type="hidden" name="delete_servicio" value="<?= $servicio['id_servicio']; ?>">
                                  <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                              </form>
                              <button class="btn btn-warning btn-sm">Editar</button>
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
    <section class="cuatro" id="opcionesI">
    <script src='js/index.global.min.js'></script>
    <script src='js/core/locales-all.global.min.js'></script>
    <script src='js/custom.js'></script>

    <div id="calendar"></div>
        <!-- 
      <section id="opciones">
        <h2>Mis citas</h2>
        <div class="container">
      <?php 
        $citas = get_citas_negocio($conexion, $id_administrador);
        if (count($citas) > 0): 
      ?>
        <div class="table-responsive">
          <table class="table-citas table-bordered table-striped">
            <thead>
              <tr>
                <th>Servicio</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Código único</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($citas as $cita): ?>
                <tr>
                  <td><?= htmlspecialchars($cita['servicio_nombre']); ?></td>
                  <td><?= date("d/m/Y H:i", strtotime($cita['fecha'])); ?></td>
                  <td><?= htmlspecialchars($cita['nombre_cliente']); ?></td>
                  <td><?= htmlspecialchars($cita['email_cliente']); ?></td>
                  <td><?= htmlspecialchars($cita['tlf_cliente']); ?></td>
                  <td><?= htmlspecialchars($cita['codigo_unico']); ?></td>
                  <td>
                    <span class="badge bg-<?= ($cita['estado'] === 'confirmada') ? 'primary' : ($cita['estado'] === 'cancelada' ? 'danger' : 'success') ?>">
                      <?= ucfirst($cita['estado']); ?>
                    </span>
                  </td>
                  <td>
                  <button class="btn btn-warning btn-sm">Editar</button>
                  <button class="btn btn-danger btn-sm">Eliminar</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p>No hay citas programadas.</p>
      <?php endif; ?>
    </div>
        </section>
        -->
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