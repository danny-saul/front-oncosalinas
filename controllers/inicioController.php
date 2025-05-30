<?php

class InicioController
{
    public function dashboard()
    {

        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
        include_once 'views/contents/dashboard.php';
     
        }else{
            echo 'no hay token por post';
        }    
        
      /*   // Enrutador
        $request_uri = $_SERVER['REQUEST_URI'];
        $route = explode('/', $request_uri);
    
        // Dependiendo de la ruta, se llama al controlador y método correspondientes
        switch ($route[1]) {
            case '':
                // Si la ruta está vacía, se redirige al dashboard
                header("Location: /dashboard");
                break;
            case 'dashboard':
                // Se llama al método dashboard del controlador InicioController
                $controller = new InicioController();
                $controller->dashboard();
                break;
            default:
                // Si la ruta no coincide con ninguna ruta definida, se muestra un error 404
                header("HTTP/1.0 404 Not Found");
                echo 'Error 404: Página no encontrada';
                break;
        } */
    }
    


 /*    public function dashboard()
    {
        include_once 'views/contents/dashboard.php';
    } */

    public function recepcion()
    {

        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
        include_once 'views/contents/recepcion.php';
     
        }else{
            echo 'no hay token por post';
        }   
    }   


    public function listarcitas()
    {

        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
        include_once 'views/contents/listarcitas.php';
     
        }else{
            echo 'no hay token por post';
        }   
    }  


    public function citas()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
        include_once 'views/contents/consultarcitas.php';
     
        }else{
            echo 'no hay token por post';
        } 
    }

    public function citasatendidas()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
    //    include_once 'views/contents/consultarcitas.php';
        include_once 'views/contents/citas_atendidas.php';
     
        }else{
            echo 'no hay token por post';
        } 
    }

    public function editarcitas()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
    //include_once 'views/contents/consultarcitas.php';
       include_once 'views/contents/editarCitas.php';
     
        }else{
            echo 'no hay token por post';
        } 
    }

    public function crearCita()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
    //include_once 'views/contents/consultarcitas.php';
       include_once 'views/contents/crearCitas.php';
     
        }else{
            echo 'no hay token por post';
        } 
    }

    public function citascanceladas()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
    //    include_once 'views/contents/consultarcitas.php';
        include_once 'views/contents/citas_canceladas.php';
     
        }else{
            echo 'no hay token por post';
        } 
    }
   
}

?>

<script> 
    let token = localStorage.getItem('token');

    //let token = JSON.parse(localStorage.getItem('token'));
   //console.log(token);
  // alert(token);
    if(token !== null){//si hay token 
   //     alert('mi token '+ token)
        $.ajax({
           type: "POST",
           url: urlCliente + 'inicio/dashboard',         
           data:  {data: token},
           success: function(data) {
              //$('#output').html(data);
              //alert(data);
           }
        });
    }else{//no hay token y nunca ingresa a la ruta
    //    alert('no hay token');
        window.location = urlCliente + 'views/pages/404.php';
        
    }
</script>
