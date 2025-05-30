<style>
.card-header {
    background-color: #3564dc;
}

.card-title {
    color: white;
}
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Recepcionista</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Agendar Citas</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">

        <a class="btn btn-warning btn-lg" href="<?=BASE?>inicio/citas" data-backdrop="static"
            style=" margin-bottom: 13px" data-keyboard="false"><i class="fas fa-level-up-alt"></i> ATENDER CITAS -> CLIC
            AQUI</a>


        <div class="card">
            <div class="card-header card-dark d-flex p-0">
                <h3 class="card-title p-3 card-dark">Agendar Citas Medicas</h3>

            </div>
        </div>


        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Informacion Cita Medica</h3>
                    </div>
                    <div class="card-body">
                        <div id="accordion">
                            <div class="card card-dark">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a id="acordion-persona" class="d-block w-100" data-toggle="collapse"
                                            href="#collapseOne">
                                            Datos Personales
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- //    <form class="form-horizontal" id="nuevo-cita"> -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group row">



                                                        <label for="" class="col-sm-4 col-form-label">Paciente:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control form-control-sm"
                                                                id="cita-paciente" required>
                                                                <option value="0">Seleccione al Paciente</option>
                                                            </select>
                                                        </div>



                                                        <label for="persona-nombres"
                                                            class="col-sm-4 col-form-label">Tipo de
                                                            Cobertura</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control form-control-sm"
                                                                id="nuevo-cobertura" disabled required>
                                                                <option value="0">Seleccione la Cobertura</option>
                                                                <option value="1">IESS</option>
                                                                <option value="2">MSP</option>
                                                                <option value="3">ISSFA</option>
                                                                <option value="4">ISSPOL</option>

                                                            </select>
                                                        </div>

                                                        <label for="persona-nombres"
                                                            class="col-sm-4 col-form-label">Responsable del
                                                            Paciente</label>
                                                        <div class="col-sm-8">
                                                            <input type="text"
                                                                class="form-control form-control-sm  danger solo-letras"
                                                                maxlength="150" minlength="4" id="nuevo-responsable"
                                                                value="Voluntario" name="nombres" required>
                                                        </div>

                                                    </div>




                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group row">
                                                        <!--  <div class="col-12">
                                                                <div class="custom-control custom-checkbox mb-3">

                                                                </div>
                                                            </div> -->
                                                        <label for="" class="col-sm-4 col-form-label">Medico:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control form-control-sm"
                                                                id="cita-medico" required>
                                                                <option value="0">Seleccione al Medico</option>
                                                            </select>
                                                        </div>


                                                        <label for="fnacimiento"
                                                            class="col-sm-4 col-form-label">Seleccione una Fecha
                                                        </label>
                                                        <div class="col-sm-8">
                                                            <input type="date" class="form-control form-control-sm"
                                                                id="cita-fecha" name="fecha" required>

                                                        </div>

                                                        <label for="persona-nombres"
                                                            class="col-sm-4 col-form-label">Escoja una Hora</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control form-control-sm" id="cita-hora"
                                                                required>
                                                                <option value="0">Seleccione la Hora
                                                                </option>


                                                            </select>
                                                        </div>

                                                        <label for="persona-nombres"
                                                            class="col-sm-4 col-form-label">Seleccione el
                                                            Servicio</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control form-control-sm"
                                                                id="cita-servicio" required>
                                                                <option value="0">Seleccione el Servicio</option>
                                                            </select>

                                                        </div>
                                                        <button id="btn-agregar" class="btn btn-primary "
                                                            style="margin-inline: 10px; margin-bottom: 26px;"><i
                                                                class="fas fa-plus mr-2"></i></button>
                                                        <!-- 
                                                            <div class="row" id="datos-r">
                                                                <div class="col-12 col-md-6 ">
                                                                    <div class="form-group">
                                                                        <select id="select-servicios"
                                                                            class="form-control">
                                                                            <option>Seleccione los Servicios</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <button id="btn-agregar-servicios"
                                                                        class="btn btn-primary"><i
                                                                            class="fas fa-plus mr-2"></i>Seleccionar</button>
                                                                </div>
                                                            </div>
 -->

                                                        <label for="" class="col-sm-4 col-form-label"></label>
                                                        <div class="col-sm-8">

                                                        </div>
                                                        <label for="" class="col-sm-4 col-form-label"></label>
                                                        <div class="col-sm-8">

                                                        </div>
                                                        <label for="" class="col-sm-4 col-form-label"></label>
                                                        <div class="col-sm-8">

                                                        </div>
                                                        <label for="" class="col-sm-4 col-form-label"></label>
                                                        <div class="col-sm-8">

                                                        </div>
                                                        <label for="" class="col-sm-4 col-form-label"></label>
                                                        <div class="col-sm-8">

                                                        </div>
                                                        <label for="" class="col-sm-4 col-form-label"></label>
                                                        <div class="col-sm-8">

                                                        </div>
                                                    </div>




                                                </div>
                                            </div>




                                        </div>
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h4 class="card-title w-100">
                                                    <a id="acordion-usuario" class="d-block w-100"
                                                        data-toggle="collapse" href="#collapseTwo">
                                                        Cargar Archivos
                                                    </a>
                                                </h4>
                                            </div>

                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="img-usuario">Archivos</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" name="img" disabled
                                                                        id="img-usuario" class="custom-file-input"
                                                                        accept="image/*">
                                                                    <label class="custom-file-label"
                                                                        for="exampleInputFile">Subir
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

                                            <div class="card-header">
                                                <h4 class="card-title w-100">
                                                    <a id="acordion-usuario" class="d-block w-100"
                                                        data-toggle="collapse" href="#collapseTwo">
                                                        Cargar Archivos
                                                    </a>
                                                </h4>
                                            </div>

                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="img-usuario">Archivos</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" name="img" disabled
                                                                        id="img-usuario" class="custom-file-input"
                                                                        accept="image/*">
                                                                    <label class="custom-file-label"
                                                                        for="exampleInputFile">Subir
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
                                        <!--  </form> -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Servicios</h3>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card-body">
                                <div class="div" style="overflow: auto; max-height: 329px;">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Servicio</th>
                                                <th>Precio</th>
                                                <th>Acciones</th>
                                                <th class="d-none">ID</th>
                                            </tr>
                                        </thead>
                                        <tbody id="items-servicios">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



                <div class="card-body">
                    <div class="row">
                        <div class=" col-12">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>$ <strong id="total-parcial">0.00</strong> <sup style="font-size: 20px"></sup>
                                    </h3>

                                    <p>Total Parcial</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-money-bill"></i>
                                </div>
                                <a class="small-box-footer">
                                    <i class="fas fa-money-bill"></i></a>
                            </div>
                        </div>

                    </div>

                    <div class=" col-12">
                        <!-- small box -->
                        <div class="row">

                            <button id="guardar-cita" class="btn btn-primary" style="width: 100% !important;">
                                <i class="fas fa-save mr-2"></i>Guardar Cita
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>


<script src="<?=BASE?>views/dist/js/scripts/agendarCitas.js?ver=1.1.1.2"></script>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




<script>
$(document).ready(function() {
    var fechaInput = document.getElementById('cita-fecha');
    var hoy = new Date();

    // Establecer la fecha mínima permitida como la fecha actual
    var fechaMinima = hoy.toISOString().split('T')[0];
    fechaInput.setAttribute('min', fechaMinima);

    // Validar la fecha cuando se selecciona una nueva fecha
    $('#cita-fecha').on('change', function() {
        var fechaSeleccionada = $(this).val();

        // Validar si la fecha seleccionada es anterior a la fecha actual
        /*   if (new Date(fechaSeleccionada) < hoy) {
            alert('No puedes seleccionar días pasados.');
            $(this).val(''); // Limpiar el valor del input si la fecha no es válida
          } */
    });
});
</script>

<script>
$(document).ready(function() {
    var fechaInput = document.getElementById('cita-fecha');
    var hoy = new Date();
    var semanaDespues = new Date();
    semanaDespues.setDate(hoy.getDate() + 6); // Obtener la fecha de una semana después

    // Establecer la fecha máxima permitida como una semana después de la fecha actual
    var maxFecha = semanaDespues.toISOString().split('T')[0];
    fechaInput.setAttribute('max', maxFecha);

    // Validar la fecha cuando se selecciona una nueva fecha
    $('#cita-fecha').on('change', function() {
        var fechaSeleccionada = $(this).val();

        // Realizar validación AJAX aquí si es necesario
        // Por ejemplo, puedes enviar la fecha seleccionada al servidor y obtener una respuesta para validarla

        // Ejemplo de validación:
        if (new Date(fechaSeleccionada) > semanaDespues) {
            alert('Selecciona una fecha dentro de la próxima semana.');
            $(this).val(''); // Limpiar el valor del input si la fecha no es válida
        }
    });
});
</script>