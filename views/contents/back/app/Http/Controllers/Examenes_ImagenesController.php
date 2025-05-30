<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class Examenes_ImagenesController extends Controller
{
    //

    public function datatablelistarxmedico2($medicoId)
	{

		$medico_id = intval($medicoId);
		$ordenes_imagenes = Orden::where('doctor_id', $medico_id)->where('estado_orden_id', '1')->where('estado','A')->get();
		$data = [];
		$i = 1;

		foreach ($ordenes_imagenes as $orden_img) {
			$numero_orden = $orden_img->numero_orden;
			$tipo_estudio = $orden_img->tipo_estudio->descripcion;
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
                            <button ' . $disabled . ' ' . $disabledCancelar . ' class="btn btn-sm btn-success" onclick="subir_pdf(' . $orden_img->id . ',' . $other . ')" title="Ver Orden de Imagenes">
                                <i class="fa fa-eye"></i> Ingresar Resultados
                            </button>

             
                        </div>';

			$data[] = [
				0 => $i,
                1 => $numero_orden,
                2 => $tipo_estudio,
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

	   public function datatablelistarOrdenGeneral()
	{

		
		$ordenes_imagenes = Orden::where('estado_orden_id', '1')->where('estado','A')->get();
		$data = [];
		$i = 1;

		foreach ($ordenes_imagenes as $orden_img) {
			$numero_orden = $orden_img->numero_orden;
			$tipo_estudio = $orden_img->tipo_estudio->descripcion;
			$paciente = $orden_img->citas->paciente->persona;
		//	$doctor = $orden_img->doctor->persona;
			$doctor = $orden_img->citas->doctor->persona;
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
                            <button ' . $disabled . ' ' . $disabledCancelar . ' class="btn btn-sm btn-success" onclick="subir_pdf(' . $orden_img->id . ',' . $other . ')" title="Ver Orden de Imagenes">
                                <i class="fa fa-eye"></i> Ingresar Resultados
                            </button>

             
                        </div>';

			$data[] = [
				0 => $i,
                1 => $numero_orden,
                2 => $tipo_estudio,
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


	public function datatablelistarresultadoxmedico($medicoId)
	{

		$medico_id = intval($medicoId);
		$ordenes_imagenes = Orden::where('doctor_id', $medico_id)->where('estado_orden_id', '1')->get();
		$data = [];
		$i = 1;
        $base = $_SERVER['APP_URL'].':'.$_SERVER['SERVER_PORT'].'/';
		
		foreach ($ordenes_imagenes as $orden_img) {
			$url = $base. 'api/estudios/estudios/' . $orden_img->documento;
			$numero_orden = $orden_img->numero_orden;
			$tipo_estudio = $orden_img->tipo_estudio->descripcion;
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
		$ordenes_imagenes = Orden::where('doctor_id', $medico_id)->where('estado_orden_id', '2')->get();
		$data = [];
		$i = 1;
        $base = $_SERVER['APP_URL'].':'.$_SERVER['SERVER_PORT'].'/';
		
		foreach ($ordenes_imagenes as $orden_img) {
			$url = $base. 'api/estudios/estudios/' . $orden_img->documento;
			$urlPdf =  $base. 'api/';
			$numero_orden = $orden_img->numero_orden;
			$tipo_estudio = $orden_img->tipo_estudio->descripcion;
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
							<a class="btn btn-sm btn-outline-success" href="' . $url . '" target="_blank" title="Ver Imagen">
								<i class="fa fa-eye fa-lg"></i>
							</a>
							<a class="btn btn-sm btn-outline-primary" href="' . $urlPdf . 'listar_ordenesPdf/' . $orden_img->id . '" target="_blank" title="Ver Informe">
								<i class="fas fa-clipboard-list"></i> Ver Informe
							</a>

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


		public function listarresultadosconcluidosGeneral()
	{

		//$medico_id = intval($medicoId);
		$ordenes_imagenes = Orden::where('estado_orden_id', '2')->get();
		$data = [];
		$i = 1;
        $base = $_SERVER['APP_URL'].':'.$_SERVER['SERVER_PORT'].'/';
		
		foreach ($ordenes_imagenes as $orden_img) {
			$url = $base. 'api/estudios/estudios/' . $orden_img->documento;
			$urlPdf =  $base. 'api/';
			$numero_orden = $orden_img->numero_orden;
			$tipo_estudio = $orden_img->tipo_estudio->descripcion;
			$paciente = $orden_img->citas->paciente->persona;
			$doctor = $orden_img->citas->doctor->persona;

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
							<a class="btn btn-sm btn-outline-success" href="' . $url . '" target="_blank" title="Ver Imagen">
								<i class="fa fa-eye fa-lg"></i>
							</a>
							<a class="btn btn-sm btn-outline-primary" href="' . $urlPdf . 'listar_ordenesPdf/' . $orden_img->id . '" target="_blank" title="Ver Informe">
								<i class="fas fa-clipboard-list"></i> Ver Informe
							</a>

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
	


	public function getFile($disk2, $file2){
        if ($disk2 === 'estudios') {
            $diskName = ($disk2 === 'usuarios') ? 'avatars' : 'estudios';
            
            $existe = Storage::disk($diskName)->exists($file2);
            
            if ($existe) {
                $archivo = Storage::disk($diskName)->get($file2);
                // Devolver el archivo PDF como respuesta
                return new Response($archivo, 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="'.$file2.'"'
                ]);
            } else {
                $data = [
                    'estado' => false,
                    'mensaje' => 'Archivo no existe',
                    'error' => 404
                ];
                return response()->json($data, 404);
            }
        } else {
            $data = [
                'estado' => false,
                'mensaje' => 'Disco no válido',
                'error' => 400
            ];
            return response()->json($data, 400);
        }
    }


	
    public function contar_ordenesImagenespendiente($medicoId){

  

        $medico_id = intval($medicoId);
        $cita = Orden::where('doctor_id', $medico_id)->where('estado_orden_id', '1')->get();
      
     
        $response = [];
    
        if ($cita) {
            $response = [
                'status' => true,
                'mensaje' => 'existe datos',
                'modelo' => 'Ordenes por Informar Pendientes',
                'cantidad' => $cita->count(),
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existe datos',
                'modelo' => 'Ordenes por Informar Pendientes',
                'cantidad' => 0,
            ];
        }
    
        return response()->json($response, 200);
    }
    
}
