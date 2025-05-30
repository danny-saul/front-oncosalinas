_init();

function _init() {

  guardarOdontograma();
  cargarOdontograma();

  guardar_elementocomponente();
  cargarDetalleComponente();


}


/**INICIO DE ODONTOGRAMA */

/* // Llamar a la función cuando se carga la página
$(document).ready(function () {
    let paciente_id = $('#paciente-id').val();
    if (paciente_id) {
      cargarOdontograma(paciente_id);
    }
  });
   */

/* let OdontogramaInicializado = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_12' && !OdontogramaInicializado) {
    cargarOdontograma();
    OdontogramaInicializado = true;
  }
});
 */


  function cargarOdontograma() {
    let paciente_id = localStorage.getItem('paciente_id');

  
    $.ajax({
      url: urlServidor + 'odontograma/listarodontopaciente/' + paciente_id,
      type: 'GET',
      dataType: 'json',
      beforeSend: function (xhr) {
        let token = localStorage.getItem('token');
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
      },


      success: function (response) {
        if (response.status) {
          //     console.log("📌 Datos recuperados del odontograma:", response);
          $('#odonto-id').val(response.odontograma.id);

          let detalles = response.detalles;
          detalles.forEach(detalle => {
            //     console.log("🧐 Detalle recibido:", detalle);

            let pieza = detalle.pieza;
            let cuadrante = detalle.cuadrante;
            let estado = detalle.estado;

            //             console.log(`✅ Estado de la cara (pieza ${pieza}, cuadrante ${cuadrante}):`, estado);

            let color = obtenerColorEstado(estado);
            //           console.log("🎨 Color asignado:", color);

            let cara = $(`.diente[data-numero="${pieza}"] .cara[data-cara="${cuadrante}"]`);
            cara.css('fill', color)  // Aplicar color directamente al fill del SVG
              .removeClass('estado-por-hacer estado-encontrado estado-realizado')
              .addClass(`estado-${estado.replace(/\s+/g, '-').toLowerCase()}`);
          });
        }
      },

      error: function () {
        //          console.error("❌ Error al obtener el odontograma.");
      }
    });
  }

  function obtenerColorEstado(estado) {
    //  console.log("🧐 Estado recibido en obtenerColorEstado:", estado); // Verificar qué valor llega
    switch (estado.toLowerCase().trim()) {
      case "por hacerse":
        return "red";
      case "encontrado":
        return "blue";
      case "realizado":
        return "deepskyblue";
      default:
        return "white"; // Si el estado no es reconocido, devolver blanco
    }
  }
  
  
function cargarDatosOd() {
    let paciente_id = localStorage.getItem('paciente_id');
    $.ajax({
      url: urlServidor + 'odontograma/listarodontopaciente/' + paciente_id,
      type: 'GET',
      dataType: 'json',
      beforeSend: function (xhr) {
        let token = localStorage.getItem('token');
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
      },


      success: function (response) {
        if (response.status) {
          console.log("📌 Datos recuperados del odontograma:", response);
          $('#odonto-id').val(response.odontograma.id);

        }
      },

      error: function () {
        //          console.error("❌ Error al obtener el odontograma.");
      }
    });
  }
  
  
  
/*   let guardarOdontogramaInicializado = false;

  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    const targetTab = $(e.target).attr('href');
  
    if (targetTab === '#tab_12' && !guardarOdontogramaInicializado) {
      guardarOdontograma();
      guardarOdontogramaInicializado = true;
    }
  }); */
  
  function guardarOdontograma() {
    $('#agregarTratamiento').click(function () {
      let doctor_id = JSON.parse(localStorage.getItem('sesion-2')) || null;
      let paciente_id = $('#paciente-id').val();
      let citas_id = $('#citas-id').val();
      let estadoTratamiento = $('#estadoTratamiento').val() || "Por hacerse"; // Captura el estado seleccionado
  
      let odontograma_detalle = [];
  
      $('.cara.seleccionado').each(function () {
        let pieza = $(this).closest('.diente').data('numero');
        let cuadrante = $(this).data('cara'); // Capturamos la cara como cuadrante
        let tratamiento = $('#tratamiento').val() || "No definido";
  
        let diagnostico_odonto_id = $('#odonto-diagnostico option:selected').val() || "No definido";
        let procedimiento_odonto_id = $('#odonto-procedimiento option:selected').val() || "No definido";
        let tratamiento_odontograma_id = $('#tratamiento-odontograma option:selected').val() || "No definido";
  
        let fecha = new Date().toISOString().split('T')[0];
  
        odontograma_detalle.push({
          pieza: pieza,
          cuadrante: cuadrante,
          citas_id: citas_id,
          diagnóstico: tratamiento,
          diagnostico_odonto_id: diagnostico_odonto_id,
          procedimiento_odonto_id: procedimiento_odonto_id,
          tratamiento_odontograma_id: tratamiento_odontograma_id,
          fecha: fecha,
          estado: estadoTratamiento // Agregamos el estado correctamente
        });
      });
  
      let json = {
        odontograma: {
          doctor_id: doctor_id,
          citas_id: citas_id,
          paciente_id: paciente_id,
  
        },
        odontograma_detalle: odontograma_detalle
      };
  
      console.log("📌 JSON generado:", JSON.stringify(json, null, 2));
      guardando_odontograma(json)
    });
  }

  
function guardando_odontograma(json) {

    $.ajax({
      // la URL para la petición
      url: urlServidor + 'odontograma/guardar',
      type: 'POST',
      data: { data: JSON.stringify(json) },
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
          Swal.fire({
            title: "Listo !",
            text: response.mensaje,
            icon: 'success'
          })
  
          cargardtodonto2();
          cargarDatosOd();
  
          //   $('#editar-usuario').val('');
  
  
        } else {
          Swal.fire({
            title: "Errpr !",
            text: response.mensaje,
            icon: 'error'
          })
  
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
  
  let cargarDtOdontogramaInicializado = false;

  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    const targetTab = $(e.target).attr('href');
  
    if (targetTab === '#tab_12' && !cargarDtOdontogramaInicializado) {
      cargardtodonto();
      cargarDtOdontogramaInicializado = true;
    }
  });
  
  function cargardtodonto() {
 
    let paciente_id = localStorage.getItem('paciente_id');

    tabla3 = $('#tabla-odonto-listar').DataTable({
      "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "aProcessing": true,//Activamos el procesamiento del datatables
      "aServerSide": true,//Paginación y filtrado realizados por el servidor
      "ajax":
      {
        url: urlServidor + 'odontograma/listar_odontogramas/' + paciente_id,
        type: "get",
        dataType: "json",
        beforeSend: function (xhr) {
          // Envía el token JWT en el encabezado Authorization
          let token = localStorage.getItem('token');
          if (token) {
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
          }
        },
        error: function (e) {
          console.log(e.responseText);
        }
      },
      destroy: true,
      "iDisplayLength": 10,//Paginación
      "language": {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",

        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        },

        "oAria": {
          "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }

      }//cerrando language
    });
  
  
  }
  
  let cargarDiagnosticoOdInicializado = false;

  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    const targetTab = $(e.target).attr('href');
  
    if (targetTab === '#tab_12' && !cargarDiagnosticoOdInicializado) {
      cargarDiagnosticoOdonto();
      cargarDiagnosticoOdInicializado = true;
    }
  });

function cargarDiagnosticoOdonto() {
    $.ajax({
      url: urlServidor + 'odontograma/listardiagnostico',
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
        //    console.log(response);
  
        if (response.status) {
          let data = [{ id: 0, text: 'Seleccione el Diagnostico' }];
          response.diagnostico.forEach(element => {
            data.push({ id: element.id, text: `${element.clave_od} - ${element.descripcion_od}` });
          });
  
          $('#odonto-diagnostico').empty();
  
  
          $('#odonto-diagnostico').select2({
            data: data,
            width: '100%', // Evita que se encoja
            dropdownParent: $('#modalTratamiento') // Evita que Bootstrap bloquee el select
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
  
  
  let tipoProcedimientoOdInicializado = false;

  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    const targetTab = $(e.target).attr('href');
  
    if (targetTab === '#tab_12' && !tipoProcedimientoOdInicializado) {
      selectTipoProcedimientoOdonto();
      tipoProcedimientoOdInicializado = true;
    }
  });


  function selectTipoProcedimientoOdonto() {
    $.ajax({
      // la URL para la petición
      url: urlServidor + "odontograma/listarprocedimiento",
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
        //    console.log(response);
        if (response.status) {
          let data = [{ id: 0, text: 'Seleccione el procedimiento' }];
          response.procedimiento.forEach(element => {
            data.push({ id: element.id, text: `${element.clave_pro} - ${element.descripcion_pro}` });
  
          });
  
          $('#odonto-procedimiento').empty();
  
          $('#odonto-procedimiento').select2({
  
            data: data,
            width: '100%', // Evita que se encoja
            dropdownParent: $('#modalTratamiento') // Evita que Bootstrap bloquee el select
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

  let tratamientoOdInicializado = false;

  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    const targetTab = $(e.target).attr('href');
  
    if (targetTab === '#tab_12' && !tratamientoOdInicializado) {
      cargarTratamiento_Odontograma();
      tratamientoOdInicializado = true;
    }
  });


function cargarTratamiento_Odontograma() {
    $.ajax({
      url: urlServidor + 'odontograma/listar_tratamientos',
      type: 'GET',
      dataType: 'json',
      beforeSend: function (xhr) {
        let token = localStorage.getItem('token');
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
      },
      success: function (response) {
        if (response.status) {
          let data = [{ id: 0, text: 'Seleccione el Tratamiento' }];
          response.tratamiento.forEach(element => {
            data.push({ id: element.id, text: `${element.nombre_tratamiento}` });
          });
  
          // Asegurar que el select está vacío antes de inicializarlo
          $('#tratamiento-odontograma').empty();
  
          // Inicializar select2 con el modal correcto
          $('#tratamiento-odontograma').select2({
            data: data,
            dropdownParent: $('#modalTratamiento'), // ID corregido
            width: '100%',
            allowClear: true,
            placeholder: "Seleccione el diagnostico",
            minimumResultsForSearch: 0
          });
        }
      },
      error: function () {
        console.log('❌ Error al cargar los tratamientos.');
      }
    });
  }


// 💡 Asegurar que el select funcione bien dentro del modal
$('#modalTratamiento').on('shown.bs.modal', function () {
    $('#tratamiento-odontograma').select2('open'); // Abrir automáticamente el select al abrir el modal
  });
  



/**editar detalle odonto */

function RecuperarDiagnosticoOdonto(selectedId = null) {
    $.ajax({
      url: urlServidor + 'odontograma/listardiagnostico',
      type: 'GET',
      dataType: 'json',
      beforeSend: function (xhr) {
        let token = localStorage.getItem('token');
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
      },
      success: function (response) {
        console.log(response);
        
        if (response.status) {
          let data = [{ id: 0, text: 'Seleccione el Diagnostico' }];
          response.diagnostico.forEach(element => {
            data.push({ id: element.id, text: `${element.clave_od} - ${element.descripcion_od}` });
          });
  
          // Llenar el select con los datos
          $('#Etratamiento-odontograma').empty().select2({
            data: data,
            width: '100%',
            dropdownParent: $('#modalTratamientoEditar')
          });
  
          // Si hay un valor seleccionado, asignarlo después de llenar los datos
          if (selectedId) {
            $('#Etratamiento-odontograma').val(selectedId).trigger('change');
          }
        }
      },
      error: function (jqXHR, status, error) {
        console.log('Disculpe, existió un problema');
      }
    });
  }



  function RecuperarTratamientoOdonto(selectedId = null) {
    $.ajax({
      url: urlServidor + 'odontograma/listar_tratamientos',
      type: 'GET',
      dataType: 'json',
      beforeSend: function (xhr) {
        let token = localStorage.getItem('token');
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
      },
      success: function (response) {
        if (response.status) {
          let data = [{ id: 0, text: 'Seleccione el Tratamiento' }];
          response.tratamiento.forEach(element => {
            data.push({ id: element.id, text: `${element.nombre_tratamiento}` });
          });
  
          // Llenar el select con los datos
          $('#Eodonto-diagnostico').empty().select2({
            data: data,
            width: '100%',
            dropdownParent: $('#modalTratamientoEditar')
          });
  
          // Si hay un valor seleccionado, asignarlo después de llenar los datos
          if (selectedId) {
            $('#Eodonto-diagnostico').val(selectedId).trigger('change');
          }
        }
      },
      error: function (jqXHR, status, error) {
        console.log('Disculpe, existió un problema');
      }
    });
  }
  

  function RecuperarProcedimientoOdonto(selectedId = null) {
    $.ajax({
      url: urlServidor + "odontograma/listarprocedimiento",
      type: 'GET',
      dataType: 'json',
      beforeSend: function (xhr) {
        let token = localStorage.getItem('token');
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
      },
      success: function (response) {
        if (response.status) {
          let data = [{ id: 0, text: 'Seleccione el procedimiento' }];
          response.procedimiento.forEach(element => {
            data.push({ id: element.id, text: `${element.clave_pro} - ${element.descripcion_pro}` });
  
          });
  
          // Llenar el select con los datos
          $('#Eodonto-procedimiento').empty().select2({
            data: data,
            width: '100%',
            dropdownParent: $('#modalTratamientoEditar')
          });
  
          // Si hay un valor seleccionado, asignarlo después de llenar los datos
          if (selectedId) {
            $('#Eodonto-procedimiento').val(selectedId).trigger('change');
          }
        }
      },
      error: function (jqXHR, status, error) {
        console.log('Disculpe, existió un problema');
      }
    });
  }


  function editar_odontograma(id) {
    $('#modalTratamientoEditar').modal('show');
    cargarOdontogramaxId(id);
  }


  function cargarOdontogramaxId(id) {
    $.ajax({
      url: urlServidor + 'odontograma/listarodontogramadetallexid/' + id,
      type: 'GET',
      headers: { "Authorization": `Bearer ${token}` },
      dataType: 'json',
      success: function (response) {
        console.log(response);
        if (response.status) {
          $('#editar-detodonto-id').val(id);
          $('#e-numero-pieza').val(response.ododetalle.pieza);
          $('#e-cuadrante').val(response.ododetalle.cuadrante);
  
          let diagnosticoId = response.ododetalle.diagnostico_odonto.id;
          let tratamientoId = response.ododetalle.tratamiento_odontograma.id;
          let procedimientoId = response.ododetalle.procedimiento_odonto.id;
          let estadoTratamiento = response.ododetalle.estado; // Recuperar el estado desde la BD
  
          // Llamar a la función de recuperación del select y pasar los ID
          RecuperarDiagnosticoOdonto(diagnosticoId);
          RecuperarTratamientoOdonto(tratamientoId);
          RecuperarProcedimientoOdonto(procedimientoId);
     //     RecuperarEodotonuevo(procedimientoId);
  
          // Establecer el valor en el select de estado
          $('#EestadoTratamiento').val(estadoTratamiento);
  
          // Actualizar el color en el odontograma
          let caraElemento = $('.diente[data-numero="' + response.ododetalle.pieza + '"] .cara[data-cara="' + response.ododetalle.cuadrante + '"]');
          caraElemento.removeClass("estado-por-hacer estado-encontrado estado-realizado");
  
          if (estadoTratamiento === "Por hacerse") {
            caraElemento.addClass("estado-por-hacer");
          } else if (estadoTratamiento === "Encontrado") {
            caraElemento.addClass("estado-encontrado");
          } else if (estadoTratamiento === "Realizado") {
            caraElemento.addClass("estado-realizado");
          }
  
  
  
  
        }
      },
      error: function (jqXHR, status, error) {
        console.log('Disculpe, existió un problema');
      }
    });
  }


  let editandoOddetallledInicializado = false;

  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    const targetTab = $(e.target).attr('href');
  
    if (targetTab === '#tab_12' && !editandoOddetallledInicializado) {
      editandodetalleOdonto();
      editandoOddetallledInicializado = true;
    }
  });



  function editandodetalleOdonto() {

    $('#EagregarTratamiento').click(function () {
  
  
  
      let id = $('#editar-detodonto-id').val();
      let pieza = $('#e-numero-pieza').val();
      let cuadrante = $('#e-cuadrante').val();
      let tratamiento_odontograma_id = $('#Eodonto-diagnostico option:selected').val();//sexo_id
      let procedimiento_odonto_id = $('#Eodonto-procedimiento option:selected').val();//sexo_id
      let diagnostico_odonto_id = $('#Etratamiento-odontograma option:selected').val();//sexo_id
      let estado = $('#EestadoTratamiento option:selected').val();
  
  
  
      let json = {
        odontograma_detalle: {
          id: id,
          pieza: pieza,
          cuadrante: cuadrante,
          tratamiento_odontograma_id: tratamiento_odontograma_id,
          procedimiento_odonto_id: procedimiento_odonto_id,
          diagnostico_odonto_id: diagnostico_odonto_id,
          estado: estado,
        }
      };
      console.log(json);
  
      $.ajax({
        // la URL para la petición
        url: urlServidor + 'odontograma/editarDetalleOdonto',
        type: 'POST',
        data: { data: JSON.stringify(json) },
        dataType: 'json',
        beforeSend: function (xhr) {
          // Envía el token JWT en el encabezado Authorization
          let token = localStorage.getItem('token');
          if (token) {
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
          }
        },
        success: function (response) {
  
          if (response.status) {
  
            Swal.fire({
              title: "Actualizar Odontograma",
              text: response.mensaje,
              icon: 'success'
            })
            $('#modalTratamientoEditar').modal('hide');
            // Actualizar el color en el odontograma al cambiar el estado
            let caraElemento = $('.diente[data-numero="' + pieza + '"] .cara[data-cara="' + cuadrante + '"]');
            caraElemento.removeClass("estado-por-hacer estado-encontrado estado-realizado");
  
            if (estado === "Por hacerse") {
              caraElemento.addClass("estado-por-hacer");
            } else if (estado === "Encontrado") {
              caraElemento.addClass("estado-encontrado");
            } else if (estado === "Realizado") {
              caraElemento.addClass("estado-realizado");
            }
  
            cargardtodonto2();
  
          } else {
  
            Swal.fire({
              title: "Actualizar Odontograma",
              text: response.mensaje,
              icon: 'error'
            })
  
  
          }
        },
        error: function (jqXHR, status, error) {
          console.log('Disculpe, existió un problema');
        },
        complete: function (jqXHR, status) {
          // console.log('Petición realizada');
        }
      });
  
    })
  }
  
function cargardtodonto2() {

  let paciente_id = localStorage.getItem('paciente_id');
 
  tabla3 = $('#tabla-odonto-listar').DataTable({
    "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "ajax":
    {
      url: urlServidor + 'odontograma/listar_odontogramas/' + paciente_id,
      type: "get",
      dataType: "json",
      beforeSend: function (xhr) {
        // Envía el token JWT en el encabezado Authorization
        let token = localStorage.getItem('token');
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
      },
      error: function (e) {
        console.log(e.responseText);
      }
    },
    destroy: true,
    "iDisplayLength": 10,//Paginación
    "language": {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando un total de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando un total de 0 registros",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",

      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      },

      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }

    }//cerrando language
  });


}


/**FIN DE ODONTOGRAAMA */



function eliminar_odontograma(id) {
    Swal.fire({
      title: '¿Estás seguro?',
      text: "Esta carilla del odontograma será eliminada y reestablecida a su estado original.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        eliminar_detalle(id); // Llama la función de eliminación
      }
    });
  }
  
  
  function eliminar_detalle(id) {
    console.log("Ejecutando eliminación en segundo plano para ID:", id);
  
    // Simula la carga de los datos sin abrir el modal
    $.ajax({
      url: urlServidor + 'odontograma/listarodontogramadetallexid/' + id,
      type: 'GET',
      headers: { "Authorization": `Bearer ${token}` },
      dataType: 'json',
      success: function (response) {
        console.log(response);
        if (response.status) {
          let pieza = response.ododetalle.pieza;
          let cuadrante = response.ododetalle.cuadrante;
  
          // Llamamos directamente a la función para eliminar sin abrir el modal
          eliminandodetalleOdonto(id, pieza, cuadrante, "Vacio");
        }
      },
      error: function () {
        console.log('Disculpe, existió un problema al obtener los datos.');
      }
    });
  }
  
  
  function eliminandodetalleOdonto(id, pieza, cuadrante, estado) {
    let json = {
      odontograma_detalle: {
        id: id,
        estado: estado,
        pieza: pieza,
        cuadrante: cuadrante
      }
    };
  
    console.log("Enviando eliminación con JSON:", json);
  
    $.ajax({
      url: urlServidor + 'odontograma/eliminarDetalleOdonto',
      type: 'POST',
      data: { data: JSON.stringify(json) },
      dataType: 'json',
      beforeSend: function (xhr) {
        let token = localStorage.getItem('token');
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
      },
      success: function (response) {
        if (response.status) {
          Swal.fire({
            title: "Actualizar Odontograma",
            text: response.mensaje,
            icon: 'success'
          });
  
          // Actualizar el color en el odontograma al cambiar el estado
          let caraElemento = $('.diente[data-numero="' + pieza + '"] .cara[data-cara="' + cuadrante + '"]');
          caraElemento.removeClass("estado-por-hacer estado-encontrado estado-realizado estado-vacio");
          caraElemento.addClass("estado-vacio"); // Restauramos el estado original
  
          cargardtodonto2();
        } else {
          Swal.fire({
            title: "Actualizar Odontograma",
            text: response.mensaje,
            icon: 'error'
          });
        }
      },
      error: function () {
        console.log('Disculpe, existió un problema al eliminar.');
      }
    });
  }
  
  






















  
//**INICIO DE GUARDAR CARILLAS DE 6  */

/* let detalleCompoCargarOdInicializado = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_12' && !detalleCompoCargarOdInicializado) {
    cargarDetalleComponente();
    detalleCompoCargarOdInicializado = true;
  }
}); */


function cargarDetalleComponente() {
    let paciente_id = localStorage.getItem('paciente_id');
    $.ajax({
      url: urlServidor + 'odontogramacomponente/obtenerDetalleComponente/' + paciente_id,  // Cambia la URL al endpoint que has creado
      type: 'GET',
      dataType: 'json',
      beforeSend: function (xhr) {
        let token = localStorage.getItem('token');
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
      },
      success: function (response) {
        if (response.status) {
     //     console.log("📌 Detalles de carillas recuperados:", response);

          let detallesComponente = response.detalles_componente;

          // Iterar sobre los detalles de las carillas y asignar los colores
          detallesComponente.forEach(detalle => {
            let numeroDiente = detalle.numeroDiente;
            let estadoCarilla = detalle.estadoCarilla;
            let elementoComponente = detalle.elementoComponente;

            // Obtener el color para el estado de la carilla
            let color2 = obtenerColorEstadoComponente(elementoComponente);

            // Selecciona la carilla correspondiente en el odontograma
            let carilla = $(`.diente[data-numero="${numeroDiente}"] .carilla[data-etiqueta="${estadoCarilla}"]`);

            if (carilla.length) {
              carilla.css('background-color', color2)  // Cambiar el color de fondo
                .removeClass('estado-por-hacer estado-encontrado estado-realizado estado-vacio')
                .addClass(`estado-${elementoComponente.replace(/\s+/g, '-').toLowerCase()}`);  // Añadir clase según el estado
            }
          });

        } else {
          console.log("❌ No se encontraron detalles de carillas.");
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log('❌ Error al obtener los detalles de las carillas:', errorThrown);
      }
    });
  }
  
  function obtenerColorEstadoComponente(elementoComponente) {
    switch (elementoComponente.toLowerCase().trim()) {
      case "por hacer":
        return "red";  // Color para "Por hacer"
      case "encontrado":
        return "blue";  // Color para "Encontrado"
      case "realizado":
        return "deepskyblue ";  // Color para "Realizado"
      default:
        return "white"; // Color predeterminado para otros estados
    }
  }
  

/*   
  let guardarOdElementoComponente = false;

  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    const targetTab = $(e.target).attr('href');
  
    if (targetTab === '#tab_12' && !guardarOdElementoComponente) {
      guardar_elementocomponente();
      guardarOdElementoComponente = true;
    }
  }); */

  
function guardar_elementocomponente() {
    $('#guardarCarilla').off('click').on('click', function () {
      //  let doctor_id = JSON.parse(localStorage.getItem('sesion-2')) || null;
      let citas_id = $('#citas-id').val();
  
      let numeroDiente = $('#numeroDiente').val();
      let estadoCarilla = $('#estadoCarilla').val();
      let elementoComponente = $('#estadoCarillaSeleccionado').val();  // Nuevo valor seleccionado en el modal
      let odontograma_id = $('#odonto-id').val();
      let tratamiento_odontograma_id = $('#carillaTratamiento option:selected').val();
      // let paciente_id = 1; // Asegúrate de que este valor esté correcto
  
      let json = {
        odonto_componentedetalle: {
          //  doctor_id: doctor_id,
          //  paciente_id: paciente_id,
          odontograma_id: odontograma_id,
          citas_id: citas_id,
          numeroDiente: numeroDiente,
          estadoCarilla: estadoCarilla,
          elementoComponente: elementoComponente,
          tratamiento_odontograma_id:tratamiento_odontograma_id
        }
      };
  
      console.log(json);
      guardando_detalle_componente(json);
  
      // Actualizar la carilla visualmente en el odontograma
      let carilla = $(`.carilla[data-diente="${numeroDiente}"][data-etiqueta="${estadoCarilla}"]`);
      if (carilla.length) {
        carilla.text(elementoComponente);
  
        // Opcional: cambiar el color según el estado
        if (elementoComponente === "Por hacer") {
          carilla.css('background-color', 'red');
        } else if (elementoComponente === "Encontrado") {
          carilla.css('background-color', 'blue');
        } else if (elementoComponente === "Realizado") {
          carilla.css('background-color', 'deepskyblue');
        } else if (elementoComponente === "Vacio") {
          carilla.css('background-color', 'white');
        }
      }
  
      // Cerrar el modal
      $('#modalCarilla').modal('hide');
    });
  }
  
  
function guardando_detalle_componente(json) {

    $.ajax({
      url: urlServidor + 'odontogramacomponente/guardar',
      type: 'POST',
      data: 'data=' + JSON.stringify(json),
      dataType: 'json',
      beforeSend: function (xhr) {
        // Envía el token JWT en el encabezado Authorization
        let token = localStorage.getItem('token');
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
      },
      success: function (response) {
        //    console.log(response);
        toastr.options = {
          "closeButton": true,
          "preventDuplicates": true,
          "positionClass": "toast-top-right",
          "progressBar": true,
        };
  
        if (response.estado) {
          toastr["success"](response.mensaje, "Registro de Componentes Odontograma");
          //  borrarCampos();
          //   $('#modal-registroProducto').modal('hide');
          //  datatable_productos();
          toastr["error"](response.mensaje, "Registro de Componentes Odontograma");
  
  
        } else {
          toastr["error"](response.mensaje, "Registro de Componentes Odontograma");
  
        }
      },
      error: function (jqXHR, status, error) {
        console.log('Disculpe, existió un problema');
  
      }
    });
  
  
  }
  

  let cargarTratamientoOdInicializado = false;

  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    const targetTab = $(e.target).attr('href');
  
    if (targetTab === '#tab_12' && !cargarTratamientoOdInicializado) {
      cargarTratamiento_OdCarillas();
      cargarTratamientoOdInicializado = true;
    }
  });


  function cargarTratamiento_OdCarillas() {
    $.ajax({
      url: urlServidor + 'odontograma/listar_tratamientos',
      type: 'GET',
      dataType: 'json',
      beforeSend: function (xhr) {
        let token = localStorage.getItem('token');
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
      },
      success: function (response) {
        if (response.status) {
          let data = [{ id: 0, text: 'Seleccione el Tratamiento' }];
          response.tratamiento.forEach(element => {
            data.push({ id: element.id, text: `${element.nombre_tratamiento}` });
          });
  
          // Asegurar que el select está vacío antes de inicializarlo
          $('#carillaTratamiento').empty();
  
          // Inicializar select2 con el modal correcto
          $('#carillaTratamiento').select2({
            data: data,
            dropdownParent: $('#modalCarilla'), // ID corregido
            width: '100%',
           
          });
        }
      },
      error: function () {
        console.log('❌ Error al cargar los tratamientos.');
      }
    });
  }
  
  
  $('#verPdf').on('click', function() {
   
    let id = localStorage.getItem('citas_id');
    $.ajax({
      url: urlServidor + 'citas/listarcitasxid/' + id,
      type: 'GET',
      dataType: 'json',
      beforeSend: function (xhr) {
        let token = localStorage.getItem('token');
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
      },
      success: function (response) {
        if (response.status) {
          let paciente_id = response.citas.paciente_id;
  
          let url = urlServidor + 'informeodonto/' + paciente_id ;
          window.open(url, '_blank');
        
        
  
        
        } else {
          console.log("Error al obtener datos del paciente.");
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        // console.log('❌ Error en la solicitud de cita:', error);
      }
    });
  });
    
  
  let selectTipoProceOdInicializado = false;

  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    const targetTab = $(e.target).attr('href');
  
    if (targetTab === '#tab_12' && !selectTipoProceOdInicializado) {
      selectTipoProcedimiento();
      selectTipoProceOdInicializado = true;
    }
  });

  function selectTipoProcedimiento() {
    $.ajax({
      // la URL para la petición
      url: urlServidor + "tipoestudio/listar",
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
        // console.log(response);
        if (response.status) {
          let data = [{ id: 0, text: 'Seleccione el procedimiento' }];
          response.tipo_Estudio.forEach(element => {
            data.push({ id: element.id, text: `${element.codigo} - ${element.descripcion}` });
  
          });
  
          $('#odontograma-procedimiento').select2({
            data: data,
  
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