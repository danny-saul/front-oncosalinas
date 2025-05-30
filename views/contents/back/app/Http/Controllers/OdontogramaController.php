<?php

namespace App\Http\Controllers;

use App\Models\Diagnostico_Odonto;
use App\Models\Odontograma;
use App\Models\Odontograma_Detalle;
use App\Models\Odontograma_Diagnostico;
use App\Models\Procedimiento_Odonto;
use App\Models\Tratamiento_Odontograma;
use Illuminate\Http\Request;

class OdontogramaController extends Controller
{
    //



    /**LISTAR DIAGNOSTICO Y PROCEDIMIENTO ODONTO */

    public function listar_diagnostico_odnto(){

        $dtdiagnostico = Diagnostico_Odonto::get();
        $response = [];

        if ($dtdiagnostico) {
            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'diagnostico' => $dtdiagnostico,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'diagnostico' => null,
            ];
        }

        return response()->json($response, 200);
    }


    
    public function listar_procedimiento_odnto(){

        $dtprocedimiento = Procedimiento_Odonto::get();
        $response = [];

        if ($dtprocedimiento) {
            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'procedimiento' => $dtprocedimiento,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'procedimiento' => null,
            ];
        }

        return response()->json($response, 200);
    }


    /***FIN  */

    public function guardar(Request $request){

        $data = json_decode($request['data']);
        $reqOdonto = $data->odontograma;
    
        $response = [];
        	 				
        if ($reqOdonto) {
            $newodonto = new Odontograma();
            $newodonto->paciente_id = $reqOdonto->paciente_id;
            $newodonto->observacion = $reqOdonto->observacion;
            $newodonto->num_cara = $reqOdonto->num_cara;
            $newodonto->color = $reqOdonto->color;

            $newodonto->doctor_id = $reqOdonto->doctor_id;
            $newodonto->pieza = '1';
            $newodonto->cuadrante = $reqOdonto->cuadrante;
            $newodonto->diagnosticoscie10_id = $reqOdonto->diagnosticoscie10_id;
            $newodonto->tipo_estudio_id = $reqOdonto->tipo_estudio_id;
            $newodonto->tratamiento_odontograma_id = $reqOdonto->tratamiento_odontograma_id;
            $newodonto->realizado = 'SI';
            $newodonto->estado = 'A';
            $newodonto->fecha = date('Y-m-d H:i:s');

            $newodonto->save();

                $response = [
                    'status' => true,
                    'message' => 'Se ha guardado el Odontograma',
                    'rol' => $newodonto,
                ];
            }
         else {
            $response = [
                'status' => false,
                'message' => 'no hay datos para procesar',
            ];
        }

        return response()->json($response, 200);
    }



    public function listar(){

        $dtTratamiento = Tratamiento_Odontograma::where('estado', 'A')->get();
        $response = [];

        if ($dtTratamiento) {
            $response = [
                'status' => true,
                'message' => 'existen datos',
                'tratamiento' => $dtTratamiento,
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'no existen datos',
                'tratamiento' => null,
            ];
        }

        return response()->json($response, 200);
    }

    public function listarOdontogramas(){

        $dtOdon = Odontograma::where('estado', 'A')->get();
        
		$data = [];
		$i = 1;

        foreach ($dtOdon as $od) {
            $od->paciente->persona;
            $od->doctor->persona;
            $od->tratamiento_odontograma;
            $od->diagnosticoscie10;
            $od->tipo_estudio;

            
			$data[] = [
				0 => $i,
                1 => $od->pieza,
                2 => $od->cuadrante,
				3 => $od->tratamiento_odontograma->nombre_tratamiento,
				4 => $od->diagnosticoscie10->descripcion,
				5 => $od->diagnosticoscie10->clave,
				6 => $od->tipo_estudio->codigo . ' ' .  $od->tipo_estudio->descripcion,
                7 => $od->fecha,
                8 => $od->doctor->persona->nombre . ' ' . $od->doctor->persona->apellido,
                9 => $od->realizado,
                10 => $od->fecha
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
/* 
    public function listarOdontogramapacienteid($paciente_id){

        $id_paciente = intval($paciente_id);
    
        // Obtener todos los odontogramas para el paciente dado
        $odontogramas = Odontograma::where('paciente_id', $id_paciente)->get();
    
   
    
        $data = [];
        $i = 1;
    
        foreach ($odontogramas as $od) {
            $od->paciente->persona;
            $od->doctor->persona;
            $od->tratamiento_odontograma;
            $od->diagnosticoscie10;
            $od->tipo_estudio;
    
            $data[] = [
                0 => $i,
                1 => $od->pieza,
                2 => $od->cuadrante,
                3 => $od->tratamiento_odontograma->nombre_tratamiento,
                4 => $od->diagnosticoscie10->descripcion,
                5 => $od->diagnosticoscie10->clave,
                6 => $od->tipo_estudio->codigo . ' ' .  $od->tipo_estudio->descripcion,
                7 => $od->fecha,
                8 => $od->doctor->persona->nombre . ' ' . $od->doctor->persona->apellido,
                9 => $od->realizado,
                10 => $od->fecha
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
    
/*     public function guardando_odonto(Request $request)
    {
        $aux = json_decode($request->data);
        $OdontoRequest = $aux->odontograma;
        $OdontoDetalleRequest = $aux->odontograma_detalle;
    
        $response = [];
    
        $citas_id = intval($OdontoRequest->citas_id);
        $doctor_id = intval($OdontoRequest->doctor_id);
        $paciente_id = intval($OdontoRequest->paciente_id);
    
        // Buscar si el paciente ya tiene un odontograma
        $odontograma = Odontograma::where('paciente_id', $paciente_id)->first();
    
        if (!$odontograma) {
            // Si no existe, se crea un nuevo odontograma
            $nuevoHC = new Odontograma();
            $nuevoHC->citas_id = $citas_id;
            $nuevoHC->doctor_id = $doctor_id;
            $nuevoHC->paciente_id = $paciente_id;
            $nuevoHC->fecha_creacion = now();
            $nuevoHC->fecha_modificacion = now();
            
    
            if ($nuevoHC->save()) {
                $odontograma_id = $nuevoHC->id;
            } else {
                return response()->json([
                    'status' => false,
                    'mensaje' => 'Error al guardar el odontograma',
                ], 500);
            }
        } else {
            // Si ya existe, solo obtenemos el ID
            $odontograma_id = $odontograma->id;
        }
    
        // Guardar detalles del odontograma
        $detallesGuardados = [];
        foreach ($OdontoDetalleRequest as $detalle) {
            // Verificar si ya existe el mismo detalle
            $existeDetalle = Odontograma_Detalle::where([
                ['odontograma_id', '=', $odontograma_id],
                ['pieza', '=', $detalle->pieza],
                ['cuadrante', '=', $detalle->cuadrante],
                ['diagnostico_odonto_id', '=', $detalle->diagnostico_odonto_id],
                ['estado_activo', '=', 'A']
            ])->first();
    
            if (!$existeDetalle) {
                $nuevoDetalle = new Odontograma_Detalle();
                $nuevoDetalle->odontograma_id = $odontograma_id;
                $nuevoDetalle->pieza = $detalle->pieza;
                $nuevoDetalle->cuadrante = $detalle->cuadrante;
                $nuevoDetalle->citas_id = $detalle->citas_id;
                $nuevoDetalle->diagnostico_odonto_id = $detalle->diagnostico_odonto_id;
                $nuevoDetalle->procedimiento_odonto_id = $detalle->procedimiento_odonto_id;
                $nuevoDetalle->tratamiento_odontograma_id = $detalle->tratamiento_odontograma_id;
                $nuevoDetalle->estado_activo = 'A';
                $nuevoDetalle->fecha = $detalle->fecha;
                $nuevoDetalle->fecha_creacion = now();
                $nuevoDetalle->fecha_modificacion = now();

           
                

                $nuevoDetalle->estado = $detalle->estado; // ✅ Agregar estado aquí

    
                if ($nuevoDetalle->save()) {
                    $detallesGuardados[] = $nuevoDetalle;
                }
            }
        }
    
        return response()->json([
            'status' => true,
            'mensaje' => 'Datos guardados correctamente',
            'odontograma' => $odontograma ?? $nuevoHC,
            'detalles' => $detallesGuardados
        ], 200);
    } */
    
    public function guardando_odonto(Request $request)
{
    $aux = json_decode($request->data);
    $OdontoRequest = $aux->odontograma;
    $OdontoDetalleRequest = $aux->odontograma_detalle;

    $response = [];

    $citas_id = intval($OdontoRequest->citas_id);
    $doctor_id = intval($OdontoRequest->doctor_id);
    $paciente_id = intval($OdontoRequest->paciente_id);

    // Buscar si el paciente ya tiene un odontograma
    $odontograma = Odontograma::where('paciente_id', $paciente_id)->first();

    if (!$odontograma) {
        // Si no existe, se crea un nuevo odontograma
        $nuevoHC = new Odontograma();
        $nuevoHC->citas_id = $citas_id;
        $nuevoHC->doctor_id = $doctor_id;
        $nuevoHC->paciente_id = $paciente_id;
        $nuevoHC->fecha_creacion = now();
        $nuevoHC->fecha_modificacion = now();

        if ($nuevoHC->save()) {
            $odontograma_id = $nuevoHC->id;
        } else {
            return response()->json([
                'status' => false,
                'mensaje' => 'Error al guardar el odontograma',
            ], 500);
        }
    } else {
        // Si ya existe, solo obtenemos el ID
        $odontograma_id = $odontograma->id;
    }

    // Guardar detalles del odontograma
    $detallesGuardados = [];
    foreach ($OdontoDetalleRequest as $detalle) {
        // Verificar si ya existe el mismo detalle
        $existeDetalle = Odontograma_Detalle::where([
            ['odontograma_id', '=', $odontograma_id],
            ['pieza', '=', $detalle->pieza],
            ['cuadrante', '=', $detalle->cuadrante],
            ['estado_activo', '=', 'A']
        ])->first();

        if ($existeDetalle) {
            return response()->json([
                'status' => false,
                'mensaje' => "La pieza {$detalle->pieza} con el cuadrante {$detalle->cuadrante} ya está registrada, por favor busque en la tabla edite o elimine la carilla ",
            ], 200);
        }

        $nuevoDetalle = new Odontograma_Detalle();
        $nuevoDetalle->odontograma_id = $odontograma_id;
        $nuevoDetalle->pieza = $detalle->pieza;
        $nuevoDetalle->cuadrante = $detalle->cuadrante;
        $nuevoDetalle->citas_id = $detalle->citas_id;
        $nuevoDetalle->diagnostico_odonto_id = $detalle->diagnostico_odonto_id;
        $nuevoDetalle->procedimiento_odonto_id = $detalle->procedimiento_odonto_id;
        $nuevoDetalle->tratamiento_odontograma_id = $detalle->tratamiento_odontograma_id;
        $nuevoDetalle->estado_activo = 'A';
        $nuevoDetalle->fecha = $detalle->fecha;
        $nuevoDetalle->fecha_creacion = now();
        $nuevoDetalle->fecha_modificacion = now();
        $nuevoDetalle->estado = $detalle->estado;

        if ($nuevoDetalle->save()) {
            $detallesGuardados[] = $nuevoDetalle;
        }
    }

    return response()->json([
        'status' => true,
        'mensaje' => 'Datos guardados correctamente',
        'odontograma' => $odontograma ?? $nuevoHC,
        'detalles' => $detallesGuardados
    ], 200);
}


/*     public function obtenerOdontograma($paciente_id) {
        // Buscar el odontograma del paciente
        $odontograma = Odontograma::where('paciente_id', $paciente_id)->first();
    
        if (!$odontograma) {
            return response()->json(['status' => false, 'mensaje' => 'No se encontró un odontograma'], 404);
        }
    
        // Buscar los detalles del odontograma
        $detalle = Odontograma_Detalle::where('odontograma_id', $odontograma->id)->get();
    
        return response()->json([
            'status' => true,
            'odontograma' => $odontograma,
            'detalles' => $detalle
        ]);
    } */


    public function obtenerOdontograma($paciente_id) {
        // Buscar el odontograma del paciente
        $odontograma = Odontograma::where('paciente_id', $paciente_id)->first();
    
        if (!$odontograma) {
            return response()->json(['status' => false, 'mensaje' => 'No se encontró un odontograma'], 404);
        }
    
        // Buscar los detalles del odontograma con el estado incluido
        $detalles = Odontograma_Detalle::where('odontograma_id', $odontograma->id)->where('estado_activo','A')
            ->select('pieza', 'cuadrante', 'diagnostico_odonto_id', 'procedimiento_odonto_id', 'estado')
            ->get();
    
        return response()->json([
            'status' => true,
            'odontograma' => $odontograma,
            'detalles' => $detalles
        ]);
    }
    
    
    public function listarOdontogramapacienteid($paciente_id)
    {
        $id_paciente = intval($paciente_id);
    
        // Obtener todos los odontogramas del paciente
        $odontogramas = Odontograma::where('paciente_id', $id_paciente)->get();
    
        $data = [];
        $i = 1;
    
        foreach ($odontogramas as $od) {
            $od->paciente->persona;
            $od->doctor->persona;
    
            // Obtener los detalles del odontograma (tratamientos por diente)
            $detalles = Odontograma_Detalle::where('odontograma_id', $od->id)->where('estado_activo','A')->get();
    
            foreach ($detalles as $detalle) {
                $detalle->diagnostico_odonto;
                $detalle->procedimiento_odonto;
                $detalle->tratamiento_odontograma;

                $botones1 = '<div class="">
                           
                <button class="btn btn-sm btn-warning" onclick="editar_odontograma(' . $detalle->id . ' )">
                       <i class="fas fa-edit"></i> Editar
                   </button>
              
                        </div>';
                $botones2 = '<div class="">
                            

                            <button  class="btn btn-sm btn-danger " onclick="eliminar_odontograma(' . $detalle->id . ')">
                                <i class="fas fa-trash"></i>  Eliminar
                            </button>
                        </div>';

                
    
                $data[] = [
                    0 => $i,
                    1 => $detalle->pieza, // Número del diente
                    2 => $detalle->cuadrante, // Cara del diente
                    3 => isset($detalle->tratamiento_odontograma) ? $detalle->tratamiento_odontograma->nombre_tratamiento : 'N/A',
                    4 => isset($detalle->diagnostico_odonto) ? $detalle->diagnostico_odonto->descripcion_od : 'N/A',
                    5 => isset($detalle->procedimiento_odonto) ? $detalle->procedimiento_odonto->descripcion_pro : 'N/A',
                    6 => $detalle->fecha, // Fecha del tratamiento
                    7 => $od->doctor->persona->nombre . ' ' . $od->doctor->persona->apellido, // Doctor responsable
                    8 => $detalle->estado, // Estado del tratamiento ("Por Hacer", "Encontrado", "Realizado")
                    9 => $detalle->fecha_creacion, // Fecha de creación
                    10 => $detalle->fecha_modificacion, // Última modificación
                    11 => $botones1,
                    12 => $botones2,
                   
                ];
                $i++;
            }
        }
    
        return response()->json([
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ], 200);
    }
    

    
    public function listar_detalleodontoxid($id){
        $iddetalle = intval($id);
        $ododetalle = Odontograma_Detalle::find($iddetalle);
     //   $ordenController = new Servicios_Controller;

        $response = [];

        if($ododetalle == null){
            $response = [
                'estado'=>false,
                'mensaje'=>'No hay datos para mostrar',
                'ododetalle'=> null,

            ];
        }else{
     
           

            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'ododetalle' => $ododetalle,
                'tratamiento' => $ododetalle->tratamiento_odontograma,
                'diagnostico' => $ododetalle->diagnostico_odonto,
                'procedimiento' => $ododetalle->procedimiento_odonto,
               
         
            ];
        }

        return response()->json($response);

    }



    public function editarOdontogramaDetalle(Request $request){

        $aux = json_decode($request['data']);
        $odontoDetalleRequest = $aux->odontograma_detalle;
     
        $idOdontogramaDetalle = intval($odontoDetalleRequest->id);
        $tratamiento_odontograma_id = $odontoDetalleRequest->tratamiento_odontograma_id;
        $diagnostico_odonto_id = $odontoDetalleRequest->diagnostico_odonto_id;
        $procedimiento_odonto_id = $odontoDetalleRequest->procedimiento_odonto_id;
        $estado = $odontoDetalleRequest->estado;
      
       
    
        $OdontoDetalleData = Odontograma_Detalle::find($idOdontogramaDetalle);
        $response = [];
    
        if ($odontoDetalleRequest) {
            if ($OdontoDetalleData) {
              
    
                $OdontoDetalleData->tratamiento_odontograma_id = $tratamiento_odontograma_id;
                $OdontoDetalleData->diagnostico_odonto_id = $diagnostico_odonto_id;
                $OdontoDetalleData->procedimiento_odonto_id = $procedimiento_odonto_id;
                $OdontoDetalleData->estado = $estado;
                $OdontoDetalleData->estado_activo = 'A';
               
                $OdontoDetalleData->save();
    
                
                $response = [
                    'status' => true,
                    'mensaje' => 'La cara del odontograma se ha actualizado',
                    'Odontograma' => $OdontoDetalleData,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar la cara del odontograma',
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



    
/* public function eliminarItemOdontograma($DetalleOdontoID){

    $id_ItemsOdonto = intval($DetalleOdontoID);
    $mensajes = '';
    $response = [];
    $detalle_Odonto = Odontograma_Detalle::find($id_ItemsOdonto);

    if ($detalle_Odonto) {
        // Cambiar el estado_activo a Inactivo (I)
        $detalle_Odonto->estado_activo = 'I';
        // Cambiar el estado a vacío
        $detalle_Odonto->estado = 'vacío';
        $detalle_Odonto->save();

        switch ($id_ItemsOdonto) {
            case 1:
                $mensajes = 'La carilla del odontograma ha sido eliminada';
                break;
            // Aquí puedes agregar más casos si necesitas mensajes específicos
        }

        $response = [
            'status' => true,
            'mensaje' => $mensajes,
        ];
    } else {
        $response = [
            'status' => false,
            'mensaje' => 'No se puede cancelar el item de la carilla',
        ];
    }

    return response()->json($response, 200);
} */


public function eliminarOdontogramaDetalle(Request $request){

    $aux = json_decode($request['data']);
    $odontoDetalleRequest = $aux->odontograma_detalle;
 
    $idOdontogramaDetalle = intval($odontoDetalleRequest->id);
    $estado = $odontoDetalleRequest->estado;
  
   

    $OdontoDetalleData = Odontograma_Detalle::find($idOdontogramaDetalle);
    $response = [];

    if ($odontoDetalleRequest) {
        if ($OdontoDetalleData) {
          
            $OdontoDetalleData->estado = $estado;
            $OdontoDetalleData->estado_activo = 'I';
           
            $OdontoDetalleData->save();

            
            $response = [
                'status' => true,
                'mensaje' => 'La cara del odontograma se ha actualizado',
                'Odontograma' => $OdontoDetalleData,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se puede actualizar la cara del odontograma',
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




public function guardar_edicionDiagnosticoO(Request $request)
{

    $auxiliar = json_decode($request['data']);
    $data_diag_req = $auxiliar->odontograma_diagnostico;


    $response = [];

    if ($data_diag_req) {
      
    
        $odontograma_id = $data_diag_req->odontograma_id;
        $tipo_diagnostico_id = $data_diag_req->tipo_diagnostico_id;
        $diagnostico_odonto_id = $data_diag_req->diagnostico_odonto_id;
        $paciente_id = $data_diag_req->paciente_id;
    
        $existecodigo = Odontograma_Diagnostico::where('diagnostico_odonto_id',$diagnostico_odonto_id)->where('odontograma_id', $odontograma_id)->where('estado', 'A')
        ->get()->first();

        if ($existecodigo) {
            $response = [
                'estado' => false,
                'mensaje' => 'El diagnostico ya se ha registrado, por favor de clic en el boton editar en la tabla',
                'odontograma_diagnostico' => null,
            ];

    }
       else {
            $nuevoRece = new Odontograma_Diagnostico();
    
            $nuevoRece->odontograma_id = $odontograma_id;
            $nuevoRece->tipo_diagnostico_id = $tipo_diagnostico_id;
            $nuevoRece->paciente_id = $paciente_id;
            $nuevoRece->diagnostico_odonto_id = $diagnostico_odonto_id;
            $nuevoRece->fecha =  date('Y-m-d H:i:s');
      
            $nuevoRece->estado = 'A';

            if ($nuevoRece->save()) {
                $response = [
                    'estado' => true,
                    'mensaje' => 'El Diagnostico se ha registrado correctamente',
                    'odontograma_diagnostico' => $nuevoRece,
                ];
            } else {
                $response = [
                    'estado' => false,
                    'mensaje' => 'No se ha guardado el diagnostico',
                    'odontograma_diagnostico' => null,
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

    
public function dtableeditardiagnosticoOdonto($paciente_id)
{

   $paciente_id = intval($paciente_id);
   $odonto_diag = Odontograma_Diagnostico::where('paciente_id', $paciente_id)->where('estado','A')->get();
   $data = [];
   $i = 1;
    foreach ($odonto_diag as $odod) {
     
       $diagnostico= $odod->diagnostico_odonto;
       $tipoDiag= $odod->tipo_diagnostico;
 

     
        $botones2 = '<div class="">
                       

                    <button  class="btn btn-sm btn-danger " onclick="eliminar_diagnostico_odonto(' . $odod->id . ')">
                        <i class="fas fa-trash"></i>  
                    </button>
                </div>';

        $data[] = [
          
             
            0 => $diagnostico->clave_od .' '. $diagnostico->descripcion_od,
            1 => $tipoDiag->tipo_diagnostico,
            2 => $botones2,
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



public function eliminarItemRDiagnostico($id){

    $iddiagnosticoodonto = intval($id);
  //  $id_estado = intval($estadoId); //3 cancelado
    $mensajes = '';
    $response = [];
    $ODiagnostico = Odontograma_Diagnostico::find($iddiagnosticoodonto);

    if ($ODiagnostico) {

      //  $cita->estado_cita_id = $id_estado;
        $ODiagnostico->estado = 'I';
        $ODiagnostico->save();
      
  
        switch ($iddiagnosticoodonto) {
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

}