<?php

namespace App\Http\Controllers;

use App\Models\Certificados_Medicos;
use Illuminate\Http\Request;

class Certificados_MedicosController extends Controller
{
    //

    public function guardarCertificado($citas_id, $orden = [] ){
        $response = [];

        if($orden > 0 ){
            foreach($orden as $serv){
                $nuevo = new Certificados_Medicos();
                $nuevo->citas_id = $citas_id;
                $nuevo->aislamiento_id = intval($serv->aislamiento_id);
                $nuevo->tipo_contingencia_id = intval($serv->tipo_contingencia_id);
                $nuevo->actividad_laboral = $serv->actividad_laboral;
                $nuevo->entidad_laboral = $serv->entidad_laboral;
                $nuevo->dia_descanso = $serv->dia_descanso;
                $nuevo->direccion = $serv->direccion;
                $nuevo->tipo_contingencia_id = $serv->tipo_contingencia_id;
                $nuevo->observacion = $serv->observacion;
                $nuevo->fecha = date('Y-m-d');

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
    } 
}
