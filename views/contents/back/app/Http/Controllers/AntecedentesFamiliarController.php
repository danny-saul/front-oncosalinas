<?php

namespace App\Http\Controllers;

use App\Models\Familiares_Antecedentes;
use App\Models\Grupos_Antecedentes_Familiares;
use Illuminate\Http\Request;

class AntecedentesFamiliarController extends Controller
{
    //
    public function listarGrupos_antecedentesfamiliares()
    {
        $response = [];

        $gruposData = Grupos_Antecedentes_Familiares::where('estado', 'A')->get();

        if( count($gruposData) > 0){
            foreach($gruposData as $chelas){
                $chelas->antecedentesfamiliares;

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


    public function guardar_antecedentes_familiares(Request $request)
    {
        $data = json_decode($request['data']);
        $data_antecedentes = (array) $data->familiares_antecedentes; 
        //return response()->json($data_antecedentes, 200); die();

        $response = [];

        if ($data_antecedentes) {

            foreach ($data_antecedentes as $ant) {
                
                $paciente_id = $ant->paciente_id;
                $antecedentesfamiliares_id = $ant->antecedentesfamiliares_id;
                $grupos_antecedentes_familiares_id = $ant->grupos_antecedentes_familiares_id;
                $observacion = $ant->observacion;
    
                $newantecedente = new Familiares_Antecedentes();
                $newantecedente->paciente_id = $paciente_id;
                $newantecedente->antecedentesfamiliares_id = $antecedentesfamiliares_id;
                $newantecedente->grupos_antecedentes_familiares_id = $grupos_antecedentes_familiares_id;
                $newantecedente->observacion = $observacion;
                $newantecedente->fecha = date('Y-m-d');
                $newantecedente->estado = 'A';
    
                if ($newantecedente->save()) {
                    $response = [
                        'status' => true,
                        'mensaje' => 'El Antecedente se ha registrado correctamente',
                        'fam_antecedente' => $newantecedente,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se ha podido guardar el antecedente',
                        'fam_antecedente' => null,
                    ];
                }
            }

        } else {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para procesar',
                'fam_antecedente' => null,
            ];
        }

        return response()->json($response, 200);
    }

    public function listar_antecedentesfamiliaresxid($paciente_id)
	{
        $idpaciente = intval($paciente_id);
        $antecedentes_familiares = Familiares_Antecedentes::where('paciente_id',$idpaciente)->get();
   
		$data = [];
		$i = 1;

		foreach ($antecedentes_familiares as $j) {
            $j->paciente->persona;
            $j->antecedentesfamiliares->grupos_antecedentes_familiares;

            $fecha = $j->fecha;
            $observacion = $j->observacion;
            $nombre_antecedente = $j->antecedentesfamiliares->nombre_antecedente;
            $nombre_grupo = $j->antecedentesfamiliares->grupos_antecedentes_familiares->nombre;

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
