<style>
#calendario {
    min-height: 700px;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 5px;
    background: #fff;

}




/* También elimina fondos de celdas de la última hora, que suelen ser las problemáticas */
.fc-timegrid-slot.fc-timegrid-slot-latest,
.fc-timegrid-slot-lane.fc-timegrid-slot-latest {
    background-color: transparent !important;
}

/* Opcional: controla el color de fondo general de las celdas */
.fc .fc-timegrid-slot {
    background-color: rgba(255, 255, 255, 0.69) !important;
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
        <div class="row">
                 <div class="col-10">
                <div id="calendario"></div>
            </div>



            <div class="col-2">
                <!-- Aquí puedes agregar los inputs, botones, modal, etc -->
                <h4>Detalles de la cita</h4>
                <form id="form-cita">

                    <div class="mb-3">
                        <h5>Identificacion</h5>
                        <div style="display: flex; flex-wrap: wrap; gap: 7px;">
                            <div style="display: flex; align-items: center;">
                                <div
                                    style="width: 20px; height: 20px; background-color: green; margin-right: 5px; border: 1px solid #000;">
                                </div>
                                <span> Atendida</span>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <div
                                    style="width: 20px; height: 20px; background-color: yellow; margin-right: 5px; border: 1px solid #000;">
                                </div>
                                <span> Pendiente</span>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <div
                                    style="width: 20px; height: 20px; background-color: #00c4ff; margin-right: 5px; border: 1px solid #000;">
                                </div>
                                <span> Atendiendo</span>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <div
                                    style="width: 20px; height: 20px; background-color: red; margin-right: 5px; border: 1px solid #000;">
                                </div>
                                <span>Hora de Almuerzo</span>
                            </div>
                        </div>
                    </div>



                    <div class="form-group">
                        <i class="fas fa-user-md"></i>
                        <label>Seleccionar Doctor</label>
                        <!--   <input type="hidden" id="doctor-id"> -->
                        <select type="text" class="form-control form-control-sm" id="select-doctor-ver">
                            <option value="0">Seleccione un medico</option>
                        </select>
                    </div>

                    <div class="form-group">

                        <label for="persona-nombres">Tipo de
                            Cobertura</label>

                        <select class="form-control form-control-sm" id="nuevo-cobertura" disabled required>
                            <option value="0">Seleccione la Cobertura</option>
                            <option value="1">IESS</option>
                            <option value="2">MSP</option>
                            <option value="3">ISSFA</option>
                            <option value="4">ISSPOL</option>

                        </select>


                        <label for="persona-nombres">Responsable del
                            Paciente</label>

                        <input type="text" class="form-control form-control-sm  danger solo-letras" maxlength="150"
                            minlength="4" id="nuevo-responsable" value="Voluntario" name="nombres" required>

                    </div>

                    <div class="form-group">
                        <div>
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
                                                <h3>$ <strong id="total-parcial">0.00</strong> <sup
                                                        style="font-size: 20px"></sup>
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
                                  <!--   <div class="row">

                                        <button id="guardar-cita" class="btn btn-primary"
                                            style="width: 100% !important;">
                                            <i class="fas fa-save mr-2"></i>Guardar Cita
                                        </button>
                                    </div> -->
                                </div>
                            </div>

                        </div>
                    </div>

                <!--     <div class="form-group">
                        <label>Paciente</label>
                        <input type="text" class="form-control" id="input-paciente" placeholder="Nombre del paciente">
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea class="form-control" id="input-descripcion" rows="4"></textarea>
                    </div> -->
            <!--         <button type="submit" class="btn btn-primary">Guardar cita</button> -->
                </form>
            </div>
        </div>
    </div>

</div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalAgendarCita" tabindex="-1" aria-labelledby="modalAgendarCitaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agendar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="input-total-parcial" value="10">

                <label for="fecha_hora">Fecha y hora:</label>
                <input type="text" id="fecha_hora" class="form-control" readonly>
                <!-- Aquí después pondrás select paciente, servicio, etc. -->


                <label for="">Paciente:</label>

                <select class="form-control form-control-sm" id="cita-paciente" required>
                    <option value="0">Seleccione al Paciente</option>
                </select>



                <label for="persona-nombres">Seleccione el Servicio</label>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 26px;">
                    <select class="form-control form-control-sm" id="cita-servicio" required style="flex: 1;">
                        <option value="0">Seleccione el Servicio</option>
                    </select>

                    <button id="btn-agregar" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i> Agregar
                    </button>
                </div>



            </div>
            <div class="modal-footer">
                <button type="button" id="btnGuardarCita" class="btn btn-primary">Guardar cita</button>

                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Cancelar Cita -->
<div class="modal fade" id="modalCancelarCita" tabindex="-1" aria-labelledby="modalCancelarCitaLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCancelarCitaLabel">Cancelar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p id="texto_cancelar"></p>
                <input type="hidden" id="cita_id_cancelar" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                <button type="button" class="btn btn-danger" id="btnConfirmarCancelar">Sí, cancelar</button>
            </div>
        </div>
    </div>
</div>





<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<!-- FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script src="<?= BASE ?>views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= BASE ?>views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= BASE ?>views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= BASE ?>views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= BASE ?>views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= BASE ?>views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= BASE ?>views/plugins/jszip/jszip.min.js"></script>
<script src="<?= BASE ?>views/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= BASE ?>views/plugins/moment/moment.min.js"></script>

<script src="<?= BASE ?>views/plugins/Toast/js/Toast.min.js"></script>

<script src="<?= BASE ?>views/dist/js/scripts/peticionJWT.js"></script>



<script src="<?= BASE ?>views/dist/js/scripts/mostrarHorarios.js?ver=1.1.1.4"></script>