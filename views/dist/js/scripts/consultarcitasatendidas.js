var tabla;

_init();
function _init() {
    dt_listarmedicoxid_atendidas();
    //imprimir();
}

/* function dt_listarmedicoxid_atendidas() {


    $('#btn-consulta').click(function () {
        let fecha_inicio = $('#fecha-inicio-r-v').val();
        let fecha_fin = $('#fecha-fin-r-v').val();


        toastr.options = {
            "closeButton": true,
            "preventDuplicates": true,
            "positionClass": "toast-top-right",
        };



        let f = new Date();
        let fecha = f.getDate() + '/' + (f.getMonth() + 1) + '/' + f.getFullYear();
        let hora = f.getHours() + ':' + (f.getMinutes()) + ':' + f.getSeconds();
        let medico_id = JSON.parse(localStorage.getItem('sesion-2'));
        // Si el usuario no selecciona fechas, envía 'null' para obtener todo
        fecha_inicio = fecha_inicio ? fecha_inicio : 'null';
        fecha_fin = fecha_fin ? fecha_fin : 'null';

      

        tabla = $('#tabla-pendientes').DataTable({
            "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            "ajax":
            {
                url: urlServidor + 'citas/listardatatablexmedico_atendidas/' + medico_id + '/' + fecha_inicio + '/' + fecha_fin,
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



    });


}
 */

function dt_listarmedicoxid_atendidas() {

    let medico_id = JSON.parse(localStorage.getItem('sesion-2'));

    function cargarDataTable(fecha_inicio = "null", fecha_fin = "null") {
        $('#tabla-pendientes').DataTable({
            "lengthMenu": [5, 10, 25, 75, 100],
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "aProcessing": true,
            "aServerSide": true,
            "ajax": {
                url: urlServidor + 'citas/listardatatablexmedico_atendidas/' + medico_id + '/' + fecha_inicio + '/' + fecha_fin,
                type: "get",
                dataType: "json",
                beforeSend: function (xhr) {
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
            "iDisplayLength": 5,
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
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
            }
        });
    }

    // 👉 Carga automática al abrir la página (sin fechas)
    cargarDataTable();

    // 👉 Botón para filtrar por fecha
    $('#btn-consulta').click(function () {
        let fecha_inicio = $('#fecha-inicio-r-v').val();
        let fecha_fin = $('#fecha-fin-r-v').val();

        fecha_inicio = fecha_inicio ? fecha_inicio : "null";
        fecha_fin = fecha_fin ? fecha_fin : "null";

        // Recarga el datatable con el filtro aplicado
        cargarDataTable(fecha_inicio, fecha_fin);
    });
}












/* 
function atender(id) {
    // alert(id);
    localStorage.setItem('citas_id', id);
    console.log(localStorage);
    location.href = urlCliente + 'gestion/atendercitas';
} */

/* function imprimir_receta(id) {
    // alert(id);
    localStorage.setItem('citas_id', id);
    console.log(localStorage);
    location.href = urlCliente + 'imprimir/ver_receta';
} */

function editar_cita(id, paciente_id) {
  //  alert(id);
    localStorage.setItem('citas_id', id);
    localStorage.setItem('paciente_id', paciente_id);

    console.log(localStorage);
    location.href = urlCliente + 'inicio/editarcitas';
}

