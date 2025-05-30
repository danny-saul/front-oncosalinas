<?php

namespace App\Http\Controllers;

use App\Models\Via;
use Illuminate\Http\Request;

class ViaController extends Controller
{
    //

        public function listar(){

            $dt_via = Via::where('estado', 'A')->get();
            $response = [];
    
            if ($dt_via) {
                $response = [
                    'status' => true,
                    'mensaje' => 'Si hay datos',
                    'via' => $dt_via,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No hay datos',
                    'via' => null,
                ];
            }
    
            return response()->json($response, 200);
        }
}
