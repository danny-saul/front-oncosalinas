let calendar = null;
_init();

function _init() {
    cargarDoctorH();
    cargarPaciente();
    // cancelarCita();
    $('#select-doctor-ver').on('change', function () {
        const doctorId = $(this).val();
        if (doctorId) {
            cargarHorariosDoctor(doctorId);
        }
    });

    selectServicios();

    agregar_servicios();
}

function cargarDoctorH() {
   peticionJWT({
        url: urlServidor + 'doctor/listardoctor',
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            const token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                let data = response.doctor.map(element => ({
                    id: element.id,
                    text: element.persona.nombre + ' ' + element.persona.apellido + ' - ' + element.persona.cedula
                }));
                $('#select-doctor-ver').select2({ data });

            }
        },
        error: function () {
            console.log('Error al cargar doctores');
        }
    });
}

/* function cargarHorariosDoctor(doctorId) {
   peticionJWT({
        url: urlServidor + 'doctor_horario/obtenerhoras/' + doctorId,
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            const token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                let intervalo = response.intervalo || '00:30:00';
                let rangos = response.rangos;

                // Destruir calendario si ya existe
                if (calendar !== null) {
                    calendar.destroy();
                    document.getElementById('calendario').innerHTML = ''; // Limpiar HTML del calendario
                }

                // Crear calendario nuevo con intervalo y eventos
                calendar = new FullCalendar.Calendar(document.getElementById('calendario'), {
                    initialView: 'timeGridWeek',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    allDaySlot: false,
                    locale: 'es',
                    slotMinTime: "07:00:00",
                    slotMaxTime: "22:00:00",
                    businessHours: true,
                    selectable: true,
                    nowIndicator: true,
                    slotDuration: intervalo, // ⬅️ aquí el intervalo sí se aplica
                    slotLabelInterval: intervalo,      // muestra etiquetas por cada intervalo

                    events: rangos
                });

                calendar.render();
            }
        },
        error: function (error) {
            console.log('Error al cargar horarios del doctor', error);
        }
    });
} */


/* 
function cargarHorariosDoctor(doctorId) {
   peticionJWT({
        url: urlServidor + 'doctor_horario/obtenerhoras/' + doctorId,
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            const token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                const intervalo = response.intervalo || '00:30:00';
                const rangos = response.rangos.map(rango => ({
                    ...rango,
                    display: 'background',
                    color: 'rgb(0 ,80, 240)'
                }));

                if (calendar !== null) {
                    calendar.destroy();
                    document.getElementById('calendario').innerHTML = '';
                }

                calendar = new FullCalendar.Calendar(document.getElementById('calendario'), {
                    initialView: 'timeGridWeek',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        
                    },
                    allDaySlot: false,
                    locale: 'es',
                    slotMinTime: "07:00:00",
                    slotMaxTime: "24:00:00",
                    selectable: true,
                    nowIndicator: true,
                    slotDuration: intervalo,
                    slotLabelInterval: intervalo,

                    eventSources: [
                        // RANGOS DISPONIBLES (fondo)
                        {
                            events: rangos,
                            id: 'disponibles'
                        },
                        // CITAS OCUPADAS (coloridas)
                        {
                            events: function (info, successCallback, failureCallback) {
                               peticionJWT({
                                    url: urlServidor + 'doctor_horario/obtenerCitasOcupadas/' + doctorId,
                                    type: 'GET',
                                    dataType: 'json',
                                    data: {
                                        start: info.startStr.replace('T', ' ').slice(0, 19),
                                        end: info.endStr.replace('T', ' ').slice(0, 19)
                                    },
                                    beforeSend: function (xhr) {
                                        const token = localStorage.getItem('token');
                                        if (token) {
                                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                                        }
                                    },
                                    success: function (response) {
                                        if (response.status) {
                                            successCallback(response.events);
                                        } else {
                                            console.warn('Sin eventos ocupados:', response.mensaje);
                                            successCallback([]);
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        console.error("Error al obtener citas ocupadas:", error);
                                        failureCallback(error);
                                    }
                                });
                            },
                            id: 'ocupadas'
                        }
                    ],

                    select: function (info) {
                        if (!info || !info.startStr) return;
                        const fechaSeleccionada = new Date(info.startStr);
                        const año = fechaSeleccionada.getFullYear();
                        const mes = String(fechaSeleccionada.getMonth() + 1).padStart(2, '0');
                        const dia = String(fechaSeleccionada.getDate()).padStart(2, '0');
                        const hora = String(fechaSeleccionada.getHours()).padStart(2, '0');
                        const minutos = String(fechaSeleccionada.getMinutes()).padStart(2, '0');
                        const segundos = '00';
                        const fechaFormateada = `${año}-${mes}-${dia} ${hora}:${minutos}:${segundos}`;

                        $('#texto-fecha-hora').text(fechaFormateada);
                        $('#fecha_hora').val(fechaFormateada);
                        $('#modalAgendarCita').modal('show');
                    }
                });

                calendar.render();
            }
        },
        error: function (error) {
            console.error('Error al cargar horarios del doctor:', error);
        }
    });
} */

/* function cargarHorariosDoctor(doctorId) {
   peticionJWT({
        url: urlServidor + 'doctor_horario/obtenerhoras/' + doctorId,
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            const token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                const intervalo = response.intervalo || '00:30:00';
                const rangos = response.rangos; // Usamos el original para validar

                const eventosFondo = rangos.map(r => ({
                    ...r,
                    display: 'background',
                    color: 'rgba(0, 123, 255, 0.2)' // celeste transparente
                }));

                if (calendar !== null) {
                    calendar.destroy();
                    document.getElementById('calendario').innerHTML = '';
                }

                calendar = new FullCalendar.Calendar(document.getElementById('calendario'), {
                    initialView: 'timeGridWeek',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    allDaySlot: false,
                    locale: 'es',
                    slotMinTime: "07:00:00",
                    slotMaxTime: "24:00:00",
                    selectable: true,
                    nowIndicator: true,
                    slotDuration: intervalo,
                    slotLabelInterval: intervalo,

                    eventSources: [
                        {
                            events: eventosFondo,
                            id: 'disponibles'
                        },
                        {
                            events: function (info, successCallback, failureCallback) {
                               peticionJWT({
                                    url: urlServidor + 'doctor_horario/obtenerCitasOcupadas/' + doctorId,
                                    type: 'GET',
                                    dataType: 'json',
                                    data: {
                                        start: info.startStr.replace('T', ' ').slice(0, 19),
                                        end: info.endStr.replace('T', ' ').slice(0, 19)
                                    },
                                    beforeSend: function (xhr) {
                                        const token = localStorage.getItem('token');
                                        if (token) {
                                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                                        }
                                    },
                                    success: function (response) {
                                        if (response.status) {
                                            successCallback(response.events);
                                        } else {
                                            console.warn('Sin eventos ocupados:', response.mensaje);
                                            successCallback([]);
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        console.error("Error al obtener citas ocupadas:", error);
                                        failureCallback(error);
                                    }
                                });
                            },
                            id: 'ocupadas'
                        }
                    ],

                    select: function (info) {
                        if (!info || !info.startStr) return;

                        const fechaSeleccionada = new Date(info.startStr);
                        const diaSemana = fechaSeleccionada.getDay(); // 0=domingo
                        const horaSeleccionada = info.startStr.split('T')[1]; // "HH:MM:SS"

                        const dentroDeHorario = rangos.some(r => {
                            return r.daysOfWeek.includes(diaSemana) &&
                                   horaSeleccionada >= r.startTime &&
                                   horaSeleccionada < r.endTime;
                        });

                        if (!dentroDeHorario) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Horario no permitido',
                                text: 'Debes seleccionar una hora dentro del horario del médico.'
                            });
                            return;
                        }

                        const año = fechaSeleccionada.getFullYear();
                        const mes = String(fechaSeleccionada.getMonth() + 1).padStart(2, '0');
                        const dia = String(fechaSeleccionada.getDate()).padStart(2, '0');
                        const hora = String(fechaSeleccionada.getHours()).padStart(2, '0');
                        const minutos = String(fechaSeleccionada.getMinutes()).padStart(2, '0');
                        const segundos = '00';
                        const fechaFormateada = `${año}-${mes}-${dia} ${hora}:${minutos}:${segundos}`;

                        $('#texto-fecha-hora').text(fechaFormateada);
                        $('#fecha_hora').val(fechaFormateada);
                        $('#modalAgendarCita').modal('show');
                    }
                });

                calendar.render();
            }
        },
        error: function (error) {
            console.error('Error al cargar horarios del doctor:', error);
        }
    });
}
 */

function cargarPaciente() {
   peticionJWT({
        url: urlServidor + 'paciente/listar',
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            // Envía el token JWT en el encabezado Authorization
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            //  console.log(response);
            if (response.status) {
                let data = response.paciente.map(element => ({
                    id: element.id,
                    text: element.persona.nombre + ' ' + element.persona.apellido + ' - ' + element.persona.cedula
                }));

                $('#cita-paciente').select2({
                    data: data,
                    width: '100%', // Evita que se encoja

                    dropdownParent: $('#modalAgendarCita') // Evita que Bootstrap bloquee el select
                });
            }
        },
        error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        },
        complete: function (jqXHR, status) {
            // console.log('Petición realizada');
        }
    });
}

function cargarPaciente2() {
   peticionJWT({
        url: urlServidor + 'paciente/listar',
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            // Envía el token JWT en el encabezado Authorization
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            //  console.log(response);
            if (response.status) {
                let data = response.paciente.map(element => ({
                    id: element.id,
                    text: element.persona.nombre + ' ' + element.persona.apellido + ' - ' + element.persona.cedula
                }));



                $('#cita-paciente').select2({
                    data: data,
                    width: '100%', // Evita que se encoja

                    dropdownParent: $('#modalAgendarCita') // Evita que Bootstrap bloquee el select
                });
            }
        },
        error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        },
        complete: function (jqXHR, status) {
            // console.log('Petición realizada');
        }
    });
}
/* 
$('#btnGuardarCita').on('click', function () {
    const paciente_id = $('#cita-paciente').val();
    const doctor_id = $('#select-doctor-ver').val(); // ya está cargado en el select
    const fecha_hora = $('#fecha_hora').val();

    if (!paciente_id || !doctor_id || !fecha_hora) {
        alert('Todos los campos son obligatorios');
        return;
    }

    const data = {
        paciente_id,
        doctor_id,
        fecha_hora
    };

   peticionJWT({
        url: urlServidor + 'citas',
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json',
        beforeSend: function (xhr) {
            const token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                alert('Cita agendada correctamente');
                $('#modalAgendarCita').modal('hide');
                calendar.refetchEvents(); // recarga eventos del calendario si usas endpoint dinámico
            } else {
                alert('Error al guardar la cita: ' + response.mensaje);
            }
        },
        error: function (err) {
            console.log(err);
            alert('Error del servidor');
        }
    });
});





 */




function cargarHorariosDoctor333333(doctorId) {
   peticionJWT({
        url: urlServidor + 'doctor_horario/obtenerhoras/' + doctorId,
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            const token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                const intervalo = response.intervalo || '00:30:00';
                const rangos = response.rangos.map(rango => ({
                    ...rango,
                    display: 'background',
                    color: 'rgba(0, 160, 255, 0.2)'
                }));

                if (calendar !== null) {
                    calendar.destroy();
                    document.getElementById('calendario').innerHTML = '';
                }

                calendar = new FullCalendar.Calendar(document.getElementById('calendario'), {
                    initialView: 'timeGridWeek',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    /*       eventClick: function (info) {
                              if (info.event.source.id === 'ocupadas') {
                                  const citaId = info.event.id;
                                  const paciente = info.event.title;
                                  const hora = info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
      
                                  // Mostrar modal con datos
                                  $('#modalCancelarCita').modal('show');
                                  $('#cita_id_cancelar').val(citaId);
                                  $('#texto_cancelar').text(`¿Cancelar cita de ${paciente} a las ${hora}?`);
                              }
                          },
      
       */

                    /*   eventClick: function (info) {
                          const estadoCita = info.event.extendedProps.estado_cita_id;
  
                          if (info.event.source.id === 'ocupadas' && estadoCita === 1) {
                              const citaId = info.event.id;
                              const paciente = info.event.title;
                              const hora = info.event.start.toLocaleTimeString();
  
                              $('#modalCancelarCita').modal('show');
                              $('#cita_id_cancelar').val(citaId);
                              $('#texto_cancelar').text(`¿Cancelar cita de ${paciente} a las ${hora}?`);
                          } else {
                              alert('Solo se pueden cancelar citas que estén pendientes.');
                          }
                      }, */


                    eventClick: function (info) {
                        /*  const estado = info.event.extendedProps.estado_cita_id; */
                        const estado = info.event.extendedProps.estado_cita_id;

                        if (info.event.source.id === 'ocupadas') {
                            if (estado === 1) { // Solo si está pendiente
                                const citaId = info.event.id;
                                const paciente = info.event.title;
                                const hora = info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                                $('#modalCancelarCita').modal('show');
                                $('#cita_id_cancelar').val(citaId);
                                $('#texto_cancelar').text(`¿Cancelar cita de ${paciente} a las ${hora}?`);
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'No permitido',
                                    text: 'Solo puedes cancelar citas en estado pendiente.',
                                    confirmButtonColor: '#3085d6'
                                });
                            }
                        }
                    }
                    ,


                    allDaySlot: false,
                    locale: 'es',
                    slotMinTime: "07:00:00",
                    slotMaxTime: "24:00:00",
                    selectable: true,
                    nowIndicator: true,
                    slotDuration: intervalo,
                    slotLabelInterval: intervalo,

                    eventSources: [
                        {
                            events: rangos,
                            id: 'disponibles'
                        },
                        {
                            events: function (info, successCallback, failureCallback) {
                               peticionJWT({
                                    url: urlServidor + 'doctor_horario/obtenerCitasOcupadas/' + doctorId,
                                    type: 'GET',
                                    dataType: 'json',
                                    data: {
                                        start: info.startStr.replace('T', ' ').slice(0, 19),
                                        end: info.endStr.replace('T', ' ').slice(0, 19)
                                    },
                                    beforeSend: function (xhr) {
                                        const token = localStorage.getItem('token');
                                        if (token) {
                                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                                        }
                                    },
                                    success: function (response) {
                                        if (response.status) {
                                            successCallback(response.events);
                                        } else {
                                            console.warn('Sin eventos ocupados:', response.mensaje);
                                            successCallback([]);
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        console.error("Error al obtener citas ocupadas:", error);
                                        failureCallback(error);
                                    }
                                });
                            },
                            id: 'ocupadas'
                        }
                    ],

                    /*    
                    se pueden agendar citas con dias anteriores
                    selectAllow: function (selectInfo) {
                           const fecha = new Date(selectInfo.start);
                           const diaSemana = fecha.getDay(); // 0 = domingo
                           const horaSeleccionada = selectInfo.start.toTimeString().substring(0, 8); // HH:MM:SS
   
                           const dentroDeHorario = rangos.some(r =>
                               r.daysOfWeek.includes(diaSemana) &&
                               horaSeleccionada >= r.startTime &&
                               horaSeleccionada < r.endTime
                           );
   
                           return dentroDeHorario;
                       }, */


                    //aca se bloquean dias anteriores
                    /*            selectAllow: function (selectInfo) {
                                   const ahora = new Date();
                                   const fechaInicio = new Date(selectInfo.start);
                                   const diaSemana = fechaInicio.getDay(); // 0 = domingo
                                   const horaSeleccionada = selectInfo.start.toTimeString().substring(0, 8); // HH:MM:SS
           
                                   // 1. Verificar si es hoy y la hora ya pasó
                                   const esHoy = ahora.toDateString() === fechaInicio.toDateString();
                                   if (esHoy && fechaInicio < ahora) {
                                       return false;
                                   }
           
                                   // 2. Validar si está dentro del horario del médico
                                   const dentroDeHorario = rangos.some(r =>
                                       r.daysOfWeek.includes(diaSemana) &&
                                       horaSeleccionada >= r.startTime &&
                                       horaSeleccionada < r.endTime
                                   );
           
                                   return dentroDeHorario;
                               },
            */

                    selectAllow: function (selectInfo) {
                        const ahora = new Date();
                        const fechaInicio = new Date(selectInfo.start);

                        // 1. Bloquear días anteriores completos
                        const hoySinHora = new Date(ahora.getFullYear(), ahora.getMonth(), ahora.getDate());
                        const fechaInicioSinHora = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), fechaInicio.getDate());

                        if (fechaInicioSinHora < hoySinHora) {
                            return false; // bloquea días anteriores
                        }

                        // 2. Bloquear horas pasadas en día actual
                        const esHoy = hoySinHora.getTime() === fechaInicioSinHora.getTime();
                        if (esHoy && fechaInicio < ahora) {
                            return false; // bloquea horas pasadas hoy
                        }

                        // 3. Validar que esté dentro del horario del médico
                        const diaSemana = fechaInicio.getDay();
                        const horaSeleccionada = selectInfo.start.toTimeString().substring(0, 8);

                        const dentroDeHorario = rangos.some(r =>
                            r.daysOfWeek.includes(diaSemana) &&
                            horaSeleccionada >= r.startTime &&
                            horaSeleccionada < r.endTime
                        );

                        return dentroDeHorario;
                    },



                    select: function (info) {
                        const fechaSeleccionada = new Date(info.startStr);
                        const año = fechaSeleccionada.getFullYear();
                        const mes = String(fechaSeleccionada.getMonth() + 1).padStart(2, '0');
                        const dia = String(fechaSeleccionada.getDate()).padStart(2, '0');
                        const hora = String(fechaSeleccionada.getHours()).padStart(2, '0');
                        const minutos = String(fechaSeleccionada.getMinutes()).padStart(2, '0');
                        const segundos = '00';
                        const fechaFormateada = `${año}-${mes}-${dia} ${hora}:${minutos}:${segundos}`;

                        $('#texto-fecha-hora').text(fechaFormateada);
                        $('#fecha_hora').val(fechaFormateada);
                        $('#modalAgendarCita').modal('show');
                    }
                });



                calendar.render();
            }
        },
        error: function (error) {
            console.error('Error al cargar horarios del doctor:', error);
        }
    });
}



function cargarHorariosDoctor(doctorId) {
    peticionJWT({
        url: urlServidor + 'doctor_horario/obtenerhoras/' + doctorId,
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            const token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                const intervalo = response.intervalo || '00:30:00';
                // Respetamos el color original que viene del backend para diferenciar almuerzo y horario normal
                const rangos = response.rangos.map(rango => ({
                    ...rango,
                    display: 'background',
                    color: rango.color  // aquí mantenemos el color que viene
                }));

                if (calendar !== null) {
                    calendar.destroy();
                    document.getElementById('calendario').innerHTML = '';
                }

                // Función para saber si la hora está dentro del rango de almuerzo (color rojo)
                function esHoraEnAlmuerzo(diaSemana, horaSeleccionada) {
                    return rangos.some(r =>
                        r.daysOfWeek.includes(diaSemana) &&
                        r.color === '#ff4d4d' &&  // rojo almuerzo
                        horaSeleccionada >= r.startTime &&
                        horaSeleccionada < r.endTime
                    );
                }

                calendar = new FullCalendar.Calendar(document.getElementById('calendario'), {
                    initialView: 'timeGridWeek',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },

                  
 

                    eventClick: function (info) {
                        /*  const estado = info.event.extendedProps.estado_cita_id; */
                        const estado = info.event.extendedProps.estado_cita_id;

                        if (info.event.source.id === 'ocupadas') {
                            if (estado === 1) { // Solo si está pendiente
                                const citaId = info.event.id;
                                const paciente = info.event.title;
                                const hora = info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                                $('#modalCancelarCita').modal('show');
                                $('#cita_id_cancelar').val(citaId);
                                $('#texto_cancelar').text(`¿Cancelar cita de ${paciente} a las ${hora}?`);
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'No permitido',
                                    text: 'Solo puedes cancelar citas en estado pendiente.',
                                    confirmButtonColor: '#3085d6'
                                });
                            }
                        }
                    }
                    ,

                    allDaySlot: false,
                    locale: 'es',
                    slotMinTime: "07:00:00",
                    slotMaxTime: "24:00:00",
                    selectable: true,
                    nowIndicator: true,
                    slotDuration: intervalo,
                    slotLabelInterval: intervalo,
                    height:800, // ajusta a tu gusto: 400, 500, etc.
                    slotMinHeight: 390, // ← aquí aumentas el alto de cada bloque de hora (prueba 40, 50, etc.)

                    eventSources: [
                        {
                            events: rangos,
                            id: 'disponibles'
                        },
                        {
                            events: function (info, successCallback, failureCallback) {
                               peticionJWT({
                                    url: urlServidor + 'doctor_horario/obtenerCitasOcupadas/' + doctorId,
                                    type: 'GET',
                                    dataType: 'json',
                                    data: {
                                        start: info.startStr.replace('T', ' ').slice(0, 19),
                                        end: info.endStr.replace('T', ' ').slice(0, 19)
                                    },
                                    beforeSend: function (xhr) {
                                        const token = localStorage.getItem('token');
                                        if (token) {
                                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                                        }
                                    },
                                    success: function (response) {
                                        if (response.status) {
                                            successCallback(response.events);
                                        } else {
                                            console.warn('Sin eventos ocupados:', response.mensaje);
                                            successCallback([]);
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        console.error("Error al obtener citas ocupadas:", error);
                                        failureCallback(error);
                                    }
                                });
                            },
                            id: 'ocupadas'
                        }
                    ],

             
                    selectAllow: function (selectInfo) {
                        const ahora = new Date();
                        const fechaInicio = new Date(selectInfo.start);

                        // 1. Bloquear días anteriores completos
                        const hoySinHora = new Date(ahora.getFullYear(), ahora.getMonth(), ahora.getDate());
                        const fechaInicioSinHora = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), fechaInicio.getDate());

                        if (fechaInicioSinHora < hoySinHora) {
                            return false; // bloquea días anteriores
                        }

                        // 2. Bloquear horas pasadas en día actual
                        const esHoy = hoySinHora.getTime() === fechaInicioSinHora.getTime();
                        if (esHoy && fechaInicio < ahora) {
                            return false; // bloquea horas pasadas hoy
                        }

                        // 3. Validar que esté dentro del horario del médico
                        const diaSemana = fechaInicio.getDay();
                        const horaSeleccionada = selectInfo.start.toTimeString().substring(0, 8);

                        // Validar que esté dentro de algún rango azul (disponible)
                        const dentroDeHorario = rangos.some(r =>
                            r.daysOfWeek.includes(diaSemana) &&
                            horaSeleccionada >= r.startTime &&
                            horaSeleccionada < r.endTime &&
                            r.color === '#5bc0de'  // azul celeste, horario disponible
                        );

                        // Validar que NO esté dentro del rango de almuerzo (rojo)
                        const enAlmuerzo = rangos.some(r =>
                            r.daysOfWeek.includes(diaSemana) &&
                            r.color === '#ff4d4d' &&  // rojo almuerzo
                            horaSeleccionada >= r.startTime &&
                            horaSeleccionada < r.endTime
                        );

                        return dentroDeHorario && !enAlmuerzo;
                    },


                    select: function (info) {
                        const fechaSeleccionada = new Date(info.startStr);
                        const año = fechaSeleccionada.getFullYear();
                        const mes = String(fechaSeleccionada.getMonth() + 1).padStart(2, '0');
                        const dia = String(fechaSeleccionada.getDate()).padStart(2, '0');
                        const hora = String(fechaSeleccionada.getHours()).padStart(2, '0');
                        const minutos = String(fechaSeleccionada.getMinutes()).padStart(2, '0');
                        const segundos = '00';
                        const fechaFormateada = `${año}-${mes}-${dia} ${hora}:${minutos}:${segundos}`;

                        $('#texto-fecha-hora').text(fechaFormateada);
                        $('#fecha_hora').val(fechaFormateada);
                        $('#modalAgendarCita').modal('show');
                    }
                });

                calendar.render();
            }
        },
        error: function (error) {
            console.error('Error al cargar horarios del doctor:', error);
        }
    });
}



$('#btnGuardarCita').on('click', function () {
    const pacienteId = $('#cita-paciente').val();
    const doctorId = $('#select-doctor-ver').val();
    const fechaHora = $('#fecha_hora').val();
    const totalParcial = $("#total-parcial").text();

    const tr_servicios = $(".tr-servicio");
    const citas_servicios = [];

    if (!pacienteId || !doctorId || !fechaHora) {
        alert('Complete todos los campos obligatorios');
        return;
    }

    const dataToSend = {
        citas: {
            paciente_id: pacienteId,
            doctor_id: doctorId,
            fecha_hora: fechaHora,
            total_parcial: totalParcial,
        },
        // citas_servicios: []
    };
    console.log(dataToSend);


    //validacion para datos de personas
    if (validarreservacion(dataToSend)) {
        //   console.log("llene los campos de datos de persona");

        if (tr_servicios.length > 0) {
            for (let i = 0; i < tr_servicios.length; i++) {
                let object = { servicios_id: tr_servicios[i].innerText };
                citas_servicios.push(object);
            }
            dataToSend.citas_servicios = citas_servicios;



            //Realizar peticion ajax
            guardandoNuevoagendamiento(dataToSend);
            // Esperar 5 segundos antes de recargar la página
            /*   setTimeout(function () {
                 location.reload();
               }, 1000); */
            // Recargar la página después de guardar exitosamente
            //   
        } else {
            Swal.fire({
                title: "Debe seleccionar al menos un servicio",
                text: 'Citas',
                icon: 'error'
            })
        }
    }

});




function guardandoNuevoagendamiento(dataToSend) {
   peticionJWT({
        url: urlServidor + 'citas/guardarfull',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ data: JSON.stringify(dataToSend) }),
        beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                toastr.options = {
                    "closeButton": true,
                    "preventDuplicates": true,
                    "positionClass": "toast-top-right",
                    "progressBar": true,
                };

                toastr["success"]("Cita agendada correctamente");



                //    alert('Cita guardada correctamente');
                $('#modalAgendarCita').modal('hide');
                $('#cita-paciente').val(' ');
                $('#total-parcial').text('0');
                $('#items-servicios').html('');
              //  selectServicios2();
                $('#cita-servicio').val(0).trigger('change');

                cargarPaciente2();
                calendar.refetchEvents();


            } else {
                /*  alert('Error: ' + response.mensaje); */


                toastr.options = {
                    "closeButton": true,
                    "preventDuplicates": true,
                    "positionClass": "toast-top-right",
                    "progressBar": true,
                };

                toastr["error"](response.mensaje);

            }
        },
        error: function (xhr, status, error) {
            console.error('Error al guardar cita:', error);

            toastr.options = {
                "closeButton": true,
                "preventDuplicates": true,
                "positionClass": "toast-top-right",
                "progressBar": true,
            };

            toastr["error"]("Error al guardar cita, revise la consola");


            /*  alert('Error al guardar cita, revise la consola'); */
        }
    });
}


function validarreservacion(dataToSend) {
    let citas = dataToSend.citas;


    if (citas.paciente_id == 0) {
        Swal.fire({
            title: "Seleccione al paciente",
            text: 'Citas',
            icon: 'error'
        })
        return false;
    } else if (citas.doctor_id == 0) {
        Swal.fire({
            title: "Seleccione al medico",
            text: 'Citas',
            icon: 'error'
        })
        return false;
    } else if (citas.fechaHora == 0) {
        Swal.fire({
            title: "Seleccione una fecha",
            text: 'Citas',
            icon: 'error'
        })

        return false;
    } else {
        return true;
    }
}

/* function cancelarCita() {
    const id = $('#cita_id_cancelar').val();
    const motivo = $('#motivo_cancelar').val();

   peticionJWT({
        url: urlServidor + 'cita/cancelarfull',
        type: 'POST',
          beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        data: {
            id,
            motivo
        },
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
        },
        success: function (response) {
            if (response.status) {
                $('#modalCancelarCita').modal('hide');
                calendar.refetchEvents();
                alert('Cita cancelada correctamente');
            } else {
                alert('Error al cancelar: ' + response.mensaje);
            }
        },
        error: function () {
            alert('Error de servidor al cancelar cita');
        }
    });
}
 */



$('#btnConfirmarCancelar').click(function () {
    const citaId = $('#cita_id_cancelar').val();

   peticionJWT({
        url: urlServidor + 'citas/cancelarfull',
        type: 'POST',
        contentType: 'application/json',
        beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
        },
        data: JSON.stringify({ id: citaId }),
        success: function (response) {
            if (response.status) {
                //  alert(response.mensaje);
                toastr.options = {
                    "closeButton": true,
                    "preventDuplicates": true,
                    "positionClass": "toast-top-right",
                    "progressBar": true,
                };

                toastr["success"](response.mensaje);



                $('#modalCancelarCita').modal('hide');
                // Recarga el calendario para actualizar citas
                calendar.refetchEvents();
            } else {
                //alert('Error: ' + response.mensaje);

                toastr.options = {
                    "closeButton": true,
                    "preventDuplicates": true,
                    "positionClass": "toast-top-right",
                    "progressBar": true,
                };

                toastr["error"](response.mensaje);


            }
        },
        error: function (xhr, status, error) {

            toastr.options = {
                "closeButton": true,
                "preventDuplicates": true,
                "positionClass": "toast-top-right",
                "progressBar": true,
            };

            toastr["error"]('Error al cancelar la cita: ' + error);


            //  alert();
        }
    });
});




function selectServicios() {
   peticionJWT({
        // la URL para la petición
        url: urlServidor + "servicios/listar",
        // especifica si será una petición POST o GET
        type: "GET",
        beforeSend: function (xhr) {
            // Envía el token JWT en el encabezado Authorization
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        // el tipo de información que se espera de respuesta
        dataType: "json",
        success: function (response) {

            /*       let option = '<option value="0">Seleccione un servicio</option>';
                  if (response.status) {
              //        console.log(response);
                   
                    response.servicios.forEach((element) => {
                      option += `<option value=${element.id}>${element.detalle_servicio}</option>`;
                    });
                    $("#cita-servicio").html(option);
                  } else {
                    
                  } */

            if (response.status) {
                let data = response.servicios.map(element => ({
                    id: element.id,
                    text: element.detalle_servicio
                }));

                $('#cita-servicio').select2({
                    data: data,
                    width: '70%', // Evita que se encoja

                    dropdownParent: $('#modalAgendarCita') // Evita que Bootstrap bloquee el select

                });
            }
        },
        error: function (jqXHR, status, error) {
            console.log("Disculpe, existió un problema");
        },
        complete: function (jqXHR, status) {
            // console.log('Petición realizada');
        },
    });
}


function selectServicios2() {
   peticionJWT({
        // la URL para la petición
        url: urlServidor + "servicios/listar",
        // especifica si será una petición POST o GET
        type: "GET",
        beforeSend: function (xhr) {
            // Envía el token JWT en el encabezado Authorization
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        // el tipo de información que se espera de respuesta
        dataType: "json",
        success: function (response) {

            /*       let option = '<option value="0">Seleccione un servicio</option>';
                  if (response.status) {
              //        console.log(response);
                   
                    response.servicios.forEach((element) => {
                      option += `<option value=${element.id}>${element.detalle_servicio}</option>`;
                    });
                    $("#cita-servicio").html(option);
                  } else {
                    
                  } */

            if (response.status) {
                let data = response.servicios.map(element => ({
                    id: element.id,
                    text: element.detalle_servicio
                }));

                $('#cita-servicio').select2({
                    data: data,
                    width: '70%', // Evita que se encoja

                    dropdownParent: $('#modalAgendarCita') // Evita que Bootstrap bloquee el select

                });
            }
        },
        error: function (jqXHR, status, error) {
            console.log("Disculpe, existió un problema");
        },
        complete: function (jqXHR, status) {
            // console.log('Petición realizada');
        },
    });
}


function agregar_servicios() {
    $("#btn-agregar").click(() => {
        let id = $("#cita-servicio option:selected").val();
        if (id == "0") {
            Swal.fire({
                title: "Seleccione un servicio",
                text: 'Citas',
                icon: 'info'
            })

        } else {
           peticionJWT({
                // la URL para la petición
                url: urlServidor + "servicios/listar/" + id,
                // especifica si será una petición POST o GET
                type: "GET",
                // el tipo de información que se espera de respuesta
                dataType: "json",
                beforeSend: function (xhr) {
                    // Envía el token JWT en el encabezado Authorization
                    let token = localStorage.getItem('token');
                    if (token) {
                        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                    }
                },
                success: function (response) {
                    console.log(response);
                    if (response.status) {
                        let tr = `<tr id="fila-servicios-${response.servicios.id}">
                            <td></td>
                            <td>${response.servicios.detalle_servicio}</td>
                            <td class="tr-precio-servicios">${response.servicios.precio}</td>
                            <td>
                                <div>
                                    <button class="btn btn-outline-danger"
                                        onclick="eliminar_servicio(${response.servicios.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="tr-servicio d-none">${response.servicios.id}</td>
                        </tr>`;

                        let li = `<li id="li-servicio-${response.servicios.id}" class="text-primary">${response.servicios.detalle_servicio}</li>`;
                        $("#items-servicios").append(tr);
                        console.log(tr);
                        calcular_totalParcial();
                    }
                },
                error: function (jqXHR, status, error) {
                    console.log("Disculpe, existió un problema");
                },
                complete: function (jqXHR, status) {
                    // console.log('Petición realizada');
                },
            });
        }
    });
}

function calcular_totalParcial() {
    let precio = $(".tr-precio-servicios");
    //   console.log(precio);
    let total_parcial = 0;
    for (let i = 0; i < precio.length; i++) {
        let pre = parseFloat(precio[i].innerText);
        total_parcial += pre;
    }
    $("#total-parcial").text(total_parcial);
}

function calcular_totalParcial2() {
    let precio = $(".tr-precio-servicios");
    console.log(precio);
    let total_parcial = 0;
    for (let i = 0; i < precio.length; i++) {
        let pre = parseFloat(precio[i].innerText);
        total_parcial += pre;
    }
    $("#total-parcial").text(total_parcial);
}


function eliminar_servicio(id) {
    let tr = "#fila-servicios-" + id;
    $(tr).remove();
    $('#datos-r').removeClass('d-none');

    calcular_totalParcial2();
}
