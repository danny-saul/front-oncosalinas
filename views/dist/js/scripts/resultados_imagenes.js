var tabla;



_init();
function _init() {
    dt_listarresultadosxmedico2();
    imprimir_orden();
}

function dt_listarresultadosxmedico2() {

 //   let medico_id = JSON.parse(localStorage.getItem('sesion-2'));

    tabla = $('#tabla-resultados').DataTable({
        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "ajax":
        {
            url: urlServidor + 'examenes_imagen/listarresultadosconcluidos/' ,
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


function ver_informe(id){
    generarPDF();
}

/* function ver_informe(id) {
    let idorden = id;
    console.log(idorden);


    peticionJWT({
        url: urlServidor + 'listar_ordenesPdf/' + idorden,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
           console.log(response);
        },
        error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        },
        complete: function (jqXHR, status) {
            // console.log('Petición realizada');
        }
    });
} */

  /*   $('#modal-detalle-resultados').modal('show');


    peticionJWT({
        url: urlServidor + 'ordenes/listar_ordenes/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            //let tr = '';
            console.log(response);
            generarInformePdf();
            if (response.status) {
                $('#num-id').text(response.orden.id);
                $('#num-orden').text(response.orden.numero_orden);

                $('#apellidos').text(response.orden.citas.paciente.persona.apellido);
                $('#nombres').text(response.orden.citas.paciente.persona.nombre);
                $('#cedula').text(response.orden.citas.paciente.persona.cedula);
                $('#apellidos').text(response.orden.citas.paciente.persona.apellido);
                $('#sexo').text(response.orden.citas.paciente.persona.sexo.tipo);
                $('#fecha-nacimiento').text(response.orden.citas.paciente.persona.fecha_nacimiento);

                $('#medico').text(response.orden.doctor.persona.apellido + ' ' + response.orden.doctor.persona.nombre);

                $('#profesional-nombres').text(response.orden.doctor.persona.apellido + ' ' + response.orden.doctor.persona.nombre);
                $('#fecha').text(response.orden.fecha);
                //  $('#detalle-imagenologia').text(response.orden.informe); 
                $('#detalle-hallazgos').text(response.orden.informe);
                $('#detalle-conclusiones').text(response.orden.conclusion);

                $('#fecha-img').text(response.orden.fecha);
                $('#apellidos-img').text(response.orden.doctor.persona.apellido);
                $('#nombres-img').text(response.orden.doctor.persona.nombre);
                $('#cedula-img').text(response.orden.doctor.persona.cedula);
                $('#telefono-img').text(response.orden.doctor.persona.telefono);

                let img_sello2 = response.orden.doctor.img_sello;
                let img = `<img src="${urlServidor}sellos/sellos/${img_sello2}" alt="User Image" style=" width: 250px; margin-left: -26px;">`;
                $('#sello-img').html(img);


                /*     response.detalle_venta.forEach((element, i) => {
                        tr += `<tr>
                                    <td style="color: black;">${i+1} </td>
                                    <td style="color: black;">${element.producto.nombre}</td>
                                    <td style="color: black;">${element.cantidad}</td>
                                    <td style="color: black;">${element.precio_venta}</td>
                                    <td style="color: black;">${element.total}</td>
                                </tr>`;
                    });
                    $('#body_detalle_venta').html(tr); 
            }
        },
        error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        },
        complete: function (jqXHR, status) {
            // console.log('Petición realizada');
        }
    }); */




function imprimir_orden() {
    $('#btn-imprimir').click(function () {
        let element = document.getElementById('imprimir-informe');

        // Ajustar el tamaño de la página a A4
        let opt = {
            margin: 1,
            filename: 'receta.pdf',
            image: { type: 'jpeg', quality: 2.5 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
        };

        // New Promise-based usage:
        html2pdf().set(opt).from(element).save();
    });
}


async function generarPDF() {
    // Definir la estructura del documento
    var docDefinition = {
        content: [
          /*   {
                alignment: 'center',
            //    image: 'data:image/png;base64,<BASE64_ENCODED_IMAGE>', // Reemplaza <BASE64_ENCODED_IMAGE> con tu imagen en base64
                width: 80
            }, */
            {
                text: 'DENTAL MAX TEAM',
                style: 'header'
            },
            {
                text: 'Barrio San Francisco Calle 10 Entre Avenidas 8 y 9 La Libertad - Ecuador',
                style: 'subheader'
            },
            {
                text: '0978640033 - 0981324662',
                style: 'subheader'
            },
            {
                text: 'INFORME MEDICO',
                style: 'title'
            },
            {
                text: 'A.- DATOS DEL ESTABLECIMIENTO Y USUARIO / PACIENTE',
                style: 'subheader'
            },
            {
                table: {
                    widths: ['*', '*', '*', '*', '*'],
                    body: [
                        ['INSTITUCION DEL SISTEMA', 'CODIGO', 'ESTABLECIMIENTO DE SALUD', 'N HISTORIA CLINICA', 'ID'],
                        ['DENTAL MAX TEAM', '0001', 'DENTAL MAX TEAM', '0001', '0001']
                        // Agrega más filas según sea necesario con los datos del paciente
                    ]
                }
            },
            // Agrega más secciones de la misma manera
        ],
        styles: {
            header: {
                fontSize: 16,
                bold: true,
                margin: [0, 10, 0, 10]
            },
            subheader: {
                fontSize: 14,
                margin: [0, 5, 0, 5]
            },
            title: {
                fontSize: 18,
                bold: true,
                margin: [0, 10, 0, 10]
            }
            // Define más estilos según sea necesario
        }
    };

    // Generar el PDF
    pdfMake.createPdf(docDefinition).open();

    //pdfmake.createPdf(docDefinition).download("informe_medico.pdf");
}



/* 
async function generarInformePdf() {
    // Definir el contenido del informe médico con un logo local
    var content = [
        { image: 'views/dist/img/logoclinica.avif', width: 200, alignment: 'center', margin: [0, 0, 0, 20] },
        { text: 'Informe Médico', style: 'header' },
        { text: 'Paciente: Juan Pérez', style: 'subheader' },
        { text: 'Fecha: 1 de marzo de 2024', style: 'subheader' },
        { text: 'Diagnóstico:', style: 'subheader' },
        'El paciente presenta los siguientes síntomas:',
        { text: ' - Fiebre persistente', margin: [20, 0, 0, 0] },
        { text: ' - Dolor de cabeza', margin: [20, 0, 0, 0] },
        { text: ' - Tos seca', margin: [20, 0, 0, 0] },
        { text: 'Recomendaciones:', style: 'subheader' },
        {
            ul: [
                'Tomar medicamentos según indicaciones del médico.',
                'Descansar adecuadamente.',
                'Beber abundantes líquidos.',
            ]
        },
    ];

    // Definir los estilos del documento
    var styles = {
        header: {
            fontSize: 22,
            bold: true,
            alignment: 'center',
            margin: [0, 0, 0, 20]
        },
        subheader: {
            fontSize: 18,
            bold: true,
            margin: [0, 15, 0, 5]
        }
    };

    // Crear el documento PDF
    var docDefinition = {
        content: content,
        styles: styles,
        images: {
            'views/dist/img/logoclinica.avif': 'base64_encoded_logo_here'
        }
    };

    // Generar el PDF
    pdfMake.createPdf(docDefinition).open();


} */


function ver_informe2(id) {
    let idorden = id;
    console.log(idorden);
    printPDF();
    peticionJWT({
        url: urlServidor + 'ordenes/listar_ordenes/' + id,
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
            //let tr = '';
            console.log(response);
          //  generarInformePdf();
          
            if (response.status) {
                $('#num-id').text(response.orden.id);
                $('#num-orden').text(response.orden.numero_orden);

                $('#apellidos').text(response.orden.citas.paciente.persona.apellido);
                $('#nombres').text(response.orden.citas.paciente.persona.nombre);
                $('#cedula').text(response.orden.citas.paciente.persona.cedula);
                $('#apellidos').text(response.orden.citas.paciente.persona.apellido);
                $('#sexo').text(response.orden.citas.paciente.persona.sexo.tipo);
                $('#fecha-nacimiento').text(response.orden.citas.paciente.persona.fecha_nacimiento);

                $('#medico').text(response.orden.doctor.persona.apellido + ' ' + response.orden.doctor.persona.nombre);

                $('#profesional-nombres').text(response.orden.doctor.persona.apellido + ' ' + response.orden.doctor.persona.nombre);
                $('#fecha').text(response.orden.fecha);
                //  $('#detalle-imagenologia').text(response.orden.informe); 
                $('#detalle-hallazgos').text(response.orden.informe);
                $('#detalle-conclusiones').text(response.orden.conclusion);

                $('#fecha-img').text(response.orden.fecha);
                $('#apellidos-img').text(response.orden.doctor.persona.apellido);
                $('#nombres-img').text(response.orden.doctor.persona.nombre);
                $('#cedula-img').text(response.orden.doctor.persona.cedula);
                $('#telefono-img').text(response.orden.doctor.persona.telefono);

                let img_sello2 = response.orden.doctor.img_sello;
                let img = `<img src="${urlServidor}sellos/sellos/${img_sello2}" alt="User Image" style=" width: 250px; margin-left: -26px;">`;
                $('#sello-img').html(img);


                /*     response.detalle_venta.forEach((element, i) => {
                        tr += `<tr>
                                    <td style="color: black;">${i+1} </td>
                                    <td style="color: black;">${element.producto.nombre}</td>
                                    <td style="color: black;">${element.cantidad}</td>
                                    <td style="color: black;">${element.precio_venta}</td>
                                    <td style="color: black;">${element.total}</td>
                                </tr>`;
                    });
                    $('#body_detalle_venta').html(tr); 
                    */

           
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

 
