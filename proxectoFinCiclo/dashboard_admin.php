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
crear_bd_bookBeauty($conexion);
seleccionar_bd_bookBeauty($conexion);
crear_tabla_administrador($conexion);

//Obtengo el ID del administrador loggeado para mostrar los datos de su negocio
$id_administrador = $_SESSION['id_administrador'];
$negocio = datos_negocio($conexion, $id_administrador);

//Obtengo  datos de los servicios del negocio del administrador loggeado
$servicios = datos_servicios($conexion, $id_administrador);

if($negocio === null){
  $nombre_negocio = "No tienes negocio";
  $id_negocio = " ";
  $telefono_negocio = " ";
}else{
  $id_negocio = $negocio['id_negocio'];
  $nombre_negocio = $negocio['nombre'];
  $telefono_negocio = $negocio['telefono'];
  $direccion_negocio = $negocio['direccion'];
  $descripcion_negocio = $negocio['descripcion'];
  $email_negocio = $negocio['email'];
}

$citas = get_citas_negocio($conexion, $id_negocio);


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


if (isset($_POST['delete_cita_id'])) {
  $id_cita = $_POST['delete_cita_id'];

  if (is_numeric($id_cita)) {
    if (deleteCita($conexion, $id_cita)) {
      echo "<script>alert('Cita eliminada con éxito');</script>";
    } else {
      echo "<script>alert('Hubo un error al eliminar la cita');</script>";
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
    Email: a22blancapv@iessanclemente.net
-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona administrador</title>
<!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
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
      <a class="navbar-brand me-auto" href="#">Book<b>Beauty</b></a>
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
        <h2><?= htmlspecialchars($nombre_negocio); ?></h2>
        <div class="accordion">
          <div class="accordion-item">
            <div class="accordion-header">
              <h3>Teléfono y email</h3>
            </div>
            <div class="accordion-content">
              <p><?= htmlspecialchars($telefono_negocio); ?></p>
              <p><?= htmlspecialchars($email_negocio); ?></p>
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
              <h3>Descripción</h3>
            </div>
            <div class="accordion-content">
              <p><?= htmlspecialchars($descripcion_negocio); ?></p>
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
                              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" onclick="cargarDatosServicio(<?= $servicio['id_servicio']; ?>)">Editar</button>

                              <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="editModalLabel">Editar Servicio</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <form id="formularioServicios" method="POST" action="editarServicio.php">
                                        <input type="hidden" id="editServicioId" name="id_servicio">
                                        <div class="mb-3">
                                          <label for="editNombre" class="form-label">Nombre</label>
                                          <input type="text" class="form-control" id="editNombre" name="nombre" required>
                                        </div>
                                        <div class="mb-3">
                                          <label for="editDescripcion" class="form-label">Descripción</label>
                                          <textarea class="form-control" id="editDescripcion" name="descripcion" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                          <label for="editPrecio" class="form-label">Precio</label>
                                          <input type="number" class="form-control" id="editPrecio" name="precio" step="0.01" required>
                                        </div>
                                        <div class="mb-3">
                                          <label for="editDuracion" class="form-label">Duración (minutos)</label>
                                          <input type="number" class="form-control" id="editDuracion" name="duracion" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
              <div class="text-center mt-4">
                  <a href="addServicio.php" class="btn btn-primary">Añadir nuevo servicio</a>
              </div>
            </div>
        <?php else: ?>
            <p>No hay servicios disponibles.</p>
        <?php endif; ?>
    </div>
        </div>
    </div>
    </section>
    <section class="cuatro" id="opcionesI">
 

    <div id="calendar"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src='js/index.global.min.js'></script>
    <script src="js/bootstrap5/index.global.min.js"></script>
    <script src='js/core/locales-all.global.min.js'></script>

        <!-- 
      <section id="opciones">
        <h2>Mis citas</h2>
        <div class="container">
      <?php 
        $eventos = [];


        foreach($citas as $cita){
          $eventos[] = [
            'title' => $cita['servicio_nombre'],
            'start' => $cita['fecha'],
            'end' => $cita['fecha_final'],
            'extendedProps' => [
              'id_cita' => $cita['id'],
              'nombre_cliente' => $cita['nombre_cliente'],
              'telefono_cliente' => $cita['tlf_cliente'],
              'email_cliente' => $cita['email_cliente'],
              'codigo_unico' => $cita['codigo_unico'],
              'estado' => $cita['estado']
                 ]
            ];
        }
      ?>
      
    </div>
        </section>
        -->
    <!-- Modal para ver CITAS -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="eventModalLabel">Detalles de la cita:</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Aquí se cargarán los datos del evento -->
            <p><strong>Servicio:</strong> <span id="eventTitle"></span></p>
            <p><strong>Fecha:</strong> <span id="eventStart"></span> a <span id="eventEnd"></span></p>
            <p><strong>Cliente:</strong> <span id="eventCliente"></span></p>
            <p><strong>Teléfono:</strong> <span id="eventTelefono"></span></p>
            <p><strong>Email:</strong> <span id="eventEmail"></span></p>
            <p><strong>Código único:</strong> <span id="eventCodigo"></span></p>
            <p><strong>Estado:</strong> <span id="eventEstado"></span></p>
          </div>
          <div class="modal-footer">
            <form id="formulario-delete" action="dashboard_admin.php" method="POST">
                <input type="hidden" id="deleteCitaId" name="delete_cita_id">
                <button type="submit" class="btn btn-danger">Eliminar</button>
              </form>
                <button type="button" class="btn btn-warning" id="editEventBtn">Editar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

  <!-- Modal para editar CITAS -->
    <div class="modal fade" id="editCitaModal" tabindex="-1" aria-labelledby="editCitaModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editCitaModalLabel">Editar Cita</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="formulario" action="editarCita.php" method="POST">
              <input type="hidden" id="editCitaId" name="id_cita">
              <div class="mb-3">
                  <label for="editCitaServicio" class="form-label">Servicios:</label>
                  <select class="form-control" id="editCitaServicio" name="id_servicio" required>
                      <option value=""disabled selected>Seleccione un servicio</option>
                      <?php
                      $servicios = datos_servicios($conexion, $id_administrador);
                      foreach ($servicios as $servicio) {
                          echo "<option value='" . $servicio['id_servicio'] . "' " . ($servicio['id_servicio'] == $evento['id_servicio'] ? 'selected' : '') . ">" . htmlspecialchars($servicio['nombre']) . "</option>";
                      }
                      ?>
                  </select>
              </div>
              <div class="mb-3">
                <label for="editCitaFecha" class="form-label">Fecha</label>
                <input type="datetime-local" class="form-control" id="editCitaFecha" name="fecha" required>
              </div>
              <div class="mb-3">
                <label for="editCitaCliente" class="form-label">Cliente</label>
                <input type="text" class="form-control" id="editCitaCliente" name="cliente" required>
              </div>
              <div class="mb-3">
                <label for="editCitaTelefono" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" id="editCitaTelefono" name="telefono" required>
              </div>
              <div class="mb-3">
                <label for="editCitaEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="editCitaEmail" name="email" required>
              </div>
              <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </form>
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
<!--Footer -->
<footer>
  <div class="footerBottom">
      <p><small>Copyright &copy;2025; Diseñado por <span class="designer">Blanca Penabad Villar</span></small></p>
    </div>
</footer>
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
    

    function cargarDatosServicio(idServicio) {
    var servicios = <?php echo json_encode($servicios); ?>;
    var servicio = servicios.find(s => s.id_servicio === idServicio);
    
    if (servicio) {
        document.getElementById('editServicioId').value = servicio.id_servicio;
        document.getElementById('editNombre').value = servicio.nombre;
        document.getElementById('editDescripcion').value = servicio.descripcion;
        document.getElementById('editPrecio').value = servicio.precio;
        document.getElementById('editDuracion').value = servicio.duracion;
    }
}
   document.getElementById('editEventBtn').addEventListener('click', function() {
    var citaId = document.getElementById('deleteCitaId').value; 
    var evento = eventos.find(evento => evento.extendedProps.id_cita == citaId); 

    if (evento) {
        document.getElementById('editCitaId').value = evento.extendedProps.id_cita;
        document.getElementById('editCitaServicio').value = evento.title;
        document.getElementById('editCitaFecha').value = evento.start;
        document.getElementById('editCitaCliente').value = evento.extendedProps.nombre_cliente;
        document.getElementById('editCitaTelefono').value = evento.extendedProps.telefono_cliente;
        document.getElementById('editCitaEmail').value = evento.extendedProps.email_cliente;

        new bootstrap.Modal(document.getElementById('editCitaModal')).show();
    }
});

</script>
<script>  var eventos = <?php echo json_encode($eventos); ?>; </script>
<script src='js/custom.js'></script>
<script>
   document.addEventListener("DOMContentLoaded", function() {
    let formulario = document.getElementById("formulario");

    formulario.addEventListener("submit", function(event) {
        event.preventDefault();
        let errores = [];

        let idServicio = document.getElementById("editCitaServicio");
        let fecha = document.getElementById("editCitaFecha");
        let cliente = document.getElementById("editCitaCliente");
        let telefono = document.getElementById("editCitaTelefono");
        let email = document.getElementById("editCitaEmail");

        let idServicioValor = idServicio.value.trim();
        let fechaValor = fecha.value.trim();
        let clienteValor = cliente.value.trim();
        let telefonoValor = telefono.value.trim();
        let emailValor = email.value.trim();

        let patronNombre = /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]{1,50}$/;
        let patronTlf = /^\d{9,15}$/;
        let patronEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        document.querySelectorAll(".is-invalid").forEach(el => el.classList.remove("is-invalid"));

        if (idServicioValor === "") {
            errores.push("Debe seleccionar un servicio.");
            idServicio.classList.add("is-invalid");
        }

        if (fechaValor === "") {
            errores.push("Debe ingresar una fecha válida.");
            fecha.classList.add("is-invalid");
        }

        if (!patronNombre.test(clienteValor)) {
            errores.push("Nombre inválido. Solo letras y máximo 50 caracteres.");
            cliente.classList.add("is-invalid");
        }

        if (!patronTlf.test(telefonoValor)) {
            errores.push("Teléfono inválido. Debe tener entre 9 y 15 dígitos numéricos.");
            telefono.classList.add("is-invalid");
        }

        if (emailValor !== "" && !patronEmail.test(emailValor)) {
            errores.push("Correo electrónico inválido.");
            email.classList.add("is-invalid");
        }

        if (errores.length > 0) {
            alert(errores.join("\n"));
            return;
        }

        let formData = new FormData(formulario);
        fetch("editarCita.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.mensajes.join("\n"));
            } else {
                alert("Cita actualizada con éxito.");
                location.reload();
            }
        })
        .catch(error => console.error("Error en la petición:", error));
    });
});
</script>

    <?php cerrar_conexion($conexion);?>
</body>
</html>