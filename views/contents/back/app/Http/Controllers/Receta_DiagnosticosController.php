<?php

namespace App\Http\Controllers;

use App\Models\Receta_Diagnostico;
use Illuminate\Http\Request;

class Receta_DiagnosticosController extends Controller
{
 
    
public function guardar_recetas_diagnosticos($receta_id, $citas_id, $diagnosticos) {
    if (empty($diagnosticos)) {
        return response()->json([
            'status' => false,
            'mensaje' => 'No hay diagnósticos en la orden',
        ], 400);
    }

    foreach ($diagnosticos as $serv) {
        $nuevo = new Receta_Diagnostico();
        $nuevo->citas_id = $citas_id;
        $nuevo->receta_id = $receta_id;
        $nuevo->diagnosticocie10_id = intval($serv->diagnosticocie10_id);
        $nuevo->tipo_diagnostico_id = intval($serv->tipo_diagnostico_id);
        $nuevo->estado = 'A';
        $nuevo->save();
    }

    return response()->json([
        'status' => true,
        'mensaje' => 'Diagnósticos guardados con receta',
    ], 200);
}


public function guardarDiagnosticosSinReceta(Request $request) {
    $data = json_decode($request->getContent());

    $receta_id = $data->receta_id ?? null; // Será null aquí
    $citas_id = $data->citas_id ?? null;
    $detalle_diagnostico = $data->diagnosticos ?? [];

    if (empty($detalle_diagnostico)) {
        return response()->json([
            'status' => false,
            'mensaje' => 'No hay diagnósticos para guardar',
        ], 400);
    }

    foreach ($detalle_diagnostico as $serv) {
        $nuevo = new Receta_Diagnostico();
        $nuevo->citas_id = $citas_id;
        $nuevo->receta_id = $receta_id; // null cuando no hay receta
        $nuevo->diagnosticocie10_id = intval($serv->diagnosticocie10_id);
        $nuevo->tipo_diagnostico_id = intval($serv->tipo_diagnostico_id);
        $nuevo->estado = 'A';
        $nuevo->save();
    }

    return response()->json([
        'status' => true,
        'mensaje' => 'Diagnósticos guardados correctamente',
    ], 200);
}

    public function guardar_recetas_diagnosticos2($receta_id, $citas_id, $detalle_diagnostico = []) {
        $response = [];
    
        // Verificar si $receta_id es null o vacío
        if ($receta_id === null || $receta_id === '') {
            $response = [
                'status' => false,
                'mensaje' => 'Deebe registrar una receta',
                'receta_diagnostico' => null,
            ];
        } elseif (count($detalle_diagnostico) > 0) {
            foreach ($detalle_diagnostico as $serv) {
                $nuevo = new Receta_Diagnostico();
                $nuevo->receta_id = $receta_id;
                $nuevo->citas_id = $citas_id;
                $nuevo->diagnosticocie10_id = intval($serv->diagnosticocie10_id);
                $nuevo->tipo_diagnostico_id = intval($serv->tipo_diagnostico_id);
                $nuevo->estado = 'A'; 
                $nuevo->save();
            }
            $response = [
                'status' => true,
                'mensaje' => 'Guardado Diagnóstico',
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay servicios en la orden',
                'receta_diagnostico' => null,
            ];
        }
    
        return response()->json($response, 200);
    }


}

