$(function () {

    _init();

    function _init() {

    preview_img2();
    seleccionar_Categorias();
    seleccionar_Presentacion();
    guardar_producto();
    recuperar_Categorias();
    recuperar_Presentacion();
 
    }


function seleccionar_Categorias() {
    peticionJWT({
        // la URL para la petición
        url: urlServidor + 'categoria/listar_categorias',
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

            let option = '<option value="0">Seleccione una Categoria</option>';
            if (response.status) {
                //   console.log(response);

                response.categorias.forEach(element => {
                    option += `<option value=${element.id}>${element.nombre_categoria}</option>`;
                });
                $('#select-categoria').html(option);
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

function recuperar_Categorias() {
    peticionJWT({
        // la URL para la petición
        url: urlServidor + 'categoria/listar_categorias',
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

            let option = '<option value="0">Seleccione una Categoria</option>';
            if (response.status) {
                //   console.log(response);

                response.categorias.forEach(element => {
                    option += `<option value=${element.id}>${element.nombre_categoria}</option>`;
                });
                $('#editar-categoria').html(option);
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


function seleccionar_Presentacion() {
    peticionJWT({
        // la URL para la petición
        url: urlServidor + 'categoria/listar_presentacion',
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

            let option = '<option value="0">Seleccione una Presentacion</option>';
            if (response.status) {
                //   console.log(response);

                response.presentacion.forEach(element => {
                    option += `<option value=${element.id}>${element.tipo_presentacion}</option>`;
                });
                $('#select-presentacion').html(option);
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
function recuperar_Presentacion() {
    peticionJWT({
        // la URL para la petición
        url: urlServidor + 'categoria/listar_presentacion',
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

            let option = '<option value="0">Seleccione una Presentacion</option>';
            if (response.status) {
                //   console.log(response);

                response.presentacion.forEach(element => {
                    option += `<option value=${element.id}>${element.tipo_presentacion}</option>`;
                });
                $('#editar-presentacion').html(option);
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


function guardar_producto() {
    $('#nuevo-producto').submit(function (e) {
        e.preventDefault();


        let categoria_id = $('#select-categoria option:selected').val();
        let codigo = $('#nuevo-codigo').val();
        let nombre_producto = $('#registro-Producto').val();
        let descripcion = $('#descripcion-Producto').val();
        let presentacion_id = $('#select-presentacion option:selected').val();
        let stock = $('#stock-Producto').val();
        let marca = $('#marca-Producto').val();
        let precio_compra = $('#precioCompra-Producto').val();
        let precio_venta = $('#precioVenta-Producto').val();
        let fecha = $('#nuevo-fecha').val();

        let imagen = $('#imagen-Producto')[0].files[0];
        let def = (imagen == undefined) ? 'productodefault.png' : imagen.name;

        let json = {
            producto: {
                codigo,
                categoria_id,              
                nombre_producto,
                descripcion,
                presentacion_id,
                stock,
                marca,
                precio_compra,
                precio_venta,
                imagen:def,
                fecha
            },


        };

           if (!validarProducto(json)) {
              console.log("llene los campos de datos de persona");
          } else { 
               //Realizar peticion ajax
        console.log(json);
        guardando_producto(json);

         }
    });
}



function validarProducto(json) {
    let producto = json.producto;
    toastr.options = {
        "closeButton": true,
        "preventDuplicates": true,
        "positionClass": "toast-top-right",
        "progressBar": true,
    };

    if (producto.categorias_id == 0) {
        toastr["warning"]("Debe seleccionar la categoria");

        return false;
    } else if (producto.nombre_producto.length == 0) {
        toastr["warning"]("Debe ingresar el nombre del producto");
        return false;
    } else if (producto.descripcion.length == 0) {
        toastr["warning"]("Debe ingresar la descripcion del producto");
        return false;
    } else if (producto.presentacion_id == 0) {
        toastr["warning"]("Debe seleccionar la presentacion del producto");
        return false;
    } else if (producto.precio_compra.length == 0) {
        toastr["warning"]("Debe ingresar el precio de compra del producto");
        return false;
    } else if (producto.precio_venta.length == 0) {
        toastr["warning"]("Debe ingresar el precio de venta del producto");
        return false;
    } else if (producto.marca.length == 0) {
        toastr["warning"]("Debe ingresar la marca  del producto");
        return false;
    } else {
        return true;
    }
}


function guardando_producto(json) {

    peticionJWT({
        url: urlServidor + 'producto/guardar_prod2',
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
                toastr["success"](response.mensaje, "Registro de Productos");
              //  borrarCampos();
             //   $('#modal-registroProducto').modal('hide');
              //  datatable_productos();
                toastr["error"](response.mensaje, "Registro de Productos");
                $('#nuevo-producto')[0].reset();

            }else{
                toastr["error"](response.mensaje, "Registro de Productos");

            }
        },
        error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');

        }
    });

    if (json.producto.imagen == 'productodefault.png') {

    } else {
        let imagen = $('#imagen-Producto')[0].files[0];
        let formData = new FormData();
        formData.append('fichero', imagen);

        peticionJWT({
            // la URL para la petición
            url: urlServidor + 'producto/subirImagenes',
            // especifica si será una petición POST o GET
            type: 'POST',
            // el tipo de información que se espera de respuesta
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(xhr) {
                // Envía el token JWT en el encabezado Authorization
                let token = localStorage.getItem('token');
                if (token) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                }
            },
            success: function (responseImg) {
                if (responseImg.estado) {

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
    
   


}

function preview_img2(){
    $('#imagen-Producto').change(function(){
        readImage(this);
        $('#imagen-produc').removeClass('d-none');
    });
}

function readImage(input) {
if (input.files && input.files[0]) {
  var reader = new FileReader();
  reader.onload = function (e) {
      $('#imagen-produc').attr('src', e.target.result); // Renderizamos la imagen
  }
  reader.readAsDataURL(input.files[0]);
}
}

 

});