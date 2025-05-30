<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio_Detalle;
use Illuminate\Http\Request;

class Laboratorio_DetalleController extends Controller
{
    //

    public function guardar_detalleLaboratorio($laboratorio_id, $det_laboratorio =[]){

        $response = [];
     
        if(count($det_laboratorio) > 0){
            foreach($det_laboratorio as $item){
                						 
                $IngresoNuevoDetalle_lab = new Laboratorio_Detalle();
                $IngresoNuevoDetalle_lab->laboratorio_id = intval($laboratorio_id);
                $IngresoNuevoDetalle_lab->tipo_examen_id = intval($item->tipo_examen_id);
                $IngresoNuevoDetalle_lab->cantidad =1;
                $IngresoNuevoDetalle_lab->precio_venta = 1;
                $IngresoNuevoDetalle_lab->total_general = 1;
                $IngresoNuevoDetalle_lab->resultado_examen = '';
                $IngresoNuevoDetalle_lab->justificacion_lab = $item->justificacion_lab;
                $IngresoNuevoDetalle_lab->resumen_lab = $item->resumen_lab;
                $IngresoNuevoDetalle_lab->estado = 'A';

                $IngresoNuevoDetalle_lab->save();
 

            }


        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No ahi detalle para guardar',
                'detalle_ventas' => null,
            ];

        }
         return $response;
    }



    public function listarDetalleXId($id)
    {

        $id = intval($id);
        $detalle = Laboratorio_Detalle::find($id);
        $response = [];

        if ($detalle) {
    
            $response = [
                'status' => true,
                'detalle' => $detalle,
                'tipo' => $detalle->tipo_examen,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el detalle',
                'detalle' => null,
            ];
        }
        return response()->json($response, 200);
    }



    public function editarItemsLabs(Request $request){

        $aux = json_decode($request['data']);
        $ItemsLabs = $aux->labs_det;
     
        $idDetalle = intval($ItemsLabs->id);
        $resultado_examen = $ItemsLabs->resultado_examen;
     
        $ItemsData = Laboratorio_Detalle::find($idDetalle);
        $response = [];
    
        if ($ItemsLabs) {
            if ($ItemsData) {
              
    
                $ItemsData->resultado_examen = $resultado_examen;
                $ItemsData->save();
    
                
                $response = [
                    'status' => true,
                    'mensaje' => 'El Items se ha actualizado',
                    'detalle' => $ItemsData,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el Items',
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos ',
            ];
        }
    
        return response()->json($response, 200);
    }
    

}
