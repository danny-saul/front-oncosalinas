var detalleProducto = [];
var detalle_diagnostico = [];
var detalle_orden = [];
var detalle_orden_laboratorio = [];
var tabla2;
var tabla3;

_init();

function _init() {
  RecuperarTratamientoOdonto();
  RecuperarDiagnosticoOdonto();
  RecuperarProcedimientoOdonto();
  selectTipoProcedimientoOdonto();
  cargardtodonto();
  cargarTratamiento_Odontograma();
  cargarDiagnosticoOdonto();
  cargarOdontograma();
  listar_resumen();
  cargarDetalleComponente();
  guardar_elementocomponente();
 // calcularSuma();
 // selectTipoProcedimiento();
 // cargarDiagnostico();
 // selectTipoExamenLaboratorio();
 // selectMedicamento();
 // agregarProductos();
 // cargarDosis();
 // cargarFrecuencia();
 // agregarDiagnosticos1();
 // guardar_producto();
  storage_citas();
//  guardarHistorial();
 // cargarTipo_diagnostico();
//  selectTipoEstudio();
///  agregarOrden();
//  generarNumerosOrden();
//  datatable_antecedentes();
 // generarNumerosOrden_laboratorio();
 /// agregarOrden_laboratorio();
 // cargarAntecedentes();
 // cargarAntecedentesfamiliares();
//  guardar_antecendente_paciente();
//  guardar_antecendente_familiares();
  guardarOdontograma();
  

  editandodetalleOdonto();
  eliminandodetalleOdonto();
}




function listar_resumen() {

    let id = localStorage.getItem('citas_id');
  
    $.ajax({
      // la URL para la petición
      url: urlServidor + 'citas/listarcitasxid/' + id,
      // especifica si será una petición POST o GET
      type: 'GET',
      // el tipo de información que se espera de respuesta
      dataType: 'json',
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
          $('#cita-id').text(response.citas.id);
          $('#citas-id').val(response.citas.id);
          $('#paciente-id').val(response.citas.paciente_id);
    
          let paciente_id = response.citas.paciente_id;
    
          $.ajax({
            // la URL para la petición
            url: urlServidor + 'citas/listarcitas_xid/' + paciente_id,
            // especifica si será una petición POST o GET
            type: 'GET',
            // el tipo de información que se espera de respuesta
            dataType: 'json',
            beforeSend: function (xhr) {
              // Envía el token JWT en el encabezado Authorization
              let token = localStorage.getItem('token');
              if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
              }
            },
            success: function (response) {
              let div = '';
    
              console.log(response);
              if (response.status) {
                let fechaNacimiento = response.paciente.persona.fecha_nacimiento;
    
                let fechaNac = new Date(fechaNacimiento);
                let hoy = new Date();
    
                let diff = hoy.getTime() - fechaNac.getTime();
                let edad = new Date(diff);
    
                let años = edad.getUTCFullYear() - 1970;
                let meses = edad.getUTCMonth();
                let días = edad.getUTCDate() - 1;
    
                $('#resumen-edad').text(`${años} años, ${meses} meses y ${días} días`);
                $('#resumen-paciente').text(response.paciente.persona.nombre + ' ' + response.paciente.persona.apellido);
                $('#resumen-fechanac').text(response.paciente.persona.fecha_nacimiento);
                $('#resumen-cedula').text(response.paciente.persona.cedula);
              //  $('#resumen-direccion').text(response.paciente.persona.direccion);
    
                // Ordenar las citas por fecha descendente
                response.paciente.citas.sort((a, b) => new Date(b.fecha) - new Date(a.fecha));
    
                response.paciente.citas.forEach(cita => {
                  div += `
                    <div class="row">
  
  
                   
  
  
  
  
  
  
  
  
  
  
                      <div class="col-3 d-flex flex-column align-items-center mt-15" style="margin-top: 182px;">
                        <p class="mb-2"><i class="fas fa-user"></i> Médico: ${cita.doctor.persona.nombre + ' ' + cita.doctor.persona.apellido}</p> 
                        <p class="mb-2">Especialidad: </p>
                        <p class="mb-2">Fecha: ${cita.fecha}  </p> 
                        <p class="mb-2">Código: ${cita.codigo_cita} </p> 
                      </div>
                      <div class="col-9">
  
                                             <div class="row">
                                                     <div class="col-md-1">
                                                          <label>Temp.</label>  <i class="fas fa-temperature-high"></i>
                                                          <div class="input-group mb-3">
                                                              <div class="input-group-prepend">
                                                               
                                                              </div>
                                                              <input type="text" 
                                                                  class="form-control" readonly placeholder="ºC"
                                                                  value="${cita.examen_fisica && cita.examen_fisica[0] ? cita.examen_fisica[0].temperatura : ''}">
                                                          </div>
                                                      </div>
  
  
                                                          <div class="col-md-1">
                                                              <label>Peso</label>  <i class="fas fa-weight"></i>
                                                              <div class="input-group mb-3">
                                                                  <div class="input-group-prepend">
                                                                      
                                                                  </div>
                                                                  <input type="number"  class="form-control"
                                                                      placeholder="Kg" readonly value="${cita.examen_fisica && cita.examen_fisica[0] ? cita.examen_fisica[0].peso : ''}">
                                                              </div>
                                                          </div>
  
                                                          <div class="col-md-1">
                                                              <label>Talla</label>  <i class="fas fa-h-square"></i>
                                                              <div class="input-group mb-3">
                                                                  <div class="input-group-prepend">
                                                                      
                                                                  </div>
                                                                  <input type="number" readonly placeholder="1.50" id="h-tal" class="form-control" value="${cita.examen_fisica && cita.examen_fisica[0] ? cita.examen_fisica[0].talla : ''}">
                                                              </div>
                                                          </div>
  
                                                               <div class="col-md-1">
                                                              <label>IMC</label>  <i class="fas fa-diagnoses"></i>
                                                              <div class="input-group mb-3">
                                                                  <div class="input-group-prepend">
                                                                     
                                                                  </div>
                                                                  <input type="number"   class="form-control"
                                                                      placeholder="IMC" readonly value="${cita.examen_fisica && cita.examen_fisica[0] ? cita.examen_fisica[0].imc : ''}">
                                                              </div>
                                                          </div>
  
                                                          <div class="col-md-1">
                                                              <label>Pulso</label>    <i class="fas fa-stethoscope"></i>
                                                              <div class="input-group mb-3">
                                                                  <div class="input-group-prepend">
                                                                      
                                                                  </div>
                                                                  <input type="number" readonly id="h-pul" class="form-control"
                                                                      placeholder="/minuto" value="${cita.examen_fisica && cita.examen_fisica[0] ? cita.examen_fisica[0].pulso : ''}">
                                                              </div>
                                                          </div>
  
  
                                                          <div class="col-md-2">
                                                              <label>Presion Arterial</label>    <i class="fas fa-heartbeat"></i>
                                                              <div class="input-group mb-3">
                                                                  <div class="input-group-prepend">
                                                                      
                                                                  </div>
                                                                  <input type="text" 
                                                                      class="form-control" readonly placeholder="/minuto" value="${cita.examen_fisica && cita.examen_fisica[0] ? cita.examen_fisica[0].presion_arterial : ''}">
  
                                                              </div>
                                                          </div>
  
                                                     
  
                                                              <div class="col-md-2">
                                                              <label>Saturacion Oxigeno </label> <i class="fas fa-lungs"></i>
                                                              <div class="input-group mb-3">
                                                                  <div class="input-group-prepend">
                                                                       
                                                                  </div>
                                                                  <input type="number" 
                                                                      class="form-control" readonly placeholder="" value="${cita.examen_fisica && cita.examen_fisica[0] ? cita.examen_fisica[0].saturacion_oxigeno : ''}">
                                                              </div>
                                                          </div>
  
  
  
                                                     
                                                          
                                                          <div class="col-md-2">
                                                              <label>Frecuencia Respiratoria </label>  <i class="fas fa-lungs"></i>
                                                              <div class="input-group mb-3">
                                                                  <div class="input-group-prepend">
                                                                      
                                                                  </div>
                                                                  <input type="text"  
                                                                      class="form-control" readonly placeholder="/minuto" value="${cita.examen_fisica && cita.examen_fisica[0] ? cita.examen_fisica[0].frecuencia_respiratoria : ''}">
                                                              </div>
                                                          </div>
  
  
                                                      
  
                                            </div>
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
                        <div class="callout callout-info">
                          <p>Motivo Consulta: ${cita.historial_clinico && cita.historial_clinico[0] ? cita.historial_clinico[0].motivo_consulta : 'No hay historial clínico definido'}</p>
                          <p>Antecedentes: ${cita.historial_clinico && cita.historial_clinico[0] ? cita.historial_clinico[0].antecedentes : 'No hay historial clínico definido'}</p>
                          <p>Problema Actual: ${cita.historial_clinico && cita.historial_clinico[0] ? cita.historial_clinico[0].enfermedad_actual : 'No hay historial clínico definido'}</p>
                          <p>Diagnóstico Definitivo:</p>
                          ${cita.receta && cita.receta.length > 0 && cita.receta[0].receta_diagnostico && cita.receta[0].receta_diagnostico.length > 0 ?
                            `<ul>${cita.receta[0].receta_diagnostico
                              .filter(diagnostico => diagnostico.tipo_diagnostico_id === 1)
                              .map(diagnostico => `<li>${diagnostico.diagnosticocie10.descripcion}</li>`)
                              .join('')}</ul>` : '<p></p>'}
  
                             ${cita.receta_diagnostico && cita.receta_diagnostico.length > 0 ?
                          `<ul>${cita.receta_diagnostico
                            .filter(diagnostico => diagnostico.tipo_diagnostico_id === 1)
                            .map(diagnostico => `<li>${diagnostico.diagnosticocie10.descripcion}</li>`)
                            .join('')}</ul>` : '<p></p>'
                        }    
                          <p>Diagnóstico Presuntivo:</p>
                          ${cita.receta && cita.receta.length > 0 && cita.receta[0].receta_diagnostico && cita.receta[0].receta_diagnostico.length > 0 ?
                            `<ul>${cita.receta[0].receta_diagnostico
                              .filter(diagnostico => diagnostico.tipo_diagnostico_id === 2)
                              .map(diagnostico => `<li>${diagnostico.diagnosticocie10.descripcion}</li>`)
                              .join('')}</ul>` : '<p></p>'}
  
                              ${cita.receta_diagnostico && cita.receta_diagnostico.length > 0 ?
                          `<ul>${cita.receta_diagnostico
                            .filter(diagnostico => diagnostico.tipo_diagnostico_id === 2)
                            .map(diagnostico => `<li>${diagnostico.diagnosticocie10.descripcion}</li>`)
                        .join('')}</ul>` : '<p></p>'
                    }
  
                          <p>Receta:</p>
                          ${cita.receta && cita.receta.length > 0 ?
                            `<ul>${cita.receta
                              .map(item => `<li>${item.producto.nombre_producto} - Cantidad: ${item.cantidad} - Frecuencia: ${item.frecuencia.tipo_frecuencia}</li>`)
                              .join('')}</ul>` : '<p>No hay receta disponible</p>'}
                          <p>Imágenes:</p>
                          ${cita.ordenes && cita.ordenes.length > 0 ?
                            `<ul>${cita.ordenes
                              .map(orden => `<li>Código: ${orden.tipo_estudio.codigo} - ${orden.tipo_estudio.descripcion}</li>`)
                              .join('')}</ul>` : '<p>No hay órdenes de imágenes disponibles</p>'}
  
                              
                        <p>Laboratorio:</p>
                      ${cita.laboratorio && cita.laboratorio.length > 0 ? 
                        `<ul>${cita.laboratorio
                          .map(lab => {
                            return lab.laboratorio_detalle && lab.laboratorio_detalle.length > 0 ? 
                              lab.laboratorio_detalle
                                .map(detalle => `<li>Código: ${detalle.tipo_examen.codigo_lab} - ${detalle.tipo_examen.descripcion_lab} </li>`)
                                .join('') 
                              : '<li>No hay detalles de laboratorio disponibles</li>';
                          })
                          .join('')}</ul>` : '<p>No hay órdenes de exámenes disponibles</p>'
                      }
  
                        </div>
                      </div>
                    </div>`;
                });
    
                $('#resumen-historial').html(div);
              } else {
                div = `<div class="col-12">
                  <div class="alert alert-danger" role="alert">
                  No hay Ordenes Pendientes Disponibles
                  </div>
                </div>`;
                $('#resumen-historial').html(div);
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
      },
      error: function (jqXHR, status, error) {
        console.log('Disculpe, existió un problema');
      },
      complete: function (jqXHR, status) {
        // console.log('Petición realizada');
      }
    });
    
  
  }




function storage_citas() {
  let id = localStorage.getItem('citas_id');

  $.ajax({
    // la URL para la petición
    url: urlServidor + 'citas/listarcitasxid/' + id,
    // especifica si será una petición POST o GET
    type: 'GET',
    // el tipo de información que se espera de respuesta
    dataType: 'json',
    beforeSend: function (xhr) {
      // Envía el token JWT en el encabezado Authorization
      let token = localStorage.getItem('token');
      if (token) {
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
      }
    },
    success: function (response) {
      //   console.log(response);
      if (response.status) {
        $('#cita-id').text(response.citas.id);
        $('#citas-id').val(response.citas.id);
        $('#paciente-id').val(response.citas.paciente_id);
        //   $('#doctor-id').val(response.citas.doctor.id);
        $('#nombres-apellidos').text(response.citas.paciente.persona.nombre + ' ' + response.citas.paciente.persona.apellido);
        $('#medico-nombre').text(response.citas.doctor.persona.nombre + ' ' + response.citas.doctor.persona.apellido);
        $('#cedula').text(response.citas.paciente.persona.cedula);
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







 
 
 





/**INICIO DE ODONTOGRAMA */




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
        tratamiento_odontograma_id:tratamiento_odontograma_id,
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

function cargarOdontograma() {
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
          } else {
              console.log("Error al obtener datos del paciente.");
          }
      },
      error: function (jqXHR, textStatus, errorThrown) {
      //    console.log('❌ Error en la solicitud de cita:', error);
      }
  });
}



  function obtenerColorEstado(estado) {
  //  console.log("🧐 Estado recibido en obtenerColorEstado:", estado); // Verificar qué valor llega
    switch (estado.toLowerCase().trim()) {
        case "por hacerse":
            return "yellow";
        case "encontrado":
            return "blue";
        case "realizado":
            return "green";
        default:
            return "white"; // Si el estado no es reconocido, devolver blanco
    }
}


// Llamar a la función cuando se carga la página
$(document).ready(function () {
  let paciente_id = $('#paciente-id').val();
  if (paciente_id) {
    cargarOdontograma(paciente_id);
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
        response.diagnostico.forEach(element => {
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



function cargardtodonto() {

  let id = localStorage.getItem('citas_id');
  $.ajax({
    url: urlServidor + 'citas/listarcitasxid/' + id,
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
      if (response.status) {


        let paciente_id = response.citas.paciente_id;

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



      } else {
        console.log("Error al obtener datos de la cita");
      }
    },
    error: function (jqXHR, status, error) {
      console.log('Disculpe, existió un problema');
    }
  });


}

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
        response.diagnostico.forEach(element => {
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
        RecuperarTratamientoOdonto(tratamientoId);
        RecuperarDiagnosticoOdonto(diagnosticoId);
        RecuperarProcedimientoOdonto(procedimientoId);

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


function editandodetalleOdonto() {

  $('#EagregarTratamiento').click(function () {
  
    

      let id = $('#editar-detodonto-id').val();
      let pieza = $('#e-numero-pieza').val();
      let cuadrante= $('#e-cuadrante').val();
      let tratamiento_odontograma_id = $('#Eodonto-diagnostico option:selected').val();//sexo_id
      let procedimiento_odonto_id = $('#Eodonto-procedimiento option:selected').val();//sexo_id
      let diagnostico_odonto_id = $('#Etratamiento-odontograma option:selected').val();//sexo_id
      let estado = $('#EestadoTratamiento option:selected').val();

     

      let json = {
        odontograma_detalle: {
              id: id,
              pieza: pieza,
              cuadrante: cuadrante,
              tratamiento_odontograma_id:tratamiento_odontograma_id,
              procedimiento_odonto_id:procedimiento_odonto_id,
              diagnostico_odonto_id:diagnostico_odonto_id,
              estado:estado,
          }
      };
      console.log(json);
   
        $.ajax({
          // la URL para la petición
          url: urlServidor + 'odontograma/editarDetalleOdonto',
          type: 'POST',
          data: { data: JSON.stringify(json) },
          dataType: 'json',
          beforeSend: function(xhr) {
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

  let id = localStorage.getItem('citas_id');
  $.ajax({
    url: urlServidor + 'citas/listarcitasxid/' + id,
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
      if (response.status) {


        let paciente_id = response.citas.paciente_id;

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



      } else {
        console.log("Error al obtener datos de la cita");
      }
    },
    error: function (jqXHR, status, error) {
      console.log('Disculpe, existió un problema');
    }
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
    beforeSend: function(xhr) {
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
 

  function guardar_elementocomponente() {
    $('#guardarCarilla').off('click').on('click', function () {
      //  let doctor_id = JSON.parse(localStorage.getItem('sesion-2')) || null;
        let citas_id = $('#citas-id').val();

        let numeroDiente = $('#numeroDiente').val();
        let estadoCarilla = $('#estadoCarilla').val();
        let elementoComponente = $('#estadoCarillaSeleccionado').val();  // Nuevo valor seleccionado en el modal
        let odontograma_id = $('#odonto-id').val();
       // let paciente_id = 1; // Asegúrate de que este valor esté correcto

        let json = {
            odonto_componentedetalle: {
              //  doctor_id: doctor_id,
              //  paciente_id: paciente_id,
                odontograma_id: odontograma_id,
                citas_id: citas_id,
                numeroDiente: numeroDiente,
                estadoCarilla: estadoCarilla,
                elementoComponente: elementoComponente
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
                carilla.css('background-color', 'yellow');
            } else if (elementoComponente === "Encontrado") {
                carilla.css('background-color', 'blue');
            } else if (elementoComponente === "Realizado") {
                carilla.css('background-color', 'green');
            }
        }

        // Cerrar el modal
        $('#modalCarilla').modal('hide');
    });
}


function guardando_detalle_componente(json){

  $.ajax({
    url: urlServidor + 'odontogramacomponente/guardar',
    type: 'POST',
    data: 'data=' + JSON.stringify(json),
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
        toastr.options = {
            "closeButton": true,
            "preventDuplicates": true,
            "positionClass": "toast-top-right",
            "progressBar": true,
        };

        if (response.estado) {
            toastr["success"](response.mensaje, "Registro de Productos");
          //  borrarCampos();
         //   $('#modal-registroProducto').modal('hide');
          //  datatable_productos();
            toastr["error"](response.mensaje, "Registro de Productos");
          

        }else{
            toastr["error"](response.mensaje, "Registro de Productos");

        }
    },
    error: function (jqXHR, status, error) {
        console.log('Disculpe, existió un problema');

    }
});

 
}



function cargarDatosOd() {
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
          } else {
              console.log("Error al obtener datos del paciente.");
          }
      },
      error: function (jqXHR, textStatus, errorThrown) {
      //    console.log('❌ Error en la solicitud de cita:', error);
      }
  });
}


function cargarDetalleComponente() {
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
                          console.log("📌 Detalles de carillas recuperados:", response);

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
                                    .removeClass('estado-por-hacer estado-encontrado estado-realizado')
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
          } else {
              console.log("Error al obtener datos del paciente.");
          }
      },
      error: function (jqXHR, textStatus, errorThrown) {
          // console.log('❌ Error en la solicitud de cita:', error);
      }
  });
}

function obtenerColorEstadoComponente(elementoComponente) {
  switch (elementoComponente.toLowerCase().trim()) {
      case "por hacer":
          return "yellow";  // Color para "Por hacer"
      case "encontrado":
          return "blue";  // Color para "Encontrado"
      case "realizado":
          return "green";  // Color para "Realizado"
      default:
          return "white"; // Color predeterminado para otros estados
  }
}


// Llamar a la función cuando se carga la página
$(document).ready(function () {
  let paciente_id = $('#paciente-id').val();
  if (paciente_id) {
      cargarDetalleComponente(paciente_id);
  }
});
