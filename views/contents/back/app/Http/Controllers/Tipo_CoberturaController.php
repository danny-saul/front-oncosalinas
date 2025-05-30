<?php

namespace App\Http\Controllers;

use App\Models\Operadora;
use App\Models\Tipo_Cobertura;
use App\Models\Tipo_Seguro;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Operator;

class Tipo_CoberturaController extends Controller
{
    //

    public function listar_tipocobertura()
    {

        $tipo_cobertura = Tipo_Cobertura::where('estado', 'A')->get();
        $response = [];

        if ($tipo_cobertura) {

            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'tipo_cobertura' => $tipo_cobertura,
           
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'tipo_cobertura' => null,
            ];
        }

        return response()->json($response, 200);
    }

    public function listar_operadora()
    {

        $tipo_operadora = Operadora::where('estado', 'A')->get();
        $response = [];

        if ($tipo_operadora) {

            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'tipo_operadora' => $tipo_operadora,
           
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'tipo_operadora' => null,
            ];
        }

        return response()->json($response, 200);
    }

    public function listar_tiposeguro()
    {

        $tipo_seguro = Tipo_Seguro::where('estado', 'A')->get();
        $response = [];

        if ($tipo_seguro) {

            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'tipo_seguro' => $tipo_seguro,
           
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'tipo_seguro' => null,
            ];
        }

        return response()->json($response, 200);
    }
}
