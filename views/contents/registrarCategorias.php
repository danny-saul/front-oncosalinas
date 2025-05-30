<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Medico</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Registrar Categoría</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-8">

                <div>
                    <button class="btn btn-secondary btn-lg mb-2" data-toggle="modal"
                        data-target="#modal-registro-categoria" data-backdrop="static" data-keyboard="false">Registrar
                        Categoría
                    </button>
                </div>

                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Listado de Categorías</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabla-categorias" class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nombre de Categoría</th>
                                    <th>Botones</th>
                                </tr>
                            </thead>
                            <tbody id="body-categoria">

                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right" id="boton-paginacion-categoria">

                        </ul>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>
</div>

<!-- Modal registro de categoria -->

<div class="modal fade" id="modal-registro-categoria">
    <div class="modal-dialog modal-bg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Registrar Categoría</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="contanier-fluid">
                    <!--   <form> -->
                    <div class="card-body">
                        <div class="form-group">
                            <label>Ingrese el Nombre de Categoría</label>
                            <input type="text" class="form-control solo-letras" id="registro-categoria">
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <!--     <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div> -->
                    <!--    </form> -->
                    <div class="row">
                        <div class="col-12 form-group text-right">
                            <button class="btn btn-primary" id="btn-guardar-categoria" type="button">
                                <i class="fas fa-save mr-2"></i>Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between"> </div>
        </div>
    </div>
</div>


<!-- Modal registro de categoria -->

<div class="modal fade" id="modal-editar-categoria">
    <div class="modal-dialog modal-bg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Editar Categoría</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="contanier-fluid">
                    <!--   <form> -->
                    <div class="card-body">
                        <div class="form-group">
                            <label>Ingrese el Nombre de Categoría</label>
                            <input type="hidden" class="form-control" id="id-categoria">

                            <input type="text" class="form-control solo-letras" id="editar-categoria">
                        </div>
                    </div>
                  
                    <div class="row">
                        <div class="col-12 form-group text-right">
                            <button class="btn btn-primary" id="btn-editar-categoria" type="button">
                                <i class="fas fa-save mr-2"></i>Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between"> </div>
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
<script src="<?=BASE?>views/plugins/pdfmake/pdfmake.min.js"></script>

<!-- <script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script> -->
<script src="<?=BASE?>views/dist/js/scripts/registro_Categoria.js"></script> 