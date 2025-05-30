
  <?php

require_once 'conf/base.php';
require_once 'conf/controller.php';

require_once 'views/layouts/header.php';

if(count($_GET) == 0){
    require_once 'views/pages/loginv2.php';
}else
if(isset($_GET['url']) && $_GET['url'] == 'login'){
    require_once 'views/pages/loginv2.php';
}else
if(isset($_GET['url']) && $_GET['url'] == 'registrarCliente'){
    require_once 'views/pages/registrarCliente.php';
}else
if(isset($_GET['url']) && $_GET['url'] == 'index'){
    require_once 'views/pages/page_corsano/index.php';
}else
if(isset($_GET['url']) && $_GET['url'] == 'about'){
    require_once 'views/pages/page_corsano/about.php';
}else
if(isset($_GET['url']) && $_GET['url'] == 'services'){
    require_once 'views/pages/page_corsano/services.php';
}else
if(isset($_GET['url']) && $_GET['url'] == 'contact'){
    require_once 'views/pages/page_corsano/contact.php';
}else
if(isset($_GET['url']) && $_GET['url'] == 'index2'){
    require_once 'views/pages/index2.php';
}else{
    $controller = new Controller();

    if(!$controller->procesar()){
        //pagina de error 404
        require_once 'views/pages/404.php';
    }else{
        require_once 'views/layouts/navbar.php';
        require_once 'views/layouts/asidebar.php';
        
        $controller->include();
        require_once 'views/layouts/asidebar_rigth.php';
    } 

}

require_once 'views/layouts/footer.php';



//require_once 'views/pages/404.php';


