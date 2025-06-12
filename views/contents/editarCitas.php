<style>
#accordion .card {
    margin-bottom: 2px;
    /* Espacio mínimo entre acordeones */
    border-radius: 5px;
    /* Bordes más compactos */
}

#accordion .card-header {
    padding: 3px 8px;
    /* Reduce el tamaño del encabezado */
    font-size: 14px;
    /* Opcional: hacer el texto más pequeño */
}

#accordion .card-body {
    padding: 3px;
    /* Reduce el espacio interno del contenido */
    font-size: 13px;
    /* Opcional: reducir el tamaño del texto */
}

#accordion .card-title a {
    font-size: 14px;
    /* Opcional: ajustar tamaño de los títulos */
}



#accordion_familiares .card {
    margin-bottom: 2px;
    /* Espacio mínimo entre acordeones */
    border-radius: 5px;
    /* Bordes más compactos */
}

#accordion_familiares .card-header {
    padding: 3px 8px;
    /* Reduce el tamaño del encabezado */
    font-size: 14px;
    /* Opcional: hacer el texto más pequeño */
}

#accordion_familiares .card-body {
    padding: 3px;
    /* Reduce el espacio interno del contenido */
    font-size: 13px;
    /* Opcional: reducir el tamaño del texto */
}

#accordion_familiares .card-title a {
    font-size: 14px;
    /* Opcional: ajustar tamaño de los títulos */
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
                    <li class="breadcrumb-item active">Atencion Medica</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="content">
    <div class="container-fluid">
        <div class="row">





        </div>
    </div>
</div>


<div class="col-12">
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <style>
                /*    .nav-pills .nav-item:not(:last-child) .nav-link {
                    border-right: 1px solid #ccc;
                } */
                </style>

                <!--   <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Detalle de la Cita Medica</h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab_6" data-toggle="tab">
                                <i class="fas fa-user"></i> Resumen Clinico
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab_5" data-toggle="tab">
                                <i class="fas fa-lungs-virus"></i> Antecedentes
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#tab_8" data-toggle="tab">
                                <i class="fas fa-history"></i> Examen Fisico
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#tab_1" data-toggle="tab">
                                <i class="fas fa-file-medical"></i> Motivo de Consulta
                            </a>
                        </li>
                    
                        <li class="nav-item">
                            <a class="nav-link" href="#tab_2" data-toggle="tab">
                                <i class="fas fa-prescription"></i> Tratamiento
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab_4" data-toggle="tab">
                                <i class="fas fa-images"></i> Orden Imagenes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab_9" data-toggle="tab">
                                <i class="fas fa-microscope"></i> Orden Laboratorio
                            </a>
                        </li>
                     
                        <li class="nav-item">
                            <a class="nav-link" href="#tab_3" data-toggle="tab">
                                <i class="fas fa-file"></i> Certificados Medicos
                            </a>
                        </li>
                    </ul>
                </div> -->


                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Detalle de la Cita Medica</h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab_6" data-toggle="tab">
                                <i class="fas fa-user text-primary"></i> Resumen Clinico
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab_5" data-toggle="tab">
                                <i class="fas fa-lungs-virus text-success"></i> Antecedentes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab_8" data-toggle="tab">
                                <i class="fas fa-history" style="color: #dc3545;"></i> Examen Fisico
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#tab_1" data-toggle="tab">
                                <i class="fas fa-file-medical" style="color: #6f42c1;"></i> Motivo de Consulta
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#tab_2" data-toggle="tab">
                                <i class="fas fa-prescription" style="color: #17a2b8;"></i> Receta
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#tab_4" data-toggle="tab">
                                <i class="fas fa-images" style="color: #fd7e14;"></i> Orden Imagenes
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#tab_9" data-toggle="tab">
                                <i class="fas fa-microscope" style="color: #343a40;"></i> Orden Laboratorio
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#tab_3" data-toggle="tab">
                                <i class="fas fa-file" style="color: #dc3545;"></i> Certificados Medicos
                            </a>
                        </li>


                </div>






                <div class="card-body">
                    <div class="tab-content">


                        <!-- ANTECEDENTES -->

                        <div class="tab-pane" id="tab_5">
                            <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                <section class="content">
                                    <div class="container-fluid">

                                        <div class="row">


                                            <div class="col-12">
                                                <div class="card card-primary card-outline card-tabs">
                                                    <div class="card-header p-0 pt-1 border-bottom-0">
                                                        <ul class="nav nav-tabs" id="custom-tabs-three-tab"
                                                            role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active"
                                                                    id="custom-tabs-three-home-tab" data-toggle="pill"
                                                                    href="#custom-tabs-three-home" role="tab"
                                                                    aria-controls="custom-tabs-three-home"
                                                                    aria-selected="true">PERSONALES</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="custom-tabs-three-profile-tab"
                                                                    data-toggle="pill" href="#custom-tabs-three-profile"
                                                                    role="tab" aria-controls="custom-tabs-three-profile"
                                                                    aria-selected="false">FAMILIARES</a>
                                                            </li>
                                                            <li class="nav-item d-none">
                                                                <a class="nav-link" id="custom-tabs-three-messages-tab"
                                                                    data-toggle="pill"
                                                                    href="#custom-tabs-three-messages" role="tab"
                                                                    aria-controls="custom-tabs-three-messages"
                                                                    aria-selected="false">ANDROLOGICOS</a>
                                                            </li>
                                                            <li class="nav-item d-none">
                                                                <a class="nav-link" id="custom-tabs-three-settings-tab"
                                                                    data-toggle="pill"
                                                                    href="#custom-tabs-three-settings" role="tab"
                                                                    aria-controls="custom-tabs-three-settings"
                                                                    aria-selected="false">VACUNACION</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="tab-content" id="custom-tabs-three-tabContent">
                                                            <div class="tab-pane fade active show"
                                                                id="custom-tabs-three-home" role="tabpanel"
                                                                aria-labelledby="custom-tabs-three-home-tab">


                                                                <div class="card-body">

                                                                    <div class="card-body">
                                                                        <div class="row">

                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>SELECCIONE EL ANTECEDENTE
                                                                                    </label>
                                                                                    <div class="col-12">
                                                                                        <div id="accordion">



                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label>ANTECEDENTES REGISTRADOS
                                                                                </label>
                                                                                <div class="row">
                                                                                    <div
                                                                                        class="col-12 table-responsive">
                                                                                        <table id="tabla-diagnos"
                                                                                            class="table table-bordered">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>Fecha</th>
                                                                                                    <th>Antecedente</th>
                                                                                                    <th>Grupo</th>
                                                                                                    <th>Observacion</th>
                                                                                                    <th>Eliminar</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody id="body-diagnos">


                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>

                                                                                </div>

                                                                                <div class="d-flex justify-content-end">

                                                                                    <button type="button"
                                                                                        id="guardar-antecedente-paciente"
                                                                                        class="btn btn-primary"><i
                                                                                            class="fas fa-save mr-2 "></i>Guardar</button>
                                                                                </div>

                                                                            </div>

                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <label>ANTECEDENTES REGISTRADOS
                                                                                </label>
                                                                                <div class="row">
                                                                                    <div
                                                                                        class="col-12 table-responsive">
                                                                                        <table
                                                                                            id="tabla-paciente-diagnosticos"
                                                                                            class="table table-bordered">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>#</th>
                                                                                                    <th>Fecha</th>
                                                                                                    <th>Antecedente</th>
                                                                                                    <th>Grupo</th>
                                                                                                    <th>Observacion</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody id="">


                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>

                                                                                </div>



                                                                            </div>
                                                                        </div>




                                                                    </div>



                                                                </div>


                                                            </div>
                                                            <div class="tab-pane fade" id="custom-tabs-three-profile"
                                                                role="tabpanel"
                                                                aria-labelledby="custom-tabs-three-profile-tab">


                                                                <div class="card-body">

                                                                    <div class="card-body">
                                                                        <div class="row">

                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>SELECCIONE EL ANTECEDENTE
                                                                                    </label>
                                                                                    <div class="col-12">
                                                                                        <div id="accordion_familiares">



                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label>ANTECEDENTES REGISTRADOS
                                                                                </label>
                                                                                <div class="row">
                                                                                    <div
                                                                                        class="col-12 table-responsive">
                                                                                        <table
                                                                                            id="tabla-diagnosticos-familiares"
                                                                                            class="table table-bordered">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>Fecha</th>
                                                                                                    <th>Antecedente</th>
                                                                                                    <th>Grupo</th>
                                                                                                    <th>Observacion</th>
                                                                                                    <th>Eliminar</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody
                                                                                                id="body-diagnosticos-familiares">


                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>

                                                                                </div>

                                                                                <div class="d-flex justify-content-end">

                                                                                    <button type="button"
                                                                                        id="guardar-antecedente-familiar"
                                                                                        class="btn btn-primary"><i
                                                                                            class="fas fa-save mr-2 "></i>Guardar</button>
                                                                                </div>

                                                                            </div>

                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <label>ANTECEDENTES REGISTRADOS
                                                                                </label>
                                                                                <div class="row">
                                                                                    <div
                                                                                        class="col-12 table-responsive">
                                                                                        <table
                                                                                            id="tabla-familiar-diagnosticos"
                                                                                            class="table table-bordered">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>#</th>
                                                                                                    <th>Fecha</th>
                                                                                                    <th>Antecedente</th>
                                                                                                    <th>Grupo</th>
                                                                                                    <th>Observacion</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody id="">


                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>

                                                                                </div>



                                                                            </div>
                                                                        </div>




                                                                    </div>



                                                                </div>



                                                            </div>
                                                            <div class="tab-pane fade" id="custom-tabs-three-messages"
                                                                role="tabpanel"
                                                                aria-labelledby="custom-tabs-three-messages-tab">



                                                            </div>
                                                            <div class="tab-pane fade" id="custom-tabs-three-settings"
                                                                role="tabpanel"
                                                                aria-labelledby="custom-tabs-three-settings-tab">




                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </section>




                            </div>
                        </div>


                        <!-- ANAMNESIS -->

                        <div class="tab-pane " id="tab_1">

                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">

                                        <address>

                                            <input type="hidden" name="" id="historial-clinico-id">
                                            <input type="hidden" name="" id="citas-id">
                                            <input type="hidden" name="" id="paciente-id">
                                            Paciente: <span id="nombres-apellidos"> </span><br>
                                            Cédula: <span id="cedula"> </span><br>

                                        </address>
                                    </div>

                                    <div class="col-sm-4 invoice-col">

                                        <address>
                                            <strong></strong><br>

                                        </address>
                                    </div>

                                    <div class="col-sm-4 invoice-col">

                                        Cita ID: <span id="cita-id"></span><br>
                                        Medico: <span id="medico-nombre"></span><br>

                                    </div>

                                </div>
                                <form>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Motivo Consulta</label>
                                                <textarea class="form-control" id="editar-motivo-consulta" rows="7"
                                                    placeholder="Enter ..."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Historia de la Enfermedad Actual</label>
                                                <textarea class="form-control" rows="7" id="editar-enfermedad-actual"
                                                    placeholder="Enter ..."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Antecedentes Personales</label>
                                                <textarea class="form-control" rows="7" id="editar-antecedentes"
                                                    placeholder="Enter ..."></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-sm-4">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Antecedentes Familiares</label>
                                                <textarea class="form-control" rows="5" id="editar-ant-familiares"
                                                    placeholder="Enter ..."></textarea>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Examen Fisico</label>
                                                <textarea class="form-control" rows="5" id="editar-examen-fisico"
                                                    placeholder="Enter ..."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Plan</label>
                                                <textarea class="form-control" rows="5" id="editar-plan"
                                                    placeholder="Enter ..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 
                                    <div class="row">
                                       
                                    </div> -->


                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Alergias</label>
                                                <textarea class="form-control" rows="3" id="editar-alergias"
                                                    placeholder="Enter ..."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Evolucion</label>
                                                <textarea class="form-control" rows="3" id="editar-evolucion"
                                                    placeholder="Enter ..."></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>



                        <!-- ODONTOGRAMA -->

                        <div class="tab-pane" id="tab_7">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label>TRATAMIENTO</label>
                                            <div class="d-flex align-items-center">
                                                <input type="hidden" id="" value="1">
                                                <select class="form-control-sm" id="tratamiento-odonto"
                                                    style="width: 85%;" aria-hidden="true">
                                                    <!-- Options for select -->
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <div id="main">

                                            <div id="odontograma-wrapper">
                                                <h2>Odontograma</h2>
                                                <div id="odontograma"></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped table-sm" id="tabla-odontograma">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Pieza</th>
                                                    <th>Cuadrante</th>
                                                    <th>Diagnostico</th>
                                                    <th>Enfermedad</th>
                                                    <th>Codigo CIE 10</th>
                                                    <th>Procedimiento</th>
                                                    <th>Fecha</th>
                                                    <th>Doctor</th>
                                                    <th>Realizado</th>
                                                    <th>Fecha Modificacion</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <!-- RECETA  -->

                        <div class="tab-pane" id="tab_2">
                            <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                <div class="card-body">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>DIAGNOSTICOS</label>
                                                    <div class="d-flex align-items-center">
                                                        <input type="hidden" id="cantidad" value="1">
                                                        <select class="form-control-sm" id="nuevo-diagnostico1"
                                                            style="width: 75%;" aria-hidden="true">
                                                            <!-- Options for select -->
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 table-responsive">
                                                        <table class="table table-striped" id="tabla-diagnostic">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Tipo Diagnostico</th>
                                                                    <th>Diagnostico</th>
                                                                    <th>Editar</th>
                                                                    <th>Eliminar</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tabla-diagnostico1">


                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>SELECCIONE EL TIPO DE DIAGNOSTICO</label>
                                                    <div class="d-flex align-items-center">
                                                        <select class="form-control-sm" id="tipo_diagnostico"
                                                            style="width: 75%;" aria-hidden="true">
                                                            <!-- Options for select -->
                                                        </select>
                                                        <button id="btn-agregar-diagnosticos-definitivos"
                                                            class="btn btn-primary ml-2"><i
                                                                class="fas fa-save mr-2"></i> Guardar
                                                            Diagnostico</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="row">

                                        </div>

                                    </div>



                                </div>

                                <section class="content">
                                    <div class="container-fluid">
                                        <button class="btn btn-secondary btn-lg" data-toggle="modal"
                                            data-target="#modal-registrar-producto" data-backdrop="static"
                                            data-keyboard="false"><i class="fa fa-plus mr-2"></i>Agregar
                                            Medicamento</button>
                                        <div class="d-flex justify-content-end mt-3">
                                            Nº. # Receta: |<input type="text" class="text-end" disabled
                                               id="nuevo-num-receta1111">
                                               <input type="texto" disabled id="id-rece" name="">
                                        </div>
                                      

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">

                                                        <!-- Mensaje de advertencia -->
                                                        <div id="mensaje-no-receta" style="display: none;"></div>

                                                        <!-- CONTENEDOR DE INPUTS -->
                                                        <div id="contenedor-receta-inputs">
                                                          


                                                        <div class="row align-items-end">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Medicamento</label>
                                                                    <select class="form-control form-control-sm"
                                                                        id="nuevo-medicamento">
                                                                        <option value="0">Seleccione el medicamento
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-1">
                                                                <div class="form-group">
                                                                    <label>Cantidad</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm solo-numeros"
                                                                        id="nuevo-cantidad">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-1">
                                                                <div class="form-group">
                                                                    <label>Dosis</label>
                                                                    <select class="form-control form-control-sm"
                                                                        id="dosis">
                                                                        <option value="0">Seleccione</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-1">
                                                                <div class="form-group">
                                                                    <label>Vía</label>
                                                                    <select class="form-control form-control-sm"
                                                                        id="via">
                                                                        <option value="0">Seleccione</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-1">
                                                                <div class="form-group">
                                                                    <label>Frecuencia</label>
                                                                    <select class="form-control form-control-sm"
                                                                        id="frecuencia">
                                                                        <option value="0">Seleccione</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Duración</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="duracion">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Observación</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm" id="obs">
                                                                </div>
                                                            </div>

                                                            
                                                           <!-- Botón Guardar -->
                                                                <div class="col-md-1 text-end">
                                                                    <div class="form-group">
                                                                          <label>&nbsp;</label><br>
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-success"
                                                                            id="btn-guardar-nuevo-receta"> + Guardar</button>
                                                                    </div>
                                                                </div>

                                                         <!--    <div class="col-md-1 text-end">
                                                                <div class="form-group">
                                                                    <label>&nbsp;</label><br>
                                                                    <button type="button" class="btn btn-sm btn-success"
                                                                        id="btn-agregar" title="Agregar">+ Agregar</button>
                                                                </div>
                                                            </div> -->
                                                        </div>
                                                       
  
 
 
                                                            </div>
                                                        </div>



                                                        <!-- Botón Crear Receta -->
                                                        <button id="crear-receta-btn" style="display: none;"
                                                            class="btn btn-success">Crear Nueva Receta</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                </section>

                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table style="display: none;" class="table table-striped" id="tabla-recetas">
                                            <thead>
                                                <tr>
                                                    <th>Cantidad</th>
                                                    <th>Medicamento</th>
                                                    <th>Dosis</th>
                                                    <th>Frecuencia</th>
                                                    <th>Via</th>
                                                    <th>Duracion</th>
                                                    <th>Observacion</th>
                                                    <th>Editar</th>
                                                    <th>Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tbody id="productos-agregados">


                                            </tbody>
                                        </table>
                                    </div>

                                </div>


                                <div class="row d-none">

                                    <div class="col-6">

                                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">

                                        </p>
                                    </div>

                                    <div class="col-6">


                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th style="width:50%">Subtotal:</th>
                                                    <td id="subtotal">$</td>
                                                </tr>
                                                <tr>
                                                    <th>IVA (12%)</th>
                                                    <td id="iva">$</td>
                                                </tr>
                                                <!--  <tr>
                                                    <th>Descuento:</th>
                                                    <td id="orden-descuento">$</td>
                                                 </tr>-->
                                                <tr>
                                                    <th>Total:</th>
                                                    <td id="total">$</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                </div>



                            </div>

                        </div>

                        <!-- ORDEN IMAGEN -->

                        <div class="tab-pane" id="tab_4">
                            <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                <section class="content">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">


                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <label>Orden Imagen</label>
                                                                <br>
                                                                <select class="form-control form-control-sm"
                                                                    id="nuevo-imagen" style="width: 75%;"
                                                                    aria-hidden="true">
                                                                    <option value="0">Seleccione Imagen</option>

                                                                </select>

                                                            </div>
                                                            <!-- Repite la estructura para los otros campos -->
                                                            <div class="col-md-1">

                                                                <label for="campo2">Orden</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    disabled id="nuevo-orden">

                                                            </div>
                                                            <!-- Repite la estructura para los otros campos -->
                                                            <div class="col-md-1 d-none">

                                                                <label for="campo3">Lateralidad</label>
                                                                <select type="text" class="form-control form-control-sm"
                                                                    id="lateralidad">
                                                                    <option value="1">Seleccione lateralidad
                                                                    </option>
                                                                    <option value="1">Izquierda</option>
                                                                    <option value="2">Derecha</option>

                                                                </select>


                                                            </div>

                                                            <!-- Repite la estructura para los otros campos -->
                                                            <div class="col-md-2">

                                                                <label for="campo5">Justificacion</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="justificacion">

                                                            </div>
                                                            <!-- Repite la estructura para los otros campos -->
                                                            <div class="col-md-2">

                                                                <label for="campo6">Resumen Clinico</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="resumen">

                                                            </div>
                                                            <div class="col-md-1">


                                                                <label for="campo6"> . </label>
                                                                <br>
                                                                <button type="button"
                                                                    class="btn btn-primary form-control form-control-sm"
                                                                    id="btn-guardar-orden">Guardar</button>

                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </section>

                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped" id="tabla-orden-imagenes">
                                            <thead>
                                                <tr>
                                                    <th>Orden</th>
                                                    <th>Codigo</th>
                                                    <th>Lateralidad</th>
                                                    <th>Justificacion</th>
                                                    <th>Resumen Clinico</th>
                                                    <th>Editar</th>
                                                    <th>Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tbody id="orden-clinico">


                                            </tbody>
                                        </table>
                                    </div>

                                </div>


                            </div>
                        </div>


                        <!-- RESUMEN -->

                        <div class="tab-pane active" id="tab_6">
                            <div class="form-group row">

                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Logo o información de la empresa -->
                                            <h2>Paciente: <span id="resumen-paciente"></span> </h2>
                                            <p>Cedula: <span id="resumen-cedula"></span> </p>
                                            <!-- Más información si es necesaria -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Información del cliente o datos de la factura -->
                                            <h2>Numero Historia Clinica: <span id="resumen-historianumero"></span> </h2>
                                            <p>Edad: <span id="resumen-edad"></span> - Fecha Nacimiento: <span
                                                    id="resumen-fechanac"></span> </p>
                                            <!--        <p>Dirección del Paciente <span id="resumen-direccion"></span> </p> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">

                                    <div class="card">

                                        <div class="card-body overflow-auto" id="resumen-historial"
                                            style="height: 500px;">
                                            <!-- Loader aquí -->
                                            <div id="loader" style="display:none; text-align: center;">
                                                <i class="fas fa-spinner fa-spin"></i> Cargando...
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <!-- SIGNOS VITALES -->

                        <div class="tab-pane" id="tab_8">
                            <div class="form-group row">

                                <div class="card-body">

                                    <div class="card-body">

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Temperatura</label>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-temperature-high"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" id="etemperatura"
                                                                    class="form-control" placeholder="ºC">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>Peso</label>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-weight"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="number" id="epeso" class="form-control"
                                                                    placeholder="Kg">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>Talla</label>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-h-square"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="number" placeholder="1.50" id="etalla"
                                                                    class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>Presion Arterial</label>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-heartbeat"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" id="epresionarterial"
                                                                    class="form-control" placeholder="/minuto">

                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>Pulso</label>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-stethoscope"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="number" id="epulso" class="form-control"
                                                                    placeholder="/minuto">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>Frecuencia Respiratoria</label>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-lungs"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" id="efrecuenciarespiratoria"
                                                                    class="form-control" placeholder="/minuto">
                                                            </div>
                                                        </div>


                                                        <div class="col-md-6">
                                                            <label>IMC</label>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-lungs"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="number" id="eimc" class="form-control"
                                                                    placeholder="IMC" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>Saturacion de Oxigeno</label>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-lungs"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="number" id="esaturacion"
                                                                    class="form-control" placeholder="">
                                                            </div>
                                                        </div>


                                                    </div>

                                                </div>


                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Observacion:</label>
                                                                <textarea id="emotivo-observacion" class="form-control"
                                                                    rows="5">Ninguna</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Recomendacion:</label>
                                                                <textarea id="emotivo-recomendacion"
                                                                    class="form-control" rows="5">Ninguna</textarea>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>





                                    </div>







                                </div>

                            </div>
                        </div>

                        <!-- CERTIFICADO MEDICO -->

                        <div class="tab-pane" id="tab_3">
                            <div class="form-group row">

                                <div class="col-12">

                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Certificado Medico</h3>
                                        </div>


                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-md-6">


                                                    <div class="form-group row">

                                                        <label for="" class="col-sm-4 col-form-label">Tipo de
                                                            Contingencia</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control form-control-sm"
                                                                id="etipo-contingencia">


                                                            </select>
                                                        </div>


                                                        <label for="cedula" class="col-sm-4 col-form-label">Dias de
                                                            Reposo </label>
                                                        <div class="col-sm-8">
                                                            <input type="text"
                                                                class="form-control form-control-sm  solo-numeros"
                                                                maxlength="3" minlength="3" id="edia-descanso">
                                                        </div>

                                                        <label class="col-sm-4 col-form-label">Actividad de
                                                            Trabajo</label>
                                                        <div class="col-sm-8">
                                                            <input type="text"
                                                                class="form-control form-control-sm  solo-letras"
                                                                placeholder="" id="eactividad-laboral" required>
                                                        </div>




                                                        <label for="persona-nombres"
                                                            class="col-sm-4 col-form-label">Empresa o Lugar de
                                                            Trabajo</label>
                                                        <div class="col-sm-8">
                                                            <input type="text"
                                                                class="form-control form-control-sm  danger"
                                                                maxlength="150" minlength="4" id="eentidad-trabajo"
                                                                name="nombres" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">





                                                        <label for="persona-nombres"
                                                            class="col-sm-4 col-form-label">Direccion</label>
                                                        <div class="col-sm-8">
                                                            <input type="text"
                                                                class="form-control form-control-sm  danger"
                                                                id="edireccion-trabajo" name="nombres" required>
                                                        </div>

                                                        <label for="persona-nombres"
                                                            class="col-sm-4 col-form-label">Tipo de Aislamiento</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control form-control-sm"
                                                                id="etipo-aislamiento">

                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="cedula" class="col-sm-4 col-form-label">Observacion
                                                        </label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm "
                                                                id="eobservacion-certificado" required>
                                                        </div>

                                                    </div>


                                                </div>


                                            </div>



                                        </div>





                                    </div>



                                </div>



                            </div>

                            <button type="button" id="btn-guardar" class="btn btn-primary"><i
                                    class="fas fa-save mr-2"></i>Guardar</button>
                        </div>

                        <!-- ORDEN LABORATORIO -->


                        <div class="tab-pane" id="tab_9">
                            <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                <section class="content">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div id="mensaje-no-orden" style="display: none;"></div>

                                                        <div class="row">

                                                            <input type="hidden" id="id-labs" name="">
                                                            <input type="hidden" id="cantidad2" value="1">

                                                            <div class="col-md-4">
                                                                <label>Orden Laboratorio</label>
                                                                <br>
                                                                <select class="form-control form-control-sm"
                                                                    id="nuevo-laboratorio" style="width: 75%;"
                                                                    aria-hidden="true">
                                                                    <option value="0">Seleccione Tipo Examen Laboratorio
                                                                    </option>

                                                                </select>

                                                            </div>
                                                            <!-- Repite la estructura para los otros campos -->
                                                            <div class="col-md-2">

                                                                <label for="campo2">Orden</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    disabled id="nuevo-orden-laboratorio">

                                                            </div>



                                                            <!-- Repite la estructura para los otros campos -->
                                                            <div class="col-md-2">

                                                                <label for="campo5">Justificacion - Motivo
                                                                    Solicitud</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="justificacion-laboratorio">

                                                            </div>
                                                            <!-- Repite la estructura para los otros campos -->
                                                            <div class="col-md-2">

                                                                <label for="campo6">Resumen Clinico</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="resumen-laboratorio">

                                                            </div>
                                                            <div class="col-md-1">


                                                                <label for="campo6"> . </label>
                                                                <br>
                                                                <button type="button"
                                                                    class="btn btn-primary form-control form-control-sm"
                                                                    id="btn-agregar-orden-laboratorio">AGREGAR</button>

                                                            </div>
                                                        </div>


                                                        <button id="crear-orden-btn" style="display: none;"
                                                            class="btn btn-primary">Crear Nueva Orden</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </section>



                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table style="display: none;" class="table table-striped" id="orden-lab-tabla">
                                            <thead>
                                                <tr>

                                                    <th>Codigo</th>
                                                    <th>Justificacion - Motivo Solicitud</th>
                                                    <th>Resumen Clinico</th>
                                                    <th>Editar</th>
                                                    <th>Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tbody id="orden-labs-cli">


                                            </tbody>
                                        </table>
                                    </div>

                                </div>


                            </div>
                        </div>

                        <!-- OFTALMOLOGIA -->

                        <div class="tab-pane" id="tab_10">
                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="row invoice-info">



                                </div>
                                <form>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Descripcion </label>
                                                <textarea class="form-control" id="exa-op-descripcion" rows="7"
                                                    placeholder="Enter ..."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Observacion</label>
                                                <textarea class="form-control" rows="7" id="exa-op-observacion"
                                                    placeholder="Enter ..."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Observacion</label>
                                                <textarea class="form-control" rows="7" id="exa-op-observacion2"
                                                    placeholder="Enter ..."></textarea>
                                            </div>
                                        </div>
                                    </div>



                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<!-- MODAL DETALLE CONSULTA COMPRA -->
<div class="modal fade" id="modal-registrar-producto">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registrar Medicamento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="cedula" class="col-12 col-form-label">Ingrese el nombre del medicamento</label>
                <div class="col-12">
                    <input type="text" class="form-control form-control-sm soloLetras" placeholder="Paracetamol"
                        maxlength="50" minlength="50" id="nuevo-medicamento2" required>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-guardar-producto" class="btn btn-primary">Guardar</button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="observacionesModal">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">REGISTRO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="odontograma-diagnostico">ENFERMEDAD</label>
                    <select class="form-control" id="odontograma-enfermedad" style="width: 100%;">
                        <!-- Options for select -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="odontograma-procedimiento">PROCEDIMIENTO</label>
                    <select class="form-control" id="odontograma-procedimiento" style="width: 100%;">
                        <!-- Options for select -->
                    </select>

                </div>
                <div class="form-group">
                    <label for="observacionesTextarea">Ingrese una observación</label>
                    <textarea id="observacionesTextarea" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button id="guardarObservacionesBtn" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarReceta" tabindex="-1" role="dialog" aria-labelledby="modalEditarRecetaLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarRecetaLabel">Editar Receta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditarReceta">
                    <!-- Campo oculto para el ID de la receta -->
                    <input type="hidden" id="editar-receta-id">

                    <div class="form-group">
                        <label for="editar-cantidad">Cantidad</label>
                        <input type="number" id="editar-cantidad" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="editar-producto">Producto</label>
                        <input type="text" id="editar-producto" class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label for="editar-dosis">Dosis</label>
                        <select id="editar-dosis" class="form-control">
                            <!-- Las opciones se cargarán dinámicamente -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="editar-frecuencia">Frecuencia</label>
                        <select id="editar-frecuencia" class="form-control">
                            <!-- Las opciones se cargarán dinámicamente -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="editar-via">Via</label>
                        <select id="editar-via" class="form-control">
                            <!-- Las opciones se cargarán dinámicamente -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editar-duracion">Duración</label>
                        <input type="text" id="editar-duracion" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="editar-observacion">Observación</label>
                        <input type="text" id="editar-observacion" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardarEdicionReceta">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarDiagnostico" tabindex="-1" role="dialog"
    aria-labelledby="modalEditarDiagnosticoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarRecetaLabel">Editar Diagnostico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditarReceta">
                    <!-- Campo oculto para el ID de la receta -->
                    <input type="hidden" id="editar-diagnostico-id">




                    <div class="form-group">
                        <label for="">Diagnostico</label>
                        <select id="editar-diagnostico" disabled class="form-control">
                            <!-- Las opciones se cargarán dinámicamente -->
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="">Tipo de Diagnostico</label>
                        <select id="editar-tdiagnostico" class="form-control">
                            <!-- Las opciones se cargarán dinámicamente -->
                        </select>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardarEdicionDiagnostico">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalEditarOrdenesImagenes" tabindex="-1" role="dialog"
    aria-labelledby="modalEditarOrdenesImagenesLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarOrdenesImagenesLabel">Editar Ordenes Imagenes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditarOrdenesImagenes">
                    <!-- Campo oculto para el ID de la receta -->
                    <input type="hidden" id="editar-orden-id">




                    <div class="form-group">
                        <label for="">Tipo de Imagenes</label>
                        <select id="editar-tipoestudio" disabled class="form-control">
                            <!-- Las opciones se cargarán dinámicamente -->
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="">Justificacion</label>
                        <input id="editar-justificacion" class="form-control">
                        <!-- Las opciones se cargarán dinámicamente -->

                    </div>

                    <div class="form-group">
                        <label for="">Resumen</label>
                        <input id="editar-resumen" class="form-control">
                        <!-- Las opciones se cargarán dinámicamente -->

                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardarEdicionOrden">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="modalEditarOrdenesNewLabs" tabindex="-1" role="dialog"
    aria-labelledby="modalEditarOrdenesNewLabsLabel" aria-hidden="true">
    <div class="modal-dialog lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarOrdenesNewLabsLabel">Editar Ordenes Imagenes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- Campo oculto para el ID de la receta -->
                <!--    <input type="text" id="editar-orden-id"> -->

                <div class="form-group">
                    <label for=""># de Orden </label>
                    <input id="nuevo-num-new-laboratorio" disabled class="form-control">
                    <!-- Las opciones se cargarán dinámicamente -->

                </div>



                <div class="form-group">
                    <label for="">Tipo de Orden Laboratorio</label>
                    <select id="new-laboratorio-modal" class="form-control">
                        <option value="0">Seleccione Imagen</option>

                    </select>

                </div>

                <div class="form-group">
                    <label for="">Justificacion</label>
                    <input id="new-editar-justificacion" class="form-control">
                    <!-- Las opciones se cargarán dinámicamente -->

                </div>

                <div class="form-group">
                    <label for="">Resumen</label>
                    <input id="new-editar-resumen" class="form-control">
                    <!-- Las opciones se cargarán dinámicamente -->

                </div>


                <div class="text-right">
                    <button type="button" class="btn btn-primary" id="agg-orden-labs-new">Agregar Examen</button>
                </div>


                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped" id="orden-lab-tabla-new">
                            <thead>
                                <tr>

                                    <th>Codigo</th>
                                    <th>Justificacion - Motivo Solicitud</th>
                                    <th>Resumen Clinico</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="orden-cli-e-new">


                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardarEdicionOrdenNew">Guardar Cambios</button>


            </div>
        </div>
    </div>
</div>


<!-- MODAL DE NUEVA RECETA CON CODIGO -->

<div class="modal fade" id="modalEditarNewReceta" tabindex="-1" role="dialog"
    aria-labelledby="modalEditarRecetaNewLabsLabel" aria-hidden="true">
    <div class="modal-dialog lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarRecetaNewLabsLabel">Editar Receta </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- Campo oculto para el ID de la receta -->
                <!--    <input type="text" id="editar-orden-id"> -->

                <div class="form-group">
                    <label for=""># de Receta </label>
                    <input id="nuevo-num-new-receta" disabled class="form-control">
                    <!-- Las opciones se cargarán dinámicamente -->

                </div>



                <div class="form-group">
                    <label for="">Medicamento </label>
                    <select id="new-medicamento-modal" class="form-control">
                        <option value="0">Seleccione Medicamento</option>

                    </select>

                </div>



                <div class="form-group">
                    <label for="">Cantidad</label>
                    <input id="new-editar-cantidad" class="form-control solo-numeros">
                    <!-- Las opciones se cargarán dinámicamente -->

                </div>

                <div class="form-group">
                    <label for="">Dosis </label>
                    <select id="new-dosis-modal" class="form-control">
                        <option value="0">Seleccione la dosis</option>

                    </select>

                </div>

                <div class="form-group">
                    <label for="">Frecuencia </label>
                    <select id="new-frecuencia-modal" class="form-control">
                        <option value="0">Seleccione la frecuencia</option>

                    </select>

                </div>

                <div class="form-group">
                    <label for="">Via de administracion </label>
                    <select id="new-via-modal" class="form-control">
                        <option value="0">Seleccione la via</option>

                    </select>

                </div>


                <div class="form-group">
                    <label for="">Duracion</label>
                    <input id="new-duracion-resumen" class="form-control">
                    <!-- Las opciones se cargarán dinámicamente -->

                </div>

                <div class="form-group">
                    <label for="">Observacion</label>
                    <input id="new-observacion-resumen" class="form-control">
                    <!-- Las opciones se cargarán dinámicamente -->

                </div>


                <div class="text-right">
                    <button type="button" class="btn btn-primary" id="agg-orden-labs-new-receta">Agregar
                        Medicamento</button>
                </div>


                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped" id="orden-lab-tabla-new">
                            <thead>
                                <tr>


                                    <th>Cantidad</th>
                                    <th>Medicamento</th>
                                    <th>Dosis</th>
                                    <th>Frecuencia</th>
                                    <th>Via</th>
                                    <th>Duracion</th>
                                    <th>Observacion</th>
                                    <th>PV</th>
                                    <th>TT</th>
                                    <th>Edicion</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="receta-cli-e-new">


                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardarEdicionOrdenNewReceta">Guardar Cambios</button>


            </div>
        </div>
    </div>
</div>


<!-- <script src="<?=BASE?>views/plugins/jquery//knockout-2.0.0.js"></script>
<script src="<?=BASE?>views/plugins/jquery/odo/jquery.svg.min.js"></script>
<script src="<?=BASE?>views/plugins/jquery/odo/jquery.svggraph.min.js"></script>

 -->
<script src="<?=BASE?>views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/jszip/jszip.min.js"></script>
<script src="<?=BASE?>views/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=BASE?>views/plugins/moment/moment.min.js"></script>



<script src="<?= BASE ?>views/dist/js/scripts/peticionJWT.js"></script>


<script src="<?=BASE?>views/dist/js/scripts/editarCitas.js?ver=1.1.1.13"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>