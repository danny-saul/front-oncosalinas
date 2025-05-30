<?php

namespace App\Http\Controllers;

use App\Models\Enfermedad_Periodontal;
use App\Models\Paciente;
use App\Models\Paciente_Angle;
use App\Models\Paciente_Fluorosis;
use App\Models\Piezas_Paciente_Higiene;
use Illuminate\Http\Request;

class Higiene_Controller extends Controller
{
    //

    
public function guardarPiezasHigiente(Request $request)
{
    $request->validate([
        'paciente_id' => 'required|exists:paciente,id',
        'antecedentes' => 'required|array',
        'antecedentes.*.piezas_higiene_id' => 'required|exists:piezas_higiene,id',
        'antecedentes.*.respuesta' => 'required|in:Sí,No'
    ]);

    foreach ($request->antecedentes as $antecedente) {
        // Buscar si ya existe un antecedente para el paciente y ese tipo de antecedente
        $piezasExistentes = Piezas_Paciente_Higiene::where('paciente_id', $request->paciente_id)
            ->where('piezas_higiene_id', $antecedente['piezas_higiene_id'])
            ->first();

        if ($piezasExistentes) {
            // Si existe, actualizar la respuesta
            $piezasExistentes->respuesta = $antecedente['respuesta'];
            $piezasExistentes->save();
        } else {
            // Si no existe, crear un nuevo antecedente
            $piezasExNew = new Piezas_Paciente_Higiene();
            $piezasExNew->paciente_id = $request->paciente_id;
            $piezasExNew->piezas_higiene_id = $antecedente['piezas_higiene_id'];
            $piezasExNew->respuesta = $antecedente['respuesta'];
           // $piezasExNew->fecha = now();
            $piezasExNew->estado = 'A'; // Estado "A" por defecto
            $piezasExNew->save();
        }
    }

    return response()->json(['mensaje' => 'Antecedentes guardados con éxito.']);
}


    // ✅ Recuperar antecedentes de un paciente
    public function obtenerPiezasPct($paciente_id)
    {
        // Validar que el paciente exista
        $paciente = Paciente::find($paciente_id);
        if (!$paciente) {
            return response()->json(['mensaje' => 'Paciente no encontrado.'], 404);
        }
    
        // Obtener los antecedentes guardados para ese paciente
        $antecedentes = Piezas_Paciente_Higiene::where('paciente_id', $paciente_id)
            ->with('piezas_higiene') // Relación con la tabla de antecedentes
            ->get();
    
        // Devolver los antecedentes en formato JSON
        return response()->json([
            'mensaje' => 'Piezas obtenidas correctamente.',
            'antecedentes' => $antecedentes
        ]);
    }









    public function guardarEnfermedadPeriodontal(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:paciente,id',
            'antecedentes' => 'required|array',
            'antecedentes.*.enfermedad_dientes_id' => 'required|exists:enfermedad_dientes,id',
            'antecedentes.*.respuesta' => 'required|in:Sí,No'
        ]);
    
        foreach ($request->antecedentes as $antecedente) {
            // Buscar por paciente_id solamente
            $enfPexistente = Enfermedad_Periodontal::where('paciente_id', $request->paciente_id)->first();
    
            if ($enfPexistente) {
                // Si existe, actualizar el ID y la respuesta
                $enfPexistente->enfermedad_dientes_id = $antecedente['enfermedad_dientes_id'];
                $enfPexistente->respuesta = $antecedente['respuesta'];
                $enfPexistente->save();
            } else {
                // Si no existe, crear uno nuevo
                $piezasExNew = new Enfermedad_Periodontal();
                $piezasExNew->paciente_id = $request->paciente_id;
                $piezasExNew->enfermedad_dientes_id = $antecedente['enfermedad_dientes_id'];
                $piezasExNew->respuesta = $antecedente['respuesta'];
                $piezasExNew->estado = 'A'; // Estado por defecto
                $piezasExNew->save();
            }
        }
    
        return response()->json(['mensaje' => 'Enfermedad periodontal actualizada/guardada con éxito.']);
    }
    


public function obtenerEnfermedadPeriodontal($paciente_id)
{
    // Validar que el paciente exista
            $paciente = Paciente::find($paciente_id);
            if (!$paciente) {
                return response()->json(['mensaje' => 'Paciente no encontrado.'], 404);
            }
        
            // Obtener los antecedentes guardados para ese paciente
            $antecedentes = Enfermedad_Periodontal::where('paciente_id', $paciente_id)
                ->with('enfermedad_dientes') // Relación con la tabla de antecedentes
                ->get();
        
            // Devolver los antecedentes en formato JSON
            return response()->json([
                'mensaje' => 'Piezas obtenidas correctamente.',
                'antecedentes' => $antecedentes
            ]);
    }




    
    public function guardarAngle(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:paciente,id',
            'antecedentes' => 'required|array',
            'antecedentes.*.angle_id' => 'required|exists:angle,id',
            'antecedentes.*.respuesta' => 'required|in:Sí,No'
        ]);
    
        foreach ($request->antecedentes as $antecedente) {
            // Buscar por paciente_id solamente
            $existeAngle = Paciente_Angle::where('paciente_id', $request->paciente_id)->first();
    
            if ($existeAngle) {
                // Si existe, actualizar el ID y la respuesta
                $existeAngle->angle_id = $antecedente['angle_id'];
                $existeAngle->respuesta = $antecedente['respuesta'];
                $existeAngle->save();
            } else {
                // Si no existe, crear uno nuevo
                $piezasExNew = new Paciente_Angle();
                $piezasExNew->paciente_id = $request->paciente_id;
                $piezasExNew->angle_id = $antecedente['angle_id'];
                $piezasExNew->respuesta = $antecedente['respuesta'];
                $piezasExNew->estado = 'A'; // Estado por defecto
                $piezasExNew->save();
            }
        }
    
        return response()->json(['mensaje' => 'Mal ocusion actualizada/guardada con éxito.']);
    }
    


    public function obtenerAngle($paciente_id)
{
    // Validar que el paciente exista
            $paciente = Paciente::find($paciente_id);
            if (!$paciente) {
                return response()->json(['mensaje' => 'Paciente no encontrado.'], 404);
            }
        
            // Obtener los antecedentes guardados para ese paciente
            $antecedentes = Paciente_Angle::where('paciente_id', $paciente_id)
                ->with('angle') // Relación con la tabla de antecedentes
                ->get();
        
            // Devolver los antecedentes en formato JSON
            return response()->json([
                'mensaje' => 'Datos obtenidas correctamente.',
                'antecedentes' => $antecedentes
            ]);
    }



        
    public function guardarFluor(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:paciente,id',
            'antecedentes' => 'required|array',
            'antecedentes.*.enfermedad_dientes_id' => 'required|exists:enfermedad_dientes,id',
            'antecedentes.*.respuesta' => 'required|in:Sí,No'
        ]);
    
        foreach ($request->antecedentes as $antecedente) {
            // Buscar por paciente_id solamente
            $existeAngle = Paciente_Fluorosis::where('paciente_id', $request->paciente_id)->first();
    
            if ($existeAngle) {
                // Si existe, actualizar el ID y la respuesta
                $existeAngle->enfermedad_dientes_id = $antecedente['enfermedad_dientes_id'];
                $existeAngle->respuesta = $antecedente['respuesta'];
                $existeAngle->save();
            } else {
                // Si no existe, crear uno nuevo
                $piezasExNew = new Paciente_Fluorosis();
                $piezasExNew->paciente_id = $request->paciente_id;
                $piezasExNew->enfermedad_dientes_id = $antecedente['enfermedad_dientes_id'];
                $piezasExNew->respuesta = $antecedente['respuesta'];
                $piezasExNew->estado = 'A'; // Estado por defecto
                $piezasExNew->save();
            }
        }
    
        return response()->json(['mensaje' => 'Fluorosis actualizada/guardada con éxito.']);
    }




    public function obtenerFluor($paciente_id)
{
    // Validar que el paciente exista
            $paciente = Paciente::find($paciente_id);
            if (!$paciente) {
                return response()->json(['mensaje' => 'Paciente no encontrado.'], 404);
            }
        
            // Obtener los antecedentes guardados para ese paciente
            $antecedentes = Paciente_Fluorosis::where('paciente_id', $paciente_id)
                ->with('enfermedad_dientes') // Relación con la tabla de antecedentes
                ->get();
        
            // Devolver los antecedentes en formato JSON
            return response()->json([
                'mensaje' => 'Datos obtenidas correctamente.',
                'antecedentes' => $antecedentes
            ]);
    }




}
