<?php

class ClienteController
{

    public function dashboard_cliente()
    {
        $dataPost = isset($_POST['data']);

        if(!$dataPost) {
            //  include_once 'views/contents/consultarcitas.php';
            include_once 'views/contents/dashboard_cliente.php';
     
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
        window.location = urlCliente + 'login';
        
    }
</script>
