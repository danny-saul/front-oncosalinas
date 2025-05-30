var tabla;

_init();
function _init() {
    dt_listarmedicoxid_atendidas();
    //imprimir();
}

 

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
                url: urlServidor + 'citas/listardatatablexmedico_canceladas/' + medico_id + '/' + fecha_inicio + '/' + fecha_fin,
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
            "iDisplayLength": 15,
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













function atender(id) {
    // alert(id);
    localStorage.setItem('citas_id', id);
    console.log(localStorage);
    location.href = urlCliente + 'gestion/atendercitas';
}

function imprimir_receta(id) {
    // alert(id);
    localStorage.setItem('citas_id', id);
    console.log(localStorage);
    location.href = urlCliente + 'imprimir/ver_receta';
}

function editar_cita(id) {
    // alert(id);
    localStorage.setItem('citas_id', id);
    console.log(localStorage);
    location.href = urlCliente + 'inicio/editarcitas';
}

