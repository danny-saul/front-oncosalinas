<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Medico </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Estudios Imagenes</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-dark d-flex p-0">
                <h3 class="card-title p-3 card-dark">Detalle de la Cita Medica</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Imagenes
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
                                        <th>Tipo Estudio</th>
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
<!-- <div class="modal fade" id="modal-editar-orden">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Imagenes </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="contanier-fluid">
                  
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
                                        Paciente: <span id="estudio-paciente"> Danny Chavez</span> <br>
                                        Imagen: <span id="estudio-imagen"> </span>


                                        <input type="hidden" id="e-orden-id">
                                        <input type="hidden" id="e-citas-id">
                                        <input type="hidden" id="e-doctor-id">
                                        <input type="hidden" id="e-tipoestudio-id">
                                        <input type="hidden" id="e-estadoorden">
                                        <input type="hidden" id="e-lateralidad">
                                        <br>

                                        <label for="">Justificacion</label>
                                        <input id="e-justificacion" type="text" readonly name="justificacion"
                                            class="form-control" required>

                                        <label for="">Resumen</label>
                                        <input id="e-resumen" type="text" readonly name="nombre" class="form-control"
                                            maxlength="200" minlength="3">

                                    </div>


                                    <div class="card-footer">
                                        INFORME Y CONCLUSIONES
                                        <div class="row">
                                            <div class="col-12 col-md-6 form-group">


                                                <label for="">Informe</label>
                                                <textarea id="e-informe" type="text" rows="10"
                                                    name="informe" class="form-control"></textarea>
                                            </div>
                                            <div class="col-12 col-md-6 form-group">
                                                <label for="">Conclusiones</label>
                                                <textarea id="e-conclusion" type="text" rows="10"
                                                    name="conclusion" class="form-control"></textarea>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card-body">
                                        Imagenologo: <span id="estudio-imagenologo"> </span> <br>
                                        Medico que realizo el Procedimiento: <span id="estudio-doctor"> </span>



                                        <br>



                                    </div>


                                    <div class="card-footer">
                                        DIAGNOSTICOS DE IMAGENOLOGIA
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>DIAGNOSTICOS</label>
                                                    <div class="d-flex align-items-center">
                                                        <input type="hidden" id="cantidad" value="1">
                                                        <select class="form-control-sm" id="nuevo-diagnostico1"
                                                            style="width: 75%;" aria-hidden="true">
                                                           
                                                        </select>

                                                        <button id="btn-agregar-diagnosticos-definitivos"
                                                            class="btn btn-primary ml-2"><i
                                                                class="fas fa-plus mr-2"></i> Agregar</button>

                                                    </div>
                                                </div>

                                                <div class="row">
                                            
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                    <label>DIAGNOSTICOS</label>

                                            <div class="col-12 table-responsive">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                              
                                                                    <th>Diagnostico</th>

                                                                    <th>Eliminar</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tabla-diagnostico1">


                                                            </tbody>
                                                        </table>
                                                    </div>


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
                                            <label for="pdf-examen">Subir Informe</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="img" id="img-estudio"
                                                        class="custom-file-input" accept=".pdf">
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
              
                    <div class="row">
                        <div class="col-12 form-group text-right">
                            <button class="btn btn-primary" id="btn-update" type="button">
                                <i class="fas fa-save mr-2"></i>Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between"> </div>
        </div>
    </div>
</div>
 -->

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
<script src="<?=BASE?>views/dist/js/scripts/examenes_imagenes.js?ver=1.1.1.4"></script>