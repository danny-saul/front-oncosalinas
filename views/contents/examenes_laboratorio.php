<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Medico </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Estudios Laboratorio</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-dark d-flex p-0">
                <h3 class="card-title p-3 card-dark">Examenes de Laboratorio</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Laboratorio
                        </a></li>

                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="div" style="overflow: auto;">
                            <table id="tabla-pendientes" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 5px">#</th>
                                        <th># Orden</th>
                                        <th>Fecha</th>
                                        <th>Paciente</th>
                                        <th>Medico</th>
                                        <!--   <th>Especialidad</th> -->
                                        <!--  <th>Hora</th>
                                        <th>Fecha</th> -->
                                        <th>Estado</th>
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




<!-- MODAL EDITAR -->
<div class="modal fade" id="modal-editar-orden">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Laboratorio </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="contanier-fluid">
                    <!-- //  <form id="actualizar-orden" method="POST"> -->
                    <div class="row">



                        <div class="col-12">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Procedimiento Clinico</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove"
                                            title="Remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    Paciente: <span id="estudio-paciente"> </span> <br>
                                    Examen de Laboratorio: <span id="estudio-lab"> </span> <br>
                                    Fecha: <span id="fecha-lab"> </span> <br>
                                    # DE ORDEN: <span id="numorden-lab"> </span> <br>
                                    Medico que envia el Procedimiento: <span id="estudio-doctor"> </span>


                                    <input type="hidden" id="e-orden-id">
                                    <input type="hidden" id="e-citas-id">
                                    <input type="hidden" id="e-doctor-id">
                                    <input type="hidden" id="e-tipoestudio-id">
                                    <input type="hidden" id="e-estadoorden">
                                    <input type="hidden" id="e-lateralidad">
                                    <br>

                <!--                     <label for="">Justificacion</label>
                                    <input id="e-justificacion" type="text" readonly name="justificacion"
                                        class="form-control" required>

                                    <label for="">Resumen</label>
                                    <input id="e-resumen" type="text" readonly name="nombre" class="form-control"
                                        maxlength="200" minlength="3"> -->

                                </div>


                    


                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped" id="orden-lab-tabla">
                                            <thead>
                                                <tr>

                                                    <th>Codigo</th>
                                                    <th>Tipo de Examen</th>
                                                    <th>Resultado </th>

                                                    <th>Editar</th>

                                                </tr>
                                            </thead>
                                            <tbody id="orden-labs-cli">


                                            </tbody>
                                        </table>
                                    </div>


                                </div>




                                <div class="card-footer">
                                        INFORME Y CONCLUSIONES
                                        <div class="row">
                                            <div class="col-12 col-md-6 form-group">


                                                <label for="">Informe</label>
                                                <textarea id="e-informe" disabled type="text" rows="5" name="informe"
                                                    class="form-control"></textarea>
                                            </div>
                                            <div class="col-12 col-md-6 form-group">
                                                <label for="">Conclusiones</label>
                                                <textarea id="e-conclusion" disabled type="text" rows="5" name="conclusion"
                                                    class="form-control"></textarea>
                                            </div>

                                        </div>
                                    </div>


                            </div>

                        </div>








                    </div>

                    <div class="row">


                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="pdf-examen">Subir Examens en PDF</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="img" id="img-estudio" class="custom-file-input"
                                                    accept=".pdf">
                                                <label class="custom-file-label" for="exampleInputFile">Subir
                                                    Archivo</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Subir</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <!--   </form> -->
                    <div class="row">
                        <div class="col-12 form-group text-right">
                            <button class="btn btn-primary" id="btn-update" type="button">
                                <i class="fas fa-save mr-2"></i>FINALIZAR ORDEN DE LABORATORIO</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between"> </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modalEditarItemsLabs" tabindex="-1" role="dialog"
    aria-labelledby="modalEditarItemsLabsLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarItemsLabsLabel">Ingresar Resultado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditarOrdenesImagenes">
                    <!-- Campo oculto para el ID de la receta -->
                    <input type="hidden" id="editar-items-id">

                    <div class="form-group">
                        <label for="">Tipo Examen</label>
                        <input id="editar-tipo-examen" disabled class="form-control">
                        <!-- Las opciones se cargarán dinámicamente -->

                    </div>
                    <div class="form-group">
                        <label for="">Ingrese Resultado</label>
                        <input id="editar-resultado" class="form-control">
                     

                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardarEdicionOrdenItemsLabs">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>







<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="<?=BASE?>views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/jszip/jszip.min.js"></script>
<script src="<?=BASE?>views/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=BASE?>views/plugins/moment/moment.min.js"></script>

<script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script>

<script src="<?= BASE ?>views/dist/js/scripts/peticionJWT.js"></script>

<script src="<?=BASE?>views/dist/js/scripts/examenes_laboratorio.js?ver=1.1.1.4"></script>