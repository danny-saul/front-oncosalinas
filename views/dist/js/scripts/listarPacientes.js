var tabla;

_init();
function _init() {
    dt_listarpaciente();
    //imprimir();
}

function dt_listarpaciente() {
   
       let token = localStorage.getItem('token');

    if (!token) {
        window.location = urlCliente + 'login';
        return;
    }

    
    tabla = $('#tabla-pacientes').DataTable({
        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "ajax":
        {
            url: urlServidor + 'paciente/dtlistar' ,
            type: "get",
              beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            },
            error: function (jqXHR) {
                if (jqXHR.status === 401) {
                    localStorage.removeItem('token');
                    window.location = urlCliente + 'login';
                } else {
                    console.log('Error AJAX:', jqXHR.status, jqXHR.responseText);
                }
            }
        },
        destroy: true,
        "iDisplayLength": 8,//Paginación
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


function atender(id){
     alert(id);
     window.location = urlServidor + 'inicio/dashboard';
    
}

function editar_pac(id){
    // alert(id);
    localStorage.setItem('usuario_id', id); 
    console.log(localStorage);
    location.href = urlCliente + 'usuario/editarPaciente'; 
}




