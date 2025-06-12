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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label>Medico</label>
                                        <input type="text" readonly class="form-control" id="usuario-md"
                                            placeholder="Nombre del medico">
                                    </div>
                                    </div>

                                    <div class="col-6">
                                        <i class="fas fa-clock"></i>
                                        <label>Seleccionar Intervalo</label>
                                        <select class="form-control" id="select-intervalo" name="intervalo" required>
                                            <option value="">Seleccione un Intervalo</option>
                                            <option value="20">20 min</option>
                                            <option value="30">30 min</option>
                                            <option value="40">40 min</option>
                                            <option value="60">60 min</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="form-group col-12">
                                        <label>Días de Atención</label>
                                        <div id="dias-container">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input dia-semana" type="checkbox" value="Lunes"
                                                    id="lunes">
                                                <label class="form-check-label" for="lunes">Lunes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input dia-semana" type="checkbox"
                                                    value="Martes" id="martes">
                                                <label class="form-check-label" for="martes">Martes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input dia-semana" type="checkbox"
                                                    value="Miercoles" id="miercoles">
                                                <label class="form-check-label" for="miercoles">Miércoles</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input dia-semana" type="checkbox"
                                                    value="Jueves" id="jueves">
                                                <label class="form-check-label" for="jueves">Jueves</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input dia-semana" type="checkbox"
                                                    value="Viernes" id="viernes">
                                                <label class="form-check-label" for="viernes">Viernes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input dia-semana" type="checkbox"
                                                    value="Sabado" id="sabado">
                                                <label class="form-check-label" for="sabado">Sábado</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input dia-semana" type="checkbox"
                                                    value="Domingo" id="domingo">
                                                <label class="form-check-label" for="domingo">Domingo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Aquí se agregan dinámicamente los horarios por día -->
                                <div id="horarios-por-dia"></div>

                                <div class="row col-6 mt-3">
                                    <button type="submit" class="btn btn-primary btn-block">Guardar Horario</button>
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






<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(function() {
        $('.dia-semana').change(function() {
            const dia = $(this).val();
            if (this.checked) {
                // Agregar inputs para ese día si no existen
                if ($(`.bloque-dia[data-dia="${dia}"]`).length === 0) {
                    $('#horarios-por-dia').append(`
          <div class="bloque-dia border rounded p-3 mb-3" data-dia="${dia}">
            <h5>${dia}</h5>
            <div class="row">
              <div class="col-md-3">
                <label>Hora Entrada</label>
                <input type="time" name="horarios[${dia}][hora_inicio]" class="form-control" required>
              </div>
              <div class="col-md-3">
                <label>Hora Salida</label>
                <input type="time" name="horarios[${dia}][hora_fin]" class="form-control" required>
              </div>
              <div class="col-md-3">
                <label>Almuerzo Desde</label>
                <input type="time" name="horarios[${dia}][almuerzo_inicio]" class="form-control">
              </div>
              <div class="col-md-3">
                <label>Almuerzo Hasta</label>
                <input type="time" name="horarios[${dia}][almuerzo_fin]" class="form-control">
              </div>
            </div>
          </div>
        `);
                }
            } else {
                // Quitar inputs si se desmarca el día
                $(`.bloque-dia[data-dia="${dia}"]`).remove();
            }
        });


        // Opcional: Validar antes de enviar
        $('#form-horario-doctor').submit(function(e) {
            // Validar que haya al menos un día seleccionado
            if ($('.dia-semana:checked').length === 0) {
                alert('Seleccione al menos un día de atención');
                e.preventDefault();
                return;
            }
            // Aquí podrías agregar más validaciones si quieres
        });
    });
</script>

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

<script src="<?= BASE ?>views/dist/js/scripts/gestionhorariodoctor.js?ver=1.1.1.3"></script>