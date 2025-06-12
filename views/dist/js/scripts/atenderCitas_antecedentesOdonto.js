_init();

function _init() {

   cargarAntecedentesOdPer();
  //  guardarAntecedentesPerOd();
   // guardarAntecedentesFamiliaresOd();
  //  cargarAntecedentesOdFam();
//    guardarAntecedentesEstomatognaticoOd();
  //  cargarAntecedentesOdEsto();
}

/**INCIIO DE ANTECEDENTES */
/**ANTECEDENTES PEROSNALES */


let IniciandoAnteOdPer = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !IniciandoAnteOdPer) {
    cargarAntecedentesOdPer();
    IniciandoAnteOdPer = true;
  }
});

function cargarAntecedentesOdPer() {
    let id = localStorage.getItem('citas_id');
    peticionJWT({
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
                peticionJWT({
                    url: urlServidor + 'odontoantecedente/obtener-antecedentes/' + paciente_id,
                    method: 'GET',
                    beforeSend: function (xhr) {
                        let token = localStorage.getItem('token');
                        if (token) {
                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                        }
                    },
                    success: function (response) {
                        if (response && response.antecedentes) {
                            // Limpiar selección antes de aplicar nuevas
                            $('input[name="antecedente"]').prop('checked', false);

                            // Recorrer los antecedentes y marcar los radio buttons
                            response.antecedentes.forEach(function (antecedente) {
                                $('input[name="antecedente"][value="' + antecedente.odonto_antecedentes_per_id + '"]').prop('checked', true);
                                if (antecedente.respuesta === 'Sí') {
                                    $('input[name="respuesta[' + antecedente.odonto_antecedentes_per_id + ']"][value="Sí"]').prop('checked', true);
                                } else if (antecedente.respuesta === 'No') {
                                    $('input[name="respuesta[' + antecedente.odonto_antecedentes_per_id + ']"][value="No"]').prop('checked', true);
                                }
                            });
                        }
                    },
                    error: function () {
                        alert('Error al cargar los antecedentes.');
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


let IniciandoGuardarAntePerOd = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !IniciandoGuardarAntePerOd) {
    guardarAntecedentesPerOd();
    IniciandoGuardarAntePerOd = true;
  }
});

function guardarAntecedentesPerOd() {
    let id = localStorage.getItem('citas_id');
    peticionJWT({
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
                $('#guardarBtn').click(function () {
                    let datosAntecedentes = [];

                    // Iterar sobre cada antecedente y capturar la respuesta seleccionada
                    $('input[name^="antecedente"]').each(function () {
                        let antecedenteId = $(this).val();
                        let respuesta = $('input[name="respuesta[' + antecedenteId + ']"]:checked').val();

                        if (respuesta) {
                            datosAntecedentes.push({
                                odonto_antecedentes_per_id: antecedenteId,
                                respuesta: respuesta
                            });
                        }
                    });

                    if (datosAntecedentes.length === 0) {
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                            "positionClass": "toast-top-right",
                            "progressBar": true,
                          };
                    
                        toastr["warning"](response.mensaje, "Selecciona al menos un antecedente antes de guardar");
                         
                        return;
                    }

                    // Realizar la solicitud AJAX para cada antecedente
                  peticionJWT({
    url: urlServidor + 'odontoantecedente/guardar', // sin slash final
    method: 'POST',
    beforeSend: function (xhr) {
        let token = localStorage.getItem('token');
        if (token) {
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
    },
    data: {
        paciente_id: paciente_id,
        antecedentes: datosAntecedentes
    },
    success: function (response) {
        toastr.options = {
            "closeButton": true,
            "preventDuplicates": true,
            "positionClass": "toast-top-right",
            "progressBar": true,
        };

        toastr["success"](response.mensaje, "Antecedentes guardados con éxito.");
    },
    error: function (xhr, status, error) {
        console.error('Error al guardar los antecedentes:', error);

        toastr.options = {
            "closeButton": true,
            "preventDuplicates": true,
            "positionClass": "toast-top-right",
            "progressBar": true,
        };

        if (xhr.responseJSON && xhr.responseJSON.mensaje) {
            toastr["error"](xhr.responseJSON.mensaje, "Hubo un problema al guardar los antecedentes. Por favor, inténtalo nuevamente.");
        } else {
            toastr["error"]("Error inesperado", "Hubo un problema al guardar los antecedentes.");
        }
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



/**ANTECEDENTE FFAMILIAR */


let IniciandoAnteOdFam = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !IniciandoAnteOdFam) {
    guardarAntecedentesFamiliaresOd();
    IniciandoAnteOdFam = true;
  }
});

function guardarAntecedentesFamiliaresOd() {
    let id = localStorage.getItem('citas_id');
    peticionJWT({
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
             $('#guardarBtnafm').off('click').on('click', function () {
    let datosAntecedentesFam = [];

    $('input[name^="respuesta_familiar"]').each(function () {
        let antecedenteId = $(this).attr('name').match(/\d+/)[0]; // Extraer el ID
        let respuesta2 = $('input[name="respuesta_familiar[' + antecedenteId + ']"]:checked').val();

        if (respuesta2) {
            datosAntecedentesFam.push({
                odonto_antecedentes_fam_id: antecedenteId,
                respuesta: respuesta2
            });
        }
    });

    if (datosAntecedentesFam.length === 0) {
        toastr.options = {
            "closeButton": true,
            "preventDuplicates": true,
            "positionClass": "toast-top-right",
            "progressBar": true,
        };

        toastr["error"]("Selecciona al menos un antecedente antes de guardar.", "Atención");
        return;
    }

    peticionJWT({
        url: urlServidor + 'odontoantecedente/guardarAFamiliares',
        method: 'POST',
        beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        },
        data: {
            paciente_id: paciente_id,
            antecedentes: datosAntecedentesFam
        },
        success: function (response) {
            toastr.options = {
                "closeButton": true,
                "preventDuplicates": true,
                "positionClass": "toast-top-right",
                "progressBar": true,
            };

            toastr["success"](response.mensaje, "Antecedentes guardados con éxito.");
        },
        error: function (xhr, status, error) {
            console.error('Error al guardar los antecedentes:', error);

            toastr.options = {
                "closeButton": true,
                "preventDuplicates": true,
                "positionClass": "toast-top-right",
                "progressBar": true,
            };

            if (xhr.responseJSON && xhr.responseJSON.mensaje) {
                toastr["error"](xhr.responseJSON.mensaje, "Hubo un problema al guardar los antecedentes.");
            } else {
                toastr["error"]("Error inesperado", "Hubo un problema al guardar los antecedentes.");
            }
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



let IniciandoAnteOdCargarFam = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !IniciandoAnteOdCargarFam) {
    cargarAntecedentesOdFam();
    IniciandoAnteOdCargarFam = true;
  }
});


function cargarAntecedentesOdFam() {
    let id = localStorage.getItem('citas_id');
    peticionJWT({
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
                peticionJWT({
                    url: urlServidor + 'odontoantecedente/obtener-antecedentesFam/' + paciente_id,
                    method: 'GET',
                    beforeSend: function (xhr) {
                        let token = localStorage.getItem('token');
                        if (token) {
                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                        }
                    },
                    success: function (response) {
                        if (response && response.antecedentes) {
                            // Limpiar selección antes de aplicar nuevas
                            $('input[name="respuesta_familiar"]').prop('checked', false);
            
                            
                            // Recorrer los antecedentes y marcar los radio buttons
                            response.antecedentes.forEach(function (antecedente) {
                                $('input[name="respuesta_familiar"][value="' + antecedente.odonto_antecedentes_fam_id + '"]').prop('checked', true);
                                if (antecedente.respuesta === 'Sí') {
                                    $('input[name="respuesta_familiar[' + antecedente.odonto_antecedentes_fam_id + ']"][value="Sí"]').prop('checked', true);
                                } else if (antecedente.respuesta === 'No') {
                                    $('input[name="respuesta_familiar[' + antecedente.odonto_antecedentes_fam_id + ']"][value="No"]').prop('checked', true);
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



/**ANTECEEDENTE ESTOMATOGNATICO */

let iniciandoGuardarAnteEsto = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !iniciandoGuardarAnteEsto) {
    guardarAntecedentesEstomatognaticoOd();
    iniciandoGuardarAnteEsto = true;
  }
});



function guardarAntecedentesEstomatognaticoOd() {
    let id = localStorage.getItem('citas_id');
    peticionJWT({
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

                $('#guardarBtnesto').off('click').on('click', function () {
                    let datosAntecedentesEsto = [];

                    $('input[name^="respuesta_esto"]').each(function () {
                        let antecedenteId = $(this).attr('name').match(/\d+/)[0];
                        let respuesta3 = $('input[name="respuesta_esto[' + antecedenteId + ']"]:checked').val();

                        if (respuesta3) {
                            datosAntecedentesEsto.push({
                                odonto_estomatognatico_id: antecedenteId,
                                respuesta: respuesta3
                            });
                        }
                    });

                    if (datosAntecedentesEsto.length === 0) {
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                            "positionClass": "toast-top-right",
                            "progressBar": true,
                        };
                        toastr["error"]("Selecciona al menos un antecedente antes de guardar.", "Atención");
                        return;
                    }

                    peticionJWT({
                        url: urlServidor + 'odontoantecedente/guardarAesto',
                        method: 'POST',
                        beforeSend: function (xhr) {
                            let token = localStorage.getItem('token');
                            if (token) {
                                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                            }
                        },
                        data: {
                            paciente_id: paciente_id,
                            antecedentes: datosAntecedentesEsto
                        },
                        success: function (response) {
                            toastr.options = {
                                "closeButton": true,
                                "preventDuplicates": true,
                                "positionClass": "toast-top-right",
                                "progressBar": true,
                            };
                            toastr["success"](response.mensaje, "Antecedentes guardados con éxito.");
                        },
                        error: function (xhr, status, error) {
                            console.error('Error al guardar los antecedentes:', error);

                            toastr.options = {
                                "closeButton": true,
                                "preventDuplicates": true,
                                "positionClass": "toast-top-right",
                                "progressBar": true,
                            };

                            if (xhr.responseJSON && xhr.responseJSON.mensaje) {
                                toastr["error"](xhr.responseJSON.mensaje, "Hubo un problema al guardar los antecedentes.");
                            } else {
                                toastr["error"]("Error inesperado", "Hubo un problema al guardar los antecedentes.");
                            }
                        }
                    });
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


let IniciadnoCargarAnteodEsto = false;

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  const targetTab = $(e.target).attr('href');

  if (targetTab === '#tab_13' && !IniciadnoCargarAnteodEsto) {
    cargarAntecedentesOdEsto();
    IniciadnoCargarAnteodEsto = true;
  }
});


function cargarAntecedentesOdEsto() {
    let id = localStorage.getItem('citas_id');
    peticionJWT({
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
                peticionJWT({
                    url: urlServidor + 'odontoantecedente/obtener-antecedentesEsto/' + paciente_id,
                    method: 'GET',
                    beforeSend: function (xhr) {
                        let token = localStorage.getItem('token');
                        if (token) {
                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                        }
                    },
                    success: function (response) {
                        if (response && response.antecedentes) {
                            // Limpiar selección antes de aplicar nuevas
                            $('input[name="respuesta_esto"]').prop('checked', false);
            
                  //          console.log(response);
                            
                            // Recorrer los antecedentes y marcar los radio buttons
                            response.antecedentes.forEach(function (antecedente) {
                                $('input[name="respuesta_esto"][value="' + antecedente.odonto_estomatognatico_id + '"]').prop('checked', true);
                                if (antecedente.respuesta === 'Sí') {
                                    $('input[name="respuesta_esto[' + antecedente.odonto_estomatognatico_id + ']"][value="Sí"]').prop('checked', true);
                                } else if (antecedente.respuesta === 'No') {
                                    $('input[name="respuesta_esto[' + antecedente.odonto_estomatognatico_id + ']"][value="No"]').prop('checked', true);
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
