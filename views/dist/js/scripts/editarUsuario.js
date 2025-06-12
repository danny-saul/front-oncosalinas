init();

function init() {
    recuperarsexo();
    recuperartipocobertura();
    recuperartipooperadora();
    recuperartiposeguro();
    recuperarrol();
    editar_usuario2();
    editandousuariol();
}

 
function recuperarsexo() {
    peticionJWT({
        url: urlServidor + 'sexo/listar',
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
            //console.log(response);
            if (response.status) {
                let option = '<option value="0">Seleccione Sexo</option>';
                response.sexo.forEach(element => {
                    option += `<option value=${element.id}>${element.tipo}</option>`;
                });
                $('#editar-genero').html(option);
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

function recuperartipocobertura() {
    peticionJWT({
        url: urlServidor + 'tipo_cobertura/listar',
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
                let option = '<option value="0">Seleccione Cobertura</option>';
                response.tipo_cobertura.forEach(element => {
                    option += `<option value=${element.id}>${element.detalle_tipo_cobertura}</option>`;
                });
                $('#editar-cobertura').html(option);
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

function recuperartipooperadora() {
    peticionJWT({
        url: urlServidor + 'tipo_cobertura/listaroperadora',
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
            //console.log(response);
            if (response.status) {
                let option = '<option value="0">Seleccione Operadora</option>';
                response.tipo_operadora.forEach(element => {
                    option += `<option value=${element.id}>${element.detalle_operadora}</option>`;
                });
                $('#editar-operadora').html(option);
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


function recuperartiposeguro() {
    peticionJWT({
        url: urlServidor + 'tipo_cobertura/listartiposeguro',
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
                let option = '<option value="0">Seleccione Tipo Seguro</option>';
                response.tipo_seguro.forEach(element => {
                    option += `<option value=${element.id}>${element.detalle_Seguro}</option>`;
                });
                $('#editar-tipo-seguro').html(option);
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

function recuperarrol() {
    peticionJWT({
        url: urlServidor + 'rol/listar',
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
            //console.log(response);
            if (response.status) {
                let option = '<option value="0">Seleccione el Rol</option>';
                response.rol.forEach(element => {
                    option += `<option value=${element.id}>${element.rol}</option>`;
                });
                $('#editar-rol').html(option);
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


function editar_usuario2() {
    let id = localStorage.getItem('usuario_id');
    console.log(id);
 

    peticionJWT({
        url: urlServidor + 'usuario/listarusuid/' + id, // Cambia la URL según tu configuración de rutas en Laravel
        type: 'GET',
        dataType: 'json',
        beforeSend: function(xhr) {
            // Envía el token JWT en el encabezado Authorization
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function(response) {
            console.log(response);
     //       console.log(response.usuario.persona.sexo_id);
            let nombre_usuario = response.usuario.usuario;
            console.log(nombre_usuario);
            if (response.status) {
                
                $('#id-usuario').val(response.usuario.id);
                $('#id-persona').val(response.usuario.persona.id);
                $('#editar-nombre').val(response.usuario.persona.nombre);
                $('#editar-apellido').val(response.usuario.persona.apellido);
                $('#editar-cedula').val(response.usuario.persona.cedula);
                $('#editar-fecha').val(response.usuario.persona.fecha_nacimiento);
                $('#editar-telefono').val(response.usuario.persona.telefono);
                $('#editar-celular').val(response.usuario.persona.celular);
                $('#editar-correo').val(response.usuario.correo);
                $('#editar-direccion').val(response.usuario.persona.direccion);
                $('#editar-usuario2').val(nombre_usuario);



                

                $('#editar-genero').val(response.usuario.persona.sexo.id);
                $('#editar-cobertura').val(response.usuario.persona.tipo_cobertura.id);//nombre_del_rol
                $('#editar-rol').val(response.usuario.roles.id);//nombre_del_rol
                $('#editar-operadora').val(response.usuario.persona.operadora.id);//nombre_del_rol
                $('#editar-tipo-seguro').val(response.usuario.persona.tipo_seguro.id);//nombre_del_rol

                
                 // Obtener el PDF asociado al usuario
                 obtenerPDF('cedulas', response.usuario.imagen_cedula);

            } else {
           

            }
        },
        error: function(xhr, status, error) {
            // Si hay un error en la solicitud AJAX
            console.error(xhr.responseText);
  
        }
    });


    function obtenerPDF(disk, file) {
        peticionJWT({
            url: urlServidor + 'cedulas/' + disk + '/' + file,
            type: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // Crear una URL para el blob recibido
                    var url = URL.createObjectURL(response);
    
                    // Mostrar el PDF en el contenedor
                    $('#pdf-container').html('<iframe src="' + url + '" type="application/pdf" width="190%" height="900px" />');
                };
                reader.readAsArrayBuffer(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Manejar el error de la solicitud AJAX
                alert('Error al obtener el PDF. Por favor, inténtalo de nuevo más tarde.');
            }
        });
    }
    
    
    
    
    
    
    

/*     // Realiza la solicitud AJAX para obtener la información del usuario y el PDF asociado
    peticionJWT({
        url: urlServidor + 'usuario/listarusuid/' + id, // Ruta hacia el método en el controlador Laravel
        method: 'GET',
        success: function(response) {
            if (response.status) {
                var usuario = response.usuario;
                var pdfPath = response.pdf_path;

                // Muestra la información del usuario en la consola
                console.log(usuario);

                // Si hay un PDF asociado, abre una nueva pestaña y muestra el PDF en un visor
                if (pdfPath) {
                    var nuevaVentana = window.open('', '_blank');
                    nuevaVentana.document.write('<embed src="' + pdfPath + '" width="100%" height="100%">');
                } else {
                    alert('No se encontró el PDF asociado.');
                }
            } else {
                alert('No se pudo obtener la información del usuario.');
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Error al obtener la información del usuario.');
        }
    }); */


    
}

/* function cargarUsuario(id){
    peticionJWT({
        url: urlServidor + 'usuario/listarusuid/' + id, // Cambia la URL según tu configuración de rutas en Laravel
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response.status) {

        /*         $('#editar-genero').val(response.usuario.persona.sexo.id);
                $('#editar-rol').val(response.usuario.roles.rol);//nombre_del_rol */



                // Si la respuesta es exitosa y hay un PDF disponible
             /*    if (response.pdf_content) {
                    // Decodificar el contenido del PDF de base64
                    var pdfData = atob(response.pdf_content);
                    // Crear un objeto Blob desde el contenido del PDF
                    var pdfBlob = new Blob([pdfData], { type: 'application/pdf' });
                    // Crear una URL para el objeto Blob
                    var pdfUrl = URL.createObjectURL(pdfBlob);
                    // Mostrar el PDF en el visor
                    $('#pdf-embed').attr('src', a);
                } else {
                    // Si no hay PDF disponible
                    $('#pdf-container').html('<p>No se encontró el PDF para este usuario.</p>');
                } 
            } else {
                // Si la respuesta indica que no hay datos
              //  $('#pdf-container').html('<p>No se encontraron datos para este usuario.</p>');
            }
        },
        error: function(xhr, status, error) {
            // Si hay un error en la solicitud AJAX
            console.error(xhr.responseText);
        //    $('#pdf-container').html('<p>Ocurrió un error al cargar el PDF.</p>');
        }
    });
} */

/* function recuperarsexo() {
    peticionJWT({
        url: urlServidor + 'sexo/listar',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            //    console.log(response);
            if (response.status) {
                let option = '<option value="0">Seleccione Sexo</option>';
                response.sexo.forEach(element => {
                    option += `<option value=${element.id}>${element.tipo}</option>`;
                });
                $('#editar-genero').html(option);
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





function editandousuariol() {
    $('#editar-usuario').submit(function (e) {
        e.preventDefault();

        let id = $('#id-usuario').val();//usuario_id
        let persona_id = $('#id-persona').val();
        let usuario = $('#editar-usuario2').val();//nombre_usuario
        let correo = $('#editar-correo').val();//correo_usuario
        let nombre = $('#editar-nombre').val();
        let apellido = $('#editar-apellido').val();
        let responsable = $('#editar-responsable').val();
        let telefono = $('#editar-telefono').val();
        let cedula = $('#editar-cedula').val();
        let celular = $('#editar-celular').val();
        let fecha_nacimiento = $('#editar-fecha').val();
        let direccion = $('#editar-direccion').val();
        let sexo_id = $('#editar-genero option:selected').val();//sexo_id
        let tipo_cobertura_id = $('#editar-cobertura option:selected').val();//sexo_id
        let tipo_seguro_id = $('#editar-tipo-seguro option:selected').val();//sexo_id
        let operadora_id = $('#editar-operadora option:selected').val();//sexo_id
        let roles_id = $('#editar-rol option:selected').val();//sexo_id
 

        let json = {
            usuario: {
                id: id,
                persona_id: persona_id,
                roles_id: roles_id,
                usuario: usuario,
                correo: correo,
                tipo_seguro_id:tipo_seguro_id,
                nombre: nombre,
                operadora_id:operadora_id,
                cedula: cedula,
                tipo_cobertura_id:tipo_cobertura_id,
                celular: celular,
                apellido: apellido,
                responsable:responsable,
                fecha_nacimiento:fecha_nacimiento,
                telefono: telefono,
                direccion: direccion,
                sexo_id: sexo_id,
 
            }
        };

        peticionJWT({
            // la URL para la petición
            url: urlServidor + 'usuario/editar',
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
                /*  console.log(response); */
           

                if (response.status) {
                    Swal.fire({
                        title: "Listo !",
                        text: response.mensaje,
                        icon: 'success'
                    })
                   
                    $('#editar-usuario').val('');
                    
                } else {
                    Swal.fire({
                        title: "Errpr !",
                        text: response.mensaje,
                        icon: 'error'
                    })
                  
                }
            },
            error: function (jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete: function (jqXHR, status) {
                // console.log('Petición realizada');
            }
        });
    });
}
