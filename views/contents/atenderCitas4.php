<style>
/* Estilos generales */
.card {
    border: 1px solid #ccc;
    border-radius: 4px;
    margin: 20px;
    background-color: #fff;
}

.card-header {
    background: #f8f8f8;
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

.card-body {
    padding: 15px;
}

.info-colores {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    margin-bottom: 15px;
}

.info-item {
    display: flex;
    align-items: center;
    font-size: 14px;
}

.color-box {
    width: 15px;
    height: 15px;
    display: inline-block;
    margin-right: 5px;
    border-radius: 3px;
}

.info-estado-por-hacer {
    background-color: yellow;
}

.info-estado-encontrado {
    background-color: blue;
}

.info-estado-realizado {
    background-color: green;
}

/* Contenedor del odontograma */
.odontograma-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    padding: 20px;
}

.fila {
    display: flex;
    justify-content: center;
    gap: 40px;
    width: 100%;
}

.odontograma {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    justify-content: center;
}

/* Cada diente */
.diente {
    background-color: white;
    position: relative;
    width: 60px;
    /* Aumentamos la altura para acomodar el SVG y las carillas */
    height: 120px;
    text-align: center;
    font-weight: bold;
    border: 1px solid #ccc;
    padding: 5px;
    box-sizing: border-box;
}

.diente-numero {
    font-size: 14px;
    margin-bottom: 3px;
}

/* SVG del diente */
.diente svg {
    width: 100%;
    height: 50px;
}

/* Estilo para las caras del diente */
.cara {
    fill: white;
    stroke: black;
    stroke-width: 1px;
    cursor: pointer;
}

.seleccionado {
    fill: yellow !important;
}

.cara.estado-por-hacer {
    fill: yellow !important;
}

.cara.estado-encontrado {
    fill: blue !important;
}

.cara.estado-realizado {
    fill: green !important;
}

.cara.estado-vacio {
    fill: white !important;
}


/* Container de carillas (las 6) */
/* Container de carillas */
.carillas {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    /* 3 columnas */
    gap: 3px;
    /* Espaciado reducido entre carillas */
    justify-items: center;
    margin-top: 5px;
}

/* Cada carilla */
.carilla {
    width: 12px;
    /* Tamaño reducido */
    height: 12px;
    /* Tamaño reducido */
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: white;
    border: 1px solid #000;
    border-radius: 2px;
    font-size: 6px;
    /* Fuente más pequeña para que encaje */
    cursor: pointer;
}

.carilla.seleccionado {
    background-color: yellow;
    font-weight: bold;
    color: black;
    border-color: orange;
}

/* Estados de carillas */
.carilla.estado-por-hacer {
    background-color: yellow;
    font-weight: bold;
}

.carilla.estado-encontrado {
    background-color: blue;
    font-weight: bold;
}

.carilla.estado-realizado {
    background-color: green;
    font-weight: bold;
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

                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Detalle de la Cita Medica</h3>
                    <ul class="nav nav-pills ml-auto p-2">

                    <input type="text" id="odonto-id">


                        <li class="nav-item">
                            <a class="nav-link" href="#tab_11" data-toggle="tab">
                                <i class="fas fa-tooth"></i> Odontograma
                            </a>
                        </li>

                </div>




                <div class="tab-pane" id="tab_11">
                    <input type="hidden" name="" id="citas-id">
                    <input type="hidden" name="" id="paciente-id">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Odontograma</h3>
                        </div>
                        <div class="card-body">

                            <div class="info-colores">
                                <div class="info-item">
                                    <span class="color-box info-estado-por-hacer"></span> Por Hacerse
                                </div>
                                <div class="info-item">
                                    <span class="color-box info-estado-encontrado"></span> Encontrado
                                </div>
                                <div class="info-item">
                                    <span class="color-box info-estado-realizado"></span> Realizado
                                </div>
                            </div>

                            <div class="odontograma-container">
                                <div><strong>Dentición Permanente</strong></div>
                                <div class="fila">
                                    <div class="odontograma" id="odontograma-adultos-superior-izq"></div>
                                    <div class="odontograma" id="odontograma-adultos-superior-der"></div>
                                </div>
                                <div class="fila">
                                    <div class="odontograma" id="odontograma-adultos-inferior-izq"></div>
                                    <div class="odontograma" id="odontograma-adultos-inferior-der"></div>
                                </div>
                                <div><strong>Dentición Primaria</strong></div>
                                <div class="fila">
                                    <div class="odontograma" id="odontograma-ninos-superior-izq"></div>
                                    <div class="odontograma" id="odontograma-ninos-superior-der"></div>
                                </div>
                                <div class="fila">
                                    <div class="odontograma" id="odontograma-ninos-inferior-izq"></div>
                                    <div class="odontograma" id="odontograma-ninos-inferior-der"></div>
                                </div>
                            </div>

                            <!-- Aquí pueden ir las tablas u otros elementos asociados -->

                        </div>
                    </div>


                    <!-- DataTable para mostrar los tratamientos seleccionados -->
                    <table id="tablaTratamientos" class="table table-striped d-none">
                        <thead>
                            <tr>
                                <th>Pieza</th>
                                <th>Cuadrante</th>
                                <th>Diagnóstico</th>
                                <th>Enfermedad</th>
                                <th>Procedimiento</th>
                                <th>Fecha</th>
                                <th>Doctor</th>
                                <th>Realizado</th>
                                <th>Fecha Crea.</th>
                                <th>Fecha Modif.</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>



                    <!-- DataTable para mostrar los tratamientos seleccionados -->
                    <table id="tabla-odonto-listar" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pieza</th>
                                <th>Cuadrante</th>
                                <th>Diagnóstico</th>
                                <th>Enfermedad</th>
                                <th>Procedimiento</th>
                                <th>Fecha</th>
                                <th>Doctor</th>
                                <th>Realizado</th>
                                <th>Fecha Crea.</th>
                                <th>Fecha Modif.</th>
                                <th>Editar</th>
                                <th>Eliminar</th>

                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>


                </div>

            </div>
        </div>
    </div>
</div>
</div>


<!-- Modal para seleccionar tratamiento -->
<div class="modal fade" id="modalTratamiento" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar Tratamiento</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formTratamiento">
                    <input type="hidden" id="dienteSeleccionado">
                    <input type="hidden" id="caraSeleccionada">

                    <div class="form-group">
                        <label for="estadoTratamiento">Estado del Tratamiento</label>
                        <select id="estadoTratamiento" class="form-control">
                            <option value="Por hacerse">Por hacerse</option>
                            <option value="Encontrado">Encontrado</option>
                            <option value="Realizado">Realizado</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="tratamiento">Diagnostico</label>
                        <select class="form-control-sm" id="tratamiento-odontograma">
                            <!-- Options for select -->
                        </select>
                    </div>

                    <input type="hidden" id="cantidad" value="1">

                    <div class="form-group">
                        <label>Enfermedad</label>
                        <select class="form-control-sm" id="odonto-diagnostico">
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="">Procedimiento </label>
                        <select class="form-control-sm" id="odonto-procedimiento">
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="observacionesTextarea">Ingrese una observación</label>
                        <textarea id="odonto-observacion" class="form-control" rows="2"></textarea>
                    </div>

                    <button type="button" id="agregarTratamiento" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para seleccionar tratamiento -->
<div class="modal fade" id="modalTratamientoEditar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar Tratamiento</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formTratamiento">
                    <input type="hidden" id="EdienteSeleccionado">
                    <input type="hidden" id="EcaraSeleccionada">
                    <input type="hidden" id="editar-detodonto-id">

                    <div class="form-group">
                        <label for="cedula" class="col-12 col-form-label">Pieza</label>
                        <div class="col-12">
                            <input type="text" class="form-control form-control-sm " disabled maxlength="50"
                                minlength="50" id="e-numero-pieza">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cedula" class="col-12 col-form-label">Cuadrante</label>
                        <div class="col-12">
                            <input type="text" class="form-control form-control-sm " disabled maxlength="50"
                                minlength="50" id="e-cuadrante">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="estadoTratamiento">Estado del Tratamiento</label>
                        <select id="EestadoTratamiento" class="form-control">
                            <option value="Por hacerse">Por hacerse</option>
                            <option value="Encontrado">Encontrado</option>
                            <option value="Realizado">Realizado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Diagnostico</label>
                        <select class="form-control-sm" id="Eodonto-diagnostico">
                        </select>

                    </div>


                    <div class="form-group">
                        <label for="tratamiento">Enfermedad</label>
                        <select class="form-control-sm" id="Etratamiento-odontograma">
                            <!-- Options for select -->
                        </select>
                    </div>

                    <input type="hidden" id="cantidad" value="1">


                    <div class="form-group">
                        <label for="">Procedimiento </label>
                        <select class="form-control-sm" id="Eodonto-procedimiento">
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="observacionesTextarea">Ingrese una observación</label>
                        <textarea id="Eodonto-observacion" class="form-control" rows="2"></textarea>
                    </div>

                    <button type="button" id="EagregarTratamiento" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para seleccionar tratamiento -->
<div class="modal fade" id="modalTratamientoEliminar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar Tratamiento</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formTratamiento">
                    <input type="hidden" id="EdienteSeleccionado">
                    <input type="hidden" id="EcaraSeleccionada">
                    <input type="text" id="eliminar-detodonto-id">

                    <div class="form-group">
                        <label for="cedula" class="col-12 col-form-label">Pieza</label>
                        <div class="col-12">
                            <input type="text" class="form-control form-control-sm " disabled maxlength="50"
                                minlength="50" id="eli-numero-pieza">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cedula" class="col-12 col-form-label">Cuadrante</label>
                        <div class="col-12">
                            <input type="text" class="form-control form-control-sm " disabled maxlength="50"
                                minlength="50" id="eli-cuadrante">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="estadoTratamiento">Estado del Tratamiento</label>
                        <select id="EestadoTratamientoEliminar" class="form-control">
                            <option value="Vacio">Vacio</option>

                        </select>
                    </div>


                    <button type="button" id="EguardarEliminar" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Carilla -->
<div class="modal fade" id="modalCarilla" tabindex="-1" aria-labelledby="modalCarillaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCarillaLabel">Seleccionar Carilla</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="numeroDiente">Número de Diente:</label>
                <input type="text" id="numeroDiente" class="form-control" disabled />
                
                <label for="estadoCarilla">Elemento Componente:</label>
                <input type="text" id="estadoCarilla" class="form-control" disabled />
                
                <label for="estadoCarillaSeleccionado">Selecciona un estado:</label>
                <select id="estadoCarillaSeleccionado" class="form-select">
                    <option value="Por hacer">Por hacer</option>
                    <option value="Encontrado">Encontrado</option>
                    <option value="Realizado">Realizado</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardarCarilla">Guardar</button>
            </div>
        </div>
    </div>
</div>





<script>
document.addEventListener("DOMContentLoaded", function() {

    // Función para crear cada diente con su SVG y bloque de carillas
    function crearDiente(numero) {
        let diente = document.createElement("div");
        diente.classList.add("diente");
        diente.dataset.numero = numero; // Asociamos el número del diente
        diente.innerHTML = `
        <div class="diente-numero">${numero}</div>
        <svg viewBox="0 0 50 50">
            <polygon class="cara vestibular" points="10,5 40,5 35,15 15,15" data-cara="vestibular" />
            <polygon class="cara lingual" points="10,45 40,45 35,35 15,35" data-cara="lingual" />
            <polygon class="cara mesial" points="10,5 15,15 15,35 10,45" data-cara="mesial" />
            <polygon class="cara distal" points="40,5 35,15 35,35 40,45" data-cara="distal" />
            <polygon class="cara oclusal" points="15,15 35,15 35,35 15,35" data-cara="oclusal" />
        </svg>
        <div class="carillas">
            <div class="carilla" data-etiqueta="A" data-diente="${numero}">A</div>
            <div class="carilla" data-etiqueta="C" data-diente="${numero}">C</div>
            <div class="carilla" data-etiqueta="EX" data-diente="${numero}">EX</div>
            <div class="carilla" data-etiqueta="EM" data-diente="${numero}">EM</div>
            <div class="carilla" data-etiqueta="SLL" data-diente="${numero}">SLL</div>
            <div class="carilla" data-etiqueta="RX" data-diente="${numero}">RX</div>
        </div>`;

        // Eventos para las caras
        diente.querySelectorAll(".cara").forEach(cara => {
            cara.addEventListener("click", function(event) {
                event.stopPropagation();
                cara.classList.toggle("seleccionado");
            });
        });

        // Eventos para las carillas
        // Eventos para las carillas
        diente.querySelectorAll(".carilla").forEach(carilla => {
            carilla.addEventListener("click", function(event) {
                event.stopPropagation();

                // Deseleccionar todas las carillas de todos los dientes
                document.querySelectorAll(".carilla").forEach(c => c.classList.remove("seleccionado"));

                // Seleccionar la nueva carilla
                carilla.classList.add("seleccionado");

                // Obtener el número de diente y la etiqueta de la carilla seleccionada
                let numeroDiente = carilla.dataset.diente;
                let etiqueta = carilla.dataset.etiqueta;

                // Mostrar el modal con el número de diente y el estado seleccionado
                $('#modalCarilla').modal('show');

                // Llenar los inputs del modal con el número de diente y el estado de la carilla
                $('#numeroDiente').val(numeroDiente);
                $('#estadoCarilla').val(etiqueta);

                // Llamar a la función del archivo externo
                guardar_elementocomponente();
            });
        });



        return diente;
    }


    // Ejemplo de creación de dientes:
    // Para dentición permanente (adultos)
    const adultos = {
        superiorIzq: ["18", "17", "16", "15", "14", "13", "12", "11"],
        superiorDer: ["21", "22", "23", "24", "25", "26", "27", "28"],
        inferiorIzq: ["48", "47", "46", "45", "44", "43", "42", "41"],
        inferiorDer: ["31", "32", "33", "34", "35", "36", "37", "38"]
    };

    // Para dentición primaria (niños)
    const ninos = {
        superiorIzq: ["55", "54", "53", "52", "51"],
        superiorDer: ["61", "62", "63", "64", "65"],
        inferiorIzq: ["85", "84", "83", "82", "81"],
        inferiorDer: ["71", "72", "73", "74", "75"]
    };

    // Función auxiliar para cargar dientes en un contenedor específico
    function cargarDientes(contenedorId, listaNumeros) {
        const contenedor = document.getElementById(contenedorId);
        listaNumeros.forEach(num => contenedor.appendChild(crearDiente(num)));
    }

    // Cargar en las secciones de dentición permanente
    cargarDientes("odontograma-adultos-superior-izq", adultos.superiorIzq);
    cargarDientes("odontograma-adultos-superior-der", adultos.superiorDer);
    cargarDientes("odontograma-adultos-inferior-izq", adultos.inferiorIzq);
    cargarDientes("odontograma-adultos-inferior-der", adultos.inferiorDer);

    // Cargar en las secciones de dentición primaria
    cargarDientes("odontograma-ninos-superior-izq", ninos.superiorIzq);
    cargarDientes("odontograma-ninos-superior-der", ninos.superiorDer);
    cargarDientes("odontograma-ninos-inferior-izq", ninos.inferiorIzq);
    cargarDientes("odontograma-ninos-inferior-der", ninos.inferiorDer);

});
</script>


<script>
$(document).ready(function() {
    $('.cara').on('click', function() {
        // Resetear selección previa
        $('.cara').removeClass('seleccionado');

        let diente = $(this).closest('.diente').data('numero');
        let cara = $(this).data('cara');

        $('#dienteSeleccionado').val(diente);
        $('#caraSeleccionada').val(cara);

        // Marcar la cara actual como seleccionada
        $(this).addClass('seleccionado');

        $('#modalTratamiento').modal('show');
    });

    $('#agregarTratamiento').on('click', function() {
        let diente = $('#dienteSeleccionado').val();
        let cara = $('#caraSeleccionada').val();
        let tratamiento = $('#tratamiento').val();
        let estado = $('#estadoTratamiento').val();
        let fecha = new Date().toISOString().split('T')[0];

        let colorClass = "";
        if (estado === "Por hacerse") {
            colorClass = "estado-por-hacer";
        } else if (estado === "Encontrado") {
            colorClass = "estado-encontrado";
        } else if (estado === "Realizado") {
            colorClass = "estado-realizado";
        }

        // Aplicar el color del estado
        $('.diente[data-numero="' + diente + '"] .cara[data-cara="' + cara + '"]')
            .removeClass("seleccionado") // Eliminar la clase de selección
            .addClass(colorClass); // Agregar la clase correspondiente

        // Agregar a la tabla
        let nuevaFila = `<tr>
            <td>${diente}</td>
            <td>${cara}</td>
            <td>${tratamiento}</td>
            <td>${estado}</td>
            <td>${fecha}</td>
        </tr>`;

        $('#tablaTratamientos tbody').append(nuevaFila);
        $('#modalTratamiento').modal('hide');
    });

    // Resetear valores cuando se cierra el modal
    $('#modalTratamiento').on('hidden.bs.modal', function() {
        $('#dienteSeleccionado').val('');
        $('#caraSeleccionada').val('');
        $('.cara').removeClass('seleccionado'); // Quitar selección al cerrar el modal
    });
});
</script>

<!-- <script>
$(document).ready(function() {
    // Cuando se hace clic en una carilla
    $('.carilla').on('click', function() {
        var carilla = $(this); // Referencia a la carilla seleccionada
        var etiqueta = carilla.data('etiqueta'); // Obtenemos la etiqueta (EX, EM, etc.)

        // Mostrar el modal
        $('#modalCarilla').modal('show');

        // Guardar la referencia de la carilla seleccionada para usarla después
        // Dentro de la función que maneja el click en la carilla y el guardado:
        $('#guardarCarilla').off('click').on('click', function() {
            var elementoComponente = $('#estadoCarilla')
        .val(); // Valor seleccionado en el modal

            // Aquí puedes guardar el elemento componente seleccionado y asociarlo al diente y la carilla
            console.log(
                `Guardado: Diente ${numeroDiente}, Carilla ${etiqueta}, Elemento Componente: ${elementoComponente}`
                );

            // Opcional: cambiar el color según el estado
            if (elementoComponente === "Por hacer") {
                carilla.style.backgroundColor = 'yellow';
            } else if (elementoComponente === "Encontrado") {
                carilla.style.backgroundColor = 'blue';
            } else if (elementoComponente === "Realizado") {
                carilla.style.backgroundColor = 'green';
            }

            // Cerrar el modal
            $('#modalCarilla').modal('hide');
        });

    });
});
</script> -->

<!-- <script>
    $(document).ready(function() {
    let carillaSeleccionada = null; // Variable global para guardar la carilla seleccionada

    // Evento para abrir el modal al hacer clic en una carilla
    $('.carilla').on('click', function() {
        carillaSeleccionada = $(this); // Guardamos la referencia de la carilla seleccionada
        var etiqueta = carillaSeleccionada.data('etiqueta'); // Obtenemos la etiqueta (EX, EM, etc.)
        var numeroDiente = carillaSeleccionada.data('diente'); // Número del diente

        // Llenar los inputs del modal con la información de la carilla seleccionada
        $('#numeroDiente').val(numeroDiente);
        $('#estadoCarilla').val(etiqueta);

        // Mostrar el modal
        $('#modalCarilla').modal('show');
    });

    // Evento para guardar el cambio de estado de la carilla
    $('#guardarCarilla').on('click', function() {
        if (!carillaSeleccionada) return; // Si no hay carilla seleccionada, salir

        var elementoComponente = $('#estadoCarillaSeleccionado').val(); // Estado seleccionado

        // Cambiar el color de la carilla seleccionada
        if (elementoComponente === "Por hacer") {
            carillaSeleccionada.css('background-color', 'yellow');
        } else if (elementoComponente === "Encontrado") {
            carillaSeleccionada.css('background-color', 'blue');
        } else if (elementoComponente === "Realizado") {
            carillaSeleccionada.css('background-color', 'green');
        }

        // Cerrar el modal
        $('#modalCarilla').modal('hide');
    });
});

</script> -->

<script src="<?=BASE?>views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/jszip/jszip.min.js"></script>
<script src="<?=BASE?>views/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=BASE?>views/plugins/moment/moment.min.js"></script>


<script src="<?=BASE?>views/dist/js/scripts/atenderCitas4.js?ver=1.1.1.15"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>