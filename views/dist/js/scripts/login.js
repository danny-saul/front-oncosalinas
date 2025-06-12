$(function () {

    _init ();


/*     function _init(){
        let sesion = JSON.parse(localStorage.getItem("sesion"));
        console.log(sesion);
        if (sesion){
            redirigir(sesion.roles_id);

        }else{
            loguear();
        }
    } */

        function _init(){
            let sesion = JSON.parse(localStorage.getItem("sesion"));
            let tokenValido = isTokenValid();

            console.log("Sesión:", sesion);
            console.log("Token válido:", tokenValido);

            if (sesion && tokenValido){
                redirigir(sesion.roles_id);
            } else {
                // Limpia el localStorage si el token está expirado o no existe
                localStorage.removeItem("token");
                localStorage.removeItem("sesion");
                localStorage.removeItem("sesion-2");
                localStorage.removeItem("sesion-3");

                loguear(); // Muestra el formulario de login
            }
        }



    function loguear(){
        $('#btn-loguear').click(function(e) {
            e.preventDefault();

            let usuario = $('#usuario').val();
            let password = $('#password').val();

            let json = {
                "credenciales": {
                    "entrada": usuario,
                    "clave": password
                }
            };

            if(validar(usuario, password)){
                ajax(json);
               console.log(json);
            }else{
                //console.log
            }
           
        });
    }



    
    function ajax(json) {  
        $.ajax({
            url: urlServidor + 'usuario/login',
            data: "data=" + JSON.stringify(json),
            type: 'POST',
            dataType: 'json', 
            success:  (response) => {
               console.log(response);
                if (response.status) {
                    Swal.fire({
                        title: response.mensaje,
                        text: 'Usuario',
                        icon: 'success'
                    })
                     

                    let sesion = response.usuario;
                    let doctor_id = response.doctor;
                    let paciente_id = response.paciente;
    
                    let token = response.token; 


                    localStorage.setItem('token', token);
                    localStorage.setItem('sesion', JSON.stringify(sesion));
                    localStorage.setItem('sesion-2', JSON.stringify(doctor_id));
                    localStorage.setItem('sesion-3', JSON.stringify(paciente_id));
              

                    redirigir(sesion.roles_id);
                } else {
                    Swal.fire({
                        title: response.mensaje,
                        text: 'Usuario',
                        icon: 'error'
                    })
                }
            },
            error: function (xhr, status) {
                console.log('Disculpe, existió un problema');
            },
            complete: function (xhr, status) {
                // console.log('Petición realizada');
            }
        });

    }



    
    function validar(correo, password) {
       
        if (correo == 0) {
            Swal.fire({
                title: 'Ingrese Correo',
                text: 'Login',
                icon: 'Error'
            })
     
            return false;
        } else if (password == 0) {    
            Swal.fire({
                title: 'Ingrese la Contraseña',
                text: 'Login',
                icon: 'Error'
            })
            return false;
        } else {
            return true;
        }
    }



    function redirigir(rol) {
        console.log(rol);
        switch (rol) {
            case 1:
                window.location = urlCliente + 'inicio/citas';
                break;
            case 2:
                window.location = urlCliente + 'gestion/asignarcitas';
                break;
            case 3:
                window.location = urlCliente + 'inicio/citas';
                break;
            case 4:
                    window.location = urlCliente + 'inicio/listarcitas';
                break;
            default:
                window.location = urlCliente + 'login';
                break;
        }
    }



    function isTokenValid() {
            const token = localStorage.getItem("token");
            if (!token) return false;

            try {
                const payload = JSON.parse(atob(token.split('.')[1]));
                const currentTime = Math.floor(Date.now() / 1000);
                return payload.exp > currentTime;
            } catch (error) {
                console.error("Token inválido o corrupto:", error);
                return false;
        }
    }





});