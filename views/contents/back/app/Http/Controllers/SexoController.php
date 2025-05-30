<?php

namespace App\Http\Controllers;

use App\Models\Sexo;
use Illuminate\Http\Request;

class SexoController extends Controller
{
    //
    public function listar(){

        $datasexo = Sexo::where('estado', 'A')->get();
        $response = [];

        if ($datasexo) {
            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'sexo' => $datasexo,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'sexo' => null,
            ];
        }

        return response()->json($response, 200);
    }
}
