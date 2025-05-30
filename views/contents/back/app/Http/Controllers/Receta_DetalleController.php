<?php

namespace App\Http\Controllers;

use App\Models\Receta_Detalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class Receta_DetalleController extends Controller
{
    //

      public function guardar_detalleReceta($receta_id, $det_receta =[]){

        $response = [];
     
        if(count($det_receta) > 0){
            foreach($det_receta as $item){
                						 
                $IngresoNuevoDetalle_rece = new Receta_Detalle();
                $IngresoNuevoDetalle_rece->receta_id = intval($receta_id);
                $IngresoNuevoDetalle_rece->producto_id = $item->producto_id;
                $IngresoNuevoDetalle_rece->cantidad = $item->cantidad; 
                $IngresoNuevoDetalle_rece->dosis_id = $item->dosis_id;
                $IngresoNuevoDetalle_rece->frecuencia_id = $item->frecuencia_id;
                $IngresoNuevoDetalle_rece->via_id = $item->via_id;
                $IngresoNuevoDetalle_rece->status_facturado = 'N';
                $IngresoNuevoDetalle_rece->duracion = $item->duracion;
                $IngresoNuevoDetalle_rece->observacion = $item->observacion;
                $IngresoNuevoDetalle_rece->estado = 'A';
                $IngresoNuevoDetalle_rece->fecha = date('Y-m-d H:i:s');

                $IngresoNuevoDetalle_rece->save();
 

            }


        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No ahi detalle para guardar',
                'detalle_receta' => null,
            ];

        }
         return $response;
    }

}
