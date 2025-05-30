var tabla;

_init();
function _init() {
    dt_listarmedicoxid();
    //imprimir();
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
            url: urlServidor + 'citas/listardatatablexmedico/' + medico_id ,
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

function dt_listarmedicoxid2() {
   
    let medico_id = JSON.parse(localStorage.getItem('sesion-2'));

    tabla = $('#tabla-pendientes').DataTable({
        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "ajax":
        {
            url: urlServidor + 'citas/listardatatablexmedico/' + medico_id ,
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

/* function atender(id){
    // alert(id);
    localStorage.setItem('citas_id', id); 
    console.log(localStorage);
  //  location.href = urlCliente + 'gestion/atendercitas'; 
    location.href = urlCliente + 'gestion/atendercitas3'; 
}
 */

function atender(id, paciente_id) {
    // Guardar el id de la cita en el localStorage
    localStorage.setItem('citas_id', id);
    
    // Guardar el id del paciente en el localStorage
    localStorage.setItem('paciente_id', paciente_id);

    console.log(localStorage);

    // Redirigir a la página donde gestionas la cita
    location.href = urlCliente + 'gestion/atendercitas3';
}

 
function cancelar_cita(id){

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Deseas Cancelar esta cita medica?.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            cambiar_estado_cancelarcita(id);
        }
});
}


function cambiar_estado_cancelarcita(id){
    $.ajax({
        url: urlServidor + 'citas/eliminarCitasCancelar/' + id, // Asegúrate de cambiar la ruta
        type: 'GET',
        dataType: 'json',
        beforeSend: function(xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function(response) {
        
            if (response.status) {
  
              Swal.fire({
                title: "Citas Medicas",
                text: 'Se ha cancelado la cita medica',
                icon: 'success'
            })
  
            dt_listarmedicoxid2();
              
            }
        },
        error: function(jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        }
    });
}