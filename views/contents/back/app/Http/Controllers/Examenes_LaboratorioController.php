<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use Illuminate\Http\Request;

class Examenes_LaboratorioController extends Controller
{
    //


  /*   public function dttablelistarlaboratorio($medicoId)
	{

		$medico_id = intval($medicoId);
		$ordenes_examenes = Laboratorio::where('doctor_id', $medico_id)->where('estado_orden_id', '1')->get();
		$data = [];
		$i = 1;

		foreach ($ordenes_examenes as $orden_lab) {
			$numero_orden = $orden_lab->numero_orden_lab;
		//	$tipo_laboratorio = $orden_lab->tipo_examen->descripcion_lab;
			$paciente = $orden_lab->citas->paciente->persona;
			$doctor = $orden_lab->doctor->persona;
			$fecha = $orden_lab->citas->fecha;
			$dataEstadoCita = $orden_lab->estado_orden;
 
			$estado = $orden_lab->estado_orden_id;
            

			$other = $orden_lab->estado_orden_id == 1 ? 2 : 1;
			$disabled = $orden_lab->estado_orden_id == 2 ? 'disabled' : ' ';
			$disabledCancelar = $orden_lab->estado_orden_id == 3 ? 'disabled' : ' ';

			if ($estado == 1) {
				$estado = '<span class="badge bg-warning" style="font-size: 1rem;">' . $dataEstadoCita->detalle_orden . '</span>';
			} else if ($estado == 2) {
				$estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $dataEstadoCita->detalle_orden . '</span>';
			} else {
				$estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $dataEstadoCita->detalle_orden . '</span>';
			}

			$botones = '<div class="">
                            <button ' . $disabled . ' ' . $disabledCancelar . ' class="btn btn-sm btn-success" onclick="subir_pdf(' . $orden_lab->id . ',' . $other . ')" title="Ver Orden de Laboratorio">
                                <i class="fa fa-eye"></i>  Ingresar Resultados
                            </button>

                        


                         
                        </div>';

			$data[] = [
				0 => $i,
                1 => $numero_orden,
                2 => $fecha,
				3 => $paciente->nombre . ' ' . $paciente->apellido,
				4 => $doctor->nombre . ' ' . $doctor->apellido,
		 
				5 => $estado,
				6 => $botones,
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


	public function dttablelistarlaboratorio($medicoId)
{
    $medico_id = intval($medicoId);

    // Agrupamos por cita y obtenemos la última orden (mayor id) para cada cita del médico
    $subquery = Laboratorio::selectRaw('MAX(id) as id')
        ->where('doctor_id', $medico_id)
        ->where('estado_orden_id', 1)
        ->groupBy('citas_id');

    // Traemos las órdenes completas a partir de los IDs máximos por cita
    $ordenes_examenes = Laboratorio::whereIn('id', $subquery)->get();

    $data = [];
    $i = 1;

    foreach ($ordenes_examenes as $orden_lab) {
        $numero_orden = $orden_lab->numero_orden_lab;
        $paciente = $orden_lab->citas->paciente->persona;
        $doctor = $orden_lab->doctor->persona;
        $fecha = $orden_lab->citas->fecha;
        $dataEstadoCita = $orden_lab->estado_orden;

        $estado = $orden_lab->estado_orden_id;
        $other = $estado == 1 ? 2 : 1;
        $disabled = $estado == 2 ? 'disabled' : ' ';
        $disabledCancelar = $estado == 3 ? 'disabled' : ' ';

        if ($estado == 1) {
            $estado = '<span class="badge bg-warning" style="font-size: 1rem;">' . $dataEstadoCita->detalle_orden . '</span>';
        } elseif ($estado == 2) {
            $estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $dataEstadoCita->detalle_orden . '</span>';
        } else {
            $estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $dataEstadoCita->detalle_orden . '</span>';
        }

        $botones = '<div class="">
                        <button ' . $disabled . ' ' . $disabledCancelar . ' class="btn btn-sm btn-success" onclick="subir_pdf(' . $orden_lab->id . ',' . $other . ')" title="Ver Orden de Laboratorio">
                            <i class="fa fa-eye"></i>  Ingresar Resultados
                        </button>
                    </div>';

        $data[] = [
            0 => $i,
            1 => $numero_orden,
            2 => $fecha,
            3 => $paciente->nombre . ' ' . $paciente->apellido,
            4 => $doctor->nombre . ' ' . $doctor->apellido,
            5 => $estado,
            6 => $botones,
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


    
    public function listar_Orden($id)
    {

        $id = intval($id);
        $lab = Laboratorio::find($id);
        $response = [];

        if ($lab) {
            $lab->doctor->persona;
        
            $lab->citas->paciente->persona;
            $lab->tipo_examen;
            $lab->lateralidad;
            $lab->estado_orden;

			foreach ($lab->laboratorio_detalle as $det) {
                $det->tipo_examen;
            }


            $response = [
                'status' => true,
                'lab' => $lab,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el lab',
                'lab' => null,
            ];
        }
        return response()->json($response, 200);
    }


    public function editar(Request $request)
    {
        $aux = json_decode($request['data']);
        $orden_request = $aux->orden;
        $id = intval($orden_request->id);
         
    
       /*  $justificacion_lab = ucfirst($orden_request->justificacion_lab);
        $resumen_lab = ucfirst($orden_request->resumen_lab);
        $informe_lab = ucfirst($orden_request->informe_lab);
        $conclusion_lab = ucfirst($orden_request->conclusion_lab); */
        $documento_lab = $orden_request->documento_lab;
        $documentoSinEspacios = str_replace(' ', '', $documento_lab);
    
        $response = [];
        $produc = Laboratorio::find($id);
    
        if ($orden_request) {
            if ($produc) {
    
              //  $produc->justificacion_lab = $justificacion_lab;
                //$produc->resumen_lab = $resumen_lab;
                $produc->documento_lab = $documentoSinEspacios;
                //$produc->informe_lab = $informe_lab;
                //$produc->conclusion_lab = $conclusion_lab;
                date_default_timezone_set('America/Guayaquil');
                $produc->fecha_lab = date('Y-m-d H:i:s');
    
            
                // Cambiar el estado_orden_id de la tabla ordenes a 2
                $produc->estado_orden_id = 2;
    
                $produc->save();
    
                $response = [
                    'status' => true,
                    'mensaje' => 'Informe Finalizado',
                    'materia' => $produc,
                   
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el Informe',
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos'
            ];
        }
        return response()->json($response, 200);
    }
    
    public function datatablelistarresultadoxmedico($medicoId)
	{

		$medico_id = intval($medicoId);
		$ordenes_laboratorio = Laboratorio::where('doctor_id', $medico_id)->where('estado_orden_id', '1')->get();
		$data = [];
		$i = 1;
        $base = $_SERVER['APP_URL'].':'.$_SERVER['SERVER_PORT'].'/';
		
		foreach ($ordenes_laboratorio as $orden_img) {
			$url = $base. 'api/estudios/estudios/' . $orden_img->documento_lab;
			$numero_orden = $orden_img->numero_orden_lab;
			$tipo_estudio = $orden_img->tipo_examen->descripcion_lab;
			$paciente = $orden_img->citas->paciente->persona;
			$doctor = $orden_img->doctor->persona;

			$dataEstadoCita = $orden_img->estado_orden;
 
			$estado = $orden_img->estado_orden_id;
            

			$other = $orden_img->estado_orden_id == 1 ? 2 : 1;
			$disabled = $orden_img->estado_orden_id == 2 ? 'disabled' : ' ';
			$disabledCancelar = $orden_img->estado_orden_id == 3 ? 'disabled' : ' ';

			if ($estado == 1) {
				$estado = '<span class="badge bg-warning" style="font-size: 1rem;">' . $dataEstadoCita->detalle_orden . '</span>';
			} else if ($estado == 2) {
				$estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $dataEstadoCita->detalle_orden . '</span>';
			} else {
				$estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $dataEstadoCita->detalle_orden . '</span>';
			}

			$botones = '<div class="">
								<a  class="btn btn-sm btn-outline-success" href="' . $url . '" target="_blank">
								<i class="fa fa-eye fa-lg"></i> </a>
                            <button ' . $disabled . ' ' . $disabledCancelar . ' class="btn btn-sm btn-outline-primary" onclick="ver_informe(' . $orden_img->id . ')">
                                <i class="fas fa-clipboard-list"></i>
                            </button>
                        </div>';

			$data[] = [
				0 => $i,
                1 => $numero_orden,
                2 => $orden_img->citas->id,
				3 => $paciente->nombre . ' ' . $paciente->apellido,
				4 => $paciente->cedula,
				5 => $tipo_estudio,
				6 => $doctor->nombre . ' ' . $doctor->apellido,
				7 => '',
				8 => $orden_img->fecha,
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



    public function listarresultadosconcluidos($medicoId)
	{

		$medico_id = intval($medicoId);
		$ordenes_imagenes = Laboratorio::where('doctor_id', $medico_id)->where('estado_orden_id', '2')->get();
		$data = [];
		$i = 1;
        $base = $_SERVER['APP_URL'].':'.$_SERVER['SERVER_PORT'].'/';
		
		foreach ($ordenes_imagenes as $orden_img) {
			$url = $base. 'api/estudios/estudios/' . $orden_img->documento_lab;
			$urlPdf =  $base. 'api/';
            $numero_orden = $orden_img->numero_orden_lab;
			//$tipo_estudio = $orden_img->tipo_examen->descripcion_lab;

			$paciente = $orden_img->citas->paciente->persona;
			$doctor = $orden_img->doctor->persona;

			$dataEstadoCita = $orden_img->estado_orden;
 
			$estado = $orden_img->estado_orden_id;
            

			$other = $orden_img->estado_orden_id == 1 ? 2 : 1;
			$disabled = $orden_img->estado_orden_id == 2 ? 'disabled' : ' ';
			$disabledCancelar = $orden_img->estado_orden_id == 3 ? 'disabled' : ' ';

			if ($estado == 1) {
				$estado = '<span class="badge bg-warning" style="font-size: 1rem;">' . $dataEstadoCita->detalle_orden . '</span>';
			} else if ($estado == 2) {
				$estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $dataEstadoCita->detalle_orden . '</span>';
			} else {
				$estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $dataEstadoCita->detalle_orden . '</span>';
			}

			$botones = '<div class="">
							<a class="btn btn-sm btn-outline-success" href="' . $url . '" target="_blank"  title="Ver Laboratorio">
								<i class="fa fa-eye fa-lg"></i>
							</a>
							<a class="btn btn-sm btn-outline-primary" href="' . $urlPdf . 'listar_resultadoslabPdf/' . $orden_img->id . '" target="_blank" title="Imprimir Resultados">
								<i class="fas fa-clipboard-list"></i>  Imprimir Resultados
							</a>

						</div>';
					 
			$data[] = [
				0 => $i,
                1 => $numero_orden,
                2 => $orden_img->citas->id,
				3 => $paciente->nombre . ' ' . $paciente->apellido,
				4 => $paciente->cedula,
				//5 => $tipo_estudio,
				5 => $doctor->nombre . ' ' . $doctor->apellido,
				6 => '',
				7 => $orden_img->citas->fecha,
				8 => $estado,
				9 => $botones,
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
