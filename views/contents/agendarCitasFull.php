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

<!-- <script>
    (function() {
        let token = localStorage.getItem('token');
        if (!token) {
            window.location = urlCliente + 'login';
        }
    })();
</script>

 -->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!--  <h1 class="m-0">Administrador </h1> -->

          <!--       <a class="btn btn-warning btn-lg" href="<?= BASE ?>inicio/citas" data-backdrop="static"
                    style=" margin-bottom: 13px" data-keyboard="false"><i class="fas fa-level-up-alt"></i> ATENDER CITAS
                    -> CLIC
                    AQUI</a> -->

           <!--      <a class="btn btn-danger btn-lg" data-backdrop="static" data-toggle="modal" style=" margin-bottom: 13px"
                    data-target="#modal-instrucciones" data-keyboard="false"><i class="fas fa-level-up-alt"></i>
                    INSTRUCCIONES -> CLIC
                    AQUI</a> -->


          <!--       <button class="btn btn-info mb-3 d-none" data-bs-toggle="modal" data-bs-target="#guiaCalendario">
                    <i class="fas fa-info-circle"></i> Ver guía de uso
                </button> -->



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

<div class="content" style="margin-top: -20px;">
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
                                <span> Pendiente/ H. ocupadas</span>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <div
                                    style="width: 20px; height: 20px; background-color: #00c4ff; margin-right: 5px; border: 1px solid #000;">
                                </div>
                                <span> H. disponibles</span>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <div
                                    style="width: 20px; height: 20px; background-color: red; margin-right: 5px; border: 1px solid #000;">
                                </div>
                                <span>H. de Almuerzo</span>
                            </div>
                        </div>
                    </div>



                    <!--    <div class="form-group">
                        <i class="fas fa-user-md"></i>
                        <label>Seleccionar Doctor</label>
                    
                        <select type="text" class="form-control form-control-sm" id="select-doctor-ver">
                            <option value="0">Seleccione un medico</option>
                        </select>
                    </div>

     -->
                    <div class="form-group">
                        <label>Medico</label>
                        <input type="text" readonly class="form-control" id="usuario-md"
                            placeholder="Nombre del paciente">
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

                        <!-- 
                        <label for="persona-nombres">Responsable del
                            Paciente</label>

                        <input type="text" class="form-control form-control-sm  danger solo-letras" maxlength="150"
                            minlength="4" id="nuevo-responsable" value="Voluntario" name="nombres" required>
 -->
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



<div class="modal fade" id="modal-instrucciones">
    <div class="modal-dialog modal-bg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">INSTRUCCIONES</h4>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <p style="text-align: justify; font-size: 16px; line-height: 1.6;">
                        <i class="fas fa-calendar-plus text-primary"></i> <strong>1.</strong> Para agendar una cita,
                        haga clic sobre una hora en el calendario correspondiente a la fecha deseada.<br>

                        <i class="fas fa-user text-primary"></i> <strong>2.</strong> Se abrirá una ventana donde deberá
                        seleccionar al paciente y el servicio de atención.<br>

                        <i class="fas fa-plus-circle text-success"></i> <strong>3.</strong> Haga clic en el botón
                        <strong>"Agregar"</strong> para incluir el servicio. A la derecha se mostrará el total y el
                        servicio agregado a la tabla.<br>

                        <i class="fas fa-save text-success"></i> <strong>4.</strong> Luego, haga clic en
                        <strong>"Guardar"</strong> para registrar la cita y proceder con la atención.<br>

                        <i class="fas fa-check-circle text-success"></i> <strong>5.</strong> La cita se guardará de
                        inmediato sin recargar la página. Las citas pendientes se mostrarán en <span
                            style="color: orange;"><strong>color naranja</strong></span> y las citas atendidas en <span
                            style="color: green;"><strong>color verde</strong></span>.<br><br>

                        <strong><i class="fas fa-palette"></i> Colores en el calendario:</strong><br>
                        <i class="fas fa-stop-circle" style="color: red;"></i> Hora de almuerzo:
                        <strong>rojo</strong>.<br>
                        <i class="fas fa-border-all" style="color: #5bc0de;"></i> Horas y días disponibles:
                        <strong>celeste</strong>.<br><br>

                        Las horas y días disponibles dependen del horario definido por el médico. Este puede ser
                        configurado desde el menú <strong>/Horarios → Mis Horarios</strong>, incluyendo el horario de
                        almuerzo.<br><br>

                        <strong><i class="fas fa-exclamation-triangle text-danger"></i> Nota importante:</strong><br>
                        • No se pueden agendar citas en fechas pasadas.<br>
                        • Las citas solo podrán agendarse a partir de la línea roja que indica la hora actual del
                        sistema.<br>
                        • Para cancelar una cita, haga clic sobre el nombre del paciente en el calendario. Solo se
                        pueden cancelar citas pendientes (<span style="color: orange;"><strong>naranja</strong></span>).
                        Las citas atendidas <strong>no pueden ser canceladas</strong>.<br>
                        • <strong>No se permite agendar citas durante el horario de almuerzo.</strong>
                    </p>

                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>

<!-- Modal de Guía del Calendario -->
<div class="modal fade" id="guiaCalendario" tabindex="-1" aria-labelledby="guiaCalendarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="guiaCalendarioLabel"><i class="fas fa-book-open"></i> Guía de uso del
                    calendario</h5>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <p style="text-align: justify; font-size: 16px; line-height: 1.6;">
                        <i class="fas fa-calendar-plus text-primary"></i> <strong>1.</strong> Para agendar una cita,
                        haga clic sobre una hora en el calendario correspondiente a la fecha deseada.<br>

                        <i class="fas fa-user text-primary"></i> <strong>2.</strong> Se abrirá una ventana donde deberá
                        seleccionar al paciente y el servicio de atención.<br>

                        <i class="fas fa-plus-circle text-success"></i> <strong>3.</strong> Haga clic en el botón
                        <strong>"Agregar"</strong> para incluir el servicio. A la derecha se mostrará el total y el
                        servicio agregado a la tabla.<br>

                        <i class="fas fa-save text-success"></i> <strong>4.</strong> Luego, haga clic en
                        <strong>"Guardar"</strong> para registrar la cita y proceder con la atención.<br>

                        <i class="fas fa-check-circle text-success"></i> <strong>5.</strong> La cita se guardará de
                        inmediato sin recargar la página. Las citas pendientes se mostrarán en <span
                            style="color: orange;"><strong>color naranja</strong></span> y las citas atendidas en <span
                            style="color: green;"><strong>color verde</strong></span>.<br><br>

                        <strong><i class="fas fa-palette"></i> Colores en el calendario:</strong><br>
                        <i class="fas fa-stop-circle" style="color: red;"></i> Hora de almuerzo:
                        <strong>rojo</strong>.<br>
                        <i class="fas fa-border-all" style="color: #5bc0de;"></i> Horas y días disponibles:
                        <strong>celeste</strong>.<br><br>

                        Las horas y días disponibles dependen del horario definido por el médico. Este puede ser
                        configurado desde el menú <strong>/Horarios → Mis Horarios</strong>, incluyendo el horario de
                        almuerzo.<br><br>

                        <strong><i class="fas fa-exclamation-triangle text-danger"></i> Nota importante:</strong><br>
                        • No se pueden agendar citas en fechas pasadas.<br>
                        • Las citas solo podrán agendarse a partir de la línea roja que indica la hora actual del
                        sistema.<br>
                        • Para cancelar una cita, haga clic sobre el nombre del paciente en el calendario. Solo se
                        pueden cancelar citas pendientes (<span style="color: orange;"><strong>naranja</strong></span>).
                        Las citas atendidas <strong>no pueden ser canceladas</strong>.<br>
                        • <strong>No se permite agendar citas durante el horario de almuerzo.</strong>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<!-- FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<!-- <script>
$(document).ready(function () {
    // Mostrar el modal solo la primera vez
    if (!localStorage.getItem('guiaCalendarioVista')) {
        $('#guiaCalendario').modal('show');
        localStorage.setItem('guiaCalendarioVista', 'true');
    }
});
</script>
 -->

<!-- 
<script>
$(document).ready(function() {
    const diasParaMostrarDeNuevo = 7;
    const hoy = new Date();
    const marcaVista = localStorage.getItem('guiaCalendarioVista');
    const fechaVista = localStorage.getItem('guiaCalendarioFecha');

    if (!marcaVista || !fechaVista || diferenciaDias(new Date(fechaVista), hoy) >= diasParaMostrarDeNuevo) {
        $('#guiaCalendario').modal('show');
        localStorage.setItem('guiaCalendarioVista', 'true');
        localStorage.setItem('guiaCalendarioFecha', hoy.toISOString());
    }

    function diferenciaDias(fechaAnterior, fechaActual) {
        const diferenciaTiempo = fechaActual - fechaAnterior;
        return Math.floor(diferenciaTiempo / (1000 * 60 * 60 * 24));
    }
});
</script> -->

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

<script src="<?= BASE ?>views/dist/js/scripts/agendarcitasmedicoFull.js?ver=1.1.1.4"></script>