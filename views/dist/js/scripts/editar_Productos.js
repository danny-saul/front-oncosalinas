
init();

function init() {
  
    cargarCategoria();
    recuperar_Presentacion();
    cargarProducto();
    editandoproducto();
}



 
function cargarCategoria() {
    $.ajax({
        url: urlServidor + 'categoria/listar_categorias',
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
            console.log(response);
            if (response.status) {
                let option = '<option value="0">Seleccione Categoria</option>';
                response.categorias.forEach(element => {
                    option += `<option value=${element.id}>${element.nombre_categoria}</option>`;
                });
                $('#editar-categ').html(option);
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
    $.ajax({
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
                   console.log(response);

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


function cargarProducto() {
    let id = localStorage.getItem('producto_id');
    console.log(id);
 
    $.ajax({
        // la URL para la petición
        url: urlServidor + 'producto/listar/' + id,
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
            console.log(response.producto.categoria.id);
            
            if (response.status) {
                $('#id-Producto').val(response.producto.id);
                $('#editar-categ').val(response.producto.categoria.id);
                $('#marca-editar').val(response.producto.marca);
 
                $('#editar-nuevo-codigo').val(response.producto.codigo);
                $('#editar-registro-Producto').val(response.producto.nombre_producto);
                $('#editar-descripcion-Producto').val(response.producto.descripcion);
                $('#editar-nuevo-fecha').val(response.producto.fecha);
                $('#editar-presentacion').val(response.producto.presentacion.id);
                $('#stock-editar').val(response.producto.stock);
                $('#precioCompra-editar').val(response.producto.precio_compra);
                $('#precioVenta-editar').val(response.producto.precio_venta);
     

  
                if (response.producto.imagen) {
                    let imagenUrl = urlServidor + 'productos/productos/' + response.producto.imagen;
                    $('#imagen-produc-e').attr('src', imagenUrl);
                } else {
                
                    $('#imagen-produc-e').attr('src', '<?=SERVIDOR?>resources/usuarios/default.jpg');
                }

    
             


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



function editandoproducto() {

    $('#nuevo-producto-ed').submit(function (e) {
        e.preventDefault();

        let id = $('#id-Producto').val();
        let categoria_id =$('#editar-categ option:selected').val();
        let presentacion_id =$('#editar-presentacion option:selected').val();
        let nombre = $('#editar-registro-Producto').val();
        let codigo = $('#editar-nuevo-codigo').val();
        let descripcion = $('#editar-descripcion-Producto').val();
        let stock = $('#stock-editar').val();
        let marca = $('#marca-editar').val();
        let precio_compra = $('#precioCompra-editar').val();
        let precio_venta = $('#precioVenta-editar').val();
        let fecha = $('#editar-nuevo-fecha').val();

        let json = {
            producto: {
                id: id,
                categoria_id: categoria_id,
                presentacion_id: presentacion_id,
                nombre: nombre,
                codigo: codigo,
                marca: marca,
                descripcion: descripcion,
                stock: stock,
                precio_compra: precio_compra,
                precio_venta: precio_venta,
                fecha:fecha,
            }
        };
        console.log(json);
     
         $.ajax({
            // la URL para la petición
            url: urlServidor + 'producto/editar',
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
                    toastr["success"](response.mensaje, "Actualizar Producto");

                   

                } else {
                    toastr["error"](response.mensaje, "Actualizar Producto");

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