<?php

namespace App\Http\Controllers;

use App\Models\Paciente_Antecedentes;
use Illuminate\Http\Request;

class Paciente_AntecedentesController extends Controller
{
    //

    public function guardar_antecedentes(Request $request)
    {
        $data = json_decode($request['data']);
        $data_antecedentes = (array) $data->paciente_antecedentes; 
        //return response()->json($data_antecedentes, 200); die();

        $response = [];

        if ($data_antecedentes) {

            foreach ($data_antecedentes as $ant) {
                
                $paciente_id = $ant->paciente_id;
                $antecedentes_id = $ant->antecedentes_id;
                $grupos_antecedentes_id = $ant->grupos_antecedentes_id;
                $observacion = $ant->observacion;
    
                $newantecedente = new Paciente_Antecedentes();
                $newantecedente->paciente_id = $paciente_id;
                $newantecedente->antecedentes_id = $antecedentes_id;
                $newantecedente->grupos_antecedentes_id = $grupos_antecedentes_id;
                $newantecedente->observacion = $observacion;
                $newantecedente->fecha = date('Y-m-d');
                $newantecedente->estado = 'A';
    
                if ($newantecedente->save()) {
                    $response = [
                        'status' => true,
                        'mensaje' => 'El Antecedente se ha registrado correctamente',
                        'antecedente' => $newantecedente,
                    ];
                } else {
                    $response = [
                        'status' => false,
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



    public function listar_antecedentesxid2($paciente_id){
        $idpaciente = intval($paciente_id);
        $antecedentePaciente = Paciente_Antecedentes::where('paciente_id',$idpaciente)->get();
   
        $response = [];

        if($antecedentePaciente == null){
            $response = [
                'estado'=>false,
                'mensaje'=>'No hay datos para mostrar',
                'antecedentes'=> null,
            ];
        }else{
            foreach($antecedentePaciente as $r){

                $r->paciente->persona;
            }
            foreach($antecedentePaciente as $ant){

                $ant->antecedentes->grupos_antecedentes;
            }

            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'data' => $antecedentePaciente,
            
            ];
        }

        return response()->json($response);

    }


    public function listar_antecedentesxid($paciente_id)
	{
        $idpaciente = intval($paciente_id);
        $antecedentePaciente = Paciente_Antecedentes::where('paciente_id',$idpaciente)->get();
   
		$data = [];
		$i = 1;

		foreach ($antecedentePaciente as $j) {
            $j->paciente->persona;
            $j->antecedentes->grupos_antecedentes;

            $fecha = $j->fecha;
            $observacion = $j->observacion;
            $nombre_antecedente = $j->antecedentes->nombre_antecedente;
            $nombre_grupo = $j->antecedentes->grupos_antecedentes->nombre;

			$data[] = [
				0 => $i,
                1 => $fecha,
                2 => $nombre_antecedente,
				3 => $nombre_grupo,
				4 => $observacion,
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




}
