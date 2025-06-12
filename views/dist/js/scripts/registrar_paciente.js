$(function () {

    _init();


    function _init() {
        guardarUsuario();
        cargarSexo();
        cargarRol();
        preview_img();
    }


    function guardarUsuario() {
        $('#nuevo-usuario').submit(function (e) {
            e.preventDefault();
    
            let roles_id = 3;
            let cedula = $('#nuevo-cedula').val();
            let nombre = $('#nuevo-nombre').val();
            let apellido = $('#nuevo-apellido').val();
            let telefono = $('#nuevo-telefono').val();
            let celular = $('#nuevo-celular').val();
            let fecha_nacimiento = $('#nuevo-fecha').val();
            let direccion = $('#nuevo-direccion').val();
            let sexo_id = $('#nuevo-genero option:selected').val();
            let operadora_id = $('#nuevo-operadora option:selected').val();
            let tipo_cobertura_id = $('#nuevo-cobertura option:selected').val();
            let tipo_seguro_id = $('#nuevo-tipo-seguro option:selected').val();
            let usuario = $('#new-usuario').val();
            let responsable = $('#nuevo-responsable').val();
            let password = $('#nuevo-password').val();
            let password2 = $('#nuevo-password2').val();
            let correo = $('#nuevo-correo').val();
            let imagen = $('#img-usuario')[0].files[0];
            let def = (imagen == undefined) ? 'userdefault.png' : imagen.name; 
            let imagen_cedula = $('#img-cedula')[0].files[0];
            let def1 = (imagen_cedula == undefined) ? 'SINCEDULA.pdf' : imagen_cedula.name; 
    
    
            let json = {
                usuario: {
                    roles_id,
                    usuario,
                    correo,
                    password,
                    password2,
                    imagen: def,
                    imagen_cedula: def1
                },
                persona: {
                    cedula,
                    nombre,
                    apellido,
                    telefono,
                    direccion,
                    sexo_id,
                    responsable,
                    tipo_cobertura_id,
                    tipo_seguro_id,
                    operadora_id,
                    fecha_nacimiento,
                    celular
                },
                doctor: {
    
                },
                cliente: {
    
                },
            };
            console.log(json);
            guardandousuario(json);
            
            //console.log(json);
            //validacion para datos de usuario
         /*    if (!validarPersona(json)) {
                toastr["error"]("Debe llenar los campos de Usuario")
                console.log('llene los datos de usuario');
            } else {
                if (valor == true) {
                    //toastr["error"]("No validar cedula");
                    guardandousuario(json);
    
    
                } else {
                    if (validarcedula(cedula)) {
                      //  toastr["info"]("Cedula Correcta");
                        guardandousuario(json);
    
                    } else {
                        toastr["error"]("La Cedula no es valida");
    
                    }
                }
            } */
        });
    }
    
    function guardandousuario(json) {
        peticionJWT({
            url: urlServidor + 'paciente/guardar',
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
            
    
                if (response.status) {
                    Swal.fire({
                        title: response.mensaje,
                        text: 'Usuario',
                        icon: 'success'
                    })
              
            
                    $('#nuevo-usuario')[0].reset();
                    setTimeout(function () {
                        location.reload();
                      }, 1000); 
                  //  cargarTabla();
                   // $('#modal-registro-usuario').modal('hide');
                } else {
                    Swal.fire({
                        title: response.mensaje,
                        text: 'Usuario',
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
    
         if (json.usuario.imagen == 'userdefault.png') {
    
        } else {
            let imagen = $('#img-usuario')[0].files[0];
            let formData = new FormData();
            formData.append('fichero', imagen);
    
            peticionJWT({
                // la URL para la petición
                url: urlServidor + 'paciente/fichero',
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
                    if (responseImg.status) {
    
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

          if (json.usuario.imagen_cedula == 'SINCEDULA.pdf') {
    
        } else {
            let imagen_cedula = $('#img-cedula')[0].files[0];
            let formData = new FormData();
            formData.append('fichero', imagen_cedula);
    
            peticionJWT({
                // la URL para la petición
                url: urlServidor + 'paciente/fichero2',
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
                    if (responseImg.status) {
    
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

/*     function cargarSexo() {
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
                    $('#nuevo-genero').html(option);
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
    function cargarSexo() {
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
                console.log(response);
                if (response.status) {
                    let data = response.sexo.map(element => ({
                        id: element.id,
                        text: element.tipo
                    }));
    
                    $('#nuevo-genero').select2({
                        data: data,
                       
                    });
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
    
    
     function cargarRol() {
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
                console.log(response);

                 if (response.status) {
                    let option = '<option value="0">Seleccione Rol</option>';
                    response.rol.forEach(element => {
                        option += `<option value=${element.id}>${element.rol} </option>`;
                    });
                    $('#nuevo-rol').html(option);
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

    function preview_img(){
        $('#img-usuario').change(function(){
            readImage(this);
            $('#imagen-usuario').removeClass('d-none');
        });
    }

    function readImage(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#imagen-usuario').attr('src', e.target.result); // Renderizamos la imagen
          }
          reader.readAsDataURL(input.files[0]);
        }
    }





});