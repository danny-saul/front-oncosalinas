var tabla_diag = [];

_init();

function _init() {
    cargarHigienePieza();

    dt_cargarDatatabledDiagnostico13();
}

let IniciandoGuardarHigiente = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !IniciandoGuardarHigiente) {
    guardarHigienePieza();
    IniciandoGuardarHigiente = true;
  }
});


function guardarHigienePieza() {
    let id = localStorage.getItem('citas_id');
    $.ajax({
        url: urlServidor + 'citas/listarcitasxid/' + id,
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                let paciente_id = response.citas.paciente_id;

                // Acción al hacer clic en el botón "Guardar"
                $('#guardarBtnPiezaHigiente').click(function () {
                    let datosHigienePct = [];


                    $('input[name^="pie"]').each(function () {
                        let antecedenteId = $(this).attr('name').match(/\d+/)[0]; // Extraer el ID del antecedente
                        let respuesta2 = $('input[name="pie[' + antecedenteId + ']"]:checked').val();

                        if (respuesta2) {
                            datosHigienePct.push({
                                piezas_higiene_id: antecedenteId, // ✅ Ahora coincide con el backend
                                respuesta: respuesta2
                            });

                        }
                    });

                    if (datosHigienePct.length === 0) {

                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                            "positionClass": "toast-top-right",
                            "progressBar": true,
                        };

                        toastr["error"](response.mensaje, "Selecciona al menos una pieza antes de guardar.");



                        return;
                    }

                    // Realizar la solicitud AJAX para cada antecedente
                    $.ajax({
                        url: urlServidor + 'higiene/guardarpieza',
                        method: 'POST',
                        beforeSend: function (xhr) {
                            let token = localStorage.getItem('token');
                            if (token) {
                                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                            }
                        },
                        data: {
                            paciente_id: paciente_id,
                            antecedentes: datosHigienePct,
                        //    _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {

                            toastr.options = {
                                "closeButton": true,
                                "preventDuplicates": true,
                                "positionClass": "toast-top-right",
                                "progressBar": true,
                            };

                            toastr["success"](response.mensaje, "Antecedentes guardados con éxito.");





                            // Aquí puedes agregar código adicional para actualizar la interfaz de usuario si es necesario
                        },
                        error: function (xhr, status, error) {
                            console.error('Error al guardar la pieza:', error);

                            toastr.options = {
                                "closeButton": true,
                                "preventDuplicates": true,
                                "positionClass": "toast-top-right",
                                "progressBar": true,
                            };

                            toastr["error"](response.mensaje, "Hubo un problema al guardar la pieza. Por favor, inténtalo nuevamente.");



                        }
                    });
                });

            } else {
                console.log("Error al obtener datos del paciente.");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('❌ Error en la solicitud de cita:', error);
        }
    });
}


let IniciandoGuardarPieza = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !IniciandoGuardarPieza) {
    cargarHigienePieza();
    IniciandoGuardarPieza = true;
  }
});
function cargarHigienePieza() {
    let id = localStorage.getItem('citas_id');
    $.ajax({
        url: urlServidor + 'citas/listarcitasxid/' + id,
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                let paciente_id = response.citas.paciente_id;

                // Obtener antecedentes
                $.ajax({
                    url: urlServidor + 'higiene/obtener-piezahigiente/' + paciente_id,
                    method: 'GET',
                    beforeSend: function (xhr) {
                        let token = localStorage.getItem('token');
                        if (token) {
                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                        }
                    },
                    success: function (response) {
                        if (response && response.antecedentes) {
                            //           console.log(response);

                            // Limpiar selección antes de aplicar nuevas
                            $('input[name="pie"]').prop('checked', false);


                            // Recorrer los antecedentes y marcar los radio buttons
                            response.antecedentes.forEach(function (antecedente) {
                                $('input[name="pie"][value="' + antecedente.piezas_higiene_id + '"]').prop('checked', true);
                                if (antecedente.respuesta === 'Sí') {
                                    $('input[name="pie[' + antecedente.piezas_higiene_id + ']"][value="Sí"]').prop('checked', true);
                                } else if (antecedente.respuesta === 'No') {
                                    $('input[name="pie[' + antecedente.piezas_higiene_id + ']"][value="No"]').prop('checked', true);
                                }
                            });
                        }
                    },
                    error: function () {
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                            "positionClass": "toast-top-right",
                            "progressBar": true,
                        };

                        toastr["error"](response.mensaje, "Error al cargar los antecedentes.");



                    }
                });

            } else {
                console.log("Error al obtener datos del paciente.");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('❌ Error en la solicitud de cita:', error);
        }
    });
}


let IniciandoEnfP = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !IniciandoEnfP) {
    guardarEnfermedadPeriodontal();
    IniciandoEnfP = true;
  }
});

function guardarEnfermedadPeriodontal() {
    let id = localStorage.getItem('citas_id');
    $.ajax({
        url: urlServidor + 'citas/listarcitasxid/' + id,
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                let paciente_id = response.citas.paciente_id;

                $('#guardar-enfp1').click(function () {
                    let cita_id = localStorage.getItem('citas_id');

                    $.ajax({
                        url: urlServidor + 'citas/listarcitasxid/' + cita_id,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function (xhr) {
                            let token = localStorage.getItem('token');
                            if (token) {
                                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                            }
                        },
                        success: function (response) {
                            if (response.status) {
                                let paciente_id = response.citas.paciente_id;
                                let enfermedad_id = $('input[name="enfp"]:checked').val();

                                if (!enfermedad_id) {
                                    toastr["error"]("Selecciona una opción antes de guardar.");
                                    return;
                                }

                                let datosEnfermedadPerio = [{
                                    enfermedad_dientes_id: enfermedad_id,
                                    respuesta: "Sí"
                                }];

                                $.ajax({
                                    url: urlServidor + 'higiene/guardarenfp',
                                    method: 'POST',
                                    beforeSend: function (xhr) {
                                        let token = localStorage.getItem('token');
                                        if (token) {
                                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                                        }
                                    },
                                    data: {
                                        paciente_id: paciente_id,
                                        antecedentes: datosEnfermedadPerio
                                    },
                                    success: function (response) {
                                        toastr["success"](response.mensaje, "Guardado exitosamente");
                                    },
                                    error: function (xhr) {
                                        toastr["error"]("Error al guardar");
                                        console.error(xhr.responseText);
                                    }
                                });

                            } else {
                                console.log("Error al obtener datos del paciente.");
                            }
                        },
                        error: function (xhr) {
                            console.log("Error en la solicitud de cita", xhr);
                        }
                    });
                });


            } else {
                console.log("Error al obtener datos del paciente.");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('❌ Error en la solicitud de cita:', error);
        }
    });
}

let iniciandoEnfPerCar = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !iniciandoEnfPerCar) {
    cargarEnfermedadPeriodontal();
    iniciandoEnfPerCar = true;
  }
});

function cargarEnfermedadPeriodontal() {
    let id = localStorage.getItem('citas_id');
    $.ajax({
        url: urlServidor + 'citas/listarcitasxid/' + id,
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                let paciente_id = response.citas.paciente_id;

                // Obtener la enfermedad periodontal del paciente
                // Obtener antecedentes
                $.ajax({
                    url: urlServidor + 'higiene/obtener-enfermerdadperiodontal/' + paciente_id,

                    method: 'GET',
                    beforeSend: function (xhr) {
                        let token = localStorage.getItem('token');
                        if (token) {
                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                        }
                    },
                    success: function (response) {
                        if (response && response.antecedentes) {
                            //           console.log(response);

                            // Limpiar selección antes de aplicar nuevas
                            $('input[name="enfp"]').prop('checked', false);


                            // Recorrer los antecedentes y marcar los radio buttons
                            response.antecedentes.forEach(function (antecedente) {
                                $('input[name="enfp"][value="' + antecedente.enfermedad_dientes_id + '"]').prop('checked', true);
                                if (antecedente.respuesta === 'Sí') {
                                    $('input[name="enfp[' + antecedente.enfermedad_dientes_id + ']"][value="Sí"]').prop('checked', true);
                                } else if (antecedente.respuesta === 'No') {
                                    $('input[name="enfp[' + antecedente.enfermedad_dientes_id + ']"][value="No"]').prop('checked', true);
                                }
                            });
                        }
                    },
                    error: function () {
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                            "positionClass": "toast-top-right",
                            "progressBar": true,
                        };

                        toastr["error"](response.mensaje, "Error al cargar los antecedentes.");



                    }
                });

            } else {
                console.log("Error al obtener datos del paciente.");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('❌ Error en la solicitud de cita:', errorThrown);
        }
    });
}

let inciandoAngleG = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !inciandoAngleG) {
    guardarAngle();
    inciandoAngleG = true;
  }
});

function guardarAngle() {
    let id = localStorage.getItem('citas_id');
    $.ajax({
        url: urlServidor + 'citas/listarcitasxid/' + id,
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                let paciente_id = response.citas.paciente_id;

                $('#guardar-angle').click(function () {
                    let cita_id = localStorage.getItem('citas_id');

                    $.ajax({
                        url: urlServidor + 'citas/listarcitasxid/' + cita_id,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function (xhr) {
                            let token = localStorage.getItem('token');
                            if (token) {
                                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                            }
                        },
                        success: function (response) {
                            if (response.status) {
                                let paciente_id = response.citas.paciente_id;
                                let angle_id = $('input[name="angle"]:checked').val();

                                if (!angle_id) {
                                    toastr["error"]("Selecciona una opción antes de guardar.");
                                    return;
                                }

                                let datosangle = [{
                                    angle_id: angle_id,
                                    respuesta: "Sí"
                                }];

                                $.ajax({
                                    url: urlServidor + 'higiene/guardarAngle',
                                    method: 'POST',
                                    beforeSend: function (xhr) {
                                        let token = localStorage.getItem('token');
                                        if (token) {
                                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                                        }
                                    },
                                    data: {
                                        paciente_id: paciente_id,
                                        antecedentes: datosangle
                                    },
                                    success: function (response) {
                                        toastr["success"](response.mensaje, "Guardado exitosamente");
                                    },
                                    error: function (xhr) {
                                        toastr["error"]("Error al guardar");
                                        console.error(xhr.responseText);
                                    }
                                });

                            } else {
                                console.log("Error al obtener datos del paciente.");
                            }
                        },
                        error: function (xhr) {
                            console.log("Error en la solicitud de cita", xhr);
                        }
                    });
                });


            } else {
                console.log("Error al obtener datos del paciente.");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('❌ Error en la solicitud de cita:', error);
        }
    });
}

let iniciandoAngleC = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !iniciandoAngleC) {
    cargarAngle();
    iniciandoAngleC = true;
  }
});

function cargarAngle() {
    let id = localStorage.getItem('citas_id');
    $.ajax({
        url: urlServidor + 'citas/listarcitasxid/' + id,
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                let paciente_id = response.citas.paciente_id;

                // Obtener la enfermedad periodontal del paciente
                // Obtener antecedentes
                $.ajax({
                    url: urlServidor + 'higiene/obtenerAngle/' + paciente_id,

                    method: 'GET',
                    beforeSend: function (xhr) {
                        let token = localStorage.getItem('token');
                        if (token) {
                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                        }
                    },
                    success: function (response) {
                        //          console.log(response);
                        if (response && response.antecedentes) {

                            // Limpiar selección antes de aplicar nuevas
                            $('input[name="angle"]').prop('checked', false);


                            // Recorrer los antecedentes y marcar los radio buttons
                            response.antecedentes.forEach(function (antecedente) {
                                $('input[name="angle"][value="' + antecedente.angle_id + '"]').prop('checked', true);
                                if (antecedente.respuesta === 'Sí') {
                                    $('input[name="angle[' + antecedente.angle_id + ']"][value="Sí"]').prop('checked', true);
                                } else if (antecedente.respuesta === 'No') {
                                    $('input[name="angle[' + antecedente.angle_id + ']"][value="No"]').prop('checked', true);
                                }
                            });
                        }
                    },
                    error: function () {
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                            "positionClass": "toast-top-right",
                            "progressBar": true,
                        };

                        toastr["error"](response.mensaje, "Error al cargar los antecedentes.");



                    }
                });

            } else {
                console.log("Error al obtener datos del paciente.");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('❌ Error en la solicitud de cita:', errorThrown);
        }
    });
}


let IniciandoGuardarFluor = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !IniciandoGuardarFluor) {
    guardarFluor();
    IniciandoGuardarFluor = true;
  }
});

function guardarFluor() {
    let id = localStorage.getItem('citas_id');
    $.ajax({
        url: urlServidor + 'citas/listarcitasxid/' + id,
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                let paciente_id = response.citas.paciente_id;

                $('#guardar-fluor').click(function () {
                    let cita_id = localStorage.getItem('citas_id');

                    $.ajax({
                        url: urlServidor + 'citas/listarcitasxid/' + cita_id,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function (xhr) {
                            let token = localStorage.getItem('token');
                            if (token) {
                                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                            }
                        },
                        success: function (response) {
                            if (response.status) {
                                let paciente_id = response.citas.paciente_id;
                                let enfermedad_dientes_id = $('input[name="fluo"]:checked').val();

                                if (!enfermedad_dientes_id) {
                                    toastr["error"]("Selecciona una opción antes de guardar.");
                                    return;
                                }

                                let datosFluor = [{
                                    enfermedad_dientes_id: enfermedad_dientes_id,
                                    respuesta: "Sí"
                                }];

                                $.ajax({
                                    url: urlServidor + 'higiene/guardarFluor',
                                    method: 'POST',
                                    beforeSend: function (xhr) {
                                        let token = localStorage.getItem('token');
                                        if (token) {
                                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                                        }
                                    },
                                    data: {
                                        paciente_id: paciente_id,
                                        antecedentes: datosFluor
                                    },
                                    success: function (response) {
                                        toastr["success"](response.mensaje, "Guardado exitosamente");
                                    },
                                    error: function (xhr) {
                                        toastr["error"]("Error al guardar");
                                        console.error(xhr.responseText);
                                    }
                                });

                            } else {
                                console.log("Error al obtener datos del paciente.");
                            }
                        },
                        error: function (xhr) {
                            console.log("Error en la solicitud de cita", xhr);
                        }
                    });
                });


            } else {
                console.log("Error al obtener datos del paciente.");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('❌ Error en la solicitud de cita:', error);
        }
    });
}


let iniciandofLUOR = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !iniciandofLUOR) {
    cargarFluor();
    iniciandofLUOR = true;
  }
});


function cargarFluor() {
    let id = localStorage.getItem('citas_id');
    $.ajax({
        url: urlServidor + 'citas/listarcitasxid/' + id,
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                let paciente_id = response.citas.paciente_id;

                // Obtener la enfermedad periodontal del paciente
                // Obtener antecedentes
                $.ajax({
                    url: urlServidor + 'higiene/obtenerFluor/' + paciente_id,

                    method: 'GET',
                    beforeSend: function (xhr) {
                        let token = localStorage.getItem('token');
                        if (token) {
                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                        }
                    },
                    success: function (response) {
                        //          console.log(response);
                        if (response && response.antecedentes) {

                            // Limpiar selección antes de aplicar nuevas
                            $('input[name="fluo"]').prop('checked', false);


                            // Recorrer los antecedentes y marcar los radio buttons
                            response.antecedentes.forEach(function (antecedente) {
                                $('input[name="fluo"][value="' + antecedente.enfermedad_dientes_id + '"]').prop('checked', true);
                                if (antecedente.respuesta === 'Sí') {
                                    $('input[name="fluo[' + antecedente.enfermedad_dientes_id + ']"][value="Sí"]').prop('checked', true);
                                } else if (antecedente.respuesta === 'No') {
                                    $('input[name="fluo[' + antecedente.enfermedad_dientes_id + ']"][value="No"]').prop('checked', true);
                                }
                            });
                        }
                    },
                    error: function () {
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                            "positionClass": "toast-top-right",
                            "progressBar": true,
                        };

                        toastr["error"](response.mensaje, "Error al cargar los antecedentes.");



                    }
                });

            } else {
                console.log("Error al obtener datos del paciente.");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('❌ Error en la solicitud de cita:', errorThrown);
        }
    });
}

let IniciandoRecuDiag = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !IniciandoRecuDiag) {
    RecuperarDiagnosticoOdonto2ho();
    IniciandoRecuDiag = true;
  }
});


function RecuperarDiagnosticoOdonto2ho(selectedId = null) {
    $.ajax({
        url: urlServidor + 'odontograma/listardiagnostico',
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {
                let data = [{ id: 0, text: 'Seleccione el Diagnostico' }];
                response.diagnostico.forEach(element => {
                    data.push({ id: element.id, text: `${element.clave_od} - ${element.descripcion_od}` });
                });

                // Llenar el select con los datos
                $('#nuevo-diagnostico1o').empty().select2({
                    data: data,
                    width: '100%',

                });
            }
        },
        error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        }
    });
}


let inidiagTipocargar = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !inidiagTipocargar) {
    cargarTipo_diagnostico_o();
    inidiagTipocargar = true;
  }
});


function cargarTipo_diagnostico_o() {
    $.ajax({
        url: urlServidor + 'diagnostico/listartipo',
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            // Envía el token JWT en el encabezado Authorization
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            //   console.log(response);

            if (response.status) {
                let option = '<option value="0">Seleccione el tipo de diagnostico</option>';
                response.diagnostico.forEach(element => {
                    option += `<option value=${element.id}>${element.tipo_diagnostico} </option>`;
                });
                $('#tipo_diagnosticoo').html(option);
            }
        },
        error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        },
        complete: function (jqXHR, status) {
            // console.log('Petición realizada');
        }
    });
}

function dt_cargarDatatabledDiagnostico13() {


    let id = localStorage.getItem('citas_id');
    $.ajax({
        url: urlServidor + 'citas/listarcitasxid/' + id,
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {

                let paciente_id = response.citas.paciente_id;
       

                tabla_diag = $('#tabla-diagnostico1o').DataTable({
                    "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "aProcessing": true,//Activamos el procesamiento del datatables
                    "aServerSide": true,//Paginación y filtrado realizados por el servidor
                    "ajax":
                    {
                        url: urlServidor + 'odontograma/dtableeditardiagnosticoOdonto/' + paciente_id,
                        type: "get",
                        dataType: "json",
                        beforeSend: function (xhr) {
                            // Envía el token JWT en el encabezado Authorization
                            let token = localStorage.getItem('token');
                            if (token) {
                                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                            }
                        },
                        error: function (e) {
                            console.log(e.responseText);
                        }
                    },
                    destroy: true,
                    "iDisplayLength": 5,//Paginación
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
            
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        },
            
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
            
                    }//cerrando language
                });
              

            } else {
                console.log("Error al obtener datos del paciente.");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('❌ Error en la solicitud de cita:', error);
        }
    });
 
 
}

let iniciarCaTipoDiag = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !iniciarCaTipoDiag) {
    guardarNuevoDiagnosticoo();
    iniciarCaTipoDiag = true;
  }
});


function guardarNuevoDiagnosticoo() {


    $('#btn-agregar-diagnosticos-definitivoso').click(function () {



        let diagnostico_odonto_id = $('#nuevo-diagnostico1o option:selected').val();
        let odontograma_id = $('#odonto-id').val();
     
        if (diagnostico_odonto_id == "0") {
            Swal.fire({
                title: "Odontograma",
                text: 'Seleccione un diagnostico',
                icon: 'error'
            })
        } else {


            let diagnostico_odonto_id = $('#nuevo-diagnostico1o option:selected').val();
            let tipo_diagnostico_id = $('#tipo_diagnosticoo option:selected').val();
            let paciente_id = $('#paciente-id').val();


            let json = {
                odontograma_diagnostico: {

                    odontograma_id: parseInt(odontograma_id),
                    diagnostico_odonto_id: parseInt(diagnostico_odonto_id),
                    tipo_diagnostico_id: parseInt(tipo_diagnostico_id),
                    paciente_id: parseInt(paciente_id),

                    
                }

            };

            if (!validarnuevorecediagnostico(json)) {

                console.log("llene los campos de datos de persona");
            } else {
                //Realizar peticion ajax
                console.log(json);
                guardando_ediciondiagnosticoo(json);

            }

        }
    });

}



function validarnuevorecediagnostico(json) {
    let odontograma_diagnostico = json.odontograma_diagnostico;

    if (odontograma_diagnostico.diagnostico_odonto_id.length == 0) {
        Swal.fire({
            title: "Diagnosticos ",
            text: 'Seleccione un Diagnostico',
            icon: 'error'
        })

    } else
        if (odontograma_diagnostico.tipo_diagnostico_id.length == 0) {
            Swal.fire({
                title: "Diagnosticos",
                text: 'Ingrese una Tipo de Diagnostico',
                icon: 'error'
            })

        } else {
            return true;
        }



}

function guardando_ediciondiagnosticoo(json) {

    $.ajax({
        url: urlServidor + 'odontograma/guardar_edicionDiagnosticoO',
        type: 'POST',
        data: 'data=' + JSON.stringify(json),
        dataType: 'json',
        beforeSend: function (xhr) {
            // Envía el token JWT en el encabezado Authorization
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            //    console.log(response);


            if (response.estado) {

                Swal.fire({
                    title: "Medicamento Agregado Exitosamente",
                    text: response.mensaje,
                    icon: 'success'
                })
                dt_cargarDatatabledDiagnostico3();



            } else {


                Swal.fire({
                    title: "Edicion de Medicamento",
                    text: response.mensaje,
                    icon: 'error'
                })



            }
        },
        error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');

        }
    });






}


  
function dt_cargarDatatabledDiagnostico3() {

    let id = localStorage.getItem('citas_id');
  //  alert(id);
    
    $.ajax({
        url: urlServidor + 'citas/listarcitasxid/' + id,
        type: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function (response) {
            if (response.status) {

                let paciente_id = response.citas.paciente_id;
       //         alert(paciente_id);

                tabla_diag = $('#tabla-diagnostico1o').DataTable({
                    "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "aProcessing": true,//Activamos el procesamiento del datatables
                    "aServerSide": true,//Paginación y filtrado realizados por el servidor
                    "ajax":
                    {
                        url: urlServidor + 'odontograma/dtableeditardiagnosticoOdonto/' + paciente_id,
                        type: "get",
                        dataType: "json",
                        beforeSend: function (xhr) {
                            // Envía el token JWT en el encabezado Authorization
                            let token = localStorage.getItem('token');
                            if (token) {
                                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                            }
                        },
                        error: function (e) {
                            console.log(e.responseText);
                        }
                    },
                    destroy: true,
                    "iDisplayLength": 5,//Paginación
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
            
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        },
            
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
            
                    }//cerrando language
                });
              

            } else {
                console.log("Error al obtener datos del paciente.");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('❌ Error en la solicitud de cita:', error);
        }
    });
 
}

function eliminar_diagnostico_odonto(id){
    Swal.fire({
      title: '¿Estás seguro?',
      text: "Este diagnostico será anulado de la historia del paciente.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
  }).then((result) => {
      if (result.isConfirmed) {
          cambiar_estado222(id);
      }
  });
  }
  
   
  
  function cambiar_estado222(id) {
    $.ajax({
        url: urlServidor + 'odontograma/eliminarItemRDiagnostico/' + id, // Asegúrate de cambiar la ruta
        type: 'GET',
        dataType: 'json',
        beforeSend: function(xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        success: function(response) {
        
            if (response.status) {
  
              Swal.fire({
                title: "Odontograma",
                text: 'Se ha eliminado el diagnostico de la historia',
                icon: 'success'
            })
  
            dt_cargarDatatabledDiagnostico3();
              
            }
        },
        error: function(jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        }
    });
  }
  
 