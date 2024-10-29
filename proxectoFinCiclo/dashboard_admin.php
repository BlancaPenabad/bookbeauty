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
crear_bd_gestorCitas($conexion);
seleccionar_bd_gestorCitas($conexion);
crear_tabla_administrador($conexion);

//Obtengo el ID del administrador loggeado para mostrar los datos de su negocio
$id_administrador = $_SESSION['id_administrador'];
$negocio = datos_negocio($conexion, $id_administrador);

if($negocio === null){
  $nombre_negocio = "No tienes negocio";
  $telefono_negocio = " ";
}else{
  $nombre_negocio = $negocio['nombre'];
  $telefono_negocio = $negocio['telefono'];
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
              <a class="nav-link mx-lg-2" href="#miNegocio">MI NEGOCIO</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#citas">MIS CITAS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#opcionesI">MIS SERVICIOS</a>
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
        <a href="#citas" class="home-btn">Mis citas</a>
        <a href="#opciones" class="home-btn">Mis servicios</a>
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
              <h3>Aumento de beneficios y rentabilidad</h3>
            </div>
            <div class="accordion-content">
              <p>Al implementar OptiPrice, los hoteleros pueden experimentar un aumento promedio del 14% en sus beneficios anuales vinculados a las reservas. La herramienta facilita la gestión de tarifas, liberando tiempo para que los gestores se enfoquen en mejorar otros aspectos del servicio, lo que impacta positivamente en la calidad y satisfacción del cliente. </p>
            </div>
          </div>
        
          <div class="accordion-item">
            <div class="accordion-header">
              <h3>Integración y facilidad de uso</h3>
            </div>
            <div class="accordion-content">
              <p>OptiPrice se integra fácilmente con la mayoría de los sistemas de gestión hotelera (PMS) y plataformas de venta online, permitiendo una actualización diaria de precios sin intervención manual. Su panel intuitivo permite a los usuarios monitorear el rendimiento de precios y obtener informes analíticos personalizados, lo que facilita la toma de decisiones informadas.</p>
            </div>
          </div>
        </div>
        <section class="analisis-datos">
          <div class="iconos">
            <div class="icono">
              <i class="fa-solid fa-gear"></i>
              <h4>EFICIENCIA</h4>
              <p>Optimización de la gestión eliminando aquellas tareas sin valor añadido.</p>
            </div>
            <div class="icono">
              <i class="fa-solid fa-hand-holding-hand"></i>
              <h4>FIABILIDAD</h4>
              <p>Prescripción automática de precios en base al comportamiento real de la demanda.</p>
            </div>
            <div class="icono">
              <i class="fa-solid fa-clock"></i>        
              <h4>AHORRO DE TIEMPO</h4>
              <p>Redución de horas dedicadas a la asignación manual de precios.</p>
            </div>
          </div>
        </section>
        
    </section>
    <section class="tres"  id="citas">
      <div class="container d-flex align-items-center justify-content-center fs-1 text-white flex-column"> 
        <h2 id="h2Reserva">Gestiona tus <b>CITAS</b></h2>
        <div id="reserva" class="reserva-container">
          <p>AQUÍ IRÁ UNA TABLA CON LAS CITAS DE UN NEGOCIO CONCRETO. HABRÁ OPCIÓN DE AÑADIR, BORRAR Y EDITAR.</p>
        </div>
    </div>
    </section>
    <section class="cuatro" id="opcionesI">
      <section id="opciones">
        <h2>Elige tu opción...</h2>
        <div class="contenedor">
            <div class="opcion">
                <h3>BÁSICO</h3>
                <p>Copilot de apoyo a la toma de
                  decisiones disponible en la nube</p>
                <ul>
                    <li>No requiere instalación de ningun hardware</li>
                    <li>Se requiere del histórico de datos de reservas y cancelaciones de 2 últimos años</li>
                    <li>Necesario compartir los precios actuales ofertados</li>
                </ul>
            </div>
            <div class="opcion">
                <h3>AVANZADO</h3>
                <p>Integración con el HPM y
                  fijación AUTOMÁTICA de precios</p>
                <ul>
                    <li>No requiere instalación de ningun hardware</li>
                    <li>Integración con su HMP (e.g., Hotelgest) para fijación automatizada de precios</li>
                    <li>Se requiere un análisis específico para integración con HMP</li>
                </ul>
            </div>
        </div>
        <section class="masDatos"></section>
          <div class="iconosI">
            <div class="iconoI">
              <i class="fa-solid fa-tag"></i>
              <h4>PRECIO </br> HABITACIÓN</h4>
              <h3>+30%</h3>
            </div>
            <div class="iconoI">
              <i class="fa-solid fa-bed"></i>
              <h4>OCUPACIÓN</h4>
              <h3>+15%</h3>

            </div>
            <div class="iconoI">
              <i class="fa-solid fa-user-tie"></i>     
              <h4>TAREAS ADMIN.</h4>
              <h3>-8h/mes</h3>
            </div>
          </div>
        </section>
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