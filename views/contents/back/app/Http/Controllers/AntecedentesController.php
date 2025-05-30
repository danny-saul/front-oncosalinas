<?php

namespace App\Http\Controllers;

use App\Models\Antecedentes;
use App\Models\Grupos_Antecedentes;
use App\Models\Paciente_Antecedentes;
use GuzzleHttp\Psr7\Request;

class AntecedentesController extends Controller
{
    //

    public function listarAntecedentesXGrupos($nombregrupo){
        $antecedentes = Antecedentes::whereHas('grupos_antecedentes', function ($query) use ($nombregrupo) {
            $query->where('nombre', $nombregrupo);
        })->where('estado', 'A')->pluck('nombre_antecedente', 'id');
        
        return $antecedentes;
    }
    
    
 
    
    public function listarGrupos(){
        $dtGrupos = Grupos_Antecedentes::where('estado', 'A')->get();
        $response = [];
        
        if ($dtGrupos->isNotEmpty()) {
            foreach ($dtGrupos as $grupoAntece) {
                $antecedentes = $this->listarAntecedentesXGrupos($grupoAntece->nombre);
                
                $response[] = [
                    'grupo_antecedente' => $grupoAntece->nombre,
                    'antecedentes' => $antecedentes,
                ];
            }
    
            return response()->json([
                'status' => true,
                'mensaje' => 'Existen datos',
                'categorias_con_productos' => $response,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'mensaje' => 'No existen datos',
                'categorias_con_productos' => null,
            ], 200);
        }
    }
    


    public function listarGrupos_antecedentes()
    {
        $response = [];

        $gruposData = Grupos_Antecedentes::where('estado', 'A')->get();

        if( count($gruposData) > 0){
            foreach($gruposData as $chelas){
                $chelas->antecedentes;

            }
            $response = [
                'status' => true,
                'mensaje' => 'Existen Datos',
                'categorias' => $gruposData
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No Existen Datos',
                'categorias' => $gruposData
            ];

        }

        return response()->json($response, 200);

    }
    



    
    public function listarGrupos_antecedentesxid($grupo_id)
    {
        $response = [];

        $gruposData = Grupos_Antecedentes::find($grupo_id);

        if( $gruposData) {
           /*  foreach($gruposData as $chelas){
                $chelas->antecedentes;

            } */
            $response = [
                'status' => true,
                'mensaje' => 'Existen Datos',
                'categorias' => $gruposData
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No Existen Datos',
                'categorias' => $gruposData
            ];

        }

        return response()->json($response, 200);

    }




    /* public function guardar_antecedentes2(Request $request){
        $data = json_decode($request['data']);
        $data_antecedentes = (array) $data->paciente_antecedentes; 
        $response = [];

        if ($data_antecedentes) {
        
                 $paciente_id = $data_antecedentes->paciente_id;
                 $antecedente_id = $data_antecedentes->antecedente_id;
                 $observacion = $data_antecedentes->observacion;
        
                   $newantecedente = new Paciente_Antecedentes();
                   $newantecedente->paciente_id = $paciente_id;
                   $newantecedente->antecedente_id = $antecedente_id;
                   $newantecedente->observacion = $observacion;
                   $newantecedente->fecha = date('Y-m-d');
                   $newantecedente->estado = 'A';
   
                   if ($newantecedente->save()) {
                       $response = [
                           'estado' => true,
                           'mensaje' => 'El Antecedente se ha registrado correctamente',
                           'antecedente' => $newantecedente,
                       ];
                   } else {
                       $response = [
                           'estado' => false,
                           'mensaje' => 'No se ha Antecedente el producto',
                           'antecedente' => null,
                       ];
                   }
            } else {
                $response = [
                    'estado' => false,
                    'mensaje' => 'No hay datos para procesar',
                    'antecedente' => null,
                ];
            }
        
   
           return response()->json($response, 200);

    } */


    public function guardar_antecedentes(Request $request)
    {
        $data = json_decode($request['data']);
        $data_antecedentes = (array) $data->paciente_antecedentes; 
        return response()->json($data_antecedentes, 200); die();

        $response = [];

        if ($data_antecedentes) {

            foreach ($data_antecedentes as $ant) {
                
                $paciente_id = $ant['paciente_id'];
                $antecedente_id = $ant['antecedente_id'];
                $observacion = $ant['observacion'];
    
                $newantecedente = new Paciente_Antecedentes();
                $newantecedente->paciente_id = $paciente_id;
                $newantecedente->antecedente_id = $antecedente_id;
                $newantecedente->observacion = $observacion;
                $newantecedente->fecha = date('Y-m-d');
                $newantecedente->estado = 'A';
    
                if ($newantecedente->save()) {
                    $response = [
                        'estado' => true,
                        'mensaje' => 'El Antecedente se ha registrado correctamente',
                        'antecedente' => $newantecedente,
                    ];
                } else {
                    $response = [
                        'estado' => false,
                        'mensaje' => 'No se ha podido guardar el antecedente',
                        'antecedente' => null,
                    ];
                }
            }

        } else {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para procesar',
                'antecedente' => null,
            ];
        }

        return response()->json($response, 200);
    }

    
}
