_init();

function _init() {
    cargarDoctor();
    cargarPaciente();
    selectServicios();
    getHour();
    agregar_servicios();
    guardar_cita();
}

function cargarDoctor() {
    $.ajax({
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

                $('#cita-medico').select2({
                    data: data,
                   
                });
             //   $('#cita-hora').removeClass('d-none'); 
//                let doctor_id = $('#cita-medico option:selected').val();


         /*        let dias = $('#cita-fecha').val();
                let d = dias.substring(8, 10); //2022-01-15 date
                //let d = dias.substring(3, 5);  //01-15-2022 datepicker   
                //console.log(d);
        
                $.ajax({
                    url: urlServidor + 'doctor_horario/listarDoctorHorario/' + doctor_id + '/' + d,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        //console.log(response);
                        let option = ''; 
        
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                            "positionClass": "toast-top-center",
                        };
        
                        if (response.status) {  
                            let diasDisponibles = response.datos;
                        
                            if(diasDisponibles == null){
                                toastr["error"]('No hay horas disponibles', "Horario Doctor");                      
                            }else{
                                option = '<option value="0">Selecione hora</option>';
                                    diasDisponibles.forEach(element => {
                                    option += `<option value=${element.id}>${element.horario} </option>`;
                                });
                                toastr["success"]('Si hay horas disponibles', "Horario Doctor");   
                            } 
                        } else {
                            toastr["error"]('No hay datos', "Horario Doctor");
                        }
                        $('#new-hora-cita').html(option);
                        $('#new-hora-cita').prop('selectedIndex',0);
                    },
                    error: function (jqXHR, status, error) {
                        console.log('Disculpe, existió un problema');
                    },
                    complete: function (jqXHR, status) {
                        // console.log('Petición realizada');
                    }
                }); */
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

 function getHour(){
    const input = document.getElementById('cita-fecha');
    
    input.addEventListener('change', (event) => {
        const fecha = event.target.value;
      //  const doctor_id = document.getElementById('doctor-id').value;
        let doctor_id = $('#cita-medico option:selected').val();

        if(fecha && doctor_id){
            //Solicitud para traer las horas
            const url = urlServidor + `doctor_horario/get_horas/${fecha}/${doctor_id}`;
              // Crear objeto de opciones con encabezados
              const options = {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            };

            fetch(url, options)

            .then(res => {
                if (!res.ok) {
                    throw new Error('Solicitud fallida - ' + res.status);
                }
                return res.json();
            })

            .then(res => {
         //       console.log(res);
                
                if(res.status){
                    let li = '<option value="0">Seleccione una opcion</option>';
                    const select = document.getElementById('cita-hora');
                    res.horas.map(item => {
                        item.hora_inicio = item.hora_inicio.substring(0, 5);
                        item.hora_fin = item.hora_fin.substring(0, 5);
                        return item;
                    });

                    res.horas.forEach(item => {
                        li += `<option value="${ item.id }">${ item.hora_inicio } - ${ item.hora_fin }</option>`;
                    });

                    select.innerHTML = li;
                }
            })
            .catch(err => console.error('Error al obtener horas:', err));


            // console.log(fecha, doctor_id);
        }
    });
}
 

/*  function getHour(){
  const input = document.getElementById('cita-fecha');

  input.addEventListener('change', (event) => {
      const fecha = event.target.value;
      let doctor_id = $('#cita-medico option:selected').val();

      if(fecha && doctor_id){
          //Solicitud para traer las horas
          const url = urlServidor + `doctor_horario/get_horas/${fecha}/${doctor_id}`;
          fetch(url, {
              method: 'GET'
          })
          .then(res => res.json())
          .then(res => {
              if(res.status){
                  let li = '<option value="0">Seleccione una opción</option>';
                  const select = document.getElementById('cita-hora');
                  res.horas.map(item => {
                      item.hora_inicio = item.hora_inicio.substring(0, 5);
                      item.hora_fin = item.hora_fin.substring(0, 5);
                      return item;
                  });

                  res.horas.forEach(item => {
                      li += `<option value="${ item.id }">${ item.hora_inicio } - ${ item.hora_fin }</option>`;
                  });

                  select.innerHTML = li;
              }
          })
          .catch(err => console.log);
          
          // Resetear el campo de fecha si se cambia el valor del select
          $('#cita-fecha').val('');
    
      }
  });
}  */

/* function getHour(){
  const input = document.getElementById('cita-fecha');
  const selectMedico = document.getElementById('cita-medico');

  input.addEventListener('change', (event) => {
      const fecha = event.target.value;
      let doctor_id = $('#cita-medico option:selected').val();

      if(fecha && doctor_id){
          //Solicitud para traer las horas
          const url = urlServidor + `doctor_horario/get_horas/${fecha}/${doctor_id}`;
          fetch(url, {
              method: 'GET'
          })
          .then(res => res.json())
          .then(res => {
              if(res.status){
                  let li = '<option value="0">Seleccione una opción</option>';
                  const selectHora = document.getElementById('cita-hora');
                  res.horas.map(item => {
                      item.hora_inicio = item.hora_inicio.substring(0, 5);
                      item.hora_fin = item.hora_fin.substring(0, 5);
                      return item;
                  });

                  res.horas.forEach(item => {
                      li += `<option value="${ item.id }">${ item.hora_inicio } - ${ item.hora_fin }</option>`;
                  });

                  selectHora.innerHTML = li;
              }
          })
          .catch(err => console.log);
          
          // Resetear el campo de fecha si se cambia el valor del select
          $('#cita-fecha').val('');
      }
  });

  // Agregar evento al cambio de la opción en el select de médico
  selectMedico.addEventListener('change', () => {
      // Resetear el select de horas
      const selectHora = document.getElementById('cita-hora');
      selectHora.innerHTML = '<option value="0">Seleccione una opción</option>';
  });
}
 */

function cargarPaciente() {
    $.ajax({
        url: urlServidor + 'paciente/listar',
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
           //  console.log(response);
               if (response.status) {
                let data = response.paciente.map(element => ({
                    id: element.id,
                    text: element.persona.nombre + ' ' + element.persona.apellido + ' - ' + element.persona.cedula  
                }));

                $('#cita-paciente').select2({
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

function selectServicios() {
    $.ajax({
      // la URL para la petición
      url: urlServidor + "servicios/listar",
      // especifica si será una petición POST o GET
      type: "GET",
      beforeSend: function(xhr) {
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
        $.ajax({
          // la URL para la petición
          url: urlServidor + "servicios/listar/" + id,
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
  

  function guardar_cita() {
    $("#guardar-cita").click(function () {
   
      let paciente_id = $("#cita-paciente option:selected").val();
      let doctor_id = $("#cita-medico option:selected").val();
      let doctor_horario_id = $("#cita-hora option:selected").val();
      let fecha = $("#cita-fecha").val();
      let total_parcial = $("#total-parcial").text();
      let tr_servicios = $(".tr-servicio");
      let citas_servicios = [];

      let json = {
        citas: {
            paciente_id,
            doctor_id,
            doctor_horario_id,
            fecha,
            total_parcial,
        },
      };
      console.log(json);

      //validacion para datos de personas
       if (validarreservacion(json)) {
        //   console.log("llene los campos de datos de persona");

        if (tr_servicios.length > 0) {
          for (let i = 0; i < tr_servicios.length; i++) {
            let object = { servicios_id: tr_servicios[i].innerText };
            citas_servicios.push(object);
          }
          json.citas_servicios = citas_servicios;

      

          //Realizar peticion ajax
           guardandoCitas(json);
             // Esperar 5 segundos antes de recargar la página
           setTimeout(function () {
              location.reload();
            }, 1000);
           // Recargar la página después de guardar exitosamente
        //   
        } else {
          Swal.fire({
            title:"Debe seleccionar al menos un servicio",
            text: 'Citas',
            icon: 'error'
            })
        }
      } 
    });
  }

  function guardandoCitas(json) {
    $.ajax({
      url: urlServidor + "citas/guardar",
      type: "POST",
      data: "data=" + JSON.stringify(json),
      dataType: "json",
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
          Swal.fire({
            title:response.mensaje,
            text: 'Citas',
            icon: 'success'
        })
          

   
      //    selectServicios();
           
     
        } else {

          Swal.fire({
            title:response.mensaje,
            text: 'Citas',
            icon: 'error'
        })
   
        
          
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

  function validarreservacion(json) {
    let citas = json.citas;

  
    if (citas.paciente_id == 0) {
      Swal.fire({
        title:"Seleccione al paciente",
        text: 'Citas',
        icon: 'error'
    })
      return false;
    } else if (citas.doctor_id == 0) {
      Swal.fire({
        title:"Seleccione al medico",
        text: 'Citas',
        icon: 'error'
    })
      return false;
    } else if (citas.fecha == 0) {
      Swal.fire({
        title:"Seleccione una fecha",
        text: 'Citas',
        icon: 'error'
    })
      return false;
    } else if (citas.doctor_horario_id == 0) {
      Swal.fire({
        title:"Seleccione una hora para agendar su turno",
        text: 'Citas',
        icon: 'error'
    })
      return false;
    } else {
      return true;
    }
  }