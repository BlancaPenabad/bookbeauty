<?php

include "lib/bd/base_datos.php";
include "lib/bd/utilidades.php";


$conexion = get_conexion();
seleccionar_bd_bookBeauty($conexion);
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
  $descripcion_negocio = $negocio['descripcion'];
  $email_negocio = $negocio['email'];
  $foto_negocio = $negocio['foto_negocio'];
}

/* VALIDACIONES */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!empty($_POST['opcionSelect']) && is_numeric($_POST['opcionSelect'])) {
      $id_servicio = $_POST['opcionSelect'];
  } else {
      $mensajes[] = array("error", "Selecciona un servicio válido.");
  }

  if (!empty($_POST['fecha']) && !empty($_POST['hora'])) {
      $fecha = $_POST['fecha'] . ' ' . $_POST['hora'];
  } else {
      $mensajes[] = array("error", "Selecciona una fecha y hora válidas.");
  }

  if (!empty($_POST['nombre']) && is_string($_POST['nombre']) && strlen($_POST['nombre']) <= 255) {
      $nombre_cliente = htmlspecialchars($_POST['nombre']);
  } else {
      $mensajes[] = array("error", "Introduce un nombre válido (máx. 255 caracteres).");
  }

  if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && strlen($_POST['email']) <= 255) {
      $email_cliente = htmlspecialchars($_POST['email']);
  } else {
      $mensajes[] = array("error", "Introduce un email válido (máx. 255 caracteres).");
  }

  if (!empty($_POST['tlf']) && is_numeric($_POST['tlf'])) {
      $tlf_cliente = $_POST['tlf'];
  } else {
      $mensajes[] = array("error", "Introduce un número de teléfono válido (máx. 9 dígitos).");
  }

  if (empty($mensajes)) {
      $codigo_unico = 'CITA' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

      $resultado = addCita($conexion, $id_servicio, $fecha, $nombre_cliente, $email_cliente, $tlf_cliente, $codigo_unico);

      if ($resultado) {
          $mensajes[] = array("success", "Tu cita se ha registrado correctamente. ¡Gracias!");

          enviarCorreoConfirmacion($email_cliente, $nombre_cliente, $nombre_negocio, $fecha, $codigo_unico);
          enviarCorreoConfirmacionNegocio($email_negocio, $nombre_cliente, $nombre_negocio, $fecha, $codigo_unico, $servicio_nombre);

          header('Location: cita_confirmada.php?id_servicio=' . urlencode($id_servicio) . '&fecha=' . urlencode($fecha) . '&nombre_cliente=' . urlencode($nombre_cliente) . '&email_cliente=' . urlencode($email_cliente) . '&tlf_cliente=' . urlencode($tlf_cliente) . '&codigo_unico=' . urlencode($codigo_unico));
          exit;
      } else {
          $mensajes[] = array("error", "Ha ocurrido un error al registrar tu cita.");
      }
  }
}


$citas_ocupadas = get_horas_negocio($conexion, $id_negocio);

$horas_ocupadas = [];
foreach ($citas_ocupadas as $cita) {
    $fecha_ocupada = new DateTime($cita['fecha']);
    $fecha_ocupada_fin = new DateTime($cita['fecha_final']); // Usar la fecha final calculada

    while ($fecha_ocupada <= $fecha_ocupada_fin) {
        $horas_ocupadas[] = [
            'fecha' => $fecha_ocupada->format('Y-m-d'),
            'hora' => $fecha_ocupada->format('H:i') // Formato HH:MM
        ];
        $fecha_ocupada->modify('+30 minutes'); // Intervalo de 30 minutos
    }
}

$horas_ocupadas_json = json_encode($horas_ocupadas);


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
      <a class="navbar-brand me-auto" href="index.php">Book<b>Beauty</b></a>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">DASHBOARD CITAS</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
           
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#miNegocio">NUESTRO NEGOCIO</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#servicios">SERVICIOS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#reservas">RESERVA TU CITA</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#contacto">CONTACTO</a>
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
        <a href="#servicios" class="home-btn">Ver servicios</a>
        <a href="#reservas" class="home-btn">Reserva tu cita</a>
      </div>
    </section>
    <section class="uno"  id="miNegocio">
        <h2><?= htmlspecialchars($nombre_negocio); ?></h2>
        <div class="accordion">
          <div class="accordion-item">
            <div class="accordion-header">
              <h3>¿Quienes somos?</h3>
            </div>
            <div class="accordion-content">
              <p><?= htmlspecialchars($descripcion_negocio); ?></p>
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
              <h3>Teléfono y email</h3>
            </div>
            <div class="accordion-content">
              <p><?= htmlspecialchars($telefono_negocio); ?></p>
              <p><?= htmlspecialchars($email_negocio); ?></p>
            </div>
          </div>
        </div>
    </section>
    <section class="dos"  id="servicios">
      <div class="container d-flex align-items-center justify-content-center fs-1 text-white flex-column"> 
        <div id="reserva" class="reserva-container">
        <h2>Nuestros servicios</h2>
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
                <?php $citas_ocupadas = get_horas_negocio($conexion, $id_negocio);
                ?>
              <label for="fecha">Fecha y hora:</label>
              <div class="fecha-hora-container">
                <input type="text" class="form-control" id="fecha" name="fecha" required>
                <input type="text" class="form-control" id="hora" name="hora" list="horasDisponibles" required>
                <datalist id="horasDisponibles">
                    <!-- Las opciones se generarán dinámicamente -->
                </datalist>
              </div>
              <label for="nombre">Nombre:</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
              <label for="email">Email:</label>
              <input type="email" class="form-control" id="email" name="email" required>
              <label for="tlf">Teléfono:</label>
              <input type="text" class="form-control" id="tlf" name="tlf" required>
              <button type="submit" name="submit" class="btn btn-primary">Reservar</button>
              <?= get_mensajes_html_format($mensajes); ?>

          </form>
        </div>
    </div>
    </section>
    <section class="cinco"  id="contacto">
      <div class="container d-flex align-items-center justify-content-center fs-1 text-white flex-column"> 
        <h2>¡Contacta con nosotros!</h2>
        <div class="contactInfo">
          <div class="box">
            <div class="icon"><i class="fa-solid fa-map-pin"></i></div>
              <div class="text">
                <h3>Visítenos y hablemos</h3>
                <p>Puedes pasarte por nuestras instalaciones en <?= htmlspecialchars($direccion_negocio); ?> y te informaremos de todos los servicios que disponemos.</p>
              </div>
          </div>
          <div class="box">
            <div class="icon"><i class="fa-solid fa-phone"></i></div>
              <div class="text">
                <h3>Llámanos</h3>
                <p>Ponte en contacto con nosotros llamando al <?= htmlspecialchars($telefono_negocio); ?></p>
              </div>
          </div>
          <div class="box">
            <div class="icon"><i class="fa-solid fa-envelope"></i></div>
              <div class="text">
                <h3>Envíanos un email a <a href="mailto:<?= htmlspecialchars($email_negocio)?>"><?= htmlspecialchars($email_negocio); ?></a></h3>
              </div>
          </div>
          <div class="box">
            <div class="icon"><i class="fa-brands fa-instagram"></i></div>
              <div class="text">
                <h3>Síguenos en instagram y no te pierdas las últimas novedades</h3>
              </div>
          </div>
        </div>
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
        <li><a href="#miNegocio">Nuestro negocio</a></li>
        <li><a href="#servicios">Servicios</a></li>
        <li><a href="#reservas">Reserva tu cita</a></li>
      </ul>
    </div>
  </div>
  <div class="footerBottom">
      <p><small>Copyright &copy;2025; Diseñado por <span class="designer">Blanca Penabad Villar</span></small></p>
    </div>
</footer>
<?php cerrar_conexion($conexion);?>

<!-- End Footer -->
<script>
    document.querySelectorAll('.accordion-header').forEach(header => {
      header.addEventListener('click', () => {
          const content = header.nextElementSibling;
          const button = header.querySelector('.accordion-button');
    
          content.classList.toggle('show'); 
          button.textContent = button.textContent === '+' ? '-' : '+'; 
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
                    
                    return (date.getDay() === 0 || date.getDay() === 6);
                }
            ],
            dateFormat: "Y-m-d",
            minDate: "today", 
            locale:{
              firstDayOfWeek:1
            }
        });
    

</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const horasOcupadas = <?= $horas_ocupadas_json; ?>; 
    const inputHora = document.getElementById("hora");
    const datalist = document.getElementById("horasDisponibles");

    function actualizarHorasDisponibles() {
        const fechaSeleccionada = document.getElementById("fecha").value;
        if (!fechaSeleccionada) return; 

        const horasOcupadasFecha = horasOcupadas
            .filter(hora => hora.fecha === fechaSeleccionada)
            .map(hora => hora.hora);

        datalist.innerHTML = '';

        const horaInicio = new Date(`${fechaSeleccionada} 10:00`);
        const horaFin = new Date(`${fechaSeleccionada} 20:00`);
        const intervalo = 30; 

        while (horaInicio <= horaFin) {
            const horaFormateada = horaInicio.toLocaleTimeString('es-ES', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }); 

            if (!horasOcupadasFecha.includes(horaFormateada)) {
                const option = document.createElement("option");
                option.value = horaFormateada;
                option.textContent = horaFormateada;
                datalist.appendChild(option);
            }
            horaInicio.setMinutes(horaInicio.getMinutes() + intervalo);
        }
    }

    document.getElementById("fecha").addEventListener("change", actualizarHorasDisponibles);

    actualizarHorasDisponibles();
});
</script>
 <!--Bootstrap JS-->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <?php cerrar_conexion($conexion);?>
</body>
</html>