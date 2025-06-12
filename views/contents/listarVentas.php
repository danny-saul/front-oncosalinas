<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Listar Ventas</h1>
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
        <div class="row mt-3">
            <div class="col-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Listar Ventas</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="div" style="overflow: auto;">
                            <table id="tabla-ventas" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Fecha</th>
                                        <th>Numero de Venta</th>
                                        <th>Cedula</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<!-- Modal para finalizar comprar-->
<div class="modal fade" id="modal-listar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalle de la Venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="imprimir">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h4 class="font-bold"><?= APLICACION ?></h4>
                        </div>
                    </div>

                    <div cldetalle-compraass="row">
                        <div class="col-12 w-100 text-center d-flex">
                            <span class="font-weight-bold mr-2">Numero Venta:</span>
                            <span id="detalle-codigo"> </span>
                        </div>

                        <div class="col-12 w-100 text-center d-flex">
                            <span class="font-weight-bold mr-2">Cliente:</span>
                            <span id="detalle-cliente"> </span>
                        </div>
                        <div class="col-12 w-100 text-center d-flex">
                            <span class="font-weight-bold mr-2">Cedula:</span>
                            <span id="detalle-cedula"> </span>
                        </div>
                        <div class="col-12 w-100 text-center d-flex">
                            <span class="font-weight-bold mr-2">Telefono:</span>
                            <span id="detalle-telefono"> </span>
                        </div>

                        <div class="col-12 w-100 text-center d-flex">
                            <span class="font-weight-bold mr-2">Fecha:</span>
                            <span id="detalle-fecha"> </span>
                        </div>

                        <div class="col-12 w-100 text-center d-flex">
                            <span class="font-weight-bold mr-2">Usuario Responsable:</span>
                            <span id="detalle-usuario"> </span>
                        </div>


                        <div class="col-12">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th style="display:none;" scope="col">#</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Descripcion</th>
                                        <th scope="col">Total Parcial $</th>

                                    </tr>
                                </thead>
                                <tbody id="detalle-productos">

                                </tbody>
                            </table>
                        </div>


                        <div class="row">

                            <div class="col-6">

                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">

                                </p>
                            </div>

                            <div class="col-6">


                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>Transaccion Abonado: (-)</th>
                                            <td id="transaccion-total"> 0</td>
                                        </tr>
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td id="detalle-subtotal">$</td>
                                        </tr>
                                        <tr>
                                            <th>IVA (0%)</th>
                                            <td id="detalle-iva">$</td>
                                        </tr>

                                        <!--    <tr>
                                            <th>Descuento:</th>
                                            <td id="orden-descuento">0</td>
                                        </tr>
                                       -->
                                        <tr>
                                            <th>Saldo Total a pagar</th>
                                            <td id="detalle-total">$</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>

                             <div class="col-12 w-100 text-center d-flex">
                                <span class="font-weight-bold mr-2">Descripcion:</span>
                                <span id="detalle-1"> </span>
                            </div>
                            <div class="col-12 w-100 text-center d-flex">
                                <span class="font-weight-bold mr-2">Medidas:</span>
                                <span id="detalle-2"> </span>
                            </div>


                        </div>


                        <!--  <div class="col-12 my-3">
                            <div class="w-100 mt-5 row">
                                <div class="col-12 w-100 text-center d-flex">
                                    <span class="font-weight-bold mr-2">Subtotal: $ </span>
                                    <span id="detalle-subtotal"></span>
                                </div>
                                <div class="col-12 w-100 text-center d-flex">
                                    <span class="font-weight-bold mr-2">Iva: $ </span>
                                    <span id="detalle-iva"></span>
                                </div>
                                <div class="col-12 w-100 text-center d-flex">
                                    <span class="font-weight-bold mr-2">Descuento: $ 0 </span>
                                    <span id=""></span>
                                </div>

                                <div class="col-12 w-100 text-center d-flex">
                                    <span class="font-weight-bold mr-2">Total a pagar: $ </span>
                                    <span id="detalle-total"></span>
                                </div>




                                <div class="w-100 text-center mt-3">
                                    <span class="loader d-none" id="spiner"></span>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn-imprimir">Imprimir</button>
            </div>
        </div>
    </div>
</div>


<script src="<?=BASE?>views/plugins/validacion/jquery.validate.js"></script>
<script src="<?=BASE?>views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/jszip/jszip.min.js"></script>
<script src="<?=BASE?>views/plugins/html2pdf/html2pdf.bundle.js"></script>
<script src="<?=BASE?>views/plugins/pdfmake/pdfmake.min.js"></script>

<script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script>

<script src="<?= BASE ?>views/dist/js/scripts/peticionJWT.js"></script>

<script src="<?=BASE?>views/dist/js/scripts/listarventas.js"></script>