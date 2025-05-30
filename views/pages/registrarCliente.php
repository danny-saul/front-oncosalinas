<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Header de login -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?=BASE?>/views/plugins/loginp/fonts/icomoon/style.css">
    <link rel="stylesheet" href="<?=BASE?>/views/plugins/loginp/css/owl.carousel.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=BASE?>/views/plugins/loginp/css/bootstrap.min.css">
    <!-- Style -->
    <link rel="stylesheet" href="<?=BASE?>/views/plugins/loginp/css/style.css">
</head>


<body>


    <div class="half">
        <div class="bg order-1 order-md-2"
            style="background-image: url('<?=BASE?>/views/plugins/loginp/images/bg_1.jpg');"></div>
        <div class="contents order-2 order-md-1">

            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12">
                        <div class="form-block">
                            <div class="text-center mb-5">
                                <h3><strong>Lubricentro GP - Registrese</strong></h3>
                                <!-- <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p> -->
                            </div>
                            <form class="form-horizontal" method="POST" id="form-registro-usuario-cliente">
                                <div class="card-body">
                                    <div class="row ">

                                        <div class="col-12 col-md-4 form-group">
                                            <label for="">Ingrese la cédula</label>
                                            <input id="cliente-cedula" type="text" name="cedula" class="form-control"
                                                maxlength="10" minlength="5">
                                        </div>
                                        <div class="col-12 col-md-4 form-group">
                                            <label for="">Ingrese el Nombre</label>
                                            <input id="cliente-nombre" type="text" name="nombre" class="form-control">
                                        </div>
                                        <div class="col-12 col-md-4 form-group">
                                            <label for="">Ingrese el Apellido</label>
                                            <input id="cliente-apellido" type="text" name="apellido" class="form-control">
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-12 col-md-4 form-group">
                                            <label for="">Ingrese el Correo</label>
                                            <input id="cliente-correo" type="text" name="correo" class="form-control">
                                        </div>

                                        <div class="col-12 col-md-4 form-group d-none">
                                            <label for="cliente-rol">Seleccione el Rol </label>
                                            <input type="hidden" id="id-rol">
                                            <input id="cliente-rol" type="texr" readonly name="rol" class="form-control">
                                        </div>
                                        <div class="col-12 col-md-4 form-group d-none">
                                            <button class="btn btn-primary mb-2" style="margin-top: 31px; width:209px"
                                                data-toggle="modal" data-target="#modal-rol" data-backdrop="static"
                                                data-keyboard="false">
                                                <i class="fas fa-search"></i> Busque el rol</button>
                                        </div>

                                        <div class="col-12 col-md-4 form-group">
                                            <label for="">Ingrese Telefono</label>
                                            <input id="cliente-telefono" type="text" name="telefono" class="form-control"
                                                maxlength="10" minlength="5">
                                        </div>
                                        <div class="col-12 col-md-4 form-group">
                                            <label for="">Ingrese la Dirección</label>
                                            <input id="cliente-direccion" type="text" name="direccion"
                                                class="form-control">
                                        </div>

                                    </div>

                          

                                    <div class="row ">

                                        <div class="col-12 col-md-6 form-group">
                                            <label for="">Ingrese la contraseña</label>
                                            <input id="cliente-password1" type="password" name="password1"
                                                class="form-control">
                                        </div>
                                        <div class="col-12 col-md-6 form-group">
                                            <label for="">Confirme la Contraseña</label>
                                            <input id="cliente-password2" type="password" name="password2"
                                                class="form-control">
                                        </div>


                                    </div>

                                </div>
                                <div class="form-group row">
                                    <!-- <i class="fas fa-save mr-2"></i> -->
                                    <button style="margin-top: 18px;"  
                                        class="btn btn-block btn-outline-primary">Guardar</button>
                                </div>
                            </form>
                            <a href="login">
                            <div class="form-group row ">
                                <!-- <i class="fas fa-save mr-2"></i> -->
                               <button style="margin-top: 18px;"  
                                    class="btn btn-block btn-outline-primary">Ir a Login</button>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer de login -->

    <script src="<?=BASE?>/views/plugins/loginp/js/jquery-3.3.1.min.js"></script>
    <script src="<?=BASE?>/views/plugins/loginp/js/popper.min.js"></script>
    <script src="<?=BASE?>/views/plugins/loginp/js/bootstrap.min.js"></script>
    <script src="<?=BASE?>/views/plugins/loginp/js/main.js"></script>

</body>

</html>
<script src="<?=BASE?>views/dist/js/scripts/registrar_usuario_cliente.js"> </script>
<!-- <script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script> -->