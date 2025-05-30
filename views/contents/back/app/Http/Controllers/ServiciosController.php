<?php

namespace App\Http\Controllers;

use App\Models\Servicios;
use Illuminate\Http\Request;

class ServiciosController extends Controller
{
    //

    public function listar(){
    
        $response = [];
        $dataservicios = Servicios::where('estado', 'A')->orderBy('detalle_servicio')->get();

        if($dataservicios){
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'servicios' => $dataservicios
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'servicios' => null
            ];
        }
        return response()->json($response, 200);
       
    }

    public function listar_serviciosxID($id){

        $id = intval($id);
        $dataservicios = Servicios::find($id);
        
        $response = [];

        if($dataservicios == null){
            $response = [
                'status' => false,
                'mensaje' => 'Los servicios no existe',
                'servicios' => null,
            ];

        }else{
            $response = [
                'status' => true,
                'mensaje' => 'Los servicios existe',
                'servicios' => $dataservicios,
            ];

        } 
        return response()->json($response, 200);

    }

}
