
var detalle_diagnostico = [];


_init();
function _init() {

    cargarOrden();
    editandoOrdenModal();
    cargarDiagnostico();
    agregarDiagnosticos1();
    cargarMedico();
}

 


    function cargarMedico(){
        let usuario = JSON.parse(localStorage.getItem('sesion'));
        let nombres = usuario.persona.nombre + ' ' + usuario.persona.apellido;
        $('#estudio-imagenologo').text(nombres);

          let medico_id = JSON.parse(localStorage.getItem('sesion-2'));
          console.log(medico_id);
    }


function cargarOrden() {
    let id = JSON.parse(localStorage.getItem('orden_id'));

    peticionJWT({
        url: urlServidor + 'ordenes/listarorden/' + id,
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
            console.log(response);
            if (response.status) {

                $('#e-justificacion').val(response.orden.justificacion);//usuario_id
                $('#e-resumen').val(response.orden.resumen);//persona_id
                $('#e-orden-id').val(response.orden.id);//rol_id
                $('#e-citas-id').val(response.orden.citas.id);//nombre_usuario
                $('#e-doctor-id').val(response.orden.citas.doctor.id);//correo_usuario
                $('#e-tipoestudio-id').val(response.orden.tipo_estudio.id);
                $('#e-estadoorden').val(response.orden.estado_orden.id);
                $('#e-lateralidad').val(response.orden.lateralidad_id);
                $('#estudio-imagen').text(response.orden.tipo_estudio.codigo + ' ' + response.orden.tipo_estudio.descripcion);
      /*           $('#estudio-imagenologo').text(response.orden.doctor.persona.nombre + ' ' + response.orden.doctor.persona.apellido); */
                $('#estudio-doctor').text(response.orden.citas.doctor.persona.nombre + ' ' + response.orden.citas.doctor.persona.apellido);


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


function editandoOrdenModal() {
    $('#btn-update').click(function () {

        let id = $('#e-orden-id').val();
        let doctor_id = JSON.parse(localStorage.getItem('sesion-2'));
        let justificacion = $('#e-justificacion').val();
        let resumen = $('#e-resumen').val();
        let informe = $('#e-informe').val();
        let conclusion = $('#e-conclusion').val();
        let documento = $('#img-estudio')[0].files[0];
        let def1 = (documento == undefined) ? 'documento.pdf' : documento.name;

        let array2 = [];
        let body2 = $('#tabla-diagnostico1 tr');

        if (body2.length > 0) {
            for (let j = 0; j < body2.length; j++) {
                let td2 = body2[j].children;
                console.log(td2);
                let diagnosticocie10_id = td2[3].innerText;


                let object2 = {
                    diagnosticocie10_id: diagnosticocie10_id,

                }
                array2.push(object2);
            }

        }

        let json = {
            orden: {
                id: id,
                doctor_id: doctor_id,
                justificacion: justificacion,
                resumen: resumen,
                informe: informe,
                conclusion: conclusion,
                documento: def1


            },
            ordenes_diagnosticos: array2,

        };

        console.log(json);

        peticionJWT({
            // la URL para la petición
            url: urlServidor + 'ordenes/editar',
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
                /*  console.log(response); */


                if (response.status) {
                    Swal.fire({
                        title: response.mensaje,
                        text: 'Imagenes',
                        icon: 'success'
                    })


                    $('#modal-editar-orden').modal('hide');
                    location.href = urlCliente + 'examenes/imagenes';

                } else {
                    Swal.fire({
                        title: response.mensaje,
                        text: 'Imagenes',
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

        if (json.orden.documento == 'documento.pdf') {

        } else {
            let documento = $('#img-estudio')[0].files[0];
            let formData = new FormData();
            formData.append('fichero', documento);

            peticionJWT({
                // la URL para la petición
                url: urlServidor + 'ordenes/subirestudio',
                // especifica si será una petición POST o GET
                type: 'POST',

                // el tipo de información que se espera de respuesta
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function (xhr) {
                    // Envía el token JWT en el encabezado Authorization
                    let token = localStorage.getItem('token');
                    if (token) {
                        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                    }
                },
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



    });




}


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

function agregarDiagnosticos1() {

    $("#btn-agregar-diagnosticos-definitivos").click(function () {
        //  alert('hola');
        let diagnosticocie10_id = $("#nuevo-diagnostico1 option:selected").val();
        //  let tipo_diagnostico_id = $('#tipo_diagnostico option:selected').val();

        if (diagnosticocie10_id == 0) {
            Swal.fire({
                title: "Receta",
                text: 'Seleccione un diagnostico',
                icon: 'error'
            });

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


                        let nombre_diagnostico = response.diagnosticos.clave + ' ' + response.diagnosticos.descripcion
                        let cantidad = 1
                        let stock = 1
                        let precio_venta = 1
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
        
        <td>${e.nombre_diagnostico}</td>
  
        <th>
          <div>
              <button class="btn btn-danger delete">
                  <i class="fas fa-trash"></i>
              </button>
          </div>
         </th>
         
      <th style="display:none;" class="id">${e.diagnosticocie10_id}</th>
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