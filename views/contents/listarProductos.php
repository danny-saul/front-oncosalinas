<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Listar Producto</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Listar Producto</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
 
        <div class="row">
            <div class="col-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Listado de Productos</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="div" style="overflow: auto;">
                            <table id="tabla-producto" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Imagen</th>
                                        <th>Código de Producto</th>
                                        <th>Categoría</th>
                                        <th>Nombre de Producto</th>
                                        <th>Descripción</th>
                                        <th>Presentación</th>
                                        <th>Stock</th>
                                        <th>Marca</th>
                                        <th>Precio Venta</th>
                                        <th>Precio Compra</th>
                                        <th>Botones</th>
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



 


<!-- Modal EDITAR de Producto -->

<div class="modal fade" id="modal-editar-producto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Editar Producto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="contanier-fluid">
                    <!--   <form> -->

                    <div class="row">

                        <div class="form-group col-12 col-md-4">
                            <label>Seleccione la Categoría </label>
                            <select class="form-control" id="editar-categoria"></select>
                        </div>
                         <div class="form-group col-12 col-md-4">
                            <label>Ingrese el Código de Producto</label>
                            <input type="hidden" class="form-control " id="id-Producto">

                            <input type="text" class="form-control " readonly id="editar-codigo-Producto">
                        </div> 
                        <div class="form-group col-12 col-md-4">
                            <label>Ingrese el Nombre de Producto</label>
                            <input type="text" class="form-control solo-letras" id="editar-nombre-Producto">
                        </div>


                    </div>

                    <div class="row">

                        <div class="form-group col-12 col-md-6">
                            <label>Ingrese la Descripción del Producto </label>
                            <textarea class="form-control" id="editar-descripcion-Producto"></textarea>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label>Seleccione la Presentación del Producto</label>
                            <select class="form-control" id="editar-presentacion"></select>

                        </div>
                        <div class="form-group col-12 col-md-2">
                            <label>Ingrese el Stock</label>
                            <input type="text" class="form-control solo-numeros" id="stock-editar">
                        </div>


                    </div>

                    <div class="row">

                        <div class="form-group col-12 col-md-2">
                            <label>P. de compra </label>
                            <input type="text" class="form-control " id="precioCompra-editar">
                        </div>
                        <div class="form-group col-12 col-md-2">
                            <label>P. de venta</label>
                            <input type="text" class="form-control " id="precioVenta-editar">

                        </div>
                     


                    </div>

                    <!-- /.card-body -->

                    <!--     <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div> -->
                    <!--    </form> -->
                    <div class="row">
                        <div class="col-12 form-group text-right">
                            <button class="btn btn-primary" id="btn-editar-Producto" type="button">
                                <i class="fas fa-save mr-2"></i>Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between"> </div>
        </div>
    </div>
</div>


<!-- MODAL AGREGAR STOCK -->
<div class="modal fade" id="modal-agregar-stock" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Agregar Stock a Productos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="contanier-fluid">
                    <input type="hidden" id="producto-stock-id">
                    <form method="POST" id="update-productos">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Stock Actual</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control solo-numeros" readOnly placeholder="Stock Actual"
                                    id="stock-ac-p">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Agregar Stock</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control solo-numeros" placeholder="Stock Nuevo" id="upd-stock-p">
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-12 form-group text-right">
                            <button class="btn btn-dark" id="btn-update-stock" type="button">
                                <i class="fas fa-plus mr-2"></i>Asignar</button>
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

<script src="<?=BASE?>views/plugins/validacion/jquery.validate.js"></script>
<script src="<?=BASE?>views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/jszip/jszip.min.js"></script>
<script src="<?=BASE?>views/plugins/pdfmake/pdfmake.min.js"></script>

<script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script>
<script src="<?=BASE?>views/dist/js/scripts/listar_Productos.js"></script>

