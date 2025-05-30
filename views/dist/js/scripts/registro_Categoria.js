$(function () {
    _init();

    function _init() {


        datatable_categorias();
        guardar_Categoria();
        editando_categoria();


    }






    function guardar_Categoria() {
        $('#btn-guardar-categoria').click(function () {

            let nombre_categoria = $('#registro-categoria').val();

            let json = {
                categorias: {
                    nombre_categoria,
                },


            };

            //validacion para datos de personas
            if (!validarcategoria(json)) {
                console.log("llene los campos de datos de persona");
            } else {
                //       //Realizar peticion ajax
                console.log(json);
                guardando_categoria(json);

            }
        });
    }

    function validarcategoria(json) {
        let categorias = json.categorias;
        console.log(categorias);
        toastr.options = {
            "closeButton": true,
            "preventDuplicates": true,
            "positionClass": "toast-top-right",
            "progressBar": true,
        };

        if (categorias.nombre_categoria == 0) {
            toastr["warning"]("Debe ingresar una categoria");

            return false;

        } else {
           
            return true;
        }
    }


    function guardando_categoria(json) {

        $.ajax({
            url: urlServidor + 'categoria/guardar_categoria',
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
                toastr.options = {
                    "closeButton": true,
                    "preventDuplicates": true,
                    "positionClass": "toast-top-right",
                    "progressBar": true,
                };

                if (response.estado) {
                    toastr["success"](response.mensaje, "Registro de Categoria");
                    $('#registro-categoria').val('');
                    $('#modal-registro-categoria').modal('hide');
                    datatable_categorias();
                    toastr["error"](response.mensaje, "Registro de Categoria");

                } else{
                    toastr["error"](response.mensaje,"Categorias");
                }
            },
            error: function (jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            }
        });


    }


    function datatable_categorias() {
        tabla = $('#tabla-categorias').DataTable({
            "lengthMenu": [5, 10, 25, 75, 100],
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "aProcessing": true,
            "aServerSide": true,
            "ajax":
            {
                url: urlServidor + 'categoria/datatable_categoria',
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
            "iDisplayLength": 5,
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



});




function editar_categoria(id) {
    $('#modal-editar-categoria').modal('show');
    cargarCategorias(id);
}

function cargarCategorias(id) {
    $.ajax({
        // la URL para la petición
        url: urlServidor + 'categoria/listarId/' + id,
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
                $('#id-categoria').val(response.categoria.id);
                $('#editar-categoria').val(response.categoria.nombre_categoria);
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

function editando_categoria() {
    $('#btn-editar-categoria').click(function () {
        let id = $('#id-categoria').val();
        let nombre_categoria = $('#editar-categoria').val();

        let json = {
            categoria: {
                id: id,
                nombre_categoria: nombre_categoria,
            }
        };

        $.ajax({
            // la URL para la petición
            url: urlServidor + 'categoria/editar',
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
                    toastr["success"](response.mensaje, "Actualizar Categoria");


                    $('#modal-editar-categoria').modal('hide');
                    datatable_categorias2();
                } else {
                    toastr["error"](response.mensaje, "Actualizar Categoria");

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

function eliminar_categoria(id) {

    let json = {
        categoria:
            { id }
    };

    $.ajax({
        // la URL para la petición
        url: urlServidor + 'categoria/eliminar/' + id,
        // especifica si será una petición POST o GET
        type: 'POST',
        // el tipo de información que se espera de respuesta
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
            if (response.status) {
                toastr["success"](response.mensaje, "Eliminar Categoria");

                datatable_categorias2();
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



function datatable_categorias2() {
    tabla = $('#tabla-categorias').DataTable({
        "lengthMenu": [5, 10, 25, 75, 100],
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,
        "aServerSide": true,
        "ajax":
        {
            url: urlServidor + 'categoria/datatable_categoria',
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
        "iDisplayLength": 5,
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