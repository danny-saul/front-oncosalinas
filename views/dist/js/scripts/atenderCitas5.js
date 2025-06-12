var detalleProducto = [];
var detalle_diagnostico = [];
var detalle_orden = [];
var detalle_orden_laboratorio = [];
var tabla2;
var tabla3;

_init();

function _init() {
  storage_citas();
  listar_resumen();
  cargarAntecedentes();
  datatable_antecedentes();
  cargarAntecedentesfamiliares();
  guardarHistorial();

}


function storage_citas() {
  let id = localStorage.getItem('citas_id');

  peticionJWT({
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



function listar_resumen() {
  // Obtener paciente_id directamente desde localStorage
  let paciente_id = localStorage.getItem('paciente_id');

  if (!paciente_id) {
    console.error('No se encontró el paciente_id en localStorage');
    return;
  }

  // Mostrar el loader mientras se hace la petición
  $('#loader').show();

  peticionJWT({
    url: urlServidor + 'citas/listarcitas_xid/' + paciente_id,
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
        console.log(response);

        // Usar un documentFragment para construir el HTML
        let fragment = document.createDocumentFragment();
        let div = '';

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
        $('#resumen-tel').text(response.paciente.persona.celular);
        $('#direccion-resumen').text(response.paciente.persona.direccion);
        $('#sexo-tipo').text(response.paciente.persona.sexo.tipo);
        $('#id-historia').text(response.paciente.id);

        // Ordenar las citas por fecha descendente
        /*   response.citas.sort((a, b) => new Date(b.fecha) - new Date(a.fecha));
   */

        // Ordenar las citas por fecha descendente
        response.citas.sort((a, b) => new Date(b.fecha) - new Date(a.fecha));

        // Verificar si hay citas atendidas
        /*         if (response.citas.length === 0) {
                  div = `<div class="col-12 text-center">
                   <lottie-player 
                     src="https://assets6.lottiefiles.com/private_files/lf30_tnrzlN.json"  
                     background="transparent"  
                     speed="1"  
                     style="width: 300px; height: 300px; margin: auto;"  
                     loop  
                     autoplay>
                   </lottie-player>
                   <div class="alert alert-info mt-3" role="alert">
                     No existen citas anteriores registradas para este paciente.
                   </div>
                 </div>`;
                  $('#resumen-historial').html(div);
                  return;
                }
         */

        if (response.citas.length === 0) {
          div = `<div class="col-12 text-center">
          <div class="alert alert-info mt-3" role="alert">
          No existen citas anteriores registradas para este paciente.
          </div>
          <img src=" ${urlCliente}/views/dist/img/download2.gif" alt="Sin datos" style="max-width: 300px;">
          </div>`;
          $('#resumen-historial').html(div);
          return;
        }




        response.citas.forEach(cita => {
          div += `
            <div class="row">
              <div class="col-3 d-flex flex-column align-items-center mt-15" style="margin-top: 182px;">
                <p class="mb-2"><i class="fas fa-user"></i> Médico: ${cita.doctor.persona.nombre + ' ' + cita.doctor.persona.apellido}</p> 
                <p class="mb-2">Especialidad: </p>
                <p class="mb-2">Fecha: ${cita.fecha_hora}</p> 
                <p class="mb-2">Código: ${cita.codigo_cita}</p> 
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
${cita.receta && cita.receta.length > 0 && cita.receta[0].receta_diagnostico ?
  (() => {
    const definitivos = cita.receta[0].receta_diagnostico
      .filter(d => d.tipo_diagnostico_id === 1 && d.estado === "A");
    return definitivos.length > 0
      ? `<ul>${definitivos.map(d => `<li>${d.diagnosticocie10.descripcion}</li>`).join('')}</ul>`
      : '<p></p>';
  })()
: '<p></p>'}

${cita.receta_diagnostico ?
  (() => {
    const definitivosExtra = cita.receta_diagnostico
      .filter(d => d.tipo_diagnostico_id === 1 && d.estado === "A");
    return definitivosExtra.length > 0
      ? `<ul>${definitivosExtra.map(d => `<li>${d.diagnosticocie10.descripcion}</li>`).join('')}</ul>`
      : '<p></p>';
  })()
: '<p></p>'}

<p>Diagnóstico Presuntivo:</p>
${cita.receta && cita.receta.length > 0 && cita.receta[0].receta_diagnostico ?
  (() => {
    const presuntivos = cita.receta[0].receta_diagnostico
      .filter(d => d.tipo_diagnostico_id === 2 && d.estado === "A");
    return presuntivos.length > 0
      ? `<ul>${presuntivos.map(d => `<li>${d.diagnosticocie10.descripcion}</li>`).join('')}</ul>`
      : '<p></p>';
  })()
: '<p></p>'}

${cita.receta_diagnostico ?
  (() => {
    const presuntivosExtra = cita.receta_diagnostico
      .filter(d => d.tipo_diagnostico_id === 2 && d.estado === "A");
    return presuntivosExtra.length > 0
      ? `<ul>${presuntivosExtra.map(d => `<li>${d.diagnosticocie10.descripcion}</li>`).join('')}</ul>`
      : '<p></p>';
  })()
: '<p></p>'}


                  <p>Receta:</p>
              ${cita.ultima_receta && cita.ultima_receta.receta_detalle && cita.ultima_receta.receta_detalle.length > 0
              ? `<ul>${cita.ultima_receta.receta_detalle
                .filter(item => item.estado === 'A')
                .map(item => {
                  const nombre = item.producto?.nombre_producto || 'Producto desconocido';
                  const cantidad = item.cantidad || '-';
                  const frecuencia = item.frecuencia?.tipo_frecuencia || '-';
                  return `<li>${nombre} - Cantidad: ${cantidad} - Frecuencia: ${frecuencia}</li>`;
                })
                .join('')}</ul>`
              : '<p>No hay receta disponible</p>'}

             <p>Imágenes:</p>
                ${cita.ordenes && cita.ordenes.length > 0 && cita.ordenes.some(orden => orden.estado === 'A') ?
                  `<ul>${cita.ordenes
                    .filter(orden => orden.estado === 'A')
                    .map(orden => `<li>Código: ${orden.tipo_estudio.codigo} - ${orden.tipo_estudio.descripcion}</li>`)
                    .join('')}</ul>` 
                  : '<p>No hay órdenes de imágenes disponibles</p>'}

                            
            <p>Orden de laboratorio:</p>
${cita.ultima_orden_lab && cita.ultima_orden_lab.laboratorio_detalle?.length > 0 ?
  (() => {
    const detallesActivos = cita.ultima_orden_lab.laboratorio_detalle
      .filter(detalle => detalle.estado === "A");
    return detallesActivos.length > 0
      ? `<ul>
          ${detallesActivos.map(detalle => `
            <li>
              Código: ${detalle.tipo_examen.codigo_lab} - ${detalle.tipo_examen.descripcion_lab} - RR: ${detalle.resultado_examen}
            </li>
          `).join('')}
        </ul>`
      : '<p>No hay detalles activos de la última orden de laboratorio</p>';
  })()
: '<p>No hay detalles de la última orden de laboratorio disponibles</p>'}

            


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
      $('#loader').hide(); // Ocultar el loader
    }
  });
}

let generarNumOrdenInicializado = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_4' && !generarNumOrdenInicializado) {
    generarNumerosOrden();
    generarNumOrdenInicializado = true;
  }
});


function generarNumerosOrden() {
  peticionJWT({
    url: urlServidor + 'ordenes/generar_numeros_aleartorios/Tabla_Orden',
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
      //       console.log(response);
      if (response.estado) {
        $('#nuevo-orden').val(response.numero);
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

function guardarCodigo() {
  let numeros = $('#nuevo-orden').val();

  let json = {
    numeros: {
      numeros: numeros,
      id_tablas: 'Tabla_Orden'
    }
  }

  peticionJWT({
    url: urlServidor + 'ordenes/aumentarNumerosAleartorios',
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
      //  console.log(response);
      generarNumerosOrden();
    },
    error: function (jqXHR, status, error) {
      console.log('Disculpe, existió un problema');
    },
    complete: function (jqXHR, status) {
      // console.log('Petición realizada');
    }
  });
}


/* let diagnosticoInicializado = false;

$('#nuevo-diagnostico1').one('focus', function () {
  if (!diagnosticoInicializado) {
    cargarDiagnostico();
    diagnosticoInicializado = true;
  }
}); */

let diagnosticoInicializado = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !diagnosticoInicializado) {
    cargarDiagnostico();
    diagnosticoInicializado = true;
  }
});


function cargarDiagnostico() {
  /*   peticionJWT({
      url: urlServidor + 'diagnostico/listar',
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
        //   console.log(response);
  
        if (response.status) {
          let data = [{ id: 0, text: 'Seleccione el Diagnostico' }];
          response.diagnostico.forEach(element => {
            data.push({ id: element.id, text: `${element.clave} - ${element.descripcion}` });
          });
  
          $('#nuevo-diagnostico1').select2({
            data: data
          });
  
  
          $('#nuevo-diagnostico2').select2({
            data: data
          });
  
  
  
  
        }
      },
      error: function (jqXHR, status, error) {
        console.log('Disculpe, existió un problema');
      },
      complete: function (jqXHR, status) {
        // console.log('Petición realizada');
      }
    }); */


  $('#nuevo-diagnostico1').select2({
    placeholder: 'Buscar diagnóstico...',
    allowClear: true,
    minimumInputLength: 2,
    ajax: {
      url: urlServidor + 'diagnostico/buscar',
      dataType: 'json',
      delay: 250,
      headers: {
        Authorization: 'Bearer ' + localStorage.getItem('token')
      },
      data: function (params) {
        return {
          q: params.term
        };
      },
      processResults: function (data) {
        if (data.status && data.diagnostico) {
          return {
            results: data.diagnostico.map(item => ({
              id: item.id,
              text: item.clave + ' - ' + item.descripcion
            }))
          };
        } else {
          return {
            results: []
          };
        }
      },
      cache: true
    },
    language: {
      inputTooShort: function () {
        return 'Por favor ingrese 2 o más caracteres'; // Mensaje en español
      },
      noResults: function () {
        return 'No se encontró ningún diagnóstico';
      }
    }
  });

}





/*RECETA----------------------------- */

let dosisInicializar = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !dosisInicializar) {
    cargarDosis();
    dosisInicializar = true;
  }
});


function cargarDosis() {
  peticionJWT({
    url: urlServidor + 'dosis/listar',
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
      //     console.log(response);

      if (response.status) {
        let option = '<option value="0">Seleccione la dosis</option>';
        response.dosis.forEach(element => {
          option += `<option value=${element.id}>${element.tipo_dosis} </option>`;
        });
        $('#dosis').html(option);
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

let frecuenciaInicializar = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !frecuenciaInicializar) {
    cargarFrecuencia();
    frecuenciaInicializar = true;
  }
});

function cargarFrecuencia() {
  peticionJWT({
    url: urlServidor + 'frecuencia/listar',
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
        let option = '<option value="0">Seleccione la frecuencia</option>';
        response.frecuencia.forEach(element => {
          option += `<option value=${element.id}>${element.tipo_frecuencia} </option>`;
        });
        $('#frecuencia').html(option);
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

let viaInicializar = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !viaInicializar) {
    cargarVia();
    viaInicializar = true;
  }
});

function cargarVia() {
  peticionJWT({
    url: urlServidor + 'via/listar',
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
        let option = '<option value="0">Seleccione la via</option>';
        response.via.forEach(element => {
          option += `<option value=${element.id}>${element.tipo_via} </option>`;
        });
        $('#via').html(option);
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

let medicamentoInicializar = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !medicamentoInicializar) {
    selectMedicamento();
    medicamentoInicializar = true;
  }
});

function selectMedicamento() {
  peticionJWT({
    // la URL para la petición
    url: urlServidor + "producto/listar",
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
      //  console.log(response);
      if (response.status) {
        let data = response.producto.map(element => ({
          id: element.id,
          text: element.nombre_producto
        }));

        $('#nuevo-medicamento').select2({
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




let productoAgregadoInicializado = false;

$('#tab_2').click(function () {
  if (!productoAgregadoInicializado) {
    agregarProductos();  // Llama a la función solo cuando se hace clic en el tab
    productoAgregadoInicializado = true;
  }
});


function agregarProductos() {
  $('#btn-agregar').click(function () {

    let producto_id = $('#nuevo-medicamento option:selected').val();

    if (producto_id == "0") {
      Swal.fire({
        title: "Receta",
        text: 'Seleccione un medicamento',
        icon: 'error'
      })
    } else {
      peticionJWT({
        // la URL para la petición
        url: urlServidor + "producto/listar/" + producto_id,
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
          //     console.log(response);
          if (response.status) {


            let nombre_producto = $('#nuevo-medicamento option:selected').text();
            let cantidad = $('#nuevo-cantidad').val();
            let dosis_id = $('#dosis option:selected').val();
            let dosis = $('#dosis option:selected').text();
            let frecuencia_id = $('#frecuencia option:selected').val();
            let frecuencia = $('#frecuencia option:selected').text();
            let via_id = $('#via option:selected').val();
            let via = $('#via option:selected').text();
            let duracion = $('#duracion').val();
            let observacion = $('#obs').val();
            let stock = response.producto.stock;
            let precio_venta = response.producto.precio_venta
            let totalParcial = Number((parseInt(cantidad) * parseFloat(precio_venta)).toFixed(2));

            if (producto_id.length == 0) {
              Swal.fire({
                title: "Receta",
                text: 'Seleccione un Producto',
                icon: 'error'
              })

            } else
              if (cantidad.length == 0) {
                Swal.fire({
                  title: "Receta",
                  text: 'Ingrese una Cantidad',
                  icon: 'error'
                })

              } else
                if (parseInt(cantidad) == 0 || parseInt(cantidad) < 0) {
                  Swal.fire({
                    title: "Receta",
                    text: 'Ingrese un valor mayor a 0',
                    icon: 'error'
                  })
                } else
                  if (dosis_id == 0) {
                    Swal.fire({
                      title: "Receta",
                      text: 'Seleccione una dosis',
                      icon: 'error'
                    })

                  } else
                    if (frecuencia_id == 0) {
                      Swal.fire({
                        title: "Receta",
                        text: 'Seleccione una frecuencia',
                        icon: 'error'
                      })
                    } else
                      if (via_id == 0) {
                        Swal.fire({
                          title: "Receta",
                          text: 'Seleccione una via',
                          icon: 'error'
                        })


                      } else
                        if (duracion.length == 0) {
                          Swal.fire({
                            title: "Receta",
                            text: 'Ingrese la duracion',
                            icon: 'error'
                          })

                        } else
                          if (observacion.length == 0) {
                            Swal.fire({
                              title: "Receta",
                              text: 'Ingrese la observacion',
                              icon: 'error'
                            })


                          } else
                            if (parseInt(cantidad) > stock) {
                              Swal.fire({
                                title: "Receta",
                                text: 'Cantidad supera al stock',
                                icon: 'error'
                              })

                            } else {

                              let json = {
                                producto_id: parseInt(producto_id),
                                nombre: nombre_producto,
                                cantidad: parseInt(cantidad),
                                dosis_id: parseInt(dosis_id),
                                dosis: dosis,
                                frecuencia_id: parseInt(frecuencia_id),
                                frecuencia: frecuencia,
                                via_id: parseInt(via_id),
                                via: via,
                                duracion: duracion,
                                observacion: observacion,
                                precio_venta: parseFloat(precio_venta),
                                totalParcial: parseFloat(totalParcial),

                              }
                              //            console.log(json);
                              validar(json);
                              tabla_actualizar();



                            }
            selectMedicamento();
            cargarDosis();
            cargarFrecuencia();
            cargarVia();


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

let GenerarNumRecetaInicializado = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !GenerarNumRecetaInicializado) {
    generarNumerosReceta();
    GenerarNumRecetaInicializado = true;
  }
});

function generarNumerosReceta() {
  peticionJWT({
    url: urlServidor + 'receta/generar_aleartorio_rec/Tabla_Orden_Rece',
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
      //     console.log(response);
      if (response.estado) {
        $('#nuevo-orden-receta').val(response.numeros_recetas);
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

function guardarCodigo_receta() {
  let num_receta = $('#nuevo-orden-receta').val();

  let json = {
    num_receta: {
      num_receta: num_receta,
      id_tablas4: 'Tabla_Orden_Rece'
    }
  }

  peticionJWT({
    url: urlServidor + 'receta/aumentarAleartoriosRec',
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
      console.log(response);
      generarNumerosReceta();
    },
    error: function (jqXHR, status, error) {
      console.log('Disculpe, existió un problema');
    },
    complete: function (jqXHR, status) {
      // console.log('Petición realizada');
    }
  });
}


function tabla_actualizar() {

  const tbody = document.getElementById('productos-agregados');
  tbody.innerHTML = '';

  if (detalleProducto === undefined) {
    detalleProducto = [];
  } else {
    detalleProducto.forEach(e => {
      const tr = document.createElement('tr');
      tr.classList.add('itemNew');

      containerChelas = `
          
          <td>${e.cantidad}</td>
          <td>${e.nombre}</td>
          <td>${e.dosis}</td>
          <td>${e.frecuencia}</td>
          <td>${e.via}</td>
          <td>${e.duracion}</td>
          <td>${e.observacion}</td>
          <td>${e.precio_venta}</td>
          <td class="total-parcial">${e.totalParcial}</td>
          <td>
          <button class="btn btn-primary btn-sm">
              <i class="fas fa-plus"></i>
          </button>
          <button class="btn btn-dark btn-sm">
              <i class="fas fa-minus"></i>
          </button>
        </td>
  
          <th>
            <div>
                <button class="btn btn-danger delete">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
           </th>
           
        <th style="display:none;" class="id">${e.producto_id}</th>
        <th style="display:none;" class="id">${e.dosis_id}</th>
        <th style="display:none;" class="id">${e.frecuencia_id}</th>
        <th style="display:none;" class="id">${e.via_id}</th>
        <td style="display:none;">0</td>
        <td style="display:none;">N</td>
     </tr> `;

      tr.innerHTML = containerChelas;
      tbody.append(tr);
      tr.querySelector('.delete').addEventListener('click', borrarItem);
      tr.querySelector('.btn-primary').addEventListener('click', aumentar);
      tr.querySelector('.btn-dark').addEventListener('click', disminuir);

      actualizarDatos();
      limpiarCampos();
    });
  }

}


function validar(json) {
  let subtotal = 0.00;
  for (let i = 0; i < detalleProducto.length; i++) {//abrir el detalleArray
    if (detalleProducto[i].producto_id === json.producto_id) {//cuando se repite el id producto
      detalleProducto[i].cantidad = detalleProducto[i].cantidad + json.cantidad;
      subtotal = Number((detalleProducto[i].totalParcial) + (json.totalParcial));
      detalleProducto[i].totalParcial = subtotal;
      return detalleProducto;
    }
  }
  detalleProducto.push(json);
  return detalleProducto;
}

function borrarItem(e) {
  const btn = e.target;
  const trPadre = btn.closest('.itemNew');
  const classId = trPadre.querySelector('.id').innerHTML;
  let id = Number(classId);

  for (let j = 0; j < detalleProducto.length; j++) {
    if (detalleProducto[j].producto_id === id) {
      detalleProducto.splice(j, 1);
    }
  }
  trPadre.remove();
  actualizarDatos();

}

function actualizarDatos() {
  let tr = $('#productos-agregados tr');
  //  console.log(tr);
  let subtotal = 0;
  let total = 0;

  for (let i = 0; i < tr.length; i++) {
    let hijos = tr[i].children;
    subtotal += parseFloat(hijos[7].innerText);

  }

  let iva = Number(subtotal.toFixed(2) * 0.12);
  total = Number(subtotal) + Number(iva.toFixed(2));

  $('#subtotal').text(subtotal.toFixed(2));
  $('iva').text(iva.toFixed(2));
  $('#total').text(total.toFixed(2));

}


function aumentar(e) {
  const buttonAumentar = e.target;
  const trPadre = buttonAumentar.closest('.itemNew');
  const classId = trPadre.querySelector('.id').innerHTML;
  let id = Number(classId);

  if (e.target.classList.contains('btn-primary')) {
    detalleProducto.forEach((res) => {
      if (res.producto_id === id) {
        //   console.log(res);
        res.cantidad++;
        res.totalParcial = (res.cantidad * res.precio_venta).toFixed(2);
        //     console.log('aumentando');
        tabla_actualizar();
        actualizarDatos();
      }
    });
  }
}

function disminuir(e) {
  const buttonDisminuir = e.target;
  const trPadre = buttonDisminuir.closest('.itemNew');
  const classId = trPadre.querySelector('.id').innerHTML;
  let id = Number(classId);

  for (let i = 0; i < detalleProducto.length; i++) {
    if (detalleProducto[i].producto_id === id) {
      detalleProducto[i].cantidad--;
      detalleProducto[i].totalParcial = (detalleProducto[i].cantidad * detalleProducto[i].precio_venta).toFixed(2);

      if (detalleProducto[i].cantidad === 0) {
        detalleProducto.splice(i, 1);
        //  vaciarTextTotales();
      }
      //   console.log('disminuyendo');
      tabla_actualizar();
      actualizarDatos();
    }
  }

}



function eliminar_producto(producto_id, totalParcial) {
  let tr = '#fila-producto-' + producto_id;
  $(tr).remove();

  actualizarDatos();
}

function limpiarCampos() {
  let option = '<option value=0>Seleccione una Medicamento</option>';
  $('#nuevo-medicamento').html(option);
  let option2 = '<option value=0>Seleccione la dosis</option>';
  $('#dosis').html(option2);
  let option3 = '<option value=0>Seleccione la frecuencia</option>';
  $('#frecuencia').html(option3);
  $('#nuevo-cantidad').val('');
  $('#duracion').val('');
  $('#obs').val('');


}




function eliminar_diagnostico(id) {
  let tr = "#fila-diagnostico-" + id;
  $(tr).remove();
  $('#datos-r').removeClass('d-none');

  let option = '<option value=0>Seleccione un diagnostico</option>';
  $('#nuevo-diagnostico1').html(option);
  peticionJWT({
    url: urlServidor + 'diagnostico/listar',
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
      //   console.log(response);

      if (response.status) {
        let data = [{ id: 0, text: 'Seleccione el Diagnostico' }];
        response.diagnostico.forEach(element => {
          data.push({ id: element.id, text: `${element.clave} - ${element.descripcion}` });
        });

        $('#nuevo-diagnostico1').select2({
          data: data
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







let TipodiagnosticoInicializado = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !TipodiagnosticoInicializado) {
    cargarTipo_diagnostico();
    TipodiagnosticoInicializado = true;
  }
});


function cargarTipo_diagnostico() {
  peticionJWT({
    url: urlServidor + 'diagnostico/listartipo',
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
      //   console.log(response);

      if (response.status) {
        let option = '<option value="0">Seleccione el tipo de diagnostico</option>';
        response.diagnostico.forEach(element => {
          option += `<option value=${element.id}>${element.tipo_diagnostico} </option>`;
        });
        $('#tipo_diagnostico').html(option);
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



let diagnosticoAgregadoInicializado = false;

$('#tab_2').click(function () {
  if (!diagnosticoAgregadoInicializado) {
    agregarDiagnosticos1();  // Llama a la función solo cuando se hace clic en el tab
    diagnosticoAgregadoInicializado = true;
  }
});



function agregarDiagnosticos1() {

  $("#btn-agregar-diagnosticos-definitivos").click(function () {
    //  alert('hola');
    let diagnosticocie10_id = $("#nuevo-diagnostico1 option:selected").val();
    let tipo_diagnostico_id = $('#tipo_diagnostico option:selected').val();

    if (diagnosticocie10_id == 0) {
      Swal.fire({
        title: "Receta",
        text: 'Seleccione un diagnostico',
        icon: 'error'
      });
    } else

      if (tipo_diagnostico_id == 0) {
        Swal.fire({
          title: "Receta",
          text: 'Seleccione un el tipo de diagnostico',
          icon: 'error'
        })
      } else {
        peticionJWT({
          // la URL para la petición
          url: urlServidor + "diagnostico/listar/" + diagnosticocie10_id,

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

              let tipo_diagnostico_id = $('#tipo_diagnostico option:selected').val();
              let tipo_diagnostico = $('#tipo_diagnostico option:selected').text();
              let nombre_diagnostico = response.diagnosticos.clave + ' ' + response.diagnosticos.descripcion


              let cantidad = $('#cantidad').val();
              let stock = $('#cantidad').val();
              let precio_venta = $('#cantidad').val();
              let totalParcial = Number((parseInt(cantidad) * parseFloat(precio_venta)).toFixed(2));

              if (diagnosticocie10_id.length == 0) {
                Swal.fire({
                  title: "Receta",
                  text: 'Seleccione un Diagnostico',
                  icon: 'error'
                })

              } else
                if (cantidad.length == 0) {
                  Swal.fire({
                    title: "Receta",
                    text: 'Ingrese una Cantidad',
                    icon: 'error'
                  })

                } else
                  if (parseInt(cantidad) == 0 || parseInt(cantidad) < 0) {
                    Swal.fire({
                      title: "Receta",
                      text: 'Ingrese un valor mayor a 0',
                      icon: 'error'
                    })
                  } else
                    if (tipo_diagnostico_id.length == 0) {
                      Swal.fire({
                        title: "Receta",
                        text: 'Seleccione un tipo de diagnostico',
                        icon: 'error'
                      })

                    } else
                      if (parseInt(cantidad) > stock) {
                        Swal.fire({
                          title: "Receta",
                          text: 'Cantidad supera al stock',
                          icon: 'error'
                        })

                      } else {

                        let json = {
                          diagnosticocie10_id: parseInt(diagnosticocie10_id),
                          cantidad: parseInt(cantidad),
                          nombre_diagnostico: nombre_diagnostico,
                          tipo_diagnostico_id: parseInt(tipo_diagnostico_id),
                          tipo_diagnostico: tipo_diagnostico,
                          precio_venta: parseFloat(precio_venta),
                          totalParcial: parseFloat(totalParcial),

                        }
                        //    console.log(json);
                        validar2(json);
                        tabla_actualizar2();



                      }



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

function validar2(json) {
  let subtotal = 0.00;
  for (let i = 0; i < detalle_diagnostico.length; i++) {//abrir el detalleArray
    if (detalle_diagnostico[i].diagnosticocie10_id === json.diagnosticocie10_id) {//cuando se repite el id producto
      detalle_diagnostico[i].cantidad = detalle_diagnostico[i].cantidad + json.cantidad;
      subtotal = Number((detalle_diagnostico[i].totalParcial) + (json.totalParcial));
      detalle_diagnostico[i].totalParcial = subtotal;
      return detalle_diagnostico;
    }
  }
  detalle_diagnostico.push(json);
  return detalle_diagnostico;
}

function tabla_actualizar2() {

  const tbody = document.getElementById('tabla-diagnostico1');
  tbody.innerHTML = '';

  if (detalle_diagnostico === undefined) {
    detalle_diagnostico = [];
  } else {
    detalle_diagnostico.forEach(e => {
      const tr = document.createElement('tr');
      tr.classList.add('itemNew');

      containerChelas = `
      <td> </td>
      <td>${e.tipo_diagnostico}</td>
      <td>${e.nombre_diagnostico}</td>

      <th>
        <div>
            <button class="btn btn-danger delete">
                <i class="fas fa-trash"></i>
            </button>
        </div>
       </th>
       
    <th style="display:none;" class="id">${e.diagnosticocie10_id}</th>
    <th style="display:none;" class="id">${e.tipo_diagnostico_id}</th>
    <th style="display:none;" class="id">0</th>
 </tr> `;

      tr.innerHTML = containerChelas;
      tbody.append(tr);
      tr.querySelector('.delete').addEventListener('click', borrarItem_diagnostico);
      /*     tr.querySelector('.btn-primary').addEventListener('click', aumentar);
           tr.querySelector('.btn-dark').addEventListener('click', disminuir); */

      /*  actualizarDatos();*/
      /*  limpiarCampos_diag(); */
    });
  }

}

function borrarItem_diagnostico(e) {
  const btn = e.target;
  const trPadre = btn.closest('.itemNew');
  const classId = trPadre.querySelector('.id').innerHTML;
  let id = Number(classId);

  for (let j = 0; j < detalle_diagnostico.length; j++) {
    if (detalle_diagnostico[j].diagnosticocie10_id === id) {
      detalle_diagnostico.splice(j, 1);
    }
  }
  trPadre.remove();
  //  actualizarDatos_diagnostico();

}

function limpiarCampos_diag() {
  let option_lab = '<option value=0>Seleccione el Diagnostico</option>';
  $('#nuevo-diagnostico1').html(option_lab);
  $('#justificacion-laboratorio').val('');
  $('#resumen-laboratorio').val('');


}

function calcularSuma() {
  // Obtén los valores de los inputs
  let peso = parseFloat($('#h-peso').val()) || 0;
  let talla = parseFloat($('#h-talla').val()) || 0;

  // Calcula la suma
  let calculo_imc = peso / (talla * talla);

  // Muestra el resultado en el input resultado
  $('#h-imc').val(parseFloat(calculo_imc).toFixed(2));

}

// Detecta cambios en los inputs y calcula la suma
$('#h-peso, #h-talla').on('input', function () {
  calcularSuma();
});



/* let guardarHistorialInicializar = false;

$('#tab_3').click(function () {
  if (!guardarHistorialInicializar) {
    guardarHistorial();  // Llama a la función solo cuando se hace clic en el tab
    guardarHistorialInicializar = true;
  }
});
 */

function guardarHistorial() {
  $('#btn-guardar').click(function () {

    let doctor_id = JSON.parse(localStorage.getItem('sesion-2'));
    // let paciente_id2 = localStorage.getItem('paciente_id');

    //  console.log(doctor_id);

    let citas_id = $('#citas-id').val();
    let enfermedad_actual = $('#enfermedad-actual').val();
    let motivo_consulta = $('#motivo-consulta').val();
    let antecedentes = $('#antecedentes').val();
    let antecedentes_familiares = $('#ant-familiares').val();
    let plan = $('#plan').val();
    let examen_fisico = $('#examen-fisico').val();
    let evolucion = $('#evolucion').val();
    let alergias = $('#alergias').val();


    let dia_descanso = $('#dia-descanso').val();
    let actividad_laboral = $('#actividad-laboral').val();
    let entidad_laboral = $('#entidad-trabajo').val();
    let direccion = $('#direccion-trabajo').val();
    let observacion = $('#observacion-certificado').val();
    let tipo_contingencia_id = $('#tipo-contingencia option:selected').val();
    let aislamiento_id = $('#tipo-aislamiento option:selected').val();




    let temperatura = $('#h-temperatura').val();
    let peso = $('#h-peso').val();
    let talla = $('#h-talla').val();
    let presion_arterial = $('#h-presion-arterial').val();
    let imc = $('#h-imc').val();
    let pulso = $('#h-pulso').val();
    let frecuencia_respiratoria = $('#h-frecuencia-respiratoria').val();
    let saturacion_oxigeno = $('#h-saturacion').val();
    let observacion_examen = $('#motivo-observacion').val();
    let recomendacion = $('#motivo-recomendacion').val();



    //lab 
    let paciente_id = $('#paciente-id').val();
    let numero_orden_lab = $('#nuevo-orden-laboratorio').val();
    let numero_receta = $('#nuevo-orden-receta').val();


    let body = $('#productos-agregados tr');
    let citas = $('#citas-id').val();
    let array = [];
    let array2 = [];
    let body2 = $('#tabla-diagnostico1 tr');
    let array3 = [];
    let body3 = $('#orden-clinico tr')
    let body4 = $('#orden-laboratorio tr')
    let array6 = [];

    let array4 = [];
    let array5 = [];


    if (body.length > 0) {
      for (let i = 0; i < body.length; i++) {
        let td = body[i].children;
        console.log(td);
        let id = td[11].innerText;
        let dosis_id = td[12].innerText;
        let duracion = td[5].innerText;
        let observacion = td[6].innerText;
        let frecuencia_id = td[13].innerText;
        let via_id = td[14].innerText;
        let cantidad = td[0].innerText;

        let object = {
          //   citas_id: citas,
          producto_id: id,
          dosis_id: dosis_id,
          frecuencia_id: frecuencia_id,
          via_id: via_id,
          status_facturado: 'N',
          duracion: duracion,
          observacion: observacion,
          cantidad: cantidad
        }
        array.push(object);
      }

    }

    if (body2.length > 0) {
      for (let j = 0; j < body2.length; j++) {
        let td2 = body2[j].children;
        //  console.log(td2);
        let diagnosticocie10_id = td2[4].innerText;
        let tipo_diagnostico_id = td2[5].innerText;

        let object2 = {
          diagnosticocie10_id: diagnosticocie10_id,
          tipo_diagnostico_id: tipo_diagnostico_id,
        }
        array2.push(object2);
      }

    }

    if (body3.length > 0) {
      for (let j = 0; j < body3.length; j++) {
        let td = body3[j].children;
        //    console.log(td);
        let numero_orden = td[1].innerText;
        let justificacion = td[3].innerText;
        let resumen = td[4].innerText;
        let tipo_estudio_id = td[6].innerText;
        let lateralidad_id = td[7].innerText;

        let object3 = {
       //   doctor_id: doctor_id,
          citas_id: citas_id,
          numero_orden: numero_orden,
          resumen: resumen,
          justificacion: justificacion,
          tipo_estudio_id: tipo_estudio_id,
          lateralidad_id: lateralidad_id,
        }
        array3.push(object3);
      }

    }

    if (body4.length > 0) {
      for (let j = 0; j < body4.length; j++) {
        let td = body4[j].children;
        //  console.log(td);
        //   let numero_orden_lab = td[1].innerText;
        let justificacion_lab = td[2].innerText;
        let resumen_lab = td[3].innerText;
        let tipo_examen_id = td[5].innerText;


        let object4 = {
          // doctor_id: doctor_id,
          //  citas_id: citas_id,
          //    numero_orden_lab: numero_orden_lab,
          resumen_lab: resumen_lab,
          justificacion_lab: justificacion_lab,
          tipo_examen_id: tipo_examen_id,

        }
        array6.push(object4);
      }

    }

    // Verificamos si los campos están vacíos
    if (dia_descanso && actividad_laboral && entidad_laboral && direccion && observacion) {
      // Creamos un objeto para almacenar los datos recolectados
      let certificados_medicos = {
        dia_descanso: dia_descanso,
        actividad_laboral: actividad_laboral,
        entidad_laboral: entidad_laboral,
        direccion: direccion,
        observacion: observacion,
        citas_id: citas,
        tipo_contingencia_id: tipo_contingencia_id,
        aislamiento_id: aislamiento_id,

      };
      array4.push(certificados_medicos);


    }


    if (temperatura && peso && talla && presion_arterial && imc && pulso && frecuencia_respiratoria && observacion_examen && recomendacion && saturacion_oxigeno) {
      // Creamos un objeto para almacenar los datos recolectados
      let examen_fisica = {
        temperatura: temperatura,
        peso: peso,
        talla: talla,
        presion_arterial: presion_arterial,
        imc: imc,
        citas_id: citas,
        frecuencia_respiratoria: frecuencia_respiratoria,
        observacion_examen: observacion_examen,
        recomendacion: recomendacion,
        saturacion_oxigeno: saturacion_oxigeno,
        pulso: pulso

      };
      array5.push(examen_fisica);


    }



    let json = {
      historial_clinico: {
        citas_id,
        evolucion,
        antecedentes,
        enfermedad_actual,
        motivo_consulta,
        alergias,
        antecedentes_familiares,
        plan,
        examen_fisico

      },
      //   receta: array,
      //  receta_diagnostico: array2,
      orden: array3,
      certificados_medicos: array4,
      examen_fisica: array5,



      //  orden_lab:array6




    }


    let json2 = {
      laboratorio: {
        citas_id,
        paciente_id,
        numero_orden_lab,
        doctor_id,

      },

      orden_lab: array6
    }

    let json3 = {
      receta: {
        citas_id,
        paciente_id,
        numero_receta,
        // doctor_id,

      },

      orden_rece: array,
      receta_diagnostico: array2,

    }



    if (!validar_registroatencion(json)) {
      //  console.log("faltan datos");

    } else {
      console.log(json);
      console.log(json2);
      console.log(json3);
      ajaxGuardandohistorial(json);
      if (array6.length > 0) {

        guardarCodigo_laboratorio();
        ajaxGuardandolaboratorio(json2);
      }


      // Validar si hay diagnósticos y receta para elegir el endpoint adecuado
      if (array2.length > 0) {  // Hay diagnósticos
        let citas_id = $('#citas-id').val();

        if (array.length > 0) {
          // Hay receta -> Guardar receta y luego diagnósticos con receta_id
          guardarCodigo_receta();
          ajaxGuardandoReceta(json3, array2);
          console.log(json3, array2);

        } else {
          // No hay receta -> Guardar solo diagnósticos con receta_id null
          let payload = {
            receta_id: null,
            citas_id: citas_id,
            diagnosticos: array2
          };

          peticionJWT({
            url: urlServidor + 'recetadiagnostico/guardarSinReceta',
            type: 'POST',
            data: JSON.stringify(payload),
            contentType: 'application/json',
            processData: false,
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
                  title: 'Diagnósticos guardados sin receta',
                  icon: 'success'
                });
              } else {
                Swal.fire({
                  title: 'Error al guardar diagnósticos',
                  text: response.mensaje,
                  icon: 'error'
                });
              }
            },
            error: function () {
              Swal.fire({
                title: 'Error en la comunicación con el servidor',
                icon: 'error'
              });
            }
          });
        }
      } else {
        // No hay diagnósticos, pero puede haber receta o no.
        /*     if (array.length > 0) {
              ajaxGuardandoReceta(json3, array2);
              console.log(json3, array2);
    
            } else {
              // Ni receta ni diagnósticos, quizá mostrar advertencia o simplemente no hacer nada.
            } */
      }

      /* 
            if (array.length > 0) {
              guardarCodigo_receta();
              ajaxGuardandoReceta(json3);
            } */
    }


  });
}

function validar_registroatencion(json) {
  let historial_clinico = json.historial_clinico;
  if (historial_clinico.motivo_consulta == 0) {
    Swal.fire({
      title: "Ingrese el Motivo de la Consulta en Anamnesis",
      text: 'Atencion Medica',
      icon: 'error'
    })
    return false;
  } else if (historial_clinico.enfermedad_actual == 0) {
    Swal.fire({
      title: "Ingrese la Historia de la Enfermedad Actual en Anamnesis",
      text: 'Atencion Medica',
      icon: 'error'
    })
    return false;
  } else if (historial_clinico.antecedentes == 0) {
    Swal.fire({
      title: "Ingrese los Antecedentes Personales del Paciente en Anamnesis",
      text: 'Atencion Medica',
      icon: 'error'
    })
    return false;
  } else if (historial_clinico.antecedentes_familiares == 0) {
    Swal.fire({
      title: "Ingrese los Antecedentes Familiares del Paciente Anamnesis",
      text: 'Atencion Medica',
      icon: 'error'
    })
    return false;
  } else if (historial_clinico.examen_fisico == 0) {
    Swal.fire({
      title: "Ingrese el Examen Fisico en Anamnesis",
      text: 'Atencion Medica',
      icon: 'error'
    })
    return false;
  } else if (historial_clinico.plan == 0) {
    Swal.fire({
      title: "Ingrese el Plan de Tratamiento en Anamnesis",
      text: 'Atencion Medica',
      icon: 'error'
    })
    return false;
  } else if (historial_clinico.alergias == 0) {
    Swal.fire({
      title: "Ingrese las Alergias del Paciente en Anamnesis",
      text: 'Atencion Medica',
      icon: 'error'
    })
    return false;
  } else if (historial_clinico.evolucion == 0) {
    Swal.fire({
      title: "Ingrese la Evolucion en Anamnesis",
      text: 'Atencion Medica',
      icon: 'error'
    })

  } else {
    return true
  }




}

function ajaxGuardandohistorial(json) {
  peticionJWT({
    url: urlServidor + 'citas/guardar_historiaclinica',
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

      if (response.status) {
        Swal.fire({
          title: response.mensaje,
          text: 'Atencion Medica',
          icon: 'success'
        })
        guardarCodigo();
        //  guardarCodigo_laboratorio();
        location.href = urlCliente + 'inicio/citas';
        /*   reset_datos();
          guardarCodigo(); */
      } else {
        Swal.fire({
          title: response.mensaje,
          text: 'Atencion Medica',
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



/**GUARDAR ORDENES LABORATORIO  */




function ajaxGuardandolaboratorio(json2) {
  peticionJWT({
    url: urlServidor + 'laboratorio/guardarOrden',
    type: 'POST',
    data: 'data=' + JSON.stringify(json2),
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
          title: response.mensaje,
          text: 'Atencion Medica',
          icon: 'success'
        })
        /*   guardarCodigo();*/
        //   guardarCodigo_laboratorio(); 
        //   location.href = urlCliente + 'inicio/citas';
        /*   reset_datos();
          guardarCodigo(); */
      } else {
        Swal.fire({
          title: response.mensaje,
          text: 'Atencion Medica',
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




function ajaxGuardandoReceta(json3, array2) {
  peticionJWT({
    url: urlServidor + 'receta/guardarReceta',
    type: 'POST',
    data: 'data=' + JSON.stringify(json3),
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
          title: response.mensaje,
          text: 'Atencion Medica',
          icon: 'success'
        });

        // Aquí cambio para leer el id bien
        let receta_id = response.receta?.id || null;
        let citas_id = $('#citas-id').val();

        if (array2.length > 0 && receta_id) {
          let payload = {
            receta_id: receta_id,
            citas_id: citas_id,
            diagnosticos: array2
          };

          //   guardarDiagnosticoReceta(payload);
        }

      } else {
        Swal.fire({
          title: response.mensaje,
          text: 'Atencion Medica',
          icon: 'error'
        });
      }
    },
    error: function () {
      console.log('Disculpe, existió un problema');
    }
  });
}



function guardarDiagnosticoReceta(payload) {
  peticionJWT({
    url: urlServidor + 'recetadiagnostico/guardar_recetas_diagnosticos',
    type: 'POST',
    data: JSON.stringify(payload),
    contentType: 'application/json',
    processData: false,
    dataType: 'json',
    beforeSend: function (xhr) {
      let token = localStorage.getItem('token');
      if (token) {
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
      }
    },
    success: function (response) {
      if (response.status) {
        console.log('Diagnósticos de receta guardados correctamente');
      } else {
        console.warn('Fallo al guardar diagnósticos de receta');
      }
    },
    error: function () {
      console.log('Error en la petición de guardar diagnósticos');
    }
  });
}


/*ORDEN IMAGEN */



let TipoEstudioInicializado = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_4' && !TipoEstudioInicializado) {
    selectTipoEstudio();
    TipoEstudioInicializado = true;
  }
});



function selectTipoEstudio() {
  $('#nuevo-imagen').select2({
    width: '75%',
    placeholder: 'Buscar tipo de estudio',
    allowClear: true,
    minimumInputLength: 1,
    ajax: {
      url: urlServidor + 'tipoestudio/listar',
      dataType: 'json',
      delay: 250,
      headers: {
        'Authorization': 'Bearer ' + localStorage.getItem('token')
      },
      data: function (params) {
        return {
          q: params.term // término que escribe el usuario
        };
      },
      processResults: function (data) {
        let resultados = data.map(element => {
          return {
            id: element.id,
            text: `${element.codigo} - ${element.descripcion}`
          };
        });

        return {
          results: resultados
        };
      },
      cache: true
    },
    language: {
      inputTooShort: () => 'Escriba al menos un carácter',
      noResults: () => 'No se encontraron resultados'
    }
  });
}

let OrdenAgregadoInicializado = false;

$('#tab_4').click(function () {
  if (!OrdenAgregadoInicializado) {
    agregarOrden();  // Llama a la función solo cuando se hace clic en el tab
    OrdenAgregadoInicializado = true;
  }
});


function agregarOrden() {

  $("#btn-agregar-orden").click(function () {
    //  alert('hola');
    let tipo_estudio_id = $("#nuevo-imagen option:selected").val();
    let lateralidad_id = $('#lateralidad option:selected').val();

    if (tipo_estudio_id == 0) {
      Swal.fire({
        title: "Receta",
        text: 'Seleccione un tipo de orden',
        icon: 'error'
      });
      /*  } else
   
         if (lateralidad_id == 0) {
           Swal.fire({
             title: "Receta",
             text: 'Seleccione un el tipo de lateralidad',
             icon: 'error'
           }) */
    } else {
      peticionJWT({
        // la URL para la petición
        url: urlServidor + "tipoestudio/listar/" + tipo_estudio_id,

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
          //     console.log(response);
          if (response.status) {

            let lateralidad_id = $('#lateralidad option:selected').val();
            let lateralidad = $('#lateralidad option:selected').text();
            let nombre_estudio = response.tipo_estudio.codigo + ' ' + response.tipo_estudio.descripcion;
            let numero_orden = $('#nuevo-orden').val();
            let justificacion = $('#justificacion').val();
            let resumen = $('#resumen').val();


            let cantidad = $('#cantidad').val();
            let stock = $('#cantidad').val();
            let precio_venta = $('#cantidad').val();
            let totalParcial = Number((parseInt(cantidad) * parseFloat(precio_venta)).toFixed(2));

            if (lateralidad_id.length == 0) {
              Swal.fire({
                title: "Receta",
                text: 'Seleccione una lateralidad',
                icon: 'error'
              })

            } else
              if (cantidad.length == 0) {
                Swal.fire({
                  title: "Receta",
                  text: 'Seleccione una Cantidad',
                  icon: 'error'
                })

              } else
                if (parseInt(cantidad) == 0 || parseInt(cantidad) < 0) {
                  Swal.fire({
                    title: "Receta",
                    text: 'Ingrese un valor mayor a 0',
                    icon: 'error'
                  })
                } else
                  if (tipo_estudio_id.length == 0) {
                    Swal.fire({
                      title: "Receta",
                      text: 'Seleccione un tipo de diagnostico',
                      icon: 'error'
                    })

                  } else
                    if (parseInt(cantidad) > stock) {
                      Swal.fire({
                        title: "Receta",
                        text: 'Cantidad supera al stock',
                        icon: 'error'
                      })

                    } else {



                      let json = {
                        tipo_estudio_id: parseInt(tipo_estudio_id),
                        lateralidad_id: parseInt(lateralidad_id),
                        cantidad: parseInt(cantidad),
                        lateralidad: lateralidad,
                        numero_orden: numero_orden,
                        justificacion: justificacion,
                        nombre_estudio: nombre_estudio,
                        resumen: resumen,
                        precio_venta: parseFloat(precio_venta),
                        totalParcial: parseFloat(totalParcial),

                      }
                      //   console.log(json);
                      validar3(json);
                      tabla_actualizar3();



                    }
            selectTipoEstudio();


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

function validar3(json) {
  let subtotal = 0.00;
  for (let i = 0; i < detalle_orden.length; i++) {//abrir el detalleArray
    if (detalle_orden[i].tipo_estudio_id === json.tipo_estudio_id) {//cuando se repite el id producto
      detalle_orden[i].cantidad = detalle_orden[i].cantidad + json.cantidad;
      subtotal = Number((detalle_orden[i].totalParcial) + (json.totalParcial));
      detalle_orden[i].totalParcial = subtotal;
      return detalle_orden;
    }
  }
  detalle_orden.push(json);
  return detalle_orden;
}

function tabla_actualizar3() {

  const tbody = document.getElementById('orden-clinico');
  tbody.innerHTML = '';

  if (detalle_orden === undefined) {
    detalle_orden = [];
  } else {
    detalle_orden.forEach(e => {
      const tr = document.createElement('tr');
      tr.classList.add('itemNew');

      containerChelas = `
      
      <td>${e.nombre_estudio}</td>
      <td>${e.numero_orden}</td>
      <td>${e.lateralidad_id}</td>
      <td>${e.justificacion}</td>
      <td>${e.resumen}</td>

      <th>
        <div>
            <button class="btn btn-danger delete2">
                <i class="fas fa-trash"></i>
            </button>
        </div>
       </th>
       
    <th style="display:none;" class="id">${e.tipo_estudio_id}</th>
    <th style="display:none;" class="id">${e.lateralidad_id}</th>
    <th style="display:none;" class="id">0</th>
 </tr> `;

      tr.innerHTML = containerChelas;
      tbody.append(tr);
      tr.querySelector('.delete2').addEventListener('click', borrarItem2);
      /*   tr.querySelector('.btn-primary').addEventListener('click', aumentar);
         tr.querySelector('.btn-dark').addEventListener('click', disminuir); */

      /*  actualizarDatos(); */
      limpiarCampos2();
    });
  }

}

function borrarItem2(e) {
  const btn = e.target;
  const trPadre = btn.closest('.itemNew');
  const classId = trPadre.querySelector('.id').innerHTML;
  let id = Number(classId);

  for (let j = 0; j < detalle_orden.length; j++) {
    if (detalle_orden[j].tipo_estudio_id === id) {
      detalle_orden.splice(j, 1);
    }
  }
  trPadre.remove();
  actualizarDatos2();

}

function limpiarCampos2() {
  let option5 = '<option value=0>Seleccione Imagen</option>';
  $('#nuevo-imagen').html(option5);
  let option6 = '<option value=0>Seleccione lateralidad</option>';
  option6 += '<option value=1>Izquierda</option>';
  option6 += '<option value=2>Derecha</option>';
  $('#lateralidad').html(option6);
  $('#justificacion').val('');
  $('#resumen').val('');


}

/**FIN IMAGENES ORDENES */




/**INICIO  DE ORDENES LABORATORIO EXAMENES */

let TipoExamenInicializado = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_9' && !TipoExamenInicializado) {
    selectTipoExamenLaboratorio();
    TipoExamenInicializado = true;
  }
});

function selectTipoExamenLaboratorio() {
  $('#nuevo-laboratorio').select2({
    width: '75%',
    placeholder: 'Buscar tipo de examen',
    allowClear: true,
    minimumInputLength: 1,
    ajax: {
      url: urlServidor + 'tipo_examen/listar',
      dataType: 'json',
      delay: 250,
      headers: {
        'Authorization': 'Bearer ' + localStorage.getItem('token')
      },
      data: function (params) {
        return {
          q: params.term // lo que escribe el usuario
        };
      },
      processResults: function (data) {
        let resultados = data.map(element => {
          return {
            id: element.id,
            text: `${element.codigo_lab} - ${element.descripcion_lab}`
          };
        });

        return {
          results: resultados
        };
      },
      cache: true
    },
    language: {
      inputTooShort: () => 'Escriba al menos un carácter',
      noResults: () => 'No se encontraron resultados'
    }
  });
}


let GenerarNumOrdenLabsInicializado = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_9' && !GenerarNumOrdenLabsInicializado) {
    generarNumerosOrden_laboratorio();
    GenerarNumOrdenLabsInicializado = true;
  }
});

function generarNumerosOrden_laboratorio() {
  peticionJWT({
    url: urlServidor + 'tipo_examen/generar_aleartorio_lab/Tabla_Orden_Labs',
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
      //     console.log(response);
      if (response.estado) {
        $('#nuevo-orden-laboratorio').val(response.numero_labs);
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

function guardarCodigo_laboratorio() {
  let num_labs = $('#nuevo-orden-laboratorio').val();

  let json = {
    num_labs: {
      num_labs: num_labs,
      id_tablas2: 'Tabla_Orden_Labs'
    }
  }

  peticionJWT({
    url: urlServidor + 'tipo_examen/aumentarAleartoriosLab',
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
      console.log(response);
      generarNumerosOrden_laboratorio();
    },
    error: function (jqXHR, status, error) {
      console.log('Disculpe, existió un problema');
    },
    complete: function (jqXHR, status) {
      // console.log('Petición realizada');
    }
  });
}


let AgregarOrdenLabsInicializado = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_9' && !AgregarOrdenLabsInicializado) {
    agregarOrden_laboratorio();
    AgregarOrdenLabsInicializado = true;
  }
});


function agregarOrden_laboratorio() {

  $("#btn-agregar-orden-laboratorio").click(function () {
    //  alert('hola');
    let tipo_examen_id = $("#nuevo-laboratorio option:selected").val();


    if (tipo_examen_id == 0) {
      Swal.fire({
        title: "Laboratorio",
        text: 'Seleccione un tipo de examen',
        icon: 'error'
      });

    } else {
      peticionJWT({
        // la URL para la petición
        url: urlServidor + "tipo_examen/listarLab/" + tipo_examen_id,

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
          //  console.log(response);
          if (response.status) {


            let nombre_examen = response.tipo_examen.codigo_lab + ' ' + response.tipo_examen.descripcion_lab;
            //  let numero_orden_lab = $('#nuevo-orden-laboratorio').val();
            let justificacion_lab = $('#justificacion-laboratorio').val();
            let resumen_lab = $('#resumen-laboratorio').val();


            let cantidad = $('#cantidad').val();
            let stock = $('#cantidad').val();
            let precio_venta = $('#cantidad').val();
            let totalParcial = Number((parseInt(cantidad) * parseFloat(precio_venta)).toFixed(2));


            if (cantidad.length == 0) {
              Swal.fire({
                title: "Laboratorio",
                text: 'Seleccione una Cantidad',
                icon: 'error'
              })

            } else
              if (parseInt(cantidad) == 0 || parseInt(cantidad) < 0) {
                Swal.fire({
                  title: "Laboratorio",
                  text: 'Ingrese un valor mayor a 0',
                  icon: 'error'
                })
              } else
                if (tipo_examen_id.length == 0) {
                  Swal.fire({
                    title: "Laboratorio",
                    text: 'Seleccione un tipo de examen',
                    icon: 'error'
                  })

                } else
                  if (parseInt(cantidad) > stock) {
                    Swal.fire({
                      title: "Laboratorio",
                      text: 'Cantidad supera al stock',
                      icon: 'error'
                    })

                  } else {



                    let json = {
                      tipo_examen_id: parseInt(tipo_examen_id),
                      cantidad: parseInt(cantidad),
                      //   numero_orden_lab: numero_orden_lab,
                      justificacion_lab: justificacion_lab,
                      nombre_examen: nombre_examen,
                      resumen_lab: resumen_lab,
                      precio_venta: parseFloat(precio_venta),
                      totalParcial: parseFloat(totalParcial),

                    }
                    //   console.log(json);
                    validar4(json);
                    tabla_actualizar4();



                  }
            selectTipoExamenLaboratorio();


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

function validar4(json) {
  let subtotal = 0.00;
  for (let i = 0; i < detalle_orden_laboratorio.length; i++) {//abrir el detalleArray
    if (detalle_orden_laboratorio[i].tipo_examen_id === json.tipo_examen_id) {//cuando se repite el id producto
      detalle_orden_laboratorio[i].cantidad = detalle_orden_laboratorio[i].cantidad + json.cantidad;
      subtotal = Number((detalle_orden_laboratorio[i].totalParcial) + (json.totalParcial));
      detalle_orden_laboratorio[i].totalParcial = subtotal;
      return detalle_orden_laboratorio;
    }
  }
  detalle_orden_laboratorio.push(json);
  return detalle_orden_laboratorio;
}

function tabla_actualizar4() {

  const tbody = document.getElementById('orden-laboratorio');
  tbody.innerHTML = '';

  if (detalle_orden_laboratorio === undefined) {
    detalle_orden_laboratorio = [];
  } else {
    detalle_orden_laboratorio.forEach(e => {
      const tr = document.createElement('tr');
      tr.classList.add('itemNew');

      containerChelas = `
      
      <td>${e.nombre_examen}</td>
      <td>${e.numero_orden_lab}</td>
      <td>${e.justificacion_lab}</td>
      <td>${e.resumen_lab}</td>

      <th>
        <div>
            <button class="btn btn-danger delete2">
                <i class="fas fa-trash"></i>
            </button>
        </div>
       </th>
       
    <th style="display:none;" class="id">${e.tipo_examen_id}</th>
    <th style="display:none;" class="id">0</th>
 </tr> `;

      tr.innerHTML = containerChelas;
      tbody.append(tr);
      tr.querySelector('.delete2').addEventListener('click', borrarItem4);
      /*   tr.querySelector('.btn-primary').addEventListener('click', aumentar);
         tr.querySelector('.btn-dark').addEventListener('click', disminuir); */

      /*  actualizarDatos(); */
      limpiarCampos4();
    });
  }

}

function borrarItem4(e) {
  const btn = e.target;
  const trPadre = btn.closest('.itemNew');
  const classId = trPadre.querySelector('.id').innerHTML;
  let id = Number(classId);

  for (let j = 0; j < detalle_orden_laboratorio.length; j++) {
    if (detalle_orden_laboratorio[j].tipo_examen_id === id) {
      detalle_orden_laboratorio.splice(j, 1);
    }
  }
  trPadre.remove();
  actualizarDatos();

}

function limpiarCampos4() {
  let option5 = '<option value=0>Seleccione Imagen</option>';
  $('#nuevo-laboratorio').html(option5);
  $('#justificacion-laboratorio').val('');
  $('#resumen-laboratorio').val('');


}
/** FIN DE ORDENES LABORATORIO EXAMENES */






/*ANTECEDENTES   */

function cargarAntecedentes2() {
  peticionJWT({
    url: urlServidor + "antecedentes/listarAntecedentesXGrupos",
    type: "GET",
    dataType: "json",
    beforeSend: function (xhr) {
      // Envía el token JWT en el encabezado Authorization
      let token = localStorage.getItem('token');
      if (token) {
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
      }
    },
    success: function (response) {
      let div = '';

      if (response.status) {
        response.categorias.forEach((element, index) => {
          let checkboxes = '';

          element.antecedentes.forEach(a => {
            checkboxes += `<div class="custom-control custom-checkbox">
                              <input class="custom-control-input" type="checkbox" name="antecedente_${index}" id="customCheckbox_${index}_${a.id}" value="${a.id}" data-nombre="${a.nombre_antecedente}">
                              <label for="customCheckbox_${index}_${a.id}" class="custom-control-label">${a.nombre_antecedente}</label>
                            </div>`;
          });

          div += `<div class="card card-primary">
                    <div class="card-header">
                      <h4 class="card-title w-100">
                        <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseTwo_${index}" aria-expanded="false">${element.nombre}</a>
                      </h4>
                    </div>
                    <div id="collapseTwo_${index}" class="collapse" data-parent="#accordion" style="">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-12 col-md-6">${checkboxes}</div>
                          <div class="col-12 col-md-6">
                            <div class="form-group mt-3">
                              <input type="text" class="form-control form-control-sm descripcion-antecedentes" data-descripcion-id="descripcion-antecedentes_${index}">
                            </div>
                            <button class="btn btn-primary agregar-datos" data-target="${index}">Agregar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>`;
        });

      } else {

      }
      $('#accordion').html(div);

      // Adjuntar controlador de eventos change a todos los checkboxes
      $('input[type="checkbox"]').change(function () {
        // Deseleccionar todos los checkboxes excepto el que está siendo seleccionado actualmente
        $('input[type="checkbox"]').not(this).prop('checked', false);
      });

      // Adjuntar controlador de eventos al botón "Agregar"
      // Dentro de la función agregar-datos
      $('.agregar-datos').click(function () {
        let index = $(this).data('target');
        let selectedCheckboxes = $(`input[name="antecedente_${index}"]:checked`).map(function () {
          return $(this).data('nombre');
        }).get();
        let descripcion = $(`input[data-descripcion-id="descripcion-antecedentes_${index}"]`).val();

        // Procesar los datos para agregarlos a la tabla
        selectedCheckboxes.forEach(nombreAntecedente => {
          let tr = `<tr>  
                <td>${new Date().toISOString().split('T')[0]}</td>
                <td>${nombreAntecedente}</td>
                <td>${response.categorias[index].nombre}</td>
                <td>${descripcion}</td>
                <td>
                    <div class="div">
                        <button class="btn btn-primary btn-sm eliminar-fila">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
          $('#body-diagnos').append(tr);
        });

        // Limpiar la descripción y los checkboxes después de agregar los datos
        $(`input[data-descripcion-id="descripcion-antecedentes_${index}"]`).val('');
        $(`input[name="antecedente_${index}"]:checked`).prop('checked', false);
      });

      // Agregar controlador de eventos para eliminar fila
      $('#body-diagnos').on('click', '.eliminar-fila', function () {
        $(this).closest('tr').remove();
      });



    },
    error: function (jqXHR, status, error) {
      console.log("Disculpe, existió un problema");
    },
    complete: function (jqXHR, status) {
      // console.log('Petición realizada');
    },
  });
}




function getCurrentDate() {
  // Obtener la fecha actual en el formato deseado (puedes usar bibliotecas como moment.js para esto)
  let date = new Date();
  let year = date.getFullYear();
  let month = String(date.getMonth() + 1).padStart(2, '0');
  let day = String(date.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
}

let GuardarAntePacInicializado = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_5' && !GuardarAntePacInicializado) {
    guardar_antecendente_paciente();
    GuardarAntePacInicializado = true;
  }
});

function guardar_antecendente_paciente() {
  $('#guardar-antecedente-paciente').click(function () {
    let id = localStorage.getItem('citas_id');
    peticionJWT({
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
          let antecedentes = [];

          // Recorrer cada fila de la tabla de antecedentes
          $('#body-diagnos tr').each(function () {
            let fecha = $(this).find('td:eq(0)').text(); // Obtener la fecha de la primera columna
            let nombreAntecedente = $(this).find('td:eq(1)').text(); // Obtener el nombre del antecedente de la segunda columna
            let antecedenteId = $(this).find('td:eq(2)').text(); // Obtener el ID del antecedente de la tercera columna
            let grupos_antecedentes_id = $(this).find('td:eq(3)').text(); // Obtener el ID del grupo de la cuarta columna
            let categoria = $(this).find('td:eq(4)').text(); // Obtener la categoría de la quinta columna
            let descripcion = $(this).find('td:eq(5)').text(); // Obtener la descripción de la sexta columna

            // Agregar cada antecedente como un objeto al array de antecedentes
            antecedentes.push({
              paciente_id: paciente_id,
              fecha: fecha,
              antecedentes_id: antecedenteId,
              grupos_antecedentes_id: grupos_antecedentes_id,
              observacion: descripcion
            });
          });

          // Construir el objeto JSON para enviar al servidor
          let json = {
            paciente_antecedentes: antecedentes
          };

          // Ahora puedes enviar este objeto JSON al servidor para guardar los antecedentes del paciente
          //      console.log(json);

          guardando_antecedentes(json);
          limpiarTabla();
          cargarDatatable(paciente_id);



        } else {
          console.log("Error al obtener datos de la cita");
        }
      },
      error: function (jqXHR, status, error) {
        console.log('Disculpe, existió un problema');
      }
    });
  });
}


function limpiarTabla() {
  $('#body-diagnos').empty();
}



function guardando_antecedentes(json) {

  peticionJWT({
    // la URL para la petición
    url: urlServidor + 'pacienteantecedentes/guardar',
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




function datatable_antecedentes() {

  let id = localStorage.getItem('citas_id');
  peticionJWT({
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
        //   console.log(paciente_id);

        cargarDatatable(paciente_id);

      } else {
        console.log("Error al obtener datos de la cita");
      }
    },
    error: function (jqXHR, status, error) {
      console.log('Disculpe, existió un problema');
    }
  });

}

function cargarDatatable(paciente_id) {
  tabla2 = $('#tabla-paciente-diagnosticos').DataTable({
    "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "ajax":
    {
      url: urlServidor + 'pacienteantecedentes/listar/' + paciente_id,
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
    "iDisplayLength": 5,//Paginación
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



// Función para cargar antecedentes
function cargarAntecedentes() {
  peticionJWT({
    url: urlServidor + "antecedentes/listarAntecedentesXGrupos",
    type: "GET",
    dataType: "json",
    beforeSend: function (xhr) {
      let token = localStorage.getItem('token');
      if (token) {
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
      }
    },
    success: function (response) {
      let div = '';

      // Crear el campo de búsqueda dinámicamente
      let searchInput = '<input type="text" id="searchInput" class="form-control mb-3" placeholder="Filtrar Categoria....">';
      $('#accordion').before(searchInput);

      // Agregar el div amarillo de advertencia
      let warningDiv = `<div id="warningDiv" class="alert alert-warning text-center" style="display: none;">
                          No se encontraron antecedentes que coincidan con la búsqueda.
                        </div>`;
      $('#accordion').before(warningDiv);

      if (response.status) {
        response.categorias.forEach((element, index) => {
          let checkboxes = '';

          element.antecedentes.forEach(a => {
            checkboxes += `<div class="custom-control custom-checkbox">
                              <input class="custom-control-input" type="checkbox" name="antecedente_${index}" id="customCheckbox_${index}_${a.id}" value="${a.id}" data-nombre="${a.nombre_antecedente}">
                              <label for="customCheckbox_${index}_${a.id}" class="custom-control-label">${a.nombre_antecedente}</label>
                            </div>`;
          });

          div += `<div class="card card-primary">
                    <div class="card-header">
                      <h4 class="card-title w-100">
                        <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseTwo_${index}" aria-expanded="false">${element.nombre}</a>
                      </h4>
                    </div>
                    <div id="collapseTwo_${index}" class="collapse" data-parent="#accordion" style="">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-12 col-md-6">${checkboxes}</div>
                          <div class="col-12 col-md-6">
                            <div class="form-group mt-3">
                              <input type="text" class="form-control form-control-sm descripcion-antecedentes" data-descripcion-id="descripcion-antecedentes_${index}">
                            </div>
                            <button class="btn btn-primary agregar-datos" data-target="${index}" data-grupo-id="${element.id}">Agregar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>`;
        });

      }
      $('#accordion').html(div);

      // Función de búsqueda dinámica
      $('#searchInput').on('input', function () {
        let query = $(this).val().toLowerCase();
        let found = false;

        $('#accordion .card').each(function () {
          let card = $(this);
          let cardTitle = card.find('.card-header a').text().toLowerCase();
          let hasMatchInTitle = cardTitle.includes(query);

          let cardBody = card.find('.card-body');
          let checkboxes = cardBody.find('label');

          let hasMatchInCheckboxes = false;

          checkboxes.each(function () {
            if ($(this).text().toLowerCase().includes(query)) {
              hasMatchInCheckboxes = true;
            }
          });

          if (hasMatchInTitle || hasMatchInCheckboxes) {
            card.show();
            found = true;
          } else {
            card.hide();
          }
        });

        if (!found) {
          $('#warningDiv').show(); // Mostrar la advertencia
        } else {
          $('#warningDiv').hide(); // Ocultar la advertencia si hay resultados
        }

        // Si el input está vacío, restauramos todo
        if (query === '') {
          $('#accordion .card').show();
          $('#warningDiv').hide();
        }
      });

      // Controladores de eventos para agregar datos
      $('.agregar-datos').click(function () {
        let index = $(this).data('target');
        let grupo_id = $(this).data('grupo-id');
        let selectedCheckboxes = $(`input[name="antecedente_${index}"]:checked`).map(function () {
          return {
            nombre: $(this).data('nombre'),
            id: $(this).val()
          };
        }).get();
        let descripcion = $(`input[data-descripcion-id="descripcion-antecedentes_${index}"]`).val();

        selectedCheckboxes.forEach(antecedente => {
          let tr = `<tr>
                <td>${new Date().toISOString().split('T')[0]}</td>
                <td>${antecedente.nombre}</td>
                <td style="display: none;">${antecedente.id}</td>
                <td style="display: none;">${grupo_id}</td>
                <td>${response.categorias[index].nombre}</td>
                <td>${descripcion}</td>
                <td>
                    <div class="div">
                        <button class="btn btn-primary btn-sm eliminar-fila">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
          $('#body-diagnos').append(tr);
        });

        $(`input[data-descripcion-id="descripcion-antecedentes_${index}"]`).val('');
        $(`input[name="antecedente_${index}"]:checked`).prop('checked', false);
      });

      // Eliminar fila
      $('#body-diagnos').on('click', '.eliminar-fila', function () {
        $(this).closest('tr').remove();
      });

    },
    error: function (jqXHR, status, error) {
      console.log("Disculpe, existió un problema");
    },
    complete: function (jqXHR, status) {
    },
  });
}



/**FIN ANTECEDENTES PERSONALES  */


let GuardarProductoInicializado = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !GuardarProductoInicializado) {
    guardar_producto();
    GuardarProductoInicializado = true;
  }
});

function guardar_producto() {
  $('#btn-guardar-producto').click(function () {


    let nombre_producto = $('#nuevo-medicamento2').val();

    let json = {
      producto: {
        nombre_producto,
      },


    };



    guardando_producto(json);

    // }
  });
}



function guardando_producto(json) {

  peticionJWT({
    url: urlServidor + 'producto/guardar',
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


      if (response.estado) {
        Swal.fire({
          title: "Registro de Productos",
          text: response.mensaje,
          icon: 'success'
        })


        $('#modal-registrar-producto').modal('hide');
        $('#nuevo-medicamento2').val(' ');
        selectMedicamento();


      } else {

        Swal.fire({
          title: "Registro de Productos",
          text: response.mensaje,
          icon: 'error'
        })


      }
    },
    error: function (jqXHR, status, error) {
      console.log('Disculpe, existió un problema');

    }
  });


}



function cargarAntecedentesfamiliares() {
  peticionJWT({
    url: urlServidor + "antecedentesfamiliares/listarantecedentesfamiliares",
    type: "GET",
    dataType: "json",
    beforeSend: function (xhr) {
      let token = localStorage.getItem('token');
      if (token) {
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
      }
    },
    success: function (response) {
      let div = '';
      let searchBox = `
        <input type="text" id="buscarAntecedentesFamiliares" class="form-control mb-2" placeholder="Filtrar Categoria" autocomplete="off">
        <div id="warningMessage" class="alert alert-warning mt-2" style="display: none;">No se encontraron antecedentes.</div>
      `;

      if (response.status) {
        response.categorias.forEach((element, index2) => {
          let checkboxes_fam = '';

          element.antecedentesfamiliares.forEach(a => {
            checkboxes_fam += `<div class="custom-control custom-checkbox">
                              <input class="custom-control-input" type="checkbox" name="antecedente_${index2}" id="customCheckbox_f${index2}_${a.id}" value="${a.id}" data-nombre="${a.nombre_antecedente}">
                              <label for="customCheckbox_f${index2}_${a.id}" class="custom-control-label">${a.nombre_antecedente}</label>
                            </div>`;
          });

          div += `<div class="card card-primary">
                    <div class="card-header">
                      <h4 class="card-title w-100">
                        <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseTwo_${index2}" aria-expanded="false">${element.nombre}</a>
                      </h4>
                    </div>
                    <div id="collapseTwo_${index2}" class="collapse" data-parent="#accordion_familiares">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-12 col-md-6">${checkboxes_fam}</div>
                          <div class="col-12 col-md-6">
                            <div class="form-group mt-3">
                              <input type="text" class="form-control form-control-sm descripcion-antecedentes" data-descripcion-id="descripcion-antecedentes2_${index2}">
                            </div>
                            <button class="btn btn-primary agregar-datos-familiares" data-target="${index2}" data-grupo-familia-id="${element.id}">Agregar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>`;
        });
      }

      $('#accordion_familiares').html(searchBox + div);

      // Filtrar antecedentes
      $("#buscarAntecedentesFamiliares").on("keyup", function () {
        let value = $(this).val().toLowerCase();
        let found = false;

        $("#accordion_familiares .card").each(function () {
          let title = $(this).find(".card-title a").text().toLowerCase();
          let antecedentes = $(this).find(".custom-checkbox label").map(function () {
            return $(this).text().toLowerCase();
          }).get();

          let match = title.includes(value) || antecedentes.some(a => a.includes(value));
          $(this).toggle(match);

          if (match) found = true;
        });

        $("#warningMessage").toggle(!found);
      });

      // Deseleccionar otros checkboxes al seleccionar uno
      $('input[type="checkbox"]').change(function () {
        $('input[type="checkbox"]').not(this).prop('checked', false);
      });

      // Agregar datos al hacer clic en "Agregar"
      $('.agregar-datos-familiares').click(function () {
        let index2 = $(this).data('target');
        let grupo_id = $(this).data('grupo-familia-id');
        let selectedCheckboxes = $(`input[name="antecedente_${index2}"]:checked`).map(function () {
          return {
            nombre: $(this).data('nombre'),
            id: $(this).val()
          };
        }).get();
        let descripcion = $(`input[data-descripcion-id="descripcion-antecedentes2_${index2}"]`).val();

        selectedCheckboxes.forEach(antecedente => {
          let tr = `<tr>  
                <td>${new Date().toISOString().split('T')[0]}</td>
                <td>${antecedente.nombre}</td>
                <td style="display: none;">${antecedente.id}</td>
                <td style="display: none;">${grupo_id}</td>
                <td>${response.categorias[index2].nombre}</td>
                <td>${descripcion}</td>
                <td>
                    <div class="div">
                        <button class="btn btn-primary btn-sm eliminar-fila-2">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
          $('#body-diagnosticos-familiares').append(tr);
        });

        // Limpiar la descripción y los checkboxes después de agregar los datos
        $(`input[data-descripcion-id="descripcion-antecedentes2_${index2}"]`).val('');
        $(`input[name="antecedente_${index2}"]:checked`).prop('checked', false);
      });

      // Eliminar fila
      $('#body-diagnosticos-familiares').on('click', '.eliminar-fila-2', function () {
        $(this).closest('tr').remove();
      });

    },
    error: function (jqXHR, status, error) {
      console.log("Disculpe, existió un problema");
    },
  });
}

let GuardarAnteFamInicializado = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_5' && !GuardarAnteFamInicializado) {
    guardar_antecendente_familiares();
    GuardarAnteFamInicializado = true;
  }
});

function guardar_antecendente_familiares() {
  $('#guardar-antecedente-familiar').click(function () {
    let id = localStorage.getItem('citas_id');
    peticionJWT({
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
          let fam_tecedente = [];

          // Recorrer cada fila de la tabla de antecedentes
          $('#body-diagnosticos-familiares tr').each(function () {
            let fecha = $(this).find('td:eq(0)').text(); // Obtener la fecha de la primera columna
            let nombreAntecedente = $(this).find('td:eq(1)').text(); // Obtener el nombre del antecedente de la segunda columna
            let antecedentesfamiliares_id = $(this).find('td:eq(2)').text(); // Obtener el ID del antecedente de la tercera columna
            let grupos_antecedentes_familiares_id = $(this).find('td:eq(3)').text(); // Obtener el ID del grupo de la cuarta columna
            let categoria = $(this).find('td:eq(4)').text(); // Obtener la categoría de la quinta columna
            let descripcion = $(this).find('td:eq(5)').text(); // Obtener la descripción de la sexta columna

            // Agregar cada antecedente como un objeto al array de antecedentes
            fam_tecedente.push({
              paciente_id: paciente_id,
              fecha: fecha,
              antecedentesfamiliares_id: antecedentesfamiliares_id,
              grupos_antecedentes_familiares_id: grupos_antecedentes_familiares_id,
              observacion: descripcion
            });
          });

          // Construir el objeto JSON para enviar al servidor
          let json = {
            familiares_antecedentes: fam_tecedente
          };

          // Ahora puedes enviar este objeto JSON al servidor para guardar los antecedentes del paciente
          console.log(json);

          guardando_antecedentes_familiares(json);
          limpiarTabla2();
          cargarDatatablefamiliresantecedentes(paciente_id);



        } else {
          console.log("Error al obtener datos de la cita");
        }
      },
      error: function (jqXHR, status, error) {
        console.log('Disculpe, existió un problema');
      }
    });
  });
}




function guardando_antecedentes_familiares(json) {

  peticionJWT({
    // la URL para la petición
    url: urlServidor + 'antecedentesfamiliares/guardar',
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

function limpiarTabla2() {
  $('#body-diagnosticos-familiares').empty();
}



function datatable_antecedentesfamiliares() {

  let id = localStorage.getItem('citas_id');
  peticionJWT({
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
        //     console.log(paciente_id);

        cargarDatatablefamiliresantecedentes(paciente_id);

      } else {
        console.log("Error al obtener datos de la cita");
      }
    },
    error: function (jqXHR, status, error) {
      console.log('Disculpe, existió un problema');
    }
  });

}

function cargarDatatablefamiliresantecedentes(paciente_id) {
  tabla2 = $('#tabla-familiar-diagnosticos').DataTable({
    "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "ajax":
    {
      url: urlServidor + 'antecedentesfamiliares/listar/' + paciente_id,
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
    "iDisplayLength": 5,//Paginación
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
