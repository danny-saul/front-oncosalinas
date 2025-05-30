<style>
.factura {
    background-color: transparent;
}

.factura-header {}

.factura-header-prov {
    padding: 10px 20px;
    display: flex;
    flex-direction: column;
    margin-top: 10px;
    border-radius: 15px;
    border: 1px solid rgba(0, 0, 0, .2);
}

.factura-header-prov span {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid rgba(0, 0, 0, .4);
    line-height: 40px;
}

.factura-body {
    min-height: 250px;
    border-radius: 15px;
    border: 1px solid rgba(0, 0, 0, .2);
}

.factura-title {
    color: #007bff;
}

.factura-body table tr {
    box-sizing: border-box;
    padding: 20px;
}

.factura-body table thead tr td {
    font-weight: bold;
    text-transform: uppercase;
    text-align: start;
    color: #007bff;
}

.factura-body table tr td {
    padding: 10px;
    border-bottom: 1px solid rgba(0, 0, 0, .2);
    width: 25%;
}
</style>


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Administrador </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Administrador</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-9 col-lg-8">
                <div class="card card-dark">
                    <div class="card-header">
                        Receta
                    </div>

                    <div class="card-body">
                        <div class="factura" id="imprimir-receta">
                            <div class="factura-header">
                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <img src="<?=BASE?>views/dist/img/logoclinica.avif" alt="Logo de clinica"
                                            width="200px">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="text-right">
                                            <h2 class="lead p-4 factura-title">Receta N° <b id="compra_id"></b></h2>
                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                  
                                    <div class="col-12 pl-3 pr-3">
                                        <span class="text-primary d-flex justify-content-between">
                                            <b>ESTABLECIMIENTO DE SALUD: </b> <b id="edad-mascota-historial">
                                                <?=NOMBRE_EMPRESA?></b>
                                        </span>
                                    </div>

                                </div>

                                <div class="factura-header-prov" style="overflow: auto;">
                                    <input type="hidden" name="" id="cita-id">
                                    <input type="hidden" name="" id="citas-id">
                                    <span>Paciente: <b id="receta-paciente"></b></span>
                                    <span>Cedula: <b id="receta-cedula"></b></span>
                                    <span>Especialidad: <b id="receta-especialidad"></b></span>
                                    <span>Fecha: <b id="receta-fecha"></b></span>
                                </div>
                            </div>

                            <div class="factura-body mt-4" style="overflow: auto;">
                                <table>
                                    <thead>
                                        <tr>

                                            <td>Medicamento</td>
                                            <td>Cantidad</td>
                                            <td>Via Administracion</td>

                                        </tr>
                                    </thead>

                                    <tbody id="body-receta">

                                    </tbody>
                                </table>
                            </div>



                            <div class="row mt-4">



                                <div class="col-6 col-md-3 box-items">
                                    <div class="item-valores">
                                        <b>Datos del Prescriptor</b>
                                        <span id="receta-medico" class="text-center"> </span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 box-items">
                                    <b>Firma:</b>
                                    <div class="image" id="sello-img">

                                    </div>
                                </div>

                                <div class="col-6 col-md-5  box-items">
                                    <div class="item-valores">
                                        <b>Indicaciones</b>
                                        <span id="compra_total" class="text-center">Signos de alarma: Si durante el
                                            tratamiento de la medicacion
                                            presenta una reaccion o anomalia no deseada tras la administracion de un
                                            medicamento. Llamar a 0999999
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <main class="mt-3 text-right">
                    <button class="btn btn-danger" id="btn-imprimir">
                        <i class="fas fa-print mr-2"></i>
                        Descargar PDF
                    </button>
                </main>
            </div>
        </div>
    </div>
</div>
</div>

<script src="<?=BASE?>views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=BASE?>views/plugins/html2pdf/html2pdf.bundle.js"></script>
<script src="<?=BASE?>views/dist/js/scripts/ver_receta.js?ver=1.1.1.2"></script>