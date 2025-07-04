 
    _init();

    function _init() {


        dt_mensajesrecibidos();
        editandoCorreos();
      
    }


    function dt_mensajesrecibidos() {
        tabla = $('#tabla-subscribe').DataTable({
            "lengthMenu": [5, 10, 25, 75, 100],
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "aProcessing": true,
            "aServerSide": true,
            "ajax":
            {
                url: urlServidor + 'correos/dtsubscribe',
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
            "iDisplayLength": 12,
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

            }
        });
    }

   
    function respondersubscribe(id) {
        $('#modal-editar-mensaje').modal('show');
       // alert(id);
        cargarCorreos(id);
    }
    
     function cargarCorreos(id) {
       peticionJWT({
            // la URL para la petición
            url: urlServidor + 'correos/listarsubscribe/' + id,
            // especifica si será una petición POST o GET
            type: 'GET',
            // el tipo de información que se espera de respuesta
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
                    $('#id-correo').val(response.subscribe.id);
                    $('#editar-observacion').val(response.subscribe.observacion);
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
    
    function editandoCorreos() {
        $('#btn-editar-mensaje').click(function () {
            let id = $('#id-correo').val();
            let observacion = $('#editar-observacion').val();
    
            let json = {
                subscribe: {
                    id: id,
                    observacion: observacion,
                }
            };
    
           peticionJWT({
                // la URL para la petición
                url: urlServidor + 'correos/editarsubscribe',
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
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                        "positionClass": "toast-top-right",
                        "progressBar": true,
                    };
    
                    if (response.status) {
                        toastr["success"](response.mensaje, "Correo Envado");
    
    
                        $('#modal-editar-mensaje').modal('hide');
                        dt_correosrecibidos2();
                    } else {
                        toastr["error"](response.mensaje, "Actualizar Correos");
    
                    }
                },
                error: function (jqXHR, status, error) {
                    console.log('Disculpe, existió un problema');
                },
                complete: function (jqXHR, status) {
                    // console.log('Petición realizada');
                }
            });
    
        })
    } 
    

    function dt_correosrecibidos2() {
        tabla = $('#tabla-subscribe').DataTable({
            "lengthMenu": [5, 10, 25, 75, 100],
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "aProcessing": true,
            "aServerSide": true,
            "ajax":
            {
                url: urlServidor + 'correos/dtsubscribe',
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
            "iDisplayLength": 12,
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

            }
        });
    }