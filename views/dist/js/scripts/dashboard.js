$(function () {

    _init();

    function _init() {
        cargandoDatos();
        cargarventasMensuales();
        cargarGrafica3();
    }

    function cargandoDatos() {
        cantidadUsuarios();
        function cantidadUsuarios() {
            $.ajax({
                url: urlServidor + 'usuario/contar',
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
                        $('#cantidad-usuarios').text(response.cantidad);
                        $('#nombre-usuario').text(response.modelo);
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

        cantidadPaciente();
        function cantidadPaciente() {
            $.ajax({
                url: urlServidor + 'usuario/contarpaciente',
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
                        $('#cantidad-clientes').text(response.cantidad);
                        $('#nombre-clientes').text(response.modelo);
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
/*
        totalcomprasxmes();
        function totalcomprasxmes() {
            $.ajax({
                url: urlServidor + 'compras/totales',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        $('#total-compras').text('$' + response.total);
                        $('#mes-compras').text('Compras' + ' - ' + response.mes);
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
*/
        totalventasxmes();
        function totalventasxmes() {
            $.ajax({
                url: urlServidor + 'ventas/totales',
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
                    //    console.log(response);
                    if (response.status) {
                        $('#total-ventas').text('$' + response.total);
                        $('#ventas-mensuales').text('Ventas' + ' - ' + response.mes);
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

        cantidadProducto();
        function cantidadProducto() {
            $.ajax({
                url: urlServidor + 'producto/cantidadproducto',
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
                    if (response.estado) {
                        $('#conta_producto').text(response.cantidad);
                        $('#nombre-productos').text(response.nombre);
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

        cantidadcitaspendientes();
        function cantidadcitaspendientes() {
          let medico_id = JSON.parse(localStorage.getItem('sesion-2'));

            $.ajax({
                url: urlServidor + 'citas/contar_citaspendiente/'+ medico_id,
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
                    //    console.log(response);
                    if (response.status) {
                        $('#conta_citas').text(response.cantidad);
                        $('#nombre-citas').text(response.modelo);
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

        contarOrdenesImagenesPendientes();
        function contarOrdenesImagenesPendientes() {
            let medico_id = JSON.parse(localStorage.getItem('sesion-2'));
            $.ajax({

                url: urlServidor + 'examenes_imagen/contar_ordenesImagenespendiente/'+ medico_id,
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
                        $('#conta_img_pendiente').text(response.cantidad);
                        $('#nombre-img_pendiente').text(response.modelo);
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
/*
        cantidadMascotas();
        function cantidadMascotas() {
            $.ajax({
                url: urlServidor + 'mascota/cantidad',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    //    console.log(response);
                    if (response.status) {
                        $('#conta_mascota').text(response.cantidad);
                        $('#nombre-mascota').text(response.modelo);
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

        totalCitasPagadasXMes(); 
        function totalCitasPagadasXMes() {
            $.ajax({
                url: urlServidor + 'citas/pagadasXMes',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    //console.log(response);
                    if (response.status) {
                        $('#total-citas-pagadas').text('$' + response.total);
                        $('#mes-citas-pagadas').text('Citas Pagadas de' + ' - ' + response.mes);
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
        
        cantidadCitas();
        function cantidadCitas() {
            $.ajax({
                url: urlServidor + 'citas/cantidadPagadas',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    //    console.log(response);
                    if (response.status) {
                        $('#cantidad-cit').text(response.cantidad);
                        $('#nombre-cit').text(response.modelo);
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

        totalcuentaxpagar();
        function totalcuentaxpagar() {
            $.ajax({
                url: urlServidor + 'cuenta_pagar/totalescuentaxpagar',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        $('#total-cuenta-pagar').text('$' + response.total);
                    //    $('#mes-compras').text('Compras' + ' - ' + response.mes);
                    }
                },
                error: function (jqXHR, status, error) {
                    console.log('Disculpe, existió un problema');
                },
                complete: function (jqXHR, status) {
                    // console.log('Petición realizada');
                }
            });
        } */
    }


        
function cargarventasMensuales() {
    $.ajax({
        // la URL para la petición
        url: urlServidor + 'ventas/graficaventasmensual',
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
        
            if (response.data.length > 0) {
                $('#venta-mes').text(response.anio);
                Highcharts.chart('ventas-mensuales', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Ventas - ' + response.anio
                    },
                    xAxis: {
                        type: 'category',
                        labels: {
                            rotation: -45,
                            style: {
                                fontSize: '13px',
                                fontFamily: 'Verdana, sans-serif',
                                color: '#212529'

                            }
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Cantidad en $'
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    series: [{
                        name: 'Ventas',
                        data: response.data,
                        dataLabels: {
                            enabled: true,
                            rotation: -90,
                            color: '#20c997',
                            align: 'right',
                            format: '{point.y:.2f}', // one decimal
                            y: 10, // 10 pixels down from the top
                            style: {
                                fontSize: '13px',
                                fontFamily: 'Verdana, sans-serif'
                            }
                        }
                    }]
                });
            } else {
                
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


function cargarGrafica3() {
    $.ajax({
        // la URL para la petición
        url: urlServidor + 'producto/graficoStockProductos',
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
            toastr.options = {
                "closeButton": true,
                "preventDuplicates": true,
                "positionClass": "toast-top-right",
            };

            if (response.data.length > 0) {
                Highcharts.chart('productos-stock', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Stock de Productos Por Categoría'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.y}</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.y}'
                            }
                        }
                    },
                    series: [{
                        name: 'Stock',
                        colorByPoint: true,
                        data: response.data
                    }]
                });
            } else {
                toastr["info"]('No hay informacion disponible', "Dashboard");
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


});