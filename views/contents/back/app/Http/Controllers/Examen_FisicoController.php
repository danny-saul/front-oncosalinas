<?php

namespace App\Http\Controllers;

use App\Models\Examen_Fisica;
use Illuminate\Http\Request;

class Examen_FisicoController extends Controller
{
    //

    
    public function guardarExamenfisico($citas_id, $exaFisico = [] ){
        $response = [];

        if($exaFisico > 0 ){
            foreach($exaFisico as $serv){
                $nuevo = new Examen_Fisica();
                $nuevo->citas_id = $citas_id;
                $nuevo->temperatura = $serv->temperatura;
                $nuevo->peso = $serv->peso;
                $nuevo->talla = $serv->talla;
                $nuevo->presion_arterial = $serv->presion_arterial;
                $nuevo->imc = $serv->imc;
                $nuevo->pulso = $serv->pulso;
                $nuevo->frecuencia_respiratoria = $serv->frecuencia_respiratoria;
                $nuevo->observacion_examen = $serv->observacion_examen;
                $nuevo->recomendacion = $serv->recomendacion;
                $nuevo->saturacion_oxigeno = $serv->saturacion_oxigeno;
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
