


document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {

      themeSystem: 'bootstrap5',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      locale: 'es',
      //initialDate: '2023-01-12',
      initialDate: '2025-03-16',
      navLinks: true, 
      selectable: true,
      selectMirror: true,
      select: function(arg) {
        var title = prompt('Event Title:');
        if (title) {
          calendar.addEvent({
            title: title,
            start: arg.start,
            end: arg.end,
            allDay: arg.allDay
          })
        }
        calendar.unselect()
      },
      eventClick: function(arg) {
        var event = arg.event;

        //Modal
        document.getElementById('eventTitle').textContent = event.title;
        document.getElementById('eventStart').textContent = event.start.toLocaleString();
        document.getElementById('eventEnd').textContent = event.end ? event.end.toLocaleString() : 'No disponible';
        document.getElementById('eventCliente').textContent = event.extendedProps.nombre_cliente;
        document.getElementById('eventTelefono').textContent = event.extendedProps.telefono_cliente;
        document.getElementById('eventEmail').textContent = event.extendedProps.email_cliente;
        document.getElementById('eventCodigo').textContent = event.extendedProps.codigo_unico;
        document.getElementById('eventEstado').textContent = event.extendedProps.estado;
  
        var modal = new bootstrap.Modal(document.getElementById('eventModal'));
        modal.show();
  
        //Botón de eliminar
        document.getElementById('deleteCitaId').value = event.extendedProps.id_cita;
      },
      editable: false,
      droppable: false,
      dayMaxEvents: true, 
      businessHours: {                   
        daysOfWeek: [1, 2, 3, 4, 5],          // Lunes a viernes 
        startTime: '09:00',                // Hora de inicio y fin del horario comercial
        endTime: '20:00',  
    },
    minTime: "09:00:00",               
    maxTime: "20:00:00", 
       
    events: eventos, 
    eventColor: 'lightblue', 
    });

    calendar.render();
  });
