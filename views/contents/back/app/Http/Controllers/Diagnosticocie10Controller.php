<?php

namespace App\Http\Controllers;

use App\Models\Diagnosticocie10;
use App\Models\Tipo_Diagnostico;
use Illuminate\Http\Request;

class Diagnosticocie10Controller extends Controller
{
    //
    public function listardiagnosticocie10(){

        $datadiagnostico = Diagnosticocie10::get(['id','clave','descripcion']);
        $response = [];

        if ($datadiagnostico->isNotEmpty()) {
            $formattedData = $datadiagnostico->map(function ($diagnostico) {
                return [
                    'id' => $diagnostico->id,
                    'text' => $diagnostico->clave . ' - ' . $diagnostico->descripcion,
                ];
            });
    
            $response = [
                'results' => $formattedData->toArray(), // Formatea los datos en un arreglo compatible con Select2
            ];
        } else {
            $response = [
                'results' => [], // Si no hay datos, se devuelve un arreglo vacío
            ];
        }
    
        return response()->json($response);
    }

        //
        public function listar(){

            $dtdiagnostico = Diagnosticocie10::get();
            $response = [];
    
            if ($dtdiagnostico) {
                $response = [
                    'status' => true,
                    'mensaje' => 'Si hay datos',
                    'diagnostico' => $dtdiagnostico,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No hay datos',
                    'diagnostico' => null,
                ];
            }
    
            return response()->json($response, 200);
        }

        public function buscar(Request $request)
        {
            $query = $request->get('q');

            $resultados = Diagnosticocie10::where('clave', 'like', "%$query%")
                ->orWhere('descripcion', 'like', "%$query%")
                ->limit(20)
                ->get(['id', 'clave', 'descripcion']);

            if ($resultados->count() > 0) {
                return response()->json([
                    'status' => true,
                    'diagnostico' => $resultados
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'diagnostico' => []
                ]);
            }
        }



        public function listar_diagnosticoxID($id){

            $id = intval($id);
            $dtdiagnosticod = Diagnosticocie10::find($id);
            
            $response = [];
    
            if($dtdiagnosticod == null){
                $response = [
                    'status' => false,
                    'mensaje' => 'Los diagnosticos no existe',
                    'diagnosticos' => null,
                ];
    
            }else{
                $response = [
                    'status' => true,
                    'mensaje' => 'Los diagnosticos existe',
                    'diagnosticos' => $dtdiagnosticod,
                ];
    
            } 
            return response()->json($response, 200);
    
        }


        public function listartipo(){

            $dt_tipodiagnostico = Tipo_Diagnostico::where('estado', 'A')->get();
            $response = [];
    
            if ($dt_tipodiagnostico) {
                $response = [
                    'status' => true,
                    'message' => 'existen datos',
                    'diagnostico' => $dt_tipodiagnostico,
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'no existen datos',
                    'diagnostico' => null,
                ];
            }
    
            return response()->json($response, 200);
        }


}