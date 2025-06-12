var tabla;
_init();

function _init() {
    seleccionar_doctor();
    cargarUsuario();
    guardarHorarioAtencion();
    cargarDoctorH();
   // cargarHorariosDoctor();
   cargarHorarioExistente();
}



function cargarUsuario2() {
    let usuario = JSON.parse(localStorage.getItem('sesion'));
    let nombres = usuario.persona.nombre + ' ' + usuario.persona.apellido;
    $('#usuario-md').val(nombres);
}


function seleccionar_doctor() {
    peticionJWT({
        url: urlServidor + 'doctor/listar',
        type: 'GET',
        dataType: 'json',
        beforeSend: function(xhr) {
            // Envía el token JWT en el encabezado Authorization
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            //    console.log(response);
            if (response.status) {
                let option = '<option value="0">Seleccione Doctor</option>';
                response.doctor.forEach(element => {
                    option += `<option value=${element.id}>${element.persona.nombre + ' ' + element.persona.apellido}</option>`;
                });
                $('#select-doctor').html(option);
                $('#select-doctor-listar').html(option);

            }
        },
        error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        },

    });


}


function cargarUsuario() {
    let usuario = JSON.parse(localStorage.getItem('sesion'));
    let nombres = usuario.persona.nombre + ' ' + usuario.persona.apellido;
    $('#usuario-md').val(nombres);
}



/** INICIO DE HORAS CON FULL CAL4NDAR*/

  function guardarHorarioAtencion() {
  $('#form-horario-doctor').submit(function (e) {
    e.preventDefault();

    let usuario_id = JSON.parse(localStorage.getItem('sesion')).id;
    let doctor_id =  JSON.parse(localStorage.getItem('sesion-2'));

    let intervalo = $('#select-intervalo').val();

  
    if (!intervalo || intervalo === '0') {
      return Swal.fire({ title: 'Seleccione un intervalo', icon: 'error' });
    }

    // Construir el objeto horarios con los inputs dinámicos por día
    let horarios = {};
    let diasSeleccionados = $('.dia-semana:checked').map(function () {
      return $(this).val();
    }).get();

    if (diasSeleccionados.length === 0) {
      return Swal.fire({ title: 'Seleccione al menos un día de atención', icon: 'error' });
    }

    // Recorrer días y obtener horarios para cada uno
    for (const dia of diasSeleccionados) {
      let bloque = $(`.bloque-dia[data-dia="${dia}"]`);

      // Extraer valores de los inputs
      let hora_inicio = bloque.find(`input[name="horarios[${dia}][hora_inicio]"]`).val();
      let hora_fin = bloque.find(`input[name="horarios[${dia}][hora_fin]"]`).val();
      let almuerzo_inicio = bloque.find(`input[name="horarios[${dia}][almuerzo_inicio]"]`).val() || null;
      let almuerzo_fin = bloque.find(`input[name="horarios[${dia}][almuerzo_fin]"]`).val() || null;

      // Validaciones por día
      if (!hora_inicio) {
        return Swal.fire({ title: `Ingrese hora de entrada para ${dia}`, icon: 'error' });
      }
      if (!hora_fin) {
        return Swal.fire({ title: `Ingrese hora de salida para ${dia}`, icon: 'error' });
      }
      if (hora_fin <= hora_inicio) {
        return Swal.fire({ title: `La hora de salida debe ser mayor que la entrada para ${dia}`, icon: 'error' });
      }
      if (almuerzo_inicio && !almuerzo_fin) {
        return Swal.fire({ title: `Ingrese hora de fin de almuerzo para ${dia}`, icon: 'error' });
      }
      if (almuerzo_fin && !almuerzo_inicio) {
        return Swal.fire({ title: `Ingrese hora de inicio de almuerzo para ${dia}`, icon: 'error' });
      }
      if (almuerzo_inicio && almuerzo_fin && almuerzo_fin <= almuerzo_inicio) {
        return Swal.fire({ title: `La hora de fin de almuerzo debe ser mayor que la de inicio para ${dia}`, icon: 'error' });
      }

      horarios[dia] = {
        hora_inicio,
        hora_fin,
        almuerzo_inicio,
        almuerzo_fin,
      };
    }

    // Armar objeto final a enviar
    let dataToSend = {
      doctor_id: parseInt(doctor_id),
      intervalo: parseInt(intervalo),
      usuario_id: parseInt(usuario_id),
      horarios: horarios,
    };

    // Enviar al backend
    guardandoHorarioAtencion(dataToSend);
  });
}

function guardandoHorarioAtencion(data) {
  peticionJWT({
    url: urlServidor + 'doctor_horario/storeHorario',
    type: 'POST',
    contentType: 'application/json',
    data: JSON.stringify(data),
    dataType: 'json',
    beforeSend: function (xhr) {
      let token = localStorage.getItem('token');
      if (token) {
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
      }
    },
    success: function (response) {
      if (response.status) {
        Swal.fire({ title: response.mensaje, icon: 'success' });
        $('#form-horario-doctor')[0].reset();
        $('#horarios-por-dia').empty();
        cargarHorarioExistente2();
        cargarUsuario2();
      } else {
        Swal.fire({ title: response.mensaje || 'Error al guardar horario', icon: 'error' });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      Swal.fire({ title: 'Error en la conexión o servidor', text: errorThrown, icon: 'error' });
      console.error('Error:', textStatus, errorThrown);
    }
  });
}


function cargarDoctorH() {
    peticionJWT({
        url: urlServidor + 'doctor/listardoctor',
        type: 'GET',
        dataType: 'json',
        beforeSend: function(xhr) {
          // Envía el token JWT en el encabezado Authorization
          let token = localStorage.getItem('token');
          if (token) {
              xhr.setRequestHeader('Authorization', 'Bearer ' + token);
          }
      },
        success: function (response) {
          //   console.log(response);
             if (response.status) {
                let data = response.doctor.map(element => ({
                    id: element.id,
                    text: element.persona.nombre + ' ' + element.persona.apellido + ' - ' + element.persona.cedula  

                }));

                $('#select-doctor-ver').select2({
                    data: data,
                   
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




function cargarHorarioExistente() {
    let doctor_id = JSON.parse(localStorage.getItem('sesion-2'));

  peticionJWT({
    url: urlServidor + 'doctor_horario/obtenerhorasedicion/' + doctor_id,
    type: 'GET',
    dataType: 'json',
    beforeSend: function(xhr) {
      let token = localStorage.getItem('token');
      if (token) {
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
      }
    },
    success: function(response) {
        console.log(response);
        
      if (response.status && response.horarios.length > 0) {
        // Marcar días seleccionados y crear bloques
        $('#horarios-por-dia').empty();
        $('.dia-semana').prop('checked', false);

        response.horarios.forEach(horario => {
          const dia = horario.dia;
          $(`#${dia.toLowerCase()}`).prop('checked', true).trigger('change');

          setTimeout(() => {
            const bloque = $(`.bloque-dia[data-dia="${dia}"]`);
            bloque.find(`input[name="horarios[${dia}][hora_inicio]"]`).val(horario.hora_inicio);
            bloque.find(`input[name="horarios[${dia}][hora_fin]"]`).val(horario.hora_fin);
            bloque.find(`input[name="horarios[${dia}][almuerzo_inicio]"]`).val(horario.almuerzo_inicio || '');
            bloque.find(`input[name="horarios[${dia}][almuerzo_fin]"]`).val(horario.almuerzo_fin || '');
          }, 200); // Esperar a que los inputs se generen
        });

        // Rellenar intervalo también
        $('#select-intervalo').val(response.horarios[0].intervalo);
      } else {
        $('#horarios-por-dia').empty();
        $('.dia-semana').prop('checked', false);
        $('#select-intervalo').val('');
      }
    },
    error: function() {
      console.error('Error al cargar horarios');
    }
  });
}

function cargarHorarioExistente2() {
    let doctor_id = JSON.parse(localStorage.getItem('sesion-2'));

  peticionJWT({
    url: urlServidor + 'doctor_horario/obtenerhorasedicion/' + doctor_id,
    type: 'GET',
    dataType: 'json',
    beforeSend: function(xhr) {
      let token = localStorage.getItem('token');
      if (token) {
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
      }
    },
    success: function(response) {
        console.log(response);
        
      if (response.status && response.horarios.length > 0) {
        // Marcar días seleccionados y crear bloques
        $('#horarios-por-dia').empty();
        $('.dia-semana').prop('checked', false);

        response.horarios.forEach(horario => {
          const dia = horario.dia;
          $(`#${dia.toLowerCase()}`).prop('checked', true).trigger('change');

          setTimeout(() => {
            const bloque = $(`.bloque-dia[data-dia="${dia}"]`);
            bloque.find(`input[name="horarios[${dia}][hora_inicio]"]`).val(horario.hora_inicio);
            bloque.find(`input[name="horarios[${dia}][hora_fin]"]`).val(horario.hora_fin);
            bloque.find(`input[name="horarios[${dia}][almuerzo_inicio]"]`).val(horario.almuerzo_inicio || '');
            bloque.find(`input[name="horarios[${dia}][almuerzo_fin]"]`).val(horario.almuerzo_fin || '');
          }, 200); // Esperar a que los inputs se generen
        });

        // Rellenar intervalo también
        $('#select-intervalo').val(response.horarios[0].intervalo);
      } else {
        $('#horarios-por-dia').empty();
        $('.dia-semana').prop('checked', false);
        $('#select-intervalo').val('');
      }
    },
    error: function() {
      console.error('Error al cargar horarios');
    }
  });
}




/* 
$('#select-doctor').change(function () {
  const doctor_id = $(this).val();
  if (doctor_id) {
    cargarHorarioExistente(doctor_id);
  }
});


 */
































