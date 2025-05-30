<?php

namespace App\Http\Controllers;

use App\Models\Citas_Servicios;
use Illuminate\Http\Request;

class Citas_ServiciosController extends Controller
{
    //
        
    public function guardar_citas_servicios($citas_id, $detalle_servicio = [] ){
        $response = [];

        if($detalle_servicio > 0 ){
            foreach($detalle_servicio as $serv){
                $nuevo = new Citas_Servicios();
                $nuevo->citas_id = $citas_id;
                $nuevo->servicios_id = intval($serv->servicios_id);
                $nuevo->estado = 'A'; 
                $nuevo->save();

            }
            $response = [
                'status' => true,
                'mensaje' => 'Guardado Detalle ordenes'
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay servicios en la orden',
                'ordenes_servicios' => null,
            ];
        }
        return response()->json($response, 200);
    }


    public function guardar_citas_serviciosCrear($citas_id ){
        $response = [];

      
                $nuevo = new Citas_Servicios();
                $nuevo->citas_id = $citas_id;
                $nuevo->servicios_id = 1;
                $nuevo->estado = 'A'; 
                $nuevo->save();

          
            $response = [
                'status' => true,
                'mensaje' => 'Guardado Detalle ordenes'
            ];
       
        return response()->json($response, 200);
    }
}
