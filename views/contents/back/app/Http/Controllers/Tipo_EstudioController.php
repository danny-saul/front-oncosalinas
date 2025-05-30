<?php

namespace App\Http\Controllers;

use App\Models\Tipo_Estudio;
use Illuminate\Http\Request;

class Tipo_EstudioController extends Controller
{
    //
     public function listar_tipoestudioNormal()
    {

        $tipo_Estudio = Tipo_Estudio::where('estado', 'A')->get();
        $response = [];

        if ($tipo_Estudio) {

            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'tipo_Estudio' => $tipo_Estudio,
           
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'tipo_Estudio' => null,
            ];
        }

        return response()->json($response, 200);
    } 


    public function listar_tipoestudio(Request $request)
{
    $search = $request->get('q');

    $tipo_Estudio = Tipo_Estudio::where('estado', 'A')
        ->when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('descripcion', 'like', '%' . $search . '%')
                  ->orWhere('codigo', 'like', '%' . $search . '%');
            });
        })
        ->limit(20)
        ->get();

    return response()->json($tipo_Estudio, 200);
}


    public function listarId($id)
    {

        $id = intval($id);
        $tipo_estudio = Tipo_Estudio::find($id);
        $response = [];

        if ($tipo_estudio) {
    
            $response = [
                'status' => true,
                'tipo_estudio' => $tipo_estudio,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el tipo_estudio',
                'tipo_estudio' => null,
            ];
        }
        return response()->json($response, 200);
    }
}
