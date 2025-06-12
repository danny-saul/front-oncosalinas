
var tabla;
var tabla2;
var detalleProducto = [];

_init();
function _init() {
  
    datatablelistarpaciente();
    select_productos();
    agregarProductos();
    guardar_venta();
    cargarStorageCliente();
    generarNumerosVentas();
  /*imprimir();
  buscar_producto(); */

}


function generarNumerosVentas() {
    peticionJWT({
      url: urlServidor + 'ventas/generar_aleartorio_ventas/Tabla_Ventas',
      type: 'GET',
      dataType: 'json',
      beforeSend: function (xhr) {
        // Envía el token JWT en el encabezado Authorization
        let token = localStorage.getItem('token');
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
      },
      success: function (response) {
        //       console.log(response);
        if (response.estado) {
          $('#num-consulta').text(response.numero);
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
  
  function guardarCodigo() {
    let num_venta = $('#num-consulta').text();
  
    let json = {
      num_venta: {
        num_venta: num_venta,
        id_tablas: 'Tabla_Ventas'
      }
    }
  
    peticionJWT({
      url: urlServidor + 'ventas/aumentarAleartoriosVentas',
      type: 'POST',
      data: 'data=' + JSON.stringify(json),
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
        generarNumerosVentas();
      },
      error: function (jqXHR, status, error) {
        console.log('Disculpe, existió un problema');
      },
      complete: function (jqXHR, status) {
        // console.log('Petición realizada');
      }
    });
  }

  

function cargarStorageCliente() {
    let usuario = JSON.parse(localStorage.getItem('sesion'));
    let nombres = usuario.persona.nombre + ' ' + usuario.persona.apellido;
  
    $('#usuario-nombre').text(nombres);
  
  }
  


function datatablelistarpaciente() {

    tabla = $('#tabla-listar-clientes').DataTable({
      "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "aProcessing": true,//Activamos el procesamiento del datatables
      "aServerSide": true,//Paginación y filtrado realizados por el servidor
      "ajax":
      {
        url: urlServidor + 'ventas/listardatatable',
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



  function seleccionar(id) {

    peticionJWT({
      // la URL para la petición
      url: urlServidor + 'ventas/listarclientexid/' + id,
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
        if (response.estado) {
               console.log(response);
          $('#cliente-id').val(response.cliente.id);
          //  $('#producto-codigo').val(categoria);
          $('#nombres-apellidos').text(response.cliente.persona.nombre + ' ' + response.cliente.persona.apellido);
          $('#cedula').text(response.cliente.persona.cedula);
          $('#telefono').text(response.cliente.persona.telefono);
          $('#direccion').text(response.cliente.persona.direccion);
  
  
        }
      },
      error: function (jqXHR, status, error) {
        console.log('Disculpe, existió un problema');
      },
      complete: function (jqXHR, status) {
        // console.log('Petición realizada');
      }
    });
    $('#modal-ver-clientes').modal('hide');
  
  
  }
  

/*   function datatableproducto() {

    tabla2 = $('#tabla-listar-producto').DataTable({
      "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "aProcessing": true,//Activamos el procesamiento del datatables
      "aServerSide": true,//Paginación y filtrado realizados por el servidor
      "ajax":
      {
        url: urlServidor + 'ventas/listardatatableprod',
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
  } */

/*   function seleccionar_prod(id) {



    peticionJWT({
      // la URL para la petición
      url: urlServidor + 'ventas/listarproductoid/' + id,
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
        if (response.estado) {
               console.log(response);
          $('#producto-id').val(response.producto.id);
          $('#producto-nombres').val(response.producto.nombre_producto);
          $('#producto-stock').val(response.producto.stock);
          $('#producto-cantidad').val(response.producto.cantidad);
          $('#descripcion-producto').val(response.producto.descripcion);
          $('#precioventa-producto').val(response.producto.precio_venta);
  
  
        }
      },
      error: function (jqXHR, status, error) {
        console.log('Disculpe, existió un problema');
      },
      complete: function (jqXHR, status) {
        // console.log('Petición realizada');
      }
    });
    $('#modal-ver-producto').modal('hide');
  
  
  } */


    function select_productos() {
        peticionJWT({
          // la URL para la petición
          url: urlServidor + 'ventas/listar_producto',
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
            if (response.length > 0) {
              //  console.log(response);
              let tr = '';
              let i = 1;
              console.log(response);
              response.forEach(element => {
                let imagen = element.imagen;

               let img2 =  `<img src="${urlServidor}productos/productos/${imagen}" class="img-circle elevation-2" alt="User Image" with="50px" height="60px">`;

                tr += `<tr id="file-prod-${element.id}">
                          <td>${i}</td>
                          <td style="display: none">${element.id}</td>
                          <td>${img2}</td>
                          <td>${element.codigo}</td>
                          <td>${element.categoria.nombre_categoria}</td>
                          <td>${element.nombre_producto}</td>
                          <td>${element.descripcion}</td>
                          <td>${element.stock}</td>
                          <td>${element.precio_venta}</td>
                          <td style="display: none">${element.precio_compra}</td>
      
                          <td>
                            <div class="div">
                              <button class="btn btn-danger btn-sm" data-dismiss="modal" onclick="seleccionar_producto(${element.id})">
                                <i class="fas fa-check"></i>
                              </button>
                            </div>
                          </td>
                        </tr>`;
                i++;
              });
              $('#producto-body').html(tr);
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


      function agregarProductos() {
        $('#agregar-producto').click(function () {
      
          let producto_id = $('#producto-id').val();
          let nombre = $('#producto-nombres').val();
          let cantidad = $('#producto-cantidad').val();
          let descripcion = $('#descripcion-producto').val();
          let precio_venta = $('#precioventa-producto').val();
          let descripcion1 = $('#descripcion-1').val();
          let descripcion2 = $('#descripcion-2').val();
          let stock = parseInt($('#producto-stock').val());
          let totalParcial = Number((parseInt(cantidad) * parseFloat(precio_venta)).toFixed(2));
      
          toastr.options = {
            "closeButton": true,
            "preventDuplicates": true,
            "positionClass": "toast-top-center",
          };
      
          if (producto_id.length == 0) {
            toastr["error"]('Seleccione un Producto', "Producto");
          } else
            if (cantidad.length == 0) {
              toastr["error"]('Ingrese una cantidad', "Producto");
            } else
              if (parseInt(cantidad) == 0 || parseInt(cantidad) < 0) {
                toastr["error"]('Ingrese un valor mayor a 0', "Producto");
              } else
                if (parseInt(cantidad) > stock) {
                  toastr["error"]('Cantidad supera al stock', "Producto");
                } else {
      
                  let json = {
                    producto_id: parseInt(producto_id),
                    nombre: nombre,
                    cantidad: parseInt(cantidad),
                    descripcion: descripcion,
                    descripcion1: descripcion1,
                    descripcion2: descripcion2,
                    precio_venta: parseFloat(precio_venta),
                    totalParcial: parseFloat(totalParcial)
                  }
                 validar(json);
                 tabla_actualizar();
      
      
                }
        });
      }

      function aumentar(e) {
        const buttonAumentar = e.target;
        const trPadre = buttonAumentar.closest('.itemNew');
        const classId = trPadre.querySelector('.id').innerHTML;
        let id = Number(classId);
      
        if (e.target.classList.contains('btn-primary')) {
          detalleProducto.forEach((res) => {
            if (res.producto_id === id) {
              console.log(res);
              res.cantidad++;
              res.totalParcial = (res.cantidad * res.precio_venta).toFixed(2);
              console.log('aumentando');
              tabla_actualizar();
              actualizarDatos();
            }
          });
        }
      }
      
      function disminuir(e) {
        const buttonDisminuir = e.target;
        const trPadre = buttonDisminuir.closest('.itemNew');
        const classId = trPadre.querySelector('.id').innerHTML;
        let id = Number(classId);
      
        for (let i = 0; i < detalleProducto.length; i++) {
          if (detalleProducto[i].producto_id === id) {
            detalleProducto[i].cantidad--;
            detalleProducto[i].totalParcial = (detalleProducto[i].cantidad * detalleProducto[i].precio_venta).toFixed(2);
      
            if (detalleProducto[i].cantidad === 0) {
              detalleProducto.splice(i, 1);
            //  vaciarTextTotales();
            }
            console.log('disminuyendo');
            tabla_actualizar();
            actualizarDatos();
          }
        }
      
      }

      function borrarItem(e) {
        const btn = e.target;
        const trPadre = btn.closest('.itemNew');
        const classId = trPadre.querySelector('.id').innerHTML;
        let id = Number(classId);
      
        for (let j = 0; j < detalleProducto.length; j++) {
          if (detalleProducto[j].producto_id === id) {
            detalleProducto.splice(j, 1);
          }
        }
        trPadre.remove();
        actualizarDatos();
        // $('#venta-descuento').text('0.00');
        // $('#orden-subtotal').text('0.00');
        // $('#orden-total').text('0.00');
      
      
      
      
      
      
      }

      function eliminar_producto(producto_id, totalParcial) {
        let tr = '#fila-producto-' + producto_id;
        $(tr).remove();
      
        actualizarDatos();
      }
      
      function actualizarDatos() {
        let tr = $('#productos-agregados tr');
        let subtotal = 0;
        let total = 0;
      
        for (let i = 0; i < tr.length; i++) {
          let hijos = tr[i].children;
          subtotal += parseFloat(hijos[4].innerText);
      
        }
      
        let iva = Number(subtotal.toFixed(2) * 0);
        /*console.log(iva);*/
        total = Number(subtotal) + Number(iva.toFixed(2));
      
        $('#orden-subtotal').text(subtotal.toFixed(2));
        $('#orden-iva').text(iva.toFixed(2));
        $('#orden-total').text(total.toFixed(2));
      
      }
      
      function limpiarCampos() {
        $('#producto-id').val('');
        $('#producto-nombres').val('');
        $('#producto-cantidad').val('');
        $('#producto-stock').val('');
        $('#precioventa-producto').val('');
        $('#descripcion-producto').val('');
        $('#preciocompra-producto').val('');
      /*    $('#descripcion-1').val('');
         $('#descripcion-2').val(''); */
      }

      function guardar_venta() {
        $('#guardar-venta').click(function () {
      
          toastr.options = {
            "closeButton": true,
            "preventDuplicates": true,
            "positionClass": "toast-top-right",
            "progressBar": true,
          };
      
          let num_venta = $('#num-consulta').text();
          let fecha= $('#fecha-o').text();
          let descuento = $('#orden-descuento').text();
          let usuario_id = JSON.parse(localStorage.getItem('sesion')).id;
          let paciente_id = $('#cliente-id').val();
          let subtotal = $('#orden-subtotal').text();
          let iva = $('#orden-iva').text();
          let total = $('#orden-total').text();
          let descripcion1 = $('#descripcion-1').val();
          let descripcion2 = $('#descripcion-2').val();
      
          let object = array_producto();
          //console.log(object);
      
      
          if (paciente_id == 0) {
            toastr["error"]("Seleccione un cliente", "Ventas");
          } else if (object == false) {
            toastr["error"]("Debe Ingresar Productos", "Ventas");
          } else {
            let json = {
              venta: {
                num_venta,
                fecha,
                descuento,
                usuario_id,
                paciente_id,
                subtotal,
                descripcion1,
                descripcion2,
                iva,
                total
              },
              ordenes_ventas: object.ordenes_ventas, detalle_venta: object.detalle_venta
            };
          console.log(json);
          //  imprimir();
         ajax_guardar(json);
          }
      
        });
      
      }


      function array_producto() {
        let tr = $('#productos-agregados tr');
      
        let detalle_venta = [];
        let ordenes_ventas = { citas_id: '0' };
        let json = {};
      
        for (let i = 0; i < tr.length; i++) {
          let hijos = tr[i].children;
      
          let cantidad = hijos[0].innerText;
          let precio_venta = hijos[3].innerText;
          let total_general = hijos[4].innerText;
          let producto_id = hijos[7].innerText;
          /* let descripcion1 = hijos[10].innerText;
          let descripcion2 = hijos[11].innerText; */
          let es_orden = hijos[9].innerText;
          let citas_id = hijos[8].innerText;
          console.log(hijos);
      
          if (citas_id == '0') {
            let object = { cantidad, precio_venta, total_general, producto_id, es_orden  };
            detalle_venta.push(object);
          } else {
      
            ordenes_ventas.citas_id = citas_id;
          }
      
          json = {
             ordenes_ventas,  detalle_venta
          }
      
        }
        return json;
      }
      function ajax_guardar(json) {
        peticionJWT({
          // la URL para la petición
          url: urlServidor + 'ventas/guardarventas',
          // especifica si será una petición POST o GET
          type: 'POST',
      
          data: "data=" + JSON.stringify(json),
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
      
              toastr.options = {
                "closeButton": true,
                "preventDuplicates": true,
                "positionClass": "toast-top-right",
                "progressBar": true,
              };
              toastr["success"](response.mensaje, "Venta");
              guardarCodigo();
              $('#productos-agregados').html('');
              $('#orden-subtotal').html('');
              $('#orden-iva').html('');
              $('#orden-descuento').html('');
              $('#orden-total').html('');
              $('#descripcion-1').text('');
              $('#descripcion-2').text('');
      
              $('#cliente-id').text('');
              $('#cedula').text('');
              $('#nombres-apellidos').text('');
              $('#telefono').text('');
              $('#direccion').text('');
              select_productos();

              setTimeout(function () {
                location.reload();
              }, 1000);
      
              //   actualizar_card();
      
            } else {
              toastr["error"](response.mensaje, "Venta");
      
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
      

   
      
function validar(json) {
    let subtotal = 0.00;
    for (let i = 0; i < detalleProducto.length; i++) {//abrir el detalleArray
      if (detalleProducto[i].producto_id === json.producto_id) {//cuando se repite el id producto
        detalleProducto[i].cantidad = detalleProducto[i].cantidad + json.cantidad;
        subtotal = Number((detalleProducto[i].totalParcial) + (json.totalParcial));
        detalleProducto[i].totalParcial = subtotal;
        return detalleProducto;
      }
    }
    detalleProducto.push(json);
    return detalleProducto;
  }

  function tabla_actualizar() {

    const tbody = document.getElementById('productos-agregados');
    tbody.innerHTML = '';
  
    if (detalleProducto === undefined) {
      detalleProducto = [];
    } else {
      detalleProducto.forEach(e => {
        const tr = document.createElement('tr');
        tr.classList.add('itemNew');
  
        containerChelas = `
          
          <td>${e.cantidad}</td>
          <td>${e.nombre}</td>
          <td>${e.descripcion}</td>
          <td>${e.precio_venta}</td>
          <td class="total-parcial">${e.totalParcial}</td>
          <td>
          <button class="btn btn-primary btn-sm">
              <i class="fas fa-plus"></i>
          </button>
          <button class="btn btn-dark btn-sm">
              <i class="fas fa-minus"></i>
          </button>
        </td>
  
          <th>
            <div>
                <button class="btn btn-danger delete">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
           </th>
  
  
          
           
        <th style="display:none;" class="id">${e.producto_id}</th>
        <td style="display:none;">0</td>
        <td style="display:none;">N</td>

          <td>${e.descripcion1}</td>
          <td>${e.descripcion2}</td>

     </tr> `;
  
        tr.innerHTML = containerChelas;
        tbody.append(tr);
        tr.querySelector('.delete').addEventListener('click', borrarItem);
        tr.querySelector('.btn-primary').addEventListener('click', aumentar);
        tr.querySelector('.btn-dark').addEventListener('click', disminuir);
        actualizarDatos();
        limpiarCampos();
  
      });
    }
  
  }
  

function seleccionar_producto(id) {
        let fila = '#file-prod-' + id;
        let f = $(fila)[0].children;
         console.log(f);
      
    //    let categoria = f[2].innerText;
        let nombre = f[5].innerText;
        let descripcion = f[6].innerText;
        let categoria = f[4].innerText;
        let stock = f[7].innerText;
        let precio_venta = f[9].innerText;
        let precio_compra = f[7].innerText;
      
        toastr.options = {
          "closeButton": true,
          "preventDuplicates": true,
          "positionClass": "toast-top-right",
          "progressBar": true,
        };
      
        if (stock > 0) {
          $('#producto-id').val(id);
          //  $('#producto-codigo').val(categoria);
          $('#producto-nombres').val(nombre);
          $('#producto-stock').val(stock);
          $('#precioventa-producto').val(precio_venta);
          $('#descripcion-producto').val( categoria + ' ' + descripcion);
          $('#preciocompra-producto').val(precio_compra);
      

   
  
        } else {
          toastr["error"]("Producto en stock 0", "Ventas");
      
        }
      
      
      
        $('#btn-borrar').show();
 }