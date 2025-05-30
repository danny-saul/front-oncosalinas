$(function(){
    let sesion = localStorage.getItem('sesion');
    // console.log(sesion);
    
    if(sesion == null){
        $(location).attr('href', urlCliente + 'login');
    }
});