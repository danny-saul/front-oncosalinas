<?php

namespace App\Http\Controllers;

use App\Models\Aislamiento;
use App\Models\Certificados_Medicos;
use App\Models\Citas;
use App\Models\Examen_Fisica;
use App\Models\Historial_Clinico;
use App\Models\Paciente;
use App\Models\Receta;
use App\Models\Receta_Detalle;
use App\Models\Receta_Diagnostico;
use App\Models\Tipo_Contingencia;
use App\Models\Usuario;
use Illuminate\Http\Request;

class CitasController extends Controller
{
    private $limite = 5;

    private function generar_codigo($limit)
    {
        $key = '';

        $aux = sha1(md5(time()));
        $key = substr($aux, 0, $limit);

        return $key;
    }

    public function guardarCitas(Request $request)
    {
        $data = json_decode($request['data']);
        $dataCita = $data->citas;
        $requestcitaservicios = $data->citas_servicios;


        $new_orden = $this->generar_codigo($this->limite);

        $response = [];



        if ($dataCita) {

            $existecodigocita = Citas::where('codigo_cita', $new_orden)->get()->first();

            if ($existecodigocita) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El numero de la orden ya existe',
                    'citas' => null,
                    'citas_servicios' => null,

                ];
            } else {
                $nuevaCita = new Citas();
                $nuevaCita->paciente_id = intval($dataCita->paciente_id);

                $nuevaCita->doctor_id = intval($dataCita->doctor_id);
                $nuevaCita->codigo_cita = $new_orden;
                $nuevaCita->estado_cita_id = 1;
                $nuevaCita->doctor_horario_id =  intval($dataCita->doctor_horario_id);
                $nuevaCita->fecha = $dataCita->fecha;
                $nuevaCita->total = floatval($dataCita->total_parcial);
                $nuevaCita->libre = 'O';
                $nuevaCita->estado = 'A';

                //validar hora
                $horaocupado = Citas::where('fecha', $dataCita->fecha)->where('doctor_horario_id', $dataCita->doctor_horario_id)->where('libre', 'O')->get()->first();
                if ($horaocupado) {
                    $response = [
                        'status' => false,
                        'mensaje' => 'la hora que desea, ya esta ocupada!! escoja otra hora',
                    ];
                } else {

                    if ($nuevaCita->save()) {
                        $citasServiciosController = new Citas_ServiciosController();
                        $citas_ordenesServicios = $citasServiciosController->guardar_citas_servicios($nuevaCita->id, $requestcitaservicios);

                        $persona = $nuevaCita->paciente->persona;
                        $usuario = Usuario::where('persona_id', $persona->id)->first();
                        $nombres = $persona->nombre . ' ' . $persona->apellido;
                        $mailer = new MailController($usuario->correo, $nombres);

                        if ($mailer->sedMailCita($nuevaCita)) {
                            // echo "Enviado";
                        }


                        $response = [
                            'status' => true,
                            'mensaje' => 'Guardando los datos',
                            'citas' => $nuevaCita,
                            'citas_servicios' => $citas_ordenesServicios,
                        ];
                    } else {
                        $response = [
                            'status' => false,
                            'mensaje' => 'no se ha guardado ',
                            'citas' => null,
                            //      'citas_servicios' => null,
                        ];
                    }
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datods',
                'citas' => null,
                // 'citas_servicios' => null,

            ];
        }
        return response()->json($response);
    }

    public function crearCitas(Request $request)
    {
        $data = json_decode($request['data']);
        $dataCita = $data->citas;



        $new_orden = $this->generar_codigo($this->limite);

        $response = [];



        if ($dataCita) {

            $existecodigocita = Citas::where('codigo_cita', $new_orden)->get()->first();

            if ($existecodigocita) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El numero de la orden ya existe',
                    'citas' => null,
                    'citas_servicios' => null,

                ];
            } else {
                $nuevaCita = new Citas();
                $nuevaCita->paciente_id = intval($dataCita->paciente_id);

                $nuevaCita->doctor_id = intval($dataCita->doctor_id);
                $nuevaCita->codigo_cita = $new_orden;
                $nuevaCita->estado_cita_id = 1;
                $nuevaCita->doctor_horario_id =  1;
                $nuevaCita->fecha = $dataCita->fecha;
                $nuevaCita->total = floatval($dataCita->total_parcial);
                $nuevaCita->libre = 'S';
                $nuevaCita->estado = 'A';



                if ($nuevaCita->save()) {
                    $citasServiciosController = new Citas_ServiciosController();
                    $citas_ordenesServicios = $citasServiciosController->guardar_citas_serviciosCrear($nuevaCita->id);

                    /*   $persona = $nuevaCita->paciente->persona;
                        $usuario = Usuario::where('persona_id', $persona->id)->first();
                        $nombres = $persona->nombre . ' ' . $persona->apellido;
                        $mailer = new MailController($usuario->correo, $nombres);

                        if ($mailer->sedMailCita($nuevaCita)) {
                            // echo "Enviado";
                        }
     */

                    $response = [
                        'status' => true,
                        'mensaje' => 'Guardando los datos',
                        'citas' => $nuevaCita,
                        'citas_servicios' => $citas_ordenesServicios,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'no se ha guardado ',
                        'citas' => null,
                        //      'citas_servicios' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datods',
                'citas' => null,
                // 'citas_servicios' => null,

            ];
        }
        return response()->json($response);
    }
    public function datatablelistarxmedico($medicoId)
    {

        $medico_id = intval($medicoId);
        $cita = Citas::where('doctor_id', $medico_id)->where('estado_cita_id', '1')->orderBy('fecha', 'DESC')->get();
        $data = [];
        $i = 1;

        foreach ($cita as $citasc) {
            $codigocita = $citasc->codigo_cita;
            $cedula = $citasc->paciente->persona->cedula;

            $cli = $citasc->paciente->persona;
            $doc = $citasc->doctor->persona;
            $esp = $citasc->doctor->especialidades->nombre_especialidad;
            //$serv = $citasc->servicios->nombre_servicio;
            $hor = substr($citasc->doctor_horario->hora_inicio, 0, -3) . ' - ' .  substr($citasc->doctor_horario->hora_fin, 0, -3);
            $dataEstadoCita = $citasc->estado_cita;
            $dataFechaCita  = $citasc->fecha;
            $estado = $citasc->estado_cita_id;
            $horaregistrada = date('Y-m-d H:i:s', strtotime($citasc->created_at));

            // Formatear la fecha de manera dinámica
            $fechaFormateada = date('l j-m-Y', strtotime($dataFechaCita));

            // Cambiar los nombres de los días de la semana a español
            $fechaFormateada = str_replace(
                ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                $fechaFormateada
            );



            $other = $citasc->estado_cita_id == 1 ? 2 : 1;
            $disabled = $citasc->estado_cita_id == 2 ? 'disabled' : ' ';
            $disabledCancelar = $citasc->estado_cita_id == 3 ? 'disabled' : ' ';

            if ($estado == 1) {
                $estado = '<span class="badge bg-warning" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            } else if ($estado == 2) {
                $estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            } else {
                $estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            }

            $botones = '<div class="">
                         <button class="btn btn-sm btn-success" onclick="atender(' . $citasc->id . ', ' . $citasc->paciente_id . ')" title="Atender Cita">
                                <i class="fa fa-eye"></i> Atender
                            </button>

                            <button  class="btn btn-sm btn-danger " onclick="cancelar_cita(' . $citasc->id . ',' . $other . ')" title="Cancelar Cita">
                                <i class="fas fa-times"></i> Cancelar Cita
                            </button>


                          
                        </div>';

            $data[] = [
                0 => $i,
                1 => $codigocita,
                2 => $horaregistrada,
                3 => $cedula,
                4 => $cli->nombre . ' ' . $cli->apellido,
                5 => $doc->nombre . ' ' . $doc->apellido,
                6 => $esp,
                7 => $fechaFormateada,
                8 => $hor,
                9 => $estado,
                10 => $botones,
            ];
            $i++;
        }

        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];

        return response()->json($result, 200);
    }

    /*listar ciats x id  */
    public function listar_citaxID($id)
    {
        $idCitas = intval($id);
        $citas = Citas::find($idCitas);

        $response = [];

        if ($citas == null) {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para mostrar',
                'citas' => null,
            ];
        } else {
            $valor = 0;

            foreach ($citas->citas_servicios as $serv) {
                $serv->servicios;
            }
            foreach ($citas->receta as $rece) {
                $rece->producto;
                $rece->dosis;
                $rece->frecuencia;
                foreach ($rece->receta_diagnostico as $recediag) {
                    $recediag->diagnosticocie10;
                    $recediag->tipo_diagnostico;
                }
            }

            foreach ($citas->receta_diagnostico as $rece) {
                $rece->diagnosticocie10;
                $rece->tipo_diagnostico;
            }

            foreach ($citas->historial_clinico as $historial) {
                $historial->citas;
                $historial->lateralidad;
            }

            foreach ($citas->ordenes as $orden) {
                $orden->tipo_estudio;
            }

            foreach ($citas->laboratorio as $lab) {
                $lab->tipo_examen;
            }

            foreach ($citas->certificados_medicos as $cert) {
                $cert->aislamiento;
                $cert->tipo_contingencia;
            }

            foreach ($citas->examen_fisica as $exa) {
                $exa->citas;
            }


            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'valor' => $valor,
                'citas' => $citas,
                'servicios' => $citas->citas_servicios,
                'paciente_id' => $citas->paciente->persona->id,
                'medico_id' => $citas->doctor->persona->id,
                'estado_orden_id' => $citas->estado_cita->id,
                //  'receta' => $citas->receta       
            ];
        }

        return response()->json($response);
    }

/*     public function guardando_atencion_medicaAnterior(Request $request)
    {

        $aux = json_decode($request['data']);
        $HistorialClinicoRequest = $aux->historial_clinico;
        $recetaRequest = $aux->receta;
        $requestrecetadiagnostico = $aux->receta_diagnostico;
        $requestOrden = $aux->orden;

        $response = [];

        $citas_id = intval($HistorialClinicoRequest->citas_id);
        if ($HistorialClinicoRequest) {

            $nuevoHC = new Historial_Clinico();
            $nuevoHC->citas_id = $citas_id;
            $nuevoHC->motivo_consulta = $HistorialClinicoRequest->motivo_consulta;
            $nuevoHC->antecedentes = $HistorialClinicoRequest->antecedentes;
            $nuevoHC->evolucion = $HistorialClinicoRequest->evolucion;
            $nuevoHC->enfermedad_actual = $HistorialClinicoRequest->enfermedad_actual;
            $nuevoHC->alergias = $HistorialClinicoRequest->alergias;
            $nuevoHC->fecha = date('Y-m-d');
            $nuevoHC->estado = 'A';

            $existeNumeroHistorial = Historial_Clinico::where('id', $citas_id)->get()->first();

            if ($existeNumeroHistorial) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El número ya existe',
                    'historial_clinico' => null,
                    'receta' => null,


                ];
            } else {
                if ($nuevoHC->save()) {
                    //guardar en la tabla receta
                    if (!empty($recetaRequest)) {
                        $recetaController = new RecetaController();
                        $extraReceta = $recetaController->guardarReceta($citas_id, $recetaRequest);
                        $recetaId = $extraReceta->original['receta']['id'];
                        //    return response()->json($recetaId); die();
                    }

                    $recetaDiagnosticos = new Receta_DiagnosticosController();
                    $receta_diagnosticosController = $recetaDiagnosticos->guardar_recetas_diagnosticos($recetaId, $requestrecetadiagnostico);

                    //guarda en la tabla orden
                    $ordenController = new OrdenController();
                    $extraOrdenController = $ordenController->guardarOrden($nuevoHC->id, $requestOrden);

                    // Cambiar el estado_cita_id de la tabla citas a 2
                    Citas::where('id', $citas_id)->update(['estado_cita_id' => 2]);


                    $response = [
                        'status' => true,
                        'mensaje' => 'Se guardo correctamente',
                        'historial_clinico' => $nuevoHC,
                        'receta' => $extraReceta,
                        //    'receta_diagnostico' => $receta_diagnosticosController,

                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se pudo guardar :(',
                        'historial_clinico' => null,
                        'receta' => null,
                        'receta_diagnostico' => null,

                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'historial_clinico' => null,
            ];
        }

        return response()->json($response, 200);
    } */

    public function guardando_atencion_medica2(Request $request)
    {

        $aux = json_decode($request['data']);
        $HistorialClinicoRequest = $aux->historial_clinico;
        $recetaRequest = $aux->receta;
        $requestrecetadiagnostico = $aux->receta_diagnostico;
        $requestOrden = $aux->orden;

        $response = [];

        $citas_id = intval($HistorialClinicoRequest->citas_id);
        if ($HistorialClinicoRequest) {

            $nuevoHC = new Historial_Clinico();
            $nuevoHC->citas_id = $citas_id;
            $nuevoHC->motivo_consulta = $HistorialClinicoRequest->motivo_consulta;
            $nuevoHC->antecedentes = $HistorialClinicoRequest->antecedentes;
            $nuevoHC->evolucion = $HistorialClinicoRequest->evolucion;
            $nuevoHC->enfermedad_actual = $HistorialClinicoRequest->enfermedad_actual;
            $nuevoHC->alergias = $HistorialClinicoRequest->alergias;
            $nuevoHC->fecha = date('Y-m-d');
            $nuevoHC->estado = 'A';

            $existeNumeroHistorial = Historial_Clinico::where('id', $citas_id)->get()->first();

            if ($existeNumeroHistorial) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El número ya existe',
                    'historial_clinico' => null,
                    'receta' => null,
                ];
            } else {
                if ($nuevoHC->save()) {
                    // Guardar receta si la solicitud no está vacía
                    $extraReceta = null;
                    if (!empty($recetaRequest)) {
                        $recetaController = new RecetaController();
                        $extraReceta = $recetaController->guardarReceta($citas_id, $recetaRequest);
                    }

                    // Guardar diagnósticos de receta independientemente de si la receta se guarda o no
                    if (!empty($requestrecetadiagnostico)) {
                        $receta_diagnosticosController = new Receta_DiagnosticosController();
                        $receta_diagnosticosController->guardar_recetas_diagnosticos($extraReceta ? $extraReceta->original['receta']['id'] : null, $citas_id, $requestrecetadiagnostico);
                    }

                    // Guardar en la tabla orden
                    $ordenController = new OrdenController();
                    $extraOrdenController = $ordenController->guardarOrden($nuevoHC->id, $requestOrden);

                    // Cambiar el estado_cita_id de la tabla citas a 2
                    Citas::where('id', $citas_id)->update(['estado_cita_id' => 2]);

                    $response = [
                        'status' => true,
                        'mensaje' => 'Se guardo correctamente',
                        'historial_clinico' => $nuevoHC,
                        'receta' => $extraReceta,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se pudo guardar :(',
                        'historial_clinico' => null,
                        'receta' => null,
                        'receta_diagnostico' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'historial_clinico' => null,
            ];
        }

        return response()->json($response, 200);
    }

    public function guardando_atencion_medica(Request $request)
    {

        $aux = json_decode($request['data']);
        $HistorialClinicoRequest = $aux->historial_clinico;
        //  $recetaRequest = $aux->receta;
        //   $requestrecetadiagnostico = $aux->receta_diagnostico;
        $requestOrden = $aux->orden;
        $requestCertificado = $aux->certificados_medicos;
        $requestExaFisico = $aux->examen_fisica;
        //   $requestOrdenLab = $aux->orden_lab;

        $codigoh = $this->generar_codigo($this->limite);
        $response = [];

        $citas_id = intval($HistorialClinicoRequest->citas_id);

        if ($HistorialClinicoRequest) {
            $existecod = Historial_Clinico::where('codigo_h', $codigoh)->get()->first();
            if ($existecod) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El codigo del historial ya existe',
                    'historial' => null,
                ];
            } else {

                $nuevoHC = new Historial_Clinico();
                $nuevoHC->codigo_h = $codigoh;
                $nuevoHC->citas_id = $citas_id;
                $nuevoHC->motivo_consulta = $HistorialClinicoRequest->motivo_consulta;
                $nuevoHC->antecedentes = $HistorialClinicoRequest->antecedentes;
                $nuevoHC->antecedentes_familiares = $HistorialClinicoRequest->antecedentes_familiares;
                $nuevoHC->plan = $HistorialClinicoRequest->plan;
                $nuevoHC->examen_fisico = $HistorialClinicoRequest->examen_fisico;
                $nuevoHC->evolucion = $HistorialClinicoRequest->evolucion;
                $nuevoHC->enfermedad_actual = $HistorialClinicoRequest->enfermedad_actual;
                $nuevoHC->alergias = $HistorialClinicoRequest->alergias;
                $nuevoHC->fecha = date('Y-m-d');

                $nuevoHC->estado = 'A';

                if ($nuevoHC->save()) {
                    // Guardar receta si la solicitud no está vacía
                    /*      $extraReceta = null;
                    if (!empty($recetaRequest)) {
                        $recetaController = new RecetaController();
                        $extraReceta = $recetaController->guardarReceta($citas_id, $recetaRequest);
                    }
 */
                    // Guardar diagnósticos de receta independientemente de si la receta se guarda o no
                    /*    if (!empty($requestrecetadiagnostico)) {
                        $receta_diagnosticosController = new Receta_DiagnosticosController();
                        $receta_diagnosticosController->guardar_recetas_diagnosticos($extraReceta ? $extraReceta->original['receta']['id'] : null, $citas_id, $requestrecetadiagnostico);
                    } */

                    /*        if (!empty($requestrecetadiagnostico)) {
                        $receta_diagnosticosController = new Receta_DiagnosticosController();
                        $receta_diagnosticosController->guardar_recetas_diagnosticos(
                            $receta_id ?? null, // puede ser null si no hay receta
                            $citas_id,
                            $requestrecetadiagnostico
                        );
                    } */


                    // Guardar en la tabla orden de imagenes
                    $ordenController = new OrdenController();
                    $extraOrdenController = $ordenController->guardarOrden($citas_id, $requestOrden);

                    /*     // Guardar en la tabla orden de examenes laboratorio
                       $ordenLabController = new LaboratorioController();
                       $extraOrdenLabController = $ordenLabController->guardarOrdenLaboratorio($citas_id, $requestOrdenLab); 
        */

                    // Guardar en la tabla certificados
                    $certificadoController = new Certificados_MedicosController();
                    $extraCertificadoController = $certificadoController->guardarCertificado($citas_id, $requestCertificado);

                    // Guardar en la tabla examen fisico
                    $exFisicoController = new Examen_FisicoController();
                    $extraExafisicoController = $exFisicoController->guardarExamenfisico($citas_id, $requestExaFisico);

                    // Cambiar el estado_cita_id de la tabla citas a 2
                    Citas::where('id', $citas_id)->update(['estado_cita_id' => 2]);

                    $response = [
                        'status' => true,
                        'mensaje' => 'Se guardo correctamente',
                        'historial_clinico' => $nuevoHC,
                        //  'receta' => $extraReceta,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se pudo guardar :(',
                        'historial_clinico' => null,
                        'receta' => null,
                        'receta_diagnostico' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'historial_clinico' => null,
            ];
        }

        return response()->json($response, 200);
    }


    /**DATATABLE RECETAS  X CITAS X ID */

  public function datatableRecetas($receta_id)
{
    $receta_id = intval($receta_id);
    $recetas_detalle = Receta_Detalle::where('receta_id', $receta_id)
                            ->where('estado', 'A')
                            ->with(['producto', 'dosis', 'frecuencia', 'via']) // Asegúrate de tener estas relaciones definidas
                            ->get();

    $data = [];
    $i = 1;
    foreach ($recetas_detalle as $rece_det) {
        $producto = $rece_det->producto;
        $dosis = $rece_det->dosis;
        $frecuencia = $rece_det->frecuencia;
        $via = $rece_det->via;

        $botones1 = '<div class="">
                         <button class="btn btn-sm btn-warning" onclick="editar_medicamento(' . $rece_det->id . ' )">
                                <i class="fas fa-edit"></i> Editar
                         </button>
                     </div>';

        $botones2 = '<div class="">
                     <button  class="btn btn-sm btn-danger " onclick="eliminarreceta(' . $rece_det->id . ')">
                         <i class="fas fa-trash"></i>  
                     </button>
                 </div>';

        $data[] = [
            0 => $rece_det->cantidad,
            1 => $producto->nombre_producto ?? 'Sin producto',
            2 => $dosis->tipo_dosis ?? 'Sin dosis',
            3 => $frecuencia->tipo_frecuencia ?? 'Sin frecuencia',
            4 => $via->tipo_via ?? 'Sin vía',
            5 => $rece_det->duracion,
            6 => $rece_det->observacion,
            7 => $botones1,
            8 => $botones2,
        ];
        $i++;
    }

    $result = [
        'sEcho' => 1,
        'iTotalRecords' => count($data),
        'iTotalDisplayRecords' => count($data),
        'aaData' => $data,
    ];

    return response()->json($result, 200);
}


    /**este listar ya no funciona es el anterior q cuando valia estaba todo en una sola tabla ahora tiene el detalle receta */
/*     public function listar_recetas($id)
    {
        $idrecetas = intval($id);
        $recetas = Receta::find($idrecetas);
        //  $serviciosController = new ServiciosController;
        // $receta_diagnostico = Receta_Diagnostico::find()
        $response = [];

        if ($recetas == null) {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para mostrar',
                'recetas' => null,

            ];
        } else {
            $producto = $recetas->producto;
            $dosis = $recetas->dosis;
            $frecuencia = $recetas->frecuencia;


            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'receta' => $recetas,
                'producto' => $producto,
                'dosis' => $dosis,
                'frecuencia' => $frecuencia
            ];
        }

        return response()->json($response);
    }
 */
/**aqiu va  a listar el detalle receta para que pueda editar */
    public function listar_recetas($id)
    {
        $idrecetas = intval($id);
        $recetas = Receta_Detalle::find($idrecetas);
 
        $response = [];

        if ($recetas == null) {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para mostrar',
                'recetas' => null,

            ];
        } else {
            $producto = $recetas->producto;
            $dosis = $recetas->dosis;
            $frecuencia = $recetas->frecuencia;
            $via = $recetas->via;


            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'receta' => $recetas,
                'producto' => $producto,
                'dosis' => $dosis,
                'frecuencia' => $frecuencia,
                'via' => $via
            ];
        }

        return response()->json($response);
    }



    public function editarReceta(Request $request)
    {

        $aux = json_decode($request['data']);
        $recetaRequest = $aux->receta;

        $idreceta = intval($recetaRequest->id);
        $dosis_id = intval($recetaRequest->dosis_id);
        $frecuencia_id = intval($recetaRequest->frecuencia_id);
        $via_id = intval($recetaRequest->via_id);
        $duracion = $recetaRequest->duracion;
        $observacion = $recetaRequest->observacion;
        $cantidad = $recetaRequest->cantidad;


        $recetadata = Receta_Detalle::find($idreceta);
        $response = [];

        if ($recetaRequest) {
            if ($recetadata) {


                $recetadata->dosis_id = $dosis_id;
                $recetadata->frecuencia_id = $frecuencia_id;
                $recetadata->via_id = $via_id;
                $recetadata->duracion = $duracion;
                $recetadata->observacion = $observacion;
                $recetadata->cantidad = $cantidad;


                $recetadata->save();


                $response = [
                    'status' => true,
                    'mensaje' => 'La receta se ha actualizado',
                    'receta' => $recetadata,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar la receta',
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos ',
            ];
        }

        return response()->json($response, 200);
    }







    /*    public function datatablelistarxmedico_atendidas($medicoId)
	{

		$medico_id = intval($medicoId);
		$cita = Citas::where('doctor_id', $medico_id)->where('estado_cita_id', '2')->orderBy('fecha', 'asc')->get();
		$data = [];
		$i = 1;

		foreach ($cita as $citasc) {
			$codigocita = $citasc->codigo_cita;
			$cedula = $citasc->paciente->persona->cedula;

			$cli = $citasc->paciente->persona;
			$doc = $citasc->doctor->persona;
		//$serv = $citasc->servicios->nombre_servicio;
			$hor = substr($citasc->doctor_horario->hora_inicio, 0, -3) . ' ' .  substr($citasc->doctor_horario->hora_fin, 0, -3);
			$dataEstadoCita = $citasc->estado_cita;
			$dataFechaCita  = $citasc->fecha;
			$estado = $citasc->estado_cita_id;
            

			$other = $citasc->estado_cita_id == 1 ? 2 : 1;
			$disabled = $citasc->estado_cita_id == 2 ? 'disabled' : ' ';
			$disabledCancelar = $citasc->estado_cita_id == 3 ? 'disabled' : ' ';

			if ($estado == 1) {
				$estado = '<span class="badge bg-warning" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
			} else if ($estado == 2) {
				$estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
			} else {
				$estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
			}

			$botones = '<div class="">
                            <button ' . $disabled . ' ' . $disabledCancelar . ' class="btn btn-sm btn-success" onclick="atender(' . $citasc->id . ',' . $other . ')">
                                <i class="fa fa-eye"></i> Atender
                            </button>

                            <button ' . $disabled . ' ' . $disabledCancelar . ' class="btn btn-sm btn-danger" onclick="cancelar_cita(' . $citasc->id . ',' . $other . ')">
                                <i class="fas fa-times"></i> Cancelar Cita
                            </button>


                            <button ' . $disabled . ' ' . $disabledCancelar . ' class="btn btn-sm btn-outline-success" onclick="ver_cita(' . $citasc->id . ')">
                                <i class="fas fa-clipboard-list"></i> Imprimir Cita
                            </button>
                        </div>';

			$data[] = [
				0 => $i,
                1 => $codigocita,
                2 => $cedula,
				3 => $cli->nombre . ' ' . $cli->apellido,
				4 => $doc->nombre . ' ' . $doc->apellido,
				5 => $hor,
				6 => $dataFechaCita,
				7 => $estado,
				8 => $botones,
			];
			$i++;
		}

		$result = [
			'sEcho' => 1,
			'iTotalRecords' => count($data),
			'iTotalDisplayRecords' => count($data),
			'aaData' => $data,
		];

		return response()->json($result, 200);
	}
 */

    /*  public function datatablelistarxmedico_atendidas($medicoId,$fechaInicio, $fechaFin)
 {

     $medico_id = intval($medicoId);
     $cita = Citas::where('doctor_id', $medico_id)->where('estado_cita_id', '2')->whereBetween('fecha', [$fechaInicio, $fechaFin])
     ->orderBy('fecha', 'asc')->get();
     $data = [];
     $i = 1;

     foreach ($cita as $citasc) {
         $codigocita = $citasc->codigo_cita;
         $cedula = $citasc->paciente->persona->cedula;

         $cli = $citasc->paciente->persona;
         $doc = $citasc->doctor->persona;
 
         $hor = substr($citasc->doctor_horario->hora_inicio, 0, -3) . ' ' .  substr($citasc->doctor_horario->hora_fin, 0, -3);
         $dataEstadoCita = $citasc->estado_cita;
         $dataFechaCita  = $citasc->fecha;
         $estado = $citasc->estado_cita_id;
         

         $other = $citasc->estado_cita_id == 1 ? 2 : 1;
         $disabled = $citasc->estado_cita_id == 2 ? 'disabled' : ' ';
         $disabledCancelar = $citasc->estado_cita_id == 3 ? 'disabled' : ' ';

         if ($estado == 1) {
             $estado = '<span class="badge bg-warning" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
         } else if ($estado == 2) {
             $estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
         } else {
             $estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
         }

         $botones = '<div class="">

                         <button class="btn btn-sm btn-outline-success" onclick="imprimir_receta(' . $citasc->id . ')">
                             <i class="fas fa-clipboard-list"></i> 
                         </button>
                         <button class="btn btn-sm btn-outline-success" onclick="imprimir_certificado(' . $citasc->id . ')">
                             <i class="fas fa-user"></i> 
                         </button>
                         <button ' . $disabled . ' ' . $disabledCancelar . ' class="btn btn-sm btn-success" onclick="atender(' . $citasc->id . ',' . $other . ')">
                             <i class="fa fa-eye"></i> 
                         </button>

                         <button ' . $disabled . ' ' . $disabledCancelar . ' class="btn btn-sm btn-danger" onclick="cancelar_cita(' . $citasc->id . ',' . $other . ')">
                             <i class="fas fa-times"></i> 
                         </button>


                         <button ' . $disabled . ' ' . $disabledCancelar . ' class="btn btn-sm btn-outline-success" onclick="ver_cita(' . $citasc->id . ')">
                             <i class="fas fa-clipboard-list"></i> 
                         </button>

                         
                         
                     </div>';

         $data[] = [
             0 => $i,
             1 => $codigocita,
             2 => $cedula,
             3 => $cli->nombre . ' ' . $cli->apellido,
             4 => $doc->nombre . ' ' . $doc->apellido,
             5 => $hor,
             6 => $dataFechaCita,
             7 => $estado,
             8 => $botones,
         ];
         $i++;
     }

     $result = [
         'sEcho' => 1,
         'iTotalRecords' => count($data),
         'iTotalDisplayRecords' => count($data),
         'aaData' => $data,
     ];

     return response()->json($result, 200);
 } */


    /*    public function datatablelistarxmedico_atendidas($medicoId, $fechaInicio, $fechaFin)
    {

        $medico_id = intval($medicoId);
        // Si no se envían fechas válidas, obtener todas las citas atendidas del médico
        if ($fechaInicio === 'null' || $fechaFin === 'null') {
            $cita = Citas::where('doctor_id', $medico_id)
                ->where('estado_cita_id', '2')
                ->orderBy('fecha', 'asc')
                ->get();
        } else {
            // Si se envían fechas, aplicar el filtro
            $cita = Citas::where('doctor_id', $medico_id)
                ->where('estado_cita_id', '2')
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->orderBy('fecha', 'asc')
                ->get();
        }


        $data = [];
        $i = 1;

        $base = $_SERVER['APP_URL'] . ':' . $_SERVER['SERVER_PORT'] . '/';
        foreach ($cita as $citasc) {
            $urlPdf =  $base . 'api/';
            $urlPdf2 =  $base . 'api/';
            $urlPdf3 =  $base . 'api/';
            $urlPdf4 =  $base . 'api/';


            $codigocita = $citasc->codigo_cita;
            $cedula = $citasc->paciente->persona->cedula;

            $cli = $citasc->paciente->persona;
            $doc = $citasc->doctor->persona;

            $hor = substr($citasc->doctor_horario->hora_inicio, 0, -3) . ' ' .  substr($citasc->doctor_horario->hora_fin, 0, -3);
            $dataEstadoCita = $citasc->estado_cita;
            $dataFechaCita  = $citasc->fecha;
            $estado = $citasc->estado_cita_id;


            $other = $citasc->estado_cita_id == 1 ? 2 : 1;
            $disabled = $citasc->estado_cita_id == 2 ? 'disabled' : ' ';
            $disabledCancelar = $citasc->estado_cita_id == 3 ? 'disabled' : ' ';

            if ($estado == 1) {
                $estado = '<span class="badge bg-warning" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            } else if ($estado == 2) {
                $estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            } else {
                $estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            }

            $botones = '<div class="btn-group">

         <a class="btn btn-sm btn-outline-primary" href="' . $urlPdf . 'receta/' . $citasc->id . '" target="_blank" title="Ver Receta">
             <i class="fas fa-clipboard-list"></i>
         </a>
     
         <a class="btn btn-sm btn-warning" href="' . $urlPdf2 . 'certificado/' . $citasc->id . '" target="_blank" title="Ver Certificado">
             <i class="fas fa-user"></i> 
         </a>
     
         <button class="btn btn-sm btn-success" onclick="editar_cita(' . $citasc->id . ',' . $other . ')" title="Editar Cita">
             <i class="fa fa-eye"></i> 
         </button>
     
         <button ' . $disabled . ' ' . $disabledCancelar . ' class="btn btn-sm btn-danger" onclick="cancelar_cita(' . $citasc->id . ',' . $other . ')" title="Cancelar Cita">
             <i class="fas fa-times"></i> 
         </button>
     
         <a class="btn btn-sm btn-outline-secondary" href="' . $urlPdf3 . 'laboratorio_orden/' . $citasc->id . '" target="_blank" title="Ver Orden de Laboratorio">
             <i class="fas fa-file-medical-alt"></i> 
         </a>
     
         <a class="btn btn-sm btn-outline-info" href="' . $urlPdf4 . 'imagenes_orden/' . $citasc->id . '" target="_blank" title="Ver Orden de Imágenes">
             <i class="fas fa-x-ray"></i>
         </a>
     
     </div>';


            $data[] = [
                0 => $i,
                1 => $codigocita,
                2 => $cedula,
                3 => $cli->nombre . ' ' . $cli->apellido,
                4 => $doc->nombre . ' ' . $doc->apellido,
                5 => $hor,
                6 => $dataFechaCita,
                7 => $estado,
                8 => $botones,
            ];
            $i++;
        }

        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];

        return response()->json($result, 200);
    }
 */

    public function datatablelistarxmedico_atendidas($medicoId, $fechaInicio, $fechaFin)
    {
        $medico_id = intval($medicoId);

        // Si las fechas son "null", cargamos todas las citas
        if ($fechaInicio == 'null' || $fechaFin == 'null') {
            // Solo filtramos por el médico y el estado de la cita "atendida" (estado_cita_id = 2)
            $cita = Citas::where('doctor_id', $medico_id)
                ->where('estado_cita_id', '2')
                ->orderBy('fecha', 'DESC')
                ->get();
        } else {
            // Si las fechas son válidas, filtramos por el rango de fechas también
            $cita = Citas::where('doctor_id', $medico_id)
                ->where('estado_cita_id', '2')
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->orderBy('fecha', 'DESC')
                ->get();
        }

        $data = [];
        $i = 1;

        $base = $_SERVER['APP_URL'] . ':' . $_SERVER['SERVER_PORT'] . '/';
        foreach ($cita as $citasc) {
            $urlPdf =  $base . 'api/';
            $urlPdf2 =  $base . 'api/';
            $urlPdf3 =  $base . 'api/';
            $urlPdf4 =  $base . 'api/';
            $urlPdf5 =  $base . 'api/';

            $codigocita = $citasc->codigo_cita;
            $cedula = $citasc->paciente->persona->cedula;

            $cli = $citasc->paciente->persona;
            $doc = $citasc->doctor->persona;

            $hor = substr($citasc->doctor_horario->hora_inicio, 0, -3) . ' ' .  substr($citasc->doctor_horario->hora_fin, 0, -3);
            $dataEstadoCita = $citasc->estado_cita;
            $dataFechaCita  = $citasc->fecha;
            $estado = $citasc->estado_cita_id;

            $other = $citasc->estado_cita_id == 1 ? 2 : 1;
            $disabled = $citasc->estado_cita_id == 2 ? 'disabled' : ' ';
            $disabledCancelar = $citasc->estado_cita_id == 3 ? 'disabled' : ' ';

            if ($estado == 1) {
                $estado = '<span class="badge bg-warning" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            } else if ($estado == 2) {
                $estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            } else {
                $estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            }

            $botones = '

            <div class="btn-group">
            <a class="btn btn-sm btn-outline-primary" href="' . $urlPdf5 . 'recetaf2/' . $citasc->id . '" target="_blank" title="Ver Receta 2 formato">
                <i class="fas fa-clipboard-list"></i>
            </a>
        
            <a class="btn btn-sm btn-warning" href="' . $urlPdf2 . 'certificado/' . $citasc->id . '" target="_blank" title="Ver Certificado">
                <i class="fas fa-user"></i> 
            </a>
        
            <button class="btn btn-sm btn-success" onclick="editar_cita(' . $citasc->id . ', ' . $citasc->paciente_id . ')" title="Editar Cita">
                <i class="fa fa-eye"></i> 
            </button>
        
            <button ' . $disabled . ' ' . $disabledCancelar . ' class="btn btn-sm btn-danger" onclick="cancelar_cita(' . $citasc->id . ',' . $other . ')" title="Cancelar Cita">
                <i class="fas fa-times"></i> 
            </button>
        
            <a class="btn btn-sm btn-outline-secondary" href="' . $urlPdf3 . 'laboratorio_orden/' . $citasc->id . '" target="_blank" title="Ver Orden de Laboratorio">
                <i class="fas fa-file-medical-alt"></i> 
            </a>
        
            <a class="btn btn-sm btn-outline-info" href="' . $urlPdf4 . 'imagenes_orden/' . $citasc->id . '" target="_blank" title="Ver Orden de Imágenes">
                <i class="fas fa-x-ray"></i>
            </a>
        </div>';

            $data[] = [
                0 => $i,
                1 => $codigocita,
                2 => $cedula,
                3 => $cli->nombre . ' ' . $cli->apellido,
                4 => $doc->nombre . ' ' . $doc->apellido,
                5 => $hor,
                6 => $dataFechaCita,
                7 => $estado,
                8 => $botones,
            ];
            $i++;
        }

        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];

        return response()->json($result, 200);
    }


    public function datatablelistarxmedico_canceladas($medicoId, $fechaInicio, $fechaFin)
    {
        $medico_id = intval($medicoId);

        // Si las fechas son "null", cargamos todas las citas
        if ($fechaInicio == 'null' || $fechaFin == 'null') {
            // Solo filtramos por el médico y el estado de la cita "atendida" (estado_cita_id = 2)
            $cita = Citas::where('doctor_id', $medico_id)
                ->where('estado_cita_id', '5')
                ->orderBy('fecha', 'DESC')
                ->get();
        } else {
            // Si las fechas son válidas, filtramos por el rango de fechas también
            $cita = Citas::where('doctor_id', $medico_id)
                ->where('estado_cita_id', '5')
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->orderBy('fecha', 'DESC')
                ->get();
        }

        $data = [];
        $i = 1;

        $base = $_SERVER['APP_URL'] . ':' . $_SERVER['SERVER_PORT'] . '/';
        foreach ($cita as $citasc) {
            $urlPdf =  $base . 'api/';
            $urlPdf2 =  $base . 'api/';
            $urlPdf3 =  $base . 'api/';
            $urlPdf4 =  $base . 'api/';

            $codigocita = $citasc->codigo_cita;
            $cedula = $citasc->paciente->persona->cedula;

            $cli = $citasc->paciente->persona;
            $doc = $citasc->doctor->persona;

            $hor = substr($citasc->doctor_horario->hora_inicio, 0, -3) . ' ' .  substr($citasc->doctor_horario->hora_fin, 0, -3);
            $dataEstadoCita = $citasc->estado_cita;
            $dataFechaCita  = $citasc->fecha;
            $estado = $citasc->estado_cita_id;

            $other = $citasc->estado_cita_id == 1 ? 2 : 1;
            $disabled = $citasc->estado_cita_id == 2 ? 'disabled' : ' ';
            $disabledCancelar = $citasc->estado_cita_id == 3 ? 'disabled' : ' ';

            if ($estado == 1) {
                $estado = '<span class="badge bg-warning" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            } else if ($estado == 2) {
                $estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            } else {
                $estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            }

            $botones = '
        
     
    
        
            <button ' . $disabled . ' ' . $disabledCancelar . ' class="btn btn-sm btn-danger" onclick="cancelar_cita(' . $citasc->id . ',' . $other . ')" title="Cita Cancelada">
                <i class="fas fa-times"></i> 
            </button>
    
           
        </div>';

            $data[] = [
                0 => $i,
                1 => $codigocita,
                2 => $cedula,
                3 => $cli->nombre . ' ' . $cli->apellido,
                4 => $doc->nombre . ' ' . $doc->apellido,
                5 => $hor,
                6 => $dataFechaCita,
                7 => $estado,

            ];
            $i++;
        }

        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];

        return response()->json($result, 200);
    }

    public function listar_citasxid2($id)
    {
        $idcitas = intval($id);
        $citas = Citas::find($idcitas);
        //  $serviciosController = new ServiciosController;
        // $receta_diagnostico = Receta_Diagnostico::find()
        $response = [];

        if ($citas == null) {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para mostrar',
                'citas' => null,

            ];
        } else {
            //    $servicios = $serviciosController->mostrarServiciosReservacionOrdenes($idcitas);
            $valor = 0;
            foreach ($citas->receta as $rece) {
                $rece->producto;
                foreach ($rece->receta_diagnostico as $recediag) {
                    $recediag->diagnosticocie10;
                    $recediag->tipo_diagnostico;
                }
                //   $valor += $rece->producto->precio_venta;
            }
            foreach ($citas->ordenes as $ord) {
                $ord->tipo_estudio;
            }
            foreach ($citas->historial_clinico as $hist) {
                $hist->id;
            }

            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                // 'valor' => $valor,
                'citas' => $citas,
                'orden' => $citas->ordenes,
                'paciente_id ' => $citas->paciente->persona->id,
                //  'historial' => $citas->historial_clinico,
                'estado_cita_id' => $citas->estado_cita->id,
                'receta' => $citas->receta
            ];
        }

        return response()->json($response);
    }


  /*   public function listar_citasxid($id)
    {
        $idpaciente = intval($id);
        $paciente = Paciente::find($idpaciente);
        $response = [];

        if ($paciente == null) {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para mostrar',
                'citas' => null,

            ];
        } else {

            $valor = 0;

            foreach ($paciente->citas as $cit) {
                $paciente->persona->sexo;
                $cit->doctor->persona;
                $cit->paciente->persona;
                foreach ($cit->ordenes as $ord) {
                    $ord->tipo_estudio;
                    foreach ($cit->historial_clinico as $hist) {
                        $hist->id;
                    }
                }
                foreach ($cit->receta_diagnostico as $rece) {
                    $rece->diagnosticocie10;
                    $rece->tipo_diagnostico;
                }

                foreach ($cit->receta as $recet) {
                    foreach ($recet->receta_detalle as $rede) {
                        $rede->producto;
                        $rede->dosis;
                        $rede->frecuencia;
                    }
                }

                foreach ($cit->historial_clinico as $historial) {
                    $historial->citas;
                    $historial->lateralidad;
                }

                foreach ($cit->examen_fisica as $exa) {
                }

                foreach ($cit->laboratorio as $lab) {
                    foreach ($lab->laboratorio_detalle as $det_lab) {
                        $det_lab->tipo_examen;
                    }
                }
            }

            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'paciente' => $paciente,
            ];
        }

        return response()->json($response);
    } */

/*     public function listar_citasxid($id)
{
    $idpaciente = intval($id);
    $paciente = Paciente::find($idpaciente);
    $response = [];

    if ($paciente == null) {
        $response = [
            'estado' => false,
            'mensaje' => 'No hay datos para mostrar',
            'citas' => null,
        ];
    } else {
        foreach ($paciente->citas as $cit) {
            // Relaciones básicas
            $cit->doctor->persona;
            $cit->paciente->persona;

            // Última receta con detalles en estado A
            $ultimaReceta = $cit->receta->sortByDesc('id')->first();
            if ($ultimaReceta) {
                $ultimaReceta->receta_detalle = $ultimaReceta->receta_detalle->where('estado', 'A')->values();
                foreach ($ultimaReceta->receta_detalle as $rede) {
                    $rede->producto;
                    $rede->dosis;
                    $rede->frecuencia;
                }
                $cit->ultima_receta = $ultimaReceta;
            }

            // Última orden de laboratorio con detalles en estado A
            $ultimaOrdenLab = $cit->laboratorio->sortByDesc('id')->first();
            if ($ultimaOrdenLab) {
                $ultimaOrdenLab->laboratorio_detalle = $ultimaOrdenLab->laboratorio_detalle->where('estado', 'A')->values();
                foreach ($ultimaOrdenLab->laboratorio_detalle as $det_lab) {
                    $det_lab->tipo_examen;
                }
                $cit->ultima_orden_lab = $ultimaOrdenLab;
            }

            // Historial clínico y lateralidad
            foreach ($cit->historial_clinico as $historial) {
                $historial->citas;
                $historial->lateralidad;
            }

            // Examen físico (si se necesita)
            foreach ($cit->examen_fisica as $exa) {
                // Puedes cargar relaciones si las tienes
            }

            // Diagnósticos de la receta (todos los que existan)
            foreach ($cit->receta_diagnostico as $rece) {
                $rece->diagnosticocie10;
                $rece->tipo_diagnostico;
            }

            // Estudios
            foreach ($cit->ordenes as $ord) {
                $ord->tipo_estudio;
                foreach ($cit->historial_clinico as $hist) {
                    $hist->id;
                }
            }
        }

        $response = [
            'status' => true,
            'mensaje' => 'Existen datos',
            'paciente' => $paciente,
        ];
    }

    return response()->json($response);
}
 */
/* 
 public function listar_citasxid($id)
{
    $idpaciente = intval($id);
    $paciente = Paciente::find($idpaciente);
    $response = [];

    if ($paciente == null) {
        $response = [
            'estado' => false,
            'mensaje' => 'No hay datos para mostrar',
            'citas' => null,
        ];
    } else {
 
          
        // 🔴 Solo obtener las citas con estado 2 (atendidas)
        $citasAtendidas = $paciente->citas()->where('estado_cita_id', 2)->get();

        // Añadimos la relación filtrada directamente al objeto para enviarla al frontend
        $paciente->citas = $citasAtendidas;

        foreach ($citasAtendidas as $cit) {
            // Relaciones principales
            $cit->doctor->persona;
            $cit->paciente->persona;

            // Última receta (con detalles en estado A)
            $ultimaReceta = $cit->receta->sortByDesc('id')->first();
            if ($ultimaReceta) {
                $ultimaReceta->receta_detalle = $ultimaReceta->receta_detalle->where('estado', 'A')->values();
                foreach ($ultimaReceta->receta_detalle as $rede) {
                    $rede->producto;
                    $rede->dosis;
                    $rede->frecuencia;
                }
                $cit->ultima_receta = $ultimaReceta;
            }

            // Última orden de laboratorio (con detalles en estado A)
            $ultimaOrdenLab = $cit->laboratorio->sortByDesc('id')->first();
            if ($ultimaOrdenLab) {
                $ultimaOrdenLab->laboratorio_detalle = $ultimaOrdenLab->laboratorio_detalle->where('estado', 'A')->values();
                foreach ($ultimaOrdenLab->laboratorio_detalle as $det_lab) {
                    $det_lab->tipo_examen;
                }
                $cit->ultima_orden_lab = $ultimaOrdenLab;
            }

            // Historial clínico
            foreach ($cit->historial_clinico as $historial) {
                $historial->citas;
                $historial->lateralidad;
            }

            // Diagnósticos de receta
            foreach ($cit->receta_diagnostico as $rece) {
                $rece->diagnosticocie10;
                $rece->tipo_diagnostico;
            }

            // Órdenes de estudios
            foreach ($cit->ordenes as $ord) {
                $ord->tipo_estudio;
                foreach ($cit->historial_clinico as $hist) {
                    $hist->id;
                }
            }

            // Examen físico (si lo usas)
            foreach ($cit->examen_fisica as $exa) {
                // Relaciones si aplica
            }
        }

        $response = [
            'status' => true,
            'mensaje' => 'Existen datos',
            'paciente' => $paciente,
        ];
    }

    return response()->json($response);
}
 */

 public function listar_citasxid($id)
{
    $idpaciente = intval($id);
    $paciente = Paciente::find($idpaciente);
    $response = [];

    if ($paciente == null) {
        $response = [
            'estado' => false,
            'mensaje' => 'No hay datos para mostrar',
            'persona' => null,
            'citas' => [],
        ];
    } else {
        // 🔴 Filtrar solo citas atendidas
        $citasAtendidas = $paciente->citas()->where('estado_cita_id', 2)->get();

        $datosPaciente = $paciente;
        $persona = $paciente->persona->sexo;

        foreach ($citasAtendidas as $cit) {
            // Relaciones necesarias
            $cit->doctor->persona;

            // Última receta con detalles en estado A
            $ultimaReceta = $cit->receta->sortByDesc('id')->first();
            if ($ultimaReceta) {
                $ultimaReceta->receta_detalle = $ultimaReceta->receta_detalle->where('estado', 'A')->values();
                foreach ($ultimaReceta->receta_detalle as $rede) {
                    $rede->producto;
                    $rede->dosis;
                    $rede->frecuencia;
                }
                $cit->ultima_receta = $ultimaReceta;
            }

            // Última orden de laboratorio con detalles en estado A
            $ultimaOrdenLab = $cit->laboratorio->sortByDesc('id')->first();
            if ($ultimaOrdenLab) {
                $ultimaOrdenLab->laboratorio_detalle = $ultimaOrdenLab->laboratorio_detalle->where('estado', 'A')->values();
                foreach ($ultimaOrdenLab->laboratorio_detalle as $det_lab) {
                    $det_lab->tipo_examen;
                }
                $cit->ultima_orden_lab = $ultimaOrdenLab;
            }

            // Historial clínico
            foreach ($cit->historial_clinico as $historial) {
                $historial->citas;
                $historial->lateralidad;
            }

            // Diagnósticos de receta
            foreach ($cit->receta_diagnostico as $rece) {
                $rece->diagnosticocie10;
                $rece->tipo_diagnostico;
            }

            // Órdenes de estudios
            foreach ($cit->ordenes as $ord) {
                $ord->tipo_estudio;
                foreach ($cit->historial_clinico as $hist) {
                    $hist->id;
                }
            }

            // Examen físico
            foreach ($cit->examen_fisica as $exa) {
                // Cargar si es necesario
            }
        }

        $response = [
            'status' => true,
            'mensaje' => 'Existen datos',
            'paciente' => $datosPaciente,
            'citas' => $citasAtendidas,
        ];
    }

    return response()->json($response);
}



    public function contar_citaspendiente($medicoId)
    {



        $medico_id = intval($medicoId);
        $cita = Citas::where('doctor_id', $medico_id)->where('estado_cita_id', '1')->get();


        $response = [];

        if ($cita) {
            $response = [
                'status' => true,
                'mensaje' => 'existe datos',
                'modelo' => 'Citas Pendientes',
                'cantidad' => $cita->count(),
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existe datos',
                'modelo' => 'Citas Pendientes',
                'cantidad' => 0,
            ];
        }

        return response()->json($response, 200);
    }



    public function listarcontingencia()
    {

        $dttipocontingencia = Tipo_Contingencia::where('estado', 'A')->get();
        $response = [];

        if ($dttipocontingencia) {
            $response = [
                'status' => true,
                'message' => 'existen datos',
                'tipo_contingencia' => $dttipocontingencia,
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'no existen datos',
                'tipo_contingencia' => null,
            ];
        }

        return response()->json($response, 200);
    }


    public function listaraislamiento()
    {

        $dtaislamiento = Aislamiento::where('estado', 'A')->get();
        $response = [];

        if ($dtaislamiento) {
            $response = [
                'status' => true,
                'message' => 'existen datos',
                'aislamiento' => $dtaislamiento,
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'no existen datos',
                'aislamiento' => null,
            ];
        }

        return response()->json($response, 200);
    }





    public function eliminarItemReceta($recetaId)
    {

        $id_Receta = intval($recetaId);
        //  $id_estado = intval($estadoId); //3 cancelado
        $mensajes = '';
        $response = [];
        $receta = Receta_Detalle::find($id_Receta);

        if ($receta) {

            //  $cita->estado_cita_id = $id_estado;
            $receta->estado = 'I';
            $receta->save();


            switch ($id_Receta) {
                case 1:
                    $mensajes = 'El medicamento de la receta ha sido cancelada';
                    break;
            }

            $response = [
                'status' => true,
                'mensaje' => $mensajes,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se puede cancelar el medicamento',
            ];
        }

        return response()->json($response, 200);
    }




 /*    public function guardar_edicionreceta(Request $request)
    {

        $auxiliar = json_decode($request['data']);
        $data_producto_req = $auxiliar->receta;


        $response = [];

        if ($data_producto_req) {

            $producto_id = $data_producto_req->producto_id;
            $citas_id = $data_producto_req->citas_id;
            $cantidad = $data_producto_req->cantidad;
            $dosis_id = $data_producto_req->dosis_id;
            $frecuencia_id = $data_producto_req->frecuencia_id;
            $duracion = $data_producto_req->duracion;
            $observacion = $data_producto_req->observacion;

            $existecodigo = Receta::where('producto_id', $producto_id)->where('citas_id', $citas_id)->where('estado', 'A')
                ->get()->first();

            if ($existecodigo) {
                $response = [
                    'estado' => false,
                    'mensaje' => 'El medicamento ya se ha registrado, por favor de clic en el boton editar en la tabla',
                    'receta' => null,
                ];
            } else {
                $nuevoRece = new Receta();
                $nuevoRece->producto_id = $producto_id;
                $nuevoRece->citas_id = $citas_id;
                $nuevoRece->cantidad = $cantidad;
                $nuevoRece->dosis_id = $dosis_id;
                $nuevoRece->frecuencia_id = $frecuencia_id;
                $nuevoRece->duracion = $duracion;
                $nuevoRece->observacion = $observacion;
                $nuevoRece->status_facturado = 'N';
                $nuevoRece->estado = 'A';

                if ($nuevoRece->save()) {
                    $response = [
                        'estado' => true,
                        'mensaje' => 'El Medicamento se ha registrado correctamente',
                        'receta' => $nuevoRece,
                    ];
                } else {
                    $response = [
                        'estado' => false,
                        'mensaje' => 'No se ha guardado el medicamento',
                        'receta' => null,
                    ];
                }
            }
        } else {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para guardar',
                'receta' => null,
            ];
        }

        return response()->json($response, 200);
    } */

       public function guardar_edicionreceta(Request $request)
    {

        $auxiliar = json_decode($request['data']);
        $data_producto_req = $auxiliar->orden_rece;


        $response = [];

        if ($data_producto_req) {

            $receta_id = $data_producto_req->receta_id;
            $producto_id = $data_producto_req->producto_id;
            $cantidad = $data_producto_req->cantidad;
            $dosis_id = $data_producto_req->dosis_id;
            $via_id = $data_producto_req->via_id;
            $frecuencia_id = $data_producto_req->frecuencia_id;
            $duracion = $data_producto_req->duracion;
            $observacion = $data_producto_req->observacion;
          

            $existecodigo = Receta_Detalle::where('producto_id', $producto_id)->where('receta_id', $receta_id)->where('estado', 'A')
                ->get()->first();

            if ($existecodigo) {
                $response = [
                    'estado' => false,
                    'mensaje' => 'El medicamento ya se ha registrado, por favor de clic en el boton editar en la tabla',
                    'receta' => null,
                ];
            } else {
                $nuevoRece = new Receta_Detalle();
                $nuevoRece->receta_id = $receta_id;
                $nuevoRece->producto_id = $producto_id;
                $nuevoRece->via_id = $via_id;
                $nuevoRece->cantidad = $cantidad;
                $nuevoRece->dosis_id = $dosis_id;
                $nuevoRece->frecuencia_id = $frecuencia_id;
                $nuevoRece->duracion = $duracion;
                $nuevoRece->observacion = $observacion;
                $nuevoRece->status_facturado = 'N';
                $nuevoRece->estado = 'A';
                $nuevoRece->fecha= date('Y-m-d H:i:s');
;

                if ($nuevoRece->save()) {
                    $response = [
                        'estado' => true,
                        'mensaje' => 'El Medicamento se ha registrado correctamente',
                        'receta' => $nuevoRece,
                    ];
                } else {
                    $response = [
                        'estado' => false,
                        'mensaje' => 'No se ha guardado el medicamento',
                        'receta' => null,
                    ];
                }
            }
        } else {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para guardar',
                'receta' => null,
            ];
        }

        return response()->json($response, 200);
    }


    /**INCIIO DE EDITAR DIAGNOSTICO EN EL DTTABLE  */
    public function dtableeditardiagnostico($citaId)
    {

        $cita_id = intval($citaId);
        $receta_diag = Receta_Diagnostico::where('citas_id', $cita_id)->where('estado', 'A')->get();
        $data = [];
        $i = 1;
        foreach ($receta_diag as $rece) {

            $diagnostico = $rece->diagnosticocie10;
            $tipoDiag = $rece->tipo_diagnostico;



            $botones1 = '<div class="">
                       
                        <button class="btn btn-sm btn-warning" onclick="editar_diagnostico(' . $rece->id . ' )">
                               <i class="fas fa-edit"></i> Editar
                           </button>
                      
                    </div>';
            $botones2 = '<div class="">
                       

                    <button  class="btn btn-sm btn-danger " onclick="eliminar_diagnostico_receta(' . $rece->id . ')">
                        <i class="fas fa-trash"></i>  
                    </button>
                </div>';

            $data[] = [

                0 => $rece->cantidad,
                1 => $diagnostico->clave . ' ' . $diagnostico->descripcion,
                2 => $tipoDiag->tipo_diagnostico,
                3 => $botones1,
                4 => $botones2,
            ];
            $i++;
        }

        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];

        return response()->json($result, 200);
    }


    public function listar_diagnostico($id)
    {
        $iddiagnostico = intval($id);
        $recetadiagnostico = Receta_Diagnostico::find($iddiagnostico);

        $response = [];

        if ($recetadiagnostico == null) {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para mostrar',
                'recetas' => null,

            ];
        } else {
            $diagnostico = $recetadiagnostico->diagnosticocie10;
            $tipodiagnostico = $recetadiagnostico->tipo_diagnostico;



            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'recetadiagnostico' => $recetadiagnostico,
                'diagnostico' => $diagnostico,
                'tipodiagnostico' => $tipodiagnostico,

            ];
        }

        return response()->json($response);
    }

    public function guardar_edicionDiagnostico(Request $request)
    {

        $auxiliar = json_decode($request['data']);
        $data_diag_req = $auxiliar->diagnostico_receta;


        $response = [];

        if ($data_diag_req) {


            $citas_id = $data_diag_req->citas_id;
            $tipo_diagnostico_id = $data_diag_req->tipo_diagnostico_id;
            $diagnosticocie10_id = $data_diag_req->diagnosticocie10_id;

            $existecodigo = Receta_Diagnostico::where('diagnosticocie10_id', $diagnosticocie10_id)->where('citas_id', $citas_id)->where('estado', 'A')
                ->get()->first();

            if ($existecodigo) {
                $response = [
                    'estado' => false,
                    'mensaje' => 'El diagnostico ya se ha registrado, por favor de clic en el boton editar en la tabla',
                    'receta_diagnostico' => null,
                ];
            } else {
                $nuevoRece = new Receta_Diagnostico();

                $nuevoRece->citas_id = $citas_id;
                $nuevoRece->receta_id = null;
                $nuevoRece->tipo_diagnostico_id = $tipo_diagnostico_id;
                $nuevoRece->diagnosticocie10_id = $diagnosticocie10_id;

                $nuevoRece->estado = 'A';

                if ($nuevoRece->save()) {
                    $response = [
                        'estado' => true,
                        'mensaje' => 'El Diagnostico se ha registrado correctamente',
                        'receta_diagnostico' => $nuevoRece,
                    ];
                } else {
                    $response = [
                        'estado' => false,
                        'mensaje' => 'No se ha guardado el diagnostico',
                        'receta_diagnostico' => null,
                    ];
                }
            }
        } else {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para guardar',
                'receta' => null,
            ];
        }

        return response()->json($response, 200);
    }


    public function editarDiagnostico(Request $request)
    {

        $aux = json_decode($request['data']);
        $recetaRequest = $aux->diagnostico_rece;

        $idrecetadiagnostico = intval($recetaRequest->id);
        $tipo_diagnostico_id = intval($recetaRequest->tipo_diagnostico_id);



        $recetadiagnosticodata = Receta_Diagnostico::find($idrecetadiagnostico);
        $response = [];

        if ($recetaRequest) {
            if ($recetadiagnosticodata) {


                $recetadiagnosticodata->tipo_diagnostico_id = $tipo_diagnostico_id;

                $recetadiagnosticodata->save();


                $response = [
                    'status' => true,
                    'mensaje' => 'El diagnotico se ha actualizado',
                    'receta' => $recetadiagnosticodata,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el diagnostico',
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos ',
            ];
        }

        return response()->json($response, 200);
    }



    public function eliminarItemRecetaDiagnostico($recetadiagnosticoId)
    {

        $id_RecetaDiagnostico = intval($recetadiagnosticoId);
        //  $id_estado = intval($estadoId); //3 cancelado
        $mensajes = '';
        $response = [];
        $recetaDiagnostico = Receta_Diagnostico::find($id_RecetaDiagnostico);

        if ($recetaDiagnostico) {

            //  $cita->estado_cita_id = $id_estado;
            $recetaDiagnostico->estado = 'I';
            $recetaDiagnostico->save();


            switch ($id_RecetaDiagnostico) {
                case 1:
                    $mensajes = 'El diagnostico  ha sido eliminada';
                    break;
            }

            $response = [
                'status' => true,
                'mensaje' => $mensajes,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se puede cancelar el diagnostico',
            ];
        }

        return response()->json($response, 200);
    }



    /**EDITAR HISTORIAL CLINICO CITAS */


    /* public function editarCitasHistorialClinico(Request $request){

    $aux = json_decode($request['data']);
    $HistorialClinicoRequest = $aux->historial_clinico;
  

    $idHistorial = intval($HistorialClinicoRequest->id);
  
    $historialData = Historial_Clinico::find($idHistorial);
    $response = [];


    if ($HistorialClinicoRequest) {
        if ($historialData) {
           
            $historialData->motivo_consulta = $HistorialClinicoRequest->motivo_consulta;
            $historialData->antecedentes = $HistorialClinicoRequest->antecedentes;
            $historialData->antecedentes_familiares = $HistorialClinicoRequest->antecedentes_familiares;
            $historialData->plan = $HistorialClinicoRequest->plan;
            $historialData->examen_fisico = $HistorialClinicoRequest->examen_fisico;
            $historialData->evolucion = $HistorialClinicoRequest->evolucion;
            $historialData->enfermedad_actual = $HistorialClinicoRequest->enfermedad_actual;
            $historialData->alergias = $HistorialClinicoRequest->alergias;
 
          
            $historialData->save();

            if ($historialData->save()) {
        
            }
            $response = [
                'status' => true,
                'mensaje' => 'el usuario se ha actualizado',
                'usuario' => $historialData,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se puede actualizar el usuario',
            ];
        }
    } else {
        $response = [
            'status' => false,
            'mensaje' => 'No hay datos ',
        ];
    }

    return response()->json($response, 200);
} */

    public function editarCitasHistorialClinico(Request $request)
    {
        $aux = json_decode($request['data']);
        $HistorialClinicoRequest = $aux->historial_clinico;
        $requestCertificado = $aux->certificados_medicos;
        $requestExaFisico = $aux->examen_fisica;

        $idHistorial = intval($HistorialClinicoRequest->id);
        $historialData = Historial_Clinico::find($idHistorial);
        $response = [];

        if ($historialData) {
            // Actualizar datos del historial clínico
            $historialData->motivo_consulta = $HistorialClinicoRequest->motivo_consulta;
            $historialData->antecedentes = $HistorialClinicoRequest->antecedentes;
            $historialData->antecedentes_familiares = $HistorialClinicoRequest->antecedentes_familiares;
            $historialData->plan = $HistorialClinicoRequest->plan;
            $historialData->examen_fisico = $HistorialClinicoRequest->examen_fisico;
            $historialData->evolucion = $HistorialClinicoRequest->evolucion;
            $historialData->enfermedad_actual = $HistorialClinicoRequest->enfermedad_actual;
            $historialData->alergias = $HistorialClinicoRequest->alergias;
            $historialData->save();

            // Actualizar Certificados Médicos
            if (!empty($requestCertificado)) {
                foreach ($requestCertificado as $certificado) {
                    $certificadoData = Certificados_Medicos::where('citas_id', $historialData->citas_id)->first();
                    if (!$certificadoData) {
                        $certificadoData = new Certificados_Medicos();
                    }
                    $certificadoData->citas_id = $historialData->citas_id;
                    $certificadoData->dia_descanso = $certificado->dia_descanso;
                    $certificadoData->actividad_laboral = $certificado->actividad_laboral;
                    $certificadoData->entidad_laboral = $certificado->entidad_laboral;
                    $certificadoData->direccion = $certificado->direccion;
                    $certificadoData->observacion = $certificado->observacion;
                    $certificadoData->tipo_contingencia_id = $certificado->tipo_contingencia_id;
                    $certificadoData->aislamiento_id = $certificado->aislamiento_id;
                    $certificadoData->estado = 'A';
                    $certificadoData->fecha = date('Y-m-d');


                    $certificadoData->save();
                }
            }

            // Actualizar Examen Físico
            if (!empty($requestExaFisico)) {
                foreach ($requestExaFisico as $examen) {
                    $examenData = Examen_Fisica::where('citas_id', $historialData->citas_id)->first();
                    if (!$examenData) {
                        $examenData = new Examen_Fisica();
                    }
                    $examenData->citas_id = $historialData->citas_id;
                    $examenData->temperatura = $examen->temperatura;
                    $examenData->peso = $examen->peso;
                    $examenData->talla = $examen->talla;
                    $examenData->presion_arterial = $examen->presion_arterial;
                    $examenData->imc = $examen->imc;
                    $examenData->pulso = $examen->pulso;
                    $examenData->frecuencia_respiratoria = $examen->frecuencia_respiratoria;
                    $examenData->saturacion_oxigeno = $examen->saturacion_oxigeno;
                    $examenData->observacion_examen = $examen->observacion_examen;
                    $examenData->recomendacion = $examen->recomendacion;
                    $examenData->estado = 'A';
                    $examenData->fecha = date('Y-m-d');
                    $examenData->save();
                }
            }

            $response = [
                'status' => true,
                'mensaje' => 'El historial clínico y sus registros asociados han sido actualizados correctamente.',
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encontró el historial clínico.',
            ];
        }

        return response()->json($response, 200);
    }



    /**FIN HISTORIAL CLINICO */








    public function eliminarCitasCancelar($id)
    {

        $id_citas = intval($id);
        //  $id_estado = intval($estadoId); //3 cancelado
        $mensajes = '';
        $response = [];
        $citas = Citas::find($id_citas);

        if ($citas) {

            //  $cita->estado_cita_id = $id_estado;
            $citas->estado_cita_id = '5';
            $citas->save();


            switch ($id_citas) {
                case 1:
                    $mensajes = 'La cita ha sido anulada';
                    break;
            }

            $response = [
                'status' => true,
                'mensaje' => $mensajes,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se puede cancelar la cita',
            ];
        }

        return response()->json($response, 200);
    }





    public function datatablelistarcitasGeneral()
    {

        $cita = Citas::where('estado', 'A')->orderBy('fecha', 'DESC')->get();
        $data = [];
        $i = 1;

        foreach ($cita as $citasc) {
            $codigocita = $citasc->codigo_cita;
            $cedula = $citasc->paciente->persona->cedula;

            $cli = $citasc->paciente->persona;
            $doc = $citasc->doctor->persona;
            $esp = $citasc->doctor->especialidades->nombre_especialidad;
            //$serv = $citasc->servicios->nombre_servicio;
            $hor = substr($citasc->doctor_horario->hora_inicio, 0, -3) . ' - ' .  substr($citasc->doctor_horario->hora_fin, 0, -3);
            $dataEstadoCita = $citasc->estado_cita;
            $dataFechaCita  = $citasc->fecha;
            $estado = $citasc->estado_cita_id;
            $horaregistrada = date('Y-m-d H:i:s', strtotime($citasc->created_at));

            // Formatear la fecha de manera dinámica
            $fechaFormateada = date('l j-m-Y', strtotime($dataFechaCita));

            // Cambiar los nombres de los días de la semana a español
            $fechaFormateada = str_replace(
                ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                $fechaFormateada
            );



            $estadoCancelado = 5;

            // Deshabilitar botones según el estado
            $disabledAtender = ($citasc->estado_cita_id == 1 || $citasc->estado_cita_id == 2 || $citasc->estado_cita_id == 5) ? 'disabled' : '';
            $disabledCancelar = ($citasc->estado_cita_id == 3 ||  $citasc->estado_cita_id == 2 || $citasc->estado_cita_id == 5) ? 'disabled' : '';

            // Mostrar badge según el estado
            if ($estado == 1) {
                $estado = '<span class="badge bg-warning" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            } else if ($estado == 2) {
                $estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            } else {
                $estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            }

            // Botones con sus respectivos "disabled"
            $botones = '<div class="">
                <button class="btn btn-sm btn-success" onclick="atender(' . $citasc->id . ', ' . $citasc->paciente_id . ')" title="Atender Cita" ' . $disabledAtender . '>
                    <i class="fa fa-eye"></i> 
                </button>
            
                <button class="btn btn-sm btn-danger" onclick="cancelar_cita(' . $citasc->id . ', ' . $estadoCancelado . ')" title="Cancelar Cita" ' . $disabledCancelar . '>
                    <i class="fas fa-times"></i>
                </button>
            </div>';


            $data[] = [
                0 => $i,
                1 => $codigocita,
                2 => $horaregistrada,
                3 => $cedula,
                4 => $cli->nombre . ' ' . $cli->apellido,
                5 => $doc->nombre . ' ' . $doc->apellido,
                6 => $esp,
                7 => $fechaFormateada,
                8 => $hor,
                9 => $estado,
                10 => $botones,
            ];
            $i++;
        }

        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];

        return response()->json($result, 200);
    }



   public function atendientocitas($id)
    {

        $id_citas = intval($id);
        //  $id_estado = intval($estadoId); //3 cancelado
        $mensajes = '';
        $response = [];
        $citas = Citas::find($id_citas);

        if ($citas) {

            //  $cita->estado_cita_id = $id_estado;
            $citas->estado_cita_id = '3';
            $citas->save();


            switch ($id_citas) {
                case 1:
                    $mensajes = 'La cita en proceso';
                    break;
            }

            $response = [
                'status' => true,
                'mensaje' => $mensajes,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se puede atender la cita',
            ];
        }

        return response()->json($response, 200);
    }



}
