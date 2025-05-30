<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Registro de Horarios de Atención</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Administrador</a></li>
                    <li class="breadcrumb-item active">Gestion de Horarios</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Datos</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <form id="form-horario-doctor" method="POST">
                        <div class="mt-1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <i class="fas fa-user-md"></i>
                                        <label>Seleccionar Doctor</label>
                                        <!--   <input type="hidden" id="doctor-id"> -->
                                        <select type="text" class="form-control" id="select-doctor">
                                        </select>
                                    </div>

                                    <div class="col-6">
                                        <i class="fas fa-user-md"></i>
                                        <label>Seleccionar Intervalo</label>
                                        <!--   <input type="hidden" id="doctor-id"> -->
                                        <select type="text" class="form-control" id="select-intervalo">
                                            <option value="0">Seleccione un Intervalo</option>
                                            <option value="20">20 min</option>
                                            <option value="30">30 min</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label>Hora de Entrada</label>
                                    <input type="time" class="form-control" id="hora-entrada"
                                        placeholder="Ingrese la Hora de Entrada">
                                </div>
                                <div class="col-6 form-group">
                                    <label>Hora de Salida</label>
                                    <input type="time" class="form-control" id="hora-salida"
                                        placeholder="Ingrese la Hora de Salida">
                                </div>
                            </div>


                            <div class="row col-6 mt-2">
                                <button type="submit" class="btn btn-block bg-gradient-primary btn-md">Guardar</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        <!--     <div class="col-md-12">
                <div class="card card-primary shadow-none">
                    <div class="card-header">
                        <h3 class="card-title">Horarios Disponibles</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>


                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <i class="fas fa-user-md"></i>
                                        <label>Seleccionar Doctor</label>
                                      
                                        <select type="text" class="form-control" id="select-doctor-listar">
                                        </select>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end mt-4">
                                        <div class="col-12 form-group">
                                            <button style="margin-top: 8px;" class="btn btn-primary" id="consutar" type="button">
                                                <i class="fas fa-save mr-2"></i>Consultar</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="card card-dark">

                                            <div class="card-body">
                                                <div class="div" style="overflow: auto;">
                                                    <table id="tabla-horarios"
                                                        class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10px">#</th>
                                                                <th>Dia</th>
                                                                <th>Hora Inicio</th>
                                                                <th>Hora Fin</th>
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
                </div>
            </div> -->

        
        </div>
    </div>
</div>
</div>


<!-- MODAL EDITAR HORAS DEL DOCTOR -->
<!-- MODAL EDITAR -->
<div class="modal fade" id="modal-editar-horasdoctor">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Editar Horas Doctor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="contanier-fluid">
                    <form id="actualizar-producto" method="POST">

                        <div class="row ">
                            <div class="col-12 col-md-4 form-group">
                                <label for="">Hora de Entrada</label>
                                <input id="e-hora-entrada" type="time" name="horaEntrada" class="form-control">
                            </div>
                            <div class="col-12 col-md-4 form-group">
                                <input type="hidden" id="e-horaD-id">
                                <label for="">Hora de Salida</label>
                                <input id="e-hora-salida" type="time" name="horaSalida" class="form-control">
                            </div>
                            <div class="col-12 col-md-4 form-group">
                                <label for="">Fecha</label>
                                <input id="e-h-fecha" type="date" name="efecha" class="form-control">
                            </div>

                        </div>
                    </form>
                    <div class="row">
                        <div class="col-12 form-group text-right">
                            <button class="btn btn-primary" id="btn-update-hora-doctor" type="button">
                                <i class="fas fa-save mr-2"></i>Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between"> </div>
        </div>
    </div>
</div>

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
<script src="<?=BASE?>views/dist/js/scripts/gestionhorarioAdmin.js?ver=1.1.1.2"></script>
