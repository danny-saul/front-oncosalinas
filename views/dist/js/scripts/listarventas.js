var tabla;

_init();
function _init() {
    listarventas();
    imprimir();
}

function listarventas() {
   

    tabla = $('#tabla-ventas').DataTable({
        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "ajax":
        {
            url: urlServidor + 'ventas/datatableventa/' ,
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
}


function ver_detalleVenta(id){
    $('#modal-listar').modal('show');

    peticionJWT({
        url:urlServidor  +'ventas/listarventasxid/'+id,
        type:'GET',
        dataType:'json',
        beforeSend: function (xhr) {
            // Envía el token JWT en el encabezado Authorization
            let token = localStorage.getItem('token');
            if (token) {
              xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
          },
        success:function(response){
            let tr = '';
            let tr2 = '';
            console.log(response);
            if(response.status){
            
                $('#detalle-fecha').text(response.venta.fecha); 
                $('#detalle-cliente').text(response.venta.paciente.persona.nombre + ' ' + response.venta.paciente.persona.apellido);
                $('#detalle-usuario').text(response.venta.usuario.persona.nombre + ' ' + response.venta.usuario.persona.apellido);
                $('#detalle-cedula').text(response.venta.paciente.persona.cedula);
                $('#detalle-telefono').text(response.venta.paciente.persona.telefono);
                $('#detalle-total').text(response.venta.total);
                $('#detalle-iva').text(response.venta.iva);
                $('#detalle-subtotal').text(response.venta.subtotal);
                $('#detalle-codigo').text(response.venta.num_venta);
                $('#transaccion-total').text(response.reservaciones.total_parcial);
                
                $('#detalle-proceso').text(response.reservaciones.total_parcial);
                $('#detalle-1').text(response.venta.descripcion1);
                $('#detalle-2').text(response.venta.descripcion2);
                
             

                response.venta.detalle_venta.forEach((element, i) => {
                    tr2 += `<tr>
                                <td style="color: black; display:none; ">${i+1} </td>
                                <td style="color: black;">${element.cantidad}</td>
                                <td style="color: black;">${element.producto.descripcion} - ${element.producto.nombre_producto} </td>
                                <td style="color: black;">${element.total_general}</td>
                             
                            
                            </tr>`;
                });

                let i = 0;
                

                if(response.reservaciones){
                    tr += `<tr>
                    <td>${i+1} </td>
                    <td>Orden ${response.reservaciones.numero_orden} Transaccion Stripe</td>
                     
                    <td>${response.reservaciones.total_parcial}</td>
                   
                </tr>`;
                }

                $('#detalle-productos').html(tr + tr2);

                
                   /*  tr += `<tr>
                                <td style="color: black;">${response.venta.ordenes_servicios.servicios.nombre_servicio}</td>
                       
                                <td style="color: black;">${'$' + response.venta.total_parcial}</td>
                             
                            </tr>`;
           
                $('#detalle-reserva').html(tr); */
            } 
        },
        error : function(jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        },
        complete : function(jqXHR, status) {
            // console.log('Petición realizada');
        }
    });
}



function imprimir() {
    $('#btn-imprimir').click(function () {
  
      let element = document.getElementById('imprimir');
  
      let opt = {
        margin: 0.5,
        filename: 'facturaimprimir.pdf',
        image: { type: 'jpeg', quality: 3 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'legal', orientation: 'portrait' }
      };
      html2pdf().set(opt).from(element).save();
    });
  }
  