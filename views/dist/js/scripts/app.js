init();

function init() {
  datos();
  inicializar_Menu();
  cerrar_Sesion();
}


function obtener_Sesion() {
  let sesion = JSON.parse(localStorage.getItem('sesion'));

  if (sesion) {
    return sesion;

  } else {
    return null;
  }
}

/* function inicializar_Menu() {
  let sesion = JSON.parse(localStorage.getItem('sesion'));

  if (sesion) {
    let rol_id = sesion.roles.id;

    $.ajax({
      url: urlServidor + 'permiso/rol/' + rol_id,
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        if (response) {
          let padre = ''; let i = 1;

          response.forEach(element => {
            let li = '';
            element.menus_hijos.forEach(hijo => {
              li += `<li class="nav-item">
                                      <a href="${urlCliente}${hijo.url}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p class="text-light">${hijo.nombre}</p>
                                      </a>
                                    </li>`;
            });

            if (i == 0) {
              padre += `<li class="nav-item menu-open">
                                          <a href="#" class="nav-link">
                                            <i class="${element.icono} mr-2"></i>
                                            <p class="text-light">
                                              ${element.nombre}
                                              <i class="right fas fa-angle-left"></i>
                                            </p>
                                          </a>
                                          <ul class="nav nav-treeview">
                                              ${li}
                                          </ul>
                                        </li>`;
            } else {
              padre += `<li class="nav-item">
                                          <a href="#" class="nav-link">
                                            <i class="${element.icono} mr-2"></i>
                                            <p class="text-light">
                                              ${element.nombre}
                                              <i class="right fas fa-angle-left"></i>
                                            </p>
                                          </a>
                                          <ul class="nav nav-treeview">
                                              ${li}
                                          </ul>
                                        </li>`;
            }
            i++;
          });
          $('#menu_rol').html(padre);
        };
      },
      error: function (xhr, status) {
        console.log('Disculpe, existió un problema');
      },
      complete: function (xhr, status) {
        // console.log('Petición realizada');
      }
    });
  }
}
 */





function inicializar_Menu() {
  let sesion = JSON.parse(localStorage.getItem('sesion'));

  if (sesion) {
    let rol_id = sesion.roles.id;

    $.ajax({
      url: urlServidor + 'permiso/rol/' + rol_id,
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        if (response) {
          let padre = ''; let i = 1;

          response.forEach(element => {
            let li = '';
            element.menus_hijos.forEach(hijo => {
              li += `<li class="nav-item">
                                      <a href="${urlCliente}${hijo.url}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p class="text-dark">${hijo.nombre}</p>
                                      </a>
                                    </li>`;
            });

            if (i == 0) {
              padre += `<li class="nav-item menu-open">
                                          <a href="#" class="nav-link">
                                            <i class="${element.icono} mr-2"></i>
                                            <p class="text-dark">
                                              ${element.nombre}
                                              <i class="right fas fa-angle-left"></i>
                                            </p>
                                          </a>
                                          <ul class="nav nav-treeview">
                                              ${li}
                                          </ul>
                                        </li>`;
            } else {
              padre += `<li class="nav-item">
                                          <a href="#" class="nav-link">
                                            <i class="${element.icono} mr-2"></i>
                                            <p class="text-dark">
                                              ${element.nombre}
                                              <i class="right fas fa-angle-left"></i>
                                            </p>
                                          </a>
                                          <ul class="nav nav-treeview">
                                              ${li}
                                          </ul>
                                        </li>`;
            }
            i++;
          });
          $('#menu_rol').html(padre);

          // Animación del submenú
          $('.nav-item > a').click(function (e) {
            var $this = $(this);

            // Si el enlace tiene un submenú, desplegamos o cerramos el submenú
            if ($this.next('.nav-treeview').length) {
              if ($this.next('.nav-treeview').is(":visible")) {
                $this.next('.nav-treeview').slideUp(300);
                $this.find('.right').removeClass('fa-angle-down').addClass('fa-angle-left');
              } else {
                $('.nav-treeview').slideUp(300); // Cierra todos los submenús
                $this.next('.nav-treeview').slideDown(300); // Abre el submenú actual
                $('.nav-item > a .right').removeClass('fa-angle-down').addClass('fa-angle-left'); // Cierra los iconos
                $this.find('.right').removeClass('fa-angle-left').addClass('fa-angle-down'); // Cambia el icono
              }
              e.preventDefault(); // Evita que el enlace navegue si es un submenú
            }
          });

          // Mantener funcionalidad de selección de enlaces
          $('.nav-item > a').on('click', function (e) {
            const href = $(this).attr('href');
            const hasSubmenu = $(this).next('.nav-treeview').length;
          
            if (!hasSubmenu) {
              if (href && !href.startsWith('#')) {
                window.location.href = href;
              } else {
                // Si es un href="#algo", permitimos el comportamiento normal (tabs, anclas)
                e.preventDefault(); // Esto puede ser opcional dependiendo del caso
              }
            }
          });
          
        };
      },
      error: function (xhr, status) {
        console.log('Disculpe, existió un problema');
      },
      complete: function (xhr, status) {
        // console.log('Petición realizada');
      }
    });
  }
}

function datos() {
  let sesion = obtener_Sesion();
 // console.log(sesion);
  if (sesion) {
    let nombres = sesion.persona.nombre + ' ' + sesion.persona.apellido;
    let nombres2 = sesion.persona.nombre + ' ' + sesion.persona.apellido;
    let imagen = sesion.imagen;
     let img =  `<img src="${urlServidor}fotos/usuarios/${imagen}" class="img-circle elevation-2" alt="User Image">`;
     let img2 =  `<img src="${urlServidor}fotos/usuarios/${imagen}" class="img-circle elevation-2" alt="User Image" with="70px" height="80px" style="margin-top: 22px;margin-inline: 65px;">`;
 //    let img3 =  `<img src="${urlServidor}fotos/usuarios/${imagen}" class="img-circle elevation-2" alt="User Image" with="50px" height="45px" style="margin-top: -14px;margin-inline: 0px;">`;
   
     let rol = sesion.roles.rol;
    let usuario = sesion.usuario;

    $('#sesion-usuario').html(nombres);
    $('#nombre-usuario').html(nombres2);
  //  console.log(sesion);
    $('#sesion-img').html(img);
    $('#sesion-img2').html(img2);
 //   $('#sesion-img3').html(img3);
    $('#sesion-rol').html(rol);
    $('#rol').html(rol);
    $('#usuario').html(usuario);
    $('#usuario2').html(usuario);




  }
}


function cerrar_Sesion() {
  $('#sesion-logout').click(function () {
     
    Swal.fire({
      title:'Sesion Finalizada',
      text: 'Login',
      icon: 'info'
  })

  
  
     localStorage.clear();
  //  sessionStorage.clear();
    window.location = urlCliente + 'login';
  });

}