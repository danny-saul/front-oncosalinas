<style>
    .card-header{
       /*  background-color:rgb(237, 50, 137); */
       background-color: rgb(62, 106, 202); ;
    }
    .card-title {
        color: white;
    }

    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #9400ff;
}

</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Citas Pendientes</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Consultar Citas</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
<!--     <a class="btn btn-success btn-lg"  href="<?=BASE?>inicio/citasatendidas"
            data-backdrop="static" style=" margin-bottom: 13px" data-keyboard="false"><i class="fa fa-check mr-4"></i>IR A CITAS ATENDIDAS</a>
  -->
  <!--    <a class="btn btn-info btn-lg"  href="<?=BASE?>inicio/crearCita"
            data-backdrop="static" style=" margin-bottom: 13px" data-keyboard="false"><i class="fa fa-check mr-4"></i>CREAR CONSULTAS</a>
 -->
<!--     <a class="btn btn-info btn-lg"  href="<?=BASE?>gestion/asignarcitas"
            data-backdrop="static" style=" margin-bottom: 13px" data-keyboard="false"><i class="fa fa-check mr-4"></i>AGENDAR CITAS</a>
 -->
        <div class="card">
            <div class="card-header card-dark d-flex p-0"  >
                <h3 class="card-title p-3 card-dark">Detalle de la Cita Medica</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Citas
                            Pendientes</a></li>

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
                                        <th># Cod Cita</th>
                                        <th>Hora Registro</th>
                                        <th>Cedula</th>
                                        <th>Paciente</th>
                                        <th>Medico</th>
                                        <th>Especialidad</th> 
                                        <th>Fecha Cita</th>
                                        <th>Hora Cita</th>
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

<script src="<?=BASE?>views/dist/js/scripts/consultarcitas.js?ver=1.1.1.3"></script>
