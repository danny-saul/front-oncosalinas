 <div class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0">Nueva Venta</h1>
             </div>
             <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-right">
                     <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                     <li class="breadcrumb-item active">Nueva Venta</li>
                 </ol>
             </div>
         </div>
     </div>
 </div>

 <div class="content">
     <div class="container-fluid">
         <div class="row">
             <div class="col-12">



                 <div class="callout callout-info">
                     <h7> Buscar Cliente:</h7>
                     <div class="row">

                         <div class="col-12 col-md-3 form-group">
                             <label for="" class=""> .</label>

                             <button data-toggle="modal" data-target="#modal-ver-clientes" data-backdrop="static"
                                 data-keyboard="false" class="btn btn-outline-primary btn-block">
                                 Buscar Cliente</button>

                         </div>




                     </div>

                 </div>


                 <div class="callout callout-info">
                     <h7> Buscar Productos:</h7>
                     <div class="row">

                         <div class="col-12 col-md-3 form-group">
                             <label for="" class=""> .</label>

                             <button data-toggle="modal" data-target="#modal-ver-producto" data-backdrop="static"
                                 data-keyboard="false" class="btn btn-outline-primary btn-block form-control-sm">
                                 Buscar Producto</button>

                         </div>
                         <div class="col-12 col-md-5 form-group">
                             <label for="">Nombre del Producto</label>
                             <input type="hidden" name="" id="producto-id">

                             <input type="text" class="form-control form-control-sm danger letras-vd" maxlength="150"
                                 minlength="4" id="producto-nombres" readonly required>
                         </div>
                         <div class="col-12 col-md-1 form-group">
                             <label for="">Stock</label>
                             <input type="text" class="form-control form-control-sm danger numero-vd"
                                 id="producto-stock" readonly required>
                         </div>
                         <div class="col-12 col-md-2 form-group">
                             <label for="">Ingrese la cantidad</label>
                             <input id="producto-cantidad" type="text"
                                 class="form-control form-control-sm solo-numeros">
                         </div>



                     </div>
                     <div class="row">


                         <div class="col-12 col-md-5 form-group">
                             <label for="">Descripción</label>
                             <input type="text" class="form-control form-control-sm danger letras-vd" maxlength="150"
                                 minlength="4" id="descripcion-producto" readonly required>
                         </div>
                         <div class="col-12 col-md-2 form-group">
                             <label for="">P. Compra</label>
                             <input type="text" class="form-control form-control-sm danger numero-vd"
                                 id="preciocompra-producto" readonly required>
                         </div>
                         <div class="col-12 col-md-2 form-group">
                             <label for="">P. Venta</label>
                             <input id="precioventa-producto" type="text" class="form-control form-control-sm" readonly>
                         </div>

                         <div class="col-12 col-md-3 form-group">
                             <label for="" class=""> .</label>

                             <button type="button" id="agregar-producto"
                                 class="btn btn-outline-primary btn-block form-control-sm">
                                 Agregar Producto <i class="fas fa-plus mr-2"></i></button>

                         </div>




                     </div>

                     <div class="row">
                         <div class="col-12 col-md-6 form-group">
                             <label for="">Descripcion</label>
                             <textarea class="form-control form-control-sm " rows="3"
                                 placeholder="Ingrese la descripcion " id="descripcion-1"></textarea>
                         </div>
                         <div class="col-12 col-md-6 form-group">
                             <label for="">Descripcion</label>
                             <textarea class="form-control form-control-sm " rows="3"
                                 placeholder="Ingrese la descripcion" id="descripcion-2"></textarea>
                         </div>
                     </div>
                 </div>


                 <div class="invoice p-3 mb-3" id="imprimir-venta">

                     <div class="row">
                         <div class="col-12">
                             <h4>
                                 <i class="fas fa-globe"></i> <?=NOMBRE_EMPRESA?>
                                 <small class="float-right" id="num-consulta">Numero de Venta: </small> <br>
                                 <small class="float-right" id="fecha-o"> <?=date('d-m-Y')?></small>
                             </h4>


                         </div>

                     </div>

                     <div class="row invoice-info">
                         <div class="col-sm-4 invoice-col">

                             <address>
                                 <input type="hidden" name="" id="cliente-id">
                                 Nombre del Cliente: <strong id="nombres-apellidos"> </strong><br>
                                 Cedula: <strong id="cedula"> </strong><br>
                                 Telefono: <strong id="telefono"> </strong><br>
                                 Dirección: <strong id="direccion"> </strong><br>
                             </address>
                         </div>

                         <div class="col-sm-4 invoice-col">

                             <address>
                                 <strong></strong><br>

                             </address>
                         </div>

                         <div class="col-sm-4 invoice-col">
                             <b>Código: </b><span id="orden-codigo"></span><br>

                             <b>Orden ID:</b> <span id="orden-id"></span><br>
                             <b>Fecha:</b><span id="orden-fecha"></span><br>
                             <b> Usuario: </b> <span id="usuario-nombre"></span><br>

                         </div>

                     </div>

                     <div class="row">
                         <div class="col-12 table-responsive">
                             <table class="table table-striped">
                                 <thead>
                                     <tr>
                                         <th>Cantidad</th>
                                         <th>Producto</th>
                                         <th>Descripción</th>
                                         <th>Precio</th>
                                         <th>Total</th>
                                         <th>Editar</th>
                                         <th>Eliminar</th>
                                         <th style="display:none;">Id</th>
                                         <th style="display:none;">Orden Reservación</th>
                                         <th style="display:none;">Reservación ID</th>
                                         <th style="display:none;">Reservación ID</th>
                                         <th>Descripcion 1</th>
                                         <th>Descripcion 2</th>
                                     </tr>
                                 </thead>
                                 <tbody id="productos-agregados">


                                 </tbody>
                             </table>
                         </div>

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
                                         <th style="width:50%">Subtotal:</th>
                                         <td id="orden-subtotal">$</td>
                                     </tr>
                                     <tr>
                                         <th>IVA (12%)</th>
                                         <td id="orden-iva">$</td>
                                     </tr>
                                     <tr>
                                         <th>Descuento:</th>
                                         <td id="orden-descuento">0</td>
                                     </tr>
                                     <tr>
                                         <th>Total:</th>
                                         <td id="orden-total">$</td>
                                     </tr>
                                 </table>
                             </div>
                         </div>

                     </div>

                 </div>
                 <div class="row no-print">
                     <div class="col-12">

                         <button id="guardar-venta" class="btn btn-success float-right"><i
                                 class="far fa-credit-card"></i>
                             Guardar Datos
                         </button>
                         <!--     <button id="btn-imprimir" class="btn btn-primary float-right" style="margin-right: 5px;">
                            <i class="fas fa-download"></i> Generar PDF
                        </button> -->
                     </div>
                 </div>

             </div>
         </div>
     </div>
 </div>
 </div>



 <!-- Modales -->
 <div class="modal fade" id="modal-ver-producto" data-backdrop="static">
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header bg-dark">
                 <h4 class="modal-title">Productos - Repuestos</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <div class="row">
                     <div class="col-12">
                         <div class="form-group">
                             <label for="">Buscar Producto</label>
                             <input id="buscar-prod" type="text" class="form-control"
                                 placeholder="Ingrese codigo o nombre de un Producto">
                         </div>
                     </div>
                 </div>
                 <div class="row" style="height: 300px !important; overflow: auto;">
                     <div class="col-12">
                         <div class="tabla-buscar-producto">
                             <table class="table table-hover text-nowrap">
                                 <thead>
                                     <tr>
                                         <th>#</th>
                                         <th>Imagen</th>
                                         <th>Codigo</th>
                                         <th>Categoria</th>
                                         <th>Nombre</th>
                                         <th>Descripción</th>
                                         <th>Stock</th>
                                         <th>Precio de V</th>
                                         <th>OK</th>
                                     </tr>
                                 </thead>
                                 <tbody id="producto-body">

                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="modal-footer justify-content-between">
             </div>
         </div>
         <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
 </div>



 <!-- Modales -->
 <div class="modal fade" id="modal-ver-clientes">
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header bg-dark">
                 <h4 class="modal-title">Listar Clientes</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">

                 <div class="row" style="height: 425px !important; overflow: auto;">
                     <div class="col-12">

                         <table id="tabla-listar-clientes" class="table table-hover text-nowrap">
                             <thead>
                                 <tr>
                                     <th style="width: 10px">#</th>

                                     <th>Cédula</th>
                                     <th>Nombres</th>
                                     <th>Teléfono</th>
                                     <th>Dirección</th>
                                     <th>Seleccionar</th>
                                 </tr>
                             </thead>
                             <tbody>
                         </table>

                     </div>
                 </div>
             </div>
             <div class="modal-footer justify-content-between">
             </div>
         </div>
         <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
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
 <script src="<?=BASE?>views/dist/js/scripts/registro_nuevaVenta.js"></script>