$(function(){

    _init();

    function _init(){
        cargar_factura();
        imprimir_orden();
        storage_citas();
    }

    function storage_citas() {
        let id = localStorage.getItem('citas_id');
      
        $.ajax({
          // la URL para la petición
          url: urlServidor + 'citas/listarcitasxid/' + id,
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
              $('#cita-id').text(response.citas.id);
              $('#citas-id').val(response.citas.id);
     
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
      

    function cargar_factura(){
        let citas_id = localStorage.getItem('citas_id');
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'citas/listarcitasxid/' + citas_id,
            // especifica si será una petición POST o GET
            type : 'GET',
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            beforeSend: function(xhr) {
              // Envía el token JWT en el encabezado Authorization
              let token = localStorage.getItem('token');
              if (token) {
                  xhr.setRequestHeader('Authorization', 'Bearer ' + token);
              }
          },
            success : function(response) {
                console.log(response);
                let tr = '';
                let tr2 = '';
                   if(response.status){
              let img_sello2 = response.citas.doctor.img_sello;

              $('#receta-paciente').text(response.citas.paciente.persona.nombre + ' ' + response.citas.paciente.persona.apellido);
              $('#receta-medico').text(response.citas.doctor.persona.nombre + ' ' + response.citas.doctor.persona.apellido);
              $('#receta-cedula').text(response.citas.paciente.persona.cedula );
              $('#receta-fecha').text(response.citas.fecha );

               let img =  `<img src="${urlServidor}sellos/sellos/${img_sello2}" alt="User Image" style=" width: 250px; margin-left: -26px;">`;
               $('#sello-img').html(img);

             
                      let i = 0;
                    response.citas.receta.forEach((element, i) => {
                        tr += `<tr>
                     
                        <td>${element.producto.nombre_producto} ${element.frecuencia.tipo_frecuencia} ${element.duracion} | ${element.observacion}</td>
                        <td>${element.cantidad}</td>
                        <td>VIA ORAL</td>
                
                    </tr>`;
                    });

                    if(response.orden){
                        tr += `<tr>
                        <td>${i+1} </td>
                        <td>Orden ${response.orden.codigo}</td>
                        <td>1</td>
                        <td>${response.orden.suma}</td>
                        <td>${response.orden.suma}</td>
                    </tr>`;
                    }
                    $('#body-receta').html(tr+tr2);
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

 /*    function imprimir_orden(){
        $('#btn-imprimir').click(function(){
            let element = document.getElementById('imprimir-receta');
            let opt = {
            margin:       1,
            filename:     'receta.pdf',
            image:        { type: 'jpeg', quality: 2.5 },
            html2canvas:  { scale: 1 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            // New Promise-based usage:
            html2pdf().set(opt).from(element).save();
                    });
    } */

    function imprimir_orden() {
      $('#btn-imprimir').click(function () {
          let element = document.getElementById('imprimir-receta');
  
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
  

});