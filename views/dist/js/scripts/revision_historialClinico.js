var tabla;

_init();
function _init() {
    dt_listarpacienterevision();
    storage_paciente();
}


function storage_paciente() {
  let paciente_id = localStorage.getItem('paciente_id');

  peticionJWT({
    // la URL para la petición
    url: urlServidor + 'paciente/listarid/' + paciente_id,
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
 
        $('#nombre-paciente').text(response.paciente.nombre + ' ' + response.paciente.apellido);
 
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



function dt_listarpacienterevision() {
      let paciente_id = localStorage.getItem('paciente_id');

   
    tabla = $('#tabla-historia-citas').DataTable({
        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "ajax":
        {
            url: urlServidor + 'paciente/dtlistarhistorialcitasrevision/' + paciente_id ,
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

$(document).on('click', '.imprimir-disabled', function(e) {
    e.preventDefault();
    Swal.fire({
        icon: 'warning',
        title: 'Faltan signos vitales',
        text: 'Debe registrar los signos vitales antes de imprimir el formulario.',
        confirmButtonText: 'Entendido'
    });
});


/* function atender(id){
     alert(id);
     window.location = urlServidor + 'inicio/dashboard';
    
}

function revisar(id){
    // alert(id);
    localStorage.setItem('usuario_id', id); 
    console.log(localStorage);
    location.href = urlCliente + 'historial/revisar';
   
}

 */


