<?php
include "lib/bd/base_datos.php";
include "lib/bd/utilidades.php";


$conexion = get_conexion();
crear_bd_gestorCitas($conexion);
seleccionar_bd_gestorCitas($conexion);
crear_tabla_administrador($conexion);
crear_tabla_negocios($conexion);
crear_tabla_servicios($conexion);
crear_tabla_citas($conexion);


$negocios = nombres_negocios($conexion);


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
    <title>Gestor Citas</title>
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
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">GESTOR CITAS</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#sobrenosotros">NEGOCIOS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#beneficios">BENEFICIOS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#reserva">RESERVA TU CITA</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#opcionesI">OPCIONES</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#contacto">CONTACTO</a>
            </li>
          </ul>
        </div>
      </div>
          <a href="login.php" class="login-boton">Iniciar sesión como admin</a>
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
        <h1>GESTOR CITAS - Reserva servicios de belleza y bienestar</h1>
        <p>Reserva servicios de belleza y bienestar en Santiago de Compostela</p>
        <a href="#sobrenosotros" class="home-btn">Saber más</a>
      </div>
    </section>
    <section class="uno" id="sobrenosotros">
      <h2>Negocios que ya trabajan con nosotros</h2>
      <ul>
        <?php
        // Mostrar los nombres de los negocios en una lista
        if ($negocios) {
            foreach ($negocios as $negocio) {
                echo "<li><a href='negocios.php?id_negocio=". $negocio['id_negocio'] ."'  >" . htmlspecialchars($negocio['nombre']) . "</a></li>";
            }
        } else {
            echo "<li>No hay negocios registrados.</li>";
        }
        ?>
      </ul>
    </section>
    <section class="dos"  id="beneficios">
        <h2>BENEFICIOS</h2>
        <div class="accordion">
          <div class="accordion-item">
            <div class="accordion-header">
              <h3>Texto</h3>
            </div>
            <div class="accordion-content">
              <p>Texto</p>
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
    <section class="tres"  id="reserva">
      <div class="container d-flex align-items-center justify-content-center fs-1 text-white flex-column"> 
        <h2 id="h2Reserva">Reserva tu <b>CITA</b></h2>
        <h2>Rápido, sencillo y sin necesidad de darte de alta!</h2>
        <div id="reserva" class="reserva-container">
          <form class="reserva-form">
               <!--FALTA AÑADIR EL SELECT DE SERVICIOS-->
              <label for="opcionSelect">Servicios:</label>
                <select id="opcionSelect" name="opcionSelect" required>
                    <option value="" disabled selected>Elige una opción</option>
                    <option value="opcion1">Balayage</option>
                    <option value="opcion2">Babylights</option>
                    <option value="opcion3">Tinte</option>
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
    <section class="cuatro" id="opcionesI">
      <section id="opciones">
        <h2>Elige tu opción...</h2>
        <div class="contenedor">
            <div class="opcion">
                <h3>BÁSICO</h3>
                <p>TextoTextoTextoTextoTextoTexto
                  TextoTextoTextoTextoTexto</p>
                <ul>
                    <li>Texto</li>
                    <li>Texto</li>
                    <li>Texto</li>
                </ul>
            </div>
            <div class="opcion">
                <h3>AVANZADO</h3>
                <p>Integración con el HPM y
                  fijación AUTOMÁTICA de precios</p>
                <ul>
                    <li>Texto</li>
                    <li>Texto</li>
                    <li>Texto</li>
                </ul>
            </div>
        </div>
        <section class="masDatos"></section>
          <div class="iconosI">
            <div class="iconoI">
              <i class="fa-solid fa-tag"></i>
              <h4>PRECIO </br> CITA</h4>
              <h3>+30%</h3>
            </div>
            <div class="iconoI">
              <i class="fa-solid fa-bed"></i>
              <h4>TEXTO</h4>
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
    <section class="cinco"  id="contacto">
      <div class="container d-flex align-items-center justify-content-center fs-1 text-white flex-column"> 
        <h2>¡Contacta con nosotros!</h2>
        <div class="contactInfo">
          <div class="box">
            <div class="icon"><i class="fa-solid fa-map-pin"></i></div>
              <div class="text">
                <h3>Visítenos y hablemos</h3>
                <p>Puedes pasarte por nuestras instalaciones en Polígono Costa Vella, Rúa da República Checa, 23-25, 15707 Santiago de Compostela, La Coruña y te informaremos de todos los servicios que disponemos.</p>
              </div>
          </div>
          <div class="box">
            <div class="icon"><i class="fa-solid fa-phone"></i></div>
              <div class="text">
                <h3>Llámanos</h3>
                <p>Ponte en contacto con nosotros llamando al (+34) 999 888 777</p>
              </div>
          </div>
          <div class="box">
            <div class="icon"><i class="fa-solid fa-envelope"></i></div>
              <div class="text">
                <h3>Envíanos un email a <a href="mailto:optiprize@optiprize.com">GESTORCITAS@GESTORCITAS.com</a></h3>
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
        <li><a href="#sobrenosotros">Sobre nosotros</a></li>
        <li><a href="#beneficios">Beneficios</a></li>
        <li><a href="#reserva">Haz tu reserva</a></li>
        <li><a href="#opciones">Opciones</a></li>
        <li><a href="#contacto">Contacto</a></li>
      </ul>
    </div>
  </div>
  <div class="footerBottom">
      <p><small>Copyright &copy;2024; Diseñado por <span class="designer">Blanca Penabad Villar</span></small></p>
    </div>
</footer>
<?php cerrar_conexion($conexion);?>

<!-- End Footer -->

<!--Bootstrap JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

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
</body>
</html>