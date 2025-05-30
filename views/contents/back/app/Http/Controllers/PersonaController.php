<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    //

    
    public function guardarPersona($request){

        $data = $request->persona;
        $response = [];

        if(!isset($data) || $data == null) {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'persona' => null,
            ];
        } else {
            $response = $this->procesandoDatos($data);
        }

        return $response;
    }

    public function guardar(Request $request){

        $data = $request->persona;
        $response = [];

        if (!isset($data) || $data == null) {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'persona' => null,
            ];
        } else {
            $response = $this->procesandoDatos($data);
        }

        return response()->json($response, 200);
    }

    private function procesandoDatos($data){

        //validar la cedula que no se repita
        $existe = Persona::where('cedula', $data->cedula)->get()->first();
        $response = [];

        if ($existe == null) {
            $persona = new Persona;

            //seteando campos o rellenando el modelo
            $persona->cedula = $data->cedula;
            $persona->celular = $data->celular;
            $persona->operadora_id = intval($data->operadora_id);
            $persona->nombre = $data->nombre;
            $persona->apellido = $data->apellido;
            $persona->telefono = $data->telefono;
            $persona->fecha_nacimiento = $data->fecha_nacimiento;
            $persona->direccion = $data->direccion;
            $persona->sexo_id = intval($data->sexo_id);
            $persona->tipo_cobertura_id = intval($data->tipo_cobertura_id);
            $persona->tipo_seguro_id = intval($data->tipo_seguro_id);
            $persona->responsable = $data->responsable;
            $persona->estado = 'A';

            if ($persona->save()) {
                $response = [
                    'status' => true,
                    'mensaje' => 'Se ha guardado la persona',
                    'persona' => $persona,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se pudo guardar ',
                    'persona' => null,
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'La persona ya se encuentra registrada',
                'persona' => $existe,
            ];
        }

        return $response;
    }
}
