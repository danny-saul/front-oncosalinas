<?php

class ImprimirController
{

    public function ver_receta()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
      //  include_once 'views/contents/consultarcitas.php';
          include_once 'views/contents/verReceta.php';
     
        }else{
            echo 'no hay token por post';
        } 
    }

    public function verInforme()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
   //     include_once 'views/contents/consultarcitas.php';
     
        include_once 'views/contents/verInformePdf.php';
        }else{
            echo 'no hay token por post';
        } 
    }

   
   
}


?>

<script> 
    let token = localStorage.getItem('token');

    //let token = JSON.parse(localStorage.getItem('token'));
  // console.log(token);
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
