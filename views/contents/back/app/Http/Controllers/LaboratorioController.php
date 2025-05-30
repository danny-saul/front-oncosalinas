<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use App\Models\Laboratorio_Detalle;
use App\Models\Numeros_Aleartorios;
use App\Models\Numeros_Laboratorio;
use App\Models\Tipo_Examen;
use Illuminate\Http\Request;

class LaboratorioController extends Controller
{
    //

    public function listar_tipoexamenAnterior()
    {

        $tipo_examen = Tipo_Examen::where('estado', 'A')->get();
        $response = [];

        if ($tipo_examen) {

            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'tipo_examen' => $tipo_examen,
           
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'tipo_examen' => null,
            ];
        }

        return response()->json($response, 200);
    } 


    public function listar_tipoexamen(Request $request)
    {
        $search = $request->get('q');

        $tipo_examen = Tipo_Examen::where('estado', 'A')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('descripcion_lab', 'like', '%' . $search . '%')
                    ->orWhere('codigo_lab', 'like', '%' . $search . '%');
                });
            })
            ->limit(20)
            ->get();

        return response()->json($tipo_examen, 200);
    }



    public function listarId($id)
    {

        $id = intval($id);
        $tipo_examen = Tipo_Examen::find($id);
        $response = [];

        if ($tipo_examen) {
    
            $response = [
                'status' => true,
                'tipo_examen' => $tipo_examen,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el tipo_examen',
                'tipo_examen' => null,
            ];
        }
        return response()->json($response, 200);
    }
    
    public function generar_aleartorio_lab($id_tablas2){

        $num_laboratorio = Numeros_Laboratorio::where('id_tablas2', $id_tablas2)->orderBy('id', 'DESC')->first();
        $response = [];

        if ($num_laboratorio == null) {
            $response = [
                'estado' => true,
                'id_tablas2' => $id_tablas2,
                'mensaje' => 'Primera Serie Labs',
                'numero_labs' => '00000000001',
            ];
        } else {
            $numero = intval($num_laboratorio->num_labs);

            $nextSerie = '0000000000' . ($numero += 1);
            $response = [
                'estado' => true,
                'id_tablas2' => $id_tablas2,
                'mensaje' => 'Proximo numero',
                'numero_labs' => $nextSerie,
            ];
        }

        return response()->json($response, 200);
    }

    public function aumentarAleartoriosLab(Request $request){

        $aux = json_decode($request['data']);
        $numLabsRequest = $aux->num_labs;
        $num_labs = $numLabsRequest->num_labs;
        $id_tablas2 = $numLabsRequest->id_tablas2;
        $response = [];

        if ($numLabsRequest == null) {
            $response = [
                'status' => false,
                'mensaje' => 'no ahi datos para procesar',
            ];
        } else {
            $nuevoNumLabs = new Numeros_Laboratorio();
            $nuevoNumLabs->num_labs = $num_labs;
            $nuevoNumLabs->id_tablas2 = $id_tablas2;
            $nuevoNumLabs->estado = 'A';
            $nuevoNumLabs->save();

            $response = [
                'estado' => true,
                'mensaje' => 'Guardando Datos',
                'numero_labs' => $nuevoNumLabs,
            ];
        }

        return response()->json($response, 200);
    }


    /**GUARDAR LABORATORIO ANTERIOR */
  /*   public function guardarOrdenLaboratorio($citas_id, $orden_lab = [] ){
        $response = [];

        if($orden_lab > 0 ){
            foreach($orden_lab as $serv){
                $nuevo = new Laboratorio();
                $nuevo->citas_id = $citas_id;
                $nuevo->doctor_id = intval($serv->doctor_id);
                $nuevo->tipo_examen_id = intval($serv->tipo_examen_id);
                $nuevo->numero_orden_lab = $serv->numero_orden_lab;
                $nuevo->estado_orden_id = 1;
                $nuevo->justificacion_lab = $serv->justificacion_lab;
                $nuevo->resumen_lab = $serv->resumen_lab;
                $nuevo->informe_lab = '';
                $nuevo->conclusion_lab = '';
                $nuevo->documento_lab = 1;
                $nuevo->fecha_lab = Date('Y-m-d');
                $nuevo->estado = 'A'; 
                $nuevo->save();

            }
            $response = [
                'status' => true,
                'mensaje' => 'Guardado Diagnostico'
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay servicios en la orden',
                'receta_diagnostico' => null,
            ];
        }
        return response()->json($response, 200);
    }  */


    public function guardarOrdenLaboratorio(Request $request ){

        $aux = json_decode($request['data']);
        $labRequest = $aux->laboratorio;
        $detalleReq = $aux->orden_lab;

        $response = [];

        if($labRequest ){
      
                $numero_orden_lab = $labRequest->numero_orden_lab;
                $labRequest->doctor_id = intval($labRequest->doctor_id);
                $labRequest->citas_id = intval($labRequest->citas_id);
                $labRequest->paciente_id = intval($labRequest->paciente_id);
             //   $labRequest->subtotal = floatval($labRequest->subtotal);
            //    $labRequest->iva = floatval($labRequest->iva);
            //    $labRequest->descuento = floatval($labRequest->descuento);
          //      $labRequest->total = floatval($labRequest->total);


                $nuevo = new Laboratorio();
          
                $nuevo->numero_orden_lab = $numero_orden_lab;
                $nuevo->citas_id = $labRequest->citas_id;
                $nuevo->doctor_id = $labRequest->doctor_id;
                $nuevo->paciente_id = $labRequest->paciente_id;
                $nuevo->subtotal = 1;
                $nuevo->iva = 1;
                $nuevo->descuento = 1;
                $nuevo->total = 1;

                $nuevo->informe_lab = '';
                $nuevo->conclusion_lab = '';
                $nuevo->documento_lab = '';
                $nuevo->fecha_lab = Date('Y-m-d');
                $nuevo->estado = 'A'; 
                $nuevo->estado_orden_id = 1;

                $norepetirCodigo = Laboratorio::where('numero_orden_lab', $numero_orden_lab)->get()->first();
                

                if ($norepetirCodigo) {
                    $response = [
                        'status' => false,
                        'mensaje' => 'El numero de orden de laboratorio ya existe',
                        'laboratorio' => null,
                        'detalle' => null,
                     //   'transaccion' => null,
                        //'inventario' => null,
    
                    ];
                } else{
                    if($nuevo->save()){
                    
                               //Guarda detalle de venta
                    $detalle_Controller = new Laboratorio_DetalleController();
                    $det = $detalle_Controller->guardar_detalleLaboratorio($nuevo->id, $detalleReq);

                    $response = [
                        'status' => true,
                        'mensaje' => 'Guardando los datos',
                        'laboratorio' => $nuevo,
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

    /**INCIIO DE EDITAR LABORATORIO */


/*     public function datatableLaboratorioeditar($citaId)
    {
        $cita_id = intval($citaId);
    
        // Obtener los laboratorios relacionados con la cita
        $laboratorios = Laboratorio::where('citas_id', $cita_id)
                                   ->where('estado', 'A')
                                   ->with(['paciente', 'laboratorio_detalle.tipo_examen'])  // Eager loading de relaciones
                                   ->get();
    
        // Obtener el primer laboratorio para mostrar el número de orden y el paciente
        $lab = $laboratorios->first();
        $paciente_nombre = $lab->paciente->persona->nombre . ' ' . $lab->paciente->persona->apellido ?? 'Paciente no encontrado';
        $numero_orden = $lab->numero_orden_lab ?? 'No disponible';
    
        // Encabezado con número de orden y nombre del paciente
        $encabezado = [
            'numero_orden' => $numero_orden,
            'paciente' => $paciente_nombre,
        ];
    
        // Crear los datos de los detalles del laboratorio
        $data = [];
        $i = 1;
    
        foreach ($laboratorios as $lab) {
            // Recorrer los detalles del laboratorio
            foreach ($lab->laboratorio_detalle as $detalle) {
                $tipo_examen = $detalle->tipo_examen;
    
                // Botón de editar
                $botones1 = '<div class="">
                                <button class="btn btn-sm btn-warning" onclick="editar_laboratorio(' . $detalle->id . ' )">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                            </div>';
    
                // Botón de eliminar
                $botones2 = '<div class="">
                                <button class="btn btn-sm btn-danger" onclick="eliminar_laboratorio(' . $detalle->id . ')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </div>';
    
                // Añadir la información del detalle a la tabla
                $data[] = [
                    0 => $tipo_examen->codigo_lab . ' ' . $tipo_examen->descripcion_lab,  // Información del tipo de examen
                    1 => $detalle->justificacion_lab,  // Justificación
                    2 => $detalle->resumen_lab,  // Resumen
                    3 => $botones1,  // Botón de editar
                    4 => $botones2,  // Botón de eliminar
                ];
                $i++;
            }
        }
    
        // Devolver la respuesta en formato JSON con los datos
        $result = [
            'encabezado' => $encabezado,  // Datos generales: número de orden y paciente
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,  // Detalles de los laboratorios
        ];
    
        return response()->json($result, 200);
    }
 */


/*  public function datatableLaboratorioeditar($citaId)
{
    $cita_id = intval($citaId);

    // Obtener los laboratorios relacionados con la cita
    $laboratorios = Laboratorio::where('citas_id', $cita_id)
                               ->where('estado', 'A')
                               ->with(['paciente.persona', 'laboratorio_detalle.tipo_examen'])  // Eager loading
                               ->get();

    // Verificar si hay laboratorios
    if ($laboratorios->isEmpty()) {
        return response()->json([
            'encabezado' => [
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
    $lab = $laboratorios->first();

    // Verificar si el laboratorio tiene paciente asociado
    $paciente_nombre = $lab->paciente && $lab->paciente->persona
        ? $lab->paciente->persona->nombre . ' ' . $lab->paciente->persona->apellido
        : 'Paciente no encontrado';

    $numero_orden = $lab->numero_orden_lab ?? 'No disponible';

    // Encabezado con número de orden y nombre del paciente
    $encabezado = [
        'numero_orden' => $numero_orden,
        'paciente' => $paciente_nombre,
    ];

    // Crear los datos de los detalles del laboratorio
    $data = [];

    foreach ($laboratorios as $lab) {
        // Verificar si tiene detalles antes de recorrerlos
        if ($lab->laboratorio_detalle->isEmpty()) {
            continue;
        }

        foreach ($lab->laboratorio_detalle as $detalle) {
            $tipo_examen = $detalle->tipo_examen;

            // Botón de editar
            $botones1 = '<div class="">
                            <button class="btn btn-sm btn-warning"  disabled onclick="editar_laboratorio(' . $detalle->id . ')">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                        </div>';

            // Botón de eliminar
            $botones2 = '<div class="">
                            <button class="btn btn-sm btn-danger" onclick="eliminar_laboratorio(' . $detalle->id . ')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>';

            // Añadir la información del detalle a la tabla
            $data[] = [
                0 => isset($tipo_examen) ? $tipo_examen->codigo_lab . ' ' . $tipo_examen->descripcion_lab : 'Sin tipo de examen',
                1 => $detalle->justificacion_lab ?? 'Sin justificación',
                2 => $detalle->resumen_lab ?? 'Sin resumen',
                3 => $botones1,
                4 => $botones2,
            ];
        }
    }

    // Devolver la respuesta en formato JSON con los datos
    return response()->json([
        'encabezado' => $encabezado,
        'sEcho' => 1,
        'iTotalRecords' => count($data),
        'iTotalDisplayRecords' => count($data),
        'aaData' => $data,
    ], 200);
} */

public function datatableLaboratorioeditar($citaId)
{
    $cita_id = intval($citaId);

    // Obtener los laboratorios relacionados con la cita
    $laboratorios = Laboratorio::where('citas_id', $cita_id)
                               ->where('estado', 'A')
                               ->with(['paciente.persona', 'laboratorio_detalle.tipo_examen'])  // Eager loading
                               ->get();

    // Verificar si hay laboratorios
    if ($laboratorios->isEmpty()) {
        return response()->json([
            'encabezado' => [
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
    $lab = $laboratorios->first();

    // Verificar si el laboratorio tiene paciente asociado
    $paciente_nombre = $lab->paciente && $lab->paciente->persona
        ? $lab->paciente->persona->nombre . ' ' . $lab->paciente->persona->apellido
        : 'Paciente no encontrado';

    $numero_orden = $lab->numero_orden_lab ?? 'No disponible';

    // Encabezado con número de orden y nombre del paciente
    $encabezado = [
        'numero_orden' => $numero_orden,
        'paciente' => $paciente_nombre,
    ];

    // Crear los datos de los detalles del laboratorio
    $data = [];

    foreach ($laboratorios as $lab) {
        // Verificar si tiene detalles antes de recorrerlos
        if ($lab->laboratorio_detalle->isEmpty()) {
            continue;
        }

        foreach ($lab->laboratorio_detalle as $detalle) {
            // Filtrar los detalles de laboratorio por estado 'A'
            if ($detalle->estado !== 'A') {
                continue;
            }

            $tipo_examen = $detalle->tipo_examen;

            // Botón de editar (deshabilitado)
            $botones1 = '<div class="">
                            <button class="btn btn-sm btn-warning"  disabled onclick="editar_laboratorio(' . $detalle->id . ')">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                        </div>';

            // Botón de eliminar
            $botones2 = '<div class="">
                            <button class="btn btn-sm btn-danger" onclick="eliminar_laboratorio(' . $detalle->id . ')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>';

            // Añadir la información del detalle a la tabla
            $data[] = [
                0 => isset($tipo_examen) ? $tipo_examen->codigo_lab . ' ' . $tipo_examen->descripcion_lab : 'Sin tipo de examen',
                1 => $detalle->justificacion_lab ?? 'Sin justificación',
                2 => $detalle->resumen_lab ?? 'Sin resumen',
                3 => $botones1,
                4 => $botones2,
            ];
        }
    }

    // Devolver la respuesta en formato JSON con los datos
    return response()->json([
        'encabezado' => $encabezado,
        'sEcho' => 1,
        'iTotalRecords' => count($data),
        'iTotalDisplayRecords' => count($data),
        'aaData' => $data,
    ], 200);
}


    
    public function listar_encabezadolabs($citaId){
    
        $cita_id = intval($citaId);
        $laboratorios = Laboratorio::where('citas_id', $cita_id)->where('estado','A')->get();
        $response = [];

        if($laboratorios == null){
            $response = [
                'estado'=>false,
                'mensaje'=>'No hay datos para mostrar',
                'labs'=> null,

            ];
        }else{
     
             
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'labs' => $laboratorios,
           
         
            ];
        }

        return response()->json($response);

    }


    public function guardar_agregarLabsEdicion(Request $request)
{

    $auxiliar = json_decode($request['data']);
    $data_labs_req = $auxiliar->labs_detalle;


    $response = [];

    if ($data_labs_req) {
      
    
        $laboratorio_id = $data_labs_req->laboratorio_id;
        $tipo_examen_id = $data_labs_req->tipo_examen_id;
        $justificacion_lab = $data_labs_req->justificacion_lab;
        $resumen_lab = $data_labs_req->resumen_lab;
       
    
        $existecodigo = Laboratorio_Detalle::where('tipo_examen_id',$tipo_examen_id)->where('laboratorio_id', $laboratorio_id)->where('estado', 'A')
        ->get()->first();

        if ($existecodigo) {
            $response = [
                'estado' => false,
                'mensaje' => 'El tipo de estudio de laboratorio ya se ha registrado, por favor de clic en el boton editar en la tabla',
                'orden' => null,
            ];

    }
       else {
            $nuevoOrden = new Laboratorio_Detalle();
    
            $nuevoOrden->laboratorio_id = $laboratorio_id;
     
            $nuevoOrden->tipo_examen_id = $tipo_examen_id;
            $nuevoOrden->justificacion_lab = $justificacion_lab;
            $nuevoOrden->resumen_lab = $resumen_lab;
            $nuevoOrden->cantidad = '1';
      
            $nuevoOrden->estado = 'A';
      
            $nuevoOrden->precio_venta = 1;
            $nuevoOrden->total_general = 1;
            $nuevoOrden->resultado_examen = '';
       

            if ($nuevoOrden->save()) {
                $response = [
                    'estado' => true,
                    'mensaje' => 'El estudio de laboratorio se ha registrado correctamente',
                    'orden' => $nuevoOrden,
                ];
            } else {
                $response = [
                    'estado' => false,
                    'mensaje' => 'No se ha guardado el estudio',
                    'orden' => null,
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

    





    /**FIN DE INICIO DE LABORATORIO */


    /**EDITAR Y ELIMINAR LABORATORIO */

public function eliminarItemLabs($LabsId){

    $id_laboratorio = intval($LabsId);
  //  $id_estado = intval($estadoId); //3 cancelado
    $mensajes = '';
    $response = [];
    $laboratorio = Laboratorio_Detalle::find($id_laboratorio);

    if ($laboratorio) {

      //  $cita->estado_cita_id = $id_estado;
        $laboratorio->estado = 'I';
        $laboratorio->save();
      
  
        switch ($id_laboratorio) {
            case 1:
                $mensajes = 'La Items de laboratorio  ha sido eliminada';
                break;
        }

        $response = [
            'status' => true,
            'mensaje' => $mensajes,
        ];
    } else {
        $response = [
            'status' => false,
            'mensaje' => 'No se puede cancelar la orden',
        ];
    }

    return response()->json($response, 200);
}
/**FIN */


}
