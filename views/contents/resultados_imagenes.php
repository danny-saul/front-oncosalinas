<style>
b {
    color: black;
}
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Medico </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Resultado de Imagenes</li>
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
                            <table id="tabla-resultados" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 5px">#</th>
                                        <th># Orden</th>
                                        <th>Cita</th>
                                        <th>Paciente</th>
                                        <th>Cedula</th>
                                        <th>Tipo Estudio</th>
                                        <th>Medico</th>
                                        <th>Especialidad</th>
                                        <th>Fecha y Hora</th>
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

<!-- MODAL DETALLE CONSULTA  -->
<div class="modal fade" id="modal-detalle-resultados">
    <div class="modal-dialog modal-lg">


        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">RESULTADO ESTUDIO</h3>
                        </div>

                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <section class="cuadro" id="imprimir-informe">
                                        <div class="row d-flex align-items-center sin-margin-y">
                                            <div class="col-12 col-sm-6 text-start pl-2 d-flex justify-content-center">
                                                <div class="ml-4">
                                                    <img src="<?=BASE?>views/dist/img/logoclinica.avif"
                                                        alt="Logo de clinica" width="200px">
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-6">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <p class="text-primary mb-0 text-center">
                                                            <b>Dirección: Barrio 25 de Septiembre</b>
                                                        </p>
                                                        <p class="text-primary text-center" style="margin-bottom: 5px">
                                                            <b> La Libertad</b>
                                                        </p>
                                                    </div>

                                                    <div class="col-12">
                                                        <p class="text-primary text-center" style="margin-bottom: 5px">
                                                            <b>
                                                                Teléfono: 0985412552
                                                            </b>
                                                        </p>
                                                    </div>

                                                    <div class="col-12">
                                                        <p class="text-primary text-center" style="margin-bottom: 5px">
                                                            <b>
                                                                Santa Elena - Ecuador
                                                            </b>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-flex border-top sin-margin-y">
                                            <div class="col-6 sin-padding-y border-rigth">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span class="title-orden">
                                                            DATOS DE ESTABLECIMIENTO
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 pl-3 pr-3">
                                                        <span class="text-primary d-flex justify-content-between">
                                                            <b>Institucion: </b> <b id="nombre-mascota-historial">
                                                                <?=NOMBRE_EMPRESA?> </b>
                                                        </span>
                                                    </div>

                                                    <div class="col-12 pl-3 pr-3">
                                                        <span class="text-primary d-flex justify-content-between">
                                                            <b>ESTABLECIMIENTO DE SALUD: </b> <b
                                                                id="edad-mascota-historial"> <?=NOMBRE_EMPRESA?></b>
                                                        </span>
                                                    </div>




                                                </div>
                                            </div>

                                            <div class="col-6 sin-padding-y ">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span class="title-orden">
                                                            -
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 pl-3 pr-3">
                                                        <span class="text-primary d-flex justify-content-between">
                                                            <b>Numero Orden: </b>
                                                            <b id="num-orden"> 0000001</b>
                                                        </span>
                                                    </div>

                                                    <div class="col-12 pl-3 pr-3">
                                                        <span class="text-primary d-flex justify-content-between">
                                                            <b>Numero de Archivo: </b>
                                                            <b id="nombre-cliente-historial"> 1 </b>
                                                        </span>
                                                    </div>




                                                </div>
                                            </div>
                                        </div>


                                        <div class="row sin-margin-y border-top">
                                            <div class="col-12 sin-padding-y">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span class="title-orden">
                                                            Datos del Paciente
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 pl-3 pr-3">
                                                <span class="text-primary d-flex justify-content-between">
                                                    <b>Apellidos: </b>
                                                    <b id="apellidos"> </b>
                                                    <b>Nombres: </b>
                                                    <b id="nombres"> </b>
                                                    <b>Cedula: </b>
                                                    <b id="cedula"> </b>
                                                    <b>Sexo: </b>
                                                    <b id="sexo"> </b>
                                                    <b>Fecha de Nacimiento: </b>
                                                    <b id="fecha-nacimiento"> </b>

                                                </span>
                                            </div>
                                        </div>

                                        <div class="row sin-margin-y border-top">
                                            <div class="col-12 sin-padding-y">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span class="title-orden">
                                                            Datos del Servicio
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 pl-3 pr-3">
                                                <span class="text-primary d-flex justify-content-between">
                                                    <b>Profesional que realiza el procedimiento: </b>
                                                    <b id="profesional-nombres"> </b>
                                                    <br>
                                                    <b>Medico Solicitante: </b>
                                                    <b id="medico"> </b>
                                                    <b>Fecha que se realizo el procedimiento: </b>
                                                    <b id="fecha"> </b>
                                                    <b>Servicio: </b>
                                                    <b id="servicio"> </b>
                                                    <b>Especialidad: </b>
                                                    <b id="especialidad"> </b>

                                                </span>
                                            </div>
                                        </div>

                                        <div class="row sin-margin-y border-top">
                                            <div class="col-12 sin-padding-y">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span class="title-orden">
                                                            Estudio de Imagenologia Realizado
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 pl-3 pr-3">
                                                <span class="text-primary d-flex justify-content-between">
                                                    <b>Detalle Imagenologia: </b>
                                                    <b id="detalle-imagenologia"> </b>

                                                </span>
                                            </div>

                                        </div>

                                        <div class="row sin-margin-y border-top">
                                            <div class="col-12 sin-padding-y">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span class="title-orden">
                                                            Hallazgos por Imagenologias Encontrados
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 pl-3 pr-3">
                                                <span class="text-primary d-flex justify-content-between">
                                                    <b>Detalle Imagenologia: </b>
                                                    <b id="detalle-hallazgos"> </b>

                                                </span>
                                            </div>

                                        </div>

                                        <div class="row sin-margin-y border-top">
                                            <div class="col-12 sin-padding-y">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span class="title-orden">
                                                            Conclusiones
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 pl-3 pr-3">
                                                <span class="text-primary d-flex justify-content-between">
                                                    <b>Conclusiones: </b>
                                                    <b id="detalle-conclusiones"> </b>

                                                </span>
                                            </div>

                                        </div>




                                        <div class="row sin-margin-y border-top">
                                            <div class="col-12 sin-padding-y">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span class="title-orden">
                                                            Datos del Profesional Responsable
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 pl-3 pr-3">
                                                <span class="text-primary d-flex justify-content-between">
                                                    <b>FECHA Y HORA: </b>
                                                    <b id="fecha-img"> </b>
                                                    <b>APELLIDOS: </b>
                                                    <b id="apellidos-img"> </b>
                                                    <b>NOMBRES: </b>
                                                    <b id="nombres-img"> </b>
                                                    <b>CEDULA: </b>
                                                    <b id="cedula-img"> </b>
                                                    <b>TELEFONO: </b>
                                                    <b id="telefono-img"> </b>

                                                </span>
                                            </div>
                                        </div>


                                        <div class="col-12 col-sm-6 text-start pl-2 d-flex justify-content-center">
                                            <div class="col-6 col-md-3 box-items">
                                                <b>Firma:</b>
                                                <div class="image" id="sello-img">

                                                </div>
                                            </div>
                                        </div>









                                    </section>

                                    <main class="mt-3">
                                        <button class="btn btn-primary" id="btn-imprimir">
                                            <i class="fas fa-print mr-2"></i>
                                            Descargar PDF
                                        </button>
                                    </main>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between"> </div>

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
<script src="<?=BASE?>views/plugins/html2pdf/html2pdf.bundle.js"></script>

<script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script>
<script src="<?=BASE?>views/dist/js/scripts/resultados_imagenes.js?ver=1.1.1.2"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>