<body class="sidebar-mini sidebar-collapse" style="height: auto;">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light"
            style="background-color: #ffffff; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <!-- Menu toggle -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" role="button">
                        <i class="fas fa-bars" style="color: #333;"></i>
                    </a>
                </li>
                <!-- Home link -->
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link" style="color: #333;">
                        Home
                    </a>
                </li>
                <!-- Contact link -->
                <li class="nav-item d-none d-sm-inline-block">
                    <a class="nav-link" style="color: #333;">
                        Contact
                    </a>
                </li>

                 <!-- Mensaje de advertencia con cronómetro -->
   <li class="nav-item d-none d-sm-inline-block">
    <span class="nav-link text-danger font-weight-bold" style="color: red;">
        ¡Su suscripción caduca en <span id="contador-suscripcion">cargando...</span>!
        Cancele su pago y evite interrupciones.
    </span>
</li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- User account dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                      <i class="fas fa-user-circle" style="font-size: 1.5em;"></i> 
                 <!--       <div class="media" id="sesion-img3">
                                         
                                    </div> -->
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a class="dropdown-item">
                            <!-- Información del usuario -->
                            <div class="media">
                                <div class="col-6">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title" id="nombre-usuario">
                                            <span class="float-right text-sm text-muted"><i
                                                    class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm" id="rol"></p>
                                        <p class="text-sm text-muted" id="usuario">
                                            <i class="fas fa-power-off mr-1"></i>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="media" id="sesion-img2">
                                        <!-- Aquí se cargará la imagen del usuario dinámicamente -->
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a role="button" id="sesion-logout" class="dropdown-item dropdown-footer"
                            style="color: #dc3545;">
                            <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                        </a>
                    </div>
                </li>


            </ul>
        </nav>
        <!-- /.navbar -->

        <style>
        /* Animación para el submenú */
        .nav-treeview {
            display: none;
            padding-left: 10px;
            transition: all 0.3s ease;
        }

        /* Efecto hover sobre los items del menú */
        .nav-item:hover {
            background-color: #f4f6f9;
            transition: background-color 0.2s ease;
        }

        .nav-link {
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: #17a2b8;
            /* Color al pasar el mouse */
        }

        /* Transición de altura suave para el menú */
        .menu-open>.nav-treeview {
            display: block;
            padding-left: 20px;
        }


        .media-body {
            max-width: 180px;
            word-wrap: break-word;
        }

        #sesion-img2 img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #17a2b8;
        }
        </style>

<script>
function actualizarContadorDesdeBaseJS() {
    const fechaVencimiento = new Date(FechaVencimientoSistema).getTime();
    const ahora = new Date().getTime();
    const tiempoRestante = fechaVencimiento - ahora;

    if (tiempoRestante <= 0) {
        document.getElementById("contador-suscripcion").innerText = "00:00:00";
        return;
    }

    const dias = Math.floor(tiempoRestante / (1000 * 60 * 60 * 24));
    const horas = Math.floor((tiempoRestante % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutos = Math.floor((tiempoRestante % (1000 * 60 * 60)) / (1000 * 60));
    const segundos = Math.floor((tiempoRestante % (1000 * 60)) / 1000);

    document.getElementById("contador-suscripcion").innerText =
        `${dias} dias ${horas} horas ${minutos} minutos ${segundos} segundos`;
}

setInterval(actualizarContadorDesdeBaseJS, 1000);
</script>
