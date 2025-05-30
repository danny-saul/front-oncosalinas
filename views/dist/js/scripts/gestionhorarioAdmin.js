var tabla;
_init();

function _init() {
    seleccionar_doctor();
    cargarlistadohorariodt();
    guardarHorarioAtencion();
    
}

function seleccionar_doctor() {
    $.ajax({
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


function guardarHorarioAtencion() {

    $('#form-horario-doctor').submit(function (e) {
        e.preventDefault();
        let usuario_id = JSON.parse(localStorage.getItem('sesion')).id;
        let doctor_id = $('#select-doctor option:selected').val();
        let hora_inicio = $('#hora-entrada').val();
        let hora_fin = $('#hora-salida').val();
        // let fecha= $('#fecha-doctor').val();
        let salto = $('#select-intervalo option:selected').val();

        let horaAtencion = '07:59:00';
        let horaFinAtencion = '22:00:00';

     
        if (doctor_id == '0') {
            Swal.fire({
                title: 'Seleccione un doctor',
                text: 'Horarios',
                icon: 'error'
            })
          
        }
        else if (salto == '0') {
            Swal.fire({
                title: 'Seleccione un interalo',
                text: 'Horarios',
                icon: 'error'
            })
 
        }
        else if (hora_fin < hora_inicio) {
            Swal.fire({
                title: 'La hora de salida no puede ser menor a la hora de entrada',
                text: 'Horarios',
                icon: 'error'
            })
            
        } else if (hora_inicio == hora_fin) {
            Swal.fire({
                title: 'La hora de entrada no puede ser igual a la hora de salida',
                text: 'Horarios',
                icon: 'error'
            })
         

        } else if (hora_inicio < horaAtencion) {
            Swal.fire({
                title: 'La hora de entrada no puede ser menor a la hora de atencion (9:00 am)',
                text: 'Horarios',
                icon: 'error'
            })
           
        } else if (hora_fin > horaFinAtencion) {
            Swal.fire({
                title: 'Solo se gestiona hasta las (18:00 pm)',
                text: 'Horarios',
                icon: 'error'
            })
          
        } else {
            let json = {
                doctor_horario: {
                    usuario_id,
                    doctor_id,
                    hora_inicio,
                    hora_fin,
                    salto,

                },

            };
            guardandoHorarioAtencion(json)
            console.log(json);
        }

    });
}

function guardandoHorarioAtencion(json) {
    $.ajax({
        url: urlServidor + 'doctor_horario/generar',
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
        

            if (response.status) {
                Swal.fire({
                    title: response.mensaje,
                    text: 'Horario de Atencion',
                    icon: 'success'
                })
          
                
 
                $('#form-horario-doctor')[0].reset();
                // get_HorariosAtencion();
                //cargarHorariosAsignacion('S');
            } else {
                Swal.fire({
                    title: response.mensaje,
                    text: 'Horario de Atencion',
                    icon: 'error'
                })
          
               
            }
        },
        error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        }
    });
}

function cargarlistadohorariodt() {
    $('#consutar').click(()=>{
        let doctor_id = $('#select-doctor-listar option:selected').val();
    
        if(doctor_id == null){
            console.log('vacio');
        }else{
            console.log(doctor_id);
            consultar(doctor_id);   
        }
    });
}

function consultar(doctor_id) {  
    tabla = $('#tabla-horarios').DataTable({
        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "ajax":
        {
            url: urlServidor + 'doctor_horario/listarHorarios/' + doctor_id,
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











