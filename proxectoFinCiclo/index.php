<?php
include "lib/bd/base_datos.php";
include "lib/bd/utilidades.php";


$conexion = get_conexion();
crear_bd_bookBeauty($conexion);
seleccionar_bd_bookBeauty($conexion);
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
    <title>BookBeauty</title>
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
      <a class="navbar-brand me-auto" href="#">Book<b>Beauty</b></a>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">BookBeauty</h5>
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
              <a class="nav-link mx-lg-2" href="#reserva">CONSULTA TU CITA</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#opcionesI">OPCIONES</a>
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
        <h1>BookBeauty - Reserva servicios de belleza y bienestar</h1>
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
        <h2 id="h2Reserva">Consulta tu <b>CITA</b></h2>
        <h2>Ingresa el código único para consultar tus datos.</h2>
        <div id="reserva" class="reserva-container">
          <form action="consultaCita.php" method="GET" class="reserva-form">
              <label for="codigo_unico">Código de la cita:</label>
              <input type="text" id="codigo_unico" name="codigo_unico" required>
              <button type="submit" class="btn btn-primary">Consultar cita</button>
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
    </div>
  <a href="#" class="to-top">
    <i class="fa-solid fa-chevron-up"></i>
  </a>
</main>
<!--End Main -->

<!-- Footer -->
<footer>
  <div class="footerBottom">
      <p><small>Copyright &copy;2025; Diseñado por <span class="designer">Blanca Penabad Villar</span></small></p>
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