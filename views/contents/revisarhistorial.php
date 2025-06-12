<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Medico </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Consultas Medicas</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
    <div class="card">
            <div class="card-header card-dark d-flex p-0">
                <h3 class="card-title p-3 card-dark"><span id="nombre-paciente"></span></h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Consulta Externa
                            </a></li>

                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="div" style="overflow: auto;">
                            <table id="tabla-historia-citas" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 5px">#</th>
                                        <th>Fecha</th>
                                        <th>Motivo Consulta </th>
                                        <th>Diagnostico</th> 
                                        <th>Plan de Tratamiento</th>
                                        <th>Enf. Actual </th>
                                        <th>Examen Fisico</th> 
                                        <th>Medico</th>  
                                        <th>Laboratorio</th>
                                        <th>Imagenes</th>
                                        <th style="width: 5px;">Impr.</th>
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
<script src="<?= BASE ?>views/dist/js/scripts/peticionJWT.js"></script>


<script src="<?=BASE?>views/dist/js/scripts/revision_historialClinico.js?ver=1.1.1.2"></script>



 