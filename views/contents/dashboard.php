<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Administrador </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Administrador</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="cantidad-usuarios" class="text-dark">0</h3>
                        <p id="nombre-usuario" class="text-white">Usuarios</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?=BASE?>gestion/registrarpacientes" class="small-box-footer">Ver Mas <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="cantidad-clientes" class="text-dark">0</h3>

                        <p id="nombre-clientes" class="text-white"></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <a href="<?=BASE?>gestion/listarpacientes" class="small-box-footer">Ver Mas <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="total-compras">0</h3>
                        <p id="mes-compras" class="text-white">Compras Mensuales </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cart-arrow-down"></i>
                    </div>
                    <a href="#" class="small-box-footer">Ver Mas <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="total-ventas" class="text-dark">0</h3>
                        <p id="mes-ventas" class="text-white">Ventas Mensuales</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-comments-dollar"></i>
                    </div>
                    <a href="#" class="small-box-footer">Ver Mas <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3 id="conta_producto" style="color: white;">0</h3>
                        <p id="nombre-productos" style="color: white;"> </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <a href="<?=BASE?>productos/listarproductos" class="small-box-footer">Ver Más <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-gray">
                    <div class="inner">
                        <h3 id="conta_citas">0</h3>
                        <p id="nombre-citas" style="color: white;"> </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-microscope"></i>
                    </div>
                    <a href="<?=BASE?>inicio/citas" class="small-box-footer">Ver Más <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3 id="conta_img_pendiente"><sup style="font-size: 20px"></sup>0</h3>
                        <p id="nombre-img_pendiente" style="color: white;"> </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <a href="<?=BASE?>examenes/imagenes" class="small-box-footer">Ver Más <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="total-cuenta-pagar">0</h3>
                        <p id="" style="color: white;">Citas Atendidas </p>
                        
                    </div>
                    <div class="icon">
                        <i class="fas fa-cart-arrow-down"></i>
                    </div>
                    <a href="#" class="small-box-footer">Ver Mas <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-12 col-md-6 text-center">
                <div class="mt-3">
                    <div class="card card-dark shadow-lg">
                        <div class="card-header">
                            <h5>Ventas - Mensuales <b id="mes-ventas"></b> </h5>
                        </div>
                        <div class="card-body">
                            <div id="ventas-mensuales"></div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12 col-md-6 text-center">
                <div class="mt-3">
                    <div class="card card-dark shadow-lg">
                        <div class="card-header">
                            <h5>Stock de Productos Por Categoría</h5>
                        </div>
                        <div class="card-body">
                            <div id="productos-stock"></div>
                        </div>
                    </div>
                </div>
            </div>

 

        </div>




    </div>
</div>
</div>

<script src="<?=BASE?>views/plugins/morris/raphael-min.js"></script>
<script src="<?=BASE?>views/plugins/morris/morris.min.js"></script>

<script src="<?=BASE?>views/plugins/html2pdf/html2pdf.bundle.js"></script>
<script src="<?=BASE?>views/plugins/chart.js/Chart.min.js"></script>
<script src="<?=BASE?>views/plugins/higchart/highcharts.js"></script>
<script src="<?=BASE?>views/plugins/higchart/modules/exporting.js"></script>
<script src="<?=BASE?>views/plugins/higchart/modules/export-data.js"></script>
<script src="<?=BASE?>views/plugins/higchart/modules/accessibility.js"></script>

<script src="<?=BASE?>views/plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script>


<script src="<?= BASE ?>views/dist/js/scripts/peticionJWT.js"></script>

<script src="<?=BASE?>views/dist/js/scripts/dashboard.js"></script>