<?php

class GestionController
{

    public function RegistrarUsuario()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
     //   include_once 'views/contents/consultarcitas.php';
     include_once 'views/contents/registrarUsuario.php';
     
        }else{
            echo 'no hay token por post';
        } 
    }
    public function RegistrarPacientes()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
        //include_once 'views/contents/consultarcitas.php';
        include_once 'views/contents/registrarPaciente.php';
     
        }else{
            echo 'no hay token por post';
        } 
    }
    public function AsignarCitas()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
      //  include_once 'views/contents/consultarcitas.php';
        include_once 'views/contents/agendarCitas.php';
     
        }else{
            echo 'no hay token por post';
        } 
    }
    public function Horarios()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
       // include_once 'views/contents/consultarcitas.php';
       include_once 'views/contents/misHorarios.php';
     
        }else{
            echo 'no hay token por post';
        } 
    }
    public function atendercitas()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
      //  include_once 'views/contents/consultarcitas.php';
        include_once 'views/contents/atendercitas.php';
     
        }else{
            echo 'no hay token por post';
        } 
    }
    public function ListarUsuarios()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
     //   include_once 'views/contents/consultarcitas.php';
        include_once 'views/contents/listarusuarios.php';
     
        }else{
            echo 'no hay token por post';
        } 
    }
    public function listarpacientes()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
      //  include_once 'views/contents/consultarcitas.php';
      include_once 'views/contents/listarPacientes.php';
     
        }else{
            echo 'no hay token por post';
        } 
    }

    public function atenderCitas2()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
      //  include_once 'views/contents/consultarcitas.php';
      include_once 'views/contents/guardaratencion.php';
     
        }else{
            echo 'no hay token por post';
        } 
    }

    public function permisos()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
      //  include_once 'views/contents/consultarcitas.php';
      include_once 'views/contents/gestionpermisos.php';
     
        }else{
            echo 'no hay token por post';
        } 
    }


    public function atenderCitas3()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
      //  include_once 'views/contents/consultarcitas.php';
      include_once 'views/contents/atenderCitas7.php';
     
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
