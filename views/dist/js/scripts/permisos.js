$(function(){

    _init();

    function _init(){
        cargarRoles();
        cargarMenus();
        getPermisos();
    }

    function cargarRoles(){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'rol/listar',
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
                if(response.status){
                    let option = '<option value=0>Seleccione un Rol</option>';
                    
                    response.rol.forEach(element =>{
                        option += `<option value=${element.id}>${element.rol}</option>`;
                    });
                    $('#select-rol').html(option);
   
                }else{
               
            toastr.options = {
                "closeButton": true,
                "preventDuplicates": true,
                "positionClass": "toast-top-center",
            };
        toastr["error"]("No hay roles disponibles", "Permisos de usuario");
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

    function cargarMenus(){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'permiso/lista',
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
                //console.log(response); 
                $('#body-menus').html('');

                if(response.length > 0){
                    let tr = '';  let fila = '';
                    let inicio = ''; let fin = '';

                    for (let i = 0; i < response.length; i++) {
                        const element = response[i];
                        inicio = `<tr>`;

                        tr = ` <td class="border check-permiso" data-id="${element.padre.id}">
                        <div class="custom-control custom-checkbox" data-id="${element.padre.id}">
                            <input class="custom-control-input" type="checkbox" id="permiso-item-${element.padre.id}" data-id="${element.padre.id}"
                                value="option1" onChange="marcar_permiso(${element.padre.id})">
                            <label for="permiso-item-${element.padre.id}" class="custom-control-label">${element.padre.menu}</label>
                        </div>
                    </td>`;
                        for (let j = 0; j < element.hijos.length; j++) {
                            const item = element.hijos[j];
                            //console.log(item);
                            tr += `<td class="border check-permiso" data-id="${item.id}">
                            <div class="form-check" data-id="${item.id}">
                                <input class="form-check-input" type="checkbox" id="permiso-item-${item.id}" data-id="${item.id}" onChange="marcar_permiso(${item.id})">
                                <label for="permiso-item-${item.id}" class="form-check-label">${item.menu}</label>
                            </div>
                        </td>`; 
                        }
                       
                        fin = `</tr>`;
                        fila = inicio + tr + fin;
                        $('#body-menus').append(fila);
                        //console.log(inicio + tr + fin);
                    }
                    //$('#body-menus').html(fila);
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

    function getPermisos(){
        $('#select-rol').change(function(){
            let id = $('#select-rol').val();
            if(id == '0'){
                clear_check();
            }else{
                ajax_rol_permiso(id);
            }
        })
    }

    function ajax_rol_permiso(id){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'permiso/get/' + id,
            // especifica si será una petición POST o GET
            type : 'GET',
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            success : function(response) {
                let array = document.querySelectorAll('.check-permiso div input');  //38 nodos
                clear_check();
                response.forEach(element => {
                    array.forEach(nodo => {
                        let nodo_id = parseInt(nodo.getAttribute('data-id'));
                        let id = nodo.getAttribute('id');
    
                        if(element.menu_id === nodo_id){
                            $('#' + id).prop('checked',true);
                            nodo.setAttribute('data-permiso', element.id);
                        }
                    });           
                });
            },
            error : function(jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete : function(jqXHR, status) {
                // console.log('Petición realizada');
            }
        });
    }

    function  clear_check(){
        let array = document.querySelectorAll('.check-permiso div input');  //38 nodos

        array.forEach(element => {
            let id = element.getAttribute('id');
            $('#' + id).prop('checked',false);
        });
    }
});

function marcar_permiso(id){
    //alert(id);
    
    let combo_id = $('#select-rol option:selected').val();
  
    toastr.options = {
        "closeButton": true,
        "preventDuplicates": true,
        "positionClass": "toast-top-center",
    };
    if(combo_id == '0'){
      
        toastr.info('Debe seleccionar un rol', 'Permisos de usuario')
       
    }else{
       
        let nodo = document.getElementById('permiso-item-' + id);
        let permiso_id = nodo.getAttribute('data-permiso');

        if(nodo.checked){
            console.log('check activado');
            ajax_permiso(id,'S',permiso_id,combo_id);
        }else{
            console.log('check desactivado');
            ajax_permiso(id,'N',permiso_id,combo_id);
            ajax_rol_permiso(combo_id);
        }
    }
}

function ajax_permiso(menu_id,permiso,permiso_id,rol_id){
    let json = {
        permiso: {menu_id, permiso, permiso_id, rol_id}
    };

    $.ajax({
        // la URL para la petición
        url : urlServidor + 'permiso/otorgar',
        // especifica si será una petición POST o GET
        type : 'POST',
        data : "data=" + JSON.stringify(json),
        // el tipo de información que se espera de respuesta
        dataType : 'json',
        success : function(response) {
           console.log(response);
                          
           toastr.options = {
            "closeButton": true,
            "preventDuplicates": true,
            "positionClass": "toast-top-center",
        };
    toastr["success"]("Permisos asignados", "Permisos de usuario");
        },
        error : function(jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        },
        complete : function(jqXHR, status) {
            // console.log('Petición realizada');
        }
    });

}