jQuery(function(){

    var caraSeleccionada = null;
 

	function drawDiente(svg, parentGroup, diente){
		if(!diente) throw new Error('Error no se ha especificado el diente.');
		
		var x = diente.x || 0,
			y = diente.y || 0;
		
		var defaultPolygon = {fill: 'white', stroke: 'navy', strokeWidth: 0.5};
       
		var dienteGroup = svg.group(parentGroup, {transform: 'translate(' + x + ',' + y + ')'});

		var caraSuperior = svg.polygon(dienteGroup,
			[[0,0],[20,0],[15,5],[5,5]],  
		    defaultPolygon);
	    caraSuperior = $(caraSuperior).data('cara', 'S');
		
		var caraInferior =  svg.polygon(dienteGroup,
			[[5,15],[15,15],[20,20],[0,20]],  
		    defaultPolygon);			
		caraInferior = $(caraInferior).data('cara', 'I');

		var caraDerecha = svg.polygon(dienteGroup,
			[[15,5],[20,0],[20,20],[15,15]],  
		    defaultPolygon);
	    caraDerecha = $(caraDerecha).data('cara', 'D');
		
		var caraIzquierda = svg.polygon(dienteGroup,
			[[0,0],[5,5],[5,15],[0,20]],  
		    defaultPolygon);
		caraIzquierda = $(caraIzquierda).data('cara', 'Z');		    
		
		var caraCentral = svg.polygon(dienteGroup,
			[[5,5],[15,5],[15,15],[5,15]],  
		    defaultPolygon);	
		caraCentral = $(caraCentral).data('cara', 'C');		    
	    
	    var caraCompleto = svg.text(dienteGroup, 6, 30, diente.id.toString(), 
	    	{fill: 'navy', stroke: 'navy', strokeWidth: 0.1, style: 'font-size: 6pt;font-weight:normal'});
    	caraCompleto = $(caraCompleto).data('cara', 'X');
    	
		//Busco los tratamientos aplicados al diente
		var tratamientosAplicadosAlDiente = ko.utils.arrayFilter(vm.tratamientosAplicados(), function(t){
			return t.diente.id == diente.id;
		});
		var caras = [];
		caras['S'] = caraSuperior;
		caras['C'] = caraCentral;
		caras['X'] = caraCompleto;
		caras['Z'] = caraIzquierda;
		caras['D'] = caraDerecha;

		for (var i = tratamientosAplicadosAlDiente.length - 1; i >= 0; i--) {
			var t = tratamientosAplicadosAlDiente[i];
			caras[t.cara].attr('fill', 'red');
		};

		// $.each([caraCentral, caraIzquierda, caraDerecha, caraInferior, caraSuperior, caraCompleto], function(index, value){
	    // 	value.click(function(){
	    // 		var me = $(this);
	    // 		var cara = me.data('cara');
				
		// 		if(!vm.tratamientoSeleccionado()){
		// 			alert('Debe seleccionar un tratamiento previamente.');	
		// 			return false;
		// 		}

		// 		//Validaciones
		// 		//Validamos el tratamiento
		// 		var tratamiento = vm.tratamientoSeleccionado();

		// 		if(cara == 'X' && !tratamiento.aplicaDiente){
		// 			alert('El tratamiento seleccionado no se puede aplicar a toda la pieza.');
		// 			return false;
		// 		}
		// 		if(cara != 'X' && !tratamiento.aplicaCara){
		// 			alert('El tratamiento seleccionado no se puede aplicar a una cara.');
		// 			return false;
		// 		}
		// 		//TODO: Validaciones de si la cara tiene tratamiento o no, etc...

		// 		vm.tratamientosAplicados.push({diente: diente, cara: cara, tratamiento: tratamiento});
		// 		vm.tratamientoSeleccionado(null);
				
		// 		//Actualizo el SVG
		// 		renderSvg();
	    // 	}).mouseenter(function(){
	    // 		var me = $(this);
	    // 		me.data('oldFill', me.attr('fill'));
	    // 		me.attr('fill', 'yellow');
	    // 	}).mouseleave(function(){
	    // 		var me = $(this);
	    // 		me.attr('fill', me.data('oldFill'));
	    // 	});			
		// });

        $.each([caraCentral, caraIzquierda, caraDerecha, caraInferior, caraSuperior, caraCompleto], function(index, value){
            value.click(function(){
                var me = $(this);
                var cara = me.data('cara');
    
        
                // Guardar la cara seleccionada y cambiar su color
                caraSeleccionada = me;
                caraSeleccionada.attr('fill', 'blue');
        
                // Aquí puedes ajustar el contenido del modal según tus necesidades
                $('#observacionesModal').modal('show');
        
              //Actualizo el SVG
				renderSvg();
            }).mouseenter(function(){
                var me = $(this);
	    		me.data('oldFill', me.attr('fill'));
	    		me.attr('fill', 'yellow');
            }).mouseleave(function(){
                var me = $(this);
	    		me.attr('fill', me.data('oldFill'));
            });          
        });
	};

	function renderSvg(){
		console.log('update render');

		var svg = $('#odontograma').svg('get').clear();
		var parentGroup = svg.group({transform: 'scale(1.5)'});
		var dientes = vm.dientes();
		for (var i =  dientes.length - 1; i >= 0; i--) {
			var diente =  dientes[i];
			var dienteUnwrapped = ko.utils.unwrapObservable(diente); 
			drawDiente(svg, parentGroup, dienteUnwrapped);
		};
	}

    function guardarObservaciones() {

       

        let id = localStorage.getItem('citas_id');
       peticionJWT({
            url: urlServidor + 'citas/listarcitasxid/' + id,
            type: 'GET',
            dataType: 'json',
            beforeSend: function(xhr) {
              // Envía el token JWT en el encabezado Authorization
              let token = localStorage.getItem('token');
              if (token) {
                  xhr.setRequestHeader('Authorization', 'Bearer ' + token);
              }
          },
            success: function (response) {
                if (response.status) {
                      // Si hay una cara seleccionada, mantener su color después de guardar las observaciones
                    if (caraSeleccionada) {
                        caraSeleccionada.attr('fill', 'blue'); // Puedes cambiar el color aquí si lo deseas
                    }

                    let paciente_id = response.citas.paciente_id;
                    let doctor_id = response.citas.doctor_id;
                    let  observaciones = $('#observacionesTextarea').val();

                   let diagnosticoscie10_id = $('#odontograma-enfermedad option:selected').val();
                   let tipo_estudio_id = $('#odontograma-procedimiento option:selected').val();
                   let tratamiento_odontograma_id = $('#tratamiento-odonto option:selected').val();



                     // Obteniendo el número de la cara seleccionada
                    let num_cara;
                    let cuadrante;
                    // Mapeo de la cara seleccionada a un número
                    switch (caraSeleccionada.data('cara')) {
                        case 'S':
                            num_cara = 1;
                            cuadrante = 'Superior';
                            break;
                        case 'I':
                            num_cara = 2;
                            cuadrante = 'Inferior';
                            break;
                        case 'Z':
                            num_cara = 3;
                            cuadrante = 'Izquierda';
                        break;
                        case 'D':
                            num_cara = 4;
                            cuadrante = 'Derecha';
                        break;
                        case 'C':
                            num_cara = 5;
                            cuadrante = 'Central';
                        break;
                        // Agrega más casos según sea necesario
                        default:
                            num_cara = null; // Si no se puede mapear a un número válido
                    }
                    // Obteniendo el color del botón seleccionado
                    let color = '#0000'; // Si no hay color seleccionado, establecerá un color predeterminado

                    // Obteniendo el diente al que pertenece la cara seleccionada
        // let diente;
        // switch (caraSeleccionada.data('cara')) {
        //     case 'S':
        //     case 'I':
        //         diente = 'Incisivo';
        //         break;
        //     case 'C':
        //     case 'Z':
        //         diente = 'Canino';
        //         break;
        //     case 'D':
        //         diente = 'Premolar';
        //         break;
        //     default:
        //         diente = 'Molar';
        //         break;
        // }

        // // Obteniendo la pieza dental según el diente y su posición en la boca
        // let pieza;
        // if (diente === 'Incisivo') {
        //     pieza = 'Incisivo';
        // } else if (diente === 'Canino') {
        //     if (caraSeleccionada.data('cara') === 'C') {
        //         pieza = 'Canino Superior';
        //     } else {
        //         pieza = 'Canino Inferior';
        //     }
        // } else if (diente === 'Premolar') {
        //     if (caraSeleccionada.data('cara') === 'D') {
        //         pieza = 'Primer Premolar Superior';
        //     } else {
        //         pieza = 'Primer Premolar Inferior';
        //     }
        // } else {
        //     if (caraSeleccionada.data('cara') === 'D') {
        //         pieza = 'Primer Molar Superior';
        //     } else {
        //         pieza = 'Primer Molar Inferior';
        //     }
        // }

        // console.log('Pieza dental: ' + pieza);

                   
                  
                    let json = {
                        odontograma: {
                            paciente_id: paciente_id,
                            doctor_id:doctor_id,
                            observacion: observaciones,
                            num_cara: num_cara,
                            cuadrante : cuadrante,
                            color: color,
                            diagnosticoscie10_id:diagnosticoscie10_id,
                            tipo_estudio_id:tipo_estudio_id,
                            tratamiento_odontograma_id:tratamiento_odontograma_id,
                            
                        }
                    };
  
                  
                    console.log(json);
  
                    guardandoOodontograma(json);
  
                } else {
                    console.log("Error al obtener datos de la cita");
                }
            },
            error: function (jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            }
        });
       
        // Cierra el modal después de guardar las observaciones
        $('#observacionesModal').modal('hide');
    }

    

    function guardandoOodontograma(json){
       peticionJWT({
            url: urlServidor + 'odontograma/guardar',
            type: 'POST',
            data: 'data=' + JSON.stringify(json),
            dataType: 'json',
            beforeSend: function(xhr) {
                // Envía el token JWT en el encabezado Authorization
                let token = localStorage.getItem('token');
                if (token) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                }
            },
            success: function (response) {
                //    console.log(response);
            
    
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        text: 'Odontograma',
                        icon: 'success'
                    })
              
            
                 /*    $('#nuevo-usuario')[0].reset();
                    setTimeout(function () {
                        location.reload();
                      }, 1000); */
                  //  cargarTabla();
                   // $('#modal-registro-usuario').modal('hide');
                } else {
                    Swal.fire({
                        title: response.message,
                        text: 'Odontograma',
                        icon: 'error'
                    })
              
            
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
    

    // Evento de clic para el botón "Guardar"
    $('#guardarObservacionesBtn').click(function() {
        guardarObservaciones();
    });
    

	//View Models
	function DienteModel(id, x, y){
		var self = this;

		self.id = id;	
		self.x = x;
		self.y = y;		
	};

	function ViewModel(){
		var self = this;

		self.tratamientosPosibles = ko.observableArray([]);
		self.tratamientoSeleccionado = ko.observable(null);
		self.tratamientosAplicados = ko.observableArray([]);

		self.quitarTratamiento = function(tratamiento){
			self.tratamientosAplicados.remove(tratamiento);
			renderSvg();
		}

		//Cargo los dientes
		var dientes = [];
		//Dientes izquierdos
		for(var i = 0; i < 8; i++){
			dientes.push(new DienteModel(18 - i, i * 25, 0));	
		}
		for(var i = 3; i < 8; i++){
			dientes.push(new DienteModel(55 - i, i * 25, 1 * 40));	
		}
		for(var i = 3; i < 8; i++){
			dientes.push(new DienteModel(85 - i, i * 25, 2 * 40));	
		}
		for(var i = 0; i < 8; i++){
			dientes.push(new DienteModel(48 - i, i * 25, 3 * 40));	
		}
		//Dientes derechos
		for(var i = 0; i < 8; i++){
			dientes.push(new DienteModel(21 + i, i * 25 + 210, 0));	
		}
		for(var i = 0; i < 5; i++){
			dientes.push(new DienteModel(61 + i, i * 25 + 210, 1 * 40));	
		}
		for(var i = 0; i < 5; i++){
			dientes.push(new DienteModel(71 + i, i * 25 + 210, 2 * 40));	
		}
		for(var i = 0; i < 8; i++){
			dientes.push(new DienteModel(31 + i, i * 25 + 210, 3 * 40));	
		}

		self.dientes = ko.observableArray(dientes);
	};

	vm = new ViewModel();
	
	//Inicializo SVG
    $('#odontograma').svg({
        settings: {
            width: '1000px', // Modifica este valor según sea necesario
            height: '500px'  // Modifica este valor según sea necesario
        }
    });


 

    

	ko.applyBindings(vm);

	//TODO: Cargo el estado del odontograma
	renderSvg();

});