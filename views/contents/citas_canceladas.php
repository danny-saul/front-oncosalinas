<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Medico </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Citas Canceladas</li>
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
                    <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Citas
                            Canceladas</a></li>

                </ul>
            </div>

            <div class="row mb-3 d-flex justify-content-center">
                <div class="col-6 col-md-4 col-lg-3 form-group ">
                    <label for="">Fecha Inicio</label>
                    <input id="fecha-inicio-r-v" type="date" class="form-control">
                </div>
                <div class="col-6 col-md-4 col-lg-3 form-group ">
                    <label for="">Fecha fin</label>
                    <input id="fecha-fin-r-v" type="date" class="form-control">
                </div>


                <div class="col-6 col-md-4 col-lg-3 form-group">
                    <button class="btn btn-dark btn-sm" id="btn-consulta" style="margin-top: 35px;">
                        <i class=" fa fa-search mr-2"></i> Consultar</button>
                    <button class="btn bg-primary btn-sm " id="btn-imprimir" style="margin-top: 35px;">
                        <i class="far fa-file-pdf mr-2"></i> PDF</button>
                </div>

            </div>

            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="div" style="overflow: auto;">
                            <table id="tabla-pendientes" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 5px">#</th>
                                        <th># Cod Cita</th>
                                        <th>Cedula</th>
                                        <th>Paciente</th>
                                        <th>Medico</th>
                                        <th>Hora</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                               
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
<script src="<?=BASE?>views/dist/js/scripts/consultarcitascanceladas.js"></script>