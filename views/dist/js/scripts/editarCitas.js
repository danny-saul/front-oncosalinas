var detalleProducto = [];
var detalle_diagnostico = [];
var detalle_orden = [];
var detalle_orden_laboratorio = [];

var tabla_recetas;
_init();

function _init() {
  recuperarcontingencia();
  recuperaraislamiento();
  cargarDatos();
  listar_resumen();
  cargarAntecedentes();
  cargarAntecedentesfamiliares();
  datatable_antecedentes();
  cargarNumerodeOrdenLabs();
  storage_citas();
  generarNumerosOrden_laboratorio();

  cargarNumerodeRecetaEdi();
  guardarHistorial();


}



/** GENERAR NUMEROS ALEARTORIOS ORDEN IMAGEN */

let IniciarNumOrdenImg = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_4' && !IniciarNumOrdenImg) {
    generarNumerosOrdenImg();
    IniciarNumOrdenImg = true;
  }
});

function generarNumerosOrdenImg() {
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

function guardarCodigoImg() {
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
      generarNumerosOrdenImg();
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



/*RECETA----------------------------- */


let diagnosticoInicializado = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !diagnosticoInicializado) {
    cargarDiagnostico();
    diagnosticoInicializado = true;
  }
});

function cargarDiagnostico() {

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




let InicarDosis = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !InicarDosis) {
    cargarDosis();
    InicarDosis = true;
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

let IniciarFrecuencia = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !IniciarFrecuencia) {
    cargarFrecuencia();
    IniciarFrecuencia = true;
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

let iniciarSelectMedicamento = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !iniciarSelectMedicamento) {
    selectMedicamento();
    iniciarSelectMedicamento = true;
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



let iniciarSelectVia = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !iniciarSelectVia) {
    selectVia();
    iniciarSelectVia = true;
  }
});
function selectVia() {
  peticionJWT({
    // la URL para la petición
    url: urlServidor + "via/listar",
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
        let data = response.via.map(element => ({
          id: element.id,
          text: element.tipo_via
        }));

        $('#via').select2({
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


let IniciarAgregarMedicamento = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !IniciarAgregarMedicamento) {
    agregarProductos();
    IniciarAgregarMedicamento = true;
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
          console.log(response);
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
                  if (dosis_id.length == 0) {
                    Swal.fire({
                      title: "Receta",
                      text: 'Seleccione una dosis',
                      icon: 'error'
                    })

                  } else
                    if (via_id.length == 0) {
                      Swal.fire({
                        title: "Receta",
                        text: 'Seleccione una via',
                        icon: 'error'
                      })

                    } else
                      if (frecuencia_id.length == 0) {
                        Swal.fire({
                          title: "Receta",
                          text: 'Seleccione una frecuencia',
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
                          console.log(json);
                          validar(json);
                          tabla_actualizar();



                        }
            selectMedicamento();
            cargarDosis();
            cargarFrecuencia();
            selectVia();


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
  console.log(tr);
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
        console.log(res);
        res.cantidad++;
        res.totalParcial = (res.cantidad * res.precio_venta).toFixed(2);
        console.log('aumentando');
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
      console.log('disminuyendo');
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
      //     console.log(response);
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




let tipoDiagnosticoIniciar = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !tipoDiagnosticoIniciar) {
    cargarTipo_diagnostico();
    tipoDiagnosticoIniciar = true;
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
            console.log(response);
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
                        console.log(json);
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
      /*      tr.querySelector('.delete').addEventListener('click', borrarItem);
          tr.querySelector('.btn-primary').addEventListener('click', aumentar);
          tr.querySelector('.btn-dark').addEventListener('click', disminuir); */

      /*  actualizarDatos();
       limpiarCampos();  */
    });
  }

}


function calcularSuma() {
  // Obtén los valores de los inputs
  let peso = parseFloat($('#epeso').val()) || 0;
  let talla = parseFloat($('#etalla').val()) || 0;

  // Calcula la suma
  let calculo_imc = peso / (talla * talla);

  // Muestra el resultado en el input resultado
  $('#eimc').val(parseFloat(calculo_imc).toFixed(2));

}

// Detecta cambios en los inputs y calcula la suma
$('#epeso, #etalla').on('input', function () {
  calcularSuma();
});


/* 
let IniciarGuardarHistorial = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !IniciarGuardarHistorial) {
    guardarHistorial();
    IniciarGuardarHistorial = true;
  }
});
 */


function guardarHistorial() {
  $('#btn-guardar').click(function () {

    let doctor_id = JSON.parse(localStorage.getItem('sesion-2'));
    console.log(doctor_id);

    let id = $('#historial-clinico-id').val();
    let citas_id = $('#citas-id').val();
    let motivo_consulta = $('#editar-motivo-consulta').val();
    let enfermedad_actual = $('#editar-enfermedad-actual').val();
    let antecedentes = $('#editar-antecedentes').val();
    let evolucion = $('#editar-evolucion').val();
    let alergias = $('#editar-alergias').val();
    let antecedentes_familiares = $('#editar-ant-familiares').val();
    let examen_fisico = $('#editar-examen-fisico').val();
    let plan = $('#editar-plan').val();



    let dia_descanso = $('#edia-descanso').val();
    let actividad_laboral = $('#eactividad-laboral').val();
    let entidad_laboral = $('#eentidad-trabajo').val();
    let direccion = $('#edireccion-trabajo').val();
    let observacion = $('#eobservacion-certificado').val();
    let tipo_contingencia_id = $('#etipo-contingencia option:selected').val();
    let aislamiento_id = $('#etipo-aislamiento option:selected').val();
    let citas = $('#citas-id').val();


    let temperatura = $('#etemperatura').val();
    let peso = $('#epeso').val();
    let talla = $('#etalla').val();
    let presion_arterial = $('#epresionarterial').val();
    let imc = $('#eimc').val();
    let pulso = $('#epulso').val();
    let frecuencia_respiratoria = $('#efrecuenciarespiratoria').val();
    let saturacion_oxigeno = $('#esaturacion').val();
    let observacion_examen = $('#emotivo-observacion').val();
    let recomendacion = $('#emotivo-recomendacion').val();

    let array4 = [];
    // Asegurarse de declarar la variable antes
    let array5 = [];

    // Verificar que todas las variables tienen valores antes de la condición
    console.log("Valores examen físico:", temperatura, peso, talla, presion_arterial, imc, pulso, frecuencia_respiratoria, observacion_examen, recomendacion, saturacion_oxigeno);



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


    if (temperatura && citas && peso && talla && presion_arterial && imc && pulso && frecuencia_respiratoria && observacion_examen && recomendacion && saturacion_oxigeno) {
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
    // Verificar si array5 tiene contenido antes de enviar
    console.log("Array de examen físico:", array5);



    let json = {
      historial_clinico: {
        id,
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

      certificados_medicos: array4,
      examen_fisica: array5,




    }



    console.log(json);
    ajaxGuardandohistorial(json);

  });
}



function ajaxGuardandohistorial(json) {
  peticionJWT({
    url: urlServidor + 'citas/editarHistorialClinico',
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

        location.href = urlCliente + 'inicio/citasatendidas';

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


  /*   if (json.examenes_digitales.img1 == ' ') {
  
    } else {
        let imagen = $('#examen-digital-1')[0].files[0];
        let formData = new FormData();
        formData.append('fichero', imagen);
  
        peticionJWT({
            // la URL para la petición
            url: urlServidor + 'historial_clinico/fichero',
            // especifica si será una petición POST o GET
            type: 'POST',
            // el tipo de información que se espera de respuesta
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (responseImg) {
                if (responseImg.status) {
  
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
   */




}


/*IMAGENES */

let TipoEstudioInicializadoE = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_4' && !TipoEstudioInicializadoE) {
    selectTipoEstudio();
    TipoEstudioInicializadoE = true;
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
    } else

      if (lateralidad_id == 0) {
        Swal.fire({
          title: "Receta",
          text: 'Seleccione un el tipo de lateralidad',
          icon: 'error'
        })
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
            console.log(response);
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
                        console.log(json);
                        validar3(json);
                        tabla_actualizar3();



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
            <button class="btn btn-danger delete">
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
      /*      tr.querySelector('.delete').addEventListener('click', borrarItem);
          tr.querySelector('.btn-primary').addEventListener('click', aumentar);
          tr.querySelector('.btn-dark').addEventListener('click', disminuir); */

      /*  actualizarDatos();
       limpiarCampos();  */
    });
  }

}



/*ANTECEDENTES   */


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



function agregar_antecedentes(grupo_id, antecedente_id) {

  alert('aqqui van chelas');

  let descripcion_antecedentes = $('#descripcion-antecedentes').val();

  console.log(descripcion_antecedentes);
  console.log('grupo_id', grupo_id);
  console.log('antecedente_id', antecedente_id);


}

let iniciarAggProducto = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !iniciarAggProducto) {
    guardar_producto();
    iniciarAggProducto = true;
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


    /*    if (!validarProducto(json)) {
          console.log("llene los campos de datos de persona");
      } else {  */
    //Realizar peticion ajax
    console.log(json);
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
      toastr.options = {
        "closeButton": true,
        "preventDuplicates": true,
        "positionClass": "toast-top-right",
        "progressBar": true,
      };

      if (response.estado) {
        toastr["success"](response.mensaje, "Registro de Productos");
        //    borrarCampos();
        $('#modal-registrar-producto').modal('hide');
        $('#nuevo-medicamento2').val(' ');
        selectMedicamento();
        toastr["error"](response.mensaje, "Registro de Productos");

      } else {
        toastr["error"](response.mensaje, "Registro de Productos");

      }
    },
    error: function (jqXHR, status, error) {
      console.log('Disculpe, existió un problema');

    }
  });

  /* if (json.producto.imagen == 'productodefault.png') {

  } else {
      let imagen = $('#imagen-Producto')[0].files[0];
      let formData = new FormData();
      formData.append('fichero', imagen);

      peticionJWT({
          // la URL para la petición
          url: urlServidor + 'producto/subirImagenes',
          // especifica si será una petición POST o GET
          type: 'POST',
          // el tipo de información que se espera de respuesta
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function (responseImg) {
              if (responseImg.estado) {

              }
          },
          error: function (jqXHR, status, error) {
              console.log('Disculpe, existió un problema');
          },
          complete: function (jqXHR, status) {
              // console.log('Petición realizada');
          }
      });
  } */


}


/* 
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

        // Ordenar las citas por fecha descendente
        response.paciente.citas.sort((a, b) => new Date(b.fecha) - new Date(a.fecha));

        response.paciente.citas.forEach(cita => {
          div += `
            <div class="row">
              <div class="col-3 d-flex flex-column align-items-center mt-15" style="margin-top: 182px;">
                <p class="mb-2"><i class="fas fa-user"></i> Médico: ${cita.doctor.persona.nombre + ' ' + cita.doctor.persona.apellido}</p> 
                <p class="mb-2">Especialidad: </p>
                <p class="mb-2">Fecha: ${cita.fecha}</p> 
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
               ${cita.receta && cita.receta.length > 0 && cita.receta[0].receta_detalle && cita.receta[0].receta_detalle.length > 0 ?
              `<ul>${cita.receta[0].receta_detalle
                .filter(item => item.estado === 'A')
                .map(item => {
                  const nombre = item.producto?.nombre_producto || 'Producto desconocido';
                  const cant = item.cantidad || '-';
                  const freq = item.frecuencia?.tipo_frecuencia || '-';
                  return `<li>${nombre} - Cantidad: ${cant} - Frecuencia: ${freq}</li>`;
                })
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
      $('#loader').hide(); // Ocultar el loader
    }
  });
} */

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
        response.citas.sort((a, b) => new Date(b.fecha_hora) - new Date(a.fecha_hora));

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
                : '<p>No hay órdenes de imágenes disponibles en estado </p>'}

                                          
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


/*AQUI VA EL EDITAR CITA */


/* let iniciarRecupAislamiento = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_3' && !iniciarRecupAislamiento) {
    recuperaraislamiento();
    iniciarRecupAislamiento = true;
  }
});

 */
function recuperaraislamiento() {
  peticionJWT({
    url: urlServidor + 'citas/listaraislamiento',
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
        let option = '<option value="0">Seleccione tipo de aislamiento</option>';
        response.aislamiento.forEach(element => {
          option += `<option value=${element.id}>${element.tipo_aislamiento}</option>`;
        });
        $('#etipo-aislamiento').html(option);
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

/* let iniciarRecupCOntingencia = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_3' && !iniciarRecupCOntingencia) {
    recuperarcontingencia();
    iniciarRecupCOntingencia = true;
  }
});

 */

function recuperarcontingencia() {
  peticionJWT({
    url: urlServidor + 'citas/listarcontingencia',
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
      if (response.status) {
        let option = '<option value="0">Seleccione tipo de contingencia</option>';
        response.tipo_contingencia.forEach(element => {
          option += `<option value=${element.id}>${element.contingencia}</option>`;
        });
        $('#etipo-contingencia').html(option);
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
function cargarDatos() {

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
      console.log(response);
      if (response.status) {
        $('#cita-id').text(response.citas.id);
        $('#citas-id').val(response.citas.id);
        $('#paciente-id').val(response.citas.paciente_id);
        $('#doctor-id').val(response.citas.doctor.id);
        $('#nombres-apellidos').text(response.citas.paciente.persona.nombre + ' ' + response.citas.paciente.persona.apellido);
        $('#medico-nombre').text(response.citas.doctor.persona.nombre + ' ' + response.citas.doctor.persona.apellido);
        $('#editar-motivo-consulta').text(response.citas.historial_clinico[0].motivo_consulta);
        $('#editar-enfermedad-actual').text(response.citas.historial_clinico[0].enfermedad_actual);
        $('#editar-antecedentes').text(response.citas.historial_clinico[0].antecedentes);
        $('#editar-evolucion').text(response.citas.historial_clinico[0].evolucion);
        $('#editar-alergias').text(response.citas.historial_clinico[0].alergias);

        $('#editar-ant-familiares').text(response.citas.historial_clinico[0].antecedentes_familiares);
        $('#editar-examen-fisico').text(response.citas.historial_clinico[0].examen_fisico);
        $('#editar-plan').text(response.citas.historial_clinico[0].plan);
        $('#historial-clinico-id').val(response.citas.historial_clinico[0].id);

        /*     $('#etemperatura').val(response.citas.examen_fisica[0].temperatura);
            $('#epeso').val(response.citas.examen_fisica[0].peso);
            $('#etalla').val(response.citas.examen_fisica[0].talla);
            $('#epresionarterial').val(response.citas.examen_fisica[0].presion_arterial);
            $('#epulso').val(response.citas.examen_fisica[0].pulso);
            $('#efrecuenciarespiratoria').val(response.citas.examen_fisica[0].frecuencia_respiratoria);
            $('#eimc').val(response.citas.examen_fisica[0].imc);
            $('#esaturacion').val(response.citas.examen_fisica[0].saturacion_oxigeno);
            $('#emotivo-observacion').val(response.citas.examen_fisica[0].observacion_examen);
            $('#emotivo-recomendacion').val(response.citas.examen_fisica[0].recomendacion);
   */

        if (response.citas.examen_fisica && response.citas.examen_fisica.length > 0) {
          let examen = response.citas.examen_fisica[0];

          $('#etemperatura').val(examen.temperatura ?? "");
          $('#epeso').val(examen.peso ?? "");
          $('#etalla').val(examen.talla ?? "");
          $('#epresionarterial').val(examen.presion_arterial ?? "");
          $('#epulso').val(examen.pulso ?? "");
          $('#efrecuenciarespiratoria').val(examen.frecuencia_respiratoria ?? "");
          $('#eimc').val(examen.imc ?? "");
          $('#esaturacion').val(examen.saturacion_oxigeno ?? "");
          $('#emotivo-observacion').val(examen.observacion_examen ?? "");
          $('#emotivo-recomendacion').val(examen.recomendacion ?? "");
        } else {
          console.warn("No hay datos de examen físico disponibles");
        }


        /*       $('#edia-descanso').val(response.citas.certificados_medicos[0].dia_descanso);
              $('#eactividad-laboral').val(response.citas.certificados_medicos[0].actividad_laboral);
              $('#eentidad-trabajo').val(response.citas.certificados_medicos[0].entidad_laboral);
              $('#edireccion-trabajo').val(response.citas.certificados_medicos[0].direccion);
              $('#eobservacion-certificado').val(response.citas.certificados_medicos[0].observacion);
              $('#etipo-contingencia').val(response.citas.certificados_medicos[0].tipo_contingencia.id);
              $('#etipo-aislamiento').val(response.citas.certificados_medicos[0].aislamiento.id);
              $('#citas-id').val(response.citas.id);
           */

        if (response.citas.certificados_medicos && response.citas.certificados_medicos.length > 0) {
          let certificado = response.citas.certificados_medicos[0];

          $('#edia-descanso').val(certificado.dia_descanso ?? "");
          $('#eactividad-laboral').val(certificado.actividad_laboral ?? "");
          $('#eentidad-trabajo').val(certificado.entidad_laboral ?? "");
          $('#edireccion-trabajo').val(certificado.direccion ?? "");
          $('#eobservacion-certificado').val(certificado.observacion ?? "");
          $('#etipo-contingencia').val(certificado.tipo_contingencia?.id ?? "");
          $('#etipo-aislamiento').val(certificado.aislamiento?.id ?? "");
        } else {
          console.warn("No hay datos de certificados médicos disponibles");
        }


        $('#cedula').text(response.citas.paciente.persona.cedula);


        let tr = `<tr id="fila-prod-" class="fila-productos">
                    <td style="display: none">0</td>
                    <td style="display: none">0</td>
                    <td style="display: none">0</td>
                    <td style="display: none">0</td>
                    <td style="display: none">0</td>
                    <th style="display: none">
                        <div>
                            <button class="btn btn-outline-danger" disabled>
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </th>
                    <td style="display:none;">S</td>
                    <td style="display:none;">${response.citas.id}</td>
                    <th style="display:none;"></th>
                </tr>
              `;


        let tr2 = `<tr id="fila-diag-" class="fila-diagnosticos">
         <td style="display: none">0</td>
         <td style="display: none">0</td>
         <td style="display: none">0</td>
         <td style="display: none">0</td>
         <td style="display: none">0</td>
         <th style="display: none">
             <div>
                 <button class="btn btn-outline-danger" disabled>
                     <i class="fas fa-minus"></i>
                 </button>
             </div>
         </th>
         <td style="display:none;">S</td>
         <td style="display:none;">${response.citas.id}</td>
         <th style="display:none;"></th>
     </tr>
   `;




        let tr3 = `<tr id="fila-ord-" class="fila-ordenes">
         <td style="display: none">0</td>
         <td style="display: none">0</td>
         <td style="display: none">0</td>
         <td style="display: none">0</td>
         <td style="display: none">0</td>
         <th style="display: none">
             <div>
                 <button class="btn btn-outline-danger" disabled>
                     <i class="fas fa-minus"></i>
                 </button>
             </div>
         </th>
         <td style="display:none;">S</td>
         <td style="display:none;">${response.citas.id}</td>
         <th style="display:none;"></th>
     </tr>
   `;

        let tr4 = `<tr id="fila-lab-" class="fila-laboratorio">
        <td style="display: none">0</td>
        <td style="display: none">0</td>
        <td style="display: none">0</td>
        <td style="display: none">0</td>
        <td style="display: none">0</td>
        <th style="display: none">
            <div>
                <button class="btn btn-outline-danger" disabled>
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </th>
        <td style="display:none;">S</td>
        <td style="display:none;">${response.citas.id}</td>
        <th style="display:none;"></th>
    </tr>
  `;







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

$(document).ready(function () {
  // Asignamos el evento click a los botones con clase "editar-receta"
  $(document).on('click', '.editar-receta', function () {
    let id = $(this).data('id');
    let cantidad = $(this).data('cantidad');
    let producto = $(this).data('producto');
    let dosisId = $(this).data('dosis-id');
    let frecuenciaId = $(this).data('frecuencia-id');
    let duracion = $(this).data('duracion');
    let observacion = $(this).data('observacion');

    // Asignamos los valores a los inputs del modal
    $('#editar-receta-id').val(id);
    $('#editar-cantidad').val(cantidad);
    $('#editar-producto').val(producto);
    $('#editar-dosis').val(dosisId);
    $('#editar-frecuencia').val(frecuenciaId);
    $('#editar-duracion').val(duracion);
    $('#editar-observacion').val(observacion);

    // Abrimos el modal
    $('#modalEditarReceta').modal('show');
  });
});


let recupFrecuenciaME = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !recupFrecuenciaME) {
    RecuperarFrecuenciaModal();
    recupFrecuenciaME = true;
  }
});


function RecuperarFrecuenciaModal() {
  peticionJWT({
    url: urlServidor + 'frecuencia/listar',
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
        let option = '<option value="0">Seleccione la frecuencia</option>';
        response.frecuencia.forEach(element => {
          option += `<option value="${element.id}">${element.tipo_frecuencia}</option>`;
        });
        $('#editar-frecuencia').html(option);
      }
    },
    error: function (jqXHR, status, error) {
      console.log('Disculpe, existió un problema');
    }
  });
}


let recupDosisE = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !recupDosisE) {
    recuperarDosis();
    recupDosisE = true;
  }
});

function recuperarDosis() {
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
        $('#editar-dosis').html(option);
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






let recupViaE = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !recupViaE) {
    recuperarVia();
    recupViaE = true;
  }
});

function recuperarVia() {
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
        let data = response.via.map(element => ({
          id: element.id,
          text: element.tipo_via
        }));

        $('#editar-via').select2({
          data: data,
          dropdownParent: $('#modalEditarReceta'), // ID corregido
          width: '100%',
          allowClear: true,

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




/** INCIIO EDIATA CARGAR DATATABLE RECETA */


/* 
IINCIO COMENTADO 15-05-202 21:05


let iniciarDtReceta = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !iniciarDtReceta) {
    dt_cargarDatatableReceta();
    iniciarDtReceta = true;
  }
});

function dt_cargarDatatableReceta() {

  let citas_id = localStorage.getItem('citas_id');


  tabla_recetas = $('#tabla-recetas').DataTable({
    "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "ajax":
    {
      url: urlServidor + 'citas/datatableRecetas/' + citas_id,
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


function dt_cargarDatatableReceta2() {


  let citas_id = localStorage.getItem('citas_id');

  tabla_recetas = $('#tabla-recetas').DataTable({
    "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "ajax":
    {
      url: urlServidor + 'citas/datatableRecetas/' + citas_id,
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
 */
function editar_medicamento(id) {
  $('#modalEditarReceta').modal('show');
  cargarlistarreceta(id);
}



function cargarlistarreceta(id) {

  peticionJWT({
    url: urlServidor + 'citas/listar_recetas/' + id,
    type: 'GET',
    headers: { "Authorization": `Bearer ${token}` },
    dataType: 'json',
    success: function (response) {
      console.log(response);
      if (response.status) {


        $('#editar-receta-id').val(id);
        $('#editar-cantidad').val(response.receta.cantidad);
        $('#editar-producto').val(response.producto.nombre_producto);
        $('#editar-dosis').val(response.dosis.id);
        $('#editar-frecuencia').val(response.frecuencia.id);
        $('#editar-via').val(response.via.id);
        $('#editar-duracion').val(response.receta.duracion);
        $('#editar-observacion').val(response.receta.observacion);


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



let iniciarEditarMedicamento = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !iniciarEditarMedicamento) {
    editandomedicamento();
    iniciarEditarMedicamento = true;
  }
});


function editandomedicamento() {

  $('#guardarEdicionReceta').click(function () {


    /*     $('#editar-receta-id').val(response.receta.id);
        $('#editar-cantidad').val(response.receta.cantidad);
        $('#editar-producto').val(response.producto.nombre_producto);
        $('#editar-dosis').val(response.dosis.id);
        $('#editar-frecuencia').val(response.frecuencia.id);
        $('#editar-duracion').val(response.receta.duracion);
        $('#editar-observacion').val(response.receta.observacion); */


    let id = $('#editar-receta-id').val();
    let frecuencia_id = $('#editar-frecuencia option:selected').val();
    let dosis_id = $('#editar-dosis option:selected').val();
    let cantidad = $('#editar-cantidad').val();
    let duracion = $('#editar-duracion').val();
    let via_id = $('#editar-via option:selected').val();
    let observacion = $('#editar-observacion').val();


    let json = {
      receta: {
        id: id,
        frecuencia_id: frecuencia_id,
        via_id: via_id,
        dosis_id: dosis_id,
        cantidad: cantidad,
        duracion: duracion,
        observacion: observacion,
      }
    };
    console.log(json);

    peticionJWT({
      // la URL para la petición
      url: urlServidor + 'citas/editarReceta',
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
            title: "Actualizar Receta",
            text: response.mensaje,
            icon: 'success'
          })
          $('#modalEditarReceta').modal('hide');
          datatableRecetaeditar22();

        } else {

          Swal.fire({
            title: "Actualizar Receta",
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


let iniciarGuardarNewMedicamento = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !iniciarGuardarNewMedicamento) {
    guardarNuevomedicamento();
    iniciarGuardarNewMedicamento = true;
  }
});


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



function limpiarTabla2() {
  $('#body-diagnosticos-familiares').empty();
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


function guardarNuevomedicamento() {


  $('#btn-guardar-nuevo-receta').click(function () {



    let producto_id = $('#nuevo-medicamento option:selected').val();



    if (producto_id == "0") {
      Swal.fire({
        title: "Receta",
        text: 'Seleccione un medicamento',
        icon: 'error'
      })
    } else {

      let producto_id = $('#nuevo-medicamento option:selected').val();
      let cantidad = $('#nuevo-cantidad').val();
      let dosis_id = $('#dosis option:selected').val();
      let via_id = $('#via option:selected').val();
      let frecuencia_id = $('#frecuencia option:selected').val();
      let duracion = $('#duracion').val();
      let observacion = $('#obs').val();
      let receta_id = $('#id-rece').val();


      let json = {
        orden_rece: {

          receta_id: parseInt(receta_id),
          producto_id: parseInt(producto_id),
          via_id: parseInt(via_id),
          cantidad: parseInt(cantidad),
          dosis_id: parseInt(dosis_id),
          frecuencia_id: parseInt(frecuencia_id),
          duracion: duracion,
          observacion: observacion,


        }

      };

      if (!validarnuevorece(json)) {
        /*   if (parseInt(cantidad) > stock) {
            Swal.fire({
              title: "Receta",
              text: 'Cantidad supera al stock',
              icon: 'error'
            });
          } */
        console.log("llene los campos de datos de persona");
      } else {
        //Realizar peticion ajax
        console.log(json);
        guardando_edicionreceta(json);

      }

    }
  });

}


function validarnuevorece(json) {
  let orden_rece = json.orden_rece;

  if (orden_rece.producto_id.length == 0) {
    Swal.fire({
      title: "Receta",
      text: 'Seleccione un Producto',
      icon: 'error'
    })

  } else
    if (orden_rece.cantidad.length == 0) {
      Swal.fire({
        title: "Receta",
        text: 'Ingrese una Cantidad',
        icon: 'error'
      })

    } else
      if (parseInt(orden_rece.cantidad) == 0 || parseInt(orden_rece.cantidad) < 0) {
        Swal.fire({
          title: "Receta",
          text: 'Ingrese un valor mayor a 0',
          icon: 'error'
        })
      } else
        if (orden_rece.dosis_id == 0) {
          Swal.fire({
            title: "Receta",
            text: 'Seleccione una dosis',
            icon: 'error'
          })

        } else
          if (orden_rece.frecuencia_id == 0) {
            Swal.fire({
              title: "Receta",
              text: 'Seleccione una frecuencia',
              icon: 'error'
            })

          } else
            if (orden_rece.duracion.length == 0) {
              Swal.fire({
                title: "Receta",
                text: 'Ingrese la duracion',
                icon: 'error'
              })

            } else if (orden_rece.observacion.length == 0) {
              Swal.fire({
                title: "Receta",
                text: 'Ingrese la observacion',
                icon: 'error'
              })
            } else {
              return true;
            }



}

function guardando_edicionreceta(json) {

  peticionJWT({
    url: urlServidor + 'citas/agregaredicionmedicamento',
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
          title: "Medicamento Agregado Exitosamente",
          text: response.mensaje,
          icon: 'success'
        })
        datatableRecetaeditar22();




        // $('#nuevo-producto')[0].reset();

      } else {


        Swal.fire({
          title: "Edicion de Medicamento",
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

/**FIN EDIACION DATATABLE RECETA */




/**EDITAR  DIAGNOSTICO */

let dtdiagnosticosreceta = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !dtdiagnosticosreceta) {
    dt_cargarDatatabledDiagnostico();
    dtdiagnosticosreceta = true;
  }
});




function dt_cargarDatatabledDiagnostico() {

  let citas_id = localStorage.getItem('citas_id');


  tabla_recetas = $('#tabla-diagnostic').DataTable({
    "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "ajax":
    {
      url: urlServidor + 'citas/dtableeditardiagnostico/' + citas_id,
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

function dt_cargarDatatabledDiagnostico2() {

  let citas_id = localStorage.getItem('citas_id');


  tabla_recetas = $('#tabla-diagnostic').DataTable({
    "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "ajax":
    {
      url: urlServidor + 'citas/dtableeditardiagnostico/' + citas_id,
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

function editar_diagnostico(id) {
  $('#modalEditarDiagnostico').modal('show');
  cargarlistardiagnostico(id);
}

function cargarlistardiagnostico(id) {

  peticionJWT({
    url: urlServidor + 'citas/listar_diagnostico/' + id,
    type: 'GET',
    headers: { "Authorization": `Bearer ${token}` },
    dataType: 'json',
    success: function (response) {
      console.log(response);
      if (response.status) {





        $('#editar-diagnostico-id').val(id);
        $('#editar-diagnostico').val(response.diagnostico.id);
        $('#editar-tdiagnostico').val(response.tipodiagnostico.id);



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

let recupdiagnostico = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !recupdiagnostico) {
    recuperarDiagnostico();
    recupdiagnostico = true;
  }
});



function recuperarDiagnostico() {
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
      //     console.log(response);

      if (response.status) {
        let option = '<option value="0">Seleccione el diagnostico</option>';
        response.diagnostico.forEach(element => {
          option += `<option value=${element.id}>${element.clave} - ${element.descripcion} </option>`;
        });
        $('#editar-diagnostico').html(option);


        /*     if (response.status) {
              let data = response.diagnostico.map(element => ({
                  id: element.id,
                  text: element.clave + ' - ' + element.descripcion
              }));
      
              $('#editar-diagnostico').select2({
                  data: data,
                 
              });
  
            } */


        /*      if (response.status) {
               let data = [{ id: 0, text: 'Seleccione el Diagnostico' }];
               response.diagnostico.forEach(element => {
                   data.push({ id: element.id, text: `${element.clave} - ${element.descripcion}` });
               });
 
               $('#editar-diagnostico').select2({
                   data: data
               });
               
               */





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


let recupTipodiagnostico = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !recupTipodiagnostico) {
    RecuperarTipo_diagnostico();
    recupTipodiagnostico = true;
  }
});


function RecuperarTipo_diagnostico() {
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
        $('#editar-tdiagnostico').html(option);
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

let editandoDIagnosticoIniciar = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !editandoDIagnosticoIniciar) {
    editandodiagnostico();
    editandoDIagnosticoIniciar = true;
  }
});



function editandodiagnostico() {

  $('#guardarEdicionDiagnostico').click(function () {



    let id = $('#editar-diagnostico-id').val();
    let tipo_diagnostico_id = $('#editar-tdiagnostico option:selected').val();


    let json = {
      diagnostico_rece: {
        id: id,
        tipo_diagnostico_id: tipo_diagnostico_id,

      }
    };
    console.log(json);

    peticionJWT({
      // la URL para la petición
      url: urlServidor + 'citas/editarDiagnostico',
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
            title: "Actualizar Diagnostico",
            text: response.mensaje,
            icon: 'success'
          })
          $('#modalEditarDiagnostico').modal('hide');
          dt_cargarDatatabledDiagnostico2();

        } else {

          Swal.fire({
            title: "Actualizar Receta",
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

let IniciarGuardarNuevoDiagnostico = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !IniciarGuardarNuevoDiagnostico) {
    guardarNuevoDiagnostico();
    IniciarGuardarNuevoDiagnostico = true;
  }
});


function guardarNuevoDiagnostico() {


  $('#btn-agregar-diagnosticos-definitivos').click(function () {



    let diagnosticocie10_id = $('#nuevo-diagnostico1 option:selected').val();
    let citas_id = localStorage.getItem('citas_id');

    if (diagnosticocie10_id == "0") {
      Swal.fire({
        title: "Receta",
        text: 'Seleccione un medicamento',
        icon: 'error'
      })
    } else {


      let diagnosticocie10_id = $('#nuevo-diagnostico1 option:selected').val();
      let tipo_diagnostico_id = $('#tipo_diagnostico option:selected').val();


      let json = {
        diagnostico_receta: {

          citas_id: parseInt(citas_id),
          diagnosticocie10_id: parseInt(diagnosticocie10_id),
          tipo_diagnostico_id: parseInt(tipo_diagnostico_id),


        }

      };

      if (!validarnuevorecediagnostico(json)) {
        /*   if (parseInt(cantidad) > stock) {
            Swal.fire({
              title: "Receta",
              text: 'Cantidad supera al stock',
              icon: 'error'
            });
          } */
        console.log("llene los campos de datos de persona");
      } else {
        //Realizar peticion ajax
        console.log(json);
        guardando_ediciondiagnostico(json);

      }

    }
  });

}


function validarnuevorecediagnostico(json) {
  let receta_diagnostico = json.diagnostico_receta;

  if (receta_diagnostico.diagnosticocie10_id.length == 0) {
    Swal.fire({
      title: "Diagnosticos ",
      text: 'Seleccione un Diagnostico',
      icon: 'error'
    })

  } else
    if (receta_diagnostico.tipo_diagnostico_id.length == 0) {
      Swal.fire({
        title: "Diagnosticos",
        text: 'Ingrese una Tipo de Diagnostico',
        icon: 'error'
      })

    } else {
      return true;
    }



}

function guardando_ediciondiagnostico(json) {

  peticionJWT({
    url: urlServidor + 'citas/agregarediciondiagnostico',
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
          title: "Medicamento Agregado Exitosamente",
          text: response.mensaje,
          icon: 'success'
        })
        dt_cargarDatatabledDiagnostico2();




        // $('#nuevo-producto')[0].reset();

      } else {


        Swal.fire({
          title: "Edicion de Medicamento",
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

function eliminar_diagnostico_receta(id) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: "Este medicamento será anulado de la receta.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado(id);
    }
  });
}



function cambiar_estado(id) {
  peticionJWT({
    url: urlServidor + 'citas/cancelardiagnostico/' + id, // Asegúrate de cambiar la ruta
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

        Swal.fire({
          title: "Receta",
          text: 'Se ha eliminado el medicamento de la receta',
          icon: 'success'
        })

        dt_cargarDatatabledDiagnostico2();

      }
    },
    error: function (jqXHR, status, error) {
      console.log('Disculpe, existió un problema');
    }
  });
}


/**FIN DIAGNOSTICO */


/**EDITAR ORDEN  */

let IniciarDTordeneesImg = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_4' && !IniciarDTordeneesImg) {
    dt_listarordenesimagenes();
    IniciarDTordeneesImg = true;
  }
});



function dt_listarordenesimagenes() {

  let citas_id = localStorage.getItem('citas_id');


  tabla_recetas = $('#tabla-orden-imagenes').DataTable({
    "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "ajax":
    {
      url: urlServidor + 'ordenes/dttablelistarorden/' + citas_id,
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


function dt_listarordenesimagenes2() {

  let citas_id = localStorage.getItem('citas_id');


  tabla_recetas = $('#tabla-orden-imagenes').DataTable({
    "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "ajax":
    {
      url: urlServidor + 'ordenes/dttablelistarorden/' + citas_id,
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


function editar_ordenimagenes(id) {
  $('#modalEditarOrdenesImagenes').modal('show');
  cargarlistarOrdenesImagenes(id);
}


function cargarlistarOrdenesImagenes(id) {

  peticionJWT({
    url: urlServidor + 'ordenes/listar_ordenes/' + id,
    type: 'GET',
    headers: { "Authorization": `Bearer ${token}` },
    dataType: 'json',
    success: function (response) {
      console.log(response);
      if (response.status) {





        $('#editar-orden-id').val(id);

        $('#editar-tipoestudio').val(response.orden.tipo_estudio_id);
        $('#editar-justificacion').val(response.orden.justificacion);
        $('#editar-resumen').val(response.orden.resumen);



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



let IniciarRecuperarTipoEstEdit = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_4' && !IniciarRecuperarTipoEstEdit) {
    RecuperarTipoEstudio();
    IniciarRecuperarTipoEstEdit = true;
  }
});


function RecuperarTipoEstudio() {
  peticionJWT({
    // la URL para la petición
    url: urlServidor + "tipoestudio/listar_tipoestudioNormal",
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
        let option = '<option value="0">Seleccione el tipo de estudio</option>';
        response.tipo_Estudio.forEach(element => {
          option += `<option value=${element.id}>${element.codigo} - ${element.descripcion} </option>`;
        });
        $('#editar-tipoestudio').html(option);
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

let iniciareditandoOrdenes = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_4' && !iniciareditandoOrdenes) {
    editandoOrdenes();
    iniciareditandoOrdenes = true;
  }
});



function editandoOrdenes() {

  $('#guardarEdicionOrden').click(function () {



    let id = $('#editar-orden-id').val();
    let resumen = $('#editar-resumen').val();
    let justificacion = $('#editar-justificacion').val();



    let json = {
      ordenes: {
        id: id,
        resumen: resumen,
        justificacion: justificacion,

      }
    };
    console.log(json);

    peticionJWT({
      // la URL para la petición
      url: urlServidor + 'ordenes/editarOrdenesImagenes',
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
            title: "Actualizar Ordenes",
            text: response.mensaje,
            icon: 'success'
          })
          $('#modalEditarOrdenesImagenes').modal('hide');
          dt_listarordenesimagenes2();

        } else {

          Swal.fire({
            title: "Actualizar Ordenes",
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


function eliminar_ordenimagenes(id) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: "Este medicamento será anulado de la receta.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado_ordenes(id);
    }
  });
}



function cambiar_estado_ordenes(id) {
  peticionJWT({
    url: urlServidor + 'ordenes/cancelarordeneseditar/' + id, // Asegúrate de cambiar la ruta
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

        Swal.fire({
          title: "Receta",
          text: 'Se ha eliminado la orden de estudio',
          icon: 'success'
        })

        dt_listarordenesimagenes2();

      }
    },
    error: function (jqXHR, status, error) {
      console.log('Disculpe, existió un problema');
    }
  });
}


let iniciarGuardarNuevaOrdenImg = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_4' && !iniciarGuardarNuevaOrdenImg) {
    guardarNuevoOrdenEdicion();
    iniciarGuardarNuevaOrdenImg = true;
  }
});


function guardarNuevoOrdenEdicion() {
  $('#btn-guardar-orden').click(function () {

    let tipo_estudio_id = $('#nuevo-imagen option:selected').val();
    let citas_id = localStorage.getItem('citas_id');
    let doctor_id = JSON.parse(localStorage.getItem('sesion-2'));
    console.log(doctor_id);

    if (tipo_estudio_id == "0") {
      Swal.fire({
        title: "Ordenes",
        text: 'Seleccione un tipo de estudio',
        icon: 'error'
      })
    } else {


      let tipo_estudio_id = $('#nuevo-imagen option:selected').val();
      let resumen = $('#resumen').val();
      let justificacion = $('#justificacion').val();
      let numero_orden = $('#nuevo-orden').val();

      let json = {
        ordenes: {

          citas_id: parseInt(citas_id),
          doctor_id: parseInt(doctor_id),
          tipo_estudio_id: parseInt(tipo_estudio_id),
          resumen: resumen,
          justificacion: justificacion,
          numero_orden: numero_orden,

        }

      };

      if (!validarordenesedicion(json)) {

        console.log("llene los campos de datos de persona");
      } else {
        //Realizar peticion ajax
        console.log(json);
        guardandoedicionordenes(json);

      }

    }
  });
}

function validarordenesedicion(json) {
  let ordenes = json.ordenes;

  if (ordenes.tipo_estudio_id.length == 0) {
    Swal.fire({
      title: "Tipo de estudio ",
      text: 'Seleccione un tipo de diagnostico',
      icon: 'error'
    })

  } else
    if (ordenes.justificacion.length == 0) {
      Swal.fire({
        title: "Tipo de estudio",
        text: 'Ingrese una justificacion',
        icon: 'error'
      })
    } else
      if (ordenes.resumen.length == 0) {
        Swal.fire({
          title: "Tipo de estudio",
          text: 'Ingrese el resumen',
          icon: 'error'
        })

      } else {
        return true;
      }



}

function guardandoedicionordenes(json) {

  peticionJWT({
    url: urlServidor + 'ordenes/guardarOrdenEdicion',
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
          title: "Orden Agregada Exitosamente",
          text: response.mensaje,
          icon: 'success'
        })
        guardarCodigoImg();
        dt_listarordenesimagenes2();



        // $('#nuevo-producto')[0].reset();

      } else {


        Swal.fire({
          title: "Edicion de Ordenes",
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

/**FIN DE EDITAR ORDEN LABORARTORIO */













/**INICIO EDITAR ORDEN LABORATORIO */



function datatableLaboratorioeditar2() {

  let citas_id = localStorage.getItem('citas_id');


  tabla_recetas = $('#orden-lab-tabla').DataTable({
    "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "ajax":
    {
      url: urlServidor + 'laboratorio/datatableLaboratorioeditar/' + citas_id,
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



let iniciarTipoExamenSelectLabs = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_9' && !iniciarTipoExamenSelectLabs) {
    selectTipoExamenLaboratorio();
    iniciarTipoExamenSelectLabs = true;
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


function cargarNumerodeOrdenLabs() {

  let id = localStorage.getItem('citas_id');

  peticionJWT({
    url: urlServidor + 'laboratorio/listar_encabezadolabs/' + id,
    type: 'GET',
    headers: { "Authorization": `Bearer ${token}` },
    dataType: 'json',
    success: function (response) {
      //   console.log(response);

      if (response.status) {
        if (response.labs && response.labs.length > 0) {
          let ultimoLabs = response.labs[response.labs.length - 1];
          $('#nuevo-orden-laboratorio').val(ultimoLabs.numero_orden_lab ?? "");
          $('#id-labs').val(ultimoLabs.id ?? "");
        } else {
          console.warn("No hay datos de laboratorio disponibles");
        }
      }
      /*     if (response.status) {
            // Verificamos que `response.labs` tenga datos
            if (response.labs && response.labs.length > 0) {
              // Asignamos los valores si existen, de lo contrario, dejamos los campos vacíos
              $('#nuevo-orden-laboratorio').val(response.labs[0].numero_orden_lab ?? "");
              $('#id-labs').val(response.labs[0].id ?? "");
            } else {
              console.warn("No hay datos de laboratorio disponibles");
            }
          } */

    },
    error: function (jqXHR, status, error) {
      console.log('Disculpe, existió un problema');
    },
    complete: function (jqXHR, status) {
      // console.log('Petición realizada');
    }
  });

}


let iniciarGuardarEdit = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_9' && !iniciarGuardarEdit) {
    guardarNuevoLabsEdicion();
    iniciarGuardarEdit = true;
  }
});



function guardarNuevoLabsEdicion() {
  $('#btn-agregar-orden-laboratorio').click(function () {

    let tipo_examen_id = $('#nuevo-laboratorio option:selected').val();



    if (tipo_examen_id == "0") {
      Swal.fire({
        title: "Ordenes",
        text: 'Seleccione un tipo de estudio',
        icon: 'error'
      })
    } else {


      let tipo_examen_id = $('#nuevo-laboratorio option:selected').val();
      let resumen_lab = $('#resumen-laboratorio').val();
      let justificacion_lab = $('#justificacion-laboratorio').val();
      let laboratorio_id = $('#id-labs').val();

      let json = {
        labs_detalle: {

          laboratorio_id: parseInt(laboratorio_id),
          tipo_examen_id: parseInt(tipo_examen_id),
          resumen_lab: resumen_lab,
          justificacion_lab: justificacion_lab,


        }

      };

      if (!validarlabsedicion(json)) {

        console.log("llene los campos de datos de persona");
      } else {
        //Realizar peticion ajax
        console.log(json);
        guardandoedicionlabs(json);

      }

    }
  });
}

function validarlabsedicion(json) {
  let labs_detalle = json.labs_detalle;

  if (labs_detalle.tipo_examen_id.length == 0) {
    Swal.fire({
      title: "Tipo de estudio ",
      text: 'Seleccione un tipo de diagnostico',
      icon: 'error'
    })

  } else
    if (labs_detalle.justificacion_lab.length == 0) {
      Swal.fire({
        title: "Tipo de estudio",
        text: 'Ingrese una justificacion',
        icon: 'error'
      })
    } else
      if (labs_detalle.resumen_lab.length == 0) {
        Swal.fire({
          title: "Tipo de estudio",
          text: 'Ingrese el resumen',
          icon: 'error'
        })

      } else {
        return true;
      }



}

function guardandoedicionlabs(json) {

  peticionJWT({
    url: urlServidor + 'laboratorio/guardar_agregarLabsEdicion',
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
          title: "Orden Agregada Exitosamente",
          text: response.mensaje,
          icon: 'success'
        })
        datatableLaboratorioeditar2();




        // $('#nuevo-producto')[0].reset();

      } else {


        Swal.fire({
          title: "Edicion de Ordenes",
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


/**FIN ORDEN LABORATORIO  */


/********************************************************************************************************************************************** */
let iniciarDTLABSeditar = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_9' && !iniciarDTLABSeditar) {
    datatableLaboratorioeditar();
    iniciarDTLABSeditar = true;
  }
});


function datatableLaboratorioeditar() {
  let citas_id = localStorage.getItem('citas_id');

  peticionJWT({
    url: urlServidor + 'laboratorio/datatableLaboratorioeditar/' + citas_id,
    type: "GET",
    dataType: "json",
    beforeSend: function (xhr) {
      let token = localStorage.getItem('token');
      if (token) {
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
      }
    },
    success: function (response) {
      if (!response.aaData || response.aaData.length === 0) {
        // No hay órdenes -> Mostrar mensaje y botón del modal
        $('#nuevo-laboratorio').closest('.col-md-4').hide();
        $('#nuevo-orden-laboratorio').closest('.col-md-2').hide();
        $('#justificacion-laboratorio').closest('.col-md-2').hide();
        $('#resumen-laboratorio').closest('.col-md-2').hide();
        $('#btn-agregar-orden-laboratorio').closest('.col-md-1').hide();
        $('#orden-lab-tabla').hide();

        $('#mensaje-no-orden').html(
          '<div class="alert alert-warning">No hay órdenes registradas. Puede generar una nueva.</div>'
        ).show();

        // Mostrar el botón "Crear Nueva Orden"
        $('#crear-orden-btn').show();  // Mostrar el botón aquí

        // Mostrar el botón del modal
        $('#btn-abrir-modal').show();
      } else {
        // Hay órdenes -> Mostrar inputs, botón "AGREGAR" y tabla
        $('#nuevo-laboratorio').closest('.col-md-4').show();
        $('#nuevo-orden-laboratorio').closest('.col-md-2').show();
        $('#justificacion-laboratorio').closest('.col-md-2').show();
        $('#resumen-laboratorio').closest('.col-md-2').show();
        $('#btn-agregar-orden-laboratorio').closest('.col-md-1').show();
        $('#orden-lab-tabla').show();

        $('#mensaje-no-orden').hide();

        // Ocultar el botón "Crear Nueva Orden" cuando haya órdenes
        $('#crear-orden-btn').hide();  // Ocultar el botón aquí

        // Ocultar el botón del modal
        $('#btn-abrir-modal').hide();
      }

      // Actualizar número de orden y paciente en la UI
      $('#numero_orden_lab').text(response.encabezado.numero_orden);
      $('#nombre_paciente_lab').text(response.encabezado.paciente);

      // Destruir DataTable si ya está inicializado
      if ($.fn.DataTable.isDataTable('#orden-lab-tabla')) {
        $('#orden-lab-tabla').DataTable().destroy();
      }

      // Inicializar DataTable con los datos de la API
      $('#orden-lab-tabla').DataTable({
        "lengthMenu": [5, 10, 25, 75, 100],
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "destroy": true,
        "data": response.aaData,
        "columns": [
          { "title": "Examen", "data": 0 },
          { "title": "Justificación", "data": 1 },
          { "title": "Resumen", "data": 2 },
          { "title": "Editar", "data": 3 },
          { "title": "Eliminar", "data": 4 }
        ],
        "language": {
          "sProcessing": "Procesando...",
          "sLengthMenu": "Mostrar _MENU_ registros",
          "sZeroRecords": "No se encontraron resultados",
          "sEmptyTable": "Ningún dato disponible en esta tabla",
          "sInfo": "Mostrando _TOTAL_ registros",
          "sInfoEmpty": "Mostrando 0 registros",
          "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
          "sSearch": "Buscar:",
          "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
          }
        }
      });
    },
    error: function (e) {
      console.log(e.responseText);
    }
  });
}

function datatableLaboratorioeditar22() {
  let citas_id = localStorage.getItem('citas_id');

  peticionJWT({
    url: urlServidor + 'laboratorio/datatableLaboratorioeditar/' + citas_id,
    type: "GET",
    dataType: "json",
    beforeSend: function (xhr) {
      let token = localStorage.getItem('token');
      if (token) {
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
      }
    },
    success: function (response) {
      if (!response.aaData || response.aaData.length === 0) {
        // No hay órdenes -> Mostrar mensaje y botón del modal
        $('#nuevo-laboratorio').closest('.col-md-4').hide();
        $('#nuevo-orden-laboratorio').closest('.col-md-2').hide();
        $('#justificacion-laboratorio').closest('.col-md-2').hide();
        $('#resumen-laboratorio').closest('.col-md-2').hide();
        $('#btn-agregar-orden-laboratorio').closest('.col-md-1').hide();
        $('#orden-lab-tabla').hide();

        $('#mensaje-no-orden').html(
          '<div class="alert alert-warning">No hay órdenes registradas. Puede generar una nueva.</div>'
        ).show();

        // Mostrar el botón "Crear Nueva Orden"
        $('#crear-orden-btn').show();  // Mostrar el botón aquí

        // Mostrar el botón del modal
        $('#btn-abrir-modal').show();
      } else {
        // Hay órdenes -> Mostrar inputs, botón "AGREGAR" y tabla
        $('#nuevo-laboratorio').closest('.col-md-4').show();
        $('#nuevo-orden-laboratorio').closest('.col-md-2').show();
        $('#justificacion-laboratorio').closest('.col-md-2').show();
        $('#resumen-laboratorio').closest('.col-md-2').show();
        $('#btn-agregar-orden-laboratorio').closest('.col-md-1').show();
        $('#orden-lab-tabla').show();

        $('#mensaje-no-orden').hide();

        // Ocultar el botón "Crear Nueva Orden" cuando haya órdenes
        $('#crear-orden-btn').hide();  // Ocultar el botón aquí

        // Ocultar el botón del modal
        $('#btn-abrir-modal').hide();
      }

      // Actualizar número de orden y paciente en la UI
      $('#numero_orden_lab').text(response.encabezado.numero_orden);
      $('#nombre_paciente_lab').text(response.encabezado.paciente);

      // Destruir DataTable si ya está inicializado
      if ($.fn.DataTable.isDataTable('#orden-lab-tabla')) {
        $('#orden-lab-tabla').DataTable().destroy();
      }

      // Inicializar DataTable con los datos de la API
      $('#orden-lab-tabla').DataTable({
        "lengthMenu": [5, 10, 25, 75, 100],
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "destroy": true,
        "data": response.aaData,
        "columns": [
          { "title": "Examen", "data": 0 },
          { "title": "Justificación", "data": 1 },
          { "title": "Resumen", "data": 2 },
          { "title": "Editar", "data": 3 },
          { "title": "Eliminar", "data": 4 }
        ],
        "language": {
          "sProcessing": "Procesando...",
          "sLengthMenu": "Mostrar _MENU_ registros",
          "sZeroRecords": "No se encontraron resultados",
          "sEmptyTable": "Ningún dato disponible en esta tabla",
          "sInfo": "Mostrando _TOTAL_ registros",
          "sInfoEmpty": "Mostrando 0 registros",
          "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
          "sSearch": "Buscar:",
          "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
          }
        }
      });
    },
    error: function (e) {
      console.log(e.responseText);
    }
  });
}

$('#crear-orden-btn').click(function () {
  // Mostrar el modal
  $('#modalEditarOrdenesNewLabs').modal('show');
});




/**aqui va el agregar y guardar orden nueva si no tiene una orden esa cita  */


/**INICIO  DE ORDENES LABORATORIO EXAMENES */


let iniciarSelectNewLabsss = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_9' && !iniciarSelectNewLabsss) {
    selectTipoExamenLaboratorioNew();
    iniciarSelectNewLabsss = true;
  }
});


function selectTipoExamenLaboratorioNew() {

  peticionJWT({
    url: urlServidor + "tipo_examen/listar_tipoexamenAnterior",
    type: "GET",
    dataType: "json",
    beforeSend: function (xhr) {
      let token = localStorage.getItem('token');
      if (token) {
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
      }
    },
    success: function (response) {
      console.log(response);

      if (response.status) {
        // Limpiar el select antes de cargar nuevos datos
        $('#new-laboratorio-modal').empty();

        // Agregar la opción por defecto
        $('#new-laboratorio-modal').append('<option value="0">Seleccione Tipo de Laboratorio</option>');

        let data = response.tipo_examen.map(element => ({
          id: element.id,
          text: element.codigo_lab + " - " + element.descripcion_lab, // Se agregó espacio para mejor visualización
        }));

        // Inicializar Select2 con la opción por defecto incluida
        $('#new-laboratorio-modal').select2({
          data: data,
          width: '100%', // Evita que se encoja
          dropdownParent: $('#modalEditarOrdenesNewLabs') // Evita bloqueo en modal
        });
      }
    },
    error: function (jqXHR, status, error) {
      console.log("Disculpe, existió un problema");
    },
  });
}

/* // Llamar la función cuando el modal se muestra
$('#modalEditarOrdenesNewLabs').on('shown.bs.modal', function () {
  selectTipoExamenLaboratorioNew();
});
 */



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
      //         console.log(response);
      if (response.estado) {
        $('#nuevo-num-new-laboratorio').val(response.numero_labs);
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
  let num_labs = $('#nuevo-num-new-laboratorio').val();

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



let iniciarAggOrdenLabss = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_9' && !iniciarAggOrdenLabss) {
    agregarOrden_laboratorio_editar();
    iniciarAggOrdenLabss = true;
  }
});

function agregarOrden_laboratorio_editar() {


  $("#agg-orden-labs-new").click(function () {


    //  alert('hola');
    let tipo_examen_id = $("#new-laboratorio-modal option:selected").val();


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
            let justificacion_lab = $('#new-editar-justificacion').val();
            let resumen_lab = $('#new-editar-resumen').val();


            let cantidad = $('#cantidad2').val();
            let stock = $('#cantidad2').val();
            let precio_venta = $('#cantidad2').val();
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
                    validar5(json);
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

function validar5(json) {
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

  const tbody = document.getElementById('orden-cli-e-new');
  tbody.innerHTML = '';

  if (detalle_orden_laboratorio === undefined) {
    detalle_orden_laboratorio = [];
  } else {
    detalle_orden_laboratorio.forEach(e => {
      const tr = document.createElement('tr');
      tr.classList.add('itemNew');

      containerChelas = `
      
      <td>${e.nombre_examen}</td>
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
  // actualizarDatos();

}

function limpiarCampos4() {
  let option5 = '<option value=0>Seleccione Imagen</option>';
  $('#nuevo-laboratorio').html(option5);
  $('#justificacion-laboratorio').val('');
  $('#resumen-laboratorio').val('');


}
/** FIN DE ORDENES LABORATORIO EXAMENES */


let iniciarGuardarNuevaOrdenLabs = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_9' && !iniciarGuardarNuevaOrdenLabs) {
    guardarNuevaOrdenLabs();
    iniciarGuardarNuevaOrdenLabs = true;
  }
});
function guardarNuevaOrdenLabs() {
  $('#guardarEdicionOrdenNew').click(function () {

    let doctor_id = JSON.parse(localStorage.getItem('sesion-2'));
    //  console.log(doctor_id);

    let citas_id = $('#citas-id').val();
    //lab 
    let paciente_id = $('#paciente-id').val();
    let numero_orden_lab = $('#nuevo-num-new-laboratorio').val();








    let body4 = $('#orden-cli-e-new tr')
    let array6 = [];




    if (body4.length > 0) {
      for (let j = 0; j < body4.length; j++) {
        let td = body4[j].children;
        console.log(td);
        //   let numero_orden_lab = td[1].innerText;
        let justificacion_lab = td[1].innerText;
        let resumen_lab = td[2].innerText;
        let tipo_examen_id = td[4].innerText;


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









    let json = {
      laboratorio: {
        citas_id,
        paciente_id,
        numero_orden_lab,
        doctor_id,

      },

      orden_lab: array6
    }



    //  if(!validar_registroatencion(json)){
    //  console.log("faltan datos");

    //   }else{

    console.log(json);
    //  ajaxGuardandohistorial(json);
    if (array6.length > 0) {
      guardarCodigo_laboratorio();

      ajaxGuardandolaboratorio(json);
    }
    //  }


  });
}





function ajaxGuardandolaboratorio(json) {
  peticionJWT({
    url: urlServidor + 'laboratorio/guardarOrden',
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
        /*   guardarCodigo();*/
        //   guardarCodigo_laboratorio(); 
        //   location.href = urlCliente + 'inicio/citas';
        /*   reset_datos();
          guardarCodigo(); */
        cargarNumerodeOrdenLabs();
        datatableLaboratorioeditar();
        $('#modalEditarOrdenesNewLabs').modal('hide');

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





function eliminar_laboratorio(id) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: "Este items de laboratorio será anulado de la orden.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado_ordenesLabs(id);
    }
  });
}



function cambiar_estado_ordenesLabs(id) {
  peticionJWT({
    url: urlServidor + 'laboratorio/eliminarItemLabs/' + id, // Asegúrate de cambiar la ruta
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

        Swal.fire({
          title: "Labotatorio",
          text: 'Se ha eliminado el items de la orden de laboratorio',
          icon: 'success'
        })

        datatableLaboratorioeditar22();

      }
    },
    error: function (jqXHR, status, error) {
      console.log('Disculpe, existió un problema');
    }
  });
}




/**fin nueva orden generada */



/***AQUI VIENE EL NUEVO RECETA CON CODIGO  PARA LA EDICION SI NO HAY RECETA SE CREA UNA NUEVA CON CODIGO */
/****************************************************************************************************************************************** */
/***************************************NUEVO RECETA */
/****************************************************************************************************************************************** */


/* function cargarNumerodeRecetaEdi() {

  let id = localStorage.getItem('citas_id');

  peticionJWT({
    url: urlServidor + 'receta/listar_encabezadoreceta/' + id,
    type: 'GET',
    headers: { "Authorization": `Bearer ${token}` },
    dataType: 'json',
    success: function (response) {
      //   console.log(response);
      if (response.status) {
        // Verificamos que `response.labs` tenga datos
        if (response.rece && response.rece.length > 0) {
          // Asignamos los valores si existen, de lo contrario, dejamos los campos vacíos
          $('#nuevo-num-receta1111').val(response.rece[0].numero_receta ?? "");
          $('#id-rece').val(response.rece[0].id ?? "");
        } else {
          console.warn("No hay datos de receta disponibles");
        }
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
 */

function cargarNumerodeRecetaEdi() {
  let id = localStorage.getItem('citas_id');

  peticionJWT({
    url: urlServidor + 'receta/listar_encabezadoreceta/' + id,
    type: 'GET',
    headers: { "Authorization": `Bearer ${token}` },
    dataType: 'json',
    success: function (response) {
      if (response.status) {
        if (response.rece && response.rece.length > 0) {
          // Tomar el último registro
          let ultimaReceta = response.rece[response.rece.length - 1];
          $('#nuevo-num-receta1111').val(ultimaReceta.numero_receta ?? "");
          $('#id-rece').val(ultimaReceta.id ?? "");
        } else {
          console.warn("No hay datos de receta disponibles");
        }
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



let iniciarDtRecetaeditar = false;


$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !iniciarDtRecetaeditar) {
    datatable_receta_editar();
    iniciarDtRecetaeditar = true;
  }
});


function datatable_receta_editar() {
  let citas_id = localStorage.getItem('citas_id');

  peticionJWT({
    url: urlServidor + 'receta/datatable_receta_editar/' + citas_id,
    type: "GET",
    dataType: "json",
    beforeSend: function (xhr) {
      let token = localStorage.getItem('token');
      if (token) {
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
      }
    },
    success: function (response) {
      const hayRecetas = response.aaData && response.aaData.length > 0;

      if (!hayRecetas) {
        // Oculta los inputs
        $('#contenedor-receta-inputs').hide();

        // Muestra mensaje de advertencia
        $('#mensaje-no-receta').html(
          '<div class="alert alert-warning">No hay recetas registradas. Puede generar una nueva.</div>'
        ).show();

        // Muestra el botón "Crear receta"
        $('#crear-receta-btn').show();

        // Oculta la tabla
        $('#tabla-recetas').hide();
      } else {
        // Muestra inputs
        $('#contenedor-receta-inputs').show();

        // Oculta mensaje y botón
        $('#mensaje-no-receta').hide();
        $('#crear-receta-btn').hide();

        // Muestra tabla
        $('#tabla-recetas').show();
      }

      // Actualizar número de orden y paciente en la UI
      $('#nuevo-num-new-receta').text(response.encabezado2.numero_orden);
      $('#nombre_paciente_lab').text(response.encabezado2.paciente);




      // Inicializa DataTable...
      if ($.fn.DataTable.isDataTable('#tabla-recetas')) {
        $('#tabla-recetas').DataTable().destroy();
      }

      $('#tabla-recetas').DataTable({
        data: response.aaData,
        columns: [
          { title: "Cantidad", data: 0 },
          { title: "Producto", data: 1 },
          { title: "Dosis", data: 2 },
          { title: "Frecuencia", data: 3 },
          { title: "Via", data: 4 },
          { title: "Duración", data: 5 },
          { title: "Observación", data: 6 },
          { title: "Editar", data: 7 },
          { title: "Eliminar", data: 8 }
        ],
        language: {
          sProcessing: "Procesando...",
          sLengthMenu: "Mostrar _MENU_ registros",
          sZeroRecords: "No se encontraron resultados",
          sEmptyTable: "Ningún dato disponible en esta tabla",
          sInfo: "Mostrando _TOTAL_ registros",
          sInfoEmpty: "Mostrando 0 registros",
          sInfoFiltered: "(filtrado de _MAX_ registros)",
          sSearch: "Buscar:",
          oPaginate: {
            sFirst: "Primero",
            sLast: "Último",
            sNext: "Siguiente",
            sPrevious: "Anterior"
          }
        }
      });
    },

    error: function (e) {
      console.log(e.responseText);
    }
  });
}



function eliminarreceta(id) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: "Este medicamento será anulado de la receta.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estadoreceta(id);
    }
  });
}



function cambiar_estadoreceta(id) {
  peticionJWT({
    url: urlServidor + 'citas/cancelar/' + id, // Asegúrate de cambiar la ruta
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

        Swal.fire({
          title: "Receta",
          text: 'Se ha eliminado el medicamento de la receta',
          icon: 'success'
        })


        datatable_receta_editar();
      }
    },
    error: function (jqXHR, status, error) {
      console.log('Disculpe, existió un problema');
    }
  });
}




function datatableRecetaeditar22() {
  let citas_id = localStorage.getItem('citas_id');

  peticionJWT({
    url: urlServidor + 'receta/datatable_receta_editar/' + citas_id,
    type: "GET",
    dataType: "json",
    beforeSend: function (xhr) {
      let token = localStorage.getItem('token');
      if (token) {
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
      }
    },
    success: function (response) {
      if (!response.aaData || response.aaData.length === 0) {
        // No hay órdenes -> Mostrar mensaje y botón del modal
        $('#nuevo-medicamento').closest('.col-md-4').hide();
        $('#nuevo-num-receta').closest('.col-md-2').hide();
        /*     $('#justificacion-laboratorio').closest('.col-md-2').hide();
            $('#resumen-laboratorio').closest('.col-md-2').hide(); */
        $('#btn-guardar-nuevo-receta').closest('.col-md-1').hide();
        $('#tabla-recetas').hide();

        $('#mensaje-no-receta').html(
          '<div class="alert alert-warning">No hay recetas registradas. Puede generar una nueva.</div>'
        ).show();

        // Mostrar el botón "Crear Nueva Orden"
        $('#crear-receta-btn').show();  // Mostrar el botón aquí

        // Mostrar el botón del modal
        $('#btn-abrir-modal-receta').show();
      } else {
        // Hay órdenes -> Mostrar inputs, botón "AGREGAR" y tabla
        $('#nuevo-medicamento').closest('.col-md-4').show();
        $('#nuevo-num-receta').closest('.col-md-2').show();
        /*      $('#justificacion-laboratorio').closest('.col-md-2').show();
             $('#resumen-laboratorio').closest('.col-md-2').show(); */
        $('#btn-guardar-nuevo-receta').closest('.col-md-1').show();
        $('#tabla-recetas').show();

        $('#mensaje-no-receta').hide();

        // Ocultar el botón "Crear Nueva Orden" cuando haya órdenes
        $('#crear-receta-btn').hide();  // Ocultar el botón aquí

        // Ocultar el botón del modal
        $('#btn-abrir-modal-receta').hide();
      }

      // Actualizar número de orden y paciente en la UI
      /*       $('#numero_orden_lab').text(response.encabezado.numero_orden);
            $('#nombre_paciente_lab').text(response.encabezado.paciente); */

      // Destruir DataTable si ya está inicializado
      if ($.fn.DataTable.isDataTable('#tabla-recetas')) {
        $('#tabla-recetas').DataTable().destroy();
      }

      // Inicializar DataTable con los datos de la API
      $('#tabla-recetas').DataTable({
        "lengthMenu": [5, 10, 25, 75, 100],
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "destroy": true,
        "data": response.aaData,
        "columns": [
          { "title": "Cantidad", "data": 0 },
          { "title": "Producto", "data": 1 },
          { "title": "Dosis", "data": 2 },
          { "title": "Frecuenca", "data": 3 },
          { "title": "Via", "data": 4 },
          { "title": "Duracion", "data": 5 },
          { "title": "Observacion", "data": 6 },
          { "title": "Editar", "data": 7 },
          { "title": "Eliminar", "data": 8 }
        ],
        "language": {
          "sProcessing": "Procesando...",
          "sLengthMenu": "Mostrar _MENU_ registros",
          "sZeroRecords": "No se encontraron resultados",
          "sEmptyTable": "Ningún dato disponible en esta tabla",
          "sInfo": "Mostrando _TOTAL_ registros",
          "sInfoEmpty": "Mostrando 0 registros",
          "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
          "sSearch": "Buscar:",
          "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
          }
        }
      });
    },
    error: function (e) {
      console.log(e.responseText);
    }
  });
}

$('#crear-receta-btn').click(function () {
  // Mostrar el modal
  $('#modalEditarNewReceta').modal('show');
});




let NewInicarDosis = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !NewInicarDosis) {
    NewcargarDosis();
    NewInicarDosis = true;
  }
});

function NewcargarDosis() {
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
        $('#new-dosis-modal').html(option);
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

let NewIniciarFrecuencia = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !NewIniciarFrecuencia) {
    NewcargarFrecuencia();
    NewIniciarFrecuencia = true;
  }
});
function NewcargarFrecuencia() {
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
        $('#new-frecuencia-modal').html(option);
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

let MewiniciarSelectMedicamento = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !MewiniciarSelectMedicamento) {
    NewselectMedicamento();
    MewiniciarSelectMedicamento = true;
  }
});
function NewselectMedicamento() {
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

        $('#new-medicamento-modal').select2({
          data: data,
          dropdownParent: $('#modalEditarNewReceta'), // ID corregido  
          width: '100%',
          allowClear: true,
          placeholder: "Seleccione el medicamento",
          minimumResultsForSearch: 0

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



let NewiniciarSelectVia = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !NewiniciarSelectVia) {
    NewselectVia();
    NewiniciarSelectVia = true;
  }
});
function NewselectVia() {
  peticionJWT({
    // la URL para la petición
    url: urlServidor + "via/listar",
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
        let data = response.via.map(element => ({
          id: element.id,
          text: element.tipo_via
        }));

        $('#new-via-modal').select2({
          data: data,
          dropdownParent: $('#modalEditarNewReceta'), // ID corregido  
          width: '100%',
          allowClear: true,
          placeholder: "Seleccione la via ",
          minimumResultsForSearch: 0
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








let IniciarAgregarMedicamentoRecetaNew = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !IniciarAgregarMedicamentoRecetaNew) {
    NewRecetaagregarProductos();
    IniciarAgregarMedicamentoRecetaNew = true;
  }
});


function NewRecetaagregarProductos() {
  $('#agg-orden-labs-new-receta').click(function () {

    let producto_id = $('#new-medicamento-modal option:selected').val();

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
          console.log(response);
          if (response.status) {


            let nombre_producto = $('#new-medicamento-modal option:selected').text();
            let cantidad = $('#new-editar-cantidad').val();
            let dosis_id = $('#new-dosis-modal option:selected').val();
            let dosis = $('#new-dosis-modal option:selected').text();
            let frecuencia_id = $('#new-frecuencia-modal option:selected').val();
            let frecuencia = $('#new-frecuencia-modal option:selected').text();
            let via_id = $('#new-via-modal option:selected').val();
            let via = $('#new-via-modal option:selected').text();
            let duracion = $('#new-duracion-resumen').val();
            let observacion = $('#new-observacion-resumen').val();
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
                  if (dosis_id.length == 0) {
                    Swal.fire({
                      title: "Receta",
                      text: 'Seleccione una dosis',
                      icon: 'error'
                    })

                  } else
                    if (via_id.length == 0) {
                      Swal.fire({
                        title: "Receta",
                        text: 'Seleccione una via',
                        icon: 'error'
                      })

                    } else
                      if (frecuencia_id.length == 0) {
                        Swal.fire({
                          title: "Receta",
                          text: 'Seleccione una frecuencia',
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
                          console.log(json);
                          validar6(json);
                          tabla_actualizar6();



                        }
            selectMedicamento2();
            cargarDosis2();
            cargarFrecuencia2();
            selectVia2();


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


function tabla_actualizar6() {

  const tbody = document.getElementById('receta-cli-e-new');
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


function validar6(json) {
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
  let tr = $('#receta-cli-e-new tr');
  console.log(tr);
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
        console.log(res);
        res.cantidad++;
        res.totalParcial = (res.cantidad * res.precio_venta).toFixed(2);
        console.log('aumentando');
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
      console.log('disminuyendo');
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
  let option = '<option value=0>Seleccione un Medicamento</option>';
  $('#new-medicamento-modal').html(option);
  let option2 = '<option value=0>Seleccione la dosis</option>';
  $('#new-dosis-modal').html(option2);
  let option3 = '<option value=0>Seleccione la frecuencia</option>';
  $('#new-frecuencia-modal').html(option3);
  let option4 = '<option value=0>Seleccione la via</option>';
  $('#new-via-modal').html(option4);


  $('#new-editar-cantidad').val('');
  $('#new-duracion-resumen').val('');
  $('#new-observacion-resumen').val('');


}

function selectMedicamento2() {
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

        $('#new-medicamento-modal').select2({
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




function cargarDosis2() {
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
      //  console.log(response);
      if (response.status) {
        let data = response.dosis.map(element => ({
          id: element.id,
          text: element.tipo_dosis
        }));

        $('#new-dosis-modal').select2({
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


function cargarFrecuencia2() {
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
        $('#new-frecuencia-modal').html(option);
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




function selectVia2() {
  peticionJWT({
    // la URL para la petición
    url: urlServidor + "via/listar",
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
        let data = response.via.map(element => ({
          id: element.id,
          text: element.tipo_via
        }));

        $('#new-via-modal').select2({
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

























let iniciarGuardarNuevarReceta = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_2' && !iniciarGuardarNuevarReceta) {
    guardarNuevaRecetaNew();
    iniciarGuardarNuevarReceta = true;
  }
});
function guardarNuevaRecetaNew() {
  $('#guardarEdicionOrdenNewReceta').click(function () {

    let paciente_id = JSON.parse(localStorage.getItem('paciente_id'));
    console.log(paciente_id);

    let citas_id = $('#citas-id').val();
    let numero_receta = $('#nuevo-num-new-receta').val();

    let body = $('#receta-cli-e-new tr')
    let array = [];


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




    let json = {
      receta: {
        citas_id,
        paciente_id,
        numero_receta,


      },

      orden_rece: array,


    }


    //  if(!validar_registroatencion(json)){
    //  console.log("faltan datos");

    //   }else{

    console.log(json);
    //  ajaxGuardandohistorial(json);
    if (array.length > 0) {
      guardarCodigo_receta();

      ajaxGuardandoRecetaNew(json);
    }

  });
}





function ajaxGuardandoRecetaNew(json) {
  peticionJWT({
    url: urlServidor + 'receta/guardarRecetaNew',
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
        /*   guardarCodigo();*/
        //   guardarCodigo_laboratorio(); 
        //   location.href = urlCliente + 'inicio/citas';
        /*   reset_datos();
          guardarCodigo(); */
        cargarNumerodeRecetaEdi();
        datatable_receta_editar();
        $('#modalEditarNewReceta').modal('hide');
        if ($.fn.DataTable.isDataTable('#receta-cli-e-new')) {
          $('#receta-cli-e-new').DataTable().clear().draw();  // Borra filas y refresca vista
        }


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
        $('#nuevo-num-new-receta').val(response.numeros_recetas);
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
  let num_receta = $('#nuevo-num-new-receta').val();

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
