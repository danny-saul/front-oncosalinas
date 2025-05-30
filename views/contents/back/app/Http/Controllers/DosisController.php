<?php

namespace App\Http\Controllers;

use App\Models\Dosis;
use Illuminate\Http\Request;

class DosisController extends Controller
{
    //
        //
        public function listar(){

            $dtdosis = Dosis::where('estado', 'A')->get();
            $response = [];
    
            if ($dtdosis) {
                $response = [
                    'status' => true,
                    'mensaje' => 'Si hay datos',
                    'dosis' => $dtdosis,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No hay datos',
                    'dosis' => null,
                ];
            }
    
            return response()->json($response, 200);
        }
}
