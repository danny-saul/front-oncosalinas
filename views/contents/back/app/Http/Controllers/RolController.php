<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    
    public function listar(){

        $dataRol = Rol::where('estado', 'A')->get();
        $response = [];

        if ($dataRol) {
            $response = [
                'status' => true,
                'message' => 'existen datos',
                'rol' => $dataRol,
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'no existen datos',
                'rol' => null,
            ];
        }

        return response()->json($response, 200);
    }


      public function guardar(Request $request){

    
        $data = json_decode($request['data']);
        $requestRol = $data->roles;
        return response()->json($requestRol, 200); die();


        $response = [];

        if ($requestRol) {
            $nuevoRol = new Rol();
            $existeRol = Rol::where('rol', $requestRol->rol)->get()->first();

            if ($existeRol) {
                $response = [
                    'status' => false,
                    'message' => 'El rol ya existe',
                    'rol' => [],
                ];
            } else {
                $nuevoRol->rol = $requestRol->rol;
                $nuevoRol->estado = 'A';
                $nuevoRol->save();

                $response = [
                    'status' => true,
                    'message' => 'Se ha guardado el rol',
                    'rol' => $nuevoRol,
                ];
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'no hay datos para procesar',
            ];
        }

        return response()->json($response, 200);
    }

}
