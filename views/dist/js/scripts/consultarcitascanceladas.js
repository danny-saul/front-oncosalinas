var tabla;

_init();

function _init() {
    dt_listarmedicoxid_atendidas();
    //imprimir();
}

function dt_listarmedicoxid_atendidas() {
    let medico_id = JSON.parse(localStorage.getItem('sesion-2'));
    let token = localStorage.getItem('token');

    if (!token) {
        window.location = urlCliente + 'login';
        return;
    }

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
                type: "GET",
                dataType: "json",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                },
                error: function (jqXHR) {
                    if (jqXHR.status === 401) {
                        localStorage.removeItem('token');
                        window.location = urlCliente + 'login';
                    } else {
                        console.error('Error AJAX:', jqXHR.status, jqXHR.responseText);
                    }
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
                    "sSortAscending": ": Activar para ordenar ascendente",
                    "sSortDescending": ": Activar para ordenar descendente"
                }
            }
        });
    }

    // 👉 Carga automática al abrir la página (sin fechas)
    cargarDataTable();

    // 👉 Filtro por fecha
    $('#btn-consulta').click(function () {
        let fecha_inicio = $('#fecha-inicio-r-v').val() || "null";
        let fecha_fin = $('#fecha-fin-r-v').val() || "null";

        cargarDataTable(fecha_inicio, fecha_fin);
    });
}

// Funciones auxiliares
function atender(id) {
    localStorage.setItem('citas_id', id);
    location.href = urlCliente + 'gestion/atendercitas';
}

function imprimir_receta(id) {
    localStorage.setItem('citas_id', id);
    location.href = urlCliente + 'imprimir/ver_receta';
}

function editar_cita(id) {
    localStorage.setItem('citas_id', id);
    location.href = urlCliente + 'inicio/editarcitas';
}
