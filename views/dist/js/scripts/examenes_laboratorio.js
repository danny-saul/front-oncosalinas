var tabla;
var detalle_diagnostico = [];


_init();
function _init() {
    dt_listarmedicoxid();
    editandoOrdenModal();
    cargarDiagnostico();
    agregarDiagnosticos1();
    editandoresultado();
}

function dt_listarmedicoxid() {
   
    let medico_id = JSON.parse(localStorage.getItem('sesion-2'));

    tabla = $('#tabla-pendientes').DataTable({
        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "ajax":
        {
            url: urlServidor + 'examenes_laboratorio/dttablelistarlaboratorio/' + medico_id ,
            type: "get",
            dataType: "json",
            beforeSend: function(xhr) {
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

function subir_pdf(id){
 
/*     localStorage.setItem('citas_id', id); 
    console.log(localStorage);
    location.href = urlCliente + 'gestion/atendercitas';  */
    $('#modal-editar-orden').modal('show');
    cargarOrden(id);



}


function cargarOrden(id) {
   // let token = JSON.parse(localStorage.getItem('token'));

    peticionJWT({
        url: urlServidor + 'laboratorio/listar/' + id,
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
            let tr2 = '';

            console.log(response);
            if (response.status) {
 
                $('#e-justificacion').val(response.lab.justificacion_lab);//usuario_id
                $('#e-resumen').val(response.lab.resumen_lab);//persona_id
                $('#e-orden-id').val(response.lab.id);//rol_id
                $('#e-citas-id').val(response.lab.citas.id);//nombre_usuario
                $('#e-doctor-id').val(response.lab.doctor.id);//correo_usuario
 
                $('#e-estadoorden').val(response.lab.estado_orden.id);
                $('#e-lateralidad').val(response.lab.lateralidad_id);

                $('#fecha-lab').text(response.lab.fecha_lab);
                $('#numorden-lab').text(response.lab.numero_orden_lab);
                 
                $('#estudio-imagenologo').text(response.lab.doctor.persona.nombre + ' ' + response.lab.doctor.persona.apellido );
                $('#estudio-doctor').text(response.lab.doctor.persona.nombre + ' ' + response.lab.doctor.persona.apellido );
                $('#estudio-paciente').text(response.lab.citas.paciente.persona.nombre + ' ' + response.lab.citas.paciente.persona.apellido );

     

                response.lab.laboratorio_detalle.forEach((element, i) => {
                    tr2 += `<tr>
                                <td style="color: black; display:none;">${i+1}</td>
                                <td style="color: black;">${element.tipo_examen.codigo_lab}</td>
                                <td style="color: black;">${element.tipo_examen.descripcion_lab}</td>
                                <td style="color: black;">${element.resultado_examen}</td>
                                <td style="color: black;">
                                    <button class="btn btn-sm btn-outline-success" onclick="editarItems(${element.id})">
                                        <i class="fas fa-clipboard-list"></i> Ingresar Resultado
                                    </button>
                                </td>
                            </tr>`;
                });
                
                $('#orden-labs-cli').html(tr2);
                
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



function editarItems(id){
    $('#modalEditarItemsLabs').modal('show');
    cargarItems(id)
}

function cargarItems(id){
     // alert(id);

      peticionJWT({
        url: urlServidor + 'laboratorio/detallexId/' + id,
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
         

            console.log(response);
            if (response.status) {
 
                $('#editar-tipo-examen').val(response.detalle.tipo_examen.codigo_lab + ' '+ response.detalle.tipo_examen.descripcion_lab);// 
                $('#editar-resultado').val(response.detalle.resultado_examen ?? "");//  
                $('#editar-items-id').val(response.detalle.id);// 
               
                
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
 
    

    function editandoresultado(){
        $('#guardarEdicionOrdenItemsLabs').click(function () {

            let id = $('#editar-items-id').val(); 
            let resultado_examen = $('#editar-resultado').val();
            
            let json = {
                labs_det: {
                    id: id,
                    resultado_examen: resultado_examen,
               
                   
                 
                },
             
    
            };
    
            console.log(json);
    
            peticionJWT({
                // la URL para la petición
                url: urlServidor + 'laboratorio/guardarDetalleItems',
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
                    /*  console.log(response); */
                 
    
                    if (response.status) {
                        Swal.fire({
                            title:response.mensaje,
                            text: 'Laboratorio',
                            icon: 'success'
                        })
    
                      
                        $('#modalEditarItemsLabs').modal('hide');
                      
                    } else {
                        Swal.fire({
                            title:response.mensaje,
                            text: 'Laboratorio',
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
    
          
    
    
    
        });
    }



    


function editandoOrdenModal() {
    $('#btn-update').click(function () {

        let id = $('#e-orden-id').val(); 
   /*      let justificacion_lab = $('#e-justificacion').val();
        let resumen_lab = $('#e-resumen').val(); 
        let informe_lab = $('#e-informe').val();
        let conclusion_lab = $('#e-conclusion').val();  */
        let documento_lab = $('#img-estudio')[0].files[0];
        let def1 = (documento_lab == undefined) ? 'documento.pdf' : documento_lab.name; 
 
   /*      let array2 = [];
        let body2 = $('#tabla-diagnostico1 tr'); */
 
    /*     if (body2.length > 0) {
            for (let j = 0; j < body2.length; j++) {
              let td2 = body2[j].children;
              console.log(td2);
              let diagnosticocie10_id = td2[3].innerText;
      
    
              let object2 = {
                diagnosticocie10_id: diagnosticocie10_id,
        
              }
              array2.push(object2);
            }
           
          } */

        let json = {
            orden: {
                id: id,
               /*  justificacion_lab: justificacion_lab,
                resumen_lab: resumen_lab,
                informe_lab: informe_lab,
                conclusion_lab: conclusion_lab, */
                documento_lab: def1
               
             
            },
         

        };

        console.log(json);

        peticionJWT({
            // la URL para la petición
            url: urlServidor + 'laboratorio/editar',
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
                /*  console.log(response); */
             

                if (response.status) {
                    Swal.fire({
                        title:response.mensaje,
                        text: 'Laboratorio',
                        icon: 'success'
                    })

                  
                    $('#modal-editar-orden').modal('hide');
                    dt_listarmedicoxid2();
                } else {
                    Swal.fire({
                        title:response.mensaje,
                        text: 'Laboratorio',
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
                beforeSend: function(xhr) {
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
    peticionJWT({
        url: urlServidor + 'diagnostico/listar',
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

function agregarDiagnosticos1() {

    $("#btn-agregar-diagnosticos-definitivos").click(function() {
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
        beforeSend: function(xhr) {
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
            let stock =  1
            let precio_venta =  1
            let totalParcial = Number((parseInt(cantidad) * parseFloat(precio_venta)).toFixed(2));
            
            if(diagnosticocie10_id.length==0 ){
              Swal.fire({
                title: "Receta",
                text: 'Seleccione un Diagnostico',
                icon: 'error'
            })
       
                }else 
                if(cantidad.length==0 ){
                  Swal.fire({
                    title: "Receta",
                    text: 'Seleccione una Cantidad',
                    icon: 'error'
                })
                   
                }else 
                if(parseInt(cantidad) ==0 || parseInt(cantidad) < 0){
                  Swal.fire({
                    title: "Receta",
                    text: 'Ingrese un valor mayor a 0',
                    icon: 'error'
                })
               
      
                 } else 
                if(parseInt(cantidad) > stock){
                  Swal.fire({
                    title: "Receta",
                    text: 'Cantidad supera al stock',
                    icon: 'error'
                })
                  
                }else{
        
                  let json = {
                    diagnosticocie10_id: parseInt(diagnosticocie10_id),
                    cantidad: parseInt(cantidad),
                    nombre_diagnostico:nombre_diagnostico,
                 
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
  
  function dt_listarmedicoxid2() {
   
    let medico_id = JSON.parse(localStorage.getItem('sesion-2'));

    tabla = $('#tabla-pendientes').DataTable({
        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "ajax":
        {
            url: urlServidor + 'examenes_laboratorio/dttablelistarlaboratorio/' + medico_id ,
            type: "get",
            dataType: "json",
            beforeSend: function(xhr) {
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
