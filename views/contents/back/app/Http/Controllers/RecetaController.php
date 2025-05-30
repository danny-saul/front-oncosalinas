<?php

namespace App\Http\Controllers;

use App\Models\Numeros_Receta;
use App\Models\Receta;
use Illuminate\Http\Request;

class RecetaController extends Controller
{
/* 
public function guardarOrdenReceta(Request $request){
   // dd($request->all());
    $aux = json_decode($request['data']);
    $receRequest = $aux->receta ?? null;
    $detalleReq = $aux->orden_rece ?? [];
    $diagnosticos = $aux->receta_diagnostico ?? [];

    $receta_id = null;

    if ($receRequest) {
        $nuevo = new Receta();
        $nuevo->numero_receta = $receRequest->numero_receta;
        $nuevo->citas_id = intval($receRequest->citas_id);
        $nuevo->fecha_rece = date('Y-m-d');
        $nuevo->estado = 'A';

        $existe = Receta::where('numero_receta', $nuevo->numero_receta)->first();
        if ($existe) {
            return response()->json([
                'status' => false,
                'mensaje' => 'El número de receta ya existe',
                'receta' => null
            ], 200);
        }

        if ($nuevo->save()) {
            $receta_id = $nuevo->id;
            $detalle_Controller = new Receta_DetalleController();
            $detalle_Controller->guardar_detalleReceta($receta_id, $detalleReq);

        if (!empty($diagnosticos)) {
            $diagnostico_controller = new Receta_DiagnosticosController();
            $diagnostico_controller->guardar_recetas_diagnosticos($receta_id, $receRequest->citas_id ?? null, $diagnosticos);
        }


        } else {
            return response()->json([
                'status' => false,
                'mensaje' => 'No se pudo guardar la receta',
                'receta' => null
            ], 200);
        }
    }

  

    // Cambiar aquí para enviar un objeto receta con id:
    return response()->json([
        'status' => true,
        'mensaje' => 'Datos guardados',
        'receta' => [
            'id' => $receta_id
        ]
    ], 200);
}
 */


 public function guardarOrdenReceta(Request $request){
    $aux = json_decode($request['data']);
    $receRequest = $aux->receta ?? null;
    $detalleReq = $aux->orden_rece ?? []; 
    $diagnosticos = $aux->receta_diagnostico ?? [];

    $receta_id = null;

    if ($receRequest) {
        $nuevo = new Receta();
        $nuevo->numero_receta = $receRequest->numero_receta;
        $nuevo->citas_id = intval($receRequest->citas_id);
        $nuevo->paciente_id = intval($receRequest->paciente_id);
        $nuevo->fecha_rece = date('Y-m-d');
        $nuevo->estado = 'A';

        $existe = Receta::where('numero_receta', $nuevo->numero_receta)->first();
        if ($existe) {
            return response()->json([
                'status' => false,
                'mensaje' => 'El número de receta ya existe',
                'receta' => null
            ]);
        }

        if ($nuevo->save()) {
            $receta_id = $nuevo->id;

            $detalle_Controller = new Receta_DetalleController();
            $detalle_Controller->guardar_detalleReceta($receta_id, $detalleReq);

            if (!empty($diagnosticos)) {
                $diagnostico_controller = new Receta_DiagnosticosController();
                $diagnostico_controller->guardar_recetas_diagnosticos(
                    $receta_id, 
                    $receRequest->citas_id ?? null, 
                    $diagnosticos
                );
            }

            return response()->json([
                'status' => true,
                'mensaje' => 'Datos guardados',
                'receta' => [
                    'id' => $receta_id
                ]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'mensaje' => 'No se pudo guardar la receta',
                'receta' => null
            ]);
        }
    }

    // Caso donde no vino receta (solo diagnóstico)
    return response()->json([
        'status' => true,
        'mensaje' => 'Datos guardados',
        'receta' => [
            'id' => null
        ]
    ]);
}



    public function getReceta($id_receta){
        $receta = Receta::where('citas_id', $id_receta)->get();

        return $receta;
    }


   public function generar_aleartorio_rece($id_tablas4) 
   {

        $numeros_recetaas = Numeros_Receta::where('id_tablas4', $id_tablas4)->orderBy('id', 'DESC')->first();
        $response = [];

        if ($numeros_recetaas == null) {
            $response = [
                'estado' => true,
                'id_tablas4' => $id_tablas4,
                'mensaje' => 'Primera Serie Labs',
                'numeros_recetas' => '00000000001',
            ];
        } else {
            $numero = intval($numeros_recetaas->num_receta);

            $nextSerie = '0000000000' . ($numero += 1);
            $response = [
                'estado' => true,
                'id_tablas4' => $id_tablas4,
                'mensaje' => 'Proximo numero',
                'numeros_recetas' => $nextSerie,
            ];
        }

        return response()->json($response, 200);
    }

    public function aumentarAleartoriosRec(Request $request) 
    
    {

        $aux = json_decode($request['data']);
        $numLabsRequest = $aux->num_receta;
        $num_receta = $numLabsRequest->num_receta;
        $id_tablas4 = $numLabsRequest->id_tablas4;
        $response = [];

        if ($numLabsRequest == null) {
            $response = [
                'status' => false,
                'mensaje' => 'no ahi datos para procesar',
            ];
        } else {
            $nuevoNumRece = new Numeros_Receta();
            $nuevoNumRece->num_receta = $num_receta;
            $nuevoNumRece->id_tablas4 = $id_tablas4;
            $nuevoNumRece->estado = 'A';
            $nuevoNumRece->save();

            $response = [
                'estado' => true,
                'mensaje' => 'Guardando Datos',
                'numeros_recetas' => $nuevoNumRece,
            ];
        }

        return response()->json($response, 200);
    }






    /**INICIO DE GUARDAR LA EDICION DE UNA NUEVA RECETA */


        public function listar_encabezadoreceta($citaId){
    
        $cita_id = intval($citaId);
        $recetas = Receta::where('citas_id', $cita_id)->where('estado','A')->get();
        $response = [];

        if($recetas == null){
            $response = [
                'estado'=>false,
                'mensaje'=>'No hay datos para mostrar',
                'rece'=> null,

            ];
        }else{
     
             
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'rece' => $recetas,
           
         
            ];
        }

        return response()->json($response);

    }


    public function datatable_receta_editar($citaId)
{
    $cita_id = intval($citaId);

    // Obtener los receta relacionados con la cita
    $receta = Receta::where('citas_id', $cita_id)
                               ->where('estado', 'A')
                               ->with(['paciente.persona', 'receta_detalle.producto'])  // Eager loading
                               ->get();

    // Verificar si hay receta
    if ($receta->isEmpty()) {
        return response()->json([
            'encabezado2' => [
                'numero_orden' => 'No disponible',
                'paciente' => 'Paciente no encontrado'
            ],
            'sEcho' => 1,
            'iTotalRecords' => 0,
            'iTotalDisplayRecords' => 0,
            'aaData' => []
        ], 200);
    }

    // Tomar el primer laboratorio para obtener los datos generales
    $rec = $receta->first();

    // Verificar si el laboratorio tiene paciente asociado
    $paciente_nombre = $rec->paciente && $rec->paciente->persona
        ? $rec->paciente->persona->nombre . ' ' . $rec->paciente->persona->apellido
        : 'Paciente no encontrado';

    $numero_orden = $rec->numero_receta ?? 'No disponible';

    // Encabezado con número de orden y nombre del paciente
    $encabezado2 = [
        'numero_orden' => $numero_orden,
        'paciente' => $paciente_nombre,
    ];

    // Crear los datos de los detalles del laboratorio
    $data = [];

    foreach ($receta as $lab) {
        // Verificar si tiene detalles antes de recorrerlos
        if ($lab->receta_detalle->isEmpty()) {
            continue;
        }

        foreach ($lab->receta_detalle as $detalle) {
            // Filtrar los detalles de laboratorio por estado 'A'
            if ($detalle->estado !== 'A') {
                continue;
            }

            $producto = $detalle->producto;
        

            // Botón de editar (deshabilitado)
            $botones1 = '<div class="">
                            <button class="btn btn-sm btn-warning"   onclick="editar_medicamento(' . $detalle->id . ')">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                        </div>';

            // Botón de eliminar
            $botones2 = '<div class="">
                            <button class="btn btn-sm btn-danger" onclick="eliminarreceta(' . $detalle->id . ')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>';

            // Añadir la información del detalle a la tabla
            $data[] = [
                0 => $detalle->cantidad ?? 'Sin cantidad',
                1 => isset($producto) ? $producto->nombre_producto : 'Sin tipo de receta',
                2 => $detalle->dosis->tipo_dosis ?? 'Sin cantidad',
                3 => $detalle->frecuencia->tipo_frecuencia ?? 'Sin cantidad',
                4 => $detalle->via->tipo_via ?? 'Sin cantidad',
                5 => $detalle->duracion ?? 'Sin duracion',
                6 => $detalle->observacion ?? 'Sin duracion',
                7 => $botones1,
                8 => $botones2,
            ];
        }
    }

    // Devolver la respuesta en formato JSON con los datos
    return response()->json([
        'encabezado2' => $encabezado2,
        'sEcho' => 1,
        'iTotalRecords' => count($data),
        'iTotalDisplayRecords' => count($data),
        'aaData' => $data,
    ], 200);
}





/****************************************************GUARDAR RECETA NUEVO CON ORDEN SI VIENE VACIO EN EL DB CREA LA ORDEN RECETA GUARDA */


 public function guardarOrdenRecetaNueva(Request $request ){

        $aux = json_decode($request['data']);
        $recetaRequest = $aux->receta;
        $detalleReq = $aux->orden_rece;

        $response = [];

        if($recetaRequest ){
      
                $numero_receta = $recetaRequest->numero_receta;
      
                $recetaRequest->citas_id = intval($recetaRequest->citas_id);
                $recetaRequest->paciente_id = intval($recetaRequest->paciente_id);
     


                $nuevo = new Receta();
          
                $nuevo->numero_receta = $numero_receta;
                $nuevo->citas_id = $recetaRequest->citas_id;
             
                $nuevo->paciente_id = $recetaRequest->paciente_id;
                $nuevo->status_facturado ='N';
                $nuevo->fecha_rece = Date('Y-m-d');
                $nuevo->estado = 'A'; 
                $norepetirCodigo = Receta::where('numero_receta', $numero_receta)->get()->first();
                

                if ($norepetirCodigo) {
                    $response = [
                        'status' => false,
                        'mensaje' => 'El numero de orden de la receta ya existe',
                        'receta' => null,
                        'detalle' => null,
     
    
                    ];
                } else{
                    if($nuevo->save()){
                    
                               //Guarda detalle de venta
                    $detalle_Controller = new Receta_DetalleController();
                    $det = $detalle_Controller->guardar_detalleReceta($nuevo->id, $detalleReq);
       

                    $response = [
                        'status' => true,
                        'mensaje' => 'Guardando los datos',
                        'receta' => $nuevo,
                        'detalle' => $det,
                       
                    ];




                    }else{
                        $response = [
                            'status' => false,
                            'mensaje' => 'No se puede guardar',
                            'laboratorio' => null,
                            'detalle' => null,
                        ];
                    }
                }
           
                
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay servicios en la orden',
                'laboratorio' => null,
                'detalle' => null,
            ];
        }
        return response()->json($response, 200);
    } 




    











}
