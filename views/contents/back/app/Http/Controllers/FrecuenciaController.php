<?php

namespace App\Http\Controllers;

use App\Models\Frecuencia;
use Illuminate\Http\Request;

class FrecuenciaController extends Controller
{
    //

        //
        public function listar(){

            $dtfrecuencia = Frecuencia::where('estado', 'A')->get();
            $response = [];
    
            if ($dtfrecuencia) {
                $response = [
                    'status' => true,
                    'mensaje' => 'Si hay datos',
                    'frecuencia' => $dtfrecuencia,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No hay datos',
                    'frecuencia' => null,
                ];
            }
    
            return response()->json($response, 200);
        }
}
