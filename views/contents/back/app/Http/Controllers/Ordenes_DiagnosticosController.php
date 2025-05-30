<?php

namespace App\Http\Controllers;

use App\Models\Ordenes_Diagnosticos;
use Illuminate\Http\Request;

class Ordenes_DiagnosticosController extends Controller
{
    //

    public function guardar_ordenes_diagnosticos($ordenes_id, $detalle_diagnostico = [] ){
        $response = [];

        if($detalle_diagnostico > 0 ){
            foreach($detalle_diagnostico as $serv){
                $nuevo = new Ordenes_Diagnosticos();
                $nuevo->ordenes_id = $ordenes_id;
                $nuevo->diagnosticocie10_id = intval($serv->diagnosticocie10_id);
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
