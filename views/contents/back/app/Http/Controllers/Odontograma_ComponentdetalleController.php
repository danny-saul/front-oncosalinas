<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\Odonto_Componentedetalle;
use App\Models\Odontograma;
use Illuminate\Http\Request;

class Odontograma_ComponentdetalleController extends Controller
{
 
/* 
    public function guardando_odontodetallecomponente(Request $request)
    {
        $auxiliar = json_decode($request['data']);
        $data_componente_req = $auxiliar->odonto_componentedetalle;  // Asegúrate de usar esta clave
    
        $response = [];
    
        if ($data_componente_req) {
            $citas_id = $data_componente_req->citas_id;
            $doctor_id = $data_componente_req->doctor_id;
            $paciente_id = $data_componente_req->paciente_id;
            $odontograma_id = $data_componente_req->odontograma_id;
            $numeroDiente = $data_componente_req->numeroDiente;
            
            $existeregistro = Odonto_Componentedetalle::where('odontograma_id', $odontograma_id)
                ->where('estado_activo', 'A')
                ->where('numeroDiente', $numeroDiente)
                ->get()
                ->first();
            if ($existeregistro) {
                $response = [
                    'estado' => false,
                    'mensaje' => 'El componente ya está registrado para este número de pieza',
                    'orden' => null,
                ];
            } else {
                $nuevoRegistro = new Odonto_Componentedetalle();
                $nuevoRegistro->odontograma_id = intval($odontograma_id);
                $nuevoRegistro->citas_id = intval($citas_id);
                $nuevoRegistro->doctor_id = intval($doctor_id);
                $nuevoRegistro->paciente_id = intval($paciente_id);
                $nuevoRegistro->estadoCarilla = $data_componente_req->estadoCarilla;
                $nuevoRegistro->numeroDiente = $data_componente_req->numeroDiente;
                $nuevoRegistro->elementoComponente = $data_componente_req->elementoComponente;
                $nuevoRegistro->estado_activo = 'A'; // Suponiendo que por defecto está activo
                $nuevoRegistro->fecha = date('Y-m-d');
                $nuevoRegistro->fecha_creacion = now();
                $nuevoRegistro->fecha_modificacion = now();
                $nuevoRegistro->save();
    
                if ($nuevoRegistro->save()) {
                    $response = [
                        'estado' => true,
                        'mensaje' => 'El Diagnóstico se ha registrado correctamente',
                        'orden' => $nuevoRegistro,
                    ];
                } else {
                    $response = [
                        'estado' => false,
                        'mensaje' => 'No se ha guardado el diagnóstico',
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
    } */
    
/*     public function guardando_odontodetallecomponente(Request $request)
{
    $auxiliar = json_decode($request['data']);
    $data_componente_req = $auxiliar->odonto_componentedetalle;

    $response = [];

    if ($data_componente_req) {
        $citas_id = $data_componente_req->citas_id;
      //  $doctor_id = $data_componente_req->doctor_id;
      //  $paciente_id = $data_componente_req->paciente_id;
        $odontograma_id = $data_componente_req->odontograma_id;
        $numeroDiente = $data_componente_req->numeroDiente;
        $estadoCarilla = $data_componente_req->estadoCarilla;

        // Verificar si ya existe un registro con el mismo odontograma_id, numeroDiente y estadoCarilla
        $existeRegistro = Odonto_Componentedetalle::where('odontograma_id', $odontograma_id)
            ->where('numeroDiente', $numeroDiente)
            ->where('estadoCarilla', $estadoCarilla) // Aseguramos que no se repita el mismo estado en la misma pieza dental
            ->where('estado_activo', 'A')
            ->exists();

        if ($existeRegistro) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'El diagnóstico ya está registrado para esta pieza dental con el mismo estado',
                'orden' => null,
            ], 200);
        } 

        // Si no existe, procedemos a guardar el nuevo registro
        $nuevoRegistro = new Odonto_Componentedetalle();
        $nuevoRegistro->odontograma_id = intval($odontograma_id);
        $nuevoRegistro->citas_id = intval($citas_id);
      //  $nuevoRegistro->doctor_id = intval($doctor_id);
     //   $nuevoRegistro->paciente_id = intval($paciente_id);
        $nuevoRegistro->estadoCarilla = $estadoCarilla;
        $nuevoRegistro->numeroDiente = $numeroDiente;
        $nuevoRegistro->elementoComponente = $data_componente_req->elementoComponente;
        $nuevoRegistro->estado_activo = 'A'; // Estado activo por defecto
        $nuevoRegistro->fecha = date('Y-m-d');
        $nuevoRegistro->fecha_creacion = now();
        $nuevoRegistro->fecha_modificacion = now();
        $nuevoRegistro->save();

        return response()->json([
            'estado' => true,
            'mensaje' => 'El diagnóstico se ha registrado correctamente',
            'orden' => $nuevoRegistro,
        ], 200);
    } 

    return response()->json([
        'estado' => false,
        'mensaje' => 'No hay datos para guardar',
        'receta' => null,
    ], 200);
} */


/* public function guardando_odontodetallecomponente(Request $request)
{
    $auxiliar = json_decode($request['data']);
    $data_componente_req = $auxiliar->odonto_componentedetalle;

    if ($data_componente_req) {
        $citas_id = $data_componente_req->citas_id;
        $odontograma_id = $data_componente_req->odontograma_id;
        $numeroDiente = $data_componente_req->numeroDiente;
        $estadoCarilla = $data_componente_req->estadoCarilla;
        $elementoComponente = $data_componente_req->elementoComponente;

        // Verificar si ya existe un registro con el mismo odontograma_id, numeroDiente y estadoCarilla
        $registroExistente = Odonto_Componentedetalle::where('odontograma_id', $odontograma_id)
            ->where('numeroDiente', $numeroDiente)
            ->where('estadoCarilla', $estadoCarilla)
            ->where('estado_activo', 'A')
            ->first();

        if ($registroExistente) {
            // Si ya existe, actualizamos la información
            $registroExistente->elementoComponente = $elementoComponente;
            $registroExistente->fecha_modificacion = now();
            $registroExistente->save();

            return response()->json([
                'estado' => true,
                'mensaje' => 'El diagnóstico ha sido actualizado correctamente',
                'orden' => $registroExistente,
            ], 200);
        } 

        // Si no existe, creamos un nuevo registro
        $nuevoRegistro = new Odonto_Componentedetalle();
        $nuevoRegistro->odontograma_id = intval($odontograma_id);
        $nuevoRegistro->citas_id = intval($citas_id);
        $nuevoRegistro->estadoCarilla = $estadoCarilla;
        $nuevoRegistro->numeroDiente = $numeroDiente;
        $nuevoRegistro->elementoComponente = $elementoComponente;
        $nuevoRegistro->estado_activo = 'A';
        $nuevoRegistro->fecha = date('Y-m-d');
        $nuevoRegistro->fecha_creacion = now();
        $nuevoRegistro->fecha_modificacion = now();
        $nuevoRegistro->save();

        return response()->json([
            'estado' => true,
            'mensaje' => 'El diagnóstico se ha registrado correctamente',
            'orden' => $nuevoRegistro,
        ], 200);
    }

    return response()->json([
        'estado' => false,
        'mensaje' => 'No hay datos para guardar',
        'receta' => null,
    ], 200);
} */

/* public function guardando_odontodetallecomponente(Request $request)
{
    $auxiliar = json_decode($request['data']);
    $data_componente_req = $auxiliar->odonto_componentedetalle;

    if ($data_componente_req) {
        $citas_id = $data_componente_req->citas_id;
        $odontograma_id = $data_componente_req->odontograma_id;
        $numeroDiente = $data_componente_req->numeroDiente;
        $estadoCarilla = $data_componente_req->estadoCarilla;
        $elementoComponente = $data_componente_req->elementoComponente;

        // Buscar si ya existe un registro activo con los mismos valores
        $registroExistente = Odonto_Componentedetalle::where([
            ['odontograma_id', '=', $odontograma_id],
            ['numeroDiente', '=', $numeroDiente],
            ['estadoCarilla', '=', $estadoCarilla],
            ['estado_activo', '=', 'A']
        ])->first();

        if ($registroExistente) {
            // Si el estado es "vacio", se inactiva el registro
            if ($elementoComponente === "Vacio") {
                $registroExistente->estado_activo = 'I';
                $registroExistente->fecha_modificacion = now();
                $registroExistente->save();

                return response()->json([
                    'estado' => true,
                    'mensaje' => 'El diagnóstico ha sido eliminado correctamente',
                    'orden' => $registroExistente,
                ], 200);
            } else {
                // Si no es "vacio", se actualiza la información
                $registroExistente->elementoComponente = $elementoComponente;
                $registroExistente->fecha_modificacion = now();
                $registroExistente->save();

                return response()->json([
                    'estado' => true,
                    'mensaje' => 'El diagnóstico ha sido actualizado correctamente',
                    'orden' => $registroExistente,
                ], 200);
            }
        }

        // NO se debe crear un nuevo registro si el estado es "vacio"
        if ($elementoComponente !== "Vacio") {
            $nuevoRegistro = new Odonto_Componentedetalle();
            $nuevoRegistro->odontograma_id = intval($odontograma_id);
            $nuevoRegistro->citas_id = intval($citas_id);
            $nuevoRegistro->estadoCarilla = $estadoCarilla;
            $nuevoRegistro->numeroDiente = $numeroDiente;
            $nuevoRegistro->elementoComponente = $elementoComponente;
            $nuevoRegistro->estado_activo = 'A';
            $nuevoRegistro->fecha = date('Y-m-d');
            $nuevoRegistro->fecha_creacion = now();
            $nuevoRegistro->fecha_modificacion = now();
            $nuevoRegistro->save();

            return response()->json([
                'estado' => true,
                'mensaje' => 'El diagnóstico se ha registrado correctamente',
                'orden' => $nuevoRegistro,
            ], 200);
        }
    }

    return response()->json([
        'estado' => false,
        'mensaje' => 'No hay datos para guardar',
        'receta' => null,
    ], 200);
} */


/* public function guardando_odontodetallecomponente(Request $request)
{
    $auxiliar = json_decode($request['data']);
    $data_componente_req = $auxiliar->odonto_componentedetalle;

    if ($data_componente_req) {
        $citas_id = $data_componente_req->citas_id;
        $odontograma_id = $data_componente_req->odontograma_id;
        $numeroDiente = $data_componente_req->numeroDiente;
        $estadoCarilla = $data_componente_req->estadoCarilla;
        $elementoComponente = $data_componente_req->elementoComponente;

        // Verificar si ya existe un registro con el mismo odontograma_id, numeroDiente y estadoCarilla
        $registroExistente = Odonto_Componentedetalle::where('odontograma_id', $odontograma_id)
            ->where('numeroDiente', $numeroDiente)
            ->where('estadoCarilla', $estadoCarilla)
            ->where('estado_activo', 'A')
            ->first();

        if ($registroExistente) {
            if ($elementoComponente === "Vacio") {
                // Si el estado es "Vacio", inactivamos el registro
                $registroExistente->update([
                    'estado_activo' => 'I', 
                    'fecha_modificacion' => now()
                ]);

                return response()->json([
                    'estado' => true,
                    'mensaje' => 'El diagnóstico ha sido eliminado correctamente',
                    'orden' => $registroExistente,
                ], 200);
            }

            // Si no es "Vacio", actualizamos la información
            $registroExistente->update([
                'elementoComponente' => $elementoComponente,
                'fecha_modificacion' => now()
            ]);

            return response()->json([
                'estado' => true,
                'mensaje' => 'El diagnóstico ha sido actualizado correctamente',
                'orden' => $registroExistente,
            ], 200);
        }

        // Si no existe y el estado NO es "Vacio", creamos un nuevo registro
        if ($elementoComponente !== "Vacio") {
            $nuevoRegistro = new Odonto_Componentedetalle();
            $nuevoRegistro->odontograma_id = intval($odontograma_id);
            $nuevoRegistro->citas_id = intval($citas_id);
            $nuevoRegistro->estadoCarilla = $estadoCarilla;
            $nuevoRegistro->numeroDiente = $numeroDiente;
            $nuevoRegistro->elementoComponente = $elementoComponente;
            $nuevoRegistro->estado_activo = 'A';
            $nuevoRegistro->fecha = date('Y-m-d');
            $nuevoRegistro->fecha_creacion = now();
            $nuevoRegistro->fecha_modificacion = now();
            $nuevoRegistro->save();

            return response()->json([
                'estado' => true,
                'mensaje' => 'El diagnóstico se ha registrado correctamente',
                'orden' => $nuevoRegistro,
            ], 200);
        }
    }

    return response()->json([
        'estado' => false,
        'mensaje' => 'No hay datos para guardar',
        'orden' => null,
    ], 200);
}
 */

/*  public function guardando_odontodetallecomponente(Request $request)
 {
     $auxiliar = json_decode($request['data']);
     $data_componente_req = $auxiliar->odonto_componentedetalle;
 
     if ($data_componente_req) {
         $citas_id = $data_componente_req->citas_id;
         $odontograma_id = $data_componente_req->odontograma_id;
         $numeroDiente = $data_componente_req->numeroDiente;
         $estadoCarilla = $data_componente_req->estadoCarilla;
         $elementoComponente = $data_componente_req->elementoComponente;
 
         // Verificar si ya existe un registro con el mismo odontograma_id, numeroDiente y estadoCarilla
         $registroExistente = Odonto_Componentedetalle::where('odontograma_id', $odontograma_id)
             ->where('numeroDiente', $numeroDiente)
             ->where('estadoCarilla', $estadoCarilla)
             ->where('estado_activo', 'A')
             ->first();
 
         if ($registroExistente) {
             if ($elementoComponente === "Vacio") {
                 // Si el estado es "Vacio", inactivamos el registro
                 $registroExistente->update([
                     'estado_activo' => 'I', 
                     'fecha_modificacion' => now()
                 ]);
 
                 return response()->json([
                     'estado' => true,
                     'mensaje' => 'El diagnóstico ha sido eliminado correctamente',
                     'orden' => $registroExistente,
                 ], 200);
             }
 
             // Si no es "Vacio", actualizamos la información
             $registroExistente->update([
                 'elementoComponente' => $elementoComponente,
                 'fecha_modificacion' => now()
             ]);
 
             return response()->json([
                 'estado' => true,
                 'mensaje' => 'El diagnóstico ha sido actualizado correctamente',
                 'orden' => $registroExistente,
             ], 200);
         }
 
         // Si no existe y el estado NO es "Vacio", creamos un nuevo registro
         if ($elementoComponente !== "Vacio") {
             $nuevoRegistro = new Odonto_Componentedetalle();
             $nuevoRegistro->odontograma_id = intval($odontograma_id);
             $nuevoRegistro->citas_id = intval($citas_id);
             $nuevoRegistro->estadoCarilla = $estadoCarilla;
             $nuevoRegistro->numeroDiente = $numeroDiente;
             $nuevoRegistro->elementoComponente = $elementoComponente;
             $nuevoRegistro->estado_activo = 'A';
             $nuevoRegistro->fecha = date('Y-m-d');
             $nuevoRegistro->fecha_creacion = now();
             $nuevoRegistro->fecha_modificacion = now();
             $nuevoRegistro->save();
 
             return response()->json([
                 'estado' => true,
                 'mensaje' => 'El diagnóstico se ha registrado correctamente',
                 'orden' => $nuevoRegistro,
             ], 200);
         }
     }
 
     return response()->json([
         'estado' => false,
         'mensaje' => 'No hay datos para guardar',
         'orden' => null,
     ], 200);
 } */
 

 public function guardando_odontodetallecomponente(Request $request)
{
    $auxiliar = json_decode($request['data']);
    $data_componente_req = $auxiliar->odonto_componentedetalle;

    if ($data_componente_req) {
        $citas_id = $data_componente_req->citas_id;
        $odontograma_id = $data_componente_req->odontograma_id;
        $tratamiento_odontograma_id = $data_componente_req->tratamiento_odontograma_id;
        
        $numeroDiente = $data_componente_req->numeroDiente;
        $estadoCarilla = $data_componente_req->estadoCarilla;
        $elementoComponente = $data_componente_req->elementoComponente;

        // Verificar si ya existe un registro con el mismo odontograma_id, numeroDiente y estadoCarilla
        $registroExistente = Odonto_Componentedetalle::where('odontograma_id', $odontograma_id)
            ->where('numeroDiente', $numeroDiente)
            ->where('estadoCarilla', $estadoCarilla)
            ->where('estado_activo', 'A')
            ->first();

        if ($registroExistente) {
            if ($elementoComponente === "Vacio") {
                // Si el estado es "Vacio", inactivamos el registro y cambiamos elementoComponente
                $registroExistente->update([
                    'estado_activo' => 'I', 
                    'elementoComponente' => 'Vacio', // Asegurar que quede en "Vacio"
                    'fecha_modificacion' => now()
                ]);

                return response()->json([
                    'estado' => true,
                    'mensaje' => 'El diagnóstico ha sido eliminado correctamente',
                    'orden' => $registroExistente,
                ], 200);
            }

            // Si no es "Vacio", actualizamos la información
            $registroExistente->update([
                'elementoComponente' => $elementoComponente,
                'fecha_modificacion' => now()
            ]);

            return response()->json([
                'estado' => true,
                'mensaje' => 'El diagnóstico ha sido actualizado correctamente',
                'orden' => $registroExistente,
            ], 200);
        }

        // Si no existe y el estado NO es "Vacio", creamos un nuevo registro
        if ($elementoComponente !== "Vacio") {
            $nuevoRegistro = new Odonto_Componentedetalle();
            $nuevoRegistro->odontograma_id = intval($odontograma_id);
            $nuevoRegistro->citas_id = intval($citas_id);
            $nuevoRegistro->estadoCarilla = $estadoCarilla;
            $nuevoRegistro->tratamiento_odontograma_id = $tratamiento_odontograma_id;
            $nuevoRegistro->numeroDiente = $numeroDiente;
            $nuevoRegistro->elementoComponente = $elementoComponente;
            $nuevoRegistro->estado_activo = 'A';
            $nuevoRegistro->fecha = date('Y-m-d');
            $nuevoRegistro->fecha_creacion = now();
            $nuevoRegistro->fecha_modificacion = now();
            $nuevoRegistro->save();

            return response()->json([
                'estado' => true,
                'mensaje' => 'El diagnóstico se ha registrado correctamente',
                'orden' => $nuevoRegistro,
            ], 200);
        }
    }

    return response()->json([
        'estado' => false,
        'mensaje' => 'No se puede eliminar una carilla que no ha sido inicializada, escoja cualquiera de los 3 estados: Por Hacer, Encontrado o Realizado',
        'orden' => null,
    ], 200);
}



public function listar_odcomponentexcita($id){
    $idCitas = intval($id);
    $citas = Citas::find($idCitas);

    $response = [];

    if($citas == null){
        $response = [
            'estado'=>false,
            'mensaje'=>'No hay datos para mostrar',
            'citas'=> null,
        ];
    }else{
        $valor = 0 ;
    
       
     

        foreach($citas->odonto_componentedetalle as $oddetallecomponente){
           // $oddetallecomponente->odontograma;
    
            
        }

     
        
        $response = [
            'status' => true,
            'mensaje' => 'Existen datos',
            'valor' => $valor,
   
          //  'receta' => $citas->receta       
        ];
    }

    return response()->json($response);

}



public function obtenerDetalleComponente($paciente_id) {
    // Buscar el odontograma del paciente
    $odontograma = Odontograma::where('paciente_id', $paciente_id)->first();

    if (!$odontograma) {
        return response()->json(['status' => false, 'mensaje' => 'No se encontró un odontograma'], 404);
    }

    // Buscar los detalles del componente (carillas) asociados al odontograma
    $detallesComponente = Odonto_ComponenteDetalle::where('odontograma_id', $odontograma->id)
        ->where('estado_activo', 'A') // Solo detalles activos
        ->select('numeroDiente', 'estadoCarilla', 'elementoComponente') // Obtener los datos necesarios
        ->get();

    return response()->json([
        'status' => true,
        'odontograma' => $odontograma,
        'detalles_componente' => $detallesComponente
    ]);
}



}